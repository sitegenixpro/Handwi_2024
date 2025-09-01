@extends("admin.template.layout")

@section('header')
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin_assets/plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('') }}admin_assets/plugins/table/datatable/custom_dt_customer.css">
@stop


@section('content')
    <div class="card mb-5">
        <div class="card-body">
            <div class="row">
           
                <form action="" method="get" class="col-sm-12 col-md-12">
                    <div id="column-filter_filter" class="dataTables_filter">
                        <input type="hidden" name="activity"  value="{{request()->activity}}">
                        <div class="row">
                            <div class="col-lg-3">
                                <label class="w-100">From Date:
                                    <input type="date" name="from_date" class="form-control form-control-sm " id="min_date" placeholder="" aria-controls="column-filter" value="{{$from}}">
                                </label>
                            </div>
                            <div class="col-lg-3">
                                <label class="w-100">To Date:
                                    <input type="date" name="to_date" class="form-control form-control-sm " id="max_date" placeholder="" aria-controls="column-filter" value="{{$to}}">
                                </label>
                            </div>
                            <div class="col-md-6">
                                        <label for="container_in" class="form-label mb-0">Order Number</label>
                                        <input type="text" class="form-control" id="order_number" name="order_number" value="{{$_GET['order_number']??''}}"
                                               placeholder="Enter Order Number">
                                    </div>
        
                            <div class="col-lg-6">
                                <div class=" mt-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    
                                    <a href="{{url('admin/report/orders')}}?activity={{request()->activity}}"  class="btn btn-primary">Clear</a>
                                    <input type="submit" name="excel" value="Export" class="btn btn-success" >
                                </div>
                            </div>
                            
                        </div>
                    {{-- <label>From Date:
                    <input type="date" name="from_date" class="form-control form-control-sm" placeholder="" aria-controls="column-filter" value="{{$from}}">
                </label>
                <label>To Date:
                    <input type="date" name="to_date" class="form-control form-control-sm" placeholder="" aria-controls="column-filter" value="{{$to}}">
                </label>
                <button type="submit" class="btn btn-primary">Submit</button>
                <input type="submit" name="excel" value="Export" class="btn btn-primary" >
                <a href="{{url('admin/earnings')}}"  class="btn btn-primary">Clear</a> --}}
                </div>
                </form>
            </div>    
                   
                    <div class="table-responsive">
                    <table class="table table-condensed table-striped" id="orders_report_listing1">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Order No</th>
                                
                                <th>Customer</th>
                                <th>Vendor Name</th>
                                <th>Product Name</th>
                                <th>Product Price</th>
                                <th>Product Quantity</th>
                                <th>Product VAT</th>
                                <th>Subtotal</th>
                                <th>Discount</th>
                                <th>Grand Total</th>
                                <th>VAT</th>
                                <th>Admin Share</th>
                                <th>Vendor Share</th>
                                
                               
                             
                               
                                
                                <th>Payment Mode</th> 
                                <th>Delivery Mode</th> 
                                <th>Order Status</th>  
                                <!-- <th>Created Date</th> -->
                                <th>Booking Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                         <tbody>
                        @if ($list->total() > 0)
                       

                            <?php $i = $list->perPage() * ($list->currentPage() - 1); ?>
                            @foreach ($list as $item)
                            @foreach ($item->order_product as $product)
                                <?php     $i++; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <!-- <td>{{ $item->order_id }}</td> -->
                                    <td> <?php echo config('global.sale_order_prefix').date(date('Ymd', strtotime($item->created_at))).$item->order_id; ?></td>
                                    
                                    <td>{{ $item->customer_name }} <br> {{ $item->customer_mobile }}</td>
                                    <td>{{ $product->store_name }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->vat_amount }}</td>
                                    <td>{{ $product->total + $product->vat_amount }}</td>
                                    <td>{{ $item->discount }}</td>
                                    <td>{{ $item->grand_total }}</td>
                                    <td>{{ $item->vat }}</td>
                                    <td>{{ $product->admin_commission ?? 0 }}</td>
                                    <td>{{ $product->vendor_commission ?? 0 }}</td>
                                    
                                  
                                  
                                   
                                    <td>{{payment_mode($item->payment_mode)}}</td>
                                    <td>{{order_type($item->order_type)}}</td>
                                     <td>{{ order_status($item->status) }}</td>
                                    <!-- <td>{{ get_date_in_timezone($item->created_at, 'd-M-y h:i A') }}</td> -->
                                    <td>{{ get_date_in_timezone($item->created_at, 'd-M-y h:i A') }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('admin/order_details/' . $item->order_id) }}" class="btn btn-info btn-sm"></i> Details</a>
                                    </td>
                                </tr>
                                @endforeach
                            @endforeach
                             @else
                             <tr><td colspan="12" align="center" class="pt-2 p-0">
                        
                        <div class="alert alert-warning">
                            <p>No Record Found</p>
                        </div>
                    </td>
                </tr>
                    @endif
                        </tbody>
                       
                    </table>
                </div>


                    <div class="col-sm-12 col-md-12 pull-right">
                        <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                            {!! $list->links('admin.template.pagination') !!}
                        </div>
                    </div>

                
            </div>
        </div>
    </div>
@stop

@section('script')
 <script src="{{asset('')}}admin-assets/plugins/table/datatable/datatables.js"></script>
<link rel="stylesheet" type="text/css" href="{{asset('')}}admin-assets/plugins/table/datatable/datatables.css">
<script>
    document.getElementById("min_date").onchange = function () {
        $('#max_date').val(' ');
        var input = document.getElementById("max_date");
        input.setAttribute("min", this.value);
    }
$('#orders_report_listing1').DataTable({
        "paging": false, 
        "lengthChange": false, 
        "searching": false, 
        "ordering": true, 
        "info": false, 
        "autoWidth": false 
    });  


</script>@stop