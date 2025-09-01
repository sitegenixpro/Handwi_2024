<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Kreait\Firebase\Contract\Database;
use Illuminate\Http\Request;
use App\CustomRequestModel;
use App\Models\OrderServiceItemsModel;
use DB;
use Validator;
use App\Models\Common;
use App\Models\OrderProductsModel;
use App\Models\Rating;
use App\Classes\FaceReg;
use App\Models\ProductModel;
use App\Models\Service;
use Illuminate\Support\Facades\App;

class RatingController extends Controller
{
        public $lang = '';
        public function __construct(Database $database, Request $request)
        {
            $this->database = $database;
            if (isset($request->lang)) {
                \App::setLocale($request->lang);
            }
            $this->lang = \App::getLocale();
        }
   
    public function add_rating(REQUEST $request)
    {
            $language = $request->header('language') ?? $request->language ?? 'en';
            
            App::setLocale($language);
            $status  = 0;
            $message = "";
            $o_data  = [];
            $errors  = [];
            $redirectUrl = '';

            $rules['type']   = "required|integer|min:1|max:3";
            $rules['rating'] = "required";
            $rules['order_id'] = "required|integer|min:1";
            //$rules['comment'] = "required";
            $user_id = validateAccesToken($request->access_token);
            $product_vender_id='';
            if($request->type == 1)//product
            { 
                $rules['product_id']         = "required|integer";
                $rules['product_variant_id'] = "required|integer";
                $where['product_id'] = $request->product_id;
                $product=ProductModel::find($request->product_id);
                $product_vender_id=( $product)? $product->product_vender_id:'';
                $where['product_varient_id'] = $request->product_variant_id;
                $ins['product_id']           = $request->product_id;
                $ins['product_varient_id']   = $request->product_variant_id;
                $purchasestatus = OrderProductsModel::join('orders','orders.order_id','=','order_products.order_id')
                ->where(['orders.user_id'=>$user_id,'orders.status'=>4,'product_id'=>$request->product_id,'product_attribute_id'=>$request->product_variant_id,'order_products.order_id'=>$request->order_id])->get()->count();
               
            }
            if($request->type == 2) //vendor
            { 
                $rules['vendor_id']         = "required|integer";
                $where['vendor_id']         = $request->vendor_id;
                $ins['vendor_id']           = $request->vendor_id;
                $purchasestatus = 1;
            }
            if($request->type == 3)//service
            { 
                $rules['service_id']         = "required|integer";
                $where['service_id']         = $request->service_id;
                $product=Service::find($request->service_id);
                $product_vender_id=( $product)? $product->vendor_id:'';
                $ins['service_id']           = $request->service_id;
                $purchasestatus = OrderServiceItemsModel::join('orders_services','orders_services.order_id','=','orders_services_items.order_id')
                ->where(['service_id'=>$request->service_id,'user_id'=>$user_id,'orders_services_items.order_status'=>4,'orders_services_items.order_id'=>$request->order_id])->count();
            }
            
            $validator = Validator::make($request->all(),$rules);
    
            
            if ($validator->fails()) {
                $status = 0;
                $message = trans('validation.validation_error_occured');
                $errors = $validator->messages();
            }else{
               
                $where['user_id'] = $user_id;
                $where['type'] = $request->type;
                $where['order_id'] = $request->order_id;
                
                $check = Common::check_already('ratings',$where);
                if($check != 1)
                {
                    $rating_types=['Quality','Delivery','Overl All'];
                    if(!empty($request->rating) && is_array(($request->rating))){
                        foreach($request->rating as $key=>$srating){
                         if(isset($rating_types[$key])){

                        $ins['type']             = $request->type;
                        $ins['user_id']          = $user_id;
                        $ins['vendor_id']          = $product_vender_id;
                        $ins['rating']           = $srating;
                        $ins['title']            = $rating_types[$key];
                        $ins['comment']          = $request->comment??'';
                        $ins['order_id']         = $request->order_id;
                        $ins['created_at']       = gmdate('Y-m-d H:i:s');
                        $ins['updated_at']       = gmdate('Y-m-d H:i:s');

                        $purchasestatus = 1;
                if(empty($purchasestatus))
                {
                   $in_id = 0;
                }
                else
                {
                  $in_id = Common::insert_to_db('ratings',$ins);  

                    if($request->type == 1)//product
                    {
                        $p_avg = number_format(Rating::avg_rating(['product_id'=>$request->product_id]), 1, '.', '');
                        $p  = ProductModel::find($request->product_id);
                        if($p){
                            $p->rating_avg = $p_avg;
                            $p->save();
                        }
                    }
                }
                         }
                        }
                    }
                    
                    
                
                if($in_id > 0 ){
                    $status = 1;
                    $message = trans('validation.rating_saved');
                }else{
                    $status = 0;
                    $message = trans('validation.purchase_required_to_rate');
                }
                }
                else
                {
                    $status = 0;
                    $message = trans('validation.already_rated');
                }
                
            }
            return response()->json(['status' => $status, 'error' => $errors, 'message' => $message, 'oData' => $o_data], 200);
    }
    
    public function get_complete_ratings(REQUEST $request){
        
         $status = 1;
        $message = "";
        $o_data = [];
        $errors = [];
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'type'=>'required'
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
        $where1=[];
        $types=['product'=>'product_id','vendor'=>'vendor_id','workshop'=>'service_id'];
        $where1[$types[$request->type]]=$request->id;
        
                $offset = isset($request->page) ? ($request->page - 1) * $request->limit : 0;
                $vendor_rattings  =  Rating::where($where1)->orderBy('id','desc')->limit(($request->limit ?? 2))->skip(($offset))->get();
               $avgRatingsByTitle = Rating::where($where1)
    ->selectRaw('title, ROUND(AVG(rating)::numeric, 2) as avg_rating')
    ->groupBy('title')
    ->pluck('avg_rating', 'title');


                
                foreach ($vendor_rattings as $key => $row) {

                    // $reply = RatingReply::where('rating_id',$row->id)->get();
                    // foreach ($reply as $key_re => $value_re) {
                    //     $reply[$key_re]->created_date = get_date_in_timezone($value_re->created_at, 'Y-m-d H:i:s');
                    //     $vendor_details = VendorModel::find($value_re->user_id);
                    //     $vendor_data = VendorDetailsModel::where('user_id',$value_re->user_id)->first();
                    //     $reply[$key_re]->user_image = $vendor_details->user_image??'';
                    //     $reply[$key_re]->company_name = $vendor_data->company_name??'';
                    //   }

                    $rattings[] = [
                        'rating' => $row->rating,
                        'name' => $row->title,
                        'comment' => $row->comment,
                        'customer_name' => $row->user ? ($row->user->first_name.' '. $row->user->last_name) : '',
                        'image' => $row->user ? $row->user->user_image : '',
                        'created_at' => date('d M y',strtotime($row->created_at)),
                       // 'reply' => $reply,
                    ];
                }
                
                $o_data['total_ratings'] = convert_all_elements_to_string($avgRatingsByTitle);
                $o_data['rattings'] = convert_all_elements_to_string($rattings);
        $message="Message sent Successfully";
        
        return response()->json(['status' => $status, 'message' => $message, 'errors' => (object) $errors, 'oData' => $o_data], 200);
            return $rattings;
    }
}
