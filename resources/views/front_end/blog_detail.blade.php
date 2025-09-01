@extends('front_end.template.layout')
@section('content')
            <!--Body Container-->
            <div id="page-content">
                <!--Collection Banner-->
                <div class="collection-header">
                    <div class="collection-hero m-0">
                        <div class="collection-hero__image"></div>
                        <div class="collection-hero__title-wrapper container">
                            <h1 class="collection-hero__title">Blog Detail</h1>
                            <div class="breadcrumbs text-uppercase mt-1 mt-lg-2"><a href="{{ route('home') }}" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">Blog Detail</span></div>
                        </div>
                    </div>
                </div>
                
                <div class="container mt-5 mb-5">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card overflow-hidden">
                                <div class="card-body p-0">
                                    <div class="blog-details">
                                        <img class="img-fluid w-100 mb-1" src="{{ $blog->blog_image }}">
                                        <div class="p-2">
                                            <h2 class="fs-3">{{ $blog->name }}</h2>
                                            {!! $blog->description !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="search-blog position-relative mb-4">
                                        <input type="search" id="search-blog" class="form-control" placeholder="Search">
                                        <button><i class="icon an an-search-l"></i></button>
                                    </div>
                                    <h2 class="fs-5">Recent Posts</h2>
                                    <ul class="recent-posts">
                                         @foreach($recent_blogs as $recent)
                                        <li class="recent-content">
                                            <a href="{{ route('blog-detail', ['id' => $recent->id]) }}">
                                                <img class="img-fluid" src="{{ $recent->blog_image }}" alt="{{ $recent->name }}">
                                                <h2>{{ \Illuminate\Support\Str::words($recent->name, 8) }}</h2>
                                            </a>
                                        </li>
                                        @endforeach
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
            <!--End Body Container-->
@endsection 