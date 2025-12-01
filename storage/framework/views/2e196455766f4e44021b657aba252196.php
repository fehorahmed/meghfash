<?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<option value="<?php echo e($subctg->id); ?>"> <?php echo e(Str::repeat("-",$i)); ?> <?php echo e($subctg->name); ?></option>

<?php if($subctg->subctgs->count() >0): ?>
  <?php echo $__env->make(adminTheme().'menus.includes.productCategorySubList',['subcategories' => $subctg->subctgs,'i'=>$i+1], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH C:\xampp\htdocs\posher-react-laravel\resources\views/admin/menus/includes/productCategorySubList.blade.php ENDPATH**/ ?>