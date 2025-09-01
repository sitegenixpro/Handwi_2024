<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\User;
use App\Models\ContactUsSetting;
use App\Models\VendorServiceTimings;
use App\Models\ActivityLog;



if (!function_exists('logActivity')) {
    function logActivity($activity)
    {
        ActivityLog::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'activity' => $activity,
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
        ]);
    }
}


if (! function_exists('get_food_activity') ) {
    function get_food_activity()
    {
        return \App\Models\ActivityType::select('id','name')->where('name','Food')->where(['name'=>'Food','deleted' => 0])->first();
    }
}

if (! function_exists('make_pdf') ) {
    function make_pdf($order,$name='',$currency='AED')
    {
        $order = \App\Models\OrderModel::with(['users','vendor','products' => function ($qr) {
            $qr->select('order_products.*', 'product_attribute_id as product_variant_id', 'default_attribute_id','product_name')->join('product', 'product.id', 'order_products.product_id');
        }])->where('order_id', $order->order_id)->first();
        $order->address = \App\Models\UserAdress::get_address_details($order->address_id);
       //stores the pdf for invoice
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'UTF-8', 
            'autoScriptToLang' => true, 
            'autoLangToFont' => true
        ]);
        $path = '';
        $mpdf->autoLangToFont = true;
        $order->order_number   = config('global.sale_order_prefix') . date(date('Ymd', strtotime($order->created_at))) . $order->order_id;
        // dd(storage_path('invoices').'/Order-'.$order_number.'.pdf');
        // return view('mail.order_success', compact('order', 'name','currency'));
        try {
            $view = view('invoices.order', compact('order', 'name','currency'))->render();
            if($currency == 'test'){
                return $view;
            }
            $mpdf->WriteHTML($view);
            if($currency == 'd'){
                return  $mpdf->output($path,'d');
            }
            $path = storage_path('app/public/invoices').'/Order-'.$order->order_number.'.pdf';
            $output =  $mpdf->output($path,'F');
            
        } catch (\Exception $e) {
            // dd($e);
        }
        return $path ;
    }
}
if (! function_exists('make_service_pdf') ) {
    function make_service_pdf($o_data,$name='')
    {
               //stores the pdf for invoice
        $path = '';
        try {
            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'UTF-8', 
                'autoScriptToLang' => true, 
                'autoLangToFont' => true
            ]);
            $mpdf->autoLangToFont = true;
            $view = view('invoices.services', compact('o_data', 'name'))->render();
            //$o_data->order_no  = config('global.sale_order_prefix') . "-SER" . date(date('Ymd', strtotime($order->created_at))) . $order->order_id;
            // return $view;
            $mpdf->WriteHTML($view);
            $path = storage_path('app/public/invoices').'/Service-Order-'.$o_data->order_no.'.pdf';
            $output =  $mpdf->output($path,'F');
        } catch (\Exception $e) {
            //dd($e);
        }
        return $path ;
    }
}
if (! function_exists('get_pdf_url') ) {
    function get_pdf_url($order_number)
    {
        $path = url('/').'/storage/invoices/Order-'.$order_number.'.pdf';
        // if(!File::exists( $path)){
        //     $path = '';
        // }
       return $path;
    }
}
if (! function_exists('get_service_pdf_url') ) {
    function get_service_pdf_url($order_number)
    {
        $path = url('/').'/storage/invoices/Service-Order-'.$order_number.'.pdf';
        // if(!File::exists($path)){
        //     $path = '';
        // }
       return $path;
    }
}


if (! function_exists('time_to_uae') ) {
    function time_to_uae($date, $format="Y-m-d H:i:s")
    {
        return date($format, strtotime(' +4 hours', strtotime($date)));
    }
}
function amount_currency($amount)
{
    $lang = App::getLocale(); 
    return $amount = number_format($amount,2);
    if($lang == 'ar') {
        return $amount.' '.trans('titles.currency') ;
    }
    return trans('titles.currency').' ' . $amount;
}
function getcreatedAt()
{   
    date_default_timezone_set('Asia/Dubai');
    return date('Y-m-d H:i:s');
}

function check_store_open($request,$vendor_id,$list='0'){
    $start_time = '';
    $end_time   = '';
    $today = strtolower(date('l'));
    $now = time_to_uae(date('Y-m-d H:i:s'));
    $now = date("H:i:s", strtotime($now));
    $is_open_24= 0;

    $timings = App\Models\VendorTimings::where('vendor_id',$vendor_id)->where(['day'=>$today])->get();
    if($timings->count() == 0){
        if($list){
            return [
                'now' => $now,
                'open_time' => '',//$start_time,
                'close_time' => '',//$end_time,
                'open' => '0',
                'is_open_24'=>"0"
            ];
        }
       return '0'; 
    }

    $is_open_now = "0";
    $open_from = $open_to = "";
    
    foreach($timings as $time_key){
        if($time_key->has_24_hour == 1){
            $is_open_now = "1";
            $open_from = '00:00 AM';
            $open_to   = '12:59 PM';
            $is_open_24=1;
            break;
        }
        
        if( strtotime($now) > strtotime($time_key->time_from) && strtotime($now) < strtotime($time_key->time_to) ){
            $is_open_now = "1";
            $open_from = $time_key->time_from;
            $open_to   = $time_key->time_to;
        }
    }
    
    if($is_open_now == 0){
        foreach($timings as $time_key){
            if( strtotime($time_key->time_from) > strtotime($now)  ){
                if($open_from == ""){
                    $open_from = $time_key->time_from;
                    $open_to   = $time_key->time_to;
                }
            }
        }
    }
    
        if($list){
            return [
                'now' => $now,
                'open_time' => date("h:i A", strtotime($open_from)),
                'close_time' => date("h:i A", strtotime($open_to)),
                'open' => (string)$is_open_now,
                'is_open_24'=>(string)$is_open_24,
            ];
        }else{
            return (string)$is_open_now;
        }

    // dd($today,$now, $start_time,$end_time,$timings);
    return '0';
}

