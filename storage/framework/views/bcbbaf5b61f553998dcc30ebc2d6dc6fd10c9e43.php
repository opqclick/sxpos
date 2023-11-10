<?php
$currantLang = Auth::user()->lang;
$languages = \App\Models\Utility::languages();

$cust_theme_bg = App\Models\Utility::getValByName('cust_theme_bg');

?>



<?php if(isset($cust_theme_bg) && $cust_theme_bg == 'on'): ?>
    <header class="dash-header transprent-bg">
    <?php else: ?>
        <header class="dash-header">
<?php endif; ?>

<div class="header-wrapper">
    <div class="me-auto dash-mob-drp">
        <ul class="list-unstyled">
            <li class="dash-h-item mob-hamburger">
                <a href="#!" class="dash-head-link" id="mobile-collapse">
                    <div class="hamburger hamburger--arrowturn">
                        <div class="hamburger-box">
                            <div class="hamburger-inner"></div>
                        </div>
                    </div>
                </a>
            </li>
            <li class="dropdown dash-h-item drp-company">
                <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    
                    <span class="theme-avtar">
                        <img src="<?php echo e((!empty(\Auth::user()->avatar))?  \App\Models\Utility::get_file(\Auth::user()->avatar): asset(Storage::url("uploads/avatar/avatar.png"))); ?>" class="img-fluid rounded-circle">
                    </span>
                    <span class="hide-mob ms-2"><?php echo e('Hi, '); ?><?php echo e(ucfirst(Auth::user()->name)); ?></span>
                    <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                </a>



                <div class="dropdown-menu dash-h-dropdown">

                    <a href="<?php echo e(route('profile.display')); ?>" class="dropdown-item">
                        <i class="ti ti-user"></i>
                        <span><?php echo e(__('Profile')); ?></span>
                    </a>


                    <a href="<?php echo e(route('logout')); ?>" class="dropdown-item"
                        onclick="event.preventDefault(); document.getElementById('logout-form1').submit();">
                        <i class="ti ti-power"></i>
                        <span><?php echo e(__('Logout')); ?></span>
                        <?php echo Form::open(['method' => 'POST', 'id' => 'logout-form1', 'route' => ['logout'], 'style' => 'display:none']); ?>

                        <?php echo Form::close(); ?>

                    </a>
                </div>
            </li>

        </ul>
    </div>
    <div class="ms-auto">
        <ul class="list-unstyled">

            <li class="dropdown dash-h-item drp-language">
                <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ti ti-world nocolor"></i>
                    
                    <?php $__currentLoopData = App\Models\Utility::languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($currantLang == $code): ?>
                        <span class="drp-text hide-mob"><?php echo e(ucFirst($lang)); ?></span>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                </a>
                <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                    <?php $__currentLoopData = App\Models\Utility::languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('change.language', $code)); ?>"
                            class="dropdown-item <?php echo e($currantLang == $code ? 'text-primary' : ''); ?>">
                            <span><?php echo e(ucFirst($lang)); ?></span>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Language')): ?>
                        <hr class="dropdown-divider">
                            <a class="dropdown-item text-primary" data-ajax-popup="true"  
                            data-bs-toggle="tooltip"  data-bs-placement="top"
                            data-title="<?php echo e(__('Create New Language')); ?>" data-url="<?php echo e(route('create.language')); ?>"><?php echo e(__('Create language')); ?></a>
                    <?php endif; ?>

                    <hr class="dropdown-divider">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Language')): ?>
                        <a class="dropdown-item text-primary"
                            href="<?php echo e(route('manage.language', [isset($currantLang) ? $currantLang : 'en'])); ?>"><?php echo e(__('Manage language')); ?></a>
                    <?php endif; ?>
                </div>
            </li>

        </ul>
    </div>
</div>
</header>
<?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/header.blade.php ENDPATH**/ ?>