<?php

namespace App\Http\Controllers\portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stores;
use App\Models\User;
use App\Models\States;
use App\Models\Currency;
use App\Models\CountryModel;
use App\Models\VendorDetailsModel;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    
    public function thankyou()
    {
        if (Auth::check() && (Auth::user()->role == '1')) {
            return redirect()->route('portal.dashboard');
        }
        return view('portal.thankyou');
    }

    public function setup_shop(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('portal.dashboard');
        }
        // Fetch dynamic data for dropdowns
        $languages = ['English', 'Arabic', 'Spanish', 'French'];
        $countries = CountryModel::all();
        $currencies = Currency::all();
        $states = States::all();

        return view('portal.setup_shop', compact('states', 'languages', 'countries', 'currencies'));
    }

    public function saveStep(Request $request)
    {
        $validated = $request->validate([
            'shop_language' => 'required|string',
            'shop_country' => 'required|integer',
            'shop_currency' => 'required|string',
            'shop_name' => 'required|string|min:4|max:20',
            'shop_logo' => 'nullable|image|max:2048',
            'shop_description' => 'nullable|string',
            'bank_country' => 'nullable|integer',
            'tax_seller_type' => 'nullable|string',
            'residence_country' => 'nullable|integer',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'dob' => 'nullable',
            'dob.day' => 'nullable|integer|min:1|max:31',
            'dob.month' => 'nullable|integer|min:1|max:12',
            'dob.year' => 'nullable|integer|min:1900|max:2025',
            'tax_address' => 'nullable',
            'bank_info' => 'nullable',
            'billing_address' => 'nullable',
            'two_factor_auth' => 'nullable|string',
           // 'delivery_type' => 'nullable',
            'standard_delivery_text' => 'nullable|string|max:255',
            'delivery_range' => 'nullable',
            'delivery_range.min' => 'nullable|integer|min:1',
            'delivery_range.max' => 'nullable|integer',

        ]);

        // Handle file upload for shop_logo
        if ($request->hasFile('shop_logo')) {
            $path = $request->file('shop_logo')->store('logos', 'public');
            $validated['shop_logo'] = $path;
        }
        if (!empty($validated['dob'])) {
            $dob = json_decode($validated['dob'], true);
        }
        $customRange = [];
        if (!empty($validated['custom_delivery_range'])) {
            $customRange = json_decode($validated['custom_delivery_range'], true);
        }

       
    
        // Create Store Entry
        $store = Stores::create([
            'vendor_id' => Auth::id(),
            'industry_type' => 0, // Example static value
            'store_name' => $validated['shop_name'],
            'business_email' => Auth::user()->email,
            'location' => $validated['billing_address']['street'] ?? '',
            'country_id' => $validated['shop_country'],
            'state_id' => $validated['billing_address']['state'] ?? null,
            'city_id' => $validated['billing_address']['city'] ?? null,
            'zip' => $validated['billing_address']['postal_code'] ?? null,
            'logo' => $validated['shop_logo'] ?? null,
            'description' => $validated['shop_description'] ?? null,
            'latitude' => null,
            'longitude' => null,
            'bank_country' => $validated['bank_country'] ?? null,
            'tax_seller_type' => $validated['tax_seller_type'] ?? null,
            'residence_country' => $validated['residence_country'] ?? null,
            'dob_day' => $dob['day'] ?? null,
            'dob_month' => $dob['month'] ?? null,
            'dob_year' => $dob['year'] ?? null,
            'first_name' => $validated['first_name'] ?? null,
            'last_name' => $validated['last_name'] ?? null,
            'shop_currency' => $validated['shop_currency'] ?? null,
            'shop_language' => $validated['shop_language'] ?? null,
           // 'delivery_type' => $validated['delivery_type'] ?? null,
            'standard_delivery_text' =>  $validated['standard_delivery_text'] ?? null ,
            'delivery_min_days' =>  $validated['delivery_min_days'] ?? null ,
            'delivery_max_days' => $validated['delivery_max_days'] ?? null ,

        ]);

        
        
        if (!empty($validated['tax_address'])) {
            $taxAddress = json_decode($validated['tax_address'], true);
            $store = Stores::find($store->id);
            $store->update([
                'tax_number' => $taxAddress['number'] ?? null,
                'tax_street' => $taxAddress['street'] ?? null,
                'tax_address_line_2' => $taxAddress['addressLine2'] ?? null,
                'tax_city' => $taxAddress['city'] ?? null,
                'tax_state' => $taxAddress['state'] ?? null,
                'tax_post_code' => $taxAddress['postCode'] ?? null,
                'tax_phone' => $taxAddress['phone'] ?? null,
            ]);
        }
        
        if (!empty($validated['bank_info'])) {
            $bankInfo = json_decode($validated['bank_info'], true);

            if (is_array($bankInfo)) {
                auth()->user()->bank_details()->create([
                    'bank_name' => $bankInfo['bankName'] ?? null,
                    'company_account' => $bankInfo['accountNumber'] ?? null,
                    'code_type' => $bankInfo['code_type'] ?? 0,
                    'account_no' => $bankInfo['account_no'] ?? null,
                    'branch_code' => $bankInfo['branch_code'] ?? null,
                    'branch_name' => $bankInfo['branch_name'] ?? null,
                    'bank_statement_doc' => $bankInfo['bank_statement_doc'] ?? null,
                    'credit_card_sta_doc' => $bankInfo['credit_card_sta_doc'] ?? null,
                    'country' => $bankInfo['country'] ?? 0,
                    'iban' => $bankInfo['ibanSwift'] ?? null,
                ]);
            } else {
                throw new \Exception('Invalid bank_info format.');
            }
        }

        if (!empty($validated['billing_address'])) {
            $billingAddress = json_decode($validated['billing_address'], true);

            if (is_array($billingAddress)) {
                VendorDetailsModel::create([
                    'company_name' => $validated['shop_name'] ?? null,
                    'country' => $billingAddress['country'] ?? 0,
                    'city' => $billingAddress['city'] ?? 0,
                    'street1' => $billingAddress['street1'] ?? 0,
                    'street2' => $billingAddress['street2'] ?? 0,
                    'state' => $billingAddress['state'] ?? 0,
                    'postal_code' => $billingAddress['postal_code'] ?? 0,
                    'phone_number' => $billingAddress['phone_number'] ?? 0,
                    'user_id' => auth()->user()->id,
                ]);
            } else {
                throw new \Exception('Invalid bank_info format.');
            }

        }
        auth()->user()->update(['verified'=>0,'two_factor_auth' => $validated['two_factor_auth'] ?? null,]);
        
        session()->pull("user_id");
        Auth::logout();
    
        return response()->json([
            'success' => true,
            'message' => 'Store created successfully!',
            'store' => $store,
        ]);
    }    

    public function check_email(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;

        // Check if email already exists in the users table
        $user = User::where('email', $email)->first();

        if ($user) {
            return response()->json([
                'success' => false,
                'message' => 'This email is already registered. Please use another email.',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Email is available.',
        ]);
    }

    public function seller_register_post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'first_name' => 'required|string|max:255',
            'password' => 'required|min:8',
            'survey_topic' => 'nullable|string',
            'help_topics' => 'nullable|array',
        ], [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered.',
        ]);
    
        if ($validator->fails()) {
            $formattedErrors = [];
            foreach ($validator->errors()->messages() as $field => $messages) {
                foreach ($messages as $message) {
                    $formattedErrors[] = $message;
                }
            }
    
            return response()->json([
                'success' => false,
                'message' => implode(' ', $formattedErrors), 
                'errors' => $validator->errors(),
            ], 422);
        }
    
        // Create the user
        $user = User::create([
            'email' => $request->input('email'),
            'first_name' => $request->input('first_name'),
            'password' => Hash::make($request->input('password')),
            'role' => 3,
            'verified' => 1,
        ]);
    
        // Save survey topic if provided
        if ($request->input('survey_topic')) {
            $user->helpTopics()->create([
                'topic' => $request->input('survey_topic'),
                'is_survey_topic' => true,
            ]);
        }
    
        // Save help topics if provided
        if (!empty($request->input('help_topics'))) {
            foreach ($request->input('help_topics') as $topic) {
                $user->helpTopics()->create([
                    'topic' => $topic,
                    'is_survey_topic' => false,
                ]);
            }
        }

        $name = $user->first_name;
        $mailbody = view('mail.vendor_register_raw', compact('name'))->render();
        send_email($user->email, 'Vendor Account Created - Pending Activation', $mailbody);
    
        // Attempt to log the user in after registration
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'role' => 3])) {
            if (Auth::check() && Auth::user()->role == 3) {
                if (Auth::user()->verified == 1) {
                    $request->session()->put('user_id', Auth::user()->id);
                    return response()->json([
                        'success' => true,
                        'message' => 'Registration and login successful.',
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Registration successful, but admin verification is pending.',
                    ]);
                }
            }
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Registration successful, but login failed.',
        ]);
    }
    
    public function seller_register()
    {
        if (Auth::check() && (Auth::user()->role == '1')) {
            return redirect()->route('portal.dashboard');
        }
        return view('portal.seller_register');
    }
    //
    public function login()
    {
        if (Auth::check() && (Auth::user()->role == '1')) {
            return redirect()->route('portal.dashboard');
        }
        // echo Hash::make('Hello@1985');
        return view('portal.login');
    }
    public function check_login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);
        $user=User::where('email',$request->email)->where('two_factor_auth','enabled')->first();
        if($user){

            $token =1111;// $this->get_user_token('password_reset_code');
           // $password_reset_time = gmdate('Y-m-d H:i:s');

                User::where("email",'=',$request->email)->update(['two_factor_code' =>$token]);
                $mailbody =  view("mail.two_factor",compact('token'));

               

                if(send_email($request->email,'Please Verify Auth code',$mailbody)){
                    return response()->json([
                        'success' => true,
                        'status_code'=>3, 
                        'message' => "Code sent to your email please verify code."]); 
                }else{
                    return response()->json([
                        'success' => false,
                        'status_code'=>3, 
                        'message' => "Code not sent to your email please contact to admin."]); 
                }
           
        }
        // Validate request
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password,'role'=>3])) {
            if (Auth::check() && (Auth::user()->role == 3)) {
               if(Auth::user()->verified == 1)
               {
                $request->session()->put('user_id',Auth::user()->id);
                return response()->json(['success' => true,'status_code'=>1, 'message' => "Logged in successfully."]);
               }
               else
               {
               return response()->json(['error' => true, 'message' => "Your account is under review"]); 
               }
            } else {
                return response()->json(['error' => false, 'message' => "Invalid Credentials!"]);
            }

        }

        return response()->json(['success' => false, 'message' => "Invalid Credentials!"]);
    }
    public function forgotpassword()
    {
        if (Auth::check() && (Auth::user()->role == '1')) {
            return redirect()->route('portal.dashboard');
        }
        return view('portal.forgot');
    }
    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $exists = User::where('email', $request->email)->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'Email already exists.']);
        }

        return response()->json(['success' => true]);
    }
    public function check_user(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email']
        ]);

        $user = User::where(['email' => $request->email,'role'=>'3'])->get();
        if($user->isNotEmpty()) {

            $token = $this->get_user_token('password_reset_code');
            $password_reset_time = gmdate('Y-m-d H:i:s');

                User::where("email",'=',$request->email)->update(['password_reset_code' =>$token,'password_reset_time'=>$password_reset_time]);
                $link = url('reset_password/'.$token);
                $mailbody =  view("mail.reset_password",compact('link'));

               

                if(send_email($request->email,'Reset Your Handwi Vendor Password',$mailbody)){
                    $status = "1";
                    $message = "A link has been sent to your email to reset your password";
                }else{
                    $status = "0";
                    $message = "Email not sent";
                }
             
            return response()->json(['success' => true, 'message' => "We have e-mailed your password reset link. Please check your inbox."]);
        }
        else
        {
            return response()->json(['success' => false, 'message' => "E-mail not exist"]);
        }
    }

    public function check_user_code(Request $request)
    {
        $request->validate([
            'two_factor_code' => ['required']
        ]);

        $user = User::where(['two_factor_code' => $request->two_factor_code,'role'=>'3'])->first();
        if($user) {

            $user = User::where('email', $user->email)
            ->where('role', 3)
            ->first();

            if ($user->verified == 1) {
                $user->two_factor_code="";
                $user->save();
                Auth::login($user); // Log in without checking password
                $request->session()->put('user_id', $user->id);
                return response()->json(['success' => true, 'message' => "Logged in successfully."]);
            } else {
                return response()->json(['error' => true, 'message' => "Your account is under review"]);
            }


        }
        else
        {
            return response()->json(['success' => false, 'message' => "Cod is not correct not exist"]);
        }
    }
    public function user_code()
    {
        if (Auth::check() && (Auth::user()->role == '1')) {
            return redirect()->route('portal.dashboard');
        }
        return view('portal.two_factor');
    }
    public function get_user_token($type = '')
    {
        $tok = bin2hex(random_bytes(32));
        if (User::where($type, '=', $tok)->first()) {
            $this->get_user_token($type);
        }
        return $tok;
    }
    public function logout(){
        session()->pull("user_id");
        Auth::logout();
        return redirect()->route('portal.login');
    }
}
