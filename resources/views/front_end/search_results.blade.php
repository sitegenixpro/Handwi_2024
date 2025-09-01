@extends('front_end.template.layout')
@section('content')
  
<div id="page-content">
                <!--Collection Banner-->
                <div class="collection-header">
                    <div class="collection-hero">
                        <div class="collection-hero__image"></div>
                        <div class="collection-hero__title-wrapper container">
                            <h1 class="collection-hero__title">Search Products</h1>
                            <div class="breadcrumbs text-uppercase mt-1 mt-lg-2"><a href="{{ route('home') }}" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">Search Products</span></div>
                        </div>
                    </div>
                </div>
                <!--End Collection Banner-->

                <div class="container-fluid">
                    <div class="row">
                      

                        <!--Main Content-->
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 main-col">
                           
                            <!--Toolbar-->
                            <div class="toolbar mt-0">
                                <div class="filters-toolbar-wrapper">
                                    <ul class="list-unstyled d-flex align-items-center">
                                        <li class="product-count d-flex align-items-center">
                                           
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
                                        <!-- <li class="collection-view ms-sm-auto">
                                            <div class="filters-toolbar__item collection-view-as d-flex align-items-center me-3">
                                                <a href="javascript:void(0)" class="change-view prd-grid change-view--active"><i class="icon an an-th" aria-hidden="true"></i><span class="tooltip-label">Grid View</span></a>
                                                <a href="javascript:void(0)" class="change-view prd-list"><i class="icon an an-th-list" aria-hidden="true"></i><span class="tooltip-label">List View</span></a>
                                            </div>
                                        </li> -->
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