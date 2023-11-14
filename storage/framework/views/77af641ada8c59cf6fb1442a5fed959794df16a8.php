<?php $__env->startSection('page-title', __('Account List')); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Account List')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Branch')): ?>
        <button type="button" class="btn btn-sm btn-primary btn-icon " data-bs-toggle="tooltip" data-ajax-popup="true"
            data-title="<?php echo e(__('Add New Account')); ?>" data-url="<?php echo e(route('accounts.create')); ?>"
            title="<?php echo e(__('Add Account')); ?>">
            <span class=""><i class="ti ti-plus text-white"></i></span>
        </button>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Accounts')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Branch')): ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header card-body table-border-style">

                        <div class="table-responsive">
                            <table class="table" id="pc-dt-simple" role="grid">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('Name')); ?></th>
                                        <th><?php echo e(__('Ref')); ?></th>
                                        <th><?php echo e(__('Type')); ?></th>
                                        <th width="200px"><?php echo e(__('Action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($key + 1); ?></td>
                                            <td><?php echo e($account->name); ?></td>
                                            <td><?php echo e($account->ref); ?></td>
                                            <td><?php echo e($account->type_name); ?></td>
                                            </td>
                                            <td class="Action">
                                                
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" data-ajax-popup="true" data-title="<?php echo e(__('Edit Account')); ?>"
                                                            title="<?php echo e(__('Edit')); ?>" data-bs-toggle="tooltip"
                                                            data-url="<?php echo e(route('accounts.edit', $account->id)); ?>"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                
                                                
                                                    <div class="action-btn bg-danger ms-2">
                                                        <a href="#"
                                                            class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center"
                                                            data-toggle="sweet-alert" data-bs-toggle="tooltip"
                                                            data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                            title="<?php echo e(__('Delete')); ?>"
                                                            data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                            data-confirm-yes="delete-form-<?php echo e($account->id); ?>">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>
                                                    </div>
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['accounts.destroy', $account->id], 'id' => 'delete-form-' . $account->id]); ?>

                                                    <?php echo Form::close(); ?>

                                                
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/accounts/index.blade.php ENDPATH**/ ?>