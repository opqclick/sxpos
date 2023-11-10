<?php $__env->startSection('page-title', __('Languages')); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Languages')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <?php if($currantLang != (!empty( $settings['default_language']) ?  $settings['default_language'] : 'en')): ?>
        <div class="action-btn ms-2">
            <div class="form-check form-switch custom-switch-v1">
                <input type="hidden" name="disable_lang" value="off">
                <input type="checkbox" class="form-check-input input-primary" name="disable_lang" data-bs-placement="top" title="<?php echo e(__('Enable/Disable')); ?>" id="disable_lang" data-bs-toggle="tooltip" <?php echo e(!in_array($currantLang,$disabledLang) ? 'checked':''); ?> > 
                <label class="form-check-label" for="disable_lang"></label>
            </div>
        </div>
    <?php endif; ?>

    
    <?php if($currantLang != (env('DEFAULT_LANG') ?? 'en')): ?>
        
        <div class="action-btn ms-2">
            <?php echo Form::open(['method' => 'DELETE', 'route' => ['lang.destroy', $currantLang], 'id' => 'delete-lang-' . $currantLang]); ?>

                <a href="#!" class="btn btn-sm btn-danger btn-icon m-1 show_confirm" data-bs-toggle="tooltip" title='Delete'>
                    <i class="ti ti-trash"></i>
                </a>
            <?php echo Form::close(); ?>

        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).on('change','#disable_lang',function(){
           var val = $(this).prop("checked");
           if(val == true){
                var langMode = 'on';
           }
           else{
            var langMode = 'off';
           }
           $.ajax({
                type:'POST',
                url: "<?php echo e(route('disablelanguage')); ?>",
                datType: 'json',
                data:{
                    "_token": "<?php echo e(csrf_token()); ?>",
                    "mode":langMode,
                    "lang":"<?php echo e($currantLang); ?>"
                },
                success : function(data){
                    show_toastr('Success',data.message, 'success')
                }
           });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Languages')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-3 col-md-3">
        <div class="card sticky-top">
            <div class="list-group list-group-flush"  id="useradd-sidenav">
                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('manage.language',[$code])); ?>"
                            class="list-group-item list-group-item-action border-0 <?php echo e(($currantLang == $code)?'active':''); ?>"><?php echo e(ucFirst($lang)); ?>

                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
                <div class="p-3 card">
        <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-user-tab-1" data-bs-toggle="pill"
                    data-bs-target="#labels" type="button"><?php echo e(__('Labels')); ?></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-user-tab-2" data-bs-toggle="pill"
                    data-bs-target="#messages" type="button"><?php echo e(__('Messages')); ?></button>
            </li>

        </ul>
    </div>
    <div class="card">
        <div class="card-body p-3">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="labels" role="tabpanel" aria-labelledby="home-tab">
                    <form method="post" action="<?php echo e(route('store.language.data',[$currantLang])); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <?php $__currentLoopData = $arrLabel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="example3cols1Input"><?php echo e($label); ?> </label>
                                        <input type="text" class="form-control" name="label[<?php echo e($label); ?>]" value="<?php echo e($value); ?>">
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <div class="card-footer text-end">
                                <input type="submit" value="<?php echo e(__('Save Changes')); ?>" class="btn btn-primary">
                            </div>

                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="profile-tab">
                    <form method="post" action="<?php echo e(route('store.language.data',[$currantLang])); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <?php $__currentLoopData = $arrMessage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fileName => $fileValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-lg-12">
                                    <h5><?php echo e(ucfirst($fileName)); ?></h5>
                                </div>
                                <?php $__currentLoopData = $fileValue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(is_array($value)): ?>
                                        <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label2 => $value2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(is_array($value2)): ?>
                                                <?php $__currentLoopData = $value2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label3 => $value3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(is_array($value3)): ?>
                                                        <?php $__currentLoopData = $value3; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label4 => $value4): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if(is_array($value4)): ?>
                                                                <?php $__currentLoopData = $value4; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label5 => $value5): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="form-label" ><?php echo e($fileName); ?>.<?php echo e($label); ?>.<?php echo e($label2); ?>.<?php echo e($label3); ?>.<?php echo e($label4); ?>.<?php echo e($label5); ?></label>
                                                                            <input type="text" class="form-control" name="message[<?php echo e($fileName); ?>][<?php echo e($label); ?>][<?php echo e($label2); ?>][<?php echo e($label3); ?>][<?php echo e($label4); ?>][<?php echo e($label5); ?>]" value="<?php echo e($value5); ?>">
                                                                        </div>
                                                                    </div>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php else: ?>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label" ><?php echo e($fileName); ?>.<?php echo e($label); ?>.<?php echo e($label2); ?>.<?php echo e($label3); ?>.<?php echo e($label4); ?></label>
                                                                        <input type="text" class="form-control" name="message[<?php echo e($fileName); ?>][<?php echo e($label); ?>][<?php echo e($label2); ?>][<?php echo e($label3); ?>][<?php echo e($label4); ?>]" value="<?php echo e($value4); ?>">
                                                                    </div>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="form-label" ><?php echo e($fileName); ?>.<?php echo e($label); ?>.<?php echo e($label2); ?>.<?php echo e($label3); ?></label>
                                                                <input type="text" class="form-control" name="message[<?php echo e($fileName); ?>][<?php echo e($label); ?>][<?php echo e($label2); ?>][<?php echo e($label3); ?>]" value="<?php echo e($value3); ?>">
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" ><?php echo e($fileName); ?>.<?php echo e($label); ?>.<?php echo e($label2); ?></label>
                                                        <input type="text" class="form-control" name="message[<?php echo e($fileName); ?>][<?php echo e($label); ?>][<?php echo e($label2); ?>]" value="<?php echo e($value2); ?>">
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" ><?php echo e($fileName); ?>.<?php echo e($label); ?></label>
                                                <input type="text" class="form-control" name="message[<?php echo e($fileName); ?>][<?php echo e($label); ?>]" value="<?php echo e($value); ?>">
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="card-footer text-end">
                            <input type="submit" value="<?php echo e(__('Save Changes')); ?>" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/AsynchronousDigital/POSGo/resources/views/languages/index.blade.php ENDPATH**/ ?>