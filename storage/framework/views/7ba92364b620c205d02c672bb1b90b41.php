
<option value="">Select Sub Brand</option>
<?php if($brand): ?>
<?php $__currentLoopData = $brand->subbrands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<option value="<?php echo e($brand->id); ?>"><?php echo e($brand->name); ?> </option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH /home/posherbd/public_html/posher.com.bd/resources/views/admin/products/includes/productsBrands.blade.php ENDPATH**/ ?>