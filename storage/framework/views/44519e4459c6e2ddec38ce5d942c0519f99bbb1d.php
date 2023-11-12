<?php $__env->startSection('page-title', __('Users List')); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Users List')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>

    <a class="btn btn-sm btn-primary grid" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Grid View')); ?>">
        <i class="ti ti-layout-grid text-white"></i>
    </a>

    <a class="btn btn-sm btn-primary list" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('List View')); ?>">
        <i class="ti ti-list-check text-white"></i>
    </a>


    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create User')): ?>
        <a href="#" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="<?php echo e(__('Add User')); ?>"
            data-title="<?php echo e(__('Add User')); ?>" data-url="<?php echo e(route('users.create')); ?>" class="btn btn-sm btn-primary btn-icon m-1">
            <span class=""><i class="ti ti-plus text-white"></i></span>
        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Users List')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section class="section list_view" style="display:none">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage User')): ?>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header card-body table-border-style">
                            <div class="table-responsive">
                                <table class="table" id="pc-dt-simple">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo e(__('Name')); ?></th>
                                            <th><?php echo e(__('Email')); ?></th>
                                            <th><?php echo e(__('Date/Time Added')); ?> </th>
                                            <th><?php echo e(__('Lastlogin')); ?></th>
                                            <th><?php echo e(__('Total Users')); ?></th>
                                            <th><?php echo e(__('User Role')); ?></th>
                                            <th width="200px"><?php echo e(__('Action')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       
                                            <tr>
                                                <td><?php echo e($key + 1); ?></td>
                                                <td><?php echo e(ucfirst($user->name)); ?></td>
                                                <td><?php echo e($user->email); ?></td>
                                                <td><?php echo e(Auth::user()->datetimeFormat($user->created_at)); ?></td>
                                                <td><?php echo e($user->last_login_at); ?></td>
                                                <td><?php echo e($user->users); ?></td>
                                                <td>
                                                    <?php $__currentLoopData = $user->roles()->pluck('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pername): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    
                                                        <span
                                                            class="badge bg-success p-2 px-3 rounded"><?php echo e($pername); ?></span>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </td>
                                                

                                                <td class="Action">
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit User')): ?>
                                                        <div class="action-btn bg-info ms-2">
                                                            <a href="#" data-ajax-popup="true" data-bs-toggle="tooltip"
                                                                data-title="<?php echo e(__('Edit User')); ?>" title="<?php echo e(__('Edit')); ?>"
                                                                data-size="lg" data-url="<?php echo e(route('users.edit', $user->id)); ?>"
                                                                class="mx-3 btn btn-sm d-inline-flex align-items-center">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>

                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete User')): ?>
                                                        <div
                                                            class="action-btn <?php echo e($user->is_active == 1 ? 'bg-success' : 'bg-danger'); ?> ms-2 ">
                                                            <a href="#" data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                                data-text="Do you want to continue?" data-bs-toggle="tooltip"
                                                                data-confirm-yes="status-form-<?php echo e($user->id); ?>"
                                                                class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center">
                                                                <?php if($user->is_active == 1): ?>
                                                                    <i class="ti ti-user-check text-white" data-bs-toggle="tooltip"
                                                                        title="<?php echo e(__('Active')); ?>"
                                                                        data-title="<?php echo e(__('Active')); ?>"></i>
                                                                <?php else: ?>
                                                                    <i class="ti ti-user-x text-white" data-bs-toggle="tooltip"
                                                                        title="<?php echo e(__('Deactive')); ?>"
                                                                        data-title="<?php echo e(__('Deactive')); ?>"></i>
                                                                <?php endif; ?>
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>

                                                    <?php if(Auth::user()->isOwner()): ?>
                                                        <div class="action-btn bg-secondary ms-2">
                                                            <a href="#"
                                                                class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                data-url="<?php echo e(route('user.reset', \Crypt::encrypt($user->id))); ?>"
                                                                data-ajax-popup="true" data-bs-toggle="tooltip"
                                                                title="<?php echo e(__('Reset Password')); ?>" data-toggle="tooltip"
                                                                data-title="<?php echo e(__('Reset Password')); ?>"><i
                                                                    class="ti ti-key text-white"></i> </a>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php echo Form::open(['method' => 'PATCH', 'route' => ['user.status', $user->id], 'id' => 'status-form-' . $user->id]); ?>

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
    </section>

    <section class="section grid_view">
        <div class="row mt-3">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage User')): ?>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-xl-3">

                        <div class="card  text-center">
                            <div class="card-header border-0 pb-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        

                                        <?php if(Auth::user()->isOwner()): ?>
                                            <?php $__currentLoopData = $user->roles()->pluck('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pername): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="badge p-2 px-3 rounded bg-primary"><?php echo e($pername); ?></div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?> 

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete User')): ?>
                                        <div class="action-btn <?php echo e($user->is_active == 1 ? 'bg-success' : 'bg-danger'); ?> ms-2 ">
                                            <a href="#" data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                data-text="Do you want to continue?" data-bs-toggle="tooltip"
                                                data-confirm-yes="status-form-<?php echo e($user->id); ?>"
                                                class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center">
                                                <?php if($user->is_active == 1): ?>
                                                    <i class="ti ti-user-check text-white" data-bs-toggle="tooltip"
                                                        title="<?php echo e(__('Active')); ?>" data-title="<?php echo e(__('Active')); ?>"></i>
                                                <?php else: ?>
                                                    <i class="ti ti-user-x text-white" data-bs-toggle="tooltip"
                                                        title="<?php echo e(__('Deactive')); ?>" data-title="<?php echo e(__('Deactive')); ?>"></i>
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    </h6>
                                </div>
                                <div class="card-header-right">
                                    <div class="btn-group card-option">
                                        <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="feather icon-more-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit User')): ?>
                                                <a href="#" class="dropdown-item"
                                                    data-url="<?php echo e(route('users.edit', $user->id)); ?>" data-size="md"
                                                    data-ajax-popup="true" data-title="<?php echo e(__('Update User')); ?>"><i
                                                        class="ti ti-pencil"></i><span class="ms-2"><?php echo e(__('Edit')); ?></span></a>
                                            <?php endif; ?>

                                            <?php if(Auth::user()->isOwner()): ?>
                                                <a href="#" class="dropdown-item" data-ajax-popup="true" data-size="md"
                                                    data-title="<?php echo e(__('Change Password')); ?>"
                                                    data-url="<?php echo e(route('user.reset', \Crypt::encrypt($user->id))); ?>"><i
                                                        class="ti ti-key"></i>
                                                    <span class="ms-1"><?php echo e(__('Reset Password')); ?></span></a>
                                            <?php endif; ?>
                                            <?php echo Form::open(['method' => 'PATCH', 'route' => ['user.status', $user->id], 'id' => 'status-form-' . $user->id]); ?>

                                            <?php echo Form::close(); ?>


                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card-body">
                                <div class="avatar">

                                    <div class="avtar">
                                        <a class="theme-avtar rounded-circle"href="<?php echo e(asset(Storage::url("avatar/")).'/'); ?><?php echo e(!empty($user->avatar)?$user->avatar:'avatar.png'); ?>" target="_blank">
                                            <img alt="" alt="wid-75 rounded-circle grid-img" src="<?php echo e(asset(Storage::url("avatar/")).'/'); ?><?php echo e(!empty($user->avatar)?$user->avatar:'avatar.png'); ?>"  class="img-fluid rounded-circle wid-75 rounded-circle grid-img">
                                        </a>
                                        
                                    </div>
                                </div>

                                <h4 class="mt-2"><?php echo e($user->name); ?></h4>

                                <small><?php echo e($user->email); ?></small>

                                <div class="row">
                                    <p class="mt-1 mb-0">
                                        <button class="btn btn-sm btn-neutral font-weight-500">
                                            <a><?php echo e(__('Users : ')); ?>

                                                <?php echo e($user->users); ?></a>
                                        </button>
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create User')): ?>
                    <div class="col-xl-3 col-lg-4 col-sm-4">
                        <a href="#" class="btn-addnew-project  " data-ajax-popup="true"
                            data-url="<?php echo e(route('users.create')); ?>"
                            data-title="<?php if(Auth::user()->parent_id == 0): ?> <?php echo e(__('Add User')); ?> <?php else: ?> <?php echo e(__('Add User')); ?> <?php endif; ?>"
                            data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
                            data-bs-original-title="<?php echo e(__('Create')); ?>">
                            <div class="badge bg-primary proj-add-icon">
                                <i class="ti ti-plus"></i>
                            </div>
                            <h6 class="mt-4 mb-2">
                                <?php if(Auth::user()->parent_id == 0): ?>
                                    <?php echo e(__('Add User')); ?>

                                <?php else: ?>
                                    <?php echo e(__('Add User')); ?>

                                <?php endif; ?>
                            </h6>

                            <p class="text-muted text-center">
                                <?php if(Auth::user()->parent_id == 0): ?>
                                    <?php echo e(__('Click here to add new User')); ?>

                                <?php else: ?>
                                    <?php echo e(__('Click here to add new User')); ?>

                                <?php endif; ?>
                            </p>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>


        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function() {

            $(".grid").hide();
            $(".grid").click(function() {
                $(".grid_view").show();
                $(".list_view").hide();
                $(".list").show();
                $(".grid").hide();
            });

            $(".list").click(function() {
                $(".grid").show();
                $(".list_view").show();
                $(".grid_view").hide();
                $(".list").hide();
                $(".grid").show();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).on('change', '#branch_id', function(e) {
            $.ajax({
                url: '<?php echo e(route('get.cash.registers')); ?>',
                dataType: 'json',
                data: {
                    'branch_id': $(this).val()
                },
                success: function(data) {
                    $('#cash_register_id').find('option').not(':first').remove();
                    $.each(data, function(key, value) {
                        $('#cash_register_id')
                            .append($("<option></option>")
                                .attr("value", value.id)
                                .text(value.name));
                    });
                },
                error: function(data) {
                    data = data.responseJSON;
                    show_toastr('<?php echo e(__('Error')); ?>', data.message, 'error');;
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/users/index.blade.php ENDPATH**/ ?>