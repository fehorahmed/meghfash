<ul>
    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li><span class="selectCustomer" style="cursor:pointer;" data-url="<?php echo e(route('admin.posOrdersAction',['selectCustomer',$invoice->id,'customer_id'=>$customer->id])); ?>"><?php echo e($customer->name?:'Unkown'); ?> - <?php echo e($customer->mobile?:$customer->email); ?></span>
    <?php if($customer->member_card_id): ?>
    <small style="color: #ff864a;font-weight: bold;=:sans-serif;">M/C: <?php echo e($customer->member_card_id); ?></small>
    <?php endif; ?>
    </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php if($customers->count()==0): ?>
    <li>
        <span style="text-align: center;color: gainsboro;">No Customer</span>
        <br>
        <div class="form-group" style="margin-bottom: 5px;">
            <label style="margin-bottom: 0px;">Email/Mobile*</label>
            <input type="text" placeholder="Enter Email / or Mobile" value="<?php echo e(request()->search); ?>" class="form-control form-control-sm NewCustomerMobile">
        </div>
        
        <label style="margin-bottom: 0px;">Name</label>
        <div class="input-group">
            <input type="text" placeholder="Enter Name" class="form-control form-control-sm NewCustomerName">
            <span class="btn btn-md btn-success NewCustomerAdd" data-url="<?php echo e(route('admin.posOrdersAction',['addCustomer',$invoice->id])); ?>" style="margin:0;border-radius:0;"><i class="fa fa-plus"></i> Add</span>
        </div>
        <div class="form-group" style="margin-bottom: 5px;">
            <label style="margin-bottom: 0px;color: #ff864a;font-weight: bold;">Member Card ID</label>
            <input type="text" placeholder="Enter Card No" value="" class="form-control form-control-sm NewCustomerCard">
        </div>
        <br>
    </li>
    <?php endif; ?>
</ul><?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/admin/pos-orders/includes/searchCustomers.blade.php ENDPATH**/ ?>