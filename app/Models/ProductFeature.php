<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFeature extends Model
{
    use HasFactory;
    protected $table = "product_features";

    protected $fillable = ['name','name_ar','description_ar','image_path','description'];
    
    public function getImagePathAttribute($value)
    {
        return get_uploaded_image_url($value, 'features_images_dir');
    }


   
}
