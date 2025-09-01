<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\BuildingTypes;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ServiceCategories;
use App\Models\Service;
use App\Models\Stores;
use App\Models\ServicePrice;
use App\Models\Rating;
use App\Models\ServiceInclude;
use App\Models\HourlyRate;
use App\Models\VendorModel;
use App\Models\VendorDetailsModel;
use App\Models\BannerModel;
use App\Models\ActivityType;
use App\Models\ServiceBooking;
use App\Models\SettingsModel;
use App\Models\ServiceType;
use App\Models\Cities;
use App\Models\ServiceCategorySelected;
use Illuminate\Support\Facades\DB;
use Validator;

class ServiceController extends Controller
{

    public function service_type(Request $request)
    {
        $status = (string) 1;
        $message = "";
        $o_data = [];
        $errors = [];
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => (string) 0,
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }
        $access_token = $request->access_token;
        $user = User::where('user_access_token', $access_token)->first();

        $serviceTypes = BuildingTypes::where(['active' => 1, 'deleted' => 0])->get();

        $o_data['list'] = convert_all_elements_to_string($serviceTypes);
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }

    public function service_categories(Request $request)
    {
        $status = "1";
        $message = "";
        $o_data = [];
        $errors = [];
        $validator = Validator::make($request->all(), [
            
        ]);

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => "0",
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }
        $access_token = $request->access_token;
        $user = User::where('user_access_token', $access_token)->first();

        $categories = ServiceCategories::where(['active'=>1,'deleted'=>0,'parent_id'=>0,'activity_id'=>6])->orderBy('sort_order','asc')
        ->get();
        $categorieslist = [];
        $key = 0;
        foreach ($categories as $value) {
            $count = ServiceCategories::join('service_category_selected','service_category_selected.category_id','=','service_category.id')
            ->join('service','service.id','=','service_category_selected.service_id')
            //->join('service_price','service_price.service_id','=','service.id')
            ->whereRaw("service.id in (select service_id from service_category_selected where category_id = '".$value->id."' or category_id in (select id from service_category where parent_id='".$value->id."')) ")
            ->where(['service.deleted'=>0,'service.active'=>1])
            //->where(['service_price.state'=>$request->emirate_id,'service_price.city'=>$request->city_id])
            ->get()->count();
            
            if($count > 0)
            {
              $categorieslist[$key] = new \stdClass;
              $categorieslist[$key]->id = $value->id;
              $categorieslist[$key]->name = $value->name;
              $categorieslist[$key]->image = $value->image;
              $categorieslist[$key]->description = (string) $value->description; 
            //   $categorieslist[$key]->sub_categories = ServiceCategories::select('service_category.id','service_category.name','service_category.image')
            //                                         ->join('service_category_selected','service_category_selected.category_id','=','service_category.id')
            //                                         ->join('service','service.id','=','service_category_selected.service_id')
            //                                         //->join('service_price','service_price.service_id','=','service.id')
            //                                         ->whereRaw("service.id in (select service_id from service_category_selected where category_id = '".$value->id."' or category_id in (select id from service_category where parent_id='".$value->id."')) ")
            //                                         ->where(['service.deleted'=>0,'service.active'=>1])
            //                                         //->where(['service_price.state'=>$request->emirate_id,'service_price.city'=>$request->city_id])
            //                                         ->where(['service_category.active'=>1,'service_category.deleted'=>0,'parent_id'=>$value->id])
            //                                         ->distinct('id')
            //                                         ->orderBy('id')
            //                                         ->orderBy('service_category.sort_order','asc')
            //   ->get(); 
            $categorieslist[$key]->sub_categories = ServiceCategories::select('service_category.id','service_category.name','service_category.image')
                                                    ->whereRaw("service_category.id in (select category_id from service_category_selected scs join service s on scs.service_id=s.id where s.deleted=0 and s.active=1 and s.id in (select service_id from service_category_selected where category_id = '".$value->id."' or category_id in (select id from service_category where parent_id='".$value->id."')) )")
                                                    
                                                    ->where(['service_category.active'=>1,'service_category.deleted'=>0,'parent_id'=>$value->id])
                                                    ->orderBy('service_category.sort_order','asc')
              ->get(); 
              $key++;
            }
            
        }

        $activity  = ActivityType::where(['deleted' => '0','status' => '1'])->orderBy('sort_order', 'asc')->select('id','name','description','logo','banner_image','indvidual_logo as all_image')
        ->find(6);
        if($activity){
            $o_data['activity'] = convert_all_elements_to_string($activity);
        }
        $o_data['list'] = convert_all_elements_to_string($categorieslist);

        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }
    public function service_categories_health(Request $request)
    {
        $status = "1";
        $message = "";
        $o_data = [];
        $errors = [];
        $validator = Validator::make($request->all(), [
            
        ]);

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => "0",
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }
        $access_token = $request->access_token;
        $user = User::where('user_access_token', $access_token)->first();

        $categories = ServiceCategories::where(['active'=>1,'deleted'=>0,'parent_id'=>0,'activity_id'=>4])->orderBy('sort_order','asc')
        ->get();
        $categorieslist = [];
        $key = 0;
        foreach ($categories as $value) {
            $count = ServiceCategories::join('service_category_selected','service_category_selected.category_id','=','service_category.id')
            ->join('service','service.id','=','service_category_selected.service_id')
            //->join('service_price','service_price.service_id','=','service.id')
            ->whereRaw("service.id in (select service_id from service_category_selected where category_id = '".$value->id."' or category_id in (select id from service_category where parent_id='".$value->id."')) ")
            ->where(['service.deleted'=>0,'service.active'=>1])
            //->where(['service_price.state'=>$request->emirate_id,'service_price.city'=>$request->city_id])
            ->get()->count();
            
            if($count > 0)
            {
              $categorieslist[$key] = new \stdClass;
              $categorieslist[$key]->id = $value->id;
              $categorieslist[$key]->name = $value->name;
              $categorieslist[$key]->image = $value->image;
              $categorieslist[$key]->description = (string) $value->description; 
              $categorieslist[$key]->sub_categories = ServiceCategories::select('service_category.id','service_category.name','service_category.image')
                                                    ->join('service_category_selected','service_category_selected.category_id','=','service_category.id')
                                                    ->join('service','service.id','=','service_category_selected.service_id')
                                                    //->join('service_price','service_price.service_id','=','service.id')
                                                    ->whereRaw("service.id in (select service_id from service_category_selected where category_id = '".$value->id."' or category_id in (select id from service_category where parent_id='".$value->id."')) ")
                                                    ->where(['service.deleted'=>0,'service.active'=>1])
                                                    //->where(['service_price.state'=>$request->emirate_id,'service_price.city'=>$request->city_id])
                                                    ->where(['service_category.active'=>1,'service_category.deleted'=>0,'parent_id'=>$value->id])
                                                    ->distinct('id')
              ->get(); 
              $key++;
            }
            
        }

        $o_data['list'] = convert_all_elements_to_string($categorieslist);
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }
    public function service_categories_transport(Request $request)
    {
        $status = "1";
        $message = "";
        $o_data = [];
        $errors = [];
        $validator = Validator::make($request->all(), [
            
        ]);

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => "0",
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }
        $access_token = $request->access_token;
        $user = User::where('user_access_token', $access_token)->first();

        $categories = ServiceCategories::where(['active'=>1,'deleted'=>0,'parent_id'=>0,'activity_id'=>1])->orderBy('sort_order','asc')
        ->get();
        $categorieslist = [];
        $key = 0;
        foreach ($categories as $value) {
            $count = ServiceCategories::join('service_category_selected','service_category_selected.category_id','=','service_category.id')
            ->join('service','service.id','=','service_category_selected.service_id')
            //->join('service_price','service_price.service_id','=','service.id')
            ->whereRaw("service.id in (select service_id from service_category_selected where category_id = '".$value->id."' or category_id in (select id from service_category where parent_id='".$value->id."')) ")
            ->where(['service.deleted'=>0,'service.active'=>1])
            //->where(['service_price.state'=>$request->emirate_id,'service_price.city'=>$request->city_id])
            ->get()->count();
            
            if($count > 0)
            {
              $categorieslist[$key] = new \stdClass;
              $categorieslist[$key]->id = $value->id;
              $categorieslist[$key]->name = $value->name;
              $categorieslist[$key]->image = $value->image;
              $categorieslist[$key]->description = (string) $value->description; 
              $categorieslist[$key]->sub_categories = ServiceCategories::select('service_category.id','service_category.name','service_category.image')
                                                    ->join('service_category_selected','service_category_selected.category_id','=','service_category.id')
                                                    ->join('service','service.id','=','service_category_selected.service_id')
                                                    //->join('service_price','service_price.service_id','=','service.id')
                                                    ->whereRaw("service.id in (select service_id from service_category_selected where category_id = '".$value->id."' or category_id in (select id from service_category where parent_id='".$value->id."')) ")
                                                    ->where(['service.deleted'=>0,'service.active'=>1])
                                                    //->where(['service_price.state'=>$request->emirate_id,'service_price.city'=>$request->city_id])
                                                    ->where(['service_category.active'=>1,'service_category.deleted'=>0,'parent_id'=>$value->id])
                                                    ->distinct('id')
              ->get(); 
              $key++;
            }
            
        }

        $o_data['list'] = convert_all_elements_to_string($categorieslist);
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }
    public function service_categories_details(Request $request)
    {
        $status = "1";
        $message = "";
        $o_data = [];
        $errors = [];
        $services_id = [];
        $validator = Validator::make($request->all(), [
            
        ]);

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => "0",
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }
        $access_token = $request->access_token;
        $user = User::where('user_access_token', $access_token)->first();

        $categories = ServiceCategories::where(['active'=>1,'deleted'=>0,'id'=>$request->category_id])->first();
        
        $sub_categories = ServiceCategories::select('id')->where(['active'=>1,'deleted'=>0,'parent_id'=>$request->category_id])->get()->toArray();
        $sub_categories[] = $request->category_id;
        
        if(!empty($categories))
        {
            $o_data = convert_all_elements_to_string($categories->toArray());
        }else{
            $activity = ActivityType::find($request->activity_id);
            $o_data = [
                "id"=>"",
                "name"=>"All",
                "image"=>"",
                "banner_image"=>$activity->banner_image,
                "parent_id"=>"",
                "active"=>"",
                "deleted"=>"",
                "order"=> "",
                "description"=>"",
                "created_at"=>"",
                "updated_at"=>"",
                "activity_id"=>"",
                "sort_order"=> ""
            ];
        }
            $services = Service::select('service.*','service_category_selected.*')->where(['service.active'=>1,'service.deleted'=>0])
        ->join('service_category_selected','service_category_selected.service_id','=','service.id')
        ->join('service_category','service_category.id','=','service_category_selected.category_id')->orderBy('service.sort_order','asc');

        //->join('service_price','service_price.service_id','=','service.id')
        if($request->category_id != ''){
            $services=$services->whereIn('service_category_selected.category_id',$sub_categories);
        }
        if($request->activity_id != ''){
            $services=$services->where('service_category.activity_id',$request->activity_id);
        }
        
        if(!empty($request->search))
        {

        $services =$services->where('service.name', 'ilike', '%'.$request->search.'%');
        }
        //->where(['service_price.state'=>$request->emirate_id,'service_price.city'=>$request->city_id])
        $services = $services->distinct('service_category_selected.service_id','service.sort_order')
        ->get();
        foreach ($services as $key => $value) {
            $services[$key]->regular_price = (string) 0;
            $services[$key]->description = (string) $value->description;
            $where['service_id']   = $value->service_id;
            $services[$key]->rating = number_format(Rating::avg_rating($where), 1, '.', '');
            $services[$key]->rating_count = Rating::where($where)->get()->count();
            $ratingdata = Rating::rating_list($where);
           
            $services[$key]->rating_details = $ratingdata;
            // if(!empty($request->city_id))
            // {
            // $pricecity = ServicePrice::where(['service_id'=>$value->service_id,'city'=>$request->city_id])->get()->first();   
            // }
            // if(!empty($pricecity))
            // {
            //  $services[$key]->service_price  = $pricecity->service_price;
            //  $services[$key]->regular_price  = (string) $pricecity->regular_price??0;
            // }
            $hourly_rate = HourlyRate::select('text','hourly_rate')->where(['service_id'=>$value->service_id])->get();
            $services[$key]->hourly_rate = $hourly_rate;
        }

        $subcategories = ServiceCategories::where(['active'=>1,'deleted'=>0,'parent_id'=>$request->category_id])->get();
        $subcategorieslist = [];
        $key = 0;
        foreach ($subcategories as $value) {
            
            $count = ServiceCategorySelected::select('service_id')
            ->where('service_category_selected.category_id',$value->id)->pluck('service_id')->toArray();

            $count = Service::whereIn('id',$count)->where('service.active',1)->get()->count();
            if($count > 0)
            {
              $subcategorieslist[$key] = new \stdClass;
              $subcategorieslist[$key]->id = $value->id;
              $subcategorieslist[$key]->name = $value->name;
              $subcategorieslist[$key]->image = $value->image;
              $subcategorieslist[$key]->description = (string) $value->description;  
              $key++;
            }
            
          }
          foreach ($services as $key => $value_services) {
            $services_id[] = $value_services->id;
          }

            $o_data['sub_categories'] = convert_all_elements_to_string($subcategorieslist);
            $o_data['service_list'] = convert_all_elements_to_string($services);
            $where = $services_id;
            $ratingdata = Rating::rating_list_by_services($services_id);
            $ratingavg = Rating::avg_rating_wherein($services_id);
            $o_data['avg_rating'] = (string) $ratingavg;
            $o_data['rating'] = convert_all_elements_to_string($ratingdata);
        
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }
    public function service_home(Request $request)
    {
        $status = "1";
        $message = "";
        $o_data = (object)[];
        $errors = [];
        $validator = Validator::make($request->all(), [
           
        ]);

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => "0",
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }
        $access_token = $request->access_token;
        $user = User::where('user_access_token', $access_token)->first();
        
        $service_categories = ServiceCategories::where(['active'=>1,'deleted'=>0,'activity_id'=>6])->orderBy('sort_order','asc')->get();

        
        $all_service_cat = [];
        $services = [];
        foreach ($service_categories as $key_main => $value) {

            $services = Service::select('service.*','service_category_selected.*')->where(['active'=>1,'deleted'=>0])
        ->join('service_category_selected','service_category_selected.service_id','=','service.id')->limit(10)
        ->where('service_category_selected.category_id',$value->id);
        if(!empty($request->search))
        {
        $services =$services->where('service.name', 'ilike', '%'.$request->search.'%');
        }
        $services = $services->distinct('service_category_selected.service_id')
        ->get();

        foreach ($services as $key => $value) {
            $services[$key]->regular_price = (string) 0;
            $services[$key]->description = (string) $value->description;
            $where['service_id']   = $value->service_id;
            $services[$key]->rating = number_format(Rating::avg_rating($where), 1, '.', '');
            $services[$key]->rating_count = Rating::where($where)->get()->count();
            $ratingdata = Rating::rating_list($where);
           
            $services[$key]->rating_details = $ratingdata;
            $hourly_rate = HourlyRate::select('text','hourly_rate')->where(['service_id'=>$value->service_id])->get();
            $services[$key]->hourly_rate = $hourly_rate;
            $service_categories[$key_main]['service_list'] = $services;
        }
        
        

          
        }
        foreach($service_categories as $service_cat)
        {
            if(!empty($service_cat->service_list) && count($service_cat->service_list) > 0)
            {
                $all_service_cat[] = $service_cat;
            }
        }
        
       
         
        $all_service_cat1 = [];
        $all_service_cat2 = [];
        $all_service_cat3 = [];
        $all_service_cat4 = [];
        $all_service_cat5 = [];
        $all_service_cat6 = [];
        $all_service_cat7 = [];
        foreach ($all_service_cat as $key => $value) {
            if($key <= 0)
            {
                $all_service_cat1[] =  $value; 
            }
            if($key > 0 && $key <= 1)
            {
                $all_service_cat2[] =  $value; 
            }
            if($key > 1 && $key <= 2)
            {
                $all_service_cat3[] =  $value; 
            }
            if($key > 2 && $key <= 3)
            {
                $all_service_cat4[] =  $value; 
            }
            if($key > 3 && $key <= 4)
            {
              
                $all_service_cat5[] =  $value; 
            }
            if($key > 4 && $key <= 5)
            {
                $all_service_cat6[] =  $value; 
            }
           

        }


        $categories = ServiceCategories::where(['active'=>1,'deleted'=>0,'activity_id'=>6])->first();
        
        
        if(!empty($categories))
        {
            $o_data = convert_all_elements_to_string($categories->toArray());
            $services = Service::select('service.*','service_category_selected.*')->where(['service.active'=>1,'service.deleted'=>0,'service_category.activity_id'=>6])
        ->join('service_category_selected','service_category_selected.service_id','=','service.id')
        ->leftjoin('service_category','service_category.id','=','service_category_selected.category_id')
        ->orderBy('service.id','asc')->limit(10);
        //->join('service_price','service_price.service_id','=','service.id')
        //->where('service_category_selected.category_id',$request->category_id);
        if(!empty($request->search))
        {

        $services =$services->where('service.name', 'ilike', '%'.$request->search.'%');
        }
        //->where(['service_price.state'=>$request->emirate_id,'service_price.city'=>$request->city_id])
        $services = $services->distinct('service.id')
        ->get();
        foreach ($services as $key => $value) {
            $services[$key]->regular_price = (string) 0;
            $services[$key]->description = (string) $value->description;
            $where['service_id']   = $value->service_id;
            $services[$key]->rating = number_format(Rating::avg_rating($where), 1, '.', '');
            $services[$key]->rating_count = Rating::where($where)->get()->count();
            $ratingdata = Rating::rating_list($where);
           
            $services[$key]->rating_details = $ratingdata;
            // if(!empty($request->city_id))
            // {
            // $pricecity = ServicePrice::where(['service_id'=>$value->service_id,'city'=>$request->city_id])->get()->first();   
            // }
            // if(!empty($pricecity))
            // {
            //  $services[$key]->service_price  = $pricecity->service_price;
            //  $services[$key]->regular_price  = (string) $pricecity->regular_price??0;
            // }
            $hourly_rate = HourlyRate::select('text','hourly_rate')->where(['service_id'=>$value->service_id])->get();
            $services[$key]->hourly_rate = $hourly_rate;
        }

        //most booked
        $services_booked = Service::select('service.*','service.id as service_id','service.id as category_id')
        ->where(['service.active'=>1,'service.deleted'=>0,'service_category.activity_id'=>6])
        ->join('service_category_selected','service_category_selected.service_id','=','service.id')
        ->leftjoin('service_category','service_category.id','=','service_category_selected.category_id')
        ->where('order_count','>',0)->limit(10);
        //->join('service_price','service_price.service_id','=','service.id')
        //->where('service_category_selected.category_id',$request->category_id);
        if(!empty($request->search))
        {

        $services_booked =$services_booked->where('service.name', 'ilike', '%'.$request->search.'%');
        }
        //->where(['service_price.state'=>$request->emirate_id,'service_price.city'=>$request->city_id])
        $services_booked = $services_booked->orderBy('order_count','desc')
        ->get();
        
        foreach ($services_booked as $key => $value) {
            $services_booked[$key]->regular_price = (string) 0;
            $services_booked[$key]->description = (string) $value->description;
            $where['service_id']   = $value->id;
            $services_booked[$key]->rating = number_format(Rating::avg_rating($where), 1, '.', '');
            $services_booked[$key]->rating_count = Rating::where($where)->get()->count();
            $ratingdata = Rating::rating_list($where);
           
            $services_booked[$key]->rating_details = $ratingdata;
            // if(!empty($request->city_id))
            // {
            // $pricecity = ServicePrice::where(['service_id'=>$value->service_id,'city'=>$request->city_id])->get()->first();   
            // }
            // if(!empty($pricecity))
            // {
            //  $services[$key]->service_price  = $pricecity->service_price;
            //  $services[$key]->regular_price  = (string) $pricecity->regular_price??0;
            // }
            $hourly_rate = HourlyRate::select('text','hourly_rate')->where(['service_id'=>$value->id])->get();
            $services_booked[$key]->hourly_rate = $hourly_rate;
        }
        //most booked


        $subcategories = ServiceCategories::where(['active'=>1,'deleted'=>0,'activity_id'=>6])->limit(10)->get();
        $subcategorieslist = [];
        $key = 0;
        foreach ($subcategories as $value) {
            
            $count = ServiceCategorySelected::select('service_id')
            ->where('service_category_selected.category_id',$value->id)->pluck('service_id')->toArray();

            $count = Service::whereIn('id',$count)->where('service.active',1)->orderBy('service.sort_order','asc')->get()->count();
            if($count > 0)
            {
              $subcategorieslist[$key] = new \stdClass;
              $subcategorieslist[$key]->id = $value->id;
              $subcategorieslist[$key]->name = $value->name;
              $subcategorieslist[$key]->image = $value->image;
              $subcategorieslist[$key]->description = (string) $value->description;  
              $key++;
            }
            
          }
        $type = [3,4,1,2];
        $activity = [0,6,7];
        $banner  = BannerModel::where(['active'=>1,'banner_type'=>1])->whereIn('type',$type)->whereIn('activity',$activity)->get();
        foreach ($banner as $key => $val) {
           $banner[$key]->banner_image = url(config('global.upload_path').config('global.banner_image_upload_dir').$val->banner_image); 
        }

        $banner1  = BannerModel::where(['active'=>1,'banner_type'=>2])->whereIn('type',$type)->whereIn('activity',$activity)->limit(10)->get();
        foreach ($banner1 as $key => $val) {
           $banner1[$key]->banner_image = url(config('global.upload_path').config('global.banner_image_upload_dir').$val->banner_image); 
        }

        $banner2  = BannerModel::where(['active'=>1,'banner_type'=>3])->whereIn('type',$type)->whereIn('activity',$activity)->limit(10)->get();
        foreach ($banner2 as $key => $val) {
           $banner2[$key]->banner_image = url(config('global.upload_path').config('global.banner_image_upload_dir').$val->banner_image); 
        }

        $banner3  = BannerModel::where(['active'=>1,'banner_type'=>4])->whereIn('type',$type)->whereIn('activity',$activity)->limit(10)->get();
        foreach ($banner3 as $key => $val) {
           $banner3[$key]->banner_image = url(config('global.upload_path').config('global.banner_image_upload_dir').$val->banner_image); 
        }

        $banner4  = BannerModel::where(['active'=>1,'banner_type'=>5])->whereIn('type',$type)->whereIn('activity',$activity)->limit(10)->get();
        foreach ($banner4 as $key => $val) {
           $banner4[$key]->banner_image = url(config('global.upload_path').config('global.banner_image_upload_dir').$val->banner_image); 
        }

        $banner5  = BannerModel::where(['active'=>1,'banner_type'=>6])->whereIn('type',$type)->whereIn('activity',$activity)->limit(10)->get();
        foreach ($banner5 as $key => $val) {
           $banner5[$key]->banner_image = url(config('global.upload_path').config('global.banner_image_upload_dir').$val->banner_image); 
        }
            
            $o_data['banner'] = convert_all_elements_to_string($banner->toArray());
            $o_data['popular_categories'] = convert_all_elements_to_string($subcategorieslist);
            $o_data['offer_banners'] = convert_all_elements_to_string($banner1->toArray());
            $o_data['most_booked_list'] = convert_all_elements_to_string($services_booked);
            $o_data['single_banner'] = convert_all_elements_to_string($banner2->toArray());
            $o_data['new_service_list'] = convert_all_elements_to_string($services);
            $o_data['service_categories1'] = convert_all_elements_to_string($all_service_cat1);
            $o_data['service_categories2'] = convert_all_elements_to_string($all_service_cat2);
            $o_data['middle_banner1'] = convert_all_elements_to_string($banner3->toArray());
            $o_data['service_categories3'] = convert_all_elements_to_string($all_service_cat3);
            $o_data['service_categories4'] = convert_all_elements_to_string($all_service_cat4);
            $o_data['middle_banner2'] = convert_all_elements_to_string($banner4->toArray());
            $o_data['service_categories5'] = convert_all_elements_to_string($all_service_cat5);
            $o_data['service_categories6'] = convert_all_elements_to_string($all_service_cat6);
            $o_data['middle_banner3'] = convert_all_elements_to_string($banner5->toArray());
            
            
            
        }
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }
    public function offer_list(Request $request)
    {
        $status = "1";
        $message = "";
        $o_data = [];
        $o_data['offer_banners'] = (object)[];
        $errors = [];
        $validator = Validator::make($request->all(), [
           
        ]);

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => "0",
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }
        $access_token = $request->access_token;
        $user = User::where('user_access_token', $access_token)->first();
        
        $service_categories = ServiceCategories::where(['active'=>1,'deleted'=>0])->get();

        $page = $request->page ?? 0;
        if (isset($page))
            $page = ($page==0) ? 0 : $page-1;

        $limit = $request->limit ?? 10;
        $offset = $page * $limit;

        $all_service_cat = [];
        foreach ($service_categories as $key_main => $value) {

            $services = Service::select('service.*','service_category_selected.*')->where(['active'=>1,'deleted'=>0])
        ->join('service_category_selected','service_category_selected.service_id','=','service.id')->limit(10)
        ->where('service_category_selected.category_id',$value->id);
        if(!empty($request->search))
        {
        $services =$services->where('service.name', 'ilike', '%'.$request->search.'%');
        }
        $services = $services->distinct('service_category_selected.service_id')
        ->get();

        foreach ($services as $key => $value) {
            $services[$key]->regular_price = (string) 0;
            $services[$key]->description = (string) $value->description;
            $where['service_id']   = $value->service_id;
            $services[$key]->rating = number_format(Rating::avg_rating($where), 1, '.', '');
            $services[$key]->rating_count = Rating::where($where)->get()->count();
            $ratingdata = Rating::rating_list($where);
           
            $services[$key]->rating_details = $ratingdata;
            $hourly_rate = HourlyRate::select('text','hourly_rate')->where(['service_id'=>$value->service_id])->get();
            $services[$key]->hourly_rate = $hourly_rate;
            $service_categories[$key_main]['service_list'] = $services;
        }
        
        if(!empty($services) && count($services) > 0)
        {
            $all_service_cat = $service_categories;
        }
        $all_service_cat1 = [];
        $all_service_cat2 = [];
        $all_service_cat3 = [];
        $all_service_cat4 = [];
        $all_service_cat5 = [];
        $all_service_cat6 = [];
        $all_service_cat7 = [];
        foreach ($all_service_cat as $key => $value) {
            if($key <= 0)
            {
                $all_service_cat1[] =  $value; 
            }
            if($key > 0 && $key <= 1)
            {
                $all_service_cat2[] =  $value; 
            }
            if($key > 1 && $key <= 2)
            {
                $all_service_cat3[] =  $value; 
            }
            if($key > 2 && $key <= 3)
            {
                $all_service_cat4[] =  $value; 
            }
            if($key > 3 && $key <= 4)
            {
                $all_service_cat5[] =  $value; 
            }
            if($key > 4 && $key <= 5)
            {
                $all_service_cat6[] =  $value; 
            }
           

        }

          
        }


        $categories = ServiceCategories::where(['active'=>1,'deleted'=>0])->first();
        
        
        if(!empty($categories))
        {
          
            $services = Service::select('service.*','service_category_selected.*')->where(['active'=>1,'deleted'=>0])
        ->join('service_category_selected','service_category_selected.service_id','=','service.id')->limit(10);
        //->join('service_price','service_price.service_id','=','service.id')
        //->where('service_category_selected.category_id',$request->category_id);
        if(!empty($request->search))
        {

        $services =$services->where('service.name', 'ilike', '%'.$request->search.'%');
        }
        //->where(['service_price.state'=>$request->emirate_id,'service_price.city'=>$request->city_id])
        $services = $services->distinct('service_category_selected.service_id')
        ->get();
        foreach ($services as $key => $value) {
            $services[$key]->regular_price = (string) 0;
            $services[$key]->description = (string) $value->description;
            $where['service_id']   = $value->service_id;
            $services[$key]->rating = number_format(Rating::avg_rating($where), 1, '.', '');
            $services[$key]->rating_count = Rating::where($where)->get()->count();
            $ratingdata = Rating::rating_list($where);
           
            $services[$key]->rating_details = $ratingdata;
            // if(!empty($request->city_id))
            // {
            // $pricecity = ServicePrice::where(['service_id'=>$value->service_id,'city'=>$request->city_id])->get()->first();   
            // }
            // if(!empty($pricecity))
            // {
            //  $services[$key]->service_price  = $pricecity->service_price;
            //  $services[$key]->regular_price  = (string) $pricecity->regular_price??0;
            // }
            $hourly_rate = HourlyRate::select('text','hourly_rate')->where(['service_id'=>$value->service_id])->get();
            $services[$key]->hourly_rate = $hourly_rate;
        }

        $subcategories = ServiceCategories::where(['active'=>1,'deleted'=>0])->limit(10)->get();
        $subcategorieslist = [];
        $key = 0;
       
        $type = [3,4,1,2];
        $activity = [0,6,7];
       

        $banner1  = BannerModel::where(['active'=>1,'banner_type'=>2])->whereIn('type',$type)->whereIn('activity',$activity)->skip($offset)
        ->take($limit)->get();
        foreach ($banner1 as $key => $val) {
           $banner1[$key]->banner_image = url(config('global.upload_path').config('global.banner_image_upload_dir').$val->banner_image); 
        }

        
            
        
            $o_data['offer_banners'] = convert_all_elements_to_string($banner1->toArray());
           
            
            
            
        }
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }
    public function new_service_list(Request $request)
    {
        $status = "1";
        $message = "";
        $o_data = [];
        $errors = [];
        $validator = Validator::make($request->all(), [
           
        ]);

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => "0",
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }
        $language = strtolower($request->language ?? 'en');

        $page = $request->page ?? 0;
        if (isset($page))
            $page = ($page==0) ? 0 : $page-1;

        $limit = $request->limit ?? 10;
        $offset = $page * $limit;
        
        $access_token = $request->access_token;
        $user = User::where('user_access_token', $access_token)->first();
        
        $service_categories = ServiceCategories::where(['active'=>1,'deleted'=>0])->get();
        $categories = ServiceType::where(['deleted' => 0])->get(); // Or your model name
         foreach ($categories as $cat) {
            $cat->name = ($language == 'ar' && !empty($cat->name_ar)) ? $cat->name_ar : $cat->name;
        }
        
        $cities = Cities::where(['deleted' => 0, 'active' => 1])->get();
        foreach ($cities as $city) {
            $city->name = ($language == 'ar' && !empty($city->name_ar)) ? $city->name_ar : $city->name;
        }

        
        $all_service_cat = [];
        $services = [];
       


       // $categories = ServiceCategories::where(['active'=>1,'deleted'=>0])->first();
        
        
        if(!empty($categories))
        {
           
            $services = Service::where(['service.active' => 1, 'service.deleted' => 0])
        ->whereDate('service.to_date', '>=', now()->toDateString())
        ->with('features');

    // Filters
    if (!empty($request->search)) {
        $services = $services->where('service.name', 'ilike', '%' . $request->search . '%');
    }

    if (!empty($request->city_id)) {
        $services = $services->where('service.city_id', $request->city_id);
    }

    if (!empty($request->category_id)) {
        $services = $services->where('service.service_price_type', $request->category_id);
    }

    // Sorting
    $userLatitude = $request->input('latitude');
    $userLongitude = $request->input('longitude');
    $sortBy = $request->input('SortBy');

    if (($sortBy === 'nearest' || $sortBy === 'farthest') && !empty($userLatitude) && !empty($userLongitude)) {
        $distanceSelect = DB::raw("(
            6371 * acos(
                cos(radians($userLatitude)) *
                cos(radians(CAST(service.latitude AS double precision))) *
                cos(radians(CAST(service.longitude AS double precision)) - radians($userLongitude)) +
                sin(radians($userLatitude)) *
                sin(radians(CAST(service.latitude AS double precision)))
            )
        ) AS distance");

        $services = $services->select('service.*', $distanceSelect)
            ->orderBy('distance', $sortBy === 'nearest' ? 'asc' : 'desc');
    } elseif ($sortBy === 'price-ascending') {
        $services = $services->orderBy('service_price', 'asc');
    } elseif ($sortBy === 'price-descending') {
        $services = $services->orderBy('service_price', 'desc');
    } else {
        $services = $services->orderBy('service.id', 'desc');
    }

    $services = $services->with('city')->skip($offset)->take($limit)->get();
    $final_services = [];
        foreach ($services as $key => $value) {
             $services[$key]->name = ($language == 'ar' && !empty($value->name_ar)) ? $value->name_ar : $value->name;
             $services[$key]->term_and_condition = ($language == 'ar' && !empty($value->term_and_condition_ar)) ? $value->term_and_condition_ar : $value->term_and_condition;
            $services[$key]->regular_price = (string) 0;
            $services[$key]->description = (string) $value->description;
            $where['service_id']   = $value->service_id;
            $services[$key]->rating = number_format(Rating::avg_rating($where), 1, '.', '');
            $services[$key]->rating_count = Rating::where($where)->get()->count();
             $services[$key]->city_name = ($value->city)?$value->city->name:'';
            $ratingdata = Rating::rating_list($where);
           
            $services[$key]->rating_details = $ratingdata;
            // if(!empty($request->city_id))
            // {
            // $pricecity = ServicePrice::where(['service_id'=>$value->service_id,'city'=>$request->city_id])->get()->first();   
            // }
            // if(!empty($pricecity))
            // {
            //  $services[$key]->service_price  = $pricecity->service_price;
            //  $services[$key]->regular_price  = (string) $pricecity->regular_price??0;
            // }
            $hourly_rate = HourlyRate::select('text','hourly_rate')->where(['service_id'=>$value->service_id])->get();
            $translatedFeatures = [];

            $features = is_array($value->features) || $value->features instanceof \Illuminate\Support\Collection
            ? $value->features
            : collect();

            foreach ($features as $feature) {
                if (is_array($feature)) {
                    $feature = (object) $feature;
                }
               //print_r($feature);die("here");
                if (!is_null($feature)) {
                    $translatedFeatures[] = [
                        'id' => $feature->id ?? 0,
                        'name' => ($language == 'ar' && !empty($feature->name_ar ?? null)) ? $feature->name_ar : ($feature->name ?? ''),
                        'description' => ($language == 'ar' && !empty($feature->description_ar ?? null)) ? $feature->description_ar : ($feature->description ?? ''),
                        'image_path' => $feature->image_path ?? '',
                        'created_at' => $feature->created_at ?? '',
                        'updated_at' => $feature->updated_at ?? '',
                        'pivot' => [
                            'service_id' => $feature->pivot->service_id ?? null,
                            'event_feature_id' => $feature->pivot->event_feature_id ?? null,
                            'feature_title' => ($language == 'ar' && !empty($feature->pivot->feature_title_ar ?? null))
                                ? $feature->pivot->feature_title_ar
                                : ($feature->pivot->feature_title ?? null),
                            'created_at' => $feature->pivot->created_at ?? null,
                        ],
                    ];

                }
            }

            // $value->features = $translatedFeatures;
             $serviceArray = $value->toArray();
            $serviceArray['features'] = convert_all_elements_to_string($translatedFeatures);
            $final_services[] = $serviceArray;



         // $final_services[] = $value->toArray();

        }

      
            
            
            $o_data['new_service_list'] = convert_all_elements_to_string($final_services);
            $o_data['categories'] = convert_all_elements_to_string($categories);
            $o_data['cities'] = convert_all_elements_to_string($cities);
          
            
        }
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }
    public function most_booked_service(Request $request)
    {
        $status = "1";
        $message = "";
        $o_data = [];
        $errors = [];
        $validator = Validator::make($request->all(), [
           
        ]);

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => "0",
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }
        $access_token = $request->access_token;
        $language = strtolower($request->language ?? 'en');
        $user = User::where('user_access_token', $access_token)->first();
        
      
       //most booked
       $services_booked = Service::select('service.*','service.id as service_id','service.id as category_id')
       ->join('service_category_selected','service_category_selected.service_id','=','service.id')
       ->leftjoin('service_category','service_category.id','=','service_category_selected.category_id')
       ->where(['service.active'=>1,'service.deleted'=>0,'service_category.activity_id'=>6])
       ->where('order_count','>',0)->limit(100);
       //->join('service_price','service_price.service_id','=','service.id')
       //->where('service_category_selected.category_id',$request->category_id);
       if(!empty($request->search))
       {

       $services_booked =$services_booked->where('service.name', 'ilike', '%'.$request->search.'%');
       }
       //->where(['service_price.state'=>$request->emirate_id,'service_price.city'=>$request->city_id])
       $services_booked = $services_booked->orderBy('order_count','desc')
       ->get();
       foreach ($services_booked as $key => $value) {
           $services_booked[$key]->regular_price = (string) 0;
           $services_booked[$key]->description = (string) $value->description;
           $where['service_id']   = $value->id;
           $services_booked[$key]->rating = number_format(Rating::avg_rating($where), 1, '.', '');
           $services_booked[$key]->rating_count = Rating::where($where)->get()->count();
           $ratingdata = Rating::rating_list($where);
          
           $services_booked[$key]->rating_details = $ratingdata;
           // if(!empty($request->city_id))
           // {
           // $pricecity = ServicePrice::where(['service_id'=>$value->service_id,'city'=>$request->city_id])->get()->first();   
           // }
           // if(!empty($pricecity))
           // {
           //  $services[$key]->service_price  = $pricecity->service_price;
           //  $services[$key]->regular_price  = (string) $pricecity->regular_price??0;
           // }
           $hourly_rate = HourlyRate::select('text','hourly_rate')->where(['service_id'=>$value->id])->get();
           $services_booked[$key]->hourly_rate = $hourly_rate;
            $translatedFeatures = [];
            foreach ($service->features as $feature) {
                if (!is_null($feature)) {
                    $translatedFeatures[] = [
                        'id' => $feature->id,
                        'name' => ($language === 'ar' && !empty($feature->name_ar)) ? $feature->name_ar : $feature->name,
                        'description' => ($language === 'ar' && !empty($feature->description_ar)) ? $feature->description_ar : $feature->description,
                        'image_path' => $feature->image_path,
                        'created_at' => $feature->created_at,
                        'updated_at' => $feature->updated_at,
                        'pivot' => [
                            'service_id' => $feature->pivot->service_id,
                            'event_feature_id' => $feature->pivot->event_feature_id,
                            'feature_title' => ($language === 'ar' && !empty($feature->pivot->feature_title_ar))
                                ? $feature->pivot->feature_title_ar
                                : $feature->pivot->feature_title,
                            'created_at' => $feature->pivot->created_at,
                        ]
                    ];
                }
            }
            $serviceArray = $service->toArray();
            $serviceArray['features'] = convert_all_elements_to_string($translatedFeatures);
            $serviceArray['hourly_rate'] = convert_all_elements_to_string($hourly_rate);
            $serviceArray['rating_details'] = convert_all_elements_to_string($service->rating_details);
            $final_services[] = convert_all_elements_to_string($serviceArray);
       }
       //most booked
       

       
       
            
            
            $o_data['most_booked_list'] = convert_all_elements_to_string($services_booked);
           
            
            
            
        
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }
    public function service_sub_categories(Request $request)
    {
        $status = "1";
        $message = "";
        $o_data = [];
        $errors = [];
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => "0",
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }
        $access_token = $request->access_token;
        $user = User::where('user_access_token', $access_token)->first();

        $categories = ServiceCategories::where(['active'=>1,'deleted'=>0,'parent_id'=>$request->category_id])->get();
        
        $categorieslist = [];
        $key = 0;
        foreach ($categories as $value) {
            $count = ServiceCategories::join('service_category_selected','service_category_selected.category_id','=','service_category.id')
            ->join('service','service.id','=','service_category_selected.service_id')
            //->join('service_price','service_price.service_id','=','service.id')
            ->where('service.active',1)
            ->whereRaw("service.id in (select service_id from service_category_selected where category_id = '".$value->id."' or category_id in (select id from service_category where parent_id='".$value->id."')) ")
            //->where(['service_price.state'=>$request->emirate_id,'service_price.city'=>$request->city_id])
            ->get()->count();
            
            if($count > 0)
            {
              $categorieslist[$key] = new \stdClass;
              $categorieslist[$key]->id = $value->id;
              $categorieslist[$key]->name = $value->name;
              $categorieslist[$key]->image = $value->image;
              $categorieslist[$key]->description = (string) $value->description;  
              $key++;
            }
            
        }

        $o_data['list'] = convert_all_elements_to_string($categorieslist);
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }
    public function servicelist(Request $request)
    {
        
        $status = "1";
        $message = "";
        $o_data = [];
        $errors = [];
        $services_id = [];
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => "0",
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }
        $access_token = $request->access_token;
        $user = User::where('user_access_token', $access_token)->first();

        $services = Service::select('service.*','service_category_selected.*')->where(['active'=>1,'deleted'=>0])
        ->join('service_category_selected','service_category_selected.service_id','=','service.id')->orderBy('sort_order','asc')
        //->join('service_price','service_price.service_id','=','service.id')
        ->where('service_category_selected.category_id',$request->category_id);
        if(!empty($request->search))
        {

        $services =$services->where('service.name', 'ilike', '%'.$request->search.'%');
        }
        //->where(['service_price.state'=>$request->emirate_id,'service_price.city'=>$request->city_id])
        $services = $services->distinct('service_category_selected.service_id','sort_order')
        ->get();
        foreach ($services as $key => $value) {
            $services[$key]->regular_price = (string) 0;
            $services[$key]->description = (string) $value->description;
            $where['service_id']   = $value->service_id;
            $services[$key]->rating = number_format(Rating::avg_rating($where), 1, '.', '');
            $services[$key]->rating_count = Rating::where($where)->get()->count();
            $ratingdata = Rating::rating_list($where);
           
            $services[$key]->rating_details = $ratingdata;
            // if(!empty($request->city_id))
            // {
            // $pricecity = ServicePrice::where(['service_id'=>$value->service_id,'city'=>$request->city_id])->get()->first();   
            // }
            // if(!empty($pricecity))
            // {
            //  $services[$key]->service_price  = $pricecity->service_price;
            //  $services[$key]->regular_price  = (string) $pricecity->regular_price??0;
            // }
            $hourly_rate = HourlyRate::select('text','hourly_rate')->where(['service_id'=>$value->service_id])->get();
            if(!empty($hourly_rate) && count($hourly_rate) > 0)
            {
                // Create the new data array
                   $dataArray = [
                  'text' => 'basic price',
                  'hourly_rate' => $value->service_price
                 ];


                  $hourly_rate->prepend($dataArray);
            }
            $services[$key]->hourly_rate = $hourly_rate;
            $services_id[] = $value->service_id;
        }
        $categories = ServiceCategories::where(['active'=>1,'deleted'=>0,'id'=>$request->category_id])->first();
        $o_data  = convert_all_elements_to_string($categories->toarray());
        $o_data['list'] = convert_all_elements_to_string($services);
        $where = $services_id;
            $ratingdata = Rating::rating_list_by_services($services_id);
            $ratingavg = Rating::avg_rating_wherein($services_id);
            $o_data['avg_rating'] = (string) $ratingavg;
            $o_data['rating'] = convert_all_elements_to_string($ratingdata);
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }

    public function servicesearch(Request $request)
    {
        
        $status = "1";
        $message = "";
        $o_data = [];
        $errors = [];
        $services_id = [];
        $validator = Validator::make($request->all(), [
            'activity_type_id' => 'required',
            'search_key'=>'required'
        ]);

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => "0",
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }
        $access_token = $request->access_token;
        $user = User::where('user_access_token', $access_token)->first();

        $activity_type_id = $request->activity_type_id;
        $search_key = $request->search_key;
        $page =$request->page??1;
        $limit=$request->limit??10;
        $offset = ($page - 1) * $limit;

        $services = Service::select('service.*')->where(['service.active'=>1,'service.deleted'=>0])
        ->join('service_category_selected','service_category_selected.service_id','=','service.id')
        ->join('service_category','service_category.id','=','service_category_selected.category_id')
        ->join('vendor_services','vendor_services.service_id','=','service.id')
        ->where('service_category.activity_id',$request->activity_type_id);
        if(!empty($request->search_key))
        {

            $services =$services->where('service.name', 'ilike', '%'.$request->search_key.'%');
        }
        //->where(['service_price.state'=>$request->emirate_id,'service_price.city'=>$request->city_id])
        $services = $services->distinct('service_category_selected.service_id')->take($limit)->skip($offset)
        ->get();
        if($services->count() > 0){
            $o_data['list'] = convert_all_elements_to_string($services->toArray());
            $status = "1";
            $message = "data listed";
        }else{
            $status = "0";
            $message = "no data to list";
        }
        
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => (object)$o_data], 200);
    }

    public function serviceDetails(Request $request)
    {
        $status = "1";
        $message = "";
        $o_data = [];
        $errors = [];
        $validator = Validator::make($request->all(), [
            'service_id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => "0",
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }
        $access_token = $request->access_token;
        $language = strtolower($request->language ?? 'en');
        $user = User::where('user_access_token', $access_token)->first();

        $services = Service::where(['active'=>1,'deleted'=>0,'service.id'=>$request->service_id])->with('features','vendor.vendordata','vendor.rattings','vendor.stores','city')->first();
        
        if($services)
        {
            $services->description = (string) $services->description;
            $services->name = ($language == 'ar' && !empty($services->name_ar)) ? $services->name_ar : $services->name;
             $services->term_and_condition = ($language == 'ar' && !empty($services->term_and_condition_ar)) ? $services->term_and_condition_ar : $services->term_and_condition;
             
            if ($language === 'ar') {
                if (isset($services->vendor->vendordata[0]) && isset($services->vendor->stores[0])) {
                    $vendorData = $services->vendor->vendordata[0];
                    $storeData = $services->vendor->stores[0];
                    
                    $services->vendor->vendordata[0]->company_name = !empty($storeData->store_name_ar) ? $storeData->store_name_ar : $storeData->store_name;

                    $services->vendor->stores[0]->store_name = !empty($storeData->store_name_ar) ? $storeData->store_name_ar : $storeData->store_name;
                    $services->vendor->stores[0]->description = !empty($storeData->description_ar) ? $storeData->description_ar : $storeData->description;
                     
                }
            }
           


            $where['service_id']   = $services->id;

            $services->rating = number_format(Rating::avg_rating($where), 1, '.', '');
            

            $where['title']   = 'Quality';
            $services->quality_rating = number_format(Rating::avg_rating($where), 1, '.', '');

            $where['title']   = 'Delivery';

            $services->delivery_rating = number_format(Rating::avg_rating($where), 1, '.', '');

            $where['title']   = 'Overl All';

            $services->overall_rating = number_format(Rating::avg_rating($where), 1, '.', '');
            $services->city_name = ($services->city)?$services->city->name:'';
           
            $services->rating_count = Rating::where($where)->get()->count();
            
            $ratingdata = Rating::rating_list($where);
            
            $translatedFeatures = [];
            foreach ($services->features as $feature) {
                if (!is_null($feature)) {
                    $translatedFeatures[] = [
                        'id' => $feature->id,
                        'name' => ($language == 'ar' && !empty($feature->name_ar)) ? $feature->name_ar : $feature->name,
                        'description' => ($language == 'ar' && !empty($feature->description_ar)) ? $feature->description_ar : $feature->description,
                        'image_path' => $feature->image_path,
                        'created_at' => $feature->created_at,
                        'updated_at' => $feature->updated_at,
                        'pivot' => [
                            'service_id' => $feature->pivot->service_id,
                            'event_feature_id' => $feature->pivot->event_feature_id,
                            'feature_title' => ($language == 'ar' && !empty($feature->pivot->feature_title_ar))
                                ? $feature->pivot->feature_title_ar
                                : $feature->pivot->feature_title,
                            'created_at' => $feature->pivot->created_at,
                        ]
                    ];
                }
            }
           $services  = convert_all_elements_to_string($services->toArray());
            $services['features'] = convert_all_elements_to_string($translatedFeatures);
            
            $services['other_Services']=[];
             if(isset($services['vendor']['vendordata'])){
                
                $services['other_Services'] = Service::where(['active'=>1,'deleted'=>0,'vendor_id'=>$services['vendor']['id']])->with('features','vendor.vendordata','vendor.rattings')->take('5')->get();
                $services['vendor']['vendordata']['rating']      = number_format(\App\Models\Rating::avg_rating(['vendor_id'=>$services['vendor']['id']]), 1, '.', '');
                $services['vendor']['vendordata']['rating_count']  = \App\Models\Rating::where('vendor_id',$services['vendor']['id'])->get()->count() ?? 0;
                
            }
          
            $services['rating_details'] = convert_all_elements_to_string($ratingdata);
           
            $hourly_rate = HourlyRate::select('text','hourly_rate')->where(['service_id'=>$services['id']])->get();
            
            if(!empty($hourly_rate) && count($hourly_rate) > 0)
            {
                // Create the new data array
                   $dataArray = [
                  'text' => $services['price_label']??'basic price',
                  'hourly_rate' => $services['service_price']
                 ];


                  $hourly_rate->prepend($dataArray);
            }

           
            $services['hourly_rate'] = convert_all_elements_to_string($hourly_rate);
            $o_data = $services;
        }
         
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }
    public function featured_service_details(Request $request)
    {

        $status = "1";
        $message = "";
        $errors = [];
        $product = [];
        $o_data = [];
        $stores = [];
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|numeric|min:0|not_in:0',
        ]);

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => "0",
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }

        $access_token = $request->access_token;
        $user = User::where('user_access_token', $access_token)->first();
        $service_id = $request->service_id;

        $limit = isset($request->limit) ? $request->limit : 10;
        $offset = isset($request->page) ? ($request->page - 1) * $request->limit : 0;



        $featuredservice = Service::where(['active' => 1, 'deleted' => 0, 'service.id' => $service_id])
            ->join('service_category_selected', 'service_category_selected.service_id', '=', 'service.id')
            ->first();


        if ($featuredservice) {
            if (!empty($request->city_id)) {
                $pricecity = ServicePrice::where(['service_id' => $featuredservice->service_id, 'city' => $request->city_id])->get()->first();
            }
            if (!empty($pricecity)) {
                $featuredservice->service_price  = $pricecity->service_price;
            }

            $featured_services  = Service::where(['active' => 1, 'deleted' => 0])
                ->join('service_price', 'service_price.service_id', '=', 'service.id')
                ->where(['service_price.state' => $request->emirate_id, 'service_price.city' => $request->city_id])
                ->limit($limit)->skip($offset)->get();
            foreach ($featured_services as $key => $value) {
                if (!empty($request->city_id)) {
                    $pricecity = ServicePrice::where(['service_id' => $value->id, 'city' => $request->city_id])->get()->first();
                }
                if (!empty($pricecity)) {
                    $featured_services[$key]->service_price  = $pricecity->service_price;
                }
            }




            $status = "1";
            $o_data['service_details']        = $featuredservice;
            $o_data['featured_services']      = $featured_services;
        } else {
            $status = "0";
            $product = [];
            $message = "No Service found.";
        }


        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }


    public function bookedOrders(Request $request){

        $status = "0";
        $message = "";
        $o_data = [];
        $errors = (object) [];
        $redirectUrl = '';
        $validator = Validator::make($request->all(), [
            // 'user_id' => 'required|integer',
             
          //   'workshop_id' => 'nullable',
             //'price' => 'nullable|numeric',
         ]);

         $access_token = $request->access_token;
         $user = User::where('user_access_token', $access_token)->first();
         $user_id=$user->id;

         if ($validator->fails()) {
             return response()->json([
                 'status' => (string) 0,
                 'message' => 'User Session Expired',
                 'errors' => $errors,
                 'oData' => $o_data,
             ], 200);
         }
         else{

            if(!empty($user_id))
                {
                    $page = $request->page ?? 0;
        if (isset($page))
            $page = ($page==0) ? 0 : $page-1;
                    $limit = $request->limit ?? 10;
        $offset = $page * $limit;

                    $booking_orders = ServiceBooking::where('user_id',$user_id)
                    ->with('service')
                    ->where('status',1)
                    ->skip($offset)
                    ->take($limit)
                    ->orderBy('id','desc')->get();
                    if($booking_orders->count()<1){
                        $booking_orders=[];
                    }
              $o_data['booking_orders']=$booking_orders;
            $o_data = convert_all_elements_to_string($o_data);
            $status='1';
            $message="All seats";
            return response()->json([
                'status' => (string) $status,
                'message' => $message,
                'errors' => $errors,
                'oData' => $o_data,
            ], 200);

                    
                }

         }
        }


        public function orderDetail(Request $request){

            $status = "0";
            $message = "";
            $o_data = [];
            $errors = (object) [];
            $redirectUrl = '';
            $validator = Validator::make($request->all(), [
                // 'user_id' => 'required|integer',
                 
                'order_id' => 'required',
                 //'price' => 'nullable|numeric',
             ]);
    
             $access_token = $request->access_token;
             $user = User::where('user_access_token', $access_token)->first();
             $user_id=$user->id;
    
             if ($validator->fails()) {
                 return response()->json([
                     'status' => (string) 0,
                     'message' => 'User Session Expired',
                     'errors' => $errors,
                     'oData' => $o_data,
                 ], 200);
             }
             else{
    
                if(!empty($user_id))
                    {
    
                        $booking_orders = ServiceBooking::where('id',$request->order_id)
                        ->with('service')
                        ->where('status',1)
                        ->first();
    
                  $o_data['booking_order']=$booking_orders;
                  $o_data['booking_order']->service->is_ratted = Rating::where('service_id',$booking_orders->service_id)->where('user_id',$user_id)->count() ? '1' : '0';
                  $o_data['booking_order']->service->is_store_rated= Rating::where('vendor_id',$booking_orders->vendor_id)->where('user_id',$user_id)->count() ? '1' : '0';
                  
                $o_data = convert_all_elements_to_string($o_data);
                $status='1';
                $message="Order Details";
                return response()->json([
                    'status' => (string) $status,
                    'message' => $message,
                    'errors' => $errors,
                    'oData' => $o_data,
                ], 200);
    
                        
                    }
    
             }
            }
    
    public function bookedSeats(Request $request){

        $status = "0";
        $message = "";
        $o_data = [];
        $errors = (object) [];
        $redirectUrl = '';
        $validator = Validator::make($request->all(), [
            // 'user_id' => 'required|integer',
             
             'workshop_id' => 'nullable',
             //'price' => 'nullable|numeric',
         ]);

         if ($validator->fails()) {
            $status = (string) 0;
            $message = trans('validation.validation_error_occured');
            $errors = $validator->messages();
        } else {
            $o_data['booked_seats']=[];
            $check_booking = ServiceBooking::where('service_id',$request->workshop_id)
            ->where('status',1)
            ->pluck('seat_no')->toArray();
            if(!empty($check_booking)){
                foreach($check_booking as $key=>$value){
                    $seats = explode(",", $value); 
                    foreach($seats as $seat){
                        $o_data['booked_seats'][] =$seat;
                    } 
                }
            }
            $service = Service::find($request->workshop_id);
            $seats=$service->seats;
            $o_data['all_seats']=[];
            for($i=1; $i<= $seats; $i++){
                $current_seat=(string)$i;
                $o_data['all_seats'][]=$current_seat;
            }
            
            $o_data = convert_all_elements_to_string($o_data);
            $status='1';
            $message="All seats";
            return response()->json([
                'status' => (string) $status,
                'message' => $message,
                'errors' => $errors,
                'oData' => $o_data,
            ], 200);

        }
    }

    
    public function createBooking(Request $request)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = (object) [];
        $redirectUrl = '';
        $validator = Validator::make($request->all(), [
            // 'user_id' => 'required|integer',
             
             'workshop_id' => 'required',
             //'price' => 'nullable|numeric',
             'seat_number' => 'required',
         ]);
        if ($validator->fails()) {
            $status = (string) 0;
            $message = trans('validation.validation_error_occured');
            $errors = $validator->messages();
        } else {

            $access_token = $request->access_token;
            $user = User::where('user_access_token', $access_token)->first();
            $user_id=$user->id;

            if ($validator->fails()) {
                return response()->json([
                    'status' => (string) 0,
                    'message' => 'User Session Expired',
                    'errors' => $errors,
                    'oData' => $o_data,
                ], 200);
            }

            $input = $request->all();

            
            
                   
                // $check_vehicle = Vehicle::find($request->vehicle_id);
                // if($check_vehicle)
                // {
                    $check_booking='';
                    $seats = explode(",", $request->seat_number);
                    $number_of_seats=count($seats);
                if(!empty($request->workshop_id))
                {

                    $check_booking = ServiceBooking::where('service_id',$request->workshop_id)
                    ->where('seat_no',$request->seat_number)->where('status',1)
                    ->first();
                }
                
               
                if(!empty($check_booking))
                {
                    $status = (string) 0;
                    $message = 'Seat already booked';
                    $errors = $validator->messages();
                    $o_data = (object)[];
                }
                else
                {
               
                $services = Service::find($request->workshop_id);
               
                $settings = SettingsModel::first();
                $cart_total=$services->service_price;
                $cart_total=$number_of_seats*$cart_total;
                
                $tax_percentage = 0;
                $service_charge = $settings->service_charge;
                $service_charge=$number_of_seats*$service_charge;
            if (isset($settings->tax_percentage)) {
            $tax_percentage = $settings->tax_percentage;
            }
            $tax_amount = ($cart_total * $tax_percentage) / 100;

            $tax_amount=$number_of_seats*$tax_amount;
            
            $grand_total = ($cart_total  + $tax_amount + $service_charge);
           // $grand_total=$number_of_seats*$grand_total;
       
                $ins = [
                    'service_id' => $request->workshop_id,
                    'user_id'=>$user_id,
                    'vendor_id' => $services->vendor_id,
                    'seat_no' => $request->seat_number,
                    'status'=>'pending',
                    'payment_type' => '1',
                    'price'=>$cart_total,
                    'service_charge'=>$service_charge,
                    'Workshop_price'=>$services->service_price,
                    'tax' => $tax_amount,
                    'grand_total' => $grand_total,
                    'ref_id' =>$request->workshop_id,
                    'number_of_seats'=>$number_of_seats,
                    'order_number'=>uniqid(),
                ];

                    $datains = ServiceBooking::create($ins);
                    
                    $datains->save();
                    $payment_response = $this->WalletStripePayment($grand_total, $user);
                    
                    $status  = "1";
                    $o_data['invoice_id'] =  $datains->id;
                    $o_data['payment_ref'] = $payment_response->client_secret;
                    $wallet_amount_used = 0;

                    

                    $o_data['amount'] = $grand_total;
                    
                    $status = "1";
                    $message = 'Booking Successfull';
                    
                // }
                // if()
                // {
                //     $status = "0";
                //     $message = "Vehicle not found";
                // }
            
            }
        }
        return response()->json([
            'status' => (string) $status,
            'message' => $message,
            'errors' => $errors,
            'oData' => $o_data,
        ], 200);
    }

    public function calclateBooking(Request $request)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = (object) [];
        $redirectUrl = '';
        $validator = Validator::make($request->all(), [
            // 'user_id' => 'required|integer',
             
             'workshop_id' => 'required',
             //'price' => 'nullable|numeric',
             'seat_number' => 'required',
         ]);
        if ($validator->fails()) {
            $status = (string) 0;
            $message = trans('validation.validation_error_occured');
            $errors = $validator->messages();
        } else {

            $access_token = $request->access_token;
            $user = User::where('user_access_token', $access_token)->first();
            $user_id=$user->id;

            if ($validator->fails()) {
                return response()->json([
                    'status' => (string) 0,
                    'message' => 'User Session Expired',
                    'errors' => $errors,
                    'oData' => $o_data,
                ], 200);
            }else
                {
                $seats = explode(",", $request->seat_number);
                $number_of_seats=count($seats);
                $services = Service::find($request->workshop_id);
               
                $settings = SettingsModel::first();
                $cart_total=$services->service_price;
                $cart_total=$number_of_seats*$cart_total;
                
                $tax_percentage = 0;
                $service_charge = $settings->service_charge;
                $service_charge=$number_of_seats*$service_charge;
            if (isset($settings->tax_percentage)) {
            $tax_percentage = $settings->tax_percentage;
            }
            $tax_amount = ($cart_total * $tax_percentage) / 100;

            $tax_amount=$number_of_seats*$tax_amount;
            
            $grand_total = ($cart_total  + $tax_amount + $service_charge);
           // $grand_total=$number_of_seats*$grand_total;

                    $o_data['single_service_price'] =$services->service_price;   
                    $o_data['sub_total'] =(string)$cart_total;
                    $o_data['tax_amount'] = (string) $tax_amount;
                    $o_data['grand_total'] =(string) $grand_total;
                    $o_data['service_charge'] = (string)$service_charge;  
                                 
                    $status = "1";
                    $message = 'Booking Successfull';
                    
                // }
                // if()
                // {
                //     $status = "0";
                //     $message = "Vehicle not found";
                // }
            
            }
        }
        return response()->json([
            'status' => (string) $status,
            'message' => $message,
            'errors' => $errors,
            'oData' => $o_data,
        ], 200);
    }

    public function WalletStripePayment( $balance, $user )
    {
        try {
            
           // $balance = CurrencyConverter2("AED", 'AED', $balance);
            
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $checkout_session = \Stripe\PaymentIntent::create([
                'amount' => ceil($balance) * 100,
                'currency' => 'AED',
                'description' => 'Wallet Recharge payment',
                'shipping' => [
                    'name' => $user->name,
                    'address' => [
                        'line1' => 'Dubai',
                        'postal_code' => 12345,
                        'city' => 'Dubai',
                        'state' => 'Dubai',
                        'country' => 'United Arab Emirates',
                    ],
                ]
            ]);
            return($checkout_session);
        } catch (\Exception $e) {
            return("fail");
        }
    }

    public function paymentSuccess(Request $request)
    {
        $status = (string) 0;
        $message = "";
        $o_data = [];
        $errors = [];
        $validator = Validator::make($request->all(), [
            'invoice_id' => 'required',
        ]);

        if ($validator->fails()) {
            $status = (string) 0;
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            $access_token = $request->access_token;
            $user = User::where('user_access_token', $access_token)->first();
            $user_id=$user->id;

            if ($validator->fails()) {
                return response()->json([
                    'status' => (string) 0,
                    'message' => 'User Session Expired',
                    'errors' => $errors,
                    'oData' => $o_data,
                ], 200);
            }
      
            $datamain =   ServiceBooking::find($request->invoice_id);

            $store = Stores::where('vendor_id', $datamain->vendor_id)->first();

            $adminSharePercent = $store->admin_share ?? 5;
            $vendorSharePercent = $store->vendor_share ?? 95;

            $adminShareAmount = ($datamain->grand_total * $adminSharePercent) / 100;
            $vendorShareAmount = ($datamain->grand_total * $vendorSharePercent) / 100;
            $datamain->status = 1;
            $datamain->admin_share = round($adminShareAmount, 2);
            $datamain->vendor_share = round($vendorShareAmount, 2);
            $datamain->save();
            $booking = $datamain;
            $workshop = Service::with('vendor')->find($datamain->service_id);
            $mailbody = view('mail.workshop_invoice', compact('user', 'booking', 'workshop'))->render();
            send_email($user->email, 'Your Workshop Booking Invoice ' . config('app.name'), $mailbody);
         
           // Artisan::call('send:send_booking_receive_email', ['booking_id' => $datamain->id]);
          //  Artisan::call('send:send_booking_email', ['booking_id' => $datamain->id]);
            
          \Artisan::call("order:send_service_order_received ".$datamain->id ); 
            //save to tracking history

        }

        $status = "1";
        $message = "Order created successfully!";
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data]);
    }

}