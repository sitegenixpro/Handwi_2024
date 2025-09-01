<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\SettingsModel;
use App\Models\Wishlist;
use App\Models\Cart;

use App\Traits\StoreImageTrait;
use App\Models\Personalization;

class CartController extends Controller
{
    use StoreImageTrait;
    public function addToCart(Request $request)
    {
        $status = 0;
        $message = "";
        $popupData = [];

        $validated = $request->validate([
            'product_id' => 'required|numeric|min:1',
            'quantity' => 'nullable|numeric|min:1',
            'customer_notes' => 'nullable|string|max:1000',
             'customer_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120' 
        ]);

        $product_id = $validated['product_id'];
        $quantity = $validated['quantity'] ?? 1;
        $notes = $validated['customer_notes'] ?? null;
        $file_name = null;

        if ($request->hasFile('customer_file')) {
            $uploaded = $this->verifyAndStoreImage(
                $request,
                'customer_file',
                config('global.product_image_upload_dir') // or use a specific one like 'uploads/cart_documents'
            );

            if (!empty($uploaded)) {
                $file_name = $uploaded;
            }
        }
        
       
         

        // Fetch product details
        $product = ProductModel::getProductInfo($product_id)->first();
        if($request->variation_id){
             $product = ProductModel::getProductVariant($product_id, $request->variation_id);
           $product=$product[1];
          
            }

        if ($product) {
            $in_stock = $product->stock_quantity;
            $allow_back_order = $product->allow_back_order;
            $sale_price = $product->sale_price;
            $product_name = $product->product_name;

            $product_image = strpos($product->image, ',') !== false
                ? asset('uploads/products/' . explode(',', $product->image)[0])
                : asset('uploads/products/' . $product->image);

            $user_id = Auth::id() ?? 0; // Use 0 for guest users
            $device_cart_id = $request->cookie('device_cart_id') ?? bin2hex(random_bytes(16));
           
            // Check if product already exists in cart
            if($request->variation_id){
                $existingCart = Cart::where('product_id', $product_id)
                ->where('product_attribute_id',$request->variation_id)
                ->where(function ($query) use ($user_id, $device_cart_id) {
                    $query->where('user_id', $user_id)
                          ->orWhere('device_cart_id', $device_cart_id);
                })
                ->first();
            }
            else{
            $existingCart = Cart::where('product_id', $product_id)
                ->where(function ($query) use ($user_id, $device_cart_id) {
                    $query->where('user_id', $user_id)
                          ->orWhere('device_cart_id', $device_cart_id);
                })
                ->first();
            }

            if ($existingCart) {
                // Update existing cart item
                $newQuantity = $existingCart->quantity + $quantity;

                if ($newQuantity <= $in_stock || $allow_back_order) {
                    $existingCart->quantity = $newQuantity;
                    $existingCart->save();
                    $message = "Product quantity updated in your cart.";
                    $status = 1;
                } else {
                    $message = "Unable to add more quantity due to limited stock.";
                }
            } else {
                // Add a new cart item
                if ($quantity <= $in_stock || $allow_back_order) {
                    Cart::create([
                        'product_id' => $product_id,
                        'quantity' => $quantity,
                        'user_id' => $user_id,
                        'device_cart_id' => $device_cart_id,
                        'product_attribute_id' => $product->product_attribute_id,
                        'store_id' => $product->store_id ?? 0,
                        'notes' => $notes,
                        'uploaded_file_path' => $file_name,
                    ]);
                    $message = "Product added to your cart.";
                    $status = 1;
                } else {
                    $message = "Unable to add product to cart due to limited stock.";
                }
            }

            // Retrieve updated cart
            $cartItems = $this->getCartItems($user_id, $device_cart_id);

            // Calculate total
            $total = $cartItems->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });

            // Prepare popup data
            $popupData = [
                'name' => $product_name,
                'image' => $product_image,
                'quantity' => $quantity,
                'price' => $sale_price,
                'cart' => $cartItems->toArray(),
                'total' => number_format($total, 2),
            ];

