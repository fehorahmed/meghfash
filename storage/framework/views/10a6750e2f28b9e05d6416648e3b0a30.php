<ul>
    <?php if($products->count() > 0): ?>
    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li data-url="<?php echo e(route('admin.ecommercePromotionsAction',['add-product',$promotion->id,'product_id'=>$product->id])); ?>">
        <span><?php echo e($product->name); ?></span>
    </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
    <li>
        <span>No Product Found</span>
    </li>
    <?php endif; ?>
</ul><?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/admin/ecommerce-setting/includes/searchPromotionProduct.blade.php ENDPATH**/ ?>