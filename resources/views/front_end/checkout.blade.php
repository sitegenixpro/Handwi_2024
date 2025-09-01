@extends('front_end.template.layout')
@section('content')
 <!--Body Container-->
 <div id="page-content">
                <!--Collection Banner-->
                <div class="collection-header">
                    <div class="collection-hero">
                        <div class="collection-hero__image"></div>
                        <div class="collection-hero__title-wrapper container">
                            <h1 class="collection-hero__title">Checkout</h1>
                            <div class="breadcrumbs text-uppercase mt-1 mt-lg-2"><a href="{{route('home')}}" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">Checkout</span></div>
                        </div>
                    </div>
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
                                                        <a href="forgot-password.html" class="ml-3 float-end">Forgot your password?</a>
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
                                    <h2 class="order-title mb-3">Your Order</h2>
                                    <div class="table-responsive order-table style2"> 
                                        <table class="bg-white table table-bordered align-middle table-hover text-center mb-1">
                                            <thead>
                                                <tr>
                                                    <th class="text-start">Product Name</th>
                                                    <th>Price</th>
                                                    <!-- <th>Size</th> -->
                                                    <th>Qty</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               @foreach($cart as $item)
                                                <tr>
                                                    <td class="text-start">
                                                        {{ $item['name'] }} {{$item['color_text']}} {{$item['size_text']}}
                                                        <div class="cart__meta-text">
                                                          {{ $item['description'] ?? '' }}
                                                          @if(!empty($item['customer_notes']) || !empty($item['customer_file']))
                                                            <a href="javascript:void(0);" class="text-primary d-block mt-1" data-bs-toggle="collapse" data-bs-target="#item-detail-{{ $item['id'] }}">
                                                                View Details
                                                            </a>

                                                            <div class="collapse mt-2" id="item-detail-{{ $item['id'] }}">
                                                                @if(!empty($item['customer_notes']))
                                                                    <div class="text-muted small mb-1">
                                                                        <strong>Note:</strong> {{ $item['customer_notes'] }}
                                                                    </div>
                                                                @endif

                                                                @if(!empty($item['customer_file']))
                                                                    @php
                                                                        $ext = pathinfo($item['customer_file'], PATHINFO_EXTENSION);
                                                                        $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                                                    @endphp
                                                                    <div class="small">
                                                                        <strong>File:</strong>
                                                                        @if($isImage)
                                                                            <div class="mt-1">
                                                                                <img src="{{ asset($item['customer_file']) }}" alt="Uploaded file" style="max-height: 100px; border: 1px solid #ddd;">
                                                                            </div>
                                                                        @else
                                                                            <a href="{{ asset($item['customer_file']) }}" target="_blank" class="text-primary text-decoration-underline">
                                                                                View Uploaded File
                                                                            </a>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        </div>
                                                    </td>
                                                    <td>AED {{ number_format($item['price'], 2) }}</td>
                                                    <!-- <td>S</td> -->
                                                    <td>{{ $item['quantity'] }}</td>
                                                    <td>AED {{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                                </tr>
                                                @endforeach
                                                
                                                
                                            </tbody>
                                            <tfoot class="font-weight-600">
                                                <tr>
                                                    <td colspan="3" class="text-end fw-bolder">Tax </td>
                                                    <td class="fw-bolder">AED {{ number_format($totalTax, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="text-end fw-bolder">Shipping </td>
                                                    <td class="fw-bolder">AED {{ number_format($shipping, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="text-end fw-bolder">Total</td>
                                                    <td class="fw-bolder">AED {{ number_format($grand_total, 2) }}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 mb-3 mb-lg-0">
                            <div class="create-ac-content">
                                <div id="address" class="address tab-pane">
                                    <h3>Delivery address</h3>
                                    <p class="xs-fon-13 margin-10px-bottom">The following addresses will be used on the checkout page by default.</p>
                                    <div class="row">
                                    @if($addresses->isEmpty())
                                        <div class="col-12">
                                            <p class="mb-1">You don't have any saved addresses.</p>
                                            <a href="{{ route('userdashboard') }}#address" class="btn btn-primary">Add New Address</a>
                                        </div>
                                    @else
                                    @foreach($addresses as $address)
                                        <div class="col-12">
                                            <p class="mb-1">{{ $address->address }}</p>
                                            <h4 class="billing-address mb-3">{{ $address->full_name }}</h4>
                                            
                                            @if($address->is_default)
                                                <a class="link-underline view me-3" href="#">Default Address</a>
                                            @else
                                                <a class="link-underline view make-default" data-id="{{ $address->id }}" href="#">Other Address</a>
                                            @endif

                                            <!-- Add radio button to select this address -->
                                            <input type="radio" name="address_id" value="{{ $address->id }}" id="address_{{ $address->id }}" {{ $address->is_default ? 'checked' : '' }} class="address-radio">
                                            <label for="address_{{ $address->id }}">Select this address</label>
                                        </div>
                                    @endforeach
                                    @endif
                                    </div>
                                </div>
                                <!-- End Address -->
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
                                                    <div class="customRadio clearfix me-3 mb-0 w-100 mb-3">
                                                        <input name="mr" id="mrs" value="0" type="radio" class="padding-10px-right">
                                                        <label for="mrs" class="mb-0">
                                                            <svg class="me-2" width="20" height="23" viewBox="0 0 20 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <g clip-path="url(#clip0_393_2077)">
                                                                <path d="M19.9333 17.0027C19.4889 18.3724 18.8223 19.6228 17.9279 20.7482C17.512 21.2711 17.0676 21.7826 16.572 22.2316C15.8028 22.9307 14.8742 23.1296 13.8715 22.8284C13.3018 22.6579 12.7492 22.4306 12.1795 22.26C11.0628 21.919 9.98035 22.0839 8.90359 22.4874C8.37376 22.6863 7.83253 22.8682 7.27421 22.9591C6.4823 23.0899 5.81574 22.7432 5.22323 22.243C4.35157 21.5098 3.685 20.5947 3.08111 19.6456C1.92458 17.8382 1.22953 15.8546 1.00165 13.7232C0.819337 12.0409 0.978857 10.3926 1.83343 8.88648C2.93868 6.94837 4.60794 5.87984 6.85832 5.89121C7.51919 5.89689 8.18005 6.16971 8.83523 6.3459C9.2796 6.46526 9.71259 6.63577 10.1513 6.78354C10.4361 6.88016 10.721 6.88016 11.0115 6.78354C11.7977 6.51641 12.584 6.23791 13.3816 6.01057C15.461 5.41947 17.8652 6.18676 19.1756 7.84069C19.2268 7.9089 19.2781 7.9771 19.3237 8.0453C15.7858 10.0005 15.9567 15.2237 19.9333 17.0027Z" fill="black"/>
                                                                <path d="M15.1534 0.474077C15.273 1.69606 14.9369 2.75889 14.2304 3.71374C13.5126 4.67427 12.6409 5.43588 11.4331 5.71438C11.2565 5.75416 11.0799 5.77121 10.8976 5.78826C10.4817 5.82805 10.4304 5.78827 10.4418 5.37904C10.4646 4.57197 10.6811 3.81605 11.0856 3.12265C11.9686 1.6108 13.3018 0.758258 15.0166 0.479761C15.0565 0.468394 15.0907 0.474077 15.1534 0.474077Z" fill="black"/>
                                                                </g>
                                                                <defs>
                                                                <clipPath id="clip0_393_2077">
                                                                <rect width="19" height="22.5185" fill="white" transform="translate(0.93335 0.474609)"/>
                                                                </clipPath>
                                                                </defs>
                                                                </svg>
                                                                
                                                            Apple Pay</label>
                                                    </div>
                                                    <div class="customRadio clearfix me-3 mb-0 w-100 mb-3">
                                                        <input name="mr" id="dsd" value="0" type="radio" class="padding-10px-right">
                                                        <label for="dsd" class="mb-0">
                                                            <svg class="me-2" width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M4.29191 12.2191L3.63717 14.6971L1.24454 14.7487C0.520723 13.382 0.136149 11.8571 0.124073 10.3059C0.111997 8.75468 0.472783 7.22383 1.17524 5.8457L3.30537 6.24189L4.23883 8.38878C3.81917 9.63363 3.83793 10.9874 4.29191 12.2198V12.2191Z" fill="#FBBB00"/>
                                                                <path d="M18.7678 8.44922C19.087 10.1493 18.9435 11.9053 18.3528 13.5289C17.7622 15.1526 16.7467 16.5826 15.4152 17.6654L12.7321 17.5264L12.3524 15.1231C13.4606 14.4647 14.3121 13.4402 14.7642 12.2212H9.7356V8.44922H18.7686H18.7678Z" fill="#518EF8"/>
                                                                <path d="M15.4153 17.6649C14.3392 18.5405 13.0863 19.1654 11.7454 19.4952C10.4045 19.8251 9.00841 19.8519 7.65616 19.5737C6.3039 19.2955 5.02857 18.7191 3.92055 17.8854C2.81254 17.0517 1.89898 15.9812 1.24463 14.7496L4.292 12.2207C4.57819 12.994 5.02754 13.6945 5.60861 14.2734C6.18969 14.8522 6.88848 15.2954 7.65611 15.5719C8.42374 15.8485 9.24168 15.9517 10.0528 15.8743C10.8638 15.7969 11.6484 15.5409 12.3517 15.1241L15.4153 17.6649Z" fill="#28B446"/>
                                                                <path d="M15.531 2.89089L12.4844 5.41976C11.7707 4.96918 10.9659 4.68756 10.13 4.59583C9.29409 4.50411 8.44853 4.60465 7.65624 4.88998C6.86395 5.1753 6.14531 5.63807 5.55378 6.24385C4.96225 6.84963 4.51305 7.58284 4.23962 8.38892L1.17603 5.84734C1.82228 4.58245 2.73984 3.48041 3.8613 2.62219C4.98276 1.76397 6.27962 1.17137 7.6566 0.887937C9.03359 0.604501 10.4557 0.637426 11.8185 0.984293C13.1813 1.33116 14.4501 1.98316 15.5318 2.89238L15.531 2.89089Z" fill="#F14336"/>
                                                                </svg>
                                                                
                                                            Google Pay</label>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                        </div>
                                        <div class="order-button-payment mt-3 clearfix">
                                            <form id="checkoutFormpage"  action="{{ route('placeorder') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="address_id" id="address_id" value="{{ old('address_id') }}">
                                                <button type="button"  id="checkoutpayment" class="fs-6 btn btn-lg rounded w-100 fw-600 text-white">
                                                    Pay Now
                                                </button>
                                            </form>
                                           
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