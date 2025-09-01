<!doctype html>
<html dir="ltr" lang="en">
<head>
        <!--Required Meta Tags-->
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="description">
        <!-- Title Of Site -->
        <title>{{$page_heading}}</title>
        <!-- Favicon -->
        <!-- <link rel="shortcut icon" href="assets/images/favicon.png" /> -->
        <!-- Plugins CSS -->
        <link rel="stylesheet" href="{{ asset('') }}front_end/assets/css/plugins.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Main Style CSS -->
        <link rel="stylesheet" href="{{ asset('') }}front_end/assets/css/style.css" />
        <link rel="stylesheet" href="{{ asset('') }}front_end/assets/css/responsive.css" />
        <link rel="stylesheet" href="{{ asset('') }}front_end/assets/css/custom.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">     
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @yield('header')
    </head>
       <style>
         .language-switch.switch {
          position: relative;
          display: inline-block;
          margin: 0 5px;
            /*position: fixed;*/
            /*z-index: 99;*/
            /*top: 10px;*/
            /*right: 20px;*/
        }
        
        .language-switch.switch > span {
          position: absolute;
          top: 8px;
          pointer-events: none;
          font-family: 'Helvetica', Arial, sans-serif;
          font-weight: bold;
          font-size: 12px;
          text-transform: uppercase;
          text-shadow: 0 1px 0 rgba(0, 0, 0, .06);
          width: 50%;
          text-align: center;
        }
        
        .language-switch input.check-toggle:checked ~ .off {
          color: #000;
        }
        
        .language-switch input.check-toggle:checked ~ .on {
          color: #fff;
        }
        
        .language-switch.switch > span.on {
          left: 0;
          padding-left: 2px;
          color: #000;
        }
        
        .language-switch.switch > span.off {
          right: 0;
          padding-right: 4px;
          color: #fff;
        }
        
        .language-switch .check-toggle {
          position: absolute;
          margin-left: -9999px;
          visibility: hidden;
        }
        .language-switch .check-toggle + label {
          display: block;
          position: relative;
          cursor: pointer;
          outline: none;
          -webkit-user-select: none;
          -moz-user-select: none;
          -ms-user-select: none;
          user-select: none;
        }
        
        .language-switch input.check-toggle + label {
          padding: 2px;
          width: 80px;
          height: 35px;
          background-color: #000;
          -webkit-border-radius: 60px;
          -moz-border-radius: 60px;
          -ms-border-radius: 60px;
          -o-border-radius: 60px;
          border-radius: 60px;
        }
        .language-switch input.check-toggle + label:before, input.check-toggle + label:after {
          display: block;
          position: absolute;
          content: "";
        }
        
        .language-switch input.check-toggle + label:before {
          top: 2px;
          left: 2px;
          bottom: 2px;
          right: 2px;
          background-color: #000;
          -webkit-
          
          -moz-border-radius: 60px;
          -ms-border-radius: 60px;
          -o-border-radius: 60px;
          border-radius: 60px;
        }
        .language-switch input.check-toggle + label:after {
          top: 4px;
          left: 4px;
          bottom: 4px;
          width: 40px;
          background-color: #fff;
          -webkit-border-radius: 52px;
          -moz-border-radius: 52px;
          -ms-border-radius: 52px;
          -o-border-radius: 52px;
          border-radius: 52px;
          -webkit-transition: margin 0.2s;
          -moz-transition: margin 0.2s;
          -o-transition: margin 0.2s;
          transition: margin 0.2s;
        }
        
        .language-switch input.check-toggle:checked + label {
        }
        
        .language-switch input.check-toggle:checked + label:after {
          margin-left: 34px;
        }
        
        [dir="rtl"] footer ul {
            padding-right: 0 !important;
        }
        [dir="rtl"] .slideshow-text {
            direction: rtl;
        }
        [dir="rtl"] .swiper-container {
          direction: ltr;
        }
        [dir="rtl"] .wishlish-oncard {
            right: auto !important;
            left: 20px !important;
        }
        [dir="rtl"] .text_dash::before {
            left: auto !important;
            right: 0 !important;
        }
        [dir="rtl"] .text_dash {
            padding-left: 0;
            padding-right: 3.25rem;
        }
        [dir="rtl"] .header-tools__cart .cart-amount {
            left: auto !important;
            right: calc(0.5rem + 1.0em);
        }
        [dir="rtl"] .pc__info {
          direction: rtl;
        }
        
        @media (min-width: 1700px) {
      [dir="rtl"] .slideshow-pagination.position-left-center {
        right: 3.0rem !important;
        left: auto !important;
        top: 50%;
        bottom: auto;
        transform: translateY(-50%);
        flex-direction: column; } }
        
        @media(max-width:1440px){
            .header .header-tools svg{
                width: 16px;
                height: 16px;
            }
            .header .navigation__link{
                font-size: 10px;
                padding: 0 6px;
            } 
            .header .header-tools__item{
                margin-right: 10px;
            }
        }
        
        
        @media(max-width: 767px){
            .language-switch input.check-toggle + label{
                width: 60px;
                height: 30px;
            }
            .language-switch input.check-toggle + label:after{
                width: 26px;
                
            }
            .language-switch.switch > span.on,
            .language-switch.switch > span.off{
                font-size: 10px;
                top: 6px;
            }
            .language-switch input.check-toggle:checked + label:after {
                margin-left: 26px;
            }
        }
        [dir="rtl"] .mobile-menu-opened .navigation__list {
            padding-right: 0 !important;
            padding-left: 0 !important;
        }
        [dir="rtl"] .navigation__link:after {
                right: 0rem;
            }
        @media (min-width: 992px) {
            [dir="rtl"] .header .navigation__link:after {
                right: 7px;
            }
        }
        
        
        [dir="rtl"] body{
            font-family: "Kufam", sans-serif !important;
            /*font-family: "Alexandria", sans-serif !important;*/
        }
        
        [dir="rtl"] h1, [dir="rtl"] .h1, h2, [dir="rtl"] .h2, [dir="rtl"] h3, [dir="rtl"] .h3, [dir="rtl"] h4, [dir="rtl"] .h4, [dir="rtl"] h5, [dir="rtl"] .h5, [dir="rtl"] h6, [dir="rtl"] .h6{
            /*font-family: "Alexandria", sans-serif !important;*/
            font-family: "Kufam", sans-serif !important;
        }
        
        [dir="rtl"] footer, [dir="rtl"] footer p, [dir="rtl"] footer, [dir="rtl"] footer h2, [dir="rtl"] footer, [dir="rtl"] footer h3, [dir="rtl"] footer, [dir="rtl"] footer h4, [dir="rtl"] footer, [dir="rtl"] footer h5{
            /*font-family: "Alexandria", sans-serif !important;*/
            font-family: "Kufam", sans-serif !important;
        }
        [dir="rtl"] .footer .menu-link,
        [dir="rtl"] .font-heading{
            /*font-family: "Alexandria", sans-serif !important;*/
            font-family: "Kufam", sans-serif !important;
        }
        
        @media (min-width: 992px) {
            [dir="rtl"] .product-single__prev-next {
                display: flex !important;
                flex-direction: row-reverse;
                justify-content: flex-start !important;
            }
        }
        [dir="rtl"] .product-single__prev-next > a{
            flex-direction: row-reverse !important;
        }
        [dir="rtl"] .cart-drawer-item__info{
            margin-right: 1.25rem;
            margin-left: 0 !important;
        }
        [dir="rtl"] .accordion-button__icon{
            margin-right: auto;
            margin-left: 0 !important;
        }
        [dir="rtl"] td.text-end, [dir="rtl"] td.cart-subtotal.text-end{
            text-align: left !important;
        }
        [dir="rtl"] .form-floating > label, [dir="rtl"] .form-label-fixed > .form-label{
            left: auto !important;
            right: 0.75rem !important;
        }
        [dir="rtl"] .content_left{
            right: var(--content-space);
            left: auto !important;
        }
        [dir="rtl"] .filter-sticky .shop-acs__select{
            padding-left: 0 !important;
            padding-right: 20px !important;
        }
        [dir="rtl"] .btn-close-aside, [dir="rtl"] .js-close-aside{
            margin-left: 0 !important;
            margin-right: auto !important;
        }
        .product-single__swatches .product-swatch.text-swatches .swatch{
            line-height: normal;
        }
        
        [dir="rtl"] .customer-forms .aside-header{
                flex-direction: row-reverse;
        }
        [dir="rtl"] .aside_right.aside_visible.customer-forms{
            direction: ltr;
            text-align: right;
        }
    </style>
    <style>
        /* Style the autocomplete container */
#autocomplete-results {
    position: absolute;
    top: 100%;  /* Position the dropdown below the search input */
    left: 0;
    right: 0;
    background-color: #fff;
    border: 1px solid #ddd;
    border-top: none;
    max-height: 300px;
    overflow-y: auto;
    z-index: 1000;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    display: none;  /* Hidden by default */
}

/* Style individual autocomplete items */
.autocomplete-item {
    padding: 10px;
    cursor: pointer;
    font-size: 14px;
    color: #333;
    transition: background-color 0.2s ease, color 0.2s ease;
}

/* Highlight the item on hover */
.autocomplete-item:hover {
    background-color: #f0f0f0;
    color: #007bff;  /* Change text color on hover */
}

/* Style the product name and price within the suggestion */
.autocomplete-item span {
    font-weight: bold;
    color: #333;
}

/* Style the price part */
.autocomplete-item .price {
    font-weight: normal;
    font-size: 12px;
    color: #888;
}

/* Adjust input field styles */


/* Focus state for input */
#search-input:focus {
    border-color: #007bff;
    outline: none;
}

/* Optional: Add some space around the search bar */
.searchField {
    position: relative;
}

