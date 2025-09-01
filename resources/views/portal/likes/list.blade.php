@extends('portal.template.layout')

@section("header")
    <link rel="stylesheet" type="text/css" href="{{asset('')}}admin_assets/plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="{{asset('')}}admin_assets/plugins/table/datatable/custom_dt_customer.css">
@stop


@section("content")
<div class="card mb-5">
    <div class="card-body">
    <div class="dataTables_wrapper container-fluid dt-bootstrap4">
    @if($list->total() > 0)

    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="dataTables_length" id="column-filter_length">
            </div>
        </div>
        
        <!-- <form method="get" action='' class="col-sm-12 col-md-6">
            <div id="column-filter_filter" class="dataTables_filter">
                <label>Search:
                    <input type="search" name="search_key" class="form-control form-control-sm" placeholder="" aria-controls="column-filter" value="{{$search_key}}">
                </label>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form> -->
    </div>
        <table class="table table-condensed table-striped" id="example2">
            <thead>
                <tr>
                <th width="5%">#</th>
                <th>Date</th>
                
                <th>Customer name</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = $list->perPage() * ($list->currentPage() - 1); ?>
            @foreach($list as $item)
            <?php $i++; ?>
            @if($item->user)
               <tr>
                   <td>{{$i}}</td>
                   <td>{{get_date_in_timezone($item->created_at)}}</td>
                  
                 
                   <td>{{($item->user)?$item->user->name:''}}</td>
                  
                   
               </tr>
               @endif
            @endforeach
            </tbody>
        </table>
       
            
            <div class="col-sm-12 col-md-12 pull-right">
                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                {!! $list->links('admin.template.pagination') !!}
                </div>
            </div>
        
        @else
        <br>
        <div class="alert alert-warning">
            <p>No details found</p>
        </div>
        @endif
    </div>
    </div>
</div>

<div class="modal" id="editcomment">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Reply</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" id="messageedit" action="{{ url('admin/reply_comment') }}" enctype="multipart/form-data"
                    data-parsley-validate="true" data-parsley-trigger="keyup" >
                    @csrf()
                    <input type="hidden" value="" id="comment_id" name="commentid"> 
      <div class="col-md-12 form-group">
                        <label>Reply comment<b class="text-danger">*</b></label>
                        <input type="text" name="reply" id="" class="form-control" required
                            data-parsley-required-message="Enter Comment"
                            value="">
                    </div></form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" form="messageedit" class="btn btn-success">Save</button>
      </div>

    </div>
  </div>
</div>
@stop

@section("script")
 <script src="{{asset('')}}admin-assets/plugins/table/datatable/datatables.js"></script>
<link rel="stylesheet" type="text/css" href="{{asset('')}}admin-assets/plugins/table/datatable/datatables.css">
<script>
$('body').off('click', '#editmessage');
$('body').on('click', '#editmessage', function(e) {
    var message = $(this).attr('message');
    var rating_id = $(this).attr('ratingid');
    $('#comment_id').val(rating_id);
    $('#editcomment').modal('show');
});
$('body').off('submit', '#messageedit');
        $('body').on('submit', '#messageedit', function(e) {
            $('.invalid-feedback').remove();
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
                            window.location.href = App.siteUrl('/admin/rating');
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