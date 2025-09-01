<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeLogo extends Model
{
    use HasFactory;

    protected $table = "home_logos"; // Table name
    public $timestamps = true; // Enable timestamps (created_at and updated_at)

    // Add 'image', 'deleted', and 'active' to the fillable property
    protected $fillable = ['image', 'deleted', 'active'];

    // If you want to access the image URL dynamically
    public function getImageAttribute($value)
    {
        if ($value) {
           // return url(config('global.upload_path').config('global.user_image_upload_dir').$value);
           return get_uploaded_image_url($value,'banner_image_upload_dir');
        }
        return "";
    }

    // Add a scope to filter out deleted entries if needed
    public function scopeNotDeleted($query)
    {
        return $query->where('deleted', 0); // Exclude rows where 'deleted' is set to 1
    }

    // Add a scope to filter active logos
    public function scopeActive($query)
    {
        return $query->where('active', 1); // Only get active logos
    }
}
