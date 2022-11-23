<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js']) 

        <!-- Styles -->
        @livewireStyles

        <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>
        {{config('app.name')}}
    </title>

    <link id="pagestyle" href="css/app.css?v=1010" rel="stylesheet"/>

    @yield('head')

    </head>

<body class="g-sidenav-show  bg-gray-100" id="clx_body">

    <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0  fixed-left " id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute right-0 top-0 d-none d-xl-none"
           aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{config('app.url')}}/dashboard">
            @if(!empty($super_settings['logo']))
                <img src="public/uploads/{{$super_settings['logo']}}" class="navbar-brand-img h-100" alt="...">
            @else
                <span class="ms-1 font-weight-bold"> {{config('app.name')}}</span>
            @endif
        </a>
    </div>
    <div class=" text-center">
        @if(!empty($user->photo))
            <a href="javascript:" class="avatar avatar-md rounded-circle border border-secondary">
                <img alt="" class="p-1" src="public/uploads/{{$user->photo}}">
            </a>
        @else
            <div class="avatar avatar-md  rounded-circle bg-purple-light  border-radius-md p-2">
                <h6 class="text-purple mt-1">{{$user->first_name[0]}}{{$user->last_name[0]}}</h6>
            </div>


        @endif
        <a href="./profile" class=" nav-link text-body font-weight-bold px-0">
            <span
                class="d-sm-inline d-none ">@if (!empty($user)) {{$user->first_name}} {{$user->last_name}}@endif</span>
        </a>

    </div>
    <hr class="horizontal dark mt-0">

    <div class="collapse navbar-collapse  w-auto" id="sidenav-collapse-main">


        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link @if(($selected_navigation ?? '') === 'dashboard') active @endif" href="./dashboard">

                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-home">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span class="nav-link-text ms-3">{{ __('Dashboard') }}</span>
                </a>


            </li>
            <li class="nav-item mt-3 mb-2">
                <h6 class="ps-4 ms-2 text-uppercase text-muted text-xs opacity-6">{{__('Product Planning')}} </h6>
            </li>

            @if(empty($modules) || in_array('projects',$modules))
                <li class="nav-item ">
                    <a class="nav-link @if(($selected_navigation ?? '') === 'projects') active @endif "
                       href="./projects">

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-grid">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                        <span class="nav-link-text ms-3">{{__('Product Planning')}}</span>
                    </a>
                </li>

            @endif
           
          
           
            <li class="nav-item mt-3 mb-2">
                <h6 class="ps-4 ms-2 text-uppercase text-muted text-xs opacity-6">{{__('Account pages')}} </h6>
            </li>

            <li class="nav-item">
                <a class="nav-link @if(($selected_navigation ?? '') === 'profile') active @endif " href="./profile">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-user">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span class="nav-link-text ms-3">{{__('Profile')}}</span>
                </a>
            </li>
           

           
            <li class="nav-item">
                <a class="nav-link @if(($selected_navigation ?? '') === 'billing') active @endif  " href="./billing">

                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-shopping-cart">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <span class="nav-link-text ms-3">{{__('My Plan')}}</span>
                </a>
            </li>



            <li class="nav-item">
                <a class="nav-link @if(($selected_navigation ?? '') === 'builder_test') active @endif  " href="./builder_test">

                   
                    <span class="nav-link-text ms-3">{{__('Cleaner Tool')}}</span>
                </a>
            </li>

            
            <li class="mb-4 mt-4 ms-5">
                <a class="btn btn-dark " type="button" href="./logout">
                    <span class="">{{__('Logout')}}</span>
                </a>
            </li>
        </ul>
    </div>

</aside>


<main class="main-content mt-1 border-radius-lg">
    <!-- Navbar -->

    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">

            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                </div>
                <ul class=" justify-content-end">
                    <li class="nav-item d-xl-none pe-2 ps-3 d-flex align-items-center">
                        <a href="javascript:" class="nav-link text-body p-0" id="iconNavbarSidenav">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item dropdown pe-2 d-flex align-items-center">
                        <a href="" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown"
                           aria-expanded="false">
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                            aria-labelledby="dropdownMenuButton">
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="./profile">
                                    <div class="d-flex py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1">
                                                <span class="font-weight-bold">{{__('My Profile')}}</span>
                                            </h6>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item border-radius-md" href="./logout">
                                    <div class="d-flex py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-bolder mb-1">
                                                {{__('Logout')}}
                                            </h6>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- End Navbar -->
    <div class="container-fluid">
        @yield('content')
    </div>
</main>
<!--   Core JS Files   -->
<script src="public/js/app.js?v=90"></script>
<script src="public/lib/tinymce/tinymce.min.js?v=57"></script>
<script>
    (function(){
        "use strict";

        var win = navigator.platform.indexOf('Win') > -1;

        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    })();
</script>

@yield('script')

</body>

</html>

