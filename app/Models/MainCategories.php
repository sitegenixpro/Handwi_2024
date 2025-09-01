<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class MainCategories extends Model
{
    //
    protected $table = "main_category";
    protected $primaryKey = "id";

    protected $guarded = [];

    
    public function getImageAttribute($value)
    {
        if($value)
        {
            return get_uploaded_image_url($value,'category_image_upload_dir');
        }
        else
        {
            return '';
        }
    }
    public function getBannerImageAttribute($value)
    {
        if($value)
        {
            return get_uploaded_image_url($value,'category_image_upload_dir');
        }
        else
        {
            return '';
        }
    }
    

}
