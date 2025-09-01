<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebBannerModel extends Model
{
   
    use HasFactory;

    protected $table = 'web_banners'; // Table name

    protected $fillable = ['name','name_ar','description_ar', 'description', 'banner_image', 'active','button_link', 'deleted']; // Mass-assignable attributes

    /**
     * Accessor to get the full URL for the blog image.
     *
     * @param string $value
     * @return string
     */
    public function getBannerImageAttribute($value)
    {
        if ($value) {
            return url(config('global.upload_path') . '/' . config('global.user_image_upload_dir') . '/' . $value);
        }
        return '';
    }
   
}
