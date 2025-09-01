<legend>Price, Inventory &amp; Images</legend>
<hr>
<div class="form-row">
    <div class="col-lg-3">
        <div class="form-group profile-form">
            <label>Regular Price <span class="text-danger">*</span></label>
            <input type="text" name="regular_price" oninput="validateNumber(this);" id="regular_price" value="{{$regular_price}}" class="form-control" data-role="regular-price" {{ $readonly}} />
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group profile-form">
            <label>Sale Price <span class="text-danger">*</span></label>
            <input type="text" name="sale_price" oninput="validateNumber(this);" data-parsley-lt="#regular_price" id="sale_price" value="{{ $sale_price}}" class="form-control" data-role="sale-price" {{ $readonly}} />
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group profile-form">
            <label>Stock Quantity <span class="text-danger">*</span></label>
            <input type="number" name="stock_quantity" value="{{ $stock_quantity }}" min="0" class="form-control" data-role="stock_quantity"  {{ $readonly}} />
        </div>
    </div>

    <div class="col-lg-3 d-none">
        <div class="form-group profile-form">
            <label>SKU <span class="text-danger">*</span></label>
            <input type="text" name="product_code" value="{{ $pr_code ?? '000000000' }}" class="form-control" data-role="product_code"  {{ $readonly}} />
        </div>
    </div>

    <div class="col-lg-3 d-none">
        <div class="form-group profile-form">
            <label>Weight (mg/ml)</label>
            <input type="text" name="weight" value="{{empty($product->weight) ? '': $product->weight}}" oninput="validateNumber(this);" class="form-control" data-role="weight"/>
        </div>
    </div>
    <div class="col-lg-3 {{request()->activity_id ? 'd-none' : 'd-none'}}">
        <div class="form-group profile-form">
            <label>Length (cm)</label>
            <input type="text" name="length" value="{{empty($product->length) ? '': $product->length}}" oninput="validateNumber(this);" class="form-control" data-role="length"  />
        </div>
    </div>
    <div class="col-lg-3 {{request()->activity_id ? 'd-none' : 'd-none'}}">
        <div class="form-group profile-form">
            <label>Width (cm) </label>
            <input type="text" name="width" value="{{empty($product->width) ? '': $product->width}}" oninput="validateNumber(this);" class="form-control" data-role="width" />
        </div>
    </div>
    <div class="col-lg-3 {{request()->activity_id ? 'd-none' : 'd-none'}}">
        <div class="form-group profile-form">
            <label>Height (cm)</label>
            <input type="text" name="height" value="{{empty($product->height) ? '': $product->height}}" oninput="validateNumber(this);" class="form-control" data-role="height"/>
        </div>
    </div>

    <div class="col-lg-3 d-none">
        <div class="form-group profile-form">
            <label>Allow Back Orders</label>
            <div class="form-check">
                <label class="form-check-label">
                    <input class="product_simple_allow_backorder" type="checkbox" name="product_variant_allow_backorder[<?=$input_index?>]" value="1" <?php echo ($t_variant_allow_backorder == 1 ? 'checked': '') ?> <?php echo ($readonly ? 'disabled': '') ?> /> Yes
                </label>
            </div>
            
        </div>
    </div>
    <div class="col-lg-3 mt-4" style="display:none;">
        <div class="form-group profile-form d-flex align-items-center" >
            <label style="margin-bottom: 0">VAT</label>
            <div class="form-check">
                <label class="form-check-label">
                    <input class="taxable" type="checkbox" name="taxablesingle" value="1" <?php echo ($taxable == 1 ? 'checked': 'checked') ?> <?php echo ($readonly ? 'disabled': '') ?> /> Yes
                </label>
            </div>
            
        </div>
    </div>
    <div class="col-lg-3 d-none">
        <div class="form-group profile-form">
            <label>Bar code <span class="text-danger"></span></label>
            <input type="text" name="bar_code" value="{{$bar_code}}" class="form-control" data-role="stock_quantity" {{ $readonly}} />
        </div>
    </div>
    
    
    <div class="col-lg-12">
        <div class="form-group profile-form">
            <label>Short Description <span class="text-danger"></span></label>
            <textarea name="product_desc" class="form-control ckeditor" data-role="product_desc" {{ $readonly }} />{{$product_desc}}</textarea>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group profile-form">
            <label>Short Description (Arabic)<span class="text-danger"></span></label>
            <textarea name="product_desc_short_arabic" class="form-control text-right rtl-text ckeditor" data-role="product_desc" {{ $readonly }} />{{$product_desc_short_arabic}}</textarea>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group profile-form">
            <label>Description <span class="text-danger"></span></label>
            <textarea type="text" name="product_full_descr"  class="form-control ckeditor" data-role="product_full_descr"  {{ $readonly }} />{{$product_desc_full}}</textarea>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group profile-form">
            <label>Description (Arabic)<span class="text-danger"></span></label>
            <textarea type="text" name="product_desc_full_arabic"  class="form-control text-right rtl-text ckeditor" data-role="product_full_descr"  {{ $readonly }} />{{$product_desc_full_arabic}}</textarea>
        </div>
    </div>

     <div class="col-lg-4" style="display:none;"> 
        <div class="form-group profile-form">
            <label>Size chart <span class="text-danger"></span>@php if(!empty($size_chart)) { @endphp <a href='{{asset($size_chart)}}' target='_blank'><strong>View</strong></a>@php }  @endphp</label>
            <input type="file" name="size_chart" class="form-control" />
            <input type="hidden" name="size_chart_old" value="{{$size_chart}}" />
        </div>
    </div>

    <div class="col-lg-4">
        
    </div>
    <div class="col-lg-4">
       
    </div>

     <div class="form-row mt-3">
        <div class="col-lg-12">
            <div class="upload-product-img">
                <label for="" class="">Upload Images (Maximum 5 images)</label>
                <div id="product-simple-images" class="upload-img-product-items" data-variant-id="<?php echo $default_attribute_id ?>">
                    <?php if (! empty($product_simple_image) ): ?>
                        <?php foreach ($product_simple_image as $t_name): ?>
                            <?php
                            $exist = file_exists(FCPATH . "uploads/products/{$t_name}") ;
                            if ( !empty($t_name) ) {
                                $t_img = get_uploaded_image_url(config('global.product_image_upload_dir').$t_name);//base_url("uploads/products/{$t_name}");
                            } else {
                                $t_img = base_url('assets/images/placeholder.png');
                            }
                            ?>
                            <div class="uploaded-prev-imd">
                                <img src="<?php echo $t_img ?>" alt="" />
                                <div class="del-product-img" data-role="product-img-trash" role="button" data-image-file="<?php echo $t_name ?>" <?php echo ($readonly ? 'data-disabled="1"' : '') ?>>
                                    <i class="fas fa-times"></i> 
                                    
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                     
                        @if(!empty($product->image)) 
                        <?php  
                        $imageList = explode(",",$product->image); ?>
                            @if(!empty($imageList)) 
                                @foreach ($imageList as $key => $value) 
                                <div class="uploaded-prev-imd">
                                    <img src="{{get_uploaded_image_url($value,'product_image_upload_dir')}}" width="100" height="100">
                                    <div class="del-product-img" data-role="product-img-trash" role="button" data-image-file="{{$value}}" <?php echo ($readonly ? 'data-disabled="1"' : '') ?>><i class="far fa-trash-alt"></i> Delete</div>
                                     </div>
                                @endforeach
                            @endif
                        @endif
                    
                    <div class="uploaded-prev-imd input-upload-file-column" <?php echo ($readonly ? 'style="display:none;"' : '') ?>>

                        <div class="image_wrap">
                            <label class="Pic_upload">
                                <input counter="0" type="file" name="product_simple_image[]" class="upload_pro form-control" data-role="product-img-upload" multiple data-parsley-fileextension="jpg,png,gif,jpeg"
                                    data-parsley-fileextension-message="Only files with type jpg,png,gif,jpeg are supported" />
                                <i class="ti-plus"></i>
                            </label>
                        </div>
                        
                    </div>
                   

                </div>
                <small class="text-info">
                    Maximum size should be 2MB.<br> Allowed types are jpg, jpeg, png and gif.
                </small>
            </div>
            <div class="upload-product-video">
                <label for="">Upload Product Video (Max 50MB)</label>

                {{-- Existing or Live Preview --}}
                @php
                    $videoURL = !empty($product->video) ? get_uploaded_image_url($product->video, 'product_image_upload_dir') : '';
                 
                @endphp

                <div id="video-preview-container" class="uploaded-prev-video position-relative" style="{{ empty($videoURL) ? 'display:none;' : '' }}">
                    <video data-fancybox href="{{ $videoURL }}"  id="video-preview" width="300" height="200" >
                        @if(!empty($videoURL))
                            <source src="{{ $videoURL }}" type="video/mp4">
                        @endif
                        Your browser does not support the video tag.
                    </video>
                    <div class="del-product-video btn btn-sm btn-danger " style="position: absolute; width: 30px; height: 30px; top: 5px; right: 5px; background-color: #FF0000" data-role="product-video-trash" role="button">
                        <i class="far fa-trash-alt"></i>
                    </div>
                </div>

                
                <div class="input-upload-file-column" >
                    <div class="image_wrap">
                        <label class="Pic_upload">
                            <input
                                type="file"
                                name="product_video"
                                id="product-video-input"
                                class="upload_pro form-control"
                                accept="video/mp4,video/webm,video/quicktime"
                                data-parsley-fileextension="mp4,webm,mov"
                                data-parsley-fileextension-message="Only MP4, WebM, MOV files are allowed"
                            />
                            <i class="ti-plus"></i>
                        </label>
                        <input type="hidden" name="delete_product_video" id="delete-product-video-flag" value="0">

                    </div>
                </div>

                <small class="text-info">
                    Maximum size: 50MB. <br> Allowed types: mp4, webm, mov.
                </small>
            </div>


        </div>
    </div>
    <input type="hidden" name="image_counter" value="0" id="image_counter">
</div>
<!-- Fancybox CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />

<!-- Fancybox JS -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
<script>
    Fancybox.bind("[data-fancybox]", {
        // Custom options
    });
</script>