function check_store_open_old($request,$vendor_id,$list='0'){
    $start_time = '';
    $end_time   = '';
    $today = strtolower(date('D'));
    $now = time_to_uae(date('Y-m-d H:i:s'));
    $now = date("H:i:s", strtotime($now));

    $timings = VendorServiceTimings::where('vendor',$vendor_id)->first();
    if(!$timings){
        if($list){
            return [
                'now' => $now,
                'open_time' => '',//$start_time,
                'close_time' => '',//$end_time,
                'open' => '0',
            ];
        }
       return '0'; 
    }
    
    
    if($today == 'sun' && $timings->sunday == 1){
        $start_time = $timings->sun_from;
        $end_time   = $timings->sun_to;
    }
    if($today == 'mon' && $timings->monday == 1){
        $start_time = $timings->mon_from;
        $end_time   = $timings->mon_to;
    }
    if($today == 'tue' && $timings->tuesday == 1){
        $start_time = $timings->tues_from;
        $end_time   = $timings->tues_to;
    }
    if($today == 'wed' && $timings->wednesday == 1){
        $start_time = $timings->wed_from;
        $end_time   = $timings->wed_to;
    }
    if($today == 'thu' && $timings->thursday == 1){
        $start_time = $timings->thurs_from;
        $end_time   = $timings->thurs_to;
    }
    if($today == 'fri' && $timings->friday == 1){
        $start_time = $timings->fri_from;
        $end_time   = $timings->fri_to;
    }
    if($today == 'sat' && $timings->saturday == 1){
        $start_time = $timings->sat_from;
        $end_time   = $timings->sat_to;
    }
    $start_time = date("H:i:s", strtotime($start_time));
    $end_time = date("H:i:s", strtotime($end_time));
    
    if($start_time <= $now && $now <= $end_time){
        if($list){
            return [
                'now' => $now,
                'open_time' => date("h:i A", strtotime($start_time)),
                'close_time' => date("h:i A", strtotime($end_time)),
                'open' => '1',
            ];
        }
        return '1';
    }
    if($list){
        return [
            'now' => $now,
            'open_time' => '',//date("h:i A", strtotime($start_time)),
            'close_time' => '',//date("h:i A", strtotime($end_time)),
            'open' => '0',
        ];
    }
    // dd($today,$now, $start_time,$end_time,$timings);
    return '0';
}
function user_symbol($name,$id){

    $buttonColors =  ['success', 'primary', 'danger', 'warning', 'info'];
    $colorCount   = count($buttonColors);
    $letter=$name[0];
    $letter     = strtoupper($letter);
    $btnColor   = $buttonColors[$id%$colorCount];
    return "<div class='p-2 user-symbols bg-{$btnColor}'>{$letter}</div>";
}
function order_number($order){

   return config('global.sale_order_prefix').date(date('Ymd', strtotime($order->created_at))).$order->order_id;
}

