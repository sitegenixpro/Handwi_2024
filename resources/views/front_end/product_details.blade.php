@extends('front_end.template.layout')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>

    /* Vertical thumbs on right */
    .fancybox-thumbs {
        top: 0;
        right: 0;
        left: auto;
        width: 200px;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        padding: 10px 5px;
    }
    
    .fancybox-thumbs > ul > li {
        display: block;
        float: none;
        margin: 0 auto 10px;
        border-color: #fff;
        max-width: 100%;
        cursor: pointer;
    }
    
    /* Adjust content area */
    .fancybox-slide {
        /*padding-right: 230px; */
        /* Increased to match wider thumbs */
    }
    
    /* Video specific adjustments */
    .fancybox-slide--video .fancybox-content,
    .fancybox-slide--iframe .fancybox-content {
        /*width: calc(100% - 230px) !important;*/
        /*max-width: calc(100% - 230px) !important;*/
        /*margin-right: 230px;*/
    }
    
    /* Fix for video thumbnails */
    .fancybox-thumbs__list a:before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: rgba(0,0,0,0.2);
        z-index: 10;
    }
    
    .fancybox-thumbs__list a.video-thumb:after {
        content: '▶';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 20px;
        z-index: 11;
    }
    .overlay-video-fancy{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        /* background: red; */
    }
