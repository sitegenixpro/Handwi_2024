<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs'; // Table name

    protected $fillable = ['name','name_ar','description_ar', 'description', 'blog_image', 'active', 'deleted']; // Mass-assignable attributes

    /**
     * Accessor to get the full URL for the blog image.
     *
     * @param string $value
     * @return string
     */
    public function getBlogImageAttribute($value)
    {
        if ($value) {
           // return url(config('global.upload_path') . '/' . config('global.banner_image_upload_dir') . '/' . $value);
           // return 'https://handwi.s3.amazonaws.com/' . config('global.banner_image_upload_dir')  . $value;
            return get_uploaded_image_url($value,'banner_image_upload_dir');
            
        }
        return '';
    }
}
