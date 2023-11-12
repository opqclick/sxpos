@extends('layouts.app')

@section('page-title', __('Custom Report'))

@section('title')
    <div class="d-inline-block">
        <h4 class="title">{{ __('Custom Report') }}</h4>
    </div>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
<li class="breadcrumb-item">{{ __('Reports') }}</li>
<li class="breadcrumb-item">{{ __('Custom Report') }}</li>
@endsection

@section('action-btn')

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="card" style="min-height: 225px;cursor: pointer;" data-bs-toggle="modal" data-bs-target="#cashRegisterSaleReportModal">
                <div class="card-body">
                    <div class="theme-avtar bg-primary">
                        <i class="ti ti-chart-bar"></i>
                    </div>
                    <h3 class="mb-0">&nbsp;</h3>
                    <h6>Cash Register Sale Report</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="card" style="min-height: 225px;cursor: pointer;" data-bs-toggle="modal" data-bs-target="#serviceWiseReportModal">
                <div class="card-body">
                    <div class="theme-avtar bg-info">
                        <i class="ti ti-chart-bar"></i>
                    </div>
                    <h3 class="mb-0">&nbsp;</h3>
                    <h6>Service Wise Report</h6>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="cashRegisterSaleReportModal" tabindex="-1" role="dialog" aria-labelledby="cashRegisterSaleReportModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cashRegisterSaleReportModalLabel">Cash Register Sale Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="body">
                    <div class="container mb-4">
                        <form action="{{ route('custom.report.cash-register-sale-report') }}" method="get" target="_blank">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="text" name="start_date" value="" class="form-control modalDatepicker" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="text" name="end_date" value="" class="form-control modalDatepicker" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Branch</label>
                                        <select name="branch" class="form-control branch" required>
                                            <option value="">Select Branch</option>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Cash Register</label>
                                        <select name="cash_register" class="form-control cash_register" required>
                                            <option value="">Select Cash Register</option>

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-2">
                                <button type="submit" class="btn btn-primary">Show Report</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="serviceWiseReportModal" tabindex="-1" role="dialog" aria-labelledby="serviceWiseReportModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="serviceWiseReportModalLabel">Service Wise Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="body">
                    <div class="container mb-4">
                        <form action="{{ route('custom.report.service-wise-report') }}" method="get" target="_blank">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="text" name="start_date" value="" class="form-control modalDatepicker" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="text" name="end_date" value="" class="form-control modalDatepicker" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Brand</label>
                                        <select name="brand" class="form-control" required>
                                            <option value="">Select Brand</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-2">
                                <button type="submit" class="btn btn-primary">Show Report</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection




@push('scripts')
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>

    <script type="text/javascript">
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
            $(".modalDatepicker").datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
            // setEndDate($('#start-date').val());
        });

        $(document).on('change', '#cashRegisterSaleReportModal .branch', function(e) {

            $.ajax({
                url: '{{ route('get.cash.registers') }}',
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
                    show_toastr('{{ __('Error') }}', data.error, 'error');
                }
            });
        });
        /*$(document).on('change', '#start-date', function(e) {
            $('#end_date_status').val(1);
            setEndDate($(this).val());
            $('#end_date_status').val(0);
        });*/

    </script>
@endpush
