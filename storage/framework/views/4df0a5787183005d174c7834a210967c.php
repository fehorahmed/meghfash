<?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<?php if($subCategory->id==$category->id): ?> 

<?php else: ?>
<option value="<?php echo e($subCategory->id); ?>" <?php echo e($subCategory->id==$category->parent_id?'selected':''); ?>><?php echo e(str_repeat('-',$i)); ?> <?php echo e($subCategory->name); ?></option>

<?php if($subCategory->subctgs->count() > 0): ?>
<?php echo $__env->make('admin.products.includes.editSubcategory',['subcategories' =>$subCategory->subctgs,'i'=>$i+1], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>

<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /home/posherbd/public_html/posher.com.bd/resources/views/admin/products/includes/editSubcategory.blade.php ENDPATH**/ ?>