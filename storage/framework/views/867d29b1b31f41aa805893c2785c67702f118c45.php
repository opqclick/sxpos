<?php $__env->startSection('page-title', __('Branches List')); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Branches List')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Branch')): ?>
        <button type="button" class="btn btn-sm btn-primary btn-icon " data-bs-toggle="tooltip" data-ajax-popup="true"
            data-title="<?php echo e(__('Add New Branch')); ?>" data-url="<?php echo e(route('branches.create')); ?>"
            title="<?php echo e(__('Add Branch')); ?>">
            <span class=""><i class="ti ti-plus text-white"></i></span>
        </button>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Settings')); ?></li>
    <li class="breadcrumb-item"><?php echo e(__('Branches')); ?></li>
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
                                        <th><?php echo e(__('Branch Type')); ?></th>
                                        <th><?php echo e(__('Branch Manager')); ?> </th>
                                        <th><?php echo e(__('Cash Register')); ?></th>
                                        <th width="200px"><?php echo e(__('Action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($key + 1); ?></td>
                                            <td><?php echo e($branch->name); ?></td>
                                            <td><?php echo e($branch->branch_type); ?></td>
                                            <td><?php echo e(ucfirst($branch->username)); ?></td>
                                            <td><?php echo e($branch->branchtotal > 0 ? 'Yes (' . $branch->branchtotal . ')' : 'No'); ?>

                                            </td>
                                            <td class="Action">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Branch')): ?>
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" data-ajax-popup="true" data-title="<?php echo e(__('Edit Branch')); ?>"
                                                            title="<?php echo e(__('Edit')); ?>" data-bs-toggle="tooltip"
                                                            data-url="<?php echo e(route('branches.edit', $branch->id)); ?>"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Branch')): ?>
                                                    <div class="action-btn bg-danger ms-2">
                                                        <a href="#"
                                                            class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center"
                                                            data-toggle="sweet-alert" data-bs-toggle="tooltip"
                                                            data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                            title="<?php echo e(__('Delete')); ?>"
                                                            data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                            data-confirm-yes="delete-form-<?php echo e($branch->id); ?>">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>
                                                    </div>
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['branches.destroy', $branch->id], 'id' => 'delete-form-' . $branch->id]); ?>

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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/branches/index.blade.php ENDPATH**/ ?>