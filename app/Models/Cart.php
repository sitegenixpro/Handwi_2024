<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = "cart";
    protected $guarded = [];
    public static function get_user_cart($where)
    {
        return Cart::where($where)->orderby("id", "asc")->get();
    }

    public static function update_cart($data, $condition)
    {
        return Cart::where($condition)->update($data);
    }
    public static function create_cart($data)
    {
        $cart = Cart::create($data);
        if ($cart) {
            return $cart->id;
        } else {
            return 0;
        }
    }
    public function product()
    {
        return $this->hasOne(ProductModel::class, 'id', 'product_id');
    }

   
}
