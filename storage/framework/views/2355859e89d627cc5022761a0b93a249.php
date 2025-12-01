<?php echo $message; ?>

<div class="table-responsive">                 
		<table class="table table-bordered">
			<tr>
				<th style="min-width:50px;width:50px;">SL</th>
				<th>Product Name</th>
				<th style="min-width:100px;width:100px;">Stock</th>
				<th style="min-width:100px;width:100px;">Quantity</th>
				<th style="min-width:150px;width:150px;">Purchase Price</th>
				<th style="min-width:150px;width:150px;">Total Price</th>
				<th style="min-width:60px;width:60px;">
					<i class="fa fa-trash"></i>
				</th>
			</tr>
			<?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr>
				<td><?php echo e(++$i); ?></td>
				<td>
				    <?php echo e($item->product_name); ?> 
				    <?php if(count($item->itemAttributes()) > 0): ?>
					    -
					    <?php $__currentLoopData = $item->itemAttributes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$attri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					        <?php if(isset($attri['title']) && isset($attri['value'])): ?>
                            <?php echo e($i==0?'':','); ?> <span><b><?php echo e($attri['title']); ?></b> : <?php echo e($attri['value']); ?></span>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?>
				    
				<?php if($item->barcode): ?>
				    / <b>Barcode:</b> <?php echo e($item->barcode); ?>

				<?php endif; ?>
				</td>
				<td>
				<?php if($product=$item->product): ?>
				<?php echo e($product->warehouseStock($invoice->branch_id,$item->variant_id)); ?>

				<?php else: ?>
				0
				<?php endif; ?>
				<?php echo e($item->weight_unit); ?>

				</td>
				<td style="padding:3px;">
					<input type="text"  value="<?php echo e($item->quantity?:''); ?>"
					data-url="<?php echo e(route('admin.purchasesAction',['item-quantity',$invoice->id])); ?>"
					data-id="<?php echo e($item->id); ?>" class="form-control form-control-sm itemUpdatePurchase" placeholder="Enter Quantity" style="text-align: center;"
					>
				</td>
				<td style="padding:3px;">
					<input type="text"  value="<?php echo e($item->price?:''); ?>"
					data-url="<?php echo e(route('admin.purchasesAction',['item-price',$invoice->id])); ?>"
					data-id="<?php echo e($item->id); ?>" class="form-control form-control-sm itemUpdatePurchase" placeholder="Enter Price" step="any" style="text-align: center;"
					>
				</td>
				<td style="text-align: center;"><?php echo e(priceFormat($item->total_price)); ?></td>
				<td style="text-align: center;">
    				<span class="badge badge-danger itemRemove" data-url="<?php echo e(route('admin.purchasesAction',['remove-item',$invoice->id])); ?>" data-id="<?php echo e($item->id); ?>" style="cursor:pointer;"> <i class="fa fa-trash"></i> </span>
				</td>
			</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php if($invoice->items->count()==0): ?>
			<tr>
			    <td colspan="5" style="text-align: center;">No Item found</td>
			</tr>
			<?php endif; ?>
			<tr>
				<th colspan="3" style="text-align: right;">Total QTY:</th>
				<td style="text-align: center;">
					<?php echo e(priceFormat($invoice->items->sum('quantity'))); ?>

				</td>
				<td>
				   Grand Total 
				</td>
				<td style="text-align: center;" ><?php echo e(priceFormat($invoice->grand_total)); ?></td>
				<td></td>
			</tr>
			<!--<tr>-->
			<!--	<th colspan="5" style="text-align: right;">Shipping Charge</th>-->
			<!--	<td >-->
			<!--		<input type="number" -->
			<!--		style="text-align: center;"-->
			<!--		data-id="<?php echo e($invoice->id); ?>"-->
			<!--		data-url="<?php echo e(route('admin.purchasesAction',['shipping-charge',$invoice->id])); ?>"-->
			<!--		class="form-control form-control-sm itemUpdatePurchase" placeholder="0" step="any" value="<?php echo e($invoice->shipping_charge > 0 ?$invoice->shipping_charge:''); ?>">-->
			<!--	</td>-->
			<!--	<td>-->
					
			<!--	</td>-->
			<!--</tr>-->
			<!--<tr>-->
			<!--	<th colspan="5" style="text-align: right;">Tax(%)</th>-->
			<!--	<td style="text-align: center;">-->
			<!--		<div class="input-group">-->
			<!--			<input type="number" -->
			<!--			data-id="<?php echo e($invoice->id); ?>"-->
			<!--			data-url="<?php echo e(route('admin.purchasesAction',['tax-charge',$invoice->id])); ?>"-->
			<!--			class="form-control form-control-sm itemUpdatePurchase" placeholder="0" step="any" value="<?php echo e($invoice->tax); ?>">-->
			<!--			<input type="text" readonly="" style="text-align: center;" class="form-control form-control-sm" placeholder="0" value="<?php echo e($invoice->tax_amount); ?>">-->
			<!--		</div>-->
			<!--	</td>-->
			<!--	<td>-->
			<!--	</td>-->
			<!--</tr>-->
			<!--<tr>-->
			<!--	<th colspan="5" style="text-align: right;">(-) Discount</th>-->
			<!--	<td style="text-align: center;">-->
			<!--	<input type="text" readonly=""  style="text-align: center;" class="form-control form-control-sm" placeholder="0" step="any" value="<?php echo e($invoice->discount_amount); ?>">-->
			<!--		<div class="input-group">-->
			<!--			<select -->
			<!--			data-id="<?php echo e($invoice->id); ?>"-->
			<!--			data-url="<?php echo e(route('admin.purchasesAction',['discount-type',$invoice->id])); ?>"-->
			<!--			class="form-control form-control-sm itemUpdatePurchase">-->
			<!--				<option value="0" <?php echo e($invoice->discount_type=='percantage'?'selected':''); ?> >Percantage(%)</option>-->
			<!--				<option value="1" <?php echo e($invoice->discount_type=='flat'?'selected':''); ?>>Flat(<?php echo e(general()->currency); ?>)</option>-->
			<!--			</select>-->
			<!--			<input type="text" -->
			<!--			data-id="<?php echo e($invoice->id); ?>"-->
			<!--			data-url="<?php echo e(route('admin.purchasesAction',['discount',$invoice->id])); ?>"-->
			<!--			class="form-control form-control-sm itemUpdatePurchase" step="any" placeholder="0" value="<?php echo e($invoice->discount > 0 ?$invoice->discount:''); ?>">-->
			<!--		</div>-->
			<!--	</td>-->
			<!--	<td>-->
			<!--	</td>-->
			<!--</tr>-->
			<!--<tr>-->
			<!--	<th colspan="5" style="text-align: right;">Grand Total</th>-->
			<!--	<td style="text-align: center;">-->
			<!--		<?php echo e(priceFormat($invoice->grand_total)); ?>-->
			<!--	</td>-->
			<!--	<td></td>-->
			<!--</tr>-->
			<!--<tr>-->
			<!--	<th colspan="5" style="text-align: right;">Paid Amount</th>-->
			<!--	<td style="text-align: center;">-->
			<!--		<?php echo e(priceFormat($invoice->paid_amount)); ?>-->
			<!--	</td>-->
			<!--	<td></td>-->
			<!--</tr>-->
			<!--<tr>-->
			<!--	<th colspan="5" style="text-align: right;">Due Amount</th>-->
			<!--	<td style="text-align: center;">-->
			<!--		<?php echo e(priceFormat($invoice->due_amount)); ?>-->
			<!--	</td>-->
			<!--	<td></td>-->
			<!--</tr>-->
			<!--<?php if($invoice->extra_amount): ?>-->
			<!--<tr>-->
			<!--	<th colspan="5" style="text-align: right;">Return Amount</th>-->
			<!--	<td style="text-align: center;">-->
			<!--		<?php echo e(priceFormat($invoice->extra_amount)); ?>-->
			<!--	</td>-->
			<!--	<td></td>-->
			<!--</tr>-->
			<!--<?php endif; ?>-->
		</table>
	</div>

	<div class="row">
		<div class="col-md-8">

		</div>
		<div class="col-md-4">
		    <?php if($invoice->order_status=='delivered'): ?>
			    <input type="hidden" value="delivered" name="status">
    			<?php if($invoice->items->count() > 0): ?>
    			<div class="form-group">
    				<button type="sumit" class="btn btn-block btn-info submitPurchase" >Update</button>
    			</div>
    			<?php endif; ?>
    		<?php else: ?>
    			<div class="form-group mb-1">
    				<label>Order Status</label>
    				
    				<select 
    				class="form-control" name="status" required="">
    					<option value="pending" <?php echo e($invoice->order_status=='pending'?'selected':''); ?>>Pending</option>
    					<option value="delivered" <?php echo e($invoice->order_status=='delivered'?'selected':''); ?>>Delivered</option>
    					<option value="cancelled" <?php echo e($invoice->order_status=='cancelled'?'selected':''); ?>>Cancelled</option>
    				</select>
    				<?php if($errors->has('status')): ?>
    				<p style="color: red; margin: 0;"><?php echo e($errors->first('status')); ?></p>
    				<?php endif; ?>
    			</div>
    			<?php if($invoice->items->count() > 0): ?>
    			<div class="form-group">
    				<button type="sumit" class="btn btn-block btn-success submitPurchase" >Submit</button>
    			</div>
    			<?php endif; ?>
			<?php endif; ?>

		</div>
	</div><?php /**PATH /home/meghfash/public_html/resources/views/admin/purchases/includes/purchaseItems.blade.php ENDPATH**/ ?>