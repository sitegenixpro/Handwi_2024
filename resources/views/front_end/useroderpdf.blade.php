<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Document</title>
    </head>
    <body style="background-color: #FFF;">
        <div class="dataTables_wrapper container-fluid dt-bootstrap4">
            <div class="order-totel-details">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="">
                                    <img src="https://handwi.com/public/front_end/assets/images/handwi-logo-black.svg" alt="" style="max-width: 190px; margin-bottom: 20px;" />
                                    <?php $ordernumber = config('global.sale_order_prefix').date(date('Ymd', strtotime($list[0]->created_at))).$list[0]->order_id; ?>
                                    <h5>Order NO: {{$ordernumber}}</h5>
                                    <div class="table-responsive">
                                        <table width="100%" style="border-spacing: 0px;">
                                            <thead>
                                                <tr>
                                                    <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">Order No: <span class="w-100 d-block font-weight-bold mt-2">{{$ordernumber}}</span></td>
                                                    <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">
                                                        Customer: <span class="w-100 d-block font-weight-bold mt-2">{{$list[0]->name??$list[0]->customer_name}}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;" colspan="2">
                                                        Delivery Address :
                                                        <span class="w-100 d-block font-weight-bold mt-2">
                                                            @if(!empty($list[0]->shipping_address))
                                                            <?php $shipdata = \App\Models\UserAdress::get_address_details($list[0]->address_id) ??[];//$list[0]->shipping_address; ?> @if(request()->test1) @dd($shipdata) @endif
                                                            <!--{{$shipdata->address}}, <br>-->
                                                            {{$shipdata->apartment??''}} <br />
                                                            {{$shipdata->building_name??''}}<br />
                                                            {{$shipdata->street??''}}<br />

                                                            {{$shipdata->area_name}}<br />
                                                            {{$shipdata->city_name}}<br />
                                                            {{$shipdata->country_name}}<br />
                                                            {{$shipdata->land_mark}}<br />
                                                            <br />
                                                            @elseif($list[0]->order_type == 1) Pick Up @else @endif
                                                        </span>
                                                    </td>

                                                    <td></td>
                                                </tr>

                                                @if($list[0]->order_type == 1)
                                                <tr>
                                                    <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">
                                                        Order Date: <span class="w-100 d-block font-weight-bold mt-2">{{ $list[0]->pick_up_date ? date('d-M-y',strtotime($list[0]->pick_up_date)) : '-' }}</span>
                                                    </td>

                                                    <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">
                                                        Order Time: <span class="w-100 d-block font-weight-bold mt-2">{{ $list[0]->pick_up_time ? $list[0]->pick_up_time : '-' }}</span>
                                                    </td>
                                                </tr>
                                                @endif

                                                <tr>
                                                    <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">
                                                        Created on: <span class="w-100 d-block font-weight-bold mt-2">{{get_date_in_timezone($list[0]->created_at,'d-M-Y h:i A')}}</span>
                                                    </td>
                                                    <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">
                                                        Sale Amount: <span class="w-100 d-block font-weight-bold mt-2">{{number_format($list[0]->total, 2, '.', '')}}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">VAT: <span class="w-100 d-block font-weight-bold mt-2">{{number_format($list[0]->vat, 2, '.', '')}}</span></td>
                                                    <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">
                                                        Discount: <span class="w-100 d-block font-weight-bold mt-2">{{number_format($list[0]->discount, 2, '.', '')}}</span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">
                                                        Sub Total: <span class="w-100 d-block font-weight-bold mt-2">{{number_format(($list[0]->total- $list[0]->discount) + $list[0]->vat, 2, '.', '')}}</span>
                                                    </td>
                                                    <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">
                                                        Grand Total: <span class="w-100 d-block font-weight-bold mt-2">{{number_format($list[0]->grand_total, 2, '.', '')}} </span>
                                                    </td>
                                                </tr>
                                                {{--
                                                <tr>
                                                    <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">Shipping Charge</td>
                                                    <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">: {{number_format('0', 2, '.', '')}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">Service Charge</td>
                                                    <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">: {{number_format('0', 2, '.', '')}}</td>
                                                </tr>
                                                --}}

                                                <tr>
                                                    <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">
                                                        Delivery Charge: <span class="w-100 d-block font-weight-bold mt-2">{{number_format($list[0]->shipping_charge, 2, '.', '')}}</span>
                                                    </td>
                                                    <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">
                                                        Service charge: <span class="w-100 d-block font-weight-bold mt-2">{{number_format($list[0]->service_charge, 2, '.', '')}}</span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">
                                                        Payment Mode: <span class="w-100 d-block font-weight-bold mt-2">{{payment_mode($list[0]->payment_mode)}}</span>
                                                    </td>
                                                   
                                                </tr>

                                               
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="page-header">
                            <div class="page-title">
                                <h3 style="margin-bottom: 0; padding: 5px; background: #000; color: #fff">Sub Orders</h3>
                            </div>
                        </div>
                        <?php
              $count=1;
                          
                          foreach ($sub_orders as $vendorId =>
                        $vendorProducts) { ?>
                        
                        
                        <div class="table-responsive">
                            <table width="100%" style="border-spacing: 0px; margin-bottom: 20px;">
                                <tbody>


                                  <tr>
                                    <td colspan="2" style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">Order NO: {{$ordernumber}}#{{$count}}</td>
                                      <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">Vendor Name: {{$vendorProducts->vendorName}}</td>
                                        <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">Status: {{$vendorProducts->order_status_text}}</td>
                                  </tr>

                                  <?php
                            $count++;
                            ?>

                                    <?php

foreach ($vendorProducts->productList as $product) { ?>
                                    <tr>
                                        <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle; width: 80px;">
                                            @if(isset($product['product_image']))
                                            <img src="{{$product['product_image']}}" style="width: 80px; height: 80px; object-fit: cover;" />
                                            @endif
                                        </td>
                                        <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle; width: 50%;">
                                            <?php
$color_text = '';
$size_text = '';

foreach ($product['selected_attribute_list'] as $attribute) {
if ($attribute->attribute_name === 'Color') { $color_text = 'Color:' . $attribute->attribute_values; } if ($attribute->attribute_name === 'Size') { $size_text = 'Size:' . $attribute->attribute_values; } } ?>
                                            <p>
                                                <?php echo  $product['product_name']; ?>
                                                {{$color_text}} {{$size_text}}
                                            </p>
                                        </td>

                                        <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle; text-align: center;">
                                            <span class="w-100 d-block font-weight-bold mt-2">Quantity:<?php echo $product['quantity']; ?></span>
                                        </td>
                                        <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle; text-align: right;">
                                            <span class="w-100 d-block font-weight-bold mt-2">
                                                AED
                                                <?php echo $product['price']; ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php
}

?>
                                </tbody>
                            </table>
                        </div>
                        <?php
}

?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
