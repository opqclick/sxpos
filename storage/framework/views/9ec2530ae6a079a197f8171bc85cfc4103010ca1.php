
<?php $__env->startPush('scripts'); ?>
    
<?php $__env->stopPush(); ?>

<?php if( !empty($purchases) && count($purchases) > 0): ?>
    <div class="container">
        <div class="row invoice">
            <div class="col contacts d-flex justify-content-between pb-4">
                <div class="invoice-to mt-4">
                    <div class="text-gray-light text-uppercase"><?php echo e(__('Invoice From:')); ?></div>
                    <?php echo $details['vendor']['details']; ?>

                </div>
                <div class="company-details mt-4">
                    <div class="text-gray-light text-uppercase"><?php echo e(__('Invoice To:')); ?></div>
                    <?php echo $details['user']['details']; ?>

                </div>
            </div>
            <div class="col invoice-details text-end">
                <h1 class="invoice-id h4"><?php echo e($details['invoice_id']); ?></h1>
                <div class="date mb-3"><?php echo e(__('Date of Invoice')); ?>: <?php echo e($details['date']); ?></div>
                <?php if(Utility::getValByName('SITE_RTL') == 'on'): ?>
                    <div class="date mb-3 float-start"><?php echo DNS2D::getBarcodeHTML(route('purchase.link.copy',\Illuminate\Support\Facades\Crypt::encrypt($details['invoice_id'])),'QRCODE',2,2); ?></div>
                <?php else: ?>
                    <div class="date mb-3 float-end"><?php echo DNS2D::getBarcodeHTML(route('purchase.link.copy',\Illuminate\Support\Facades\Crypt::encrypt($details['invoice_id'])),'QRCODE',2,2); ?></div>
                <?php endif; ?>
             <span class="clearfix" style="clear: both; display: block;"></span>
            </div>
        </div>
        
       
        <div class="row invoice">
            
            <div class="col-12 col-md-12">
                <div class="table-responsive invoice-table">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="text-left"><?php echo e(__('Items')); ?></th>
                            <th><?php echo e(__('Quantity')); ?></th>
                            <th class="text-right"><?php echo e(__('Price')); ?></th>
                            <th class="text-right"><?php echo e(__('Tax')); ?></th>
                            <th class="text-right"><?php echo e(__('Tax Amount')); ?></th>
                            <th class="text-right"><?php echo e(__('Total')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $total = 0 ?>
                        <?php $__currentLoopData = $purchases['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="cart-summary-table text-left">
                                    <?php echo e($value['name']); ?>

                                </td>
                                <td class="cart-summary-table">
                                    <?php echo e($value['quantity']); ?>

                                </td>
                                <td class="text-right cart-summary-table">
                                    <?php echo e($value['price']); ?>

                                </td>
                                <td class="text-right cart-summary-table">
                                    <?php echo e($value['tax']); ?>

                                </td>
                                <td class="text-right cart-summary-table">
                                    <?php echo e($value['tax_amount']); ?>

                                </td>
                                <td class="text-right cart-summary-table">
                                    <?php echo e($value['subtotal']); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td class="text-left font-weight-bold"><?php echo e(__('Total')); ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right font-weight-bold"><?php echo e($purchases['total']); ?></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <?php if($details['pay'] == 'show'): ?>
                    <button class="btn btn-primary btn-done-payment rounded mb-3 float-right" data-url="<?php echo e(route('purchases.store')); ?>"><?php echo e(__('Done Payment')); ?></button>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/purchases/show.blade.php ENDPATH**/ ?>