@extends('front_end.template.layout')
@section('content')
<div id="page-content">   
                <!--Collection Banner-->
                <div class="collection-header">
                    <div class="collection-hero">
                        <div class="collection-hero__image"></div>
                        <div class="collection-hero__title-wrapper container">
                            <h1 class="collection-hero__title">FAQs</h1>
                            <div class="breadcrumbs text-uppercase mt-1 mt-lg-2"><a href="{{route('home')}}" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">FAQs</span></div>
                        </div>
                    </div>
                </div>
                <!--End Collection Banner-->

                <!--Main Content-->
                <div class="container">

                    
                    <!-- FAQ's Style1 -->
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-10 col-lg-10 mx-auto">
                            <div class="accordion" id="accordionFaq">
                                <h3 class="faqttl">FAQ'S</h3>
                                @foreach($faqs as $index => $faq)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $index }}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
                                                {{ $faq->title }}
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#accordionFaq">
                                            <div class="accordion-body">
                                                <p>{{ $faq->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                              
                             
                               
                               
                            </div>
                        </div>
                    </div>
                    <!-- End FAQ's Style1 -->
                </div>
                <!--End Main Content-->
            </div>
            <!--End Body Container-->
@endsection 