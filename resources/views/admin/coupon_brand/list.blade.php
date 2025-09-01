@extends('admin.template.layout')

@section('header')
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin-assets/plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('') }}admin-assets/plugins/table/datatable/custom_dt_customer.css">
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            @if(GetUserPermissions('coupon_brand_create'))
            <a href="{{ url('admin/coupon_brand/create') }}" class="btn-custom btn mr-2 mt-2 mb-2"><i class="fa-solid fa-plus"></i> Create Brand</a>
            @endif
            <a href="{{ url('admin/coupon_brand/sort') }}" class="btn-custom btn mr-2 mt-2 mb-2 d-none"><i class="fa-solid fa-arrow-up-wide-short"></i> Sort</a>
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
                            <th>Brand Name</th>
                            <th>Coupons</th>
                            <th>Is Active</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        @foreach ($datamain as $row)
                        
                            <?php $i++; ?>
                            <tr>
                                <td>{{ $i }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span>
                                            @if ($row->image != '')
                                                <img id="image-preview" style="width:100px; height:90px;"
                                                    class="img-responsive mb-2" data-image="{{asset($row->image) }}"
                                                    src="{{ asset($row->image) }}">
                                            @endif
                                        </span>
                                        <span class="ml-3">
                                            <a href="#" class="yellow-color">{{ $row->name }}</a>
                                            <div>{{ $row->industry }}</div>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    
                                    {{$row->coupon()}}
                                </td> 
                                <!-- <td>
                                    {{ $row->name }}
                                </td>
                                <td>{{ $row->industry }}</td>
                                <td>
                                    @if ($row->image != '')
                                        <img id="image-preview" style="width:100px; height:90px;"
                                            class="img-responsive mb-2" data-image="{{asset($row->image) }}"
                                            src="{{ asset($row->image) }}">
                                    @endif
                                </td> -->
                               
                                <td>
                                    <label class="switch s-icons s-outline  s-outline-warning  mb-4 mr-2">
                                        <input type="checkbox" class="change_status" data-id="{{ $row->id }}"
                                            data-url="{{ url('admin/coupon_brand/change_status') }}"
                                            @if ($row->active) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    {{web_date_in_timezone($row->created_at,'d-M-Y h:i A')}}</td>
                                <td class="text-center">
                                    <div class="dropdown custom-dropdown">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink7"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <i class="flaticon-dot-three"></i>
                                        </a>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink7">
                                            @if(GetUserPermissions('coupon_brand_edit'))
                                            <a class="dropdown-item"
                                                href="{{ url('admin/coupon_brand/edit/' . $row->id) }}"><i
                                                    class="flaticon-pencil-1"></i> Edit</a>
                                            @endif
                                            @if(GetUserPermissions('coupon_brand_delete'))
                                            <a class="dropdown-item" data-role="unlink"
                                                data-message="Do you want to remove this category?"
                                                href="{{ url('admin/coupon_brand/delete/' . $row->id) }}"><i
                                                    class="flaticon-delete-1"></i> Delete</a>
                                            @endif
                                            @if(GetUserPermissions('coupon_view'))
                                            <a class="dropdown-item" 
                                                href="{{ url('admin/coupons_voucher/?brand=' . $row->id) }}"><i class="flaticon-view"></i> {{$row->coupon()}} Coupons</a>
                                            @endif
                                            @if(GetUserPermissions('coupon_view'))
                                            <a class="dropdown-item" 
                                                href="{{ url('admin/coupons_voucher/create?brand=' . $row->id) }}"><i class="flaticon-plus"></i> Add Coupon</a>         
                                            @endif
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
