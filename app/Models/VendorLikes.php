<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorLikes extends Model
{
    use HasFactory;
    public function liked_user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    public function liked_vendor() {
        return $this->belongsTo('App\Models\User', 'vendor_id', 'id');
    }
}
