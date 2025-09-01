<?php

namespace App\Http\Controllers\Admin;

use App\Models\ServiceCategories;
use App\Models\Service;
use App\Models\Categories;
use App\Models\BuildingTypes;
use App\Models\ProductModel;
use App\Models\VendorServiceTimings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use App\Models\States;
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
use Illuminate\Support\Facades\Mail;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!GetUserPermissions('services_view')){
            return redirect()->to('admin/dashboard');
        }
        $page_heading = "Workshops";
        $categories = Service::with('serviceType')->where(['deleted' => 0])->orderBy('id','desc')->get();
        
        foreach ($categories as $key => $cat) {

            $categories[$key]->categories_selected = DB::table('service_category_selected')
                ->join('service_category', 'service_category.id', '=', 'service_category_selected.category_id')
                ->where('service_id', '=', $cat->id)->get();
        }



        return view('admin.service.list', compact('page_heading', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $page_heading = "Workshops";
        $mode = "create";
        $id = "";
        $name = "";
        $name_ar = "";
        $activity_id = "";
        $parent_id = "";
        $image = "";
        $active = "1";
        $banner_image = "";
        $category = [];
        $description = "";
        $category       = '';
        $serviceprice       = "";
        $duration       = "";
        $building_type  = "";
        $servic_prcies = [];
        $service_price_type = '';
        $price_label  = "";
        $to_date  = "";
        $from_date  = "";
        $term_and_condition  = "";
        $term_and_condition_ar  = "";
        $work_shop_details  = "";
        $seats  = "";
        $from_time  ="";
        $to_time  ="";
        $location  ="";
        $latitude  ="";
        $longitude  ="";
        $service_features=[];
        $service_features_ids=[];
        $category_ids = [];
        $additional_images = [];
        $cities = Cities::where(['deleted' => 0])->get();

        $parent_categories_list = $parent_categories = ServiceCategories::where(['deleted' => 0, 'active' => 1, 'parent_id' => 0])->get()->toArray();
        $parent_categories_list = ServiceCategories::where(['deleted' => 0, 'active' => 1])->where('parent_id', '!=', 0)->get()->toArray();

        $parent_categories = array_column($parent_categories, 'name', 'id');
        asort($parent_categories);
        $category_list = $parent_categories;

        $sub_categories = [];
        foreach ($parent_categories_list as $row) {
            $sub_categories[$row['parent_id']][$row['id']] = $row['name'];
        }
        $sub_category_list = $sub_categories;
        $states = States::where(['deleted' => 0, 'country_id' => 1])->get();
       // $cities = [];
        $buildingTypes = BuildingTypes::where(['deleted' => 0])->get();

        $activity_types = ActivityType::select('id','name as activity_name')->where(['deleted' => 0, 'account_id' => AccountType::COMMERCIAL_CENTER])->whereIn('id',[4,1,6])->get();
            $service_types = ServiceType::select('id','name')->where(['deleted' => 0])->get();
            $all_features=\App\Models\EventFeature::get();
            $service_features=[];
            // $sellers = VendorModel::select('users.id', 'vendor_details.company_name as name')->where(['role'=>'3','users.verified'=>'1','users.deleted'=>'0','users.deleted'=>'0'])
            // ->leftjoin('vendor_details','vendor_details.user_id','=','users.id')->get();
            $sellers = VendorModel::leftJoin('stores', 'stores.vendor_id', '=', 'users.id')->where(['users.role'=>'3','users.verified'=>'1','users.deleted'=>'0','users.deleted'=>'0'])->select('users.*', 'stores.store_name as store_name')->get();
            $seller_user_id="";
        return view("admin.service.create", compact('service_features_ids','name_ar','term_and_condition_ar','cities','additional_images','from_time','to_time','seller_user_id','sellers','service_features','location','latitude','longitude','all_features','service_features','from_date','to_date','seats','term_and_condition','work_shop_details','page_heading', 'category', 'price_label','mode', 'id', 'name', 'parent_id', 'image', 'active', 'banner_image', 'description', 'category', 'category_list', 'serviceprice', 'duration', 'parent_categories_list', 'sub_categories', 'sub_category_list', 'category_ids', 'states', 'cities', 'servic_prcies', 'buildingTypes', 'building_type','service_price_type','activity_id','activity_types','service_types'));
    }
    public function get_service_categories_by_activity_id(Request $request){

        $activity_id = $request->activity_id ;
        $category_list = [];
        $cat_view = '';
        $brand_view = '';
        if($activity_id){
            $parent_categories_list = $parent_categories = ServiceCategories::where(['deleted'=>0,'active'=>1,'parent_id'=>0])->where('activity_id',$activity_id)->get()->toArray();
            $parent_categories_list = ServiceCategories::where(['deleted'=>0,'active'=>1])->where('parent_id','!=',0)->where('activity_id',$activity_id)->get()->toArray();

            $parent_categories = array_column($parent_categories, 'name', 'id');
            asort($parent_categories);
            $category_list = $parent_categories;
            $category_ids = [];

            $sub_categories = [];
            foreach ($parent_categories_list as $row) {
                $sub_categories[$row['parent_id']][$row['id']] = $row['name'];
            }
            $sub_category_list = $sub_categories;
            $id = '';

            $cat_view = view('admin.product.categories',compact('category_list','category_ids','sub_category_list','id'))->render();

        }
        return  json_encode(['status' => '1','cat_view'=>$cat_view, 'message' => '']);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
        $redirectUrl = '';

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            $lat = "";
            $long = "";
            if ($request->location) {
                $location = explode(",", $request->location);
                $lat = $location[0];
                $long = $location[1];
            }
            $request->activity_id=($request->activity_id)?$request->activity_id:0;
            $input = $request->all();
            $check_exist = Service::where(['deleted' => 0, 'name' => $request->name])->where('id', '!=', $request->id)->get()->toArray();
            if (empty($check_exist)) {
                $request->duration=0;
                $ins = [
                    'name'            => $request->name,
                    'name_ar'            => $request->name_ar,
                    'updated_at'      => gmdate('Y-m-d H:i:s'),
                    'service_price'   => $request->price ?? 0,
                    'description'     => $request->description,
                    'duration'        => $request->duration,
                    'building_type_id' => $request->buildingType,
                    'active'          => $request->active,
                    'service_price_type'=>$request->service_price_type,
                    'price_label'=>$request->price_lable,
                    'activity_id'=>$request->activity_id,
                    'from_date'=>$request->from_date,
                    'to_date'=>$request->to_date,
                    'seats'=>$request->seats,
                    'term_and_condition'=>$request->term_and_condition,
                    'term_and_condition_ar'=>$request->term_and_condition_ar,
                    'work_shop_details'=>$request->work_shop_details,
                    'location' => $request->txt_location,
                    'latitude' => $lat,
                    'longitude' => $long,
                    'vendor_id' =>  $request->seller_id,
                    'from_time' =>  $request->from_time,
                    'to_time' =>  $request->to_time,
                    'city_id' => $request->city_id
                    //'seats'=>$request->seats,
                ];

                if ($request->file("image")) {
                    $response = image_save($request, config('global.service_image_upload_dir'), 'image', '');
                    if ($response['status']) {
                        $ins['image'] = $response['link'];
                    }
                }
                if ($request->file("feature_image")) {
                    $response = image_save($request, config('global.service_image_upload_dir'), 'feature_image', '');
                    if ($response['status']) {
                        $ins['feature_image'] = $response['link'];
                    }
                }

              

                if ($request->id != "") {
                    $category = Service::find($request->id);
                    $category->update($ins);
                    $inid = $request->id;
                    $status = "1";
                    $message = "Services updated succesfully";
                } else {
                    $ins['created_at'] = gmdate('Y-m-d H:i:s');
                    $service =  Service::create($ins);
                    $inid = $service->id;
                    $status = "1";
                    $message = "Services added successfully";
                }
                if ($request->hasFile('additional_images')) {
                    // Delete existing additional images
                    ServiceImage::where('service_id', $inid)->delete();
            
                    // Loop through the uploaded files and save them
                    foreach ($request->file('additional_images') as $image) {
                        // Generate a unique file name for the image
                        $fileName = time() . uniqid() . '.' . $image->getClientOriginalExtension();
            
                        // Use the config to set the directory where the images will be saved
                        $directory = 'uploads/service/'; // Use the directory from the config
                        $path = $image->storeAs($directory, $fileName, 'public'); // Store it in the 'public' disk
            
                        // Save the image path in the database
                        ServiceImage::create([
                            'service_id' => $inid,
                            'image' => $fileName, // Store the file path returned by storeAs()
                        ]);
                    }
            
                   
                }
                

                $categories = $request->category_ids;


                if (!empty($categories)) {
                    $all_categories = ServiceCategories::getCategoriesCondition($categories);
                    $all_categories = array_column($all_categories, 'service_category_parent_id', 'service_category_id');
                    foreach ($categories as $t_cat) {
                        $p_cat_id = $all_categories[$t_cat] ?? 0;
                        do {
                            if ($p_cat_id > 0) {
                                $categories[] = $p_cat_id;
                                $p_cat_id = $all_categories[$p_cat_id] ?? 0;
                            }
                        } while ($p_cat_id > 0);
                    }
                    $categories = array_filter($categories);
                    $categories = array_unique($categories);
                }

                if (!empty($categories)) {
                    DB::table('service_category_selected')->where('service_id', '=', $inid)->delete();
                    foreach ($categories as $cat) {
                        DB::table('service_category_selected')->insert(['category_id' => $cat, 'service_id' => $inid]);
                    }
                }

                $text = $request->text;
                $hourly_rate = $request->hourly_rate;
                HourlyRate::where('service_id',$inid)->delete();
                if(!empty($hourly_rate))
                {
                    foreach($text as $key => $value) {
                        $serviceprice = new HourlyRate();
                        $serviceprice->service_id    = $inid;
                        $serviceprice->text         = $value;
                        $serviceprice->hourly_rate  = $hourly_rate[$key];
                        $serviceprice->save();
                    }
                }

                Servicefeatures::where('service_id',$inid)->delete();
                $feature_ids = $request->feature_ids;

                if ( isset($request->item) && !empty($request->item) ) {
                    foreach ($request->item as $key => $row) {
                        $Cuisine = new Servicefeatures();
                        $Cuisine->service_id = $inid;
                        $Cuisine->feature_title = $row['name'];
                        $Cuisine->feature_title_ar = $row['name_ar'] ?? "";
                        $Cuisine->event_feature_id = $row['feature_ids'];
                        $Cuisine->save();
                    }
                }

            } else {
                $status = "0";
                $message = "Name should be unique";
                $errors['name'] = $request->name . " already added";
            }
        }
        echo json_encode(['status' => $status, 'message' => $message, 'errors' => $errors]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function deleteImage(Request $request)
    {
        $id = $request->input('id'); 
        $feature_image = Service::find($id)->feature_image; 
      

        if ($request->input('feature_image') == 'delete' && $feature_image) {
            // Perform the image deletion from storage
            if (file_exists(public_path($feature_image))) {
                unlink(public_path($feature_image)); // Delete the image file
            }

            // Optionally, remove the image path from the database
            Service::where('id', $id)->update(['feature_image' => null]);

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error'], 400);
    }

    public function edit($id)
    {
        //
        $category = Service::find($id);
        
        $product_categories = ServiceCategories::get_service_categories($id);
        $additional_images = ServiceImage::where('service_id', $id)->get();
        $category_ids       = array_column($product_categories, 'category_id');
        $states = States::where(['deleted' => 0, 'country_id' => 1])->get();
        $cities = Cities::where(['deleted' => 0])->get();
       
        if ($category) {
            $page_heading   = "Workshops";
            $mode           = "edit";
            $serviceprice   = $category->service_price;
            $id             = $category->id;
            $name           = $category->name;
            $name_ar           = $category->name_ar;
            $parent_id      = $category->parent_id;
            $image          = $category->image;
            $feature_image = $category->feature_image;
            $active         = $category->active;
            $description    = $category->description;
            $duration       = $category->duration;
            $building_type  = $category->building_type_id;
            $service_price_type = $category->service_price_type;
            $activity_id       = $category->activity_id;
            $price_label    = $category->price_label;
            $to_date  =$category->to_date;
            $from_date  = $category->from_date;
            $term_and_condition  = $category->term_and_condition;
            $term_and_condition_ar  = $category->term_and_condition_ar;
            $work_shop_details  = $category->work_shop_details;
            $seats  =$category->seats;
            $from_time  =$category->from_time;
            $to_time  =$category->to_time;

            $location  =$category->location;
            $latitude  =$category->latitude;
            $longitude  =$category->longitude;
            $seller_user_id=$category->vendor_id;
            $city_id       = $category->city_id;
            $category       = $category->category;
            
            
            
           
            $service_features=Servicefeatures::where('service_id',$id)->get();
            
            $service_features_ids=Servicefeatures::where('service_id',$id)->pluck('event_feature_id')->toArray();
            $activity_types = ActivityType::select('id','name as activity_name')->where(['deleted' => 0, 'account_id' => AccountType::COMMERCIAL_CENTER])->whereIn('id',[4,1,6])->get();
            $service_types = ServiceType::select('id','name')->where(['deleted' => 0])->get();


            $banner_image   = "";

            $parent_categories_list = $parent_categories = ServiceCategories::where(['deleted' => 0, 'active' => 1, 'parent_id' => 0])->whereIn('activity_id',[$activity_id])->get()->toArray();
            $parent_categories_list = ServiceCategories::where(['deleted' => 0, 'active' => 1])->whereIn('activity_id',[$activity_id])->where('parent_id', '!=', 0)->get()->toArray();

            $parent_categories = array_column($parent_categories, 'name', 'id');
            asort($parent_categories);
            $category_list = $parent_categories;

            $sub_categories = [];
            foreach ($parent_categories_list as $row) {
                $sub_categories[$row['parent_id']][$row['id']] = $row['name'];
            }
            $sub_category_list = $sub_categories;
            $buildingTypes = BuildingTypes::where(['deleted' => 0])->get();

            $servic_prcies = HourlyRate::where('service_id',$id)->get();
            
            $all_features=\App\Models\EventFeature::get();
            //  $sellers = VendorModel::select('users.id', 'vendor_details.company_name as name')->where(['role'=>'3','users.verified'=>'1','users.deleted'=>'0','users.deleted'=>'0'])
            // ->leftjoin('vendor_details','vendor_details.user_id','=','users.id')->get();
            $sellers = VendorModel::leftJoin('stores', 'stores.vendor_id', '=', 'users.id')->where(['users.role'=>'3','users.verified'=>'1','users.deleted'=>'0','users.deleted'=>'0'])->select('users.*', 'stores.store_name as store_name')->get();
            return view("admin.service.create", compact('service_features_ids','term_and_condition_ar','name_ar','city_id','additional_images','seller_user_id','sellers','location','latitude','longitude','all_features','service_features','from_time','to_time','work_shop_details','from_date','to_date','seats','term_and_condition','page_heading', 'category', 'price_label',
            'mode', 'id', 'name', 'parent_id', 'image', 'active',  'banner_image',
             'description', 'category', 'serviceprice', 'parent_categories_list', 'sub_category_list',
              'category_list', 'category_ids','feature_image', 'states', 'cities',  'buildingTypes', 'building_type', 'duration','servic_prcies','service_price_type','activity_id','activity_types','service_types'));
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $category = Service::find($id);
        if ($category) {
            $category->deleted = 1;
            $category->active = 0;
            $category->updated_at = gmdate('Y-m-d H:i:s');
            $category->save();
            $status = "1";
            $message = "Services removed successfully";
        } else {
            $message = "Sorry!.. You cant do this?";
        }

        echo json_encode(['status' => $status, 'message' => $message, 'o_data' => $o_data]);
    }
    public function change_status(Request $request)
    {
        $status = "0";
        $message = "";
        if (Service::where('id', $request->id)->update(['active' => $request->status])) {
            $status = "1";
            $msg = "Successfully activated";
            if (!$request->status) {
                $msg = "Successfully deactivated";
            }
            $message = $msg;
            // $user_email = DB::select('select email from service s 
            // left join users u on s.service_user_id = u.id where order_id =' . $request->id);

            // Mail::to(['address' => $user_email[0]->email])
            //     ->send(new \App\Mail\OrderStatusChange($request->id, $request->status));
        } else {
            $message = "Something went wrong";
        }
        echo json_encode(['status' => $status, 'message' => $message]);
    }
    public function sort(Request $request)
    {
        if ($request->ajax()) {
            $status = 0;
            $message = '';

            $items = $request->items;
            $items = explode(",", $items);
            $sorted = Service::sort_item($items);
            if ($sorted) {
                $status = 1;
            }

            echo json_encode(['status' => $status, 'message' => $message]);
        } else {
            $page_heading = "Sort Categories";

            $list = Service::where(['deleted' => 0])->orderBy('sort_order','asc')->get();

            foreach ($list as $key => $value) {
                $category_id = ServiceCategorySelected::where('service_id',$value->id)->first()->category_id??'';
                $categoryname = ServiceCategories::find($category_id);
                $list[$key]->name = $value->name.' - '.$categoryname->name;
            }

            return view("admin.sort", compact('page_heading', 'list'));
        }
    }
    public function timeslote()
    {
        $page_heading = "Eevents";
        $mode = "create";
        $id = "";
        $name = "";
        $parent_id = "";
        $image = "";
        $feature_image = "";
        $active = "1";
        $banner_image = "";
        $category = [];
        $description = "";
        $category       = '';
        $serviceprice       = "";
        $duration       = "";
        $building_type  = "";
        $servic_prcies = [];

        $category_ids = [];

        $parent_categories_list = $parent_categories = ServiceCategories::where(['deleted' => 0, 'active' => 1, 'parent_id' => 0])->get()->toArray();
        $parent_categories_list = ServiceCategories::where(['deleted' => 0, 'active' => 1])->where('parent_id', '!=', 0)->get()->toArray();

        $parent_categories = array_column($parent_categories, 'name', 'id');
        asort($parent_categories);
        $category_list = $parent_categories;

        $sub_categories = [];
        foreach ($parent_categories_list as $row) {
            $sub_categories[$row['parent_id']][$row['id']] = $row['name'];
        }
        $sub_category_list = $sub_categories;
        $states = States::where(['deleted' => 0, 'country_id' => 1])->get();
        $cities = [];
        $buildingTypes = BuildingTypes::where(['deleted' => 0])->get();
        $datamain = VendorServiceTimings::get()->first();
        $datamain->gr_availablity =VendorServiceTimings::where(['service_id'=>2,'vendor'=>1])->first();
        $vendor_timings = ServiceTimings::where(['vendor_id'=>1])->get();
            $days = Config('global.days');
            $selected_days = [];
            foreach($days as $k=>$val){
                $in=[
                    'day'       =>  $val
                ];
                $in['open_24'] = "0";
                $from_hours = [];
                $to_hours = [];
                foreach($vendor_timings as $timing){
                    if($timing->day == $val){
                        $in['open_24'] = $timing->has_24_hour;
                        
                        $from_hours[] = $timing->time_from;
                        $to_hours[] = $timing->time_to;
                    }
                }
                
                $in['from_hours'] = $from_hours;
                $in['to_hours'] = $to_hours;
                
                $selected_days[$val] = $in;
            }

        

        return view("admin.service.time_slote", compact('page_heading', 'feature_image','selected_days','datamain','category', 'mode', 'id', 'name', 'parent_id', 'image', 'active', 'banner_image', 'description', 'category', 'category_list', 'serviceprice', 'duration', 'parent_categories_list', 'sub_categories', 'sub_category_list', 'category_ids', 'states', 'cities', 'servic_prcies', 'buildingTypes', 'building_type'));
    }
    public function save_time_slote(Request $request)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
        $redirectUrl = '';

        $validator = Validator::make($request->all(), [
            //'first_name' => 'required',
        ]);
       
        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            ServiceTimings::where('vendor_id',1)->delete();
                 $days = Config('global.days') ;
                    $gr_availability =[];
                    foreach($days as $key =>$val){
                        $vet_val = $val.'_grooming';
                        if(isset($request->{$vet_val})) {
                            $to_data = $request->{$key.'_to_grooming'};
                            $has_24=$request->{$val.'_24'}??0;
                            if($has_24 != 1){
                           
                                foreach($request->{$key.'_from_grooming'} as $in=>$dd){
                                    $insert_data = [];
                                    $insert_data['vendor_id'] = 1;
                                    $insert_data['service_id'] = 2;
                                    $insert_data['day'] = $val;
                                    $insert_data['has_24_hour'] = $request->{$val.'_24'}??0;
                                    $insert_data['time_from'] = $dd;
                                    $insert_data['time_to'] = $to_data[$in];
                                    $insert_data['created_at'] = gmdate('Y-m-d H:i:s');
                                    $insert_data['updated_at'] = gmdate('Y-m-d H:i:s');
                                    $gr_availability[] = $insert_data;
                                    ServiceTimings::create($insert_data);
                                }
                            }else{
                                $insert_data = [];
                                $insert_data['vendor_id'] = 1;
                                $insert_data['service_id'] = 2;
                                $insert_data['day'] = $val;
                                $insert_data['has_24_hour'] = 1;
                                $insert_data['time_from'] = "00:00 AM";
                                $insert_data['time_to'] = "12:59 PM";
                                $insert_data['created_at'] = gmdate('Y-m-d H:i:s');
                                $insert_data['updated_at'] = gmdate('Y-m-d H:i:s');
                                $gr_availability[] = $insert_data;
                                ServiceTimings::create($insert_data);
                            }
                            
                        } else {
                            // $gr_availability[][$val] = 0;
                            // $gr_availability[]['time_from'] = '00:00';
                            // $gr_availability[]['time_to'] = '00:00';
                            // $gr_availability[]['created_at'] = gmdate('Y-m-d H:i:s');
                            // $gr_availability[]['updated_at'] = gmdate('Y-m-d H:i:s');
                        }
                    }
                    //$datamain = VendorServiceTimings::where('vendor',1)->first();
                    
           
                    $status = "1";
                    $message ="Service time updated successfully!";
        }
        echo json_encode(['status' => $status, 'message' => $message, 'errors' => $errors]);
    }
    public function save_time_slote_old(Request $request)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
        $redirectUrl = '';

        $validator = Validator::make($request->all(), [
            //'first_name' => 'required',
        ]);
       
        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            VendorServiceTimings::where('vendor',1)->delete();
                 $days = Config('global.days') ;
                    $gr_availability['vendor'] = 1;
                    $gr_availability['service_id'] = 2;
                    foreach($days as $key =>$val){
                        $vet_val = $val.'_grooming';
                        if(isset($request->{$vet_val})) {
                            $gr_availability[$val] = $request->{$vet_val} ;
                            $gr_availability[$key.'_from'] = $request->{$key.'_from_grooming'} ;
                            $gr_availability[$key.'_to'] = $request->{$key.'_to_grooming'} ;
                        } else {
                            $gr_availability[$val] = 0;
                            $gr_availability[$key.'_from'] = '00:00';
                            $gr_availability[$key.'_to'] = '00:00';
                        }
                    }
                    VendorServiceTimings::create($gr_availability);
                    //$datamain = VendorServiceTimings::where('vendor',1)->first();
                    
           
                    $status = "1";
                    $message ="Service time updated successfully!";
        }
        echo json_encode(['status' => $status, 'message' => $message, 'errors' => $errors]);
    }
    
}