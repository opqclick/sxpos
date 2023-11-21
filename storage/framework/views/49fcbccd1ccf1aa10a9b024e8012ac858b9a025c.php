 <?php
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
 ?>


 <!DOCTYPE html>
 <html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="<?php echo e($SITE_RTL == 'on' ? 'rtl' : ''); ?>">

 <head>
     <title>
        <?php echo e(\App\Models\Utility::settings()['company_name'] != '' ? \App\Models\Utility::settings()['company_name'] : config('app.name', 'POSGo Saas')); ?>

         <?php if(trim($__env->yieldContent('page-title'))): ?>
             - <?php echo $__env->yieldContent('page-title'); ?>
         <?php endif; ?>

     </title>

    

    <!-- Primary Meta Tags -->

        <meta name="title" content="<?php echo e($seo_settings['meta_keywords']); ?>">
        <meta name="description" content="<?php echo e($seo_settings['meta_description']); ?>">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="<?php echo e(env('APP_URL')); ?>">
        <meta property="og:title" content="<?php echo e($seo_settings['meta_keywords']); ?>">
        <meta property="og:description" content="<?php echo e($seo_settings['meta_description']); ?>">
        <meta property="og:image" content="<?php echo e($logo.$seo_settings['meta_image']); ?>">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="<?php echo e(env('APP_URL')); ?>">
        <meta property="twitter:title" content="<?php echo e($seo_settings['meta_keywords']); ?>">
        <meta property="twitter:description" content="<?php echo e($seo_settings['meta_description']); ?>">
        <meta property="twitter:image" content="<?php echo e($logo.$seo_settings['meta_image']); ?>">

    
     <meta charset="utf-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
     <meta http-equiv="X-UA-Compatible" content="IE=edge" />
     <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">


     <link rel="icon"
         href="<?php echo e($logo . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png').'?timestamp='.time()); ?>"
         type="image/png">

     <!-- Favicon icon -->

     <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/main.css')); ?>">

     <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/bootstrap-switch-button.min.css')); ?>">
     <link rel="stylesheet" href="<?php echo e(asset('custom/libs/animate.css/animate.min.css')); ?>">
     <!-- font css -->
     <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/tabler-icons.min.css')); ?>">
     <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/feather.css')); ?>">
     <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/fontawesome.css')); ?>">
     <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/material.css')); ?>">
     <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/datepicker-bs5.min.css')); ?>">

     <!-- vendor css -->
     <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/style.css')); ?>">
     <link rel="stylesheet" href="<?php echo e(asset('assets/css/customizer.css')); ?>">

     <link rel="stylesheet" href="<?php echo e(asset('custom/css/custom.css')); ?>">


     

     <?php if($SITE_RTL == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-rtl.css')); ?>">
    <?php endif; ?>
    <?php if(isset($cust_darklayout) && $cust_darklayout == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-dark.css')); ?>" id="main-style-link">
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>" id="main-style-link">
    <?php endif; ?>


     <?php echo $__env->yieldPushContent('old-datatable-css'); ?>
     <?php echo $__env->yieldPushContent('stylesheets'); ?>

 </head>

 <body class="<?php echo e($color); ?>">


     <?php echo $__env->make('sidenav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
     <?php echo $__env->make('header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
     <?php echo $__env->make('layouts.cookie_consent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

     <div class="dash-container">
        <div class="dash-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-6 mt-3">
                            <div class="page-header-title">
                                <h4 class="m-b-10"><?php echo $__env->yieldContent('title'); ?></h4>
                            </div>
                            <ul class="breadcrumb">
                                <?php echo $__env->yieldContent('breadcrumb'); ?>
                            </ul>
                        </div>

                        <div class="col-md-6">
                            <div class="col-12">
                                <?php echo $__env->yieldContent('filter'); ?>
                            </div>
                            <div class="col-12 text-end mt-3">
                                <?php echo $__env->yieldContent('action-btn'); ?>
                            </div>
                        </div>
                        <?php echo $__env->yieldContent('header-content'); ?>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <?php echo $__env->yieldContent('content'); ?>

        </div>
    </div>
     <?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



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


     <script src="<?php echo e(asset('custom/js/jquery.min.js')); ?>"></script>
     <script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>
     <script src="<?php echo e(asset('js/select2/dist/js/select2.min.js')); ?>"></script>
     <script src="<?php echo e(asset('assets/js/plugins/popper.min.js')); ?>"></script>
     <script src="<?php echo e(asset('assets/js/plugins/simplebar.min.js')); ?>"></script>
     <script src="<?php echo e(asset('assets/js/plugins/perfect-scrollbar.min.js')); ?>"></script>
     <script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>
     <script src="<?php echo e(asset('assets/js/plugins/feather.min.js')); ?>"></script>
     <script src="<?php echo e(asset('assets/js/dash.js')); ?>"></script>
     <script src="<?php echo e(asset('assets/js/plugins/main.min.js')); ?>"></script>
     <script src="<?php echo e(asset('assets/js/plugins/simple-datatables.js')); ?>"></script>

     <script src="<?php echo e(asset('assets/js/plugins/bootstrap-switch-button.min.js')); ?>"></script>
     <script src="<?php echo e(asset('custom/libs/bootstrap-notify/bootstrap-notify.min.js')); ?>"></script>
     <script src="<?php echo e(asset('assets/js/plugins/sweetalert2.all.min.js')); ?>"></script>
     <script src="<?php echo e(asset('assets/js/plugins/datepicker-full.min.js')); ?>"></script>
     <script src="<?php echo e(asset('assets/js/pages/ac-datepicker.js')); ?>"></script>
     <script src="<?php echo e(asset('custom/libs/moment/moment.js')); ?>"></script>

     <script src="<?php echo e(asset('js/custom.js')); ?>"></script>

     <script>
         if ($("#pc-dt-simple").length > 0) {
             const dataTable = new simpleDatatables.DataTable("#pc-dt-simple");
         }
     </script>

     <!-- Apex Chart -->
     <script src="<?php echo e(asset('assets/js/plugins/apexcharts.min.js')); ?>"></script>


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
                            .setAttribute("href", "<?php echo e(asset('assets/css/style-dark.css')); ?>");
                        document
                            .querySelector(".m-header > .b-brand > .logo-lg")
                            .setAttribute("src", "<?php echo e(asset('/storage/uploads/logo/logo-light.png')); ?>");
                    } else {

                        document
                            .querySelector("#main-style-link")
                            .setAttribute("href", "<?php echo e(asset('assets/css/style.css')); ?>");
                        document
                            .querySelector(".m-header > .b-brand > .logo-lg")
                            .setAttribute("src", "<?php echo e(asset('/storage/uploads/logo/logo-dark.png')); ?>");
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
         //     var toster_pos="<?php echo e(env('SITE_RTL') == 'on' ? 'left' : 'right'); ?>";
         //
     </script>

     <?php echo $__env->yieldPushContent('scripts'); ?>

     <?php echo $__env->yieldPushContent('old-datatable-js'); ?>

     <?php if(Session::has('success')): ?>
         <script>
             show_toastr("<?php echo e(__('Success')); ?>", "<?php echo session('success'); ?>", 'success');
         </script>
     <?php endif; ?>
     <?php if(Session::has('error')): ?>
         <script>
             show_toastr("<?php echo e(__('Error')); ?>", "<?php echo session('error'); ?>", 'error');
         </script>
     <?php endif; ?>
 <?php echo $__env->yieldContent('custom_scripts'); ?>
 </body>

 </html>
<?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/layouts/app.blade.php ENDPATH**/ ?>