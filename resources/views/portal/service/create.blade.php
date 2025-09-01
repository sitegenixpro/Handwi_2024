@extends('portal.template.layout')
@section('header')
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
   
@stop
@section('content')

 <style>
        .text-muted {
            color: #181722 !important;
            font-size: 12px;
        }
        .uploaded-prev-imd{
                display: flex;
                flex-direction: row-reverse;
                justify-content: flex-end;
                align-items: center;
                margin: 10px 0px;
        }
        .del-product-img{
            margin-left: 0px;
                color: #fa1b28;
                font-size: 12px;
                font-weight: 400;
        }
        .del-product-img:hover{
            color: #ff3743;
        }
        .select2-container .select2-selection--multiple{
            min-height: 44px;
        }
        #product-single-variant legend{
            font-size: 15px;
            color: #000;
            font-weight: 600;
            margin-bottom: 5px;
        }
        #product-single-variant hr{
            display: none;
        }
        .select-category-form-group .parsley-required{
            position: absolute;
            bottom: -20px
        }

        .default_attribute_id{
            width: auto;
            margin-right: 5px;
        }
        .top-bar{
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        
    </style>
    <div class="card mb-5">
        <div class="card-body">
            <div class="">
                <form method="post" id="admin-form" action="{{ url('portal/save_services') }}" enctype="multipart/form-data"
                    data-parsley-validate="true">
                    <input type="hidden" name="id" id="cid" value="{{ $id }}">
                    @csrf()
                    
                    <div class="row">
                        
                        {{-- <div class="col-md-6 form-group  ">
                            <label>Vendor<b class="text-danger">*</b></label>
                            <select class="form-control jqv-input select2 product_vendor" name="seller_id" required
                                data-parsley-required-message="Select a vendor" data-role="vendor-change" data-input-store="store-id" >
                                <option value="">Select Vendor</option>
                                @foreach ($sellers as $sel)
                                    <option value="{{$sel->id }}" data-activity="{{$sel->activity_id}}" @if ($sel->id == $seller_user_id) selected @endif >{{ $sel->store_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                        
                         <div class="col-md-6">
                                <div class="form-group">
                                    <label>Workshop Name<b class="text-danger">*</b></label>
                                    <input type="text" name="name" class="form-control" required
                                        data-parsley-required-message="Enter Workshop Category Name" value="{{ $name }}">
                                </div>
                         </div>
                                               
                        
                       
                        <div class="col-md-3 mb-3">
                            <label for="from_date" class="form-label">From Date</label>
                            <input type="date" class="form-control" value="{{ $from_date }}" id="from_date" name="from_date"
                                   placeholder="Select From Date">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="from_time" class="form-label">From Time</label>
                            <input type="time" class="form-control" value="{{ $from_time }}" id="from_time" name="from_time"
                                   placeholder="Select From Time">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="to_date" class="form-label">To Date</label>
                            <input type="date" class="form-control" value="{{ $to_date }}" id="to_date" name="to_date"
                                   placeholder="Select To Date">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="to_time" class="form-label">To Time</label>
                            <input type="time" class="form-control" value="{{ $to_time }}" id="to_time" name="to_time"
                                   placeholder="Select To Time">
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
                        <div class="col-md-6">
                           <div class="form-group">
                                <label>City</label>
                                <select name="city_id" class="form-control" required>
                                    <option value="">Select City</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ old('city_id', $city_id ?? '') == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Category<b class="text-danger">*</b></label>
                            <select name="service_price_type" class="form-control jqv-input select2"
                                    data-parsley-required-message="Select Activity Type" id="activity-id" required 
                                    data-url="{{url('admin/get_service_categories_by_activity_id')}}"
                                    >
                                <option value="">Select Category</option>
                                @foreach ($service_types as $row)
                                    <option value="{{ $row->id }}" {{$service_price_type == $row->id ? 'selected' : ""}}>{{ $row->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div> 

                        
                        <div class="col-md-6">
                                <div class="form-group">
                                    
                                    <label>Workshop Price<b class="text-danger">*</b></label>
                                    <input type="text" name="price" class="form-control" required
                                        data-parsley-required-message="Enter Workshop Price" oninput="validateNumber(this);" value="{{ $serviceprice }}">
                                </div>
                         </div>
                        
                         <div class="col-md-6">
                            <div class="form-group">
                                <label>Seats<b class="text-danger">*</b></label>
                                <input type="text" name="seats" class="form-control" required
                                    data-parsley-required-message="Enter price lable" value="{{ $seats }}">
                            </div>
                           
                     </div>
                    
                        
                         <div class="col-md-12">
                         <div class="form-group">
                            <label>Term And Conditions</label>
                            <textarea name="term_and_condition" rows="5" class="form-control">{{ $term_and_condition }}</textarea>
                        </div>
                         </div>
                         
                           
                         <div class="col-md-6">
                            <div class="form-group d-flex">
                                <div class="pr-3">
                                <label>Image</label><br>
                                <input type="file" name="image" class="form-control" data-role="file-image" data-preview="image-preview" data-parsley-trigger="change"
                                    data-parsley-fileextension="jpg,png,gif,jpeg,webp"
                                    data-parsley-fileextension-message="Only files with type jpg,png,gif,jpeg,webp are supported" data-parsley-max-file-size="5120" data-parsley-max-file-size-message="Max file size should be 5MB"  >
                                </div>
                                <!-- <br><br> -->
                                <img id="image-preview" style="width:100px; height:90px;" class="img-responsive"
                                    @if ($image) src="{{$image}}" @endif>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group d-flex">
                                <div class="pr-3">
                                <label>Feature Image</label><br>
                                <input type="file" name="feature_image" class="form-control" data-role="file-image" data-preview="image-preview-feature" data-parsley-trigger="change"
                                    data-parsley-fileextension="jpg,png,gif,jpeg,webp"
                                    data-parsley-fileextension-message="Only files with type jpg,png,gif,jpeg,webp are supported" data-parsley-max-file-size="5120" data-parsley-max-file-size-message="Max file size should be 5MB"  >
                                </div>
                                <!-- <br><br> -->
                                 <div class="d-flex flex-column">
                                    <img id="image-preview-feature" style="width:100px; height:90px;" class="img-responsive"
                                    @if (isset($feature_image)) src="{{$feature_image}}" @endif>
                                    
                                    @if (isset($feature_image) && $feature_image !== 'http://localhost/handwi_2024/public/storage/placeholder.png' )
                                    <button type="button" style="background: none;" class="btn del-product-img d-flex align-items-center justify-content-center py-0" id="delete-feature-image"><i class="far fa-trash-alt mr-2"></i> Delete</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="additional_images">Additional Images</label>
                                    <input type="file" name="additional_images[]" id="additional_images" class="form-control" accept="image/*" multiple onchange="previewMultipleImages(event, 'additionalImagesPreview')">
                                </div>
                            </div>
                            <div id="additionalImagesPreview" style="display: flex; gap: 10px; margin-top: 10px;">
                                @foreach($additional_images as $img)
                                    <div class="additional-image-item" style="display: inline-block; margin-right: 10px; position: relative;">
                                        <img src="{{ asset('storage/uploads/service/'.$img->image) }}" alt="Additional Image" style="max-width: 100px; max-height: 100px;">
                                       
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        </div>

                   
                <div class="form-group col-md-12">
                    <label class="control-label">Enter the location or Drag the marker<b class="text-danger">*</b></label>
                    <input type="text" name="txt_location" id="txt_location" class="form-control autocomplete" placeholder="673C+VFH - Dubai - United Arab Emirates" required data-parsley-required-message="Enter Location" @if($id) value="{{empty($location) ? '': $location}}" @endif>
                    <input type="hidden" id="location" name="location">
                </div>
                <div class="form-group col-md-12">
                    <div id="map_canvas" style="height: 200px;width:100%;"></div>
                </div>
                       
                        <div class="col-md-12 mt-2">

                                <div class="top-bar d-flex justify-content-between align-items-center">
                                    <legend class="">Item Details </legend>
                                    <button class="btn btn-primary pull-right d-inline-flex align-items-center" type="button"
                                    data-role="add-item"><i class="flaticon-plus-1 mr-2"></i>Add</button>
                                </div>

                            <input type="hidden" id="item_counter" value="{{ count($prod_features ?? []) }}">
                            <div id="item-holder">
                                @if (!empty($service_features))
                                    <?php $j = 0; 
                                    $added_features=[];?>
                                    @foreach ($service_features as $item)
                                        <div class="row">
                                            <div class="col-md-5 form-group">
                                                <input type="text" name="item[{{ $j }}][name]" placeholder="Name"
                                                    value="{{ $item->feature_title }}" class="form-control jqv-input"
                                                    data-jqv-required="true">
                                            </div>
                        <div class="col-md-5 form-group">

                                                
                        <select data-url="{{url('admin/sellers_by_categories')}}" class="form-control jqv-input product_catd select2"
                            name="item[{{ $j }}][feature_ids]" data-role="select2" data-placeholder="Select Features"
                            data-allow-clear="true" 
                            data-parsley-required-message="Select Feature">
                            @php
                            $select_aounter=0;
                            @endphp
                            @foreach($all_features as $feature)
                            <option value="{{$feature->id}}" <?php echo  $item->product_feature_id ==$feature->id ? 'selected' : ''; ?>>{{$feature->name}}</option>
                            
                            @endforeach
                           
                        </select>
                                            </div>
                                            </div>
                                            @endforeach
                                            @endif
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
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvYQkf-70Ka1kpQnAy2DB2-KB36RqMF8o&v=weekly&libraries=places"></script>
        
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>

        $("#activity-id").change(function(){
            $(".product_catd").attr('disabled','');
            html = '<option value="">None</option>';
            $(".product_catd").html(html);
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
                        $(".product_catd").html(res['cat_view']);
                        $(".product_catd").removeAttr('disabled');
                    }
                },
                error: function(e) {
                    App.alert(e.responseText, 'Oops!');
                }
            });
        })

        @if(empty($id))
        $(function(){
            $( "#addnew" ).trigger( "click" );
        });
        @endif
        $(document).ready(function() {
            $('.select2').select2();

        });
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
        var currentLat = {{empty($latitude) ? 25.204819: $latitude}};
        var currentLong = {{empty($longitude) ? 55.270931: $longitude}};
        $("#location").val(currentLat+","+currentLong);

        currentlocation = {
            "lat": currentLat,
            "lng": currentLong,
        };
        initMap();
        initAutocomplete();
        function initMap() {
        map2 = new google.maps.Map(document.getElementById('map_canvas'), {
            center: {
                lat: currentlocation.lat,
                lng: currentlocation.lng
            },
            zoom: 14,
            gestureHandling: 'greedy',
            mapTypeControl: false,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
            },
            streetViewControlOptions: {
                position: google.maps.ControlPosition.LEFT_BOTTOM
            },
        });

        geocoder = new google.maps.Geocoder();

        // geocoder2 = new google.maps.Geocoder;
        usermarker = new google.maps.Marker({
            position: {
                lat: currentlocation.lat,
                lng: currentlocation.lng
            },
            map: map2,
            draggable: true,

            animation: google.maps.Animation.BOUNCE
        });


        //map click
        google.maps.event.addListener(map2, 'click', function(event) {
            updatepostition(event.latLng, "movemarker");
            //drag end event
            usermarker.addListener('dragend', function(event) {
                // alert();
                updatepostition(event.latLng, "movemarker");

            });
        });

        //drag end event
        usermarker.addListener('dragend', function(event) {
            // alert();
            updatepostition(event.latLng);

        });
    }

    updatepostition = function(position, movemarker) {
        geocodePosition(position);
        usermarker.setPosition(position);
        map2.panTo(position);
        map2.setZoom(15);
        let createLatLong = position.lat()+","+position.lng();
        console.log("Address Lat/long="+createLatLong);
        $("#location").val(createLatLong);
    }
    function geocodePosition(pos) {
        geocoder.geocode({
            latLng: pos
        }, function(responses) {
            if (responses && responses.length > 0) {
                usermarker.formatted_address = responses[0].formatted_address;
            } else {
                usermarker.formatted_address = 'Cannot determine address at this location.';
            }
            $('#txt_location').val(usermarker.formatted_address);
        });
    }
    function initAutocomplete() {
        // Create the search box and link it to the UI element.
        var input2 = document.getElementById('txt_location');
        var searchBox2 = new google.maps.places.SearchBox(input2);

        map2.addListener('bounds_changed', function() {
            searchBox2.setBounds(map2.getBounds());
        });

        searchBox2.addListener('places_changed', function() {
            var places2 = searchBox2.getPlaces();

            if (places2.length == 0) {
                return;
            }
            $('#txt_location').val(input2.value)

            var bounds2 = new google.maps.LatLngBounds();
            places2.forEach(function(place) {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }

                updatepostition(place.geometry.location);

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds2.union(place.geometry.viewport);
                } else {
                    bounds2.extend(place.geometry.location);
                }
            });
            map2.fitBounds(bounds2);
        });
    }
    updatepostition = function(position, movemarker) {
        console.log(position);
        geocodePosition(position);
        usermarker.setPosition(position);
        map2.panTo(position);
        map2.setZoom(15);
        let createLatLong = position.lat()+","+position.lng();
        // console.log("Address Lat/long="+createLatLong);
        $("#location").val(createLatLong);
    }
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
                            'Unable to save service. Please try again later.';
                            App.alert(m, 'Oops!');
                        }
                    } else {
                        App.alert(res['message'], 'Success!');
                                setTimeout(function(){
                                    window.location.href = App.siteUrl('/portal/workshops');
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
        var validNumber = new RegExp(/^\d*\.?\d*$/);
        var lastValid = 0;
        function validateNumber(elem) {
          if (validNumber.test(elem.value)) {
            lastValid = elem.value;
          } else {
            elem.value = lastValid;
          }
        }
        $('body').on("click", '[data-role="remove-spec"]', function() {
            $(this).parent().parent().remove();
        });
        var form_uploaded_images = {};
        $('[data-role="add-spec"]').click(function() {
            let counter = $("#spec_counter").val();
            counter++;
            var html = '<div class="row">'+
                       '<div class="form-group col-md-4">'+ 
                       '<input type="text" name="text[]" placeholder="Enter hour" class="form-control" required data-parsley-required-message="Enter hour" id="city-id'+counter+'">' +
                       '</div>'+
                       '<div class="form-group col-md-2">'+ 
                       '<input type="text" name="hourly_rate[]" oninput="validateNumber(this);" class="form-control" required data-parsley-required-message="Enter Price" placeholder="Hourly rate"></div>' +
                       '<div class="col-md-2">'+
                       '<button type="button" class="btn btn-danger" data-role="remove-spec"><i class="flaticon-minus-2"></i></button>'+
                                                '</div></div>'
            $("#spec_counter").val(counter);
            $('#spec-holder').append(html);
        });

        $('body').on("click", '[data-role="remove-item"]', function() {
            $(this).parent().parent().remove();
        });
        const allFeatures = <?php echo json_encode($all_features); ?>;
    const url = "<?php echo url('admin/sellers_by_categories'); ?>";
    $('[data-role="add-item"]').click(function() {
    let itemCounter = parseInt($("#item_counter").val(), 10); // Ensure it's parsed as an integer
    itemCounter++;

    const url = $('#item-holder').data('url'); // Ensure `url` is dynamically fetched if needed
    const allFeatures = <?php echo json_encode($all_features); ?>; // Embed all features from PHP

    let features_html = `<select class="form-control jqv-input product_catd select2" 
                name="item[${itemCounter}][feature_ids]" 
                data-url="${url}" 
                data-role="select2" 
                data-placeholder="Select Feature"
                data-allow-clear="true" 
                data-parsley-required-message="Select Feature">`;

    // Add options dynamically
    allFeatures.forEach(feature => {
        features_html += `<option value="${feature.id}">${feature.name}</option>`;
    });

    features_html += `</select>`;

    const html = `
        <div class="row">
            <div class="col-md-5 form-group">
                <input type="text" name="item[${itemCounter}][name]" placeholder="Name"
                    class="form-control jqv-input" data-jqv-required="true">
            </div>
            <div class="col-md-5 form-group">
                ${features_html}
            </div>
            <div class="col-md-2 form-group">
                <button type="button" class="btn btn-danger" data-role="remove-item">
                    <i class="flaticon-minus-2"></i>
                </button>
            </div>
        </div>`;

    $("#item_counter").val(itemCounter); // Update counter value
    $('#item-holder').append(html); // Append new HTML

    // Reinitialize select2 for dynamically added select
    $('.select2').select2();
});
        $('body').off('change', '[data-role="state-change-service"]');
        $('body').on('change', '[data-role="state-change-service"]', function() {
                var $t = $(this);
                var $city = $('#'+ $t.data('input-city'));

                if ( $city.length > 0 ) {
                    var id   = $t.val();
                    var html = '<option value="">Select</option>';

                    $city.html(html);
                    if ( id != '' ) {
                        $.ajax({
                            type: "POST",
                            enctype: 'multipart/form-data',
                            url: "{{url('admin/cities/get_by_state')}}",
                            data: {
                                "id": id,
                                "_token": "{{ csrf_token() }}"
                            },
                            timeout: 600000,
                            dataType: 'json',
                            success: function(res) {
                                for (var i=0; i < res['cities'].length; i++) {
                                html += '<option value="'+ res['cities'][i]['id'] +'">'+ res['cities'][i]['name'] +'</option>';
                                if ( i == res['cities'].length-1 ) {
                                    $city.html(html);
                                // $('.selectpicker').selectpicker('refresh')
                                }
                            }
                            }
                        });
                    }

                }
            });

function previewMultipleImages(event, previewContainerId) {
    const files = event.target.files;
    const container = document.getElementById(previewContainerId);
    container.innerHTML = ''; // Clear existing previews
    Array.from(files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '100px';
            img.style.margin = '5px';
            container.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
}

$('#delete-feature-image').on('click', function() {
        if (confirm('Are you sure you want to delete the image?')) {
            // Hide image preview and delete button
            $('#image-preview-feature').attr('src', '');
            $(this).hide();

            // Send an AJAX request to delete the image from the server
            $.ajax({
                url: "{{ route("admin.featureimagedelete") }}", // Your route for image deletion
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    feature_image: 'delete',
                    id: $('#cid').val()  // Pass the id from the hidden input field
                },
                success: function(response) {
                    // Handle success (e.g., notify user or update UI)
                    
                    App.alert('Image deleted successfully', 'Success!');
                                setTimeout(function(){
                                    reloadtion.reload();
                                },1500);
                },
                error: function(response) {
                    alert('Error deleting image');
                }
            });
        }
    });
    </script>
@stop
