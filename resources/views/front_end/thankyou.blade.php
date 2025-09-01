@extends('front_end.template.layout')
@section('content')

            <!--Body Container-->
            <div id="page-content">
                <!--Collection Banner-->
                <div class="collection-header">
                    <div class="collection-hero">
                        <div class="collection-hero__image"></div>
                        <div class="collection-hero__title-wrapper container">
                            <h1 class="collection-hero__title">Checkout Success</h1>
                            <div class="breadcrumbs text-uppercase mt-1 mt-lg-2"><a href="{{route('home')}}" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">Checkout Success</span></div>
                        </div>
                    </div>
                </div>
                <!--End Collection Banner-->

                <!--Main Content-->
                <div class="container">
                    <div class="checkout-success-content py-2">
                        <!--Order Card-->
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="checkout-scard card border-0 rounded">
                                    <div class="card-body text-center">
                                        <p class="card-icon">
                                            <svg width="200" height="200" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M100 200C86.4666 200 73.7916 193.708 65.6 183.042C52.2666 184.775 38.8583 180.275 29.2916 170.708C19.725 161.142 15.2166 147.733 16.9583 134.4C6.29997 126.208 0.00830078 113.542 0.00830078 100C0.00830078 86.4583 6.29997 73.7917 16.9583 65.6C15.2166 52.2667 19.725 38.8583 29.2916 29.2917C38.8583 19.7167 52.275 15.1917 65.6 16.9583C73.7916 6.29167 86.4666 0 100 0C113.533 0 126.208 6.29167 134.4 16.9583C147.717 15.1917 161.133 19.7167 170.708 29.2917C180.283 38.8667 184.783 52.2667 183.042 65.6C193.7 73.7917 199.992 86.4583 199.992 100C199.992 113.542 193.7 126.208 183.042 134.4C184.783 147.733 180.275 161.142 170.708 170.708C161.133 180.275 147.708 184.775 134.4 183.042C126.208 193.708 113.533 200 100 200ZM69.3833 173.9L70.925 176.183C77.4666 185.875 88.3333 191.658 100 191.658C111.667 191.658 122.533 185.875 129.075 176.183L130.617 173.9L133.325 174.425C144.775 176.658 156.558 173.058 164.817 164.817C173.067 156.567 176.658 144.792 174.425 133.317L173.908 130.608L176.192 129.067C185.875 122.533 191.658 111.667 191.658 100C191.658 88.3333 185.875 77.4667 176.192 70.9333L173.908 69.3917L174.425 66.6833C176.658 55.2083 173.067 43.425 164.817 35.1833C156.558 26.9333 144.775 23.3417 133.325 25.575L130.617 26.1L129.075 23.8167C122.533 14.125 111.667 8.34167 100 8.34167C88.3333 8.34167 77.4666 14.125 70.925 23.8167L69.3833 26.1L66.675 25.575C55.2333 23.3333 43.4333 26.9417 35.1833 35.1833C26.9333 43.425 23.3416 55.2083 25.575 66.6833L26.0916 69.3917L23.8083 70.9333C14.125 77.4667 8.34163 88.3333 8.34163 100C8.34163 111.667 14.125 122.533 23.8083 129.067L26.0916 130.608L25.575 133.317C23.3416 144.792 26.9333 156.575 35.1833 164.817C43.4333 173.058 55.2333 176.658 66.675 174.425L69.3833 173.9ZM96.3083 121.358L144.583 73.8L138.742 67.8667L90.4416 115.442C88.825 117.067 86.1833 117.067 84.5 115.4L61.225 92.8417L55.4333 98.825L78.6583 121.342C81.1 123.783 84.3083 125 87.5083 125C90.7083 125 93.8916 123.783 96.3083 121.358Z" fill="black"/>
                                                </svg>
                                        </p>
                                        <h4 class="card-title">Thank you!</h4>
                                        <p class="card-text mb-1">You will not be charged until you review this order on the next page</p>
                                        <!-- <p class="card-text mb-1">All necessary information about the delivery, we sent to your email</p> -->
                                        <!-- <p class="card-text text-order badge bg-success my-3">Your order # is: <b>00000123</b></p> -->
                                        <!-- <p class="card-text mb-0">Order date: 14 Nov 2021</p> -->
                                        <a type="button" href="{{route('home')}}" class="btn btn-outline-primary text-transform-none mt-4">Back to Home</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Main Content-->
            </div>
            <!--End Body Container-->
@endsection 