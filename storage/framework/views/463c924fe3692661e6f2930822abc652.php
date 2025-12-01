<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Supplier*</label>
            <?php if($invoice->items()->count() > 0): ?>
            <input type="text" readonly value="<?php echo e($invoice->name); ?>" class="form-control">
            <?php else: ?>
            <select class="form-control selectSupplier"  data-url="<?php echo e(route('admin.purchasesAction',['supplier-select',$invoice->id])); ?>">
                <option value="">Select Supplier</option>
                <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($supplier->id); ?>" <?php echo e($supplier->id==$invoice->user_id?'selected':''); ?>><?php echo e($supplier->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php endif; ?>
            <span class="supplierErro" style="color:red;"></span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Store/Branch*</label>
            <?php if($invoice->items()->count() > 0): ?>
            <input type="text" readonly value="<?php echo e($invoice->branch?$invoice->branch->name:''); ?>" class="form-control">
            <?php else: ?>
            <select class="form-control selectWarehouse"  data-url="<?php echo e(route('admin.purchasesAction',['warehouse-select',$invoice->id])); ?>">
                <option value="">Select Store/Branch</option>
                <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($warehouse->id); ?>" <?php echo e($warehouse->id==$invoice->branch_id?'selected':''); ?>><?php echo e($warehouse->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php endif; ?>
            <span class="warehouseErro" style="color:red;"></span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Invoice No*</label>
            <input type="text" name="invoice" value="<?php echo e($invoice->invoice); ?>" class="form-control" placeholder="Enter Invoice No" required="">
            <?php if($errors->has('invoice')): ?>
            <p style="color: red; margin: 0;"><?php echo e($errors->first('invoice')); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-md-3">
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
</div><?php /**PATH D:\xampp\htdocs\posher-react-laravel\resources\views/admin/purchases/includes/purchaseInformation.blade.php ENDPATH**/ ?>