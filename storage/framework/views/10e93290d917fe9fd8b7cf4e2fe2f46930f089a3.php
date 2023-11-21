<?php $__env->startSection('page-title', __('Customers')); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Customer Edit')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Customer')); ?></li>
    <li class="breadcrumb-item"><?php echo e(__('Edit Customer')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Customer')): ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header card-body table-border-style">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#customerDetails" type="button" role="tab" aria-controls="customerDetails" aria-selected="true">Details</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#customerDocuments" type="button" role="tab" aria-controls="customerDocuments" aria-selected="false">Documents</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="customerDetails" role="tabpanel" aria-labelledby="home-tab">
                                <?php echo e(Form::model($customer, ['route' => ['customers.update', $customer->id], 'method' => 'PUT'])); ?>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('name', __('Name'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter new customer name'), 'required'=>'required'])); ?>

                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('email', __('Email'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::email('email', null, ['class' => 'form-control', 'placeholder' => __('Enter new email address'), 'required'=>'required'])); ?>

                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('phone_number', __('Phone number'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::text('phone_number', null, ['class' => 'form-control', 'maxlength' => '15', 'placeholder' => __('Enter phone number')])); ?>

                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('address', __('Address'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::text('address', null, ['class' => 'form-control', 'placeholder' => __('Enter Address')])); ?>

                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('city', __('City'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::text('city', null, ['class' => 'form-control', 'maxlength' => '15', 'placeholder' => __('Enter city name')])); ?>

                                        </div>

                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('state', __('State'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::text('state', null, ['class' => 'form-control', 'maxlength' => '15', 'placeholder' => __('Enter state name')])); ?>

                                        </div>

                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('country', __('Country'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::text('country', null, ['class' => 'form-control', 'maxlength' => '15', 'placeholder' => __('Enter country name')])); ?>

                                        </div>

                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('zipcode', __('Zipcode'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::text('zipcode', null, ['class' => 'form-control', 'maxlength' => '15', 'placeholder' => __('Enter zipcode name')])); ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                                    <input class="btn btn-primary" type="submit" value="<?php echo e(__('Edit')); ?>">
                                </div>

                                <?php echo e(Form::close()); ?>

                            </div>
                            <div class="tab-pane fade" id="customerDocuments" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="text-end">
                                    <a href="#" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip"
                                       data-title="<?php echo e(__('Add New Document')); ?>" title="<?php echo e(__(' New Document')); ?>"
                                       data-url="<?php echo e(route('customers.create.document',$customer->id)); ?>" class="btn btn-sm btn-primary btn-icon m-1">
                                        <span class=""><i class="ti ti-plus text-white"></i></span>
                                    </a>
                                </div>

                                <div class="mt-4 table-responsive">
                                    <table class="table dataTable" id="pc-dt-simple">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo e(__('Type')); ?></th>
                                            <th><?php echo e(__('Description')); ?></th>
                                            <th><?php echo e(__('File')); ?> </th>
                                            <th><?php echo e(__('Expiration Date')); ?> </th>
                                            <th><?php echo e(__('Status')); ?> </th>
                                            <th width="200px"><?php echo e(__('Action')); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(count($documents) > 0): ?>
                                            <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($loop->iteration); ?></td>
                                                    <td><?php echo e($document->type_text); ?></td>
                                                    <td><?php echo e($document->description); ?></td>
                                                    <td>
                                                        <?php if($document->isImage()): ?>
                                                            <a href="<?php echo e(asset('storage/'.$document->file)); ?>" class="document-list-icon-link" target="_blank">
                                                                <img src="<?php echo e(asset('storage/'.$document->file)); ?>" alt="<?php echo e($document->name); ?>" class="document-list-icon">
                                                            </a>
                                                        <?php else: ?>
                                                            <a href="<?php echo e(asset('storage/'.$document->file)); ?>" class="document-list-icon-link p-2" target="_blank">
                                                                <img src="<?php echo e(asset('public/file.png')); ?>" alt="<?php echo e($document->name); ?>" class="document-list-icon">
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo e($document->expiration_date); ?></td>
                                                    <td><?php echo e(($document->status == 1)?'Active':'Inactive'); ?></td>
                                                    <td>
                                                        <div class="action-btn bg-info ms-2">
                                                            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                               data-ajax-popup="true"
                                                               data-size="lg"
                                                               data-url="<?php echo e(route('customers.document.edit', ['id' => $document->customer_id, 'did' =>$document->id])); ?>"
                                                               title="<?php echo e(__('Edit Document')); ?>"
                                                               data-title="<?php echo e(__('Edit Document')); ?>"
                                                               data-bs-toggle="tooltip">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                        <div class="action-btn bg-danger ms-2">
                                                            <a href="#"
                                                               class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center"
                                                               data-toggle="sweet-alert" data-bs-toggle="tooltip"
                                                               data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                               data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                               data-confirm-yes="delete-form-<?php echo e($document->id); ?>"
                                                               title="<?php echo e(__('Delete')); ?>">
                                                                <i class="ti ti-trash text-white"></i>
                                                            </a>
                                                        </div>
                                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['customers.document.delete', ['id' => $document->customer_id, 'did' =>$document->id]], 'id' => 'delete-form-' . $document->id]); ?>

                                                        <?php echo Form::close(); ?>

                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center"><?php echo e(__('No data available')); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('custom_scripts'); ?>
    <script>
        function startCamera() {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(function(stream) {
                        // Set the video source to the user's camera stream
                        var video = document.getElementById('cameraVideo');
                        video.srcObject = stream;
                        video.play();
                        $("#cameraSection").slideDown();
                        $("#showImgSection").slideUp();
                    })
                    .catch(function(error) {
                        console.error('Error accessing the camera: ', error);
                    });
            } else {
                console.error('getUserMedia is not supported in this browser');
            }
        }

        function captureImage() {
            var video = document.getElementById('cameraVideo');
            var canvas = document.getElementById('canvas');
            var context = canvas.getContext('2d');
            var capturedImage = document.getElementById('capturedImage');
            var filePreview = $('.show-img-wrapper .output-img');

            // Draw the current video frame onto the canvas
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Convert the canvas content to a data URL and set it as the source for the captured image
            capturedImage.src = canvas.toDataURL('image/png');

            $("#capturedImageInput").val(capturedImage.src);
            // Show the captured image
            // capturedImage.style.display = 'block';
            filePreview.attr('src', capturedImage.src);
            $('.show-img-wrapper .uploaded-img-name').html('Captured Image');

            $("#cameraSection").slideUp();
            $("#showImgSection").slideDown();
        }

        function handleFileSelect(event) {
            var fileInput = event.target;
            var defaultImage = "<?php echo e(asset('public/file.png')); ?>";
            var filePreview = $('.show-img-wrapper .output-img');
            var fileNameDisplay = $('.show-img-wrapper .uploaded-img-name');

            // Reset the file preview and name display

            fileNameDisplay.text('');

            // Check if any file is selected
            if (fileInput.files.length > 0) {
                var file = fileInput.files[0];

                // Display the file name
                fileNameDisplay.text(file.name);

                // Check if the file is an image
                if (file.type && file.type.indexOf('image') !== -1) {
                    // If it is an image, display the image preview
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        filePreview.attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                } else {
                    // If it is not an image, display a text message
                    filePreview.attr('src', defaultImage);
                }
            }

            $("#capturedImageInput").val("");
        }

        function cancelCapture() {
            $("#cameraSection").slideUp();
            $("#showImgSection").slideDown();
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/customers/edit.blade.php ENDPATH**/ ?>