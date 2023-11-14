<?php echo e(Form::model($account, ['route' => ['accounts.update', $account->id], 'method' => 'PUT'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            <label for="type" class="col-form-label">Type</label>
            <select name="type" id="type" class="form-control" required>
                <option value="">Select Type</option>
                <?php $__currentLoopData = \App\Models\Account::TYPES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>" <?php echo e(($account->type == $key) ? 'selected':''); ?>><?php echo e($value); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group col-md-12">
            <?php echo e(Form::label('name', __('Name'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Account Name'), 'required'])); ?>

        </div>

        <div class="form-group col-md-12">
            <?php echo e(Form::label('ref', __('Ref'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::text('ref', null, ['class' => 'form-control', 'placeholder' => __('Enter Account Reference'), 'required'])); ?>

        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    <input class="btn btn-primary" type="submit" value="<?php echo e(__('Edit')); ?>">
</div>

<?php echo e(Form::close()); ?>


<?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/accounts/edit.blade.php ENDPATH**/ ?>