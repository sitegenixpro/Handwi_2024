<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBooking extends Model
{
    use HasFactory;
   	protected $table = "service_bookings";
    protected $guarded = []; 
    public $fillable = [
        'service_id',
        'user_id',
        'vendor_id',
        'seat_no',
        'status',
        'payment_type',
        'price',
        'service_charge',
        'Workshop_price',
        'tax', 
        'grand_total',
        'ref_id',
        'number_of_seats',
        'order_number',
        'admin_share',
        'vendor_share',
        

    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
}
