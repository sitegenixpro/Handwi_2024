<div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2 item" style="display: block;">
    <div class="product-image">
        @php
            $images = explode(',', $product->image);
            $firstImage = $images[0] ?? 'default.jpg'; // Fallback for missing image
        @endphp
        <a href="{{ route('productdetails', ['id' => $product->id]) }}" class="product-img">
            <img class="primary blur-up lazyload" data-src="{{ asset('uploads/products/'.$firstImage) }}" src="{{ asset('uploads/products/'.$firstImage) }}" alt="image" title="" width="800" height="960">
            <img class="hover blur-up lazyload" data-src="{{ asset('uploads/products/'.$firstImage) }}" src="{{ asset('uploads/products/'.$firstImage) }}" alt="image" title="" width="800" height="960">
        </a>
    </div>
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
    <div class="product-details text-center">
        <div class="product-name text-uppercase">
            <a href="{{ route('productdetails', ['id' => $product->id]) }}">{{ $product->product_name }}</a>
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
</div>
