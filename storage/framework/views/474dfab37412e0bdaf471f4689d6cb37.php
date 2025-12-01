<div class="row">
    <div class="col-md-6">
        <div class="table-responsive">
            <table class="table table-borderless">
                <tr>
                    <td>Invoice No*</td>
                    <td style="padding:1px;">
                        <input type="text" name="invoice" value="<?php echo e($invoice->invoice); ?>" readonly="" class="form-control" placeholder="Enter Invoice No" required="">
                        <?php if($errors->has('invoice')): ?>
                        <p style="color: red; margin: 0;"><?php echo e($errors->first('invoice')); ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>Wholesale Date*</td>
                    <td style="padding:1px;">
                        <input type="date" value="<?php echo e($invoice->created_at->format('Y-m-d')); ?>" name="created_at" class="form-control" required="">
                        <?php if($errors->has('created_at')): ?>
                        <p style="color: red; margin: 0;"><?php echo e($errors->first('created_at')); ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>Store/Branch*</td>
                    <td style="padding:1px;">
                        <?php if($invoice->items()->count() > 0): ?>
                        <input type="text" readonly value="<?php echo e($invoice->branch?$invoice->branch->name:''); ?>" class="form-control">
                        <?php else: ?>
                        <select class="form-control selectWarehouse"  data-url="<?php echo e(route('admin.wholeSalesAction',['warehouse-select',$invoice->id])); ?>">
                            <option value="">Select Store/Branch</option>
                            <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($warehouse->id); ?>" <?php echo e($warehouse->id==$invoice->branch_id?'selected':''); ?>><?php echo e($warehouse->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php endif; ?>
                        <span class="warehouseErro" style="color:red;"></span>
                    </td>
                </tr>
                <tr>
                    <td>Customer*</td>
                    <td style="padding:1px;">
                        <?php if($invoice->items()->count() > 0): ?>
                        <input type="text" readonly value="<?php echo e($invoice->company_name); ?> / <?php echo e($invoice->name); ?>" class="form-control">
                        <?php else: ?>
                        <select class="form-control selectSupplier"  data-url="<?php echo e(route('admin.wholeSalesAction',['customer-select',$invoice->id])); ?>">
                            <option value="">Select Customer</option>
                            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($customer->id); ?>" <?php echo e($customer->id==$invoice->user_id?'selected':''); ?>><?php echo e($customer->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php endif; ?>
                        <span class="supplierErro" style="color:red;"></span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="table-responsive">
            <table class="table table-borderless">
                <tr>
                    <td>Company name*</td>
                    <td style="padding:1px;">
                        <input type="text" name="company_name" value="<?php echo e($invoice->company_name); ?>" class="form-control updateInfo" data-url="<?php echo e(route('admin.wholeSalesAction',['company-name',$invoice->id])); ?>" placeholder="Enter company name" required="">
                        <?php if($errors->has('company_name')): ?>
                        <p style="color: red; margin: 0;"><?php echo e($errors->first('company_name')); ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>Customer name*</td>
                    <td style="padding:1px;">
                        <input type="text" name="name" value="<?php echo e($invoice->name); ?>" class="form-control updateInfo" data-url="<?php echo e(route('admin.wholeSalesAction',['customer-name',$invoice->id])); ?>" placeholder="Enter Customer name" required="">
                        <?php if($errors->has('name')): ?>
                        <p style="color: red; margin: 0;"><?php echo e($errors->first('name')); ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>Mobile/Email*</td>
                    <td style="padding:1px;">
                        <input type="text" name="mobile_email" value="<?php echo e($invoice->mobile?:$invoice->email); ?>" data-url="<?php echo e(route('admin.wholeSalesAction',['mobile-email',$invoice->id])); ?>" class="form-control updateInfo" placeholder="Enter mobile/Email " required="">
                        <?php if($errors->has('mobile_email')): ?>
                        <p style="color: red; margin: 0;"><?php echo e($errors->first('mobile_email')); ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td style="padding:1px;">
                        <input type="text" name="address" value="<?php echo e($invoice->address); ?>" class="form-control updateInfo" data-url="<?php echo e(route('admin.wholeSalesAction',['address',$invoice->id])); ?>" placeholder="Enter Address" >
                        <?php if($errors->has('address')): ?>
                        <p style="color: red; margin: 0;"><?php echo e($errors->first('address')); ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
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
</div><?php /**PATH /home/meghfash/public_html/resources/views/admin/wholesale/includes/saleInformation.blade.php ENDPATH**/ ?>