</style>

    <style>
      .product-slider-wrapper {
        display: flex;
        flex-direction: row-reverse;
        gap: 10px;
      }
      
      .swiper {
        width: 100%;
        height: 100%;
      }
      
      .thumbnail-container {
        position: relative;
        height: 565px;
        width: 120px;
      }
      
      .mySwiper2 {
        height: 565px;
        width: 100%;
        flex-grow: 1;
      }
      
      .mySwiper {
        height: 100%;
        width: 100%;
      }
      
      .swiper-slide {
        text-align: center;
        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
      }
      
      .swiper-slide img,
      .swiper-slide video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 6px;
      }
      
      /* Thumbnail styles */
      .mySwiper .swiper-slide {
        width: 100% !important;
        height: calc((100% - 70px) / 8) !important;
        opacity: 0.4;
        transition: opacity 0.3s;
        cursor: pointer;
      }
      
      .mySwiper .swiper-slide-thumb-active {
        opacity: 1;
        border: 2px solid #000;
        border-radius: 6px;
      }
      
      /* Video specific styles */
      .video-poster-thump {
        position: relative;
      }
      
      .video-poster-thump .play-btn {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 30px;
        height: 30px;
        background: #ffffff;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 2;
      }
      
      .video-poster-thump .play-btn i {
        font-size: 12px;
      }
      
      .swiper-slide video {
        cursor: pointer;
      }
      
      /* Hide native video controls */
      video::-webkit-media-controls {
        display: none !important;
      }
      
      /* Navigation buttons */
      .swiper-nav-btn {
        position: absolute;
        left: 0;
        width: 100%;
        height: 30px;
        background: rgba(0,0,0,0.5);
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
      }
      
      .swiper-nav-btn svg {
        width: 20px;
        height: 20px;
        fill: white;
      }
      
      .swiper-nav-top {
        top: 0;
      }
      
      .swiper-nav-bottom {
        bottom: 0;
      }
      
      /* Play/pause indicator */
      .swiper-slide.video-paused::after {
        content: "▶";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 40px;
        opacity: 0.8;
        z-index: 2;
        pointer-events: none;
      }
    </style>
    <style>
        .custom-choose-wrap{
            display: flex;
        }
        .attr-wrap .title{
            display: inline-block;
            margin-bottom: 8px;
        }
        /* Customize the label (the container) */
        .attr-wrap .check-container {
          display: block;
          position: relative;
          /*margin-bottom: 12px;*/
          margin-right: 10px;
          cursor: pointer;
          font-size: 14px;
          -webkit-user-select: none;
          -moz-user-select: none;
          -ms-user-select: none;
          user-select: none;
          border: 1px solid #F6F6F6;
          background: #F6F6F6;
          padding: 6px 25px;
        }
        
        /* Hide the browser's default checkbox */
        .attr-wrap .check-container input {
          position: absolute;
          opacity: 0;
          cursor: pointer;
          height: 0;
          width: 0;
        }
        
        /* Create a custom checkbox */
        .attr-wrap .checkmark {
          /*position: absolute;*/
          top: 0;
          left: 0;
          height: 25px;
          width: 25px;
          background-color: #eee;
        }
        
        /* On mouse-over, add a grey background color */
        .attr-wrap .check-container:hover input ~ .checkmark {
          background-color: #ccc;
        }
        
        /* When the checkbox is checked, add a blue background */
        .attr-wrap .check-container input:checked ~ .checkmark {
          background-color: #2196F3;
        }
        
        /* Create the checkmark/indicator (hidden when not checked) */
        .attr-wrap .checkmark:after {
          content: "";
          position: absolute;
          display: none;
        }
        
        /* Show the checkmark when checked */
        .attr-wrap .check-container input:checked ~ .checkmark:after {
          display: block;
        }
        
        .attr-wrap .check-container input:checked ~ .title-txt{
            color: #FFFFFF;
        }
        
        /* Style the checkmark/indicator */
        .attr-wrap .check-container .checkmark:after {
          left: 0px;
          top: 0px;
          width: 100%;
          height: 100%;
          /*border: solid white;*/
          /*border-width: 0 3px 3px 0;*/
          /*-webkit-transform: rotate(45deg);*/
          /*-ms-transform: rotate(45deg);*/
          /*transform: rotate(45deg);*/
          background: #000;
        }
        .title-txt{
            position: relative;
            z-index: 1;
            color: #6C727F;
            font-weight: 600;
        }
        
    .position-sticky{
        position: -webkit-sticky;
      position: sticky;
      top: 10px;
    }
    </style>
    <!--Body Container-->
    <div id="page-content">   
                <!--Breadcrumbs-->
                <div class="breadcrumbs-wrapper text-uppercase">
                    <div class="container">
                        
                        <div class="breadcrumbs"><a href="{{ route('home') }}" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">{{$product->product_name}}</span></div>
                    </div>
                </div>
                <!--End Breadcrumbs-->

                <!--Main Content-->
                <div class="container">
                    <!--Product Content-->
                    <div class="product-single">
                        <div class="row">
                            <div class="col-lg-7 col-md-6 col-sm-12 col-12">
                                
                                <div class="position-sticky">
                                    
                                
                                    @php
                                        $imageString = $product->image;
                                        $images = explode(',', $imageString); 
                                        $firstImage = get_uploaded_image_url($images[0],'product_image_upload_dir'); 
                                    @endphp
                                    
                                    
                                    <!-- HTML Structure -->
                                    <div class="product-slider-wrapper">
                                      <!-- Main Slider -->
                                      <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2">
                                        <div class="swiper-wrapper">
                                        <!--@foreach($images as $image)-->
                                        <!--@if(!empty($image))-->
                                        <!-- <div class="swiper-slide">-->
                                        <!--      <a data-fancybox="gallery" href="{{get_uploaded_image_url($image,'product_image_upload_dir')}}" data-thumb="{{get_uploaded_image_url($image,'product_image_upload_dir')}}">-->
                                        <!--        <img src="{{get_uploaded_image_url($image,'product_image_upload_dir')}}" />-->
                                        <!--      </a>-->
                                        <!--  </div>-->
                                        <!--  @endif-->
                                        <!--  @endforeach-->
                                          @foreach($sproduct['product_images'] ?? [] as $image)
                                          @if(!empty($image) )
                                         <div class="swiper-slide">
                                              <a data-fancybox="gallery" href="{{$image}}" data-thumb="{{ $image }}">
                                                <img src="{{$image}}" />
                                              </a>
                                          </div>
                                          @endif
                                          @endforeach
                                          @if(!empty($video_url))
                                            @php
                                                $videoURL = !empty($video_url) ? get_uploaded_image_url($video_url, 'product_image_upload_dir') : '';
                                                $video_thumbnail = !empty($video_thumbnail) ? get_uploaded_image_url($video_thumbnail, 'product_image_upload_dir') : '';   
                                            @endphp
                                          <!--<div class="swiper-slide">-->
                                          <!--    <a data-fancybox="gallery" href="{{$videoURL}}" data-type="video"  data-thumb="{{ $video_thumbnail }}">-->
                                          <!--      <img src="{{$video_thumbnail}}" />-->
                                          <!--      <div class="video-play-overlay"></div>-->
                                          <!--    </a>-->
                                          <!--</div>-->
                                          <div class="swiper-slide">
                                             <a class="overlay-video-fancy" data-fancybox="gallery" href="{{$videoURL}}" data-type="video"  data-thumb="{{ $video_thumbnail }}"></a>
                                            <video autoplay muted loop playsinline width="100%" height="100%">
                                              <source src="{{$videoURL}}" type="video/mp4" poster="{{ $video_thumbnail }}">
                                            </video>
                                            <div class="video-play-overlay"></div>
                                          </div>
                                          @endif
                                        
                                         
                                         
                                        </div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                      </div>
                                      
                                      <!-- Thumbnail Slider (Vertical) -->
                                      <div class="thumbnail-container">
                                        <div class="swiper-nav-btn swiper-nav-top" onclick="scrollThumbs('up')">
                                          <svg viewBox="0 0 24 24"><path d="M7 15l5-5 5 5"/></svg>
                                        </div>
                                        <div thumbsSlider="" class="swiper mySwiper">
                                          <div class="swiper-wrapper">
                                          <!--@foreach($images as $image)-->
                                          <!--@if(!empty($image))-->
                                          <!--  <div class="swiper-slide">-->
                                          <!--    <img src="{{get_uploaded_image_url($image,'product_image_upload_dir')}}" />-->
                                          <!--  </div>-->
                                          <!--  @endif-->
                                          <!--  @endforeach-->
                                            @foreach($sproduct['product_images'] as $image)
                                            @if(!empty($image) )
                                            <div class="swiper-slide">
                                              <img src="{{$image}}" />
                                            </div>
                                            @endif
                                            @endforeach
                                            @if(!empty($video_url))
                                            @php
                                                $videoURL = !empty($video_url) ? get_uploaded_image_url($video_url, 'product_image_upload_dir') : '';
                                               
                                            @endphp
                                            <div class="swiper-slide video-poster-thump">
                                              <span class="play-btn">
                                                <i class="an an-play-r" aria-hidden="true"></i>
                                              </span>
                                              <img src="{{$video_thumbnail}}" />
                                            </div>

                                            @endif
                                            
                                          </div>
                                        </div>
                                        <div class="swiper-nav-btn swiper-nav-bottom" onclick="scrollThumbs('down')">
                                          <svg viewBox="0 0 24 24"><path d="M7 10l5 5 5-5"/></svg>
                                        </div>
                                      </div>
                                    </div>
                                    
                                    
                                    
                            
                                
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-6 col-sm-12 col-12">
                                <!-- Product Info -->
                                <div class="product-single__meta mb-0">
                                    <h1 class="product-single__title">{{ $sproduct['product_name'] }}</h1>
                                    @php
                                        $rating = $product->average_rating;  
                                        $ratedUsers = $product->rated_users;  
                                        
                                    @endphp
                                    <!-- <div class="product-single__subtitle">From Italy</div> -->
                                    <!-- Product Reviews -->
                                    <div class="product-review mb-2">
                                        <a class="reviewLink d-flex-center" href="#reviews">
                                            @for ($i = 0; $i < 5; $i++)
                                                @if ($i < $rating) 
                                                    <i class="an an-star"></i>  <!-- Full star -->
                                                @else
                                                    <i class="an an-star-o"></i>  <!-- Empty star -->
                                                @endif
                                            @endfor
                                            <span class="spr-badge-caption ms-2">{{ $product->total_reviews }} Reviews</span>
                                        </a>
                                    </div>

                                    @php
                                        $store = isset($vendor->stores) && $vendor->stores->first() ? $vendor->stores->first() : null;
                                    @endphp

                                    <div class="product-info">
                                        <p class="product-type">
                                            by: 
                                            @if ($store)
                                                <a href="{{ route('storedetails', ['id' => $store->vendor_id]) }}">
                                                    <span>{{ $store->store_name ?? 'N/A' }}</span>
                                                </a>
                                            @else
                                                <span>N/A</span>
                                            @endif
                                        </p>
                                    </div>

                                    
                                    <!-- <div class="product-info">
                                        <p class="product-type">by: <a href="{{ route('storedetails', ['id' => $vendor->stores->first()->vendor_id]) }}" ><span>{{ isset($vendor->stores) && $vendor->stores->first() && isset($vendor->stores->first()->store_name) && $vendor->stores->first()->store_name ? $vendor->stores->first()->store_name : 'N/A' }}</span></a></p>  
                                        
                                    </div> -->
                                    
                                    <select class="form-select mb-3 d-none" aria-label="Select Color">
                                          <option selected>Select Color</option>
                                          <option value="1">Green</option>
                                          <option value="2">Blue</option>
                                          <option value="3">Red</option>
                                        </select>
                                        
                                        
                                    <!-- @if($product->product_type==2 && isset($sproduct['product_variations']))
                                    @php
                                    // Get URL query parameters
                                    $selectedColor = request()->get('color');
                                    $selectedSize = request()->get('size');
                                
                                    // Prepare fallback values from $sproduct
                                    $defaultColor = null;
                                    $defaultSize = null;
                                
                                    if (!empty($sproduct['selected_attribute_list'])) {
                                        foreach ($sproduct['selected_attribute_list'] as $attr) {
                                            if (strtolower($attr->attribute_name) == 'color') {
                                                $defaultColor = $attr->attribute_values_id;
                                            } elseif (strtolower($attr->attribute_name) == 'size') {
                                                $defaultSize = $attr->attribute_values_id;
                                            }
                                        }
                                    }
                                @endphp
                                    @foreach($sproduct['product_variations'] as $variation)
                                    @php
            $attrName = strtolower($variation['attribute_name']);
        @endphp
                                    <div class="attr-wrap mt-3">
                                        <span class="title">{{$variation['attribute_name']}}</span>
                                        
                                        
                                        <div class="custom-choose-wrap">
                                            @foreach($variation['attribute_values'] as $color)
                                                 @php
                                                 $val=$color;
                        $valId = (isset($sproduct['product_variations'][0]) && isset($sproduct['product_variations'][1]))
                            ? $val['attribute_value_id']
                            : $val['product_attribute_id'];
                            
                             $variation_type = (isset($sproduct['product_variations'][0]) && isset($sproduct['product_variations'][1]))
                            ? 'multiple'
                            : 'single';
                            
                           

                        // Check for selected based on priority: URL > fallback
                        $shouldCheck = false;
                       
                        if ($attrName === 'color') {
                       
                            $shouldCheck = ($selectedColor && $selectedColor == $valId) || (!$selectedColor && $defaultColor == $valId);
                        } elseif ($attrName === 'size') {
                            $shouldCheck = ($selectedSize && $selectedSize == $valId) || (!$selectedSize && $defaultSize == $valId);
                        }
                        
                        if($variation_type=='single' && empty($selectedColor) && empty($selectedSize)){
                        $shouldCheck = ( $sproduct['product_variant_id'] == $valId) || (!$selectedSize && $defaultSize == $valId);
                        }
                    @endphp
                                     <label class="check-container">
                                              <input {{ $shouldCheck ? 'checked' : '' }} type="radio" class="variation{{$variation['attribute_name']}}" value="{{(isset($sproduct['product_variations'][0]) && isset($sproduct['product_variations'][1]))?$color['attribute_value_id']:$color['product_attribute_id']}}" name="colorsattr{{$variation['attribute_name']}}" >
                                              <span class="checkmark"></span>
                                              <span class="title-txt">{{$color['attribute_value_name']}}</span>
                                            </label>
                                                
                                                @endforeach
                                           
                                            
                                            
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif -->
                                    @if($product->product_type == 2 && isset($sproduct['product_variations']))
                                        @php
                                            $selectedColor = request()->get('color');
                                            $selectedSize = request()->get('size');

                                            $defaultColor = null;
                                            $defaultSize = null;

                                            if (!empty($sproduct['selected_attribute_list'])) {
                                                foreach ($sproduct['selected_attribute_list'] as $attr) {
                                                    if (strtolower($attr->attribute_name) == 'color') {
                                                        $defaultColor = $attr->attribute_values_id;
                                                    } elseif (strtolower($attr->attribute_name) == 'size') {
                                                        $defaultSize = $attr->attribute_values_id;
                                                    }
                                                }
                                            }
                                        @endphp

                                        @foreach($sproduct['product_variations'] as $variation)
                                            @php
                                                $attrName = strtolower($variation['attribute_name']);
                                                $inputName = 'colorsattr' . $variation['attribute_name'];
                                                $selectedValue = null;

                                                if ($attrName === 'color') {
                                                    $selectedValue = $selectedColor ?? $defaultColor;
                                                } elseif ($attrName === 'size') {
                                                    $selectedValue = $selectedSize ?? $defaultSize;
                                                }

                                                $variation_type = (isset($sproduct['product_variations'][0]) && isset($sproduct['product_variations'][1]))
                                                    ? 'multiple'
                                                    : 'single';

                                                if ($variation_type == 'single' && empty($selectedColor) && empty($selectedSize)) {
                                                    $selectedValue = $sproduct['product_variant_id'] ?? $defaultSize;
                                                }
                                            @endphp

                                            <div class="form-group mt-3">
                                                <label for="{{ $inputName }}" class="font-weight-bold">{{ $variation['attribute_name'] }}</label>
                                                <select class="form-control" name="{{ $inputName }}" id="{{ $inputName }}">
                                                    @foreach($variation['attribute_values'] as $option)
                                                        @php
                                                            $valId = (isset($sproduct['product_variations'][0]) && isset($sproduct['product_variations'][1]))
                                                                ? $option['attribute_value_id']
                                                                : $option['product_attribute_id'];
                                                            $isSelected = $selectedValue == $valId;
                                                        @endphp
                                                        <option value="{{ $valId }}" {{ $isSelected ? 'selected' : '' }}>
                                                            {{ $option['attribute_value_name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endforeach
                                    @endif

                                    
                                    

                                    <div class="product-single__price items-icons-tab pb-1 w-100">
                                            <ul class="swatches-size d-flex-center list-unstyled clearfix">
                                                @foreach($features as $feature)
                                                <li data-value="S" class="swatch-element">
                                                    <a href="#" title="Handmade"><img src="{{get_uploaded_image_url($feature->image_path,'features_images_dir')}}" alt=""></a>
                                                </li>
                                                @endforeach
                                               
                                            </ul>
                                    </div>
                                    <!-- End Product Info -->
                                    <!-- Product Price -->
                                    @php
                                        $regularPrice = $sproduct['regular_price'];
                                        $salePrice = $sproduct['sale_price'];
                                        $discount = 0;

                                        // Calculate discount percentage if there's a sale price
                                        if ($salePrice && $regularPrice > $salePrice) {
                                            $discount = round((($regularPrice - $salePrice) / $regularPrice) * 100);
                                            $saveAmount = $regularPrice - $salePrice;
                                        }
                                    @endphp
                                    <div class="product-single__price pb-1 mt-2">
                                    <span class="visually-hidden">Regular price</span>
                                    <span class="product-price__sale--single">
                                        @if ($salePrice && $salePrice < $regularPrice)
                                            <!-- Show Regular Price if Sale Price is less -->
                                            <span class="product-price-old-price">{{ number_format($regularPrice, 2) }} AED</span>
                                            <span class="product-price__price product-price__sale">{{ number_format($salePrice, 2) }} AED</span>
                                            
                                            <!-- Calculate and show savings and discount -->
                                            @php
                                                $saveAmount = $regularPrice - $salePrice;
                                                $discount = round(($saveAmount / $regularPrice) * 100); // Calculate the percentage discount
                                            @endphp
                                            <span class="discount-badge">
                                                <span class="devider me-2">|</span>
                                                <span>Save: </span>
                                                <span class="product-single__save-amount">
                                                    <span class="money">{{ number_format($saveAmount, 2) }} AED</span>
                                                </span>
                                                <span class="off ms-1">(<span>{{ $discount }}% OFF</span>)</span>
                                            </span>
                                        @else
                                            <!-- If no sale price or the sale price is not less, just show the regular price -->
                                            <span class="product-price__price">{{ number_format($regularPrice, 2) }} AED</span>
                                        @endif
                                    </span>

                                        <!-- <div class="product__policies fw-normal mt-1">Tax included.</div> -->
                                    </div>
                                    <!-- End Product Price -->
                                    <!-- Countdown -->
                                    <!-- <div class="countdown-text d-flex-wrap mb-3 pb-1">
                                        <label class="mb-2 mb-lg-0">Limited-Time Offer :</label>
                                        <div class="prcountdown d-flex" data-countdown="2024/10/01"></div>
                                    </div> -->
                                    <!-- End Countdown -->
                                    <!-- Product Sold -->
                                    <!-- <div class="orderMsg d-flex-center" data-user="23" data-time="24">
                                        <img src="assets/images/order-icon.jpg" alt="order" />
                                        <p class="m-0"><strong class="items">8</strong> Sold in last <strong class="time">14</strong> hours</p>
                                        <p id="quantity_message" class="ms-2 ps-2 border-start">Hurry! Only  <span class="items fw-bold">4</span>  left in stock.</p>
                                    </div> -->
                                    <!-- End Product Sold -->
                                </div>
                                <!-- End Product Info -->
                                <!-- Product Form -->
                                 
                                @if($product->personalisation==1) 
                                <div class="d-flex align-items-center gap-2 justify-content-between">
                                    <a href="#!" class="fs-16 mb-2 d-inline-block text-black" data-bs-toggle="modal" data-bs-target="#personalisation" data-product-id="{{ $product->product_id }}">Your Personalization</a>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="#!" class="text-black fs-16 mb-2 d-none" id="personalisation-edit">Edit</a>
                                        <input type="hidden" id="personalization_id" name="personalization_id">
                                        <a href="#!" class="text-danger fs-16 mb-2 d-none" id="personalisation-delete">Delete</a>
                                    </div>
                                </div>
                                <p class="fs-14 mb-2" id="display_note"></p>
                                <p class="text-danger mb-3" id="display_file_name_wrap" style="color: #D4B2A7"> <a href="#" target="_blank" id="display_file_link" class="text-danger fs-14"></a></p>
                                @endif
                                
                                <form method="post" action="#" class="product-form hidedropdown" enctype="multipart/form-data">
                                    <!-- Swatches Color -->
                                   
                                    <!-- End Swatches Size -->
                                    <!-- Product Action -->
                                    

                                    <div class="product-action w-100 clearfix">
                                        <div class="product-form__item--quantity d-flex-center mb-3">
                                            <div class="qtyField">
                                                <a class="qtyBtn minus" href="javascript:void(0);"><i class="icon an an-minus-r" aria-hidden="true"></i></a>
                                                <input type="text" name="quantity" value="1" class="product-form__input qty">
                                                <a class="qtyBtn plus" href="javascript:void(0);"><i class="icon an an-plus-r" aria-hidden="true"></i></a>
                                            </div>
                                            <div class="pro-stockLbl ms-3">
                                                  
                                                    @if($stock > 0)
                                                    <span class="d-flex-center stockLbl instock"><i class="icon an an-check-cil"></i><span> In stock</span></span>
                                                    @else
                                                    <span class="d-flex-center stockLbl outstock "><i class="icon an an-times-cil"></i> <span>Sold out</span></span>
                                                        
                                                    @endif
                                                <!-- <span class="d-flex-center stockLbl instock"><i class="icon an an-check-cil"></i><span> In stock</span></span> -->
                                                <span class="d-flex-center stockLbl preorder d-none"><i class="icon an an-clock-r"></i><span> Pre-order Now</span></span>
                                                <span class="d-flex-center stockLbl outstock d-none"><i class="icon an an-times-cil"></i> <span>Sold out</span></span>
                                                <span class="d-flex-center stockLbl lowstock d-none" data-qty="15"><i class="icon an an-exclamation-cir"></i><span> Order now, Only  <span class="items">10</span>  left!</span></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="product-form__item--submit col-lg-6 mb-2">
                                                <button type="button" name="add" class="btn rounded product-form__cart-submit" data-variation_id="{{$sproduct['product_variant_id']}}" data-product-id="{{ $product->id }}"><span>Add to cart</span></button>
                                                <button type="submit" name="add" class="btn rounded product-form__sold-out d-none" disabled="disabled">Sold out</button>
                                            </div>
                                            <div class="product-form__item--buyit col-lg-6 mb-2 clearfix">
                                                <a href="javascript:void(0);" type="button" class="btn rounded btn-outline-primary proceed-to-checkout proceed-to-checkout-buy-now" data-product-id="{{ $product->id }}">Buy it now</a>
                                            </div>
                                        </div>
                                        <div class="agree-check customCheckbox clearfix d-none">
                                            <input id="prTearm" name="tearm" type="checkbox" value="tearm" required />
                                            <label for="prTearm">I agree with the terms and conditions</label>
                                        </div>
                                    </div>
                                    <!-- End Product Action -->
                                    <!-- Product Info link -->
                                    <!-- <p class="infolinks d-flex-center mt-2 mb-3">
                                        <a class="btn add-to-wishlist d-none" href="my-wishlist.html"><i class="icon an an-heart-l me-1" aria-hidden="true"></i> <span>Add to Wishlist</span></a>
                                        <a class="btn add-to-wishlist" href="compare-style1.html"><i class="icon an an-sync-ar me-1" aria-hidden="true"></i> <span>Add to Compare</span></a>
                                        <a class="btn shippingInfo" href="#ShippingInfo"><i class="icon an an-paper-l-plane me-1"></i> Delivery &amp; Returns</a>
                                        <a class="btn emaillink me-0" href="#productInquiry"> <i class="icon an an-question-cil me-1"></i> Ask A Question</a>
                                    </p> -->
                                    <!-- End Product Info link -->
                                </form>
                              
                                <!-- End Product Form -->
                                <!-- Social Sharing -->
                                <div class="social-sharing d-flex-center mb-3">
                                    <span class="sharing-lbl me-2">Share :</span>
                                    <a href="#" target="_blank" rel="noopener noreferrer" class="d-flex-center btn btn-link btn--share share-facebook" data-bs-toggle="tooltip" data-bs-placement="top" title="Share on Facebook"><i class="icon an an-facebook mx-1"></i><span class="share-title d-none">Facebook</span></a>
                                    <a href="#" target="_blank" rel="noopener noreferrer" class="d-flex-center btn btn-link btn--share share-twitter" data-bs-toggle="tooltip" data-bs-placement="top" title="Tweet on Twitter"><i class="icon an an-twitter mx-1"></i><span class="share-title d-none">Tweet</span></a>
                                    <a href="#" target="_blank" rel="noopener noreferrer" class="d-flex-center btn btn-link btn--share share-pinterest" data-bs-toggle="tooltip" data-bs-placement="top" title="Pin on Pinterest"><i class="icon an an-pinterest-p mx-1"></i> <span class="share-title d-none">Pin it</span></a>
                                    <a href="#" target="_blank" rel="noopener noreferrer" class="d-flex-center btn btn-link btn--share share-linkedin" data-bs-toggle="tooltip" data-bs-placement="top" title="Share on Linkedin"><i class="icon an an-linkedin mx-1"></i><span class="share-title d-none">Linkedin</span></a>
                                    <a href="#" target="_blank" rel="noopener noreferrer" class="d-flex-center btn btn-link btn--share share-email" data-bs-toggle="tooltip" data-bs-placement="top" title="Share by Email"><i class="icon an an-envelope-l mx-1"></i><span class="share-title d-none">Email</span></a>
                                </div>
                                
                                
                                <!-- End Social Sharing -->
                                <!-- Product Info -->
                                <!-- <div class="freeShipMsg" data-price="199"><i class="icon an an-truck" aria-hidden="true"></i>SPENT <b class="freeShip"><span class="money" data-currency-usd="$199.00" data-currency="USD">$199.00</span></b> MORE FOR FREE SHIPPING</div> -->
                                <!-- <div class="shippingMsg"><i class="icon an an-clock-r" aria-hidden="true"></i>Estimated Delivery Between <b id="fromDate">Wed, May 1</b> and <b id="toDate">Tue, May 7</b>.</div> -->
                                <!-- <div class="userViewMsg" data-user="20" data-time="11000"><i class="icon an an-eye-r" aria-hidden="true"></i><strong class="uersView">21</strong> People are Looking for this Product</div>
                                <div class="trustseal-img mt-4"><img src="assets/images/powerby-cards.jpg" alt="powerby cards" /></div> -->
                                <!-- End Product Info -->
                                 <div class="vendor-stk-detail-area align-items-center">
                                     @if (isset($vendor->stores) && $vendor->stores->first() && file_exists(public_path('storage/' . $vendor->stores->first()->logo)))
                                     <a href="{{ route('storedetails', ['id' => $vendor->stores->first()->vendor_id]) }}" > <img src="{{ asset('') }}storage/{{$vendor->stores->first()->logo}} " alt="" class="log-are"></a>
                                    @else
                                        <img src="{{ asset('front_end/assets/images/logo-placeholder.jpg') }}" alt="" class="log-are">
                                    @endif
                                    <div class="vendor-stk-dtl">
                                    <a href="{{ route('storedetails', ['id' => $vendor->stores->first()->vendor_id]) }}" > <h4 class="v-name">    {{ isset($vendor->stores) && $vendor->stores->first() && isset($vendor->stores->first()->store_name) && $vendor->stores->first()->store_name ? $vendor->stores->first()->store_name : 'N/A' }}</h4></a>
                                    <a href="{{ route('storedetails', ['id' => $vendor->stores->first()->vendor_id]) }}" > <p class="loc">{{ isset($vendor->stores) && $vendor->stores->first() && isset($vendor->stores->first()->location) && $vendor->stores->first()->location ? $vendor->stores->first()->location : 'N/A' }}</p></a>
                                        <div class="btm-bar">
                                            <span class="star-ratin"><svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0.829374 7.7504L3.05437 9.3754L2.20937 11.9923C2.07282 12.3981 2.07109 12.8373 2.20444 13.2442C2.3378 13.6511 2.59909 14.0041 2.94937 14.2504C3.29366 14.5046 3.71087 14.6408 4.13885 14.6387C4.56682 14.6366 4.98265 14.4962 5.32437 14.2385L7.5 12.6373L9.67625 14.2366C10.0199 14.4894 10.4349 14.6267 10.8615 14.6288C11.2881 14.6309 11.7044 14.4976 12.0505 14.2482C12.3966 13.9988 12.6547 13.6461 12.7877 13.2407C12.9207 12.8353 12.9217 12.3983 12.7906 11.9923L11.9456 9.3754L14.1706 7.7504C14.5138 7.49947 14.769 7.14649 14.8996 6.74189C15.0302 6.33729 15.0296 5.90176 14.8979 5.49752C14.7662 5.09327 14.5101 4.74098 14.1663 4.49096C13.8224 4.24095 13.4083 4.106 12.9831 4.1054H10.25L9.42062 1.5204C9.2902 1.1135 9.03392 0.758532 8.68873 0.506689C8.34354 0.254847 7.92729 0.119141 7.5 0.119141C7.07271 0.119141 6.65646 0.254847 6.31127 0.506689C5.96608 0.758532 5.7098 1.1135 5.57937 1.5204L4.75 4.1054H2.01937C1.59421 4.106 1.18012 4.24095 0.836236 4.49096C0.492354 4.74098 0.236274 5.09327 0.104574 5.49752C-0.0271252 5.90176 -0.0277081 6.33729 0.102909 6.74189C0.233526 7.14649 0.488662 7.49947 0.831874 7.7504H0.829374Z" fill="#D4B2A7"/>
                                                </svg>
                                                4.5
                                            </span>
                                            @if (isset($vendor->stores) && $vendor->stores->first() && isset($vendor->stores->first()->vendor_id) && !empty($vendor->stores->first()->vendor_id))
                                            <a href="{{ route('storedetails', ['id' => $vendor->stores->first()->vendor_id]) }}" class="btn btn-outline-primary">View Store</a>
                                             @endif
                                        </div>
                                        @if (isset($vendor->stores) && $store = $vendor->stores->first())
                                            @php
                                                $deliveryType = $store->delivery_type ?? 'standard';
                                                $standardText = $store->standard_delivery_text ?? '';
                                                $minDays = $store->delivery_min_days;
                                                $maxDays = $store->delivery_max_days;
                                            @endphp

                                            <div class="delivery-info mt-2">
                                                {{-- Always show standard delivery --}}
                                                <p id="sandard_delivery_range"><strong>Standard Delivery :</strong> {{ $standardText }}</p>
                                             

                                                {{-- Show custom delivery details only if personalisation is enabled --}}
                                                @if ($product->personalisation == 1 )
                                                    @if (!empty($minDays) && !empty($maxDays))
                                                        <p id="custom_delivery_range" style="display: none;"> <strong>Estimated Custom Delivery:</strong> {{ $minDays }} - {{ $maxDays }} days</p>
                                                    @else
                                                        <p><strong>Estimated Delivery:</strong> Information not available</p>
                                                    @endif
                                                @endif
                                            </div>
                                        @endif


                                        
                                    </div>
                                    
                                 </div>
                                 <div class="accordion product_accordion mt-3" id="accordionExample">
                                  <div class="accordion-item">
                                    <h2 class="accordion-header">
                                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="font-size: 13px; font-weight: 600; text-transform: uppercase; position: relative; background-color: transparent; color: rgb(0, 0, 0); cursor: pointer; border-width: initial; border-style: none; letter-spacing: 0.3px; border-color: initial; border-image: initial;">
                                        Shipping and Policies
                                      </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                      <div class="accordion-body">{{$product->shipment_and_policies}}</div>
                                    </div>
                                  </div>
                                  <!--<div class="accordion-item">-->
                                  <!--  <h2 class="accordion-header">-->
                                  <!--    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">-->
                                  <!--      Accordion Item #2-->
                                  <!--    </button>-->
                                  <!--  </h2>-->
                                  <!--  <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">-->
                                  <!--    <div class="accordion-body">-->
                                  <!--      <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.-->
                                  <!--    </div>-->
                                  <!--  </div>-->
                                  <!--</div>-->
                                  <!--<div class="accordion-item">-->
                                  <!--  <h2 class="accordion-header">-->
                                  <!--    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">-->
                                  <!--      Accordion Item #3-->
                                  <!--    </button>-->
                                  <!--  </h2>-->
                                  <!--  <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">-->
                                  <!--    <div class="accordion-body">-->
                                  <!--      <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.-->
                                  <!--    </div>-->
                                  <!--  </div>-->
                                  <!--</div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Product Content-->

                    <!--Product Nav-->
                    @php
                    $nextProductimage = explode(',', $nextProductInfo->image);
                    $prevProductimage = explode(',', $prevProductInfo->image);
                    @endphp
                    <a href="{{ route('productdetails', ['id' => $prevProductInfo->id]) }}" class="product-nav prev-pro d-flex-center justify-content-between d-none" title="Previous Product">
                        <span class="details">
                            <span class="name">{{$prevProductInfo->product_name}}</span>
                            <span class="price">AED{{$prevProductInfo->sale_price}}</span>
                        </span>
                        <span class="img"><img src="{{ asset('uploads/products/'.$prevProductimage[0]) }}" alt="product" /></span>
                    </a>
                    <a href="{{ route('productdetails', ['id' => $nextProductInfo->id]) }}" class="product-nav next-pro d-flex-center justify-content-between d-none" title="Next Product">
                        <span class="img"><img src="{{ asset('uploads/products/'.$nextProductimage[0]) }}" alt="product"></span>
                        <span class="details">
                            <span class="name">{{$nextProductInfo->product_name}}</span>
                            <span class="price">AED{{$nextProductInfo->sale_price}}</span>
                        </span>
                    </a>
                    <!--End Product Nav-->

                    <!--Product Tabs-->
                    <div class="tabs-listing mt-2 mt-md-5">
                        <ul class="product-tabs list-unstyled d-flex-wrap border-bottom m-0 d-none d-md-flex">
                            <li rel="description" class="active"><a class="tablink">Item details</a></li>
                            <!-- <li rel="shipping-return"><a class="tablink">Shipping and Policies</a></li> -->
                            <!-- <li rel="shipping-return"><a class="tablink">Shipping &amp; Return</a></li> -->
                            <li rel="reviews"><a class="tablink">Reviews</a></li>
                            <!-- <li rel="addtional-tabs"><a class="tablink">Addtional Tabs</a></li> -->
                        </ul>
                        <div class="tab-container">
                            <h3 class="tabs-ac-style d-md-none active" rel="description">Description</h3>
                            <div id="description" class="tab-content">
                                <div class="product-description">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-8 col-lg-8 mb-4 mb-md-0">
                                            <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p> -->
                                            <!-- <h4 class="pt-2 text-uppercase">Features</h4> -->
                                            <!-- <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p> -->
                                            <ul class="item-list-icn-sec">
                                            @foreach($features as $feature)
                                                <li>
                                                    <img class="icn" src="{{get_uploaded_image_url($feature->image_path,'features_images_dir')}}" alt="">
                                                    @if($feature->feature_title=='')
                                                        {{ $feature->name }}
                                                    @else
                                                        {{ $feature->name }}: {{ $feature->feature_title }}
                                                    @endif
                                                </li>
                                            @endforeach
                                            </ul>
                                            <!-- <h4 class="pt-2 text-uppercase">Variations of passages</h4>
                                            <p>All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words.</p>
                                            <h4 class="pt-2 text-uppercase">Popular belief specimen</h4>
                                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage.</p> -->
                                        </div>
                                        <!-- <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                            <img data-src="{{ asset('') }}front_end/assets/images/about/about-info-s3.jpg" src="{{ asset('') }}front_end/assets/images/about/about-info-s3.jpg" alt="image" />
                                        </div> -->
                                    </div>
                                </div>
                            </div>

                           

                            <h3 class="tabs-ac-style d-md-none" rel="shipping-return">Shipping and Policies</h3>
                            <div id="shipping-return" class="tab-content">
                                {{$product->shipment_and_policies}}
                               
                            </div>

                            <h3 class="tabs-ac-style d-md-none" rel="reviews">Review</h3>
                            <div id="reviews" class="tab-content">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="spr-header clearfix d-flex-center justify-content-between">
                                            <div class="product-review d-flex-center me-auto">
                                                <a class="reviewLink" href="#">
                                                    @for ($i = 0; $i < 5; $i++)
                                                        @if ($i < $product->average_rating) 
                                                            <i class="an an-star"></i>  <!-- Full star -->
                                                        @else
                                                            <i class="an an-star-o"></i>  <!-- Empty star -->
                                                        @endif
                                                    @endfor
                                                </a>
                                                <span class="spr-summary-actions-togglereviews ms-2">Based on {{ $product->total_reviews }} reviews </span>
                                            </div>
                                            <div class="spr-summary-actions mt-3 mt-sm-0">
                                                    @auth
                                                        
                                                        <a href="#" id="write-review-btn" class="spr-summary-actions-newreview write-review-btn btn rounded">
                                                            <i class="icon an-1x an an-pencil-alt me-2"></i>Write a review
                                                        </a>
                                                    @endauth

                                                    @guest

                                                        <a href="{{ route('login') }}" class="spr-summary-actions-newreview  btn rounded">
                                                            <i class="icon an-1x an an-pencil-alt me-2"></i>Write a review
                                                        </a>
                                                    @endguest
                                                <!-- <a href="#" class="spr-summary-actions-newreview write-review-btn btn rounded"><i class="icon an-1x an an-pencil-alt me-2"></i>Write a review</a> -->
                                            </div>
                                        </div>

                                        <form method="post"  id="review-form"  action="#" class="product-review-form new-review-form mb-4">
                                            <h4 class="spr-form-title text-uppercase">Write A Review</h4>
                                            <input type="hidden" id="product_id" name="product_id" value="{{$id}}">
                                            <input type="hidden" id="type" name="type" value="1">
                                            <input type="hidden" id="product_variant_id" name="product_variant_id" value="{{$product->product_variation_type}}">
                                            <fieldset class="spr-form-contact">
                                                <div class="spr-form-contact-name form-group">
                                                    <label class="spr-form-label" for="nickname">Name <span class="required">*</span></label>
                                                    <input class="spr-form-input spr-form-input-text" id="nickname" type="text" name="name" value="{{ Auth::check() ? Auth::user()->name : '' }}" placeholder="Enter Name" required />
                                                </div>
                                                <div class="spr-form-contact-email form-group">
                                                    <label class="spr-form-label" for="email">Email <span class="required">*</span></label>
                                                    <input class="spr-form-input spr-form-input-email " id="email" type="email" name="email" value="{{ Auth::check() ? Auth::user()->email : '' }}" placeholder="Enter Name" required />
                                                </div>
                                                <div class="spr-form-review-rating form-group">
                                                    <label class="spr-form-label">Rating</label>
                                                    <div class="product-review pt-1">
                                                        <div class="review-rating">
                                                            <input type="radio" name="rating" value="5" id="rating-5"><label for="rating-5"></label>
                                                            <input type="radio" name="rating" value="4" id="rating-4"><label for="rating-4"></label>
                                                            <input type="radio" name="rating" value="3" id="rating-3"><label for="rating-3"></label>
                                                            <input type="radio" name="rating" value="2" id="rating-2"><label for="rating-2"></label>
                                                            <input type="radio" name="rating" value="1" id="rating-1"><label for="rating-1"></label>
                                                        </div>
                                                        <a class="reviewLink d-none" href="#"><i class="icon an an-star-o"></i><i class="icon an an-star-o mx-1"></i><i class="icon an an-star-o"></i><i class="icon an an-star-o mx-1"></i><i class="icon an an-star-o"></i></a>
                                                    </div>
                                                </div>
                                                <div class="spr-form-review-title form-group">
                                                    <label class="spr-form-label" for="review">Review Title </label>
                                                    <input class="spr-form-input spr-form-input-text " id="review" type="text" name="review" placeholder="Give your review a title" />
                                                </div>
                                                <div class="spr-form-review-body form-group">
                                                    <label class="spr-form-label" for="message">Body of Review <span class="spr-form-review-body-charactersremaining">(1500) characters remaining</span></label>
                                                    <div class="spr-form-input">
                                                        <textarea class="spr-form-input spr-form-input-textarea " id="message" name="message" rows="5" placeholder="Write your comments here"></textarea>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <div class="spr-form-actions clearfix">
                                                <input type="submit" class="btn btn-primary rounded spr-button spr-button-primary" value="Submit Review">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="spr-reviews">
                                            <h4 class="spr-form-title text-uppercase mb-3">Customer Reviews</h4>
                                            <div class="review-inner">
                                               @foreach($reviews as $review)
                                                <div class="spr-review">
                                                    <div class="spr-review-header">
                                                        <span class="product-review spr-starratings"><span class="reviewLink">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="icon an an-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                                        @endfor
                                                        </span></span>
                                                        <h5 class="spr-review-header-title mt-1">{{ $review->title }}</h5>
                                                        <span class="spr-review-header-byline"><strong>{{ $review->name }}</strong> on <strong>{{ \Carbon\Carbon::parse($review->created_at)->format('M d, Y') }}</strong></span>
                                                    </div>
                                                    <div class="spr-review-content">
                                                        <p class="spr-review-content-body">{{ $review->comment }}</p>
                                                    </div>
                                                </div>
                                                @endforeach
                                             
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                        </div>
                    </div>
                    <!--End Product Tabs-->
                </div>
                <!--End Container-->

                <!--You May Also Like Products-->
                <section class="section product-slider pb-0">
                    <div class="container">
                        <div class="row">
                            <div class="section-header col-12">
                                <h2 class="text-transform-none">You May Also Like</h2>
                            </div>
                        </div>
                        <div class="productSlider grid-products">
                           
                        @foreach($relatedProducts as $product)
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
                <!--End You May Also Like Products-->

                <!--Recently Viewed Products-->
                <section class="section product-slider pb-0">
                    <div class="container">
                        <div class="row">
                            <div class="section-header col-12">
                                <h2 class="text-transform-none">Recently Viewed Products</h2>
                            </div>
                        </div>
                        <div class="productSlider grid-products">
                            
                        @foreach($recentlyviewedproducts as $product)
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
           
            </div>
            
            <!-- Modal -->
                                <div class="modal fade" id="personalisation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h2 class="modal-title fs-5" id="exampleModalLabel">Add your personalisation</h2>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                      <input type="hidden" id="modal_product_id" value="{{ $product->product_id }}">

                                        <div class="mb-3">
                                            <label for="customer_notes" class="form-label">Add Note </label>
                                            <textarea name="customer_notes" id="customer_notes" class="form-control mb-2" placeholder="Add a note"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="customer_file" class="form-label">Upload File (Only image files (JPG, PNG, JPEG, PDF) are allowed)</label>
                                            <input type="file" name="customer_file" id="customer_file" class="form-control mb-2" style="padding: 10px;" multiple/>
                                            <small id="file_error" class="text-danger d-none"></small>
                                            <a id="previewPdfBtn" class="btn btn-primary d-none" target="_blank">View PDF</a>
                                            <div id="file_preview" class="mt-2 d-none">
                                                <img id="file_preview_img" src="#" alt="Preview" style="max-height: 120px; border: 1px solid #ccc;" />
                                            </div>
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="submitPersonalization">Submit</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
          
@endsection  

@section('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  
<script>
$(document).ready(function() {
    $('[data-fancybox="gallery"]').fancybox({
  thumbs: {
    autoStart: true,
    axis: 'y',
    hideOnClose: true
  },

  margin: [20, 130, 20, 20],

  youtube: {
    controls: 1,
    showinfo: 0,
    autoplay: 1
  },

  iframe: {
    preload: false,
    css: {
      width: 'calc(100% - 130px)',
      height: 'calc(100% - 40px)'
    }
  },

  buttons: [
    "zoom",
    "close"
  ],

  afterShow: function(instance, current) {
    setTimeout(function() {
      // Remove all existing .video-thumb classes
      $('.fancybox-thumbs__list a').removeClass('video-thumb');

      // Loop through the group items (Fancybox 3.5)
      instance.group.forEach(function(item, index) {
        var $thumb = $('.fancybox-thumbs__list a').eq(index);

        var isVideo = item.type === 'video' ||
          (typeof item.src === 'string' &&
            (item.src.indexOf('youtube') > -1 ||
             item.src.indexOf('vimeo') > -1 ||
             item.src.match(/\.(mp4|webm|ogg)$/i)));

        if (isVideo && $thumb.length) {
          $thumb.addClass('video-thumb');
        }
      });
    }, 100);
  }
});

});


</script>

  
<!-- Initialize Swiper -->
<script>
  // Initialize Swipers after DOM is loaded
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize vertical thumb swiper
    var thumbsSwiper = new Swiper(".mySwiper", {
      direction: 'vertical',
      spaceBetween: 10,
      slidesPerView: 8,
      freeMode: true,
      watchSlidesProgress: true,
      slideToClickedSlide: true
    });

    // Main swiper with thumbs control
    var mainSwiper = new Swiper(".mySwiper2", {
      spaceBetween: 10,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      thumbs: {
        swiper: thumbsSwiper,
      },
      on: {
        slideChange: function() {
          // Pause all videos
          document.querySelectorAll('.mySwiper2 video').forEach(video => {
            video.pause();
            video.closest('.swiper-slide').classList.remove('video-playing');
            video.closest('.swiper-slide').classList.add('video-paused');
          });
          
          // Play current slide's video if it exists
          const currentSlide = this.slides[this.activeIndex];
          const video = currentSlide.querySelector('video');
          if (video) {
            video.currentTime = 0;
            video.play()
              .then(() => {
                currentSlide.classList.add('video-playing');
                currentSlide.classList.remove('video-paused');
              })
              .catch(e => console.log('Autoplay prevented:', e));
          }
          
          // Ensure active thumb is visible
          setTimeout(() => {
            thumbsSwiper.slideTo(this.activeIndex);
            updateNavButtons(thumbsSwiper);
          }, 100);
        },
        init: function() {
          // Initialize click handlers
          document.querySelectorAll('.swiper-slide video, .video-play-overlay').forEach(el => {
            el.addEventListener('click', function(e) {
              e.stopPropagation();
              const video = this.tagName === 'VIDEO' ? this : this.previousElementSibling;
              const slide = video.closest('.swiper-slide');
              
              if (video.paused) {
                video.play()
                  .then(() => {
                    slide.classList.add('video-playing');
                    slide.classList.remove('video-paused');
                  });
              } else {
                video.pause();
                slide.classList.remove('video-playing');
                slide.classList.add('video-paused');
              }
            });
          });
          
          // Play first video if it exists
          const firstSlide = this.slides[0];
          const firstVideo = firstSlide.querySelector('video');
          if (firstVideo) {
            firstVideo.play()
              .then(() => {
                firstSlide.classList.add('video-playing');
                firstSlide.classList.remove('video-paused');
              })
              .catch(e => console.log('Autoplay prevented:', e));
          }
          
          // Initialize navigation buttons
          setTimeout(() => updateNavButtons(thumbsSwiper), 300);
        }
      }
    });

    // Update navigation button visibility
    function updateNavButtons(swiperInstance) {
      if (!swiperInstance || !swiperInstance.initialized) return;
      
      const topBtn = document.querySelector('.swiper-nav-top');
      const bottomBtn = document.querySelector('.swiper-nav-bottom');
      
      if (topBtn && bottomBtn) {
        topBtn.style.display = swiperInstance.isBeginning ? 'none' : 'flex';
        bottomBtn.style.display = swiperInstance.isEnd ? 'none' : 'flex';
      }
    }

    // Manual scroll buttons
    window.scrollThumbs = function(direction) {
      if (!thumbsSwiper || !thumbsSwiper.initialized) return;
      
      if (direction === 'up') {
        thumbsSwiper.slidePrev();
      } else {
        thumbsSwiper.slideNext();
      }
      updateNavButtons(thumbsSwiper);
    };

    // Hover-based scrolling
    const thumbContainer = document.querySelector('.mySwiper');
    if (thumbContainer) {
      thumbContainer.addEventListener('mouseenter', () => {
        thumbContainer.addEventListener('mousemove', handleMouseMove);
      });
      
      thumbContainer.addEventListener('mouseleave', () => {
        thumbContainer.removeEventListener('mousemove', handleMouseMove);
        if (scrollInterval) clearInterval(scrollInterval);
      });
    }

    let scrollInterval;
    function handleMouseMove(e) {
      if (!thumbsSwiper || !thumbsSwiper.initialized) return;
      
      const rect = e.currentTarget.getBoundingClientRect();
      const yPos = e.clientY - rect.top;
      const threshold = 50;
      
      clearInterval(scrollInterval);
      
      if (yPos < threshold && !thumbsSwiper.isBeginning) {
        scrollInterval = setInterval(() => {
          thumbsSwiper.slidePrev();
          updateNavButtons(thumbsSwiper);
        }, 100);
      } 
      else if (yPos > rect.height - threshold && !thumbsSwiper.isEnd) {
        scrollInterval = setInterval(() => {
          thumbsSwiper.slideNext();
          updateNavButtons(thumbsSwiper);
        }, 100);
      }
    }
  });
</script>
  
  
<script>
$(document).ready(function () {
    $('#colorsattrColor, #colorsattrSize').on('change', function () {
        
        const colorSelect = $('#colorsattrColor');
        const sizeSelect = $('#colorsattrSize');

        const colorExists = colorSelect.length > 0;
        const sizeExists = sizeSelect.length > 0;

        const colorVal = colorSelect.val();
        const sizeVal = sizeSelect.val();
       
        let shouldSubmit = false;

        if (colorExists && sizeExists) {
            // Both exist — only submit if both have values
            if (colorVal && sizeVal) {
                shouldSubmit = true;
            }
        } else if (colorExists && colorVal) {
            shouldSubmit = true;
        } else if (sizeExists && sizeVal) {
            shouldSubmit = true;
        }

        if (shouldSubmit) {
            // Get base URL without query string
            const baseUrl = window.location.origin + window.location.pathname;

            // Build query params
            const params = new URLSearchParams(window.location.search);
            if (colorVal) params.set('color', colorVal);
            else params.delete('color');

            if (sizeVal) params.set('size', sizeVal);
            else params.delete('size');

            // Redirect with new query string
            window.location.href = baseUrl + '?' + params.toString();
        }
    });
});
</script>

<script>
$(document).ready(function () {
    $('.variationColor, .variationSize').on('change', function () {
        // Check if radio buttons exist
        const colorExists = $('.variationColor').length > 0;
        const sizeExists = $('.variationSize').length > 0;

        // Get selected values
        const colorVal = $('.variationColor:checked').val();
        const sizeVal = $('.variationSize:checked').val();

        let shouldSubmit = false;

        if (colorExists && sizeExists) {
            if (colorVal && sizeVal) {
                shouldSubmit = true;
            }
        } else if (colorExists && colorVal) {
            shouldSubmit = true;
        } else if (sizeExists && sizeVal) {
            shouldSubmit = true;
        }

        if (shouldSubmit) {
            const baseUrl = window.location.origin + window.location.pathname;

            const params = new URLSearchParams(window.location.search);
            if (colorVal) params.set('color', colorVal);
            else params.delete('color');

            if (sizeVal) params.set('size', sizeVal);
            else params.delete('size');

            // Redirect with selected values
            window.location.href = baseUrl + '?' + params.toString();
        }
    });
});
</script>

<script>
$(document).ready(function () {
    const params = new URLSearchParams(window.location.search);

    const color = params.get('color');
    const size = params.get('size');

    // Auto-check the color radio if it matches the URL param
    if (color) {
        $(`input[type=radio][value="${color}"].variationColor`).prop('checked', true);
    }

    // Auto-check the size radio if it matches the URL param
    if (size) {
        $(`input[type=radio][value="${size}"].variationSize`).prop('checked', true);
    }
});
</script>
<script>
    $(document).ready(function () {
        const pageUrl = encodeURIComponent(window.location.href);
        const pageTitle = encodeURIComponent(document.title);

        // Update Facebook share link
        $('.share-facebook').attr('href', `https://www.facebook.com/sharer/sharer.php?u=${pageUrl}`);

        // Update Twitter share link
        $('.share-twitter').attr('href', `https://twitter.com/intent/tweet?url=${pageUrl}&text=${pageTitle}`);

        // Update Pinterest share link (you can add media if needed)
        $('.share-pinterest').attr('href', `https://pinterest.com/pin/create/button/?url=${pageUrl}&description=${pageTitle}`);

        // Update LinkedIn share link
        $('.share-linkedin').attr('href', `https://www.linkedin.com/shareArticle?mini=true&url=${pageUrl}&title=${pageTitle}`);

        // Update Email share link
        $('.share-email').attr('href', `mailto:?subject=${pageTitle}&body=${pageUrl}`);
    });
</script>


@endsection