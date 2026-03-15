@include('frontend.partials.header')


    <!-- BreadCrumb Starts -->  
    <section class="breadcrumb-main pb-20 pt-14" style="background-image: url(images/bg/bg1.jpg);">
        <div class="section-shape section-shape1 top-inherit bottom-0" style="background-image: url(images/shape8.png);"></div>
        <div class="breadcrumb-outer">
            <div class="container">
                <div class="breadcrumb-content text-center">
                    <h1 class="mb-3">Tour Grid</h1>
                    <nav aria-label="breadcrumb" class="d-block">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tour Grid Leftside</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="dot-overlay"></div>
    </section>
    <!-- BreadCrumb Ends --> 

    <!-- top Destination starts -->
    <section class="trending pt-6 pb-0 bg-lgrey">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="list-results d-flex align-items-center justify-content-between">
                        <div class="list-results-sort">
                            <p class="m-0">Showing {{ $tours->count() }} of {{ $tours->count() }} results</p>
                        </div>
                        <div class="click-menu d-flex align-items-center justify-content-between">
                            <div class="sortby d-flex align-items-center justify-content-between ml-2">
                                <form method="get" action="{{ route('category.tours', $category->slug) }}" id="sortForm" class="d-inline">
                                    <select name="sort" class="niceSelect form-select form-select-sm" onchange="this.form.submit()" style="min-width: 180px;">
                                        <option value="">Sort By</option>
                                        <option value="price_asc" {{ ($sort ?? '') === 'price_asc' ? 'selected' : '' }}>Price: low to high</option>
                                        <option value="price_desc" {{ ($sort ?? '') === 'price_desc' ? 'selected' : '' }}>Price: high to low</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>

                   <div class="row">
                        @forelse($tours as $tour)
                            <div class="col-lg-6 col-md-6 mb-4">
                                <div class="trend-item rounded box-shadow">
                                    <div class="trend-image position-relative">
                                        <img src="{{ $tour->image ? asset($tour->image) : asset('/images/trending/trending10.jpg') }}"
                                            alt="image"
                                            style="width:100%;height:400px;object-fit:cover;">
                                        <div class="color-overlay"></div>
                                    </div>

                                    <div class="trend-content p-4 pt-5 position-relative">
                                        <div class="trend-meta bg-theme white px-3 py-2 rounded">
                                            <div class="entry-author">
                                                <i class="icon-calendar"></i>
                                                <span class="fw-bold">
                                                    {{ is_array($tour->day) ? implode(', ', $tour->day) : $tour->day }} Days
                                                </span>

                                            </div>
                                        </div>

                                        <h5 class="theme mb-1">
                                            <i class="flaticon-location-pin"></i> {{ $tour->location }}
                                        </h5>

                                        <h3 class="mb-1">
                                            <a href="{{ route('frontend.tour.detail', $tour->slug) }}">
                                                {{ $tour->title }}
                                            </a>
                                        </h3>

                                        <div class="rating-main d-flex align-items-center pb-2">
                                            <div class="rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span class="fa {{ $i <= $tour->star_rating ? 'fa-star checked' : 'fa-star-o' }}"></span>
                                                @endfor
                                            </div>
                                        </div>

                                        <p class="border-b pb-2 mb-2">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($tour->description), 200) }}
                                        </p>

                                        <div class="entry-meta">
                                            <p class="mb-0">
                                                <span class="theme fw-bold fs-5">{{ $tour->price }}</span> | Per person
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <!-- EMPTY STATE -->
                            <div class="col-lg-12">
                                <div class="alert alert-warning text-center">
                                    No tours available in this category.
                                </div>
                            </div>
                        @endforelse

                        @if($tours->count() > 0)
                            <div class="col-lg-12">
                                <div class="text-center">
                                    <a href="#" class="nir-btn">
                                        Load More <i class="fa fa-long-arrow-alt-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
                <div class="col-lg-4 ps-lg-4">
                    <div class="sidebar-sticky">
                        <div class="list-sidebar">
                            <div class="sidebar-item mb-4">
                                <h3 class="">Categories Type</h3>
                                @php
                                    $categoriesWithCount = $categoriesWithCount ?? collect();
                                    $parentCategories = $categoriesWithCount->whereNull('parent_id')->sortBy('name');
                                    $selectedCategories = request()->get('categories', []);
                                    if (!is_array($selectedCategories)) {
                                        $selectedCategories = isset($category) ? [$category->id] : [];
                                    }
                                @endphp
                                <form method="get" action="{{ route('category.tours', isset($category) && $category->slug ? $category->slug : ($parentCategories->first()->slug ?? 'all')) }}" id="categoryFilterForm">
                                    @if(request()->has('sort'))
                                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                                    @endif
                                    <ul class="sidebar-category1 list-unstyled">
                                        @forelse($parentCategories as $parent)
                                        <li class="mb-2">
                                            <label class="d-flex justify-content-between align-items-center text-decoration-none text-dark w-100 mb-0" style="cursor: pointer;">
                                                <span class="d-flex align-items-center flex-grow-1">
                                                    <input type="checkbox" 
                                                           name="categories[]" 
                                                           value="{{ $parent->id }}"
                                                           {{ in_array($parent->id, $selectedCategories) ? 'checked' : '' }}
                                                           class="me-2 category-checkbox"
                                                           onchange="document.getElementById('categoryFilterForm').submit();">
                                                    <strong>{{ $parent->name }}</strong>
                                                </span>
                                                <span>{{ $parent->tours_count ?? 0 }}</span>
                                            </label>
                                            @php
                                                $children = $categoriesWithCount->where('parent_id', $parent->id)->sortBy('name');
                                            @endphp
                                            <!-- @if($children->isNotEmpty())
                                            <ul class="sidebar-category1 list-unstyled ms-3 mt-1 ps-2 border-start border-secondary" style="border-width: 2px !important;">
                                                @foreach($children as $child)
                                                <li class="py-1">
                                                    <label class="d-flex justify-content-between align-items-center text-decoration-none text-dark w-100 mb-0" style="cursor: pointer;">
                                                        <span class="d-flex align-items-center flex-grow-1">
                                                            <input type="checkbox" 
                                                                   name="categories[]" 
                                                                   value="{{ $child->id }}"
                                                                   {{ in_array($child->id, $selectedCategories) ? 'checked' : '' }}
                                                                   class="me-2 category-checkbox"
                                                                   onchange="document.getElementById('categoryFilterForm').submit();">
                                                            {{ $child->name }}
                                                        </span>
                                                        <span>{{ $child->tours_count ?? 0 }}</span>
                                                    </label>
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif -->
                                        </li>
                                        @empty
                                        <li class="text-muted">No categories yet.</li>
                                        @endforelse
                                    </ul>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- top Destination ends -->

    <!-- Discount action starts -->
    <section class="discount-action pt-0" style="background-image:url(images/section-bg1.png); background-position:center;">
        <div class="container">
            <div class="call-banner rounded pt-10 pb-14">
                <div class="call-banner-inner w-75 mx-auto text-center px-5">
                    <div class="trend-content-main">
                        <div class="trend-content mb-5 pb-2 px-5">
                            <h5 class="mb-1 theme">Love Where Your're Going</h5>
                            <h2><a href="detail-fullwidth.html">Explore Your Life, <span class="theme1"> Travel Where You Want!</span></a></h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                        <div class="video-button text-center position-relative">
                             <div class="call-button text-center">
                                <button type="button" class="play-btn js-video-button" data-video-id="152879427" data-channel="vimeo">
                                    <i class="fa fa-play bg-blue"></i>
                                </button>
                            </div>
                            <div class="video-figure"></div>
                        </div>
                    </div>
                </div>
            </div>     
        </div>    
        <div class="white-overlay"></div>
        <div class="white-overlay"></div>
        <div class="section-shape  top-inherit bottom-0" style="background-image: url(images/shape6.png);"></div>
    </section>
    <!-- Discount action Ends -->

    <!-- partner starts -->
    <section class="our-partner pb-6 pt-6">
        <div class="container">
            <div class="section-title mb-6 w-75 mx-auto text-center">
                <h4 class="mb-1 theme1">Our Partners</h4>
                <h2 class="mb-1">Our Awesome <span class="theme">partners</span></h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p>
            </div>
            <div class="row align-items-center partner-in partner-slider">
                <div class="col-md-3 col-sm-6">
                    <div class="partner-item p-4 py-2 rounded bg-lgrey">
                        <img src="images/cl-1.png" alt="">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="partner-item p-4 py-2 rounded bg-lgrey">
                        <img src="images/cl-5.png" alt="">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="partner-item p-4 py-2 rounded bg-lgrey">
                        <img src="images/cl-2.png" alt="">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="partner-item p-4 py-2 rounded bg-lgrey">
                        <img src="images/cl-3.png" alt="">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="partner-item p-4 py-2 rounded bg-lgrey">
                        <img src="images/cl-4.png" alt="">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="partner-item p-4 py-2 rounded bg-lgrey">
                        <img src="images/cl-5.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- partner ends -->

   <!-- footer starts -->
 @include('frontend.partials.footer')

    <!-- footer ends -->



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