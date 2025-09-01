@extends('front_end.template.layout')
@section('content')
     <!--Body Container-->
     <div id="page-content">  
                <!--Collection Banner-->
                <div class="collection-header">
                    <div class="collection-hero">
                        <div class="collection-hero__image"></div>
                        <div class="collection-hero__title-wrapper container">
                            <h1 class="collection-hero__title">Cart</h1>
                            <div class="breadcrumbs text-uppercase mt-1 mt-lg-2"><a href="{{ route('home') }}" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">Cart</span></div>
                        </div>
                    </div>
                </div>
                <!--End Collection Banner-->

                <!--Main Content-->
                <div class="container">
                    <!--Cart Page-->
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 main-col">
                        
                        @if($cart->isEmpty())
                            <div class="alert alert-warning text-center" role="alert">
                                <i class="align-middle icon an an-cart icon-large me-2"></i><strong>No items in the cart.</strong>
                            </div>
                        @else
                            <div class="alert alert-success py-2 rounded-1 alert-dismissible fade show cart-alert" role="alert">
                                <i class="align-middle icon an an-truck icon-large me-2"></i><strong class="text-uppercase">Congratulations!</strong> You've got free shipping!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>

                            <form action="#" method="post" class="cart style1">
                                <table>
                                    <thead class="cart__row cart__header small--hide">
                                        <tr>
                                            <th class="action">&nbsp;</th>
                                            <th colspan="2" class="text-start">Product</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cart-items-list-cartpage">
                                        @foreach($cart as $item)
                                            <tr class="cart__row border-bottom line1 cart-flex border-top">
                                                <td class="cart-delete text-center small--hide">
                                                    <a href="javascript:void(0);" data-id="{{ $item['id'] }}" class="btn btn--secondary cart__remove remove-icon position-static" title="Remove item">
                                                        <i class="icon an an-times-r"></i>
                                                    </a>
                                                </td>
                                                <td class="cart__image-wrapper cart-flex-item">
                                                    <a href="#"><img class="cart__image blur-up lazyload" src="{{ $item['image'] }}" alt="{{ $item['name'] }}" width="80" /></a>
                                                </td>
                                                <td class="cart__meta small--text-left cart-flex-item">
                                                    <div class="list-view-item__title">
                                                        {{ $item['name'] }}
                                                    </div>
                                                    <div class="variant-cart">{{$item['color_text']}} {{$item['size_text']}}</div>
                                                    <!-- <div class="cart__meta-text">
                                                        {{ $item['description'] ?? '' }}
                                                        @if(!empty($item['customer_notes']))
                                                            <div class="mt-2 text-muted small">
                                                                <strong>Note:</strong> {{ $item['customer_notes'] }}
                                                            </div>
                                                        @endif

                                                        @if(!empty($item['customer_file']))
                                                            <div class="mt-1 small">
                                                                <strong>File:</strong> 
                                                                @php
                                                                    $ext = pathinfo($item['customer_file'], PATHINFO_EXTENSION);
                                                                    $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                                                @endphp
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

                                                    </div> -->
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
                                                <td class="cart__price-wrapper cart-flex-item text-center small--hide">
                                                    <span class="money">AED {{ number_format($item['price'], 2) }}</span>
                                                </td>
                                                <td class="cart__update-wrapper cart-flex-item text-end text-md-center">
                                                    <div class="cart__qty d-flex justify-content-end justify-content-md-center">
                                                        <div class="qtyField">
                                                            <a class="qtyBtn minus" href="javascript:void(0);" data-id="{{ $item['id'] }}"><i class="icon an an-minus-r"></i></a>
                                                            <input class="cart__qty-input qty" type="text" name="updates[]" value="{{ $item['quantity'] }}" pattern="[0-9]*" readonly />
                                                            <a class="qtyBtn plus" href="javascript:void(0);" data-id="{{ $item['id'] }}"><i class="icon an an-plus-r"></i></a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="cart-price cart-flex-item text-center small--hide">
                                                    <span class="money fw-500">AED {{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-start pt-3"><a href="#" class="btn btn--link d-inline-flex align-items-center btn--small p-0 cart-continue"><i class="me-1 icon an an-angle-left-l"></i><span class="text-decoration-underline">Continue shopping</span></a></td>
                                            <td colspan="3" class="text-end pt-3">
                                                <button type="button" name="clear-cart" id="clear-cart" class="btn btn--link d-inline-flex align-items-center btn--small small--hide"><i class="me-1 icon an an-times-r"></i><span class="ms-1 text-decoration-underline">Clear Shoping Cart</span></button>
                                                <button type="submit" name="update" class="btn btn--small d-inline-flex align-items-center rounded cart-continue ml-2"><i class="me-1 icon an an-sync-ar d-none"></i>Update Cart</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table> 
                            </form>                   
                        </div>
                        @endif
                    </div>
                    @if($cart->isNotEmpty())
                    <div class="row mt-2">
                      
                        <div class="col-12 col-sm-12 col-md-12 col-lg-8 cart__footer"></div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-4 cart__footer">
                            <div class="solid-border">	
                                <div class="row border-bottom pb-2">
                                    <span class="col-6 col-sm-6 cart__subtotal-title">Subtotal</span>
                                    <span class="col-6 col-sm-6 text-right"><span class="money" id="cart-totalcartpage">AED {{ number_format($subtotal, 2) }}</span></span>
                                </div>
                                <div class="row border-bottom pb-2 pt-2">
                                    <span class="col-6 col-sm-6 cart__subtotal-title">Tax</span>
                                    <span class="col-6 col-sm-6 text-right"  id="cart-taxcartpage">AED {{ number_format($totalTax, 2) }}</span>
                                </div>
                                <div class="row border-bottom pb-2 pt-2">
                                    <span class="col-6 col-sm-6 cart__subtotal-title">Shipping</span>
                                    <span class="col-6 col-sm-6 text-right" id="cart-shippingcartpage">AED {{ number_format($shipping, 2) }}</span>
                                </div>
                                <div class="row border-bottom pb-2 pt-2">
                                    <span class="col-6 col-sm-6 cart__subtotal-title"><strong>Grand Total</strong></span>
                                    <span class="col-6 col-sm-6 cart__subtotal-title cart__subtotal text-right" id="cart-grandcartpage"><span class="money">AED {{ number_format($grand_total, 2) }}</span></span>
                                </div>
                                <p class="cart__shipping m-0">Shipping &amp; taxes calculated at checkout</p>
                                <p class="cart__shipping pt-0 m-0 fst-normal freeShipclaim"><i class="me-1 align-middle icon an an-truck-l"></i><b>FREE SHIPPING</b> ELIGIBLE</p>
                                <div class="customCheckbox cart_tearm">
                                    <input type="checkbox" value="allen-vela" id="cart_tearm" checked>
                                    <label for="cart_tearm">I agree with the terms and conditions</label>
                                </div>
                                @if (Auth::check())
                                    <!-- User is logged in, show "Proceed to Checkout" button -->
                                    <a href="{{ route('checkout') }}" id="cartCheckout" class="btn btn--small-wide rounded mt-4 checkout">Proceed To Checkout</a>
                                @else
                                    <!-- User is not logged in, show "Login" button -->
                                    <a href="{{ route('login') }}" class="btn btn--small-wide rounded mt-4 checkout">Login</a>
                                @endif

                                <!-- <a href="#" id="cartCheckout" class="btn btn--small-wide rounded mt-4 checkout">Proceed To Checkout</a> -->
                                <!-- <div class="paymnet-img"><img src="assets/images/payment-img.jpg" alt="Payment" /></div> -->
                                <!-- <p class="mt-2"><a href="#">Checkout with Multiple Addresses</a></p> -->
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!--End Cart Page-->
                </div>
                <!--End Main Content-->
            </div>
            <!--End Body Container-->
@endsection 