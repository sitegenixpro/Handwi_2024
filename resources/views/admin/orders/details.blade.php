@extends("admin.template.layout")

@section('header')
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin_assets/plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('') }}admin_assets/plugins/table/datatable/custom_dt_customer.css">
    <style>
        td {
            padding-top: 8px;
            padding-bottom: 8px;
        }
        .order-totel-details thead tr:last-child{
            border-bottom: none;
        }
    </style>
@stop


@section('content')
    <div class="order-detail-page row">
            <div class="dataTables_wrapper container-fluid dt-bootstrap4">
            {{-- <form action="" method="get">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Date From</label>
                            <input type="text" name="from" class="form-control datepicker" autocomplete="off" value="">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Date To</label>
                            <input type="text" name="to" class="form-control datepicker" autocomplete="off" value="">
                        </div> 
                        <div class="col-md-4 form-group">
                            <label>Search Order ID</label>
                            <input type="text" name="search_key" class="form-control" autocomplete="off"
                                value="{{ $search_key }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Customer Name</label>
                            <input type="text" name="search_key" class="form-control" autocomplete="off"
                                value="{{ $search_key }}">
                        </div>
                        <button type="submit" class="btn btn-warning mb-4 mr-2 btn-rounded">Search</button>
                    </div>
                </form>--}}




                <!-- <div class="row mt-3">
                    <div class="col-sm-12 col-md-6">
                        <div class="dataTables_length" id="column-filter_length">
                        </div>
                    </div>


                </div> -->
                
                <div class="order-totel-details">
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        
                                        <?php $ordernumber = config('global.sale_order_prefix').date(date('Ymd', strtotime($list[0]->created_at))).$list[0]->order_id; ?>
                                        <h5>Order NO: {{$ordernumber}} </h5>
                                        <div class="table-responsive">
                                            <table width="100%">
                                                <thead>
                                                    <tr>
                                                        <td>Order No:
                                                        <span class="w-100 d-block font-weight-bold mt-2">{{$ordernumber}}</span></td>
                                                        <td>Customer:
                                                        <span class="w-100 d-block font-weight-bold mt-2">{{$list[0]->name??$list[0]->customer_name}}</span></td>
                                                    </tr>
                                                    <tr>
                                                        
                                                        <td> Delivery Address :
                                                        <span class="w-100 d-block font-weight-bold mt-2">@if(!empty($list[0]->shipping_address)) <?php $shipdata = \App\Models\UserAdress::get_address_details($list[0]->address_id) ??[];//$list[0]->shipping_address;
                                                        ?>
                                                        @if(request()->test)
                                                        @dd($shipdata)
                                                        @endif
                                                            <!--{{$shipdata->address}}, <br>-->
                                                            {{$shipdata->apartment??''}} <br>
                                                            {{$shipdata->building_name??''}}<br>
                                                            {{$shipdata->street??''}}<br>
                                                            
                                                            {{$shipdata->area_name}}<br>
                                                            {{$shipdata->city_name}}<br>
                                                            {{$shipdata->country_name}}<br>
                                                            {{$shipdata->land_mark}}<br>
                                                        <br>
                                                            @elseif($list[0]->order_type == 1)
                                                            Pick Up
                                                            @else
                                                        @endif
                                                        </span>
                                                        </td>
                                                        
                                                        <td></td>
                                                    </tr>

                                                    @if($list[0]->order_type == 1)
                                                    <tr>
                                                        <td >Order date:
                                                        <span class="w-100 d-block font-weight-bold mt-2">{{ $list[0]->pick_up_date ? date('d-M-y',strtotime($list[0]->pick_up_date)) : '-' }}</span></td>
                                                    
                                                        <td >Order Time:
                                                        <span class="w-100 d-block font-weight-bold mt-2">{{ $list[0]->pick_up_time ? $list[0]->pick_up_time : '-' }}</span></td>
                                                    </tr>
                                                    @endif

                                                    <tr>
                                                        <td>Created on: 
                                                            <span class="w-100 d-block font-weight-bold mt-2">{{get_date_in_timezone($list[0]->created_at,'d-M-Y h:i A')}}</span></td>
                                                        <td>Sale Amount: 
                                                            <span class="w-100 d-block font-weight-bold mt-2">{{number_format($list[0]->total, 2, '.', '')}}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>VAT: 
                                                            <span class="w-100 d-block font-weight-bold mt-2">{{number_format($list[0]->vat, 2, '.', '')}}</span></td>
                                                        <td>Discount: 
                                                        <span class="w-100 d-block font-weight-bold mt-2">{{number_format($list[0]->discount, 2, '.', '')}}</span></td>
                                                    </tr>
                                                    
                                                

                                                    <tr>
                                                        <td>Sub Total: 
                                                        <span class="w-100 d-block font-weight-bold mt-2">{{number_format(($list[0]->total- $list[0]->discount) + $list[0]->vat, 2, '.', '')}}</span></td>
                                                        <td>Grand Total: 
                                                        <span class="w-100 d-block font-weight-bold mt-2">{{number_format($list[0]->grand_total, 2, '.', '')}} </span></td>
                                                        
                                                        </th>
                                                    </tr>
                                                    {{--<tr>
                                                        <th>Shipping Charge</th>
                                                        <th>: {{number_format('0', 2, '.', '')}}</th>
                                                        <th>Service Charge</th>
                                                        <th>: {{number_format('0', 2, '.', '')}}</th>
                                                    </tr>--}}
                                                    
                                                    <tr>
                                                        <td>Delivery Charge: 
                                                            <span class="w-100 d-block font-weight-bold mt-2">{{number_format($list[0]->shipping_charge, 2, '.', '')}}</span></td>
                                                        <td>Service charge: 
                                                        <span class="w-100 d-block font-weight-bold mt-2">{{number_format($list[0]->service_charge, 2, '.', '')}}</span></td>
                                                    
                                                    </tr>
                                                
                                                    <tr>
                                                    
                                                        <td>Payment Mode:
                                                            <span class="w-100 d-block font-weight-bold mt-2">{{payment_mode($list[0]->payment_mode)}}</span></td>
                                                        <!-- <td>Admin Earning:
                                                            <span class="w-100 d-block font-weight-bold mt-2"> {{number_format($list[0]->admin_commission, 2, '.', '')}}</span></td> -->
                                                    
                                                    </tr>

                                                    <tr>
                                                    
                                                        <!-- <td>Vendor Earning: 
                                                        <span class="w-100 d-block font-weight-bold mt-2">{{number_format($list[0]->vendor_commission, 2, '.', '')}} </span></td> -->
                                                        <td></td>
                                                        <td>Invoice: 
                                                        <span class="w-100 d-block font-weight-bold mt-2"><a href="{{ url('order_invoice/' . $list[0]->order_id) }}" target="_blank"><button type="button" class="btn btn-primary">View Invoice</button></a></span></td>
                                                    </tr>

                                                </thead>

                                            </table>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="page-header">
                            <div class="page-title">
                        <h3>Sub Orders</h3>
                            </div>
                            </div><br>
                            <?php
                            $count=1;
                                        
                                        foreach ($sub_orders as $vendorId => $vendorProducts) {

?>
<div class="card">
                                <div class="card-body">
                                    <div class="">
                                          <h5>Order NO: {{$ordernumber}}#{{$count}}  </h5> 
                                          <h5>{{$vendorProducts->vendorName}}</h5>
                                          <span> Status: {{$vendorProducts->order_status_text}} </span>
                                          @if($vendorProducts->reject_reason)
                                         <br> <span> Rejected Reason: {{$vendorProducts->reject_reason}} </span>
                                          @endif
                                          
                                          <?php
                                          $count++;
                                          ?>
  <div class="table-responsive">
      
                                            <table width="100%">
                                                <thead>
 
                                        
<?php

    foreach ($vendorProducts->productList as $product) {
        
        ?>
        <tr>
       <td>
            
                                           
            @if(isset($product['product_image']))
            <img src="{{$product['product_image']}}" style="width:80px;height:80px;object-fit:cover;">
            @endif
            <?php
            $color_text = '';
$size_text = '';

foreach ($product['selected_attribute_list'] as $attribute) {
    if ($attribute->attribute_name === 'Color') {
        $color_text = 'Color:' . $attribute->attribute_values;
    }

    if ($attribute->attribute_name === 'Size') {
        $size_text = 'Size:' . $attribute->attribute_values;
    }
}
            ?>
       <span class="w-100 d-block font-weight-bold mt-2"><?php echo  $product['product_name']; ?> {{$color_text}} {{$size_text}}</span></td>
      
       <td> 
       <span class="w-100 d-block font-weight-bold mt-2">Quantity:<?php echo $product['quantity']; ?></span>
       </td>
       <td> 
       <td> 
       <span class="w-100 d-block font-weight-bold mt-2">Vat:<?php echo $product['vat_amount']; ?></span>
       </td>
       <!-- <span class="w-100 d-block font-weight-bold mt-2">Admin Share:<?php echo $product['admin_share']; ?></span>
       </td>
       <td> 
       <span class="w-100 d-block font-weight-bold mt-2">Vendor Share:<?php echo $product['vendor_share']; ?></span>
       </td> -->
       <td>
       
        <span class="w-100 d-block font-weight-bold mt-2">AED <?php echo $product['price']; ?></span></td>
        </tr>
        <tr>
            <td colspan="3">
                @if(!empty($product['customer_notes']))
                    <div class="mt-1"><strong>Notes:</strong> {{ $product['customer_notes'] }}</div>
                @endif

                @if(!empty($product['customer_file']))
                    <div class="mt-1">
                        <strong>File:</strong>
                        <a href="{{ $product['customer_file'] }}" target="_blank">View</a>
                        <br>
                        <img src="{{ $product['customer_file'] }}" alt="Uploaded File" style="height:50px; margin-top:5px;">
                    </div>
                @endif
            </td>
        </tr>
        <?php
    }

   ?>
   </thead>
   </table>
   </div>
   </div>
   </div>
   </div>
   <?php
}

