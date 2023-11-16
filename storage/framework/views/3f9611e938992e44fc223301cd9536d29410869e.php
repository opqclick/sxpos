<?php $__env->startSection('content'); ?> 

    <?php echo $content; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('emails.common', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/emails/common_email_template.blade.php ENDPATH**/ ?>