/* Optional: Add a slight margin between the input box and the suggestion box */
.searchField .input-box {
    margin-bottom: 5px;
}

    </style>

    <body class="{{ Route::currentRouteName() == 'home' ? 'template-index index-demo1' : '' }}{{ Route::currentRouteName() == 'about-us' ? 'about-page about-pstyle1' : '' }}{{ Route::currentRouteName() == 'privacy-policy' ? 'about-page about-pstyle1' : '' }}{{ Route::currentRouteName() == 'terms-and-condition' ? 'about-page about-pstyle1' : '' }}{{ Route::currentRouteName() == 'faq' ? 'faq-page faqs-style1' : '' }}{{ Route::currentRouteName() == 'contactus' ? 'contactus-page2' : '' }}{{ Route::currentRouteName() == 'storedetails' ? 'category-page category-5columns' : '' }}{{ Route::currentRouteName() == 'thankyou' ? 'my-wishlist-page' : '' }}{{ Route::currentRouteName() == 'checkout' ? 'checkout-page checkout-page-style2' : '' }}{{ Route::currentRouteName() == 'workshopbooking' ? 'checkout-page checkout-page-style2' : '' }}{{ Route::currentRouteName() == 'workshopdetail' ? 'template-product product-layout1' : '' }}{{ Route::currentRouteName() == 'workshops' ? 'shop-sub-collections' : '' }}{{ Route::currentRouteName() == 'gifts' ? 'shop-sub-collections' : '' }}{{ Route::currentRouteName() == 'professionals' ? 'shop-sub-collections' : '' }}{{ Route::currentRouteName() == 'productdetails' ? 'template-product product-layout1' : '' }}{{ Route::currentRouteName() == 'categoryproducts' ? 'shop-listing shop-fullwidth' : '' }}">
        <!-- Page Loader -->
        <!-- <div id="pre-loader"><img src="assets/images/loader.gif" alt="Loading..." /></div> -->
        <!-- End Page Loader -->

        <!--Page Wrapper-->
        <div class="page-wrapper">
            <!--Header-->
            <div id="header" class="header  {{ Route::currentRouteName() == 'home' ? 'header-1' : '' }} ">
                <div class="header-main">
                    <header class="header-wrap container d-flex align-items-center">
                        <div class="row g-0 align-items-center w-100">
                            <!--Social Icons-->
                            <div class="col-4 col-sm-4 col-md-4 col-lg-5 d-none d-lg-block">
                                <button type="button" class="btn--link site-header__menu js-mobile-nav-toggle mobile-nav--open me-3 btn rounded btn-secondary">
                                    <i class="icon an an-times-l"></i><i class="icon an an-bars-l me-2"></i>
                                    <span>Explore Categories</span>
                                </button>
                                <!-- <ul class="social-icons list-inline"> -->
                                    <!-- <li class="list-inline-item"><a href="#"><i class="an an-facebook" aria-hidden="true"></i><span class="tooltip-label">Facebook</span></a></li> -->
                                    <!-- <li class="list-inline-item"><a href="#"><i class="an an-twitter" aria-hidden="true"></i><span class="tooltip-label">Twitter</span></a></li> -->
                                    <!-- <li class="list-inline-item"><a href="#"><i class="an an-pinterest-p" aria-hidden="true"></i><span class="tooltip-label">Pinterest</span></a></li> -->
                                    <!-- <li class="list-inline-item"><a href="#"><i class="an an-instagram" aria-hidden="true"></i><span class="tooltip-label">Instagram</span></a></li> -->
                                    <!-- <li class="list-inline-item"><a href="#"><i class="an an-tiktok" aria-hidden="true"></i><span class="tooltip-label">TikTok</span></a></li> -->
                                    <!-- <li class="list-inline-item"><a href="#"><i class="an an-whatsapp" aria-hidden="true"></i><span class="tooltip-label">Whatsapp</span></a></li> -->
                                <!-- </ul> -->
                            </div>
                            <!--End Social Icons-->
                            <!--Logo / Menu Toggle-->
                            <div class="col-6 col-sm-6 col-md-6 col-lg-2 d-flex">
                                <!--Mobile Toggle-->
                                <button type="button" class="btn--link site-header__menu js-mobile-nav-toggle mobile-nav--open me-3 d-lg-none"><i class="icon an an-times-l"></i><i class="icon an an-bars-l"></i></button>
                                <!--End Mobile Toggle-->
                                <!--Logo-->
                                <div class="logo mx-lg-auto">
                                    <a href="{{ route('home') }}">
                                        <img class="logo-img" src="{{ asset('') }}front_end/assets/images/handwi-logo-black.svg" alt="" title="" />
                                        <!-- <span class="logo-txt" style="font-size: 32px;">SPACE</span> -->
                                    </a>
                                </div>
                                <!--End Logo-->
                            </div>
                            <!--End Logo / Menu Toggle-->
                            <!--Right Action-->
                            <div class="col-6 col-sm-6 col-md-6 col-lg-5 icons-col text-right d-flex justify-content-end">
                                <div class="wishlist-link iconset">
                                    <a href="{{url('portal')}}" class="btn w-100 rounded">Start to Sell</a>
                                </div>
                                <!--Search-->
                                <div class="site-search iconset"><i class="icon an an-search-l"></i><span class="tooltip-label">Search</span></div>
                                <!--End Search-->
                                <!--Wishlist-->
                                <!-- <div class="wishlist-link iconset">
                                    <a href="#"><i class="icon an an-heart-l"></i><span class="wishlist-count counter d-flex-center justify-content-center position-absolute translate-middle rounded-circle">0</span><span class="tooltip-label">Wishlist</span></a>
                                </div> -->
                                <!--End Wishlist-->
                                <!--Setting Dropdown-->
                                <!-- <div class="user-link iconset"><i class="icon an an-user-expand"></i><span class="tooltip-label">Account</span></div>
                                <div id="userLinks">
                                    <ul class="user-links">
                                    <li ><a href="{{ route('login') }}">Login</a></li>
                                    <li ><a href="{{ route('register') }}">Signup</a></li>
                                        <li><a href="">Wishlist</a></li>
                                    </ul>
                                </div> -->
                                <div class="user-link iconset">
                                    <i class="icon an an-user-expand"></i>
                                    <span class="tooltip-label">
                                        @if(Auth::user() && Auth::user()->role == 2)
                                            Hi, {{ Auth::user()->first_name }} <!-- Show user's first name if logged in -->
                                        @else
                                            Account
                                        @endif
                                    </span>
                                </div>

                                <div id="userLinks">
                                    <ul class="user-links">
                                        @if(Auth::user() && Auth::user()->role == 2 )
                                            <!-- If user is logged in -->
                                            <li><a href="{{ route('userdashboard') }}">Dashboard</a></li> <!-- Link to the Dashboard -->
                                            <li><a href="{{ route('logoutuser') }}">Logout</a></li> 
                                            
                                        @else
                                            <!-- If user is not logged in -->
                                            <li><a href="{{ route('login') }}">Login</a></li>
                                            <li><a href="{{ route('register') }}">Signup</a></li>
                                            <!-- <li><a href="#">Wishlist</a></li> -->
                                        @endif
                                        
                                    </ul>
                                </div>

                                <!--End Setting Dropdown-->
                                <!--Minicart Drawer-->
                                <div class="header-cart iconset">
                                    <a href="{{ route('cart') }}" class="site-header__cart btn-minicart" data-bs-toggle="modal" data-bs-target="#minicart-drawer">
                                        <i class="icon an an-sq-bag"></i><span class="site-cart-count counter d-flex-center justify-content-center position-absolute translate-middle rounded-circle" id="cartcountheader">0</span><span class="tooltip-label">Cart</span>
                                    </a>
                                </div>
                                 <div class="switch language-switch">
                                    <input id="language-toggle-desktop" class="check-toggle" type="checkbox">
                                    <label for="language-toggle-desktop"></label>
                                    <span class="on">EN</span>
                                            <span class="off">AR</span>
                                </div>
                                <!--End Minicart Drawer-->
                                <!--Setting Dropdown-->
                                <!-- <div class="setting-link iconset pe-0"><i class="icon an an-right-bar-s"></i><span class="tooltip-label">Settings</span></div> -->
                                <div id="settingsBox">
                                    <div class="currency-picker">
                                        <span class="ttl">Select Currency</span>
                                        <ul id="currencies" class="cnrLangList">
                                            <li class="selected"><a href="#;" class="active">INR</a></li><li><a href="#;">GBP</a></li><li><a href="#;">CAD</a></li><li><a href="#;">USD</a></li><li><a href="#;">AUD</a></li><li><a href="#;">EUR</a></li><li><a href="#;">JPY</a></li>
                                        </ul>
                                    </div>
                                    <div class="language-picker">
                                        <span class="ttl">SELECT LANGUAGE</span>
                                        <ul id="language" class="cnrLangList">
                                            <li><a href="#" class="active">English</a></li><li><a href="#">French</a></li><li><a href="#">German</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!--End Setting Dropdown-->
                            </div>
                            <!--End Right Action-->
                        </div>
                    </header>
                    <!--Main Navigation Desktop-->
                    <div class="menu-outer  d-none">
                        <nav class="container">
                            <div class="row">
                                <div class="col-1 col-sm-12 col-md-12 col-lg-12 align-self-center d-menu-col">
                                    <!--Desktop Menu-->
                                    <nav class="grid__item" id="AccessibleNav">
                                        <ul id="siteNav" class="site-nav medium center hidearrow">

                                            @php
                                                use App\Models\Categories;

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
                                            @endphp
                                            <!-- <li class="lvl1 parent megamenu"><a href="#;">Home <i class="an an-angle-down-l"></i></a></li> -->
                                            @foreach ($categoriesHierarchy as $parent)
                                            <li class="lvl1 parent megamenu">
                                                <a href="{{ route('categoryproducts', ['id' => $parent['category']->id]) }}">
                                                    {!! app()->getLocale() === 'ar' && !empty($parent['category']->name_ar) ? $parent['category']->name_ar : $parent['category']->name !!} <i class="an an-angle-down-l"></i>
                                                </a>
                                                @if (!empty($parent['children']))
                                                    <div class="megamenu style4">
                                                        <div class="row">
                                                            @foreach (array_chunk($parent['children'], 3) as $childGroup)
                                                                <div class="col-md-4 col-lg-4">
                                                                    <ul class="subLinks">
                                                                        @foreach ($childGroup as $child)
                                                                          
                                                                            <li class="lvl-2">
                                                                                <a href="{{ route('categoryproducts', ['id' => $child->id]) }}" class="site-nav lvl-2">
                                                                                    {!! app()->getLocale() === 'ar' && !empty($child->name_ar) ? $child->name_ar : $child->name !!}
                                                                                </a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </li>
                                            @endforeach
                                            
                                        </ul>
                                    </nav>
                                    <!--End Desktop Menu-->
                                </div>
                            </div>
                        </nav>
                    </div>
                    <!--End Main Navigation Desktop-->
                    <!--Search Popup-->
                    <div id="search-popup" class="search-drawer">
                        <div class="container">
                            <span class="closeSearch an an-times-l"></span>
                            <form class="form minisearch" id="header-search"  action="{{ route('productssearch') }}" method="get">
                                <label class="label"><span>Search</span></label>
                                <div class="control">
                                    <div class="searchField">
                                        <div class="search-category">
                                            <select id="rgsearch-category" name="categorysearch" data-default="All Categories">
                                                <option value="00" label="All Categories" selected="selected">All Categories</option>
                                                <optgroup id="rgsearch-shop" label="Shop">
                                                    @php
                                                    

                                                    $categories = Categories::where('deleted', 0)
                                                        ->where('active', 1)
                                                        ->orderBy('name', 'ASC')
                                                        ->get();
                                                    @endphp
                                                    
                                                    <option value="0">- All</option>
                                                    @foreach ($categories as $category)
                                                    <option value="{{$category->id}}"> {!! app()->getLocale() === 'ar' && !empty($category->name_ar) ? $category->name_ar : $category->name !!}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="input-box">
                                            <button type="submit" title="Search"  class="action search" disabled=""><i class="icon an an-search-l"></i></button>
                                            <input type="text" name="q" value="{{ request('q') }}" value="" placeholder="Search by keyword or #" class="input-text" id="search-input">
                                            <ul id="autocomplete-results" style="display:none; position:absolute; background-color:white; border: 1px solid #ccc; padding: 0; margin-top: 5px;">
                                                <!-- Autocomplete results will appear here -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--End Search Popup-->
                </div>
            </div>
            <!--End Header-->
            <!--Mobile Menu-->
            <div class="mobile-nav-wrapper" role="navigation">
                <div class="closemobileMenu"><i class="icon an an-times-l pull-right"></i> Close Menu</div> 
                <ul id="MobileNav" class="mobile-nav">
                    <!-- <li class="lvl1 parent megamenu"><a href="#">Home <i class="an an-plus-l"></i></a>
                        <ul>
                            <li><a href="#" class="site-nav">Home Styles <i class="an an-plus-l"></i></a>
                                <ul>
                                    <li class="lvl-2"><a href="#" class="site-nav">Home 01 - Default</a></li>
                                    <li class="lvl-2"><a href="index-demo2.html" class="site-nav">Home 02 - Minimal</a></li>
                                    <li class="lvl-2"><a href="index-demo3.html" class="site-nav">Home 03 - Colorful</a></li>
                                    <li class="lvl-2"><a href="index-demo4.html" class="site-nav">Home 04 - Modern</a></li>
                                    <li class="lvl-2"><a href="index-demo5.html" class="site-nav">Home 05 - Kids Clothing</a></li>
                                    <li class="lvl-2"><a href="index-demo6.html" class="site-nav">Home 06 - Single Product</a></li>
                                    <li class="lvl-2"><a href="index-demo7.html" class="site-nav">Home 07 - Glamour</a></li>
                                    <li class="lvl-2"><a href="index-demo8.html" class="site-nav">Home 08 - Simple</a></li>
                                    <li class="lvl-2"><a href="index-demo9.html" class="site-nav">Home 09 - Cool <span class="lbl nm_label1">Hot</span></a></li>
                                    <li class="lvl-2"><a href="index-demo10.html" class="site-nav last">Home 10 - Cosmetic</a></li>
                                </ul>
                            </li>
                            <li><a href="#" class="site-nav">Home Styles <i class="an an-plus-l"></i></a>
                                <ul>
                                    <li class="lvl-2"><a href="index-demo11.html" class="site-nav">Home 11 - Pets <span class="lbl nm_label3">Popular</span></a></li>
                                    <li class="lvl-2"><a href="index-demo12.html" class="site-nav">Home 12 - Tools & Parts</a></li>
                                    <li class="lvl-2"><a href="index-demo13.html" class="site-nav">Home 13 - Watches <span class="lbl nm_label1">Hot</span></a></li>
                                    <li class="lvl-2"><a href="index-demo14.html" class="site-nav">Home 14 - Food</a></li>
                                    <li class="lvl-2"><a href="index-demo15.html" class="site-nav">Home 15 - Christmas</a></li>
                                    <li class="lvl-2"><a href="index-demo16.html" class="site-nav">Home 16 - Phone Case</a></li>
                                    <li class="lvl-2"><a href="index-demo17.html" class="site-nav">Home 17 - Jewelry</a></li>
                                    <li class="lvl-2"><a href="index-demo18.html" class="site-nav">Home 18 - Bag <span class="lbl nm_label3">Popular</span></a></li>
                                    <li class="lvl-2"><a href="index-demo19.html" class="site-nav">Home 19 - Swimwear</a></li>
                                    <li class="lvl-2"><a href="index-demo20.html" class="site-nav last">Home 20 - Furniture <span class="lbl nm_label2">New</span></a></li>
                                </ul>
                            </li>
                            <li><a href="#" class="site-nav">Home Styles <i class="an an-plus-l"></i></a>
                                <ul>
                                    <li class="lvl-2"><a href="index-demo21.html" class="site-nav">Home 21 - Party Supplies</a></li>
                                    <li class="lvl-2"><a href="index-demo22.html" class="site-nav">Home 22 - Digital</a></li>
                                    <li class="lvl-2"><a href="index-demo23.html" class="site-nav">Home 23 - Vogue</a></li>
                                    <li class="lvl-2"><a href="index-demo24.html" class="site-nav">Home 24 - Glamour</a></li>
                                    <li class="lvl-2"><a href="index-demo25.html" class="site-nav">Home 25 - Shoes <span class="lbl nm_label2">New</span></a></li>
                                    <li class="lvl-2"><a href="index-demo26.html" class="site-nav">Home 26 - Books <span class="lbl nm_label2">New</span></a></li>
                                    <li class="lvl-2"><a href="index-demo27.html" class="site-nav last">Home 27 - Yoga <span class="lbl nm_label2">New</span></a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="lvl1 parent megamenu"><a href="#">Shop <i class="an an-plus-l"></i></a>
                        <ul>
                            <li><a href="#" class="site-nav">Category Page <i class="an an-plus-l"></i></a>
                                <ul>
                                    <li><a href="#" class="site-nav">2 Columns with style1</a></li>
                                    <li><a href="#" class="site-nav">3 Columns with style2</a></li>
                                    <li><a href="#" class="site-nav">4 Columns with style3</a></li>
                                    <li><a href="#" class="site-nav">5 Columns with style4</a></li>
                                    <li><a href="#" class="site-nav">6 Columns with Fullwidth</a></li>
                                    <li><a href="#" class="site-nav">7 Columns</a></li>
                                    <li><a href="#" class="site-nav last">Category Empty</a></li>
                                </ul>
                            </li>
                            <li><a href="#" class="site-nav">Shop Page <i class="an an-plus-l"></i></a>
                                <ul>
                                    <li><a href="#" class="site-nav">Left Sidebar</a></li>
                                    <li><a href="#" class="site-nav">Right Sidebar</a></li>
                                    <li><a href="#" class="site-nav">Top Filter</a></li>
                                    <li><a href="#" class="site-nav">Fullwidth</a></li>
                                    <li><a href="#" class="site-nav">Without Filter</a></li>
                                    <li><a href="#" class="site-nav">List View</a></li>
                                    <li><a href="#" class="site-nav">List View Drawer</a></li>
                                    <li><a href="#" class="site-nav">Category Slideshow</a></li>
                                    <li><a href="#" class="site-nav last">Headings With Banner</a></li>
                                </ul>
                            </li>
                            <li><a href="#" class="site-nav">Shop Page <i class="an an-plus-l"></i></a>
                                <ul>
                                    <li><a href="#" class="site-nav">Sub Collection List <span class="lbl nm_label5">Hot</span></a></li>
                                    <li><a href="#" class="site-nav">Shop Masonry Grid</a></li>
                                    <li><a href="#" class="site-nav">Shop Countdown</a></li>
                                    <li><a href="#" class="site-nav">Shop Hover Info</a></li>
                                    <li><a href="#" class="site-nav">Infinite Scrolling</a></li>
                                    <li><a href="#" class="site-nav">Classic Pagination</a></li>
                                    <li><a href="#" class="site-nav">Swatches Style</a></li>
                                    <li><a href="#" class="site-nav">Grid Style</a></li>
                                    <li><a href="#" class="site-nav last">Search Results</a></li>
                                </ul>
                            </li>
                            <li><a href="#" class="site-nav">Shop Other Page <i class="an an-plus-l"></i></a>
                                <ul>
                                    <li><a href="#" class="site-nav">My Wishlist Style1</a></li>
                                    <li><a href="#" class="site-nav">My Wishlist Style2</a></li>
                                    <li><a href="#" class="site-nav">Compare Page Style1</a></li>
                                    <li><a href="#" class="site-nav">Compare Page Style2</a></li>
                                    <li><a href="#" class="site-nav">Cart Page Style1</a></li>
                                    <li><a href="#" class="site-nav">Cart Page Style2</a></li>
                                    <li><a href="#" class="site-nav">Checkout Page Style1</a></li>
                                    <li><a href="#" class="site-nav">Checkout Page Style2</a></li>
                                    <li><a href="#" class="site-nav last">Checkout Success</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li> -->
                    <!-- <li class="lvl1 parent megamenu"><a href="#">Product <i class="an an-plus-l"></i></a>
                        <ul>
                            <li><a href="#" class="site-nav">Product Types<i class="an an-plus-l"></i></a>
                                <ul>
                                    <li><a href="#" class="site-nav">Simple Product</a></li>
                                    <li><a href="#" class="site-nav">Variable Product</a></li>
                                    <li><a href="#" class="site-nav">Grouped Product</a></li>
                                    <li><a href="#" class="site-nav">External / Affiliate Product</a></li>
                                    <li><a href="#" class="site-nav">Out Of Stock Product</a></li>
                                    <li><a href="#" class="site-nav">New Product</a></li>
                                    <li><a href="#" class="site-nav">Sale Product</a></li>
                                    <li><a href="#" class="site-nav">Variable Image</a></li>
                                    <li><a href="#" class="site-nav">Variable Select</a></li>
                                    <li><a href="#" class="site-nav last">360 Degree view</a></li>
                                </ul>
                            </li>
                            <li><a href="#" class="site-nav">Product Page Types <i class="an an-plus-l"></i></a>
                                <ul>
                                    <li><a href="#" class="site-nav">Product Layout1</a></li>
                                    <li><a href="#" class="site-nav">Product Layout2</a></li>
                                    <li><a href="#" class="site-nav">Product Layout3</a></li>
                                    <li><a href="#" class="site-nav">Product Layout4</a></li>
                                    <li><a href="#" class="site-nav">Product Layout5</a></li>
                                    <li><a href="#" class="site-nav">Product Layout6</a></li>
                                    <li><a href="#" class="site-nav">Product Layout7</a></li>
                                    <li><a href="#" class="site-nav">Product Accordian</a></li>
                                    <li><a href="#" class="site-nav">Product Tabs Left</a></li>
                                    <li><a href="#" class="site-nav last">Product Tabs Center</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li> -->
                    @foreach ($categoriesHierarchy as $parent)
                        <li class="lvl1 parent megamenu">
                            <a href="{{ route('categoryproducts', ['id' => $parent['category']->id]) }}">
                                {!! app()->getLocale() === 'ar' && !empty($parent['category']->name_ar) ? $parent['category']->name_ar : $parent['category']->name !!}
                                @if (!empty($parent['children'])) <!-- If category has children -->
                                    <i class="an an-plus-l"></i>
                                @endif
                            </a>
                            
                            @if (!empty($parent['children'])) <!-- If category has children -->
                                <ul>
                                    @foreach (array_chunk($parent['children'], 3) as $childGroup) <!-- Loop through child categories -->
                                        <li>
                                            @foreach ($childGroup as $child)
                                            
                                                <a href="{{ route('categoryproducts', ['id' => $child->id]) }}" class="site-nav">
                                                    {!! app()->getLocale() === 'ar' && !empty($child->name_ar) ? $child->name_ar : $child->name !!}
                                                </a>
                                            @endforeach
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach


                   
                    <li class="acLink"></li>
                    <li class="lvl1 bottom-link"><a href="{{ route('login') }}">Login</a></li>
                    <li class="lvl1 bottom-link"><a href="{{ route('register') }}">Signup</a></li>
                    <!-- <li class="lvl1 bottom-link"><a href="#">Wishlist</a></li> -->
                    <!-- <li class="lvl1 bottom-link"><a href="#">Compare</a></li> -->
                    <li class="help bottom-link"><b>NEED HELP?</b><br>Call: +971 525 523 5687</li>
                </ul>
            </div>
            <!--End Mobile Menu-->
            @yield('content')




              <!--Footer-->
              <div class="footer footer-1">
                <div class="footer-top clearfix">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 text-center about-col mb-4">
                                <img src="{{ asset('') }}front_end/assets/images/handwi-logo-black.svg" alt="" class="mb-3"/>
                                @php
                                use App\Models\ContactUsSetting;
                                $contactdetails  = ContactUsSetting::first();
                                @endphp
                                <!-- <span class="logo-txt" style="font-size: 32px;font-weight: 700;text-transform: uppercase;">SPACE</span> -->
                                <p>{{$contactdetails->location}}</p>
                                <p class="mb-0 mb-md-3">Phone: <a href="tel:{{$contactdetails->mobile}}">{{$contactdetails->mobile}}</a> <span class="mx-1">|</span> Email: <a href="mailto:{{$contactdetails->email}}">{{$contactdetails->email}}</a></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-4 col-lg-3 footer-links">
                                <h4 class="h4">Informations</h4>
                                <ul>
                                    <li><a href="{{ route('login') }}">My Account</a></li>
                                    <li><a href="{{route('about-us')}}">About us</a></li>
                                    <li ><a href="{{ route('login') }}">Login</a></li>
                                    <li ><a href="{{ route('blogs') }}">Blog</a></li>
                                    
                                   
                                </ul>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4 col-lg-2 footer-links">
                                <h4 class="h4">Quick Shop</h4>
                                <ul>
                                
                                <li><a href="{{ route('gifts') }}">Gift</a></li>
                                <li><a href="{{ route('professionals') }}">Professional</a></li>
                                <li><a href="{{ route('workshops') }}">Workshops</a></li>
                                
                                </ul>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4 col-lg-3 footer-links">
                                <h4 class="h4">Customer Services</h4>
                                <ul>
                                    
                                    <li><a href="{{route('faq')}}">FAQ's</a></li>
                                    <li><a href="{{route('contactus')}}">Contact Us</a></li>
                                    <li><a href="{{route('terms-and-condition')}}">Terms and Conditions</a></li>
                                    <li><a href="{{route('privacy-policy')}}">Privacy Policy</a></li>
                                </ul>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-4 newsletter-col">
                                <div class="display-table pt-md-3 pt-lg-0">
                                    <div class="display-table-cell footer-newsletter">
                                        <form action="#" method="post" id="newsletter-form">
                                            <label class="h4">NEWSLETTER SIGN UP</label>
                                            <p>Enter Your Email To Receive Daily News And Get 20% Off Coupon For All Items.</p>
                                            <div class="input-group">
                                                <input type="email" class="brounded-start input-group__field newsletter-input mb-0" name="newsletteremail" id="newsletteremail"  placeholder="Email address" required>
                                                <span class="input-group__btn">
                                                    <button type="submit" class="btn newsletter__submit rounded-end" name="commit" id="Subscribe"><i class="an an-envelope-l"></i></button>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <ul class="list-inline social-icons mt-3 pt-1">
                                    <li class="list-inline-item"><a href="{{$contactdetails->facebook}}" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="Facebook"><i class="an an-facebook" aria-hidden="true"></i></a></li>
                                    <li class="list-inline-item"><a href="{{$contactdetails->twitter}}" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="Twitter"><i class="an an-twitter" aria-hidden="true"></i></a></li>
                                    <li class="list-inline-item"><a href="{{$contactdetails->pinterest}}" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="Pinterest"><i class="an an-pinterest-p" aria-hidden="true"></i></a></li>
                                    <li class="list-inline-item"><a href="{{$contactdetails->instagram}}" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="Instagram"><i class="an an-instagram" aria-hidden="true"></i></a></li>
                                    <li class="list-inline-item"><a href="{{$contactdetails->tiktok}}" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="TikTok"><i class="an an-tiktok" aria-hidden="true"></i></a></li>
                                    <li class="list-inline-item"><a href="https://wa.me/{{ $contactdetails->whatsapp }}" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="Whatsapp"><i class="an an-whatsapp" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom clearfix">
                    <div class="container">
                        <div class="d-flex-center flex-column justify-content-md-between flex-md-row-reverse">
                            <img src="{{ asset('') }}front_end/assets/images/payment.png" alt="Paypal Visa Payments"/>
                            <div class="copytext text-uppercase">&copy; <script>document.write(new Date().getFullYear())</script> Handwi. All Rights Reserved.</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Footer-->

