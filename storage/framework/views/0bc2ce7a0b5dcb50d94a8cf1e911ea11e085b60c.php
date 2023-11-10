<?php
$settings = Utility::settings();
?>
<div class="pt-0 pb-3 modal-body invoice-module" id="printarea">
    <div class="mt-2 mb-2 text-black text-center fs-3 border"><?php echo e($settings['company_name']); ?></div>
    <div style="font-weight: bold;"><?php echo e($details['invoice_id']); ?></div>
   
    <?php
     $settings['company_telephone'] = $settings['company_telephone'] != '' ? ", " . $settings['company_telephone'] : '';
     $settings['company_state'] = $settings['company_state'] != '' ? ", " . $settings['company_state'] : '';
    ?>   
    <div class="d-flex product-border">   
        <ul class="list-unstyled">
        <li><?php echo $details['user']['name']; ?></li>
        <li><?php echo $settings['company_name'] . $settings['company_telephone']; ?></li>
        <li><?php echo $settings['company_address']; ?></li>
        <li><?php echo $settings['company_city'] . $settings['company_state']; ?></li>
        <li><?php echo $settings['company_zipcode']; ?></li>
        <li><?php echo $settings['company_country']; ?></li>
        </ul>       
    </div>
    <div class="d-flex product-border">
        <ul class="list-unstyled" style="margin-top:10px;">
            <li><?php echo isset($details['customer']['name']) ? '' : $details['customer']['details']; ?></li>
            <li><?php echo isset($details['customer']['name']) ? 'Name:  ' . $details['customer']['name'] : ''; ?></li>
            <li><?php echo isset($details['customer']['address']) ? 'Address:  ' . $details['customer']['address'] : ''; ?></li>
            <li><?php echo isset($details['customer']['email']) ? 'Email:  ' . $details['customer']['email'] : ''; ?></li>
            <li> <?php echo isset($details['customer']['phone_number']) ? 'Phone:  ' . $details['customer']['phone_number'] : ''; ?></li>
            <span><?php echo e(__('Date of Invoice')); ?>:</span>
            <span class="ms-2 font-label"><?php echo e($details['date']); ?></span>
        </ul>
     </div>
     <h2 class="h5 font-weight-normal" style="margin-top:10px;"><?php echo e(__('Items:')); ?></h2>
   
    <?php $__currentLoopData = $sales['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div>
            <h2 class="h6 font-weight-normal" style="margin-top:13px;"> <?php echo e($value['name']); ?></h2>
            <div class="d-flex product-border">
                <div><?php echo e(__('Quantity:')); ?></div>
                <div class="text-end ms-auto"><?php echo e($value['quantity']); ?></div>
            </div>
        </div>

        <div class="d-flex product-border">
            <div><?php echo e(__('Price:')); ?></div>
            <div class="text-end ms-auto"><?php echo e($value['price']); ?></div>
        </div>
        <div class="d-flex product-border">
            <div><?php echo e(__('Tax:')); ?></div>
            <div class="text-end ms-auto"> <?php echo e($value['tax']); ?></div>
        </div>
        <div class="d-flex product-border mb-2">
            <div><?php echo e(__('Tax Amount:')); ?></div>
            <div class="text-end ms-auto"><?php echo e($value['tax_amount']); ?></div>
        </div>
        <div class="d-flex product-border mb-2">
            <div><?php echo e(__('Total:')); ?></div>
            <div class="text-end ms-auto"> <?php echo e($value['subtotal']); ?></div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <h5 class="text-center mt-3 font-label"><?php echo e(__('Thank You For Shopping With Us. Please visit again.')); ?></h5>
    

    

</div>
<div class="justify-content-center pt-2 modal-footer">

  
    <button type="submit" id='btn' value='Print'
    class="btn btn-primary btn-sm text-right float-right mb-3">
    <?php echo e(__('Print')); ?>

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











 <?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/sales/print.blade.php ENDPATH**/ ?>