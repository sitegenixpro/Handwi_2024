<?php

namespace App\Http\Controllers\Admin;
use App\Models\VendorModel;
use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\ServiceBooking;
use App\Models\User;
use App\Models\Maintainance;
use App\Models\Contracting;
use App\Models\Service;
use Carbon\Carbon;
use DateTime;
use App\Models\OrderServiceModel;
use App\Models\OrderProductsModel;
use DB;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $page_heading = "Dashboard";
        $users  = VendorModel::where(['role'=>'2','users.deleted'=>'0'])->get()->count();;
        $vendors = VendorModel::where(['role'=>'3','users.deleted'=>'0'])->get()->count();
        $vendors_new = VendorModel::where(['role'=>'3','users.deleted'=>'0','users.admin_viewed'=>'0'])->get()->count();
        $products = ProductModel::where(['product.deleted'=>0])->get()->count();
        $bookings = ServiceBooking::get()->count();
        $sales    = OrderModel::get()->count();

        $latest_orders =  OrderModel::select('orders.*','users.name',DB::raw("CONCAT(users.first_name,' ',users.last_name) as customer_name"))->leftjoin('users','users.id','orders.user_id')->with(['customer','activity'])->orderBy('orders.order_id','DESC')->limit(6)->get();
        foreach($latest_orders as $key => $val){
            $lowest_order_prd_status = OrderProductsModel::where('order_id', $val->order_id)->orderby('order_status', 'asc')->first();
                if (isset($lowest_order_prd_status->order_status)) {
                    $latest_orders[$key]->status = $lowest_order_prd_status->order_status;
                    $latest_orders[$key]->status_text = order_status($lowest_order_prd_status->order_status);
                } else {
                    $latest_orders[$key]->status_text = order_status($val->status);
                }
        }

        $Date  = date('Y-m-d');
        $date7 = date('Y-m-d', strtotime($Date. ' - 7 days'));

        $newusers = [];
        $newvendors = [];
        $days = [];


            $stop_date = date('Y-m-d H:i:s');
            $stop_date = date('Y-m-d', strtotime($stop_date . ' -12 months'));

            $begin = new DateTime(date('Y-m-d')); 
            $end   = new DateTime($stop_date);
            for($i = $begin; $i >= $end; $i->modify('-1 months')){ 
           
           $newusers[] = User::where(['role'=>'2','deleted'=>0])
           ->whereDate('users.created_at','>=',$i->format("Y-m-01").' 00:00:00')
           ->where('users.created_at','<=',$i->format("Y-m-t").' 23:59:59')
           ->count();

           $newvendors[] = User::where(['role'=>'3','deleted'=>0])
           ->whereDate('users.created_at','>=',$i->format("Y-m-01").' 00:00:00')
           ->where('users.created_at','<=',$i->format("Y-m-t").' 23:59:59')
           ->count();

           $months[] = date('F', strtotime($i->format('Y-m-d')));

          
            
                  }

                  // echo '<pre>'; print_r(implode(', ', $months)); echo '</pre>';exit;
       
         
           $graphdata['stop_date']  = date('Y-m-d');
           $graphdata['start_date']  = $stop_date;
           
           $service_josbs = OrderServiceModel::get()->count();
           $contract_maintanence_count = Maintainance::get()->count() + Contracting::get()->count();
            /////////////////////////////////
           $filter = ['product.deleted'=>0];
           $params = [];
           $params['activity_ids'] = '7';
           $sortby = "product.id";
           $sort_order = "desc";
           $products = ProductModel::get_products_list($filter, $params,$sortby,$sort_order)->get()->count();

           $services =  Service::where(['deleted' => 0])->get()->count();
           $params['activity_ids'] = '3';
           $food = ProductModel::get_products_list($filter, $params,$sortby,$sort_order)->get()->count();
           $vendors = VendorModel::where(['role'=>'3','users.deleted'=>'0'])
           ->leftjoin('vendor_details','vendor_details.user_id','=','users.id')
           ->leftjoin('industry_types','industry_types.id','=','vendor_details.industry_type')->get()->count();
           
         
$startOfWeek = Carbon::now()->startOfWeek(); // Monday
$endOfWeek = Carbon::now()->endOfWeek();     // Sunday

// Group bookings by weekday
$bookings_serial = ServiceBooking::whereBetween('created_at', [$startOfWeek, $endOfWeek])
    ->get()->groupBy(function($date) {
    return Carbon::parse($date->created_at)->format('D'); // e.g., Mon, Tue
});

// Group sales by weekday
$sales_serial = OrderModel::whereBetween('created_at', [$startOfWeek, $endOfWeek])
    ->get()->groupBy(function($date) {
    return Carbon::parse($date->created_at)->format('D');
});

$days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

$bookings_data = [];
$sales_data = [];

foreach ($days as $day) {
    $bookings_data[] = isset($bookings_serial[$day]) ? count($bookings_serial[$day]) : 0;
    $sales_data[] = isset($sales_serial[$day]) ? count($sales_serial[$day]) : 0;
}




        return view('admin.dashboard', compact('page_heading','bookings_data','sales_data','bookings','services','food','vendors','latest_orders','products','users','sales','newusers','newvendors','months','graphdata','service_josbs','contract_maintanence_count','vendors_new'));
    }

}
