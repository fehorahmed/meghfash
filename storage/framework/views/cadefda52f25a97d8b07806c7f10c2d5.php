
<?php if(is_array($stores) && isset($stores[0])): ?>
<select class="form-control form-control-sm courierStore" name="courier_store">
    <option value="">Select Store</option>
    
    <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($store['store_id']); ?>"><?php echo e($store['store_name']); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</select>
<?php endif; ?>

<?php if(is_array($districts) && isset($districts[0])): ?>
<div class="input-group">
    <select class="form-control form-control-sm courierDistrict" name="courier_district" data-url="<?php echo e(route('admin.ordersAction',['courier-district',$order->id])); ?>">
        <option value="">Select District</option>
        <?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($district['city_id']); ?>"><?php echo e($district['city_name']); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <select class="form-control form-control-sm courierCity" name="courier_city">
        <option value="">Select Area</option>
    </select>
</div>
<?php endif; ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/orders/includes/courierData.blade.php ENDPATH**/ ?>