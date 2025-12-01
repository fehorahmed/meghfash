<?php if($recommendProducts->count() > 0): ?>
<div class="relatedProductMaindDiv">
    <div class="container-fluid">
        <h2>You may also like</h2>
        <div class="productsLists">
            <div class="row productRow">
                <?php $__currentLoopData = $recommendProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-3 col-6">
                    <?php echo $__env->make(welcomeTheme().'.products.includes.productCard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?><?php /**PATH D:\xampp\htdocs\poshak\resources\views/welcome/products/includes/relatedProducts.blade.php ENDPATH**/ ?>