function refer_code($user){
    return date(date('Ymd', strtotime(date('Ymd')))) . $user->id;
    // return 'RF_' . date(date('Ymd', strtotime(date('Ymd')))) . $user->id;
}
function merge_cart_items($user,$request){
    if(!$user->ref_code){
        $user->ref_code = refer_code($user);
        $user->save();
    }
    if($request->refer_code){
        $send = User::where("ref_code",$request->refer_code)->where('deleted', 0)->where(['role' => 2])->first();

        if($send){
            $accepted_user_id = $user->id;
            $sender_id = $send->id;

            $history = \App\Models\RefHistory::where('accepted_user_id',$accepted_user_id)->first();
            if(!$history){
                $history = new \App\Models\RefHistory();
                
                $con = ContactUsSetting::first();

                $history->sender_id         = $sender_id;
                $history->accepted_user_id  = $accepted_user_id;
                $history->name              = $user->first_name.' '. $user->last_name;
                $history->ref_code          = $request->refer_code;
                $history->status            = 1;
                $history->discount          = $con->ref_discount;
                $history->discount_type     = $con->ref_discount_type;
                $history->save(); 
            }
        }

    }
    \App\Models\Cart::where('device_cart_id',$request->device_cart_id)->update(['user_id'=>$user->id]);
    $cart_items = \App\Models\Cart::where(["user_id" => $user->id])->orderBy('id','desc')->get();
    $p_id = '';
    $store_id = '';
    foreach ($cart_items as $key => $row) {
        if($store_id && $store_id != $row->store_id){
            $car = \App\Models\Cart::find($row->id);
            if($car){
                $car->delete();
            }
        }else{
            if($p_id != $row->product_id){
                $qty = \App\Models\Cart::
                where(["user_id" => $user->id , 'product_id'=>$row->product_id , 'store_id'=>$row->store_id])
                ->sum('quantity');
                $row->quantity = $qty;
                $row->save();
            }else{
                $car = \App\Models\Cart::find($row->id);
                if($car){
                    $car->delete();
                }
            }
        }

        $p_id = $row->product_id;
        $store_id = $row->store_id;
    }
    return;
}
if (! function_exists('get_uploaded_image_url') ) {
    function get_uploaded_image_url( $filename='', $dir='', $default_file='placeholder.png' )
    {
        if ( !empty($filename) ) {

            $upload_dir = '';//config('global.upload_path');
            
            if (! empty($dir) ) {
                $dir= $upload_dir.config("global.{$dir}");
            }
            return \Storage::disk(config('global.upload_bucket'))->url($dir . $filename);
            if($dir =='post_image_upload_dir' || $dir=='service_image_upload_dir'){
                if($dir != 'post_image_upload_dir'){
                    $upload_dir =config('global.upload_path');
                }
                if (! empty($dir) ) {
                    $dir= $upload_dir.config("global.{$dir}");
                }
                return \Storage::disk(config('global.upload_bucket'))->url($dir . $filename);
            }else{
                
            
                if (! empty($dir) ) {
                    $dir= $upload_dir.config("global.{$dir}");
                }
                return asset($filename);
                return \Storage::disk('local')->url($dir . $filename);
            }
            if (\Storage::disk(config('global.upload_bucket'))->exists($dir . $filename)) {
                // return 'https://d3k2qvqsrjpakn.cloudfront.net/moda/public'.\Storage::url("{$dir}{$filename}");
                // return 'https://dcoxlqahffirr.cloudfront.net/'.$dir . $filename;
                return \Storage::disk(config('global.upload_bucket'))->url($dir . $filename);
            } else {
                // return config('global.aws_url').$dir . $filename;
                return asset($filename);
                // return asset(\Storage::url("{$dir}{$filename}"));
            }
            // if ( \Storage::disk(config('global.upload_bucket'))->exists($dir.$filename) ) {
            //    return asset(\Storage::url("{$dir}{$filename}"));
            // }
        }
        if ( !empty($default_file) ) {
            if (! empty($dir) ) {
                $dir= config("global.{$dir}");
            }
            $default_file = asset(\Storage::url("{$default_file}"));
        }
        if (! empty($default_file) ) {
            return $default_file;
        }


        return \Storage::url("logo.png");
    }
}
if (! function_exists('time_ago') ) {
    function time_ago( $datetime, $now=NULL, $timezone='Etc/GMT' )
    {
        if (! $now ) {
            $now = time();
        }
        $timezone_user  = new DateTimeZone($timezone);
        $date           = new DateTime($datetime, $timezone_user);
        $timestamp      = $date->getTimestamp();
        $timespan       = explode(', ', timespan($timestamp, $now));
        $timespan       = $timespan[0] ?? '';
        $timespan       = strtolower($timespan);

        if (! empty($timespan) ) {
            if ( stripos($timespan, 'second') !== FALSE ) {
                $timespan = 'few seconds ago';
            } else {
                $timespan .= " ago";
            }
        }

        return $timespan;
    }
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

if (! function_exists('get_date_in_timezone') ) {
    function get_date_in_timezone($date, $format="d-M-Y h:i a",$timezone='',$server_time_zone="Etc/GMT")
    {
        if($timezone == ''){
            $timezone = config('global.date_timezone');
        }
        try {
            $timezone_server    = new DateTimeZone($server_time_zone);
            $timezone_user      = new DateTimeZone($timezone);
        }
        catch (Exception $e) {
            $timezone_server    = new DateTimeZone($server_time_zone);
            $timezone_user      = new DateTimeZone($server_time_zone);
        }


        $dt = new DateTime($date, $timezone_server);

        $dt->setTimezone($timezone_user);

        return $dt->format($format);
    }
}
function public_url()
{
    if (config('app.url') == 'http://127.0.0.1:8000') {
        return str_replace('/public', '', config('app.url'));
    }
    return config('app.asset_url');
}
function login_message()
{
    return 'Current login session has been expired. Please login again.';
}

function image_upload($request,$model = 'category',$file_name="", $mb_file_size = 25)
{
    if($request->file($file_name ))
    {
        $file = $request->file($file_name);
         return  file_save_to_s3($file,$model, $mb_file_size);
        return  file_save($file,$model, $mb_file_size);
    }
    return ['status' =>false,'link'=>null,'message' => 'Unable to upload file'];
}
function image_save($request,$model = 'category', $file_name = "", $mb_file_size = 25)
{
    if($file = $request->file($file_name)){
   //$dir = config('global.upload_path')."/".$model;
    $dir =$model;
    $file_name = time().uniqid().".".$file->getClientOriginalExtension();
    $file->storeAs($dir,$file_name,config('global.upload_bucket'));
    return ['status' =>true,'link'=>$file_name,'message' => 'file uploaded'];
    }
    else
    {
    return ['status' =>false,'link'=>null,'message' => 'file not uploaded'];    
    }
    
}
if (! function_exists('array_combination') ) {
    function array_combination($arrays, $i = 0)
    {
        if (!isset($arrays[$i])) {
            return array();
        }
        if ($i == count($arrays) - 1) {
            return $arrays[$i];
        }

        // get combinations from subsequent arrays
        $tmp = array_combination($arrays, $i + 1);

        $result = array();

        // concat each array from tmp with each element from $arrays[$i]
        foreach ($arrays[$i] as $v) {
            foreach ($tmp as $t) {
                $result[] = is_array($t) ?
                    array_merge(array($v), $t) :
                    array($v, $t);
            }
        }

        return $result;
    }
}

function file_save($file,$model,$mb_file_size=25)
{
     try {
        //validateSize
        $precision = 2;
        $size = $file->getSize();
        $size = (int) $size;
        $base = log($size) / log(1024);
        $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
        $dSize = round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];

        $aSizeArray = explode(' ', $dSize);
        if ($aSizeArray[0] > $mb_file_size && ($aSizeArray[1] == 'MB' || $aSizeArray[1] == 'GB' || $aSizeArray[1] == 'TB')) {
            return ['status' =>false,'link'=>null,'message' => 'Image size should be less than equal '.$mb_file_size.' MB'];
        }
        // rename & upload files to upload folder
        $name =  uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = public_path() . '/uploads/'.$model.'/';
        $file->move($path, $name);

        $image_url = '/uploads/'.$model.'/' . $name;

        return ['status' =>true,'link'=>$image_url,'message' => 'file uploaded'];

    } catch (\Exception $e) {
        return ['status' =>false,'link'=> null ,'message' => $e->getMessage()];
    }
}

function file_save_to_s3($file, $model, $mb_file_size = 25)
{
    try {
        $model = str_replace('/', '', $model);
        //validateSize
        $precision = 2;
        $size = $file->getSize();
        $size = (int) $size;
        $base = log($size) / log(1024);
        $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
        $dSize = round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];

        $aSizeArray = explode(' ', $dSize);
        if ($aSizeArray[0] > $mb_file_size && ($aSizeArray[1] == 'MB' || $aSizeArray[1] == 'GB' || $aSizeArray[1] == 'TB')) {
            return ['status' => false, 'link' => null, 'message' => 'Image size should be less than equal ' . $mb_file_size . ' MB'];
        }
        // rename & upload files to upload folder
        $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs($model, $fileName, config('global.upload_bucket'));
        $image_url = $fileName;
        return ['status' => true, 'link' => $image_url, 'message' => 'file uploaded'];
    } catch (\Exception $e) {
        return ['status' => false, 'link' => null, 'message' => $e->getMessage()];
    }
}

