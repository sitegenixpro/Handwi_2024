@foreach($products as $product)
                                        <div class="col-6 col-sm-6 col-md-4 col-lg-3 item" style="display: block;">
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
                                                
                                            </div>
                                            <!--End Product Details-->
                                        </div>
                                        @endforeach