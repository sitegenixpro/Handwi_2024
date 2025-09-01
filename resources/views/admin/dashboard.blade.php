@extends('admin.template.layout')

@section('header')
    <link href="{{ asset('') }}admin-assets/assets/css/support-chat.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}admin-assets/plugins/maps/vector/jvector/jquery-jvectormap-2.0.3.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('') }}admin-assets/plugins/charts/chartist/chartist.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('') }}admin-assets/assets/css/default-dashboard/style.css" rel="stylesheet" type="text/css" />
@stop


@section('content')

<style>

.home-section footer{
    bottom: auto !important;
}
.custom-container{
    min-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
}
/*body.dark{*/
/*    background: url('{{ asset('') }}admin-assets/assets/img/laconcierge-bg.jpg');*/
/*    background-size: 100% 100%;*/
/*    background-position: center;*/
/*    background-repeat: no-repeat;*/
/*}*/
.custom-wl{
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
    
}
.custom-wl li{
    width: calc(25% - 30px);
    list-style-type: none;
}

@media(max-width:1200px){
    .custom-wl li{
        width: calc(33.33% - 30px);
        list-style-type: none;
    }
}

@media(max-width:1200px){
    .custom-wl li{
        width: calc(33.33% - 30px);
        list-style-type: none;
    }
}


.custom-wl li .icon-card{
    /*max-width: 320px;*/
    margin: auto;
    min-height: 230px;
}


.icon-card{
    background: #121212;
    padding: 30px 20px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: flex-start;
    transition: 0.5s all ease-in-out !important;
}


.icon-card .icon{
    max-width: 70px;
    height: 70px; 
    font-size: 30px;
}

.icon-card .content h6{
    color: #fff;
    margin: 0 !important;
    margin-bottom: 10px !important;

}

.icon-card .content h3{
    color: #fff;
    margin-bottom: 0 !important;
    font-size: 36px !important;
    
}


.icon-card .content.text-center{
    text-align: left !important;
}


.icon-card .icon {
    color: #ffff !important;
    background-color: #252525 !important;
    box-shadow: rgba(255, 255, 255, 0.25) 0px 30px 60px -12px inset, rgba(255, 255, 255, 0.3) 0px 18px 36px -18px inset;
}

.icon-card:hover{
    box-shadow: rgba(255, 255, 255, 0.25) 0px 30px 60px -12px inset, rgba(255, 255, 255, 0.3) 0px 18px 36px -18px inset;
}

/* .icon-card.yellow .icon {
    color: #FF8C00;
    background-color: #ffdeda;
}

.icon-card.yellow:hover .icon {
  background-color: #FF8C00;
  color: #fff;
}

.icon-card.Orchid .icon {
    color: #BA55D3;
    background-color: #ffdeda;
}

.icon-card.Orchid:hover .icon {
  background-color: #BA55D3;
  color: #fff;
}

.icon-card.BlueViolet .icon {
    color: #7B68EE;
    background-color: #ffdeda;
}


.icon-card.BlueViolet:hover .icon {
  background-color: #7B68EE;
  color: #fff;
}

.icon-card.Green .icon {
    color: #2E8B57;
    background-color: #ffdeda;
}


.icon-card.Green:hover .icon {
  background-color: #2E8B57;
  color: #fff;
}

.icon-card.Tomato .icon {
    color: #FF6347;
    background-color: #ffdeda;
}

.icon-card.Tomato:hover .icon {
  background-color: #FF6347;
  color: #fff;
}


.icon-card.LightSeaGreen .icon {
    color: #20B2AA;
    background-color: #ffdeda;
}

.icon-card.LightSeaGreen:hover .icon {
  background-color: #20B2AA;
  color: #fff;
}


.icon-card.chocklate .icon {
    color: #D2691E;
    background-color: #ffdeda;
}

.icon-card.chocklate:hover .icon {
  background-color: #D2691E;
  color: #fff;
} */


