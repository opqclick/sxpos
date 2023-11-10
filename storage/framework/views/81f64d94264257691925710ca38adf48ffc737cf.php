<li class="dash-item dash-hasmenu <?php echo e((Request::route()->getName() == 'landingpage.index' || Request::segment(1) == 'custom_page'|| Request::segment(1) == 'homesection' || Request::segment(1) == 'features'|| Request::segment(1) == 'discover' || Request::segment(1) == 'screenshots'|| Request::segment(1) == 'faq' || Request::segment(1) == 'testimonials'|| Request::segment(1) == 'join_us') ? ' active' : ''); ?>">
    <a href="<?php echo e(route('landingpage.index')); ?>" class="dash-link">
        <span class="dash-micon"><i class="ti ti-settings"></i></span><span class="dash-mtext"><?php echo e(__('Landing Page')); ?></span>
    </a>
</li>
<?php /**PATH /var/www/html/AsynchronousDigital/POSGo/Modules/LandingPage/Resources/views/menu/landingpage.blade.php ENDPATH**/ ?>