function printr($data){
  echo '<pre>';
  var_dump($data);
  echo '</pre>';
}
function url_title($str, $separator = '-', $lowercase = FALSE)
{
    if ($separator == 'dash')
    {
        $separator = '-';
    }
    else if ($separator == 'underscore')
    {
        $separator = '_';
    }

    $q_separator = preg_quote($separator);

    $trans = array(
        '&.+?;'                 => '',
        '[^a-z0-9 _-]'          => '',
        '\s+'                   => $separator,
        '('.$q_separator.')+'   => $separator
    );

    $str = strip_tags($str);

    foreach ($trans as $key => $val)
    {
        $str = preg_replace("#".$key."#i", $val, $str);
    }

    if ($lowercase === TRUE)
    {
        $str = strtolower($str);
    }

    return trim($str, $separator);
}

function send_email($to, $subject, $mailbody)
{
    
    require base_path("./vendor/autoload.php");
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = env('MAIL_HOST');
        $mail->SMTPAuth = true;
        $mail->Username = env('MAIL_USERNAME');
        $mail->Password = env('MAIL_PASSWORD');
        $mail->SMTPSecure = env('MAIL_ENCRYPTION');
        $mail->Port = env('MAIL_PORT');
        $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        $mail->addAddress($to);
        $mail->isHTML(true);
        //$mail->addCC('orders@leconciergeapp.ae');
       // $mail->addBCC('ahmadalhamoi1997@gmail.com');
        $mail->addBCC('anilnavis@gmail.com');
        $mail->Subject = $subject;
        $mail->Body    = $mailbody;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
       
        if (!$mail->send()) {
            return 0;
        } else {
            return 1;
        }
    } catch (Exception $e) {
        return 0;
    }
}
function send_sms(){
    //Please Enter Your Details
    $user="LaConcierge"; //your username
    $password="Khaf@2024"; //your password
    $mobilenumbers="919847823799"; //enter Mobile numbers comma seperated
    $message = "test messgae"; //enter Your Message
    $senderid="LaConcierge"; //Your senderid
    $messagetype="N"; //Type Of Your Message
    $DReports="Y"; //Delivery Reports
    $url="http://www.smscountry.com/SMSCwebservice_Bulk.aspx";
    $message = urlencode($message);
    $ch = curl_init();
    if (!$ch){die("Couldn't initialize a cURL handle");}
    $ret = curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt ($ch, CURLOPT_POSTFIELDS,
    "User=$user&passwd=$password&mobilenumber=$mobilenumbers&message=$message&sid=$senderid&mtype=$messagetype&DR=$DReports");
    $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //If you are behind proxy then please uncomment below line and provide your proxy ip with port.
    // $ret = curl_setopt($ch, CURLOPT_PROXY, "PROXY IP ADDRESS:PORT");
    $curlresponse = curl_exec($ch); // execute
    if(curl_errno($ch))
    echo 'curl error : '. curl_error($ch);
    if (empty($ret)) {
    // some kind of an error happened
    die(curl_error($ch));
    curl_close($ch); // close cURL handler
    } else {
    $info = curl_getinfo($ch);
    curl_close($ch); // close cURL handler
    echo $curlresponse; //echo "Message Sent Succesfully" ;
    }
}
function send_normal_SMS($message, $mobile_numbers, $sender_id = "")
{
    $data = [
        "Text" => $message,
        "Number"=>$mobile_numbers,
        "SenderId"=> "LaConcierge",
        "DRNotifyUrl"=> "https://www.domainname.com/notifyurl",
        "DRNotifyHttpMethod"=> "POST",
        "Tool"=> "API"
    ];
    
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://restapi.smscountry.com/v0.1/Accounts/cioxBZzk6mrhXPFqtYVh/SMSes/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>json_encode($data),
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Basic Y2lveEJaems2bXJoWFBGcXRZVmg6ZXVpVWNUSVZQVmRlT0F1MVpNQzJEZXhJbllLSk81NW5kUHpOYnY0OA=='
  ),
));

$response = curl_exec($curl);

curl_close($curl);
// echo $response;
// exit;
return true;
    $username = "LaConcierge"; //username
    $password = "Khaf@2024"; //password
    $sender_id = "LaConcierge";
    $message_type = "N";
    $delivery_report = "Y";
    $url = "http://www.smscountry.com/SMSCwebservice_Bulk.aspx";
    $proxy_ip = "";
    $proxy_port = "";
    $message_type = "N";
    $message = urlencode($message);
    $sender_id = (!empty($sender_id)) ? $sender_id : $sender_id;
    $ch = curl_init();
    if (!$ch) {
        $curl_error = "Couldn't initialize a cURL handle";
        return false;
    }
    $ret = curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "User=" . $username . "&passwd=" . $password . "&mobilenumber=" . $mobile_numbers . "&message=" . $message . "&sid=" . $sender_id . "&mtype=" . $message_type . "&DR=" . $delivery_report);
    $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if (!empty($proxy_ip)) {
        $ret = curl_setopt($ch, CURLOPT_PROXY, $proxy_ip . ":" . $proxy_port);
    }
    $curl_response = curl_exec($ch);
    //echo '<pre>'; print_r($curl_response); echo '</pre>';exit;
    if (curl_errno($ch)) {
        $curl_error = curl_error($ch);
    }
    
    if (empty($ret)) {
        curl_close($ch);
        dd('1');
        return false;
    } else {
        $curl_info = curl_getinfo($ch);
        curl_close($ch);
        return true;
    }
}

function convert_all_elements_to_string($data=null){
    if($data != null){
        array_walk_recursive($data, function (&$value, $key) {
            if (! is_object($value) ) {
                $value = (string) $value;
            } else {
                $json = json_encode($value);
                $array = json_decode($json, true);
                if(is_array($array)){
                    array_walk_recursive($array, function (&$obj_val, $obj_key) {
                        $obj_val = (string) $obj_val;
                    });
                }
                if (! empty($array) ) {
                    $json = json_encode($array);
                    $value = json_decode($json);
                } else {
                    $value = new stdClass();
                }
            }
        });
    }
    return $data;
}
function convert_all_elements_to_string2($data=null){
    if($data != null){
        array_walk_recursive($data, function (&$value, $key) {
            if (! is_object($value) ) {
                $value = (string) $value;
            } else {
                $json = json_encode($value);
                $array = json_decode($json, true);

                array_walk_recursive($array, function (&$obj_val, $obj_key) {
                    $obj_val = (string) $obj_val;
                });

                if (! empty($array) ) {
                    $json = json_encode($array);
                    $value = json_decode($json);
                } else {
                    $value = $array;
                }
            }
        });
    }
    return $data;
}
function thousandsCurrencyFormat($num) {

    if( $num > 1000 ) {
        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];
        return $x_display;
    }

    return $num;
}
function order_type($id)
   {

        $status_string = "Delivery";
        if($id == 1)
        {
           $status_string = "Pick Up";
        }
    return $status_string;
   }

