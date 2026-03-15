<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zxx">
  <head>
    <meta charset="UTF-8" />
    @if(Route::is('home'))
   <title>Tripigo Tales | Tours & Travels | Customized Holiday Packages</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Tripigo Tales is a trusted travel agency offering customized domestic tour packages, honeymoon trips, spiritual tours, and family holidays." />
    <meta name="keywords" content="tours and travels, travel agency, holiday packages, customized tours, trip planner, honeymoon packages, travel company in india" />
    <meta name="author" content="Tripigo Tales" />
    @elseif(Route::is('frontend.tour'))
         <title>Tour Packages | Domestic Tours – Tripigo Tales</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="Explore domestic tour packages with Tripigo Tales. Family tours, honeymoon trips, spiritual tours, and customized holidays available." />
        <meta name="keywords" content="tour packages, holiday packages, domestic tours, travel packages india, customized tour packages" />
        <meta name="author" content="Tripigo Tales" />
        @elseif(Route::is('frontend.tour.detail'))
       <title>Tour Details | Domestic Tours – Tripigo Tales</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="Explore the selected domestic tour package with Tripigo Tales" />
        <meta name="keywords" content="tour packages, holiday packages, domestic tours, travel packages india, customized tour packages" />
        <meta name="author" content="Tripigo Tales" />
     @elseif(Route::is('frontend.aboutus'))
          <title>About Tripigo Tales | Trusted Tours & Travel Agency</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="Know more about Tripigo Tales, a customer-focused travel agency creating personalized travel experiences across India." />
        <meta name="keywords" content="about travel agency, tripigo tales, tours and travels company, travel experts, holiday planners" />
        <meta name="author" content="Tripigo Tales" />
          @elseif(Route::is('frontend.blogs'))
        <title>Travel Blog | Destination Guides & Travel Stories – Tripigo Tales</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="Read travel blogs, destination guides, spiritual journeys, and travel tips by Tripigo Tales to plan your next trip better." />
        <meta name="keywords" content="travel blog, destination guide, travel stories, trip planning tips, india travel blog" />
        <meta name="author" content="Tripigo Tales" />
                          @elseif(Route::is('frontend.blog.detail'))
        <title>Blog Details | Tripigo Tales</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="Read travel blogs, destination guides, spiritual journeys, and travel tips by Tripigo Tales to plan your next trip better." />
        <meta name="keywords" content="travel blog, destination guide, travel stories, trip planning tips, india travel blog" />
        <meta name="author" content="Tripigo Tales" />
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}" />
    @elseif(Route::is('frontend.faq'))
 <title>FAQs | Travel Booking Help – Tripigo Tales</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="Find answers to common travel booking questions including payments, cancellations, tour packages, and customized trips at Tripigo Tales." />
        <meta name="keywords" content="travel faq, tour booking questions, holiday booking help, tripigo tales faq" />
        <meta name="author" content="Tripigo Tales" />
    @elseif(Route::is('frontend.gallery'))  
