<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductTag extends Model
{
    //
    protected $table = "product_tags";
   // protected $primaryKey = "attribute_id";
    public $path = "/uploads/banners/";
    public $timestamps = false;


    public static function saveData($data)
    {
        if(isset($data['id']) && !empty($data['id'])) {
            $attribute = Tag::find($data['id']);
        } else {
           $attribute = new Tag(); 
           $attribute->status ='Active';
        }
        
        $attribute->name = $data['name'];
        $attribute->name_ar = $data['name_arabic'];
        if(isset($data['status'])){
            $attribute->status = $data['status'];
        }
        
        $status = $attribute->save();
        
        if($status ) {
            return TRUE;
        }
        return FALSE;
    }

    
    
}
