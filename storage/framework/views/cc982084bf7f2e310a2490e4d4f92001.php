
    <div class="invoiceContainer">
        <div class="invoice-inner InnerInvoiePage" >
			<div class="invoice-header">
				<div class="row">
					<div class="col-4">
						<img src="<?php echo e(asset(general()->logo())); ?>" style="max-width: 100%;">
					</div>
					<div class="col-1"></div>
					<div class="col-7" style="text-align: end;">
						<h6>CONTACT INFORMATION:</h6>
						<p><?php echo e(general()->address_one); ?></p>
						<p><?php echo e(general()->mobile); ?></p>
						<p><?php echo e(general()->email); ?></p>
						<p><?php echo e(general()->website); ?></p>
					</div>
				</div>
			</div>
			<hr style="border: 2px solid #00549e; margin: 0;">
			<h2 style="margin: 10px 0px;font-size: 41px;letter-spacing: 3px;color: #00549e;">INVOICE</h2>
			<div class="orderInfo">
				<div class="row" style="flex-wrap: wrap;">
					<div class="col-3">
						<p>
							<b>Order To:</b><br>
							<b>Name:</b> <?php echo e($order->name); ?><br>
							<b>Mobile:</b> <?php echo e($order->mobile); ?><br>
							<b>Address:</b> <?php echo e($order->fullAddress()); ?>

						</p>
					</div>
					<div class="col-3">
					</div>
					<div class="col-6">
						<div class="ordrinfotable">
							<table class="tableOrderinfo table">
							  <thead>
							    <tr>
							      <td style="width: 40%;">Invoice Number</td>
							      <td>: <?php echo e($order->invoice); ?></td>
							    </tr>
							    <tr>
							      <td style="width: 40%;">Invoice Date</td>
							      <td>: <?php echo e($order->created_at->format('d-m-Y h:i A')); ?></td>
							    </tr>
							    <tr>
							      <td style="width: 40%;">Order Status</td>
							      <td>: <?php echo e(ucfirst($order->order_status)); ?></td>
							    </tr>
							    <tr>
							      <td style="width: 40%;">Payment Method</td>
							      <td>: <?php echo e(ucfirst($order->payment_method)); ?></td>
							    </tr>
							  </thead>
							</table>
						</div>							
					</div>
				</div>
			</div>
            
            <div class="table-responsive">
    			<div class="mainTable" style="margin: 30px 0;">
    				<table class="table mainproducttable">
					  <thead>
					    <tr class="headerTable">
					      <th style="min-width:300px;">Product Name & Description</th>
					      <th style="width: 120px;min-width:120px; text-align: center;">Unit Price</th>
					      <th style="width: 100px;min-width:100px; text-align: center;">Quantity</th>
					      <th style="width: 120px;min-width:120px; text-align: center;">Total Price</th>
					    </tr>
					  </thead>
					  <tbody>
					      
					    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					    <tr>
					      <td><?php echo e($item->product_name); ?>

                            
                            <?php if(count($item->itemAttributes()) > 0): ?>
                            <br>
							<span style="font-size: 14px;">
							    <?php $__currentLoopData = $item->itemAttributes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$attri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							        <?php if(isset($attri['title']) && isset($attri['value'])): ?>
                                    <?php echo e($i==0?'':','); ?> <span><?php echo e($attri['title']); ?> : <?php echo e($attri['value']); ?></span>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </span>
							<?php endif; ?>
		
							
							<?php if($item->warranty_note): ?>
							<br>
							 <small style="font-size: 12px;"><?php echo e($item->warranty_note); ?> -  <b><?php echo e($item->warranty_charge > 0?priceFullFormat($item->warranty_charge):'Free'); ?></b></small>
							<?php endif; ?>
					      </td>
					      <td style="text-align: center;"><?php echo e(priceFormat($item->price)); ?></td>
					      <td style="text-align: center;"><?php echo e($item->quantity); ?></td>
					      <td style="text-align: center;"><?php echo e(priceFormat($item->final_price)); ?></td>
					    </tr>
					    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					    
					    <tr>
					      <td colspan="3" style="text-align: end;">Subtotal</td>
					      <td style="text-align: center;"><?php echo e(priceFormat($order->total_price)); ?></td>
					    </tr>
					    <tr>
					      <td colspan="3" style="text-align: end;">Discount</td>
					      <td style="text-align: center;"><?php echo e(priceFormat($order->coupon_discount + $order->items->sum('total_coupon_discount'))); ?></td>
					    </tr>
					 
					    <tr>
					      <td colspan="3" style="text-align: end;">Shipping</td>
					      <td style="text-align: center;">
					      <?php if($order->shipping_charge>0): ?>
					      <?php echo e(priceFormat($order->shipping_charge)); ?>

					      <?php else: ?>
					      Free Shipping
					      <?php endif; ?>
					      </td>
					    </tr>
					    
					    <tr>
					      <td colspan="3" style="text-align: end;">Grand Total</td>
					      <td style="text-align: center;"><?php echo e(priceFormat($order->grand_total)); ?></td>
					    </tr>
					  </tbody>
					</table>
    			</div>
			</div>

			<div class="frozenTable">
				<div class="row" style="display:flex;">
					<div class="col-md-12" style="">
					    <?php if($order->payment_status=='paid'): ?>
					    <div class="paidsStatus" style="text-align:right;">
					        <img src="<?php echo e(asset('public/medies/paid.png')); ?>" style="max-width:80px;">
					    </div>
					     <?php endif; ?>
					</div>
					<?php if($order->note): ?>
    				<div class="col-12">
    				    <b>Order Note</b><br>
    				    <p><?php echo $order->note; ?></p>
    				</div>
    				<?php endif; ?>
    				
				</div>
			</div>

			<div class="footerInvoice">
				<div class="row" style="dispaly:flex;">
					<div class="col-6" style="flex: 0 0 50%;max-width: 50%;">
						<p>Thank you for shopping from <?php echo e(general()->title); ?></p>
					</div>
					<div class="col-6" style="text-align: end;flex: 0 0 50%;max-width: 50%;">
						------------------------
						<p>Authorised Sign</p>
					</div>
				</div>
			</div>
		</div>
    </div>
<?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/admin/orders/includes/invoiceView.blade.php ENDPATH**/ ?>