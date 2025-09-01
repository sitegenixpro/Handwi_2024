<?php

// app/Models/ReportedArtist.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportedShop extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'reason_id',
        'description',
       
    ];

    public function reason()
    {
        return $this->belongsTo(ReportReason::class, 'reason_id');
    }

    // User who made the report
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Artist being reported
    public function shop()
    {
        return $this->belongsTo(User::class, 'shop_id');
    }

}
