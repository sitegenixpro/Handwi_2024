<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorLocation extends Model
{
    use HasFactory;

    protected $fillable = ['location', 'latitude', 'longitude', 'user_id'];

    
}
