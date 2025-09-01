<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BankCodetypes;
use App\Models\BankdataModel;
use App\Models\ProductAttribute;
use App\Models\BankModel;
use App\Models\HomeLogo;
use App\Models\ReportedShop;
use App\Models\CountryModel;
use App\Models\ContactUsSetting;
use App\Models\Cities;
use App\Models\VendorReport;
use App\Models\SubscriberEmail;
use App\Models\ProductModel;
use App\Models\Blog;
use App\Models\IndustryTypes;
use App\Models\VendorDetailsModel;
use App\Models\VendorModel;
use App\Models\Article;
use App\Models\User;
use App\Models\Categories;
use App\Models\VendorLocation;
use App\Models\FaqModel;
use App\Models\ActivityType;
use App\Models\Testimonial;
use App\Models\WebBannerModel;
use App\Models\MainCategories;
use Illuminate\Http\Request;
use App\Models\ContactUsModel;
use App\Models\VendorFollower;
use App\Models\VendorMessage;
use App\Models\RecentlyViewedProduct;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;

class HomeController extends Controller
{

    public function index()
    {
    $page_heading = "Handwi || Curated Gifts: Handmade, Vintage, and Custom Just for You";

    $categories = Categories::where(['deleted' => 0, 'home_page' => 1, 'active' => 1])->take(3)->get();

    // Fetch trending products
    $products = ProductModel::join('product_selected_attribute_list', 'product_selected_attribute_list.product_id', '=', 'product.id')
        ->leftJoin('ratings', 'ratings.product_id', '=', 'product.id')
        ->select(
            'product.*',
            'product_selected_attribute_list.*',
            DB::raw('COALESCE(AVG(ratings.rating), 0) as average_rating'),
            DB::raw('COUNT(ratings.id) as total_reviews')
        )
        ->where('product.trending', 1)
        ->where('product.product_status', 1)
        ->where('product.deleted', 0)
        ->groupBy('product.id', 'product_selected_attribute_list.product_attribute_id', 'ratings.product_id');

    if (auth()->check() && auth()->user()->role == 2) {
        $products->leftJoin('wishlists', function ($join) {
            $join->on('wishlists.product_id', '=', 'product.id')
                ->where('wishlists.user_id', auth()->id());
        })
        ->addSelect(
            DB::raw('CASE WHEN wishlists.id IS NOT NULL THEN 1 ELSE 0 END AS added_to_wishlist')
        )
        ->groupBy('wishlists.id');
    }

    $products = $products->limit(4)->get();

    // Fetch latest products
   

    $latest_products =  ProductModel::leftJoin('product_selected_attribute_list', 'product_selected_attribute_list.product_id', '=', 'product.id')
    ->leftJoin('ratings', 'ratings.product_id', '=', 'product.id')
    ->leftJoin('wishlists', function ($join) {
        $join->on('wishlists.product_id', '=', 'product.id');

        if (auth()->check() && auth()->user()->role == 2) {
            $join->where('wishlists.user_id', auth()->id());
        } else {
            // Make sure no wishlist rows are matched for guests or other roles
            $join->whereRaw('1=0');
        }
    })
    ->where('product.new_arrival', 1)
    ->where('product.product_status', 1)
    ->where('product.deleted', 0)
    ->select(
        'product.id',
        'product.product_name',
        'product.product_desc_short',
        DB::raw('MIN(product_selected_attribute_list.regular_price) as regular_price'),
        DB::raw('MIN(product_selected_attribute_list.sale_price) as sale_price'),
        DB::raw('MIN(product_selected_attribute_list.image) as image'),
        DB::raw('COALESCE(AVG(ratings.rating), 0) as average_rating'),
        DB::raw('COUNT(ratings.id) as total_reviews'),
        DB::raw('CASE WHEN COUNT(wishlists.id) > 0 THEN 1 ELSE 0 END AS added_to_wishlist')
    )
    ->groupBy('product.id', 'product.product_name', 'product.product_desc_short')
    ->orderBy('product.created_at', 'DESC')
    ->limit(10)
    ->get();

    $foryou_products = ProductModel::leftJoin('product_selected_attribute_list', 'product_selected_attribute_list.product_id', '=', 'product.id')
    ->leftJoin('ratings', 'ratings.product_id', '=', 'product.id')
    ->leftJoin('wishlists', function ($join) {
        $join->on('wishlists.product_id', '=', 'product.id');

        if (auth()->check() && auth()->user()->role == 2) {
            $join->where('wishlists.user_id', auth()->id());
        } else {
            // Make sure no wishlist rows are matched for guests or other roles
            $join->whereRaw('1=0');
        }
    })
    ->where('product.for_you', 1)
    ->where('product.product_status', 1)
    ->where('product.deleted', 0)
    ->select(
        'product.id',
        'product.product_name',
        'product.product_desc_short',
        DB::raw('MIN(product_selected_attribute_list.regular_price) as regular_price'),
        DB::raw('MIN(product_selected_attribute_list.sale_price) as sale_price'),
        DB::raw('MIN(product_selected_attribute_list.image) as image'),
        DB::raw('COALESCE(AVG(ratings.rating), 0) as average_rating'),
        DB::raw('COUNT(ratings.id) as total_reviews'),
        DB::raw('CASE WHEN COUNT(wishlists.id) > 0 THEN 1 ELSE 0 END AS added_to_wishlist')
    )
    ->groupBy('product.id', 'product.product_name', 'product.product_desc_short')
    ->orderBy('product.created_at', 'DESC')
    ->limit(10)
    ->get();



    // Fetch other data
    $testimonials = Testimonial::where(['deleted' => 0, 'active' => 1])->get();
    $blogs = Blog::where(['deleted' => 0, 'active' => 1])->orderby('id', 'desc')->get();
    $logos = HomeLogo::where(['deleted' => 0, 'active' => 1])->orderby('id', 'desc')->get();
    $maincategories = MainCategories::where(['deleted' => 0, 'active' => 1])->orderBy('id', 'asc')->get();
    $banners = WebBannerModel::where(['deleted' => 0, 'active' => 1])->orderby('id', 'desc')->get();
    $recentlyviewedproducts = []; // default

    if (Auth::check() ) {
        $recentlyViewedProductIds = RecentlyViewedProduct::where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->pluck('product_id');

        $recentlyviewedproducts = ProductModel::join('product_selected_attribute_list', 'product_selected_attribute_list.product_id', '=', 'product.id')
            ->leftJoin('ratings', 'ratings.product_id', '=', 'product.id')
            ->select(
                'product.*',
                'product_selected_attribute_list.*',
                DB::raw('COALESCE(AVG(ratings.rating), 0) as average_rating'),
                DB::raw('COUNT(ratings.id) as total_reviews')
            )
            ->whereIn('product.id', $recentlyViewedProductIds)
            ->where('product.product_status', 1)
            ->where('product.deleted', 0)
            ->groupBy('product.id', 'product_selected_attribute_list.product_attribute_id');

        $recentlyviewedproducts->leftJoin('wishlists', function ($join) {
            $join->on('wishlists.product_id', '=', 'product.id')
                ->where('wishlists.user_id', Auth::id());
        })
        ->addSelect(DB::raw('CASE WHEN wishlists.id IS NOT NULL THEN 1 ELSE 0 END AS added_to_wishlist'))
        ->groupBy('wishlists.id');

        $recentlyviewedproducts = $recentlyviewedproducts->get();
    }
    
    $following_products = [];

    if (Auth::check()) {
        $userId = Auth::id();
        $vendorIds = VendorFollower::where('user_id', $userId)->pluck('vendor_id');

        if ($vendorIds->isNotEmpty()) {
            $followingQuery = ProductModel::join('product_selected_attribute_list', 'product_selected_attribute_list.product_id', '=', 'product.id')
                ->leftJoin('ratings', 'ratings.product_id', '=', 'product.id')
                ->select(
                    'product.*',
                    'product_selected_attribute_list.*',
                    DB::raw('COALESCE(AVG(ratings.rating), 0) as average_rating'),
                    DB::raw('COUNT(ratings.id) as total_reviews')
                )
                ->whereIn('product.product_vender_id', $vendorIds)
                ->where('product.product_status', 1)
                ->where('product.deleted', 0)
                ->groupBy('product.id', 'product_selected_attribute_list.product_attribute_id');

            $followingQuery->leftJoin('wishlists', function ($join) use ($userId) {
                $join->on('wishlists.product_id', '=', 'product.id')
                    ->where('wishlists.user_id', $userId);
            })
            ->addSelect(DB::raw('CASE WHEN wishlists.id IS NOT NULL THEN 1 ELSE 0 END AS added_to_wishlist'))
            ->groupBy('wishlists.id');

            $following_products = $followingQuery
                ->orderBy('product.created_at', 'desc')
                ->limit(10)
                ->get();
        }
    }



    return view('front_end.index', compact('page_heading','following_products','recentlyviewedproducts', 'banners', 'maincategories', 'foryou_products', 'categories', 'products', 'testimonials', 'latest_products', 'blogs', 'logos'));
}