function payment_mode($id)
   {

        $status_string = "Wallet";
                if($id == 1)
                {
                   $status_string = "Wallet";
                }
                if($id == 2)
                {
                   $status_string = "Card Payment";
                }
                if($id == 3)
                {
                   $status_string = "Apple Pay";
                }
                if($id == 4)
                {
                   $status_string = "Google Pay";
                }
                if($id == 5)
                {
                   $status_string = "Cash on delivery";
                }
                if($id == "")
                {
                    $status_string = "";
                }
    return $status_string;
   }
function order_status($id)
   {
        $status_string = "Pending";
        if($id == config('global.order_status_pending'))
                {
                   $status_string = "Pending";
                }
                if($id == config('global.order_status_accepted'))
                {
                   $status_string = "Accepted";
                }
                if($id == config('global.order_status_ready_for_delivery'))
                {
                   $status_string = "Ready for Delivery";
                }
                if($id == config('global.order_status_dispatched'))
                {
                   $status_string = "Dispatched";
                }
                if($id == config('global.order_status_delivered'))
                {
                   $status_string = "Delivered";
                }
                if($id == config('global.order_status_cancelled'))
                {
                   $status_string = "Canceled";
                }
                if($id == 11)
                {
                   $status_string = "Rejected";
                }
    return $status_string;
   }
   function service_order_status($id)
   {
        $status_string = "Pending";
        if($id == config('global.order_status_pending'))
                {
                   $status_string = "Pending";
                }
                if($id == config('global.order_status_accepted'))
                {
                   $status_string = "Accepted";
                }
                if($id == config('global.order_status_ready_for_delivery'))
                {
                   $status_string = "Ready for Delivery";
                }
                if($id == config('global.order_status_dispatched'))
                {
                   $status_string = "Ongoing";
                }
                if($id == config('global.order_status_delivered'))
                {
                   $status_string = "Completed";
                }
                if($id == config('global.order_status_cancelled'))
                {
                   $status_string = "Cancelled";
                }
    return $status_string;
   }
function quote_status($id)
{
    $status_string = "Pending";
    if($id == 0)
    {
        $status_string = "Pending";
    }
    if($id == 1)
    {
        $status_string = "Accepted";
    }
    if($id == 2)
    {
        $status_string = "Paid";
    }
    if($id == 3)
    {
        $status_string = "Quote Generated";
    }
    if($id == 10)
    {
        $status_string = "Canceled";
    }
    return $status_string;
}
function process_order($list, $lang_code = "1")
   {
            foreach($list as $key=>$value)
            {
                if($value->status == config('global.order_status_pending'))
                {
                   $list[$key]->status_string = trans('order.pending');
                }
                if($value->status == config('global.order_status_accepted'))
                {
                   $list[$key]->status_string = trans('order.accepted');
                }
                if($value->status == config('global.order_status_ready_for_delivery'))
                {
                   $list[$key]->status_string = trans('order.ready_for_delivery');
                }
                if($value->status == config('global.order_status_dispatched'))
                {
                   $list[$key]->status_string = trans('order.dispatched');
                }
                if($value->status == config('global.order_status_delivered'))
                {
                   $list[$key]->status_string = trans('order.delivered');
                }
                if($value->status == config('global.order_status_cancelled'))
                {
                   $list[$key]->status_string = trans('order.cancelled');
                }


               if(!empty($value->address_id))
               {
               $list[$key]->shipping_address = App\Models\UserAdress::get_address_details($value->address_id);
               }

               $order_products  = App\Models\OrderProductsModel::product_details(['order_id'=>$value->order_id]);
               $list[$key]->order_products = process_product_data($order_products);




            //    $order_events    = App\Models\OrderProductsModel::events_details(['order_id'=>$value->order_id]);
            //    $list[$key]->order_events = process_events_data($order_events);

            //    $order_services    = App\Models\OrderProductsModel::services_details(['order_id'=>$value->order_id]);
            //    $list[$key]->order_services = process_service_data($order_services);

            //    $order_packages    = App\Models\OrderProductsModel::packages_details(['order_id'=>$value->order_id]);

            //    $list[$key]->order_packages = process_package_data($order_packages);
           }
           return $list;
    }
    function process_product_data($row, $lang_code = "1")
   {

      $ratings  = [];
      $product_row_data = $row;
      $sl = 0;
      foreach($row as $item) {

      if($lang_code == 2)
      {
      $product_row_data[$sl]->product_name      = (string) $item->product_name_arabic;
      $product_row_data[$sl]->product_desc_full      = (string) $item->product_desc_full_arabic;
      $product_row_data[$sl]->product_desc_short      = (string) $item->product_desc_short_arabic;
      }
      $product_images = [];

      if(!empty($item->image))
      {
         $imagesarray = explode(",",$item->image);
         foreach($imagesarray as $img)
         {
           $product_images[] = (string) get_uploaded_image_url($img,'product_image_upload_dir');//url(config('global.upload_path').config('global.product_image_upload_dir').$img);
         }
      }
      else
      {
          $product_images[] = (string) url(config('global.upload_path').'placeholder.jpg');
      }
      if(isset($item->order_status))
      {
      $product_row_data[$sl]->status_string = order_status($item->order_status);
      }

      $stock_status = 0;
      $stock_status_string = "Out of stock";
      if(isset($item->stock_quantity))
      {
      if($item->stock_quantity > 0)
      {
        $stock_status = 1;
        $stock_status_string = "In stock";
      }
      }


      $discountper = 0;
      if(isset($item->sale_price) && isset($item->regular_price))
      {
          $diff = $item->regular_price - $item->sale_price;
          $discountper = ($diff/$item->regular_price)*100;
          $discountper = round($discountper);
      }

        $product_attributes = \App\Models\ProductModel::getSelectedProductAttributeVals($item->product_attribute_id);
        if($product_attributes && $product_attributes->attribute_name){
            $product_row_data[$sl]->attribute_name = (string) $product_attributes->attribute_name;
            $product_row_data[$sl]->attribute_values = (string) $product_attributes->attribute_values;
        }
        
        $product_attributes_full = \App\Models\ProductModel::getSelectedProductAttributeValsFull($item->product_attribute_id);
        if($product_attributes_full){
        $product_row_data[$sl]->selected_attribute_list = $product_attributes_full->toArray();
        }else{
            $product_row_data[$sl]->selected_attribute_list = [];
        }

      $product_row_data[$sl]->stock_status        = $stock_status;
      $product_row_data[$sl]->stock_status_string = $stock_status_string;
      $product_row_data[$sl]->product_images      = $product_images;
      $product_row_data[$sl]->discount_per        = $discountper;
      $product_row_data[$sl]->share_url           = url('share/product/'.encryptor($item->id));





      $sl++;
   }
   
   $product_row_data = process_vendor($product_row_data);
   return $product_row_data;

   }
   function encryptor($string) {
    $output = false;

    $encrypt_method = "AES-128-CBC";
    //pls set your unique hashing key
    $secret_key = 'muni';
    $secret_iv = 'muni123';

    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    //do the encyption given text/string/number

        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);


    return $output;
}

