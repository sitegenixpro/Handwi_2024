@extends('admin.template.layout')

@section('header')
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin-assets/plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('') }}admin-assets/plugins/table/datatable/custom_dt_customer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .home-section .container-fluid {
            padding-left: 0px !important;
            padding-right: 0px !important;
        }

        .action-col-3-bt .btn-primary,
        .action-col-3-bt .btn-secondary,
        .action-col-3-bt .btn-warning,
        .action-col-3-bt .btn-info,
        .action-col-3-bt .btn-danger {
            padding: 12px 20px !important;
        }
    </style>
@stop

@section('content')

    @php

        use App\Http\Controllers\admin\VendorUsersController;

    @endphp

    <?php $permission_id = "customers"; ?>
    <div class="card mb-5">
        @if($vendor_id)
            <!--<div class="card-header">-->
            <!--    <a href="{{url('admin/vendor_videos/create/'.$vendor_id)}}"-->
            <!--       class="btn-custom btn mr-2 mt-2 mb-2"><i class="fa-solid fa-plus"></i>-->
            <!--        Upload Reel-->
            <!--    </a>-->
            <!--</div>-->
        @endif
        <div class="card-body">

            <style>
                .table-top-scroll,
                .table-responsive {
                    width: 100%;
                    border: none;
                    overflow-x: scroll;
                    overflow-y: hidden;
                }

                .table-top-scroll {
                    height: 20px;
                    position: sticky;
                    position: -webkit-sticky;
                    top: 0;
                    /* required */
                    z-index: 3;
                    background: #36454f;
                }

                /*.table-responsive{height: 200px; }*/
                .scroller {
                    height: 20px;
                }

                .table {
                    overflow: auto;
                }

                body,
                .card.mb-5 {
                    overflow-x: visible;
                    overflow-y: visible;
                }
            </style>
            <div class="table-top-scroll mb-1">
                <div class="scroller">
                </div>
            </div>
            <div class="table-responsive mt-1">
                <table class="table table-condensed table-bordered table-striped" id="example2">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Reel</th>
                        <th>Description</th>
                        
                        <!--<th>Likes</th>-->
                        <!--<th>Messages</th>-->
                        <th>Created at</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = $lists->perPage() * ($lists->currentPage() - 1); ?>
                    @foreach ($lists as $list)
                            <?php $i++; ?>
                        <tr>
                            <td>{{ $i }}</td>
                            <td>
                               
                                
                                <a href=" {{$list->file}}" target="_blank">Play Video </a>
                                @if(!empty($list->url))
                                <a href="{{url($list->url)}}" data-fancybox>
                                    <img style="height: 100px;" src="{{ asset('') }}admin-assets/assets/img/55045487800453.png">
                                </a>
                                    <!--<video width="auto" height="70" controls>-->
                                    <!--    <source src="{{url($list->url)}}" type="video/mp4">-->
                                    <!--    Your browser does not support the video tag.-->
                                    <!--</video>-->
                                @endif
                            </td>
                           
                            <td>{{$list->caption}} </td>
                            
                            <!--<td><a href="{{url('admin/likes')}}?vendor_id=17&likes=1">5</a></td>>-->
                            <!--<td><a href="{{url('admin/video_messages/98')}}">6</a></td>-->

                            <td>{{web_date_in_timezone($list->created_at,'d-m-Y h:i A')}}</td>

                        </tr>

                    @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    <span>Total {{ $lists->total() }} entries</span>
                    <div class="col-sm-12 col-md-12 pull-right">
                        <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                            {!! $lists->appends(request()->input())->links('admin.template.pagination') !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(function () {
            var widthTable = $(".table-responsive .table").outerWidth();
            $(".table-top-scroll .scroller").css("width", widthTable);
            $(".table-top-scroll").scroll(function () {
                $(".table-responsive")
                    .scrollLeft($(".table-top-scroll").scrollLeft());
            });
            $(".table-responsive").scroll(function () {
                $(".table-top-scroll")
                    .scrollLeft($(".table-responsive").scrollLeft());
            });
            // console.log(widthTable);
        });
    </script>
    <script src="{{ asset('') }}admin-assets/plugins/table/datatable/datatables.js"></script>
    <script>
        App.initFormView();

        // --- Get the disableSortingColumnsIndex from the server side ----
        ;

        // ----------------------------------------------------------------

        // ready the order
        var sortIndex = <?php echo request()->get('sort_index') ?? 0; ?>;
        var sortOrder = `<?php echo request()->get('sort_order') ?? 'asc'; ?>`;


        // Disable the table sorting rows, as we are sorting from the backend
        $.fn.dataTable.ext.order['disableSort'] = function (settings, col) {
            return []; // Return an empty array to effectively disable sorting
        };

        var table = $('#example2').DataTable({
            "paging": false,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": true,
            "responsive": true,
            "order": [
                [sortIndex, sortOrder]
            ], // Default sort order
            "columnDefs": [...disableSortingColumns, {
                "targets": '_all',
                "orderDataType": 'disableSort'
            }]
        });

        // Handle the order event
        table.on('order.dt', function (e) {

            // Get the order details
            var order = table.order();
            var columnIndex = order[0][0]; // Column index
            var sortDirection = order[0][1]; // 'asc' or 'desc'

            // Get the column name from the header
            var columnName = table.column(columnIndex).header().textContent.trim();

            // Build the new URL with the query parameters
            var currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('sort_index', columnIndex);
            currentUrl.searchParams.set('sort_order', sortDirection);
            currentUrl.searchParams.set('page', 1); // Reset the page number to 1

            // Redirect to the new URL
            window.location.href = currentUrl.toString();

        });
        $(document).ready(function () {
            var fromDate = $('.from_date').datepicker({
                format: 'dd-mm-yyyy',
                todayHighlight: true,
                autoclose: true
            }).on('changeDate', function (e) {
                var selectedDate = e.date;
                $('.to_date').datepicker('setStartDate', selectedDate);
            });

            var toDate = $('.to_date').datepicker({
                format: 'dd-mm-yyyy',
                todayHighlight: true,
                autoclose: true
            }).on('changeDate', function (e) {
                var selectedDate = e.date;
                $('.from_date').datepicker('setEndDate', selectedDate);
            });
        });
    </script>
@stop
