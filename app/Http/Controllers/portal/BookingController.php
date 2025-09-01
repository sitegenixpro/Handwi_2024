<?php

namespace App\Http\Controllers\portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use DB;
use Kreait\Firebase\Database;
use App\Models\OrderModel;
use App\Models\OrderProductsModel;
use App\Models\OrderStatusHistory;
use App\Models\ServiceBooking;
use App\Exports\ExportReports;
use Maatwebsite\Excel\Facades\Excel;
class BookingController extends Controller
{

    public function index(Request $request)
    {
        $vendor  = auth::user();
        
        $page_heading = "Bookings"; 
        

        $list = ServiceBooking::join('service', 'service.id', '=', 'service_bookings.service_id')->join('users', 'users.id', '=', 'service_bookings.user_id')
            ->select(
                'service_bookings.*',
                'service.name as service_name', // Assuming the service table has a `name` field
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as customer_name"),
                'service_bookings.created_at as order_date'
            )->where('service_bookings.vendor_id', $vendor->id)
            ->orderBy('service_bookings.id', 'DESC') 
            ->get();
            
        
       
        return view('portal.bookings.list',compact('page_heading','list'));
    }
   
    
    
   public function details(Request $request,$id)
    {
        $page_heading = "Booking Details"; 
        
        $booking = ServiceBooking::join('service', 'service.id', '=', 'service_bookings.service_id')
        ->join('users', 'users.id', '=', 'service_bookings.user_id')
        ->select(
            'service_bookings.*',
            'service.name as service_name', 
            'service.description as service_description',
            'service.image as service_image', 
            'service.service_price as service_price', 
            'service.to_date as service_to_date', 
            'service.from_date as service_from_date', 
            'service.to_time as service_to_time', 
            'service.from_time as service_from_time', 
            DB::raw("CONCAT(users.first_name, ' ', users.last_name) as customer_name"),
            'users.email as customer_email',
            'users.phone as customer_phone',
            'service_bookings.created_at as booking_date'
        )
        ->where('service_bookings.id', $id)
        ->first();
        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found');
        }
        if ($request->test) {
            return make_pdf($booking, '', 'test');
        }
        if ($request->d) {
            return make_pdf($booking, '', 'd');
        }

        
             
            
         
        return view('admin.bookings.details',compact('page_heading','booking',));
    }

    public function edit_order(Request $request,$id)
    {
        $page_heading = "Orders Details Edit"; 
        //$list =  OrderProductsModel::select('orders.*',DB::raw("CONCAT(res_users.first_name,' ',res_users.last_name) as customer_name"))->->leftjoin('res_users','res_users.id','orders.user_id')->with('vendor')->where(['order_id'=>$id])->paginate(10);
        //if($list->total()){     
        //foreach($list->items() as $key=>$row){
       
            //$list->items()[$key]->tickets=OrderModel::tickets($row->id);
            //$list->items()[$key]->product_name=OrderProductsModel::product_name($row->product_id,$row->product_type);
        //}
        // }
            $filter['order_id']  = $id;
            
            $page = (int)$request->page??1;
            $limit= 10;
            $offset = ($page - 1) * $limit;
            $list = OrderProductsModel::get_order_details($filter)->skip($offset)->take($limit)->get();
            $list = process_order($list);

            
         
        return view('admin.orders.details_edit',compact('page_heading','list'));
    }

    function change_status(Request $request)
    {
        $status  = "0";
        $message = "";
        if(OrderProductsModel::where('order_id',$request->detailsid)->update(['order_status'=>$request->statusid])){
            $orderproducts = OrderProductsModel::where('order_id',$request->detailsid)->orderBy('order_status','asc')->first();
            OrderModel::where('order_id',$orderproducts->order_id)->update(['status'=>$orderproducts->order_status]);
            $status = "1";
            $message = "Successfully updated";
            $message = "Order status is changed successfully";


            $check =  OrderStatusHistory::where('order_id',$request->detailsid)->where('status_id',$request->statusid)->get()->count();
            if($check == 0)
            {
            $datastatusins = new OrderStatusHistory;
            $datastatusins->order_id = $request->detailsid;
            $datastatusins->status_id = $request->statusid;
            $datastatusins->created_at = gmdate('Y-m-d H:i:s');
            $datastatusins->updated_at = gmdate('Y-m-d H:i:s');
            $datastatusins->save();
           }

            // update payment withdraw status to comfirm in cod payment menthod
            $order = OrderModel::where('order_id',$request->detailsid)->first();
            if($order->payment_mode ==5 && $order->status ==4){
                $order->withdraw_status = 3;
                $order->save();
            }

            \Artisan::call("order:update_status ".$orderproducts->order_id." ".$request->statusid ); 
            
        // exec("php ".base_path()."/artisan order:update_status ".$orderproducts->order_id." ".$request->statusid." > /dev/null 2>&1 & ");
        exec("php ".base_path()."/artisan order:update_status_vendor ".$orderproducts->order_id." ".$request->statusid." > /dev/null 2>&1 & "); 
        // if($request->order_status == 4)
        // {
        // exec("php ".base_path()."/artisan order:update_status_vendor ".$orderproducts->order_id." ".$request->statusid." > /dev/null 2>&1 & ");    
        // }
        }else{
            $message = "Something went wrong";
        }
        echo json_encode(['status'=>$status,'message'=>$message]);
    }
    

}