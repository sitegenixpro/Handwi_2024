<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ServiceBooking;
use App\Models\User;
use Kreait\Firebase\Contract\Database;

class ServiceOrderReceived extends Command
{
    /**
     * The name and signature of the console command. 
     * 
     * @var string
     */
    protected $signature = 'order:send_service_order_received {order_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
     public $database = '';
     public $status_text = '';
    public function __construct(Database $database)
    {
        parent::__construct();
        $this->database = $database;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $order_id = $this->argument("order_id");
      //  $status_text = order_status($this->argument("status"));
        $order = ServiceBooking::where('id',$order_id )->get();
        $ntype          = 'workshop_order_placed';
        if($order->count() > 0){
            $order = $order->first();
            $user=User::find($order->user_id);
           
            $nottification_id = time();
             
            if($user->firebase_user_key != ''){
                if (!empty($user->firebase_user_key)) {
                    $notification_data["Notifications/" . $user->firebase_user_key . "/" . $nottification_id] = [
                        "title" => "Workshop has been Booked",
                        "description" => "Order has been places",
                        "notificationType" => $ntype,
                        "createdAt" => gmdate("d-m-Y H:i:s", $nottification_id),
                        "orderId" => (string) $order_id,
                        "url" => "",
                        "imageURL" => '',
                        "read" => "0",
                        "seen" => "0",
                    ];
                    $this->database->getReference()->update($notification_data);
                }
                
            }
            $nodeData = [
              'type'     => 'order_status',
              'orderId'  => $order->order_id,
              'title'    => "order status is updated",
              'createdDate' => gmdate('Y-m-d H:i:s'),
              'imageUrl' => '',
              'time'    => $nottification_id
            ];
            if($order->store_firebase_user_key != ''){
                //$this->database->getReference('Notifications/'.$order->store_firebase_user_key."/".$nottification_id.'/')->update($nodeData);
            }

            
          
         if($user->user_device_token != ''){
           $res = send_single_notification($user->user_device_token,
                        [
                            "title" => "Workshop Booked",
                            "body" => "You order has been placed",
                            "icon" => 'myicon',
                            "sound" => 'default',
                            "click_action" => "EcomNotification",
                        ],
                        [
                            "type" => $ntype,
                            "notificationID" => $nottification_id,
                            "imageURL" => '',
                            "orderId" => $order->id
                        ]);
           
         }
         
        

        }
        return 0;
    }
}