            // Set device_cart_id cookie for guest users
            if (!$user_id) {
                cookie()->queue('device_cart_id', $device_cart_id, 60 * 24 * 30); // Store for 30 days
            }
        } else {
            $message = "Product not found.";
        }

        return response()->json(['status' => $status, 'message' => $message, 'data' => $popupData]);
    }


    public function storePersonalization(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|numeric|min:1',
            'customer_notes' => 'nullable|string|max:1000',
            'customer_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);

        $user_id = Auth::id() ?? null;
        $cookie_id = $request->cookie('user_cookie_id') ?? bin2hex(random_bytes(16));
        $file_name = null;

        if ($request->hasFile('customer_file')) {
            $file_name = $this->verifyAndStoreImage(
                $request,
                'customer_file',
                config('global.product_image_upload_dir') // Use your configured upload path
            );
        }

        $personalization = Personalization::create([
            'product_id' => $validated['product_id'],
            'user_id' => $user_id,
            'cookie_id' => $user_id ? null : $cookie_id,
            'notes' => $validated['customer_notes'],
            'uploaded_file_path' => $file_name,
        ]);

        if (!$user_id) {
            cookie()->queue('user_cookie_id', $cookie_id, 60 * 24 * 30); // 30 days
        }

        return response()->json(['status' => 1, 'message' => 'Personalization saved successfully.', 'data' => $personalization]);
    }
    public function getPersonalization(Request $request)
    {
        $userId = Auth::id();
        $cookieId = request()->cookie('user_cookie_id');

        $query = Personalization::where('product_id', $request->productId);

        if ($userId) {
            $query->where('user_id', $userId);
        } elseif ($cookieId) {
            $query->where('cookie_id', $cookieId);
        }

        $data = $query->latest()->first();
       
        

        if ($data) {
            $customerFileUrl = $data->uploaded_file_path
            ? get_uploaded_image_url($data->uploaded_file_path, 'product_image_upload_dir') // Use PHP function to generate URL
            : '';
            return response()->json(['status' => 1, 'data' => [
                'uploaded_file_path' => $customerFileUrl, // Send the full URL of the uploaded file
                'notes' => $data->notes,
                'id' => $data->id,
                'uploaded_file_path_name' =>  $data->uploaded_file_path
            ],]);
        }

        return response()->json(['status' => 0, 'data' => null]);
    }
    public function updatePersonalization(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|numeric|exists:personalizations,id',
            'customer_notes' => 'nullable|string|max:1000',
            'customer_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);

        $personalization = Personalization::findOrFail($validated['id']);

        $file_name = $personalization->uploaded_file_path;

        if ($request->hasFile('customer_file')) {
            $file_name = $this->verifyAndStoreImage(
                $request,
                'customer_file',
                config('global.product_image_upload_dir') // Use your configured upload path
            );
        }

        $personalization->update([
            'notes' => $validated['customer_notes'],
            'uploaded_file_path' => $file_name,
        ]);

        return response()->json(['status' => 1, 'message' => 'Personalization updated.', 'data' => $personalization]);
    }

    public function deletePersonalization(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
        ]);

        $personalization = Personalization::find($request->id);
        $personalization->delete();

        return response()->json(['status' => 1, 'message' => 'Personalization deleted.']);
    }



    // public function getCart()
    // {
    //     $user_id = Auth::id() ?? 0;
    //     $device_cart_id = request()->cookie('device_cart_id') ?? null;

    //     $cartItems = $this->getCartItems($user_id, $device_cart_id);

    //     return response()->json(['cart' => $cartItems]);
    // }

    public function getCart()
    {
        $user_id = Auth::id() ?? 0;
        $device_cart_id = request()->cookie('device_cart_id') ?? null;
       
        $cartItems = $this->getCartItems($user_id, $device_cart_id);
      
        $settings = SettingsModel::first();
        $tax_percentage = 0;
        if (isset($settings->tax_percentage)) {
            $tax_percentage = $settings->tax_percentage;
        }
        $shipping_charge = 0;
        if (isset($settings->shipping_charge)) {
            $shipping_charge = $settings->shipping_charge;
        }
    
        $total = $cartItems->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        $totalTax = $cartItems->sum(function ($item) use ($tax_percentage) {
            return ($item['price']  * $tax_percentage) / 100;
        });

        $grand_total = $total + $totalTax +$shipping_charge;
    
        return response()->json([
            'cart' => $cartItems,
            'total' => $total,
            'grand_total' => $grand_total,
            'totalTax'   =>$totalTax,
            'shipping_charge' =>$shipping_charge,
            'item_count' => $cartItems->count(),
        ]);
    }
    

    public function cartpage()
    {
        $page_heading = "Handwi || Cart";
        $user_id = Auth::id() ?? 0;
        $device_cart_id = request()->cookie('device_cart_id') ?? null;

        $cartItems = $this->getCartItems($user_id, $device_cart_id);

        // Calculate totals
        $subtotal = $cartItems->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        $settings = SettingsModel::first();
       
        $tax_percentage = 0;
        if (isset($settings->tax_percentage)) {
            $tax_percentage = $settings->tax_percentage;
        }
        
        $shipping_charge = 0;
        if (isset($settings->shipping_charge)) {
            $shipping_charge = $settings->shipping_charge;
        }
        $totalTax = $cartItems->sum(function ($item) use ($tax_percentage) {
            return ($item['price']  * $tax_percentage) / 100;
        });

        $grand_total = $subtotal  + $totalTax + $shipping_charge;

        return view('front_end.cartpage', [
            'cart' => $cartItems,
            'subtotal' => $subtotal,
            'grand_total' =>$grand_total,
            'shipping'    => $shipping_charge,
            'totalTax'   =>$totalTax,
            'page_heading' => $page_heading,
        ]);
    }

    public function removeItem(Request $request)
    {
        $cartId = $request->input('cart_id');
        $user_id = Auth::id() ?? 0;
        $device_cart_id = $request->cookie('device_cart_id') ?? null;

        $cartItem = Cart::where('id', $cartId)
                        ->where(function ($query) use ($user_id, $device_cart_id) {
                            $query->where('user_id', $user_id)
                                ->orWhere('device_cart_id', $device_cart_id);
                        })
                        ->first();

        if ($cartItem) {
            $cartItem->delete();
            $cartItems = $this->getCartItems($user_id, $device_cart_id);

            $subtotal = $cartItems->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });
            $settings = SettingsModel::first();
           
            $tax_percentage = 0;
            if (isset($settings->tax_percentage)) {
                $tax_percentage = $settings->tax_percentage;
            }
            
            $shipping_charge = 0;
            if (isset($settings->shipping_charge)) {
                $shipping_charge = $settings->shipping_charge;
            }
            $totalTax = $cartItems->sum(function ($item) use ($tax_percentage) {
                return ($item['price']  * $tax_percentage) / 100;
            });
    
            $grand_total = $subtotal  + $totalTax + $shipping_charge;

            return response()->json([
                'status' => true,
                'message' => 'Item removed successfully.',
                'cart' => $cartItems, 
                'subtotal' => $subtotal,
                'grand_total' =>$grand_total,
                'shipping'    => $shipping_charge,
                'totalTax'   =>$totalTax,
                'item_count' => $cartItems->count(),
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Item not found.',
        ]);
    }


    private function getCartItems($user_id, $device_cart_id)
    {
        
       $user_id=($user_id==0)?'10001':$user_id;
        $cartItems = Cart::where(function ($query) use ($user_id, $device_cart_id) {
            $query->where('user_id', $user_id)
                  ->orWhere('device_cart_id', $device_cart_id);
        })->get();
        
      
    
        // Fetch product details for each cart item
        $cartItems = $cartItems->map(function ($item) {
            if($item->product_attribute_id){
             $product = ProductModel::getProductVariant($item->product_id, $item->product_attribute_id);
             
           $product=$product[1];
           
           $attributes = ProductModel::getSelectedProductAttributeValsFull($item->product_attribute_id)->first();
         //  dd( $attributes);
          // dd($product);
          
            }
            else{
            $product = ProductModel::getProductInfo($item->product_id)->first();
            $attributes = ProductModel::getProductAttributesByProductId($item->product_id);
            }
           $product_attributes_full =ProductModel::getSelectedProductAttributeValsFull($item->product_attribute_id);
          $color_text = '';
            $size_text = '';

            foreach ($product_attributes_full as $attribute) {
                if ($attribute->attribute_name === 'Color') {
                    $color_text = 'Color:' . $attribute->attribute_values;
                }

                if ($attribute->attribute_name === 'Size') {
                    $size_text = 'Size:' . $attribute->attribute_values;
                }
            }
            $productImage = '';
            if (!empty($product->image)) {
                $images = explode(',', $product->image);
                $productImage = get_uploaded_image_url($images[0], 'product_image_upload_dir');
            } else {
                $productImage = asset('default-image.jpg'); // fallback
            }
    
            // Get customer uploaded file
            $customerFileUrl = $item->uploaded_file_path
                ? get_uploaded_image_url($item->uploaded_file_path, 'product_image_upload_dir')
                : '';

           // dd($attributes['attribute_name']);
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'name' => $product->product_name ?? 'N/A',
                //'image' => $product && $product->image
                //    ? asset('uploads/products/' . explode(',', $product->image)[0])
                //    : asset('default-image.jpg'), // Use a default image if none is available
                'image' => $productImage,
                'price' => $product->sale_price ?? 0,
                'quantity' => $item->quantity,
                'variant' => $item->product_attribute_id ?? 'N/A',
                'attributes' => $attributes ?? 'N/A',
                'color_text'=>$color_text,
                'size_text'=>$size_text,
                'customer_notes' => $item->notes ?? '',
                'customer_file' => $customerFileUrl,
            ];
        });
    
        return $cartItems;
    }

    public function updateQuantity(Request $request)
    {
        $validated = $request->validate([
            'cart_id' => 'required|numeric|min:1',
            'action' => 'required|string|in:add,subtract',
        ]);
    
        $cart_id = $validated['cart_id'];
        $action = $validated['action'];
    
        // Fetch the cart item
        $cartItem = Cart::find($cart_id);
    
        if (!$cartItem) {
            return response()->json(['status' => 0, 'message' => 'Cart item not found.']);
        }
    
        $product = ProductModel::getProductInfo($cartItem->product_id)->first();
        if (!$product) {
            return response()->json(['status' => 0, 'message' => 'Product not found.']);
        }
    
        $in_stock = $product->stock_quantity;
        $allow_back_order = $product->allow_back_order;
    
        // Update the quantity based on action
        if ($action === 'add') {
            if ($cartItem->quantity + 1 <= $in_stock || $allow_back_order) {
                $cartItem->quantity += 1;
                $cartItem->save();
            } else {
                return response()->json(['status' => 0, 'message' => 'Stock limit exceeded.']);
            }
        } elseif ($action === 'subtract') {
            if ($cartItem->quantity > 1) {
                $cartItem->quantity -= 1;
                $cartItem->save();
            } else {
                return response()->json(['status' => 0, 'message' => 'Quantity cannot be less than 1.']);
            }
        }
    
        // Retrieve updated cart items
        $cartItems = $this->getCartItems(Auth::id() ?? 0, request()->cookie('device_cart_id'));
    
        // Calculate the total
        $subtotal = $cartItems->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        $settings = SettingsModel::first();
       
        $tax_percentage = 0;
        if (isset($settings->tax_percentage)) {
            $tax_percentage = $settings->tax_percentage;
        }
        
        $shipping_charge = 0;
        if (isset($settings->shipping_charge)) {
            $shipping_charge = $settings->shipping_charge;
        }
        $totalTax = $cartItems->sum(function ($item) use ($tax_percentage) {
            return ($item['price']  * $tax_percentage) / 100;
        });

        $grand_total = $subtotal  + $totalTax + $shipping_charge;
    
        return response()->json([
            'status' => 1,
            'message' => 'Quantity updated successfully.',
            'cart' => $cartItems,
            'subtotal' => $subtotal,
            'grand_total' =>$grand_total,
            'shipping'    => $shipping_charge,
            'totalTax'   =>$totalTax,
            'item_count' => $cartItems->count(),
        ]);
    }
    
    public function clearCart(Request $request)
    {
        $user_id = Auth::id() ?? 0;
        $device_cart_id = $request->cookie('device_cart_id') ?? null;

        Cart::where(function ($query) use ($user_id, $device_cart_id) {
            $query->where('user_id', $user_id)
                ->orWhere('device_cart_id', $device_cart_id);
        })->delete();

        return response()->json(['status' => 1, 'message' => 'Cart cleared successfully.']);
    }

    public function addwishlist(Request $request)
    {
        
        $request->validate([
            'product_id' => 'required|exists:product,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $wishlist = Wishlist::where('user_id', $request->user_id)
                            ->where('product_id', $request->product_id)
                            ->first();

        if ($wishlist) {
            return response()->json(['status' => 'error', 'message' => 'Product already in wishlist!'], 400);
        }

        Wishlist::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Product added to wishlist!']);
    }

    public function deletewishlist(Request $request)
    {
        
        $request->validate([
            'wishlist_item_id' => 'required|exists:wishlists,id'
        ]);

        $wishlistItem = Wishlist::where('id', $request->wishlist_item_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$wishlistItem) {
            return response()->json([
                'message' => 'Item not found or unauthorized action.'
            ], 404); 
        }

        $wishlistItem->delete();

        return response()->json([
            'message' => 'Item successfully removed from wishlist.'
        ], 200);
    }



    
}
