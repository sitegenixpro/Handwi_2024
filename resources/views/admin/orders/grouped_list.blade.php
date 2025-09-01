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
                               
                                <th>Vendor </th>
                               
                                
                                
                                <th>Order Status</th> 
                                <th>Order Date</th> 
                                {{-- <th>Status</th>  --}}
                                <!-- <th>Created Date</th> -->
                                <th>Prodcts</th>
                                
                            </tr>
                        </thead>

                           
                         <tbody>
                        @if ($list)
                                @php
                                $i=0;
                                @endphp
                            @foreach ($list as $item)
                            @php
                            $i++;
                            @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td> <?php echo config('global.sale_order_prefix').date(date('Ymd', strtotime($item['order_created_at']	))).$item['order_id']; ?></td>
                                    
                                    <td>{{$item['store_name']}}</td>
                                  
                                    <td>{{$item['status']  }}</td>
                                    <td>{{ get_date_in_timezone($item['order_created_at'], 'd-M-y h:i A') }}</td>
                                    
                                    
                                    <td class="text-center">
                                        @foreach($item['products'] as $product)
                                         
                                         {{implode(',',$product)}}
                                         
                                         
                                        @endforeach
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