 @php
    $logo=\App\Models\Utility::get_file('uploads/logo/');
    $company_favicon = App\Models\Utility::getValByName('company_favicon');
    $SITE_RTL = App\Models\Utility::getValByName('SITE_RTL');
    $cust_darklayout = App\Models\Utility::getValByName('cust_darklayout');
    $setting = App\Models\Utility::colorset();
    $seo_settings = \App\Models\Utility::getSeoSetting();
    $color = 'theme-3';
    if (!empty($setting['color'])) {
        $color = $setting['color'];
    }
 @endphp


 <!DOCTYPE html>
 <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $SITE_RTL == 'on' ? 'rtl' : '' }}">

 <head>
     <title>
        {{ \App\Models\Utility::settings()['company_name'] != '' ? \App\Models\Utility::settings()['company_name'] : config('app.name', 'POSGo Saas') }}
         @if (trim($__env->yieldContent('page-title')))
             - @yield('page-title')
         @endif
         
     </title>

    {{-- seo --}}

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
     <meta name="csrf-token" content="{{ csrf_token() }}">


     <link rel="icon"
         href="{{ $logo . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png').'?timestamp='.time() }}"
         type="image/png">

     <!-- Favicon icon -->

     <link rel="stylesheet" href="{{ asset('assets/css/plugins/main.css') }}">

     <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">
     <link rel="stylesheet" href="{{ asset('custom/libs/animate.css/animate.min.css') }}">
     <!-- font css -->
     <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/plugins/datepicker-bs5.min.css') }}">

     <!-- vendor css -->
     <link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">

     <link rel="stylesheet" href="{{ asset('custom/css/custom.css') }}">


     {{-- @if ($SITE_RTL == 'on')
         <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
     @else
         @if (isset($setting['cust_darklayout']) && $setting['cust_darklayout'] == 'on')
             <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
         @else
             <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
         @endif
     @endif --}}

     @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
    @endif
    @if (isset($cust_darklayout) && $cust_darklayout == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}" id="main-style-link">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    @endif


     @stack('old-datatable-css')
     @stack('stylesheets')

 </head>

 <body class="{{ $color }}">


     @include('sidenav')
     @include('header')
     @include('layouts.cookie_consent')

     <div class="dash-container">
        <div class="dash-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-6 mt-3">
                            <div class="page-header-title">
                                <h4 class="m-b-10">@yield('title')</h4>
                            </div>
                            <ul class="breadcrumb">
                                @yield('breadcrumb')
                            </ul>
                        </div>

                        <div class="col-md-6">
                            <div class="col-12">
                                @yield('filter')
                            </div>
                            <div class="col-12 text-end mt-3">
                                @yield('action-btn')
                            </div>
                        </div>
                        @yield('header-content')
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            @yield('content')

        </div>
    </div>
     @include('footer')



     <div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel"></h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="body">

                 </div>

             </div>
         </div>
     </div>


     <div class="modal fade" id="commonModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="body">

                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="commonModalOver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>

            </div>
        </div>
    </div>


     <script src="{{ asset('custom/js/jquery.min.js') }}"></script>
     <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
     <script src="{{ asset('js/select2/dist/js/select2.min.js')}}"></script>
     <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
     <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
     <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
     <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
     <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
     <script src="{{ asset('assets/js/dash.js') }}"></script>
     <script src="{{ asset('assets/js/plugins/main.min.js') }}"></script>
     <script src="{{ asset('assets/js/plugins/simple-datatables.js') }}"></script>

     <script src="{{ asset('assets/js/plugins/bootstrap-switch-button.min.js') }}"></script>
     <script src="{{ asset('custom/libs/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
     <script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
     <script src="{{ asset('assets/js/plugins/datepicker-full.min.js') }}"></script>
     <script src="{{ asset('assets/js/pages/ac-datepicker.js') }}"></script>
     <script src="{{ asset('custom/libs/moment/moment.js') }}"></script>

     <script src="{{ asset('js/custom.js') }}"></script>

     <script>
         if ($("#pc-dt-simple").length > 0) {
             const dataTable = new simpleDatatables.DataTable("#pc-dt-simple");
         }
     </script>

     <!-- Apex Chart -->
     <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>


     <script>
         $(document).ready(function() {
             //  cust_theme_bg();
             //  cust_darklayout();



         });


         feather.replace();
         var pctoggle = document.querySelector("#pct-toggler");
         if (pctoggle) {
             pctoggle.addEventListener("click", function() {
                 if (
                     !document.querySelector(".pct-customizer").classList.contains("active")
                 ) {
                     document.querySelector(".pct-customizer").classList.add("active");
                 } else {
                     document.querySelector(".pct-customizer").classList.remove("active");
                 }
             });
         }

         var themescolors = document.querySelectorAll(".themes-color > a");
         for (var h = 0; h < themescolors.length; h++) {
             var c = themescolors[h];

             c.addEventListener("click", function(event) {
                 var targetElement = event.target;
                 if (targetElement.tagName == "SPAN") {
                     targetElement = targetElement.parentNode;
                 }
                 var temp = targetElement.getAttribute("data-value");
                 removeClassByPrefix(document.querySelector("body"), "theme-");
                 document.querySelector("body").classList.add(temp);
             });
         }


        var custthemebg = document.querySelector("#cust-theme-bg");
        custthemebg.addEventListener("click", function() {
            if (custthemebg.checked) {
                document.querySelector(".dash-sidebar").classList.add("transprent-bg");
                document
                    .querySelector(".dash-header:not(.dash-mob-header)")
                    .classList.add("transprent-bg");
            } else {
                document.querySelector(".dash-sidebar").classList.remove("transprent-bg");
                document
                    .querySelector(".dash-header:not(.dash-mob-header)")
                    .classList.remove("transprent-bg");
            }
        });


        var custdarklayout = document.querySelector("#cust-darklayout");
                custdarklayout.addEventListener("click", function() {
                    if (custdarklayout.checked) {

                        document
                            .querySelector("#main-style-link")
                            .setAttribute("href", "{{ asset('assets/css/style-dark.css') }}");
                        document
                            .querySelector(".m-header > .b-brand > .logo-lg")
                            .setAttribute("src", "{{ asset('/storage/uploads/logo/logo-light.png') }}");
                    } else {

                        document
                            .querySelector("#main-style-link")
                            .setAttribute("href", "{{ asset('assets/css/style.css') }}");
                        document
                            .querySelector(".m-header > .b-brand > .logo-lg")
                            .setAttribute("src", "{{ asset('/storage/uploads/logo/logo-dark.png') }}");
                    }
                });


         function removeClassByPrefix(node, prefix) {
             for (let i = 0; i < node.classList.length; i++) {
                 let value = node.classList[i];
                 if (value.startsWith(prefix)) {
                     node.classList.remove(value);
                 }
             }
         }
     </script>


     <script>
         //     var toster_pos="{{ env('SITE_RTL') == 'on' ? 'left' : 'right' }}";
         //
     </script>

     @stack('scripts')

     @stack('old-datatable-js')

     @if (Session::has('success'))
         <script>
             show_toastr("{{ __('Success') }}", "{!! session('success') !!}", 'success');
         </script>
     @endif
     @if (Session::has('error'))
         <script>
             show_toastr("{{ __('Error') }}", "{!! session('error') !!}", 'error');
         </script>
     @endif
 </body>

 </html>
