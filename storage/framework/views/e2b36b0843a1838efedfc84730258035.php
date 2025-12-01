
<?php echo $message; ?>

<?php if($parentOrder =$order->parentOrder): ?>
    <h3>Order item</h3>
    <table class="table table-bordered">
        <tr>
            <td style="min-width:50px;width: 50px;">SL</td>
            <td style="min-width:200px;">Item description</td>
            <td style="min-width:120px;width: 120px;">Price</td>
            <td style="min-width:120px;width: 120px;">Order Qty</td>
            <td style="min-width:120px;width: 120px;">Return Qty</td>
            <td style="min-width:150px;width: 150px;">Total</td>
        </tr>
        <?php $__currentLoopData = $parentOrder->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$rItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($i+1); ?></td>
            <td>
                <b><?php echo e($rItem->product_name); ?></b> <br>
                <?php if(count($rItem->itemAttributes()) > 0): ?>
				    <?php $__currentLoopData = $rItem->itemAttributes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$attri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				        <?php if(isset($attri['title']) && isset($attri['value'])): ?>
                        <?php echo e($i==0?'':','); ?> <span><?php echo e($attri['title']); ?> : <?php echo e($attri['value']); ?></span>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			    <?php endif; ?>
            </td>
            <td><?php echo e($rItem->price); ?></td>
            <td style="text-align: center;"><?php echo e($rItem->quantity); ?></td>
            <td style="padding:5px;">
                <input type="number" value="<?php echo e($rItem->return_quantity); ?>" class="form-control form-control-sm itemUpdate" data-url="<?php echo e(route('admin.wholesaleReturnAction',['item-quantity',$order->id])); ?>" data-id="<?php echo e($rItem->id); ?>" >
            </td>
            <td><?php echo e($rItem->return_total); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" style="text-align:right;">Return Amount</td>
            <td><?php echo e($parentOrder->return_amount); ?></td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td colspan="2">
                <div class="form-group">
                    <button class="btn btn-success" type="submit" style="width: 100%;background-color: #e91e63 !important;border-color: #e91e63;">
                    <i class="fa fa-check"></i>
                    Submit Return
                   </button>
                </div>
            </td>
        </tr>
    </table>
<?php endif; ?><?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/admin/returns/includes/wholesaleOrderItems.blade.php ENDPATH**/ ?>