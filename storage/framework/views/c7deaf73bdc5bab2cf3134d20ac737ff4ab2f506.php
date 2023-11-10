<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Product Barcode Print')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__(' Product Barcode')); ?></li>
    <li class="breadcrumb-item"><?php echo e(__('Product Barcode Print')); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="<?php echo e(__('Back')); ?>">
            <i class="ti ti-arrow-left text-white"></i>
        </a>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php echo e(Form::open(array('route'=>'product.receipt','method'=>'post'))); ?>




                        <div class="row" id="printableArea">
                            
                            <div class="col-md-4">
                                <div class="form-group" id="product_div">
                                    <?php echo e(Form::label('product',__('product'),['class'=>'form-label'])); ?>

                                    <?php echo e(Form::select('product_id[]', $product,'', array('multiple'=>'true','class' => 'select2','id'=>'product_id','required'=>'required'))); ?>

                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <?php echo e(Form::label('quantity', __('Quantity'),['class'=>'form-label'])); ?><span class="text-danger">*</span>
                                <?php echo e(Form::text('quantity',null, array('class' => 'form-control','required'=>'required'))); ?>

                            </div>
                        </div>

                        <div class="col-md-6 pt-4">

                            <button class="btn btn-sm btn-primary btn-icon" type="submit"><?php echo e(__('Print')); ?></button>


                        </div>

                    <?php echo e(Form::close()); ?>


                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/products/print.blade.php ENDPATH**/ ?>