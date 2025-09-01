@extends('admin.template.layout')
@section('header')
   
@stop
@section('content')
    <div class="card mb-5">
        <div class="card-body">
            <div class="">
                <form method="post" id="admin-form" action="{{ url('admin/save_event_feature') }}" enctype="multipart/form-data"
                    data-parsley-validate="true">
                    <input type="hidden" name="id" id="cid" value="{{ $product_feature? $product_feature->id:''}}">
                    @csrf()
                    
                        <div class="row">
                         <div class="col-md-12">
                                <div class="form-group">
                                    <label>Feature Name<b class="text-danger">*</b></label>
                                    <input type="text" name="name" class="form-control" required
                                        data-parsley-required-message="Enter Feature Name" value="{{ $product_feature?$product_feature->name:'' }}">
                                </div>
                         </div>
                         <div class="col-md-12">
                            <div class="form-group">
                                <label>Feature Name (Arabic)<b class="text-danger">*</b></label>
                                <input type="text" name="name_ar" class="form-control text-right" required
                                    data-parsley-required-message="Enter Arabic Feature Name"
                                    value="{{ $product_feature->name_ar ?? '' }}">
                            </div>
                        </div>


                         <div class="col-md-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control">{{  $product_feature?$product_feature->description:'' }}</textarea>
                            </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                            <label>Description (Arabic)</label>
                            <textarea name="description_ar" class="form-control text-right">{{ $product_feature->description_ar ?? '' }}</textarea>
                        </div>
                    </div>
                        

                        
                       

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Image</label><br>
                                <img id="image-preview" style="width:100px; height:90px;" class="img-responsive"
                                    @if ($product_feature) src="{{$product_feature->image_path}}" @endif>
                                <br><br>
                                <input type="file" name="image" class="form-control" data-role="file-image" data-preview="image-preview" data-parsley-trigger="change"
                                    data-parsley-fileextension="jpg,png,gif,jpeg,webp"
                                    data-parsley-fileextension-message="Only files with type jpg,png,gif,jpeg,webp are supported" data-parsley-max-file-size="5120" data-parsley-max-file-size-message="Max file size should be 5MB" >
                                
                            </div>
                        </div>
                      

                         

                        
                        
                       
                        <div class="col-md-12 mt-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="col-xs-12 col-sm-6">
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>
        App.initFormView();
       
        $('body').on("click", '[data-role="remove-spec"]', function() {
            $(this).parent().parent().remove();
        });
        var form_uploaded_images = {};
        $('[data-role="add-spec"]').click(function() {
            let counter = $("#spec_counter").val();
            counter++;
            var html = '<div class="row">'+
                       '<div class="form-group col-md-4">' +
                        '<input type="text" name="include_title['+counter+']" class="form-control" required data-parsley-required-message="Enter title" placeholder=" title">'
                            +
                        '</div>' + 
                       '<div class="form-group col-md-4">'+ 
                         '  <input type="text" name="include_description['+counter+']" class="form-control"  required ssdata-parsley-required-message="Enter description" placeholder=" description"></div>'+
                       '<div class="form-group col-md-2">'+ 
                            '<input type="file" name="include_icon'+counter+'" class="form-control" data-role="file-image" data-preview="image-preview-icon123" data-parsley-trigger="change" data-parsley-fileextension="jpg,png,gif,jpeg"                                    data-parsley-fileextension-message="Only files with type jpg,png,gif,jpeg are supported" data-parsley-max-file-size="5120" data-parsley-max-file-size-message="Max file size should be 5MB"></div>' +
                       '<div class="col-md-2">'+
                            '<button type="button" class="btn btn-danger" data-role="remove-spec"><i class="flaticon-minus-2"></i></button>'+
                        '</div></div>'
            $("#spec_counter").val(counter);
            $('#spec-holder').append(html);
        });

        $('body').off('submit', '#admin-form');
        $('body').on('submit', '#admin-form', function(e) {
            e.preventDefault();
            var $form = $(this);
            var formData = new FormData(this);

            App.loading(true);
            $form.find('button[type="submit"]')
                .text('Saving')
                .attr('disabled', true);

            var parent_tree = $('option:selected', "#parent_id").attr('data-tree');
            formData.append("parent_tree", parent_tree);

            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: $form.attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                dataType: 'json',
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
                            var m = res['message'] ||
                            'Unable to save Event Category. Please try again later.';
                            App.alert(m, 'Oops!');
                        }
                    } else {
                        App.alert(res['message'], 'Success!');
                            setTimeout(function(){
                                window.location.href = App.siteUrl('/admin/event_features');
                        },1500);
                       
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

        $('body').off('change', '#activityid');
$('body').on('change', '#activityid', function(e) {
    var activityid = $(this).val();
    $.ajax({
           type: "POST",
           url: "{{url('admin/get_parants_activity')}}",
           dataType: 'json',
           data: {'activity_id': activityid,'_token':'{{ csrf_token() }}'},
           success: function (result) {
            $("#parantcat").html('');
                $("#parantcat").append('<option value="">None</option>'); 
            $.each(result, function(index) {
                
                $("#parantcat").append('<option value=' + result[index].id +' >'+result[index].text+'</option>');
                        });
            }
          });
      
});
    </script>
@stop
