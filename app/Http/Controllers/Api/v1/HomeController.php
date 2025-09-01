<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorDetailsModel;
use App\Models\User;
use App\Models\Likes;
use App\Models\BannerModel;
use App\Models\Categories;
use App\Models\VendorFollower;
use App\Models\ProductModel;
use App\Models\Service;
use App\Models\FeaturedProducts;
use App\Models\Rating;
use App\Models\FeaturedProductsImg;
use App\Models\ServiceCategories;
use App\Models\ActivityType;
use App\Models\ServicePrice;
use App\Models\RecentlyViewedProduct;
use App\Models\PromotionBanners;
use Validator,DB;

class HomeController extends Controller
{

    public function get_promotions(REQUEST $request){
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
        $list = PromotionBanners::where(['status'=>1])->orderBy('id','desc')->get();
        if($list->count() > 0){
            $status = "1";
            $message = "data listed";
            $o_data['list'] = convert_all_elements_to_string($list->toArray());
        }else{
            $message = "no data to list";
        }
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => (object)$o_data], 200);
    }
    public function get_home_search(REQUEST $request){
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];

        $validator = Validator::make($request->all(), [
            'search_key'=>'required',
        ],[
            'search_key.required'=>'Search key required'
        ]);

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{
            $search_key = $request->search_key;
            $page = $request->page??1;
            $limit=$request->limit??10;
            $offset = ($page - 1) * $limit;

            // $model1Query = VendorDetailsModel::select(['id', 'company_name as name'])->addSelect(DB::raw("'store' as nav_type"))->addSelect(DB::raw("'own' as store_name"));
            // $model2Query = Service::select(['service.id', 'name','vendor_details.company_name as store_name'])->join('vendor_services','vendor_services.service_id','=','service.id')->join('vendor_details','vendor_details.id','=','vendor_services.vendor_id')->addSelect(DB::raw("'service' as nav_type"));
            // $model3Query = ProductModel::select(['product.id', 'product_name as name','vendor_details.company_name as store_name'])->join('vendor_details','vendor_details.id','=','product.product_vender_id')->addSelect(DB::raw("'product' as nav_type"));
            $category_filter = ServiceCategories::join('service_category_selected','service_category_selected.category_id','=','service_category.id')->select('*')->whereRaw("lower(name) ilike '%".strtolower($search_key)."%' ")->get();
            $filter_sevice_ids = [];
            if($category_filter->count() > 0){
                $category_filter = $category_filter->toArray();
                $filter_sevice_ids = array_column($category_filter,'service_id');
            }
            

            $model1Query = VendorDetailsModel::select(['user_id as id', 'company_name as name'])->addSelect(DB::raw("'own' as store_name"))->addSelect(DB::raw("'store' as nav_type"))->join('users','users.id','=','vendor_details.user_id')->whereNotIn('users.activity_id',[1,6,4]);
            $model2Query = Service::select(['service.id', 'service.name','vendor_details.company_name as store_name'])->addSelect(DB::raw("'service' as nav_type"))->join('vendor_services','vendor_services.service_id','=','service.id')->leftjoin('vendor_details','vendor_details.user_id','=','vendor_services.vendor_id')->where(['service.active'=>1,'service.deleted'=>0])->distinct('service.id');
            $model3Query = ProductModel::select(['product.id', 'product_name as name','vendor_details.company_name as store_name'])->leftJoin('vendor_details','vendor_details.user_id','=','product.product_vender_id')->addSelect(DB::raw("'product' as nav_type"))->where(['product.deleted'=>0,'product.product_status'=>1]);
            
            $main_service_search_result = $model2Query->get()->toArray();
            $selcted_ids = array_column($main_service_search_result,'id');
            $model4Query = Service::select(['service.id', 'service.name','vendor_details.company_name as store_name'])->addSelect(DB::raw("'service' as nav_type"))->join('vendor_services','vendor_services.service_id','=','service.id')->leftjoin('vendor_details','vendor_details.user_id','=','vendor_services.vendor_id')->where(['service.active'=>1,'service.deleted'=>0])->whereIn('service.id',$filter_sevice_ids)->whereNotIn('service.id',$selcted_ids);
            
            if($search_key != ''){
                $model1Query->whereRaw("lower(company_name) ilike '%".strtolower($search_key)."%' ");
            }
            if($search_key != ''){
                $model2Query->whereRaw("lower(name) ilike '%".strtolower($search_key)."%' ");
            }
            if($search_key != ''){
                $model3Query->whereRaw("lower(product_name) ilike '%".strtolower($search_key)."%' ");
            }
            
            
            $unionedQuery = $model1Query->union($model2Query)->union($model3Query)->union($model4Query);
            //echo $unionedQuery->toSql(); 
            $results = DB::table(DB::raw("({$unionedQuery->toSql()}) as combined"))
                        ->mergeBindings($unionedQuery->getQuery())->take($limit)->skip($offset)
                        ->get();
            if($results->count() > 0){
                $result = [];
                foreach($results as $item){
                    $resp = ['id'=>$item->id,'name'=>$item->name,'type'=>$item->nav_type];
                    if($item->nav_type=='product' || $item->nav_type == "service"){
                        $resp['display_name'] = $item->name."- ".$item->store_name;
                    }else{
                        $resp['display_name'] = $item->name;
                    }
                    $result[]= $resp;
                }
                $o_data['list'] = convert_all_elements_to_string($result);
                $status = "1";
                $message = "data fetched successfully";
            }else{
                $message = "no data to list";
            }
            
        }


        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => (object)$o_data], 200);
    }

    function getGiftCatgories(Request $request){

        $status = (string) 1;
        $message = "";
        $o_data = [];
        $errors = [];
        $validator = Validator::make($request->all(), []);
        $language = strtolower($request->language ?? 'en');

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => (string) 0,
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }

        $limit = isset($request->limit) ? $request->limit : 10;
        $offset = isset($request->page) ? ($request->page - 1) * $request->limit : 0;
        $access_token = $request->access_token;
        $user = User::where('user_access_token', $access_token)->first();

        $type = [1,2,4];
        $activity = [0,7,6];

         $banner  = BannerModel::where(['active' => 1,'is_type_gift' => 1,'banner_type' => 1])->whereIn('type',$type)->whereIn('activity',$activity)->get();
         $banner_obj=$banner;
         if($banner_obj->first()){
        foreach ($banner as $key => $val) {
            $banner[$key]->banner_title = $language == 'ar' ? $val->banner_title_ar : $val->banner_title;
            $banner[$key]->banner_image ='https://handwi.com/public/banner_images/'.$val->banner_image;//url(config('global.upload_path') . config('global.banner_image_upload_dir') . $val->banner_image);
            unset($banner[$key]->active);
            unset($banner[$key]->created_by);
            unset($banner[$key]->updated_by);
            unset($banner[$key]->created_at);
            unset($banner[$key]->updated_at);
        }
        if(!empty($banner)){
        $o_data['banner']  = ($banner)?$banner:[];
        }
         }

        $parent_categories = Categories::where(['is_gift'=>1,'deleted'=>0,'active'=>1,'parent_id'=>0]);

        if(request()->activity_id){
            $parent_categories->where('activity_id',request()->activity_id);
        }else{
            $parent_categories->whereIn('activity_id',[7,3]);
        }
        $parent_categories_list =  $parent_categories = $parent_categories->get()->toArray();


        $parent_categories_list = Categories::where(['deleted'=>0,'active'=>1,'is_gift'=>1])->where('parent_id','!=',0);
        if(request()->activity_id){
            $parent_categories_list->where('activity_id',request()->activity_id);
        }
        $parent_categories_list = $parent_categories_list->get()->toArray();
        foreach ($parent_categories as $key => $cat) {
            if ($cat) {
                $parent_categories[$key]['name'] = $language == 'ar' ? $cat['name_ar'] : $cat['name'];
            }
        }

        $o_data['categories_list']  = $parent_categories;
        $limit=5;

        $o_data['gift_page_products']=[];
        $o_data['gift_page_products']['below_products']=[];
        $gift_categories=Categories::with('products','products.selectedAttributes')->where('show_gift_page',1)->where('deleted',0)->get();
        // if(!empty( $gift_categories->first())){
            
        //     $products_new_arrivals = Categories::with('products','products.selectedAttributes')->where('id', $gift_categories->first()->id)->first();
        
        //     $o_data['gift_page_products']['top_products'] = $products_new_arrivals?$products_new_arrivals:[];
        
        // }

        // if(!empty( $gift_categories->first())){

        //     foreach($gift_categories as $gift_category){
        //         if($gift_category->id!=$gift_categories->first()->id){
        //         $products_new_arrivals = Categories::with('products','products.selectedAttributes')->where('id', $gift_category->id)->first();
        //         $o_data['gift_page_products']['below_products'][] = $products_new_arrivals ?$products_new_arrivals : [];
        //         }
        //     }
        // }
        $gift_categories = Categories::with('products', 'products.selectedAttributes')
            ->where('show_gift_page', 1)->where('deleted',0)
            ->get();
            
            $filter=[];
            $filter['tag_ids'] = $request->tag_ids;

       if (!empty($gift_categories->first())) {
    $products_new_arrivals = Categories::with(['products' => function ($query) use ($filter) {
        $query->where('product.deleted', 0)
              ->where('product.product_status', 1)
              ->orderBy('product.created_at', 'desc');

        if (isset($filter['tag_ids']) && $filter['tag_ids'] != '') {
            $tag_ids = explode(',', $filter['tag_ids']);
            $query->whereHas('tags', function ($q) use ($tag_ids) {
                $q->whereIn('tag_id', $tag_ids);
            });
        }

        // Add selectedAttributes if needed
        $query->with('selectedAttributes');
    }])
    ->where('id', $gift_categories->first()->id)
    ->where('deleted', 0)
    ->first();

    // Apply localization
    if ($products_new_arrivals) {
        $products_new_arrivals->name = $language == 'ar' && !empty($products_new_arrivals->name_ar)
            ? $products_new_arrivals->name_ar
            : $products_new_arrivals->name;

        foreach ($products_new_arrivals->products as $product) {
            $product->product_name = $language == 'ar' && !empty($product->product_name_arabic)
                ? $product->product_name_arabic
                : $product->product_name;
                $where['product_id'] = $product->id;
                     $product->avg_rating = number_format(Rating::avg_rating($where), 1, '.', '');
            $product->rating_count = Rating::where($where)->get()->count();
            $product->is_liked=0;
             if ($user) {
                $is_liked = Likes::where(['product_id' => $product->id, 'user_id' => $user->id])->count();
                if ($is_liked) {
                   $product->is_liked = 1;
                }
             }
            
        }

        $o_data['gift_page_products']['top_products'] = $products_new_arrivals;
    }
}


       foreach ($gift_categories as $gift_category) {
           
    if ($gift_category->id != $gift_categories->first()->id) {
        $products_new_arrivals = Categories::with(['products' => function ($query) use ($filter) {
            $query->where('product.deleted', 0)
                  ->where('product.product_status', 1)
                  ->orderBy('product.created_at', 'desc');
       
            if (isset($filter['tag_ids']) && $filter['tag_ids'] != '') {
                $tag_ids = explode(',', $filter['tag_ids']);
                
                $query->whereHas('tags', function ($q) use ($tag_ids) {
                    $q->whereIn('tag_id', $tag_ids);
                });
            }

            // Include selectedAttributes
            $query->with('selectedAttributes');
        }])
        ->where('id', $gift_category->id)
        ->where('deleted', 0)
        ->first();
        

        if ($products_new_arrivals) {
            $products_new_arrivals->name = $language == 'ar' && !empty($products_new_arrivals->name_ar)
                ? $products_new_arrivals->name_ar
                : $products_new_arrivals->name;

            foreach ($products_new_arrivals->products as $product) {
                $product->product_name = $language == 'ar' && !empty($product->product_name_arabic)
                    ? $product->product_name_arabic
                    : $product->product_name;
                     $where['product_id'] = $product->id;
                     $product->avg_rating = number_format(Rating::avg_rating($where), 1, '.', '');
            $product->rating_count = Rating::where($where)->get()->count();
            $product->is_liked=0;
             if ($user) {
                $is_liked = Likes::where(['product_id' => $product->id, 'user_id' => $user->id])->count();
                if ($is_liked) {
                   $product->is_liked = 1;
                }
            }
            }
        }

        $o_data['gift_page_products']['below_products'][] = $products_new_arrivals ?? [];
    }
}


        $o_data=convert_all_elements_to_string($o_data);
       if( empty($banner_obj->first())){
        $o_data['banner']  = [];
        }

        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
  
    }
    public function getAllCategories(Request $request){
        $status = (string) 1;
        $message = "";
        $o_data = [];
        $errors = [];
        $validator = Validator::make($request->all(), []);
         $language = strtolower($request->language ?? 'en');
        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => (string) 0,
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        } 
        
        $parent_categories = Categories::where(['deleted'=>0,'active'=>1,'parent_id'=>0]);

        if(request()->activity_id){
            $parent_categories->where('activity_id',request()->activity_id);
        }else{
            $parent_categories->whereIn('activity_id',[7,3]);
        }
        $parent_categories_list =  $parent_categories = $parent_categories->get()->toArray();
        foreach ($parent_categories as $key => $cat) {
            if ($cat) {
                $parent_categories[$key]['name'] = $language == 'ar' ? $cat['name_ar'] : $cat['name'];
            }
        }


        $parent_categories_list = Categories::where(['deleted'=>0,'active'=>1])->where('parent_id','!=',0);
        if(request()->activity_id){
            $parent_categories_list->where('activity_id',request()->activity_id);
        }
        $parent_categories_list = $parent_categories_list->get()->toArray();
        foreach ($parent_categories_list as $key => $cat) {
            if ($cat) {
                $parent_categories_list[$key]['name'] = $language == 'ar' ? $cat['name_ar'] : $cat['name'];
            }
        }
        $o_data['categories_list']  = $parent_categories;

        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => convert_all_elements_to_string($o_data)], 200);

    }

    function recomendedProducts(Request $request){
        
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
        $language = strtolower($request->language ?? 'en');
        $limit = isset($request->limit) ? $request->limit : 10;
        $offset = isset($request->page) ? ($request->page - 1) * $request->limit : 0;

        $where['deleted'] = 0;
        $where['product_status'] = 1;
        $where['for_you'] = 1;

        $filter['search_text'] = $request->search_text;
        $filter['vendor_id']   = $request->vendor_id;
        $filter['activity_id'] = $request->activity_id;
        $filter['category_id'] = $request->category_id;
        $filter['category_ids'] = $request->category_ids;
        $filter['start_price'] = $request->start_price;
        $filter['end_price'] = $request->end_price;
        $filter['ratting'] = $request->ratting;
        $filter['cuisines_ids'] = $request->cuisines_ids;
        $limit=5;
        

        $for_you_list = ProductModel::products_list($where, $filter, $limit, $offset)->get();
        $products_for_you = $this->product_inv($for_you_list, $user);
        foreach ($products_for_you as $key => $product) {
            $products_for_you[$key]['product_name'] = $language == 'ar' ? $product['product_name_arabic'] : $product['product_name'];
            if (isset($product->inventory)) {
                $product->inventory->product_full_descr =
                    $language == 'ar'
                        ? ($product->inventory->product_desc_full_arabic ?? $product->inventory->product_full_descr ?? '')
                        : ($product->inventory->product_full_descr ?? '');
            }

        }
        $for_you_list =  $products_for_you->count() ? convert_all_elements_to_string( $products_for_you) : [];

       
        $o_data['recomended_products'] = $for_you_list;
         
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => convert_all_elements_to_string($o_data)], 200);
    }
    function exploreProducts(Request $request){
        
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
        $language = strtolower($request->language ?? 'en');
        $limit = isset($request->limit) ? $request->limit : 10;
        $offset = isset($request->page) ? ($request->page - 1) * $request->limit : 0;

        $where['deleted'] = 0;
        $where['product_status'] = 1;
        $where['explore'] = 1;

        $filter['search_text'] = $request->search_text;
        $filter['vendor_id']   = $request->vendor_id;
        $filter['activity_id'] = $request->activity_id;
        $filter['category_id'] = $request->category_id;
        $filter['category_ids'] = $request->category_ids;
        $filter['start_price'] = $request->start_price;
        $filter['end_price'] = $request->end_price;
        $filter['ratting'] = $request->ratting;
        $filter['cuisines_ids'] = $request->cuisines_ids;
        $filter['tag_ids'] = $request->tag_ids;
      //  $limit=5;
        

        $for_you_list = ProductModel::products_list($where, $filter, $limit, $offset)->get();
        $products_for_you = $this->product_inv($for_you_list, $user);
        foreach ($products_for_you as $key => $product) {
            $products_for_you[$key]['product_name'] = $language == 'ar' ? $product['product_name_arabic'] : $product['product_name'];
            if (isset($product->inventory)) {
                $product->inventory->product_full_descr =
                    $language == 'ar'
                        ? ($product->inventory->product_desc_full_arabic ?? $product->inventory->product_full_descr ?? '')
                        : ($product->inventory->product_full_descr ?? '');
            }

        }
        $for_you_list =  $products_for_you->count() ? convert_all_elements_to_string( $products_for_you) : [];

       
        $o_data['explore_products'] = $for_you_list;
         
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => convert_all_elements_to_string($o_data)], 200);
    }

    function index(Request $request)
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
        $language = strtolower($request->language ?? 'en');
        $access_token = $request->access_token;
        $user = User::where('user_access_token', $access_token)->first();
        $limit = isset($request->limit) ? $request->limit : 10;
        $offset = isset($request->page) ? ($request->page - 1) * $request->limit : 0;

        $where = [];
        $params = [];
        $filter['search_text'] = $request->search_text;
        $filter['emirate_id']  = $request->emirate_id;
        $filter['city_id']     = $request->city_id;


        //banner 
        $type = [1,2,4];
        $activity = [0,7,6];
        $banner  = BannerModel::where(['active' => 1,'banner_type' => 1])->whereIn('type',$type)->whereIn('activity',$activity)->get();
        foreach ($banner as $key => $val) {
            $banner[$key]->banner_title = $language == 'ar' ? $val->banner_title_ar : $val->banner_title;
            $banner[$key]->banner_image = url(config('global.upload_path') . config('global.banner_image_upload_dir') . $val->banner_image);
            unset($banner[$key]->active);
            unset($banner[$key]->created_by);
            unset($banner[$key]->updated_by);
            unset($banner[$key]->created_at);
            unset($banner[$key]->updated_at);
        }
        //banner END
        $activities  = ActivityType::where(['deleted' => '0','status' => '1'])->orderBy('sort_order', 'asc')->select('id','name','description','logo')->get();

        // foreach ($activities as $key => $val) {
        //     unset($activities[$key]->activity_type_image);
        //     unset($activities[$key]->capitalized_name);
        // }
        

        //services 
       // DB::enableQueryLog();



       $parent_categories = Categories::where(['deleted'=>0,'active'=>1,'parent_id'=>0,'home_page'=>1]);

        if(request()->activity_id){
            $parent_categories->where('activity_id',request()->activity_id);
        }else{
            $parent_categories->whereIn('activity_id',[7,3]);
        }
        $parent_categories_list =  $parent_categories = $parent_categories->get()->toArray();


        $parent_categories_list = Categories::where(['deleted'=>0,'active'=>1,'home_page'=>1])->where('parent_id','!=',0);
        if(request()->activity_id){
            $parent_categories_list->where('activity_id',request()->activity_id);
        }
        $parent_categories_list = $parent_categories_list->get()->toArray();

        foreach ($parent_categories as $key => $cat) {
            if ($cat)  {
                
             $parent_categories[$key]['name'] = $language == 'ar' ? $cat['name_ar'] : $cat['name'];
            }
        }
        
        


        //services END

        $con = \App\Models\ContactUsSetting::first();

        $o_data['transport_website_link']  = $con->transport_website_link;

        $o_data['mobile']    = $con->mobile;
        $o_data['email']    = $con->email;
        $o_data['twitter']    = $con->twitter;
        $o_data['instagram']    = $con->instagram;
        $o_data['facebook']   = $con->facebook;
        $o_data['youtube']   = $con->youtube;
        $o_data['linkedin']   = $con->linkedin;
        


        $o_data['banner']  = $banner;
       // $o_data['activities']  = $activities;
        $o_data['categories_list']  = $parent_categories;

        $where['deleted'] = 0;
        $where['product_status'] = 1;
        $where['new_arrival'] = 1;

        $filter['search_text'] = $request->search_text;
        $filter['vendor_id']   = $request->vendor_id;
        $filter['activity_id'] = $request->activity_id;
        $filter['category_id'] = $request->category_id;
        $filter['category_ids'] = $request->category_ids;
        $filter['start_price'] = $request->start_price;
        $filter['end_price'] = $request->end_price;
        $filter['ratting'] = $request->ratting;
        $filter['cuisines_ids'] = $request->cuisines_ids;
        $limit=5;

        $new_arrival_list = ProductModel::products_list($where, $filter, $limit, $offset)->get();
        $products_new_arrivals = $this->product_inv($new_arrival_list, $user);
        foreach ($products_new_arrivals as $key => $product) {
            $products_new_arrivals[$key]['product_name'] = $language == 'ar' ? $product['product_name_arabic'] : $product['product_name'];
            if (isset($product->inventory)) {
                $product->inventory->product_full_descr =
                    $language == 'ar'
                        ? ($product->inventory->product_desc_full_arabic ?? $product->inventory->product_full_descr ?? '')
                        : ($product->inventory->product_full_descr ?? '');
            }

        }

        $new_arrival_list = $products_new_arrivals->count() ? convert_all_elements_to_string($products_new_arrivals) : [];
        
        unset($where['new_arrival']);
        $where['for_you'] = 1;

        $for_you_list = ProductModel::products_list($where, $filter, $limit, $offset)->get();
        $products_for_you = $this->product_inv($for_you_list, $user);
        foreach ($products_for_you as $key => $product) {
            $products_for_you[$key]['product_name'] = $language == 'ar' ? $product['product_name_arabic'] : $product['product_name'];
        }
        $for_you_list =  $products_for_you->count() ? convert_all_elements_to_string( $products_for_you) : [];
        
        unset($where['for_you']);
        $where['trending'] = 1;

        $trending_list = ProductModel::products_list($where, $filter, $limit, $offset)->get();
        $products_trending = $this->product_inv($trending_list, $user);
        foreach ($products_trending as $key => $product) {
            $products_trending[$key]['product_name'] = $language == 'ar' ? $product['product_name_arabic'] : $product['product_name'];
        }
        $trending_list =  $products_trending->count() ? convert_all_elements_to_string($products_trending) : [];


        $recently_viewed_list = [];

        if ($user && !empty($access_token)) {
            
            $recent_ids = RecentlyViewedProduct::where('user_id', $user->id)
                ->orderByDesc('updated_at')
                ->limit(10)
                ->pluck('product_id')
                ->toArray();

            if (!empty($recent_ids)) {
                $params = []; 
                $where = [
                    ['product.product_status', '=', 1],
                    ['product.deleted', '=', 0]
                ];

               
                $products = ProductModel::get_products_list($where, $params, 'product.created_at', 'DESC')
                    ->whereIn('product.id', $recent_ids)
                    ->get();

               
                $products_recently_viewed = $this->product_inv($products, $user);
                 foreach ($products_recently_viewed as $key => $product) {
                    $products_recently_viewed[$key]['product_name'] = $language == 'ar' ? $product['product_name_arabic'] : $product['product_name'];
                }
                
                $recently_viewed_list = $products_recently_viewed->count()
                    ? convert_all_elements_to_string($products_recently_viewed)
                    : [];
            }

            // Add to output
            $o_data['recently_viewed'] = $recently_viewed_list;
        }else{
            $o_data['recently_viewed'] = [];
        }
        

        $following_products = [];

        if ($user) {
            $vendorIds = Likes::where('user_id', $user->id)
                ->whereNotNull('vendor_id')
                ->where('vendor_id', '!=', 0)
                ->pluck('vendor_id')
                ->unique()
                ->toArray();
        
            if (!empty($vendorIds)) {
                $params = [];
                $where = [
                    ['product.product_status', '=', 1],
                    ['product.deleted', '=', 0]
                ];
        
                $products = ProductModel::get_products_list($where, $params, 'product.created_at', 'DESC')
                    ->whereIn('product.product_vender_id', $vendorIds) // ✅ Safe and simple
                    ->get();
        
                $products_following = $this->product_inv($products, $user);
                 foreach ($products_following as $key => $product) {
                    $products_following[$key]['product_name'] = $language == 'ar' ? $product['product_name_arabic'] : $product['product_name'];
                    
                }
                $following_products = $products_following->count()
                    ? convert_all_elements_to_string($products_following)
                    : [];
            }
        
            $o_data['following_products'] = $following_products;
        }
        



        $o_data['new_arrivals'] =$new_arrival_list;
        $o_data['for_you'] = $following_products;
         $o_data['trending_now'] =$trending_list;
         $o_data['emirati_heritage'] = $for_you_list;

        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => convert_all_elements_to_string($o_data)], 200);
    }

    public function product_inv($products, $user)
    {
        foreach ($products as $key => $val) {
            $products[$key]->is_liked = 0;
            $where['product_id'] = $val->id;
            $products[$key]->avg_rating = number_format(Rating::avg_rating($where), 1, '.', '');
            $products[$key]->rating_count = Rating::where($where)->get()->count();
            if(request()->test){
                $products[$key]->ratings_list = Rating::where(['product_id'=>$val->id])->get();
            }
            if ($user) {
                $is_liked = Likes::where(['product_id' => $val->id, 'user_id' => $user->id])->count();
                if ($is_liked) {
                    $products[$key]->is_liked = 1;
                }
            }
            $det = [];
            if ($val->default_attribute_id) {
                $det = DB::table('product_selected_attribute_list')->select('product_attribute_id', 'stock_quantity', 'sale_price', 'regular_price', 'image', 'product_full_descr')->where('product_id', $val->id)->where('product_attribute_id', $val->default_attribute_id)->first();
                if ($det) {
                    $images = $det->image;
                    if ($images) {
                        $images = explode(',', $images);
                        $i = 0;
                        $prd_img = [];
                        foreach ($images as $img) {
                            if ($img) {
                                $prd_img[$i] = get_uploaded_image_url($img,'product_image_upload_dir');//url(config('global.upload_path') . '/' . config('global.product_image_upload_dir') . $img);
                                // dd($prd_img[$i],config('global.upload_path') .  config('global.product_image_upload_dir') . $img);
                                $i++;
                            }
                        }
                        $det->image = $prd_img;
                    } else {
                        $det->image = [];
                    }
                }
            } else {
                $det = DB::table('product_selected_attribute_list')->select('product_attribute_id', 'stock_quantity', 'sale_price', 'regular_price', 'image', 'product_full_descr')->where('product_id', $val->id)->orderBy('product_attribute_id', 'DESC')->limit(1)->first();

                if ($det) {
                    $images = $det->image;
                    if ($images) {
                        $images = explode(',', $images);
                        $i = 0;
                        $prd_img = [];

                        foreach ($images as $img) {
                            if ($img) {
                                $prd_img[$i] = get_uploaded_image_url($img,'product_image_upload_dir');//url(config('global.upload_path') . '/' . config('global.product_image_upload_dir') . $img);
                                $i++;
                            }
                        }
                        $det->image = $prd_img;
                    } else {
                        $det->image = [];
                    }
                }
            }
            $products[$key]->inventory = $det;
        }
        return $products;
    }
}