function decryptor( $string) {
    $output = false;

    $encrypt_method = "AES-128-CBC";
    //pls set your unique hashing key
    $secret_key = 'muni';
    $secret_iv = 'muni123';

    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);


        //decrypt the given text/string/number
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);


    return $output;
}
 function process_vendor($row, $lang_code = "1")
   {
      foreach($row as $key=>$item) {

        $row[$key]->vendor_img_path              = (string) image_link("placeholder.png",config('global.user_image_upload_dir'));
      if(!empty($item->vendorimage))
      {
        $row[$key]->vendor_img_path             = (string) url(config('global.upload_path').config('global.user_image_upload_dir').$item->vendorimage);
      }

      }
      return $row;
   }
    function image_link($image ,$directory )
    {
    if($image !="") {
        return url(config('global.upload_path').$directory.$image);

    }
   }

function process_product_data_api($row)
{

    $product_row_data = [];
    $product_row_data["product_id"]         = (string) $row->product_id;
    $selected_attribute_list = [];
    if (isset($row->product_attribute_id)) {
        $product_row_data["product_variant_id"] = (string) $row->product_attribute_id;

        $product_attributes = \App\Models\ProductModel::getSelectedProductAttributeVals($row->product_attribute_id);

        if($product_attributes && $product_attributes->attribute_name){
            $product_row_data["attribute_name"]       = (string) $product_attributes->attribute_name;
            $product_row_data["attribute_name_arabic"]       = (string) $product_attributes->attribute_name_arabic;
            $product_row_data["attribute_values"]       = (string) $product_attributes->attribute_values;
            $product_row_data["attribute_values_arabic"]       = (string) $product_attributes->attribute_values_arabic;
        }
        $product_attributes_full = \App\Models\ProductModel::getSelectedProductAttributeValsFull($row->product_attribute_id);
        $selected_attribute_list = $product_attributes_full->toArray();
       
        //printr($product_attributes_full->toArray());
        // dd($product_row_data,$product_attributes->attribute_name);
    }
    $product_row_data["product_name"]       = (string) $row->product_name;
    $product_row_data["product_name_arabic"]       = (string) $row->product_name_arabic;
    $product_row_data["video"]       = (string)  !empty($row->video) ? get_uploaded_image_url($row->video, 'product_image_upload_dir') : "";
    $product_row_data["thumbnail"]       = (string) !empty($row->thumbnail) ? get_uploaded_image_url($row->thumbnail, 'product_image_upload_dir') : "";
    $product_row_data["shipment_and_policies"]       = (string) $row->shipment_and_policies;
     $product_row_data["shipment_and_policies_ar"]       = (string) $row->shipment_and_policies_ar;
    $product_row_data["is_personalisation"]       = (string) $row->personalisation;
    $product_row_data["product_desc_short"] = (string) $row->product_desc;
    $product_row_data["product_desc_short_arabic"] = (string) $row->product_desc_short_arabic;
    $product_row_data["product_desc"]       = (string) $row->product_full_descr;
    $product_row_data["product_desc_arabic"]       = (string) $row->product_desc_full_arabic;
    $product_row_data["stock_quantity"]       = (int) $row->stock_quantity;
    if ( isset($row->product_vender_id) ) {
        $product_row_data["product_seller_id"]  = (string) $row->product_vender_id;
    }
    $product_row_data["allow_back_order"]   = (string) $row->allow_back_order;

    if (isset($row->category_id)) {
        $product_row_data["category_id"] = (string) $row->category_id;
    }
    if (isset($row->category_name)) {
        $product_row_data["category_name"] = (string) $row->category_name;
    }
    if (isset($row->product_brand_id) && ($row->product_brand_id > 0) ) {
        $product_row_data["product_brand_id"] = (string) $row->product_brand_id;
    } else {
        $product_row_data["product_brand_id"] = '';
    }

    if (isset($row->brand)) {
        $product_row_data["brand_name"] = (string) $row->brand;
    } else {
        $product_row_data["brand_name"] = '';
    }

    $product_row_data["product_type"]       = (string) $row->product_type;
    // $product_row_data["boxcount"]       = (string) $row->boxcount;

    $product_images = explode(",", $row->image);
    $product_image  = (count($product_images) > 0) ? $product_images[0] : $row->image;
    $product_row_data["product_image"] = get_uploaded_image_url($product_image,'product_image_upload_dir');//url(config('global.upload_path') . '/' . config('global.product_image_upload_dir') . $product_image);

    $product_row_data["product_images"]     = array();
    if (is_array($product_images)) {
        foreach($product_images as $key=>$image) {
            if($image){
                $product_row_data["product_images"][] =get_uploaded_image_url($image,'product_image_upload_dir');// url(config('global.upload_path') . '/' . config('global.product_image_upload_dir') . $image);
            }
        }
    }
    // $product_row_data["rated_users"] = (!empty($row->rated_users)) ? (string) $row->rated_users : "0";
    // $product_row_data["rating"]      = (!empty($row->rated_users)) ? (string) $row->rating: "0";
    $product_row_data["sale_price"]         = number_format((float) $row->sale_price,2,".", "");
    $product_row_data["regular_price"]      = number_format((float) $row->regular_price,2,".", "");
    $product_row_data["product_vendor_id"] = $row->product_vender_id;
    $product_row_data["product_taxable"] = $row->taxable;

    $product_row_data["avg_rating"]      = number_format(\App\Models\Rating::avg_rating(['product_id'=>$row->product_id]), 1, '.', '');
    $product_row_data["rating_count"] = \App\Models\Rating::where('product_id',$row->product_id)->get()->count() ?? 0;
    $where_rating['product_id']   = $row->product_id;
    $ratingdata = \App\Models\Rating::rating_list($where_rating);
    $product_row_data["rating_details"] = convert_all_elements_to_string($ratingdata);

    
    
    // $product_row_data["moda_main_category"] = $row->moda_main_category;
    // $product_row_data["moda_sub_category"] = $row->moda_sub_category;

    if ( isset($row->seller_id) ) {
        $product_row_data["seller_id"] = $row->seller_id;
    }
    if ( isset($row->store_id) ) {
        $product_row_data["store_id"] = $row->store_id;
    }
    
    // if(request()->test){
    //     dd($row);
    // }

    if(isset($row->vendor->vendordata)){
        $store = $row->vendor->vendordata;

        $store->rating      = number_format(\App\Models\Rating::avg_rating(['vendor_id'=>$row->vendor->id]), 1, '.', '');
        $store->rating_count = \App\Models\Rating::where('vendor_id',$row->vendor->id)->get()->count() ?? 0;

        $store_timing = check_store_open(request(),$row->vendor->id,'1');
        $store->open_time = $store_timing['open_time'] ?? '';
        $store->close_time = $store_timing['close_time'] ?? '';
        $store->store_is_open = $store_timing['open'] ?? '0';
        $storeDetails =  \App\Models\Stores::where('vendor_id', $row->vendor->id)->first();
       
             
        $stor  = [
            'id'=>(string)$store->id,
            'store_id'=>(string)$store->user_id,
            'company_name'=>$storeDetails->store_name,
            'email'=>$storeDetails->business_email,
            'about'=>$storeDetails->description,
            'company_name_ar'=>$storeDetails->store_name_ar,
            'description'=>$storeDetails->description,
            'description_ar'=>$storeDetails->description_ar,
            'logo'=> $storeDetails->logo ?? '',
            'available_from'  => $store->open_time." - ".$store->close_time,
            'rating'=>$store->rating,
            'store_is_open'=>$store->store_is_open,
            'rating_count'=>$store->rating_count,
            'location'=>$storeDetails->tax_city,
            'latitude'=> $store->latitude,
            'longitude'=>$store->longitude,
            'delivery_type' => (string) (optional($storeDetails)->delivery_type ?? ""),
            'standard_delivery_text' => (string) (optional($storeDetails)->standard_delivery_text ?? ""),
            'delivery_min_days' => (string) (optional($storeDetails)->delivery_min_days ?? ""),
            'delivery_max_days' => (string) (optional($storeDetails)->delivery_max_days ?? ""),
        ];

        $product_row_data['store'] = $stor;
    }


    if ( isset($row->store_name) ) {
        $product_row_data["store_name"] = substr($row->store_name,0,19).".";
    }

    if ( $product_row_data["sale_price"] < $product_row_data["regular_price"] ) {
        $product_row_data['offer_enabled'] = 1;
        $price_diff = $product_row_data["regular_price"] - $product_row_data["sale_price"];
        $offer_percentage = ($price_diff / $product_row_data["regular_price"]) * 100;
        $offer_percentage = ceil($offer_percentage);
        $product_row_data['offer_percentage'] = $offer_percentage;
    } else {
        $product_row_data['offer_enabled'] = 0;
        $product_row_data['offer_percentage'] = 0;
    }
    $product_row_data["vendor_rating"]  = "0";
    if(isset($row->vendor_rating)){
        $product_row_data["vendor_rating"]  =   (string) $row->vendor_rating;
    }
    $product_row_data['selected_attribute_list'] = $selected_attribute_list;
    return $product_row_data;
}

