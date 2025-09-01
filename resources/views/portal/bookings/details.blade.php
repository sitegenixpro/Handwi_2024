@extends("admin.template.layout")

@section('header')
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin_assets/plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('') }}admin_assets/plugins/table/datatable/custom_dt_customer.css">
    <style>
        td {
            padding-top: 8px;
            padding-bottom: 8px;
        }
        .order-totel-details thead tr:last-child{
            border-bottom: none;
        }
    </style>
@stop


@section('content')
<div class="order-detail-page row">
    <div class="dataTables_wrapper container-fluid dt-bootstrap4">
        <div class="row">
            <div class="col-lg-8">
                <div class="order-totel-details">
                    <div class="card">
                        <div class="card-body">
                            <div class="">
                                <!-- Display Booking Information -->
                                <h5>Booking No: {{$booking->order_number}}</h5>
                                <div class="table-responsive">
                                    <table width="100%">
                                        <thead>
                                            <tr>
                                                <td>Booking No:
                                                    <span class="w-100 d-block font-weight-bold mt-2">{{$booking->order_number}}</span>
                                                </td>
                                                <td>Customer:
                                                    <span class="w-100 d-block font-weight-bold mt-2">{{$booking->customer_name}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Customer Email:
                                                    <span class="w-100 d-block font-weight-bold mt-2">{{$booking->customer_email}}</span>
                                                </td>
                                                <td>Customer Phone:
                                                    <span class="w-100 d-block font-weight-bold mt-2">{{$booking->customer_phone}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Service Name:
                                                    <span class="w-100 d-block font-weight-bold mt-2">{{$booking->service_name}}</span>
                                                </td>
                                                <td>Booking Date:
                                                    <span class="w-100 d-block font-weight-bold mt-2">{{date('d-M-Y h:i A', strtotime($booking->booking_date))}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Seats Booked:
                                                    <span class="w-100 d-block font-weight-bold mt-2">{{$booking->seat_no}}</span>
                                                </td>
                                                <td>Number of Seats:
                                                    <span class="w-100 d-block font-weight-bold mt-2">{{$booking->number_of_seats}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Price Per Seat:
                                                    <span class="w-100 d-block font-weight-bold mt-2">{{number_format($booking->price, 2, '.', '')}}</span>
                                                </td>
                                                <td>Service Charge:
                                                    <span class="w-100 d-block font-weight-bold mt-2">{{number_format($booking->service_charge ?? 0, 2, '.', '')}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tax:
                                                    <span class="w-100 d-block font-weight-bold mt-2">{{number_format($booking->tax, 2, '.', '')}}</span>
                                                </td>
                                                <td>Grand Total:
                                                    <span class="w-100 d-block font-weight-bold mt-2">{{number_format($booking->grand_total, 2, '.', '')}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Status:
                                                    <span class="w-100 d-block font-weight-bold mt-2">Confirmed</span>
                                                </td>
                                                <td>Payment Mode:
                                                    <span class="w-100 d-block font-weight-bold mt-2">{{($booking->payment_type == 1) ? 'Online Payment' : 'Cash'}}</span>
                                                </td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                
                @if(!empty($booking->service_name))
                <div class="order-totel-details">
                    <div class="card">
                    <div class="card-body">
                        <h5>Service Details</h5>


                        <div class="service-name">
                            <strong>Service Name:</strong>
                            <span class="w-100  font-weight-bold mt-2">{{$booking->service_name}}</span>
                        </div>


                        <div class="service-price">
                            <strong>Service Price:</strong>
                            <span class="w-100  font-weight-bold mt-2">{{number_format($booking->service_price, 2, '.', '')}}</span>
                        </div>

                        <div class="service-price">
                            <strong>Date and Time:</strong>
                            <span class="w-100  font-weight-bold mt-2">{{ \Carbon\Carbon::parse($booking->service_from_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->service_to_time)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->service_from_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->service_to_time)->format('H:i') }}</span>
                        </div>


                        @if(!empty($booking->service_image))
                            <div class="product-heading-title mt-3">
                                <img src="{{asset('storage/uploads/service/' . $booking->service_image)}}" style="width:100px;height:100px;object-fit:cover;">
                            </div>
                        @endif
                    </div>

                    </div>
                </div>
                @endif
            </div>
        </div>

       
    </div>
</div>


@stop

@section('script')
    <script src="{{ asset('') }}admin_assets/plugins/table/datatable/datatables.js"></script>
    <script>
        $('body').off('click', '[data-role="status-change"]');
        $('body').on('click', '[data-role="status-change"]', function(e) {
            e.preventDefault();
            var msg = $(this).data('message') || 'Are you sure that you want to change status?';
            var href = $(this).attr('href');
            var detailsid = $(this).attr('detailsid');
            var statusid = $(this).attr('value');
            var title = $(this).data('title') || 'Confirm Status Change';

            App.confirm(title, msg, function() {
                var ajxReq = $.ajax({
                    url: href,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "detailsid": detailsid,
                        "statusid": statusid,
                    },
                    success: function(res) {
                        if (res['status'] == 1) {
                            App.alert(res['message'] || 'Status changed successfully', 'Success!');
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);

                        } else {
                            App.alert(res['message'] || 'Unable to change the record.',
                                'Failed!');
                        }
                    },
                    error: function(jqXhr, textStatus, errorMessage) {

                    }
                });
            });

        });
        

        $('body').off('click', '[data-role="cancel-order"]');
        $('body').on('click', '[data-role="cancel-order"]', function(e) {
            e.preventDefault();
            var msg = $(this).data('message') || 'Are you sure that you want to cancel this order?';
            var href = $(this).attr('href');
            var order_id = $(this).attr('order_id');
            var title = 'Confirm Cancel Order';

            App.confirm(title, msg, function() {
                var ajxReq = $.ajax({
                    url: href,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "order_id": order_id,
                    },
                    success: function(res) {
                        if (res['status'] == 1) {
                            App.alert(res['message'], 'Success!');
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);

                        } else {
                            App.alert(res['message'],
                                'Failed!');
                        }
                    },
                    error: function(jqXhr, textStatus, errorMessage) {

                    }
                });
            });

        });


        $('body').off('click', '[data-role="return-status-change"]');
        $('body').on('click', '[data-role="return-status-change"]', function(e) {
            e.preventDefault();
            var msg = $(this).data('message') || 'Are you sure that you want to change return status?';
            var href = $(this).attr('href');
            var detailsid = $(this).attr('detailsid');
            var statusid = $(this).attr('value');
            var title = $(this).data('title') || 'Confirm Return Status Change';

            App.confirm(title, msg, function() {
                var ajxReq = $.ajax({
                    url: href,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "detailsid": detailsid,
                        "statusid": statusid,
                    },
                    success: function(res) {
                        if (res['status'] == 1) {
                            App.alert(res['message'] || 'Successfully updated', 'Success!');
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);

                        } else {
                            App.alert(res['message'] || 'Unable to change the status.',
                                'Failed!');
                        }
                    },
                    error: function(jqXhr, textStatus, errorMessage) {

                    }
                });
            });

        });
    </script>
@stop