<!--Sticky Menubar Mobile-->
<div class="menubar-mobile d-flex align-items-center justify-content-between d-lg-none">
    <div class="menubar-shop menubar-item">
        <a href="#">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.9952 22.9856C10.1452 22.9856 8.29512 22.9466 6.45149 22.9986C4.56305 23.0506 2.681 21.6138 2.35453 19.4682C1.95123 16.783 1.45832 14.1043 1.05502 11.419C0.83097 9.93664 1.29188 8.61679 2.42494 7.66104C4.7935 5.6715 7.20046 3.74049 9.60743 1.80297C10.9389 0.730185 13.0386 0.730185 14.3958 1.81598C16.8091 3.74699 19.2225 5.6715 21.5846 7.66754C22.7817 8.68181 23.185 10.0797 22.929 11.6466C22.5065 14.2408 22.0648 16.835 21.6551 19.4292C21.3606 21.2692 20.0419 22.654 18.2303 22.9531C18.0318 22.9856 17.8334 22.9856 17.6349 22.9856C15.7529 22.9921 13.8708 22.9856 11.9952 22.9856ZM12.0208 21.4252C13.9092 21.4252 15.7977 21.4317 17.6861 21.4252C18.9024 21.4187 19.9267 20.5085 20.1187 19.2926C20.5412 16.6919 20.9637 14.0913 21.4054 11.4906C21.6038 10.3072 21.2774 9.34499 20.3299 8.61679C19.9651 8.33722 19.6194 8.03814 19.2609 7.75206C17.3596 6.21115 15.4648 4.66374 13.5636 3.12933C12.6866 2.42064 11.3678 2.39463 10.51 3.09032C8.14149 5.00183 5.77933 6.91334 3.43638 8.85085C2.71301 9.44901 2.43135 10.2942 2.57858 11.237C2.98828 13.8442 3.46839 16.4319 3.83968 19.0456C4.06373 20.6125 5.31202 21.5032 6.59872 21.4512C8.39755 21.3797 10.2092 21.4252 12.0208 21.4252Z" fill="#141414" stroke="white"/>
                <path d="M15.3302 13.058C15.3238 14.924 13.8258 16.4389 11.995 16.4324C10.1642 16.4259 8.67902 14.9045 8.67902 13.0385C8.68542 11.1725 10.177 9.66406 12.0142 9.66406C13.845 9.67056 15.3366 11.192 15.3302 13.058ZM13.7938 13.058C13.8002 12.0567 13.0064 11.2375 12.027 11.2245C11.0412 11.218 10.2346 12.0242 10.2218 13.019C10.209 14.0267 11.0156 14.859 12.0014 14.8655C12.9744 14.8785 13.7874 14.0527 13.7938 13.058Z" fill="#141414" stroke="white"/>
                </svg>
                
            <span class="menubar-label">Home</span></a>
    </div>
    <div class="menubar-account menubar-item">
        
        <a href="#">
            <span class="span-count position-relative text-center">
                
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.001 20.5907C10.3407 20.5907 9.6804 20.3394 9.17775 19.8367L1.91955 12.5785C-0.637817 10.0211 -0.637817 5.86001 1.91955 3.30268C4.41307 0.80916 8.43147 0.747114 11.0011 3.11615C13.5709 0.748918 17.5875 0.811825 20.0805 3.3047C21.3193 4.54353 22.0015 6.19065 22.0015 7.94258C22.0015 9.69445 21.3191 11.3417 20.0805 12.5805L12.8243 19.8367C12.3216 20.3394 11.6613 20.5907 11.001 20.5907ZM6.55747 3.1006C5.26467 3.1006 4.04926 3.60402 3.1351 4.51818C2.22094 5.43234 1.71747 6.6478 1.71747 7.9406C1.71747 9.2334 2.22089 10.4488 3.13505 11.363L10.3932 18.6212C10.7284 18.9563 11.2736 18.9563 11.6087 18.6212L18.865 11.365C19.7791 10.4508 20.2825 9.23542 20.2825 7.94262C20.2825 6.64982 19.7791 5.4344 18.8649 4.52024C16.9778 2.63314 13.9073 2.63314 12.0202 4.52024L11.6087 4.93167C11.2731 5.26738 10.7289 5.26734 10.3932 4.93167L9.9798 4.51827C9.06569 3.60406 7.85027 3.1006 6.55747 3.1006Z" fill="#141414" fill-opacity="0.4" stroke="white"/>
                </svg>
                    
                <span class="menubar-count counter d-flex-center justify-content-center position-absolute translate-middle rounded-circle">0</span></span>
            <span class="menubar-label">Favorite</span>
        </a>
    </div>
    <div class="menubar-search menubar-item">
        <a href="{{route('gifts')}}">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18.7917 6.41667H15.4797C17.1591 5.61092 18.3333 4.25792 18.3333 2.29167C18.3333 2.03867 18.128 1.83333 17.875 1.83333C17.622 1.83333 17.4167 2.03867 17.4167 2.29167C17.4167 5.09942 14.4183 6.13158 12.0643 6.3635C12.7783 5.48075 13.75 4.0425 13.75 2.75C13.75 1.23383 12.5162 0 11 0C9.48383 0 8.25 1.23383 8.25 2.75C8.25 4.0425 9.22075 5.47983 9.93575 6.3635C7.58175 6.1325 4.58333 5.09942 4.58333 2.29167C4.58333 2.03867 4.378 1.83333 4.125 1.83333C3.872 1.83333 3.66667 2.03867 3.66667 2.29167C3.66667 4.25792 4.84092 5.61092 6.52025 6.41667H3.20833C1.43917 6.41667 0 7.85583 0 9.625V10.5417C0 11.2998 0.616917 11.9167 1.375 11.9167H1.83333V17.875C1.83333 20.1493 3.68408 22 5.95833 22H16.0417C18.3159 22 20.1667 20.1493 20.1667 17.875V11.9167H20.625C21.3831 11.9167 22 11.2998 22 10.5417V9.625C22 7.85583 20.5608 6.41667 18.7917 6.41667ZM11 0.916667C12.0111 0.916667 12.8333 1.73892 12.8333 2.75C12.8333 3.894 11.7058 5.40742 11 6.204C10.2942 5.40742 9.16667 3.894 9.16667 2.75C9.16667 1.73892 9.98892 0.916667 11 0.916667ZM0.916667 10.5417V9.625C0.916667 8.36183 1.94517 7.33333 3.20833 7.33333H10.5417V11H1.375C1.122 11 0.916667 10.7947 0.916667 10.5417ZM2.75 17.875V11.9167H10.5417V21.0833H5.95833C4.18917 21.0833 2.75 19.6442 2.75 17.875ZM19.25 17.875C19.25 19.6442 17.8108 21.0833 16.0417 21.0833H11.4583V11.9167H19.25V17.875ZM21.0833 10.5417C21.0833 10.7947 20.878 11 20.625 11H11.4583V7.33333H18.7917C20.0548 7.33333 21.0833 8.36183 21.0833 9.625V10.5417Z" fill="#141414" fill-opacity="0.4" stroke="white" stroke-width="0.3"/>
                </svg>
                    
        <span class="menubar-label">Gifts</span></a>
    </div>
    <div class="menubar-wish menubar-item">
        
        <a href="{{route('workshops')}}">
                
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22 5C20.897 5 20 5.897 20 7C20 7.215 20.043 7.418 20.106 7.613L16.44 9.946C15.681 8.833 14.676 7.905 13.509 7.225L15.454 3.915C15.629 3.965 15.809 4 16 4C17.103 4 18 3.103 18 2C18 0.897 17.103 0 16 0C14.897 0 14 0.897 14 2C14 2.552 14.225 3.053 14.588 3.415L12.618 6.767C11.509 6.278 10.287 6.001 8.999 6.001C4.037 6.001 0 10.039 0 15.001C0 19.963 4.037 24.001 9 24.001C13.963 24.001 18 19.964 18 15.001C18 13.485 17.62 12.058 16.955 10.803L20.64 8.458C20.997 8.792 21.473 9 22 9C23.103 9 24 8.103 24 7C24 5.897 23.103 5 22 5ZM16 1C16.552 1 17 1.449 17 2C17 2.551 16.552 3 16 3C15.448 3 15 2.551 15 2C15 1.449 15.448 1 16 1ZM8.382 17.18C11.797 16.35 14.518 13.791 15.552 10.424C16.002 11.066 16.361 11.776 16.608 12.537C15.728 15.396 13.424 17.626 10.532 18.401C9.754 18.097 9.033 17.683 8.382 17.18ZM14.763 9.466C13.95 13.052 11.063 15.755 7.439 16.338C6.96 15.842 6.543 15.288 6.193 14.69C9.474 13.906 12.138 11.383 13.094 8.14C13.708 8.508 14.27 8.952 14.763 9.466ZM5.148 11.878C7.487 11.118 9.39 9.387 10.366 7.126C11.004 7.237 11.618 7.418 12.195 7.671C11.37 10.743 8.832 13.132 5.722 13.776C5.46 13.175 5.268 12.539 5.148 11.878ZM9.322 7.017C8.454 8.815 6.909 10.2 5.028 10.866C5.017 10.685 5 10.504 5 10.32C5 9.491 5.127 8.675 5.357 7.887C6.451 7.324 7.688 7 9 7C9.109 7 9.214 7.012 9.322 7.016V7.017ZM1 15.001C1 14.133 1.143 13.299 1.4 12.516C1.892 17.939 6.341 22.224 11.829 22.475C10.948 22.81 9.997 23.001 8.999 23.001C4.588 23.001 1 19.412 1 15.001ZM13.792 21.391C13.312 21.462 12.822 21.5 12.333 21.5C6.828 21.5 2.35 17.021 2.35 11.517C2.35 11.227 2.359 10.826 2.382 10.514C2.869 9.799 3.473 9.172 4.159 8.647C4.063 9.198 4 9.755 4 10.32C4 15.657 8.343 20 13.68 20C14.245 20 14.804 19.937 15.355 19.841C14.907 20.427 14.382 20.948 13.793 21.391H13.792ZM16.114 18.643C15.326 18.873 14.51 19 13.68 19C13.171 19 12.675 18.947 12.19 18.863C14.264 17.946 15.954 16.326 16.965 14.299C16.985 14.531 17.001 14.764 17.001 15.001C17.001 16.313 16.676 17.549 16.114 18.643ZM22 8C21.448 8 21 7.551 21 7C21 6.449 21.448 6 22 6C22.552 6 23 6.449 23 7C23 7.551 22.552 8 22 8Z" fill="#141414" fill-opacity="0.4" stroke="white" stroke-width="0.4"/>
                </svg>
            <span class="menubar-label">Workshop</span></a>
    </div>
    <div class="menubar-cart menubar-item">
        <a href="{{ route('cart') }}" class="cartBtn" data-bs-toggle="modal" data-bs-target="#minicart-drawer">
            <span class="span-count position-relative text-center">
                <svg width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.65 21.5H5.95001C3.47501 21.5 1.45001 19.475 1.45001 17V16.85L1.90001 4.85C1.97501 2.375 4.00001 0.5 6.40001 0.5H17.2C19.6 0.5 21.625 2.375 21.7 4.85L22.15 16.85C22.225 18.05 21.775 19.175 20.95 20.075C20.125 20.975 19 21.5 17.8 21.5H17.65ZM6.40001 2C4.75001 2 3.47501 3.275 3.40001 4.85L2.95001 17C2.95001 18.65 4.30001 20 5.95001 20H17.8C18.625 20 19.375 19.625 19.9 19.025C20.425 18.425 20.725 17.675 20.725 16.85L20.275 4.85C20.2 3.2 18.925 2 17.275 2H6.40001Z" fill="#141414" fill-opacity="0.4" stroke="white"/>
                    <path d="M11.8 9.5C8.87499 9.5 6.54999 7.175 6.54999 4.25C6.54999 3.8 6.84999 3.5 7.29999 3.5C7.74999 3.5 8.04999 3.8 8.04999 4.25C8.04999 6.35 9.69999 8 11.8 8C13.9 8 15.55 6.35 15.55 4.25C15.55 3.8 15.85 3.5 16.3 3.5C16.75 3.5 17.05 3.8 17.05 4.25C17.05 7.175 14.725 9.5 11.8 9.5Z" fill="#141414" fill-opacity="0.4" stroke="white"/>
                    </svg>
                    <span class="menubar-count counter d-flex-center justify-content-center position-absolute translate-middle rounded-circle" id="cart_counter">0</span></span>
            <span class="menubar-label">Cart</span>
        </a>
    </div>
