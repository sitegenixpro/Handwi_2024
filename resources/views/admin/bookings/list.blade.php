@extends("admin.template.layout")

@section('header')
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin_assets/plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('') }}admin_assets/plugins/table/datatable/custom_dt_customer.css">
@stop


@section('content')
    <div class="card">
        <div class="card-body">
            <div class="dataTables_wrapper container-fluid dt-bootstrap4">
              
                

                    

                    <div class="row mt-3 d-none">
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_length" id="column-filter_length">
                            </div>
                        </div>

                        
                    </div>
                    <div class="table-responsive">
                    <table class="table table-condensed table-striped" id="orders_listing">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order No</th>
                                <!-- <th>Order ID</th> -->
                                <th>Customer </th>
                            
                                <th>Vendor Name </th>
                                <th>Workshop Name</th>
                                <th>Workshop Price</th>
                                <th>Admin Commission</th> 
                                <th>Vendor Earning</th>
                                <!-- <th>Shipping Charge</th> -->
                                <th>Total</th>
                                
                                <th>Order Status</th> 
                                {{-- <th>Status</th>  --}}
                                <!-- <th>Created Date</th> -->
                                <th>Booking Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                           
                         <tbody>
                        @if ($list->count() > 0)
                       

                            
                            @foreach ($list as $item)
                                
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td> <?php echo config('global.sale_order_prefix').date(date('Ymd', strtotime($item->created_at))).$item->order_number; ?></td>
                                    
                                    <td>{{ $item->customer_name }}</td>
                                
                                    <td>{{ $item->vendor_name }}</td>
                            <td>{{$item->service_name}}</td>

                            <td>{{$item->price}}</td>
                                    <td>{{ $item->admin_share }}</td>
                                    <td>{{$item->vendor_share}}</td>
                                    
                                    <td>{{ $item->grand_total }}</td>
                                    
                                    <td>Confirmed</td>
                                    <td>{{ get_date_in_timezone($item->order_date, 'd-M-y h:i A') }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('admin/booking_details/' . $item->id) }}" class="btn btn-info btn-sm"></i> Details</a>
                                    </td>
                                </tr>
                            @endforeach
                             @else
                             <tr><td colspan="12" align="center" class="pt-2 p-0">
                        
                        <div class="alert alert-warning">
                            <p>No Orders found</p>
                        </div>
                    </td>
                </tr>
                    @endif
                        </tbody>
                       
                    </table>
                </div>


                  

                
            </div>
        </div>
    </div>

   
@stop

@section('script')
    <script src="{{asset('')}}admin-assets/plugins/table/datatable/datatables.js"></script>
<link rel="stylesheet" type="text/css" href="{{asset('')}}admin-assets/plugins/table/datatable/datatables.css">
<script>
$('#orders_listing').DataTable({
        "paging": false, 
        "lengthChange": false, 
        "searching": false, 
        "ordering": true, 
        "info": false, 
        "autoWidth": false 
    });    
</script>
@stop