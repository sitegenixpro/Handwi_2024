@extends('front_end.template.layout')
@section('content')
@if(!empty($handmade->banner_image))
<style>
    
    .shop-listview-drawer .collection-hero__image, 
    .shop-sub-collections .collection-hero__image, 
    .shop-top-filter .collection-hero__image { 
        background-image: url('{{ asset($handmade->banner_image) }}'); 
    }

    #load-more {

align-items: center;
gap: 1px; /* Adjust the value as needed */
}

#loaded-products-count, #total-products-count {
margin-left: 2px; /* Optional: Add space between the count elements */
}
    
</style>
@endif    
<div id="page-content">
                <!-- Collection Banner -->
                <div class="collection-header">
                    <div class="collection-hero medium mb-4 mb-lg-5">
                        <div class="collection-hero__image blur-up lazyload"></div>
                        <div class="collection-hero__title-wrapper container">
                            <h1 class="collection-hero__title medium">{{$handmade->name}}</h1>
                            <div class="breadcrumbs text-uppercase mt-1 mt-lg-2"><a href="{{ route('home') }}" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">{{$handmade->name}}</span></div>
                        </div>
                    </div>
                </div>
                <!-- End Collection Banner -->

                <!--Container-->
                <div class="container">
                    <!--Category Grid-->
                    <!-- <div class="collection-slider-4items grid-categorys sub-collection grid-mr-15 d-none">
                       @foreach($categories as $cat)
                        <div class="mw-100 category-grid-item cl-item">
                            <div class="category-item zoomscal-hov">
                                <a href="{{ route('categoryproducts', ['id' => $cat->id]) }}" class="category-link">
                                    <div class="zoom-scal"><img class="blur-up lazyload" data-src="{{asset($cat->image)}}" src="{{asset($cat->image)}}" alt="collection" title="" /></div>
                                    <div class="details">
                                        <div class="inner">
                                            <h3 class="category-title">{{$cat->name}}</h3>
                                            <span class="counts">{{ \App\Models\ProductModel::join('product_selected_attribute_list', 'product_selected_attribute_list.product_id', '=', 'product.id')->join('product_category', 'product_category.product_id', '=', 'product.id')->where('product_category.category_id', $cat->id)->distinct()->count() }}  Products</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div> -->
                    <div class="row">
                        @foreach($vendors as $vendor)
                            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 mb-4">
                                <div class="vendor-card text-center border rounded h-100 overflow-hidden">
                                    @php
                                        $store = $vendor->stores->first();
                                        $storeLogo = $store && file_exists(public_path('storage/' . $store->logo))
                                            ? asset('storage/' . $store->logo)
                                            : asset('front_end/assets/images/logo-placeholder.jpg');
                                        $storeName = $store && $store->store_name ? $store->store_name : 'N/A';
                                    @endphp

                                    <a href="{{ route('storedetails', ['id' => $vendor->id]) }}">
                                        <img src="{{ $storeLogo }}" alt="{{ $storeName }}" class="log-are img-fluid w-100" style="object-position: center; aspect-ratio: 3 / 2; object-fit: cover; background-color: #e1e1e1;">
                                        <h6 class="mb-0 p-2 ">{{ $storeName }}</h6>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!--End Category Grid-->
                </div>
                <!--End Container-->

                <!--Most Popular-->
                <section class="section product-items pb-0">
                    <div class="container">
                        <div class="row">
                            <div class="section-header col-12">
                                <h2 class="text-transform-none">Most Popular</h2>
                            </div>
                        </div>

                        <!--Product List-->
                        <div class="product-load-more">
                            <!--Product Grid-->
                            <div class="grid-products grid--view-items">
                                <div class="row" id="productgrid">
                                    @foreach($products as $product)
                                    <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2 item">
                                        <!--Start Product Image-->
                                        <div class="product-image">
                                                @php
                                                    $images = explode(',', $product->image); 
                                                    $firstImage = $images[0]; 
                                                @endphp
                                            <!--Start Product Image-->
                                            <a href="{{ route('productdetails', ['id' => $product->id]) }}" class="product-img">
                                                <!--Image-->
                                                <img class="primary blur-up lazyload" data-src="{{ asset('uploads/products/'.$firstImage) }}" src="{{ asset('uploads/products/'.$firstImage) }}" alt="image" title="" width="800" height="960">
                                                <!--End image-->
                                                <!--Hover image-->
                                                <img class="hover blur-up lazyload" data-src="{{ asset('uploads/products/'.$firstImage) }}" src="{{ asset('uploads/products/'.$firstImage) }}" alt="image" title="" width="800" height="960">
                                                <!--End hover image-->
                                            </a>
                                            <!--end product image-->

                                            <!--Product Button-->
                                            <div class="button-set-top position-absolute style1">
                                                <!--Wishlist Button-->
                                                @php
                                                $userLoggedIn = auth()->check(); 
                                                $userRole = $userLoggedIn ? auth()->user()->role : null;
                                                $loginUrl = route('login'); 
                                                @endphp
                                                @if (isset($product->added_to_wishlist) && $product->added_to_wishlist == 1)
                                                    
                                                    <a class="btn-icon wishlist add-to-wishlist rounded" href="javascript:void(0);">
                                                        <i class="icon an an-heart"></i>
                                                        <span class="tooltip-label">Available in Wishlist</span>
                                                    </a>
                                                @else
                                                <a class="btn-icon wishlist add-to-wishlist rounded"
                                                    href="<?= $userLoggedIn && $userRole == 2 ? 'javascript:void(0)' : $loginUrl; ?>"
                                                    <?= $userLoggedIn && $userRole == 2 ? 'onclick="addToWishlist(this, ' . $product->id . ')"' : ''; ?>>
                                                        <i class="icon an an-heart-l"></i>
                                                        <span class="tooltip-label">Add To Wishlist</span>
                                                </a>
                                                @endif
                                               
                                            </div>
                                            <div class="button-set-bottom position-absolute style1">
                                                <!--Cart Button-->
                                                <a class="btn-icon btn btn-addto-cart pro-addtocart-popup rounded" href="javascript:void(0);" data-product-id="{{$product->id}}">
                                                  <i class="icon an an-cart-l"></i> <span>Add To Cart</span>
                                                 </a>
                                                <!--End Cart Button-->
                                            </div>
                                            <!--End Product Button-->
                                        </div>
                                        <!--End Product Image-->
                                        <!--Start Product Details-->
                                        <div class="product-details text-center">
                                            <!--Product Name-->
                                            <div class="product-name text-uppercase">
                                               <a href="{{ route('productdetails', ['id' => $product->id]) }}">{{$product->product_name}} </a>
                                            </div>
                                            <!--End Product Name-->
                                            <!--Product Price-->
                                            <div class="product-price">
                                            @if($product->regular_price)
                                                @if($product->sale_price && $product->sale_price < $product->regular_price)
                                                    <div class="sale-price">
                                                        Sale Price: AED {{ $product->sale_price ?? 'N/A' }}
                                                    </div>
                                                    <div class="regular-price">
                                                        Regular Price: <span class="old-price">AED {{ $product->regular_price }}</span>
                                                    </div>
                                                @else
                                                    <div class="regular-price">
                                                        Price: AED {{ $product->regular_price }}
                                                    </div>
                                                @endif
                                            @else
                                                <div class="regular-price">Price: Not available</div>
                                            @endif

                                            </div>
                                            <!--End Product Price-->
                                            <!--Product Review-->
                                            <div class="product-review">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($product->average_rating >= $i)
                                                        <i class="an an-star"></i> 
                                                    @elseif($product->average_rating >= $i - 0.5)
                                                        <i class="an an-star-half"></i> 
                                                    @else
                                                        <i class="an an-star-o"></i> 
                                                    @endif
                                                @endfor
                                            </div>
                                            <!--End Product Review-->
                                            <!--Color Variant -->
                                            <!-- <ul class="swatches">
                                                <li class="swatch small rounded navy"><span class="tooltip-label">Navy</span></li>
                                                <li class="swatch small rounded green"><span class="tooltip-label">Green</span></li>
                                                <li class="swatch small rounded gray"><span class="tooltip-label">Gray</span></li>
                                                <li class="swatch small rounded aqua"><span class="tooltip-label">Aqua</span></li>
                                                <li class="swatch small rounded orange"><span class="tooltip-label">Orange</span></li>
                                            </ul> -->
                                            <!--End Variant-->
                                        </div>
                                        <!--End Product Details-->
                                    </div>
                                    @endforeach
                                    
                                                                          
                                   
                                                                         
                                    
                                </div>
                            </div>
                            <!--End Product Grid-->

                            <!--Load More Button-->
                            <div class="infinitpaginOuter">
                                <div class="infinitpagin">	
                                    @if($products->count() < $totalProducts)
                                        <a href="#" class="btn rounded " id="load-more" data-offset="6">Load More <span id="loaded-products-count">{{ $products->count() }}</span> / <span id="total-products-count">{{ $totalProducts }}</span></a>
                                    @endif
                                    
                                </div>
                            </div>
                            <!--End Load More Button-->
                        </div>
                        <!--End Product List-->
                    </div>
                </section>
                <!--End Most Popular-->
            </div>
@endsection   