
<body>
    <div id="print" class="m-5">
        <h3>
            <center>{{__('sales')}}</center>
        </h3>
        <div class="row">
            <table class="table">
                <tbody>
                    <tr>
                        <td scope="row" class="p-2">
                            <span>{{ __('Date of Invoice:') }}</span>
                            <span class="ms-2 font-label">{{ $details['date'] }}</span>
                        </td>
                    </tr>
                    <div>
                        <div class="invoice-to col-12 mt-3">
                            {{-- <div class="text-gray-light">{{ __('Name:') }} --}}

                            {!! isset($details['customer']['name']) ? '' : $details['customer']['details'] !!}

                        </div>
                    </div>
                    <div>
                        {!! isset($details['customer']['name']) ? 'Name:  ' . $details['customer']['name'] : '' !!}

                    </div>
                    <div>
                        {!! isset($details['customer']['address']) ? 'Address:  ' . $details['customer']['address'] : '' !!}

                    </div>
                    <div>
                        {!! isset($details['customer']['email']) ? 'Email:  ' . $details['customer']['email'] : '' !!}

                    </div>
                    <div>
                        {!! isset($details['customer']['phone_number']) ? 'Phone:  ' . $details['customer']['phone_number'] : '' !!}

                    </div>


                </tbody>
            </table>
            @foreach ($sales['data'] as $key => $value)
                <div>

                    <div class="ms-3"> {{ $value['name'] }}</div>


                    <div class="d-flex product-border">
                        <div class="ms-3">{{__('Quantity:')}}</div>
                        <div class="text-end ms-auto">{{ $value['quantity'] }}</div>
                    </div>
                </div>


                <div class="d-flex product-border">
                    <div class="ms-3">{{__('Price:')}}</div>
                    <div class="text-end ms-auto">{{ $value['price'] }}</div>
                </div>
                <div class="d-flex product-border">
                    <div class="ms-3">{{__('Tax:')}}</div>
                    <div class="text-end ms-auto"> {{ $value['tax'] }}</div>
                </div>
                <div class="d-flex product-border mb-2">
                    <div class="ms-3">{{__('Tax Amount:')}}</div>
                    <div class="text-end ms-auto">{{ $value['tax_amount'] }}</div>
                </div>
                <div class="d-flex product-border mb-2">
                    <div class="ms-3">{{__('Total:')}}</div>
                    <div class="text-end ms-auto"> {{ $value['subtotal'] }}</div>
                </div>
            @endforeach

            <center>

                <div class="text-center d-block" style="margin-left:300px;">{!! DNS2D::getBarcodeHTML(
                    route('sale.link.copy', \Illuminate\Support\Facades\Crypt::encrypt($details['invoice_id'])),
                    'QRCODE',
                    2,
                    2,
                ) !!}</div>
            </center>



            <h5 class="text-center mt-3 font-label">{{__('Thank You For Shopping With Us. Please visit again.')}}</h5>


        </div>
    </div>
  


</body>



