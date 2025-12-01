<table class="table table-borderless">
	    <tr>
			<th>Delivery Charge:</th>
			<td><?php echo e(general()->currency); ?> <span class="shippingCharge"><?php echo e($order->shipping_charge); ?></span> </td>
		</tr>
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
			<td><?php echo e(priceFullFormat($order->paid_amount)); ?> | <?php echo e(priceFullFormat($order->total_purchase)); ?> | <?php echo e(priceFullFormat($order->profit_loss)); ?></td>
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
			<th>Payment Method:</th>
			<td><?php echo e($order->payment_method); ?></td>
		</tr>
		
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
	</table><?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/admin/orders/includes/orderSummery.blade.php ENDPATH**/ ?>