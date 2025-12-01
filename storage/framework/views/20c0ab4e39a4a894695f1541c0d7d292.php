<div class="row" style="margin:0 -1px;">
    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($product->variation_status): ?>
            <?php $__currentLoopData = $product->productVariationActiveAttributeItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-6" style="padding:1px">
                <div class="addCart" style="border: 1px solid #17a2b8;cursor: pointer;">
                    <div style="position: relative;">
                        <span class="addItemCart" data-url="<?php echo e(route('admin.posOrdersAction',['addCart',$invoice->id,'product_id'=>$product->id,'barcode'=>$item->barcode])); ?>">
                            <?php if($product->warehouseStock($invoice->branch_id,$item->id)==0): ?>
                            <span style="font-size: 16px;color: red;">Stock Out</span>
                            <?php else: ?>
                            <i class="bx bx-plus"></i>
                            <?php endif; ?>
                        </span>
                        <span style="position: absolute;display: inline-block;background: rebeccapurple;color: white;padding: 3px 10px;font-size: 12px;border-radius: 10px;margin: 2px;">
                        <?php echo e($product->warehouseStock($invoice->branch_id,$item->id)); ?> <?php echo e($product->weight_unit); ?>

                        </span>
                        <img src="<?php echo e(asset($item->variationItemImage())); ?>" style="height: 155px;width: 100%;">
        
                        <span style="position: absolute;bottom: 0;left: 0;width: 100%;text-align: center;background: #dc3545e0;font-size: 12px;color: white;">
                        <i class="bx bx-barcode"></i> <?php echo e($item->barcode); ?>

                        <span>
        
                    </div>
                    <div style="text-align:center;">
                        <span style="display: block;font-size: 13px;line-height: 14px;height: 30px;overflow: hidden;"><?php echo $item->variationItemValues(); ?> - <?php echo e($product->name); ?></span>
                        <span style="display: block;background: #17a2b8;font-size: 12px;color: white;padding: 3px 10px;"><?php echo e(priceFullFormat($item->final_price)); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
        <div class="col-md-6 col-6" style="padding:1px">
            <div class="addCart" style="border: 1px solid #17a2b8;cursor: pointer;">
                <div style="position: relative;">
                    <span class="addItemCart" data-url="<?php echo e(route('admin.posOrdersAction',['addCart',$invoice->id,'product_id'=>$product->id,'barcode'=>$product->bar_code])); ?>">
                        <?php if($product->warehouseStock($invoice->branch_id)==0): ?>
                        <span style="font-size: 16px;color: red;">Stock Out</span>
                        <?php else: ?>
                        <i class="bx bx-plus"></i>
                        <?php endif; ?>
                    </span>
                    <span style="position: absolute;display: inline-block;background: rebeccapurple;color: white;padding: 3px 10px;font-size: 12px;border-radius: 10px;margin: 2px;">
                    <?php echo e($product->warehouseStock($invoice->branch_id)); ?> <?php echo e($product->weight_unit); ?>

                    </span>
                    <img src="<?php echo e(asset($product->image())); ?>" style="height: 155px;width: 100%;">
    
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
        <?php endif; ?>
        
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div><?php /**PATH /home/meghfash/public_html/resources/views/admin/pos-orders/includes/productsList.blade.php ENDPATH**/ ?>