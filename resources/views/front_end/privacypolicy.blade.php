@extends('front_end.template.layout')
@section('content')
<div id="page-content">   
                <!--Collection Banner-->
                <div class="collection-header">
                    <div class="collection-hero">
                        <div class="collection-hero__image"></div>
                        <div class="collection-hero__title-wrapper container">
                            <h1 class="collection-hero__title">Privacy Policy</h1>
                            <div class="breadcrumbs text-uppercase mt-1 mt-lg-2"><a href="{{route('home')}}" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">Privacy Policy</span></div>
                        </div>
                    </div>
                </div>
                <!--End Collection Banner-->

                <!--Main Content-->
                <div class="container">

                    
                    <!-- FAQ's Style1 -->
                    
                            {!! $record->desc_en !!}
                      
                    <!-- End FAQ's Style1 -->
                </div>
                <!--End Main Content-->
            </div>
            <!--End Body Container-->
@endsection 