</style>
  @if(GetUserPermissions("dashboard_view"))
    <div class="row d-none">
        <div class="col-lg-12 mb-4">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                    <a href="{{url('admin/customers')}}">
                        <div class="card custom-card">
                            <div class="widget">
                                <div class="widget-icon widget-bg-red">
                                    <i class='bx bx-user' ></i>
                                </div>
                                <div class="widget-info">
                                    <span>{{$users}}</span>
                                    <h6>Users</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                    <a href="{{url('admin/customers')}}">
                        <div class="card custom-card">
                            <div class="widget">
                                <div class="widget-icon widget-bg-red-light text-white">
                                    <i class='bx bx-cog'></i>
                                </div>
                                <div class="widget-info">
                                    <span>{{$service_josbs}}</span>
                                    <h6>Service Job</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                    <a href="{{url('admin/customers')}}">
                        <div class="card custom-card">
                            <div class="widget">
                                <div class="widget-icon widget-bg-yellow-light">
                                    <i class='bx bx-file' ></i>
                                </div>
                                <div class="widget-info">
                                    <span>{{$contract_maintanence_count}}</span>
                                    <h6>Contract Maintenance Jobs</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                
            </div>
             <ul class="nav nav-pills mb-3 custom-pills justify-content-around" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-user-tab" href="{{url('admin/customers')}}" role="tab" aria-controls="pills-user" aria-selected="true">
                        <i class='bx bx-user' ></i> <span>Users</span>
                        <span>10</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-vendors-tab" href="{{url('admin/vendors')}}" role="tab" aria-controls="pills-vendors" aria-selected="false">
                        <i class='bx bx-user-circle' ></i> <span>Vendors</span>
                        <span>10</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-product-tab" href="{{url('admin/products')}}" role="tab" aria-controls="pills-product" aria-selected="false">
                    <i class='bx bx-list-check'></i> <span>Service provider</span>
                    <span>15</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-stores-tab" href="{{url('admin/store')}}" role="tab" aria-controls="pills-stores" aria-selected="false">
                        <i class='bx bx-store' ></i> <span>Sales</span>
                        <span>30</span>
                    </a>
                </li>

                 <li class="nav-item">
                    <a class="nav-link" id="pills-stores-tab" href="{{url('admin/store')}}" role="tab" aria-controls="pills-stores" aria-selected="false">
                        <i class='bx bx-store' ></i> <span>Commission</span>
                        <span>300</span>
                    </a>
                </li>
            </ul> 
        </div>
        
    </div>

        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
              <a href="{{url('admin/vendors')}}"><div class="icon-card height-100 text-center Tomato h-100">
                 <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                 </div>
                 <div class="content m-0 text-center">
                    <h6 class="m m-1 text-center">Vendors</h6>
                    <h3>{{$vendors}}</h3>
                 </div>
              </div></a>
           </div>

           <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
              <a href="{{url('admin/customers')}}"><div class="icon-card height-100 text-center yellow h-100">
                 <div class="icon">
                    <i class="fa-solid fa-users"></i>
                 </div>
                 <div class="content m-0 text-center">
                    <h6 class="m m-1 text-center">Customers</h6>
                    <h3>{{$users}}</h3>
                 </div>
              </div></a>
           </div>

           <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
              <a href="{{url('admin/orders')}}"><div class="icon-card height-100 text-center Orchid h-100">
                 <div class="icon">
                    <i class="fa-solid fa-boxes-stacked"></i>
                 </div>
                 <div class="content m-0 text-center">
                    <h6 class="m m-1 text-center">Orders</h6>
                    <h3>{{$sales}}</h3>
                 </div>
              </div></a>
           </div>

           <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
              <a href="{{url('admin/products')}}"><div class="icon-card height-100 text-center orange h-100">
                 <div class="icon">
                 <i class="fa-solid fa-dolly"></i>
                 </div>
                 <div class="content m-0 text-center">
                    <h6 class="m m-1 text-center">Products</h6>
                    <h3>{{$products}}</h3>
                 </div>
              </div></a>
           </div>

           <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
              <a href="{{url('admin/products')}}"><div class="icon-card height-100 text-center Green h-100">
                 <div class="icon">
                    <i class="fa-solid fa-gift"></i>
                 </div>
                 <div class="content m-0 text-center">
                    <h6 class="m m-1 text-center">Gifts</h6>
                    <h3>{{$food}}</h3>
                 </div>
              </div></a>
           </div>

           <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
              <a href="{{url('admin/workshops')}}"><div class="icon-card height-100 text-center LightSeaGreen h-100">
                 <div class="icon">
                 <i class="fa-solid fa-users-gear"></i>
                 </div>
                 <div class="content m-0 text-center">
                    <h6 class="m m-1 text-center">Workshop</h6>
                    <h3>{{$services}}</h3>
                 </div>
              </div></a>
           </div>

           <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
              <a href="{{url('admin/bookings')}}"><div class="icon-card height-100 text-center chocklate h-100">
                 <div class="icon">
                 <i class="fa-solid fa-list-check"></i>
                 </div>
                 <div class="content m-0 text-center">
                    <h6 class="m m-1 text-center">Bookings</h6>
                    <h3>{{$bookings}}</h3>
                 </div>
              </div></a>
           </div>
        
           <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
               <a href="{{url('admin/vendors')}}">
              <div class="icon-card height-100 text-center red h-100">
                 <div class="icon">
                    <i class="fa-solid fa-briefcase"></i>
                 </div>
                 <div class="content m-0 text-center">
                    <h6 class="m m-1 text-left">Vendors @if($vendors_new > 0)<span class="badge badge-danger" style="border-radius: 5px; padding: 4px 6px; width: auto; font-size: 11px;">New ({{$vendors_new}})</span>@endif </h6>
                    <h3>{{$vendors}}</h3>
                 </div>
              </div>
              </a>
           </div>
           
           
        </div>
        
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card w-100 h-100">
                    <h5 class="card-header">Orders & Bookings</h5>
                    <div class="card-body">
                        <canvas id="myPieChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 mb-4">
                <div class="card w-100 h-100">
                    <h5 class="card-header">Daily Orders & Bookings</h5>
                    <div class="card-body">
                        <canvas id="ordersBookingsChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 mb-4 d-none">
                <div class="card w-100 h-100">
                  <h5 class="card-header">Latest Orders</h5>
                  <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-striped mb-0">
                          <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order No</th>
                                        <th>Order ID</th>
                                        <th>Customer </th>
                                        
                                        <th>Total</th>
                                        <th>Status</th> 
                                        <th>Booking Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                          <tbody>
                            <tr>
                                <td>1</td>
                                <td>HA20250506169</td>
                                <td>169</td>
                                <td>Nasrullah khan</td>
                            
                                <td>1207.5</td>
                                <td>Pending</td>
                                <td>06-May-25 11:46 PM</td>
                                <td class="text-center">
                                    <a href="https://handwi.com/public/portal/order_details/169" class="btn btn-info btn-sm"> Details</a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>HA20250506168</td>
                                <td>168</td>
                                <td>Nasrullah khan</td>
                            
                                <td>210</td>
                                <td>Pending</td>
                                <td>06-May-25 07:50 PM</td>
                                <td class="text-center">
                                    <a href="https://handwi.com/public/portal/order_details/168" class="btn btn-info btn-sm"> Details</a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>HA20250506167</td>
                                <td>167</td>
                                <td>anil navis</td>
                            
                                <td>4182.95</td>
                                <td>Accepted</td>
                                <td>06-May-25 01:41 PM</td>
                                <td class="text-center">
                                    <a href="https://handwi.com/public/portal/order_details/167" class="btn btn-info btn-sm"> Details</a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>HA20250501166</td>
                                <td>166</td>
                                <td>anil</td>
                                <td>609</td>
                                <td>Accepted</td>
                                <td>01-May-25 10:02 AM</td>
                                <td class="text-center">
                                    <a href="https://handwi.com/public/portal/order_details/166" class="btn btn-info btn-sm"> Details</a>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>HA20250423165</td>
                                <td>165</td>
                                <td>Ajesh Kumar</td>
                            
                                <td>735</td>
                                <td>Delivered</td>
                                <td>23-Apr-25 07:49 PM</td>
                                <td class="text-center">
                                    <a href="https://handwi.com/public/portal/order_details/165" class="btn btn-info btn-sm"> Details</a>
                                </td>
                            </tr>
        
                          </tbody>
                        </table>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        
    
    <div class="row"  style="display:none;">
         <div class="col-lg-6 mb-4">
            <div class="card custom-card" id="primary-card">
                <div class="progress-bars">
                    <!-- <span>
                        <div class="d-flex justify-content-between mb-2">
                                <h6 class="text-xsl">Daily sells of medicine vrs service</h6>
                                <p class="text-xxs mb-0">Lorem Ipsum is simply dummy text</p>
                        </div>
                        
                    </span> -->
                    <div class="custom-card-flex">
                            <div class="mb-2">
                                <h6 class="mb-2 text-xl">User registration</h6>
                                <p class="text-xsl">Monthly user registration. </p>
                            </div>
                            <!--<div class="d-flex align-items-center border-1">-->
                            <!--    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>-->
                            <!--    <input type="text" class="form-control dashboard-form-control flat-picker border-0 bg-transparent pr-0 flatpickr-input" placeholder="{{$graphdata['start_date']}}">-->
                            <!--    <input type="text" class="form-control dashboard-form-control flat-picker border-0 bg-transparent pr-0 flatpickr-input" placeholder="{{$graphdata['stop_date']}}">-->
                            <!--</div>-->
                        </div>
                    <!-- <span class="mb-4">
                        <div class="progress mb-2">
                            <div class="progress-bar progress-bar-2" role="progressbar" style="width: 0%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="30"></div>
                        </div>
                    </span> -->
                    <div class="chart" style="position: relative; height: 40vh; overflow: hidden;">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card custom-card" id="secondary-card">
                <div class="chart" style="position: relative; height: 44vh; overflow: hidden;">
                    <canvas id="orderschart"></canvas>
                </div>
            </div>
        </div>
    </div>
    @if(GetUserPermissions("orders_view"))
    <div class="row mb-4 d-none">
        <div class="col-lg-6 d-none">
            <div class="card custom-card mb-4">
                <div class="row align-items-center">
                    <div class="col-lg-12 mb-4">
                        <div class="custom-card-flex">
                            <div class="mb-2">
                                <h6 class="mb-2 text-xl">User registration</h6>
                                <p class="text-xsl">Monthly user registration. </p>
                            </div>
                            <div class="d-flex align-items-center border-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                <input type="text" class="form-control dashboard-form-control flat-picker border-0 bg-transparent pr-0 flatpickr-input" placeholder="YYYY-MM-DD">
                                <input type="text" class="form-control dashboard-form-control flat-picker border-0 bg-transparent pr-0 flatpickr-input" placeholder="YYYY-MM-DD">
                            </div>
                        </div>
                        <div class="text-right">
                            
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="chart" style="position: relative; height: 30vh; overflow: hidden;">
                            <canvas id="mybarlineChart1"></canvas>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- <div class="col-lg-6">
            <div class="card custom-card mb-4">
                <div class="row align-items-center">

                    <div class="col-lg-12 mb-4">
                        <div class="custom-card-flex">
                            <div class="mb-2">
                                <h6 class="mb-2 text-xl">Vendor registration</h6>
                                <p class="text-xsl">Monthly Vendor registration. </p>
                            </div>
                            <div class="d-flex align-items-center border-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                <input type="text" class="form-control dashboard-form-control flat-picker border-0 bg-transparent pr-0 flatpickr-input" placeholder="YYYY-MM-DD">
                                <input type="text" class="form-control dashboard-form-control flat-picker border-0 bg-transparent pr-0 flatpickr-input" placeholder="YYYY-MM-DD">
                            </div>
                        </div>
                        <div class="text-right">
                            
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="chart" style="position: relative; height: 30vh; overflow: hidden;">
                            <canvas id="mybarlineChart2"></canvas>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div> -->
        <!--<div class="col-lg-6">-->
        <!--    <div class="card custom-card">-->
        <!--        <div class="chart" style="position: relative; height: 44vh; overflow: hidden;">-->
        <!--            <canvas id="orderschart"></canvas>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
        <!-- <div class="col-lg-6">
            <div class="card custom-card">
                <div class="chart" style="position: relative; height: 30vh; overflow: hidden;">
                <canvas id="userschat" width="600" height="300"></canvas>
                </div>
            </div>
        </div> -->
       <div class="col-lg-12" style="display:none;">
            <div class="row">
            <div class="col-12">
      <div class="card custom-card">
         <div class="card-header "> <b style="color: black;">Latest Orders</b></div>
         <table class="table table-responsive recent-orders-table mb-0"
            style="">
            <thead>
               <tr>
                  <th scope="col" width="20%">Order ID</th>
                  <th scope="col" width="25%">Activity Type</th>
                  <th scope="col" width="25%">Customer</th>
                  <th scope="col" width="20%">Order Date</th>
                  <th scope="col" width="20%">Total</th>
                  <th scope="col" width="15%">Status</th>
                  <!-- <th scope="col" width="10%">View</th> -->
               </tr>
            </thead>
            <tbody id="newdata">
               @if($latest_orders->isEmpty())
               <tr>
                  <td colspan="6"> No Data</td>
               </tr>
               @endif
               @foreach ($latest_orders as $item)
               <tr>
                  <td><?php echo config('global.sale_order_prefix').date(date('Ymd', strtotime($item->created_at))).$item->order_id; ?></td>
                  <td>{{ $item->activity ? $item->activity->name : ''  }}</td>
                  <td>{{ $item->name ?? $item->customer_name }}</td>
                  <td>{{ web_date_in_timezone($item->booking_date, 'M d h:i A') }}</td>
                  <td>{{config('global.default_currency_code')}} {{ $item->grand_total }}</td>
                  <td><span class="badge badge-info"> {{ $item->status_text }}</span></td>
                  <!-- <td><a href="{{ url('admin/order_details/' . $item->order_id) }}"><span
                     class="badge badge-success"> Details</span></a></td> -->
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
                
            </div>
        </div>
    </div>
    @endif

    <div class="row layout-spacing d-none">

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-sm-0 mb-4">
            <a href="#">
                <div class="widget-content-area  data-widgets br-4">
                    <div class="widget  t-customer-widget">

                        <div class="media">
                            <div class="icon ml-2">
                                <i class="flaticon-users"></i>
                            </div>
                            <div class="media-body text-right">
                                <p class="widget-text mb-0">Users</p>
                                <p class="widget-numeric-value">0</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-sm-0 mb-4">
            <a href="#">
                <div class="widget-content-area  data-widgets br-4">
                    <div class="widget  t-customer-widget">

                        <div class="media">
                            <div class="icon ml-2">
                                <i class="flaticon-users"></i>
                            </div>
                            <div class="media-body text-right">
                                <p class="widget-text mb-0">Vendors</p>
                                <p class="widget-numeric-value">{{$vendors}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-sm-0 mb-4">
            <a href="#">
                <div class="widget-content-area  data-widgets br-4">
                    <div class="widget  t-customer-widget">

                        <div class="media">
                            <div class="icon ml-2">
                                <i class="flaticon-menu-list"></i>
                            </div>
                            <div class="media-body text-right">
                                <p class="widget-text mb-0">Products</p>
                                <p class="widget-numeric-value">{{$products}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>




    </div>








    </div>
    @endif
@stop

@section('footer')
    <!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js'></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0-rc"></script>
@stop

@section('script')
    <script>
        $(window).resize(function(){
           var height = $('#primary-card').height();
           $('#secondary-card').height(height);
        })
        
        $(window).resize(); 

    var myChartctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(myChartctx, {
    type: 'bar',
    data: {
        labels: @json(array_values($months), JSON_PRETTY_PRINT),
        datasets: [ {
        label: 'Users',
        data: [{{implode(", ",$newusers)}}],
        backgroundColor: "#2C93FA"
        }]
    },
    options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    },
                },
                scales: {
                    x: {
                        grid: {
                            color: '#000'
                        }
                    },
                    y: {
                        grid: {
                            color: '#000'
                        }
                    },
                },
            }
    });



    //    var ctx = document.getElementById('myChart').getContext('2d');
    //     var chart = new Chart(ctx, {
    //         type: 'line',
    //         data: {
    //             labels: ["100", "200", "300", "400", "500", "600", "700", "800", "900", "1000", "1100","1200", "1300", "1400", "1500", "1600", "1700"],
    //             datasets: [{
    //                 label: "",
    //                 fill: true,
    //                 backgroundColor: 'rgb(204 155 68)',
    //                 borderColor: 'rgb(235 192 94)',
    //                 data: [10, 200, 150, 50, 180, 80, 150, 60, 130, 90, 135, 85, 165, 78, 138, 48, 158],
    //             }]
    //         },

    //         options: {
    //             maintainAspectRatio: false,
    //             responsive: true,
    //             scales: {
    //                 x: {
    //                     position: 'top',
    //                     grid: {
    //                         color: '#FAF0E6'
    //                     },
    //                     ticks: {
    //                         maxRotation: 0,
    //                         minRotation: 0,
    //                         font: {
    //                             size: 5
    //                         }
    //                     }
    //                 },
    //                 y: {
    //                     grid: {
    //                         color: '#FAF0E6'
    //                     },
    //                     ticks: {
    //                         display: false
    //                     }
                        
    //                 },
    //             },
    //             plugins: {
    //                 legend: {
    //                     display: false
    //                 },
    //             }
    //         }
    //     });


        var ctx = document.getElementById("mybarlineChart1");
        var chart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: ["", "", "", "", "", "","", "", ""],
            datasets: [
            {
                type: "bar",
                backgroundColor: "rgb(140 202 17)",
                borderWidth: 1,
                label: "",
                data: [60, 49, 72, 85, 80, 60, 50, 45, 46]
            },
            {
                type: "line",
                
                backgroundColor: "rgb(89 133 7)",
                borderColor: "rgb(89 133 7)",
                label: "",
                data: [60, 49, 72, 85, 80, 60, 50, 45, 46],
                lineTension: 0, 
            }
            ]
        },
        options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    x: {
                        grid: {
                            color: '#000'
                        },
                        ticks: {
                            display: false
                        }
                    },
                    y: {
                        

                        position: 'top',
                        grid: {
                            borderDash: [2, 3],
                            color: '#000'
                        },
                        ticks: {
                            maxRotation: 0,
                            minRotation: 0,
                            font: {
                                size: 5
                            }
                        }
                        
                    },
                },
                plugins: {
                    legend: {
                        display: false
                    },
                }
            }
        });


        var ctx = document.getElementById("mybarlineChart2");
        var chart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: ["", "", "", "", "", "","", "", ""],
            datasets: [
                {
                type: "bar",
                backgroundColor: "rgb(89 133 7)",
                borderWidth: 1,
                label: "",
                data: [60, 49, 72, 85, 80, 60, 50, 45, 46]
            },
            {
                type: "line",
                backgroundColor: "rgb(140 202 17)",
                borderColor: "rgb(140 202 17)",
                label: "",
                data: [60, 49, 72, 85, 80, 60, 50, 45, 46],
                lineTension: 0, 
            }
            ]
        },
        options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    x: {
                        grid: {
                            color: '#000'
                        },
                        ticks: {
                            display: false
                        }
                    },
                    y: {
                        

                        position: 'top',
                        grid: {
                            borderDash: [2, 3],
                            color: '#000'
                        },
                        ticks: {
                            maxRotation: 0,
                            minRotation: 0,
                            font: {
                                size: 5
                            }
                        }
                        
                    },
                },
                plugins: {
                    legend: {
                        display: false
                    },
                }
            }
        });

        // var mybarctx = document.getElementById("mybarlineChart3");
        // var chart = new Chart(mybarctx, {
        // type: "bar",
        // data: {
        //     labels: ["", "", "", "", "", "", "", "", ""],
        //     datasets: [
        //         {
        //         type: "bar",
        //         backgroundColor: "rgba(0,0,0,0.3)",
        //         borderWidth: 1,
        //         label: "",
        //         data: [60, 49, 72, 85, 80, 60, 50, 45, 46]
        //     },
        //     {
        //         type: "line",
        //         backgroundColor: "rgb(0,0,0)",
        //         borderColor: "rgb(89 133 7)",
        //         label: "",
        //         data: [60, 49, 72, 85, 80, 60, 50, 45, 46],
        //         lineTension: 0,
        //     }
        //     ]
        // },
        // options: {
        //         maintainAspectRatio: false,
        //         responsive: true,
        //         scales: {
        //             x: {
        //                 grid: {
        //                     color: '#000'
        //                 },
        //                 ticks: {
        //                     display: false
        //                 }
        //             },
        //             y: {
                        

        //                 position: 'top',
        //                 grid: {
        //                     borderDash: [2, 3],
        //                     color: '#000'
        //                 },
        //                 ticks: {
        //                     maxRotation: 0,
        //                     minRotation: 0,
        //                     font: {
        //                         size: 5
        //                     }
        //                 }
                        
        //             },
        //         },
        //         plugins: {
        //             legend: {
        //                 display: false
        //             },
        //         }
        //     }
        // });

        
        var orderschartctx = document.getElementById("orderschart");
        var myChart = new Chart(orderschartctx, {
        type: 'doughnut',
        data: {
            labels: ['Service Job', 'Contract & Maintanence Job'],
            datasets: [{
            label: '',
            data: ['{{$service_josbs}}', '{{$contract_maintanence_count}}'],
            backgroundColor: [
                'rgb(89 133 7)',
                'rgb(37 37 37)'
            ],
            borderColor: [
                'rgb(89 133 7)',
                'rgb(37 37 37)'
            ],
            borderWidth: 2
            }]
        },
        options:{
            cutout: 60,
            centerPercentage: 80,
            responsive: true,
            maintainAspectRatio: false,
            tooltips: {
                enabled: true
            },
            interaction: {
            intersect: false
            },
            plugins: {
            legend: {
                display: true,
                position: 'bottom',
                
                labels: {
                    font: {
                        size: 10,
                    },
                    boxWidth: 10,
                    color: "white"
                }
            }
            },
        }
        });


