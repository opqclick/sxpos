<?php echo e(Form::open(['url' => 'branches'])); ?>

<div class="modal-body">
    <div class="row">
        <?php if(isset(Utility::settings()['enable_chatgpt']) && Utility::settings()['enable_chatgpt'] == 'on'): ?>
        <div class="col-md-12">
            <a href="#" class="btn btn-primary btn-sm float-end" data-size="md" data-ajax-popup-over="true" data-url="<?php echo e(route('generate',['branch'])); ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Generate Branch Name')); ?>" data-title="<?php echo e(__('Generate Branch Name')); ?>">
                <i class="fas fa-robot"></i> <?php echo e(__('Generate With AI')); ?>

            </a>
        </div>
        <?php endif; ?>

        <div class="form-group col-md-12">
            <?php echo e(Form::label('name', __('Name'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter new Branch Name')])); ?>

        </div>

        <div class="form-group col-md-12">
            <?php echo e(Form::label('branch_type', __('Branch type'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::select('branch_type', ['' => __('Select Branch Type'), 'retail' => 'Retail', 'restaurant' => 'Restaurant'], null, ['class' => 'form-control', 'data-toggle' => 'select'])); ?>

        </div>

        <div class="form-group col-md-12">
            <?php echo e(Form::label('branch_manager', __('Branch Manager'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::select('branch_manager', $users, null, ['class' => 'form-control', 'data-toggle' => 'select'])); ?>

        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    <input class="btn btn-primary" type="submit" value="<?php echo e(__('Create')); ?>">
</div>

<?php echo e(Form::close()); ?>

<?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/branches/create.blade.php ENDPATH**/ ?>