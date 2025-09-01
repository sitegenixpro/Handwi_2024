@extends("admin.template.layout")

@section("header")
    <link rel="stylesheet" type="text/css" href="{{asset('')}}admin-assets/plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="{{asset('')}}admin-assets/plugins/table/datatable/custom_dt_customer.css">
@stop


@section("content")

<style>
    #example2_info{
        display: none
    }
    /* .switch input {
        display: block;
        margin: 0 auto;
    } */
</style>
<div class="card mb-5">
    <div class="card-header"><a href="{{url('admin/customers/create')}}" class="btn-custom btn mr-2 mt-2 mb-2"><i class="fa-solid fa-plus"></i> Create Customer</a></div>
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-condensed table-striped" id="example2">
            <thead>
                <tr>
                <th>#</th>
                <th>Name</th>
                <th style="text-align: center;width:100px;">Image</th>
                <th>E-mail</th>
                <th>Phone</th>
                <th>Active</th>
                <!--<th>Wallet</th>-->
                <!--<th>Orders</th>-->
                <th>Updated</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=0; ?>
                @foreach($datamain as $datarow) 
                    <?php $i++ ?>
                    <tr>
                        <td>{{$i}}</td>
                        <td>
                            <a href="#" class="yellow-color">{{$datarow->first_name . ' '. $datarow->last_name}}</a>
                            <br>{{$datarow->is_social ? 'Social login' : ''}}
                            
                        </td>
                        <td style="width:100px; text-align: center;">
                                <span>
                                    @if($datarow->user_image)
                                    <img src="{{($datarow->user_image)}}" style="width:60px;height:60px;object-fit:cover;" class="rounded-circle" alt="User">
                                    @endif
                                </span>
                        </td>
                        <td>{{$datarow->email}}</td>
                        <td>+{{str_replace('+', '', $datarow->dial_code)}} {{$datarow->phone}}</td>
                        
                        <td>
                            <label class="switch s-icons s-outline  s-outline-warning mb-2 mt-2 mr-2">
                                        <input type="checkbox" class="change_status" data-id="{{ $datarow->id }}"
                                            data-url="{{ url('admin/customers/change_status') }}"
                                            @if ($datarow->active) checked @endif>
                                        <span class="slider round"></span>
                            </label>
                        </td>
                        <!--<td>{{$datarow->wallet_amount}}</td>-->
                        <!--<td>0</td>-->
                        <td>{{ get_date_in_timezone($datarow->updated_at, config('global.datetime_format')) }}</td>
                        <td class="text-center">
                            <div class="dropdown custom-dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="flaticon-dot-three"></i>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink7">
                                    <!-- <a href="{{ route('admin.customers.show', [$datarow->id]) }}" class="dropdown-item" userid="{{$datarow->id}}" data-role="view"><i class="flaticon-dollar-coin"></i> View </a> -->
                                    <a class="dropdown-item" href="{{url('admin/customers/'.$datarow->id.'/edit')}}"><i class="flaticon-pencil-1"></i> Edit</a>
                                     @if($datarow->email_verified != 1)<a class="dropdown-item" userid="{{$datarow->id}}" data-role="change_password" ><i class="flaticon-plus"></i> Change Password</a>@endif
                                     <a class="dropdown-item" href="{{url('admin/user/ref_history/'.$datarow->id)}}"><i class="flaticon-credit-card"></i> Referal Code History</a>
                                     <a class="dropdown-item" href="{{url('admin/user/wallet_history/'.$datarow->id)}}"><i class="flaticon-credit-card"></i> Wallet History</a>
                                    <!--<a class="dropdown-item" userid="{{$datarow->id}}" data-role="add wallet balance" data-toggle="modal" data-target="#exampleModal" onclick="set_id({{$datarow->id}})"><i class="flaticon-dollar-coin"></i> Add Wallet Balance </a>-->

                                    <!--<a class="dropdown-item" href="{{url('admin/orders?customer='.$datarow->id)}}" userid="{{$datarow->id}}" data-role="View orders"><i class="flaticon-dollar-coin"></i> Orders(0) </a>-->
                                    <a class="dropdown-item" href="{{url('admin/orders?customer='.$datarow->id)}}" data-role="View orders"><i class="flaticon-dollar-coin"></i> Orders </a>
                                   
                                    <a class="dropdown-item" data-role="unlink"
                                    data-message="Do you want to remove this Customer?"
                                    href="{{ url('admin/customers/' . $datarow->id) }}"><i
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Recharge Wallet </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form name="recharge_wallet" id="recharge_wallet" method="post" action="{{ url('admin/customers/add_wallet_balance') }}">
                <div class="modal-body">

                    <input class="form-control" type="number" required name="wallet_balance" id="wallet_balance" placeholder="0.00">
                    <input type="hidden" id="customer_id" name="customer_id">
                    @csrf
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    {{--<button type="button" class="btn btn-primary" onclick="add_wallet_balance()">Add</button>--}}
                </div>
            </form>
        </div>
    </div>
</div>

@stop

@section("script")
<script src="{{asset('')}}admin-assets/plugins/table/datatable/datatables.js"></script>
<script>
    
    function set_id( id ) {
        $("#customer_id").val(id);
    }
    
$('#example2').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        // "columnDefs": [
        //     //{ "orderable": false, "targets": [0,2,3,4,5,7] },
        //     { "orderable": true, "targets": [1, 8] }
        // ]
    });
    </script>
    <script>
        App.initFormView();
        $('body').off('click', '#recharge_wallet');
        $('body').on('submit', '#recharge_wallet', function(e) {
            e.preventDefault();
            var $form = $(this);
            var formData = new FormData(this);

            App.loading(true);
            $form.find('button[type="submit"]')
                .text('Saving')
                .attr('disabled', true);

            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: $form.attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                dataType: 'json',
                timeout: 600000,
                success: function(res) {
                    App.loading(false);

                    if (res['status'] == 0) {
                        if (typeof res['errors'] !== 'undefined') {
                            var error_def = $.Deferred();
                            var error_index = 0;
                            jQuery.each(res['errors'], function(e_field, e_message) {
                                if (e_message != '') {
                                    $('[name="' + e_field + '"]').eq(0).addClass('is-invalid');
                                    $('<div class="invalid-feedback">' + e_message + '</div>')
                                        .insertAfter($('[name="' + e_field + '"]').eq(0));
                                    if (error_index == 0) {
                                        error_def.resolve();
                                    }
                                    error_index++;
                                }
                            });
                            error_def.done(function() {
                                var error = $form.find('.is-invalid').eq(0);
                                $('html, body').animate({
                                    scrollTop: (error.offset().top - 100),
                                }, 500);
                            });
                        } else {
                            var m = res['message'];
                            App.alert(m, 'Oops!');
                        }
                    } else {
                        App.alert(res['message']);
                        setTimeout(function() {
                            window.location.href = App.siteUrl('/admin/customers');
                        }, 1500);
                    }

                    $form.find('button[type="submit"]')
                        .text('Save')
                        .attr('disabled', false);
                },
                error: function(e) {
                    App.loading(false);
                    $form.find('button[type="submit"]')
                        .text('Save')
                        .attr('disabled', false);
                    App.alert(e.responseText, 'Oops!');
                }
            });
        });


    </script>
@stop