</div>
<!--End Sticky Menubar Mobile-->


            <!--Scoll Top-->
            <span id="site-scroll"><i class="icon an an-chevron-up"></i></span>
            <!--End Scoll Top-->

            <!--MiniCart Drawer-->
            <!-- <div class="minicart-right-drawer modal right fade" id="minicart-drawer">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div id="cart-drawer" class="block block-cart">
                            <div class="minicart-header">
                                <a href="javascript:void(0);" class="close-cart" data-bs-dismiss="modal" aria-label="Close"><i class="an an-times-r" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="left" title="Close"></i></a>
                                <h4 class="fs-6">Your cart (2 Items)</h4>
                            </div>
                            <div class="minicart-content">
                                <ul class="clearfix">
                                    <li class="item d-flex justify-content-center align-items-center">
                                        <a class="product-image" href="#">
                                            <img class="blur-up lazyload" src="{{ asset('') }}front_end/assets/images/products/cart-product-img1.jpg" data-src="assets/images/products/cart-product-img1.jpg" alt="image" title="">
                                        </a>
                                        <div class="product-details">
                                            <a class="product-title" href="#">Floral Crop Top</a>
                                            <div class="variant-cart">Black / XL</div>
                                            <div class="priceRow">
                                                <div class="product-price">
                                                    <span class="money">AED 59.00</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="qtyDetail text-center">
                                            <div class="wrapQtyBtn">
                                                <div class="qtyField">
                                                    <a class="qtyBtn minus" href="javascript:void(0);"><i class="icon an an-minus-r" aria-hidden="true"></i></a>
                                                    <input type="text" name="quantity" value="1" class="qty">
                                                    <a class="qtyBtn plus" href="javascript:void(0);"><i class="icon an an-plus-l" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                            <a href="#" class="edit-i remove"><i class="icon an an-edit-l" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>
                                            <a href="#" class="remove"><i class="an an-times-r" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove"></i></a>
                                        </div>
                                    </li>
                                    <li class="item d-flex justify-content-center align-items-center">
                                        <a class="product-image" href="#">
                                            <img class="blur-up lazyload" src="{{ asset('') }}front_end/assets/images/products/cart-product-img2.jpg" data-src="{{ asset('') }}front_end/assets/images/products/cart-product-img2.jpg" alt="image" title="">
                                        </a>
                                        <div class="product-details">
                                            <a class="product-title" href="#">V Neck T-shirts</a>
                                            <div class="variant-cart">Blue / XL</div>
                                            <div class="priceRow">
                                                <div class="product-price">
                                                    <span class="money">AED 199.00</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="qtyDetail text-center">
                                            <div class="wrapQtyBtn">
                                                <div class="qtyField">
                                                    <a class="qtyBtn minus" href="javascript:void(0);"><i class="icon an an-minus-r" aria-hidden="true"></i></a>
                                                    <input type="text" name="quantity" value="1" class="qty">
                                                    <a class="qtyBtn plus" href="javascript:void(0);"><i class="icon an an-plus-l" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                            <a href="#" class="edit-i remove"><i class="icon an an-edit-l" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>
                                            <a href="#" class="remove"><i class="an an-times-r" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove"></i></a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="minicart-bottom">
                                <div class="shipinfo text-center mb-3 text-uppercase">
                                    <p class="freeShipMsg"><i class="an an-truck fs-5 me-2 align-middle"></i>SPENT <b>AED 199.00</b> MORE FOR FREE SHIPPING</p>
                                </div>
                                <div class="subtotal">
                                    <span>Total:</span>
                                    <span class="product-price">AED 93.13</span>
                                </div>
                                <a href="buynow-checkout.html" class="w-100 p-2 my-2 btn btn-outline-primary proceed-to-checkout rounded">Proceed to Checkout</a>
                                <a href="cart.html" class="w-100 btn-primary cart-btn rounded">View Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- Mini Cart Modal (Drawer) -->
                <div class="minicart-right-drawer modal right fade" id="minicart-drawer">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div id="cart-drawer" class="block block-cart">
                                <div class="minicart-header">
                                    <a href="javascript:void(0);" class="close-cart" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="an an-times-r" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="left" title="Close"></i>
                                    </a>
                                    <!-- Dynamic cart item count -->
                                    <h4 class="fs-6">Your cart (<span id="cart-item-count">0</span> Items)</h4>
                                </div>
                                <div class="minicart-content">
                                    <ul class="clearfix" id="cart-items-list"></ul>
                                </div>
                                <div class="minicart-bottom" id="cartminibottomdetails">
                                    <div class="subtotal">
                                        <span>Tax:</span>
                                        <span class="product-price" id="cart-total-tax">AED 0.00</span>
                                    </div>
                                    <div class="subtotal">
                                        <span>Shipping:</span>
                                        <span class="product-price" id="cart-total-shipping">AED 0.00</span>
                                    </div>
                                    <div class="subtotal">
                                        <span>Total:</span>
                                        <span class="product-price" id="cart-total">AED 0.00</span>
                                    </div>
                                    <a href="{{route('checkout')}}" class="w-100 p-2 my-2 btn btn-outline-primary proceed-to-checkout rounded">Proceed to Checkout</a>
                                    <a href="{{ route('cart') }}" class="w-100 btn-primary cart-btn rounded">View Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <!--End MiniCart Drawer-->
            <div class="modalOverly"></div>

            <!--Quickview Popup-->
            <div class="loadingBox"><div class="an-spin"><i class="icon an an-spinner4"></i></div></div>
            <div id="quickView-modal" class="mfp-with-anim mfp-hide">
                <button title="Close (Esc)" type="button" class="mfp-close">×</button>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 mb-3 mb-md-0">
                        <!--Model thumbnail -->
                        <div id="quickView" class="carousel slide">
                            <!-- Image Slide carousel items -->
                            <div class="carousel-inner">
                                <div class="item carousel-item active" data-bs-slide-number="0">
                                    <img class="blur-up lazyload" data-src="{{ asset('') }}front_end/assets/images/products/product-5.jpg" src="{{ asset('') }}front_end/assets/images/products/product-5.jpg" alt="image" title="" />
                                </div>
                                <div class="item carousel-item" data-bs-slide-number="1">
                                    <img class="blur-up lazyload" data-src="{{ asset('') }}front_end/assets/images/products/product-5-1.jpg" src="{{ asset('') }}front_end/assets/images/products/product-5-1.jpg" alt="image" title="" />
                                </div>
                                <div class="item carousel-item" data-bs-slide-number="2">
                                    <img class="blur-up lazyload" data-src="{{ asset('') }}front_end/assets/images/products/product-5-2.jpg" src="{{ asset('') }}front_end/assets/images/products/product-5-2.jpg" alt="image" title="" />
                                </div>
                                <div class="item carousel-item" data-bs-slide-number="3">
                                    <img class="blur-up lazyload" data-src="{{ asset('') }}front_end/assets/images/products/product-5-3.jpg" src="{{ asset('') }}front_end/assets/images/products/product-5-3.jpg" alt="image" title="" />
                                </div>
                                <div class="item carousel-item" data-bs-slide-number="4">
                                    <img class="blur-up lazyload" data-src="{{ asset('') }}front_end/assets/images/products/product-5-4.jpg" src="{{ asset('') }}front_end/assets/images/products/product-5-4.jpg" alt="image" title="" />
                                </div>
                            </div>
                            <!-- End Image Slide carousel items -->
                            <!-- Thumbnail image -->
                            <div class="model-thumbnail-img">
                                <!-- Thumbnail slide -->
                                <div class="carousel-indicators list-inline">
                                    <div class="list-inline-item active" id="carousel-selector-0" data-bs-slide-to="0" data-bs-target="#quickView">
                                        <img class="blur-up lazyload" data-src="{{ asset('') }}front_end/assets/images/products/product-5.jpg" src="{{ asset('') }}front_end/assets/images/products/product-5.jpg" alt="image" title="" />
                                    </div>
                                    <div class="list-inline-item" id="carousel-selector-1" data-bs-slide-to="1" data-bs-target="#quickView">
                                        <img class="blur-up lazyload" data-src="{{ asset('') }}front_end/assets/images/products/product-5-1.jpg" src="{{ asset('') }}front_end/assets/images/products/product-5-1.jpg" alt="image" title="" />
                                    </div>
                                    <div class="list-inline-item" id="carousel-selector-2" data-bs-slide-to="2" data-bs-target="#quickView">
                                        <img class="blur-up lazyload" data-src="{{ asset('') }}front_end/assets/images/products/product-5-2.jpg" src="{{ asset('') }}front_end/assets/images/products/product-5-2.jpg" alt="image" title="" />
                                    </div>
                                    <div class="list-inline-item" id="carousel-selector-3" data-bs-slide-to="3" data-bs-target="#quickView">
                                        <img class="blur-up lazyload" data-src="{{ asset('') }}front_end/assets/images/products/product-5-3.jpg" src="{{ asset('') }}front_end/assets/images/products/product-5-3.jpg" alt="image" title="" />
                                    </div>
                                    <div class="list-inline-item" id="carousel-selector-4" data-bs-slide-to="4" data-bs-target="#quickView">
                                        <img class="blur-up lazyload" data-src="{{ asset('') }}front_end/assets/images/products/product-5-4.jpg" src="{{ asset('') }}front_end/assets/images/products/product-5-4.jpg" alt="image" title="" />
                                    </div>
                                </div>
                                <!-- End Thumbnail slide -->
                                <!-- Carousel arrow button -->
                                <a class="carousel-control-prev carousel-arrow" href="#quickView" data-bs-target="#quickView" data-bs-slide="prev"><i class="icon an-3x an an-angle-left"></i><span class="visually-hidden">Previous</span></a>
                                <a class="carousel-control-next carousel-arrow" href="#quickView" data-bs-target="#quickView" data-bs-slide="next"><i class="icon an-3x an an-angle-right"></i><span class="visually-hidden">Next</span></a>
                                <!-- End Carousel arrow button -->
                            </div>
                            <!-- End Thumbnail image -->
                        </div>
                        <!--End Model thumbnail -->
                        <div class="text-center mt-3"><a href="#">VIEW MORE DETAILS</a></div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                        <h2 class="product-title">Product Quick View Popup</h2>
                        <div class="product-review d-flex-center mb-2">
                            <div class="rating"><i class="icon an an-star"></i><i class="icon an an-star"></i><i class="icon an an-star"></i><i class="icon an an-star"></i><i class="icon an an-star-o"></i></div>
                            <div class="reviews ms-2"><a href="#">5 Reviews</a></div>
                        </div>
                        <div class="product-info">
                            <p class="product-vendor">Vendor:  <span class="fw-normal"><a href="#" class="fw-normal">Handwi</a></span></p>  
                            <p class="product-type">Product Type: <span class="fw-normal">Tops</span></p> 
                            <p class="product-sku">SKU:  <span class="fw-normal">50-ABC</span></p>
                        </div>
                        <div class="pro-stockLbl my-2">
                            <span class="d-flex-center stockLbl instock"><i class="icon an an-check-cil"></i><span> In stock</span></span>
                            <span class="d-flex-center stockLbl preorder d-none"><i class="icon an an-clock-r"></i><span> Pre-order Now</span></span>
                            <span class="d-flex-center stockLbl outstock d-none"><i class="icon an an-times-cil"></i> <span>Sold out</span></span>
                            <span class="d-flex-center stockLbl lowstock d-none" data-qty="15"><i class="icon an an-exclamation-cir"></i><span> Order now, Only  <span class="items">10</span>  left!</span></span>
                        </div>
                        <div class="pricebox">
                            <span class="price old-price">AED 400.00</span><span class="price product-price__sale">AED 300.00</span>
                        </div>
                        <div class="sort-description">Handwi Multipurpose Bootstrap 5 Html Template that will give you and your customers a smooth shopping experience which can be used for various kinds of stores such as fashion.. </div>
                        <form method="post" action="#" id="product_form--option" class="product-form">
                            <div class="product-options d-flex-wrap">
                                <div class="swatch clearfix swatch-0 option1">
                                    <div class="product-form__item">
                                        <label class="label d-flex">Color:<span class="required d-none">*</span> <span class="slVariant ms-1 fw-bold">Black</span></label>
                                        <ul class="swatches-image swatches d-flex-wrap list-unstyled clearfix">
                                            <li data-value="Black" class="swatch-element color available active">
                                                <label class="rounded swatchLbl small color black" title="Black"></label>
                                                <span class="tooltip-label top">Black</span>
                                            </li>
                                            <li data-value="Green" class="swatch-element color available">
                                                <label class="rounded swatchLbl small color green" title="Green"></label>
                                                <span class="tooltip-label top">Green</span>
                                            </li>
                                            <li data-value="Orange" class="swatch-element color available">
                                                <label class="rounded swatchLbl small color orange" title="Orange"></label>
                                                <span class="tooltip-label top">Orange</span>
                                            </li>
                                            <li data-value="Blue" class="swatch-element color available">
                                                <label class="rounded swatchLbl small color blue" title="Blue"></label>
                                                <span class="tooltip-label top">Blue</span>
                                            </li>
                                            <li data-value="Red" class="swatch-element color available">
                                                <label class="rounded swatchLbl small color red" title="Red"></label>
                                                <span class="tooltip-label top">Red</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="swatch clearfix swatch-1 option2">
                                    <div class="product-form__item">
                                        <label class="label">Size:<span class="required d-none">*</span> <span class="slVariant ms-1 fw-bold">XS</span></label>
                                        <ul class="swatches-size d-flex-center list-unstyled clearfix swatch-1 option2">
                                            <li data-value="XS" class="swatch-element xs available active">
                                                <label class="swatchLbl rounded medium" title="XS">XS</label>
                                                <span class="tooltip-label">XS</span>
                                            </li>
                                            <li data-value="S" class="swatch-element s available">
                                                <label class="swatchLbl rounded medium" title="S">S</label>
                                                <span class="tooltip-label">S</span>
                                            </li>
                                            <li data-value="M" class="swatch-element m available">
                                                <label class="swatchLbl rounded medium" title="M">M</label>
                                                <span class="tooltip-label">M</span>
                                            </li>
                                            <li data-value="L" class="swatch-element l available">
                                                <label class="swatchLbl rounded medium" title="L">L</label>
                                                <span class="tooltip-label">L</span>
                                            </li>
                                            <li data-value="XL" class="swatch-element xl available">
                                                <label class="swatchLbl rounded medium" title="XL">XL</label>
                                                <span class="tooltip-label">XL</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-action d-flex-wrap w-100 mb-3 clearfix">
                                    <div class="quantity">
                                        <div class="qtyField rounded">
                                            <a class="qtyBtn minus" href="javascript:void(0);"><i class="icon an an-minus-r" aria-hidden="true"></i></a>
                                            <input type="text" name="quantity" value="1" class="product-form__input qty">
                                            <a class="qtyBtn plus" href="javascript:void(0);"><i class="icon an an-plus-l" aria-hidden="true"></i></a>
                                        </div>
                                    </div>                                
                                    <div class="add-to-cart ms-3 fl-1">
                                        <button type="button" class="btn button-cart rounded"><span>Add to cart</span></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="wishlist-btn d-flex-center">
                            <a class="add-wishlist d-flex-center text-uppercase me-3" href="#" title="Add to Wishlist"><i class="icon an an-heart-l me-1"></i> <span>Add to Wishlist</span></a>
                            <a class="add-compare d-flex-center text-uppercase" href="#" title="Add to Compare"><i class="icon an an-random-r me-2"></i> <span>Add to Compare</span></a>
                        </div>
                        <!-- Social Sharing -->
                        <div class="social-sharing share-icon d-flex-center mx-0 mt-3">
                            <span class="sharing-lbl me-2">Share :</span>
                            <a href="#" class="d-flex-center btn btn-link btn--share share-facebook" data-bs-toggle="tooltip" data-bs-placement="top" title="Share on Facebook"><i class="icon an an-facebook mx-1"></i><span class="share-title d-none">Facebook</span></a>
                            <a href="#" class="d-flex-center btn btn-link btn--share share-twitter" data-bs-toggle="tooltip" data-bs-placement="top" title="Tweet on Twitter"><i class="icon an an-twitter mx-1"></i><span class="share-title d-none">Tweet</span></a>
                            <a href="#" class="d-flex-center btn btn-link btn--share share-pinterest" data-bs-toggle="tooltip" data-bs-placement="top" title="Pin on Pinterest"><i class="icon an an-pinterest-p mx-1"></i> <span class="share-title d-none">Pin it</span></a>
                            <a href="#" class="d-flex-center btn btn-link btn--share share-linkedin" data-bs-toggle="tooltip" data-bs-placement="top" title="Share on Instagram"><i class="icon an an-instagram mx-1"></i><span class="share-title d-none">Instagram</span></a>
                            <a href="#" class="d-flex-center btn btn-link btn--share share-whatsapp" data-bs-toggle="tooltip" data-bs-placement="top" title="Share on WhatsApp"><i class="icon an an-whatsapp mx-1"></i><span class="share-title d-none">WhatsApp</span></a>
                            <a href="#" class="d-flex-center btn btn-link btn--share share-email" data-bs-toggle="tooltip" data-bs-placement="top" title="Share by Email"><i class="icon an an-envelope-l mx-1"></i><span class="share-title d-none">Email</span></a>
                        </div>
                        <!-- End Social Sharing -->
                    </div>
                </div>
            </div>
            <!--End Quickview Popup-->

            <!--Addtocart Added Popup-->
            <div id="pro-addtocart-popup" class="mfp-with-anim mfp-hide">
                <button title="Close (Esc)" type="button" class="mfp-close">×</button>
                <div class="addtocart-inner text-center clearfix">
                    <h4 class="title mb-3 text-success">Added to your shopping cart successfully.</h4>
                    <div class="pro-img mb-3">
                        <img class="img-fluid blur-up lazyload" src="{{ asset('') }}front_end/assets/images/products/add-to-cart-popup.jpg" data-src="{{ asset('') }}front_end/assets/images/products/add-to-cart-popup.jpg" alt="Added to your shopping cart successfully." title="Added to your shopping cart successfully." width="600" height="508" />
                    </div>
                    <div class="pro-details">   
                        <h5 class="pro-name mb-0">Ditsy Floral Dress</h5>
                        <p class="sku my-2">Color: Gray</p>
                        <p class="mb-0 qty-total">1 X AED 113.88</p>
                        <div class="addcart-total bg-light mt-3 mb-3 p-2">
                            Total: <b class="price">AED 113.88</b>
                        </div>
                        <div class="button-action">
                            <a href="{{route('cart')}}" class="btn btn-primary view-cart mx-1 rounded">Go To Checkout</a>
                            <a href="{{route('home')}}" class="btn btn-secondary rounded">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Addtocart Added Popup-->

            <!--Product Promotion Popup-->
            <!-- <div class="product-notification" id="dismiss">
                <span class="close" aria-hidden="true"><i class="an an-times-r"></i></span>
                <div class="media d-flex">
                    <a href="#"><img class="mr-2 blur-up lazyload" src="assets/images/products/product-3.jpg" data-src="assets/images/products/product-3.jpg" alt="Trim Button Front Blouse" /></a>
                    <div class="media-body">
                        <h5 class="mt-0 mb-1">Someone purchsed a</h5>
                        <p class="pname"><a href="#">Trim Button Front Blouse</a></p>
                        <p class="detail">14 Minutes ago from New York, USA</p>
                    </div>
                </div>
            </div> -->
            <!--End Product Promotion Popup-->

            <!--Newsletter Popup-->
            <!-- <div id="newsletter-modal" class="style1 mfp-with-anim mfp-hide">
                <div class="d-flex flex-column">
                    <div class="newsltr-img d-none d-sm-none d-md-block"><img class="blur-up lazyload" src="assets/images/newsletter-img.webp" data-src="assets/images/newsletter-img.webp" alt="image" width="550" height="290"></div>
                    <div class="newsltr-text text-center">
                        <div class="wraptext">
                            <p><b>GET THE UPDATES ABOUT LATEST TREANDS</b></p>
                            <h2 class="title fw-normal mb-4">20% OFF YOUR FIRST ORDER</h2>
                            <form action="#" method="post" class="mcNewsletter mb-4">
                                <div class="input-group d-flex flex-nowrap">
                                    <input type="email" class="rounded-start newsletter__input" name="EMAIL" value="" placeholder="Email address" required>
                                    <span><button type="submit" class="btn mcNsBtn rounded-end" name="commit"><span>Subscribe</span></button></span>
                                </div>
                            </form>
                            <div class="customCheckbox justify-content-center checkboxlink clearfix mb-3">
                                <input id="dontshow" name="newsPopup" type="checkbox" />
                                <label for="dontshow" class="pt-1">Don't show this popup again</label>
                            </div>
                            <p>Your information will never be shared</p>
                        </div>
                    </div>
                </div>
                <button title="Close (Esc)" type="button" class="mfp-close">×</button>
            </div> -->
            <!--End Newsletter Popup-->


            <!-- Including Jquery -->
            <script src="{{ asset('') }}front_end/assets/js/vendor/jquery-min.js"></script>
            <script src="{{ asset('') }}front_end/assets/js/vendor/js.cookie.js"></script>
            <!--Including Javascript-->
            <script src="{{ asset('') }}front_end/assets/js/plugins.js"></script>
            
            <script src="{{ asset('') }}front_end/assets/js/main.js"></script>

