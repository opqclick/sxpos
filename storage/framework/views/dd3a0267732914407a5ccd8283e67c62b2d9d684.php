
    <?php if(!empty($sales) && count($sales) > 0): ?>
        <div class="container">
            <div class="row invoice">
                <div class="col contacts d-flex justify-content-between pb-4">
                    <div class="invoice-to mt-4">
                        <div class="text-gray-light text-uppercase"><?php echo e(__('Invoice To:')); ?></div>
                        <?php echo $details['customer']['details']; ?>

                    </div>
                    <div class="company-details mt-4">
                        <div class="text-gray-light text-uppercase"><?php echo e(__('Invoice From:')); ?></div>
                        <?php echo $details['user']['details']; ?>

                    </div>
                </div>
                <div class="col invoice-details text-end">
                    <h1 class="invoice-id h4"><?php echo e($details['invoice_id']); ?></h1>
                    <div class="date mb-3"><?php echo e(__('Date of Invoice')); ?>: <?php echo e($details['date']); ?></div>
                    <?php if(Utility::getValByName('SITE_RTL') == 'on'): ?>
                        <div class="date mb-3 float-start"><?php echo DNS2D::getBarcodeHTML(
                            route('sale.link.copy', \Illuminate\Support\Facades\Crypt::encrypt($details['invoice_id'])),
                            'QRCODE',
                            2,
                            2,
                        ); ?></div>
                    <?php else: ?>
                        <div class="date mb-3 float-end"><?php echo DNS2D::getBarcodeHTML(
                            route('sale.link.copy', \Illuminate\Support\Facades\Crypt::encrypt($details['invoice_id'])),
                            'QRCODE',
                            2,
                            2,
                        ); ?></div>
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
                                <?php $__currentLoopData = $sales['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                    <td class="text-right font-weight-bold"><?php echo e($sales['total']); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <?php if($details['pay'] == 'show'): ?>
                        
                        <div class="row mb-2">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="row justify-content-end">
                                    <div class="col-auto">
                                        <label for="payment_method">Payment Method</label>
                                    </div>
                                    <div class="col-auto">
                                        <select name="payment_method" id="payment_method" class="form-control">
                                            <?php $__currentLoopData = \App\Models\Sale::PAYMENT_METHODS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <button class="btn btn-primary btn-done-payment btn-sm text-right float-right mb-3 " data-url="<?php echo e(route('sale.print')); ?>" data-ajax-popup="truee" data-size="sm"
                        data-bs-toggle="tooltip" data-title="<?php echo e(__('Invoice Sale')); ?>">
                        <?php echo e(__('Done Payment')); ?>

                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endif; ?>


<?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/sales/show.blade.php ENDPATH**/ ?>