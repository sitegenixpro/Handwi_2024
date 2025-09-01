@foreach ($services as $service)
                                    <div class="col-12 col-sm-6 col-md-4  item" style="display: block;">
                                        <!--Start Product Image-->
                                        <div class="product-image">
                                            <!--Start Product Image-->
                                            <a href="{{ route('workshopdetail', $service->id) }}" class="product-img">
                                                <!--Image-->
                                                <img class="primary blur-up lazyload" data-src="{{ asset($service->image) }}" src="{{ asset($service->image) }}" alt="image" title="" width="800" height="960">
                                                <!--End image-->
                                                <!--Hover image-->
                                                <img class="hover blur-up lazyload" data-src="{{ asset($service->image) }}" src="{{ asset($service->image) }}" alt="image" title="" width="800" height="960">
                                                <!--End hover image-->
                                            </a>
                                            <!--end product image-->

                                            <!--Product Button-->
                                            <div class="button-set-bottom show-always position-absolute style1">
                                                <!--Cart Button-->
                                                <a class="btn-icon btn  rounded  bg-cream9 " href="{{ route('workshopdetail', $service->id) }}">
                                                    <i class="icon an an-cart-l"></i> <span>{{ \Carbon\Carbon::parse($service->from_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($service->to_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($service->from_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($service->to_time)->format('H:i') }}</span>
                                                </a>
                                                <!--End Cart Button-->
                                            </div>
                                            <!--End Product Button-->
                                        </div>
                                        <!--End Product Image-->
                                        <!--Start Product Details-->
                                        <div class="product-details text-center">
                                            <!--Product Name-->
                                            <div class="product-name text-uppercase">
                                                <a href="{{ route('workshopdetail', $service->id) }}">{{ $service->name }}</a>
                                            </div>
                                            <!--End Product Name-->
                                            <!--Product Price-->
                                            <div class="product-price">
                                                <span class="price">AED {{ $service->service_price }} </span>
                                            </div>
                                        </div>
                                        <!--End Product Details-->
                                    </div>
                                    @endforeach