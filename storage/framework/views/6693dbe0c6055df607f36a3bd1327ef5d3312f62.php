<?php $__env->startSection('page-title', __('Sales')); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Sales')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('action-btn'); ?>
        <a type="button" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="collapse"
        data-bs-toggle="tooltip" 
            data-bs-target=".multi-collapse" title="<?php echo e(__('Filter')); ?>"> <i class="ti ti-filter text-white"></i> </a>

        <a href="<?php echo e(route('Sale.export')); ?>" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="tooltip" title="<?php echo e(__('Export')); ?>">
        <i class="ti ti-file-export"></i> 
        </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
         <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
        <li class="breadcrumb-item"><?php echo e(__('Sale list')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('old-datatable-css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('custom/css/jquery.dataTables.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('custom/css/customdatatable.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/flatpickr.min.css')); ?>">
<?php $__env->stopPush(); ?>


<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/flatpickr.min.js')); ?>"></script>
    <script>
        // minimum setup
        document.querySelector("#pc-daterangepicker-1").flatpickr({
            mode: "range",
            onChange: function(selectedDates, dateStr, instance) {
                var dates = dateStr.split(" to ");
                var start = moment(dates[0]).format('YYYY-MM-DD');
                var end = moment(dates[0]).format('YYYY-MM-DD');
                $('#start_date1').val(start);
                $('end_date1').val(end);
                if (dates.length == 1) {
                    var end = moment(dates[1]).format('YYYY-MM-DD');
                    $('end_date1').val(end);
                    if (typeof ajax_invoice_filter == 'function') {
                        ajax_invoice_filter();
                    }
                }
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Sales')): ?>

    <?php $__env->startSection('content'); ?>
        <div class="row ">
            <div class="col-12">
                <div class="card collapse multi-collapse">
                    <div class="card-body p-3">
                        <div class="row input-daterange analysis-datepicker align-items-center">
                            <div class="form-group col-md-4 mb-0">
                                <?php echo e(Form::label('duration1', __('Date Duration'), ['class' => 'form-control-label'])); ?>

                                <div class="input-group" style="width: 1066px;">
                                    


                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <input type='text' class="form-control" id="pc-daterangepicker-1"
                                            placeholder="Select time" type="text" />
                                        <?php echo e(Form::hidden('start_date1', $start_date, ['class' => 'form-control', 'id' => 'start_date1'])); ?>

                                        <?php echo e(Form::hidden('due_date1', $end_date, ['class' => 'form-control', 'id' => 'end_date1'])); ?>

                                    </div>

                                </div>
                            </div>
                            <div class="form-group col-md-4 mb-0">
                                <?php echo e(Form::label('sell_to', __('Sold To'), ['class' => 'form-control-label'])); ?>

                                <div class="input-group">
                                    <?php echo e(Form::select('sell_to', $customers, null, ['class' => 'form-control', 'id' => 'sell_to', 'data-toggle' => 'select'])); ?>

                                </div>
                            </div>
                            <div class="form-group col-md-4 mb-0">
                                <?php echo e(Form::label('sell_by', __('Sold By'), ['class' => 'form-control-label'])); ?>

                                <div class="input-group">
                                    <?php echo e(Form::select('sell_by', $users, null, ['class' => 'form-control', 'id' => 'sell_by', 'data-toggle' => 'select'])); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card table-card">
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
                                        <h5 class="h6" id="totalitems"></h5>
                                    </td>
                                    <td rowspan="1" colspan="1">
                                        <h5 class="h6" id="totalcounts"></h5>
                                    </td>
                                    <td rowspan="1" colspan="1"></td>
                                    <td rowspan="1" colspan="1"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                </div>

            </div>
        </div>

    <?php $__env->stopSection(); ?>

    <?php $__env->startPush('old-datatable-js'); ?>
        
    <script src="<?php echo e(asset('custom/js/jquery.dataTables.min.js')); ?>"></script>
    <script>
        var dataTabelLang = {
            paginate: {previous: "<i class='fas fa-angle-left'>", next: "<i class='fas fa-angle-right'>"},
            lengthMenu: "<?php echo e(__('Show')); ?> _MENU_ <?php echo e(__('entries')); ?>",
            zeroRecords: "<?php echo e(__('No data available in table.')); ?>",
            info: "<?php echo e(__('Showing')); ?> _START_ <?php echo e(__('to')); ?> _END_ <?php echo e(__('of')); ?> _TOTAL_ <?php echo e(__('entries')); ?>",
            infoEmpty: "<?php echo e(__('Showing 0 to 0 of 0 entries')); ?>",
            infoFiltered: "<?php echo e(__('(filtered from _MAX_ total entries)')); ?>",
            search: "<?php echo e(__('Search:')); ?>",
            thousands: ",",
            loadingRecords: "<?php echo e(__('Loading...')); ?>",
            processing: "<?php echo e(__('Processing...')); ?>"
        };

        var site_currency_symbol_position = '<?php echo e(\App\Models\Utility::getValByName('site_currency_symbol_position')); ?>';
        var site_currency_symbol = '<?php echo e(\App\Models\Utility::getValByName('site_currency_symbol')); ?>';
    </script>

    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('scripts'); ?>
        <script src="<?php echo e(asset('js/bootstrap-datepicker.min.js')); ?>"></script>

        <script>
           
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
       </script>

        <script type="text/javascript">
            

            $(document).ready(function() {
                ajax_invoice_filter();
            });

            $(document).on('change', '#sell_to, #sell_by', function(e) {
                ajax_invoice_filter();
            });

            function ajax_invoice_filter() {

                var data = {
                    'url': '<?php echo e(route('invoice.filter')); ?>',
                    'start_date': $('#start_date1').val(),
                    'end_date': $('#end_date1').val(),
                    'customer_id': $('#sell_to').val(),
                    'user_id': $('#sell_by').val(),
                    'customers': 1,
                }

                $('#myTable').DataTable({
                        "processing": true,
                        "destroy": true,
                        "paging": true,
                        "pageLength": 10,
                        "ordering": false,
                        "language": dataTabelLang,
                        "ajax": {
                            "type": "GET",
                            "url": data.url,
                            "data": data,
                        },
                        "columns": [{
                                "data": "invoice_id"
                            },
                            {
                                "data": "created_at"
                            },
                            {
                                "data": "username"
                            },
                            {
                                "data": "customername"
                            },
                            {
                                "data": "itemscount"
                            },
                            {
                                "data": "itemstotal"
                            },
                            {
                                "data": "paymentstatus"
                            },
                            {
                                "data": "action"
                            }
                        ],
                    })
                    .on("xhr.dt", function(e, settings, json, xhr) {
                        $('#totalitems').text(json.totalItemsCount);
                        $('#totalcounts').text(json.totalCount);
                        setTimeout(function() {
                            loadConfirm();
                        }, 1000);
                    });
            }

            $(document).on('click', '.payment-action', function(e) {
                e.stopPropagation();
                e.preventDefault();

                var ele = $(this);

                var id = ele.parent().attr('data-id');
                var url = ele.parent().attr('data-url');
                var status = ele.attr('data-status');

                $.ajax({
                    url: url,
                    method: 'PATCH',
                    data: {
                        status: status
                    },
                    success: function(response) {

                        if (response) {

                            $('[data-li-id="' + id + '"] .payment-action').removeClass('selected');

                            if (ele.hasClass('selected')) {

                                ele.removeClass('selected');

                            } else {
                                ele.addClass('selected');
                            }

                            var payment = $('[data-li-id="' + id + '"] .payment-actions').find('.selected')
                                .text().trim();

                            var payment_class = $('[data-li-id="' + id + '"] .payment-actions').find(
                                '.selected').attr('data-class');
                            $('[data-li-id="' + id + '"] .payment-label').removeClass(
                                'unpaid partially-paid paid').addClass(payment_class).text(payment);
                        }
                    },
                    error: function(data) {
                        data = data.responseJSON;
                        show_toastr('<?php echo e(__('Error')); ?>', data.error, 'error');
                    }
                });
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/reports/sale.blade.php ENDPATH**/ ?>