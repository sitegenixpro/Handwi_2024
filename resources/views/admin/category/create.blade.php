@extends('admin.template.layout')
@section('header')
<style>

/* Create a custom checkbox */
.checkmark {
    position: absolute;
    top: 0;
    left: 30px;
    height: 25px;
    width: 25px;
    background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
    background-color: #FFC087;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
    display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
    left: 9px;
    top: 5px;
    width: 5px;
    height: 10px;
    border: solid #000;
    border-width: 0 2.5px 2.5px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}
</style>
   
@stop
@section('content')
    <div class="card mb-5">
        <div class="card-body">
            <div class="">
                <form method="post" id="admin-form" action="{{ url('admin/save_category') }}" enctype="multipart/form-data"
                    data-parsley-validate="true">
                    <input type="hidden" name="id" id="cid" value="{{ $id }}">
                    @csrf()
                    
                    <div class="row">
                    
                    
                        <div class="col-md-12 form-group" style="display:none;">
                            <label>Activity Type<b class="text-danger">*</b></label>
                            <select name="activity_id" class="form-control jqv-input select2"
                                    data-parsley-required-message="Select Activity Type" id="activity-id" required 
                                    data-url="{{url('admin/get_categories_by_activity_id')}}"
                                    >
                                <option value="7">Select Activity Type</option>
                                @foreach ($activity_types as $activity_type)
                                    @if($activity_type->id!=12)
                                        <option value="{{ $activity_type->id }}" {{$activity_id == $activity_type->id ? 'selected' : ""}}>{{ $activity_type->activity_name }}
                                        </option>
                                    @endif;
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category Name<b class="text-danger">*</b></label>
                                    <input type="text" name="name" class="form-control" required
                                        data-parsley-required-message="Enter Category Name" value="{{ $name }}" @if(in_array(strtolower(str_replace(' ', '', $name)) ,['dinein','pickup','delivery'])) readonly @endif>
                                </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category Name (Arabic)</label>
                                <input type="text" name="name_ar" class="form-control text-right" value="{{ $name_ar ?? '' }}">
                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Parent Category</label>
                                <select name="parent_id" class="form-control parent_cat">
                                    @include('admin.category.cat_options')
                                </select>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Image</label><br>
                                <img id="image-preview" style="width:100px; height:90px;" class="img-responsive"
                                    @if ($image) src="{{ asset($image) }}" @endif>
                                <br><br>
                                <input type="file" name="image" class="form-control" data-role="file-image" data-preview="image-preview" data-parsley-trigger="change"
                                    data-parsley-fileextension="jpg,png,gif,jpeg"
                                    data-parsley-fileextension-message="Only files with type jpg,png,gif,jpeg are supported" >
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group b_img_div">
                                <label>Banner Image</label><br>
                                <img id="image-preview-b" style="width:300px; height:93px;" class="img-responsive"
                                    @if ($banner_image) src="{{ $banner_image }}" @endif>

                                <br><br>
                                <input type="file" name="banner_image" class="form-control" onclick="this.value=null;"
                                    data-role="file-image" data-preview="image-preview-b" data-parsley-trigger="change"
                                    data-parsley-fileextension="jpg,png,gif,jpeg"
                                    data-parsley-fileextension-message="Only files with type jpg,png,gif,jpeg are supported">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="active" class="form-control">
                                    <option <?= $active == 1 ? 'selected' : '' ?> value="1">Active</option>
                                    <option <?= $active == 0 ? 'selected' : '' ?> value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                        </div>
                        <div class="col-lg-3">
                            <label class="container ml-5">Show on home page
                                <input hidden="" name="home_page" type="checkbox" value="1" @if(!empty($home_page)) @if($home_page == 1) checked @endif @endif data-parsley-multiple="home_page">
                                <span class="checkmark"></span>
                            </label>
                           
                        </div>

                        <div class="col-lg-3">
                            <label class="container ml-5">Is Type Gift?
                                <input hidden="" name="is_gift" type="checkbox" value="1" @if(!empty($is_gift)) @if($is_gift == 1) checked @endif @endif data-parsley-multiple="is_gift">
                                <span class="checkmark"></span>
                            </label>
                           
                        </div>
                        <div class="col-lg-3">
                            <label class="container ml-5">Is Type Handmade?
                                <input hidden="" name="is_handmade" type="checkbox" value="1" @if(!empty($is_handmade)) @if($is_handmade == 1) checked @endif @endif data-parsley-multiple="is_handmade">
                                <span class="checkmark"></span>
                            </label>
                           
                        </div>

                        <div class="col-lg-3">
                            <label class="container ml-5">Show Listing on Gift Page
                                <input hidden="" name="show_gift_page" type="checkbox" value="1" @if(!empty($show_gift_page)) @if($show_gift_page == 1) checked @endif @endif data-parsley-multiple="show_gift_page">
                                <span class="checkmark"></span>
                            </label>
                           
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
        // $(document).ready(function() {
        //     if (!$("#cid").val()) {
        //         $(".b_img_div").removeClass("d-none");
        //     }
        // });
        // $(".parent_cat").change(function() {
        //     if (!$(this).val()) {
        //         $(".b_img_div").removeClass("d-none");
        //     } else {
        //         $(".b_img_div").addClass("d-none");
        //     }
        // });
        $("#activity-id").change(function(){
            $(".parent_cat").attr('disabled','');
            html = '<option value="">None</option>';
            $(".parent_cat").html(html);
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: $(this).data('url'),
                data: {
                    "activity_id" :$(this).val(),
                    "_token": "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: function(res) {
                    if(res['status'] == '1'){
                        $(".parent_cat").html(res['cat_view']);
                        $(".parent_cat").removeAttr('disabled');
                    }
                },
                error: function(e) {
                    App.alert(e.responseText, 'Oops!');
                }
            });
        })
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
                            'Unable to save category. Please try again later.';
                            App.alert(m, 'Oops!');
                        }
                    } else {
                        App.alert(res['message'], 'Success!');
                                setTimeout(function(){
                                    window.location.href = App.siteUrl('/admin/category');
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
    </script>
@stop
