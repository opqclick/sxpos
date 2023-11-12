<?php echo e(Form::model($brand, ['route' => ['brands.update', $brand->id], 'method' => 'PUT'])); ?>

<div class="modal-body">
   <div class="row">
        

      <div class="form-group col-md-12">
          <?php echo e(Form::label('name', __('Brand Name'), ['class' => 'col-form-label'])); ?>

          <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter new Brand Name')])); ?>

      </div>
   </div>
</div>

 <div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    <input class="btn btn-primary" type="submit" value="<?php echo e(__('Edit')); ?>">
</div>

<?php echo e(Form::close()); ?>

<?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/brands/edit.blade.php ENDPATH**/ ?>