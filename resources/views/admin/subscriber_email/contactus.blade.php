@extends('admin.template.layout')

@section('header')
<link rel="stylesheet" type="text/css" href="{{asset('')}}admin_assets/plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="{{asset('')}}admin_assets/plugins/table/datatable/custom_dt_customer.css">
@stop

@section('content')
    <div class="card mb-5">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Total: <b class="primary-color">{{$subscriberemails->count()}}</b> Contact Us Queries</h3>
            <!-- <a href="{{ url('admin/subscriberemailsexport') }}" class="btn btn-primary">Export</a>  -->
        </div>
        
        <div class="card-body">
            <div class="row">
       
      </div>
            <!-- <p>Total: {{$subscriberemails->count()}} Testimonials</p> -->
            <div class="table-responsive">
                <table class="table table-condensed table-striped table-bordered" id="example2">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Subject</th>
                            <th>Message</th>

                            <th>Created Date</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        @foreach ($subscriberemails as $category)
                            <?php $i++; ?>
                            <tr>
                                <td>{{ $i }}</td>
                             
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->email }}</td>
                                <td>{{ $category->mobile_number }}</td>
                                <td>{{ $category->subject }}</td>
                                <td>{{ $category->message }}</td>
                               
                                  
                                <td>{{web_date_in_timezone($category->created_at,config('global.datetime_format'))}}</td>
                         

                           

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script src="{{asset('')}}admin-assets/plugins/table/datatable/datatables.js"></script>
<link rel="stylesheet" type="text/css" href="{{asset('')}}admin-assets/plugins/table/datatable/datatables.css">
    <script>
        $('#example2').DataTable({
            "paging": true,
            "searching": true,
            
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });
    </script>
@stop