document.addEventListener('DOMContentLoaded', function () {
  var ctxs = document.getElementById('userschat').getContext('2d');
  var gradient = ctxs.createLinearGradient(0, 0, 0, 225);
  gradient.addColorStop(0, 'rgb(140,202,17, 0.8)');
  gradient.addColorStop(1, 'rgb(140,202,17, 0)');
  // Line chart
  new Chart(document.getElementById('userschat'), {
    type: 'line',
    data: {
      labels: [
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'May',
        'Jun',
        'Jul',
        'Aug',
        'Sep',
        'Oct',
        'Nov',
        'Dec',
      ],
      datasets: [
        {
          label: 'Active Users',
          fill: true,
          backgroundColor: gradient,
          borderColor: 'rgb(89 133 7)',
          tension: 0.5,
          data: [
            2115, 1562, 1584, 1892, 1587, 1923, 2566, 2448, 2805, 3438, 2917,
            3327,
          ],
        },
      ],
    },
    options: {
        maintainAspectRatio: false,
        responsive: true,
      tooltips: {
        intersect: false,
      },
      hover: {
        intersect: true,
      },
      plugins: {
        filler: {
          propagate: false,
        },
        legend: {
            display: false
        },
      },
      scales: {
                    x: {
                        grid: {
                            color: '#000'
                        },
                        ticks: {
                            display: false
                        }
                    },
                    y: {
                        

                        position: 'top',
                        grid: {
                            borderDash: [2, 3],
                            color: '#000'
                        },
                        ticks: {
                            maxRotation: 0,
                            minRotation: 0,
                            font: {
                                size: 5
                            }
                        }
                        
                    },
                },
    },
  });
});

    </script>
    
    
    
    <script>
    const ctxpie = document.getElementById('myPieChart').getContext('2d');
    let orders='<?php echo $sales; ?>';
    let bookings='<?php echo $bookings; ?>';
    const data = {
      labels: ['Orders', 'Bookings'],
      datasets: [{
        data: [orders, bookings],
        backgroundColor: [
          'rgba(0, 0, 0, 0.7)',
          'rgba(231, 81, 90, 0.5)',
        ],
        borderColor: [
          'rgba(0, 0, 0, 0)',
          'rgba(231, 81, 90, 1)',
        ],
        borderWidth: 1
      }]
    };

    const config = {
      type: 'pie',
      data: data,
      options: {
        responsive: true,
      },
    };

    new Chart(ctxpie, config);
    
    
     const linectx = document.getElementById('ordersBookingsChart').getContext('2d');
         const bookingsData = @json($bookings_data);
  const salesData = @json($sales_data);
    const ldata = {
      labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      datasets: [
        {
          label: 'Orders',
          data: salesData,
          borderColor: 'rgba(231, 81, 90, 1)',
          backgroundColor: 'rgba(231, 81, 90, 0.2)',
          tension: 0.4,
          fill: true
        },
        {
          label: 'Bookings',
          data: bookingsData,
          borderColor: 'rgba(0, 0, 0, 1)',
          backgroundColor: 'rgba(0, 0, 0, 0.2)',
          tension: 0.4,
          fill: true
        }
      ]
    };

    const options = {
      responsive: true,
      plugins: {
        legend: { position: 'top' },
        
      },
      scales: {
        y: { beginAtZero: true }
      }
    };

    new Chart(linectx, {
      type: 'line',
      data: ldata,
      options: options
    });
  </script>
@stop
