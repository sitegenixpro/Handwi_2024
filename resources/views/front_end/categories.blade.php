@extends('front_end.template.layout')
@section('content')
  
<div id="page-content">
                <!--Collection Banner-->
                <div class="collection-header">
                    <div class="collection-hero">
                        <div class="collection-hero__image"></div>
                        <div class="collection-hero__title-wrapper container">
                            <h1 class="collection-hero__title">{{$categorydetail->name}}</h1>
                            <div class="breadcrumbs text-uppercase mt-1 mt-lg-2"><a href="{{ route('home') }}" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">{{$categorydetail->name}}</span></div>
                        </div>
                    </div>
                </div>
                <!--End Collection Banner-->

                <div class="container-fluid">
                    <div class="row">
                        <!--Sidebar-->
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 sidebar filterbar">
                            <div class="closeFilter d-block"><i class="icon icon an an-times-r"></i></div>
                            <div class="sidebar_tags">
                                <!--Categories-->
                                <div class="sidebar_widget categories filterBox filter-widget">
                                    <div class="widget-title"><h2 class="mb-0">Categories</h2></div>
                                    <div class="widget-content filterDD">
                                     
                                        <ul class="clearfix sidebar_categories mb-0">
                                            @foreach ($categoriesHierarchy as $parentCategory)
                                                @if (count($parentCategory['children']) > 0)
                                                    <li class="lvl-1 sub-level">
                                                        <a href="{{ route('categoryproducts', ['id' => $parentCategory['category']->id]) }}" >
                                                            {{ $parentCategory['category']->name }}
                                                            >
                                                        </a>
                                                        <ul id="category-{{ $parentCategory['category']->id }}" class="sublinks collapse">
                                                            @foreach ($parentCategory['children'] as $childCategory)
                                                                <li class="level2">
                                                                    <a href="{{ route('categoryproducts', ['id' => $childCategory->id]) }}" class="site-nav">
                                                                        {{ $childCategory->name }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @else
                                                    <!-- If no children, render normally without the "lvl-1" class -->
                                                    <li>
                                                        <a href="{{ route('categoryproducts', ['id' => $parentCategory['category']->id]) }}" class="site-nav">
                                                            {{ $parentCategory['category']->name }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>

                                    </div>
                                </div>
                                <!--Categories-->
                                <!--Price Filter-->
                                <div class="sidebar_widget filterBox filter-widget">
                                    <div class="widget-title"><h2 class="mb-0">Price</h2></div>
                                     <?php
                                        $startPrice = $products->min('sale_price');
                                        $endPrice = $products->max('sale_price');
                                        
                                        $min_price=(request('min_sale_price'))?request('min_sale_price'):$products->min('sale_price');
                                        $max_price =(request('max_sale_price'))?request('max_sale_price'):$products->max('sale_price');
                                        
                                        if(!empty(request('start_price'))){
                                            $price_range=explode(',' ,request('price_range'));
                                            $startPrice=request('start_price');
                                            $endPrice = request('end_price');
                                        }
                        
                                        ?>
                    
                    
                                    <form id="priceFilterForm" action="{{ route('categoryproducts', ['id' => $categoryId]) }}" method="GET" class="price-filter filterDD">
                                         <input type="hidden" name="min_sale_price" value="{{ $min_price }}">
                                         <input type="hidden" name="max_sale_price" value="{{ $max_price }}">
                                        <div id="slider-range-give" class="mt-2"></div>
                                        <div class="row mt-3">
                                            <div class="col-12 mb-3">
                                                <p class="no-margin"><input id="amount" class="w-100" type="text"></p>
                                            </div>
                                            <div class="col-12 text-right margin-25px-top">
                                                <button class="btn btn--small rounded w-100">filter</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="start_price" id="start_price" value="{{$startPrice}}">
                                        <input type="hidden" name="end_price" id="end_price" value="{{$endPrice}}">
                                    </form>
                                </div>
                                

                            
                                <div class="sidebar_widget sidePro">
                                    <div class="widget-title"><h2>Popular Products</h2></div>
                                    <div class="widget-content">
                                        <div class="sideProSlider grid-products">
                                            <div class="col-12 item">
                                                <!--Start Product Image-->
                                                <div class="product-image">
                                                    <!--Start Product Image-->
                                                    <a href="product-layout1.html" class="product-img">
                                                        <!-- image -->
                                                        <img class="primary blur-up lazyload" data-src="http://localhost/handwi_2024/public/front_end/assets/images/products/product-1.jpg" src="http://localhost/handwi_2024/public/front_end/assets/images/products/product-1.jpg" alt="image" title="">
                                                        <!-- End image -->
                                                        <!-- Hover image -->
                                                        <img class="hover blur-up lazyload" data-src="http://localhost/handwi_2024/public/front_end/assets/images/products/product-1-1.jpg" src="http://localhost/handwi_2024/public/front_end/assets/images/products/product-1-1.jpg" alt="image" title="">
                                                        <!-- End hover image -->
                                                    </a>
                                                    <!--End Product Image-->

                                                    <!--Countdown Timer-->
                                                    <div class="saleTime" data-countdown="2029/03/01"></div>
                                                    <!--End Countdown Timer-->

                                                    <!--Product Button-->
                                                    <div class="button-set style0 d-none d-md-block">
                                                        <ul>
                                                            <!--Cart Button-->
                                                            <li><a class="btn-icon btn cartIcon pro-addtocart-popup" href="#pro-addtocart-popup"><i class="icon an an-cart-l"></i> <span class="tooltip-label top">Add to Cart</span></a></li>
                                                            <!--End Cart Button-->
                                                            <!--Quick View Button-->
                                                            <li><a class="btn-icon quick-view-popup quick-view" href="javascript:void(0)" data-toggle="modal" data-target="#content_quickview"><i class="icon an an-search-l"></i> <span class="tooltip-label top">Quick View</span></a></li>
                                                            <!--End Quick View Button-->
                                                            <!--Wishlist Button-->
                                                            <li><a class="btn-icon wishlist add-to-wishlist" href="my-wishlist.html"><i class="icon an an-heart-l"></i> <span class="tooltip-label top">Add To Wishlist</span></a></li>
                                                            <!--End Wishlist Button-->
                                                            <!--Compare Button-->
                                                            <li><a class="btn-icon compare add-to-compare" href="compare-style2.html"><i class="icon an an-sync-ar"></i> <span class="tooltip-label top">Add to Compare</span></a></li>
                                                            <!--End Compare Button-->
                                                        </ul>
                                                    </div>
                                                    
                                                    <!--End Product Button-->  
                                                </div>
                                                <!--End Product Image-->
                                                <!--Start Product Details-->
                                                <div class="product-details text-center">
                                                    <!--Product Name-->
                                                    <div class="product-name text-uppercase">
                                                        <a href="product-layout1.html">Floral Crop Top</a>
                                                    </div>
                                                    <!--End Product Name-->
                                                    <!--Product Price-->
                                                    <div class="product-price">
                                                        <span class="old-price">$199.00</span>
                                                        <span class="price">$219.00</span>
                                                    </div>
                                                    <!--End Product Price-->
                                                    <!--Product Review-->
                                                    <div class="product-review d-flex align-items-center justify-content-center">
                                                        <i class="an an-star"></i><i class="an an-star"></i><i class="an an-star"></i><i class="an an-star"></i><i class="an an-star-o"></i>
                                                        <span class="caption hidden ms-2">3 reviews</span>
                                                    </div>
                                                    <!--End Product Review-->
                                                    <!--Color Variant -->
                                                    <ul class="image-swatches swatches mb-0">
                                                        <li class="radius blue medium"><span class="swacth-btn"></span><span class="tooltip-label">Blue</span></li>
                                                        <li class="radius pink medium"><span class="swacth-btn"></span><span class="tooltip-label">Pink</span></li>
                                                        <li class="radius red medium"><span class="swacth-btn"></span><span class="tooltip-label">Red</span></li>
                                                        <li class="radius yellow medium"><span class="swacth-btn"></span><span class="tooltip-label">Yellow</span></li>
                                                    </ul>
                                                    <!--End Color Variant-->
                                                </div>
                                                <!--End Product Details-->
                                            </div>
                                            <div class="col-12 item">
                                                <!--Start Product Image-->
                                                <div class="product-image">
                                                    <!--Start Product Image-->
                                                    <a href="product-layout1.html" class="product-img">
                                                        <!-- image -->
                                                        <img class="primary blur-up lazyload" data-src="http://localhost/handwi_2024/public/front_end/assets/images/products/product-2.jpg" src="http://localhost/handwi_2024/public/front_end/assets/images/products/product-2.jpg" alt="image" title="">
                                                        <!-- End image -->
                                                        <!-- Hover image -->
                                                        <img class="hover blur-up lazyload" data-src="http://localhost/handwi_2024/public/front_end/assets/images/products/product-2-1.jpg" src="http://localhost/handwi_2024/public/front_end/assets/images/products/product-2-1.jpg" alt="image" title="">
                                                        <!-- End hover image -->
                                                        <!-- product label -->
                                                        <div class="product-labels"><span class="lbl on-sale rounded">Sale</span></div>
                                                        <!-- End product label -->
                                                    </a>
                                                    <!--End Product Image-->

                                                    <!--Product Button-->
                                                    <div class="button-set style0 d-none d-md-block">
                                                        <ul>
                                                            <!--Cart Button-->
                                                            <li><a class="btn-icon btn cartIcon pro-quickshop-popup" href="#pro-quickshop2" data-bs-toggle="offcanvas" data-bs-target="#pro-quickshop2" aria-controls="pro-quickshop2"><i class="icon an an-cart-l"></i> <span class="tooltip-label top">Quick Shop</span></a></li>
                                                            <!--End Cart Button-->
                                                            <!--Quick View Button-->
                                                            <li><a class="btn-icon quick-view-popup quick-view" href="javascript:void(0)" data-toggle="modal" data-target="#content_quickview"><i class="icon an an-search-l"></i> <span class="tooltip-label top">Quick View</span></a></li>
                                                            <!--End Quick View Button-->
                                                            <!--Wishlist Button-->
                                                            <li><a class="btn-icon wishlist add-to-wishlist" href="my-wishlist.html"><i class="icon an an-heart-l"></i> <span class="tooltip-label top">Add To Wishlist</span></a></li>
                                                            <!--End Wishlist Button-->
                                                            <!--Compare Button-->
                                                            <li><a class="btn-icon compare add-to-compare" href="compare-style2.html"><i class="icon an an-sync-ar"></i> <span class="tooltip-label top">Add to Compare</span></a></li>
                                                            <!--End Compare Button-->
                                                        </ul>
                                                    </div>
                                                    <!--End Product Button-->    

                                                    <!-- Product Quickshop Form -->
                                                    <div class="quickshop-content d-flex-center" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="pro-quickshop2">
                                                        <button type="button" class="btn-close text-reset ms-auto position-absolute top-0 end-0 m-1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                        <div class="offcanvas-body quickshop-variant h-100 d-flex align-items-start align-items-sm-center">
                                                            <form method="post" action="#" id="product_form_1053" class="product-form align-items-center text-center hidedropdown" accept-charset="UTF-8" enctype="multipart/form-data">
                                                                <!-- Product Price -->
                                                                <div class="product-single__price lh-1 mb-3 mt-0 mx-auto">
                                                                    <span class="visually-hidden">Regular price</span>
                                                                    <span class="product-price__sale--single">
                                                                        <span class="product-price-old-price d-none">$200.00</span><span class="product-price__price product-price__sale0">$199.00</span>   
                                                                    </span>
                                                                </div>
                                                                <!-- End Product Price -->
                                                                <!-- Swatches Color -->
                                                                <div class="swatches-image swatch clearfix mb-3 swatch-0 option1" data-option-index="0">
                                                                    <div class="product-form__item">
                                                                        <label class="label d-flex justify-content-center">Color:<span class="required d-none">*</span><span class="slVariant ms-1 fw-bold">Black</span></label>
                                                                        <ul class="swatches d-flex-justify-center list-unstyled m-0 clearfix">
                                                                            <li class="swatch-element rounded-0 color gray available active">
                                                                                <label class="swatchLbl rounded-0 color small gray" title="Gray"></label>
                                                                                <span class="tooltip-label top">Gray</span>
                                                                            </li>
                                                                            <li data-value="Peach" class="swatch-element rounded-0 color orange available">
                                                                                <label class="swatchLbl rounded-0 color small orange" title="Orange"></label>
                                                                                <span class="tooltip-label top">Orange</span>
                                                                            </li>
                                                                            <li data-value="White" class="swatch-element rounded-0 color brown available">
                                                                                <label class="swatchLbl rounded-0 color small brown" title="Brown"></label>
                                                                                <span class="tooltip-label top">Brown</span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <!-- End Swatches Color -->
                                                                <!-- Swatches Size -->
                                                                <div class="swatch clearfix mb-3 swatch-1 option2" data-option-index="1">
                                                                    <div class="product-form__item">
                                                                        <label class="label d-flex justify-content-center">Size:<span class="required d-none">*</span><span class="slVariant ms-1 fw-bold">S</span></label>
                                                                        <ul class="swatches-size d-flex-justify-center list-unstyled m-0 clearfix">
                                                                            <li data-value="S" class="swatch-element s available active">
                                                                                <label class="swatchLbl rounded-0 medium" title="S">S</label><span class="tooltip-label">S</span>
                                                                            </li>
                                                                            <li data-value="M" class="swatch-element m available">
                                                                                <label class="swatchLbl rounded-0 medium" title="M">M</label><span class="tooltip-label">M</span>
                                                                            </li>
                                                                            <li data-value="L" class="swatch-element l available">
                                                                                <label class="swatchLbl rounded-0 medium" title="L">L</label><span class="tooltip-label">L</span>
                                                                            </li>
                                                                            <li data-value="XL" class="swatch-element xl available">
                                                                                <label class="swatchLbl rounded-0 medium" title="XL">XL</label><span class="tooltip-label">XL</span>
                                                                            </li>
                                                                            <li data-value="XS" class="swatch-element xs soldout">
                                                                                <label class="swatchLbl rounded-0 medium" title="XS">XS</label><span class="tooltip-label">XS</span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <!-- End Swatches Size -->
                                                                <!-- Product Action -->
                                                                <div class="product-form-submit mx-auto">
                                                                    <button type="submit" name="add" class="btn rounded product-form__cart-submit btn-small px-3"><span>Add to cart</span></button>
                                                                    <button type="submit" name="add" class="btn rounded product-form__sold-out btn-small px-3 d-none" disabled="disabled">Sold out</button>
                                                                    <button type="button" name="buy" class="btn rounded btn-outline-primary proceed-to-checkout btn-small px-3 d-none">Buy it now</button>
                                                                </div>
                                                                <!-- End Product Action -->
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <!-- End Product Quickshop Form -->
                                                </div>
                                                <!--End Product Image-->
                                                <!--Start Product Details-->
                                                <div class="product-details text-center">
                                                    <!--Product Name-->
                                                    <div class="product-name text-uppercase">
                                                        <a href="product-layout1.html">Mini Sleev Top</a>
                                                    </div>
                                                    <!--End Product Name-->
                                                    <!--Product Price-->
                                                    <div class="product-price">
                                                        <span class="price">$199.00</span>
                                                    </div>
                                                    <!--End Product Price-->
                                                    <!--Product Review-->
                                                    <div class="product-review d-flex align-items-center justify-content-center">
                                                        <i class="an an-star"></i><i class="an an-star"></i><i class="an an-star"></i><i class="an an-star"></i><i class="an an-star"></i>
                                                        <span class="caption hidden ms-2">8 reviews</span>
                                                    </div>
                                                    <!--End Product Review-->
                                                    <!--Color Variant-->
                                                    <ul class="swatches mb-0">
                                                        <li class="swatch medium radius black"><span class="tooltip-label">Black</span></li>
                                                        <li class="swatch medium radius navy"><span class="tooltip-label">Navy</span></li>
                                                        <li class="swatch medium radius purple"><span class="tooltip-label">Purple</span></li>
                                                    </ul>
                                                    <!--End Color Variant-->
                                                </div>
                                                <!--End Product Details-->
                                            </div>
                                            <div class="col-12 item">
                                                <!--Start Product Image-->
                                                <div class="product-image">
                                                    <!--Start Product Image -->
                                                    <a href="product-layout1.html" class="product-img">
                                                        <!-- image -->
                                                        <img class="primary blur-up lazyload" data-src="http://localhost/handwi_2024/public/front_end/assets/images/products/product-3.jpg" src="http://localhost/handwi_2024/public/front_end/assets/images/products/product-3.jpg" alt="image" title="">
                                                        <!-- End image -->
                                                        <!-- Hover image -->
                                                        <img class="hover blur-up lazyload" data-src="http://localhost/handwi_2024/public/front_end/assets/images/products/product-3-1.jpg" src="http://localhost/handwi_2024/public/front_end/assets/images/products/product-3-1.jpg" alt="image" title="">
                                                        <!-- End hover image -->
                                                    </a>
                                                    <!--End Product Image-->
                                                    <!--Product label-->
                                                    <div class="product-labels"><span class="lbl pr-label1 rounded">New</span></div>
                                                    <!--Product label-->

                                                    <!--Product Button-->
                                                    <div class="button-set style0 d-none d-md-block">
                                                        <ul>
                                                            <!--Cart Button-->
                                                            <li><a class="btn-icon btn cartIcon pro-addtocart-popup" href="#pro-addtocart-popup"><i class="icon an an-cart-l"></i> <span class="tooltip-label top">Add to Cart</span></a></li>
                                                            <!--End Cart Button-->
                                                            <!--Quick View Button-->
                                                            <li><a class="btn-icon quick-view-popup quick-view" href="javascript:void(0)" data-toggle="modal" data-target="#content_quickview"><i class="icon an an-search-l"></i> <span class="tooltip-label top">Quick View</span></a></li>
                                                            <!--End Quick View Button-->
                                                            <!--Wishlist Button-->
                                                            <li><a class="btn-icon wishlist add-to-wishlist" href="my-wishlist.html"><i class="icon an an-heart-l"></i> <span class="tooltip-label top">Add To Wishlist</span></a></li>
                                                            <!--End Wishlist Button-->
                                                            <!--Compare Button-->
                                                            <li><a class="btn-icon compare add-to-compare" href="compare-style2.html"><i class="icon an an-sync-ar"></i> <span class="tooltip-label top">Add to Compare</span></a></li>
                                                            <!--End Compare Button-->
                                                        </ul>
                                                    </div>
                                                    <!--End Product Button-->  
                                                </div>
                                                <!--End Product Image-->
                                                <!--Start Product Details-->
                                                <div class="product-details text-center">
                                                    <!--Product name-->
                                                    <div class="product-name text-uppercase">
                                                        <a href="product-layout1.html">Ditsy Floral Dress</a>
                                                    </div>
                                                    <!--End product name-->
                                                    <!--Product price-->
                                                    <div class="product-price">
                                                        <span class="price">$99.00</span>
                                                    </div>
                                                    <!--End product price-->
                                                    <!--Product Review-->
                                                    <div class="product-review d-flex align-items-center justify-content-center">
                                                        <i class="an an-star"></i><i class="an an-star"></i><i class="an an-star"></i><i class="an an-star"></i><i class="an an-star-o"></i>
                                                        <span class="caption hidden ms-2">12 reviews</span>
                                                    </div>
                                                    <!--End Product Review-->
                                                    <!--Color Variant-->
                                                    <ul class="swatches mb-0">
                                                        <li class="swatch medium radius red"><span class="tooltip-label">red</span></li>
                                                        <li class="swatch medium radius orange"><span class="tooltip-label">orange</span></li>
                                                        <li class="swatch medium radius yellow"><span class="tooltip-label">yellow</span></li>
                                                    </ul>
                                                    <!--End Color Variant-->
                                                </div>
                                                <!--End Product Details-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--End Popular Products-->
                                <!--Banner-->
                                <div class="sidebar_widget static-banner">
                                    <a href="shop-fullwidth.html"><img src="http://localhost/handwi_2024/public/front_end/assets/images/shop-banner.jpg" alt="image"></a>
                                </div>
                                <!--End Banner-->
                            </div>
                        </div>
                        <!--End Sidebar-->

                        <!--Main Content-->
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 main-col">
                            <!--Active Filters-->
                            <ul class="active-filters d-flex flex-wrap align-items-center m-0 list-unstyled d-none">
                                <li><a href="#">Clear all</a></li>
                                <li><a href="#">Men <i class="an an-times-l"></i></a></li>
                                <li><a href="#">Neckalses <i class="an an-times-l"></i></a></li>
                                <li><a href="#">Accessories <i class="an an-times-l"></i></a></li>
                            </ul>
                            <!--End Active Filters-->
                            <!--Toolbar-->
                            <div class="toolbar mt-0">
                                <div class="filters-toolbar-wrapper">
                                    <ul class="list-unstyled d-flex align-items-center">
                                        <li class="product-count d-flex align-items-center">
                                            <button type="button" class="btn btn-filter d-flex align-items-center an an-slider-3 me-2 me-sm-3">Filter</button>
                                            <div class="filters-toolbar__item">
                                                <span class="filters-toolbar__product-count d-none d-sm-block"> 
                                                   Showing: 
                                                    @php
                                                        $start = $products->firstItem(); // Get the first item of the current page
                                                        $end = $products->lastItem(); // Get the last item of the current page
                                                    @endphp
                                                    {{ $start }} - {{ $end }} of {{ $products->total() }} products
                                                </span>
                                            </div>
                                        </li>
                                        <li class="collection-view ms-sm-auto">
                                            <div class="filters-toolbar__item collection-view-as d-flex align-items-center me-3">
                                                <a href="javascript:void(0)" class="change-view prd-grid change-view--active"><i class="icon an an-th" aria-hidden="true"></i><span class="tooltip-label">Grid View</span></a>
                                                <a href="javascript:void(0)" class="change-view prd-list"><i class="icon an an-th-list" aria-hidden="true"></i><span class="tooltip-label">List View</span></a>
                                            </div>
                                        </li>
                                        <!-- <li class="filters-sort ms-auto ms-sm-0">
                                            <div class="filters-toolbar__item">
                                                <label for="SortBy" class="hidden">Sort by:</label>
                                                <select name="SortBy" id="SortBy" class="filters-toolbar__input filters-toolbar__input--sort">
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
                                        </li> -->
                                        <li class="filters-sort ms-auto ms-sm-0">
                                            <div class="filters-toolbar__item">
                                                <label for="SortBy" class="hidden">Sort by:</label>
                                                <form id="sortForm" method="GET" action="{{ route('categoryproducts', ['id' => $categoryId]) }}">
                                                    <select name="SortBy" id="SortBy" class="filters-toolbar__input filters-toolbar__input--sort" onchange="document.getElementById('sortForm').submit();">
                                                        <option value="featured" {{ request('SortBy') == 'featured' ? 'selected' : '' }}>Featured</option>
                                                        <!-- <option value="best-selling" {{ request('SortBy') == 'best-selling' ? 'selected' : '' }}>Best selling</option> -->
                                                        <option value="title-ascending" {{ request('SortBy') == 'title-ascending' ? 'selected' : '' }}>Alphabetically, A-Z</option>
                                                        <option value="title-descending" {{ request('SortBy') == 'title-descending' ? 'selected' : '' }}>Alphabetically, Z-A</option>
                                                        <option value="price-ascending" {{ request('SortBy') == 'price-ascending' ? 'selected' : '' }}>Price, low to high</option>
                                                        <option value="price-descending" {{ request('SortBy') == 'price-descending' ? 'selected' : '' }}>Price, high to low</option>
                                                        <option value="created-ascending" {{ request('SortBy') == 'created-ascending' ? 'selected' : '' }}>Date, old to new</option>
                                                        <option value="created-descending" {{ request('SortBy') == 'created-descending' ? 'selected' : '' }}>Date, new to old</option>
                                                    </select>
                                                </form>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--End Toolbar-->

                            <!--Product Grid-->
                            <div class="grid-products grid--view-items shop-grid-5 prd-grid">
                                <div class="row">
                                   @if($products->isEmpty())
                                   <div class="alert alert-warning text-center" role="alert">
                                        <i class="align-middle icon an an-cart icon-large me-2"></i><strong>No products availabe.</strong>
                                    </div>
                                    @else
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
                                                <img class="primary blur-up lazyload" data-src="{{get_uploaded_image_url($firstImage,'product_image_upload_dir')}}" src="{{get_uploaded_image_url($firstImage,'product_image_upload_dir')}}" alt="image" title="" width="800" height="960">
                                                <!--End image-->
                                                <!--Hover image-->
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
                                                <!--End Wishlist Button-->
                                                <!--Quick View Button-->
                                                <!-- <a href="javascript:void(0)" title="Quick View" class="btn-icon quick-view-popup quick-view rounded" data-toggle="modal" data-target="#content_quickview">
                                                    <i class="icon an an-search-l"></i>
                                                    <span class="tooltip-label">Quick View</span>
                                                </a> -->
                                                <!--End Quick View Button-->
                                                <!--Compare Button-->
                                                <!-- <a class="btn-icon compare add-to-compare rounded" href="#" title="Add to Compare">
                                                    <i class="icon an an-sync-ar"></i>
                                                    <span class="tooltip-label">Add to Compare</span>
                                                </a> -->
                                                <!--End Compare Button-->
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
                                                <a href="{{ route('productdetails', ['id' => $product->id]) }}">{{$product->product_name}}  </a>
                                            </div>
                                            <!--End Product Name-->
                                            <!--Product Price-->
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
                                    @endif                                   
                                  
                                
                                  
                                  
                                  
                                </div>
                            </div>
                            <!--End Product Grid-->

                            <!--Pagination Classic-->
                            @if(!$products->isEmpty())
                            <hr class="clear">
                            <div class="pagination">
                                <ul>
                                    <li class="prev">@if ($products->onFirstPage()) <span><i class="icon align-middle an an-caret-left" aria-hidden="true"></i></span> @else <a href="{{ $products->previousPageUrl() }}"><i class="icon align-middle an an-caret-left" aria-hidden="true"></i></a> @endif</li>
                                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                        <li class="{{ $page == $products->currentPage() ? 'active' : '' }}">
                                            <a href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach
                                    <li class="next">@if ($products->hasMorePages()) <a href="{{ $products->nextPageUrl() }}"><i class="icon align-middle an an-caret-right" aria-hidden="true"></i></a> @else <span><i class="icon align-middle an an-caret-right" aria-hidden="true"></i></span> @endif</li>
                                </ul>
                            </div>
                            @endif
                            <!--End Pagination Classic-->

                            <!-- Collection Description-->
                            <!-- <div class="collection-description mt-4 pt-2">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard reader dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen the book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                            </div> -->
                            <!--End Collection Description-->
                        </div>
                        <!--End Main Content-->
                    </div>
                </div>
            </div>
           
@endsection   
@section('script')
 <script>
    function price_slider_giv() {
        let min = {{ $min_price }};
        let max = {{ $max_price }};
        let start = {{ $startPrice }};
        let end = {{ $endPrice }};
        
        $("#slider-range-give").slider({
            range: true,
            min: min,
            max: max,
            values: [start, end],
            slide: function (event, ui) {
                $("#amount").val("AED" + ui.values[0] + " - AED" + ui.values[1]);
                $('#start_price').val(ui.values[0]);
                $('#end_price').val(ui.values[1]);
            }
        });

        $("#amount").val("AED" + start + " - AED" + end);
    }

    price_slider_giv();
</script>
@endsection