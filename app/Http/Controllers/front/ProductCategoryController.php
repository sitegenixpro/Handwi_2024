<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ReportReason;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\Categories;
use App\Models\Service;
use App\Models\MainCategories;
use App\Models\Wishlist;
use App\Models\HourlyRate;
use App\Models\Stores;
use App\Models\ServiceImage;
use App\Models\Cities;

use App\Models\ServiceTimings;
use App\Models\ActivityType;
use App\Models\AccountType;
use App\Models\ServiceType;
use App\Models\Rating;
use App\Models\VendorModel;
use App\Models\Servicefeatures;
use App\Models\ServiceCategorySelected;
use App\Models\Productfeatures;
use App\Models\RecentlyViewedProduct;
use App\Models\VendorFollower;
use App\Models\ProductAttribute;
use App\Models\VendorDetailsModel;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Auth;



class ProductCategoryController extends Controller
{
    /**
     * Get products by category.
     *
     * @param int $categoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductsByCategory($categoryId)
    {
        $categorydetail = Categories::where('id', $categoryId)->first();
        $page_heading = "Handwi || " . $categorydetail->name;
    
        // Get sorting and price filter parameters
        $sortBy = request('SortBy');
        $startPrice = request('start_price');
        $endPrice = request('end_price');
    
        // Initialize the query builder
        $query = ProductModel::join(DB::raw('(
    SELECT DISTINCT ON (product_id) *
    FROM product_selected_attribute_list
    ORDER BY product_id, sale_price ASC
) as product_selected_attribute_list'), 'product_selected_attribute_list.product_id', '=', 'product.id')
            ->join('product_category', 'product_category.product_id', '=', 'product.id')
            ->leftJoin('ratings', 'ratings.product_id', '=', 'product.id')
            ->select(
                'product.*',
                'product_selected_attribute_list.*',
                DB::raw('COALESCE(AVG(ratings.rating), 0) as average_rating'), // Average rating
                DB::raw('COUNT(ratings.id) as total_reviews')                // Total reviews
            )
            ->where('product.product_status', 1)
            ->where('product.deleted', 0)
            ->where('product_category.category_id', $categoryId);
    
        // Add wishlist data if the user is authenticated
        if (auth()->check() && auth()->user()->role == 2) {
            $query->leftJoin('wishlists', function ($join) {
                $join->on('wishlists.product_id', '=', 'product.id')
                    ->where('wishlists.user_id', auth()->id());
            })
            ->addSelect(
                DB::raw('CASE WHEN wishlists.id IS NOT NULL THEN 1 ELSE 0 END AS added_to_wishlist')
            );
        }
    
        // Apply sorting options
        switch ($sortBy) {
            case 'featured':
                $query->where('product.featured', 1)->orderBy('product.created_at', 'desc');
                break;
            case 'best-selling':
                $query->orderBy('product.sales', 'desc'); // Requires a 'sales' column
                break;
            case 'title-ascending':
                $query->orderBy('product.product_name', 'asc');
                break;
            case 'title-descending':
                $query->orderBy('product.product_name', 'desc');
                break;
            case 'price-ascending':
                $query->orderBy('product_selected_attribute_list.sale_price', 'asc');
                break;
            case 'price-descending':
                $query->orderBy('product_selected_attribute_list.sale_price', 'desc');
                break;
            case 'created-ascending':
                $query->orderBy('product.created_at', 'asc');
                break;
            case 'created-descending':
                $query->orderBy('product.created_at', 'desc');
                break;
            default:
                $query->orderBy('product.created_at', 'desc');
                break;
        }
    
        // Apply price range filter
        if ($startPrice && $endPrice) {
            $query->whereBetween('product_selected_attribute_list.sale_price', [$startPrice, $endPrice]);
        }
    
        // Add required columns to GROUP BY to resolve SQL error
        $query->groupBy(
            'product.id',
            'product_selected_attribute_list.product_attribute_id',
            'product_selected_attribute_list.product_desc_short_arabic',
            'product_selected_attribute_list.product_desc_full_arabic',
            'product_selected_attribute_list.product_id',
            'product_selected_attribute_list.stock_quantity',
            'product_selected_attribute_list.allow_back_order',
            'product_selected_attribute_list.stock_status',
            'product_selected_attribute_list.sold_individually',
            'product_selected_attribute_list.weight',
            'product_selected_attribute_list.length',
            'product_selected_attribute_list.height',
            'product_selected_attribute_list.width',
            'product_selected_attribute_list.shipping_class',
            'product_selected_attribute_list.sale_price',
            'product_selected_attribute_list.regular_price',
            'product_selected_attribute_list.taxable',
            'product_selected_attribute_list.image',
            'product_selected_attribute_list.shipping_note',
            'product_selected_attribute_list.title',
            'product_selected_attribute_list.rating',
            'product_selected_attribute_list.rated_users',
            'product_selected_attribute_list.image_temp',
            'product_selected_attribute_list.product_full_descr',
            'product_selected_attribute_list.barcode',
            'product_selected_attribute_list.image_action',
            'product_selected_attribute_list.pr_code',
            'product_selected_attribute_list.product_desc',
            'product_selected_attribute_list.size_chart',
            'product_selected_attribute_list.manage_stock'   );
    
        // Ensure the `wishlists` column is included only if the user is authenticated
        if (auth()->check() && auth()->user()->role == 2) {
            $query->groupBy('wishlists.id');
        }
    
        // Paginate the results
        $products = $query->paginate(10);
    
        // Fetch category data and build hierarchy
        $categories = Categories::where('deleted', 0)
            ->where('active', 1)
            ->orderBy('parent_id', 'ASC')
            ->orderBy('name', 'ASC')
            ->get();
    
        $categoriesHierarchy = [];
        foreach ($categories as $category) {
            if ($category->parent_id == 0) {
                $categoriesHierarchy[$category->id] = [
                    'category' => $category,
                    'children' => []
                ];
            } else {
                if (isset($categoriesHierarchy[$category->parent_id])) {
                    $categoriesHierarchy[$category->parent_id]['children'][] = $category;
                }
            }
        }
    
        // Return the view with data
        return view('front_end.categories', compact('page_heading','categorydetail', 'products', 'categoryId','categoriesHierarchy'));

    }
    
    public function getProductSuggestions(Request $request)
    {
        $query = $request->get('q');  

        // Check if a query exists
        if ($query) {
             $products = ProductModel::join('product_selected_attribute_list', 'product_selected_attribute_list.product_id', '=', 'product.id')
    ->join('product_category', 'product_category.product_id', '=', 'product.id')
    ->select('product.id', 'product.product_name', 'product.product_desc_short', 'product_selected_attribute_list.sale_price')  
    ->whereRaw('LOWER(product.product_name) LIKE LOWER(?)', ["%{$query}%"])
    ->orWhereRaw('LOWER(product.product_desc_short) LIKE LOWER(?)', ["%{$query}%"])
    ->where('product.product_status', 1)  
    ->where('product.deleted', 0)  
    ->limit(10)  
    ->get();

            // Return the products as JSON
            return response()->json($products);

        }

        // If no query, return an empty response
        return response()->json([]);

    }
    public function searchProducts(Request $request)
    {
        $query = $request->input('q', '');
        $page_heading = "Handwi || " . $query;
        $categoryId = $request->input('categorysearch', 0);
    
        $queryBuilder = ProductModel::join('product_selected_attribute_list', 'product_selected_attribute_list.product_id', '=', 'product.id')
            ->join('product_category', 'product_category.product_id', '=', 'product.id')
            ->leftJoin('ratings', 'ratings.product_id', '=', 'product.id')
            ->select(
                'product.*',
                'product_selected_attribute_list.*',
                DB::raw('COALESCE(AVG(ratings.rating), 0) as average_rating'), // Average rating
                DB::raw('COUNT(ratings.id) as total_reviews') // Total reviews
            );
    
        // Case-insensitive product name search
        if (!empty($query)) {
            $queryBuilder->whereRaw('LOWER(product.product_name) LIKE ?', ['%' . strtolower($query) . '%']);
        }
    
        // Filter by category if category ID is greater than 0
        if ($categoryId > 0) {
            $queryBuilder->where('product_category.category_id', $categoryId);
        }
    
        // Finalize product query with status and grouping
        $products = $queryBuilder
            ->where('product.product_status', 1)
            ->where('product.deleted', 0)
            ->groupBy('product.id', 'product_selected_attribute_list.product_attribute_id')
            ->paginate(10);
    
        // Fetch categories
        $categories = Categories::where('deleted', 0)
            ->where('active', 1)
            ->orderBy('name', 'ASC')
            ->get();
    
        // Return the view with data
        return view('front_end.search_results', compact('products', 'categories', 'page_heading'));
    }
    
    public function getProductDetails(Request $request,$id,$variant_id="")
    {
        $product_id=$id;
        // Fetch product details using the model method
        $product = ProductModel::getProductInfofordetailpage($id);
       

        $sattr = $request->sattr;
            $sattr = json_decode($request->sattr, true);
            $return_status = true;
        if(isset($request->size) && isset($request->color)){
                $request->newattr_ids='2,1';
                $request->newattr_values=$request->color.','.$request->size;
                $attr_ids = explode(",",$request->newattr_ids);
                $attr_values = explode(",",$request->newattr_values);
                //$attr_values = array_reverse($attr_values);
                $ar = array();
                $myObj = new \stdClass();
                foreach($attr_ids as $k=>$id){
                    $myObj->$id=$attr_values[$k];
                }
                $sattr=(array)$myObj;
            }
            $id=$product_id;
            if (!$variant_id) {
                list($return_status, $product_attribute_id, $message) = ProductModel::get_product_attribute_id_from_attributes($sattr, 53);
                $variant_id = $product_attribute_id;
            }
            if(isset($request->color) && !$variant_id){
                $variant_id = $request->color;
            }
        
            //dd($variant_id);
        // Ensure product exists
        if (!$product) {
            abort(404, 'Product not found');
        }

        $product = $product->first();
        $stock = $product->stock_quantity;
        $video_url = $product->video;
        $video_thumbnail = $product->thumbnail;
        $addedToWishlist = 0;  

        // Check if user is logged in and product is in wishlist
        if (auth()->check()) {
            $addedToWishlist = Wishlist::where('product_id', $id)
                ->where('user_id', auth()->id()) 
                ->exists();  
        }
        
        list($status, $sproduct, $message) = ProductModel::getProductVariant($id, $variant_id);
        $sproduct = process_product_data_api($sproduct);
        $product_selected_attributes = ProductModel::getProductVariantAttributes($sproduct['product_variant_id']);

        $product_variations = [];
        $product_attributes = ProductModel::getProductAttributeVals([$sproduct['product_id']]);
        $selectedAttributes=ProductAttribute::where('product_id',$sproduct['product_id'])->get();
        $attributes=( $selectedAttributes)?$selectedAttributes:[];
        foreach ($product_attributes as $attr_row) {
                    if (array_key_exists($attr_row->attribute_id, $product_variations) === false) {
                        $product_variations[$attr_row->attribute_id] = [
                            'product_attribute_id' => $attr_row->product_attribute_id,
                            'attribute_id' => $attr_row->attribute_id,
                            'attribute_id' => $attr_row->attribute_id,
                            'attribute_type' => $attr_row->attribute_type,
                            'attribute_name' => $attr_row->attribute_name,
                            'attribute_values' => [],
                        ];
                        if ($attr_row->attribute_type === 'radio_button_group') {
                            $product_variations[$attr_row->attribute_id]['help_text_start'] = $attr_row->attribute_value_label;
                        }
                    }
                    if ($attr_row->attribute_type === 'radio_button_group') {
                        $product_variations[$attr_row->attribute_id]['help_text_end'] = $attr_row->attribute_value_label;
                    }
                    
                    if (array_key_exists($attr_row->attribute_values_id, $product_variations[$attr_row->attribute_id]['attribute_values']) === false) {
                        $is_selected = 0;
                        if (array_key_exists($attr_row->attribute_id, $product_selected_attributes) && ($product_selected_attributes[$attr_row->attribute_id] == $attr_row->attribute_values_id)) {
                            $is_selected = 1;
                        }
                        $product_variations[$attr_row->attribute_id]['attribute_values'][$attr_row->attribute_values_id] = [
                            'attribute_value_id' => $attr_row->attribute_values_id,
                            'attribute_value_name' => $attr_row->attribute_values,
                            'product_attribute_id' => $attr_row->product_attribute_id,
                            'attribute_name' => $attr_row->attribute_name,
                            'is_selected' => $is_selected,
                        ];

                        $sproduct['attribut_variations'][]=[
                            'attribute_value_id' => $attr_row->attribute_values_id,
                            'attribute_value_name' => $attr_row->attribute_values,
                            'product_attribute_id' => $attr_row->product_attribute_id,
                            'attribute_name' => $attr_row->attribute_name,
                            'is_selected' => $is_selected,
                        ];
                        if ($attr_row->attribute_value_in == 2) {
                            $product_variations[$attr_row->attribute_id]['attribute_values'][$attr_row->attribute_values_id]['attribute_value_color'] = $attr_row->attribute_color;
                        }
                        if ($attr_row->attribute_type === 'radio_image') {
                            $t_image = $attr_row->attribute_value_image;

                            $product_variations[$attr_row->attribute_id]['attribute_values'][$attr_row->attribute_values_id]['attribute_value_image'] = $t_image;
                        }
                    }
                }

                $sproduct['product_variations'] = [];
                if (!empty($product_variations)) {
                    $t_variations = array_values($product_variations);
                    foreach ($t_variations as $k => $v) {
                        $t_variations[$k]['attribute_values'] = array_values($t_variations[$k]['attribute_values']);
                    }
                    $sproduct["product_variations"] = convert_all_elements_to_string($t_variations);
                }
        
        // Fetch product features
        $features = Productfeatures::join('product_features', 'product_features.id', '=', 'product_product_feature.product_feature_id')
                    ->where('product_product_feature.product_id', $id)
                    ->select('*') 
                    ->get();

        // Set page heading
        $page_heading = "Handwi || " . $product->product_name;

        // Fetch vendor details
        $vendor = VendorModel::with('stores')->where(['role' => '3', 'verified' => '1', 'deleted' => '0'])
                    ->where('id', $product->product_vender_id)
                    ->first();
                    

        // Fetch next product
        $nextProduct = ProductModel::where('id', '>', $id)
                    ->where('product.deleted', 0)
                    ->orderBy('id', 'asc')
                    ->first();

        if ($nextProduct) {
            $nextProductInfo = ProductModel::getProductInfo($nextProduct->id)->first(); // Get product info of next
        } else {
            // If no next product, get the first product ordered by id ascending
            $next = ProductModel::orderBy('id', 'asc')->where('product.deleted', 0)->first();
            $nextProductInfo = ProductModel::getProductInfo($next->id)->first();
        }

        // Fetch the previous product (if exists)
        $prevProduct = ProductModel::where('id', '<', $id)
                    ->where('product.deleted', 0)
                    ->orderBy('id', 'desc')
                    ->first();

        if ($prevProduct) {
            $prevProductInfo = ProductModel::getProductInfo($prevProduct->id)->first(); // Get product info of previous
        } else {
            $prev = ProductModel::orderBy('id', 'desc')->first();
            // If no previous product, get the last product ordered by id descending
            $prevProductInfo = ProductModel::getProductInfo($prev->id)->first();
        }

        // Fetch category ids for related products
        $categoryIds = DB::table('product_category')->where('product_id', $id)->pluck('category_id')->toArray();

        // Fetch related products
        $relatedProducts = ProductModel::join('product_selected_attribute_list', 'product_selected_attribute_list.product_id', '=', 'product.id')
                        ->join('product_category', 'product_category.product_id', '=', 'product.id')
                        ->leftJoin('ratings', 'ratings.product_id', '=', 'product.id')
                        ->select('product.*', 'product_selected_attribute_list.*', 
                            DB::raw('COALESCE(AVG(ratings.rating), 0) as average_rating'), 
                            DB::raw('COUNT(ratings.id) as total_reviews'))
                        ->whereIn('product_category.category_id', $categoryIds)
                        ->where('product.id', '!=', $id)
                        ->where('product.product_status', 1)
                        ->where('product.deleted', 0)
                        ->groupBy('product.id', 'product_selected_attribute_list.product_attribute_id')
                        ->distinct()
                        ->limit(10);

        // Add wishlist info if user is logged in
        if (auth()->check() && auth()->user()->role == 2) {
            $relatedProducts->leftJoin('wishlists', function ($join) {
                $join->on('wishlists.product_id', '=', 'product.id')
                    ->where('wishlists.user_id', auth()->id());
            })
            ->addSelect(DB::raw('CASE WHEN wishlists.id IS NOT NULL THEN 1 ELSE 0 END AS added_to_wishlist'))
            ->groupBy('wishlists.id');  // Ensure 'wishlists.id' is in GROUP BY clause
        }

        $relatedProducts = $relatedProducts->get();

        // Fetch recently viewed products
        $recentlyviewedproducts = ProductModel::join('product_selected_attribute_list', 'product_selected_attribute_list.product_id', '=', 'product.id')
            ->leftJoin('ratings', 'ratings.product_id', '=', 'product.id')
            ->select('product.*', 'product_selected_attribute_list.*', 
                DB::raw('COALESCE(AVG(ratings.rating), 0) as average_rating'), 
                DB::raw('COUNT(ratings.id) as total_reviews'))
            ->where('product.trending', 1)
            ->where('product.product_status', 1)
            ->where('product.deleted', 0)
            ->groupBy('product.id', 'product_selected_attribute_list.product_attribute_id')
            ->limit(10);

        if (auth()->check() && auth()->user()->role == 2) {
            $recentlyviewedproducts->leftJoin('wishlists', function ($join) {
                $join->on('wishlists.product_id', '=', 'product.id')
                    ->where('wishlists.user_id', auth()->id());
            })
            ->addSelect(DB::raw('CASE WHEN wishlists.id IS NOT NULL THEN 1 ELSE 0 END AS added_to_wishlist'))
            ->groupBy('wishlists.id');
        }

        $recentlyviewedproducts = $recentlyviewedproducts->get();

        // Fetch reviews for the product
        $reviews = Rating::where('product_id', $id)->orderBy('created_at', 'desc')->get();
        if (auth()->check() ) {
            RecentlyViewedProduct::updateOrCreate(
                ['user_id' => Auth::id(), 'product_id' => $id],
                ['updated_at' => now()] // Refresh timestamp
            );
        }
       
        return view('front_end.product_details', compact('sproduct',
            'product','video_url', 'stock', 'vendor','video_thumbnail', 'id', 'reviews', 'addedToWishlist', 'page_heading', 
            'prevProductInfo', 'nextProductInfo', 'nextProduct', 'prevProduct', 'features', 
            'recentlyviewedproducts', 'relatedProducts'
        ));
    }


    public function submitReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'type' => 'required|integer|in:1,2,3',
            'product_id' => 'required_if:type,1', 
            'vendor_id' => 'required_if:type,2', 
            'service_id' => 'required_if:type,3', 
            'product_variant_id' => 'required_if:type,1|integer', 
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'The email may not be greater than 255 characters.',
            
            'rating.required' => 'The rating field is required.',
            'rating.integer' => 'The rating must be an integer.',
            'rating.min' => 'The rating must be at least 1.',
            'rating.max' => 'The rating may not be greater than 5.',
            
            'review.required' => 'The review title is required.',
            'review.string' => 'The review title must be a string.',
            'review.max' => 'The review title may not be greater than 255 characters.',
            
            'message.required' => 'The message field is required.',
            'message.string' => 'The message must be a string.',
            'message.max' => 'The message may not be greater than 1000 characters.',
            
            'type.required' => 'The review type is required.',
            'type.integer' => 'The review type must be an integer.',
            'type.in' => 'The review type must be one of the following values: 1, 2, or 3.',
            
            'product_id.required_if' => 'The product ID is required when the review type is product.',
            
            'vendor_id.required_if' => 'The vendor ID is required when the review type is vendor.',
            
            'service_id.required_if' => 'The service ID is required when the review type is service.',
            
            'product_variant_id.required_if' => 'The product variant ID is required when the review type is product.',
            'product_variant_id.integer' => 'The product variant ID must be an integer.',
        ]);
        
        
        

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 200);
        }

        $review = new Rating();
        $review->name = $request->name;
        $review->type = $request->type;
        $review->email = $request->email;
        $review->rating = $request->rating;
        $review->title = $request->review;
        $review->comment = $request->message;
        if (Auth::check()) {
            $review->user_id = Auth::id();
        } else {
            $review->user_id = 0;
        }

        if ($request->type == 1) { 
            $review->product_id = $request->product_id;
            $review->product_varient_id = $request->product_variant_id;
        } elseif ($request->type == 2) { 
            $review->vendor_id = $request->vendor_id;
        } elseif ($request->type == 3) { 
            $review->service_id = $request->service_id;
        }

        
        $review->save();

        // Return success response
        return response()->json([
            'status' => 1,
            'message' => 'Your review has been submitted successfully!'
        ], 200);
    }


    public function storeDetails (Request $request,$id) 
    {
        $store = Stores::where(['vendor_id' => $id])->orderBy('id', 'asc')->first();
        $vendorDetails = VendorDetailsModel::where('user_id', $id)->first();
        if (!$store) {
            abort(404, 'Store not found');
        }
        $page_heading = "Handwi || ".$store->store_name;
        $latest_products = ProductModel::join('product_selected_attribute_list', 'product_selected_attribute_list.product_id', '=', 'product.id')
        ->leftJoin('ratings', 'ratings.product_id', '=', 'product.id')
        ->select('product.*', 'product_selected_attribute_list.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as average_rating'), // Calculate average rating
        DB::raw('COUNT(ratings.id) as total_reviews'))
        ->where('product.new_arrival', 1)
        ->where('product.product_status', 1)
        ->where('product.deleted', 0)
        ->where('product.product_vender_id', $id)
        ->orderBy('product.created_at', 'desc')
        ->groupBy('product.id', 'product_selected_attribute_list.product_attribute_id');  
        
        if (auth()->check() && auth()->user()->role == 2) {
                        
            $latest_products->leftJoin('wishlists', function($join) {
                $join->on('wishlists.product_id', '=', 'product.id')
                     ->where('wishlists.user_id', auth()->id());
            })
            ->addSelect(\DB::raw('CASE WHEN wishlists.id IS NOT NULL THEN 1 ELSE 0 END AS added_to_wishlist'))->groupBy('wishlists.id');
        }   
        $latest_products = $latest_products->limit(10)->get();

        $all_products = ProductModel::leftJoin('ratings', 'ratings.product_id', '=', 'product.id')
                                        ->select(
                                            'product.*',
                                            DB::raw('COALESCE(AVG(ratings.rating), 0) as average_rating'),
                                            DB::raw('COUNT(ratings.id) as total_reviews')
                                        )
                                        ->where('product.product_vender_id', $id) // or $id if that's the vendor
                                        ->where('product.product_status', 1)
                                        ->where('product.deleted', 0)
                                        ->groupBy('product.id');

                                    if (auth()->check() && auth()->user()->role == 2) {
                                        $all_products->leftJoin('wishlists', function($join) {
                                            $join->on('wishlists.product_id', '=', 'product.id')
                                                ->where('wishlists.user_id', auth()->id());
                                        })
                                        ->addSelect(DB::raw('CASE WHEN wishlists.id IS NOT NULL THEN 1 ELSE 0 END AS added_to_wishlist'))
                                        ->groupBy('wishlists.id');
                                    }

                                    $all_products = $all_products->get();

         
        //  $categories = Categories::where('deleted', 0)
        //  ->where('active', 1)
        //  ->orderBy('parent_id', 'ASC')
        //  ->orderBy('name', 'ASC')
        //  ->get();
        $condition = [
            'product.deleted' => 0,
            'product.product_status' => 1,
            'product.product_vender_id' => $id,
        ];
        
        $categories = Categories::select('category.*')
            ->join('product_category', 'product_category.category_id', '=', 'category.id')
            ->join('product', 'product.id', '=', 'product_category.product_id')
            ->where($condition) // Apply product-related conditions
            ->where('category.active', 1) // Ensure the category is active
            ->where('category.deleted', 0) // Ensure the category is not deleted
            ->orderBy('category.parent_id', 'ASC') // Sort by parent_id
            ->orderBy('category.name', 'ASC') // Sort by name
            ->groupBy('category.id') // Avoid duplicate categories
            ->get();
            

         $offset = $request->get('offset', 0); // Default offset is 0
         $limit = $request->get('limit', 8);

         $productsQuery = ProductModel::join(
            'product_selected_attribute_list',
            'product_selected_attribute_list.product_id',
            '=',
            'product.id'
        )->leftJoin('ratings', 'ratings.product_id', '=', 'product.id')
        ->select('product.*', 'product_selected_attribute_list.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as average_rating'), // Calculate average rating
        DB::raw('COUNT(ratings.id) as total_reviews'))
        ->where('product.product_vender_id', $id)
        ->where('product.product_status', 1)
        ->where('product.deleted', 0)
        ->orderBy('product.created_at', 'desc')
        ->distinct();
        if (auth()->check() && auth()->user()->role == 2) {
                        
            $productsQuery->leftJoin('wishlists', function($join) {
                $join->on('wishlists.product_id', '=', 'product.id')
                     ->where('wishlists.user_id', auth()->id());
            })
            ->addSelect(\DB::raw('CASE WHEN wishlists.id IS NOT NULL THEN 1 ELSE 0 END AS added_to_wishlist'))->groupBy('wishlists.id');
        }  
        $productsQuery->groupBy('product.id', 'product_selected_attribute_list.product_attribute_id');

        $totalProducts = $productsQuery->count();


        $products = $productsQuery->offset($offset)->limit($limit)->get();
        
        if ($request->ajax()) {
            return response()->json([
                'products' => view('front_end.partials_store_product_grid', compact('products'))->render(),
                'totalProducts' => $totalProducts,
                'loadedProducts' => $offset + $products->count(),
            ]);
        }
        
         $is_followed = 0;
        if (auth()->check()) {
            $user_id = auth()->id();
            $vendor_id = $store->vendor_id;
            
            // Check if the user has already followed the vendor
            $is_followed = VendorFollower::where('vendor_id', $vendor_id)->where('user_id', $user_id)->exists();
        }
        $reasons = ReportReason::all();

        $all_products = ProductModel::join('product_selected_attribute_list', 'product_selected_attribute_list.product_id', '=', 'product.id')
            ->leftJoin('ratings', 'ratings.product_id', '=', 'product.id')
            ->select(
                'product.*',
                'product_selected_attribute_list.*',
                DB::raw('COALESCE(AVG(ratings.rating), 0) as average_rating'),
                DB::raw('COUNT(ratings.id) as total_reviews')
            )
            ->where('product.product_vender_id', $id)
            ->where('product.product_status', 1)
            ->where('product.deleted', 0)
            ->groupBy('product.id', 'product_selected_attribute_list.product_attribute_id');

        if (auth()->check() && auth()->user()->role == 2) {
            $all_products->leftJoin('wishlists', function($join) {
                $join->on('wishlists.product_id', '=', 'product.id')
                    ->where('wishlists.user_id', auth()->id());
            })
            ->addSelect(DB::raw('CASE WHEN wishlists.id IS NOT NULL THEN 1 ELSE 0 END AS added_to_wishlist'))->groupBy('wishlists.id');
        }

        $all_products = $all_products->get();


        $most_selling_products = ProductModel::join('product_selected_attribute_list', 'product_selected_attribute_list.product_id', '=', 'product.id')
            ->join('order_products', 'order_products.product_id', '=', 'product.id')
            ->leftJoin('ratings', 'ratings.product_id', '=', 'product.id')
            ->select(
                'product.*',
                'product_selected_attribute_list.*',
                DB::raw('SUM(order_products.quantity) as total_sold'),
                DB::raw('COALESCE(AVG(ratings.rating), 0) as average_rating'),
                DB::raw('COUNT(ratings.id) as total_reviews')
            )
            ->where('product.product_vender_id', $id)
            ->where('product.product_status', 1)
            ->where('product.deleted', 0)
            ->groupBy('product.id', 'product_selected_attribute_list.product_attribute_id')
            ->orderByDesc('total_sold');

        if (auth()->check() && auth()->user()->role == 2) {
            $most_selling_products->leftJoin('wishlists', function($join) {
                $join->on('wishlists.product_id', '=', 'product.id')
                    ->where('wishlists.user_id', auth()->id());
            })
            ->addSelect(DB::raw('CASE WHEN wishlists.id IS NOT NULL THEN 1 ELSE 0 END AS added_to_wishlist'))->groupBy('wishlists.id');
        }

        $most_selling_products = $most_selling_products->limit(30)->get();



        
        
               
       
        return view('front_end.store_details', compact('vendorDetails','page_heading','reasons','all_products','most_selling_products','latest_products','categories','store','products','totalProducts','is_followed'));
    }



   

    public function giftCategories(Request $request)
    {
        // Fetch the gift category
        $gift = MainCategories::where(['deleted' => 0, 'active' => 1, 'id' => 1])->orderBy('id', 'asc')->first();
        $page_heading = "Handwi || " . $gift->name;
    
        // Fetch categories
        $categories = Categories::where('deleted', 0)
            ->where('active', 1)
            ->where('is_gift', 1)
            ->orderBy('parent_id', 'ASC')
            ->orderBy('name', 'ASC')
            ->get();
    
        // Fetch the first category if available
        $firstCategory = $categories->first();
    
        // Default values for products and total count
        $products = collect();
        $totalProducts = 0;
    
        if ($firstCategory) {
            $productsQuery = ProductModel::join(
                    'product_selected_attribute_list',
                    'product_selected_attribute_list.product_id',
                    '=',
                    'product.id'
                )
                ->join(
                    'product_category',
                    'product_category.product_id',
                    '=',
                    'product.id'
                )
                ->leftJoin('ratings', 'ratings.product_id', '=', 'product.id')
                ->leftJoin('wishlists', function($join) {
                    $join->on('wishlists.product_id', '=', 'product.id')
                        ->where('wishlists.user_id', auth()->id());
                })
                ->select(
                    'product.*', 
                    'product_selected_attribute_list.*',
                    DB::raw('COALESCE(AVG(ratings.rating), 0) as average_rating'),
                    DB::raw('COUNT(ratings.id) as total_reviews'),
                    DB::raw('CASE WHEN COUNT(wishlists.id) > 0 THEN 1 ELSE 0 END AS added_to_wishlist') // Updated the CASE statement with COUNT
                )
                ->where('product.product_status', 1)
                ->where('product.deleted', 0)
                ->where('product_category.category_id', $firstCategory->id);
    
            if (auth()->check() && auth()->user()->role == 2) {
                // If user is authenticated and has role 2, include wishlist information
                $productsQuery->addSelect(DB::raw('CASE WHEN COUNT(wishlists.id) > 0 THEN 1 ELSE 0 END AS added_to_wishlist'));
            }
    
            // Group by necessary columns
            $productsQuery->groupBy('product.id', 'product_selected_attribute_list.product_attribute_id');
    
            // Get total product count for the category
            $totalProducts = $productsQuery->count();
    
            // Apply limit for "Load More"
            $products = $productsQuery->offset($request->get('offset', 0))
                ->limit(6)
                ->get();
        }
    
        // Handle AJAX request
        if ($request->ajax()) {
            return response()->json([
                'products' => view('front_end.partial_products', compact('products'))->render(),
                'totalProducts' => $totalProducts,
            ]);
        }
    
        return view('front_end.gifts', compact('page_heading', 'categories', 'gift', 'products', 'totalProducts'));
    }
    
    public function handmadeCategories(Request $request)
    {
        // Fetch the handmade category
        $handmade = MainCategories::where(['deleted' => 0, 'active' => 1, 'id' => 2])->orderBy('id', 'asc')->first();
        $page_heading = "Handwi || " . $handmade->name;
    
        // Fetch categories
        $categories = Categories::where('deleted', 0)
            ->where('active', 1)
            ->where('is_handmade', 1)
            ->orderBy('parent_id', 'ASC')
            ->orderBy('name', 'ASC')
            ->get();
    
        // Fetch the first category if available
        $firstCategory = $categories->first();
    
        // Default values for products and total count
        $products = collect();
        $totalProducts = 0;
    
        if ($firstCategory) {
            $productsQuery = ProductModel::join(
                    'product_selected_attribute_list',
                    'product_selected_attribute_list.product_id',
                    '=',
                    'product.id'
                )
                ->join(
                    'product_category',
                    'product_category.product_id',
                    '=',
                    'product.id'
                )
                ->leftJoin('ratings', 'ratings.product_id', '=', 'product.id')
                ->leftJoin('wishlists', function($join) {
                    $join->on('wishlists.product_id', '=', 'product.id')
                        ->where('wishlists.user_id', auth()->id());
                })
                ->select(
                    'product.*',
                    'product_selected_attribute_list.*',
                    DB::raw('COALESCE(AVG(ratings.rating), 0) as average_rating'), // Average rating
                    DB::raw('COUNT(ratings.id) as total_reviews'),
                    DB::raw('CASE WHEN COUNT(wishlists.id) > 0 THEN 1 ELSE 0 END AS added_to_wishlist') // Updated to COUNT(wishlists.id)
                )
                ->where('product.product_status', 1)
                ->where('product.deleted', 0)
                ->where('product_category.category_id', $firstCategory->id);
    
            if (auth()->check() && auth()->user()->role == 2) {
                // If user is authenticated and has role 2, include wishlist information
                $productsQuery->addSelect(DB::raw('CASE WHEN COUNT(wishlists.id) > 0 THEN 1 ELSE 0 END AS added_to_wishlist'));
            }
    
            // Group by necessary columns, excluding wishlists.id
            $productsQuery->groupBy('product.id', 'product_selected_attribute_list.product_attribute_id');
    
            // Get total product count for the category
            $totalProducts = $productsQuery->count();
    
            // Apply limit for "Load More"
            $products = $productsQuery->offset($request->get('offset', 0)) // Default offset = 0
                ->limit(6)
                ->get();
        }
    
        // Handle AJAX request
        if ($request->ajax()) {
            return response()->json([
                'products' => view('front_end.partial_products', compact('products'))->render(),
                'totalProducts' => $totalProducts,
            ]);
        }

        $vendors = VendorModel::with(['stores', 'vendordata'])->where('deleted', 0)
                    ->where('verified', 1)
                    ->where('role', 3) // Assuming role 3 is vendor
                    ->orderBy('id', 'desc')
                    ->get();
                    


    
        return view('front_end.handmade', compact('page_heading','vendors', 'categories', 'handmade', 'products', 'totalProducts'));
    }
    
    public function services(Request $request)
    {
        $workshop = MainCategories::where(['deleted' => 0, 'active' => 1, 'id' => 3])->orderBy('id', 'asc')->first();
        $page_heading = "Handwi || ".$workshop->name;
        $categories = ServiceType::where(['deleted' => 0])->get(); // Or your model name
        $cities = Cities::where(['deleted' => 0, 'active' => 1])->get();

       

            $userLatitude = $request->input('latitude');
            $userLongitude = $request->input('longitude');
            $sortBy = $request->input('SortBy');
           
            $categoryId = $request->input('category_id');
            $cityId = $request->input('city_id');
            

            $servicesQuery = Service::where(['service.active' => 1, 'service.deleted' => 0])
                ->whereDate('service.to_date', '>=', now()->toDateString())
                ->with('features');
                if (!empty($categoryId)) {
                
                    $servicesQuery->where('service.service_price_type', $categoryId);
                }
            
                // Filter by city_id
                if (!empty($cityId)) {
                    $servicesQuery->where('service.city_id', $cityId);
                }

            if (($sortBy === 'nearest' || $sortBy === 'farthest') && !empty($userLatitude) && !empty($userLongitude)) {
                $distanceSelect = DB::raw("(
                    6371 * acos(
                        cos(radians($userLatitude)) *
                        cos(radians(CAST(service.latitude AS double precision))) *
                        cos(radians(CAST(service.longitude AS double precision)) - radians($userLongitude)) +
                        sin(radians($userLatitude)) *
                        sin(radians(CAST(service.latitude AS double precision)))
                    )
                ) AS distance");

                $servicesQuery->select('service.*', $distanceSelect)
                    ->orderBy('distance', $sortBy === 'nearest' ? 'asc' : 'desc');
            } elseif ($sortBy === 'price-ascending') {
                $servicesQuery->orderBy('service_price', 'asc');
            } elseif ($sortBy === 'price-descending') {
                $servicesQuery->orderBy('service_price', 'desc');
            } else {
                $servicesQuery->orderBy('service.id', 'desc'); // Default sort
            }
           

            $totalServices = $servicesQuery->count();

            $services = $servicesQuery
                ->offset($request->get('offset', 0))
                ->limit(6)
                ->get();


        // Handle AJAX request for services
        if ($request->ajax()) {
            return response()->json([
                'services' => view('front_end.partial_services', compact('services'))->render(),
                'totalServices' => $totalServices,
            ]);
        }


        return view('front_end.services', compact('page_heading','categories','workshop','cities', 'services', 'totalServices','categoryId','cityId'));
    }
    public function workshopDetail($id, Request $request)
    {
        // Fetch workshop details using the Service model with its relationships
        $workshop = Service::with(['features', 'vendor', 'building_type'])->where(['service.id' => $id, 'service.deleted' => 0, 'service.active' => 1])->first();

        
        if (!$workshop) {
            abort(404); // If no workshop is found, return 404
        }
        if(!empty($workshop->vendor_id)){
            $vendor = VendorModel::with('stores')->where(['role'=>'3','verified'=>'1','deleted'=>'0','deleted'=>'0'])->where('id',$workshop->vendor_id);
            $vendor = $vendor->first();
        }else{
            $vendor = [];
        }
    
        // Set page heading dynamically
        $page_heading = "Workshop Details || " . $workshop->name;
        $additional_images = ServiceImage::where('service_id', $id)->get();
        $other_services = Service::with(['features', 'vendor', 'building_type'])->where(['service.deleted' => 0, 'service.active' => 1])->where('id', '!=', $id) ->take(10) ->get();
        $reviews = Rating::where('service_id', $id)->orderBy('created_at', 'desc')->get();
        
       
       
        // Return the workshop details view with required data
        return view('front_end.service_detail', compact('page_heading','reviews','vendor','id', 'workshop','additional_images','other_services'));
    }
    



}