<script>
$(document).ready(function(){
    $("#search-blog").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".recent-posts .recent-content").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
$(document).on('click', '.btn-addto-cart', function (e) {
    e.preventDefault();
    
    const product_id = $(this).data('product-id');
    const quantity = 1; // Default quantity (can be dynamic based on user input)
    const variation_id = $(this).data('variation_id');
    
    
    $.ajax({
        url: "{{ route('addtocart') }}", // Adjust the route name if necessary
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token from meta tag
        },
        data: {
            product_id: product_id,
            quantity: quantity,
            variation_id:variation_id
        },
        success: function (response) {
            if (response.status == 1) {
                
                // Update popup content dynamically
                $('#pro-addtocart-popup .pro-name').text(response.data.name);
                $('#pro-addtocart-popup .pro-img img').attr('src', response.data.image);
                $('#pro-addtocart-popup .pro-img img').attr('data-src', response.data.image);
                $('#pro-addtocart-popup .qty-total').text(`${response.data.quantity} X AED ${response.data.price}`);
                $('#pro-addtocart-popup .price').text(`AED ${response.data.total}`);
                fetchCartData();
                // if (!$.magnificPopup.instance) {
                //     $('#pro-addtocart-popup').magnificPopup({
                //         type: 'inline',
                //         midClick: true,
                //         mainClass: 'mfp-zoom-in',
                //         removalDelay: 400
                //     }).magnificPopup('open'); 
                // } else {
                //     $.magnificPopup.open({
                //         items: { src: '#pro-addtocart-popup' },
                //         type: 'inline',
                //         mainClass: 'mfp-zoom-in',
                //         removalDelay: 400
                //     });
                // }
            } else {
                
                Swal.fire({
                    toast: true,
                    position: 'top-end', 
                    icon: 'success', 
                    title: response.message, 
                    showConfirmButton: false, 
                    timer: 3000, 
                    timerProgressBar: true, 
                });
            }
        },
        error: function (xhr) {
            alert("Something went wrong. Please try again.");
        }
    });
});

function updateMiniCart(cart,grand_total,totalTax,shipping_charge) {
 
    var cartContent = '';
    var total = 0;
    var itemCount = 0;

    if (cart.length === 0) {
        cartContent = `
            <div class="alert alert-warning text-center" role="alert">
                <i class="align-middle icon an an-cart icon-large me-2"></i>
                <strong>No items in the cart.</strong>
            </div>
        `;
        $('#cart-items-list').html(cartContent);
        $('#cartminibottomdetails').hide();
    }else{
        $('#cartminibottomdetails').show();
        $.each(cart, function (index, item) {
            var itemTotal = item.quantity * item.price;
            total += itemTotal;
            itemCount++;

            cartContent += `
                <li class="item d-flex justify-content-center align-items-center">
                    <a class="product-image" href="#">
                        <img class="blur-up lazyload" src="${item.image}" data-src="${item.image}" alt="image" title="">
                    </a>
                    <div class="product-details">
                        <a class="product-title" href="#">${item.name} </a>
                       
                        <div class="variant-cart">${item.color_text} ${item.size_text}</div>
                        <div class="priceRow">
                            <div class="product-price">
                                <span class="money">AED ${item.price}</span>
                            </div>
                        </div>
                    </div>
                    <div class="qtyDetail text-center">
                        <div class="wrapQtyBtn">
                            <div class="qtyField">
                                <a class="qtyBtn minus" href="javascript:void(0);" data-id="${item.id}"><i class="icon an an-minus-r" aria-hidden="true"></i></a>
                                <input type="text" name="quantity" value="${item.quantity}" class="qty" readonly>
                                <a class="qtyBtn plus" href="javascript:void(0);" data-id="${item.id}"><i class="icon an an-plus-l" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <a href="javascript:void(0);" class="remove cart__remove" data-id="${item.id}"><i class="an an-times-r" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove"></i></a>
                    </div>
                </li>
            `;
        });

        // Update the cart content and total
        $('#cart-items-list').html(cartContent);
        $('#cart-total').text('AED ' + grand_total.toFixed(2));
        $('#cart-total-tax').text('AED ' + totalTax.toFixed(2));
        $('#cart-total-shipping').text('AED ' + shipping_charge);
        
        $('#cart_counter').text(itemCount);
        $('#cartcountheader').text(itemCount);
        
        $('#cart-item-count').text(itemCount); // Update the item count

    }
   
}

function fetchCartData() {
    $.ajax({
        url: "{{ route('getcart') }}",  // Adjust the route name if necessary
        method: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF token from meta tag
        },
        success: function(response) {
            updateMiniCart(response.cart,response.grand_total,response.totalTax,response.shipping_charge);  // Update the mini cart with the latest data
        },
        error: function(xhr) {
            console.log("Error fetching cart data.");
        }
    });
}

$(document).ready(function () {
    fetchCartData();
});

$(document).on('click', '.qtyBtn', function () {
    var action = $(this).hasClass('plus') ? 'add' : 'subtract';
    var cartId = $(this).data('id');

    $.ajax({
        url: '{{ route('cartupdatequantity') }}',
        method: 'POST',
        data: {
            cart_id: cartId,
            action: action,
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (response) {
            if (response.status) {
                updateMiniCart(response.cart,response.grand_total,response.totalTax,response.shipping);
                updateCartUI(response.cart, response.subtotal, response.item_count,response.grand_total,response.totalTax,response.shipping); // Refresh the page to update the cart
            } else {

                Swal.fire({
                    toast: true,
                    position: 'top-end', 
                    icon: 'success', 
                    title: response.message, 
                    showConfirmButton: false, 
                    timer: 3000, 
                    timerProgressBar: true, 
                });
            }
        },
    });
});

$(document).on('click', '.cart__remove', function (e) {
    e.preventDefault();
    
    var cartId = $(this).data('id'); // Get the cart item ID

    $.ajax({
        url: '{{ route('removecartitem') }}', // Update with the route to handle item removal
        method: 'POST',
        data: {
            cart_id: cartId,
            _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token
        },
        success: function (response) {
            if (response.status) {
                // Update the cart UI after item removal
                if (response.cart.length === 0) {
                    location.reload(); // Reload the page to show "No items in the cart"
                } else {
                    // Update the cart UI after item removal
                    updateMiniCart(response.cart,response.grand_total,response.totalTax,response.shipping);
                    updateCartUI(response.cart, response.subtotal, response.item_count,response.grand_total,response.totalTax,response.shipping); // Refresh the page to update the cart
                }
            } else {
                
                Swal.fire({
                    toast: true,
                    position: 'top-end', 
                    icon: 'success', 
                    title: response.message, 
                    showConfirmButton: false, 
                    timer: 3000, 
                    timerProgressBar: true, 
                });
            }
        },
    });
});

function updateCartUI(cartItems, total, itemCount,grand_total,totalTax,shipping_charge) {
    // Update the cart content dynamically
    var cartContent = '';
    $.each(cartItems, function (index, item) {
        var itemTotal = item.quantity * item.price;

        let detailsToggle = '';
        let detailsContent = '';

        if (item.customer_notes || item.customer_file) {
            let fileHtml = '';
            if (item.customer_file) {
                let ext = item.customer_file.split('.').pop().toLowerCase();
                let isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext);
                if (isImage) {
                    fileHtml = `<div class="mt-1">
                                    <img src="${item.customer_file}" alt="Uploaded file" style="max-height: 100px; border: 1px solid #ddd;">
                                </div>`;
                } else {
                    fileHtml = `<a href="${item.customer_file}" target="_blank" class="text-primary text-decoration-underline">
                                    View Uploaded File
                                </a>`;
                }
            }

            detailsToggle = `<a href="javascript:void(0);" class="text-primary d-block mt-1" data-bs-toggle="collapse" data-bs-target="#item-detail-${item.id}">
                                View Details
                            </a>`;

            detailsContent = `<div class="collapse mt-2" id="item-detail-${item.id}">
                                ${item.customer_notes ? `<div class="text-muted small mb-1"><strong>Note:</strong> ${item.customer_notes}</div>` : ''}
                                ${fileHtml ? `<div class="small"><strong>File:</strong> ${fileHtml}</div>` : ''}
                            </div>`;
        }
        

       console.log(detailsContent);
        cartContent += `
            <tr class="cart__row border-bottom line1 cart-flex border-top">
                <td class="cart-delete text-center small--hide">
                    <a href="javascript:void(0);" class="btn btn--secondary cart__remove remove-icon position-static" title="Remove item" data-id="${item.id}">
                        <i class="icon an an-times-r"></i>
                    </a>
                </td>
                <td class="cart__image-wrapper cart-flex-item">
                    <a href="#"><img class="cart__image blur-up lazyload" src="${item.image}" alt="${item.name}" width="80" /></a>
                </td>
                <td class="cart__meta small--text-left cart-flex-item">
                    <div class="list-view-item__title">
                        <a href="#">${item.name}</a>
                    </div>
                    <div class="variant-cart">${item.color_text} ${item.size_text}</div>
                    <div class="cart__meta-text">
                        ${detailsToggle}
                        ${detailsContent}
                    </div>
                </td>
                
                <td class="cart__price-wrapper cart-flex-item text-center small--hide">
                    <span class="money">AED ${item.price}</span>
                </td>
                <td class="cart__update-wrapper cart-flex-item text-end text-md-center">
                    <div class="cart__qty d-flex justify-content-end justify-content-md-center">
                        <div class="qtyField">
                            <a class="qtyBtn minus" href="javascript:void(0);" data-id="${item.id}"><i class="icon an an-minus-r"></i></a>
                            <input class="cart__qty-input qty" type="text" name="updates[]" value="${item.quantity}" readonly />
                            <a class="qtyBtn plus" href="javascript:void(0);" data-id="${item.id}"><i class="icon an an-plus-r"></i></a>
                        </div>
                    </div>
                </td>
                <td class="cart-price cart-flex-item text-center small--hide">
                    <span class="money fw-500">AED ${itemTotal}</span>
                </td>
            </tr>
        `;
    });

    $('#cart-items-list-cartpage').html(cartContent);
    $('#cart-totalcartpage').text('AED ' + total.toFixed());
    $('#cart-grandcartpage').text('AED ' + grand_total.toFixed());
    $('#cart-taxcartpage').text('AED ' + totalTax.toFixed(2));
    $('#cart-shippingcartpage').text('AED ' + shipping_charge);
    $('#cart_counter').text(itemCount);
    $('#cartcountheader').text(itemCount);
    $('#cart-item-count').text(itemCount); // Update the item count
}

