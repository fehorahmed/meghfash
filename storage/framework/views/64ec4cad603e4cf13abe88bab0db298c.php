<!-- Modal -->
<div class="modal fade text-left" id="payment">
   <div class="modal-dialog" role="document">
	 <div class="modal-content">
	   <div class="modal-header">
		 <h4 class="modal-title">Payment</h4>
		 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		   <span aria-hidden="true">&times; </span>
		 </button>
	   </div>
	   <div class="modal-body">
	   		<ul class="nav nav-tabs" role="tablist" style="border-bottom: none;">
				<li class="nav-item">
					<a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" role="tab" aria-selected="true"> Received Payment</a>
				</li>
				<!--<li class="nav-item">-->
				<!--	<a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" role="tab" aria-selected="false"> Refund Payment</a>-->
				<!--</li>-->
			</ul>
			<div class="tab-content px-1 pt-1" style="border: 1px solid #ddd;">
				<div class="tab-pane active" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
				<form action="<?php echo e(route('admin.wholeSalesAction',['payment',$invoice->id])); ?>" method="post">
					<?php echo csrf_field(); ?>
					<input type="hidden" value="0" name="transaction_type">
					
					<div class="form-group">
					    <label>Payment Date</label>
					    <input type="date" value="<?php echo e($invoice->created_at->format('Y-m-d')); ?>" class="form-control" name="created_at">
					</div>
					<div class="form-group">
						<label>Amount</label>
						<input type="number" class="form-control PayAmount" step="any" name="amount" placeholder="Enter Amount" value="<?php echo e($invoice->due_amount?:''); ?>">
					</div>
					<div class="form-group">
						<label>Method</label>
						<div class="input-group">
						<select class="form-control" name="method" required="">
							<option value="">Select Method</option>
						<?php $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($method->id); ?>" ><?php echo e($method->name); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
						</div>
					</div>
					<div class="form-group">
						<label>Note</label>
						<textarea name="note" class="form-control" placeholder="Write Note.."></textarea>
					</div>
					<div class="input-group input-group-sm" style="width: 250px;margin:5px 0;">
					<!--<?php if(general()->sms_status): ?>-->
					<!--	<label style="cursor: pointer;padding: 0 5px;"><input type="checkbox" name="mail_sms"> Send SMS</label>-->
					<!--<?php endif; ?>-->
					<!--<?php if(general()->mail_status): ?>-->
					<!--	<label style="cursor: pointer;padding: 0 5px;"><input type="checkbox" name="mail_send"> Send Mail</label>-->
					<!--<?php endif; ?>-->
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
					<br>
				</form>
				</div>

            </div>
	   </div>
	 </div>
   </div>
</div><?php /**PATH /home/meghfash/public_html/resources/views/admin/wholesale/includes/paymentModal.blade.php ENDPATH**/ ?>