    public function success()
    {
        $page_heading = "Success";
        return view('front_end.success', compact('page_heading'));
    }
    
     public function blogs()
    {
        $page_heading = "Blogs";
         $blogs = Blog::where(['deleted' => 0, 'active' => 1])->orderBy('id', 'desc')->paginate(6);
         $recent_blogs = Blog::where(['deleted' => 0, 'active' => 1])->orderBy('id', 'desc')->take(5)->get();
        return view('front_end.blogs', compact('page_heading','blogs','recent_blogs'));
    }
     public function blog_detail($id)
    {
        $page_heading = "Blog Detail";
         $blog = Blog::where('id', $id)->where(['deleted' => 0, 'active' => 1])->firstOrFail();
         $recent_blogs = Blog::where(['deleted' => 0, 'active' => 1])->orderBy('id', 'desc')->take(5)->get();
        return view('front_end.blog_detail', compact('page_heading','blog','recent_blogs'));
    }
    public function register()
    {  
        $page_heading = "Vendor Registration";
        $countries = CountryModel::where(['deleted' => 0])->orderBy('name', 'asc')->get();
        $industry = IndustryTypes::where(['deleted' => 0])->get();
        $banks = BankModel::get();
        $banks_codes = BankCodetypes::get();
        $activityTypes = ActivityType::with('account')->where(['deleted' => '0'])->whereNotIn('id',[2])
            ->orderBy('sort_order', 'asc')->get();

        return view('front_end.register', compact('page_heading', 'countries', 'industry', 'banks', 'banks_codes','activityTypes'));
    }

