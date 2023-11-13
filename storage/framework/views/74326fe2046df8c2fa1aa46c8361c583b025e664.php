<?php $__env->startSection('page-title', __('Custom Report')); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h4 class="title"><?php echo e(__('Cash Register Sale Report')); ?></h4>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
<li class="breadcrumb-item"><?php echo e(__('Reports')); ?></li>
<li class="breadcrumb-item"><?php echo e(__('Custom Report')); ?></li>
<li class="breadcrumb-item"><?php echo e(__('Cash Register Sale Report')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('old-datatable-css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('custom/css/jquery.dataTables.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('custom/css/customdatatable.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/flatpickr.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('action-btn'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-lg-2 col-4">
            <div class="card" style="min-height: 180px;">
                <div class="card-body">
                    <div class="theme-avtar bg-primary">
                        <i class="ti ti-hand-finger"></i>
                    </div>
                    <p class="text-muted text-sm mt-4 mb-2">Cashier</p>
                    <h6 class="mb-3"></h6>
                    <h3 class="mb-0"><?php echo e($cashier->name); ?><span class="text-success text-sm"><i class=""></i> </span></h3>
                </div>
            </div>
        </div>
        <?php $__currentLoopData = $pm_amounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $pm_amount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($pm_amount <= 0): ?> <?php continue; ?> <?php endif; ?>
            <div class="col-lg-2 col-4">
                <div class="card" style="min-height: 180px;">
                    <div class="card-body">
                        <div class="theme-avtar bg-warning">
                            <i class="ti ti-report-money"></i>
                        </div>
                        <p class="text-muted text-sm mt-4 mb-2"><?php echo e(\App\Models\Sale::PAYMENT_METHODS[$key]); ?></p>
                        <h6 class="mb-3"></h6>
                        <h3 class="mb-0">$<?php echo e($pm_amount); ?><span class="text-success text-sm"><i class=""></i> </span></h3>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>


    <div class="card table-card mt-5">
        <div class="card-header card-body table-border-style">
            
            <div class="col-sm-12 table-responsive mt-3 table_over">
                <table class="table dataTable" id="myTable" role="grid">
                    <thead class="thead-light">
                    <tr role="row">
                        <th style="width: 277px;"><?php echo e(__('Invoice ID')); ?></th>
                        <th><?php echo e(__('Date')); ?></th>
                        <th><?php echo e(__('Sold By')); ?></th>
                        <th><?php echo e(__('Sold To')); ?></th>
                        <th><?php echo e(__('Items Sold')); ?></th>
                        <th><?php echo e(__('Total')); ?></th>
                        <th><?php echo e(__('Payment Status')); ?></th>
                        <th style="width: 180px;"><?php echo e(__('Action')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php ($total_items = 0); ?>
                    <?php ($total_amount = 0); ?>
                    <?php $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php ($total_items += $sale->items->count()); ?>
                        <?php ($total_amount += $sale->getTotal()); ?>
                        <tr role="row">
                            <td><?php echo e($sale->invoice_id); ?></td>
                            <td><?php echo e(Auth::user()->datetimeFormat($sale->created_at)); ?></td>
                            <td><?php echo e($sale->user->name); ?></td>
                            <td><?php echo e($sale->customer != null ? ucfirst($sale->customer->name) : __('Walk-in Customer')); ?></td>
                            <td><?php echo e($sale->items->count()); ?></td>
                            <td>$<?php echo e($sale->getTotal()); ?></td>
                            <td>
                                <?php if($sale->payment_status == 0): ?>
                                    <span class="display-payment">
                                        <span data-bs-toggle="dropdown" class="badge payment-label badge-lg p-2  unpaid"><?php echo e(__('Unpaid')); ?></span>
                                    </span>
                                <?php else: ?>
                                    <span class="display-payment">
                                        <span data-bs-toggle="dropdown" class="badge payment-label badge-lg p-2  paid"><?php echo e(__('Paid')); ?></span>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-btn bg-dark ms-2">
                                    <a href="<?php echo e(route('get.sales.invoice', Crypt::encrypt($sale->id))); ?>" target="_blank" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip"  data-title="<?php echo e(__('Download')); ?>"   title="<?php echo e(__('Download')); ?>"><i class="ti ti-arrow-bar-to-down text-white"></i></a>
                                </div>
                                <div class="action-btn bg-primary ms-2">
                                    <a href="<?php echo e(route('sale.link.copy', Crypt::encrypt($sale->id))); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center copy_link_sale"   data-bs-toggle="tooltip"  data-title="<?php echo e(__('Copy Link')); ?>"  title="<?php echo e(__('Copy Link')); ?>"><i class="ti ti-link text-white"></i></a>
                                </div>
                                <div class="action-btn bg-warning ms-2">
                                    <a href="#" data-ajax-popup="true" data-title="<?php echo e(__('Sale Invoice')); ?>" data-size="lg" data-url="<?php echo e(route('show.sell.invoice', $sale->id)); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip"  data-title="<?php echo e(__('Show')); ?>" title="<?php echo e(__('Show')); ?>"><i class="ti ti-eye text-white"></i></a>
                                </div>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td rowspan="1" colspan="1">
                            <h5 class="h6"><?php echo e(__('Grand Total')); ?></h5>
                        </td>
                        <td rowspan="1" colspan="1"></td>
                        <td rowspan="1" colspan="1"></td>
                        <td rowspan="1" colspan="1"></td>
                        <td rowspan="1" colspan="1">
                            <h5 class="h6" id="totalitems"><?php echo e($total_items); ?></h5>
                        </td>
                        <td rowspan="1" colspan="1">
                            <h5 class="h6" id="totalcounts">$<?php echo e($total_amount); ?></h5>
                        </td>
                        <td rowspan="1" colspan="1"></td>
                        <td rowspan="1" colspan="1"></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>

    <script src="<?php echo e(asset('custom/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap-datepicker.min.js')); ?>"></script>

    <script type="text/javascript">
        $(document).on('click', '.copy_link_sale', function(e) {
            e.preventDefault();
            var copyText = $(this).attr('href');

            document.addEventListener('copy', function (e) {
                e.clipboardData.setData('text/plain', copyText);
                e.preventDefault();
            }, true);

            document.execCommand('copy');
            show_toastr('Success', 'Url copied to clipboard', 'success');
        });

        $(document).ready(function() {
            $('#myTable').DataTable();
        });

        $(document).on('change', '#cashRegisterSaleReportModal .branch', function(e) {

            $.ajax({
                url: '<?php echo e(route('get.cash.registers')); ?>',
                dataType: 'json',
                data: {
                    'branch_id': $(this).val()
                },
                success: function(data) {
                    $('#cashRegisterSaleReportModal .cash_register').find('option').not(':first').remove();
                    $.each(data, function(key, value) {
                        $('#cashRegisterSaleReportModal .cash_register')
                            .append($("<option></option>")
                                .attr("value", value.id)
                                .text(value.name));
                    });
                },
                error: function(data) {
                    data = data.responseJSON;
                    show_toastr('<?php echo e(__('Error')); ?>', data.error, 'error');
                }
            });
        });
        /*$(document).on('change', '#start-date', function(e) {
            $('#end_date_status').val(1);
            setEndDate($(this).val());
            $('#end_date_status').val(0);
        });*/

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/reports/custom/cash_register_sale_report.blade.php ENDPATH**/ ?>