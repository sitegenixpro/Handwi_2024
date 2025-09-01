@extends('front_end.template.layout')
@section('content')
            <!--Body Container-->
            <div id="page-content">
                <!--Collection Banner-->
                <div class="collection-header">
                    <div class="collection-hero m-0">
                        <div class="collection-hero__image"></div>
                        <div class="collection-hero__title-wrapper container">
                            <h1 class="collection-hero__title">Blogs</h1>
                            <div class="breadcrumbs text-uppercase mt-1 mt-lg-2"><a href="{{ route('home') }}" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">Blogs</span></div>
                        </div>
                    </div>
                </div>
                <div class="container mt-5 mb-5">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row">
                                 @foreach($blogs as $blog)
                                <div class="col-md-6 mb-4">
                                    <article class="h-100 entry mb-0 position-relative">
                                        <div class="entry-img mb-0">
                                            <img class="w-100 img-fluid" src="{{ $blog->blog_image }}">
                                        </div>
                                        <div class="entry-content mb-2">
                                            <h2>{{ $blog->name }}</h2>
                                            {!! \Illuminate\Support\Str::words(strip_tags($blog->description), 18, '...') !!}
                                            <div class="btn-primary btn-lg rounded read-more">Read More</div>
                                        </div>
                                        <a href="{{ route('blog-detail', ['id' => $blog->id]) }}" class="blog-overlay-link"></a>
                                    </article>
                                </div>
                                @endforeach
                              
                               
                               
                               
                               
                            </div>
                            <div class="pagination">
                                {{ $blogs->links() }}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="search-blog position-relative mb-4">
                                        <input type="search" id="search-blog"  class="form-control" placeholder="Search">
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