$('#clear-cart').on('click', function () {
    $.ajax({
        url: '{{ route('cartclear') }}',
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (response) {
            if (response.status) {
                $('#cart-items-list-cartpage').html('');
                $('#cart-totalcartpage').text('AED 0.00');
                $('#cart_counter').text(0);
                $('#cartcountheader').text(0);
                $('#cart-item-count').text(0);
                location.reload();
            } else {
                alert(response.message);
            }
        },
    });
});

$(document).ready(function () {
    $('#register-btn').click(function (e) {
        e.preventDefault();

        let formData = {
            first_name: $('#first_name').val(),
            last_name: $('#last_name').val(),
            phone: $('#phone').val(),
            email: $('#email').val(),
            password: $('#password').val(),
            password_confirmation: $('#password_confirmation').val(),
            terms: $('#agree').is(':checked') ? 1 : '',
            _token: $('input[name="_token"]').val(),
        };

        $.ajax({
            url: "{{ route('register') }}",
            method: 'POST',
            data: formData,
            beforeSend: function () {
                $('span.error-text').text('');
            },
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end', 
                        icon: 'success',
                        title: 'Registration Successful!',
                        showConfirmButton: true,
                        confirmButtonText: 'Go to Login',
                        confirmButtonColor: '#000000', 
                        timer: 3000, 
                        timerProgressBar: true, 
                    }).then((result) => {
                        
                        if (result.isConfirmed) {
                            window.location.href = "{{route('login')}}"; 
                        }
                    });

                    
                    setTimeout(() => {
                        window.location.href = "{{route('login')}}"; 
                    }, 3000);
                }
            },
            error: function (response) {
                $.each(response.responseJSON.errors, function (key, value) {
                    $('span.' + key + '_error').text(value[0]);
                });
            }
        });
    });
});

$(document).on('click', '#login-btn', function (e) {
    e.preventDefault();

    // Get form data
    const email = $('#email').val();
    const password = $('#password').val();

    $.ajax({
        url: "{{ route('login') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            email: email,
            password: password,
        },
        success: function (response) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: response.message,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            setTimeout(() => {
                window.location.href = response.redirect_url;
            }, 3000);
        },
        error: function (xhr) {
            let message = xhr.responseJSON.message || 'An error occurred.';
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: message,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        },
    });
});

$(document).ready(function() {
    // Handle form submission
    $('#change-password-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Clear previous error messages
        $('#current-password-error, #new-password-error, #new-password-confirmation-error').addClass('d-none').text('');

        // Get form data
        var formData = $(this).serialize();

        // Make an AJAX request
        $.ajax({
            url: $(this).attr('action'), // The URL where the form is submitted
            method: 'POST', // The HTTP method
            data: formData, // The form data
            success: function(response) {
                if (response.status === 'success') {
                    // Display a success toast
                    Swal.fire({
                        icon: 'success',
                        title: 'Password Changed Successfully!',
                        text: response.message,
                        timer: 3000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });

                    // Optionally, redirect to the dashboard
                    setTimeout(function() {
                        window.location.href = response.redirect_url;
                    }, 3000);
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;

                // Display error messages
                if (errors.current_password) {
                    $('#current-password-error').removeClass('d-none').text(errors.current_password[0]);
                }
                if (errors.new_password) {
                    $('#new-password-error').removeClass('d-none').text(errors.new_password[0]);
                }
                if (errors.new_password_confirmation) {
                    $('#new-password-confirmation-error').removeClass('d-none').text(errors.new_password_confirmation[0]);
                }
            }
        });
    });
});


$(document).ready(function () {
    $('#update-profile-form').on('submit', function (e) {
        e.preventDefault();

        var form = $(this)[0]; // Get the actual DOM element
        var formData = new FormData(form); // Create FormData from form

        $.ajax({
            url: "{{ route('update-profile') }}",
            type: 'POST',
            data: formData,
            processData: false, // Important!
            contentType: false, // Important!
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Profile Updated!',
                        text: response.message,
                        timer: 3000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });

                    setTimeout(function () {
                        window.location.href = response.redirect_url;
                    }, 3000);
                }
            },
            error: function (response) {
                var errors = response.responseJSON.errors;

                $('.form-group').removeClass('has-error');
                $('.error-message').remove();

                $.each(errors, function (key, value) {
                    var field = $('[name="' + key + '"]');
                    field.closest('.form-group').addClass('has-error');
                    field.after('<div class="error-message text-danger">' + value[0] + '</div>');
                });
            }
        });
    });
});


$(document).ready(function () {
    // Swal Toast Configuration
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });

    // Handle Add/Edit Form Submission
    $('#address-form').on('submit', function (e) {
        e.preventDefault();

        let addressId = $('#address_id').val();
        let url = addressId 
            ? `{{ url('/userdashboard/addresses') }}/${addressId}` 
            : `{{ url('/userdashboard/addresses') }}`;
        let method = addressId ? 'POST' : 'POST';

        // Clear previous errors
        $('.text-danger').text('');

        $.ajax({
            url: url,
            type: method,
            data: $(this).serialize(),
            success: function (response) {
                if (response.status === 'success') {
                    Toast.fire({
                        icon: 'success',
                        title: response.message,
                    });
                    setTimeout(() => location.reload(), 2000);
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    // Display validation errors
                    let errors = xhr.responseJSON.errors;
                    for (const field in errors) {
                        $(`#error-${field}`).text(errors[field][0]);
                    }
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong!',
                    });
                }
            }
        });
    });

    // Populate Form for Edit
    $('.edit-address').on('click', function (e) {
        e.preventDefault();
        let addressId = $(this).data('id');
        let editUrl = `{{ url('/userdashboard/addresses') }}/${addressId}/edit`;

        $.ajax({
            url: editUrl,
            type: 'GET',
            success: function (response) {
                if (response.status === 'success') {
                    let address = response.address;
                    $('#address_id').val(address.id);
                    $('#full_name').val(address.full_name);
                    $('#dial_code').val(address.dial_code);
                    $('#phone').val(address.phone);
                    $('#address').val(address.address);
                    $('#country_id').val(address.country_id);
                    $('#state_id').val(address.state_id);
                    $('#city_id').val(address.city_id);
                    $('#address_type').val(address.address_type);

                    $('#shipping').collapse('show');
                }
            }
        });
    });
    $('.make-default').on('click', function (e) {
        e.preventDefault();

        let addressId = $(this).data('id');
        let makeDefaultUrl = `{{ url('/userdashboard/addresses') }}/${addressId}/make-default`;
        
        $.ajax({
            url: makeDefaultUrl,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.status === 'success') {
                    // Update the UI
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        
                    });

                    // Change the UI to reflect the new primary address
                    location.reload();
                }
            },
            error: function (xhr) {
              
                Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Something went wrong!',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            }
        });
    });
});




$(document).ready(function () {
    $('#load-more').on('click', function (e) {
        e.preventDefault();

        let $button = $(this);
        let offset = $button.data('offset'); // Current offset
        let newOffset = offset + 6; // Update offset for the next load
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Make AJAX request
        $.ajax({
            url: '?offset=' + offset, // Pass offset as a query parameter
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (response) {
                // Append new products to the grid
                // var productsHTML = $(response.products);
                // console.log("Response products: ", response.products);

                // // Ensure #product-grid exists in the DOM
                // console.log($('#productgrid').length);
                // if (response.products) {
                //     alert("here");
                //     $('#productgrid').append(response.products);
                // }
                
                // //$('#product-grid').append(response.products);

                // // Update the offset
                // $button.data('offset', newOffset);

                // // Update the total products count
                // $('#total-products').text(response.totalProducts);

                // // Hide "Load More" button if all products are loaded
                // if (newOffset >= response.totalProducts) {
                //     $button.hide();
                // }

                $('#productgrid').append(response.products); // Append the products

                // Update the loaded products count
               // Count the number of products appended (split by <div> for product count)
                $('#loaded-products-count').text(newOffset); 

                // Update the offset
                $button.data('offset', newOffset);

                // Update the total products count (this should remain constant)
                $('#total-products-count').text(response.totalProducts);

                // Hide "Load More" button if all products are loaded
                if (newOffset >= response.totalProducts) {
                    $button.hide();
                }
            },
            error: function (xhr, status, error) {
                console.error('Error loading more products:', error);
            }
        });
    });
});



$(document).ready(function () {
    // Load More Services
    $('#load-more-services').on('click', function (e) {
        e.preventDefault();

        let $button = $(this);
        let offset = $button.data('offset');
        let newOffset = offset + 6;  // Increase offset by 6
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '?offset=' + offset, // Use the updated offset for services
            type: 'GET',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function (response) {
                $('#servicegrid').append(response.services); // Append the new services to the grid
                $('#total-services-count').text(response.totalServices); // Update the total service count

                $button.data('offset', newOffset); // Update the offset for the next load

                if (newOffset >= response.totalServices) {
                    $button.hide(); // Hide the button if all services are loaded
                }

                // Update loaded services count
                $('#loaded-services-count').text(newOffset);
            },
            error: function (xhr, status, error) {
                console.error('Error loading more services:', error);
            }
        });
    });
});

$(document).on('click', '.product-form__cart-submit', function (e) {
    e.preventDefault();

    // const product_id = $(this).data('product-id'); // Get product ID from data attribute
    // const quantity = parseInt($('.product-form__input.qty').val()) || 1; // Fetch quantity input value or default to 1
    //  const variation_id = $(this).data('variation_id');
    const product_id = $(this).data('product-id');
    const variation_id = $(this).data('variation_id');
    const quantity = parseInt($('.product-form__input.qty').val()) || 1;
    const fileInput = document.getElementById('customer_file'); // Ensure your form has this file input
    const note = $('#customer_notes').val(); // Add a textarea or input for notes

    let formData = new FormData();
    formData.append('product_id', product_id);
    formData.append('quantity', quantity);
    formData.append('variation_id', variation_id);
    formData.append('customer_notes', note);

    if (fileInput && fileInput.files[0]) {
        formData.append('customer_file', fileInput.files[0]);
    }

    $.ajax({
        url: "{{ route('addtocart') }}", // Adjust the route name if necessary
        method: "POST",
        contentType: false,  
        processData: false,  
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token from meta tag
        },
        // data: {
        //     product_id: product_id,
        //     quantity: quantity,
        //     variation_id:variation_id
        // },
        data: formData,
        success: function (response) {
            if (response.status == 1) {
                // Update popup content dynamically
                $('#pro-addtocart-popup .pro-name').text(response.data.name);
                $('#pro-addtocart-popup .pro-img img').attr('src', response.data.image);
                $('#pro-addtocart-popup .pro-img img').attr('data-src', response.data.image);
                $('#pro-addtocart-popup .qty-total').text(`${response.data.quantity} X AED ${response.data.price}`);
                $('#pro-addtocart-popup .price').text(`AED ${response.data.total}`);
                fetchCartData(); // Update cart data dynamically

              //  if (!$.magnificPopup.instance) {
                 //   $('#pro-addtocart-popup').magnificPopup({
                 //       type: 'inline',
                 //       midClick: true,
                 //       mainClass: 'mfp-zoom-in',
                 //       removalDelay: 400
                 //   }).magnificPopup('open'); // Open the popup directly
               // } else {
                //    $.magnificPopup.open({
                //        items: { src: '#pro-addtocart-popup' },
                 //       type: 'inline',
                 //       mainClass: 'mfp-zoom-in',
                 //       removalDelay: 400
                 //   });
                //}
            } else {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            }
        },
        error: function (xhr) {
            alert("Something went wrong. Please try again.");
        }
    });
});

// $('#customer_file').on('change', function () {
//     const file = this.files[0];
//     const errorEl = $('#file_error');
//     const previewContainer = $('#file_preview');
//     const previewImg = $('#file_preview_img');

//     // Reset error and preview
//     errorEl.addClass('d-none').text('');
//     previewContainer.addClass('d-none');
//     previewImg.attr('src', '#');

//     if (file) {
//         const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
//         const maxSize = 2 * 1024 * 1024; // 2 MB

//         if (!validTypes.includes(file.type)) {
//             errorEl.removeClass('d-none').text('Only image files (JPG, PNG, GIF, WEBP) are allowed.');
//             this.value = ''; // Clear the invalid file
//             return;
//         }

//         if (file.size > maxSize) {
//             errorEl.removeClass('d-none').text('File size must be less than 2MB.');
//             this.value = ''; // Clear the large file
//             return;
//         }

//         // Preview the image
//         const reader = new FileReader();
//         reader.onload = function (e) {
//             previewImg.attr('src', e.target.result);
//             previewContainer.removeClass('d-none');
//         };
//         reader.readAsDataURL(file);
//     }
// });



$(document).on('click', '.proceed-to-checkout-buy-now', function (e) {
    e.preventDefault();

    const product_id = $(this).data('product-id'); // Get product ID from data attribute
    const quantity = parseInt($('.product-form__input.qty').val()) || 1; // Fetch quantity input value or default to 1
     const variation_id = $(this).data('variation_id');

    $.ajax({
        url: "{{ route('addtocart') }}", // Adjust the route name if necessary
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token from meta tag
        },
        data: {
            product_id: product_id,
            quantity: quantity,
            variation_id:variation_id
        },
        success: function (response) {
            if (response.status == 1) {
                window.location.href = "{{ route('cart') }}";
              
            } else {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            }
        },
        error: function (xhr) {
            alert("Something went wrong. Please try again.");
        }
    });
});

