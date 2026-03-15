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
                <h1 class="mb-3">Our Blogs</h1>
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Blogs
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="dot-overlay"></div>
</section>
<!-- BreadCrumb Ends -->


    <!-- Blogs starts -->
    <section class="trending pt-6 pb-6 bg-lgrey">
        <div class="container">
            @if(isset($blogs) && $blogs->count() > 0)
            <div class="list-results d-flex align-items-center justify-content-between mb-4">
                <div class="list-results-sort">
                    <p class="m-0">
                        Showing {{ $blogs->firstItem() ?? 0 }}-{{ $blogs->lastItem() ?? 0 }} of {{ $blogs->total() }} blogs
                    </p>
                </div>
            </div>
            @endif

            <div class="row">
                @forelse($blogs ?? [] as $blog)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="trend-item rounded box-shadow bg-white h-100">
                        <div class="trend-image position-relative">
                            <img 
                                src="{{ $blog->image ? asset($blog->image) : asset('images/trending/trending10.jpg') }}" 
                                alt="{{ $blog->title }}" 
                                style="width:100%; height:300px; object-fit:cover;"
                            />
                            <div class="color-overlay"></div>
                        </div>
                        <div class="trend-content p-4 pt-5 position-relative">
                            <div class="trend-meta bg-theme white px-3 py-2 rounded mb-3">
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
                                <h5 class="theme mb-2"><i class="icon-user"></i> {{ $blog->author }}</h5>
                            @endif
                            <h3 class="mb-2">
                                <a href="{{ route('frontend.blog.detail', $blog->slug) }}">
                                    {{ \Illuminate\Support\Str::limit($blog->title, 60) }}
                                </a>
                            </h3>
                            @if($blog->description)
                                <p class="border-b pb-2 mb-2">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($blog->description), 150) }}
                                </p>
                            @endif
                            <div class="entry-meta">
                                <a href="{{ route('frontend.blog.detail', $blog->slug) }}" class="nir-btn">
                                    Read More <i class="fa fa-long-arrow-alt-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <h3 class="mb-3">No Blogs Found</h3>
                        <p class="mb-0">Check back soon for new blog posts!</p>
                    </div>
                </div>
                @endforelse
            </div>

            @if(isset($blogs) && $blogs->hasPages())
            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="text-center">
                        <nav aria-label="Blog pagination">
                            {{ $blogs->links() }}
                        </nav>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
    <!-- Blogs Ends -->

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
