@extends('front_end.template.layout')
@section('content')
            <!--Body Container-->
            <div id="page-content">
                <!--Collection Banner-->
                <div class="collection-header">
                    <div class="collection-hero m-0">
                        <div class="collection-hero__image"></div>
                        <div class="collection-hero__title-wrapper container">
                            <h1 class="collection-hero__title">About Us</h1>
                            <div class="breadcrumbs text-uppercase mt-1 mt-lg-2"><a href="{{ route('home') }}" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">About Us</span></div>
                        </div>
                    </div>
                </div>
                <!--End Collection Banner-->

                <!--Main Content-->
                <!--Content Info-->
                @php
                                    
                    $about_us_title = \App\Models\AboutusPageSetting::where('meta_key', 'about_us_title')->first();
                    $about_us_description = \App\Models\AboutusPageSetting::where('meta_key', 'about_us_description')->first();

                    $about_us_title = $about_us_title && $about_us_title->meta_value  ? $about_us_title->meta_value    : '';
                    $about_us_description = $about_us_description && $about_us_description->meta_value   ? $about_us_description->meta_value   : '';
                @endphp 
                <div class="container section">
                    <div class="row about-info1">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-9 mx-auto text-center">
                            <h2 class="mb-3 fw-normal fs-26 text-capitalize">{!! $about_us_title !!}</h2> 
                            <p>{!! $about_us_description !!}</p>                     
                        </div>
                    </div>
                </div>
                <!--End Content Info-->

                <!--The Founder-->
                @php
                                    
                    $founder_date = \App\Models\AboutusPageSetting::where('meta_key', 'founder_date')->first();
                    $founder_title = \App\Models\AboutusPageSetting::where('meta_key', 'founder_title')->first();
                    $founder_description = \App\Models\AboutusPageSetting::where('meta_key', 'founder_description')->first();
                    $founder_image = \App\Models\AboutusPageSetting::where('meta_key', 'founder_image')->first();
                    
                    $founder_image = $founder_image && $founder_image->meta_value  ? $founder_image->meta_value    : '';
                    $founder_date = $founder_date && $founder_date->meta_value  ? $founder_date->meta_value    : '';
                    $founder_title = $founder_title && $founder_title->meta_value   ? $founder_title->meta_value   : '';
                    $founder_description = $founder_description && $founder_description->meta_value   ? $founder_description->meta_value   : '';
                @endphp 
                <div class="container-fluid px-0 clr-f5 about-bnr-text">
                    <div class="row g-0 align-items-center">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 row_text">
                            <div class="about-info2 row-text">
                                <h3 class="h6">{!! $founder_date !!} <b class="h1 fs-26 d-block mt-2 fw-bold">{!! $founder_title !!}</b></h3>
                                <p>{!! $founder_description !!}</p>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                            <img class="about-info-img blur-up lazyload" data-src="{{ $founder_image}}" src="{{ $founder_image}}" alt="about" />
                        </div>
                    </div>
                </div>
                <!--End The Founder-->

                <!--Our Story-->
                @php
                                    
                $our_story_title = \App\Models\AboutusPageSetting::where('meta_key', 'our_story_title')->first();
                $our_story_date = \App\Models\AboutusPageSetting::where('meta_key', 'our_story_date')->first();
                $our_story_description = \App\Models\AboutusPageSetting::where('meta_key', 'our_story_description')->first();

                $our_story_title = $our_story_title && $our_story_title->meta_value  ? $our_story_title->meta_value    : '';
                $our_story_date = $our_story_date && $our_story_date->meta_value   ? $our_story_date->meta_value   : '';
                $our_story_description = $our_story_description && $our_story_description->meta_value   ? $our_story_description->meta_value   : '';
               @endphp 
                <div class="container section pb-0">
                    <div class="section-header col-12">
                        <h2 class="text-capitalize">{!! $our_story_title !!}</h2>
                        <p>{!! $our_story_date !!}</p>
                    </div>
                    <div class="row about-info3">
                        {!! $our_story_description !!}
                    </div>

                    @php
                                    
                        $our_vision_title = \App\Models\AboutusPageSetting::where('meta_key', 'our_vision_title')->first();
                        $our_vision_description = \App\Models\AboutusPageSetting::where('meta_key', 'our_vision_description')->first();
                        
        
                        $our_vision_title = $our_vision_title && $our_vision_title->meta_value  ? $our_vision_title->meta_value    : '';
                        $our_vision_description = $our_vision_description && $our_vision_description->meta_value   ? $our_vision_description->meta_value   : '';
                    @endphp 

                    <div class="row section">
                        <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                            <h3>{!! $our_vision_title !!}</h3>
                        </div>
                        <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                            <p>{!! $our_vision_description !!}</p>
                        </div>
                    </div>
                  
                    <!--End Main Content-->
                </div>
                <!--End Our Story-->
                <!--End Main Content-->
            </div>
            <!--End Body Container-->
@endsection 