function generate_otp(){
 return 1111;
  return  rand(pow(10, 4 - 1), pow(10, 4) - 1);
}
if (!function_exists('get_otp')) {
    function get_otp()
    {
        return generate_otp();
    }
}
function wallet_history($data=[])
    {
        $data = (object)$data;
        $WalletHistory = new \App\Models\WalletHistory();
        $WalletHistory->user_id	        = $data->user_id;
        $WalletHistory->wallet_amount	= $data->wallet_amount;
        $WalletHistory->pay_type	    = $data->pay_type;
        $WalletHistory->pay_method      = $data->pay_method;
        $WalletHistory->description	    = $data->description;
        $WalletHistory->created_at	    = gmdate('Y-m-d H:i:00');
        $WalletHistory->updated_at	    = gmdate('Y-m-d H:i:00');

        if($WalletHistory->save())
            return 1;

        return 0;
    }
if (! function_exists('web_date_in_timezone') ) {
        function web_date_in_timezone($date, $format="d M Y h:i A",$server_time_zone="Etc/GMT")
        {
//            $timezone = session('user_timezone');
             // $timezone = 'Asia/Dubai';
            $timezone = 'Asia/Riyadh';
            if(!$timezone){
                $timezone = $server_time_zone;
            }
            $timezone_server    = new DateTimeZone($server_time_zone);
            $timezone_user      = new DateTimeZone($timezone);
            $dt = new DateTime($date, $timezone_server);
            $dt->setTimezone($timezone_user);
            return $dt->format($format);
        }
    }