?>
                        </div>
                        
                
             </div>
            </div>
    </div>
@stop

@section('script')
    <script src="{{ asset('') }}admin_assets/plugins/table/datatable/datatables.js"></script>
    <script>
        $('body').off('click', '[data-role="status-change"]');
        $('body').on('click', '[data-role="status-change"]', function(e) {
            e.preventDefault();
            var msg = $(this).data('message') || 'Are you sure that you want to change status?';
            var href = $(this).attr('href');
            var detailsid = $(this).attr('detailsid');
            var statusid = $(this).attr('value');
            var title = $(this).data('title') || 'Confirm Status Change';

            App.confirm(title, msg, function() {
                var ajxReq = $.ajax({
                    url: href,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "detailsid": detailsid,
                        "statusid": statusid,
                    },
                    success: function(res) {
                        if (res['status'] == 1) {
                            App.alert(res['message'] || 'Status changed successfully', 'Success!');
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);

                        } else {
                            App.alert(res['message'] || 'Unable to change the record.',
                                'Failed!');
                        }
                    },
                    error: function(jqXhr, textStatus, errorMessage) {

                    }
                });
            });

        });
        

        $('body').off('click', '[data-role="cancel-order"]');
        $('body').on('click', '[data-role="cancel-order"]', function(e) {
            e.preventDefault();
            var msg = $(this).data('message') || 'Are you sure that you want to cancel this order?';
            var href = $(this).attr('href');
            var order_id = $(this).attr('order_id');
            var title = 'Confirm Cancel Order';

            App.confirm(title, msg, function() {
                var ajxReq = $.ajax({
                    url: href,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "order_id": order_id,
                    },
                    success: function(res) {
                        if (res['status'] == 1) {
                            App.alert(res['message'], 'Success!');
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);

                        } else {
                            App.alert(res['message'],
                                'Failed!');
                        }
                    },
                    error: function(jqXhr, textStatus, errorMessage) {

                    }
                });
            });

        });


        $('body').off('click', '[data-role="return-status-change"]');
        $('body').on('click', '[data-role="return-status-change"]', function(e) {
            e.preventDefault();
            var msg = $(this).data('message') || 'Are you sure that you want to change return status?';
            var href = $(this).attr('href');
            var detailsid = $(this).attr('detailsid');
            var statusid = $(this).attr('value');
            var title = $(this).data('title') || 'Confirm Return Status Change';

            App.confirm(title, msg, function() {
                var ajxReq = $.ajax({
                    url: href,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "detailsid": detailsid,
                        "statusid": statusid,
                    },
                    success: function(res) {
                        if (res['status'] == 1) {
                            App.alert(res['message'] || 'Successfully updated', 'Success!');
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);

                        } else {
                            App.alert(res['message'] || 'Unable to change the status.',
                                'Failed!');
                        }
                    },
                    error: function(jqXhr, textStatus, errorMessage) {

                    }
                });
            });

        });
    </script>
@stop
