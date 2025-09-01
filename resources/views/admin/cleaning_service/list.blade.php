@extends('admin.template.layout')

@section('header')
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin-assets/plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('') }}admin-assets/plugins/table/datatable/custom_dt_customer.css">
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ url('admin/cleaning-service/create') }}" class="btn-custom btn mr-2 mt-2 mb-2"><i class="fa-solid fa-plus"></i> Create Cleaning Service</a>
{{--            <a href="{{ url('admin/brand/sort') }}" class="btn-custom btn mr-2 mt-2 mb-2 d-none"><i class="fa-solid fa-arrow-up-wide-short"></i> Sort</a>--}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-condensed table-striped" id="example2">
                    <thead>
                    <tr>
                        <th>#</th>
                        <!-- <th>Brand Name</th>
                        <th>Industry type</th>
                        <th>Image</th> -->
                        <th>Cleaning Service</th>
{{--                        <th>Is Active</th>--}}
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    @foreach ($cleaning_services as $cleaning_service)
                            <?php $i++; ?>
                        <tr>
                            <td>{{ $i }}</td>
{{--                            <td>--}}
{{--                                <div class="d-flex align-items-center">--}}
{{--                                        <span>--}}
{{--                                            @if ($row->image != '')--}}
{{--                                                <img id="image-preview" style="width:100px; height:90px;"--}}
{{--                                                     class="img-responsive mb-2" data-image="{{asset($row->image) }}"--}}
{{--                                                     src="{{ asset($row->image) }}">--}}
{{--                                            @endif--}}
{{--                                        </span>--}}
{{--                                    <span class="ml-3">--}}
{{--                                            <a href="#" class="yellow-color">{{ $row->name }}</a>--}}
{{--                                            <div>{{ $row->industry }}</div>--}}
{{--                                        </span>--}}
{{--                                </div>--}}
{{--                            </td>--}}
                            <td>{{$cleaning_service->title}}</td>

{{--                            <td>--}}
{{--                                <label class="switch s-icons s-outline  s-outline-warning  mb-4 mr-2">--}}
{{--                                    <input type="checkbox" class="change_status" data-id="{{ $row->id }}"--}}
{{--                                           data-url="{{ url('admin/category/change_status') }}"--}}
{{--                                           @if ($row->active) checked @endif>--}}
{{--                                    <span class="slider round"></span>--}}
{{--                                </label>--}}
{{--                            </td>--}}
                            <td>{{ get_date_in_timezone($cleaning_service->created_at, config('global.datetime_format')) }}</td>
                            <td class="text-center">
                                <div class="dropdown custom-dropdown">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink7"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <i class="flaticon-dot-three"></i>
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink7">
                                        <a class="dropdown-item"
                                           href="{{ url('admin/cleaning-service/edit/'.$cleaning_service->id) }}"><i
                                                class="flaticon-pencil-1"></i> Edit</a>
                                        <a class="dropdown-item" data-role="unlink"
                                           data-message="Do you want to remove this cleaning services?"
                                           href="{{url('admin/cleaning-service/delete/'.$cleaning_service->id) }}"><i
                                                class="flaticon-delete-1"></i> Delete</a>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script src="{{ asset('') }}admin-assets/plugins/table/datatable/datatables.js"></script>
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
