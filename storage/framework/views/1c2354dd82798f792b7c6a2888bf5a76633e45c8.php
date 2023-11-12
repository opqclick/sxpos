<?php echo e(Form::open(['url' => 'cashregisters'])); ?>

<div class="modal-body">

<div class="form-group">
    <?php echo e(Form::label('name', __('Cash Register Name'), ['class' => 'col-form-label'])); ?>

    <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter new Cash Register Name')])); ?>

</div>

<div class="form-group">
    <?php echo e(Form::label('branch_id', __('Branch'), ['class' => 'col-form-label'])); ?>

    <div class="input-group">
        <?php echo e(Form::select('branch_id', $branches, null, ['class' => 'form-control', 'data-toggle' => 'select'])); ?>

    </div>
</div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    <input class="btn btn-primary" type="submit" value="<?php echo e(__('Create')); ?>">
</div>

<?php echo e(Form::close()); ?>

<?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/cashregisters/create.blade.php ENDPATH**/ ?>