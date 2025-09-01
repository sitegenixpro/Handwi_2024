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
                        <div class="breadcrumbs"><a href="{{ route('home') }}" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">Workshop Details</span></div>
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
                                    <div class="product-details-img thumb-left clearfix d-flex-wrap mb-3 mb-md-0 d-none">
                                        <div class="product-thumb">
                                            <div id="gallery" class="product-dec-slider-2 product-tab-left">
                                                <a data-image="{{ asset($workshop->image) }}" data-zoom-image="{{ asset($workshop->image) }}" class="slick-slide slick-cloned active">
                                                    <img class="blur-up lazyload" data-src="{{ asset($workshop->image) }}" src="{{ asset($workshop->image) }}" alt="product" />
                                                </a>
                                                @foreach($additional_images as $img)
                                                <a data-image="{{ asset('storage/uploads/service/'.$img->image) }}" data-zoom-image="{{ asset('storage/uploads/service/'.$img->image) }}" class="slick-slide slick-cloned">
                                                    <img class="blur-up lazyload" data-src="{{ asset('storage/uploads/service/'.$img->image) }}" src="{{ asset('storage/uploads/service/'.$img->image) }}" alt="product" />
                                                </a>
                                                @endforeach
                                                
                                            </div>
                                        </div>
                                        <div class="zoompro-wrap product-zoom-right">
                                            <!--<div class="zoompro-span"><img id="zoompro" class="" src="{{ asset($workshop->image) }}" data-zoom-image="{{ asset($workshop->image) }}" alt="product" /></div>-->
                                            <a data-fancybox="gallery" href="{{ asset($workshop->image) }}" data-thumb="{{ asset($workshop->image) }}">
                                                    <img class="blur-up lazyload" data-src="{{ asset($workshop->image) }}" src="{{ asset($workshop->image) }}" alt="product" />
                                                  </a>
                                            <!-- <div class="product-labels"><span class="lbl pr-label1">new</span><span class="lbl on-sale">Best seller</span></div> -->
                                            <div class="product-wish"><a class="wishIcon wishlist rounded m-0" href="#"><i class="icon an an-heart"></i><span class="tooltip-label left">Available in Wishlist</span></a></div>
                                            <!-- <div class="product-buttons">
                                                <a href="https://www.youtube.com/watch?v=93A2jOW5Mog" class="mfpbox mfp-with-anim btn rounded popup-video"><i class="icon an an-video"></i><span class="tooltip-label">Watch Video</span></a>
                                                <a href="#" class="btn rounded prlightbox"><i class="icon an an-expand-l-arrows"></i><span class="tooltip-label">Zoom Image</span></a>
                                            </div> -->
                                        </div>
                                    </div>
                                    
                                    <div class="product-slider-wrapper">
                                      <!-- Main Slider -->
                                      <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2">
                                        <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                         <a data-fancybox="gallery" href="{{ asset($workshop->image) }}"  style="display: block; width: 100%; height: 100%; object-fit: cover;">
                                                    <img data-src="{{ asset($workshop->image) }}" src="{{ asset($workshop->image) }}" alt="workshop"/>
                                                </a>
                                                
                                            </div>
                                                @foreach($additional_images as $img)
                                                <div class="swiper-slide">
                                                    <a data-fancybox="gallery" href="{{ asset('storage/uploads/service/'.$img->image) }}" style="display: block; width: 100%; height: 100%; object-fit: cover;">
                                                        <img data-src="{{ asset('storage/uploads/service/'.$img->image) }}" src="{{ asset('storage/uploads/service/'.$img->image) }}" alt="Service Img" />
                                                    </a>
                                                </div>
                                                @endforeach
                                        
                                         
                                         
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
                                              <div class="swiper-slide">
                                             <a href="{{ asset($workshop->image) }}" data-thumb="{{ asset($workshop->image) }}">
                                                    <img class="blur-up lazyload" data-src="{{ asset($workshop->image) }}" src="{{ asset($workshop->image) }}" alt="product" />
                                                  </a>
                                            </div>
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
                                <div class="product-single__meta">
                                    <h1 class="product-single__title">{{ $workshop->name }}</h1>
                                  
                                    

                                    <div class="button-set-bottom show-always style1">
                                        <!--Cart Button-->
                                        <span class="btn-icon btn  rounded bg-cream9">
                                            <i class="icon an an-cart-l"></i> <span>{{ \Carbon\Carbon::parse($workshop->from_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($workshop->to_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($workshop->from_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($workshop->to_time)->format('H:i') }}</span>
                                        </span>
                                        <!--End Cart Button-->
                                    </div>

                                  
                                    <div class="product-single__price pb-1">
                                        <span class="visually-hidden">Regular price</span>
                                        <span class="product-price__sale--single">
                                            <span class="product-price__price product-price__sale">{{ $workshop->service_price }} AED</span>   
                                            <!-- <span class="discount-badge"><span class="devider me-2">|</span><span>Save: </span><span class="product-single__save-amount"><span class="money">19.99 AED</span></span><span class="off ms-1">(<span>20% OFF</span>%)</span></span>  -->
                                        </span>
                                        <!-- <div class="product__policies fw-normal mt-1">Tax included.</div> -->
                                    </div>
                                    <!-- Product Reviews -->
                                    <div class="product-review mb-2"><a class="reviewLink d-flex-center" href="#reviews"><i class="an an-star"></i><i class="an an-star mx-1"></i><i class="an an-star"></i><i class="an an-star mx-1"></i><i class="an an-star-o"></i><span class="spr-badge-caption ms-2">16 Reviews</span></a></div>
                                    <!-- End Product Reviews -->
                                    <!-- Product Info -->
                                    <div class="product-info">
                                        <p class="product-type">by: 
                                        <a href="{{ route('storedetails', ['id' => $vendor->stores->first()->vendor_id]) }}">
                                            <span>{{ isset($vendor->stores) && $vendor->stores->first() && isset($vendor->stores->first()->store_name) && $vendor->stores->first()->store_name ? $vendor->stores->first()->store_name : 'N/A' }}</span>
                                           </a> 
                                            </p>  
                                    
                                    </div>
                                  
                                </div>
                                <!-- End Product Info -->
                                <!-- Product Form -->
                                <form method="post" action="#" class="product-form hidedropdown">
                                    <!-- Product Action -->
                                    <div class="product-action w-100 clearfix">
                                       
                                        <div class="product-form__item--submit">
                                            <a type="submit" href="{{ route('workshopbooking', $workshop->id) }}" name="add" class="btn rounded "><span>Book Now</span></a>
                                            <!-- <button type="submit" name="add" class="btn rounded product-form__sold-out d-none" disabled="disabled">Sold out</button> -->
                                        </div>
                                        <!-- <div class="product-form__item--buyit clearfix">
                                            <a href="buynow-checkout.html" type="button" class="btn rounded btn-outline-primary proceed-to-checkout">Buy it now</a>
                                        </div> -->
                                        <div class="agree-check customCheckbox clearfix d-none">
                                            <input id="prTearm" name="tearm" type="checkbox" value="tearm" required />
                                            <label for="prTearm">I agree with the terms and conditions</label>
                                        </div>
                                    </div>
                                    <!-- End Product Action -->
                                    <!-- Product Info link -->
                                    <!-- <p class="infolinks d-flex-center mt-2 mb-3">
                                        <a class="btn add-to-wishlist d-none" href="#"><i class="icon an an-heart-l me-1" aria-hidden="true"></i> <span>Add to Wishlist</span></a>
                                        <a class="btn add-to-wishlist" href="#"><i class="icon an an-sync-ar me-1" aria-hidden="true"></i> <span>Add to Compare</span></a>
                                        <a class="btn shippingInfo" href="#ShippingInfo"><i class="icon an an-paper-l-plane me-1"></i> Delivery &amp; Returns</a>
                                        <a class="btn emaillink me-0" href="#productInquiry"> <i class="icon an an-question-cil me-1"></i> Ask A Question</a>
                                    </p> -->
                                    <!-- End Product Info link -->
                                </form>
                                <!-- End Product Form -->
                                <!-- Social Sharing -->
                                <div class="social-sharing d-flex-center mb-3">
                                    <span class="sharing-lbl me-2">Share :</span>
                                    <a href="#" class="d-flex-center btn btn-link btn--share share-facebook" data-bs-toggle="tooltip" data-bs-placement="top" title="Share on Facebook"><i class="icon an an-facebook mx-1"></i><span class="share-title d-none">Facebook</span></a>
                                    <a href="#" class="d-flex-center btn btn-link btn--share share-twitter" data-bs-toggle="tooltip" data-bs-placement="top" title="Tweet on Twitter"><i class="icon an an-twitter mx-1"></i><span class="share-title d-none">Tweet</span></a>
                                    <a href="#" class="d-flex-center btn btn-link btn--share share-pinterest" data-bs-toggle="tooltip" data-bs-placement="top" title="Pin on Pinterest"><i class="icon an an-pinterest-p mx-1"></i> <span class="share-title d-none">Pin it</span></a>
                                    <a href="#" class="d-flex-center btn btn-link btn--share share-linkedin" data-bs-toggle="tooltip" data-bs-placement="top" title="Share on Linkedin"><i class="icon an an-linkedin mx-1"></i><span class="share-title d-none">Linkedin</span></a>
                                    <a href="#" class="d-flex-center btn btn-link btn--share share-email" data-bs-toggle="tooltip" data-bs-placement="top" title="Share by Email"><i class="icon an an-envelope-l mx-1"></i><span class="share-title d-none">Email</span></a>
                                </div>
                                <!-- End Social Sharing -->
                                <!-- Product Info -->
                                <!-- <div class="freeShipMsg" data-price="199"><i class="icon an an-truck" aria-hidden="true"></i>SPENT <b class="freeShip"><span class="money" data-currency-usd="$199.00" data-currency="USD">$199.00</span></b> MORE FOR FREE SHIPPING</div> -->
                                <!-- <div class="shippingMsg"><i class="icon an an-clock-r" aria-hidden="true"></i>Estimated Delivery Between <b id="fromDate">Wed, May 1</b> and <b id="toDate">Tue, May 7</b>.</div> -->
                                <!-- <div class="userViewMsg" data-user="20" data-time="11000"><i class="icon an an-eye-r" aria-hidden="true"></i><strong class="uersView">21</strong> People are Looking for this Product</div>
                                <div class="trustseal-img mt-4"><img src="assets/images/powerby-cards.jpg" alt="powerby cards" /></div> -->
                                <!-- End Product Info -->
                                 <div class="vendor-stk-detail-area">
                                    @if (isset($vendor->stores) && $vendor->stores->first() && file_exists(public_path('storage/' . $vendor->stores->first()->logo)))
                                    <a href="{{ route('storedetails', ['id' => $vendor->stores->first()->vendor_id]) }}">
                                    <img src="{{ asset('') }}storage/{{$vendor->stores->first()->logo}} " alt="" class="log-are">
                                    </a>
                                    @else
                                        <!-- <p>No logo available</p> -->
                                    @endif
                                    <div class="vendor-stk-dtl">
                                        <h4 class="v-name">
                                            <a href="{{ route('storedetails', ['id' => $vendor->stores->first()->vendor_id]) }}">
                                                {{ isset($vendor->stores) && $vendor->stores->first() && isset($vendor->stores->first()->store_name) && $vendor->stores->first()->store_name ? $vendor->stores->first()->store_name : 'N/A' }}
                                                </a>
                                                </h4>
                                        <p class="loc">{{ isset($vendor->stores) && $vendor->stores->first() && isset($vendor->stores->first()->location) && $vendor->stores->first()->location ? $vendor->stores->first()->location : 'N/A' }}</p>
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
                                    </div>
                                 </div>
                                 <div class="accordion product_accordion mt-3" id="accordionExample">
                                  <div class="accordion-item">
                                    <h2 class="accordion-header">
                                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="font-size: 13px; font-weight: 600; text-transform: uppercase; position: relative; background-color: transparent; color: rgb(0, 0, 0); cursor: pointer; border-width: initial; border-style: none; letter-spacing: 0.3px; border-color: initial; border-image: initial;">
                                        Terms and Policies
                                      </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                      <div class="accordion-body">{!! $workshop->term_and_condition !!}</div>
                                    </div>
                                  </div>
                                 
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <!--Product Content-->

                    <!--Product Tabs-->
                    <div class="tabs-listing mt-2 mt-md-5">
                        <ul class="product-tabs list-unstyled d-flex-wrap border-bottom m-0 d-none d-md-flex">
                            <li rel="description" class="active"><a class="tablink">Workshop details</a></li>
                           
                            <li rel="locatio-tab"><a class="tablink">Location</a></li>
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
                                                @foreach ($workshop->features as $feature)
                                                <li>
                                                    @if(isset($feature->image_path) && !empty($feature->image_path))
                                                        <img class="icn" 
                                                            src="{{ asset($feature->image_path) }}" 
                                                            alt="{{ $feature->name ?? 'No feature name available' }}">
                                                    @endif
                                                    {{ $feature->name ?? 'No feature name available' }}
                                                </li>
                                                @endforeach
                                            </ul>
                                            <!-- <h4 class="pt-2 text-uppercase">Variations of passages</h4>
                                            <p>All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words.</p>
                                            <h4 class="pt-2 text-uppercase">Popular belief specimen</h4>
                                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage.</p> -->
                                        </div>
                                        @if(isset($workshop->feature_image) && file_exists(public_path($workshop->feature_image)))
                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                            
                                                <img data-src="{{ asset($workshop->feature_image) }}" src="{{ asset($workshop->feature_image) }}" alt="image" />
                                            
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            

                            <h3 class="tabs-ac-style d-md-none" rel="shipping-return">Shipping and Policies</h3>
                            <div id="shipping-return" class="tab-content">
                               {!! $workshop->term_and_condition !!}
                            </div>

                            


                            <h3 class="tabs-ac-style d-md-none" rel="locatio-tab">Location</h3>
                            <div id="locatio-tab" class="tab-content">
                                <div class="product-description">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-8 col-lg-8 mb-4 mb-md-0">
                                            <p>{{ $workshop->location }}</p>
                                            <!-- <h4 class="pt-2 text-uppercase">Features</h4> -->
                                        
                                            <iframe width="100%" height="300" style="border:0;" 
                                                    loading="lazy" 
                                                    allowfullscreen 
                                                    referrerpolicy="no-referrer-when-downgrade" 
                                                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCj5K2-cJ_P4_4d2Iufmau-BFl3Wjv0CuA&q={{ $workshop->latitude }},{{ $workshop->longitude }}">
                                            </iframe>


                                            <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7223.6798632737955!2d{{ $workshop->longitude }}!3d{{ $workshop->latitude }}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f69c089a656b7%3A0xcb7380de46d9763a!2sRACECOURSE%20400KV%20SUBSTATION!5e0!3m2!1sen!2sin!4v1719983494002!5m2!1sen!2sin" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> -->
    
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h3 class="tabs-ac-style d-md-none" rel="reviews">Review</h3>
                            <div id="reviews" class="tab-content">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="spr-header clearfix d-flex-center justify-content-between">
                                            <div class="product-review d-flex-center me-auto">
                                                <a class="reviewLink" href="#"><i class="icon an an-star"></i><i class="icon an an-star mx-1"></i><i class="icon an an-star"></i><i class="icon an an-star mx-1"></i><i class="icon an an-star-o"></i></a>
                                                <span class="spr-summary-actions-togglereviews ms-2">Based on 6 reviews 234</span>
                                            </div>
                                            <div class="spr-summary-actions mt-3 mt-sm-0">
                                            @auth
                                                <!-- If the user is logged in, show the button to open the review popup -->
                                                <a href="#" id="write-review-btn" class="spr-summary-actions-newreview write-review-btn btn rounded">
                                                    <i class="icon an-1x an an-pencil-alt me-2"></i>Write a review
                                                </a>
                                            @endauth

                                            @guest
                                                <!-- If the user is not logged in, redirect to the login page -->
                                                <a href="{{ route('login') }}" class="spr-summary-actions-newreview  btn rounded">
                                                    <i class="icon an-1x an an-pencil-alt me-2"></i>Write a review
                                                </a>
                                            @endguest
                                                <!-- <a href="#" class="spr-summary-actions-newreview write-review-btn btn rounded"><i class="icon an-1x an an-pencil-alt me-2"></i>Write a review</a> -->
                                            </div>
                                        </div>

                                        <form method="post" id="review-form" action="#" class="product-review-form new-review-form mb-4">
                                            <input type="hidden" id="service_id" name="service_id" value="{{$id}}">
                                            <input type="hidden" id="type" name="type" value="3">
                                            <h4 class="spr-form-title text-uppercase">Write A Review</h4>
                                            <fieldset class="spr-form-contact">
                                                <div class="spr-form-contact-name form-group">
                                                    <label class="spr-form-label" for="nickname">Name <span class="required">*</span></label>
                                                    <input class="spr-form-input spr-form-input-text" id="nickname" type="text" value="{{ Auth::check() ? Auth::user()->name : '' }}" name="name" placeholder="Enter Name" required />
                                                </div>
                                                <div class="spr-form-contact-email form-group">
                                                    <label class="spr-form-label" for="email">Email <span class="required">*</span></label>
                                                    <input class="spr-form-input spr-form-input-email " id="email" type="email" name="email" value="{{ Auth::check() ? Auth::user()->email : '' }}" placeholder="Enter Email" required />
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
                <section class="section product-slider similar-workshop-area pb-0">
                    <div class="container">
                        <div class="row">
                            <div class="section-header col-12">
                                <h2 class="text-transform-none">Similar Workshop</h2>
                            </div>
                        </div>
                        <div class="productSlider grid-products">
                            @foreach ($other_services as $service)
                            <div class="item">
                                <!--Start Product Image-->
                                <div class="product-image">
                                    <!--Start Product Image-->
                                    <a href="{{ route('workshopdetail', $service->id) }}" class="product-img">
                                        <!--Image-->
                                        <img class="primary blur-up lazyload" data-src="{{ asset($service->image) }}" src="{{ asset($service->image) }}" alt="image" title="" width="800" height="960">
                                        <!--End image-->
                                        <!--Hover image-->
                                        <img class="hover blur-up lazyload" data-src="{{ asset($service->image) }}" src="{{ asset($service->image) }}" alt="image" title="" width="800" height="960">
                                        <!--End hover image-->
                                    </a>
                                    <!--end product image-->

                                    <!--Product Button-->
                                    <div class="button-set-bottom show-always position-absolute style1">
                                        <!--Cart Button-->
                                        <a class="btn-icon btn btn-addto-cart pro-addtocart-popup rounded  bg-cream9 " href="{{ route('workshopdetail', $service->id) }}">
                                            <i class="icon an an-cart-l"></i> <span>{{ \Carbon\Carbon::parse($service->from_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($service->from_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($service->to_time)->format('H:i') }}</span>
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
                                        <a href="{{ route('workshopdetail', $service->id) }}">{{ $service->name }}</a>
                                    </div>
                                    <!--End Product Name-->
                                    <!--Product Price-->
                                    <div class="product-price">
                                        <span class="price">{{ $service->service_price }} AED</span>
                                    </div>
                                </div>
                                <!--End Product Details-->
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>
                
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


@endsection
