<?php $__env->startSection('page-title', __('Brands List')); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Brands List')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Brand')): ?>
        <a href="#" data-ajax-popup="true" data-size="md" data-title="<?php echo e(__('Add New Brand')); ?>"
            data-url="<?php echo e(route('brands.create')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Add Brand')); ?>"
            class="btn btn-sm btn-primary btn-icon">
            <span class=""><i class="ti ti-plus text-white"></i></span>
        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Brands')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Brand')): ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table" id="pc-dt-simple">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('Brand Name')); ?></th>
                                        <th width="200px"><?php echo e(__('Action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($key + 1); ?></td>
                                            <td><?php echo e($brand->name); ?></td>
                                            <td class="Action">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Brand')): ?>
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" data-ajax-popup="true" data-bs-toggle="tooltip"
                                                            data-title="<?php echo e(__('Edit Brand')); ?>" title="<?php echo e(__('Edit Brand')); ?>"
                                                            data-size="md" data-url="<?php echo e(route('brands.edit', $brand->id)); ?>"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Brand')): ?>
                                                    <div class="action-btn bg-danger ms-2">
                                                        <a href="#"
                                                            class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center"
                                                            data-toggle="sweet-alert" data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                            data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                            data-bs-toggle="tooltip"
                                                            data-confirm-yes="delete-form-<?php echo e($brand->id); ?>"
                                                            title="<?php echo e(__('Delete')); ?>">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>



                                                    </div>
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['brands.destroy', $brand->id], 'id' => 'delete-form-' . $brand->id]); ?>

                                                    <?php echo Form::close(); ?>

                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/brands/index.blade.php ENDPATH**/ ?>