@include('frontend.partials.header')

  
 <!-- BreadCrumb Starts -->  
<section class="breadcrumb-main pb-20 pt-14" 
    style="background-image: url('{{ asset('images/bg/bg1.jpg') }}');">
    
    <div class="section-shape section-shape1 top-inherit bottom-0" 
         style="background-image: url('{{ asset('images/shape8.png') }}');">
    </div>

    <div class="breadcrumb-outer">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <h1 class="mb-3">Blog Details</h1>
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}">Home</a>
                        </li>
                         <li class="breadcrumb-item">
                            <a href="{{ route('frontend.blogs') }}">Blogs</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $blog->title }}
                        </li>
                     
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="dot-overlay"></div>
</section>
<!-- BreadCrumb Ends -->
    <!-- Blog Detail starts -->
    <section class="trending pt-6 pb-6 bg-lgrey">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="trend-item rounded box-shadow bg-white p-4">
                        @if($blog->image)
                        <div class="trend-image mb-4">
                            <img 
                                src="{{ asset($blog->image) }}" 
                                alt="{{ $blog->title }}" 
                                style="width:100%; height:400px; object-fit:cover; border-radius:8px;"
                            />
                        </div>
                        @endif

                        <div class="trend-meta bg-theme white px-3 py-2 rounded mb-3 d-inline-block mt-4">
                            <div class="entry-author">
                                <i class="icon-calendar"></i>
                                <span class="fw-bold">
                                    @if($blog->published_date)
                                        {{ $blog->published_date->format('d M Y') }}
                                    @else
                                        {{ $blog->created_at->format('d M Y') }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        @if($blog->author)
                            <h5 class="theme mb-3"><i class="icon-user"></i> {{ $blog->author }}</h5>
                        @endif

                        <h2 class="mb-3">{{ $blog->title }}</h2>

                        @if($blog->description)
                            <div class="blog-content" style="line-height: 1.8; font-size: 16px;">
                                {!! $blog->description !!}
                            </div>
                        @endif

                        <div class="mt-4 pt-4 border-top d-flex justify-content-between align-items-center">
                            <a href="{{ route('frontend.blogs') }}" class="nir-btn">
                                <i class="fa fa-arrow-left"></i> Back to Blogs
                            </a>
                            <div class="social-share">
                                @php
                                    $blogUrl = route('frontend.blog.detail', $blog->slug);
                                    $shareText = urlencode("Check out this amazing blog: {$blog->title}");
                                @endphp
                                <a href="https://wa.me/?text={{ $shareText }} {{ $blogUrl }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-primary me-1">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sidebar-sticky">
                        <div class="trend-item rounded box-shadow bg-white p-4 mb-4">
                            <h4 class="mb-3">Recent Blogs</h4>
                            @php
                                $recentBlogs = collect();
                                if (\Illuminate\Support\Facades\Schema::hasTable('blogs')) {
                                    $recentBlogs = \App\Models\Blog::where('status', 1)
                                        ->where('id', '!=', $blog->id)
                                        ->latest()
                                        ->take(5)
                                        ->get();
                                }
                            @endphp
                            @forelse($recentBlogs as $recent)
                                <div class="mb-3 pb-3 border-bottom">
                                    <h6 class="mb-1">
                                        <a href="{{ route('frontend.blog.detail', $recent->slug) }}">
                                            {{ \Illuminate\Support\Str::limit($recent->title, 50) }}
                                        </a>
                                    </h6>
                                    <small class="text-muted">
                                        @if($recent->published_date)
                                            {{ $recent->published_date->format('d M Y') }}
                                        @else
                                            {{ $recent->created_at->format('d M Y') }}
                                        @endif
                                    </small>
                                </div>
                            @empty
                                <p class="text-muted mb-0">No recent blogs</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Detail Ends -->

@include('frontend.partials.footer')

   <!-- *Scripts* -->
<script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/fontawesome.min.js') }}"></script>
<script src="{{ asset('js/particles.js') }}"></script>
<script src="{{ asset('js/particlerun.js') }}"></script>
<script src="{{ asset('js/plugin.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/custom-swiper.js') }}"></script>
<script src="{{ asset('js/custom-nav.js') }}"></script>
  </body>
</html>
