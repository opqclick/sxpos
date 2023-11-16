<?php
$profile = asset(Storage::url('uploads/avatar/'));
?>
<?php $__env->startPush('css-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300
        })
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Profile')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"> <?php echo e(__('Profile')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Profile')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top" style="top:30px">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <a href="#useradd-1" class="list-group-item list-group-item-action border-0"><?php echo e(__('Personal Information')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#useradd-2"
                                class="list-group-item list-group-item-action border-0"><?php echo e(__('Change Password')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                          
                        </div>
                    </div>
                </div>


                <div class="col-xl-9">
                    <div id="useradd-1">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><?php echo e(__('Personal Information')); ?></h5>
                                <small> <?php echo e(__('Details about your personal information')); ?></small>
                            </div>
                            <div class="card-body">
                                <?php echo e(Form::model($user, ['route' => ['profile.upload'], 'enctype' => 'multipart/form-data'])); ?>

                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label text-dark"><?php echo e(__('Name')); ?></label>
                                            <input class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name"
                                                type="text" id="fullname" placeholder="<?php echo e(__('Enter Your Name')); ?>"
                                                value="<?php echo e($user->name); ?>" required autocomplete="name">
                                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="email" class="col-form-label text-dark"><?php echo e(__('Email')); ?></label>
                                            <input class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email"
                                                type="text" id="email" placeholder="<?php echo e(__('Enter Your Email Address')); ?>"
                                                value="<?php echo e($user->email); ?>" required autocomplete="email">
                                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <div class="choose-files ">
                                                <label for="avatar">
                                                    <div class="d-flex align-items-center">
                                                    <div class="bg-primary profile_update nowrap"> 
                                                        <i class="ti ti-upload px-1"></i>
                                                        <?php echo e(__('Choose file here')); ?>

                                                    </div>
                                                    <div class="action-btn bg-danger ms-2">
                                                        <a class="btn btn-sm d-inline-flex align-items-center"
                                                            onclick="document.getElementById('delete_avatar').submit();">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <input type="file" class="form-control file d-none" name="profile"
                                                id="avatar" data-filename="profile_update">
                                                </label>
                                            </div>
                                            <span
                                                class="text-xs text-muted"><?php echo e(__('Please upload a valid image file. Size of image should not be more than 2MB.')); ?></span>
                                            <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback text-danger text-xs"
                                                    role="alert"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                          
                                        </div>

                                    </div>
                                    <div class="col-lg-12 text-end">
                                        <input type="submit" value="<?php echo e(__('Save Changes')); ?>"
                                            class="btn btn-print-invoice  btn-primary m-r-10">
                                    </div>
                                </div>
                                </form>
                           
                                <?php echo e(Form::close()); ?>

                            </div>
                            <?php echo Form::open(['method' => 'DELETE', 'id' => 'delete_avatar', 'route' => ['profile.delete']]); ?>

                            <?php echo Form::close(); ?>

                        </div>
                    </div>

                    <div id="useradd-2">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><?php echo e(__('Change Password')); ?></h5>
                                <small> <?php echo e(__('Details about your account password change')); ?></small>
                            </div>
                            <div class="card-body">
                                <?php echo e(Form::open(['route' => 'update.password', 'method' => 'POST'])); ?>


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="current_password"
                                            class="col-form-label text-dark"><?php echo e(__('Current Password')); ?></label>
                                        <input class="form-control" name="current_password" type="password"
                                            id="current_password" required autocomplete="current_password"
                                            placeholder="<?php echo e(__('Enter Current Password')); ?>">
                                        <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-current_password" role="alert">
                                                <strong class="text-danger"><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="password" class="form-label col-form-label text-dark"><?php echo e(__('New Password')); ?></label>
                                            <input class="form-control" name="password" type="password" id="password" required
                                                autocomplete="password" placeholder="<?php echo e(__('Enter New Password')); ?>">
                                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-password" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                             <label for="confirm_password"
                                        class="form-label col-form-label text-dark"><?php echo e(__('Confirm Password')); ?></label>
                                    <input class="form-control" name="confirm_password" type="password"
                                        id="confirm_password" required autocomplete="confirm_password"
                                        placeholder="<?php echo e(__('Confirm New Password')); ?>">
                                    <?php $__errorArgs = ['confirm_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-confirm_password" role="alert">
                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer pr-0">
                                    <?php echo e(Form::submit(__('Update'), ['class' => 'btn  btn-primary'])); ?>

                                </div>
                                <?php echo e(Form::close()); ?>

                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300,

        })
        $(".list-group-item").click(function() {
            $('.list-group-item').filter(function() {
                return this.href == id;
            }).parent().removeClass('text-primary');
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/users/profile.blade.php ENDPATH**/ ?>