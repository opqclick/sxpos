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
            <label for="expiration_date">Expiration Date</label>
            <input type="date" class="form-control" value="<?php echo e($document->expiration_date); ?>" required name="expiration_date">
        </div>
        <div class="col-12">
            <div class="img-camera-wrapper">
                <div class="camera" id="cameraSection" style="display: none;">
                    <video class="d-block m-0-auto" id="cameraVideo" width="640" height="480" autoplay></video>
                    <div class="text-center mt-2">
                        <button type="button" class="btn btn-primary" id="captureBtn" onclick="captureImage()">Capture Image</button>
                        <button type="button" class="btn btn-danger" onclick="cancelCapture()">Cancel</button>
                    </div>
                    <canvas id="canvas" width="640" height="480" style="display:none;"></canvas>
                    <img id="capturedImage" style="display:none;">
                    <input type="hidden" id="capturedImageInput" name="capture_file" value="">
                </div>
                <div id="showImgSection">
                    <div class="show-img-wrapper">
                        <img src="<?php echo e(asset('public/file.png')); ?>" alt="" class="output-img">
                        <span class="uploaded-img-name text-danger">Upload File</span>
                    </div>
                    <div class="text-center mt-2">
                        <button type="button" class="btn btn-primary btn-sm" onclick="$('#uploadFile').click()">
                            <span>Upload</span>
                        </button>
                        <input type="file" name="upload_file" id="uploadFile" style="display: none;"  onchange="handleFileSelect(event)">
                        <button type="button" class="btn btn-danger btn-sm" id="showCamera" onclick="startCamera()">Capture</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label >Status</label>
                <select name="status" class="form-control">
                    <option value="1" <?php echo e(($document->status == 1)?'selected':''); ?>>Active</option>
                    <option value="0" <?php echo e(($document->status == 0)?'selected':''); ?>>Inactive</option>
                </select>
            </div>
        </div>
    </div>
    </div>
     <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
        <input class="btn btn-primary" type="submit" value="<?php echo e(__('Edit')); ?>">
     </div>
</form>
<?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/customers/edit_document.blade.php ENDPATH**/ ?>