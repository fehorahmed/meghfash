<ul>
  <?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <li>
    <div class="custom-control custom-checkbox">
       <input type="checkbox" class="custom-control-input" value="<?php echo e($subctg->id); ?>" id="category_<?php echo e($subctg->id); ?>" name="categoryid[]" <?php $__currentLoopData = $product->productCtgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $postctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($postctg->reff_id==$subctg->id?'checked':''); ?>  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  />
       <label class="custom-control-label" for="category_<?php echo e($subctg->id); ?>"><?php echo e($subctg->name); ?></label>
    </div>
  </li>
  <?php if($subctg->subctgs->count() >0): ?>
  <?php echo $__env->make('admin.products.includes.productEditSubctg',['subcategories' => $subctg->subctgs,'i'=>$i+1], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <?php endif; ?>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul><?php /**PATH D:\xampp\htdocs\posher-react-laravel\resources\views/admin/products/includes/productEditSubctg.blade.php ENDPATH**/ ?>