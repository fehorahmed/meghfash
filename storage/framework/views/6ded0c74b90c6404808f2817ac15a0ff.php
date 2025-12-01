<div class="blogGrid">
    <div class="image">
        <a href="<?php echo e(route('blogView',$post->slug?:'no-title')); ?>">
            <img src="<?php echo e(asset($post->image())); ?>" alt="<?php echo e($post->name); ?>">
        </a>
        <?php if($ctg =$post->postCategories()->first()): ?>
        <a href="<?php echo e(route('blogCategory',$ctg->slug?:'no-title')); ?>" class="ctg"><?php echo e($ctg->name); ?></a>
        <?php endif; ?>
    </div>
    <div class="title">
        <a href="<?php echo e(route('blogView',$post->slug?:'no-title')); ?>"><?php echo e($post->name); ?></a>
    </div>
    <div class="author">
        <div class="row m-0">
            <div class="col-6 p-0">
                <i class="fa fa-user"></i> By <a href="javascript:void(0)" style="color: #0ba350;">Bytebliss</a>
            </div>
            <div class="col-6 p-0" style="text-align:right;">
                <i class="fa fa-calander"></i> <?php echo e($post->created_at->format('d M Y')); ?>

            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\xampp\htdocs\poshak\resources\views/welcome//blogs/includes/blogGrid.blade.php ENDPATH**/ ?>