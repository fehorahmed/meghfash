<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Store/Branch*</label>
            <?php if($invoice->items()->count() > 0): ?>
            <input type="text" readonly value="<?php echo e($invoice->branch?$invoice->branch->name:''); ?>" class="form-control">
            <?php else: ?>
            <select class="form-control selectWarehouse"  data-url="<?php echo e(route('admin.stockMinusAction',['warehouse-select',$invoice->id])); ?>">
                <option value="">Select Store/Branch</option>
                <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($warehouse->id); ?>" <?php echo e($warehouse->id==$invoice->branch_id?'selected':''); ?>><?php echo e($warehouse->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php endif; ?>
            <!--<span class="supplierErro" style="color:red;"></span>-->
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Invoice No*</label>
            <input type="text" name="invoice" value="<?php echo e($invoice->invoice); ?>" class="form-control" placeholder="Enter Invoice No" required="">
            <?php if($errors->has('invoice')): ?>
            <p style="color: red; margin: 0;"><?php echo e($errors->first('invoice')); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Stock Date*</label>
            <input type="date" value="<?php echo e($invoice->created_at->format('Y-m-d')); ?>" name="created_at" class="form-control" required="">
            <?php if($errors->has('created_at')): ?>
            <p style="color: red; margin: 0;"><?php echo e($errors->first('created_at')); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>Note</label>
            <textarea class="form-control" name="note" placeholder="Write Invoice Note."><?php echo e($invoice->note); ?></textarea>
            <?php if($errors->has('note')): ?>
            <p style="color: red; margin: 0;"><?php echo e($errors->first('note')); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div><?php /**PATH /home/meghfash/public_html/resources/views/admin/stock-minus/includes/transferInformation.blade.php ENDPATH**/ ?>