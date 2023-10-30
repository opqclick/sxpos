@php
$settings = Utility::settings();
@endphp
<div class="pt-0 pb-3 modal-body invoice-module" id="printarea">
    <div class="mt-2 mb-2 text-black text-center fs-3 border">{{$settings['company_name']}}</div>
    <div style="font-weight: bold;">{{ $details['invoice_id'] }}</div>
   
    <?php
     $settings['company_telephone'] = $settings['company_telephone'] != '' ? ", " . $settings['company_telephone'] : '';
     $settings['company_state'] = $settings['company_state'] != '' ? ", " . $settings['company_state'] : '';
    ?>   
    <div class="d-flex product-border">   
        <ul class="list-unstyled">
        <li>{!!$details['user']['name']!!}</li>
        <li>{!! $settings['company_name'] . $settings['company_telephone'] !!}</li>
        <li>{!! $settings['company_address'] !!}</li>
        <li>{!! $settings['company_city'] . $settings['company_state'] !!}</li>
        <li>{!! $settings['company_zipcode'] !!}</li>
        <li>{!! $settings['company_country'] !!}</li>
        </ul>       
    </div>
    <div class="d-flex product-border">
        <ul class="list-unstyled" style="margin-top:10px;">
            <li>{!! isset($details['customer']['name']) ? '' : $details['customer']['details'] !!}</li>
            <li>{!! isset($details['customer']['name']) ? 'Name:  ' . $details['customer']['name'] : '' !!}</li>
            <li>{!! isset($details['customer']['address']) ? 'Address:  ' . $details['customer']['address'] : '' !!}</li>
            <li>{!! isset($details['customer']['email']) ? 'Email:  ' . $details['customer']['email'] : '' !!}</li>
            <li> {!! isset($details['customer']['phone_number']) ? 'Phone:  ' . $details['customer']['phone_number'] : '' !!}</li>
            <span>{{ __('Date of Invoice') }}:</span>
            <span class="ms-2 font-label">{{ $details['date'] }}</span>
        </ul>
     </div>
     <h2 class="h5 font-weight-normal" style="margin-top:10px;">{{__('Items:')}}</h2>
   
    @foreach ($sales['data'] as $key => $value)
        <div>
            <h2 class="h6 font-weight-normal" style="margin-top:13px;"> {{ $value['name'] }}</h2>
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
    

    {{-- <div id="print_barcode" class="productbarcode"  style="padding-left: 33px;">
        {!! DNS1D::getBarcodeHTML('123456789', 'UPCA') !!} 
    </div>
    --}}

</div>
<div class="justify-content-center pt-2 modal-footer">

  
    <button type="submit" id='btn' value='Print'
    class="btn btn-primary btn-sm text-right float-right mb-3">
    {{ __('Print') }}
</button>

    
        
  
</div>
<script>
    $("#btn").click(function () {
    var print_div = document.getElementById("printarea");
    $('.row').addClass('d-none');
    $('.toast').addClass('d-none');
    $('#btn').addClass('d-none');  
   // $('#print_barcode').addClass('productbarcode_print');  
    window.print();
    $('.row').removeClass('d-none');
    // $('#btn').removeClass('d-none');
    $('.toast').removeClass('d-none');
   // $('#print_barcode').removeClass('productbarcode_print');
});
 </script>











 