$(document).ready(function() {
        // Listen for changes on the radio buttons with class 'address-radio'
        $('input[name="address_id"]').change(function() {
            // When a radio button is selected, set the value of the hidden input
            var selectedAddressId = $(this).val();  // Get the value (address_id) of the selected radio button
            $('#address_id').val(selectedAddressId); // Set the value to the hidden input
        });

        // If a radio button is already selected (like after a form submission), set the hidden input value
        var selectedRadio = $('input[name="address_id"]:checked');
        if (selectedRadio.length > 0) {
            $('#address_id').val(selectedRadio.val());
        }
    });




    $(document).ready(function () {
    let selectedSeats = [];
    const workshopId = $('.seat-selection').data('workshop-id');

    // Handle seat selection
    $('.seat-checkbox').on('change', function () {
        const seat = $(this).val();
        if ($(this).is(':checked')) {
            selectedSeats.push(seat);
        } else {
            selectedSeats = selectedSeats.filter(s => s !== seat);
        }
        const seatPrice = $('#service_subtotal').val(); 
        const taxPercentage = $('#service_tax').val();
        const seatCount = selectedSeats.length; 

        const subTotal = seatPrice * seatCount; 
        
        const taxAmount = (subTotal * taxPercentage) / 100; 
        const grandTotal = subTotal + taxAmount; 

        $('#subtotalDisplay').text(`AED ${subTotal.toFixed(2)} (${seatPrice} * ${seatCount})`);
        $('#taxDisplay').text(`AED ${taxAmount.toFixed(2)}`);
        $('#quantityDisplayservice').text(`${seatCount}`);
        $('#grandTotalDisplay').text(`AED ${grandTotal.toFixed(2)}`);
    });

    // Handle Pay Now button click
    $('#payNowButtonworkshop').on('click', function (e) {
        e.preventDefault();

        if (selectedSeats.length === 0) {
            
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Please select at least one seat before proceeding.',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            return;
        }
        const workshopId = $('#workshopId').val();
        $(this).prop('disabled', true);
        Swal.fire({
            title: 'Processing your request...',
            html: '<div class="spinner-border text-primary" role="status" style="border-color: black; border-top-color: black;"><span class="visually-hidden">Loading...</span></div>',
            allowOutsideClick: false,
            showConfirmButton: false,
        });

        // Send AJAX request to initiate payment
        $.ajax({
            url: "{{ route('worshopcheckoutpage') }}",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                workshop_id: workshopId,
                seats: selectedSeats
            },
            success: function (response) {
                if (response.session_id) {
                    // Redirect to Stripe checkout
                    window.location.href = response.url;
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function (xhr) {
                alert('An error occurred. Please try again.');
            }
        });
    });
});

$(document).ready(function () {
    $('#checkoutpayment').click(function (e) {
        // Prevent the form from submitting immediately
        e.preventDefault();
        
        // Check if address_id is empty
        var addressId = $('#address_id').val();
        
        if (!addressId) {
            // If empty, show alert
            
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Please add or select a delivery address.',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        } else {
            // If not empty, submit the form by its id
            $('#checkoutFormpage').submit();
        }
    });
});



$(document).on('click', '#load-more-button-storepage', function () {
    let button = $(this);
    let offset = button.data('offset');
    let limit = button.data('limit');
    let total = button.data('total');

    $.ajax({
        url: "{{ url()->current() }}",
        type: "GET",
        data: {
            offset: offset,
            limit: limit,
        },
        beforeSend: function () {
            button.prop('disabled', true);
        },
        success: function (response) {
            if (response.products) {
                $('#productcontainerstore').append(response.products);
                let loadedProducts = response.loadedProducts;

                button.data('offset', loadedProducts);
                button.text(`Load More (${loadedProducts}/${total})`);

                if (loadedProducts >= total) {
                    button.parent().hide(); // Hide the button if all products are loaded
                }
            }
        },
        complete: function () {
            button.prop('disabled', false);
        },
        error: function () {
            alert('An error occurred while loading more products.');
        }
    });
});

function addToWishlist(element, productId) {
    let userId = '{{ auth()->check() ? auth()->user()->id : null }}';  

    
    let wishlistData = {
        product_id: productId,
        user_id: userId,
        _token: '{{ csrf_token() }}'  
    };

    $.ajax({
        url: "{{ route('addtowishlist') }}",  
        method: 'POST',
        data: wishlistData,
        beforeSend: function () {

            $(element).prop('disabled', true);
        },
        success: function (response) {
            if (response.status === 'success') {
                // Swal.fire({
                //     toast: true,
                //     position: 'top-end',
                //     icon: 'success',
                //     title: 'Product added to Wishlist!',
                //     showConfirmButton: true,
                //     confirmButtonText: 'Ok',
                //     confirmButtonColor: '#000000',
                //     timer: 3000,
                //     timerProgressBar: true
                // }).then((result) => {
                    
                //         location.reload();  
                    
                // });
                location.reload();

                
                $(element).find('.tooltip-label').text('Added to Wishlist');
            }
        },
        error: function (response) {
            
            $(element).prop('disabled', false);
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Error adding product to wishlist',
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
}

function removeFromWishlist(element, wishlistItemId) {
    
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'warning',
        title: 'Are you sure you want to delete this from your wishlist?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, keep it',
        confirmButtonColor: '#000000',
        cancelButtonColor: '#3085d6',
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: '{{ route('removewishlist') }}', 
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', 
                    wishlist_item_id: wishlistItemId
                },
                success: function(response) {
                    
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Product removed from Wishlist!',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });


                    $(element).closest('.item').fadeOut();  
                },
                error: function() {
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Something went wrong. Please try again.',
                        showConfirmButton: true
                    });
                }
            });
        }
    });
}




$(document).ready(function () {
    
    $('#review-form').on('submit', function (e) {
        e.preventDefault();  

        
        var formData = {
            
            'name': $('#nickname').val(),
            'email': $('#email').val(),
            'rating': $('input[name="rating"]:checked').val(),
            'review': $('#review').val(),
            'message': $('#message').val(),  
            'product_id':$('#product_id').val(),
            'product_variant_id': $('#product_variant_id').val(),  
            'type': $('#type').val(),
            'service_id':$('#service_id').val(),
             
        };

        
       

        // Send the AJAX request
        $.ajax({
            url: '{{route('add-reviews')}}',  
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'  
            },
            success: function (response) {
                if (response.status === 1) {
                    
                    Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Review submitted successfully!',
                    showConfirmButton: true,
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#000000',
                    timer: 3000,
                    timerProgressBar: true
                }).then((result) => {
                    
                        location.reload();  
                    
                });
                    $('#review-form')[0].reset();  
                } else {
                    if (response.status === 0) {
                        $('.form-group').removeClass('has-error'); 
                        $('.validation-error').remove();
                       
                        $.each(response.errors, function (field, errors) {
                            
                            var fieldContainer = $('[name="' + field + '"]').closest('.form-group');
                            if (fieldContainer.length > 0) {
                                fieldContainer.addClass('has-error'); 

                                
                                $.each(errors, function (index, errorMessage) {
                                    fieldContainer.append('<div class="validation-error text-danger">' + errorMessage + '</div>');
                                });
                            }
                        });
                    } 
                }
            },
            error: function () {
                alert('There was an error submitting your review. Please try again later.');
            }
        });
    });
});

$(document).ready(function () {
    $('#newsletter-form').on('submit', function (e) {
        e.preventDefault(); 
        var email = $('#newsletteremail').val();


        $.ajax({
            url: '{{route('subscribeemail')}}', 
            type: 'POST',
            data: { email: email },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' 
            },
            success: function (response) {
                if (response.status === 1) { 
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: response.message || 'Subscribed successfully!',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                    $('#newsletter-form')[0].reset(); 
                } else if (response.status === 0) { 
                    let errorMessage = '';

                    if (response.errors) {
                        // Loop through the errors to create a message
                        for (let field in response.errors) {
                            if (response.errors.hasOwnProperty(field)) {
                                errorMessage += response.errors[field].join('<br>'); 
                            }
                        }
                    }
                   
                    Swal.fire({
                        toast: true, 
                        icon: 'error',
                        title: 'Validation Errors',
                        html: errorMessage,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#000000',
                        timer: 3000,
                        timerProgressBar: true
                        
                    });

                }
            },
            error: function (xhr, status, error) { 
                Swal.fire({
                    toast: true, 
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error',
                    text: 'There was an issue with your subscription. Please try again later.',
                    confirmButtonText: false
                });
            }
        });
    });
});

$(document).ready(function () {
    function validateEmail(email) {
        let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        return emailPattern.test(email);
    }
    
    // Helper function to validate phone number format
    function validatePhone(phone) {
        // Assuming a valid phone is only digits (could be modified to allow more formats)
        let phonePattern = /^[0-9]{10}$/; 
        return phonePattern.test(phone);
    }
    $('#followVendor').click(function() {
       
        let vendor_id = $(this).data('vendor-id');
        

        // Make AJAX call to follow/unfollow the vendor
        $.ajax({
            url: '{{ route('followvendor') }}',
            method: 'POST',
            data: {
                vendor_id: vendor_id,
                _token: $('meta[name="csrf-token"]').attr('content')  // CSRF token
            },
            success: function(response) {
                if (response.status == 1) {
                    
                    // Optionally update the button text to show the follow/unfollow status
                    //  Swal.fire({
                    //     toast: true,
                    //     position: 'top-end',
                    //     icon: 'success',
                    //     title: response.message ,
                    //     showConfirmButton: false,
                    //     timer: 3000,
                    //     timerProgressBar: true
                    // });
                    if (response.message === 'liked') {
                        $('#followVendor').text('Unfollow').prepend('<i class="fa-solid fa-minus"></i> '); // Change button text to "Unfollow" when liked
                    } else if (response.message === 'disliked') {
                        $('#followVendor').text('Follow').prepend('<i class="fa-solid fa-plus"></i> '); // Change button text to "Follow" when disliked
                    }
                } else {
                    alert('Something went wrong!');
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    });
    // Send Message AJAX
    $('#submitMessage').click(function() {
        // Get vendor ID from the hidden field
        let vendor_id = $('#vendor_id').val();
    
        // Get form data from the input fields
        let name = $('#name').val();
        let email = $('#email').val();
        let phone = $('#phone').val();
        let subject = $('#subject').val();
        let message = $('#message').val();
        $('.form-group').removeClass('has-error');
        $('.error-message').remove(); // Remove any previous error messages
    
        // Validate if all fields are filled
        if (!name || !email || !phone || !subject || !message) {
            
            if (!name) {
            $('#name').closest('.form-group').addClass('has-error').append('<div class="error-message text-danger">Please enter your name.</div>');
            }
            if (!email) {
                $('#email').closest('.form-group').addClass('has-error').append('<div class="error-message text-danger">Please enter a valid email address.</div>');
            }
            if (!phone) {
                $('#phone').closest('.form-group').addClass('has-error').append('<div class="error-message text-danger">Please enter a valid phone number.</div>');
            }
            if (!subject) {
                $('#subject').closest('.form-group').addClass('has-error').append('<div class="error-message text-danger">Please enter a subject.</div>');
            }
            if (!message) {
                $('#message').closest('.form-group').addClass('has-error').append('<div class="error-message text-danger">Please enter a message.</div>');
            }
            
            return;
        }
        let isValidEmail = validateEmail(email);
        let isValidPhone = validatePhone(phone);
    
        if (!isValidEmail) {
            $('#email').closest('.form-group').addClass('has-error').append('<div class="error-message text-danger">Please enter a valid email address.</div>');
            return;
        } else {
            // If email is valid, remove the error message if any
            $('#email').closest('.form-group').removeClass('has-error');
            $('#email').closest('.form-group').find('.error-message').remove();
        }
    
        if (!isValidPhone) {
            $('#phone').closest('.form-group').addClass('has-error').append('<div class="error-message text-danger">Please enter a valid phone number.</div>');
            return;
        } else {
            // If phone is valid, remove the error message if any
            $('#phone').closest('.form-group').removeClass('has-error');
            $('#phone').closest('.form-group').find('.error-message').remove();
        }
    
        // Make AJAX call to send the message
        $.ajax({
            url: '{{ route('sendmessagevendor') }}', // Define the route for sending the message
            method: 'POST',
            data: {
                vendor_id: vendor_id,
                name: name,
                email: email,
                phone: phone,
                subject: subject,
                message: message,
                _token: $('meta[name="csrf-token"]').attr('content')  // CSRF token
            },
            success: function(response) {
                if (response.status == 1) {
                    // Show success message
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Message sent successfully!',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
    
                    // Optionally, clear the form after success
                    $('#messagemodal input[name="name"]').val('');
                    $('#messagemodal input[name="email"]').val('');
                    $('#messagemodal input[name="subject"]').val('');
                    $('#messagemodal textarea[name="message"]').val('');
                    $('#messagemodal input[name="phone"]').val('');
                    $('#messagemodal').modal('hide');  // Close modal after sending the message
                } else {
                    alert('Something went wrong! Please try again later.');
                }
            },
            error: function(error) {
                console.error('Error:', error);
                alert('An error occurred while sending the message.');
            }
        });
    });
    $('#submitReport').click(function () {
        let vendor_id = $('#report_vendor_id').val();
        let reason = $('input[name="report_reason"]:checked').val();
        let remarks = $('#report_remarks').val();

        // Basic validation
        if (!reason) {
            
            Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'Please select a reason for the report.',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
            return;
        }

        $.ajax({
            url: '{{ route("reportvendor") }}',
            method: 'POST',
            data: {
                vendor_id: vendor_id,
                reason: reason,
                remarks: remarks,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.status == 1) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Report submitted successfully!',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                    $('#flagmodal').modal('hide');
                    $('#report_remarks').val('');
                } else {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'Something went wrong. Please try again.',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                    
                }
            },
            error: function (xhr) {
                console.error(xhr);
                Swal.fire("An error occurred. Please try again.");
            }
        });
    });





    $('#contact-form').on('submit', function (e) {
        e.preventDefault(); 
        $('.error_msg').text(''); 
        $('.loading').show(); 

        $.ajax({
            url: "{{ route('contactusstore') }}",
            method: 'POST',
            data: $(this).serialize(), 
            success: function (response) {
                $('.loading').hide(); 
                Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: response.success || 'Your message has been sent successfully!',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                });

                $('#contact-form')[0].reset(); 
            },
            error: function (xhr) {
                $('.loading').hide(); 
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors; 
                    for (let field in errors) {
                        $('#' + field + '_error').text(errors[field][0]); 
                    }
                } else {
                    alert('Something went wrong. Please try again later.');
                }
            }
        });
    });
});


$(document).ready(function() {
    $('#search-input').on('keyup', function(e) {
        var query = $(this).val();  

        
        if (query.length < 2) {
            $('#autocomplete-results').hide();
            return;
        }
        if (e.keyCode === 13) {
            $('#header-search').submit();
        }

        $.ajax({
            url: "{{ route('productsuggestions') }}",  
            method: "GET",
            data: { q: query }, 
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' 
            }, 
            success: function(response) {
                var suggestions = response;
                var resultsHtml = '';

                if (suggestions.length > 0) {
                    suggestions.forEach(function(product) {
                        resultsHtml += '<li class="autocomplete-item" data-id="' + product.id + '">' + product.product_name + '</li>';
                    });
                    $('#autocomplete-results').html(resultsHtml).show();
                } else {
                    $('#autocomplete-results').hide();
                }
            }
        });
        
    });

    
    $(document).on('click', '.autocomplete-item', function() {
        var productName = $(this).text();
        $('#search-input').val(productName);  
        $('#autocomplete-results').hide();  
        $('#header-search').submit();
    });
    $('.action.search').on('click', function(e) {
        e.preventDefault();  
        $('#header-search').submit();  
    });

    
    $(document).click(function(e) {
        if (!$(e.target).closest('#search-input').length) {
            $('#autocomplete-results').hide();
        }
    });
});







// $(document).ready(function () {
//     let isEditMode = false;

