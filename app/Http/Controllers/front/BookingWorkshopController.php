<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\Categories;
use App\Models\Service;
use App\Models\Stores;
use App\Models\MainCategories;
use App\Models\SettingsModel;
use App\Models\ServiceBooking;
use App\Models\HourlyRate;
use App\Models\ServiceImage;
use App\Models\Cities;
use App\Models\ServiceTimings;
use App\Models\ActivityType;
use App\Models\AccountType;
use App\Models\ServiceType;
use App\Models\VendorModel;
use App\Models\Servicefeatures;
use App\Models\ServiceCategorySelected;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Checkout\Session as StripeSession; // Alias here
use Illuminate\Support\Facades\Log;



class BookingWorkshopController extends Controller
{
    /**
     * Get products by category.
     *
     * @param int $categoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id, Request $request)
    {
        $workshop = Service::with(['features', 'vendor', 'building_type'])->where(['service.id' => $id, 'service.deleted' => 0, 'service.active' => 1])->first();
       
        if (!$workshop) {
            abort(404); // If no workshop is found, return 404
        }
    
        // Set page heading dynamically
        $page_heading = "Workshop Booking || " . $workshop->name;
        $settings = SettingsModel::first(); 
        $tax_percentage = 0;
        if (isset($settings->tax_percentage)) {
          $tax_percentage = $settings->tax_percentage;
        }
        $service_price = $workshop->service_price ?? 0; 
        $tax_amount = ($service_price * $tax_percentage) / 100;
        $grand_total = $service_price + $tax_amount;
        $check_booking = ServiceBooking::where('service_id', $id)->pluck('seat_no')->toArray();
        $booked_seats = [];
        if (!empty($check_booking)) {
            foreach ($check_booking as $value) {
                $seats = explode(",", $value);
                $booked_seats = array_merge($booked_seats, $seats);
            }
        }
    
        $total_seats = $workshop->seats;
        $all_seats = [];
        for ($i = 1; $i <= $total_seats; $i++) {
            $all_seats[] = (string)$i;
        }
        


        return view('front_end.bookingworkshop', compact('page_heading', 'workshop','tax_percentage','tax_amount','grand_total','all_seats','booked_seats'));
    }

    public function checkoutpage(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'workshop_id' => 'required|exists:service,id',
            'seats' => 'required|array|min:1',
        ]);
        $workshop = Service::with(['features', 'vendor', 'building_type'])
        ->where('id', $request->workshop_id)
        ->first();

        if (!$workshop) {
            return response()->json(['error' => 'Invalid workshop ID.'], 404);
        }

        // Retrieve the tax percentage from the Settings model
        $settings = SettingsModel::first();
        $tax_percentage = $settings->tax_percentage ?? 0;

        // Get selected seats from the request
        $selectedSeats = $request->seats;

        // Count the selected seats
        $seatCount = count($selectedSeats);

        // Calculate the price and tax based on the number of selected seats
        $service_price = $workshop->service_price ?? 0;
        $totalServicePrice = $service_price * $seatCount; // Multiply service price by seat count
        $tax_amount = ($totalServicePrice * $tax_percentage) / 100;
        $grand_total = $totalServicePrice + $tax_amount;
        $user_id = Auth::id();
        $user_email = Auth::user() ? Auth::user()->email : null;

        // Save workshop_id and seats in the session (no database save here)
        Session::put('workshop_id', $workshop->id);
        Session::put('selected_seats', $selectedSeats);
        Session::put('grand_total', $grand_total);
        Session::put('service_price', $service_price);

        // Stripe Checkout Session creation (Correct Stripe usage)
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripeSession = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'AED',
                    'product_data' => [
                        'name' => $workshop->name,
                        'description' => 'Workshop Booking'
                    ],
                    'unit_amount' => $service_price * 100, 
                ],
                'quantity' => $seatCount, 
            ],
                [
                    'price_data' => [
                        'currency' => 'AED',
                        'product_data' => [
                            'name' => 'Tax',
                            'description' => 'Tax for Workshop Booking'
                        ],
                        'unit_amount' => $tax_amount * 100, // Tax amount (in cents)
                    ],
                    'quantity' => 1, // Only 1 line item for tax
                ]
            ],
            
            'mode' => 'payment',
            'success_url' => route('workshoppaymentsuccess') . '?workshopcheckout={CHECKOUT_SESSION_ID}', // Use query parameter for success URL
            'cancel_url' => route('workshops'),
            'customer_email' => $user_email,
        ]);

        // Return the session ID and Stripe public key
        return response()->json([
            'session_id' => $stripeSession->id,
            'stripe_public_key' => env('STRIPE_KEY'),
            'url' => $stripeSession->url
        ]);
    }



    public function paymentSuccess(Request $request)
    {
        
        // Set up Stripe API key
        Stripe::setApiKey(env('STRIPE_SECRET'));
    
        // Retrieve the session ID from the request query string
        $page_heading = "Handwi || Thankyou";
        $sessionId = $request->query('workshopcheckout');
        $workshop_id = session('workshop_id');
        $selectedSeats = session('selected_seats');
        $grand_total = session('grand_total');
        $service_price = session('service_price');
    
        // Ensure session data exists
        if (!$sessionId || !$workshop_id || !$selectedSeats) {
            abort(404, 'Session data not found.');
        }
        
    
        try {
            // Retrieve the Stripe session object using the session ID
            $session = StripeSession::retrieve($sessionId);
            
            \Log::info('Stripe Session:', [$session]);
    
            // Ensure that the session was found and is in a successful state
            if ($session->payment_status !== 'paid') {
                \Log::error('Payment not successful:', [$session]);
                return redirect()->route('workshops')->with('error', 'Payment not successful.');
            }
    
            // Create a new order record in the ServiceBooking model
            $workshop = Service::find($workshop_id);
            $user_id = auth()->id();
            $order_number = uniqid();
            
            $store = Stores::where('vendor_id', $workshop->vendor_id)->first();
            
            $adminSharePercent = $store->admin_share ?? 5;
            $vendorSharePercent = $store->vendor_share ?? 95;

            $adminShareAmount = ($grand_total * $adminSharePercent) / 100;
            $vendorShareAmount = ($grand_total * $vendorSharePercent) / 100;
          
            $bookingData = [
                'service_id' => $workshop_id,
                'user_id' => $user_id,
                'seat_no' => implode(',', $selectedSeats), // Store seat numbers as comma-separated values
                'status' => 'confirmed', // Set status to 'confirmed' after successful payment
                'payment_type' => '1', // Assuming 1 represents Stripe payment
                'price' => $service_price,
                'tax' => ($service_price * count($selectedSeats) * (SettingsModel::first()->tax_percentage ?? 0)) / 100,
                'grand_total' => $grand_total,
                'admin_share' => round($adminShareAmount,2),
                'vendor_share' => round($vendorShareAmount,2),
                'order_number' => $order_number,
                'number_of_seats' => count($selectedSeats),
            ];
           
            
          
    
            // Save the booking record
            $booking = ServiceBooking::create($bookingData);
    
            // Log the created booking
            \Log::info('Booking created:', [$booking]);
    
            
            $user = Auth::user();
            $workshop = Service::with('vendor')->find($workshop_id);
            $mailbody = view('mail.workshop_invoice', compact('user', 'booking', 'workshop'))->render();
            send_email($user->email, 'Your Workshop Booking Invoice ' . config('app.name'), $mailbody);
            // Return the thank-you page view with the booking details
            // Optionally, delete the session data to clean up temporary data
            session()->forget(['workshop_id', 'selected_seats', 'grand_total', 'service_price']);
            return view('front_end.thankyou', [
                'temp_id' => $booking->id,
                'order' => $booking,
                'page_heading' => $page_heading
            ]);
        } catch (\Exception $e) {
            // Log any errors that occur during the payment verification process
            \Log::error('Error during payment verification:', ['error' => $e->getMessage()]);
            
            // Redirect to checkout if something went wrong
            return redirect()->route('checkout')->with('error', 'Unable to verify payment or process the order.');
        }
    }



   

    



}
