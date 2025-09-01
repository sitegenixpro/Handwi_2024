@extends('front_end.template.layout')
@section('content')

<style>
    .blur_img{
        max-height: 350px;
        min-height: 350px;
        object-fit: cover;
    }
</style>
 <!--Body Container-->
 <div id="page-content">
                <!--Home Slider-->
                <section class="slideshow slideshow-wrapper">
                    <div class="home-slideshow">
                        <!-- <div class="slide">
                            <div class="blur-up lazyload">
                                <img class="blur-up lazyload desktop-hide" data-src="assets/images/slideshow/demo1-banner1.jpg" src="assets/images/slideshow/demo1-banner1.jpg" alt="HIGH CONVERTING" title="HIGH CONVERTING" width="2000" height="840" />
                                <img class="blur-up lazyload mobile-hide" data-src="assets/images/slideshow/demo1-banner1-m.jpg" src="assets/images/slideshow/demo1-banner1-m.jpg" alt="HIGH CONVERTING" title="HIGH CONVERTING" width="705" height="780" />
                                <div class="container">
                                    <div class="slideshow-content slideshow-overlay bottom-middle d-flex justify-content-center align-items-center">
                                        <div class="slideshow-content-in text-center">
                                            <div class="wrap-caption animation style2 whiteText px-2">
                                                <p class="ss-small-title fs-5 mb-2">Simple, Clean</p>
                                                <h1 class="h1 mega-title ss-mega-title fs-1">HIGH CONVERTING</h1>
                                                <span class="mega-subtitle fs-6 ss-sub-title">Creative, Flexible and High Performance Html Template!</span>
                                                <div class="ss-btnWrap">
                                                    <a class="btn btn-lg rounded btn-primary" href="#">Shop Women</a>
                                                    <a class="btn btn-lg rounded btn-primary" href="#">Shop Men</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        @foreach($banners as $item)
                        <div class="slide">
                            <div class="blur-up lazyload">
                                <img class="blur-up lazyload desktop-hide" data-src="{{ $item->banner_image }}" src="{{ $item->banner_image }}" alt="MAKING BRAND VISIBLE" title="MAKING BRAND VISIBLE" width="2000" height="840" />
                                <img class="blur-up lazyload mobile-hide" data-src="{{ $item->banner_image }}" src="{{ $item->banner_image }}" alt="MAKING BRAND VISIBLE" title="MAKING BRAND VISIBLE" width="705" height="780" />
                                <div class="slideshow-content slideshow-overlay bottom-middle container d-flex justify-content-center align-items-center">
                                    <div class="slideshow-content-in text-center">
                                        <div class="wrap-caption animation style2 whiteText px-2">
                                            <h2 class="mega-title ss-mega-title fs-1"> {!! app()->getLocale() === 'ar' ? $item->name_ar : $item->name !!}</h2>
                                            <span class="mega-subtitle ss-sub-title fs-6"> {!! app()->getLocale() === 'ar' ? $item->description_ar : $item->description !!}</span>
                                            <div class="ss-btnWrap">
                                                <a class="btn btn-lg rounded btn-primary" href="{{ $item->button_link   }}">Shop Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
                <!--End Home Slider-->

                <!--Banner Masonary-->
                <section class="collection-banners style1 d-none d-md-block d-lg-block">
                    <div class="container">
                        <div class="grid-masonary banner-grid grid-mr-20">
                            <div class="grid-sizer col-md-4 col-lg-4"></div>
                            <div class="row">
                                @foreach($maincategories as $cat)
                                <div class="col-12 col-sm-6 col-md-4 col-lg-4 banner-item cl-item">
                                    <div class="collection-grid-item">
                                        <a href="{{ $cat->button_link }}">
                                            <div class="img">
                                                <img class="blur-up lazyload blur_img" data-src="{{ $cat->image }}" src="{{ $cat->image }}" alt="SUMMER" title="SUMMER" width="450" height="450" />
                                            </div>
                                            <div class="details center white-text">
                                                <div class="inner">
                                                    <h3 class="title fs-3 mb-1"> {!! app()->getLocale() === 'ar' ? $cat->name_ar : $cat->name !!}</h3>
                                                    <p> {!! app()->getLocale() === 'ar' ? $cat->sub_title_ar : $cat->sub_title !!}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                                
                            </div>
                        </div>
                    </div>
                </section>
                <!--End Banner Masonary-->
               
                @if(Auth::check()  && isset($recentlyviewedproducts) && count($recentlyviewedproducts) > 0)
                <section class="section product-slider">
                    <div class="container">
                        <div class="row">
                            <div class="section-header text-uppercase col-12">
                               
                                <h2>Recently Viewed </h2>
                                <p>Here are the products you’ve recently looked at</p>
                            </div>
                        </div>
                        <div class="productSlider grid-products">
                            @foreach($recentlyviewedproducts as $product)
                            <div class="item">
                                <div class="product-image">
                                    <a href="{{ route('productdetails', ['id' => $product->id]) }}" class="product-img">
                                        @php
                                            $images = explode(',', $product->image); 
                                            $firstImage = get_uploaded_image_url($images[0],'product_image_upload_dir');
                                        @endphp
                                        <img class="primary blur-up lazyload" data-src="{{ $firstImage }}" src="{{ $firstImage }}" alt="image" width="800" height="960">
                                        <img class="hover blur-up lazyload" data-src="{{ $firstImage }}" src="{{ $firstImage }}" alt="image" width="800" height="960">
                                    </a>
                                    <div class="button-set-top position-absolute style1">
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
                                            href="{{ $userLoggedIn && $userRole == 2 ? 'javascript:void(0)' : $loginUrl }}"
                                            {!! $userLoggedIn && $userRole == 2 ? 'onclick="addToWishlist(this, ' . $product->id . ')"' : '' !!}>
                                                <i class="icon an an-heart-l"></i>
                                                <span class="tooltip-label">Add To Wishlist</span>
                                            </a>
                                        @endif
                                    </div>
                                    <div class="button-set-bottom position-absolute style1">
                                        <a class="btn-icon btn btn-addto-cart pro-addtocart-popup rounded" href="javascript:void(0);" data-product-id="{{ $product->id }}">
                                            <i class="icon an an-cart-l"></i> <span>Add To Cart</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="product-details text-center">
                                    <div class="product-name text-uppercase">
                                        <a href="{{ route('productdetails', ['id' => $product->id]) }}">{!! app()->getLocale() === 'ar' ? $product->product_name_arabic : $product->product_name !!}</a>
                                    </div>
                                    <div class="product-price">
                                        @if($product->regular_price)
                                            @if($product->sale_price && $product->sale_price < $product->regular_price)
                                                <div class="sale-price">
                                                    Sale Price: AED {{ $product->sale_price }}
                                                </div>
                                                <div class="regular-price">
                                                    Regular Price: <span class="old-price"> AED {{ $product->regular_price }}</span>
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
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>
                @endif
                <section class="section product-slider ">
                    <div class="container">
                        <div class="row">
                            <div class="section-header text-uppercase col-12">
                                  @php
                                    
                                  $latestTitle = \App\Models\LandingPageSetting::where('meta_key', 'latest_title')->first();
                                  $latestSubTitle = \App\Models\LandingPageSetting::where('meta_key', 'latest_subtitle')->first();

                                  $latestTitle = $latestTitle && $latestTitle->meta_value  ? $latestTitle->meta_value    : '';
                                  $latestSubTitle = $latestSubTitle && $latestSubTitle->meta_value   ? $latestSubTitle->meta_value   : '';
                                    @endphp 
                                <h2>{!! $latestTitle !!}</h2>
                                <p>{!! $latestSubTitle !!}</p>
                            </div>
                        </div>
                        <div class="productSlider grid-products">

                            @foreach($latest_products as $product)
                            <div class="item">
                                <!--Start Product Image-->
                                <div class="product-image">
                                        
                                    <a href="{{ route('productdetails', ['id' => $product->id]) }}" class="product-img">
                                        @php
                                            $images = explode(',', $product->image); 
                                            $firstImage = get_uploaded_image_url($images[0],'product_image_upload_dir'); 
                                        @endphp
                                        <img class="primary blur-up lazyload" data-src="{{$firstImage }}" src="{{$firstImage }}" alt="image" title="" width="800" height="960">
                                       
                                        <img class="hover blur-up lazyload" data-src="{{$firstImage }}" src="{{$firstImage }}" alt="image" title="" width="800" height="960">
                                        <!--End hover image-->
                                    </a>
                                    <!--end product image-->

                                    <!--Product Button-->
                                    <div class="button-set-top position-absolute style1">
                                        <!--Wishlist Button-->
                                        <!-- <a class="btn-icon wishlist add-to-wishlist rounded" href="#">
                                            <i class="icon an an-heart-l"></i>
                                            <span class="tooltip-label">Add To Wishlist</span>
                                        </a> -->
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
                               
                                <div class="product-details text-center">
                                    
                                    <div class="product-name text-uppercase">
                                        <a href="{{ route('productdetails', ['id' => $product->id]) }}">{!! app()->getLocale() === 'ar' ? $product->product_name_arabic : $product->product_name !!} </a>
                                    </div>
                                   
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
                                   
                                </div>
                                
                            </div>
                            @endforeach
                            
                        </div>
                    </div>
                </section>
                @if(isset($following_products) && count($following_products) > 0)
                <section class="section product-slider">
                    <div class="container">
                        <div class="row">
                            <div class="section-header text-uppercase col-12">
                                <h2>For You</h2>
                                <p>Explore new arrivals and top-rated items from your favorite vendors.</p>
                            </div>
                        </div>
                        <div class="productSlider grid-products">
                            @foreach($following_products as $product)
                            <div class="item">
                                <div class="product-image">
                                    @php
                                        $images = explode(',', $product->image);
                                        $firstImage = get_uploaded_image_url($images[0], 'product_image_upload_dir');
                                    @endphp
                                    <a href="{{ route('productdetails', ['id' => $product->id]) }}" class="product-img">
                                        <img class="primary blur-up lazyload" data-src="{{ $firstImage }}" src="{{ $firstImage }}" alt="image" width="800" height="960">
                                        <img class="hover blur-up lazyload" data-src="{{ $firstImage }}" src="{{ $firstImage }}" alt="image" width="800" height="960">
                                    </a>

                                    <div class="button-set-top position-absolute style1">
                                        @if($product->added_to_wishlist == 1)
                                            <a class="btn-icon wishlist add-to-wishlist rounded" href="javascript:void(0);">
                                                <i class="icon an an-heart"></i>
                                                <span class="tooltip-label">Available in Wishlist</span>
                                            </a>
                                        @else
                                            <a class="btn-icon wishlist add-to-wishlist rounded"
                                            href="{{ auth()->check() ? 'javascript:void(0)' : route('login') }}"
                                            {!! auth()->check() ? 'onclick=addToWishlist(this,' . $product->id . ')' : '' !!}>
                                                <i class="icon an an-heart-l"></i>
                                                <span class="tooltip-label">Add To Wishlist</span>
                                            </a>
                                        @endif
                                    </div>

                                    <div class="button-set-bottom position-absolute style1">
                                        <a class="btn-icon btn btn-addto-cart pro-addtocart-popup rounded" href="javascript:void(0);" data-product-id="{{ $product->id }}">
                                            <i class="icon an an-cart-l"></i> <span>Add To Cart</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="product-details text-center">
                                    <div class="product-name text-uppercase">
                                        <a href="{{ route('productdetails', ['id' => $product->id]) }}">{!! app()->getLocale() === 'ar' ? $product->product_name_arabic : $product->product_name !!}</a>
                                    </div>

                                    <div class="product-price">
                                        @if($product->sale_price && $product->sale_price < $product->regular_price)
                                            <div class="sale-price">Sale Price: AED {{ $product->sale_price }}</div>
                                            <div class="regular-price">
                                                Regular Price: <span class="old-price">AED {{ $product->regular_price }}</span>
                                            </div>
                                        @else
                                            <div class="regular-price">Price: AED {{ $product->regular_price }}</div>
                                        @endif
                                    </div>

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
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>
                @endif

                  <!--Spring Summer Product Slider-->
                 
                <!--End Spring Summer Product Slider-->
               

              
                <section class="section product-slider">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 section-header style1">
                                  @php
                                  $bestSellerTitle = \App\Models\LandingPageSetting::where('meta_key', 'best_seller_title')->first();
                                  $bestSellerSubTitle = \App\Models\LandingPageSetting::where('meta_key', 'best_seller_subtitle')->first();
                                  $bestSellerTitleText = $bestSellerTitle && $bestSellerTitle->meta_value  ? $bestSellerTitle->meta_value   : '';
                                  $bestSellerSubTitleText = $bestSellerSubTitle && $bestSellerSubTitle->meta_value ? $bestSellerSubTitle->meta_value  : '';
                                    
                                  @endphp 
                                <div class="section-header-left">
                                    <h2>{!! $bestSellerTitleText !!}</h2>
                                    <p>{!! $bestSellerSubTitleText !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid-products">
                            
                            <div class="row">
                                  @foreach($products as $product)
                                <div class="item col-lg-3 col-md-4 col-6">
                                    <!--Start Product Image-->
                                    <div class="product-image">
                                        <!--Start Product Image-->
                                        <a href="{{ route('productdetails', ['id' => $product->id]) }}" class="product-img">
                                            @php
                                                $images = explode(',', $product->image); 
                                                $firstImage = get_uploaded_image_url($images[0],'product_image_upload_dir'); 
                                            @endphp
                                            <!--Image-->
                                            <img class="primary blur-up lazyload" data-src="{{$firstImage }}" src="{{$firstImage }}" alt="image" title="" width="800" height="960">
                                            <!--End image-->
                                            <!--Hover image-->
                                            <img class="hover blur-up lazyload" data-src="{{$firstImage }}" src="{{$firstImage }}" alt="image" title="" width="800" height="960">
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
                                            <a href="{{ route('productdetails', ['id' => $product->id]) }}">{!! app()->getLocale() === 'ar' ? $product->product_name_arabic : $product->product_name !!}</a>
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
                            
                            <div class="row">
                                <div class="col-12 text-center mt-3">
                                    <a href="#" class="btn-primary btn-lg rounded">Shop All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


                 <!--Spring Summer Product Slider-->
                 <section class="section product-slider">
                    <div class="container">
                        <div class="row">
                            <div class="section-header text-uppercase col-12">
                                  @php
                                    
                                  $foryouTitle = \App\Models\LandingPageSetting::where('meta_key', 'for_you_title')->first();
                                  $foryouSubTitle = \App\Models\LandingPageSetting::where('meta_key', 'for_you_subtitle')->first();

                                  $foryouTitle = $foryouTitle && $foryouTitle->meta_value  ? $foryouTitle->meta_value    : '';
                                  $foryouSubTitle = $foryouSubTitle && $foryouSubTitle->meta_value   ? $foryouSubTitle->meta_value   : '';
                                    @endphp 
                                <h2>{!! $foryouTitle !!}</h2>
                                <p>{!! $foryouSubTitle !!}</p>
                            </div>
                        </div>
                        <div class="productSlider grid-products">

                            @foreach($foryou_products as $product)
                            <div class="item">
                                <!--Start Product Image-->
                                <div class="product-image">
                                        
                                    <a href="{{ route('productdetails', ['id' => $product->id]) }}" class="product-img">
                                        @php
                                            $images = explode(',', $product->image); 
                                            $firstImage = get_uploaded_image_url($images[0],'product_image_upload_dir')
                                        @endphp
                                       
                                        <img class="primary blur-up lazyload" data-src="{{$firstImage }}" src="{{$firstImage }}" alt="image" title="" width="800" height="960">
                                       
                                        <img class="hover blur-up lazyload" data-src="{{$firstImage }}" src="{{$firstImage }}" alt="image" title="" width="800" height="960">
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
                               
                                <div class="product-details text-center">
                                    
                                    <div class="product-name text-uppercase">
                                        <a href="{{ route('productdetails', ['id' => $product->id]) }}">{!! app()->getLocale() === 'ar' ? $product->product_name_arabic : $product->product_name !!} </a>
                                    </div>
                                   
                                    <div class="product-price">
                                    @if($product->regular_price)
                                        @if($product->sale_price && $product->sale_price < $product->regular_price)
                                            <div class="sale-price">
                                                Sale Price: AED {{ $product->sale_price ?? 'N/A' }}
                                            </div>
                                            <div class="regular-price">
                                                Regular Price: <span class="old-price"> AED {{ $product->regular_price }}</span>
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
                                   
                                </div>
                                
                            </div>
                            @endforeach
                            
                        </div>
                    </div>
                </section>
                <!--End Spring Summer Product Slider-->

                <!--Best Seller-->
              
                <!--End Best Seller-->

                <!--Testimonial Slider-->
                <section class="section testimonial-slider style1">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 section-header style1">
                                <div class="section-header-left">
                                    <h2>Testimonials</h2>
                                </div>
                            </div>
                        </div>
                        <div class="quote-wraper">
                            <!--Testimonial Slider Items-->
                            <div class="quotes-slider">
                                @foreach($testimonials as $testimonial)
                                <div class="quotes-slide">
                                    <blockquote class="quotes-slider__text text-center">             
                                        <div class="testimonial-image"><img class="blur-up lazyload" data-src="{{ $testimonial->user_image }}" src="{{ asset('uploads/users/'.$testimonial->user_image) }}" alt="{{$testimonial->name}}" title="{{$testimonial->name}}" /></div>
                                        <div class="rte-setting"><p> {!! app()->getLocale() === 'ar' ? $testimonial->comment_ar : $testimonial->comment !!}</p></div>
                                        <div class="product-review">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($testimonial->average_rating >= $i)
                                                <i class="an an-star"></i> 
                                            @elseif($testimonial->average_rating >= $i - 0.5)
                                                <i class="an an-star-half"></i> 
                                            @else
                                                <i class="an an-star-o"></i> 
                                            @endif
                                        @endfor
                                        </div>
                                        <p class="authour"> {!! app()->getLocale() === 'ar' ? $testimonial->name_ar : $testimonial->name !!},</p>
                                        <p class="cmp-name"> {!! app()->getLocale() === 'ar' ? $testimonial->designation_ar : $testimonial->designation !!}</p>
                                    </blockquote>
                                </div>
                                @endforeach
                               
                            </div>
                            <!--Testimonial Slider Items-->
                        </div>
                    </div>
                </section>
                <!--End Testimonial Slider-->

                <!--Store Feature-->
                <section class="store-features pb-0">
                    <div class="container">
                        <div class="row store-info">
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3 my-sm-3">
                                <a class="d-flex clr-none" href="#">
                                    <i class="an an-truck-l"></i>
                                    <div class="detail">
                                    @php
                                    $shippingTitleSetting = \App\Models\LandingPageSetting::where('meta_key', 'shipping_title')->first();
                                    $shippingDescSetting = \App\Models\LandingPageSetting::where('meta_key', 'shipping_description')->first(); 
                                    $shippingTitle = $shippingTitleSetting && $shippingTitleSetting->meta_value ? $shippingTitleSetting->meta_value  : '';
                                    $shippingDesc = $shippingDescSetting && $shippingDescSetting->meta_value  ? $shippingDescSetting->meta_value  : '';
                                    @endphp 
                                        <h5 class="fs-6 text-uppercase mb-1">{!! $shippingTitle !!}</h5>
                                        <p class="sub-text">{!! $shippingDesc !!}</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3 my-sm-3">
                                <a class="d-flex clr-none" href="#">
                                    <i class="an an-dollar-sign-l"></i>
                                    <div class="detail">
                                    @php
                                    $moneyTitleSetting = \App\Models\LandingPageSetting::where('meta_key', 'money_title')->first();
                                    $moneyDescSetting = \App\Models\LandingPageSetting::where('meta_key', 'money_description')->first(); 

                                    $moneyTitle = $moneyTitleSetting && $moneyTitleSetting->meta_value ? $moneyTitleSetting->meta_value  : '';
                                    $moneyDesc = $moneyDescSetting && $moneyDescSetting->meta_value  ? $moneyDescSetting->meta_value  : '';
                                    @endphp 
                                        <h5 class="fs-6 text-uppercase mb-1">{!! $moneyTitle !!}</h5>
                                        <p class="sub-text">{!! $moneyDesc !!}</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3 my-sm-3">
                                <a class="d-flex clr-none" href="#">
                                    <i class="an an-credit-card-l"></i>
                                    <div class="detail">
                                    @php
                                    
                                    $paymentTitleSetting = \App\Models\LandingPageSetting::where('meta_key', 'payment_title')->first();
                                    $paymentDescSetting = \App\Models\LandingPageSetting::where('meta_key', 'payment_description')->first();
                                    $paymentTitle = $paymentTitleSetting && $paymentTitleSetting->meta_value  ? $paymentTitleSetting->meta_value  : '';
                                    $paymentDesc = $paymentDescSetting && $paymentDescSetting->meta_value  ? $paymentDescSetting->meta_value  : '';
                                    @endphp 
                                        <h5 class="fs-6 text-uppercase mb-1">{!! $paymentTitle !!}</h5>
                                        <p class="sub-text">{!! $paymentDesc !!}</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-1 my-sm-3">
                                <a class="d-flex clr-none" href="#">
                                    <i class="an an-award"></i>
                                    <div class="detail">
                                    @php
                                    
                                    $supportTitleSetting = \App\Models\LandingPageSetting::where('meta_key', 'support_title')->first();
                                    $supportDescSetting = \App\Models\LandingPageSetting::where('meta_key', 'support_description')->first();

                                    $supportTitle = $supportTitleSetting && $supportTitleSetting->meta_value ? $supportTitleSetting->meta_value  : '';
                                    $supportDesc = $supportDescSetting && $supportDescSetting->meta_value  ? $supportDescSetting->meta_value  : '';
                                    @endphp 
                                        <h5 class="fs-6 text-uppercase mb-1">{!! $supportTitle !!}</h5>
                                        <p class="sub-text">{!! $supportDesc !!}</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
                <!--End Store Feature-->

              

                <!--Banner Masonary-->
                <section class="collection-banners style1 mt-0 d-none" >
                    <div class="container">
                        <div class="grid-masonary banner-grid">
                            <div class="grid-sizer col-12 col-sm-12 col-md-6 col-lg-6"></div>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 banner-item">
                                    <div class="collection-grid-item">
                                        @php
                                        
                                        $saleSection1Title = \App\Models\LandingPageSetting::where('meta_key', 'sale_section_1_title')->first();
                                       
                                        $saleSection1Desc = \App\Models\LandingPageSetting::where('meta_key', 'sale_section_1_description')->first();
                                        $saleSection1ButtonText = \App\Models\LandingPageSetting::where('meta_key', 'sale_section_1_button_text')->first();
                                        $saleSection1Image = \App\Models\LandingPageSetting::where('meta_key', 'sale_section_1_image')->first();

                                        $saleSection1Title = $saleSection1Title && $saleSection1Title->meta_value  ? $saleSection1Title->meta_value   : '';
                                        $saleSection1Desc = $saleSection1Desc && $saleSection1Desc->meta_value ? $saleSection1Desc->meta_value   : '';
                                        $saleSection1ButtonText = $saleSection1ButtonText && $saleSection1ButtonText->meta_value   ? $saleSection1ButtonText->meta_value : '';
                                        $saleSection1Image = $saleSection1Image && $saleSection1Image->meta_value  ? $saleSection1Image->meta_value  : '';
                                        @endphp 
                                        <a href="#">
                                            <div class="img">
                                                <img class="blur-up lazyload" data-src="{{ $saleSection1Image  }}" src="{{ $saleSection1Image  }}" alt="STREETSTYLE" title="STREETSTYLE" width="800" height="518" />
                                            </div>
                                            <div class="details center w-50 white-overlay rounded">
                                                <div class="inner">
                                                    <p class="mb-0">{!! $saleSection1Title  !!} </p>
                                                    <h3 class="title mt-1 fs-3 redText">{!! $saleSection1Desc  !!}</h3>
                                                    <span class="btn-primary rounded mt-3">{!! $saleSection1ButtonText  !!}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 banner-item">
                                    <div class="collection-grid-item">
                                       @php
                                        
                                       $saleSection2Title = \App\Models\LandingPageSetting::where('meta_key', 'sale_section_2_title')->first();
                                        $saleSection2Desc = \App\Models\LandingPageSetting::where('meta_key', 'sale_section_2_description')->first();
                                        $saleSection2ButtonText = \App\Models\LandingPageSetting::where('meta_key', 'sale_section_2_button_text')->first();
                                        $saleSection2Image = \App\Models\LandingPageSetting::where('meta_key', 'sale_section_2_image')->first();

                                        $saleSection2Title = $saleSection2Title && $saleSection2Title->meta_value   ? $saleSection2Title->meta_value  : '';
                                        $saleSection2Desc = $saleSection2Desc && $saleSection2Desc->meta_value  ? $saleSection2Desc->meta_value : '';
                                        $saleSection2ButtonText = $saleSection2ButtonText && $saleSection2ButtonText->meta_value  ? $saleSection2ButtonText->meta_value  : '';
                                        $saleSection2Image = $saleSection2Image && $saleSection2Image->meta_value  ? $saleSection2Image->meta_value  : '';
                                        @endphp
                                        <a href="#">
                                            <div class="img">
                                                <img class="blur-up lazyload" data-src="{{ $saleSection2Image  }}" src="{{ $saleSection2Image  }}" alt="BOTTOM &amp; JEANS" title="BOTTOM &amp; JEANS" width="800" height="518" />
                                            </div>
                                            <div class="details center w-70 white-text rounded middle">
                                                <div class="inner">
                                                    <p class="mb-0 fs-5">{!! $saleSection2Title  !!}</p>
                                                    <h3 class="title large-title mb-2 mt-1">{!! $saleSection2Desc  !!}</h3>
                                                    <p class="btn--link text-center fs-6">{!! $saleSection2ButtonText  !!}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--End Banner Masonary-->

                <!--Blog Post-->
                <section class="section home-blog-post">
                    <div class="container">
                        <div class="section-header">
                            <h2>Fresh From Our Blog</h2>
                            <p>TOP NEWS STORIES OF THE DAY</p>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="blog-post-slider">
                                    @foreach($blogs as $blog)
                                    <div class="blogpost-item">
                                        <a href="{{ route('blog-detail', ['id' => $blog->id]) }}" class="post-thumb">
                                            <img class="blur-up lazyload" src="{{ $blog->blog_image }}" data-src="{{ $blog->blog_image }}" width="380" height="205" alt="image" title=""/>
                                        </a>
                                        <div class="post-detail">
                                            <h3 class="post-title mb-3"><a href="{{ route('blog-detail', ['id' => $blog->id]) }}"> {!! app()->getLocale() === 'ar' ? $blog->name_ar : $blog->name !!}</a></h3>
                                            <ul class="publish-detail d-flex-center mb-3">
                                                <li class="d-flex align-items-center"><i class="an an-calendar me-2"></i> <span class="article__date">{{ \Carbon\Carbon::parse($blog->created_at)->format('F d, Y') }}</span></li>
                                                <li class="d-flex align-items-center"><i class="an an-comments-l me-2"></i> <a href="#;" class="article-link">0 comment</a></li>
                                            </ul>
                                            <p class="exceprt">     {!! \Illuminate\Support\Str::words(strip_tags(app()->getLocale() === 'ar' ? $blog->description_ar : $blog->description), 50, '...') !!} </p>
                                            <a href="{{ route('blog-detail', ['id' => $blog->id]) }}" class="btn-small">Read more</a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                         <div class="text-center mt-4">
                            <a href="{{ route('blogs') }}" class="btn btn-primary">View All</a>
                        </div>
                    </div>
                </section>
                <!--End Blog Post-->

                <!--Brand Logo Slider-->
                <section class="section logo-section pt-2 ">
                    <div class="container">
                        <div class="section-header ">
                            <h2>Our Partners</h2>
                            <p>Lorem ipsum dolor sit amet</p>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="logo-bar">
                                     @foreach($logos as $logo)
                                    <div class="logo-bar__item">
                                        <a href="#"><img class="blur-up lazyload" data-src="{{ $logo->image }}" src="{{ $logo->image }}" alt="brand" title="" /></a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--End Brand Logo Slider-->
            </div>
            <!--End Body Container-->
@endsection   