function get_user_permission($model, $operation = 'r')
{
    $return = false;

    if (Auth::user()->role_id == '1' || Auth::user()->id == '1') {
        $return = true;
    } else/* if (Auth::user()->is_admin_access == 1) */ {
        $user_permissions = Session::get('user_permissions');
        // dd($user_permissions);
        if (isset($user_permissions[strtolower($model)])) {
            $permissions = json_decode($user_permissions[strtolower($model)] ?? '');
            if (in_array($operation, $permissions)) {
                $return = true;
            }
        }
    }

    return $return;
}
function GetUserPermissions( $action = '' ){


    if ( Auth()->user()->id == 1 )
        return true;

        $flag = false;

    if ( Auth()->user()->id )
    {

        $sPermission = App\Models\User::where('id', Auth()->user()->id)->first()->user_permissions;

        if ( $sPermission ) {
            $aPermissions = json_decode($sPermission, 1);

            if ( $action != '' ) {

                if ( isset ( $aPermissions[$action] ) )
                    $flag = true;

            }
        }
    }

    return ($flag);
}
function validateAccesToken($access_token)
    {

        $user = User::where(['user_access_token' => $access_token])->get();

        if ($user->count() == 0) {
            http_response_code(401);
            echo json_encode([
                'status' => "0",
                'message' => 'Invalid login',
                'oData' => (object) array(),
                'errors' => (object) [],
            ]);
            exit;

        } else {
            $user = $user->first();
            if ($user->active == 1) {
                return $user->id;
            } else {
                http_response_code(401);
                echo json_encode([
                    'status' => "0",
                    'message' => 'Invalid login',
                    'oData' => (object) array(),
                    'errors' => (object) [],
                ]);
                exit;
                return response()->json([
                    'status' => "0",
                    'message' => 'Invalid login',
                    'oData' => (object) array(),
                    'errors' => (object) [],
                ], 401);
                exit;
            }
        }
    }
    function rating_type($id)
   {

        $text_value = "";
                if($id == 1)
                {
                   $text_value = "Product";
                }
                if($id == 2)
                {
                   $text_value = "Vendor";
                }
                if($id == 3)
                {
                   $text_value = "Service";
                }
                if($id == "")
                {
                    $text_value = "";
                }
    return $text_value;
   }
   function banner_type($id)
   {

        $text_value = "";
                if($id == 1)
                {
                   $text_value = "Main Banner";
                }
                if($id == 2)
                {
                   $text_value = "New Offers Banner";
                }
                if($id == 3)
                {
                   $text_value = "Single banner";
                }
                if($id == 4)
                {
                   $text_value = "Middle 1 banner";
                }
                if($id == 5)
                {
                   $text_value = "Middle 2 banner";
                }
                if($id == 6)
                {
                   $text_value = "Middle 3 banner";
                }
                if($id == "")
                {
                    $text_value = "";
                }
    return $text_value;
   }

   function fetch_booking_created_at_date($order_id){
    $items = \App\Models\OrderServiceModel::where('order_id',$order_id)->first();
    if ( $items ){
        $datetime = $items->created_at;
        $dCreatedAtDate = \Carbon\Carbon::parse($datetime)->setTimezone('Asia/Dubai')->toDateTimeString();
        $datetime = gmdate("d-M-y h:i A", strtotime($dCreatedAtDate));
        return $datetime;
    }
    
}
function fetch_booking_date($order_id){
       
      
    $items = \App\Models\OrderServiceItemsModel::where('order_id',$order_id)->first();
    
    if ( $items ){

        
        $booking_date = $items->booking_date;
        
        $booking_date = date('d-M-y h:i A', strtotime($booking_date));
        
        return $booking_date;
    }
    //return date('d-M-y h:i A');
   }

   if (! function_exists('DateTimeFormat') ) {
    function DateTimeFormat($datetime)
    {
       
        $dCreatedAtDate = \Carbon\Carbon::parse($datetime)->setTimezone('Asia/Dubai')->toDateTimeString();
        $datetime = gmdate("d-M-y h:i A", strtotime($dCreatedAtDate));
      
        return $datetime;
    }

}
function findClosest($arr, $n, $target)
{
    // Corner cases
    if ($target <= $arr[0])
        return $arr[0];
    if ($target >= $arr[$n - 1])
        return $arr[$n - 1];

    // Doing binary search
    $i = 0;
    $j = $n;
    $mid = 0;
    while ($i < $j)
    {
        $mid = ($i + $j) / 2;

        if ($arr[$mid] == $target)
            return $arr[$mid];

        /* If target is less than array element,
            then search in left */
        if ($target < $arr[$mid])
        {

            // If target is greater than previous
            // to mid, return closest of two
            if ($mid > 0 && $target > $arr[$mid - 1])
                return getClosest($arr[$mid - 1],
                                  $arr[$mid], $target);

            /* Repeat for left half */
            $j = $mid;
        }

        // If target is greater than mid
        else
        {
            if ($mid < $n - 1 &&
                $target < $arr[$mid + 1])
                return getClosest($arr[$mid],
                                  $arr[$mid + 1], $target);
            // update i
            $i = $mid + 1;
        }
    }

    // Only single element left after search
    return $arr[$mid];
}

// Method to compare which one is the more close.
// We find the closest by taking the difference
// between the target and both values. It assumes
// that val2 is greater than val1 and target lies
// between these two.
function getClosest($val1, $val2, $target)
{
    if ($target - $val1 >= $val2 - $target)
        return $val2;
    else
        return $val1;
}

if (! function_exists('get_uploaded_image_url_multiple') ) {
    function get_uploaded_image_url_multiple( $filename='', $dir='', $default_file='placeholder.png' )
    {

        
        if ( !empty($filename) ) {

            $upload_dir = config('global.upload_path');
            if (! empty($dir) ) {
                $dir= config("global.{$dir}");

            }

            if ( \Storage::disk(config('global.upload_bucket'))->exists($dir.$filename) ) {
                // return 'https://d3k2qvqsrjpakn.cloudfront.net/moda/public'.\Storage::url("{$dir}{$filename}");
                return \Storage::disk(config('global.upload_bucket'))->url($dir.$filename);
                //return asset(\Storage::url("{$dir}{$filename}"));
           }else{

            return asset(\Storage::url("{$dir}{$filename}"));
           }
        }
        if ( !empty($default_file) ) {
            if (! empty($dir) ) {
                $dir= config("global.{$dir}");
            }
            $default_file = asset(\Storage::url("{$dir}{$default_file}"));
        }
        if (! empty($default_file) ) {
            return $default_file;
        }


        return \Storage::url("logo.png");
    }
}
   
?>
