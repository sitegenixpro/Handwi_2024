@extends("admin.template.layout")

@section('header')

@stop


@section('content')

<style>
    #parsley-id-9{
        position: absolute;
        bottom: -20px;
    }
    .dataTables_length, .dataTables_filter{
        margin-bottom: 10px !important; 
    }
</style>

    <div class="card mb-4">
        <div class="card-header">
            Create Tag
        </div>
        <div class="card-body">
            <form action="{{ url('/admin/tags_save') }}" method="post" id="admin-form" data-parsley-validate="true"> 
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <input type="text" name="name" id="name"  class="form-control" placeholder="Enter Tag Name" required
                        data-parsley-required-message="Enter Attribute Name">
                        </div>
                       <div class="col-sm-6 col-md-6">
                            <input type="text" name="name_ar"  id="name_ar" class="form-control text-right" placeholder="Enter Arabic Name">
                        </div>                   
                    </div><br/>
                    <div class="row">

                        
                       
                        <input type="hidden" name="id" value="0" id="tag_id">
                        <div class="col-sm-6 col-md-6 mt-4">
                            <input type="submit" name="Save" value="Save" class="btn btn-warning mb-2 mr-2 btn-rounded">
                        </div>
                    </div>
                </form>
                
        </div>
    </div>
    <div class="card mb-5">
        <div class="card-body">
            <!--<div class="dataTables_wrapper container-fluid dt-bootstrap4 d-none">-->
            <!--</div>-->


                    <div class="row d-none">
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_length" id="column-filter_length">
                            </div>
                        </div>

                        <form method="get" action='' class="col-sm-12 col-md-6" style="text-align: right;">
                          <div id="column-filter_filter" class="dataTables_filter">
                              <label style="display: flex;justify-content: flex-end;align-items: center;">
                                    <span class="mr-2">Search: </span> 
                                  <input type="search" name="search_key" class="form-control form-control-sm"
                                      placeholder="" aria-controls="column-filter" value="" style="width: auto;">
                              </label>
                              <!--<button type="submit" class="btn btn-primary">Submit</button>-->
                          </div>
                      </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-condensed table-striped" id="attribute_listing">
                            <thead>
                                <tr>
                                    <th width="15%">Tag ID</th>                                
                                    <th width="30%">Name</th>  
                                     <th width="30%">Name (Arabic)</th>
                                    <th>Status</th> 
                                    <th>Is Active</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @if (count($list) > 0)
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($list as $item)   
                                    <?php $i++;  ?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        
                                        <td>{{ $item->name }}</td>
                                        <td class="text-right">{{ $item->name_ar }}</td>
                                        
                                        
                                       <td>{{$item->status ? 'Active' :'Inactive'}}</td> 
                                        <td>
                                            <label class="switch s-icons s-outline  s-outline-warning mt-2 mb-0 mr-2">
                                                <input type="checkbox" class="change_status" data-id="{{$item->id}}"
                                                    data-url="{{ url('admin/tags/change_status') }}"
                                                    @if ($item->status) checked @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td>{{ get_date_in_timezone($item->created_date, config('global.datetime_format')) }}</td>
                                        <td class="text-center">
                                            <div class="dropdown custom-dropdown">
                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink7"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <i class="flaticon-dot-three"></i>
                                                </a>
    
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink7">
                                                    <a class="dropdown-item edit_attribute"
                                                        href="#" attid ="{{$item->id}}"><i
                                                            class="flaticon-pencil-1"></i> Edit</a>
                                                 
                                                    <a class="dropdown-item" data-role="unlink"
                                                        data-message="Do you want to remove this attribute?"
                                                        href="{{ url('admin/tags/delete/' . $item->id) }}"><i
                                                            class="flaticon-delete-1"></i> Delete</a>
    
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                             @else
                             <tr>
                                <td colspan="8" align="center" class="p-0">
                                    <div class="alert alert-warning mt-2">
                                        <p class="mb-0">No products found</p>
                                    </div>
                                </td>
                            </tr>
                               @endif
                        </table>
                    </div>


                    <div class="col-sm-12 col-md-12 pull-right">
                        <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                           {!! $list->links('admin.template.pagination') !!}
                        </div>
                    </div>

        </div>
    </div>
@stop

@section('script')
<script src="{{asset('')}}admin-assets/plugins/table/datatable/datatables.js"></script>
<link rel="stylesheet" type="text/css" href="{{asset('')}}admin-assets/plugins/table/datatable/datatables.css">
    <script>
    $('#attribute_listing').DataTable({
            
        });    
    </script>
    <script>
        App.initFormView();
        $('body').off('submit', '#admin-form');
        $('body').on('submit', '#admin-form', function(e) {
            e.preventDefault();
            var $form = $(this);
            $('.invalid-feedback').remove();
            
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
                            window.location.href = App.siteUrl('/admin/product_tags');
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

$('.edit_attribute').on('click',function(){
    var id = $(this).attr('attid');
    $.ajax({
        type: "get",
        enctype: 'multipart/form-data',
        url: "{{ url('admin/tags_edit/')}}/"+id,
        data: {},
        dataType: 'json',
        success: function(res) {
            $('#tag_id').val(res.id);
            $('#name').val(res.name);
            $('#name_ar').val(res.name_ar);
            
            $('.card-header').html('Edit Tag');

        }
    })
})
    </script>
@stop