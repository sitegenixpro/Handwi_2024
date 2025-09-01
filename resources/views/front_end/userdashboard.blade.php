@extends('front_end.template.layout')
@section('content')
 <!--Body Container-->
 <div id="page-content">
                <!--Collection Banner-->
                <div class="collection-header">
                    <div class="collection-hero">
                        <div class="collection-hero__image"></div>
                        <div class="collection-hero__title-wrapper container">
                            <h1 class="collection-hero__title">My Account</h1>
                            <div class="breadcrumbs text-uppercase mt-1 mt-lg-2"><a href="{{ route('home') }}" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">My Account</span></div>
                        </div>
                    </div>
                </div>
                <!--End Collection Banner-->

                <!--Container-->
                <div class="container pt-2">
                    <!--Main Content-->
                    <div class="dashboard-upper-info">
                        <div class="row align-items-center g-0">
                            <div class="col-xl-3 col-lg-3 col-sm-6">
                                <div class="d-single-info">
                                    <p class="user-name">Hello <span class="fw-600">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span></p>
                                    <p>(not {{ Auth::user()->first_name }}? <a class="link-underline fw-600" href="{{ route('logoutuser') }}">Log Out</a>)</p>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-sm-6">
                                <div class="d-single-info">
                                    <p>Need Assistance? Customer service at.</p>
                                    <p><a href="mailto:info@handwi.com">info@handwi.com</a></p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-sm-6">
                                <div class="d-single-info">
                                    <p>E-mail them at </p>
                                    <p><a href="mailto:info@handwi.com">info@handwi.com</a></p>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-sm-6">
                                <div class="d-single-info text-lg-center">
                                    <a class="link-underline fw-600 view-cart" href="{{ route('cart') }}"><i class="icon an an-sq-bag me-2"></i>View Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4 mb-lg-5 pb-lg-5">
                        <div class="col-xl-3 col-lg-2 col-md-12 mb-4 mb-lg-0">
                            <!-- Nav tabs -->
                            <ul class="nav flex-column bg-light h-100 dashboard-list" role="tablist">
                                <li><a class="nav-link active" data-bs-toggle="tab" href="#dashboard">Dashboard</a></li>
                                <li><a class="nav-link" data-bs-toggle="tab" href="#orders">My Orders</a></li>
                                <li><a class="nav-link" data-bs-toggle="tab" href="#booking">My Bookings</a></li>
                                 <li><a class="nav-link" data-bs-toggle="tab" href="#messages">My Messages</a></li>
                                <!-- <li><a class="nav-link" data-bs-toggle="tab" href="#orderstracking">Orders tracking</a></li> -->
                                <li><a class="nav-link" data-bs-toggle="tab" href="#downloads">Change Password</a></li>
                                <li><a class="nav-link" data-bs-toggle="tab" href="#address">Saved Address</a></li>
                                <li><a class="nav-link" data-bs-toggle="tab" href="#account-details">My Profile</a></li>
                                <li><a class="nav-link" data-bs-toggle="tab" href="#wishlist">Wishlist</a></li>
                                <li><a class="nav-link" href="{{route('logoutuser')}}">logout</a></li>
                            </ul>
                            <!-- End Nav tabs -->
                        </div>

                        <div class="col-xl-9 col-lg-10 col-md-12">
                            <!-- Tab panes -->
                            <div class="tab-content dashboard-content">
                                <!-- Dashboard -->
                                <div id="dashboard" class="tab-pane fade active show">
                                    <h3>Dashboard </h3>
                                    <p>From your account dashboard. you can easily check &amp; view your
                                        recent orders, manage your
                                       shipping and billing addresses and
                                        edit your password and account details.
                                    </p>
                                    <div class="row user-profile mt-4">
                                        <div class="col-12 col-lg-6">
                                            <div class="profile-img">
                                                @php
                                                $user_image=get_uploaded_image_url(Auth::user()->user_image,'user_image_upload_dir');
                                                @endphp
                                                <div class="img"><img src="{{$user_image }}" alt="profile" width="65" /></div>
                                                <div class="detail ms-3">
                                                    <h5 class="mb-1">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h5>
                                                    <p>{{ Auth::user()->email }}</p>
                                                </div>
                                                <!-- <div class="lbl">SILVER USER</div> -->
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <ul class="profile-order mt-3 mt-lg-0">
                                                <li>
                                                    <h3 class="mb-1">{{$orders->count()}}</h3>
                                                    All Orders
                                                </li>
                                                <!--<li>-->
                                                <!--    <h3 class="mb-1">02</h3>-->
                                                <!--    Awaiting Payments-->
                                                <!--</li>-->
                                                <!--<li>-->
                                                <!--    <h3 class="mb-1">00</h3>-->
                                                <!--    Awaiting Shipment-->
                                                <!--</li>-->
                                                <!--<li>-->
                                                <!--    <h3 class="mb-1">01</h3>-->
                                                <!--    Awaiting Delivery-->
                                                <!--</li>-->
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="table-responsive order-table mt-4">
                                       <table class="table table-bordered table-hover align-middle text-center mb-0">
                                            <thead class="alt-font">
                                                <tr>
                                                    <th>Order</th>
                                                   
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Total</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($orders as $order)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    
                                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                                                    <td class="text-success">{{ order_status($order->status) }}</td>
                                                    <td>AED {{$order->grand_total}} </td>
                                                    <td>
                                                         <a class="link-underline view" href="{{url('/order_details/')}}/{{ $order->order_id}}" onclick="">View</a>
                                                        <!--<a class="link-underline view" href="javascript:void(0)" onclick="viewOrderDetails({{ json_encode($order) }})">View</a>-->
                                                    </td>
                                                </tr>
                                            @endforeach
                                              
                                               
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- End Dashboard -->

                                <!-- Orders -->
                                <div id="orders" class="product-order tab-pane fade">
                                    <h3>My Orders</h3>
                                    <div class="table-responsive order-table" id="orderList">
                                        <table class="table table-bordered table-hover align-middle text-center mb-0">
                                            <thead class="alt-font">
                                                <tr>
                                                    <th>Order</th>
                                                   
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Total</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($orders as $order)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    
                                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                                                    <td class="text-success">{{ order_status($order->status) }}</td>
                                                    <td>AED {{$order->grand_total}} </td>
                                                    <td>
                                                         <a class="link-underline view" href="{{url('/order_details/')}}/{{ $order->order_id}}" onclick="">View</a>
                                                        <!--<a class="link-underline view" href="javascript:void(0)" onclick="viewOrderDetails({{ json_encode($order) }})">View</a>-->
                                                    </td>
                                                </tr>
                                            @endforeach
                                              
                                               
                                            </tbody>
                                        </table>
                                    </div>

                                    <div id="orders-details" style="display: none;">
                                        <div class="row mt-2">
                                            <div class="col-sm-12 position-relative">
                                                <h3>Order no: #<span id="order-id"></span></h3>
                                                <a href="javascript:void(0)" onclick="closeOrderDetails()" class="position-absolute" style="right: 20px;top: -15px;">
                                                    <svg width="24" height="20" viewBox="0 0 24 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M19.5 0H4.5C2.019 0 0 2.019 0 4.5V15.5C0 17.981 2.019 20 4.5 20H19.5C21.981 20 24 17.981 24 15.5V4.5C24 2.019 21.981 0 19.5 0ZM23 15.5C23 17.43 21.43 19 19.5 19H4.5C2.57 19 1 17.43 1 15.5V4.5C1 2.57 2.57 1 4.5 1H19.5C21.43 1 23 2.57 23 4.5V15.5ZM15.854 6.854L12.708 10L15.854 13.146C16.049 13.341 16.049 13.658 15.854 13.853C15.756 13.951 15.628 13.999 15.5 13.999C15.372 13.999 15.244 13.95 15.146 13.853L12 10.707L8.854 13.853C8.756 13.951 8.628 13.999 8.5 13.999C8.372 13.999 8.244 13.95 8.146 13.853C7.951 13.658 7.951 13.341 8.146 13.146L11.292 10L8.146 6.854C7.951 6.659 7.951 6.342 8.146 6.147C8.341 5.952 8.658 5.952 8.853 6.147L11.999 9.293L15.145 6.147C15.34 5.952 15.657 5.952 15.852 6.147C16.047 6.342 16.047 6.659 15.852 6.854H15.854Z" fill="black"/>
                                                    </svg>
                                                </a>
                                                <!-- Status Order -->
                                                <div class="row mt-3">
                                                    <div class="col-lg-6 col-md-9 col-sm-8">
                                                        <div class="tracking-detail d-flex-center">
                                                            <ul>
                                                                <li>
                                                                    <div class="left"><span>Order no</span></div>
                                                                    <div class="right"><span >#<span id="order-id1"></span></span></div>
                                                                </li>
                                                                <li>
                                                                    <div class="left"><span>Status</span></div>
                                                                    <div class="right"><span id="order-status">Pending</span></div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-9 col-sm-8">
                                                        <div class="tracking-detail d-flex-center">
                                                            <ul>
                                                                <li>
                                                                    <div class="left"><span>order date</span></div>
                                                                    <div class="right"><span id="order-date">12 June 2024 05:00 PM</span></div>
                                                                </li>
                                                                <li>
                                                                    <div class="left"><span>Total Amount</span></div>
                                                                    <div class="right"><span id="total-amount">120.99 AED</span></div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                   
                                                </div>
                                                
                                                <hr>
                                                <div class="row product-list-orderlist">
                                                    
                                                <h3>Order Summery</h3>
                                                   <div id="product-list"></div>
                                                </div>
                                                <!-- End Status Order -->
                                                <div class="table-responsive order-table style2"> 
                                                    <table class="bg-white table table-bordered align-middle table-hover text-center mb-1">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="2" class="text-start">Price Details</th>
                                                            </tr>
                                                        </thead>
                                                        <tfoot class="font-weight-600">
                                                            <tr>
                                                                <td style="width: 80%;" class="text-end fw-bolder">Sub Total </td>
                                                                <td class="fw-bolder" id="sub-total">AED 50.00</td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <td style="width: 80%;" class="text-end fw-bolder">Tax </td>
                                                                <td class="fw-bolder"  id="tax">AED 50.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 80%;" class="text-end fw-bolder">Grand Total</td>
                                                                <td class="fw-bolder" id="grand-total">AED 855.00</td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Orders -->

                                <script>
                                    function viewOrderDetails(order){
                                        console.log(order);
                                        var orderDetailsDiv = document.getElementById("orders-details");
                                        var oList = document.getElementById("orderList");
                                        if (orderDetailsDiv.style.display === "none") {
                                            orderDetailsDiv.style.display = "block";
                                            oList.style.display = "none";
                                        } else {
                                            orderDetailsDiv.style.display = "none";
                                            oList.style.display = "block";
                                        }

                                        document.getElementById("order-id").textContent = order.order_number;
                                        document.getElementById("order-id1").textContent = order.order_number;
                                        var orderStatusText = '';
                                        switch (order.status) {
                                            case 1:
                                                orderStatusText = 'Accepted';
                                                break;
                                            case 2:
                                                orderStatusText = 'Ready for Delivery ';
                                                break;
                                            case 3:
                                                orderStatusText = 'Dispatched';
                                                break;
                                            case 4:
                                                orderStatusText = 'Delivered';
                                                break;
                                            case 10:
                                                orderStatusText = 'Cancelled';
                                                break;
                                            default:
                                                orderStatusText = 'Unknown Status';
                                                break;
                                        }
                                        document.getElementById("order-status").textContent = orderStatusText; // Update status accordingly
                                        document.getElementById("order-date").textContent = new Date(order.created_at).toLocaleString(); // Format order date
                                        document.getElementById("total-amount").textContent = `${order.grand_total} AED`;
                                        

                                        // Populate products in the order
                                        var productList = document.getElementById("product-list");
                                        productList.innerHTML = ''; // Clear any existing content

                                        order.products.forEach(function(product, index) {
                                            var imagePath = getImagePath(product.image);
                                            var productHTML = `
                                                <div class="col-lg-6">
                                                    <div class="row produt-itm">
                                                        <div class="col-lg-4 col-md-3 col-sm-4">
                                                            <div class="product-img mb-3 mb-sm-0">
                                                                <img class="blur-up lazyload" src="${imagePath || 'default-product-image.jpg'}" alt="${product.product_name}" title="">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-9 col-sm-8">
                                                            <div class="tracking-detail d-flex-center">
                                                                <ul>
                                                                    <li class="flex-wrap">
                                                                        <div><span id="product-name-${index}">${product.product_name}</span></div>
                                                                    </li>
                                                                    <li class="flex-wrap">
                                                                        <div><span id="product-description-${index}">${product.product_description}</span></div>
                                                                    </li>
                                                                    <li class="flex-wrap">
                                                                        <div><span id="product-quantity-${index}">${product.quantity}</span> x <span id="product-price-${index}">${product.sale_price} AED</span></div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            `;
                                            productList.innerHTML += productHTML;
                                        });

                                        // Price details
                                        document.getElementById("sub-total").textContent = `${order.total} AED`;

                                        document.getElementById("tax").textContent = `${order.vat} AED`;
                                        document.getElementById("grand-total").textContent = `${order.grand_total} AED`;
                                    }
                                    function getImagePath(image) {
                                        // Check if the image string contains a comma
                                        var imageArray = image.split(',');

                                        // Get the first image path
                                        var imagePath = "{{ asset('uploads/products/') }}/" + imageArray[0];

                                        return imagePath;
                                    }
                                    
                                    function closeOrderDetails(){
                                        var orderDetailsDiv = document.getElementById("orders-details");
                                        var oList = document.getElementById("orderList");
                                        if (orderDetailsDiv.style.display === "none") {
                                            orderDetailsDiv.style.display = "block";
                                            oList.style.display = "none";
                                        } else {
                                            orderDetailsDiv.style.display = "none";
                                            oList.style.display = "block";
                                        }
                                    }
                                </script>

                                <!-- Orders -->
                                <div id="booking" class="product-order tab-pane fade">
                                    <h3>My Bookings</h3>
                                    <div class="table-responsive order-table"  id="bookingList">
                                        <table class="table table-bordered table-hover align-middle text-center mb-0">
                                            <thead class="alt-font">
                                                <tr>
                                                    <th>Order</th>
                                                    <th>Workshop</th>
                                                    <th>Date</th>
                                                    <th>Seats</th>
                                                    <th>Total</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($bookings as $booking)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $booking->name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->from_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->to_date)->format('d M Y') }}</td>
                                                    <td class="text-danger">{{ $booking->number_of_seats }}</td>
                                                    <td> {{ $booking->grand_total }} for {{ $booking->number_of_seats }} seats </td>
                                                    <td><a class="link-underline view" onclick="viewbookingDetails({{ json_encode($booking) }})" href="javascript:void(0)">View</a></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    

                                    <div id="booking-details" style="display: none;">
                                        <div class="row mt-2">
                                            <div class="col-sm-12 position-relative">
                                                <h3>Booking no: #<span id="booking-number"></span></h3>
                                                <a href="javascript:void(0)" onclick="closebookingDetails()" class="position-absolute" style="right: 20px;top: -15px;">
                                                    <svg width="24" height="20" viewBox="0 0 24 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M19.5 0H4.5C2.019 0 0 2.019 0 4.5V15.5C0 17.981 2.019 20 4.5 20H19.5C21.981 20 24 17.981 24 15.5V4.5C24 2.019 21.981 0 19.5 0ZM23 15.5C23 17.43 21.43 19 19.5 19H4.5C2.57 19 1 17.43 1 15.5V4.5C1 2.57 2.57 1 4.5 1H19.5C21.43 1 23 2.57 23 4.5V15.5ZM15.854 6.854L12.708 10L15.854 13.146C16.049 13.341 16.049 13.658 15.854 13.853C15.756 13.951 15.628 13.999 15.5 13.999C15.372 13.999 15.244 13.95 15.146 13.853L12 10.707L8.854 13.853C8.756 13.951 8.628 13.999 8.5 13.999C8.372 13.999 8.244 13.95 8.146 13.853C7.951 13.658 7.951 13.341 8.146 13.146L11.292 10L8.146 6.854C7.951 6.659 7.951 6.342 8.146 6.147C8.341 5.952 8.658 5.952 8.853 6.147L11.999 9.293L15.145 6.147C15.34 5.952 15.657 5.952 15.852 6.147C16.047 6.342 16.047 6.659 15.852 6.854H15.854Z" fill="black"/>
                                                    </svg>
                                                </a>
                                                <!-- Status Order -->
                                                <div class="row mt-3">
                                                    <div class="col-lg-6 col-md-9 col-sm-8">
                                                        <div class="tracking-detail d-flex-center">
                                                            <ul>
                                                                <li>
                                                                    <div class="left"><span>Booking no</span></div>
                                                                    <div class="right">#<span id="booking-no">12250850453</span></div>
                                                                </li>
                                                                <li>
                                                                    <div class="left"><span>Seats</span></div>
                                                                    <div class="right"><span id="booking-number-of-seats"></span></div>
                                                                </li>
                                                                
                                                                <li>
                                                                    <div class="left"><span>Workshop date</span></div>
                                                                    <div class="right"><span class="wok-badge-tag" id="booking-workshop-date">10 July 2024 - 01:00 PM - 03:00 PM</span></div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-9 col-sm-8">
                                                        <div class="tracking-detail d-flex-center">
                                                            <ul>
                                                                <li>
                                                                    <div class="left"><span>order date</span></div>
                                                                    <div class="right"><span id="booking-order-date">12 June 2024 05:00 PM</span></div>
                                                                </li>
                                                                <li>
                                                                    <div class="left"><span>Total Amount</span></div>
                                                                    <div class="right"><span id="total-amount-workshop">120.99 </span></div>
                                                                </li>
                                                                <li>
                                                                    <div class="left" ><span>Seats</span></div>
                                                                    <div class="right"><span><b id="booking-seats">A2, A3</b> </span></div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-lg-12">
                                                        <div class="tracking-detail d-flex-center">
                                                            <ul>
                                                                <li>
                                                                    <div class="left"><span>shipping address</span></div>
                                                                    <div class="right"><span><b>John Doe</b> 55 Gallaxy Enque, 2568 steet, 23568 NY</span></div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div> -->
                                                </div>
                                                <hr>
                                                <div class="row product-list-orderlist">
                                                    <div class="col-lg-6">                                                    
                                                        <h3>Workshop Summery</h3>
                                                        <div class="row produt-itm">
                                                            <div class="col-lg-4 col-md-3 col-sm-4">
                                                                <div class="product-img mb-3 mb-sm-0">
                                                                    <img class="blur-up lazyload" id="booking-workshop-image" data-src="assets/images/98.jpg" src="assets/images/98.jpg" alt="product" title="">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-8 col-md-9 col-sm-8">
                                                                <div class="tracking-detail d-flex-center">
                                                                    <ul>
                                                                        <li class="flex-wrap">
                                                                            <!-- <div class="w-100"><span>Order name</span></div> -->
                                                                            <div class=""><span id="booking-workshop-name">Pottery Workshop</span></div>
                                                                        </li>
                                                                        <li class="flex-wrap">
                                                                            <!-- <div class="w-100"><span>customer number</span></div> -->
                                                                            <div class=""><span><b id="booking-workshop-location">Downtown, Dubai</b></span></div>
                                                                        </li>
                                                                        <li class="flex-wrap">
                                                                            <!-- <div class="w-100"><span>Total Amount</span></div> -->
                                                                            <div class=""><span><b id="booking-workshop-amount">120.99 AED</b></span></div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-lg-6">
                                                        <p id="booking-workshop-address">SM RESIDENCE- MEYDAN AVENNUE OPPISITE MEYDAN HOTEL - Dubai - United Arab Emirates</p>
                                                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7223.6798632737955!2d55.264753027620934!3d25.1411019361727!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f69c089a656b7%3A0xcb7380de46d9763a!2sRACECOURSE%20400KV%20SUBSTATION!5e0!3m2!1sen!2sin!4v1719983494002!5m2!1sen!2sin" width="100%" height="150" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>    
                                                    </div>

                                                </div>
                                                <!-- End Status Order -->
                                                <div class="table-responsive order-table style2"> 
                                                    <table class="bg-white table table-bordered align-middle table-hover text-center mb-1">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="2" class="text-start">Price Details</th>
                                                            </tr>
                                                        </thead>
                                                        <tfoot class="font-weight-600">
                                                            <tr>
                                                                <td style="width: 80%;" class="text-end fw-bolder">Sub Total </td>
                                                                <td class="fw-bolder" id="booking-sub-total">AED 50.00</td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <td style="width: 80%;" class="text-end fw-bolder">Tax </td>
                                                                <td class="fw-bolder" id="booking-tax-amount">AED 50.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 80%;" class="text-end fw-bolder">Grand Total</td>
                                                                <td class="fw-bolder" id="booking-grand-total">AED 855.00</td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div id="messages" class="product-order tab-pane fade">
                                    <h3>My Messages</h3>
                                    <div class="table-responsive order-table" id="messageList">
                                        <table class="table table-bordered table-hover align-middle text-center mb-0">
                                            <thead class="alt-font">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Store Name</th>
                                                    <th>Subject</th>
                                                    <th>Message</th>
                                                    <th>Sent At</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($messages as $msg)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ ($msg->vendor->first_name ?? '') . ' ' . ($msg->vendor->last_name ?? '') }}</td>
                                                    <td>{{ $msg->subject }}</td>
                                                    <td>{{ \Illuminate\Support\Str::limit($msg->message, 30) }}</td>
                                                    <td>{{ $msg->created_at->format('d M Y') }}</td>
                                                    <td>
                                                        <a class="link-underline view" onclick="viewMessageDetails({{ json_encode($msg) }})" href="javascript:void(0)">View</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                
                                    <div id="message-details" style="display: none;">
                                        <div class="row mt-2">
                                            <div class="col-sm-12 position-relative">
                                                <h3>Message from: <span id="message-store-name"></span></h3>
                                                <a href="javascript:void(0)" onclick="closeMessageDetails()" class="position-absolute" style="right: 20px;top: -15px;">
                                                    <svg width="24" height="20" viewBox="0 0 24 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M19.5 0H4.5C2.019 0 0 2.019 0 4.5V15.5C0 17.981 2.019 20 4.5 20H19.5C21.981 20 24 17.981 24 15.5V4.5C24 2.019 21.981 0 19.5 0ZM23 15.5C23 17.43 21.43 19 19.5 19H4.5C2.57 19 1 17.43 1 15.5V4.5C1 2.57 2.57 1 4.5 1H19.5C21.43 1 23 2.57 23 4.5V15.5ZM15.854 6.854L12.708 10L15.854 13.146C16.049 13.341 16.049 13.658 15.854 13.853C15.756 13.951 15.628 13.999 15.5 13.999C15.372 13.999 15.244 13.95 15.146 13.853L12 10.707L8.854 13.853C8.756 13.951 8.628 13.999 8.5 13.999C8.372 13.999 8.244 13.95 8.146 13.853C7.951 13.658 7.951 13.341 8.146 13.146L11.292 10L8.146 6.854C7.951 6.659 7.951 6.342 8.146 6.147C8.341 5.952 8.658 5.952 8.853 6.147L11.999 9.293L15.145 6.147C15.34 5.952 15.657 5.952 15.852 6.147C16.047 6.342 16.047 6.659 15.852 6.854H15.854Z" fill="black"/>
                                                    </svg>
                                                </a>
                                
                                                <div class="row mt-3">
                                                    <div class="col-lg-6 col-md-9 col-sm-8">
                                                        <div class="tracking-detail d-flex-center">
                                                            <ul>
                                                                <li>
                                                                    <div class="left"><span>Store Name</span></div>
                                                                    <div class="right"><span id="message-vendor-name"></span></div>
                                                                </li>
                                                                <li>
                                                                    <div class="left"><span>Subject</span></div>
                                                                    <div class="right"><span id="message-subject"></span></div>
                                                                </li>
                                                                <li>
                                                                    <div class="left"><span>Date Sent</span></div>
                                                                    <div class="right"><span id="message-sent-at"></span></div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                
                                                    <div class="col-lg-6 col-md-9 col-sm-8">
                                                        <div class="tracking-detail d-flex-center">
                                                            <ul>
                                                                <li>
                                                                    <div class="left"><span>Sender Name</span></div>
                                                                    <div class="right"><span id="message-sender-name"></span></div>
                                                                </li>
                                                                <li>
                                                                    <div class="left"><span>Sender Email</span></div>
                                                                    <div class="right"><span id="message-sender-email"></span></div>
                                                                </li>
                                                                <li>
                                                                    <div class="left"><span>Sender Phone</span></div>
                                                                    <div class="right"><span id="message-sender-phone"></span></div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                
                                                <hr>
                                
                                                <div class="row product-list-orderlist">
                                                    <div class="col-lg-12">
                                                        <h3>Full Message</h3>
                                                        <p id="message-full-text" class="mt-2"></p>
                                                    </div>
                                                </div>
                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- End Orders -->

                                

                                <script>
                                    function viewbookingDetails(booking){
                                        var subtotal = booking.service_price * booking.number_of_seats;
                                        document.querySelector('#booking-number').textContent = `${booking.order_number}`;
                                        document.querySelector('#booking-no').textContent = `${booking.order_number}`;
                                        document.querySelector('#total-amount-workshop').textContent = `${booking.grand_total} AED`;
                                        document.querySelector('#booking-seats').textContent = `${booking.seat_no}`;
                                        document.querySelector('#booking-workshop-name').textContent = `${booking.name}`;
                                        document.querySelector('#booking-workshop-location').textContent = `${booking.location}`;
                                        document.querySelector('#booking-workshop-amount').textContent = `${booking.service_price}`;
                                        document.querySelector('#booking-workshop-address').textContent = `${booking.location}`;
                                        document.querySelector('#booking-grand-total').textContent = `AED ${booking.grand_total}`;
                                        document.querySelector('#booking-tax-amount').textContent = `AED ${booking.tax}`;
                                        document.querySelector('#booking-sub-total').textContent = `AED ${subtotal}`;
                                        document.querySelector('#booking-number-of-seats').textContent = `${booking.number_of_seats}`;
                                        var imagePath = "{{ asset('storage/uploads/service/') }}/" + booking.image;
                                        $('#booking-workshop-image').attr('data-src', imagePath).attr('src', imagePath);
                                        var fromDate = new Date(booking.from_date); 
                                        var toDate = new Date(booking.to_date);     
                                        var fromTime = booking.from_time;          
                                        var toTime = booking.to_time;              

                                        var fromDateFormatted = fromDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                                        var toDateFormatted = toDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                                        var formattedDateTime = `${fromDateFormatted} - ${toDateFormatted} - ${fromTime} - ${toTime}`;
                                        $('#booking-workshop-date').text(formattedDateTime);

                                        var orderDate = booking.order_date; 

                                        
                                        let formattedDate = new Date(orderDate).toLocaleString('en-US', {day: '2-digit',month: 'long', year: 'numeric',hour: '2-digit',minute: '2-digit', hour12: true});

                                        
                                        $('#booking-order-date').text(formattedDate);
                                        

                                        

                                        

                                        

                                        
                                        

                                        

                                        

                                        


                                        
                                        
                                        
                                        // document.querySelector('#booking-details .status span').textContent = booking.status;
                                        // document.querySelector('#booking-details .workshop-date span').textContent = `${booking.from_date} - ${booking.to_date}`;
                                        // document.querySelector('#booking-details .total-amount span').textContent = `AED ${booking.grand_total}`;
                                        // document.querySelector('#booking-details .seats span').textContent = booking.number_of_seats;
                                        var orderDetailsDiv = document.getElementById("booking-details");
                                        var oList = document.getElementById("bookingList");
                                        if (orderDetailsDiv.style.display === "none") {
                                            orderDetailsDiv.style.display = "block";
                                            oList.style.display = "none";
                                        } else {
                                            orderDetailsDiv.style.display = "none";
                                            oList.style.display = "block";
                                        }
                                    }
                                    
                                    function closebookingDetails(){
                                        var orderDetailsDiv = document.getElementById("booking-details");
                                        var oList = document.getElementById("bookingList");
                                        if (orderDetailsDiv.style.display === "none") {
                                            orderDetailsDiv.style.display = "block";
                                            oList.style.display = "none";
                                        } else {
                                            orderDetailsDiv.style.display = "none";
                                            oList.style.display = "block";
                                        }
                                    }
                                    function viewMessageDetails(message) {
                                        // Fill details
                                        document.getElementById('message-store-name').innerText = message.vendor ? ((message.vendor.first_name ?? '') + ' ' + (message.vendor.last_name ?? '')) : 'N/A';
                                        document.getElementById('message-vendor-name').innerText = message.vendor ? ((message.vendor.first_name ?? '') + ' ' + (message.vendor.last_name ?? '')) : 'N/A';
                                        document.getElementById('message-subject').innerText = message.subject;
                                        document.getElementById('message-sent-at').innerText = new Date(message.created_at).toLocaleDateString();
                                        document.getElementById('message-sender-name').innerText = message.name;
                                        document.getElementById('message-sender-email').innerText = message.email;
                                        document.getElementById('message-sender-phone').innerText = message.phone;
                                        document.getElementById('message-full-text').innerText = message.message;
                                    
                                        // Hide list, Show detail
                                        document.getElementById('messageList').style.display = "none";
                                        document.getElementById('message-details').style.display = "block";
                                    }
                                    
                                    function closeMessageDetails() {
                                        // Hide detail, Show list
                                        document.getElementById('message-details').style.display = "none";
                                        document.getElementById('messageList').style.display = "block";
                                    }

                                </script>

                                <!-- Orders tracking -->
                                <div id="orderstracking" class="order-tracking tab-pane fade">
                                    <h3>Orders tracking</h3>
                                    <form class="orderstracking-from mt-3" method="post" action="#">
                                        <p class="mb-3">To track your order please enter your OrderID in the box below and press "Track" button. This was given to you on your receipt and in the confirmation email you should have received.</p>
                                        <div class="row align-items-center">
                                            <div class="form-group col-md-5 col-lg-5">
                                                <label for="orderId" class="d-none">Order ID <span class="required-f">*</span></label>
                                                <input name="orderId" placeholder="Order ID" value="" id="orderId" type="text" required>
                                            </div>
                                            <div class="form-group col-md-5 col-lg-5">
                                                <label for="billingEmail" class="d-none">Billing email <span class="required-f">*</span></label>
                                                <input name="billingEmail" placeholder="Billing email" value="" id="billingEmail" type="text" required>
                                            </div>
                                            <div class="form-group col-md-2 col-lg-2">
                                                <button type="submit" class="btn rounded w-100 h-100"><span>Track</span></button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row mt-2">
                                        <div class="col-sm-12">
                                            <h3>Status for order no: 000123</h3>
                                            <!-- Status Order -->
                                            <div class="row mt-3">
                                                <div class="col-lg-2 col-md-3 col-sm-4">
                                                    <div class="product-img mb-3 mb-sm-0">
                                                        <img class="blur-up lazyload" data-src="assets/images/products/product-6-1.jpg" src="assets/images/products/product-6-1.jpg" alt="product" title="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-9 col-sm-8">
                                                    <div class="tracking-detail d-flex-center">
                                                        <ul>
                                                            <li>
                                                                <div class="left"><span>Order name</span></div>
                                                                <div class="right"><span>Sunset Sleep Scarf Top</span></div>
                                                            </li>
                                                            <li>
                                                                <div class="left"><span>customer number</span></div>
                                                                <div class="right"><span>000123</span></div>
                                                            </li>
                                                            <li>
                                                                <div class="left"><span>order date</span></div>
                                                                <div class="right"><span>14 Nov 2024</span></div>
                                                            </li>
                                                            <li>
                                                                <div class="left"><span>Ship Date</span></div>
                                                                <div class="right"><span>16 Nov 2024</span></div>
                                                            </li>
                                                            <li>
                                                                <div class="left"><span>shipping address</span></div>
                                                                <div class="right"><span>55 Gallaxy Enque, 2568 steet, 23568 NY</span></div>
                                                            </li>
                                                            <li>
                                                                <div class="left"><span>Carrier</span></div>
                                                                <div class="right"><span>Ipsum</span></div>
                                                            </li>
                                                            <li>
                                                                <div class="left"><span>carrier tracking number</span></div>
                                                                <div class="right"><span>000123</span></div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12 col-sm-12 mt-4 mt-lg-0">
                                                    <div class="tracking-map map-section ratio ratio-16x9 h-100">
                                                        <iframe src="https://www.google.com/maps/embed?pb=" allowfullscreen="" height="650"></iframe>                             
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Status Order -->
                                            <!-- Tracking Steps -->
                                            <div class="tracking-steps nav mt-5 mb-4 clearfix">
                                                <div class="step done"><span>order placed</span></div>
                                                <div class="step current"><span>preparing to ship</span></div>
                                                <div class="step"><span>shipped</span></div>
                                                <div class="step"><span>delivered</span></div>
                                            </div>
                                            <!-- End Tracking Steps -->
                                            <!-- Order Table -->
                                            <div class="table-responsive order-table">
                                                <table class="table table-bordered table-hover align-middle text-center mb-0">
                                                    <thead class="">
                                                        <tr>
                                                            <th scope="col">Date</th>
                                                            <th scope="col">Time</th>
                                                            <th scope="col">Description</th>
                                                            <th scope="col">Location</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>14 Nov 2024</td>
                                                            <td>08.00 AM</td>
                                                            <td>Shipped</td>
                                                            <td>Canada</td>
                                                        </tr>
                                                        <tr>
                                                            <td>15 Nov 2024</td>
                                                            <td>12.00 AM</td>
                                                            <td>Shipping info received</td>
                                                            <td>California</td>
                                                        </tr>
                                                        <tr>
                                                            <td>16 Nov 2024</td>
                                                            <td>10.00 AM</td>
                                                            <td>Origin scan</td>
                                                            <td>Landon</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- End Order Table -->
                                        </div>
                                    </div>
                                </div>
                                <!-- End Orders tracking -->

                                <!-- Downloads -->
                                <div id="downloads" class="product-order tab-pane fade">
                                    <h3>Change Password</h3>
                                    <form id="change-password-form" method="POST" action="{{ route('change-password') }}" class="customer-form">
                                        @csrf
                                        <p>Use the form below to change your password.</p>
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <!-- Current Password -->
                                                <div class="form-group custom-input-group pd-l-reduc">
                                                    <label for="CurrentPassword" class="d-none">Current Password <span class="required">*</span></label>
                                                    <input type="password" class="form-control" name="current_password" placeholder="Current Password" id="CurrentPassword"  />
                                                    <div id="current-password-error" class="text-danger d-none"></div>
                                                </div>

                                                <!-- New Password -->
                                                <div class="form-group custom-input-group pd-l-reduc">
                                                    <label for="NewPassword" class="d-none">New Password <span class="required">*</span></label>
                                                    <input type="password" class="form-control" name="new_password" placeholder="New Password" id="NewPassword"  />
                                                    <small class="form-text text-muted">Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces or special characters.</small>
                                                    <div id="new-password-error" class="text-danger d-none"></div>
                                                </div>

                                                <!-- Verify New Password -->
                                                <div class="form-group custom-input-group pd-l-reduc">
                                                    <label for="Verify" class="d-none">Verify <span class="required">*</span></label>
                                                    <input type="password" class="form-control" name="new_password_confirmation" placeholder="Verify New Password" id="Verify"  />
                                                    <small class="form-text text-muted">To confirm, type the new password again.</small>
                                                    <div id="new-password-confirmation-error" class="text-danger d-none"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="text-left col-12 col-sm-12 col-md-12 col-lg-12">
                                                <p class="d-flex-center">
                                                    <button type="submit" class="btn rounded me-auto">Change Password</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>

                                    
                                </div>
                                <!-- End Downloads -->

                                <!-- Address -->
                                <div id="address" class="address tab-pane">
                                    <h3>Saved Address</h3>
                                    <p class="xs-fon-13 margin-10px-bottom">The following addresses will be used on the checkout page by default.</p>
                                    <div class="row">
                                    @foreach($addresses as $address)
                                        <div class="col-12 col-sm-6 mt-4">
                                            <p class="mb-1">{{ $address->address }}</p>
                                            <h4 class="billing-address mb-3">{{ $address->full_name }}</h4>
                                            @if($address->is_default)
                                                <a class="link-underline view me-3" href="#">Primary Address</a>
                                            @else
                                                <a class="link-underline view make-default" data-id="{{ $address->id }}" href="#">Make Primary Address</a>
                                            @endif
                                            <a class="view bgOpacity edit-address" data-id="{{ $address->id }}" href="#">Edit</a>
                                        </div>
                                    @endforeach
                                        
                                        <div class="col-12">
                                            <div class="accordion add-address mt-3" id="address1">
                                                <button class="collapsed btn btn--small rounded" type="button" data-bs-toggle="collapse" data-bs-target="#shipping" aria-expanded="false" aria-controls="shipping">Add Address</button>
                                                <div id="shipping" class="accordion-collapse collapse" data-bs-parent="#address">
                                                <form class="address-from mt-3" id="address-form">
                                                    @csrf
                                                    <input type="hidden" name="address_id" id="address_id">
                                                    <fieldset>
                                                        <h2 class="login-title mb-3">Address Details</h2>
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <input name="full_name" placeholder="Full Name" id="full_name" type="text" required>
                                                                <div class="text-danger" id="error-full_name"></div>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <input name="dial_code" placeholder="Dial Code" id="dial_code" type="text" required>
                                                                <div class="text-danger" id="error-dial_code"></div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <input name="phone" placeholder="Phone" id="phone" type="text" required>
                                                                <div class="text-danger" id="error-phone"></div>
                                                            </div>
                                                             <div class="form-group col-md-6">
                                                                <textarea name="address" placeholder="Address" id="address" required></textarea>
                                                                <div class="text-danger" id="error-address"></div>
                                                            </div>
                                                          
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-4">
                                                                <select name="country_id" id="country_id" required>
                                                                    <option value="0">Select Country</option>
                                                                    @foreach ($countries as $cnt)
                                                                        <option  value="{{ $cnt->id }}">
                                                                            {{ $cnt->name }}</option>
                                                                    @endforeach;
                                                                </select>
                                                                <div class="text-danger" id="error-country_id"></div>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <select name="state_id" id="state_id" required>
                                                                    <option value="0">Select State</option>
                                                                    @foreach ($states as $st)
                                                                        <option  value="{{ $cnt->id }}">
                                                                            {{ $st->name }}</option>
                                                                    @endforeach;
                                                                </select>
                                                                <div class="text-danger" id="error-state_id"></div>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <select name="city_id" id="city_id" required>
                                                                    <option value="0">Select City</option>
                                                                    @foreach ($cities as $ct)
                                                                        <option  value="{{ $ct->id }}">
                                                                            {{ $ct->name }}</option>
                                                                    @endforeach;
                                                                </select>
                                                                <div class="text-danger" id="error-city_id"></div>
                                                            </div>
            <!--                                                <div class="col-md-6 mb-4">-->
            <!--    <div class="form-group" value = "{{$address->address ?? ''}}">-->

            <!--        <x-elements.map-location  -->
            <!--        addressFieldName="address"-->
            <!--        :lat="$address->latitude ?? ''"-->
            <!--        :lng="$address->longitude ?? ''"-->
            <!--        :address="$address->address ?? ''"-->
                    
            <!--        />-->
            <!--    </div>-->
            <!--</div>-->
                                                            
                                                              
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <select name="address_type" id="address_type" required>
                                                                    <option value="Home">Home</option>
                                                                    <option value="Office">Office</option>
                                                                </select>
                                                                <div class="text-danger" id="error-address_type"></div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn rounded mt-1"><span>Save Address</span></button>
                                                    </fieldset>
                                                </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Address -->

                                <!-- Account Details -->
                                <div id="account-details" class="tab-pane fade">
                                    <h3>My Profile </h3>
                                    <div class="account-login-form bg-light-gray padding-20px-all">
                                    <form id="update-profile-form">
                                       @csrf
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6 col-lg-6 col-xl-6">
                                                    <div class="form-group custom-input-group pd-l-reduc">
                                                        <label for="input-firstname" class="d-none">Full name <span class="required-f">*</span></label>
                                                        <input name="firstname" id="input-firstname" class="form-control" type="text" value="{{ $user->first_name }}" Placeholder="First Name" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-6 col-xl-6">
                                                    <div class="form-group custom-input-group pd-l-reduc">
                                                        <label for="input-lastname" class="d-none">Last Name <span class="required-f">*</span></label>
                                                        <input name="lastname" id="input-lastname" class="form-control" type="text" value="{{ $user->last_name }}" Placeholder="Last Name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-lg-6 col-xl-6">
                                                    <div class="form-group custom-input-group pd-l-reduc">
                                                        <label for="input-email" class="d-none">Email Address <span class="required-f">*</span></label>
                                                        <input name="email" id="input-email" class="form-control" type="email" value="{{ $user->email }}" Placeholder="Email Address">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-lg-2 col-xl-2">
                                                    <div class="form-group custom-input-group pd-l-reduc">
                                                        <label for="input-mobile" class="d-none">Dial code <span class="required-f">*</span></label>
                                                        <input name="dial_code" id="input-mobile" class="form-control" type="text" value="{{ $user->dial_code }}" Placeholder="Dial code">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4 col-lg-4 col-xl-4">
                                                    <div class="form-group custom-input-group pd-l-reduc">
                                                        <label for="input-mobile" class="d-none">Mobile number <span class="required-f">*</span></label>
                                                        <input name="mobile_number" id="input-mobile" class="form-control" type="text" value="{{ $user->phone }}" Placeholder="Mobile Number">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-xs-12">
                                            <div class="form-group d-flex align-items-end">
                                                <div>
                                                    <label >Upload Profile Picture (gif,jpg,png,jpeg) <span style="color:red;">*<span></span></span></label>
                                                    <input type="file" class="form-control jqv-input" name="user_image" data-role="file-image" data-preview="logo-preview" value="" data-parsley-trigger="change">
                                                </div>
                                                    </div>
                                        </div>
                                            
                                            <button type="submit" class="btn btn-primary rounded">Update Profile</button>
                                        </fieldset>
                                    </form>
                                    </div>
                                </div>
                                <!-- End Account Details -->

                                <!-- Wishlist -->
                                <div id="wishlist" class="product-wishlist tab-pane fade">
                                    <h3>My Wishlist</h3>
                                    <!-- Grid Product -->
                                    <div class="grid-products grid--view-items wishlist-grid mt-4">
                                        <div class="row">
                                            @php
                                                $uniqueProducts = collect();
                                            @endphp
                                            @foreach($wishlists as $item)
                                            @if(!$uniqueProducts->contains('product_id', $item->product_id))
                                             @php $uniqueProducts->push($item); @endphp
                                            <div class="col-6 col-sm-6 col-md-3 col-lg-3 item position-relative">
                                                <button type="button" class="btn remove-icon close-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove"  onclick="removeFromWishlist(this, {{ $item->id }})"><i class="icon an an-times-r"></i></button>
                                                <!--Start Product Image-->
                                                <div class="product-image">
                                                    @php
                                                        $images = explode(',', $item->image); 
                                                        $firstImage = $images[0]; 
                                                    @endphp
                                                    <!--Start Product Image-->
                                                    <a href="{{ route('productdetails', ['id' => $item->product_id]) }}" class="product-img">
                                                        <!--Image-->
                                                        <img class="primary blur-up lazyload" data-src="{{ asset('uploads/products/'.$firstImage) }}" src="{{ asset('uploads/products/'.$firstImage) }}" alt="image" title="" width="800" height="960">
                                                        <!--End image-->
                                                        <!--Hover image-->
                                                        <img class="hover blur-up lazyload" data-src="{{ asset('uploads/products/'.$firstImage) }}" src="{{ asset('uploads/products/'.$firstImage) }}" alt="image" title="" width="800" height="960">
                                                        <!--End hover image-->
                                                    </a>
                                                    <!--end product image-->

                                                    <div class="button-set-bottom position-absolute style1">
                                                        <!--Cart Button-->
                                                        <a class="btn-icon btn btn-addto-cart pro-addtocart-popup rounded" href="javascript:void(0);" data-product-id="{{$item->id}}">
                                                            <i class="icon an an-cart-l"></i> <span>Add To Cart</span>
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
                                                        <a href="{{ route('productdetails', ['id' => $item->product_id]) }}">{{$item->product_name}}</a>
                                                    </div>
                                                    <!--End Product Name-->
                                                    <!--Product Price-->
                                                    <div class="product-price">
                                                    @if($item->regular_price)
                                                        @if($item->sale_price && $item->sale_price < $item->regular_price)
                                                            <div class="sale-price">
                                                                Sale Price: {{ $item->sale_price ?? 'N/A' }}
                                                            </div>
                                                            <div class="regular-price">
                                                                Regular Price: <span class="old-price">{{ $item->regular_price }}</span>
                                                            </div>
                                                        @else
                                                            <div class="regular-price">
                                                                Price: {{ $item->regular_price }}
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="regular-price">Price: Not available</div>
                                                    @endif
                                                    </div>
                                                    <!--End Product Price-->
                                                    <!--Product Review-->
                                                    <div class="product-review">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($item->rating >= $i)
                                                                <i class="an an-star"></i> 
                                                            @elseif($item->rating >= $i - 0.5)
                                                                <i class="an an-star-half"></i> 
                                                            @else
                                                                <i class="an an-star-o"></i> 
                                                            @endif
                                                        @endfor
                                                    </div>
                                                </div>
                                                <!--End Product Details-->
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- End Grid Product-->
                                </div>
                                <!-- End Wishlist -->
                            </div>
                            <!-- End Tab panes -->
                        </div>
                    </div>
                    <!--End Main Content-->
                </div>
                <!--End Container-->
            </div>
            <!--End Body Container-->
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Check the URL hash on page load
                    var hash = window.location.hash;
            
                    // If the hash matches the tab ID
                    if (hash === "#address") {
                        // Trigger the click on the "Saved Address" tab link
                        var addressTab = document.querySelector('a[href="#address"]');
                        if (addressTab) {
                            addressTab.click();
                        }
                    }
                });
            </script>
            
            @endsection 

