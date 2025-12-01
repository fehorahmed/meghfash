<div class="row" style="margin:0 -1px;">
    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-4" style="padding:1px">
        <div class="addCart" style="border: 1px solid #17a2b8;cursor: pointer;">
            <div style="position: relative;">
                <span class="addItemCart" data-url="<?php echo e(route('admin.posOrdersAction',['addCart',$invoice->id,'product_id'=>$product->id])); ?>">
                    <?php if($product->warehouseStock($invoice->warehouse_id)==0): ?>
                    <span style="font-size: 16px;color: red;">Stock Out</span>
                    <?php else: ?>
                    <i class="bx bx-plus"></i>
                    <?php endif; ?>
                </span>
                <span style="position: absolute;display: inline-block;background: rebeccapurple;color: white;padding: 3px 10px;font-size: 12px;border-radius: 10px;margin: 2px;">
                <?php echo e($product->warehouseStock($invoice->warehouse_id)); ?> <?php echo e($product->weight_unit); ?>

                </span>
                <img src="<?php echo e(asset($product->image())); ?>" style="height: 130px;width: 100%;">

                <span style="position: absolute;bottom: 0;left: 0;width: 100%;text-align: center;background: #dc3545e0;font-size: 12px;color: white;">
                <i class="bx bx-barcode"></i> <?php echo e($product->bar_code); ?>

                <span>

            </div>
            <div style="text-align:center;">
                <span style="display: block;font-size: 13px;line-height: 14px;height: 30px;overflow: hidden;"><?php echo e($product->name); ?></span>
                <span style="display: block;background: #17a2b8;font-size: 12px;color: white;padding: 3px 10px;"><?php echo e(priceFullFormat($product->final_price)); ?></span>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div><?php /**PATH C:\xampp\htdocs\posher-react-laravel\resources\views/admin/pos-orders/includes/productsList.blade.php ENDPATH**/ ?>