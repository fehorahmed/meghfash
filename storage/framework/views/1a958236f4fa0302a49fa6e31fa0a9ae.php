<div class="row" style="margin:0 -5px;">
    <div class="col-md-7" style="padding:5px;">
        <table class="table table-bordered summeryTable">
            <tr>
                <th>Sub Total</th>
                <td><?php echo e(priceFullFormat($invoice->total_price)); ?></td>
            </tr>
            <tr>
                <th>Shipping Charge</th>
                <td><?php echo e(priceFullFormat($invoice->shipping_charge)); ?></td>
            </tr>
            <tr>
                <th>Tax (<?php echo e($invoice->tax); ?>%)</th>
                <td><?php echo e(priceFullFormat($invoice->tax_amount)); ?></td>
            </tr>
            <tr>
                <th>Discount</th>
                <td><?php echo e(priceFullFormat($invoice->discount_amount)); ?></td>
            </tr>
            <tr>
                <th>Grand Total</th>
                <td><?php echo e(priceFullFormat($invoice->grand_total)); ?></td>
            </tr>
            <tr>
                <th>Paid Amount</th>
                <td><?php echo e(priceFullFormat($invoice->paid_amount)); ?></td>
            </tr>
            <tr>
                <th>Due Amount</th>
                <td><?php echo e(priceFullFormat($invoice->due_amount)); ?></td>
            </tr>
        </table>    
    </div>
    <div class="col-md-5" style="padding:5px;">
        <div class="form-group" style="margin-bottom:5px;">
            <label class="m-0">Payment Method </label>
            <select class="form-control form-control-sm paymentMethod">
                <?php $__currentLoopData = $accountsMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($method->id); ?>"><?php echo e($method->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <span class="paymentMethodErr"></span>
        </div>
        <div class="form-group" style="margin-bottom:5px;">
            <label class="m-0">Received Amount <?php echo e(priceFormat($invoice->due_amount)); ?></label>
            <Input type="number" class="form-control form-control-sm ReceivedAmount" data-total="<?php echo e($invoice->due_amount); ?>" value="<?php echo e(number_format($invoice->due_amount, 2, '.', '')); ?>" step="any" placeholder="Amount">
            <span class="receivedAmountErr"></span>
        </div>
        <div class="form-group m-0">
            <label class="m-0">Return BDT </label><span class="returnAmount">0</span>
        </div>
        <div class="form-group m-0">
            <button type="button" class="btn btn-md btn-block btn-success <?php echo e($invoice->due_amount==0?'':'AddPayment'); ?>" data-url="<?php echo e(route('admin.posOrdersAction',['addPayment',$invoice->id])); ?>" <?php echo e($invoice->due_amount==0?'disabled':''); ?>   >Add Payment</button>
        </div>
    </div>
    <div class="col-md-12" style="padding:5px;">
        <h4 style="font-size: 18px;">All Tansection</h4>
        <div class="table-responsive">
            <table class="table table-bordered transectionTable">
                <tr>
                    <th style="min-width: 120px;">Method</th>
                    <th style="min-width: 120px;">Amount</th>
                    <th style="min-width: 100px;">Return</th>
                </tr>
                <?php $__currentLoopData = $invoice->transections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($transection->payment_method); ?></td>
                    <td><?php echo e(priceFullFormat($transection->received_amount)); ?></td>
                    <td><?php echo e(priceFormat($transection->return_amount)); ?>


                    <span class="removePayment" data-url="<?php echo e(route('admin.posOrdersAction',['removepayment',$invoice->id,'transection_id'=>$transection->id])); ?>"><i class="fa fa-trash"></i></span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($invoice->transections->count()==0): ?>
                <tr>
                    <td colspan="4" style="text-align:center;">
                        No Transaction
                    </td>
                </tr>
                <?php endif; ?>
            </table>
        </div>
        <form action="<?php echo e(route('admin.posOrdersAction',['completed-invoice',$invoice->id])); ?>" method="post">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label>Sale Note</label>
                <textarea class="form-control saleNote" data-url="<?php echo e(route('admin.posOrdersAction',['salesnote',$invoice->id])); ?>" placeholder="Write sale note"><?php echo $invoice->note; ?></textarea>
            </div>
            <button type="submit" data-url="<?php echo e(route('admin.posOrdersAction',['completed-invoice',$invoice->id])); ?>" class="btn btn-primary btn-block CompletedOrder1">Completed Order</button>
        </form>
    </div>
</div><?php /**PATH C:\xampp\htdocs\posher-react-laravel\resources\views/admin/pos-orders/includes/invoiceTansection.blade.php ENDPATH**/ ?>