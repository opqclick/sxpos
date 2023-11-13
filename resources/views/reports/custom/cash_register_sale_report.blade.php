@extends('layouts.app')

@section('page-title', __('Custom Report'))

@section('title')
    <div class="d-inline-block">
        <h4 class="title">{{ __('Cash Register Sale Report') }}</h4>
    </div>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
<li class="breadcrumb-item">{{ __('Reports') }}</li>
<li class="breadcrumb-item">{{ __('Custom Report') }}</li>
<li class="breadcrumb-item">{{ __('Cash Register Sale Report') }}</li>
@endsection

@push('old-datatable-css')
    <link rel="stylesheet" href="{{ asset('custom/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('custom/css/customdatatable.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/flatpickr.min.css') }}">
@endpush

@section('action-btn')

@endsection

@section('content')

    <div class="row">
        <div class="col-lg-2 col-4">
            <div class="card" style="min-height: 180px;">
                <div class="card-body">
                    <div class="theme-avtar bg-primary">
                        <i class="ti ti-hand-finger"></i>
                    </div>
                    <p class="text-muted text-sm mt-4 mb-2">Cashier</p>
                    <h6 class="mb-3"></h6>
                    <h3 class="mb-0">{{ $cashier->name }}<span class="text-success text-sm"><i class=""></i> </span></h3>
                </div>
            </div>
        </div>
        @foreach($pm_amounts as $key => $pm_amount)
            @if($pm_amount <= 0) @continue @endif
            <div class="col-lg-2 col-4">
                <div class="card" style="min-height: 180px;">
                    <div class="card-body">
                        <div class="theme-avtar bg-warning">
                            <i class="ti ti-report-money"></i>
                        </div>
                        <p class="text-muted text-sm mt-4 mb-2">{{ \App\Models\Sale::PAYMENT_METHODS[$key] }}</p>
                        <h6 class="mb-3"></h6>
                        <h3 class="mb-0">${{ $pm_amount }}<span class="text-success text-sm"><i class=""></i> </span></h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    <div class="card table-card mt-5">
        <div class="card-header card-body table-border-style">
            {{-- <h5></h5> --}}
            <div class="col-sm-12 table-responsive mt-3 table_over">
                <table class="table dataTable" id="myTable" role="grid">
                    <thead class="thead-light">
                    <tr role="row">
                        <th style="width: 277px;">{{ __('Invoice ID') }}</th>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Sold By') }}</th>
                        <th>{{ __('Sold To') }}</th>
                        <th>{{ __('Items Sold') }}</th>
                        <th>{{ __('Total') }}</th>
                        <th>{{ __('Payment Status') }}</th>
                        <th style="width: 180px;">{{ __('Action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($total_items = 0)
                    @php($total_amount = 0)
                    @foreach($sales as $key => $sale)
                        @php($total_items += $sale->items->count())
                        @php($total_amount += $sale->getTotal())
                        <tr role="row">
                            <td>{{ $sale->invoice_id }}</td>
                            <td>{{ Auth::user()->datetimeFormat($sale->created_at) }}</td>
                            <td>{{ $sale->user->name }}</td>
                            <td>{{ $sale->customer != null ? ucfirst($sale->customer->name) : __('Walk-in Customer') }}</td>
                            <td>{{ $sale->items->count() }}</td>
                            <td>${{ $sale->getTotal() }}</td>
                            <td>
                                @if($sale->payment_status == 0)
                                    <span class="display-payment">
                                        <span data-bs-toggle="dropdown" class="badge payment-label badge-lg p-2  unpaid">{{ __('Unpaid') }}</span>
                                    </span>
                                @else
                                    <span class="display-payment">
                                        <span data-bs-toggle="dropdown" class="badge payment-label badge-lg p-2  paid">{{ __('Paid') }}</span>
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="action-btn bg-dark ms-2">
                                    <a href="{{route('get.sales.invoice', Crypt::encrypt($sale->id)) }}" target="_blank" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip"  data-title="{{ __('Download') }}"   title="{{ __('Download') }}"><i class="ti ti-arrow-bar-to-down text-white"></i></a>
                                </div>
                                <div class="action-btn bg-primary ms-2">
                                    <a href="{{ route('sale.link.copy', Crypt::encrypt($sale->id)) }}" class="mx-3 btn btn-sm d-inline-flex align-items-center copy_link_sale"   data-bs-toggle="tooltip"  data-title="{{ __('Copy Link') }}"  title="{{ __('Copy Link') }}"><i class="ti ti-link text-white"></i></a>
                                </div>
                                <div class="action-btn bg-warning ms-2">
                                    <a href="#" data-ajax-popup="true" data-title="{{ __('Sale Invoice')  }}" data-size="lg" data-url="{{ route('show.sell.invoice', $sale->id) }}" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip"  data-title="{{ __('Show') }}" title="{{ __('Show') }}"><i class="ti ti-eye text-white"></i></a>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td rowspan="1" colspan="1">
                            <h5 class="h6">{{ __('Grand Total') }}</h5>
                        </td>
                        <td rowspan="1" colspan="1"></td>
                        <td rowspan="1" colspan="1"></td>
                        <td rowspan="1" colspan="1"></td>
                        <td rowspan="1" colspan="1">
                            <h5 class="h6" id="totalitems">{{ $total_items }}</h5>
                        </td>
                        <td rowspan="1" colspan="1">
                            <h5 class="h6" id="totalcounts">${{ $total_amount }}</h5>
                        </td>
                        <td rowspan="1" colspan="1"></td>
                        <td rowspan="1" colspan="1"></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endsection


@push('scripts')

    <script src="{{ asset('custom/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>

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