<title>Travel Gallery | Tripigo Tales Tours & Experiences</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="Explore photos from tour packages, destinations, and travel experiences curated by Tripigo Tales across India." />
        <meta name="keywords" content="travel gallery, tour photos, travel experiences, holiday pictures" />
        <meta name="author" content="Tripigo Tales" />
    @elseif(Route::is('frontend.contactus'))
        <title>Contact Tripigo Tales | Plan Your Trip Today</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="Contact Tripigo Tales for customized travel packages, holiday planning, and tour enquiries. Call or WhatsApp our travel experts today." />
        <meta name="keywords" content="contact travel agency, trip enquiry, tour booking contact, holiday planner contact" />
        <meta name="author" content="Tripigo Tales" />
       @elseif(Route::is('frontend.cancellation.policy'))
       <title>Cancellation & Refund Policy | Tripigo Tales</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="Know about cancellation charges and refund policies for tour packages booked with Tripigo Tales." />
        <meta name="keywords" content="cancellation policy travel, refund policy tours, tripigo tales cancellation" />
        <meta name="author" content="Tripigo Tales" />
      @elseif(Route::is('frontend.terms.and.conditions'))
       <title>Terms & Conditions | Tripigo Tales Travel Services</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="Review the terms and conditions for booking tours and travel services with Tripigo Tales." />
        <meta name="keywords" content="travel terms and conditions, tour booking terms, tripigo tales terms" />
        <meta name="author" content="Tripigo Tales" />
         @elseif(Route::is('frontend.tour.book'))
 <title>Travel Booking | Tripigo Tales</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="Find answers to common travel booking questions including payments, cancellations, tour packages, and customized trips at Tripigo Tales." />
        <meta name="keywords" content="travel faq, tour booking questions, holiday booking help, tripigo tales faq" />
        <meta name="author" content="Tripigo Tales" />
                 @elseif(Route::is('frontend.booking.success'))
 <title>Booking Successful| Tripigo Tales</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="Find answers to common travel booking questions including payments, cancellations, tour packages, and customized trips at Tripigo Tales." />
        <meta name="keywords" content="travel faq, tour booking questions, holiday booking help, tripigo tales faq" />
        <meta name="author" content="Tripigo Tales" />
      @elseif(Route::is('frontend.privacy.policy'))
      <title>Privacy Policy | Tripigo Tales Tours & Travels</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="Read the privacy policy of Tripigo Tales to understand how we collect, use, and protect customer information." />
        <meta name="keywords" content="privacy policy travel website, data protection policy, tripigo tales privacy" />
        <meta name="author" content="Tripigo Tales" />
    @else
        <title>Tripigo Tales</title>
    @endif

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}" />
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />

    <!-- Plugin CSS -->
    <link href="{{ asset('css/plugin.css') }}" rel="stylesheet" type="text/css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}" />

    <!-- Line Icons -->
    <link rel="stylesheet" href="{{ asset('fonts/line-icons.css') }}" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
    /* Simple Profile Dropdown - Matching Destination Dropdown Style */
    .auth-links .dropdown {
        position: relative;
    }
    .auth-links .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid #fff;
    }
    .auth-links .user-avatar-initial {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #18a9a1;
        color: #fff;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        border: 2px solid #fff;
    }


    /* Avatar */
