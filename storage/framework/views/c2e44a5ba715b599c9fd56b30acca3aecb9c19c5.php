<?php
    $setting = App\Models\Utility::settings();
?>
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="<?php echo e($setting['SITE_RTL'] == 'on' ? 'rtl' : ''); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://fonts.googleapis.com/css?family=Lato&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <?php if($setting['SITE_RTL'] == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-rtl.css')); ?>">
    <?php endif; ?>
    <style type="text/css">
        :root {
            --theme-color: #003580;
            --white: #ffffff;
            --black: #000000;
        }

        body {
            font-family: 'Lato', sans-serif;
        }

        p,
        li,
        ul,
        ol {
            margin: 0;
            padding: 0;
            list-style: none;
            line-height: 1.5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table tr th {
            padding: 0.75rem;
            text-align: left;
        }

        table tr td {
            padding: 0.75rem;
            text-align: left;
        }

        table th small {
            display: block;
            font-size: 12px;
        }

        .invoice-preview-main {
            max-width: 700px;
            width: 160%;
            /* width: 120%; */
            margin: 0 auto;
            background: #ffff;
            box-shadow: 0 0 10px #ddd;
        }

        .invoice-logo {
            max-width: 200px;
            width: 100%;
        }

        .invoice-header table td {
            padding: 15px 30px;
        }

        .text-right {
            text-align: right;
        }

        .no-space tr td {
            padding: 0;
        }

        .vertical-align-top td {
            vertical-align: top;
        }

        .view-qrcode {
            max-width: 114px;
            height: 114px;
            margin-left: auto;
            margin-top: 15px;
            background: var(--white);
        }

        .view-qrcode img {
            width: 100%;
            height: 100%;
        }

        .invoice-body {
            padding: 30px 25px 0;
        }

        table.add-border tr {
            border-top: 1px solid var(--theme-color);
        }

        tfoot tr:first-of-type {
            border-bottom: 1px solid var(--theme-color);
        }

        .total-table tr:first-of-type td {
            padding-top: 0;
        }

        .total-table tr:first-of-type {
            border-top: 0;
        }

        .sub-total {
            padding-right: 0;
            padding-left: 0;
        }

        .border-0 {
            border: none !important;
        }

        .invoice-summary td,
        .invoice-summary th {
            font-size: 13px;
            font-weight: 600;
        }

        .total-table td:last-of-type {
            width: 146px;
        }

        .invoice-footer {
            padding: 15px 20px;
        }

        .itm-description td {
            padding-top: 0;
        }

        html[dir="rtl"] table tr td,
        html[dir="rtl"] table tr th {
            text-align: right;
        }

        html[dir="rtl"] .text-right {
            text-align: left;
        }

        html[dir="rtl"] .view-qrcode {
            margin-left: 0;
            margin-right: auto;
        }

        p:not(:last-of-type) {
            margin-bottom: 15px;
        }

        .invoice-summary p {
            margin-bottom: 0;
        }
    </style>
</head>

<body>
<div class="table-responsive">
    <div class="invoice-preview-main" id="boxes">
        <div class="invoice-header" style="background: <?php echo e($color); ?>;color:<?php echo e($font_color); ?>" >
            <table>
                <tbody>
                    <tr>
                        <td>
                            <img src="<?php echo e($img); ?>" style="max-width: 250px" />
                        </td>
                        <td class="text-right">
                            <h3 style="text-transform: uppercase; font-size: 40px; font-weight: bold;">PURCHASE</h3>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="vertical-align-top">
                <tbody>
                    <tr>
                        <td>
                            <strong><?php echo e(__('From')); ?>:</strong>
                            <p>
                                <?php if($settings['company_name']): ?>
                                    <?php echo e($settings['company_name']); ?>

                                <?php endif; ?>
                                <br>
                                <?php if($settings['company_address']): ?>
                                    <?php echo e($settings['company_address']); ?>

                                <?php endif; ?>
                                <?php if($settings['company_city']): ?>
                                    <br> <?php echo e($settings['company_city']); ?>,
                                <?php endif; ?>
                                <?php if($settings['company_state']): ?>
                                    <?php echo e($settings['company_state']); ?>

                                <?php endif; ?>
                                <?php if($settings['company_zipcode']): ?>
                                    - <?php echo e($settings['company_zipcode']); ?>

                                <?php endif; ?>
                                <?php if($settings['company_country']): ?>
                                    <br><?php echo e($settings['company_country']); ?>

                                <?php endif; ?>
                                <?php if($settings['tax_type'] == 'VAT'): ?>
                                    <br><?php echo e(__('VAT Number : ')); ?><?php echo e($settings['vat_number']); ?>

                                <?php elseif($settings['tax_type'] == 'GST'): ?>
                                    <br><?php echo e(__('GST Number : ')); ?><?php echo e($settings['vat_number']); ?>

                                <?php endif; ?>
                            </p>
                        </td>
                        <td>
                            <table class="no-space">
                                <tbody>
                                    <tr>
                                        <td>Number: </td>
                                        <td class="text-right">
                                            <?php echo e($user->purchaseInvoiceNumberFormat($purchase->invoice_id)); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Issue Date:</td>
                                        <td class="text-right">
                                            <?php echo e($user->dateFormat($purchase->created_at)); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="view-qrcode">
                                                <?php echo DNS2D::getBarcodeHTML(route('purchase.link.copy',\Illuminate\Support\Facades\Crypt::encrypt($purchase->id)),'QRCODE',2,2); ?>

                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="invoice-body">
            <table>
                <tbody>
                    <tr>
                        <td>
                            <strong style="margin-bottom: 10px; display:block;">Bill To:</strong>
                            
                            <?php if(isset($vendordetails) && !empty($vendordetails)): ?>
                                <p>
                                    <?php $__currentLoopData = $vendordetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo e($detail); ?> <br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </p>
                            <?php else: ?>
                                <p> - </p>
                            <?php endif; ?>
                        </td>
                        
                    </tr>
                </tbody>
            </table>
            <table class="add-border invoice-summary" style="margin-top: 30px;">
                <thead style="background: <?php echo e($color); ?>;color:<?php echo e($font_color); ?>">
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Tax (%)</th>
                        <th>Tax Amount</th>
                        <th>Total <small>before tax</small></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($purchase->items) && count($purchase->items) > 0): ?>
                    <?php $i=0; ?>
                        <?php $__currentLoopData = $purchase->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr style="border-bottom:1px solid <?php echo e(($color == '#ffffff') ? 'black' : $color); ?>;">
                                <td><?php echo e($item->name); ?></td>
                                <td><?php echo e($item->quantity); ?></td>
                                <td><?php echo e($item->price); ?></td>
                                <td>
                                    
                                    <?php echo e($item->tax); ?>

                                </td>
                                
                                <td><?php echo e($item->tax_amount); ?></td>
                                <td>  <?php echo e(\App\Models\Utility::priceFormat($settings, $p_total[$i++])); ?>

                                    
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total</td>
                        <td><?php echo e($totalquantity); ?></td>
                        <td></td>
                        <td></td>
                        <td><?php echo e(\App\Models\Utility::priceFormat($settings, $totaltax)); ?></td>
                        <td><?php echo e(\App\Models\Utility::priceFormat($settings, $product_total)); ?></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td colspan="2" class="sub-total">
                            <table class="total-table">
                                

                                
                                    
                                <tr>
                                    <td><?php echo e(__('Tax')); ?> :</td>
                                    <td style="width: 95px;"><?php echo e(\App\Models\Utility::priceFormat($settings, $totaltax)); ?></td>
                                </tr>
                                    
                                                                
                                <tr>
                                    <td><b><?php echo e(__('Total')); ?> :</b></td>
                                    <td style="width: 95px;"><b><?php echo e($purchase->subtotal); ?></b>
                                        
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                </tfoot>
            </table>
                <div class="d-header-50">
                    <p>
                        <b><?php echo e($settings['invoice_footer_title']); ?></b><br>
                        <?php echo e($settings['invoice_footer_notes']); ?>

                    </p>
                </div>
        </div>
    </div>
    <?php if(!isset($preview)): ?>
    <?php echo $__env->make('purchases.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
</div>
</body>

</html>




<?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/purchases/templates/template1.blade.php ENDPATH**/ ?>