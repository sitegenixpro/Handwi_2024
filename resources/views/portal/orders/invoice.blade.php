


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
                            
                            <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">{{$list[0]->name??$list[0]->customer_name}}</td>
                        </tr>
                        
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

                        
                        @if($list[0]->order_type == 1)
                        <tr>
                            
                            <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">
                                                        Order Date: <span class="w-100 d-block font-weight-bold mt-2">{{ $list[0]->pick_up_date ? date('d-M-y',strtotime($list[0]->pick_up_date)) : '-' }}</span>
                                                    </td>

                                                    <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">
                                                        Order Time: <span class="w-100 d-block font-weight-bold mt-2">{{ $list[0]->pick_up_time ? $list[0]->pick_up_time : '-' }}</span>
                                                    </td>
                                                     <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">
                                                        Created on: <span class="w-100 d-block font-weight-bold mt-2">{{get_date_in_timezone($list[0]->created_at,'d-M-Y h:i A')}}</span>
                                                    </td>
                        </tr>
                        @endif
                        <tr>
                           
                            
                            <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">Sale Amount: <span class="w-100 d-block font-weight-bold mt-2">{{number_format($list[0]->total, 2, '.', '')}}</span></td>
                            <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">VAT: <span class="w-100 d-block font-weight-bold mt-2">{{number_format($list[0]->vat, 2, '.', '')}}</span></td>
                        <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">Coupon Discount: <span class="w-100 d-block font-weight-bold mt-2">{{number_format($list[0]->discount, 2, '.', '')}}</span></td>
                           
                        </tr>
                        
                        <tr>
                            
                            <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">Sub Total: <span class="w-100 d-block font-weight-bold mt-2">{{number_format(($list[0]->total - $list[0]->discount) + $list[0]->vat, 2, '.', '')}}</span></td>
                        
                            <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">Service charge: <span class="w-100 d-block font-weight-bold mt-2">{{number_format($list[0]->service_charge, 2, '.', '')}}</span>
                            
                            </td>
                            
                            <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">Shipping Charge: <span class="w-100 d-block font-weight-bold mt-2">{{number_format($list[0]->shipping_charge, 2, '.', '')}}</span> </td>
                        </tr>
                        <tr>
                            
                            
                            <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">Payment Mode:<span class="w-100 d-block font-weight-bold mt-2">{{payment_mode($list[0]->payment_mode)}}</span>
                            
                            </td>
                            
                            <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">Grand Total: <span class="w-100 d-block font-weight-bold mt-2">{{number_format($list[0]->grand_total, 2, '.', '')}}</span> </td>
                            
                            <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">Status: 
                            
                             @if($list[0]->status != config('global.order_status_cancelled'))
                                                {{-- <div class="checkbox-dsign-order-select">
                                                    <input type="checkbox">
                                                    <label>Select</label>
                                                </div> --}}
                                                    {{-- <button type="button" class="btn btn-danger">Cancel</button> --}}
                                                     @if($list[0]->status != config('global.order_status_cancelled') || $list[0]->status != config('global.order_status_delivered'))
                                                    @if($list[0]->status == config('global.order_status_pending'))
                                                        <span class="btn btn-warning" data-role="status-change" href="{{url('portal/order/change_status')}}" detailsid="{{$list[0]->order_id}}" value="{{config('global.order_status_accepted')}}" >Accept</span>
                                                        <span class="btn btn-danger" data-role="status-change" href="{{url('admin/order/change_status')}}" detailsid="{{$list[0]->order_id}}" value="{{config('global.order_status_cancelled')}}" >cancel</span>
                                                    @endif

                                                    @if($list[0]->status == config('global.order_status_accepted'))
                                                        <span class="btn btn-design" data-role="status-change" href="{{url('portal/order/change_status')}}" detailsid="{{$list[0]->order_id}}" value="{{config('global.order_status_ready_for_delivery')}}" >Ready for Delivery</span>
                                                        <!-- <span class="btn btn-danger" data-role="status-change" href="{{url('admin/order/change_status')}}" detailsid="{{$list[0]->order_id}}" value="{{config('global.order_status_cancelled')}}" >cancel</span> -->
                                                    @endif

                                                    @if($list[0]->status == config('global.order_status_ready_for_delivery'))
                                                        <span class="btn btn-info" data-role="status-change" href="{{url('portal/order/change_status')}}" detailsid="{{$list[0]->order_id}}" value="{{config('global.order_status_dispatched')}}" >Dispatched</span>
                                                        <!-- <span class="btn btn-danger" data-role="status-change" href="{{url('admin/order/change_status')}}" detailsid="{{$list[0]->order_id}}" value="{{config('global.order_status_cancelled')}}" >cancel</span> -->
                                                    @endif

                                                    @if($list[0]->status == config('global.order_status_dispatched'))
                                                        <span class="btn btn-success" data-role="status-change" href="{{url('portal/order/change_status')}}" detailsid="{{$list[0]->order_id}}" value="{{config('global.order_status_delivered')}}" >Delivered</span>
                                                        <!-- <span class="btn btn-danger" data-role="status-change" href="{{url('admin/order/change_status')}}" detailsid="{{$list[0]->order_id}}" value="{{config('global.order_status_cancelled')}}" >cancel</span> -->
                                                    @endif
                                                     @endif
                                                @endif
                            
                            
                            </td>
                        </tr>
                        
                        <tr>
                            
                            
                            
                        </tr>
                        
                       
                       
                    </thead>

                </table>
                </div>
                    </div>
                    </div>
                    </div>
                </div>
                <div class="order-totel-details">
                <div class="card">
                <div class="card-body">
                <!-- <div class="col-sm-12" style="padding-top: 20px;">
                <?php if(sizeof($list[0]->order_products)) { ?>
                <h4>Order Items <a href="{{ url('admin/order_edit/1')}}">edit</a></h4>
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">Image</td>
                            <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">Vendor</td>
                            <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">Item</td>
                            <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">Quantity</td>
                           {{-- <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">Discount</td>--}}
                           <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;"> Shipping Charge </td>
                            <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">Total</td>
                            <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">Change Status</td>
                            <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle;">Status</td>
                            
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($list[0]->order_products as $datavalue) { ?>
                           <tr>
                            <td>
                                @if($datavalue->product_images)
                                <img src="{{$datavalue->product_images[0]}}" style="width:100px;height:100px;object-fit:cover;">
                                @endif</td>
                            <td>{{$datavalue->name}}</td>
                            <td>{{$datavalue->product_name}}</td>
                            <td>{{$datavalue->order_qty}}</td>
                            {{--<td>{{$datavalue->order_discount}}</td>--}}
                            <td>{{ number_format($datavalue->shipping_charge,2) }}</td>
                            <td>{{$datavalue->order_total}}{{config('global.site_name')}}</td> 
                            <td></td>
                            <td>{{order_status($datavalue->order_status)}}</td>
                           </tr>
                    
                    <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
             
               </div> -->
                <div class="order-page-infomatics">

                     <div class="row">
                                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="action-divs d-flex align-items-center">
                                               

                                            </div>
                                        </div></div>
                    <div class="product-headeing-title">
                                        <h4>Products</h4>
                                    </div>
                    <?php if(sizeof($list[0]->order_products)) { ?>
                    <form>
                        <div class="action-divs d-flex align-items-center">
                            
                           
                        </div>
                        <div class="product-order-details-div">
                            <?php foreach($list[0]->order_products as $datavalue) { ?>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 mb-3">
                                    
                                    <div class="product_details-flex d-flex">
                                        
                                        <table width="100%" style="border-spacing: 0px; margin-bottom: 0px;">
                                            <tbody>
            
            
                                              <tr>
                                                
                                                <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle; width:100px; text-align: center;">
                                                    @if($datavalue->product_images)
                                                    <img src="{{$datavalue->product_images[0]}}" style="width:100px;height:100px;object-fit:cover;">
                                                    @endif
                                                </td>
                                                <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle; width: 30%; text-align: center;" >
                                                    {{$datavalue->product_name}}
                                                </td>
                                                @if(isset($datavalue->attribute_name) && $datavalue->attribute_name)
                                                    
                                                    @endif
                                                    @if(isset($datavalue->selected_attribute_list) && !empty($datavalue->selected_attribute_list))
                                                <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle; text-align: center;">
                                                    
                                                        @foreach($datavalue->selected_attribute_list as $variation)
                                                                <b>{{$variation->attribute_name}}</b>: {{$variation->attribute_values}}
                                                        @endforeach
                                                      
                                                </td>
                                                 @endif 
                                                <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle; text-align: center;">
                                                    <b>Quantity: </b> {{$datavalue->order_qty}}
                                                </td>
                                                <td style="border: 1px solid #eee; padding: 10px; vertical-align: middle; text-align: center;">
                                                    <b>Total: </b> {{$datavalue->order_total}}
                                                </td>
                                              </tr>
                                              
                                              </tbody>
                            </table>
                                        
                                    </div>
                                </div>
                                
                            </div>
                            <?php } ?>
                        </div>
                    </form>
                    <?php } ?>
                </div>
            </div>
            </div>
             </div>
            </div>
    </body>
</html>



