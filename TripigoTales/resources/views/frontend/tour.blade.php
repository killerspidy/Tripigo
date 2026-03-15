@include('frontend.partials.header')
<style>
  /* Share button */
.share-inline-btn {
    display: flex;
    gap: 6px;
}

.share-inline-btn a {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
}

.share-inline-btn a:nth-child(1) { background: #1877F2; } /* Facebook */
.share-inline-btn a:nth-child(2) { 
    background: linear-gradient(45deg,#f09433,#dc2743,#bc1888);
}
.share-inline-btn a:nth-child(3) { background: #25D366; }

/* Book Now button */
.book-btn-inline {
    padding: 8px 22px;
    border-radius: 30px;
    font-weight: 600;
    font-size: 14px;
    color: #fff;
    background: linear-gradient(135deg, #0aa6a6, #0f766e);
    box-shadow: 0 6px 15px rgba(15,118,110,.35);
    text-decoration: none;
    transition: 0.3s;
}

.book-btn-inline:hover {
    transform: translateY(-2px);
    color: #fff;
}

</style>    
  
 <!-- BreadCrumb Starts -->  
<section class="breadcrumb-main pb-20 pt-14" 
    style="background-image: url('{{ asset('images/bg/bg1.jpg') }}');">
    
    <div class="section-shape section-shape1 top-inherit bottom-0" 
         style="background-image: url('{{ asset('images/shape8.png') }}');">
    </div>

    <div class="breadcrumb-outer">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <h1 class="mb-3">Tours We Offer</h1>
                <nav aria-label="breadcrumb" class="d-block">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Tours
                        </li>
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
            <div class="list-results d-flex align-items-center justify-content-between">
                <div class="list-results-sort">
                    <p class="m-0">Showing {{ $tours->count() }} of {{ $tours->count() }} results</p>
                </div>
                <div class="click-menu d-flex align-items-center justify-content-between">
                    <div class="sortby d-flex align-items-center justify-content-between ml-2">
                        <form method="get" action="{{ route('frontend.tour') }}" id="tourSortForm" class="d-inline">
                            @php $searchParams = $searchParams ?? []; @endphp
                            @if(!empty($searchParams['destination']))<input type="hidden" name="destination" value="{{ $searchParams['destination'] }}">@endif
                            @if(!empty($searchParams['travel_type']))<input type="hidden" name="travel_type" value="{{ $searchParams['travel_type'] }}">@endif
                            @if(!empty($searchParams['tour_duration']))<input type="hidden" name="tour_duration" value="{{ $searchParams['tour_duration'] }}">@endif
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
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="trend-item rounded box-shadow">
                        <div class="trend-image position-relative">
                            <img src="{{ $tour->image ? asset($tour->image) : asset('/images/trending/trending10.jpg') }}" alt="image" class="" width="400" height="400">
                            <div class="color-overlay"></div>
                        </div>
                        <div class="trend-content p-4 pt-5 position-relative">
                            <div class="trend-meta bg-theme white px-3 py-2 rounded">
                                <div class="entry-author">
                                    <i class="icon-calendar"></i>
                                    <span class="fw-bold"> {{ $tour->tour_duration ?? 0 }}</span>
                                </div>
                            </div>
                            <h5 class="theme mb-1"><i class="flaticon-location-pin"></i>{{ $tour->location }}</h5>
                            <h3 class="mb-1"><a href="{{ route('frontend.tour.detail', $tour->slug) }}">{{ $tour->title }}</a></h3>
                            <div class="rating-main d-flex align-items-center pb-2">
                             <div class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $tour->star_rating)
                                        <span class="fa fa-star checked"></span>
                                    @else
                                        <span class="fa-regular fa-star"></span>
                                    @endif
                                @endfor
                            </div>

                            </div>
                            <p class="border-b pb-2 mb-2">
                                {{ \Illuminate\Support\Str::limit(strip_tags($tour->description), 200) }}
                            </p>
                           <div class="entry-meta">
    <div class="d-flex align-items-center justify-content-between flex-nowrap">

        {{-- Price --}}
        <p class="mb-0 d-flex align-items-center">
            <span class="theme fw-bold fs-5 me-1">₹{{ $tour->price }}</span>
            <span class="text-muted">/pax</span>
        </p>

        {{-- Buttons --}}
        <div class="d-flex align-items-center gap-2 ms-2">

            {{-- Share Icons --}}
            <div class="share-inline-btn d-flex align-items-center">
          
                <a href="https://wa.me/?text={{ urlencode($tour->title) }} {{ url()->current() }}" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>

            {{-- Book Now --}}
            <a href="{{ route('frontend.tour.detail', $tour->slug) }}" class="book-btn-inline">
                Book Now
            </a>

        </div>
    </div>
</div>


                        </div>
                    </div>
                </div>
                @empty
                <div class="col-lg-12 py-5 text-center">
                    <p class="text-muted mb-3">No tours found. Try adjusting your search or <a href="{{ route('frontend.tour') }}">view all tours</a>.</p>
                    <a href="{{ url('/') }}" class="nir-btn">Back to Home</a>
                </div>
                @endforelse

                @if($tours->count() > 0)
                <div class="col-lg-12">
                    <div class="text-center">
                        <a href="{{ route('frontend.tour') }}" class="nir-btn">View All Tours <i class="fa fa-long-arrow-alt-right"></i></a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
    <!-- top Destination ends -->

    <!-- Discount action starts -->
    
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
