<?php $__env->startSection('page-title', __('Sale Daily/Monthly Report')); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h4 class="title"><?php echo e(__('Sale Daily')); ?></h4>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
<li class="breadcrumb-item"><?php echo e(__('Reports')); ?></li>
<li class="breadcrumb-item"><?php echo e(__('Sale Daily')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
<a class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="collapse" data-bs-target=".multi-collapse-daily-sale"
title="<?php echo e(__('Filter')); ?>"> <i class="ti ti-filter text-white"></i> </a>
<?php $__env->stopSection(); ?>


<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Sales')): ?>

    <?php $__env->startSection('content'); ?>
       

        <ul class="nav nav-pills my-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#daily-chart" role="tab"
                    aria-controls="pills-home" aria-selected="true"><?php echo e(__('Daily')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                    href="<?php echo e(route('sold.monthly.analysis')); ?>"
                    onclick="window.location.href = '<?php echo e(route('sold.monthly.analysis')); ?>'" role="tab"
                    aria-controls="pills-profile" aria-selected="false"><?php echo e(__('Monthly')); ?></a>
            </li>

        </ul>



        <div class="w-100">
            <div class="card collapse multi-collapse-daily-sale">
                <div class="card-body">
                    <div class="row input-daterange analysis-datepicker align-items-center">
                        <div class="form-group col-md-3 mb-0">
                            <?php echo e(Form::label('start-date', __('Start date'), ['class' => 'col-form-label'])); ?>

                            <div class="input-group">
                                <?php echo e(Form::text('start-date', $start_date, ['class' => 'form-control', 'placeholder' => __('Select Start date')])); ?>

                            </div>
                        </div>
                        <div class="form-group col-md-3 mb-0">
                            <?php echo e(Form::label('end-date', __('End date'), ['class' => 'col-form-label'])); ?>

                            <div class="input-group">
                                <?php echo e(Form::hidden('end_date_status', 0, ['id' => 'end_date_status'])); ?>


                                <?php echo e(Form::text('end-date', $end_date, ['class' => 'form-control', 'placeholder' => __('Select End date')])); ?>

                            </div>
                        </div>
                        <div class="form-group col-md-3 mb-0 <?php echo e($display_status); ?>">
                            <?php echo e(Form::label('daily_branch_id', __('Branch'), ['class' => 'col-form-label'])); ?>

                            <div class="input-group">
                                <?php echo e(Form::select('daily_branch_id', $branches, null, ['class' => 'form-control','id' => 'daily_branch_id','data-toggle' => 'select'])); ?>

                            </div>
                        </div>
                        <div class="form-group col-md-3 mb-0 <?php echo e($display_status); ?>">
                            <?php echo e(Form::label('daily_cash_register_id', __('Cash Register'), ['class' => 'col-form-label'])); ?>

                            <div class="input-group">
                                <?php echo e(Form::select('daily_cash_register_id', $cash_registers, null, ['class' => 'form-control','id' => 'daily_cash_register_id','data-toggle' => 'select'])); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row min-vh-74">
            <div class="col-12">
                <div class="card">
                   
                        <div class="setting-tab">

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="daily-chart" role="tabpanel">
                                    <div class="col-lg-12">
                                        <div class="card-header">
                                            <div class="row ">
                                                <div class="col-6">
                                                    <h6><?php echo e(__('Daily Report')); ?></h6>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <h6><?php echo e(__('Last 30 Days')); ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="sale-daily-report"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="monthly-chart" role="tabpanel">
                                </div>
                            </div>
                        </div>
                   
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>




    <?php $__env->startPush('scripts'); ?>
        <script src="<?php echo e(asset('js/bootstrap-datepicker.min.js')); ?>"></script>

        <script type="text/javascript">
            var saleDailyReport;

            function init($this, data) {
                var options = {
                    chart: {
                        height: 400,
                        type: 'area',
                        toolbar: {
                            show: false,
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 2,
                        curve: 'smooth'
                    },
                    series: [{
                        name: '<?php echo e(__('Sale')); ?>',
                        data: data.value
                    }, ],
                    xaxis: {
                        categories: data.label,
                        title: {
                            text: '<?php echo e(__('Days')); ?>'
                        }
                    },
                    colors: ['#6fd943', '#FF3A6E'],

                    grid: {
                        strokeDashArray: 4,
                    },
                    legend: {
                        show: false,
                    },
                    // markers: {
                    //     size: 4,
                    //     colors: ['#ffa21d', '#FF3A6E'],
                    //     opacity: 0.9,
                    //     strokeWidth: 2,
                    //     hover: {
                    //         size: 7,
                    //     }
                    // },
                    yaxis: {
                        title: {
                            text: '<?php echo e(__('Amount')); ?>'
                        },
                    }
                };
                saleDailyReport = new ApexCharts($this[0], options);
                saleDailyReport.render();


            };


            function ajax_sale_daily_chart_filter() {

                var data = {
                    'start_date': $('#start-date').val(),
                    'end_date': $('#end-date').val(),
                    'branch_id': $('#daily_branch_id').val(),
                    'cash_register_id': $('#daily_cash_register_id').val(),
                };

                $.ajax({
                    url: '<?php echo e(route('sold.daily.chart.filter')); ?>',
                    dataType: 'json',
                    data: data,
                    success: function(data) {

                        var $chart = $('#sale-daily-report');

                        if ($chart.length) {
                            if (typeof saleDailyReport == 'undefined') {
                                init($chart, data);
                            } else {
                                saleDailyReport.updateOptions({
                                    series: [{
                                        data: data.value
                                    }, ],
                                    xaxis: {
                                        categories: data.label,
                                    },
                                })
                            }

                        }
                    },
                    error: function(data) {
                        data = data.responseJSON;
                        show_toastr('<?php echo e(__('Error')); ?>', data.error, 'error');
                    }
                });
            }

            function addDays(s, days) {
                var b = s.split(/\D/);
                var d = new Date(b[0], b[1] - 1, b[2]);
                d.setDate(d.getDate() + Number(days));

                function z(n) {
                    return (n < 10 ? '0' : '') + n
                }

                if (isNaN(+d)) return d.toString();
                return d.getFullYear() + '-' + z(d.getMonth() + 1) + '-' + z(d.getDate());
            }

            function setEndDate(value) {

                var added30 = addDays(value, 30);

                var currentdateParts = value.split("-");
                var currentdays = new Date(currentdateParts[0], currentdateParts[1] - 1, currentdateParts[2]);

                var added30dateParts = added30.split("-");
                var added30days = new Date(added30dateParts[0], added30dateParts[1] - 1, added30dateParts[2]);

                $("#end-date").datepicker("destroy");
                $("#end-date").datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    startDate: currentdays,
                    endDate: added30days
                });
                $('#end-date').datepicker('setDate', added30days);
            }

            $(document).ready(function() {

                $("#start-date").datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true
                });
                // $('[data-toggle="select"]').select2({});

                setEndDate($('#start-date').val());

            });

            $(document).on('change', '#daily_cash_register_id, #vendor_id, #end-date', function(e) {

                if ($(this).attr('id') == 'end-date') {
                    if ($('#end_date_status').val() == 1) {
                        return;
                    }
                }
                ajax_sale_daily_chart_filter();
            });

            $(document).on('change', '#start-date', function(e) {

                $('#end_date_status').val(1);

                setEndDate($(this).val());

                ajax_sale_daily_chart_filter();

                $('#end_date_status').val(0);

            });

            $(document).on('change', '#daily_branch_id', function(e) {

                $.ajax({
                    url: '<?php echo e(route('get.cash.registers')); ?>',
                    dataType: 'json',
                    async: false,
                    data: {
                        'branch_id': $(this).val()
                    },
                    success: function(data) {
                        $('#daily_cash_register_id').find('option').not(':first').remove();
                        $.each(data, function(key, value) {
                            $('#daily_cash_register_id')
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

                ajax_sale_daily_chart_filter();
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/reports/sold-daily.blade.php ENDPATH**/ ?>