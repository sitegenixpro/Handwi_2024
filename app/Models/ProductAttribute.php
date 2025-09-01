<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductAttribute extends Model
{
    //
    protected $table = "product_selected_attribute_list";
    protected $primaryKey = "product_attribute_id";
    public $timestamps = false;
     public $fillable = [
        'product_id',
        'manage_stock',
        'stock_quantity',
        'allow_back_order',
        'stock_status',
        'sale_price',
        'regular_price',
        'taxable',
        'image',
        'weight',
        'length',
        'width',
        'height',
        'shipping_note',
        'pr_code','product_desc','product_full_descr','barcode'
    ];
    protected $appends = ['image_paths'];

    
    public function getImagePathsAttribute()
{
    if ($this->image) {
        $images = explode(',', $this->image); // Split the image filenames by comma
        $imageUrls = array_map(function ($image) {
             return asset('/uploads/products/'.$image);
            //return get_uploaded_image_url($image, 'product_image_upload_dir');
        }, $images);

        return $imageUrls;
    }

    // Return a default placeholder image if no images are found
    return [get_uploaded_image_url('placeholder.png', 'product_image_upload_dir')];
}

}