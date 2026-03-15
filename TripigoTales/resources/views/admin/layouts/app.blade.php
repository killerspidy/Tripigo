<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">
    <title>@yield('title', 'Admin Dashboard') | Tripigo Tales</title>

    <!-- Custom CSS -->
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
    <!-- Icons -->
    <link href="{{ asset('dist/css/icons/font-awesome/css/fontawesome-all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/icons/themify-icons/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/icons/iconmind/iconmind.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/icons/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/icons/material-design-iconic-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet">

    <style>
        /* Premium Admin Dashboard design system */
        :root {
            --sidebar-bg: #2b333e;
            --sidebar-active: #18a9a1;
            --sidebar-text: #adb5bd;
            --body-bg: #f4f7fa;
            --card-shadow: 0 10px 30px rgba(0,0,0,0.04);
            --card-shadow-hover: 0 15px 45px rgba(0,0,0,0.08);
            --primary-gradient: linear-gradient(135deg, #18a9a1 0%, #128c85 100%);
            --sidebar-width: 240px;
            --topbar-height: 64px;
        }

        body {
            background-color: var(--body-bg) !important;
            font-family: 'Inter', 'Segoe UI', sans-serif !important;
        }

        /* ── Topbar & Header Layout Fix ── */
        .topbar {
            background: #ffffff !important;
            border-bottom: 1px solid #edf2f9 !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02) !important;
            position: fixed !important;
            top: 0;
            width: 100%;
            z-index: 1030;
        }

        .topbar .navbar-header {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            flex-wrap: nowrap !important;
            height: var(--topbar-height);
            padding: 0 15px;
            border-right: 1px solid #edf2f9;
            min-width: var(--sidebar-width);
        }

        .topbar .navbar-header .navbar-brand {
            display: flex !important;
            align-items: center !important;
            flex: 1;
            min-width: 0;
            text-decoration: none;
        }

        /* ── Sidebar Toggle Smooth Transition ── */
        #main-wrapper {
            transition: all 0.3s ease;
        }

        #main-wrapper.mini-sidebar .left-sidebar {
            width: 70px;
        }

        #main-wrapper.mini-sidebar .left-sidebar .hide-menu,
        #main-wrapper.mini-sidebar .left-sidebar .logo-text {
            display: none;
        }

        #main-wrapper.mini-sidebar .page-wrapper {
            margin-left: 70px;
        }

        .page-wrapper {
            background: var(--body-bg) !important;
            padding-top: 64px;
            transition: all 0.3s ease;
        }

        /* Sidebar Refinement */
        .left-sidebar {
            background: var(--sidebar-bg) !important;
            box-shadow: 10px 0 30px rgba(0,0,0,0.05) !important;
        }
        
        .sidebar-nav {
            padding: 15px 0 !important;
        }

        .sidebar-nav ul .sidebar-item .sidebar-link {
            padding: 10px 20px !important;
            border-radius: 10px !important;
            margin: 4px 15px !important;
            color: var(--sidebar-text) !important;
            opacity: 0.8;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: all 0.2s ease-in-out;
        }

        .sidebar-nav ul .sidebar-item .sidebar-link i {
            font-size: 1.1rem;
            margin-right: 12px;
            width: 25px;
            text-align: center;
        }

        .sidebar-nav ul .sidebar-item .sidebar-link:hover {
            color: #fff !important;
            opacity: 1;
            background: rgba(255,255,255,0.05) !important;
            transform: translateX(5px);
        }

        .sidebar-nav ul .sidebar-item.selected > .sidebar-link {
            background: var(--primary-gradient) !important;
            color: #fff !important;
            opacity: 1;
            box-shadow: 0 4px 15px rgba(24, 169, 161, 0.3) !important;
        }

        /* Topbar Refinement */
        .topbar {
            background: #ffffff !important;
            border-bottom: 1px solid #edf2f9 !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02) !important;
        }

        .topbar .top-navbar .navbar-header[data-logobg="skin1"] {
            background: #ffffff !important;
            border-right: 1px solid #edf2f9 !important;
        }

        /* Card Modernization */
        .card {
            border: none !important;
            border-radius: 16px !important;
            box-shadow: var(--card-shadow) !important;
            transition: all 0.3s cubic-bezier(.25,.8,.25,1) !important;
            overflow: hidden;
            background: #fff !important;
        }

        .card:hover {
            box-shadow: var(--card-shadow-hover) !important;
            transform: translateY(-5px);
        }

        /* Header Logo Spacing */
        .navbar-brand {
            padding-left: 20px !important;
        }

        /* Profile Section in Sidebar */
        .user-profile {
            padding: 20px 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            margin-bottom: 10px;
        }

        .user-profile .user-pic img {
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        /* Button Styles */
        .btn-rounded {
            border-radius: 30px !important;
            font-weight: 600;
            padding: 10px 25px;
            transition: 0.3s;
        }

        .btn-outline-danger:hover {
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }

        /* Active highlight for sidebar items */
        #sidebarnav li.sidebar-item.selected a i {
            color: #fff !important;
        }

        /* Dropdown refinement */
        .user-dd {
            padding: 0 !important;
            overflow: hidden;
        }

        /* Sidebar Scroll and Sticky Footer */
        .left-sidebar {
            display: flex;
            flex-direction: column;
            height: 100vh !important;
        }

        .scroll-sidebar {
            flex: 1;
            overflow-y: auto !important;
            padding-bottom: 70px !important; /* Space for fixed footer */
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            background: rgba(0,0,0,0.2);
            padding: 15px;
            border-top: 1px solid rgba(255,255,255,0.05);
            z-index: 100;
        }

        .sidebar-footer .sidebar-link {
            margin: 0 !important;
            padding: 10px 15px !important;
            justify-content: center;
        }

        /* Custom scrollbar for sidebar */
        .scroll-sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .scroll-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
        }

        /* Responsiveness & Better View Refinements */
        @media (max-width: 767px) {
            .topbar .top-navbar .navbar-header {
                width: 100% !important;
                display: flex !important;
                align-items: center;
                justify-content: space-between;
                padding: 0 15px;
            }
            .navbar-brand {
                padding-left: 0 !important;
                margin: 0 auto !important;
            }
            .page-wrapper {
                padding-top: 64px !important;
                margin-left: 0 !important;
            }
            .container-fluid {
                padding: 15px !important;
            }
            .card-body {
                padding: 20px !important;
            }
            .btn-rounded {
                padding: 8px 15px !important;
                font-size: 13px !important;
            }
            h2 {
                font-size: 1.5rem !important;
            }
            .m-r-25 {
                margin-right: 15px !important;
            }
            .user-avatar-mobile {
                width: 60px !important;
                height: 60px !important;
            }
        }

        @media (min-width: 768px) and (max-width: 1024px) {
            .col-lg-3 {
                flex: 0 0 50% !important;
                max-width: 50% !important;
            }
        }

        /* Smooth sidebar transition */
        .left-sidebar {
            transition: 0.3s ease-in-out;
        }

        /* Refined Card View */
        .card-hover:hover {
            transform: translateY(-8px) scale(1.01);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
        }

        .bg-gradient-primary { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important; }
        .bg-gradient-info { background: linear-gradient(135deg, #36b9cc 0%, #1a8a9a 100%) !important; }
        
        /* Better visual hierarchy for titles */
        .card-title {
            font-weight: 700 !important;
            color: #2c3e50;
            letter-spacing: -0.5px;
        }
    </style>
    @stack('styles')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin1" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        @include('admin.partials.header')
        
        @include('admin.partials.sidebar')

        <div class="page-wrapper">
            @yield('content')
            
            @include('admin.partials.footer')
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <!-- apps -->
    <script src="{{ asset('dist/js/app.min.js') }}"></script>
    <script>
        $(function() {
            "use strict";

            // Fallback for missing perfectScrollbar library to prevent JS errors
            if (typeof $.fn.perfectScrollbar === 'undefined') {
                $.fn.perfectScrollbar = function() {
                    return this;
                };
            }

            $("#main-wrapper").AdminSettings({
                Theme: false,
                Layout: 'vertical',
                LogoBg: 'skin5',
                NavbarBg: 'skin6',
                SidebarType: 'full',
                SidebarColor: 'skin5',
                SidebarPosition: true,
                HeaderPosition: true,
                BoxedLayout: false,
            });
            // Hide preloader
            $(".preloader").fadeOut();
        });
    </script>
    <script src="{{ asset('dist/js/app-style-switcher.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('dist/js/custom.min.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
