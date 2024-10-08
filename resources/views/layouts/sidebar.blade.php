<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Logo icon -->
    <link rel="icon" href="{{ asset('images/icon.png') }}" type="image/png" />

    <!-- Styles -->
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap"
        rel="stylesheet">

    <style>
        .roboto-thin {
            font-family: "Roboto", sans-serif;
            font-weight: 100;
            font-style: normal;
        }

        .roboto-light {
            font-family: "Roboto", sans-serif;
            font-weight: 300;
            font-style: normal;
        }

        .roboto-regular {
            font-family: "Roboto", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .roboto-medium {
            font-family: "Roboto", sans-serif;
            font-weight: 500;
            font-style: normal;
        }

        .roboto-bold {
            font-family: "Roboto", sans-serif;
            font-weight: 700;
            font-style: normal;
        }

        .roboto-black {
            font-family: "Roboto", sans-serif;
            font-weight: 900;
            font-style: normal;
        }

        .roboto-thin-italic {
            font-family: "Roboto", sans-serif;
            font-weight: 100;
            font-style: italic;
        }

        .roboto-light-italic {
            font-family: "Roboto", sans-serif;
            font-weight: 300;
            font-style: italic;
        }

        .roboto-regular-italic {
            font-family: "Roboto", sans-serif;
            font-weight: 400;
            font-style: italic;
        }

        .roboto-medium-italic {
            font-family: "Roboto", sans-serif;
            font-weight: 500;
            font-style: italic;
        }

        .roboto-bold-italic {
            font-family: "Roboto", sans-serif;
            font-weight: 700;
            font-style: italic;
        }

        .roboto-black-italic {
            font-family: "Roboto", sans-serif;
            font-weight: 900;
            font-style: italic;
        }

        /* Bottom navigation bar styles */
        .bottom-nav {
            display: none;
            flex-direction: row;
            align-items: center;
            justify-content: space-around;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 60px;
            background: #0a0a0a;
            border-top: 1px solid #333;
            border-top-right-radius: 20px;
            border-top-left-radius: 20px;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.5);
            color: #fff;
            padding: 0 10px;
        }

        .bottom-nav .logo_content {
            display: none;
        }

        .bottom-nav ul {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            width: 100%;
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .bottom-nav ul .content {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            list-style: none;
            border-radius: 12px;
        }

        .bottom-nav ul .content a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            text-decoration: none;
            color: #fff;
            border-radius: 12px;
            transition: background 0.3s ease;
            position: relative;
        }

        .bottom-nav ul .content a:hover,
        .bottom-nav ul .content a:focus {
            background: #292929;
        }

        .bottom-nav ul .content a::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 20%;
            left: 170%;
            transform: translateX(-50%);
            background-color: #141414;
            color: #fff;
            padding: 5px 10px;
            border-radius: 8px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.5s ease, visibility 0.5s ease;
            font-size: 12px;
        }

        .bottom-nav ul .content a:hover::after,
        .bottom-nav ul .content a:focus::after {
            opacity: 1;
            visibility: visible;
        }

        .bottom-nav ul .content a svg {
            width: 24px;
            height: 24px;
        }

        .bottom-nav ul .content a:hover svg path,
        .bottom-nav ul .content a:focus svg path {
            fill: #fff;
        }

        .bottom-nav ul .content a.active {
            background: #141414;
        }

        .bottom-nav .logout {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Show bottom-nav on larger screens */
        @media (min-width: 768px) {
            .bottom-nav {
                display: flex;
            }
        }

        /* Responsive adjustments for row direction */
        @media (max-width: 768px) {
            .bottom-nav {
                height: auto;
                padding: 0 5px;
                flex-direction: row;
                /* Ensure row direction on smaller screens */
            }

            .bottom-nav ul {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                width: 100%;
                padding: 0;
                margin: 0;
            }

            .bottom-nav ul .content {
                width: 50px;
                /* Adjust width for smaller screens */
                height: 50px;
                /* Adjust height for smaller screens */
                margin: 0 5px;
            }

            .bottom-nav ul .content a {
                width: 100%;
                height: 100%;
                padding: 5px;
            }

            .bottom-nav ul .content a::after {
                bottom: 100%;
                left: 50%;
                transform: translateX(-50%) translateY(-10px);
                white-space: normal;
            }
        }

        /* Further customization for very small screens (if needed) */
        @media (max-width: 480px) {
            .bottom-nav ul .content {
                width: 40px;
                height: 40px;
                margin: 0 3px;
            }

            .bottom-nav ul .content a {
                width: 100%;
                height: 100%;
                padding: 3px;
            }

            .bottom-nav ul .content a svg {
                width: 20px;
                height: 20px;
            }
        }
    </style>
    @yield('style')
</head>

<body>

    <!-- Navbar Section Start -->
    <div class="container-fluid">
        <div class="row">
            <nav class="sidebar col-lg-3 col-md-4 d-none d-md-block sidebar-sticky">
                <div class="logo_content">
                    <a href="{{ route('posts.index') }}" class="logo">
                        <img class="icon" src="{{ asset('images/icon.png') }}" alt="Logo">
                    </a>
                </div>
                <ul class="nav_list list-unstyled">
                    <!-- Home Page Start -->
                    <li class="content">
                        <a href="{{ route('posts.index') }}" data-tooltip="Home"
                            class="d-flex align-items-center nav-link{{ Request::routeIs('posts.index') ? ' active' : '' }}">
                            @if (Request::routeIs('posts.index'))
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff"
                                    class="bi bi-house-door-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff"
                                    class="bi bi-house-door" viewBox="0 0 16 16">
                                    <path
                                        d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4z" />
                                </svg>
                            @endif
                        </a>
                    </li>
                    <!-- Home Page End -->

                    <!-- Friends Page Start -->
                    <li class="content">
                        <a href="{{ route('friendRequests.index') }}" data-tooltip="Friends"
                            class=" friends d-flex align-items-center nav-link{{ Request::routeIs('friendRequests.index') ? ' active' : '' }}">

                            @if ($friendRequestCount > 0)
                                <span class="badge" id="friend-request-count">
                                    @if ($friendRequestCount > 9)
                                        9+
                                    @else
                                        {{ $friendRequestCount }}
                                    @endif
                                </span>
                            @endif
                            @if (Request::routeIs('friendRequests.index'))
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                                    <path
                                        d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
                                </svg>
                            @endif
                        </a>
                    </li>
                    <!-- Friends Page End -->

                    <!-- Post Create Page Start -->
                    <li class="content">
                        <a href="{{ route('posts.create') }}" data-tooltip="Create Post"
                            class="d-flex align-items-center nav-link{{ Request::routeIs('posts.create') ? ' active' : '' }}">
                            @if (Request::routeIs('posts.create'))
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff"
                                    class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff"
                                    class="bi bi-plus-square" viewBox="0 0 16 16">
                                    <path
                                        d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                    <path
                                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                </svg>
                            @endif
                        </a>
                    </li>
                    <!-- Post Create Page End -->

                    <!-- Profile Page Start -->
                    <li class="content">
                        <a href="{{ route('profile.index') }}" data-tooltip="Profile"
                            class="d-flex align-items-center nav-link{{ Request::routeIs('profile.index') ? ' active' : '' }}">
                            @if (Request::routeIs('profile.index'))
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff"
                                    class="bi bi-person-fill" viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff"
                                    class="bi bi-person" viewBox="0 0 16 16">
                                    <path
                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                                </svg>
                            @endif
                        </a>
                    </li>
                    <!-- Profile Page End -->

                    <!-- Logout Section Start -->
                    <li class="logout">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                        <button class="Btn d-flex align-items-center"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <div class="sign">
                                <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960"
                                    width="30px" fill="#fff">
                                    <path
                                        d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z" />
                                </svg>
                            </div>

                            <div class="text">{{ __('Logout') }}</div>
                        </button>
                    </li>
                    <!-- Logout Section End -->
                </ul>
            </nav>
            <main class="col-lg-9 col-md-8 col-sm-12 p-4 flex-grow-1 main-content">
                @yield('content')
            </main>
        </div>
    </div>
    <!-- Navbar Section End -->

    <!-- Bottom navigation bar for mobile devices -->
    <nav class="bottom-nav d-md-none d-block">
        <ul class="nav_list list-unstyled">
            <!-- Home Page Start -->
            <li class="content">
                <a href="{{ route('posts.index') }}" data-tooltip="Home"
                    class="d-flex align-items-center nav-link{{ Request::routeIs('posts.index') ? ' active' : '' }}">
                    @if (Request::routeIs('posts.index'))
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff"
                            class="bi bi-house-door-fill" viewBox="0 0 16 16">
                            <path
                                d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff"
                            class="bi bi-house-door" viewBox="0 0 16 16">
                            <path
                                d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4z" />
                        </svg>
                    @endif
                </a>
            </li>
            <!-- Home Page End -->

            <!-- Friends Page Start -->
            <li class="content">
                <a href="{{ route('friendRequests.index') }}" data-tooltip="Friends"
                    class="d-flex align-items-center nav-link{{ Request::routeIs('friendRequests.index') ? ' active' : '' }}">
                    @if (Request::routeIs('friendRequests.index'))
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-people-fill" viewBox="0 0 16 16">
                            <path
                                d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-people" viewBox="0 0 16 16">
                            <path
                                d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
                        </svg>
                    @endif
                </a>
            </li>
            <!-- Friends Page End -->

            <!-- Post Create Page Start -->
            <li class="content">
                <a href="{{ route('posts.create') }}" data-tooltip="Create Post"
                    class="d-flex align-items-center nav-link{{ Request::routeIs('posts.create') ? ' active' : '' }}">
                    @if (Request::routeIs('posts.create'))
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff"
                            class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                            <path
                                d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff"
                            class="bi bi-plus-square" viewBox="0 0 16 16">
                            <path
                                d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                        </svg>
                    @endif
                </a>
            </li>
            <!-- Post Create Page End -->

            <!-- Profile Page Start -->
            <li class="content">
                <a href="{{ route('profile.index') }}" data-tooltip="Profile"
                    class="d-flex align-items-center nav-link{{ Request::routeIs('profile.index') ? ' active' : '' }}">
                    @if (Request::routeIs('profile.index'))
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff"
                            class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff"
                            class="bi bi-person" viewBox="0 0 16 16">
                            <path
                                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                        </svg>
                    @endif
                </a>
            </li>
            <!-- Profile Page End -->

            <!-- Logout Section Start -->
            <li class="logout">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button class="Btn d-flex align-items-center"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <div class="sign">
                        <!-- SVG for Logout Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960"
                            width="30px" fill="#fff">
                            <path
                                d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z" />
                        </svg>
                    </div>
                    <div class="text">{{ __('Logout') }}</div>
                </button>
            </li>
            <!-- Logout Section End -->
        </ul>
    </nav>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @yield('script')
    {{-- logout button confirmation --}}
    {{-- <script>
        if (confirm('Are you sure you want to logout?')) {
            document.getElementById('logout-form').submit();
        }
    </script> --}}
    <script>
        function fetchFriendRequestCount() {
            $.ajax({
                url: "{{ route('friendRequests.count') }}",
                method: "GET",
                success: function(response) {
                    const count = response.count;

                    let displayCount = count > 9 ? '9+' : count;
                    $('#friend-request-count').text(displayCount);

                    if (count > 0) {
                        $('#friend-request-count').show();
                    } else {
                        $('#friend-request-count').hide();
                    }
                }
            });
        }

        setInterval(fetchFriendRequestCount, 2000);

        $(document).ready(function() {
            fetchFriendRequestCount();
        });
    </script>
</body>

</html>
