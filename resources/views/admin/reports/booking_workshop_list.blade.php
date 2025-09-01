@extends("admin.template.layout")

@section("header")

@stop


@section("content")
<div class="card">

    <div class="card-body">
      <div class="row">
        <form method="get" action='' class="col-sm-12 col-md-12">
            <div id="column-filter_filter" class="dataTables_filter">
                <div class="row">
                    <div class="col-lg-3">
                        <label class="w-100">From Date:
                            <input type="date" name="from_date" class="form-control form-control-sm" id="min_date"  placeholder="" aria-controls="column-filter" value="{{$from_date}}">
                        </label>
                    </div>
                    <div class="col-lg-3">
                        <label class="w-100">To Date:
                            <input type="date" name="to_date" class="form-control form-control-sm" id="max_date"  placeholder="" aria-controls="column-filter" value="{{$to_date}}">
                        </label>
                    </div>
                    <div class="col-lg-3 ">
                        <label  class="w-100">Booking Number:
                        <input type="text" class="form-control" id="booking_number" name="booking_number" value="{{$_GET['booking_number']??''}}"
                               placeholder="Enter Booking Number">
                            </label>
                    </div>

                    <div class="col-lg-6">
                        <div class=" mt-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{url('admin/report/booking_workshops')}}"  class="btn btn-primary">Clear</a>
                            <input type="submit" name="excel" value="Export" class="btn btn-success" >
                           
                        </div>
                    </div>
                    
                </div>
                
               
                
                
                
            </div>
        </form>
      </div>
        <div class="table-responsive">
        <table class="table table-condensed table-striped" id="booking_workshop_listing">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Booking No</th>
                    <th>Customer </th>
                    <th>No of Seats </th>
                    <th>Vendor </th>
                    <th>Workshop Name</th> 
                    <th>Workshop Price</th>
                    <th>Tax</th>
                    <th>Admin Commission</th> 
                    <th>Vendor Earning</th>
                    <th>GTotal</th>
                    <th>Booking Date</th>
                </tr>
            </thead>
            <tbody>
                @if ($list->count() > 0)
               

                    
                    @foreach ($list as $item)
                        
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td> <?php echo config('global.sale_order_prefix').date(date('Ymd', strtotime($item->created_at))).$item->order_number; ?></td>
                            
                            <td>{{ $item->customer_name }}<br>{{ $item->customer_phone }}</td>
                            <td>{{ $item->number_of_seats }}</td>

                            <td>{{ $item->vendor_name }}</td>
                            <td>{{$item->service_name}}</td>

                            <td>{{$item->price}}</td>

                            <td>{{$item->tax}}</td>
                            <td>{{ $item->admin_share }}</td>
                                    <td>{{$item->vendor_share}}</td>
                            <td>{{ $item->grand_total }}</td>

                            <td>{{ get_date_in_timezone($item->booking_date, 'd-M-y h:i A') }}</td>
                            {{-- <td class="text-center">
                                <a href="{{ url('admin/booking_details/' . $item->id) }}" class="btn btn-info btn-sm"></i> Details</a>
                            </td> --}}
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
        <span>Total {{ $list->total() }} entries</span>

            <div class="col-sm-12 col-md-12 pull-right">
                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                {{-- {!! $list->links('admin.template.pagination') !!} --}}
                {!! $list->appends(request()->input())->links('admin.template.pagination') !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section("script")
 <script src="{{asset('')}}admin-assets/plugins/table/datatable/datatables.js"></script>
<link rel="stylesheet" type="text/css" href="{{asset('')}}admin-assets/plugins/table/datatable/datatables.css">
<script>
    document.getElementById("min_date").onchange = function () {
        $('#max_date').val(' ');
        var input = document.getElementById("max_date");
        input.setAttribute("min", this.value);
    }
$('#booking_workshop_listing').DataTable({
        "paging": false, 
        "lengthChange": false, 
        "searching": false, 
        "ordering": true, 
        "info": false, 
        "autoWidth": false 
    });    
</script>
@stop
