
    @if (!empty($sales) && count($sales) > 0)
        <div class="container">
            <div class="row invoice">
                <div class="col contacts d-flex justify-content-between pb-4">
                    <div class="invoice-to mt-4">
                        <div class="text-gray-light text-uppercase">{{ __('Invoice To:') }}</div>
                        {!! $details['customer']['details'] !!}
                    </div>
                    <div class="company-details mt-4">
                        <div class="text-gray-light text-uppercase">{{ __('Invoice From:') }}</div>
                        {!! $details['user']['details'] !!}
                    </div>
                </div>
                <div class="col invoice-details text-end">
                    <h1 class="invoice-id h4">{{ $details['invoice_id'] }}</h1>
                    <div class="date mb-3">{{ __('Date of Invoice') }}: {{ $details['date'] }}</div>
                    @if (Utility::getValByName('SITE_RTL') == 'on')
                        <div class="date mb-3 float-start">{!! DNS2D::getBarcodeHTML(
                            route('sale.link.copy', \Illuminate\Support\Facades\Crypt::encrypt($details['invoice_id'])),
                            'QRCODE',
                            2,
                            2,
                        ) !!}</div>
                    @else
                        <div class="date mb-3 float-end">{!! DNS2D::getBarcodeHTML(
                            route('sale.link.copy', \Illuminate\Support\Facades\Crypt::encrypt($details['invoice_id'])),
                            'QRCODE',
                            2,
                            2,
                        ) !!}</div>
                    @endif
                    {{-- <div class="date mb-3 float-right">{!! DNS2D::getBarcodeHTML($details['invoice_id'], 'QRCODE', 5, 5) !!}</div> --}}
                    <span class="clearfix" style="clear: both; display: block;"></span>
                </div>
            </div>

            <div class="row invoice">

                <div class="col-12 col-md-12">
                    <div class="table-responsive invoice-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-left">{{ __('Items') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th class="text-right">{{ __('Price') }}</th>
                                    <th class="text-right">{{ __('Tax') }}</th>
                                    <th class="text-right">{{ __('Tax Amount') }}</th>
                                    <th class="text-right">{{ __('Total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales['data'] as $key => $value)
                                    <tr>
                                        <td class="cart-summary-table text-left">
                                            {{ $value['name'] }}
                                        </td>
                                        <td class="cart-summary-table">
                                            {{ $value['quantity'] }}
                                        </td>
                                        <td class="text-right cart-summary-table">
                                            {{ $value['price'] }}
                                        </td>
                                        <td class="text-right cart-summary-table">
                                            {{ $value['tax'] }}
                                        </td>
                                        <td class="text-right cart-summary-table">
                                            {{ $value['tax_amount'] }}
                                        </td>
                                        <td class="text-right cart-summary-table">
                                            {{ $value['subtotal'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-left font-weight-bold">{{ __('Total') }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right font-weight-bold">{{ $sales['total'] }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @if ($details['pay'] == 'show')
                        {{-- <a href="" data-url="{{ route('sale.print') }}" data-ajax-popup="truee" data-size="sm"
                            data-bs-toggle="tooltip" data-title="{{ __('Invoice Sale') }}"
                            class="btn btn-primary btn-done-payment rounded mb-3 float-right">
                            {{ __('Done Payment') }}
                        </a> --}}
                        <div class="row mb-2">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="row justify-content-end">
                                    <div class="col-auto">
                                        <label for="payment_method">Payment Method</label>
                                    </div>
                                    <div class="col-auto">
                                        <select name="payment_method" id="payment_method" class="form-control">
                                            @foreach(\App\Models\Sale::PAYMENT_METHODS as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <button class="btn btn-primary btn-done-payment btn-sm text-right float-right mb-3 " data-url="{{ route('sale.print') }}" data-ajax-popup="truee" data-size="sm"
                        data-bs-toggle="tooltip" data-title="{{ __('Invoice Sale') }}">
                        {{ __('Done Payment') }}
                    </button>
                    @endif
                </div>
            </div>
        </div>

    @endif


