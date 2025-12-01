<?php if($searchProducts): ?>
<ul>
	<?php $__currentLoopData = $searchProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $searchProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    	<?php if($searchProduct->variation_status): ?>
            <?php $__currentLoopData = $searchProduct->productVariationAttributeItems()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        	<li data-url="<?php echo e(route('admin.ordersAction',['add-product',$order->id])); ?>" data-id="<?php echo e($searchProduct->id); ?>" data-variant="<?php echo e($item->id); ?>">
        	    <img src="<?php echo e(asset($item->variationItemImage())); ?>" style="max-height: 25px;margin-right: 5px;"> <?php echo $item->variationItemValues(); ?> -	<?php echo e($searchProduct->name); ?> <?php echo e($item->barcode?'| '.$item->barcode:''); ?>

        	</li>
        	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    	<?php else: ?>
    	<li data-url="<?php echo e(route('admin.ordersAction',['add-product',$order->id])); ?>" data-id="<?php echo e($searchProduct->id); ?>" data-variant="">
    		<img src="<?php echo e(asset($searchProduct->image())); ?>" style="max-height: 25px;margin-right: 5px;"> <?php echo e($searchProduct->name); ?> <?php echo e($searchProduct->bar_code?'| '.$searchProduct->bar_code:''); ?>

    	</li>
    	<?php endif; ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php if($searchProducts->count() ==0): ?>
	<li><span>Not Found</span></li>
	<?php endif; ?>
</ul>
<?php endif; ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/orders/includes/searchResult.blade.php ENDPATH**/ ?>