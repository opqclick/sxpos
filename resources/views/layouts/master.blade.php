<!DOCTYPE html>
@php
$SITE_RTL = App\Models\Utility::getValByName('SITE_RTL');
// $logo = asset(Storage::url('logo'));
$company_favicon = App\Models\Utility::getValByName('company_favicon');
$logo=\App\Models\Utility::get_file('uploads/logo/');
$company_logo = \App\Models\Utility::get_superadmin_logo();
$setting = App\Models\Utility::colorset();
$color = 'theme-3';
if (!empty($setting['color'])) {
    $color = $setting['color'];
}
// dd($setting);
$seo_settings = \App\Models\Utility::getSeoSetting();

if( app()->getLocale() == 'ar' || app()->getLocale() == 'he' ){
        $SITE_RTL = 'on';
    }

@endphp


<!DOCTYPE html>
<html lang="en"  dir="@if(app()->getLocale() == 'ar' || app()->getLocale() == 'he'){{$SITE_RTL == 'on' ? 'rtl' : ''}}@else{{ Utility::getValByName('SITE_RTL') == 'on' ? 'rtl' : '' }}@endif">

<head>

    <title>{{ env('APP_NAME') }} - @yield('page-title')</title>
        <!-- Primary Meta Tags -->

        <meta name="title" content="{{$seo_settings['meta_keywords']}}">
        <meta name="description" content="{{$seo_settings['meta_description']}}">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{env('APP_URL')}}">
        <meta property="og:title" content="{{$seo_settings['meta_keywords']}}">
        <meta property="og:description" content="{{$seo_settings['meta_description']}}">
        <meta property="og:image" content="{{$logo.$seo_settings['meta_image']}}">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{env('APP_URL')}}">
        <meta property="twitter:title" content="{{$seo_settings['meta_keywords']}}">
        <meta property="twitter:description" content="{{$seo_settings['meta_description']}}">
        <meta property="twitter:image" content="{{$logo.$seo_settings['meta_image']}}">

    {{--  --}}
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Dashboard Template Description" />
    <meta name="keywords" content="Dashboard Template" />
    <meta name="author" content="Rajodiya Infotech" />

    <!-- Favicon icon -->
    <link rel="icon"
    href="{{ $logo . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png').'?timestamp='.time() }}"
    type="image/png">

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/stylesheet.css') }}"> --}}
    <!-- vendor css -->

    {{-- @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
    @endif
    @if (isset($cust_darklayout) && $cust_darklayout == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @endif --}}


    @if (Utility::getValByName('SITE_RTL') == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
    @endif

    @if ( isset($SITE_RTL) && $SITE_RTL == 'on' )
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">

    @endif

    @if (Utility::getValByName('cust_darklayout') == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @endif

    @if(Utility::getValByName('cust_darklayout') == 'on')
        <style>
            .g-recaptcha {
                filter: invert(1) hue-rotate(180deg) !important;
            }
        </style>
    @endif


    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
    <link rel="stylesheet" href="{{ asset('custom/css/custom.css') }}">


    {{-- @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
    @else
        @if (isset($cust_darklayout) && $cust_darklayout == 'on')
            <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
        @else
            <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
        @endif
    @endif --}}

</head>

@stack('custom-scripts')


<body class="{{ $color }}">

    <input type="hidden" id="path_admin" value="{{url('/')}}">
    <div class="auth-wrapper auth-v3">
        <div class="bg-auth-side bg-primary"></div>
        <div class="auth-content">
            <nav class="navbar navbar-expand-md navbar-light default">
                <div class="container-fluid pe-2">
                    <a class="navbar-brand" href="#">
                        <img src="{{ $logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png').'?timestamp='.time() }}"
                        alt="{{ config('app.name', 'Posgo') }}" class="logo logo-lg">
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo01" style="flex-grow: 0;">
                        <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                            {{-- <li class="nav-item">
                                <a class="nav-link active" href="#">{{ __('Support') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">{{ __('Terms') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">{{ __('Privacy') }}</a>
                            </li> --}}
                            <li class="nav-item">
                                @include('landingpage::layouts.buttons')
                            </li>
                        </ul>

                        <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <select name="language" id="language" class="btn btn-primary ms-2 me-2 language_option_bg"
                                    onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                    @foreach (\App\Models\Utility::languages() as $code => $language)
                                        @if (Request::segment(1) == 'login')
                                            <option @if ($lang == $code) selected @endif
                                                value="{{ route('login', $code) }}">
                                                {{ ucFirst($language) }}
                                            </option>
                                        @elseif(Request::segment(1) == 'register')
                                            <option @if ($lang == $code) selected @endif
                                                value="{{ route('register', $code) }}">
                                                {{ ucFirst($language) }}
                                            </option>
                                        @elseif(Request::segment(1) == 'forgot-password')
                                            <option @if ($lang == $code) selected @endif
                                                value="{{ route('password.request', $code) }}">
                                                {{ ucFirst($language) }}
                                            </option>
                                        @elseif(Request::segment(1) == 'reset-password')
                                            <option @if ($lang == $code) selected @endif
                                                value="{{ route('login', $code) }}">
                                                {{ ucFirst($language) }}
                                            </option>

                                        @endif
                                    @endforeach
                                </select>
                            </li>
                        </ul>

                    </div>
                </div>
            </nav>
            <div class="card">
                <div class="row align-items-center">
                    @yield('content')
                    <div class="col-xl-6 img-card-side">
                        <div class="auth-img-content">
                            <img src="{{ asset('assets/images/auth/img-auth-3.svg') }}" alt=""
                                class="img-fluid">
                            <h3 class="text-white mb-4 mt-5">“Attention is the new currency”</h3>
                            <p class="text-white">The more effortless the writing looks, the more effort the writer
                                actually put into the process.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="auth-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6">
                            <!--   {{ \App\Models\Utility::getValByName('footer_text') ? \App\Models\Utility::getValByName('footer_text') : config('app.name', 'SxPos') }} -->
                            {{-- {{ __('Copyright') }} --}}
                            {{ \App\Models\Utility::getValByName('footer_text') ? \App\Models\Utility::getValByName('footer_text') : config('app.name', 'SxPos') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ auth-signup ] end -->
@include('layouts.cookie_consent')
    <!-- Required Js -->
    <script src="{{ asset('assets/js/vendor-all.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

    <input type="checkbox" class="d-none" id="cust-theme-bg"
        {{ Utility::getValByName('cust_theme_bg') == 'on' ? 'checked' : '' }} />
    <input type="checkbox" class="d-none" id="cust-darklayout"
        {{ Utility::getValByName('cust_darklayout') == 'on' ? 'checked' : '' }} />

    <script>
        feather.replace();
    </script>
    <div class="pct-customizer">
        <div class="pct-c-btn">
            <button class="btn btn-primary" id="pct-toggler">
                <i data-feather="settings"></i>
            </button>
        </div>
        <div class="pct-c-content">
            <div class="pct-header bg-primary">
                <h5 class="mb-0 text-white f-w-500">Theme Customizer</h5>
            </div>
            <div class="pct-body">
                <h6 class="mt-2">
                    <i data-feather="credit-card" class="me-2"></i>Primary color settings
                </h6>
                <hr class="my-2" />
                <div class="theme-color themes-color">
                    <a href="#!" class="" data-value="theme-1"></a>
                    <a href="#!" class="" data-value="theme-2"></a>
                    <a href="#!" class="" data-value="theme-3"></a>
                    <a href="#!" class="" data-value="theme-4"></a>
                </div>
                <h6 class="mt-4">
                    <i data-feather="layout" class="me-2"></i>Sidebar settings
                </h6>
                <hr class="my-2" />
                <div class="form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="cust-theme-bg" checked />
                    <label class="form-check-label f-w-600 pl-1" for="cust-theme-bg">Transparent layout</label>
                </div>
                <h6 class="mt-4">
                    <i data-feather="sun" class="me-2"></i>Layout settings
                </h6>
                <hr class="my-2" />
                <div class="form-check form-switch mt-2">
                    <input type="checkbox" class="form-check-input" id="cust-darklayout" />
                    <label class="form-check-label f-w-600 pl-1" for="cust-darklayout">Dark Layout</label>
                </div>
            </div>
        </div>
    </div>



    <script src="{{ asset('custom/js/jquery.min.js') }}"></script>

    <script src="{{ asset('js/custom.js') }}"></script>
    @stack('script')

    @stack('custom-scripts')


</body>

</html>
