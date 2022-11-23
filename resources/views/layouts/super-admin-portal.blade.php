<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>
        {{config('app.name')}}
    </title>

    <link id="pagestyle" href="../css/app.css" rel="stylesheet"/>

    @yield('head')

</head>

<body class="g-sidenav-show   bg-gray-100" id="clx_body">

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0  fixed-left" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute right-0 top-0 d-none d-xl-none"
           aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{config('app.url')}}/super-admin/dashboard">
            @if(!empty($settings['logo']))
                <img src="{{PUBLIC_DIR}}/uploads/{{$settings['logo']}}" class="navbar-brand-img h-100" alt="...">
            @else
                <span class="ms-1 font-weight-bold"> {{config('app.name')}}</span>
            @endif
        </a>
    </div>
    <hr class="horizontal dark mt-0">

    <div class="collapse navbar-collapse  w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link @if(($selected_navigation ?? '') === 'sdashboard') active @endif"
                   href="./dashboard">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-home">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span class="nav-link-text ms-3">{{ __('Dashboard') }}</span>
                </a>
            </li>
            

           
            <li class="nav-item mt-4 mb-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs  text-muted font-weight-bolder opacity-6">{{__('Users')}}  </h6>
            </li>
            
            <li class="nav-item">
                <a class="nav-link @if(($selected_navigation ?? '') === 'users') active @endif " href="./users">

                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-users">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <span class="nav-link-text ms-3">{{__('Users')}}</span>
                </a>
            </li>

            <!--<li class="nav-item mt-4 mb-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-muted font-weight-bolder opacity-6">{{__('Payment Gateways')}} </h6>
            </li> 

            <li class="nav-item">
                <a class="nav-link @if(($selected_navigation ?? '') === 'payment-gateways') active @endif "
                   href="./payment-gateways">

                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-credit-card">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                        <line x1="1" y1="10" x2="23" y2="10"></line>
                    </svg>
                    <span class="nav-link-text ms-3">{{__('Payment Gateways')}}</span>
                </a>
            </li> -->

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-muted font-weight-bolder opacity-6">{{__('My Account')}} </h6>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(($selected_navigation ?? '') === 'profile') active @endif "
                   href="./super-admin-profile">

                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-user">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span class="nav-link-text ms-3">{{__('My Profile')}}</span>
                </a>
            </li>
            <li class="nav-item mt-4 mb-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-muted font-weight-bolder opacity-6">{{__('Settings')}}  </h6>
            </li>
            <li class="nav-item mb-4">
                <a class="nav-link @if(($selected_navigation ?? '') === 'settings') active @endif  "
                   href="./super-admin-setting">

                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-settings">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path
                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                    </svg>
                    <span class="nav-link-text ms-3">{{__('Settings')}}</span>
                </a>
            </li>
            <li class="mb-4 ms-5">
                <a class="btn btn-warning " type="button" href="./logout">


                    <span class="">{{__('Logout')}}</span>
                </a>
            </li>

        </ul>
    </div>

</aside>
<main class="main-content mt-1 border-radius-lg">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <h6 class="font-weight-bolder mb-0"></h6>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    <div class="input-group">
                    </div>
                </div>
                <ul class=" justify-content-end">
                    <li class="nav-item px-3 d-flex align-items-center">
                    </li>
                    <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                        <a href="javascript:" class="nav-link text-body p-0" id="iconNavbarSidenav">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid ">
        @yield('content')
    </div>
</main>

<!--   Core JS Files   -->
<script src="public/js/app.js?v=53"></script>
<script src="public/lib/tinymce/tinymce.min.js?v=50"></script>

<script>
    "use strict"
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
@yield('script')
</body>
</html>