.user-avatar,
.user-avatar-initial {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    object-fit: cover;
    background: linear-gradient(135deg, #0d6efd, #6610f2);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 18px;
}

/* Dropdown toggle */
.user-toggle::after {
    display: none;
}

/* Dropdown menu */
.user-menu {
    border-radius: 12px;
    padding: 0;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    min-width: 230px;
}

  /* User info */
  .user-info {
      padding: 16px;
      background: #f8f9fa;
      border-bottom: 1px solid #eee;
  }

  .user-avatar-lg {
      width: 55px;
      height: 55px;
      border-radius: 50%;
      background: linear-gradient(135deg, #0d6efd, #6610f2);
      color: #fff;
      font-size: 22px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: auto;
  }

  /* Dropdown items */
  .user-menu .dropdown-item {
      padding: 10px 18px;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 10px;
  }

  .user-menu .dropdown-item:hover {
      background: #f1f3f5;
  }

  .user-menu .dropdown-item i {
      width: 18px;
  }

  /* Sticky Header Enhancements */
  .header_menu {
      transition: all 0.3s ease-in-out;
      width: 100%;
      z-index: 999;
  }
  
  .navbar-sticky-in {
      position: fixed !important;
      top: 0 !important;
      left: 0 !important;
      width: 100% !important;
      background: #fff !important;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
      padding-top: 5px !important;
      padding-bottom: 5px !important;
      z-index: 1000 !important;
      animation: fadeInDown 0.4s ease-out;
  }

  .navbar-sticky-in .navbar-brand img {
      height: 40px !important; /* Shrink logo */
      transition: all 0.3s ease-in-out;
  }

  @keyframes fadeInDown {
      from {
          opacity: 0;
          transform: translateY(-20px);
      }
      to {
          opacity: 1;
          transform: translateY(0);
      }
  }

  /* Premium Mobile Menu (Slicknav) Overrides */
  .slicknav_menu {
      background: transparent !important;
      padding: 0 !important;
  }

  .slicknav_nav {
      background: #ffffff !important; /* Premium white background */
      border-radius: 15px !important;
      padding: 10px 0 !important;
      margin: 15px 15px 15px 15px !important; /* Proper margin on all sides */
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      border: 1px solid #eee;
      max-height: none !important; /* Force no max-height */
      height: auto !important; /* Ensure background follows content */
      overflow: visible !important; /* Ensure no scrollbars */
  }

  .slicknav_nav a {
      color: #17233e !important; /* Dark text for white background */
      font-weight: 600 !important;
      padding: 12px 25px !important;
      text-transform: uppercase;
      font-size: 14px;
      border-bottom: 1px solid #f1f1f1;
  }

  .slicknav_nav a:hover {
      background: #029e9d !important;
      color: #fff !important;
  }

  .slicknav_btn {
      background-color: transparent !important;
      margin-top: 5px !important;
  }

  .slicknav_icon-bar {
      background-color: #17233e !important; /* Hamburger color */
      width: 25px !important;
      height: 3px !important;
      margin-bottom: 4px !important;
  }

  /* Mobile Login Button Visibility Fix */
  .header-mobile-nav .btn-primary {
      color: #fff !important;
      background-color: #029e9d !important;
      border: none !important;
      font-weight: 600;
      padding: 8px 20px !important;
      border-radius: 25px !important;
      box-shadow: 0 4px 10px rgba(2, 158, 157, 0.2);
  }

  .header-mobile-nav .btn-primary i {
      color: #fff !important;
  }

  .navbar-sticky-in .header-mobile-nav .btn-outline-light {
      color: #17233e !important;
      border-color: #17233e !important;
  }

  .navbar-sticky-in .slicknav_icon-bar {
      background-color: #17233e !important;
  }

  @media (max-width: 991px) {
      .navbar-flex {
          padding-left: 15px !important;
          padding-right: 15px !important;
          padding-top: 12px !important;
          padding-bottom: 12px !important;
      }
      
      .navbar-brand img {
          max-height: 45px; /* Ensure logo doesn't dominate on mobile */
      }
  }

    </style>
  </head>
  <body>
    <!-- Preloader -->
    <div id="preloader" style="display: none !important;">
      <div id="status" style="display: none !important;"></div>
    </div>
    <!-- Preloader Ends -->

    <!-- header starts -->
    <header class="main_header_area">
      <div class="header-content py-1 bg-theme">
        <div class="container d-flex align-items-center justify-content-between">
          <div class="links">
            <ul>
              
              <li>
                <a href="#" class="white"><i class="icon-location-pin white"></i> Pune, Maharashtra</a>
              </li>
              <li>
                <a href="#" class="white"><i class="icon-clock white"></i> Mon-Sat: 10:00 AM – 7:00 PM</a>
              </li>
            </ul>
          </div>
          <div class="links float-right">
                   <ul>
              <li>
                <a href="https://www.facebook.com/people/Tripigo-Tales/61586111814953/" class="white"><i class="fab fa-facebook" aria-hidden="true"></i></a>
              </li>
             
              <li>
                <a href="https://www.instagram.com/tripigotales" class="white"><i class="fab fa-instagram" aria-hidden="true"></i></a>
              </li>
        
            </ul>
          </div>
        </div>
      </div>
      <!-- Navigation Bar -->
      <div class="header_menu" id="header_menu">
        <nav class="navbar navbar-default">
          <div class="container">
            <div class="navbar-flex d-flex align-items-center justify-content-between w-100 pb-3 pt-3">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('home') }}">
                  <img src="{{ asset('images/logo.png') }}" alt="image" />
                </a>
              </div>
              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="navbar-collapse1 d-flex align-items-center" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav" id="responsive-menu">
                  <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    <a href="{{ url('/') }}">Home</a>
                  </li>

                  <li class="{{ request()->routeIs('frontend.aboutus') ? 'active' : '' }}">
                    <a href="{{ route('frontend.aboutus') }}">About Us</a>
                  </li>
                 
                  
                  {{-- <li class="{{ request()->routeIs('frontend.faq') ? 'active' : '' }}">
                    <a href="{{ route('frontend.faq') }}">FAQ</a>
                  </li> --}}

                  <li class="{{ request()->routeIs('frontend.tour') ? 'active' : '' }}">
                    <a href="{{ route('frontend.tour') }}">Tours</a>
                  </li>

                  <li class="{{ request()->routeIs('frontend.gallery') ? 'active' : '' }}">
                    <a href="{{ route('frontend.gallery') }}">Gallery</a>
                  </li>
                  <li class="{{ request()->routeIs('frontend.contactus') ? 'active' : '' }}">
                    <a href="{{ route('frontend.contactus') }}">Contact Us</a>
                  </li>
                
                </ul>
              </div>
              <!-- /.navbar-collapse -->
              <div class="register-login d-flex align-items-center">
                 <div class="auth-links d-none d-lg-block">
                    @auth('user')
                        @php
                            $user = auth('user')->user();
                        @endphp
                        <div class="dropdown user-dropdown">
                          <a href="#" class="d-flex align-items-center dropdown-toggle user-toggle"
                            id="userDropdown"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                              @if($user->avatar)
                                  <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                                      class="user-avatar"
                                      onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                  <div class="user-avatar-initial" style="display:none;">
                                      {{ strtoupper(substr($user->name, 0, 1)) }}
                                  </div>
                              @else
                                  <div class="user-avatar-initial">
                                      {{ strtoupper(substr($user->name, 0, 1)) }}
                                  </div>
                              @endif
                          </a>
                          <div class="dropdown-menu dropdown-menu-end user-menu">
                              <div class="user-info text-center">
                                  <div class="user-avatar-lg">
                                      {{ strtoupper(substr($user->name, 0, 1)) }}
                                  </div>
                                  <h6 class="mb-0 mt-2">{{ $user->name }}</h6>
                              </div>
                              <a class="dropdown-item" href="{{ route('frontend.profile.edit') }}">
                                  <i class="fa fa-user"></i> Profile Edit Details
                              </a>
                              <a class="dropdown-item" href="{{ route('frontend.my.bookings') }}">
                                  <i class="fa fa-suitcase"></i> My Bookings
                              </a>
                              @if(is_null($user->google_id))
                                  <a class="dropdown-item" href="{{ route('frontend.password.change') }}">
                                      <i class="fa fa-key"></i> Change Password
                                  </a>
                              @endif
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item text-danger" href="{{ route('frontend.logout') }}">
                                  <i class="fa fa-sign-out-alt"></i> Logout
                              </a>
                          </div>
                      </div>
                    @else
                        <a href="{{ route('frontend.login') }}" class="nir-btn white">Login</a>
                    @endauth
                </div>
              </div>

              <div class="header-mobile-nav d-flex align-items-center d-lg-none">
                <div class="auth-links-mobile me-2">
                    @auth('user')
                        @php
                            $user = auth('user')->user();
                        @endphp
                        <div class="dropdown user-dropdown">
                          <a href="#" class="d-flex align-items-center dropdown-toggle user-toggle"
                            id="userDropdownMobile"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                              @if($user->avatar)
                                  <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                                      class="user-avatar" style="width: 35px; height: 35px;"
                                      onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                  <div class="user-avatar-initial" style="display:none; width: 35px; height: 35px; font-size: 14px;">
                                      {{ strtoupper(substr($user->name, 0, 1)) }}
                                  </div>
                              @else
                                  <div class="user-avatar-initial" style="width: 35px; height: 35px; font-size: 14px;">
                                      {{ strtoupper(substr($user->name, 0, 1)) }}
                                  </div>
                              @endif
                          </a>
                          <div class="dropdown-menu dropdown-menu-end user-menu">
                              <div class="user-info text-center p-2">
                                  <h6 class="mb-0" style="font-size: 0.9rem;">{{ $user->name }}</h6>
                              </div>
                              <a class="dropdown-item py-2" href="{{ route('frontend.profile.edit') }}" style="font-size: 0.8rem;">
                                  <i class="fa fa-user"></i> Profile
                              </a>
                              <a class="dropdown-item py-2" href="{{ route('frontend.my.bookings') }}" style="font-size: 0.8rem;">
                                  <i class="fa fa-suitcase"></i> My Bookings
                              </a>
                              <div class="dropdown-divider my-1"></div>
                              <a class="dropdown-item text-danger py-2" href="{{ route('frontend.logout') }}" style="font-size: 0.8rem;">
                                  <i class="fa fa-sign-out-alt"></i> Logout
                              </a>
                          </div>
                        </div>
                    @else
                        <a href="{{ route('frontend.login') }}" class="btn btn-sm btn-primary border-0 px-3 py-2 rounded-pill shadow-sm text-white"><i class="fa fa-user me-1 text-white"></i> Login</a>
                    @endauth
                </div>
                <div id="slicknav-mobile"></div>
              </div>
            </div>
          </div>
          <!-- /.container-fluid -->
        </nav>
      </div>
      <!-- Navigation Bar Ends -->
    </header>
    <!-- header ends -->
