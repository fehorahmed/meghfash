<?php if($products->count() > 0): ?>
<div class="row productRow">
    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="<?php echo e($colName); ?> col-6">
        <?php echo $__env->make(welcomeTheme().'.products.includes.productCard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="paginationPart">
    <?php echo e($products->links('pagination')); ?>

</div>

<?php else: ?>
<div>
    <p style="text-align: center;font-size: 24px;color: gray;margin-top: 100px;">No Product found</p>
</div>

<?php endif; ?><?php /**PATH D:\xampp\htdocs\poshak\resources\views/welcome/products/includes/productsAll.blade.php ENDPATH**/ ?>