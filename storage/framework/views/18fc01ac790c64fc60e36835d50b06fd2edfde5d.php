<?php $__env->startSection('page-title', __('Sale Daily/Monthly Report')); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h4 class="title"><?php echo e(__('Sale Monthly')); ?></h4>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
<li class="breadcrumb-item"><?php echo e(__('Reports')); ?></li>
<li class="breadcrumb-item"><?php echo e(__('Sale Monthly')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
<a class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="collapse"
                data-bs-target=".multi-collapse-monthly-sale" title="<?php echo e(__('Filter')); ?>"> <i
                    class="ti ti-filter text-white"></i> </a>
<?php $__env->stopSection(); ?>


<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Sales')): ?>

    <?php $__env->startSection('content'); ?>


        <ul class="nav nav-pills my-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="pills-home-tab" data-bs-toggle="pill" href="<?php echo e(route('sold.daily.analysis')); ?>"
                    onclick="window.location.href = '<?php echo e(route('sold.daily.analysis')); ?>'" role="tab"
                    aria-controls="pills-home" aria-selected="true"><?php echo e(__('Daily')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="pills-profile-tab" data-bs-toggle="pill" href="#monthly-chart" role="tab"
                    aria-controls="pills-profile" aria-selected="false"><?php echo e(__('Monthly')); ?></a>
            </li>
        </ul>


        <div class=w-100>
            <div class="card collapse multi-collapse-monthly-sale <?php echo e($display_status); ?>">
                <div class="card-body py-3">
                    <div class="row input-daterange align-items-center">
                        <div class="form-group col-md-6 mb-0">
                            <?php echo e(Form::label('monthly_branch_id', __('Branch'), ['class' => 'col-form-label'])); ?>

                            <div class="input-group">
                                <?php echo e(Form::select('monthly_branch_id', $branches, null, ['class' => 'form-control','id' => 'monthly_branch_id','data-toggle' => 'select'])); ?>

                            </div>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                            <?php echo e(Form::label('monthly_cash_register_id', __('Cash Register'), ['class' => 'col-form-label'])); ?>

                            <div class="input-group">
                                <?php echo e(Form::select('monthly_cash_register_id', $cash_registers, null, ['class' => 'form-control','id' => 'monthly_cash_register_id','data-toggle' => 'select'])); ?>

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
                                <div class="tab-pane fade" id="daily-chart" role="tabpanel">
                                </div>

                                <div class="tab-pane fade show active" id="monthly-chart" role="tabpanel">
                                    <div class="row <?php echo e($display_status ? 'mt-59' : ''); ?>">
                                        <div class="col-lg-12">
                                            <div class="card-header">
                                                <div class="row ">
                                                    <div class="col-6">
                                                        <h6><?php echo e(__('Monthly Report')); ?></h6>
                                                    </div>
                                                    <div class="col-6 text-end">
                                                        <h6><?php echo e(__('Last 12 Months')); ?></h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div id="sale-monthly-report"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>

    <?php $__env->startPush('scripts'); ?>
        <script src="<?php echo e(asset('js/bootstrap-datepicker.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/js/plugins/apexcharts.min.js')); ?>"></script>

        <script type="text/javascript">
            var saleMonthlyReport;

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
                            text: '<?php echo e(__('Months')); ?>'
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
                    //     colors: ['#ffa21d', '#6fd943'],
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
                saleMonthlyReport = new ApexCharts($this[0], options);
                saleMonthlyReport.render();
            };

            function ajax_sale_monthly_chart_filter() {

                var data = {
                    'start_date': $('#start-date').val(),
                    'end_date': $('#end-date').val(),
                    'branch_id': $('#monthly_branch_id').val(),
                    'cash_register_id': $('#monthly_cash_register_id').val(),
                };

                $.ajax({
                    url: '<?php echo e(route('sold.monthly.chart.filter')); ?>',
                    dataType: 'json',
                    data: data,
                    success: function(data) {

                        var $chart = $('#sale-monthly-report');

                        if ($chart.length) {
                            if (typeof saleMonthlyReport == 'undefined') {
                                init($chart, data);
                            } else {
                                saleMonthlyReport.updateOptions({
                                    series: [{
                                        data: data.value
                                    }, ],
                                    xaxis: {
                                        categories: data.label,
                                    },
                                });
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
                ajax_sale_monthly_chart_filter();
            });

            $(document).on('change', '#monthly_cash_register_id', function(e) {

                ajax_sale_monthly_chart_filter();
            });

            $(document).on('change', '#monthly_branch_id', function(e) {

                $.ajax({
                    url: '<?php echo e(route('get.cash.registers')); ?>',
                    dataType: 'json',
                    async: false,
                    data: {
                        'branch_id': $(this).val()
                    },
                    success: function(data) {
                        $('#monthly_cash_register_id').find('option').not(':first').remove();
                        $.each(data, function(key, value) {
                            $('#monthly_cash_register_id')
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

                ajax_sale_monthly_chart_filter();
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/reports/sold-monthly.blade.php ENDPATH**/ ?>