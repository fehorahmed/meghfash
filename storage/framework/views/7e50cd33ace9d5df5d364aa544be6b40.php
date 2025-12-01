<?php if($coupon->couponProductPosts()->count() > 0): ?>
<div class="row">
    <div class="col-md-4">
        <div class="input-group">
            <label style="background: #c9c6c6;padding: 5px 15px;margin: 0;margin-right: 10px;">
                <input type="checkbox" class="checkAll"> All
            </label>
            <button type"button" class="btn btn-sm btn-danger rounded-0 counponProductDelete" data-url="<?php echo e(route('admin.ecommerceCouponsAction',['delete-product',$coupon->id])); ?>"><i class="fa fa-trash"></i> Delete</button>
        </div>
    </div>
</div>
<div class="row" style="margin:0 -5px;">
    <?php $__currentLoopData = $coupon->couponProductPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productPost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-2 col-6" style="padding:5px;">
        <div class="productGrid">
        <?php if($product =$productPost->product): ?>
        <img src="<?php echo e(asset($product->image())); ?>">
        <a href="" target="_blank">
            <?php echo e($product->name); ?>

        </a>
        <?php else: ?>
        <h4>Not Found</h4>
        <?php endif; ?>
        <label>
                <input type="checkbox" value="<?php echo e($productPost->id); ?>" class="counponCheck">
        </label>
        
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?><?php /**PATH /home/posherbd/public_html/posher.com.bd/resources/views/admin/ecommerce-setting/includes/couponProductsList.blade.php ENDPATH**/ ?>