    public function save_vendor(Request $request)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
        $redirectUrl = '';

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if (!empty($request->password)) {
            $validator = Validator::make($request->all(), [
                'confirm_password' => 'required',
            ]);
        }
        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            $input = $request->all();
            $check_exist = VendorModel::where('email', $request->email)->where('id', '!=', $request->id)->get()->toArray();
            if (empty($check_exist)) {
                $check_exist_phone = VendorModel::where('phone', $request->phone)->where('id', '!=', $request->id)->get()->toArray();
                if (empty($check_exist_phone)) {

                    $ins = [
                        'country_id' => $request->country_id,
                        'name' => $request->name,
                        'email' => $request->email,
                        'dial_code' => $request->dial_code,
                        'phone' => $request->phone,
                        'role' => '3', //vendor
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'state_id' => '0',
                        'city_id' => $request->city_id,
                        'activity_id' => $request->activity_id,
                    ];

                    if ($request->password) {
                        $ins['password'] = bcrypt($request->password);
                    }

                    if ($request->file("image")) {
                        $response = image_upload($request, 'company', 'image');
                        if ($response['status']) {
                            $ins['user_image'] = $response['link'];
                        }
                    }

                    if ($request->id != "") {
                        $ins['updated_at'] = gmdate('Y-m-d H:i:s');
                        $user = VendorModel::find($request->id);
                        $user->update($ins);

                        $vendordata = VendorDetailsModel::where('user_id', $request->id)->first();
                        $bank = BankdataModel::where('user_id', $request->id)->first();
                        if (empty($vendordata->id)) {
                            $vendordatils = new VendorDetailsModel();
                            $vendordatils->user_id = $request->id;
                        } else {
                            $vendordatils = VendorDetailsModel::find($vendordata->id);
                        }

                        if (empty($bank->id)) {
                            $bankdata = new BankdataModel();
                            $bankdata->user_id = $request->id;
                        } else {
                            $bankdata = BankdataModel::find($bank->id);
                        }

                        $status = "1";
                        $message = "Vendor updated succesfully";
                    } else {
                        $ins['created_at'] = gmdate('Y-m-d H:i:s');
                        $userid = VendorModel::create($ins)->id;

                        $vendordatils = new VendorDetailsModel();
                        $vendordatils->user_id = $userid;

                        $bankdata = new BankdataModel();
                        $bankdata->user_id = $userid;

                        

                        $status = "1";
                        $message = "Vendor added successfully";

                        
                    }

                    //pharmacy or product
                    $industrytype = 0;
                    if(!empty($request->type))
                    {
                        $typecount = count($request->type);
                        if($typecount == 2)
                        {
                           $industrytype = 3;//pharmacy and service
                        }
                        else
                        {
                            foreach($request->type as $typeval)
                            {
                                if($typeval == 1)
                                {
                                    $industrytype = 1;
                                }
                                else
                                {
                                    $industrytype = 2;
                                }
                            }
                        }
                    }
                    //pharmacy or product END

                    $lat = "";
                    $long = "";
                    if ($request->location) {
                    $location = explode(",", $request->location);
                    $lat = $location[0];
                    $long = $location[1];
                    }

                    $vendordatils->industry_type = $industrytype;
                    $vendordatils->homedelivery = $request->has_own_delivery??1;
                    $vendordatils->branches = 0;
                    $vendordatils->company_name = $request->company_legal_name;
                    $vendordatils->company_brand = $request->company_brand_name;
                    $vendordatils->reg_date = $request->business_registration_date;
                    $vendordatils->trade_license = $request->trade_licene_number;
                    $vendordatils->trade_license_expiry = date('Y-m-d', strtotime($request->trade_licene_expiry));
                    $vendordatils->vat_reg_number = $request->vat_registration_number;
                    $vendordatils->vat_reg_expiry = $request->vat_expiry_date;
                    $vendordatils->location = $request->txt_location;
                    $vendordatils->latitude = $lat;
                    $vendordatils->longitude = $long;

                    $vendordatils->address1 = $request->address1;
                    $vendordatils->address2 = $request->address2;
                    $vendordatils->street = $request->street;
                    $vendordatils->state = '0';
                    $vendordatils->city = $request->city_id;
                    $vendordatils->area = $request->area;
                    $vendordatils->zip = $request->zip;

                    //logo
                    if ($request->file("logo")) {
                        $response = image_upload($request, 'company', 'logo');
                        if ($response['status']) {
                            $vendordatils->logo = $response['link'];
                        }
                    }
                    //logo end

                    if ($request->file("trade_licence")) {
                        $response = image_upload($request, 'company', 'trade_licence');
                        if ($response['status']) {
                            $vendordatils->trade_license_doc = $response['link'];
                        }
                    }
                    $vendordatils->save();

                    $user = User::find($userid);
                    $send_email_id = $request->email;
                    $email_status = send_email($send_email_id, 'Registration Successfully', view('mail.registration_successful', compact('user')));

                   //add location 

                   $locationins = new VendorLocation;
                   $locationins->user_id = $userid;
                   $locationins->location = $request->txt_location;
                   $locationins->latitude = $lat;
                   $locationins->longitude = $long;
                   $locationins->created_at = gmdate('Y-m-d H:i:s');
                   $locationins->updated_at = gmdate('Y-m-d H:i:s');
                   $locationins->is_default = 1;
                   $locationins->save();

                   //add location END

                } else {
                    $status = "0";
                    $message = "Phone number should be unique";
                    $errors['phone'] = "Already exist";
                }

            } else {
                $status = "0";
                $message = "Email should be unique";
                $errors['email'] = $request->email . " already added";
            }

        }
        echo json_encode(['status' => $status, 'message' => $message, 'errors' => $errors]);
    }

    public function reset_password($id)
    {
        $userdata = VendorModel::where('password_reset_code',$id)->first();
        if($userdata)
        {
            $timenew       = date('Y-m-d H:i:s');
            $cenvertedTime = date('Y-m-d H:i:s',strtotime('+10 minutes',strtotime($userdata->password_reset_time)));
            if($timenew <= $cenvertedTime)
            {
                $page_heading = "Reset Password";
                $id = $id;
                return view('front_end.reset_password', compact('page_heading','id'));
            }
            else
            {
            echo "Link expired";
            }
        }
        else
        {
            echo "Link expired";
        }

    }
    public function new_password(Request $request)
    {
       if ($request->isMethod('post')) {
            $status = "0";
            $message = "";
            $errors = [];
            $validator = Validator::make($request->all(),
                [
                    'password' => 'required',
                    'token' => 'required',
                ],
                [
                    'password.required' => 'Password required',
                    'token.required' => 'User token required',
                ]
            );
            if ($validator->fails()) {
                $status = "0";
                $message = "Validation error occured";
                $errors = $validator->messages();
            } else {
                $userdata = VendorModel::where('password_reset_code',$request->token)->first();
                $new_pswd = $request->password;
                $user_id = $userdata->id;
                    $up['password'] = bcrypt($new_pswd);
                    $up['updated_on'] =gmdate('Y-m-d H:i:s');
                    if(User::update_password($user_id,$new_pswd)){
                        $status = "1";
                        $message = "Password successfully changed";
                        $errors = '';
                    }else{
                        $status = "0";
                        $message = "Unable to change password. Please try again later";
                        $errors = '';
                    }

            }
            return response()->json(['success' => true, 'message' => $message]);
        }

    }
    public function getCountryToCity(Request $request){
      $status   = true;
      $sid = $request->sid;
      $citys    = Cities::where('country_id',$request->id)->orderBy('id', 'desc')->get();
      $listing  = '<option value="" selected>Select</option>';
      foreach ($citys as $row){
        $selected = ($row->id==$sid)?'selected':'';
        $listing .='<option '.$selected.' value="'.$row->id.'">'.$row->name.'</option>';
      }
      echo json_encode(['status'=>$status,'message'=>$listing]);
    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscribers_emails,email'
        ], [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already subscribed.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()
            ]);
        }

        try {
            SubscriberEmail::create([
                'email' => $request->email
            ]);

            return response()->json([
                'status' => 1,
                'message' => 'Subscription successful!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'An error occurred. Please try again later.'
            ]);
        }
    }

    public function contactus(Request $request){
        $page_heading = "Contact Us";
        $detailssite  = ContactUsSetting::first();
        return view('front_end.contact_us', compact('page_heading','detailssite'));
    }

    public function faqs(Request $request){
        $page_heading = "FAQs";
        $faqs = FaqModel::where('active', 1)->orderBy('id', 'desc')->get();
        
        return view('front_end.faq', compact('page_heading','faqs'));
    }
    public function sendMessage(Request $request)
    {
        // Validate the data
        $validated = $request->validate([
            'vendor_id' => 'required',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);
    
        // Store the message or send it (e.g., store it in a database or send an email)
        // Example: Store the message in the database (Message model should be created)
        $message = new VendorMessage();
        $message->vendor_id = $request->vendor_id;
        $message->user_id = Auth::id();
        $message->name = $request->name;
        $message->email = $request->email;
        $message->phone = $request->phone;
        $message->subject = $request->subject;
        $message->message = $request->message;
        $message->save();
    
        // Return a JSON response
        return response()->json(['status' => 1, 'message' => 'Message sent successfully']);
    }
    public function reportVendor(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|integer',
            'reason' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        $report = new ReportedShop(); // Make sure this model exists
        $report->shop_id = $request->vendor_id;
        $report->user_id = Auth::id(); // optional, if user is logged in
        $report->reason_id = $request->reason;
        $report->description = $request->remarks;
        $report->save();

        return response()->json(['status' => 1, 'message' => 'Report submitted successfully']);
    }


    
    public function followVendor(Request $request)
    {
        // Check if the user is logged in
        
    
        $user_id = Auth::id();  // Get logged-in user's ID
        $vendor_id = $request->input('vendor_id');
     
         $vendor_id = $request->vendor_id;
            $check_exist = VendorFollower::where(['vendor_id' => $vendor_id, 'user_id' => $user_id])->get();
            if ($check_exist->count() > 0) {
                VendorFollower::where(['vendor_id' => $vendor_id, 'user_id' => $user_id])->delete();
                $status = (string) 1;
                $message = "disliked";
            } else {
                $like = new VendorFollower();
                $like->vendor_id = $vendor_id;
                $like->user_id = $user_id;
                $like->save();
                if ($like->id > 0) {
                    $status = (string) 1;
                    $message = "liked";
                } else {
                    $message = "faild to like";
                }
            }
    
       
            return response()->json(['status' => 1, 'message' => $message]);
        
    }

    public function contactusstore(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|digits_between:10,15',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a valid string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email may not be greater than 255 characters.',
            
            'phone.required' => 'The phone number field is required.',
            'phone.digits_between' => 'The phone number must be between 10 and 15 digits.',
            
            'subject.required' => 'The subject field is required.',
            'subject.string' => 'The subject must be a valid string.',
            'subject.max' => 'The subject may not be greater than 255 characters.',
            
            'message.required' => 'The message field is required.',
            'message.string' => 'The message must be a valid string.',
            'message.max' => 'The message may not be greater than 1000 characters.',
        ]);

        ContactUsModel::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'mobile_number' => $validatedData['phone'], 
            'subject' => $validatedData['subject'],
            'message' => $validatedData['message'],
        ]);

        return response()->json(['success' => 'Your message has been sent successfully!']);
    }

    public function privacypolicy(Request $request){
        $page_heading = "Privacy Policy";
        $record = Article::find(1);
        
        return view('front_end.privacypolicy', compact('page_heading','record'));
    }
    public function termsandconditions(Request $request){
        $page_heading = "Terms and Conditions";
        $record = Article::find(2);
        
        return view('front_end.termsandcondition', compact('page_heading','record'));
    }
    public function sellerpolicy(Request $request){
        $page_heading = "Seller Policy";
        $record = Article::find(4);
        
        return view('front_end.sellerpolicy', compact('page_heading','record'));
    }
    public function handwipaymentpolicy(Request $request){
        $page_heading = "Payment Policy";
        $record = Article::find(5);
        
        return view('front_end.handwipaymentpolicy', compact('page_heading','record'));
    }
    public function aboutus(Request $request){
        $page_heading = "About Us";
        
        
        return view('front_end.aboutus', compact('page_heading'));
    }
}
