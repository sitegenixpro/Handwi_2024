@extends('front_end.template.layout')
@section('content')
<div class="container">
<div class="order-detail-page row">
            <div class="dataTables_wrapper container-fluid dt-bootstrap4">
          
                
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
                                                        @if(request()->test1)
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
                                                        <td >Order Date:
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
                                                        <td>Admin Earning:
                                                            <span class="w-100 d-block font-weight-bold mt-2"> {{number_format($list[0]->admin_commission, 2, '.', '')}}</span></td>
                                                    
                                                    </tr>

                                                    <tr>
                                                    
                                                        <td>Vendor Earning: 
                                                        <span class="w-100 d-block font-weight-bold mt-2">{{number_format($list[0]->vendor_commission, 2, '.', '')}} </span></td>
                                                        <td></td>
                                                        <!--<td>Invoice: -->
                                                        <!--<span class="w-100 d-block font-weight-bold mt-2"><a href="{{get_pdf_url($ordernumber)}}" target="_blank"><button type="button" class="btn btn-primary">View Invoice</button></a></span></td>-->
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
       <div class="cart__meta-text mt-2">
                @if(!empty($product['customer_notes']) || !empty($product['customer_file']))
                    <!-- Display customer notes -->
                    @if(!empty($product['customer_notes']))
                        <div class="text-muted small mb-1">
                            <strong>Note:</strong> {{$product['customer_notes']}}
                        </div>
                    @endif
                    
                    <!-- Display customer file -->
                    @if(!empty($product['customer_file']))
                        @php
                            $ext = pathinfo($product['customer_file'], PATHINFO_EXTENSION);
                            $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                        @endphp
                        <div class="small">
                            <strong>File:</strong>
                            @if($isImage)
                                <div class="mt-1">
                                    <img src="{{ $product['customer_file'] }}" alt="Uploaded file" style="max-height: 100px; border: 1px solid #ddd;">
                                </div>
                            @else
                                <a href="{{ $product['customer_file'] }}" target="_blank" class="text-primary text-decoration-underline">
                                    View Uploaded File
                                </a>
                            @endif
                        </div>
                    @endif
                @endif
            </div>
       <td> 
       <span class="w-100 d-block font-weight-bold mt-2">Quantity:<?php echo $product['quantity']; ?></span>
       </td>
       <td>
       
        <span class="w-100 d-block font-weight-bold mt-2">AED <?php echo $product['price']; ?></span></td>
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
    </div>
    </div>
            
            @endsection 

