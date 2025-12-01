<?php if($searchProducts): ?>
<ul>
	<?php $__currentLoopData = $searchProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $searchProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    	<?php if($searchProduct->variation_status): ?>
    	    <li data-url="<?php echo e(route('admin.wholeSalesAction',['add-product',$invoice->id])); ?>" data-id="<?php echo e($searchProduct->id); ?>" data-variant="">
        		<img src="<?php echo e(asset($searchProduct->image())); ?>" style="max-height: 25px;margin-right: 5px;">
        		<?php echo e($searchProduct->name); ?>

        		<br>
        		<?php $__currentLoopData = $searchProduct->productAttibutesVariationGroup(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ii=>$attri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        		   <b><?php echo e($attri->name); ?>:</b> 
        		   <?php $__currentLoopData = $searchProduct->productVariationAttributeItemsList()->whereHas('attributeItem')->where('attribute_id',$attri->id)->select('attribute_item_id')->groupBy('attribute_item_id')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$sku): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        		    <?php echo e($sku->attributeItemValue()); ?> ,
        		   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        	</li>
    	<?php else: ?>
    	<li data-url="<?php echo e(route('admin.wholeSalesAction',['add-product',$invoice->id])); ?>" data-id="<?php echo e($searchProduct->id); ?>" data-variant="">
    		<img src="<?php echo e(asset($searchProduct->image())); ?>" style="max-height: 25px;margin-right: 5px;"> <?php echo e($searchProduct->name); ?> <?php echo e($searchProduct->bar_code?'| '.$searchProduct->bar_code:''); ?>

    	</li>
    	<?php endif; ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php if($searchProducts->count() ==0): ?>
	<li><span>Not Found</span></li>
	<?php endif; ?>
</ul>
<?php endif; ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/wholesale/includes/searchResult.blade.php ENDPATH**/ ?>