@extends("admin.template.layout")

@section('header')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
     <style>
        .progress {
            position: relative;
            width: 100%;
        }

        .bar {
            background-color: #00ff00;
            width: 0%;
            height: 20px;
        }

        .percent {
            position: absolute;
            display: inline-block;
            left: 50%;
            color: #040608;
        }

    </style>
@stop


@section('content')
    <div class="card mb-5">
         @if($message = Session::get('success'))
   <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
           <strong>{{ $message }}</strong>
   </div>
   @endif
   @if($message = Session::get('error'))
   <div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
           <strong>{{ $message }}</strong>
   </div>
   @endif
        <div class="card-header">
            @php
                $create_url = url('admin/product/create');
                $deleted_url = url('admin/products').'?deleted=1';
                if(request()->activity_id){
                    $create_url = url('admin/product/create').'?activity_id='.request()->activity_id;
                    $deleted_url = url('admin/products').'?activity_id='.request()->activity_id.'&deleted=1';
                }
            @endphp

                   <form action="{{route('admin.product.export')}}" method="get" class="justify-content-end">
            <div class="status d-flex justify-content-end ">
                <a href="{{ $deleted_url }}" class="btn-custom btn mr-2 mt-2 mb-2"><i class="fa-solid fa-trash"></i> Deleted {{$p_name}}</a>
                <a href="{{ $create_url }}" class="btn-custom btn mr-2 mt-2 mb-2"><i class="fa-solid fa-plus"></i> Create {{$p_name}}</a>
                <!-- <a href="{{ url('admin/import_export') }}" class="btn-custom btn mr-2 mt-2 mb-2"><i class="fa-solid fa-download"></i> Import</a> -->
                <!--  <a href="javascript:void(0);" class="btn btn-info mr-2 btn-rounded"  data-toggle="modal" data-target="#exampleModal" > Import</a> -->
                <input type="hidden" name="from" value="{{$from}}"> 
                 <!-- <button type="submit" class="btn btn-danger mr-2 btn-rounded">Export</button>  -->
            </div>
        </form>
                </div>
                 <div class="modal" tabindex="-1"  id="exampleModal" role="dialog">
            <div class="modal-dialog" role="document">
               
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Import Products & Upload Images</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                
                <div class="modal-body">
                    <form id="fileUploadForm1" method="POST" class="form-inline" enctype="multipart/form-data" action="{{ url('admin/product/import') }}">
                        {{ csrf_field() }}
                    <label>Import File (.xls, .xslx) </label>
                    <input type="file" name="select_file" class="form-control" />
                    <button type="submit" class="btn btn-primary">Import</button>
                </form>
                <form method="POST" id="fileUploadForm2" class="mt-2 form-inline" enctype="multipart/form-data" action="{{ url('admin/product/image_upload') }}">
                    {{ csrf_field() }}
                <label>Upload Image (.zip) </label>
                <input type="file" name="zip_file" class="form-control" />
                <button type="submit" class="btn btn-primary">Upload</button>
                
            </form><br>
                                <div class="progress">
                                    <div class="bar"></div>
                                    <div class="percent"></div>
                                </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('admin.product.download_format')}}"  class="btn btn-success" style="float: left;">Download Format</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  
                </div>
              </div>
           
            </div>
          </div>
        
        <style>
            .form-control {
                height: 38px;
            }
            .btn-secondary:hover, .btn-secondary:focus {
                color: #fff !important;
                background-color: #714cbd;
                box-shadow: none;
                border-color: #714cbd;
            }
        </style>
      
        <div class="card-body">
            <div class="">
                <div class="dataTables_wrapper container-fluid dt-bootstrap4 table-responsive">
                    @if(!request()->deleted)
                    @include('admin/product/search_form')
                    @endif
                    

                        

                        <div class="row mt-1">
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_length" id="column-filter_length">
                                </div>
                            </div>

                            
                        </div>
                        <table class="table table-condensed table-striped " id="product_listing">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%">{{$p_name}} Name</th>
                                     <th width="20%">{{$p_name}} Name (Arabic)</th>
                                    @if(empty($vendor))
                                    <th width="15%">Vendor</th>
                                    @endif
                                    <th width="15%">Type</th>
                                    @if(!request()->deleted)
                                    <th width="15%">Is Active</th>
                                    @endif
                                    <th width="15%">Created Date</th>
                                    @if(!request()->deleted)
                                    <th width="15%">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                
                                @if ($list->total() > 0)
                                <?php $i = ($list->currentPage() - 1) * $list->perPage(); ?>
                                @foreach ($list as $item)
                                    <?php $i++; ?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $item->product_name }}
                                            @if($item->featured)<br><span class="badge badge-warning mt-2">Featured</span>@endif</td>
                                            <td>{{ $item->product_name_arabic }}</td>
                                            @if(empty($vendor))
                                            <td>{{ $item->name }}</td>
                                            @endif
                                        <td>{{$item->product_type ==1 ? 'Simple' :'Variants'}}</td> 
                                            @if(!request()->deleted)
                                        <td>
                                            <label class="switch s-icons s-outline  s-outline-warning  mb-2 mt-2 mr-2">
                                                <input type="checkbox" class="change_status" data-id="{{$item->id}}"
                                                    data-url="{{ url('admin/products/change_status') }}"
                                                    @if ($item->product_status) checked @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                            @endif
                                        <td>{{ get_date_in_timezone($item->created_at, config('global.datetime_format')) }}</td>
                                            @if(!request()->deleted)
                                        <td class="text-center">
                                            <div class="dropdown custom-dropdown">
                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink7"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <i class="flaticon-dot-three"></i>
                                                </a>
                                                @php
                                                    $edit_url = url('admin/products/edit/' . $item->id);
                                                    $delete_url = url('admin/products/delete/' . $item->id);
                                                    if(request()->activity_id){
                                                        $edit_url = url('admin/products/edit/' . $item->id).'?activity_id='.request()->activity_id;
                                                        $delete_url = url('admin/products/delete/' . $item->id).'?activity_id='.request()->activity_id;
                                                    }
                                                @endphp

                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink7">
                                                    <a class="dropdown-item"
                                                        href="{{ $edit_url }}"><i class="flaticon-pencil-1"></i> Edit</a>
                                                    <a class="dropdown-item" data-role="unlink"
                                                        data-message="Do you want to remove this product?"
                                                        href="{{ $delete_url }}"><i
                                                            class="flaticon-delete-1"></i> Delete</a>

                                                </div>
                                            </div>
                                        </td>
                                            @endif
                                    </tr>
                                @endforeach
                        
                            @else
                            <tr><td colspan="7" align="center">No {{$p_name}} found</td></tr>
                            @endif
                            </tbody>
                        </table>
                        @if ($list->total() > 0)
                        <div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info" id="product_listing_portal_info" role="status" aria-live="polite">Showing {{( ($list->currentPage() - 1) * $list->perPage() ) + 1}} to {{$i}} of {{$list->total()}} entries</div></div><div class="col-sm-12 col-md-7"></div></div>
                        @endif

                         <div class="col-sm-12 col-md-12 pull-right">
                            <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                {!! $list->links('admin.template.pagination') !!}
                            </div>
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
$('#product_listing').DataTable({
        "paging": false, 
        "lengthChange": false, 
        "searching": false, 
        "ordering": true, 
        "info": false, 
        "autoWidth": false 
    });    
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script>
        $(".product_vendor").change(function(){
            $(".product_cat").attr('disabled','');
            html = '<option value="">All</option>';
            $(".product_cat").html(html);
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: $(this).data('url'),
                data: {
                    "id" :$(this).val(),
                    "_token": "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: function(res) {
                    if(res['status'] == '1'){
                        $(".product_cat").append(res['cat_view']);
                        $(".product_cat").removeAttr('disabled');
                        // $(".product_catd").change();
                    }
                },
                error: function(e) {
                    App.alert(e.responseText, 'Oops!');
                }
            });
        })

           var bar = $('.bar');
        var percent = $('.percent');
        $('#fileUploadForm1').ajaxForm({
            beforeSend: function() {
                var percentVal = '0%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentValue = percentComplete + '%';
                $(".bar").animate({
                        width: '' + percentValue + ''
                    }, {
                        duration: 5000,
                        easing: "linear",
                        step: function (x) {
                        percentText = Math.round(x * 100 / percentComplete);
                            $(".percent").text(percentText + "%");
                        
                        }
                    });
                var percentVal = percentComplete + '%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            success: function(response) {
                bar.css('background-color','#00ff00');
                if (response.success == 0) {
                     App.alert([response.message, 'error']);
                    bar.css('background-color','red');
                    bar.width('100%');
                    percent.html('');
                  //  window.location.reload();
                } else {
                     App.alert([response.message, 'success']);
                }
                bar.width('0%');
                percent.html('');
            },
            complete: function(xhr) {
                $('#fileUploadForm1').trigger('reset');
                
            },error: function(xhr, status, error) {
                bar.width('0%')
                percent.html('error occured, try again');
}
        });
        $('#fileUploadForm2').ajaxForm({
            beforeSend: function() {
                $('.percent').html('0%');
                var percentVal = '0%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentValue = percentComplete + '%';
                $(".bar").animate({
                        width: '' + percentValue + ''
                    }, {
                        duration: 5000,
                        easing: "linear",
                        step: function (x) {
                        percentText = Math.round(x * 100 / percentComplete);
                            $(".percent").text(percentText + "%");
                        
                        }
                    });
                var percentVal = percentComplete + '%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            success: function(response) {
                bar.css('background-color','#00ff00');
                if (response.success == 0) {
                    App.alert([response.message, 'error']);
                    bar.css('background-color','red');
                    bar.width('100%');
                    percent.html('');
                    
                } else {
                     App.alert([response.message, 'success']);
                   
                    
                }
                bar.width('0%');
                percent.html('');
                  $('#fileUploadForm2').trigger('reset');
                  setTimeout("window.location=''",3000);
            },
            error: function(xhr, status, error) {
                bar.width('0%')
                percent.html('error occured, try again');
}
        });
    </script>
@stop