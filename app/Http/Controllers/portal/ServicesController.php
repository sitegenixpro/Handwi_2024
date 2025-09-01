<?php

namespace App\Http\Controllers\portal;

use App\Models\ServiceCategories;
use App\Models\Service;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Categories;
use App\Models\BuildingTypes;
use App\Models\ProductModel;
use App\Models\VendorServiceTimings;
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
use Validator;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_heading = "Services";
        $user  = auth::user();

            $page_heading = "Workshops";
            $categories = Service::with('serviceType')->where(['deleted' => 0, 'vendor_id'=>$user->id])->orderBy('id','desc')->get();
    
            foreach ($categories as $key => $cat) {
    
                $categories[$key]->categories_selected = DB::table('service_category_selected')
                    ->join('service_category', 'service_category.id', '=', 'service_category_selected.category_id')
                    ->where('service_id', '=', $cat->id)->get();
            }
    
    
    
            return view('portal.service.list', compact('page_heading', 'categories'));
        
    
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
    $cities = Cities::where(['deleted' => 0])->get();
    $service_types = ServiceType::select('id','name')->where(['deleted' => 0])->get();

    // Initialize variables with default values
    $data = [
        'id' => "",
        'name' => "",
        'activity_id' => "",
        'parent_id' => "",
        'image' => "",
        'active' => "1",
        'banner_image' => "",
        'description' => "",
        'serviceprice' => "",
        'duration' => "",
        'building_type' => "",
        'service_price_type' => "",
        'price_label' => "",
        'to_date' => "",
        'from_date' => "",
        'term_and_condition' => "",
        'work_shop_details' => "",
        'seats' => "",
        'from_time' => "",
        'to_time' => "",
        'location' => "",
        'latitude' => "",
        'longitude' => "",
        'seller_user_id' => "",
        'category' => [],
        'service_features' => [],
        'service_features_ids' => [],
        'category_ids' => [],
        'additional_images' => [],
        'servic_prcies' => [],
        'all_features' => [],
        'states' => [],
        'cities' => $cities,
        'parent_categories_list' => [],
        'sub_categories' => [],
        'sub_category_list' => [],
        'buildingTypes' => [],
        'service_types' => $service_types,
        
    ];

    return view("portal.service.create", array_merge($data, [
        'page_heading' => $page_heading,
        'mode' => $mode,
    ]));
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ public function store(Request $request)
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
            $input = $request->all();
            $check_exist = Service::where(['deleted' => 0, 'name' => $request->name])->where('id', '!=', $request->id)->get()->toArray();
            if (empty($check_exist)) {
                $request->duration=0;
                $ins = [
                    'vendor_id'     =>Auth::user()->id,
                    'name'            => $request->name,
                    'updated_at'      => gmdate('Y-m-d H:i:s'),
                    'service_price'   => $request->price ?? 0,
                    'description'     => $request->description,
                    'duration'        => $request->duration,
                    'building_type_id' => $request->buildingType,
                    'active'          => $request->active,
                    'service_price_type'=>$request->service_price_type,
                    
                    'price_label'=>$request->price_lable,
                    'activity_id'=>0,
                    'from_date'=>$request->from_date,
                    'to_date'=>$request->to_date,
                    'seats'=>$request->seats,
                    'term_and_condition'=>$request->term_and_condition,
                    'work_shop_details'=>$request->work_shop_details,
                    'location' => $request->txt_location,
                    'latitude' => $lat,
                    'longitude' => $long,
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
    public function edit($id)
    {
        //
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
             $work_shop_details  = $category->work_shop_details;
             $seats  =$category->seats;
             $from_time  =$category->from_time;
             $to_time  =$category->to_time;
             $city_id       = $category->city_id;
             $location  =$category->location;
             $latitude  =$category->latitude;
             $longitude  =$category->longitude;
             $seller_user_id=$category->vendor_id;
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
             return view("portal.service.create", compact('service_features_ids','additional_images','seller_user_id','location','latitude','longitude','all_features','service_features','from_time','to_time','work_shop_details','from_date','to_date','seats','term_and_condition','page_heading', 'category', 'price_label',
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
            $sorted = ServiceCategories::sort_item($items);
            if ($sorted) {
                $status = 1;
            }

            echo json_encode(['status' => $status, 'message' => $message]);

        } else {
            $page_heading = "Sort Categories";

            $list = Categories::where(['deleted' => 0, 'parent_id' => 0])->get();

            return view("portal.sort", compact('page_heading', 'list'));
        }
    }
}
