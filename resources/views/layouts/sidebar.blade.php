<!doctype html>
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
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    @yield('style')
</head>

<body>
    @yield('content')
    <div class="d-flex">
        <div class="sidebar">
            <div class="logo_content">
                <div class="logo">
                    <img class="icon" src="images/icon.png" alt="">
                    <div class="logo_name">{{ __('Link Us') }}</div>
                </div>
            </div>
            <ul class="nav_list list-unstyled">
                <li class="content">
                    <a href="{{ route('home') }}" class="d-flex align-items-center">
                        <i class="fa-solid fa-house"></i>
                        <span class="nav-item ms-2">{{ __('Home') }}</span>
                    </a>
                    <span class="tooltip">{{ __('Home') }}</span>
                </li>
                <li class="content">
                    <a href="#" class="d-flex align-items-center">
                        <i class="fa-solid fa-user-group"></i>
                        <span class="nav-item ms-2">{{ __('Friends') }}</span>
                    </a>
                    <span class="tooltip">{{ __('Friends') }}</span>
                </li>
                <li class="content">
                    <a href="#" class="d-flex align-items-center">
                        <i class="fa-solid fa-square-plus"></i>
                        <span class="nav-item ms-2">{{ __('Create') }}</span>
                    </a>
                    <span class="tooltip">{{ __('Create') }}</span>
                </li>
                <li class="content">
                    <a href="#" class="d-flex align-items-center">
                        <i class="fa-solid fa-user"></i>
                        <span class="nav-item ms-2">{{ __('Profile') }}</span>
                    </a>
                    <span class="tooltip">{{ __('Profile') }}</span>
                </li>
                <li class="logout">
                    <a href="{{ route('logout') }}">
                        <button class="Btn d-flex align-items-center">
                            <div class="sign"><svg viewBox="0 0 512 512">
                                    <path
                                        d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z">
                                    </path>
                                </svg></div>
                            <div class="text ms-2">{{ __('Logout') }}</div>
                        </button>
                    </a>
                </li>
            </ul>
        </div>
        <div class="home-content p-4">
            <!-- Main content goes here -->
        </div>
    </div>
</body>

<script src="{{ asset('js/app.js') }}"></script>
@yield('script')

</html>
