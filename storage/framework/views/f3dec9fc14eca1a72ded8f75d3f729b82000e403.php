<form method="post" action="<?php echo e(route('customers.document.edit', ['id' => $document->customer_id, 'did' =>$document->id])); ?>" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            <?php echo e(Form::label('description', __('Description'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::text('description', $document->description, ['class' => 'form-control', 'placeholder' => __('Enter Description'), 'required'=>'required'])); ?>

        </div>
        <div class="form-group col-md-6">
            <label for="type">Type</label>
            <select name="type" id="type" required class="form-control">
                <option value="">Select Type</option>
                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeKey => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($typeKey); ?>" <?php echo e(($document->type == $typeKey)? 'selected':''); ?>><?php echo e($type); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="file">File</label>
            <input type="file" class="form-control" name="file">
            [Note: If you want to change the file, please upload new file.]
        </div>
        <div class="form-group col-md-6">
            <label for="expiration_date">Expiration Date</label>
            <input type="date" class="form-control" value="<?php echo e($document->expiration_date); ?>" required name="expiration_date">
        </div>
    </div>
    </div>
     <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
        <input class="btn btn-primary" type="submit" value="<?php echo e(__('Edit')); ?>">
     </div>
</form>
<?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/customers/edit_document.blade.php ENDPATH**/ ?>