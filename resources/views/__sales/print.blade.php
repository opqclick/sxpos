<div class="pt-0 pb-3 modal-body invoice-module" id="printarea">
    <div class="mt-2 mb-2 text-black text-center fs-3">{{__('Sales')}}</div>

    <table class="table">
        <tbody>
            <tr>
                <td scope="row" class="p-0">
                    <span>{{ __('Date of Invoice') }}:</span>
                    <span class="ms-2 font-label">{{ $details['date'] }}</span>
                </td>
            </tr>
            <div class="invoice-to col-12 mt-4">
                {!! isset($details['customer']['name']) ? '' : $details['customer']['details'] !!}
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
            <div class="p-0"> {{ $value['name'] }}</div>
            <div class="d-flex product-border">
                <div>{{ __('Quantity:') }}</div>
                <div class="text-end ms-auto">{{ $value['quantity'] }}</div>
            </div>
        </div>

        <div class="d-flex product-border">
            <div>{{__('Price:')}}</div>
            <div class="text-end ms-auto">{{ $value['price'] }}</div>
        </div>
        <div class="d-flex product-border">
            <div>{{__('Tax:')}}</div>
            <div class="text-end ms-auto"> {{ $value['tax'] }}</div>
        </div>
        <div class="d-flex product-border mb-2">
            <div>{{__('Tax Amount:')}}</div>
            <div class="text-end ms-auto">{{ $value['tax_amount'] }}</div>
        </div>
        <div class="d-flex product-border mb-2">
            <div>{{__('Total:')}}</div>
            <div class="text-end ms-auto"> {{ $value['subtotal'] }}</div>
        </div>
    @endforeach

    <h5 class="text-center mt-3 font-label">{{__('Thank You For Shopping With Us. Please visit again.')}}</h5>


    {{-- <div class="text-center d-block" style="margin-left:65px;">{!! DNS2D::getBarcodeHTML(
        route('sale.link.copy', \Illuminate\Support\Facades\Crypt::encrypt($details['invoice_id'])),
        'QRCODE',
        2,
        2,
    ) !!}</div> --}}

    <div id="print_barcode" class="productbarcode"  style="padding-left: 33px;">
        {!! DNS1D::getBarcodeHTML('123456789', 'UPCA') !!} 
        {{-- {!! DNS1D::getBarcodeSVG('897879', 'C39',0.9,50,'black',true) !!} --}}
    </div>
   

</div>
<div class="justify-content-center pt-2 modal-footer">

    {{-- <button class="btn btn-sm btn-primary " type="submit"><a
            href="{{ route('sale.receipt', $details) }}">{{ __('Print') }}</a></button> --}}
    {{-- <a href="{{ route('sale.receipt', $details) }}" type="submit"
        class="btn btn-primary btn-sm text-right float-right mb-3 ">
        {{ __('Print') }}
    </a> --}}

    <button type="submit" id='btn' value='Print'
    class="btn btn-primary btn-sm text-right float-right mb-3 ">
    {{ __('Print') }}
</button>

   
</div>

<script>
    $("#btn").click(function () {
    var print_div = document.getElementById("printarea");
    $('.row').addClass('d-none');
    $('.toast').addClass('d-none');
    $('#btn').addClass('d-none');  
    $('#print_barcode').addClass('productbarcode_print');  
    window.print();
    $('.row').removeClass('d-none');
    $('#btn').removeClass('d-none');
    $('.toast').removeClass('d-none');
    $('#print_barcode').removeClass('productbarcode_print');
});
 </script>

