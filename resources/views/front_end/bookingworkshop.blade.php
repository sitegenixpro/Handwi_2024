@extends('front_end.template.layout')
@section('content')
 <!--Body Container-->
 <div id="page-content">
                <!--Collection Banner-->
                <div class="collection-header">
                    <div class="collection-hero">
                        <div class="collection-hero__image"></div>
                        <div class="collection-hero__title-wrapper container">
                            <h1 class="collection-hero__title">Book Now</h1>
                            <div class="breadcrumbs text-uppercase mt-1 mt-lg-2"><a href="{{ route('home') }}" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">Book Now</span></div>
                        </div>
                    </div>A
                </div>
                <!--End Collection Banner-->

                <!--Main Content-->
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <div class="customer-box returning-customer">
                                <!-- <h3 class="rounded-1"><i class="me-2 icon an an-user"></i>Returning customer? <a href="#customer-login" id="customer" class="text-white fw-bolder" data-bs-toggle="collapse">Click here to login</a></h3> -->
                                <div id="customer-login" class="collapse customer-content">
                                    <div class="rounded-bottom customer-info">
                                        <p class="coupon-text mb-3">If you have shopped with us before, please enter your details in the boxes below. If you are a new customer, please proceed to the Billing &amp; Shipping section.</p>
                                        <form method="post" action="#">
                                            <div class="row">
                                                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                    <label for="exampleInputEmail1">Email address <span class="required-f">*</span></label>
                                                    <input type="email" class="no-margin" id="exampleInputEmail1" required>
                                                </div>
                                                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                    <label for="exampleInputPassword1">Password <span class="required-f">*</span></label>
                                                    <input type="password" id="exampleInputPassword1" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-check d-flex justify-content-between ps-0">
                                                        <div class="customCheckbox">
                                                            <input type="checkbox" class="form-check-input" id="remember" value="" />
                                                            <label for="remember"> Remember me!</label>
                                                        </div>
                                                        <a href="#" class="ml-3 float-end">Forgot your password?</a>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary rounded mt-3">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <div class="customer-box customer-coupon">
                                <!-- <h3 class="rounded-1"><i class="me-2 icon an an-gift"></i>Have a coupon? <a href="#have-coupon" class="text-white fw-bolder" data-bs-toggle="collapse">Click here to enter your code</a></h3> -->
                                <div id="have-coupon" class="collapse coupon-checkout-content">
                                    <div class="rounded-bottom discount-coupon">
                                        <div id="coupon" class="coupon-dec tab-pane active">
                                            <p class="mb-3">Enter your coupon code if you have one.</p>
                                            <form method="post" action="#">
                                                <div class="form-group mb-0">
                                                    <label class="get" for="coupon-code">Coupon code <span class="required-f">*</span></label>
                                                    <input id="coupon-code" required type="text" class="mb-3">
                                                    <button class="coupon-btn btn rounded" type="submit">Apply Coupon</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row billing-fields">

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="your-order-payment mb-4">
                                <div class="your-order">
                                    <h2 class="order-title mb-3">Chosen Workshop</h2>
                                    <div class="table-responsive order-table style2"> 
                                        <table class="bg-white table table-bordered align-middle table-hover text-center mb-1">
                                            <thead>
                                                <tr>
                                                    <th class="text-start">Workshop Name</th>
                                                    <th>Price</th>
                                                    <!-- <th>Size</th> -->
                                                    <th>Qty</th>
                                                    <!-- <th>Price</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-start">
                                                        <a href="workshop-details.html">{{ $workshop->name }}</a>
                                                        <div class="cart__meta-text">
                                                        {{ $workshop->location }}
                                                        </div>
                                                    </td>
                                                    <td>AED {{ $workshop->service_price }}</td>
                                                    <!-- <td>S</td> -->
                                                    <td id="quantityDisplayservice">1</td>
                                                    <!-- <td>AED {{ $workshop->service_price }}</td> -->
                                                </tr>
                                            </tbody>
                                            <tfoot class="font-weight-600"> 
                                                <tr>
                                                    <input type="hidden" name="service_subtotal" id="service_subtotal" value="{{ $workshop->service_price }}">
                                                    <input type="hidden" name="service_tax" id="service_tax" value="{{ $tax_percentage }}">
                                                    <td colspan="2" class="text-end fw-bolder">Sub Total </td>
                                                    <td class="fw-bolder" id="subtotalDisplay">AED {{ $workshop->service_price }}</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td colspan="2" class="text-end fw-bolder">Tax ({{ $tax_percentage }}%)</td>
                                                    <td class="fw-bolder" id="taxDisplay">AED {{ number_format($tax_amount, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="text-end fw-bolder">Grand Total</td>
                                                    <td class="fw-bolder" id="grandTotalDisplay">AED {{ number_format($grand_total, 2) }}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 mb-3 mb-lg-0">
                            <div class="create-ac-content">
                                <form method="post" action="#">
                                    <fieldset>
                                        <h2 class="login-title mb-3">Date and Time</h2>

                                        <span>Workshop Date</span>
                                        <h4>{{ \Carbon\Carbon::parse($workshop->from_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($workshop->from_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($workshop->to_time)->format('H:i') }}</h4>

                                        <div class="seat-selector" data-workshop-id="{{ $workshop->id }}">
                                            <input type="hidden" id="workshopId" name="workshopId" value="{{ $workshop->id }}">
                                            <div class="grid-wrap">
                                                  
                                            
                                              @foreach ($all_seats as $seat)
                                                @php
                                                    $is_booked = in_array($seat, $booked_seats);
                                                @endphp
                                                  <label class="container-check-c">
                                                    <input type="checkbox" class="seat-checkbox" name="seats[]" value="{{ $seat }}" {{ $is_booked ? 'disabled' : '' }}>
                                                    <span class="icon" {{ $is_booked ? 'unavail' : 'avail' }}>
                                                        <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M16.5885 6.66667H16.1719V3.75C16.1719 1.6825 14.4894 0 12.4219 0H8.25521C6.18771 0 4.50521 1.6825 4.50521 3.75V6.66667H4.08854C2.48021 6.66667 1.17188 7.975 1.17188 9.58333V13.75C1.17188 14.8992 2.10688 15.8333 3.25521 15.8333H9.92188V19.1667H5.75521C5.52521 19.1667 5.33854 19.3533 5.33854 19.5833C5.33854 19.8133 5.52521 20 5.75521 20H14.9219C15.1519 20 15.3385 19.8133 15.3385 19.5833C15.3385 19.3533 15.1519 19.1667 14.9219 19.1667H10.7552V15.8333H17.4219C18.5702 15.8333 19.5052 14.8992 19.5052 13.75V9.58333C19.5052 7.975 18.1969 6.66667 16.5885 6.66667ZM16.5885 7.5C17.7369 7.5 18.6719 8.43417 18.6719 9.58333V12.0842C18.3235 11.8217 17.8902 11.6667 17.4219 11.6667H16.1719V7.5H16.5885ZM5.33854 3.75C5.33854 2.14167 6.64688 0.833333 8.25521 0.833333H12.4219C14.0302 0.833333 15.3385 2.14167 15.3385 3.75V11.6667H5.33854V3.75ZM4.08854 7.5H4.50521V11.6667H3.25521C2.78688 11.6667 2.35354 11.8225 2.00521 12.0842V9.58333C2.00521 8.43417 2.94021 7.5 4.08854 7.5ZM17.4219 15H3.25521C2.56604 15 2.00521 14.4392 2.00521 13.75C2.00521 13.0608 2.56604 12.5 3.25521 12.5H17.4219C18.111 12.5 18.6719 13.0608 18.6719 13.75C18.6719 14.4392 18.111 15 17.4219 15Z" fill="#6C727F"/>
                                                        </svg>
                                                    </span>
                                                    <span class="checkmark"></span>
                                                  </label>
                                                  @endforeach
                                            </div>
                                            <ul class="list-indc">
                                                <li>
                                                    <span class="ind avail"></span>
                                                    Available
                                                </li>
                                                <li>
                                                    <span class="ind unavail"></span>
                                                    Unavailable
                                                </li>
                                                <li>
                                                    <span class="ind selct"></span>
                                                    Selected
                                                </li>
                                            </ul>
                                        </div>

                                    </fieldset>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="your-order-payment">
                                <div class="your-payment">
                                    <h2 class="payment-title mb-3">payment method</h2>
                                    <div class="payment-method">
                                        <div class="payment-accordion">

                                            <div class="form-group">
                                                <div class="d-flex flex-wrap mt-3 col-md-12 col-lg-12 col-xl-12">
                                                    <!-- <label class="control-label me-3 mb-0"><strong>Choose Payment</strong></label> -->
                                                    <div class="customRadio clearfix me-3 mb-0 w-100 mb-3">
                                                        <input name="mr" id="mr" value="1" checked="checked" type="radio" class="padding-10px-right">
                                                        <label for="mr" class="mb-0">
                                                            <svg class="me-2" width="26" height="17" viewBox="0 0 26 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M25.603 4.89652V2.44041C25.603 1.3549 24.7149 0.466797 23.6294 0.466797H2.90696C1.82145 0.466797 0.93335 1.3549 0.93335 2.44041V4.89652H25.603Z" fill="#D9ADA0"/>
                                                                <path d="M0.93335 7.36328V14.5064C0.93335 15.5919 1.82145 16.48 2.90696 16.48H23.6294C24.7149 16.48 25.603 15.5919 25.603 14.5064V7.36328H0.93335ZM14.5739 13.284H4.80867V10.817H14.5734V13.284H14.5739ZM21.728 13.284H18.4593V10.817H21.728V13.284Z" fill="#A0A0A0"/>
                                                                </svg>
                                                                
                                                            Debit/Credit Card</label>
                                                    </div>
                                                 
                                                    
                                                </div>
                                            </div>
                                          
                                        </div>
                                        <div class="order-button-payment mt-3 clearfix">
                                            
                                            @if (Auth::check())

                                                <a href="javascript:void(0)" id="payNowButtonworkshop" class="fs-6 btn btn-lg rounded w-100 fw-600 text-white">Pay Now</a>
                                            @else

                                                <a href="{{ route('login') }}" class="fs-6 btn btn-lg rounded w-100 fw-600 text-white">Login</a>
                                            @endif
                                        </div>
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