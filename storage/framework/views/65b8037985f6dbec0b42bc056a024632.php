<option value="">Select Option</option>
<?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<option value="<?php echo e($data->id); ?>"><?php echo e($data->name); ?></option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/geofilter.blade.php ENDPATH**/ ?>