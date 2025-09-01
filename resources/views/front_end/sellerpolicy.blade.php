@extends('front_end.template.layout')
@section('content')
<div id="page-content">   
                <!--Collection Banner-->
                <div class="collection-header">
                    <div class="collection-hero">
                        <div class="collection-hero__image"></div>
                        <div class="collection-hero__title-wrapper container">
                            <h1 class="collection-hero__title">Seller Policy</h1>
                            <div class="breadcrumbs text-uppercase mt-1 mt-lg-2"><a href="{{route('home')}}" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">Terms and Conditions</span></div>
                        </div>
                    </div>
                </div>
                <!--End Collection Banner-->

                <!--Main Content-->
                <div class="container">

                                {!! $record->desc_en !!}
                              
                             
                               
                         
                    </div>
                    <!-- End FAQ's Style1 -->
                </div>
                <!--End Main Content-->
            </div>
            <!--End Body Container-->
@endsection 