
<div class="allProd">
    <div class="container-fluid">
        <h3>Shop by Brands</h3>
        <div class="row">
            <div class="col-md-10">
                <div class="proCtgTab">
                    <nav>
                        <div class="nav nav-tabs brandSlick" id="nav-tab" role="tablist">
                            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$brd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button class="nav-link <?php echo e($i==0?'active':''); ?> slick-box" id="nav-brand_<?php echo e($brd->id); ?>-tab" data-bs-toggle="tab" data-bs-target="#nav-brand_<?php echo e($brd->id); ?>" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                                <img src="<?php echo e(asset($brd->image())); ?>" alt="<?php echo e($brd->name); ?>" />
                            </button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="col-md-2">
                <?php if($bPg =pageTemplate('All Brands')): ?>
                <a href="<?php echo e(route('pageView',$bPg->slug?:'no-title')); ?>" class="showMoreLink">Show More</a>
                <?php endif; ?>
            </div>
            <div class="col-md-12">
                <hr />
            </div>
            <div class="col-md-12">
                <div class="tab-content" id="nav-tabContent">
                    <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bb=>$brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="tab-pane fade <?php echo e($bb==0?'show active':''); ?>" id="nav-brand_<?php echo e($brand->id); ?>" role="tabpanel" aria-labelledby="nav-brand_<?php echo e($brand->id); ?>-tab">
                        <div class="row">
                            <?php $__currentLoopData = $brand->brandProducts()->latest()->where('status','active')->limit(8)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-3 col-6">
                                <?php echo $__env->make(welcomeTheme().'.products.includes.productCard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php /**PATH D:\xampp\htdocs\poshak\resources\views/welcome/layouts/brandsProduct.blade.php ENDPATH**/ ?>