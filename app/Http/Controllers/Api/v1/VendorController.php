<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorDetailsModel;
use App\Models\User;
use App\Models\ProductModel;
use App\Models\ProductMasterModel;
use App\Models\FeaturedProductsImg;
use App\Models\Categories;
use App\Models\ProductLikes;
use App\Models\VendorLocation;
use App\Models\Rating;
use App\Models\Likes;
use App\Models\VendorLikes;
use App\Models\VendorModel;
use App\Models\RatingReply;
use App\Models\VendorFollower;
use App\Models\Stores;
use App\Models\Cities;
use DB;
use Validator;
use App\Models\ReportedShop;
use App\Models\ReportReason;
use App\Models\VendorMessage;

class VendorController extends Controller
{
    function list(Request $request) {
        $status = 1;
        $message = "";
        $o_data = [];
        $errors = [];
        $validator = Validator::make($request->all(), [
            // 'latitude' => 'required',
            // 'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => 0,
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }

        $access_token = $request->access_token;
        $limit = isset($request->limit) ? $request->limit : 10;
        $offset = isset($request->page) ? ($request->page - 1) * $request->limit : 0;

        $where = [];
        $filter['search_text'] = $request->search_text;
       // $filter['lat'] = $request->latitude;
       // $filter['long'] = $request->longitude;
        $filter['distance'] = $request->distance;
        $filter['master_product_id'] = $request->master_product_id;
        if($request->category_id){
            $filter['category_id'] = $request->category_id;
        }
        if($request->activity_id){
            $filter['activity_id'] = $request->activity_id;
        }
        if($request->ignore_id){
            $filter['ignore_id'] = $request->ignore_id;
        }
        $stores = VendorDetailsModel::get_stores($where, $filter, $limit, $offset)->get();
        
        $user = User::where('user_access_token', $access_token)->first();
        foreach ($stores as $key => $val) {
            $stores[$key]->logo = asset($val->logo);
            if(!empty($val->cover_image))
            {
                   $stores[$key]->cover_image = asset($val->cover_image);
            }
            else
            {
                $stores[$key]->cover_image = asset("storage/placeholder.png");
            }

            $store_timing = check_store_open($request,$val->id,'1');

            $stores[$key]->open_time = $store_timing['open_time'] ?? '';
            $stores[$key]->close_time = $store_timing['close_time'] ?? '';
            $stores[$key]->store_is_open = $store_timing['open'] ?? '0';
            $stores[$key]->available_from = $store_timing['open_time']."-".$store_timing['close_time'];
            if($store_timing['is_open_24'] == "1"){
                $stores[$key]->available_from = "24 hours";
            }

            $stores[$key]->is_liked = 0;
            // $stores[$key]->rating = number_format(0, 1, '.', '');
            // $stores[$key]->rating_count = 0;
            if ($user) {
                $is_liked = Likes::where(['vendor_id' => $val->id, 'user_id' => $user->id])->count();
                if ($is_liked) {
                    $stores[$key]->is_liked = 1;
                }
            }
            $stores[$key]->rating = number_format(Rating::avg_rating(['vendor_id'=>$val->id]), 1, '.', '');
            $stores[$key]->rating_count = Rating::where('vendor_id',$val->id)->get()->count();
            unset($stores[$key]->cover_image);
            unset($stores[$key]->latitude);
            unset($stores[$key]->longitude);
            //unset($stores[$key]->location);

            $vendor = VendorModel::find($val->id);
            $stores[$key]->is_dinein =  (string)($vendor->is_dinein ?? '0');
            $stores[$key]->is_delivery =  (string)($vendor->is_delivery ?? '0');

        }
          $filter = [];
          $where = [];
          $limit = isset($request->limit) ? $request->limit : 10;
          $offset = isset($request->page) ? ($request->page - 1) * $request->limit : 0;
          $filter['search_text'] = $request->search_text;
          $filter['lat'] = $request->latitude;
          $filter['long'] = $request->longitude;
          $filter['distance'] = $request->distance;
          $stores2 = VendorDetailsModel::get_stores_for_featured($where, $filter, $limit, $offset)->get();

        //   foreach ($stores2 as $key => $val) {
        //     $stores2[$key]->logo = asset($val->logo);
        //     $stores2[$key]->cover_image = asset($val->cover_image);
        //     $stores2[$key]->is_liked = 0;
        //     $where['vendor_id']   = $val->id;
        //     $stores2[$key]->rating = number_format(Rating::avg_rating($where), 1, '.', '');
        //     if ($user) {
        //         $is_liked = Likes::where(['vendor_id' => $val->id, 'user_id' => $user->id])->count();
        //         if ($is_liked) {
        //             $stores2[$key]->is_liked = 1;
        //         }
            
        //     }

        // }

        $o_data['list'] = convert_all_elements_to_string($stores);
        // $o_data['product_stores'] = $stores2;
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }
    
   
    public function details(Request $request)
    {
        
        $status = 1;
        $message = "";
        $o_data = [];
        $errors = [];
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required',
        ]);
        $language = strtolower($request->language ?? 'en');
        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => 0,
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }
        $access_token = $request->access_token;

        $where['user_id'] = $request->vendor_id;
        
        
        $language = strtolower($request->language ?? 'en');

        $details = VendorDetailsModel::with('activity','city')->select('user_id as id','city','company_name','location','cover_image','logo','description','open_time','close_time','latitude','longitude','location')->where($where)->first();
        $city=Cities::find($details->city);
        $user = User::where('user_access_token', $access_token)->first();
        $details->city_name=($language == 'ar')? $city->name_ar:$city->name;
        if(empty( $details)){
            $message = "Vendor Details not found";
            return response()->json([
               
                'status' => '0',
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }
        if ($details) {
            
            $company_user=User::find($details->id);
            
             $storeDetails = Stores::where('vendor_id', $details->id)->first();
            $details->logo =  $storeDetails->logo;
            $details->email=($company_user)?$company_user->email:'';
            $details->dob=$storeDetails->dob;
            //$details->description=$storeDetails->description;
            $details->description_ar=$storeDetails->description_ar;
             $details->is_liked = 0;
            if ($user) {
                $is_liked = VendorLikes::where(['vendor_id' => $details->id, 'user_id' => $user->id])->count();
                if ($is_liked) {
                    $details->is_liked = 1;
                }
                 

            }
            if ($language == 'ar') {
                // Localize company name
                if (!empty($details->company_name)) {
                    $details->company_name = $storeDetails->store_name_ar;
                }

                // Localize store fields
                if (!empty($storeDetails->store_name_ar)) {
                    $details->store_name = $storeDetails->store_name_ar;
                }
                if (!empty($storeDetails->description_ar)) {
                    $details->description = $storeDetails->description_ar;
                }
               
            }else{
                if (!empty($details->company_name)) {
                    $details->company_name = $storeDetails->store_name;
                }

                // Localize store fields
                if (!empty($storeDetails->store_name)) {
                    $details->store_name = $storeDetails->store_name;
                }
                if (!empty($storeDetails->description)) {
                    $details->description = $storeDetails->description;
                }
                if (!empty($storeDetails->description)) {
                    $details->about = $storeDetails->description;
                }

            }


           
            
            $details->is_followed = 0;
            $where1['vendor_id']   = $details->id;
            $details->rating      = number_format(Rating::avg_rating($where1), 1, '.', '');
            $details->rating_count = Rating::where($where1)->get()->count() ?? 0;
            if ($user) {
                $is_liked = Likes::where(['vendor_id' => $details->id, 'user_id' => $user->id])->count();
                if ($is_liked) {
                    $details->is_followed = 1;
                }
                 

            }
            $store_timing = check_store_open($request,$details->id,'1');
            $details->open_time = $store_timing['open_time'] ?? '';
            $details->close_time = $store_timing['close_time'] ?? '';
            $details->store_is_open = $store_timing['open'] ?? '0';
            
            $details->location  = (string) $storeDetails->tax_city;
            $details->available_from  = $details->open_time." - ".$details->close_time;
            if($store_timing['is_open_24'] == "1"){
                $details->available_from  = "24 hours";
            }
            $details->about           = (string) $details->description;
            $details->description =  $details->description ?? '';
            $details->delivery_type = (string) ($storeDetails->delivery_type ?? '');
            $details->standard_delivery_text = (string) ($storeDetails->standard_delivery_text ?? '');
            $details->delivery_min_days = (string) ($storeDetails->delivery_min_days ?? '');
            $details->delivery_max_days = (string) ($storeDetails->delivery_max_days ?? '');

            $vendor = VendorModel::with('menu_images','vendor_cuisines.cuisine','rattings.user')->find($details->id);

            $details->is_dinein =  (string)($vendor->is_dinein ?? '0');
            $details->is_delivery =  (string)($vendor->is_delivery ?? '0');
            $details->activity_id =  (string)($vendor->activity_id ?? '0');
            $images = [];
            if($vendor && $vendor->menu_images->count()){
                foreach ($vendor->menu_images as $key => $row) {
                    $images[] = asset($row->image);
                }
            }
            $details->vendor_menu_images =  $images;

            $cuisines = [];
            if($vendor && $vendor->vendor_cuisines->count()){
                foreach ($vendor->vendor_cuisines as $key => $row) {
                    if($row->cuisine){
                        $cuisines[] = $row->cuisine->name;
                    }
                }
            }
            $details->vendor_cuisines =  $cuisines;
            $rattings = [];
            
            if($vendor && $vendor->rattings->count()){
                $offset = isset($request->page) ? ($request->page - 1) * $request->limit : 0;
                $vendor_rattings  =  Rating::where($where1)->orderBy('id','desc')->limit(($request->limit ?? 2))->skip(($offset))->get();
                
                foreach ($vendor_rattings as $key => $row) {

                    $reply = RatingReply::where('rating_id',$row->id)->get();
                    foreach ($reply as $key_re => $value_re) {
                        $reply[$key_re]->created_date = get_date_in_timezone($value_re->created_at, 'Y-m-d H:i:s');
                        $vendor_details = VendorModel::find($value_re->user_id);
                        $vendor_data = VendorDetailsModel::where('user_id',$value_re->user_id)->first();
                        $reply[$key_re]->user_image = $vendor_details->user_image??'';
                        $reply[$key_re]->company_name = $vendor_data->company_name??'';
                       }

                    $rattings[] = [
                        'rating' => $row->rating,
                        'name' => $row->title,
                        'comment' => $row->comment,
                        'customer_name' => $row->user ? ($row->user->first_name.' '. $row->user->last_name) : '',
                        'image' => $row->user ? asset($row->user->user_image) : '',
                        'created_at' => date('d M y',strtotime($row->created_at)),
                        'reply' => $reply,
                    ];
                }
            }
            $details->rattings =  $rattings;


            // $details->open_time =  $details->open_time ?? '';
            // $details->close_time =  $details->close_time ?? '';


            
        }

        $condition['product.deleted'] = 0;
        $condition['product.product_status'] = 1;
        $condition['product.product_vender_id'] = $request->vendor_id;

        $categories = Categories::select('category.*')->where('active',1)->join('product_category','product_category.category_id','=','category.id')
        ->join('product','product.id','=','product_category.product_id')
        ->where($condition)
        ->orderBy('category.sort_order', 'asc')
        ->groupBy('category.id')->get();
         foreach ($categories as $key => $cat) {
            if ($cat) {
                $categories[$key]['name'] = $language == 'ar' ? $cat['name_ar'] : $cat['name'];
            }
        }

        

        foreach ($categories as $key => $value) {
           
            $categories[$key]->product_count = Categories::where('category.id',$value->id)->where('active',1)
            ->join('product_category','product_category.category_id','=','category.id')
            ->join('product','product.id','=','product_category.product_id')
            ->where($condition)
            ->get()->count();
            unset($categories[$key]->parent_id);
            unset($categories[$key]->active);
            unset($categories[$key]->deleted);
            unset($categories[$key]->sort_order);
            unset($categories[$key]->created_uid);
            unset($categories[$key]->updated_uid);
            
            unset($categories[$key]->created_at);
            unset($categories[$key]->updated_at);
            unset($categories[$key]->activity_id);
        }
        $details->store_id =  (string)$details->id;

        if($request->location_id){
            $loc_data = VendorLocation::find($request->location_id);
            if($loc_data){
                $details->location=$loc_data->location??'';
            }
        }
        $o_data['store']   = convert_all_elements_to_string($details);
        $categories  = $categories->toArray();
        if($details->is_dinein == '1'){
            $vendor = User::find($details->id);
            $category = Categories::where(DB::raw('lower(name)'),'!=','delivery')->where('active',1)->where('activity_id',$vendor->activity_id)->orderBy('sort_order', 'asc')->first();

            $categ  = [
                "id"=> $category->id,
                "name"=> $category->name,
                "image"=> $category->image,
                "banner_image"=> $category->banner_image,
                "is_dinein"=> '1',
            ];
            $categories[] = $categ;
        }

        
        
        foreach ($categories as $key => $value) {
            $modified_cats[] = $value;
        }
        // $modified_cats = array_merge( $f_categ,$categories);
        // $modified_cats = $categories;
        //$data_sale_price_min = ProductModel::leftjoin('product_selected_attribute_list','product_selected_attribute_list.product_id','=','product.id')
        //->where('product_vender_id',$details->id)->where(['deleted'=>0,'product_status'=>1])->min('sale_price');
        $data_sale_price_min = VendorModel::find($details->id)->minimum_order_amount??0;
        $o_data['min_order_amount'] = (string) $data_sale_price_min;
        $modified_cats=isset($modified_cats)?$modified_cats:[];
        $o_data['categories'] = convert_all_elements_to_string($modified_cats);


        $limit = isset($request->limit) ? $request->limit : 10;
        $offset = isset($request->page) ? ($request->page - 1) * $request->limit : 0;
        $where = [];
        $where['deleted'] = 0;
        $where['product_status'] = 1;

        $filter['search_text'] = $request->search_text;
        $filter['vendor_id']   = $request->vendor_id;
        $filter['new_arrival'] = 1;

        $list = ProductModel::products_list($where, $filter, 100, $offset)->get();
        $products = $this->product_inv($list, $user);
         foreach ($products as $key => $product) {
            $products[$key]['product_name'] = $language == 'ar' ? $product['product_name_arabic'] : $product['product_name'];
            if (isset($product->inventory)) {
                $product->inventory->product_full_descr =
                    $language == 'ar'
                        ? ($product->inventory->product_desc_full_arabic ?? $product->inventory->product_full_descr ?? '')
                        : ($product->inventory->product_full_descr ?? '');
            }

        }
        $filter['featured'] = 0;
        $filter['recommended'] = 1;
        $recommended = ProductModel::products_list($where, $filter, 100, $offset)->get();
        $recommended = $this->product_inv($recommended, $user);
        foreach ($recommended as $key => $product) {
            $recommended[$key]['product_name'] = $language == 'ar' ? $product['product_name_arabic'] : $product['product_name'];
            if (isset($product->inventory)) {
                $product->inventory->product_full_descr =
                    $language == 'ar'
                        ? ($product->inventory->product_desc_full_arabic ?? $product->inventory->product_full_descr ?? '')
                        : ($product->inventory->product_full_descr ?? '');
            }

        }

        
        $o_data['list'] = $products->count() ? convert_all_elements_to_string($products) : [];
        $o_data['recommended_list'] = $recommended->count() ? convert_all_elements_to_string($recommended) : [];
        $all_products = ProductModel::join('product_selected_attribute_list', 'product_selected_attribute_list.product_id', '=', 'product.id')
                ->leftJoin('ratings', 'ratings.product_id', '=', 'product.id')
                ->select(
                    'product.*',
                    'product_selected_attribute_list.*',
                    DB::raw('COALESCE(AVG(ratings.rating), 0) as average_rating'),
                    DB::raw('COUNT(ratings.id) as total_reviews')
                )
                ->where('product.product_vender_id', $details->id)
                ->where('product.product_status', 1)
                ->where('product.deleted', 0)
                ->groupBy('product.id', 'product_selected_attribute_list.product_attribute_id');

            if ($user && $user->role == 2) {
                $all_products->leftJoin('wishlists', function($join) use ($user) {
                    $join->on('wishlists.product_id', '=', 'product.id')
                        ->where('wishlists.user_id', $user->id);
                })
                ->addSelect(DB::raw('CASE WHEN wishlists.id IS NOT NULL THEN 1 ELSE 0 END AS is_liked'))
                ->groupBy('wishlists.id');
            }

            $all_products = $all_products->limit(10)->get();
            $all_products = $this->product_inv($all_products, $user);
            foreach ($all_products as $key => $product) {
                $all_products[$key]['product_name'] = $language == 'ar' ? $product['product_name_arabic'] : $product['product_name'];
                if (isset($product->inventory)) {
                    $product->inventory->product_full_descr =
                        $language == 'ar'
                            ? ($product->inventory->product_desc_full_arabic ?? $product->inventory->product_full_descr ?? '')
                            : ($product->inventory->product_full_descr ?? '');
                }

            }
            $o_data['all_products'] = $all_products->count()
                ? convert_all_elements_to_string($all_products)
                : [];

            $most_selling_products = ProductModel::join('product_selected_attribute_list', 'product_selected_attribute_list.product_id', '=', 'product.id')
            ->join('order_products', 'order_products.product_id', '=', 'product.id')
            ->leftJoin('ratings', 'ratings.product_id', '=', 'product.id')
            ->select(
                'product.*',
                'product_selected_attribute_list.*',
                DB::raw('SUM(order_products.quantity) as total_sold'),
                DB::raw('COALESCE(AVG(ratings.rating), 0) as average_rating'),
                DB::raw('COUNT(ratings.id) as total_reviews')
            )
            ->where('product.product_vender_id', $details->id)
            ->where('product.product_status', 1)
            ->where('product.deleted', 0)
            ->groupBy('product.id', 'product_selected_attribute_list.product_attribute_id')
            ->orderByDesc('total_sold');

        if ($user && $user->role == 2) {
            $most_selling_products->leftJoin('wishlists', function($join) use ($user) {
                $join->on('wishlists.product_id', '=', 'product.id')
                    ->where('wishlists.user_id', $user->id);
            })
            ->addSelect(DB::raw('CASE WHEN wishlists.id IS NOT NULL THEN 1 ELSE 0 END AS is_liked'))
            ->groupBy('wishlists.id');
        }

        $most_selling_products = $most_selling_products->limit(10)->get();
        $most_selling_products = $this->product_inv($most_selling_products, $user);
        foreach ($most_selling_products as $key => $product) {
                $most_selling_products[$key]['product_name'] = $language == 'ar' ? $product['product_name_arabic'] : $product['product_name'];
                if (isset($product->inventory)) {
                    $product->inventory->product_full_descr =
                        $language == 'ar'
                            ? ($product->inventory->product_desc_full_arabic ?? $product->inventory->product_full_descr ?? '')
                            : ($product->inventory->product_full_descr ?? '');
                }

            }
        $o_data['most_selling_products'] = $most_selling_products->count()
            ? convert_all_elements_to_string($most_selling_products)
            : [];
        
        


        $o_data = convert_all_elements_to_string($o_data);
        

        if($request->latitude && $request->category_id){
            $request->id = $vendor->activity_id;
            $request->ignore_id = $details->id;
           try {
                $o_data['nearby_vendors'] = $this->list($request)->original['oData']['list'] ?? [];
           } catch (\Exception $e) {
               
           }
        }

        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }
    // function product_inv($products,$user){
    //     foreach ($products as $key => $val) {
    //         $products[$key]->is_liked = 0;
    //         $where['product_id'] = $val->id;
    //         $products[$key]->avg_rating = number_format(Rating::avg_rating($where), 1, '.', '');
    //         $products[$key]->rating_count = Rating::where($where)->get()->count();
    //         if ($user) {
    //             $is_liked = ProductLikes::where(['product_id' => $val->id, 'user_id' => $user->id])->count();
    //             if ($is_liked) {
    //                 $products[$key]->is_liked = 1;
    //             }
    //         }
    //         $det = [];
    //         if ($val->default_attribute_id) {
    //             $det = DB::table('product_selected_attribute_list')->select('product_attribute_id', 'stock_quantity', 'sale_price', 'regular_price', 'image')->where('product_id', $val->id)->where('product_attribute_id', $val->default_attribute_id)->first();
    //             if ($det) {
    //                 $images = $det->image;
    //                 if ($images) {
    //                     $images = explode(',', $images);
    //                     $images = array_values(array_filter($images));
    //                     $i = 0;
    //                     $prd_img = [];
    //                     foreach ($images as $img) {
    //                         if ($img) {
    //                             $prd_img[$i] = get_uploaded_image_url($img,'product_image_upload_dir');//url(config('global.upload_path') . '/' . config('global.product_image_upload_dir').$img);
    //                             $i++;
    //                         }
    //                     }
    //                     $det->image = $prd_img;
    //                 } else {
    //                     $det->image = [];
    //                 }
    //             }

    //         } else {
    //             $det = DB::table('product_selected_attribute_list')->select('product_attribute_id', 'stock_quantity', 'sale_price', 'regular_price', 'image')->where('product_id', $val->id)->orderBy('product_attribute_id', 'DESC')->limit(1)->first();

    //             if ($det) {
    //                 $images = $det->image;
    //                 if ($images) {
    //                     $images = explode(',', $images);
    //                     $images = array_values(array_filter($images));
    //                     $i = 0;
    //                     $prd_img = [];
                        
    //                     foreach ($images as $img) {
    //                         if ($img) {
    //                             $prd_img[$i] = get_uploaded_image_url($img,'product_image_upload_dir');//url(config('global.upload_path') . '/' . config('global.product_image_upload_dir').$img);
    //                             $i++;
    //                         }
    //                     }
    //                     $det->image = $prd_img;
    //                 } else {
    //                     $det->image = [];
    //                 }
    //             }
    //         }
    //         $products[$key]->inventory = $det;
    //     }
    //     return $products;
    // }
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

    public function followVendor(REQUEST $request)
    {
        $status = (string) 0;
        $message = "";
        $o_data = [];
        $errors = [];

        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'vendor_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $status = (string) 0;
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            $user_id = $this->validateAccesToken($request->access_token);
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
        }
        return response()->json(['status' => $status, 'error' => $errors, 'message' => $message, 'oData' => $o_data], 200);
    }

    public function ReportShop(Request $request){

        $validator = Validator::make($request->all(), [
            'shop_id' => 'required|numeric',
            'reason_id' => 'required|numeric',
            'access_token'=>'required'
           // 'access_token'=>'required'
        ]);

        $status = 1;
        $message = "";
        $o_data = [];
        $errors = [];
       

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => 0,
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }

        if ($validator->fails()) {
            return response()->error('Invalid request', $validator->messages());
        }

        $vendor_id = $request->id;

        //140
        $user_id = $this->validateAccesToken($request->access_token);
      
        $report=new ReportedShop;
        $report->user_id= $user_id;
        $report->shop_id=$request->shop_id;
        $report->reason_id=$request->reason_id;
        $report->description=$request->description;
        $report->save();

        

        $o_data['report'] = convert_all_elements_to_string($report->toArray());
        $message="Thank you for reporting. We take these matters seriously and will investigate accordingly. Your report will 
            be kept confidential and only reviewed by our team.";
        
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);

        
    }

    public function ReportReasons(Request $request){

        $status = 1;
        $message = "";
        $o_data = [];
        $errors = [];
       
        $reasons=ReportReason::get();
        $reasons = convert_all_elements_to_string($reasons->toArray());

        $o_data['reasons'] = $reasons;

        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);   
    }

    public function messageList(Request $request){

        $validator = Validator::make($request->all(), [
            'access_token'=>'required'
        ]);

        $status = 1;
        $message = "";
        $o_data = [];
        $errors = [];
       

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => 0,
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }

        if ($validator->fails()) {
            return response()->error('Invalid request', $validator->messages());
        }
        $user_id = $this->validateAccesToken($request->access_token);
        $reasons=VendorMessage::with('vendor.store')->where('user_id',$user_id)->get();
        $reasons = convert_all_elements_to_string($reasons->toArray());

        $o_data['messages'] = $reasons;

        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);   
    }

    public function vendorMessageList(Request $request){

        $validator = Validator::make($request->all(), [
            'access_token'=>'required'
        ]);

        $status = 1;
        $message = "";
        $o_data = [];
        $errors = [];
       

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => 0,
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }

        if ($validator->fails()) {
            return response()->error('Invalid request', $validator->messages());
        }
        $user_id = $this->validateAccesToken($request->access_token);
        $reasons=VendorMessage::with('vendor.store')->where('vendor_id',$user_id)->get();
        $reasons = convert_all_elements_to_string($reasons->toArray());

        $o_data['messages'] = $reasons;

        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);   
    }
    public function sendMessage(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'subject' => 'required',
            'message' => 'required',
            'vendor_id' => 'required|numeric',
            'access_token'=>'required'
           // 'access_token'=>'required'
        ]);

        $status = 1;
        $message = "";
        $o_data = [];
        $errors = [];
       

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => 0,
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }

        if ($validator->fails()) {
            return response()->error('Invalid request', $validator->messages());
        }

        $vendor_id = $request->vendor_id;

        //140
        $user_id = $this->validateAccesToken($request->access_token);
      
        $vendor_message=new VendorMessage;
        $vendor_message->user_id=$user_id;
        $vendor_message->name= $request->name;
        $vendor_message->email=$request->email;
        $vendor_message->phone=$request->phone;
        $vendor_message->subject=$request->subject;
        $vendor_message->message=$request->message;
        $vendor_message->vendor_id=$request->vendor_id;
        $vendor_message->save();

        

        $o_data['report'] = convert_all_elements_to_string($vendor_message->toArray());
        $message="Message sent Successfully";
        
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);

        
    }

    private function validateAccesToken($access_token)
    {

        $user = User::where(['user_access_token' => $access_token])->get();

        if ($user->count() == 0) {
            http_response_code(401);
            echo json_encode([
                'status' => (string) 0,
                'message' => login_message(),
                'oData' => [],
                'errors' => (object) [],
            ]);
            exit;
        } else {
            $user = $user->first();
            if ($user->active == 1 || $user->role!=2) {
                return $user->id;
            } else {
                http_response_code(401);
                echo json_encode([
                    'status' => (string) 0,
                    'message' => login_message(),
                    'oData' => [],
                    'errors' => (object) [],
                ]);
                exit;
                return response()->json([
                    'status' => (string) 0,
                    'message' => login_message(),
                    'oData' => [],
                    'errors' => (object) [],
                ], 401);
                exit;
            }
        }
    }
}
