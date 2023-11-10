
<footer class="dash-footer">
    <div class="footer-wrapper">
        <div class="py-1">
            <span class="text-muted"> <!-- &copy; -->
                
                <?php echo e(Utility::getValByName('footer_text') ? Utility::getValByName('footer_text') : config('app.name', 'POSGo')); ?>

                </span> 

        </div>
    </div>
</footer>
<?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/footer.blade.php ENDPATH**/ ?>