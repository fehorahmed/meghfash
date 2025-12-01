 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Order Manage')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css"></style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Order Manage</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Order Manage</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.orders')); ?>"><i class="fa fa-list"></i> Back</a>
            
            <a class="btn btn-success" href="<?php echo e(route('admin.invoice',$order->id)); ?>"><i class="fa fa-print"></i> Invoice</a>
            
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.ordersManage',$order->id)); ?>">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>


<div class="content-body">
    <!-- Basic Elements start -->
    <section class="basic-elements">
        <div class="row">
            <div class="col-md-12">
			<?php echo $__env->make('admin.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            	<div class="card">
                    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                        <h4 class="card-title">Customer Info</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                        	<div class="row">
                        		<div class="col-md-6">
                        		    <div class="table-responsive">
                        			<table class="table table-borderless">
                        			    <tr>
		                        			<th>INVOICE:</th>
		                        			<td><?php echo e($order->invoice); ?></td>
		                        		</tr>
		                        		
		                        		<tr>
		                        			<th>Name:</th>
		                        			<td><?php echo e($order->name); ?></td>
		                        		</tr>
		                        		<tr>
		                        			<th>Mobile:</th>
		                        			<td><?php echo e($order->mobile); ?></td>
		                        		</tr>
		                        		<tr>
		                        			<th>Email:</th>
		                        			<td><?php echo e($order->email); ?></td>
		                        		</tr>
		                        		<tr>
		                        			<th>Billing:</th>
		                        			<td><?php echo e($order->fullAddress()); ?></td>
		                        		</tr>
										<tr>
		                        			<th>Shipping:</th>
		                        			<td></td>
		                        		</tr>
		                        		<tr>
		                        			<th>Note:</th>
		                        			<td><?php echo $order->note; ?></td>
		                        		</tr>
		                        	</table>
		                        	</div>
                        		</div>
                        		<div class="col-md-6">
                        		    <div class="table-responsive">
                        			<table class="table table-borderless">
		                        		<tr>
		                        			<th>Grand Total:</th>
		                        			<td><?php echo e(priceFullFormat($order->grand_total)); ?>

											<?php if($order->return_amount>0): ?>
		                        			<span class="badge badge-success" style="background:#ff9800;">Refund</span> <?php echo e(priceFullFormat($order->return_amount)); ?>

		                        			<?php endif; ?>
											</td>
		                        		</tr>
		                        		<tr>
		                        			<th>Paid:</th>
		                        			<td><?php echo e(priceFullFormat($order->paid_amount)); ?></td>
		                        		</tr>
		                        		<tr>
		                        			<th>Due:</th>
		                        			<td><?php echo e(priceFullFormat($order->due_amount)); ?></td>
		                        		</tr>
		                        		<?php if($order->extra_amount): ?>
		                        		<tr>
		                        			<th>Advence:</th>
		                        			<td><?php echo e(priceFullFormat($order->extra_amount)); ?> 
		                        			
		                        			</td>
		                        		</tr>
		                        		<?php endif; ?>
		                        		
		                        		<tr>
		                        			<th>Payment:</th>
		                        			<td>
		                        			    <?php if($order->payment_status=='partial'): ?>
								                <span class="badge badge-success" style="background:#ff9800;"><?php echo e(ucfirst($order->payment_status)); ?></span>
								                <?php elseif($order->payment_status=='paid'): ?>
								                <span class="badge badge-success" style="background:#673ab7;"><?php echo e(ucfirst($order->payment_status)); ?></span>
								                <?php else: ?>
								                <span class="badge badge-success" style="background:#f44336;"><?php echo e(ucfirst($order->payment_status)); ?></span>
								                <?php endif; ?>
		                        			</td>
		                        		</tr>
		                        		<tr>
		                        			<th>Order Status:</th>
		                        			<td>

									            <?php if($order->order_status=='confirmed'): ?>
									            <span class="badge badge-success" style="background:#e91e63;"><?php echo e(ucfirst($order->order_status)); ?></span>
									            <?php elseif($order->order_status=='shipped'): ?>
									            <span class="badge badge-success" style="background:#673ab7;"><?php echo e(ucfirst($order->order_status)); ?></span>
									            <?php elseif($order->order_status=='delivered'): ?>
									            <span class="badge badge-success" style="background:#1c84c6;"><?php echo e(ucfirst($order->order_status)); ?></span>
									            <?php elseif($order->order_status=='cancelled'): ?>
									            <span class="badge badge-success" style="background:#f44336;"><?php echo e(ucfirst($order->order_status)); ?></span>
									            <?php else: ?>
									            <span class="badge badge-success" style="background:#ff9800;"><?php echo e(ucfirst($order->order_status)); ?></span>
									            <?php endif; ?>
		                        			    
		                        			</td>
		                        		</tr>
		                        		<tr>
		                        			<th>Date:</th>
		                        			<td><?php echo e($order->created_at->format('d-m-Y')); ?></td>
		                        		</tr>
		                        		<tr>
		                        			<th>Total Items:</th>
		                        			<td> <?php echo e($order->items->count()); ?> Items</td>
		                        		</tr>
		                        	</table>
		                        	</div>
                        		</div>
                        	</div>
                        	
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                        <h4 class="card-title">Orders Item</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                        	<form class="form-inline" method="post" action="<?php echo e(route('admin.ordersAction',['update',$order->id])); ?>">
					                <?php echo csrf_field(); ?>
					                <div class="table-responsive m-t">
					                    <table class="table table-sm table-bordered table-striped">
					                        <thead>
					                            <tr>
					                                <th style="min-width: 50px;width:50px;padding: 8px 10px;">SL</th>
					                                <th style="min-width: 70px;width:50px">Image</th>
					                                <th style="min-width: 300px;">Items</th>
					                                <th style="min-width: 120px;">QTY/Price</th>
					                                <th style="width: 250px;">Total</th>
					                            </tr>
					                        </thead>
					                        <tbody>

					                            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					                            <tr>
					                                <td style="padding: 8px 10px;"><?php echo e($i+1); ?></td>
					                               
					                                <td>
					                                    <img src="<?php echo e(asset($item->image())); ?>" style="max-height: 40px;max-width: 100%;">
					                                </td>
					                                
					                                <td>
					                                  <div><strong><?php echo e($item->product_name); ?></strong></div>
					                                  <small>
					                                    ID:<?php echo e($item->product_id); ?>

					                                    
					                                    
                            							<?php if(count($item->itemAttributes()) > 0): ?>
                            							    <?php $__currentLoopData = $item->itemAttributes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$attri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            							        <?php if(isset($attri['title']) && isset($attri['value'])): ?>
                                                                <?php echo e($i==0?'':','); ?> <span><?php echo e($attri['title']); ?> : <?php echo e($attri['value']); ?></span>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            							<?php endif; ?>
                            							
                            							<?php if($item->warranty_note): ?>
                            							<br>
                            							 <small style="font-size: 12px;"><?php echo e($item->warranty_note); ?> -  <b><?php echo e($item->warranty_charge > 0?priceFullFormat($item->warranty_charge):'Free'); ?></b></small>
                            							<?php endif; ?>
					                                    
					                                    
					                                    <?php if($item->sku_code): ?>
					                                    , SKU: <?php echo e($item->sku_code); ?> 
					                                    <?php endif; ?>
					                                    
					                                    <?php if($item->weight_unit && $item->weight_amount): ?>
					                                    , Weight: <?php echo e($item->weight_amount); ?> <?php echo e($item->weight_unit); ?> 
					                                    <?php endif; ?>
					                                    
					                                    <?php if($item->dimensions_unit && $item->dimensions_length || $item->dimensions_width  || $item->dimensions_height ): ?>
					                                    , Dimensions($item->dimensions_unit): L-<?php echo e($item->dimensions_length); ?> W-<?php echo e($item->dimensions_width); ?> H-<?php echo e($item->dimensions_height); ?>

					                                    <?php endif; ?>

					                                    
					                                    </small>
					                                    <?php if($item->returnItems->count() > 0): ?>
					                                    <?php if($item->return_type): ?>
					                                    <span class="badge badge-info" style="background: #ff9800;">Return</span>
					                                    <?php else: ?>
					                                    <span class="badge badge-primary" style="background: #ff5722;">Cancel</span>
					                                    <?php endif; ?>
					                                    <?php endif; ?>
					                                </td>
					                                <td><?php echo e($item->quantity); ?> X <?php echo e(priceFormat($item->price)); ?></td>
					                                 <td>
					                                  <?php echo e(priceFullFormat($item->total_price)); ?>

					                                </td>
					                        </tr>
					                       
					                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


					                    </tbody>

					                    <thead>
					                        <tr>
					                            <th colspan="4"></th>
					                            <th>

					                            <div class="input-group input-group-sm">

					                              <select class="form-control" name="order_status" id="order_status" style="width: 250px;border: 2px solid #009688;height: 35px;">
												  	<option	option <?php echo e($order->order_status == 'pending' ? 'selected' : ''); ?> value="pending">Pending</option>
					                                <option <?php echo e($order->order_status == 'confirmed' ? 'selected' : ''); ?> value="confirmed">Confirmed</option>
					                                <option <?php echo e($order->order_status == 'shipped' ? 'selected' : ''); ?> value="shipped">Shipped</option>
					                                <option <?php echo e($order->order_status == 'delivered' ? 'selected' : ''); ?> value="delivered">Delivered</option>
					                                <option <?php echo e($order->order_status == 'cancelled' ? 'selected' : ''); ?> value="cancelled">Cancelled</option>   
					                            </select>
					                        </div>
					                         <div class="input-group input-group-sm" style="width: 250px;margin:5px 0;">
											<?php if(general()->sms_status): ?>
					                            <label style="cursor: pointer;padding: 0 5px;"><input type="checkbox" name="sms_send"> Send SMS</label>
					                        <?php endif; ?>
											<?php if(general()->mail_status): ?>
												<label style="cursor: pointer;padding: 0 5px;"><input type="checkbox" name="mail_send"> Send Mail</label>
					                    	<?php endif; ?>
											</div>
					                        <div class="form-group">
					                            <button class="btn btn-success" type="submit" style="width: 100%;background-color: #e91e63 !important;border-color: #e91e63;">
					                            <i class="fa fa-check"></i>
					                            Order Update
					                           </button>
					                        </div>
					                 
					                </th>
					            </tr>
					        </thead>
					    </table>
					</div><!-- /table-responsive -->
					</form>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;padding: 1rem;">
                        <div class="row">
                        	<div class="col-md-6">
                        		<h4 class="card-title" style="padding: 5px;">Order Payment</h4>
                        	</div>
                        	<div class="col-md-6">
                        		<div class="left-tools" style="text-align: right;">
                        			<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#payment" style="padding: 8px 15px;border-radius: 0;"> <i class="fas fa-money"></i> payment</button>
                        		</div>
                        	</div>
                        </div>
                        
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                        	<h4>All Transactions:</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th style="min-width:150px;">Billing By</th>
                                    <th style="min-width:300px;">Billing Info</th>
                                    <th style="min-width:300px;">Note</th>
                                    <th style="min-width:150px;">Amount</th>
                                </tr>
                               <?php $__currentLoopData = $order->transactionsAll; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                               <tr>
                                <td>
                                    <b>TNX:</b> <?php echo e($transaction->transection_id); ?><br>
                                    <b>Method:</b> <?php echo e($transaction->method?$transaction->method->name:''); ?><br>
                                    
                                    <b>Date:</b> <?php echo e($transaction->created_at->format('Y-m-d h:i A')); ?>

                                </td>
                                <td>
                                    <b>Name:</b> <?php echo e($transaction->billing_name); ?> <br>
                                    <b>Mobile:</b> <?php echo e($transaction->billing_mobile); ?> <br>
                                    <b>E-mail:</b> <?php echo e($transaction->billing_email); ?> <br>
                                </td>
                                <td>
                                    <b>Type: </b><?php if($transaction->type==1): ?>
                                    <span class="badge badge-success" style="background:#00bcd4;">Recharge</span>
                                    <?php elseif($transaction->type==2): ?>
                                    <span class="badge badge-success" style="background:#ff9800;">Re-fund Order</span>
                                    <?php else: ?>
                                    <span class="badge badge-success" style="background:#8bc34a;">Order Payment</span>
                                    <?php endif; ?> <br>
                                    <b>Address:</b> <?php echo e($transaction->billing_address); ?><br>
                                    <b>Note:</b> <?php echo e($transaction->billing_note); ?>

                                </td>
                                <td><?php echo e($transaction->currency); ?> <?php echo e(number_format($transaction->amount,2)); ?>

                                    <br>
                                    <b>Status:</b> <?php echo e(ucfirst($transaction->status)); ?>

                                    <br>
                                    <a href="<?php echo e(route('admin.ordersAction',['payment-delete',$order->id,'transection_id'=>$transaction->id])); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are You Want To Delete?')">Delete</a>
                                </td>
                               </tr>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                               <?php if($order->transactionsAll->count()==0): ?>
                               <tr>
                                   <td colspan="4" style="text-align:center;">
                                           <span>No Transaction</span>
                                   </td>
                               </tr>
                               <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </section>
</div>


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
				<form action="<?php echo e(route('admin.ordersAction',['payment',$order->id])); ?>" method="post">
					<?php echo csrf_field(); ?>
					<input type="hidden" value="0" name="transaction_type">
					<div class="form-group">
						<label>Amount</label>
						<input type="number" class="form-control PayAmount" step="any" name="amount" placeholder="Enter Amount" value="<?php echo e($order->due_amount?:''); ?>">
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
				
				<!--<div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">-->
				<!--	<form action="<?php echo e(route('admin.ordersAction',['payment',$order->id])); ?>" method="post">-->
				<!--		<?php echo csrf_field(); ?>-->
				<!--		<input type="hidden" value="1" name="transaction_type">-->
				<!--		<div class="form-group">-->
				<!--			<label>Amount</label>-->
				<!--			<input type="number" class="form-control PayAmount" name="amount" placeholder="Enter Amount" value="<?php echo e($order->paid_amount); ?>">-->
				<!--		</div>-->
				<!--		<div class="form-group">-->
				<!--			<label>Method</label>-->
				<!--			<div class="input-group">-->
				<!--			<select class="form-control" name="method" required="">-->
				<!--				<option value="">Select Method</option>-->
				<!--			<?php $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>-->
				<!--				<option value="<?php echo e($method->id); ?>"><?php echo e($method->name); ?></option>-->
				<!--			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>-->
				<!--			</select>-->
				<!--			</div>-->
				<!--		</div>-->
				<!--		<div class="form-group">-->
				<!--			<label>Note</label>-->
				<!--			<textarea name="note" class="form-control" placeholder="Write Note.."></textarea>-->
				<!--		</div>-->
				<!--		<div class="input-group input-group-sm" style="width: 250px;margin:5px 0;">-->
				<!--			<?php if(general()->sms_status): ?>-->
				<!--				<label style="cursor: pointer;padding: 0 5px;"><input type="checkbox" name="mail_sms"> Send SMS</label>-->
				<!--			<?php endif; ?>-->
				<!--			<?php if(general()->mail_status): ?>-->
				<!--				<label style="cursor: pointer;padding: 0 5px;"><input type="checkbox" name="mail_send"> Send Mail</label>-->
				<!--			<?php endif; ?>-->
				<!--		</div>-->
				<!--		<button type="submit" class="btn btn-primary">Submit</button>-->
				<!--		<br>-->
				<!--	</form>-->
				<!--</div>-->
				
            </div>
	   </div>
	 </div>
   </div>
 </div>

<?php $__env->stopSection(); ?> 

<?php $__env->startPush('js'); ?>

<script>
    $(document).ready(function(){
        $('.paymentType').click(function(){
            var amount =$(this).data('amount');
            
            if(amount==0){
                amount='';
            }
            
            
            $('.PayAmount').val(amount);

        });
    });
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/posherbd/public_html/resources/views/admin/orders/ordersManage.blade.php ENDPATH**/ ?>