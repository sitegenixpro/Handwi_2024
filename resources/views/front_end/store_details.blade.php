@extends('front_end.template.layout')
@section('content')

<style>
    .category-grid-item_custom{
        position: relative !important;
        top: 0 !important;
        left: 0 !important;
        margin-bottom: 10px;
    }
    .category-grid-item_custom img{
        height: 260px;
        object-fit: cover;
        width: 100%;
    }
    
    .category-grid-item_custom .details{
            background: rgba(255, 255, 255, 0.88);
        padding: 10px;
        width: auto;
        height: auto;
        justify-content: center;
        align-items: center;
        text-align: center;
        position: absolute;
        top: auto;
        bottom: 10px;
        left: 10px;
        right: 10px;
        z-index: 2;
        -ms-transform: translateX(0);
        -webkit-transform: translateX(0);
        transform: translateX(0);
    }
    
    
.category-grid-item_custom .details .category-title {
    color: #000000;
    font-size: 15px;
}

.category-grid-item_custom .details:hover .details {
    background: #ffffff;
}

.collection-hero.medium .collection-hero__image {
        height: 280px !important;
    }
@media(max-width:767px){
    .collection-hero.medium .collection-hero__image{
        height: 180px !important;
        
    }
}
</style>
  <!--Body Container-->
  <div id="page-content">
                <!--Collection Banner-->
                <div class="collection-header d-none">
                    <div class="collection-hero mb-0">
                        <div class="collection-hero__image"></div>
                        <div class="collection-hero__title-wrapper container">
                            <h1 class="collection-hero__title">Shop Detail</h1>
                            <div class="breadcrumbs text-uppercase mt-1 mt-lg-2"><a href="{{route('home')}}" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">Shop Detail</span></div>
                        </div>
                    </div>
                </div>
                <!--End Collection Banner-->
                <!-- Collection Banner -->
                <div class="collection-header">
                    <div class="collection-hero medium pb-2 mb-0 mb-4" style="background-image: url({{$vendorDetails->cover_image }}); background-size: cover; background-position: center; background-repeat: no-repeat; background: #fafafa; border-bottom: 1px solid #ddd">
                            <div class="collection-hero__image collection-hero__image_custom" style="background-image: url({{$vendorDetails->cover_image }});"></div>
                            <div class="collection-hero__title-wrapper container d-none">
                                <!-- <h1 class="collection-hero__title medium">Sub Collection List</h1> -->
                                <div class="vendor-stk-detail-area">
                                    @if (isset($store->logo) && $store->logo && file_exists(public_path('storage/' . $store->logo)))
                                    <img src="{{asset('')}}storage/{{$store->logo}}" alt="" class="log-are">
                                    @endif
                                    <div class="vendor-stk-dtl">
                                        <h4 class="v-name text-left fs-3">{{ $store->store_name ? $store->store_name : 'No Store Name' }}</h4>
                                        <p class="loc text-left mb-2">{{ $store->location ? $store->location : 'No Store Location' }}</p>
                                        <div class="btm-bar">
                                            <span class="star-ratin fs-6"><svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0.829374 7.7504L3.05437 9.3754L2.20937 11.9923C2.07282 12.3981 2.07109 12.8373 2.20444 13.2442C2.3378 13.6511 2.59909 14.0041 2.94937 14.2504C3.29366 14.5046 3.71087 14.6408 4.13885 14.6387C4.56682 14.6366 4.98265 14.4962 5.32437 14.2385L7.5 12.6373L9.67625 14.2366C10.0199 14.4894 10.4349 14.6267 10.8615 14.6288C11.2881 14.6309 11.7044 14.4976 12.0505 14.2482C12.3966 13.9988 12.6547 13.6461 12.7877 13.2407C12.9207 12.8353 12.9217 12.3983 12.7906 11.9923L11.9456 9.3754L14.1706 7.7504C14.5138 7.49947 14.769 7.14649 14.8996 6.74189C15.0302 6.33729 15.0296 5.90176 14.8979 5.49752C14.7662 5.09327 14.5101 4.74098 14.1663 4.49096C13.8224 4.24095 13.4083 4.106 12.9831 4.1054H10.25L9.42062 1.5204C9.2902 1.1135 9.03392 0.758532 8.68873 0.506689C8.34354 0.254847 7.92729 0.119141 7.5 0.119141C7.07271 0.119141 6.65646 0.254847 6.31127 0.506689C5.96608 0.758532 5.7098 1.1135 5.57937 1.5204L4.75 4.1054H2.01937C1.59421 4.106 1.18012 4.24095 0.836236 4.49096C0.492354 4.74098 0.236274 5.09327 0.104574 5.49752C-0.0271252 5.90176 -0.0277081 6.33729 0.102909 6.74189C0.233526 7.14649 0.488662 7.49947 0.831874 7.7504H0.829374Z" fill="#D4B2A7"/>
                                                </svg>
                                                4.5
                                            </span>
                                        </div>
                                        
                                    </div>
                                 </div>
                            </div>
                            <div class="container py-3 pb-2 custom_store_container">
                                <div class="row align-items-center">
                                    <div class="col-6 col-lg-4">
                                        <div class="store-profile">
                                            @if (isset($store->logo) && $store->logo && file_exists(public_path('storage/' . $store->logo)))
                                        <img src="{{asset('')}}storage/{{$store->logo}}" alt="" class="log-are">
                                        @endif
                                        <div class="vendor-stk-dtl">
                                            <h4 class="v-name text-left fs-5">{{ $store->store_name ? $store->store_name : 'No Store Name' }}</h4>
                                            <p class="loc text-left mb-1">{{ $store->location ? $store->location : 'No Store Location' }}</p>
                                            <div class="btm-bar">
                                                <span class="star-ratin fs-6"><svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0.829374 7.7504L3.05437 9.3754L2.20937 11.9923C2.07282 12.3981 2.07109 12.8373 2.20444 13.2442C2.3378 13.6511 2.59909 14.0041 2.94937 14.2504C3.29366 14.5046 3.71087 14.6408 4.13885 14.6387C4.56682 14.6366 4.98265 14.4962 5.32437 14.2385L7.5 12.6373L9.67625 14.2366C10.0199 14.4894 10.4349 14.6267 10.8615 14.6288C11.2881 14.6309 11.7044 14.4976 12.0505 14.2482C12.3966 13.9988 12.6547 13.6461 12.7877 13.2407C12.9207 12.8353 12.9217 12.3983 12.7906 11.9923L11.9456 9.3754L14.1706 7.7504C14.5138 7.49947 14.769 7.14649 14.8996 6.74189C15.0302 6.33729 15.0296 5.90176 14.8979 5.49752C14.7662 5.09327 14.5101 4.74098 14.1663 4.49096C13.8224 4.24095 13.4083 4.106 12.9831 4.1054H10.25L9.42062 1.5204C9.2902 1.1135 9.03392 0.758532 8.68873 0.506689C8.34354 0.254847 7.92729 0.119141 7.5 0.119141C7.07271 0.119141 6.65646 0.254847 6.31127 0.506689C5.96608 0.758532 5.7098 1.1135 5.57937 1.5204L4.75 4.1054H2.01937C1.59421 4.106 1.18012 4.24095 0.836236 4.49096C0.492354 4.74098 0.236274 5.09327 0.104574 5.49752C-0.0271252 5.90176 -0.0277081 6.33729 0.102909 6.74189C0.233526 7.14649 0.488662 7.49947 0.831874 7.7504H0.829374Z" fill="#D4B2A7"/>
                                                    </svg>
                                                    4.5
                                                </span>
                                            </div>
                                            <!--<a href="#!" style=" font-size: 18px; " data-bs-toggle="modal" data-bs-target="#flagmodal"><i class="fa-regular fa-flag"></i></a>-->
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 d-none d-lg-block">
                                        <div class="store_info_extra">
                                            <i class="fa-solid fa-truck"></i> 
                                            <h4 class="mb-1">Easy Shipping</h4>
                                            <p class="fs-6">Reliable shipping with tracking info.</p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-5">
                                        <div class="store_btns">
                                            <!--<a href="#!"><i class="fa-solid fa-plus"></i> Follow</a>-->
                                            @if(Auth::user())  
                                                <a href="javascript:void(0);" id="followVendor" data-vendor-id="{{ $store->vendor_id }}">
                                                    @if($is_followed)
                                                        <i class="fa-solid fa-minus"></i> Unfollow
                                                    @else
                                                        <i class="fa-solid fa-check"></i> Follow
                                                    @endif
                                                </a>
                                            @else
                                                <a href="{{ route('login') }}">
                                                    <i class="fa-solid fa-check"></i> Follow
                                                </a>
                                            @endif
                                            @if(Auth::user())
                                                <a href="#!" data-bs-toggle="modal" data-bs-target="#messagemodal"><i class="fa-regular fa-message"></i> Message</a>
                                            @else
                                            <a href="{{ route('login') }}" ><i class="fa-regular fa-message"></i> Message</a>
                                               
                                            @endif

                                            @if(Auth::user())
                                               <a href="#!" data-bs-toggle="modal" data-bs-target="#flagmodal"><i class="fa-regular fa-flag"></i> Report</a>
                                            @else
                                            <a href="{{ route('login') }}" ><i class="fa-regular fa-flag"></i> Report</a>
                                               
                                            @endif
                                            <!--<a href="#!" data-bs-toggle="modal" data-bs-target="#messagemodal"><i class="fa-solid fa-message"></i> Message</a>-->
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <!-- End Collection Banner -->

                <!--Category Grid-->
                <div class="container">
        
                    <!--Collection Description-->
                        <div class="collection-description mb-4 pt-0 mx-auto">
                            <h3 class="fs-6 mb-1">More Info:-</h3>
                            <p>{{ $store->description ? $store->description : 'No Store Description' }}</p>
                        </div>
                    <!--End Collection Description-->

                    <!--Category Masonary Grid-->
                    <div class="">
                        <div class="">
                            <div class="grid-sizer grid-5col col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2"></div>
                            <div class="row">
                               @foreach($categories as $cat)
                                <div class="col-6 col-sm-6 col-md-4 col-lg-3 category-grid-item_custom">
                                    <div class="category-item position-relative overflow-hidden zoomscal-hov">
                                        <a href="{{ route('categoryproducts', ['id' => $cat->id]) }}" class="category-link">
                                            <div class="zoom-scal"><img class="blur-up lazyload" data-src="{{asset($cat->image)}}" src="{{asset($cat->image)}}" alt="collection" title="" /></div>
                                            <div class="details">
                                                <div class="inner">
                                                    <h3 class="category-title">{{$cat->name}}</h3>
                                                    <span class="counts mt-0 mt-md-1">{{ \App\Models\ProductModel::join('product_selected_attribute_list', 'product_selected_attribute_list.product_id', '=', 'product.id')->join('product_category', 'product_category.product_id', '=', 'product.id')->where('product_category.category_id', $cat->id)->distinct()->count() }}  Products</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!--End Category Masonary Grid-->
                </div>
                <!--End Category Grid-->

                <!--This week's highlight Slider-->
                <section class="section product-slider pb-0">
                    <div class="container">
                        <div class="row">
                            <div class="section-header col-12">
                                <h2 class="text-transform-none">All Products</h2>
                            </div>
                        </div>
                        <div class="productSlider grid-products">
                            @if($all_products->isEmpty())
                                <<div class="alert alert-warning text-center" role="alert">
                                    <i class="align-middle icon an an-cart icon-large me-2"></i><strong>No products availabe.</strong>
                                </div>
                            @else
                            @foreach($all_products as $product) 
                            <div class="item">
                                <!--Start Product Image-->
                                <div class="product-image">
                                        
                                    <a href="{{ route('productdetails', ['id' => $product->id]) }}" class="product-img">
                                        @php
                                            $images = explode(',', $product->image); 
                                            $firstImage = $images[0]; 
                                        @endphp
                                        <img class="primary blur-up lazyload" data-src="{{get_uploaded_image_url($firstImage,'product_image_upload_dir')}}" src="{{get_uploaded_image_url($firstImage,'product_image_upload_dir')}}" alt="image" title="" width="800" height="960">
                                       
                                        <img class="hover blur-up lazyload" data-src="{{get_uploaded_image_url($firstImage,'product_image_upload_dir')}}" src="{{get_uploaded_image_url($firstImage,'product_image_upload_dir')}}" alt="image" title="" width="800" height="960">
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
                                        <a href="{{ route('productdetails', ['id' => $product->id]) }}">{{$product->product_name}} </a>
                                    </div>
                                   
                                    <div class="product-price">
                                    @if($product->regular_price)
                                        @if($product->sale_price && $product->sale_price < $product->regular_price)
                                            <div class="sale-price">
                                                Sale Price: {{ $product->sale_price ?? 'N/A' }}
                                            </div>
                                            <div class="regular-price">
                                                Regular Price: <span class="old-price">{{ $product->regular_price }}</span>
                                            </div>
                                        @else
                                            <div class="regular-price">
                                                Price: {{ $product->regular_price }}
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
                            @endif
                        </div>
                    </div>
                </section>
                <section class="section product-slider pb-0">
                    <div class="container">
                        <div class="row">
                            <div class="section-header col-12">
                                <h2 class="text-transform-none">MOST SELLING PRODUCTS</h2>
                            </div>
                        </div>
                        <div class="productSlider grid-products">
                            @if($most_selling_products->isEmpty())
                                <<div class="alert alert-warning text-center" role="alert">
                                    <i class="align-middle icon an an-cart icon-large me-2"></i><strong>No products availabe.</strong>
                                </div>
                            @else
                            @foreach($most_selling_products as $product) 
                            <div class="item">
                                <!--Start Product Image-->
                                <div class="product-image">
                                        
                                    <a href="{{ route('productdetails', ['id' => $product->id]) }}" class="product-img">
                                        @php
                                            $images = explode(',', $product->image); 
                                            $firstImage = $images[0]; 
                                        @endphp
                                        <img class="primary blur-up lazyload" data-src="{{get_uploaded_image_url($firstImage,'product_image_upload_dir')}}" src="{{get_uploaded_image_url($firstImage,'product_image_upload_dir')}}" alt="image" title="" width="800" height="960">
                                       
                                        <img class="hover blur-up lazyload" data-src="{{get_uploaded_image_url($firstImage,'product_image_upload_dir')}}" src="{{get_uploaded_image_url($firstImage,'product_image_upload_dir')}}" alt="image" title="" width="800" height="960">
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
                                        <a href="{{ route('productdetails', ['id' => $product->id]) }}">{{$product->product_name}} </a>
                                    </div>
                                   
                                    <div class="product-price">
                                    @if($product->regular_price)
                                        @if($product->sale_price && $product->sale_price < $product->regular_price)
                                            <div class="sale-price">
                                                Sale Price: {{ $product->sale_price ?? 'N/A' }}
                                            </div>
                                            <div class="regular-price">
                                                Regular Price: <span class="old-price">{{ $product->regular_price }}</span>
                                            </div>
                                        @else
                                            <div class="regular-price">
                                                Price: {{ $product->regular_price }}
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
                            @endif
                        </div>
                    </div>
                </section>
                <!--End This week's highlight Slider-->

                <div class="container mt-5 d-none">
                    <div class="row">
                        <div class="section-header col-12">
                            <h2 class="text-transform-none">TRENDING NOW </h2>
                        </div>
                    </div>
                    <div class="row">
                        <!--Main Content-->
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 main-col">
                            <!--Collection top filters-->
                            <!-- <div class="collection-top-filters filterbar">
                                <div class="closeFilter d-block d-lg-none"><i class="icon icon an an-times-r"></i></div>
                                <div class="filters-toolbar-wrapper sidebar_tags m-0 d-flex flex-wrap align-items-center">
                                    <label class="flby mb-3 m-lg-0">Filter By</label>
                                    <form class="d-flex flex-wrap" action="#" method="post">
                                        <div class="btn-group filterBox filter-widget ">
                                            <button type="button" class="flTtl dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Color <span class="count-bubble text-center rounded-circle"></span></button>
                                            <div class="filterDD dropdown-menu">
                                                <div class="bxTtl d-none d-lg-flex justify-content-between"><span class="selected">0 selected</span><a href="#" class="reset text-decoration-underline">Reset</a></div>
                                                <div class="filter-color swacth-list clearfix">
                                                    <ul class="clearfix p-0 d-flex flex-wrap">
                                                        <li><span class="swacth-btn medium rectangle black"></span><span class="tooltip-label">Black</span></li>
                                                        <li><span class="swacth-btn medium rectangle white"></span><span class="tooltip-label">White</span></li>
                                                        <li><span class="swacth-btn medium rectangle red"></span><span class="tooltip-label">Red</span></li>
                                                        <li><span class="swacth-btn medium rectangle blue"></span><span class="tooltip-label">Blue</span></li>
                                                        <li><span class="swacth-btn medium rectangle pink"></span><span class="tooltip-label">Pink</span></li>
                                                        <li><span class="swacth-btn medium rectangle gray"></span><span class="tooltip-label">Gray</span></li>
                                                        <li><span class="swacth-btn medium rectangle green"></span><span class="tooltip-label">Green</span></li>
                                                        <li><span class="swacth-btn medium rectangle orange"></span><span class="tooltip-label">Orange</span></li>
                                                        <li><span class="swacth-btn medium rectangle yellow"></span><span class="tooltip-label">Yellow</span></li>
                                                        <li><span class="swacth-btn medium rectangle blueviolet"></span><span class="tooltip-label">Blue Violet</span></li>
                                                        <li><span class="swacth-btn medium rectangle brown"></span><span class="tooltip-label">Brown</span></li>
                                                        <li><span class="swacth-btn medium rectangle darkGoldenRod"></span><span class="tooltip-label">Dark Golden Red</span></li>
                                                        <li><span class="swacth-btn medium rectangle darkGreen"></span><span class="tooltip-label">Dark Green</span></li>
                                                        <li><span class="swacth-btn medium rectangle darkRed"></span><span class="tooltip-label">Dark Red</span></li>
                                                        <li><span class="swacth-btn medium rectangle khaki"></span><span class="tooltip-label">Khaki</span></li>
                                                        <li><span class="swacth-btn medium rectangle blue-red"></span><span class="tooltip-label">Blue/Red</span></li>
                                                        <li><span class="swacth-btn medium rectangle black-grey"></span><span class="tooltip-label">Black/Grey</span></li>
                                                        <li><span class="swacth-btn medium rectangle pink-black"></span><span class="tooltip-label">pink-Black</span></li>
                                                        <li><span class="swacth-btn medium rectangle yellow-black"></span><span class="tooltip-label">Yellow</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btn-group filterBox filter-widget size-swacthes">
                                            <button type="button" class="flTtl dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Size<span class="count-bubble text-center rounded-circle"></span></button>
                                            <div class="filterDD dropdown-menu">
                                                <div class="bxTtl d-none d-lg-flex justify-content-between">                                  
                                                    <span class="selected">0 selected</span><a href="#" class="reset text-decoration-underline">Reset</a>                              
                                                </div>
                                                <div class="filter-size swacth-list clearfix">
                                                    <ul class="clearfix">
                                                        <li><input type="checkbox" value="s" id="s"><label for="s"><span></span>S</label></li>
                                                        <li><input type="checkbox" value="m" id="m"><label for="m"><span></span>M</label></li>
                                                        <li><input type="checkbox" value="l" id="l"><label for="l"><span></span>L</label></li>
                                                        <li><input type="checkbox" value="x" id="x"><label for="x"><span></span>X</label></li>
                                                        <li><input type="checkbox" value="xl" id="xl"><label for="xl"><span></span>XL</label></li>
                                                        <li><input type="checkbox" value="xll" id="xll"><label for="xll"><span></span>XLL</label></li>
                                                        <li><input type="checkbox" value="xxl" id="xxl"><label for="xxl"><span></span>XXL</label></li>
                                                        <li><input type="checkbox" value="xs" id="xs"><label for="xs"><span></span>XS</label></li>
                                                        <li><input type="checkbox" value="15" id="15"><label for="15"><span></span>15</label></li>
                                                        <li><input type="checkbox" value="25" id="25"><label for="25"><span></span>25</label></li>
                                                        <li><input type="checkbox" value="35" id="35"><label for="35"><span></span>35</label></li>
                                                        <li><input type="checkbox" value="45" id="45"><label for="45"><span></span>45</label></li>
                                                        <li><input type="checkbox" value="55" id="55"><label for="55"><span></span>55</label></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btn-group filterBox filter-widget size-swacthes product-type">
                                            <button type="button" class="flTtl dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Product type<span class="count-bubble text-center rounded-circle"></span></button>
                                            <div class="filterDD dropdown-menu">
                                                <div class="bxTtl d-none d-lg-flex justify-content-between">                                  
                                                    <span class="selected">0 selected</span><a href="#" class="reset text-decoration-underline">Reset</a>                              
                                                </div>
                                                <div class="filter-size swacth-list clearfix">
                                                    <ul class="clearfix">
                                                        <li><input type="checkbox" value="accessories" id="accessories"><label for="accessories"><span></span>Accessories </label></li>
                                                        <li><input type="checkbox" value="bags" id="bags"><label for="bags"><span></span>Bags</label></li>
                                                        <li><input type="checkbox" value="jeans" id="jeans"><label for="jeans"><span></span>Jeans</label></li>
                                                        <li><input type="checkbox" value="shoes" id="shoes"><label for="shoes"><span></span>Shoes</label></li>
                                                        <li><input type="checkbox" value="t-shirts" id="t-shirts"><label for="t-shirts"><span></span>T-shirts</label></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btn-group filterBox filter-widget size-swacthes brand-filter">
                                            <button type="button" class="flTtl dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Brands<span class="count-bubble text-center rounded-circle"></span></button>
                                            <div class="filterDD dropdown-menu">
                                                <div class="bxTtl d-none d-lg-flex justify-content-between">                                  
                                                    <span class="selected">0 selected</span><a href="#" class="reset text-decoration-underline">Reset</a>                              
                                                </div>
                                                <div class="filter-size swacth-list clearfix">
                                                    <ul class="clearfix">
                                                        <li><input type="checkbox" value="adidas" id="adidas"><label for="adidas"><span></span>Adidas</label></li>
                                                        <li><input type="checkbox" value="baggit" id="baggit"><label for="baggit"><span></span>Baggit</label></li>
                                                        <li><input type="checkbox" value="campus" id="campus"><label for="campus"><span></span>Campus</label></li>
                                                        <li><input type="checkbox" value="caprese" id="caprese"><label for="caprese"><span></span>Caprese</label></li>
                                                        <li><input type="checkbox" value="elle" id="elle"><label for="elle"><span></span>Elle</label></li>
                                                        <li><input type="checkbox" value="diva" id="diva"><label for="diva"><span></span>Diva</label></li>
                                                        <li><input type="checkbox" value="optimal" id="optimal"><label for="optimal"><span></span>Optimal</label></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btn-group filterBox filter-widget size-swacthes availability">
                                            <button type="button" class="flTtl dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Availability<span class="count-bubble text-center rounded-circle"></span></button>
                                            <div class="filterDD dropdown-menu">
                                                <div class="bxTtl d-none d-lg-flex justify-content-between">                                  
                                                    <span class="selected">0 selected</span><a href="#" class="reset text-decoration-underline">Reset</a>                              
                                                </div>
                                                <div class="filter-size swacth-list clearfix">
                                                    <ul class="clearfix">
                                                        <li><input type="checkbox" value="instock" id="instock"><label for="instock"><span></span>In stock</label></li>
                                                        <li><input type="checkbox" value="outofstock" id="outofstock"><label for="outofstock"><span></span>Out of stock</label></li>
                                                    </ul>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="btn-group filterBox filter-widget size-swacthes">
                                            <button type="button" class="flTtl dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Price<span class="count-bubble text-center rounded-circle"></span></button>
                                            <div class="filterDD dropdown-menu">
                                                <div class="bxTtl d-none d-lg-flex justify-content-between">                                  
                                                    <span class="selected">The highest price is $599.00</span><a href="#" class="reset text-decoration-underline">Reset</a>                              
                                                </div>
                                                <div class="filter-size swacth-list clearfix">
                                                    <div class="price-filter">
                                                        <div id="slider-range"></div>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <p class="no-margin"><input id="amount" type="text"></p>
                                                            </div>
                                                            <div class="col-6 text-right margin-25px-top">
                                                                <button class="btn btn--small rounded">filter</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="filters-toolbar__item filters-sort d-none d-lg-flex align-items-center ms-auto">
                                        <label for="SortBy" class="text-nowrap mb-0 me-2">Sort by:</label>
                                        <select name="SortBy" id="SortBy" class="filters-toolbar__input filters-toolbar__input--sort border-0 bg-transparent">
                                            <option value="featured" selected="selected">Featured</option>
                                            <option value="best-selling">Best selling</option>
                                            <option value="title-ascending">Alphabetically, A-Z</option>
                                            <option value="title-descending">Alphabetically, Z-A</option>
                                            <option value="price-ascending">Price, low to high</option>
                                            <option value="price-descending">Price, high to low</option>
                                            <option value="created-ascending">Date, old to new</option>
                                            <option value="created-descending">Date, new to old</option>
                                        </select>
                                    </div>
                                </div>
                            </div> -->
                            <!--End Collection top filters-->

                            <!--Active Filters-->
                            <!-- <ul class="active-filters d-flex flex-wrap align-items-center m-0 list-unstyled d-none">
                                <li><a href="#">Clear all</a></li>
                                <li><a href="#">Men <i class="an an-times-l"></i></a></li>
                                <li><a href="#">Neckalses <i class="an an-times-l"></i></a></li>
                                <li><a href="#">Accessories <i class="an an-times-l"></i></a></li>
                            </ul> -->
                            <!--End Active Filters-->
                            <!--Toolbar-->
                            <!-- <div class="toolbar mt-0">
                                <div class="filters-toolbar-wrapper">
                                    <ul class="list-unstyled d-flex align-items-center">
                                        <li class="product-count d-flex align-items-center">
                                            <button type="button" class="btn btn-filter an an-slider-3 d-inline-flex d-lg-none me-2 me-sm-3"><span class="hidden">Filter</span></button>
                                            <div class="filters-toolbar__item">
                                                <span class="filters-toolbar__product-count d-none d-sm-block">Showing: 21 products</span>
                                            </div>
                                        </li>
                                        <li class="collection-view ms-sm-auto">
                                            <div class="filters-toolbar__item collection-view-as d-flex align-items-center me-3 me-lg-0">
                                                <a href="javascript:void(0)" class="change-view prd-grid change-view--active"><i class="icon an an-th" aria-hidden="true"></i><span class="tooltip-label">Grid View</span></a>
                                                <a href="javascript:void(0)" class="change-view prd-list"><i class="icon an an-th-list" aria-hidden="true"></i><span class="tooltip-label">List View</span></a>
                                            </div>
                                        </li>
                                        <li class="filters-sort ms-auto ms-sm-0 d-lg-none">
                                            <div class="filters-toolbar__item">
                                                <label for="SortBy2" class="hidden">Sort by:</label>
                                                <select name="SortBy2" id="SortBy2" class="filters-toolbar__input filters-toolbar__input--sort">
                                                    <option value="featured" selected="selected">Featured</option>
                                                    <option value="best-selling">Best selling</option>
                                                    <option value="title-ascending">Alphabetically, A-Z</option>
                                                    <option value="title-descending">Alphabetically, Z-A</option>
                                                    <option value="price-ascending">Price, low to high</option>
                                                    <option value="price-descending">Price, high to low</option>
                                                    <option value="created-ascending">Date, old to new</option>
                                                    <option value="created-descending">Date, new to old</option>
                                                </select>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div> -->
                            <!--End Toolbar-->

                            <!--Product List-->
                            <div class="product-load-more">
                                <!--Product Grid-->
                                <div class="grid-products grid--view-items prd-grid">
                                    <div class="row" id="productcontainerstore">
                                        @if($products->isEmpty())
                                        <div class="alert alert-warning text-center" role="alert">
                                            <i class="align-middle icon an an-cart icon-large me-2"></i><strong>No products availabe.</strong>
                                        </div>
                                        @else
                                         @include('front_end.partials_store_product_grid', ['products' => $products])
                                        @endif
                                        
                                        
                                        
                                        
                                        
                                         
                                    </div>
                                </div>
                                <!--End Product Grid-->

                                <!--Load More Button-->
                                @if($totalProducts > count($products))
                                    <div class="infinitpaginOuter">
                                        <div class="infinitpagin">    
                                            <button class="btn rounded " id="load-more-button-storepage" 
                                                data-offset="{{ count($products) }}" 
                                                data-limit="8" 
                                                data-total="{{ $totalProducts }}">
                                                Load More ({{ count($products) }}/{{ $totalProducts }})
                                            </button>
                                        </div>
                                    </div>
                                @endif
                                <!--End Load More Button-->
                            </div>
                            <!--End Product List-->

                            <!--Collection Description-->
                            <!-- <div class="collection-description mt-4 pt-2">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard reader dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen the book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                            </div> -->
                            <!--End Collection Description-->
                        </div>
                        <!--End Main Content-->
                    </div>
            </div>
            <!--End Body Container-->
            
            
            
            
            <!-- Modal -->
            <div class="modal fade" id="messagemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Send Message</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" id="vendor_id" name="vendor_id" value="{{ $store->vendor_id }}" />
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Name" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input class="form-control" type="number" id="phone" name="phone" pattern="[0-9\-]*" placeholder="Phone Number">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                       <input type="text" id="subject" name="subject" class="form-control" placeholder="Subject" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                         <textarea id="message" name="message" class="form-control" rows="4" placeholder="Message"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="button" id="submitMessage" class="btn btn-primary w-100">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="flagmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Report The Shop</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div>
                                    <input type="hidden" id="report_vendor_id" value="{{ $store->vendor_id }}">
                                   
                                    @foreach($reasons as $index => $reason)
                                    <div class="col-12 mb-2">
                                        <div class="form-check custom_radio">
                                          <input class="form-check-input" type="radio" name="report_reason" id="flexRadioDefault5" value="{{ $reason->id }}">
                                          <label class="form-check-label" for="flexRadioDefault5">
                                              {{ $reason->reason }}
                                          </label>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="col-12 mb-2">
                                        <div class="form-check custom_radio">
                                          <input class="form-check-input" type="radio" name="report_reason" id="flexRadioDefault6">
                                          <label class="form-check-label" for="flexRadioDefault6">
                                            Remarks
                                          </label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group mb-0">
                                             <textarea name="remarks" id="report_remarks"  class="form-control" rows="4" placeholder="Remarks"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" id="submitReport" class="btn btn-primary w-100">Submit</button>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

@endsection