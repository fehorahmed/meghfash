<div class="sliderPart">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3"></div>
            <div class="col-xl-9">
                <?php if($slider =slider('Front Page Slider')): ?>
                <div class="sliderImages">
                    <div class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php $__currentLoopData = $slider->subSliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e($slider->seo_description?:'javascript:void(0);'); ?>">
                            <div class="carousel-item <?php echo e($i==0?'active':''); ?>" style="background-image:url(<?php echo e(asset($slider->image())); ?>)">
                                <div class="sliderContent">
                                    <!--<span>HP</span>-->
                                    <?php if($slider->name): ?>
                                    <h1><?php echo $slider->name; ?></h1>
                                    <?php endif; ?>
                                    <?php if($slider->description): ?>
                                    <p><?php echo $slider->description; ?></p>
                                    <?php endif; ?>
                                    <?php if($slider->seo_title && $slider->seo_description): ?>
                                    <a href="<?php echo e($slider->seo_description); ?>" class="shopNowBtn"><?php echo $slider->seo_title; ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\xampp\htdocs\poshak\resources\views/welcome/layouts/slider.blade.php ENDPATH**/ ?>