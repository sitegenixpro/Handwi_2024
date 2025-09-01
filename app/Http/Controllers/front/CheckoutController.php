<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\SettingsModel;
use App\Models\Cart;
use App\Models\TempOrderModel;
use App\Models\TempOrderProductsModel;
use App\Models\OrderModel;
use App\Models\OrderProductsModel;
use App\Models\UserAddress;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\Stores;
use Stripe\Checkout\Session as StripeSession; // Alias here



class CheckoutController extends Controller
{
   
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login'); 
        }
        $page_heading = "Handwi || Checkout";
       
        $user_id = Auth::id() ?? 0;
        $device_cart_id = request()->cookie('device_cart_id') ?? null;

        $cartItems = $this->getCartItems($user_id, $device_cart_id);
        $addresses = UserAddress::where('user_id', Auth::id())->get();
        // Calculate totals
        $subtotal = $cartItems->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        $settings = SettingsModel::first();
       
        $tax_percentage = 0;
        if (isset($settings->tax_percentage)) {
            $tax_percentage = $settings->tax_percentage;
        }
        
        $shipping_charge = 0;
        if (isset($settings->shipping_charge)) {
            $shipping_charge = $settings->shipping_charge;
        }
        $totalTax = $cartItems->sum(function ($item) use ($tax_percentage) {
            return ($item['price']  * $tax_percentage) / 100;
        });

        $grand_total = $subtotal  + $totalTax + $shipping_charge;

        return view('front_end.checkout', [
            'cart' => $cartItems,
            'subtotal' => $subtotal,
            'grand_total' =>$grand_total,
            'shipping'    => $shipping_charge,
            'totalTax'   =>$totalTax,
            'page_heading' => $page_heading,
            'addresses' => $addresses
        ]);
    }

    public function placeOrder(Request $request)
    {
        
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $user_id = Auth::id();
        $user_email = Auth::user() ? Auth::user()->email : null;
         
         $device_cart_id = request()->cookie('device_cart_id') ?? null;

         $cartItems = $this->getCartItems($user_id, $device_cart_id);
         
        $existingOrder = TempOrderModel::where('user_id', $user_id)->first();
        if ($existingOrder) {
            TempOrderModel::where('user_id', $user_id)->delete();
            TempOrderProductsModel::where('order_id', $existingOrder->id)->delete();
        }
            
        $settings = SettingsModel::first();
       
        $tax_percentage = 0;
        if (isset($settings->tax_percentage)) {
            $tax_percentage = $settings->tax_percentage;
        }
        
        $shipping_charge = 0;
        if (isset($settings->shipping_charge)) {
            $shipping_charge = $settings->shipping_charge;
        }
        $totalTax = $cartItems->sum(function ($item) use ($tax_percentage) {
            return ($item['price']  * $tax_percentage) / 100;
        });
        $subtotal =  $cartItems->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $grand_total = $subtotal  + $totalTax + $shipping_charge;
    

        $tempOrder = new TempOrderModel();
        $tempOrder->user_id = $user_id;
        $tempOrder->address_id = $request->address_id ?? 1;
        $tempOrder->order_type = $request->order_type == 1 ? 1 : 1;
        $tempOrder->pick_up_date = $request->pick_up_date ? date('Y-m-d', strtotime($request->pick_up_date)) : '';
        $tempOrder->pick_up_time = $request->pick_up_time ? date('h:i A', strtotime($request->pick_up_time)) : '';
        $tempOrder->total = $cartItems->sum('price');
       
        $tempOrder->vat = $totalTax; 
        $tempOrder->service_charge = 0; 
        $tempOrder->discount = 0; 
        $tempOrder->grand_total = $grand_total;
        $tempOrder->shipping_charge = $shipping_charge;
        $tempOrder->payment_mode = $request->payment_type ? $request->payment_mode : 2;
        $tempOrder->temp_id = uniqid();
        $tempOrder->save();
    
       
        foreach ($cartItems as $item) {
            $tempOrderProduct = new TempOrderProductsModel();
            $tempOrderProduct->order_id = $tempOrder->id;
            $tempOrderProduct->product_id = $item['product_id'];
            $tempOrderProduct->product_attribute_id = $item['variant'];
            $tempOrderProduct->quantity = $item['quantity'];
            $tempOrderProduct->price = $item['price'];
            $tempOrderProduct->total = $item['price'] * $item['quantity'];
            $tempOrderProduct->customer_notes = $item['customer_notes'] ?? '';
            $tempOrderProduct->customer_file = $item['customer_file'] ?? '';
            $tempOrderProduct->save();
        }

        
        try {
            $session = StripeSession::create([ 
                'payment_method_types' => ['card'],
                'line_items' => $this->getLineItems(), 
                'mode' => 'payment',
                'success_url' => route('thankyou') . '?checkoutid={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout'),
                'customer_email' => $user_email,
            ]);

            
            return redirect()->away($session->url);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
   

    public function success(Request $request)
    {
        $page_heading = "Handwi || Thankyou";
        Stripe::setApiKey(env('STRIPE_SECRET'));

        
        $sessionId = $request->query('checkoutid');
        $device_cart_id = request()->cookie('device_cart_id') ?? null;
        $user_id = Auth::id(); 

        
        $session = StripeSession::retrieve($sessionId);
        \Log::info('Stripe Session:', [$session]);

        if (!$session) {
            return redirect()->route('cart')->with('error', 'Session not found.');
        }

        
        if (isset($session->payment_intent)) {
            $paymentIntent = PaymentIntent::retrieve($session->payment_intent);
            \Log::info('Payment Intent Status:', [$paymentIntent->status]);

            if ($paymentIntent->status == 'succeeded') {
                
                $existingOrder = TempOrderModel::where('user_id', $user_id)->first();
                \Log::info('Existing Order:', [$existingOrder]);

                if ($existingOrder) {
                    
                    if (empty($existingOrder->address_id) || $existingOrder->address_id == 0) {
                        \Log::error('Invalid address_id:', ['address_id' => $existingOrder->address_id]);
                        return redirect()->route('cart')->with('error', 'Invalid address.');
                    }

                    
                    $order = new OrderModel();
                    $order->user_id = $user_id;
                    $order->address_id = $existingOrder->address_id;
                    $order->order_type = $existingOrder->order_type;
                    $order->pick_up_date = $existingOrder->pick_up_date ?: now(); 
                    $order->pick_up_time = $existingOrder->pick_up_time ?: now()->format('H:i'); 
                    $order->total = $existingOrder->total;
                    $order->vat = $existingOrder->vat;
                    $order->service_charge = $existingOrder->service_charge;
                    $order->discount = $existingOrder->discount;
                    $order->grand_total = $existingOrder->grand_total;
                    $order->shipping_charge = $existingOrder->shipping_charge;
                    $order->payment_mode = $existingOrder->payment_mode;
                    $order->order_number = uniqid(); 
                    $order->status = 1; 

                    
                    \Log::info('Order before saving:', [$order]);

                    
                    $orderSaved = $order->save();
                  
                    if ($orderSaved && $order->order_id) {
                        \Log::info('Order successfully created with ID:', ['order_id' => $order->id]);

                        $tempOrderProducts = TempOrderProductsModel::where('order_id', $existingOrder->id)->get();
                        foreach ($tempOrderProducts as $item) {
                            $existprodct=   ProductModel::find($item->product_id);
                            

                            $store = Stores::where('vendor_id', $existprodct->product_vender_id)->first();
                            
                            // Set fallback values if store not found
                            $adminSharePercent = $store->admin_share?? 5;
                            $vendorSharePercent = $store->vendor_share ?? 95;
                            $settings = SettingsModel::first();
                            $tax_percentage = isset($settings->tax_percentage) ? $settings->tax_percentage : 5; // Default to 5% if not set
                        
                            // Apply 5% VAT to product price
                            $vatPerUnit = $item->price * ($tax_percentage / 100);
                            $priceWithVat = $item->price + ($item->price * ($tax_percentage / 100));
                            $totalWithVat = $priceWithVat * $item->quantity;
                        
                            // Calculate admin & vendor share from totalWithVat
                            $adminShareAmount = ($totalWithVat * $adminSharePercent) / 100;
                        
                            $vendorShareAmount = ($totalWithVat * $vendorSharePercent) / 100;
                            
                            $orderProduct = new OrderProductsModel();
                            $orderProduct->order_id = $order->order_id;
                             $orderProduct->vendor_id = $existprodct->product_vender_id;
                            $orderProduct->product_id = $item->product_id;
                            $orderProduct->product_attribute_id = $item->product_attribute_id;
                            $orderProduct->quantity = $item->quantity;
                            $orderProduct->price = $item->price;
                            $orderProduct->total = $item->total;
                            $orderProduct->customer_notes = $item->customer_notes;  // Save customer notes
                             $orderProduct->customer_file = $item->customer_file; 
                             $orderProduct->vat_amount = round($vatPerUnit, 2);
                             $orderProduct->admin_share = round($adminShareAmount, 2);
                             $orderProduct->vendor_share = round($vendorShareAmount, 2);
                              $orderProduct->admin_commission = round($adminShareAmount, 2);
                             $orderProduct->vendor_commission = round($vendorShareAmount, 2);
                            $orderProduct->save();
                        }

                        TempOrderModel::where('user_id', $user_id)->delete();
                        TempOrderProductsModel::where('order_id', $existingOrder->id)->delete();
                        Cart::where(function ($query) use ($user_id, $device_cart_id) {
                            $query->where('user_id', $user_id)
                                  ->orWhere('device_cart_id', $device_cart_id);
                        })->delete();
                        $user = Auth::user();
                        $orderProducts = OrderProductsModel::where('order_id', $order->order_id)->get();

                        $mailbody = view('mail.order_invoice', compact('user', 'order', 'orderProducts'))->render();
                        send_email($user->email, 'Your Order Invoice - ' . config('app.name'), $mailbody);
                        return view('front_end.thankyou', [
                            'session' => $session,
                            'page_heading' => $page_heading,
                            'order' => $order,
                        ]);
                    } else {
                        \Log::error('Failed to save order:', ['order' => $order]);
                        return redirect()->route('cart')->with('error', 'Failed to create order.');
                    }
                } else {
                    \Log::error('No temporary order found for user:', ['user_id' => $user_id]);
                    return redirect()->route('cart')->with('error', 'No temporary order found for this user.');
                }
            } else {
                \Log::error('Payment not successful, status:', ['status' => $paymentIntent->status]);
                return redirect()->route('checkout')->with('error', 'Payment not successful.');
            }
        } else {
            \Log::error('Unable to verify payment, no payment intent found.');
            return redirect()->route('checkout')->with('error', 'Unable to verify payment.');
        }

        \Log::error('Error during success:', ['error' => $e->getMessage()]);
        return redirect()->route('cart')->with('error', 'Unable to retrieve session or process the order: ' . $e->getMessage());
    }




    


    

    private function getLineItems()
    {
        // Retrieve cart items from the user's cart
        $cartItems = $this->getCartItems(Auth::id() ?? 0, request()->cookie('device_cart_id'));

        // Fetch settings from the database (for tax and shipping charge)
        $settings = SettingsModel::first();
        $tax_percentage = $settings->tax_percentage ?? 0;
        $shipping_charge = $settings->shipping_charge ?? 0;

        // Initialize an array to store line items for Stripe
        $line_items = [];

        // Calculate subtotal, tax, and total tax
        $subtotal = 0;
        $totalTax = 0;

        foreach ($cartItems as $item) {
            $itemPrice = $item['price'] * $item['quantity'];
            $subtotal += $itemPrice;
            $itemTax = ($item['price'] * $tax_percentage) / 100;
            $totalTax += $itemTax;

            // Add the item to the line items array
            $line_items[] = [
                'price_data' => [
                    'currency' => 'AED',
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                    'unit_amount' => $item['price']  * 100, // Price + tax (converted to cents)
                ],
                'quantity' => $item['quantity'],
            ];
        }

        // Add shipping charge as a separate line item if applicable
        if ($shipping_charge > 0) {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'AED',
                    'product_data' => [
                        'name' => 'Shipping Charge',
                    ],
                    'unit_amount' => $shipping_charge * 100, // Shipping charge in cents
                ],
                'quantity' => 1,
            ];
        }

        // Add total tax as a separate line item if applicable
        if ($totalTax > 0) {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'AED',
                    'product_data' => [
                        'name' => 'Tax',
                    ],
                    'unit_amount' => $totalTax * 100, // Tax amount in cents
                ],
                'quantity' => 1,
            ];
        }

        return $line_items;
    }



    
  



    private function getCartItems($user_id, $device_cart_id)
    {
        
       $user_id=($user_id==0)?'001':$user_id;
        $cartItems = Cart::where(function ($query) use ($user_id, $device_cart_id) {
            $query->where('user_id', $user_id)
                  ->orWhere('device_cart_id', $device_cart_id);
        })->get();
        
      
    
        // Fetch product details for each cart item
        $cartItems = $cartItems->map(function ($item) {
            if($item->product_attribute_id){
             $product = ProductModel::getProductVariant($item->product_id, $item->product_attribute_id);
             
           $product=$product[1];
           
           $attributes = ProductModel::getSelectedProductAttributeValsFull($item->product_attribute_id)->first();
         //  dd( $attributes);
          // dd($product);
          
            }
            else{
            $product = ProductModel::getProductInfo($item->product_id)->first();
            $attributes = ProductModel::getProductAttributesByProductId($item->product_id);
            }
           $product_attributes_full =ProductModel::getSelectedProductAttributeValsFull($item->product_attribute_id);
          $color_text = '';
            $size_text = '';

            foreach ($product_attributes_full as $attribute) {
                if ($attribute->attribute_name === 'Color') {
                    $color_text = 'Color:' . $attribute->attribute_values;
                }

                if ($attribute->attribute_name === 'Size') {
                    $size_text = 'Size:' . $attribute->attribute_values;
                }
            }
            $productImage = '';
            if (!empty($product->image)) {
                $images = explode(',', $product->image);
                $productImage = get_uploaded_image_url($images[0], 'product_image_upload_dir');
            } else {
                $productImage = asset('default-image.jpg'); // fallback
            }
    
            // Get customer uploaded file
            $customerFileUrl = $item->uploaded_file_path
                ? get_uploaded_image_url($item->uploaded_file_path, 'product_image_upload_dir')
                : '';

           // dd($attributes['attribute_name']);
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'name' => $product->product_name ?? 'N/A',
               // 'image' => $product && $product->image
                 //   ? asset('uploads/products/' . explode(',', $product->image)[0])
                 //   : asset('default-image.jpg'), // Use a default image if none is available
                 'image' => $productImage,
                'price' => $product->sale_price ?? 0,
                'quantity' => $item->quantity,
                'variant' => $item->product_attribute_id ?? 'N/A',
                'attributes' => $attributes ?? 'N/A',
                'color_text'=>$color_text,
                'size_text'=>$size_text,
                'customer_notes' => $item->notes ?? '',
                'customer_file' => $customerFileUrl,
            ];
        });
    
        return $cartItems;
    }

    public function updateQuantity(Request $request)
    {
        $validated = $request->validate([
            'cart_id' => 'required|numeric|min:1',
            'action' => 'required|string|in:add,subtract',
        ]);
    
        $cart_id = $validated['cart_id'];
        $action = $validated['action'];
    
        // Fetch the cart item
        $cartItem = Cart::find($cart_id);
    
        if (!$cartItem) {
            return response()->json(['status' => 0, 'message' => 'Cart item not found.']);
        }
    
        $product = ProductModel::getProductInfo($cartItem->product_id)->first();
        if (!$product) {
            return response()->json(['status' => 0, 'message' => 'Product not found.']);
        }
    
        $in_stock = $product->stock_quantity;
        $allow_back_order = $product->allow_back_order;
    
        // Update the quantity based on action
        if ($action === 'add') {
            if ($cartItem->quantity + 1 <= $in_stock || $allow_back_order) {
                $cartItem->quantity += 1;
                $cartItem->save();
            } else {
                return response()->json(['status' => 0, 'message' => 'Stock limit exceeded.']);
            }
        } elseif ($action === 'subtract') {
            if ($cartItem->quantity > 1) {
                $cartItem->quantity -= 1;
                $cartItem->save();
            } else {
                return response()->json(['status' => 0, 'message' => 'Quantity cannot be less than 1.']);
            }
        }
    
        // Retrieve updated cart items
        $cartItems = $this->getCartItems(Auth::id() ?? 0, request()->cookie('device_cart_id'));
    
        // Calculate the total
        $total = $cartItems->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    
        return response()->json([
            'status' => 1,
            'message' => 'Quantity updated successfully.',
            'cart' => $cartItems,
            'total' => $total,
            'item_count' => $cartItems->count(),
        ]);
    }
    
    public function clearCart(Request $request)
    {
        $user_id = Auth::id() ?? 0;
        $device_cart_id = $request->cookie('device_cart_id') ?? null;

        Cart::where(function ($query) use ($user_id, $device_cart_id) {
            $query->where('user_id', $user_id)
                ->orWhere('device_cart_id', $device_cart_id);
        })->delete();

        return response()->json(['status' => 1, 'message' => 'Cart cleared successfully.']);
    }

    
}
