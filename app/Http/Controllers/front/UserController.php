<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\CountryModel;
use App\Models\States;
use App\Models\Cities;
use App\Models\Wishlist;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\Rating;
use App\Models\ServiceBooking;
use App\Models\OrderProductsModel;
use App\Models\VendorMessage;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Session;




use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm(Request $request)
    {
        $page_heading = "Handwi || Login";
        if (Auth::check()) {
            
            return redirect()->route('userdashboard');  
        }
        if (!$request->session()->has('url.intended') && url()->previous() !== url()->current()) {
            session(['url.intended' => url()->previous()]);
        }
        return view('front_end.auth.login', compact('page_heading'));
    }

    /**
     * Handle user login.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'The email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 6 characters.',
        ]);
        
    
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            
            if (Auth::user()->role == 2 || Auth::user()->role == 3) {
                $redirectUrl = session('url.intended', route('userdashboard'));

                return response()->json([
                    'status' => 'success',
                    'message' => 'Login successful! Redirecting...',
                    'redirect_url' => $redirectUrl,
                    //'redirect_url' => route('userdashboard'), 
                ]);
            }
    
            
            Auth::logout(); 
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to access this area.',
            ], 403);
        }
    

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid email or password.',
        ], 401);
    }

    public function dashboard()
    {
        
        if (Auth::check()) {
            
            $user = Auth::user();

            if ($user->role == 2 || $user->role == 3) {
                $page_heading = "Handwi || Dashboard";
                $countries = CountryModel::where(['deleted' => 0 , 'active' => 1])->get();
                $states = States::where(['deleted' => 0 , 'active' => 1])->get();
                $cities = Cities::where(['deleted' => 0, 'active' => 1])->get();
                $wishlists = Wishlist::where('user_id', Auth::id()) 
                ->join('product', 'product.id', '=', 'wishlists.product_id') 
                ->join('product_selected_attribute_list', 'product_selected_attribute_list.product_id', '=', 'product.id') 
                ->select('product.*', 'product_selected_attribute_list.*', 'wishlists.*') 
                ->get(); 
                
                $orders = OrderModel::where('orders.user_id', Auth::id())
                    ->with(['products' => function ($query) {
                        $query->join('product', 'order_products.product_id', '=', 'product.id')
                            ->join('product_selected_attribute_list', 'product.id', '=', 'product_selected_attribute_list.product_id')
                            ->select(
                                'order_products.order_id', 
                                'order_products.product_id', 
                                'order_products.quantity', 
                                'product.product_name', 
                                'product.product_desc_short as product_description', 
                                'product_selected_attribute_list.regular_price',
                                'product_selected_attribute_list.image', 
                                'product_selected_attribute_list.sale_price'
                            );
                    }])
                    ->orderBy('orders.created_at', 'desc')
                    ->get();
                    
                             

               
                $bookings = ServiceBooking::join('service', 'service.id', '=', 'service_bookings.service_id')
                            ->where('service_bookings.user_id', Auth::id())
                            ->select('service_bookings.*', 'service.*','service_bookings.created_at as order_date') // select the fields you need
                            ->get();
                            $messages = VendorMessage::with('vendor')->where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
                           
                            
               
                
                $addresses = UserAddress::where('user_id', Auth::id())->get();
                return view('front_end.userdashboard', compact('user','addresses','orders','bookings','wishlists','page_heading','countries','states','cities','messages')); 
            } else {
                
                Auth::logout();
                return redirect()->route('login')->withErrors(['role' => 'You do not have access to the dashboard.']);
            }
        }

        
        return redirect()->route('login')->withErrors(['message' => 'You must log in to access the dashboard.']);
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile_number' => 'required|string|max:15',
            'dial_code' => 'required|string|max:15',
           
        ], [
            'firstname.required' => 'First name is required.',
            'firstname.string' => 'First name must be a string.',
            'firstname.max' => 'First name must not exceed 255 characters.',
            
            'lastname.required' => 'Last name is required.',
            'lastname.string' => 'Last name must be a string.',
            'lastname.max' => 'Last name must not exceed 255 characters.',
            
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',
            
            'mobile_number.required' => 'Mobile number is required.',
            'mobile_number.string' => 'Mobile number must be a string.',
            'mobile_number.max' => 'Mobile number must not exceed 15 characters.',
            
            'dial_code.required' => 'Location is required.',
            'dial_code.string' => 'Location must be a string.',
            'dial_code.max' => 'Location must not exceed 255 characters.',
            
            'birthdate.required' => 'Birthdate is required.',
            'birthdate.date' => 'Please provide a valid birthdate.',

            'about.required' => 'About information is required.',
            'about.string' => 'About information must be a string.',
            'about.max' => 'About information must not exceed 1000 characters.',
        ]);
        

        $user = Auth::user();
        if($request->file("user_image")){
                    $response = image_upload($request,'users','user_image');
                   
                    if($response['status']){
                 $user->user_image = $response['link']??'';
                 $user->save();
                    }
                 }
        // Update user data
        $user->update([
            'first_name' => $request->firstname,
            'last_name' => $request->lastname,
            'name' => $request->firstname . ' ' . $request->lastname,
            'email' => $request->email,
            'phone' => $request->mobile_number,
            'location' => $request->location,
            'dob' => $request->birthdate,
            'about_me' => $request->about,
            'dial_code' =>$request->dial_code
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully!',
            'redirect_url' => route('userdashboard'),
        ]);
    }
    

    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegisterForm()
    {
        $page_heading = "Handwi || Register";
        if (Auth::check()) {
            
            return redirect()->route('userdashboard');  
        }
        
        return view('front_end.auth.register', compact('page_heading'));
    }

    /**
     * Handle user registration.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:10,15',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'terms' => 'required|accepted',
        ], [
            'first_name.required' => 'The first name is required.',
            'last_name.required' => 'The last name is required.',
            'email.required' => 'The email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'password.required' => 'The password is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'terms.required' => 'You must agree to the terms and conditions.',
            'phone.required' => 'The phone number is required.',
            'phone.numeric' => 'The phone number must contain only numbers.',
            'phone.digits_between' => 'The phone number must be between 10 and 15 digits.',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }
        
    
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 2,
        ]);
        $name = $user->name;
        $email = $user->email; 
        $mailbody = view('mail.registration_successful', compact('name','email','user'))->render();
        send_email($user->email, 'Welcome to Handwi', $mailbody);
    
        Auth::login($user);
    
        return response()->json(['status' => 'success', 'message' => 'Registration successful']);
    }

     public function changePassword(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Current password is required.',
            'new_password.required' => 'New password is required.',
            'new_password.confirmed' => 'The new password confirmation does not match.',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        // Check if the current password is correct
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return response()->json([
                'status' => 'error',
                'errors' => [
                    'current_password' => ['The current password is incorrect.']
                ]
            ], 422);
        }

        // Update the password in the database
        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Return success response
        return response()->json([
            'status' => 'success',
            'message' => 'Password changed successfully!',
            'redirect_url' => route('userdashboard'), // Redirect after success
        ]);
    }
    
    

    /**
     * Logout the user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');  
    }

    public function storeuseraddress(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'dial_code' => 'required|string|max:5',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'country_id' => 'required|integer',
            'state_id' => 'required|integer',
            'city_id' => 'required|integer',
            'address_type' => 'required|string',
        ], [
            'full_name.required' => 'Full Name is required.',
            'dial_code.required' => 'Dial Code is required.',
            'phone.required' => 'Phone is required.',
            'address.required' => 'Address is required.',
            'country_id.required' => 'Country is required.',
            'state_id.required' => 'State is required.',
            'city_id.required' => 'City is required.',
            'address_type.required' => 'Address Type is required.',
        ]);
    
        $validated['user_id'] = Auth::id();
    
        $address = UserAddress::create($validated);
    
        return response()->json(['status' => 'success', 'message' => 'Address added successfully!', 'address' => $address]);
    }
    
    public function edituseraddress($id)
    {
        $address = UserAddress::findOrFail($id);

        if ($address->user_id !== Auth::id()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        return response()->json(['status' => 'success', 'address' => $address]);
    }

    public function updateuseraddress(Request $request, $id)
    {
        $address = UserAddress::findOrFail($id);

        if ($address->user_id !== Auth::id()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'dial_code' => 'required|string|max:5',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'country_id' => 'required|integer',
            'state_id' => 'required|integer',
            'city_id' => 'required|integer',
            'address_type' => 'required|string',
        ], [
            'full_name.required' => 'Full Name is required.',
            'dial_code.required' => 'Dial Code is required.',
            'phone.required' => 'Phone is required.',
            'address.required' => 'Address is required.',
            'country_id.required' => 'Country is required.',
            'state_id.required' => 'State is required.',
            'city_id.required' => 'City is required.',
            'address_type.required' => 'Address Type is required.',
        ]);

        $address->update($validated);

        return response()->json(['status' => 'success', 'message' => 'Address updated successfully!', 'address' => $address]);
    }

    public function makeDefaultAddress($id)
    {
        // Find the address
        $address = UserAddress::findOrFail($id);

        // Check if the address belongs to the current user
        if ($address->user_id !== Auth::id()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        // Set all addresses to non-default
        UserAddress::where('user_id', Auth::id())->update(['is_default' => false]);

        // Mark this address as default
        $address->is_default = true;
        $address->save();

        return response()->json(['status' => 'success', 'message' => 'Primary address updated successfully!', 'address' => $address]);
    }
public function orderDetails(Request $request,$id)
    {
        $page_heading = "Orders Details"; 
        
            $filter['order_id']  = $id;
            
            $page = (int)$request->page??1;
            $limit= 10;
            $offset = ($page - 1) * $limit;
             $list = OrderProductsModel::where('order_id',$id)->with('vendor','product')->get();
             $sub_orders =$list->groupBy('vendor_id');
           $all_sub_orders = [];

foreach ($sub_orders as $vendor_id => $items) {
    $vendor = $items->first()->vendor;

    $products = [];

    foreach ($items as $val) {
       // return $val->quantity;
        // Get the enriched product data
        list($status, $product, $message) = ProductModel::getProductVariant($val->product_id, $val->product_attribute_id);
        $product = process_product_data_api($product);

        // You can merge or customize the product info with other order details
        $product['quantity'] = $val->quantity;
         $product['price'] = $val->price;
        //  $customerFileUrl = $val->customer_file
        //  ? get_uploaded_image_url($val->customer_file, 'product_image_upload_dir')
        //  : '';
        
          $product['customer_notes'] = $val->customer_notes;
          $product['customer_file'] = $val->customer_file;
        // $product['is_ratted']=Rating::where('product_id',$val->product_id)->where('user_id',$user_id)->count() ? '1' : '0';
        // $product->order_product_id = $val->id;

        $products[] = $product;
    }

    $all_sub_orders[] = (object)[
        'vendorId' => $vendor_id,
        'vendorName' => $vendor->first_name . ' ' . $vendor->last_name,
        'order_status_text' => order_status($items->first()->order_status),
        'status' => $items->first()->order_status,
        'productList' => $products
    ];
}

$sub_orders=$all_sub_orders;

             
            $list = OrderProductsModel::get_order_details($filter)->skip($offset)->take($limit)->get();
            
            $list = process_order($list);
                   
             $order = OrderModel::with('vendor.vendordata')->where('order_id', $id)->first();
        //    dd($order);
            if($request->test){
                return make_pdf($order,'','test');
            }
            if($request->d){
                return make_pdf($order,'','d');
            }

            
             
            
         
        return view('front_end.useroder',compact('page_heading','list','order','sub_orders'));
    }

    

public function invoice(Request $request,$id = '')
{
    $page_heading = "Orders Details"; 
        
    $filter['order_id']  = $id;
    
    $page = (int)$request->page??1;
    $limit= 10;
    $offset = ($page - 1) * $limit;
     $list = OrderProductsModel::where('order_id',$id)->with('vendor','product')->get();
     $sub_orders =$list->groupBy('vendor_id');
   $all_sub_orders = [];

foreach ($sub_orders as $vendor_id => $items) {
$vendor = $items->first()->vendor;

$products = [];

foreach ($items as $val) {
// return $val->quantity;
// Get the enriched product data
list($status, $product, $message) = ProductModel::getProductVariant($val->product_id, $val->product_attribute_id);
$product = process_product_data_api($product);

// You can merge or customize the product info with other order details
$product['quantity'] = $val->quantity;
 $product['price'] = $val->price;
// $product['is_ratted']=Rating::where('product_id',$val->product_id)->where('user_id',$user_id)->count() ? '1' : '0';
// $product->order_product_id = $val->id;

$products[] = $product;
}

$all_sub_orders[] = (object)[
'vendorId' => $vendor_id,
'vendorName' => $vendor->first_name . ' ' . $vendor->last_name,
'order_status_text' => order_status($items->first()->order_status),
'status' => $items->first()->order_status,
'productList' => $products
];
}

$sub_orders=$all_sub_orders;

     
    $list = OrderProductsModel::get_order_details($filter)->skip($offset)->take($limit)->get();
    
    $list = process_order($list);
           
     $order = OrderModel::with('vendor.vendordata')->where('order_id', $id)->first();
//    dd($order);
    if($request->test){
        return make_pdf($order,'','test');
    }
    if($request->d){
        return make_pdf($order,'','d');
    }
     
    
 
 
    // 1. Render Blade view to HTML
    $html = view('front_end.useroderpdf',compact('page_heading','list','order','sub_orders'));
    // 2. Create mPDF instance
    $mpdf = new Mpdf();

    // 3. Write HTML to PDF
    $mpdf->WriteHTML($html);

    // 4. Output PDF for download
    return response($mpdf->Output('Order-Invoice.pdf', 'S')) // 'S' returns content as string
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'attachment; filename="Order-Invoice.pdf"');
}




}
