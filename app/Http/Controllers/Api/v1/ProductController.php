<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\ModaSubCategories;
use App\Models\Likes;
use App\Models\ProductModel;
use App\Models\FeaturedProducts;
use App\Models\FeaturedProductsImg;
use App\Models\Stores;
use App\Models\Personalization;
use App\Models\VendorDetailsModel;
use App\Models\User;
use App\Models\Rating;
use App\Models\Categories;
use App\Models\Cuisine;
use App\Models\ProductAttribute;
use App\Models\RecentlyViewedProduct;

use App\Models\Productfeatures;
use DB;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
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
    function product_filters(Request $request)
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
        $limit = isset($request->limit) ? $request->limit : 10;
        $offset = isset($request->page) ? ($request->page - 1) * $request->limit : 0;

        $where['deleted'] = 0;
        $where['product_status'] = 1;

        if($request->vendor_id){
            $where['product_vender_id']   = $request->vendor_id;
        }
        if($request->category_id){
            // $where['category_id'] = $request->category_id;
        }

        $categories = Categories::whereHas('product_categories.product',function($q) use($request){
            $q->when($request->vendor_id,function($qq) use($request){
                $qq->where('product_vender_id',$request->vendor_id);
            });
        })
        ->where(['deleted' => '0','active' => '1'])->orderBy('sort_order', 'asc')->select('id','name','image','banner_image','activity_id');
        if($request->activity_id){
            $categories->where('activity_id',$request->activity_id);
        }
        $categories = $categories->get();


        $Cuisine = Cuisine::whereHas('product_cuisine.product',function($q) use($request){
            $q->when($request->vendor_id,function($qq) use($request){
                $qq->where('product_vender_id',$request->vendor_id);
            });
        })->where(['deleted' => '0','status' => '1'])->orderBy('sort_order', 'asc')->select('id','name');
        $Cuisine = $Cuisine->get();


        $min_products = ProductModel::where($where)->select('product_category.*','product.id', 'product.product_name', 'product.product_type', 'default_attribute_id','master_product','product.featured','product.recommended','product_selected_attribute_list.*')
        ->join("product_selected_attribute_list","product_selected_attribute_list.product_id","=","product.id")
        ->join("product_category","product_category.product_id","=","product.id");
        if($request->category_id){
            $cat_id = explode(',', $request->category_id);
            $min_products->whereIn("product_category.category_id",$cat_id);
            // ->whereIn('product.id',function($query) use ($cat_id){
            //     $query->select('product_id')->from('product_category')->where("category_id","=",$cat_id);
            // });
        }
        if($request->cuisines_ids){
            $cuisine_id = explode(',', $request->cuisines_ids);
            $min_products->whereHas('product_cuisine',function($c_q) use($cuisine_id){
                return $c_q->whereIn("cuisine_id",$cuisine_id);
            });
        }
        $min_price = $min_products->orderBy('sale_price','asc')->first()->sale_price ?? 0;

        $max_products = ProductModel::where($where)->select('product_category.*','product.id', 'product.product_name', 'product.product_type', 'default_attribute_id','master_product','product.featured','product.recommended','product_selected_attribute_list.*')
        ->join("product_selected_attribute_list","product_selected_attribute_list.product_id","=","product.id")
        ->join("product_category","product_category.product_id","=","product.id");

        if($request->category_id){
            $cat_id = explode(',', $request->category_id);
            $max_products->whereIn("product_category.category_id",$cat_id);
            // ->whereIn('product.id',function($query) use ($cat_id){
            //     $query->select('product_id')->from('product_category')->where("category_id","=",$cat_id);
            // });
        }
        if($request->cuisines_ids){
            $cuisine_id = explode(',', $request->cuisines_ids);
            $max_products->whereHas('product_cuisine',function($c_q) use($cuisine_id){
                return $c_q->whereIn("cuisine_id",$cuisine_id);
            });
        }
        $max_price = $max_products->orderBy('sale_price','desc')->first()->sale_price ?? 0;

        $o_data['min_price']    = $min_price;
        $o_data['max_price']    = $max_price;
        $o_data['categories']   = $categories;
        $o_data['Cuisine']      = $Cuisine;


        if(request()->test){
            $ps  = ProductModel::get();
            foreach ($ps as $key => $p) {
                if(Rating::where(['product_id'=>$p->id])->get()->count()){
                    $p_avg = number_format(Rating::avg_rating(['product_id'=>$p->id]), 1, '.', '');
                    if($p){
                        $p->rating_avg = $p_avg;
                        $p->save();
                    }
                }
            }

        }
        
        $o_data = convert_all_elements_to_string($o_data);
        $o_data['categories']   = $categories->count() ? convert_all_elements_to_string($categories) : [];
        $o_data['Cuisine']      = $Cuisine->count() ? convert_all_elements_to_string($Cuisine) : [];
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => ($o_data)], 200);
    }
    function list(Request $request)
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
        $language = strtolower($request->language ?? 'en');
        $limit = isset($request->limit) ? $request->limit : 10;
        $offset = isset($request->page) ? ($request->page - 1) * $request->limit : 0;

        $where['deleted'] = 0;
        $where['product_status'] = 1;
        if($request->vender_id){
        $where['product_vender_id'] = $request->vender_id;
        }

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
        $price_order=$request->price_order;
        $product_name=$request->product_name;
        $top_rated=$request->top_rated;
      //  dd($price_order);
        $list = ProductModel::products_list($where, $filter, $limit, $offset,[],$price_order,$product_name,$top_rated)->get();
        $user = User::where('user_access_token', $access_token)->first();
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
        $o_data['list'] = $products->count() ? convert_all_elements_to_string($products) : [];
        // $o_data = ($o_data);
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
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
    public function product_like_dislike(REQUEST $request)
    {
        $status = (string) 0;
        $message = "";
        $o_data = [];
        $errors = [];

        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'product_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $status = (string) 0;
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            $user_id = $this->validateAccesToken($request->access_token);
            $product_id = $request->product_id;
            $check_exist = ProductLikes::where(['product_id' => $product_id, 'user_id' => $user_id])->get();
            if ($check_exist->count() > 0) {
                ProductLikes::where(['product_id' => $product_id, 'user_id' => $user_id])->delete();
                $status = (string) 1;
                $message = "disliked";
            } else {
                $like = new ProductLikes();
                $like->product_id = $product_id;
                $like->user_id = $user_id;
                $like->created_at = gmdate('Y-m-d H:i:s');
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

    public function details(Request $request)
    {
        $ar = ["1"=>"1","2"=>"4"];
        //echo json_encode($ar);
        $status = (string) 1;
        $message = "";
        $o_data = [];
        $errors = [];
        $product = [];
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric|min:0|not_in:0',
        ]);

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
        $product_id = $request->product_id;
        $prod_features=Productfeatures::where('product_id',$product_id)->pluck('product_feature_id')->toArray();
        $all_features=\App\Models\ProductFeature::whereIn('id', $prod_features)->get();
        $tall_features= $all_features;
        if(empty($tall_features->first())){
            $all_features=[];
        }
        $product_variant_id = $request->product_variant_id;

        $sattr = $request->sattr;
        $sattr = json_decode($request->sattr, true);
        $return_status = true;
        if(isset($request->newattr_ids)){
            $attr_ids = explode(",",$request->newattr_ids);
            $attr_values = explode(",",$request->newattr_values);
            //$attr_values = array_reverse($attr_values);
            $ar = array();
            $myObj = new \stdClass();
            foreach($attr_ids as $k=>$id){
                $myObj->$id=$attr_values[$k];
            }
            $sattr=(array)$myObj;
        }

        if (!$product_variant_id) {
            list($return_status, $product_attribute_id, $message) = ProductModel::get_product_attribute_id_from_attributes($sattr, $product_id);
            $product_variant_id = $product_attribute_id;
        }

        if (!$return_status) {
            $status = (string) 0;
            $message = "Invalid data passed";
            return response()->json([
                'status' => "0",
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }

        list($status, $product, $message) = ProductModel::getProductVariant($product_id, $product_variant_id);

       
        if ($status && !empty($product)) {
            $product = process_product_data_api($product);
            
           
             if(empty($request->access_token)){
                $user_id = null;
            }else{
                $user_id = $user->id;
            }
            // $personalization = Personalization::where('user_id', $user->id)
            //     ->where('product_id', $product['product_id'])
            //     ->first();
            $cookie_id = $request->cookie('user_cookie_id') ?? Str::uuid()->toString();
            $personalization = "";
            // Localize product details based on language
            if ($language === 'ar') {
                $product['product_name'] = $product['product_name_arabic'] ?? $product['product_name'];
                if (!empty($product['attribute_name_arabic'])) {
                    $product['attribute_name'] = $product['attribute_name_arabic'];
                }

                if (!empty($product['attribute_values_arabic'])) {
                    $product['attribute_values'] = $product['attribute_values_arabic'];
                }

                $product['product_desc_short'] = $product['product_desc_short_arabic'] ?? $product['product_desc_short'];
                $product['product_desc'] = $product['product_desc_arabic'] ?? $product['product_desc'];
                $product['shipment_and_policies'] = $product['shipment_and_policies_ar'] ?? $product['shipment_and_policies'];

                if (isset($product['store']['company_name_ar'])) {
                    
                    $product['store']['company_name'] = $product['store']['company_name_ar'];
                }
                if (isset($product['store']['description_ar'])) {
                    
                    $product['store']['description'] = $product['store']['description_ar'];
                    $product['store']['about'] = $product['store']['description_ar'];
                }
            }

        
            $product['personalize_id'] = $personalization ? (string) $personalization->id : "";
            $product['notes'] = $personalization ? (string) $personalization->notes : "";
            $product['uploaded_file_name'] = $personalization ? (string) $personalization->uploaded_file_path : "";
            $product['uploaded_file_url'] = ($personalization && $personalization->uploaded_file_path)
                ? get_uploaded_image_url($personalization->uploaded_file_path, 'product_image_upload_dir')
                : "";
               
            $product['is_liked'] = 0;
            $where['product_id']   = $product['product_id'];
            $product['avg_rating'] = number_format(Rating::avg_rating($where), 1, '.', '');

            $where['title']   = 'Quality';
            $product['quality_rating'] = number_format(Rating::avg_rating($where), 1, '.', '');

            $where['title']   = 'Delivery';

            $product['delivery_rating'] = number_format(Rating::avg_rating($where), 1, '.', '');

            $where['title']   = 'Overl All';

            $product['overall_rating'] = number_format(Rating::avg_rating($where), 1, '.', '');

            $product['rating_count'] = Rating::where($where)->get()->count();
            if ($user) {
                $is_liked = Likes::where(['product_id' => $product['product_id'], 'user_id' => $user->id])->count();
                if ($is_liked) {
                    $product['is_liked'] = 1;
                }
            }


            $product['share_link'] = url("share/product/" . $product_id . "/" . $product['product_variant_id']);

            $product['specifications'] = convert_all_elements_to_string(ProductModel::get_product_specs($product_id));
            if ($language === 'ar') {
                foreach ($product['specifications'] as $spec) {
                    if (!empty($spec->title_ar)) {
                        $spec->spec_title = $spec->title_ar;
                    }
                    if (!empty($spec->description_ar)) {
                        $spec->spec_descp = $spec->description_ar;
                    }
                }
            }
            $product['attribut_variations']=[];
            $product_selected_attributes = ProductModel::getProductVariantAttributes($product['product_variant_id']);

            $product_variations = [];
            $product_attributes = ProductModel::getProductAttributeVals([$product['product_id']]);
            $selectedAttributes=ProductAttribute::where('product_id',$product['product_id'])->get();
            
            
            $attributes=( $selectedAttributes)?$selectedAttributes:[];
            foreach ($product_attributes as $attr_row) {
                if (array_key_exists($attr_row->attribute_id, $product_variations) === false) {
                    $product_variations[$attr_row->attribute_id] = [
                        'product_attribute_id' => $attr_row->product_attribute_id,
                        'attribute_id' => $attr_row->attribute_id,
                        'attribute_id' => $attr_row->attribute_id,
                        'attribute_type' => $attr_row->attribute_type,
                        'attribute_name' =>  ($language === 'ar' && !empty($attr_row->attribute_name_arabic)) ? $attr_row->attribute_name_arabic : $attr_row->attribute_name,
                        'attribute_values' => [],
                    ];
                    if ($attr_row->attribute_type === 'radio_button_group') {
                        $product_variations[$attr_row->attribute_id]['help_text_start'] = $attr_row->attribute_value_label;
                    }
                }
                if ($attr_row->attribute_type === 'radio_button_group') {
                    $product_variations[$attr_row->attribute_id]['help_text_end'] = $attr_row->attribute_value_label;
                }
                
                if (array_key_exists($attr_row->attribute_values_id, $product_variations[$attr_row->attribute_id]['attribute_values']) === false) {
                    $is_selected = 0;
                    if (array_key_exists($attr_row->attribute_id, $product_selected_attributes) && ($product_selected_attributes[$attr_row->attribute_id] == $attr_row->attribute_values_id)) {
                        $is_selected = 1;
                    }
                    $product_variations[$attr_row->attribute_id]['attribute_values'][$attr_row->attribute_values_id] = [
                        'attribute_value_id' => $attr_row->attribute_values_id,
                        'attribute_value_name' => ($language === 'ar' && !empty($attr_row->attribute_values_arabic)) ? $attr_row->attribute_values_arabic : $attr_row->attribute_values,
                        'product_attribute_id' => $attr_row->product_attribute_id,
                        'attribute_name' =>   ($language === 'ar' && !empty($attr_row->attribute_name_arabic)) ? $attr_row->attribute_name_arabic : $attr_row->attribute_name,
                        'is_selected' => $is_selected,
                    ];

                    $product['attribut_variations'][]=[
                        'attribute_value_id' => $attr_row->attribute_values_id,
                        'attribute_value_name' =>  ($language === 'ar' && !empty($attr_row->attribute_values_arabic)) ? $attr_row->attribute_values_arabic : $attr_row->attribute_values,
                        'product_attribute_id' => $attr_row->product_attribute_id,
                        'attribute_name' => ($language === 'ar' && !empty($attr_row->attribute_name_arabic)) ? $attr_row->attribute_name_arabic : $attr_row->attribute_name,
                        'is_selected' => $is_selected,
                    ];
                    //if ($attr_row->attribute_value_in == 2) {
                        $product_variations[$attr_row->attribute_id]['attribute_values'][$attr_row->attribute_values_id]['attribute_value_color'] = $attr_row->attribute_color;
                   // }
                    if ($attr_row->attribute_type === 'radio_image') {
                        $t_image = $attr_row->attribute_value_image;

                        $product_variations[$attr_row->attribute_id]['attribute_values'][$attr_row->attribute_values_id]['attribute_value_image'] = $t_image;
                    }
                }
            }
           if (!empty($product['selected_attribute_list']) && $language === 'ar') {
                foreach ($product['selected_attribute_list'] as $attr_row) {
                    if (!empty($attr_row->attribute_name_arabic)) {
                        $attr_row->attribute_name = $attr_row->attribute_name_arabic;
                    }
                    if (!empty($attr_row->attribute_values_arabic)) {
                        $attr_row->attribute_values = $attr_row->attribute_values_arabic;
                    }
                }
            }


            $product['product_variations'] = [];
            if (!empty($product_variations)) {
                $t_variations = array_values($product_variations);
                foreach ($t_variations as $k => $v) {
                    $t_variations[$k]['attribute_values'] = array_values($t_variations[$k]['attribute_values']);
                }
                $product["product_variations"] = convert_all_elements_to_string($t_variations);
            }

            $variable_products = ProductModel::select('product.id', 'product.product_name','product.product_desc_full_arabic','product.product_name_arabic', 'product.product_type', 'product_selected_attribute_list.product_attribute_id as default_attribute_id', 'product.boxcount')
                ->join('product_selected_attribute_list', 'product_selected_attribute_list.product_id', '=', 'product.id')
                ->where('product.product_status', 1)->where('product.deleted', 0)->where('product_vender_id', $product['product_vendor_id'])->orderBy('created_at', 'desc')
                ->where('product.id', '=', $product_id)
                ->where('product_selected_attribute_list.product_attribute_id', '!=', $product_variant_id)->limit(4)->get();
                
            $pros = $this->product_inv($variable_products, $user);
            foreach ($pros as $key => $pro) {
              $pro->product_name = ($language === 'ar' && !empty($pro->product_name_arabic))
                ? $pro->product_name_arabic
                : $pro->product_name;

                // Update product_full_descr based on language
                if (isset($pro->inventory)) {
                    $pro->inventory->product_full_descr = ($language === 'ar' && !empty($pro->product_desc_full_arabic))
                        ? $pro->product_desc_full_arabic
                        : ($pro->inventory->product_full_descr ?? '');
                }

                // This ensures the changes are reflected in the final array
                $pros[$key] = $pro;

            }
            $product['variants_list'] = count($pros) ? convert_all_elements_to_string($pros) : [];
            

            $shop_products = ProductModel::select('product.id', 'product.product_name','product.product_desc_full_arabic','product.product_name_arabic', 'product.product_type', 'default_attribute_id', 'product.boxcount')->where('product.product_status', 1)->where('product.deleted', 0)->where('product_vender_id', $product['product_vendor_id'])->orderBy('created_at', 'desc')->where('product.id', '!=', $product_id)->limit(4)->get();
            $shop_products = $this->product_inv($shop_products, $user);
            foreach ($shop_products as $key => $pro) {
              $pro->product_name = ($language === 'ar' && !empty($pro->product_name_arabic))
                ? $pro->product_name_arabic
                : $pro->product_name;

                // Update product_full_descr based on language
                if (isset($pro->inventory)) {
                    $pro->inventory->product_full_descr = ($language === 'ar' && !empty($pro->product_desc_full_arabic))
                        ? $pro->product_desc_full_arabic
                        : ($pro->inventory->product_full_descr ?? '');
                }

                // This ensures the changes are reflected in the final array
                $pros[$key] = $pro;

            }
            $product['shop_products'] = $shop_products->count() ? convert_all_elements_to_string($shop_products) : [];
        } else {
            $status = (string) 0;
            $product = [];
            $message = "No details found.";
        }
        $product_features = ProductModel::with('features')->where('id',$product_id)->first();
        
        $product['product_features'] =(isset($product_features->features) && !empty($product_features->features->first()))? convert_all_elements_to_string( $product_features->features):[];
        $o_data['product_details'] = convert_all_elements_to_string($product);
        
       
        $product  = convert_all_elements_to_string($product);
        if ($user ) {
            RecentlyViewedProduct::updateOrCreate(
                ['user_id' => $user->id, 'product_id' => $request->product_id],
                ['updated_at' => now()] // Refresh timestamp
            );
        }
        if(!isset($product['rating_details']) || count( (array)$product['rating_details'])  == 0)
        {
            $product['rating_details'] = [];  
        }
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $product], 200);
    }
    public function featured_product_details(Request $request)
    {

        $status = (string) 1;
        $message = "";
        $errors = [];
        $product = [];
        $o_data = [];
        $stores = [];
        $validator = Validator::make($request->all(), [
            'master_product_id' => 'required|numeric|min:0|not_in:0',
        ]);

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
        $master_product_id = $request->master_product_id;


        // $featuredproduct = FeaturedProducts::select('featured_products.*','product_master.name','featured_products.id as id')
        // ->join('product_master','product_master.id','=','featured_products.master_product')
        // ->join('product','product.master_product','=','featured_products.master_product')
        // ->where(['product.deleted'=>0,'product.product_status'=>1])
        // ->distinct('product_master.id')->first();
        $featuredproduct = FeaturedProducts::select('featured_products.*', 'product_master.name')->where('featured_products.master_product', $master_product_id)
            ->join('product_master', 'product_master.id', '=', 'featured_products.master_product')->first();

        if ($featuredproduct) {

            $img = [];
            $featuredproductimage   = FeaturedProductsImg::select('image')->where('featured_product_id', $featuredproduct->id)->get();
            foreach ($featuredproductimage as $key => $value) {
                $img[] = asset($value->image);
            }

            $product = $featuredproduct;
            $product->image = $img;

            $where = [];
            $limit = isset($request->limit) ? $request->limit : 10;
            $offset = isset($request->page) ? ($request->page - 1) * $request->limit : 0;
            $filter['master_product_id'] = $request->master_product_id;
            $stores = VendorDetailsModel::get_stores_for_featured($where, $filter, $limit, $offset)->get();

            foreach ($stores as $key => $val) {
                $stores[$key]->logo = asset($val->logo);
                $stores[$key]->cover_image = asset($val->cover_image);
                $stores[$key]->is_liked = 0;
                $stores[$key]->rating = 0;
                if ($user) {
                    $is_liked = Likes::where(['vendor_id' => $val->id, 'user_id' => $user->id])->count();
                    if ($is_liked) {
                        $stores[$key]->is_liked = 1;
                    }
                }
            }

            $status = (string) 1;
            $o_data['product_details'] = $product;
            $o_data['pharmacies']      = $stores;
            if (empty($stores)) {
                $o_data['pharmacies']      = [];
            }
        } else {
            $status = (string) 0;
            $product = [];
            $message = "No product found.";
        }


        $o_data = convert_all_elements_to_string($o_data);
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => (object) $o_data], 200);
    }

    public function list_moda_products(Request $request)
    {
        $status = (string) 1;
        $message = "";
        $o_data = [];
        $errors = [];
        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'moda_sub_category' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => (string) 0,
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }

        $user_id = $this->validateAccesToken($request->access_token);
        $user = User::where('id', $user_id)->first();
        $limit = isset($request->limit) ? $request->limit : 10;
        $offset = isset($request->page) ? ($request->page - 1) * $request->limit : 0;

        $where['product.deleted'] = 0;
        $where['product.product_status'] = 1;
        $where['product.moda_sub_category'] = $request->moda_sub_category;
        $where['moda_sub_categories.gender'] = $user->gender;

        $filter['search_text'] = $request->search_text;
        $filter['store_id'] = $request->store_id;
        $filter['sort_by_price'] = $request->sort_by_price;
        $filter['sort_by_newest'] = $request->sort_by_newest;

        $list = ProductModel::moda_products_list($where, $filter, $limit, $offset)->get();

        $products = $this->product_inv($list, $user);
        $moda_sub_category = ModaSubCategories::select('id', 'name')->where('id', $request->moda_sub_category)->first();
        $o_data['moda_sub_category'] = $moda_sub_category;
        $o_data['list'] = $products;

        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
    }
    
    
    public function categoryDetail(Request $request){
        
         $status = (string) 1;
        $message = "";
        $o_data = [];
        $errors = [];
        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'category_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => (string) 0,
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }

        $user_id = $this->validateAccesToken($request->access_token);
        $language = strtolower($request->language ?? 'en');
        $user = User::where('id', $user_id)->first();
        $limit = isset($request->limit) ? $request->limit : 10;
        $offset = isset($request->page) ? ($request->page - 1) * $request->limit : 0;
        $category=Categories::with('products','products.selectedAttributes')->where('id',$request->category_id)->first();
        if ($category) {
            // Update category name
            $category->name = $language === 'ar' && !empty($category->name_ar)
                ? $category->name_ar
                : $category->name;

            // Loop through products and update product_name
            foreach ($category->products as $product) {
                $product->product_name = $language === 'ar' && !empty($product->product_name_arabic)
                    ? $product->product_name_arabic
                    : $product->product_name;
            }
        }
        $o_data['category']=$category;
         return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);    
    }
    
    public function ProductDetail(Request $request){
        
        
         $status = (string) 1;
        $message = "";
        $o_data = [];
        $errors = [];
        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'product_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $message = "Validation error occured";
            $errors = $validator->messages();
            return response()->json([
                'status' => (string) 0,
                'message' => $message,
                'errors' => (object) $errors,
            ], 200);
        }

        $user_id = $this->validateAccesToken($request->access_token);
        $user = User::where('id', $user_id)->first();
        if(empty($user)){
            $user_id = null;
        }
        $limit = isset($request->limit) ? $request->limit : 10;
        $offset = isset($request->page) ? ($request->page - 1) * $request->limit : 0;
        $product=ProductModel::with('selectedAttributes')->where('id',$request->product_id)->first();
        // $video_url = $product->video;
        // $video_thumbnail = $product->thumbnail;

        // $product->video_url = !empty($video_url) ? get_uploaded_image_url($video_url, 'product_image_upload_dir') : '';
        // $product->video_thumbnail = !empty($video_thumbnail) ? get_uploaded_image_url($video_thumbnail, 'product_image_upload_dir') : '';



        // $personalization = Personalization::where('user_id', $user_id)
        // ->where('product_id', $request->product_id)
        // ->first();
        $cookie_id = $request->cookie('user_cookie_id') ?? Str::uuid()->toString();
        $personalization = "";

        // Merge values into the product model
        $product->personalize_id = $personalization ? (string) $personalization->id : "";
        $product->notes = $personalization ? (string) $personalization->notes : "";
        $product->uploaded_file_name = $personalization ? (string) $personalization->uploaded_file_path : "";
        $product->uploaded_file_url = ($personalization && $personalization->uploaded_file_path)
            ? get_uploaded_image_url($personalization->uploaded_file_path, 'product_image_upload_dir')
            : "";
         $o_data['product']=$product;
        if ($user_id ) {
            RecentlyViewedProduct::updateOrCreate(
                ['user_id' => $user_id, 'product_id' => $request->product_id],
                ['updated_at' => now()] // Refresh timestamp
            );
        }
       
         return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);    
    }
}