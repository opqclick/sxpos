<?php echo e(Form::model($product, ['route' => ['products.update', $product->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data'])); ?>

<div class="modal-body">
    <div class="row">
        <?php if(isset(Utility::settings()['enable_chatgpt']) && Utility::settings()['enable_chatgpt'] == 'on'): ?>
        <div class="col-md-12">
            <a href="#" class="btn btn-primary btn-sm float-end" data-size="md" data-ajax-popup-over="true" data-url="<?php echo e(route('generate',['product'])); ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Generate Product Name & Description')); ?>" data-title="<?php echo e(__('Generate Product Details')); ?>">
                <i class="fas fa-robot"></i> <?php echo e(__('Generate With AI')); ?>

            </a>
        </div>
        <?php endif; ?>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="product_type">Product Type</label>
                    <select name="is_service" class="form-control">
                        <option value="0" <?php echo e(($product->is_service == 0)? 'selected':''); ?>>Product</option>
                        <option value="1" <?php echo e(($product->is_service == 1)? 'selected':''); ?>>Service</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group col-md-12">
            <?php echo e(Form::label('name', __('Product Name'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter new Product Name'), 'required' => ''])); ?>

        </div>
        <div class="form-group col-md-12">
            <?php echo e(Form::label('description', __('Description'), ['class' => 'col-form-label'])); ?>

            <?php echo Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Enter Product Description'), 'rows' => 3, 'style' => 'resize: none']); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('category_id', __('Category'), ['class' => 'col-form-label'])); ?>

            <div class="input-group">
                <?php echo e(Form::select('category_id', $categories, null, ['class' => 'form-control', 'data-toggle' => 'select'])); ?>

            </div>
        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('brand_id', __('Brand'), ['class' => 'col-form-label'])); ?>

            <div class="input-group">
                <?php echo e(Form::select('brand_id', $brands, null, ['class' => 'form-control', 'data-toggle' => 'select'])); ?>

            </div>
        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('tax_id', __('Tax'), ['class' => 'col-form-label'])); ?>

            <div class="input-group">
                <?php echo e(Form::select('tax_id', $taxes, null, ['class' => 'form-control', 'data-toggle' => 'select'])); ?>

            </div>
        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('unit_id', __('Unit'), ['class' => 'col-form-label'])); ?>

            <div class="input-group">
                <?php echo e(Form::select('unit_id', $units, null, ['class' => 'form-control', 'data-toggle' => 'select'])); ?>

            </div>
        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('account_for_sale', __('Account For Sale'), ['class' => 'col-form-label'])); ?>

            <div class="input-group">
                <select name="account_for_sale" id="account_for_sale" class="form-control" data-toggle="select">
                    <option value="">Select Account</option>
                    <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($account->id); ?>" <?php echo e(($product->account_for_sale == $account->id)?'selected':''); ?>><?php echo e($account->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('account_for_purchase', __('Account For Purchase'), ['class' => 'col-form-label'])); ?>

            <div class="input-group">
                <select name="account_for_purchase" id="account_for_purchase" class="form-control" data-toggle="select">
                    <option value="">Select Account</option>
                    <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($account->id); ?>" <?php echo e(($product->account_for_purchase == $account->id)?'selected':''); ?>><?php echo e($account->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <div class="mb-4 col-md-6">
            <div class="choose-files mt-3">
                <label for="image">
                    <div class=" bg-primary edit-product-image"> <i
                            class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?>

                    </div>
                    <input type="file" class="form-control file d-none" name="image" id="image"
                        data-filename="edit-product-image" accept="image/*">
                </label>
            </div>
        </div>

        <div class="col-md-6 my-auto">
            
            <?php echo e(Form::hidden('imgstatus', 0)); ?>

            <div class="form-group" id="product-image">
                

                <a href="<?php echo e(\App\Models\Utility::get_file($product->image)); ?>" target="_blank">
                    <img src="<?php echo e(\App\Models\Utility::get_file($product->image)); ?>" class="profile-image rounded-circle-product"
                           onerror="this.onerror=null;this.src='<?php echo e(asset(Storage::url('logo/placeholder.png'))); ?>';">
                </a>
                <button type="button" class="action-btn bg-danger btn-xs ms-3 mt-2 product-img-btn">
                    <i class="ti ti-trash text-white btn-xs mb-1"></i>
                </button>
            </div>
            
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-4">
            <?php echo e(Form::label('purchase_price', __('Purchase price') . ' (' . Auth::user()->currencySymbol() . ')', ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::number('purchase_price', null, ['class' => 'form-control', 'placeholder' => __('Enter new Purchase Price'), 'step' => '0.01'])); ?>

        </div>
        <div class="form-group col-md-4">
            <?php echo e(Form::label('sale_price', __('Selling price') . ' (' . Auth::user()->currencySymbol() . ')', ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::number('sale_price', null, ['class' => 'form-control', 'placeholder' => __('Enter new Selling Price'), 'step' => '0.01'])); ?>

        </div>
        <div class="form-group col-md-4">
            <?php echo e(Form::label('sku', __('SKU'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::text('sku', null, ['class' => 'form-control', 'placeholder' => __('Enter new SKU Code')])); ?>

        </div>
    </div>
</div>


<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    <input class="btn btn-primary" type="submit" value="<?php echo e(__('Edit')); ?>">
</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/products/edit.blade.php ENDPATH**/ ?>