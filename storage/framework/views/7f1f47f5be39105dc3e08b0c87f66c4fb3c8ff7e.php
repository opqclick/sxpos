
<!DOCTYPE html>
<?php
    $settings = Utility::settings();
    $seo_settings = \App\Models\Utility::getSeoSetting();
    $logo=\App\Models\Utility::get_file('uploads/logo/');
?>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="<?php echo e(Utility::getValByName('SITE_RTL') == 'on' ? 'rtl' : ''); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>
        <?php if(trim($__env->yieldContent('page-title'))): ?>
            <?php echo $__env->yieldContent('page-title'); ?> -
        <?php endif; ?>
        <?php echo e(\App\Models\Utility::settings()['company_name'] != '' ? \App\Models\Utility::settings()['company_name'] : config('app.name', 'POSGo Saas')); ?>

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
    
    <?php $logo = asset(Storage::url('logo')); ?>

    <link rel="icon" href="<?php echo e($logo.'/favicon.png'); ?>" type="image/png">

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

    <?php if(Utility::getValByName('SITE_RTL') == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-rtl.css')); ?>">
    <?php endif; ?>
    <?php if(Utility::getValByName('cust_darklayout') == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-dark.css')); ?>">
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <?php endif; ?>
    <?php echo $__env->yieldPushContent('stylesheets'); ?>

</head>

     <div class="m-6">
        <div class="container position-relative">
            <div class="download_btn">
                <a onclick="saveAsPDF2()" class="btn btn-sm btn-primary btn-icon-only  ml-2 shadow-sm">
                    <span class="btn-inner--icon"><i class="ti ti-download"></i></span>
                </a>
            </div>
            <div class="row invoice" id="printableArea2">
                <div class="col-12 card p-4">

                    <div class="invoice-details">
                        <h1 class="invoice-id h4 text-end"><?php echo e($details['invoice_id']); ?></h1>
                        <div class="date mb-3 text-end"><?php echo e(__('Date of Invoice')); ?>: <?php echo e($details['date']); ?></div>
                        <div class="date mb-3 float-right"><?php echo DNS2D::getBarcodeHTML(route('sale.link.copy',\Illuminate\Support\Facades\Crypt::encrypt($sell->id)),'QRCODE',2,2); ?></div>
                        <span class="clearfix" style="clear: both; display: block;"></span>
                    </div>
                    <div class="row">
                        <div class="col md-12">
                                <div class="col md-6">
                                        <div class="text-gray-light text-uppercase"><?php echo e(__('Invoice To:')); ?></div>
                                        <?php echo $details['customer']['details']; ?>


                                </div>
                                <div class="col md-6 text-end">
                                    <div class="text-gray-light text-uppercase"><?php echo e(__('Invoice From:')); ?></div>
                                    <?php echo $details['user']['details']; ?>

                                </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div class="invoice-table">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="text-left"><?php echo e(__('Items')); ?></th>
                                    <th><?php echo e(__('Quantity')); ?></th>
                                    <th class="text-right"><?php echo e(__('Price')); ?></th>
                                    <th class="text-right"><?php echo e(__('Tax')); ?></th>
                                    <th class="text-right"><?php echo e(__('Tax Amount')); ?></th>
                                    <th class="text-right"><?php echo e(__('Total')); ?></th>
                                </tr>
                                </thead>
                                <tbody>


                                <?php $__currentLoopData = $sales['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="cart-summary-table text-left">
                                            <?php echo e($value['name']); ?>

                                        </td>
                                        <td class="cart-summary-table">
                                            <?php echo e($value['quantity']); ?>

                                        </td>
                                        <td class="text-right cart-summary-table">
                                            <?php echo e($value['price']); ?>

                                        </td>
                                        <td class="text-right cart-summary-table">
                                            <?php echo e($value['tax']); ?>

                                        </td>
                                        <td class="text-right cart-summary-table">
                                            <?php echo e($value['tax_amount']); ?>

                                        </td>
                                        <td class="text-right cart-summary-table">
                                            <?php echo e($value['subtotal']); ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td class="text-left font-weight-bold"><?php echo e(__('Total')); ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right font-weight-bold"><?php echo e($sales['total']); ?></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <?php if($details['pay'] == 'show'): ?>
                            <button class="btn btn-primary btn-sm btn-done-payment text-right float-right rounded-pill" data-url="<?php echo e(route('sales.store')); ?>"><?php echo e(__('Done Payment')); ?></button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
     </div>

    <script type="text/javascript" src="<?php echo e(asset('js/html2pdf.bundle.min.js')); ?>"></script>
    <script>

        function saveAsPDF2() {
            var element = document.getElementById('printableArea2');
            var opt = {
                margin: 0.3,
                filename:'sale_invoice',
                image: {
                    type: 'jpeg',
                    quality: 1
                },
                html2canvas: {
                    scale: 4,
                    dpi: 72,
                    letterRendering: true
                },
                jsPDF: {
                    unit: 'in',
                    format: 'A3'
                }
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>

    <script>
        $('.copy_link').click(function (e) {
            e.preventDefault();
            var copyText = $(this).attr('href');

            document.addEventListener('copy', function (e) {
                e.clipboardData.setData('text/plain', copyText);
                e.preventDefault();
            }, true);

            document.execCommand('copy');
            show_toastr('Success', 'Url copied to clipboard', 'success');
        });
    </script>




<script src="<?php echo e(asset('assets/js/site.core.js')); ?>"></script>
<script src="<?php echo e(asset('assets/libs/progressbar.js/dist/progressbar.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/libs/apexcharts/dist/apexcharts.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/libs/moment/min/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/libs/bootstrap-daterangepicker/daterangepicker.js')); ?>"></script>
<script src="<?php echo e(asset('assets/libs/fullcalendar/dist/fullcalendar.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/libs/select2/dist/js/select2.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/libs/bootstrap-notify/bootstrap-notify.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/jquery-ui.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/app.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/letter.avatar.js')); ?>"></script>
<script src="<?php echo e(asset('js/jquery.form.js')); ?>"></script>



<script src="<?php echo e(asset('js/custom.js')); ?>"></script>

<?php echo $__env->yieldPushContent('scripts'); ?>

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

</body>
</html>

<?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/sales/sale_invoice.blade.php ENDPATH**/ ?>