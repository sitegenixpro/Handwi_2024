<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $table = 'user_address';

    protected $fillable = [
        'user_id', 'full_name', 'dial_code', 'phone', 'address',
        'country_id', 'state_id', 'city_id', 'address_type',
        'status', 'is_default'
    ];
}
