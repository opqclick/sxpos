@php
    $settings = Utility::settings();
@endphp
<!DOCTYPE html>
<html lang="en" dir="{{ $settings == 'on' ? 'rtl' : '' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/main.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}">

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">

    <title>{{ env('APP_NAME') }} - Sales</title>
    @if (isset($settings['SITE_RTL']) && $settings['SITE_RTL'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
    @endif
</head>

<body>
    <div id="bot" class="m-5">
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

    <script src="{{ asset('js/jquery.min.js') }} "></script>
    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var element = document.getElementById('bot');
            html2pdf().from(element).toPdf().get('pdf').then(function(pdfObj) {
                pdfObj.autoPrint();
                window.open(pdfObj.output('bloburl'), '_self');
            });
        });
    </script>


</body>

</html>