//     $('#customer_file').on('change', function () {
//         const file = this.files[0];
//         const errorEl = $('#file_error');
//         const previewContainer = $('#file_preview');
//         const previewImg = $('#file_preview_img');
//         const previewPdfBtn = $('#previewPdfBtn');

//         errorEl.addClass('d-none').text('');
//         previewContainer.addClass('d-none');
//         previewImg.attr('src', '#');
//         previewPdfBtn.addClass('d-none').attr('href', '');

//         if (file) {
//             const validTypes = ['image/jpeg', 'image/png', 'image/jgp', 'image/pdf','application/pdf'];
//             const maxSize = 2 * 1024 * 1024;

//             if (!validTypes.includes(file.type)) {
//                 errorEl.removeClass('d-none').text('Only image files (JPG, PNG, JPEG, PDF) are allowed.');
//                 this.value = '';
//                 return;
//             }

//             if (file.size > maxSize) {
//                 errorEl.removeClass('d-none').text('File size must be less than 2MB.');
//                 this.value = '';
//                 return;
//             }

//             const reader = new FileReader();
//             reader.onload = function (e) {
//                 if (file.type === 'application/pdf') {
                        
//                         // previewPdfBtn.removeClass('d-none').attr('href', e.target.result).attr('target', '_blank');
//                         const pdfUrl = URL.createObjectURL(file);
//                             previewPdfBtn.removeClass('d-none').attr('href', pdfUrl).attr('target', '_blank');

//                     } else {
                        
//                         previewImg.attr('src', e.target.result);
//                         previewContainer.removeClass('d-none');
//                     }
//                 // previewImg.attr('src', e.target.result);
//                 // previewContainer.removeClass('d-none');
//             };
//             reader.readAsDataURL(file);
//         }
//     });

//     $('[data-bs-target="#personalisation"]').on('click', function () {
//         $('#modal_product_id').val($(this).data('product-id'));
//         isEditMode = false;
//         $('#submitPersonalization').text('Submit');
//         $('#personalization_id').val('');
//         resetModal();
//     });

//     $('#submitPersonalization').on('click', function () {
//         const product_id = $('#modal_product_id').val();
//         const note = $('#customer_notes').val();
//         const fileInput = document.getElementById('customer_file');
//         const personalization_id = $('#personalization_id').val();

//         let formData = new FormData();
//         formData.append('product_id', product_id);
//         formData.append('customer_notes', note);
//         if (fileInput.files[0]) {
//             formData.append('customer_file', fileInput.files[0]);
//         }

//         const url = personalization_id ? "{{ route('updatepersonalization') }}" : "{{ route('personalization') }}";
//         if (personalization_id) formData.append('id', personalization_id);
       

//         $.ajax({
//             url,
//             method: "POST",
//             contentType: false,
//             processData: false,
//             headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
//             data: formData,
//             success: function (response) {
//                 if (response.status === 1) {
//                     Swal.fire({
                        
//                         toast: true,
//                         position: 'top-end',
//                         icon: 'success',
//                         title: response.message,
//                         showConfirmButton: false,
//                         timer: 2500
//                     });
//                     $('#personalisation').modal('hide');
//                     fetchPersonalization(product_id);
//                 }
//             },
//             error: function () {
//                 alert("Failed to save personalization.");
//             }
//         });
//     });

//     function fetchPersonalization(productId) {
//         $.ajax({
//             url: "{{ route('getpersonalization') }}",
//             method: 'POST',
//             data: { _token: '{{ csrf_token() }}', productId: productId },
//             success: function (res) {
//                 if (res.status === 1 && res.data) {
//                     $('#display_note').text(res.data.notes || '');
//                     const fileUrl = res.data.uploaded_file_path;
//                     const fileName = res.data.uploaded_file_path_name || '';
//                     const fileExtension = fileName.split('.').pop().toLowerCase();
//                     $('#display_file_link').attr(fileUrl);
//                     $('#display_file_name_wrap').toggleClass('d-none', !res.data.uploaded_file_path);
//                     $('#display_file_link').text(res.data.uploaded_file_path_name);
//                     $('#display_file_link').attr('href', fileUrl);
//                     const previewContainer = $('#file_preview');
//                     const previewImg = $('#file_preview_img');
//                     const errorEl = $('#file_error');
//                     const previewPdfBtn = $('#file_preview_pdf_btn');

//                     errorEl.addClass('d-none').text('');
//                     previewContainer.addClass('d-none'); // Hide the preview container first
//                     previewImg.attr('src', '#'); // Reset the image to a placeholder or empty state
//                     previewPdfBtn.addClass('d-none').attr('href', '');

//                     // if (fileUrl) {
//                     //     previewImg.attr('src', fileUrl); // Set the new image source
//                     //     previewImg.on('load', function() {
//                     //         previewContainer.removeClass('d-none'); // Only show the container once the image is loaded
//                     //     }).on('error', function() {
//                     //         previewImg.attr('src', '#'); // In case of an error, reset to a placeholder
//                     //         previewContainer.addClass('d-none'); // Hide the container
//                     //     });
//                     // }
//                     if (fileUrl) {
//                         if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
//                             previewImg.attr('src', fileUrl)
//                                 .on('load', function () {
//                                     previewContainer.removeClass('d-none');
//                                 })
//                                 .on('error', function () {
//                                     previewImg.attr('src', '#');
//                                     previewContainer.addClass('d-none');
//                                 });
//                         } else if (fileExtension === 'pdf') {
//                             previewPdfBtn.removeClass('d-none').attr('href', fileUrl).attr('target', '_blank');
//                         }
//                     }
//                     $('.text-black.fs-16.mb-2').data('personalization-id', res.data.id);
//                     $('#personalization_id').val(res.data.id);
//                     $('#personalisation-edit').removeClass('d-none');
//                     $('#personalisation-delete').removeClass('d-none');
//                 } else {
//                     $('#display_note').text('');
//                     $('#display_file_name_wrap').addClass('d-none');
//                     $('#personalisation-edit').addClass('d-none');
//                     $('#personalization_id').val("");
//                     $('#personalisation-delete').addClass('d-none');
//                 }
//             }
//         });
//     }

//     $('.text-black.fs-16.mb-2').on('click', function () {
//         isEditMode = true;
//         const personalizationId = $('#personalization_id').val();
//        // $('#submitPersonalization').text('Update');
//        $('#submitPersonalization').text(personalizationId ? 'Update' : 'Submit');
//         $('#personalization_id').val(personalizationId);
//         $('#personalisation').modal('show');

//         // Fetch details
//         $.ajax({
//             url: "{{ route('getpersonalization') }}",
//             method: 'POST',
//             data: {
//                 _token: '{{ csrf_token() }}',
//                 productId: $('#modal_product_id').val()
//             },
//             success: function (res) {
//                 if (res.status === 1) {
//                     $('#customer_notes').val(res.data.notes);
//                     $('#display_note').text(res.data.notes || '');
//                     const fileUrl = res.data.uploaded_file_path;
//                     $('#display_file_link').attr(fileUrl);
//                     $('#display_file_name_wrap').toggleClass('d-none', !res.data.uploaded_file_path);
//                     $('#display_file_link').text(res.data.uploaded_file_path_name);
//                     $('#display_file_link').attr('href', fileUrl);
//                     const previewContainer = $('#file_preview');
//                     const previewImg = $('#file_preview_img');
//                     const errorEl = $('#file_error');

//                     errorEl.addClass('d-none').text('');
//                     previewContainer.addClass('d-none'); // Hide the preview container first
//                     previewImg.attr('src', '#'); // Reset the image to a placeholder or empty state

//                     if (fileUrl) {
//                         previewImg.attr('src', fileUrl); // Set the new image source
//                         previewImg.on('load', function() {
//                             previewContainer.removeClass('d-none'); // Only show the container once the image is loaded
//                         }).on('error', function() {
//                             previewImg.attr('src', '#'); // In case of an error, reset to a placeholder
//                             previewContainer.addClass('d-none'); // Hide the container
//                         });
//                     }
//                     $('#personalization_id').val(res.data.id);
//                     $('.text-black.fs-16.mb-2').data('personalization-id', res.data.id);
//                 }
//             }
//         });
//     });

//     $('.text-danger.fs-16.mb-2').on('click', function () {
//         const personalizationId = $('#personalization_id').val();
//         Swal.fire({
//             iconHtml: `<img src="{{ asset('front_end/assets/images/delete-circle.svg') }}" class="img-fluid">`,
//             // title: "Are you sure?",
//             text: "Are you sure you want to delete this personalization?",
//             icon: "warning",
//             showCancelButton: true,
//             confirmButtonText: "Yes, delete it!"
//         }).then(result => {
//             if (result.isConfirmed) {
//                 $.ajax({
//                     url: "{{ route('deletepersonalization') }}",
//                     method: 'POST',
//                     data: { _token: '{{ csrf_token() }}', id: personalizationId },
//                     success: function (res) {
//                         if (res.status === 1) {
//                            // Swal.fire("Deleted!", res.message, "success");
//                             fetchPersonalization($('#modal_product_id').val());
//                         }
//                     }
//                 });
//             }
//         });
//     });

//     function resetModal() {
//         $('#customer_notes').val('');
//         $('#customer_file').val('');
//         $('#file_preview').addClass('d-none');
//         $('#file_error').addClass('d-none').text('');
//     }

//     const detailProductId = $('.product-form__cart-submit').data('product-id');
//     if (detailProductId) fetchPersonalization(detailProductId);
// });


$(document).ready(function () {
    toggleDeliveryInfo();
    let currentFile = null;
    let currentNote = '';
    let isEditMode = false;

    const fileInput = $('#customer_file');
    const errorEl = $('#file_error');
    const previewContainer = $('#file_preview');
    const previewImg = $('#file_preview_img');
    const previewPdfBtn = $('#previewPdfBtn');
    const noteInput = $('#customer_notes');
    const fileNameWrap = $('#display_file_name_wrap');
    const fileLink = $('#display_file_link');
    const displayNote = $('#display_note');

    resetModal();

    fileInput.on('change', function () {
        const file = this.files[0];
        previewFile(file);
    });

    function previewFile(file) {
        errorEl.addClass('d-none').text('');
        previewContainer.addClass('d-none');
        previewImg.attr('src', '#');
        previewPdfBtn.addClass('d-none').attr('href', '');

        if (!file) return;

        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
        const maxSize = 2 * 1024 * 1024;

        if (!validTypes.includes(file.type)) {
            errorEl.removeClass('d-none').text('Only JPG, PNG, JPEG, or PDF files are allowed.');
            fileInput.val('');
            return;
        }

        if (file.size > maxSize) {
            errorEl.removeClass('d-none').text('File size must be less than 2MB.');
            fileInput.val('');
            return;
        }

        currentFile = file;

        const reader = new FileReader();
        reader.onload = function (e) {
               toggleDeliveryInfo();
            if (file.type === 'application/pdf') {
                const pdfUrl = URL.createObjectURL(file);
                previewPdfBtn.removeClass('d-none').attr('href', pdfUrl).attr('target', '_blank');
                fileLink.attr('href', pdfUrl).attr('target', '_blank');
            } else {
                const imageUrl = e.target.result;
                previewImg.attr('src', imageUrl);
                previewContainer.removeClass('d-none');
                fileLink.attr('href', "Javascript:void(0);").attr('target', '_blank');
            }
        };

        if (file.type === 'application/pdf') {
            reader.readAsArrayBuffer(file); // Required to trigger onload
        } else {
            reader.readAsDataURL(file);
        }
    }
    function toggleDeliveryInfo() {
        const fileInput = $('#customer_file').val();
        const noteInput = $('#customer_notes').val();

        if (fileInput || noteInput.trim() !== '') {
            $('#sandard_delivery_range').hide();
            $('#custom_delivery_range').show();
        } else {
            $('#sandard_delivery_range').show();
            $('#custom_delivery_range').hide();
        }
    }

    $('[data-bs-target="#personalisation"]').on('click', function () {
        isEditMode = false;
        $('#submitPersonalization').text('Submit');
        resetModal();
    });

    $('#submitPersonalization').on('click', function () {
        currentNote = noteInput.val();

        displayNote.text(currentNote);
        fileNameWrap.addClass('d-none');
        fileLink.text('');

        if (currentFile) {
            fileNameWrap.removeClass('d-none');
            fileLink.text(currentFile.name);

            previewFile(currentFile); // Refresh preview
        }
        toggleDeliveryInfo();

        $('#personalisation').modal('hide');
        $('#personalisation-edit').removeClass('d-none');
        $('#personalisation-delete').removeClass('d-none');
    });

    $('#personalisation-edit').on('click', function () {
        isEditMode = true;
        $('#submitPersonalization').text('Update');
        noteInput.val(currentNote);
        fileInput.val('');
        previewContainer.addClass('d-none');
        previewPdfBtn.addClass('d-none').attr('href', '');

        if (currentFile) {
            previewFile(currentFile);
        }
        toggleDeliveryInfo();

        $('#personalisation').modal('show');
    });

    $('#personalisation-delete').on('click', function () {
        currentNote = '';
        currentFile = null;
        displayNote.text('');
        fileNameWrap.addClass('d-none');
        fileLink.text('').attr('href', '');
        resetModal();
        toggleDeliveryInfo();
        $('#personalisation-edit').addClass('d-none');
        $('#personalisation-delete').addClass('d-none');
    });

    function resetModal() {
        noteInput.val('');
        fileInput.val('');
        errorEl.addClass('d-none').text('');
        previewContainer.addClass('d-none');
        previewImg.attr('src', '#');
        previewPdfBtn.addClass('d-none').attr('href', '');
        toggleDeliveryInfo();
    }
});




  // Language toggle logic
const languageToggles = document.querySelectorAll('.check-toggle');

function updateLanguage(isArabic) {
  const lang = isArabic ? 'ar' : 'en';
  const dir = isArabic ? 'rtl' : 'ltr';

  // Update HTML lang and direction
  document.documentElement.lang = lang;
  document.documentElement.dir = dir;

 

  // Sync all toggle switches
  languageToggles.forEach(toggle => {
    toggle.checked = isArabic;
  });
  $.ajax({
  url: '{{ route("set.language") }}',
  method: 'GET',
  data: { lang: lang },
  success: function (data) {
    if (data.status === 1) {
      // Reload page to apply language change
      window.location.reload();
    }
  },
  error: function (err) {
    console.error('Error setting language:', err);
  }
});
}

// Add change listener to all toggle inputs
languageToggles.forEach(toggle => {
  toggle.addEventListener('change', () => {
    updateLanguage(toggle.checked);
  });
});

$(document).ready(function () {
  const currentLang = '{{ app()->getLocale() }}';

  const isArabic = currentLang === 'ar';

  languageToggles.forEach(toggle => {
    toggle.checked = isArabic;
  });

  document.documentElement.lang = currentLang;
  document.documentElement.dir = isArabic ? 'rtl' : 'ltr';
});

// Optional: Set initial language (based on saved preference or default)
// updateLanguage(false); // English by default














</script>




            <!--Newsletter Popup Cookies-->
            <!-- <script>
                function newsletter_popup() {
                    var cookieSignup = "cookieSignup", date = new Date();
                    if (AED .cookie(cookieSignup) != 'true' && window.location.href.indexOf("challenge#newsletter-modal") <= -1) {
                        setTimeout(function () {
                            AED .magnificPopup.open({
                                items: {
                                    src: '#newsletter-modal'
                                }
                                , type: 'inline', removalDelay: 300, mainClass: 'mfp-zoom-in'
                            }
                            );
                        }
                        , 5000);
                    }
                    AED .magnificPopup.instance.close = function () {
                        if (AED ("#dontshow").prop("checked") == true) {
                            AED .cookie(cookieSignup, 'true', {
                                expires: 1, path: '/'
                            }
                            );
                        }
                        AED .magnificPopup.proto.close.call(this);
                    }
                }
                newsletter_popup();
            </script> -->
            <!--End Newsletter Popup Cookies-->

        </div>
        <!--End Page Wrapper-->
        @yield('script')
    </body>
</html>