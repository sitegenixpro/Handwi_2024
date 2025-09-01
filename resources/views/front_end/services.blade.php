@extends('front_end.template.layout')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    
    .shop-listview-drawer .collection-hero__image, 
    .shop-sub-collections .collection-hero__image, 
    .shop-top-filter .collection-hero__image { 
        background-image: url("{{ asset($workshop->banner_image) }}"); 
    }
    #load-more-services {

    align-items: center;
    gap: 1px; /* Adjust the value as needed */
}

#loaded-services-count, #total-services-count {
    margin-left: 2px; /* Optional: Add space between the count elements */
}
.select2-container--default .select2-results__option--highlighted[aria-selected]{
    background: #000;
    background-color: #000;
    color: #fff;
}

.select2-container{
    z-index: 9999;
}
.select2-container--default .select2-selection--single .select2-selection__arrow{
    height: 42px;
}
    .select2-container .select2-selection--single{
        height: 42px;
    }
</style>
<!--Body Container-->
<div id="page-content">
                <!-- Collection Banner -->
                <div class="collection-header">
                    <div class="collection-hero medium mb-4 mb-lg-5">
                        <div class="collection-hero__image blur-up lazyload"></div>
                        <div class="collection-hero__title-wrapper container">
                            <h1 class="collection-hero__title medium">{{$workshop->name}}</h1>
                            <div class="breadcrumbs text-uppercase mt-1 mt-lg-2"><a href="{{ route('home') }}" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">{{$workshop->name}}</span></div>
                        </div>
                    </div>
                </div>
                <!-- End Collection Banner -->

                <div class="container shop-fullwidth">
                    
                    <!--Sidebar-->
                    <div class="col-12 col-sm-12 col-md-12 col-lg-3 sidebar filterbar">
                        <div class="closeFilter d-block"><i class="icon icon an an-times-r"></i></div>
                        <div class="sidebar_tags">
                            <!--Categories-->
                            <div class="sidebar_widget categories filterBox filter-widget">
                                <h2 class="mb-2">Categories</h2>
                                <form method="GET" action="{{ route('workshops') }}">
                                <select name="category_id" id="category_id" class="select2" data-placeholder="Select Category">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <hr>
                                <h2 class="mb-2">City</h2>
                                <select name="city_id" id="city_id" class="select2" data-placeholder="Select City">
                                    <option value="">All Cities</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                <hr>
                                <button class="btn btn--small rounded w-100">filter</button>
                            </form>
                        </div>
                    </div>
                    </div>

                    <!--Toolbar-->
                            <div class="toolbar mt-0 mb-0">
                                <div class="filters-toolbar-wrapper mb-0">
                                    <ul class="list-unstyled d-flex align-items-center justify-content-between">
                                        <li class="product-count d-flex align-items-center">
                                            <button type="button" class="btn btn-filter d-flex align-items-center an an-slider-3 me-2 me-sm-3">Filter</button>
                                            <div class="filters-toolbar__item">
                                                <span class="filters-toolbar__product-count d-none d-sm-block"> Showing: 1 - 5 of 5 products</span>
                                            </div>
                                        </li>
                                        
                                        <li class="filters-sort ms-auto ms-sm-0">
                                            <div class="filters-toolbar__item">
                                                <label for="SortBy" class="hidden">Sort by:</label>
                                                <form>
                                                    <select name="SortBy" id="SortBy" class="filters-toolbar__input filters-toolbar__input--sort">
                                                        <option value="" >Sort By</option>
                                                        <option value="nearest">Nearest</option>
                                                        <option value="farthest">Farthest</option>
                                                        <option value="price-ascending">Price, low to high</option>
                                                        <option value="price-descending">Price, high to low</option>
                                                    </select>
                                                </form>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--End Toolbar-->
                </div>
                <!--Most Popular-->
                <section class="section product-items pt-2 pb-0 pt-lg-5">
                    <div class="container">
                        
                        <!--Product List-->
                        <div class="product-load-more">
                            <!--Product Grid-->
                            <div class="grid-products grid--view-items">
                                <div class="row" id="servicegrid">
                                @if($services->isEmpty())
                                    <<div class="alert alert-warning text-center" role="alert">
                                        <i class="align-middle icon an an-cart icon-large me-2"></i><strong>No workshops availabe.</strong>
                                    </div>
                                @else
                                     @foreach ($services as $service)
                                    <div class="col-12 col-sm-6 col-md-4  item">
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
                                @endif
                                </div>
                            </div>
                            <!--End Product Grid-->

                            <!--Load More Button-->
                            <div class="infinitpaginOuter">
                                <div class="infinitpagin">	
                                @if($services->count() < $totalServices)
                                    <a href="#" class="btn rounded " id="load-more-services" data-offset="6">Load More <span id="loaded-services-count"> {{ $services->count() }}</span> / <span id="total-services-count">{{ $totalServices }}</span></a>
                                @endif
                                </div>
                            </div>
                            <!--End Load More Button-->
                        </div>
                        <!--End Product List-->
                    </div>
                </section>
                <!--End Most Popular-->
            </div>
            <!--End Body Container-->
@endsection

@section('script')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
      $(".select2").select2({      
      });
    });
    


    
    
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sortSelect = document.getElementById('SortBy');

    // Optional: populate select from current URL
    const params = new URLSearchParams(window.location.search);
    if (params.get('SortBy')) {
        sortSelect.value = params.get('SortBy');
    }

    sortSelect.addEventListener('change', function () {
        const sortBy = this.value;

        // Optional: use stored location or fallback
        let latitude = localStorage.getItem('latitude');
        let longitude = localStorage.getItem('longitude');

        // If not stored, try to get it (this will ask for permission)
        if (!latitude || !longitude) {
            navigator.geolocation.getCurrentPosition(function (position) {
                latitude = position.coords.latitude;
                longitude = position.coords.longitude;
                localStorage.setItem('latitude', latitude);
                localStorage.setItem('longitude', longitude);
                redirectToSortedUrl(sortBy, latitude, longitude);
            });
        } else {
            redirectToSortedUrl(sortBy, latitude, longitude);
        }
    });

    function redirectToSortedUrl(sortBy, lat, lng) {
        const url = new URL(window.location.href);
        url.searchParams.set('SortBy', sortBy);
        if (sortBy === 'nearest' || sortBy === 'farthest') {
            url.searchParams.set('latitude', lat);
            url.searchParams.set('longitude', lng);
        } else {
            url.searchParams.delete('latitude');
            url.searchParams.delete('longitude');
        }
        url.searchParams.set('offset', 0); // reset pagination
        window.location.href = url.toString();
    }
});
</script>


@endsection