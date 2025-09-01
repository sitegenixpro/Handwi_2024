<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventFeature extends Model
{
    use HasFactory;
    protected $table = "event_features";

    protected $fillable = ['name','name_ar','image_path','description','description_ar'];
    
    public function getImagePathAttribute($value)
    {
        return get_uploaded_image_url($value, 'features_images_dir');
    }

   
}
