<?php echo $message; ?>

<table class="table table-sm table-bordered table-striped">
        <thead>
            <tr>
                <th style="min-width: 50px;width:50px;padding: 8px 10px;">SL</th>
                <th style="min-width: 70px;width:50px">Image</th>
                <th style="min-width: 300px;">Items</th>
                <th style="min-width: 120px;width: 120px;">QTY</th>
                <th style="min-width: 120px;width: 120px;">Price</th>
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
                    
                    <b>Stock:</b>
                    <?php if($product=$item->product): ?>
    				<?php echo e($product->warehouseStock($order->branch_id,$item->variant_id)); ?>

    				<?php else: ?>
    				0
    				<?php endif; ?>
                    
                </td>
                 <td style="padding: 8px;">
                    <input type="number" name="quantity" placeholder="Enter quantity" value="<?php echo e($item->quantity); ?>" data-url="<?php echo e(route('admin.ordersAction',['item-quantity',$order->id])); ?>" data-id="<?php echo e($item->id); ?>" class="form-control itemUpdatePurchase">
                 </td>
                 <td style="padding: 8px;">
                    <input type="number" name="price" placeholder="Enter Price" value="<?php echo e($item->price); ?>" data-url="<?php echo e(route('admin.ordersAction',['item-price',$order->id])); ?>" data-id="<?php echo e($item->id); ?>" class="form-control itemUpdatePurchase">
                 </td>
                 <td>
                  <?php echo e(priceFullFormat($item->total_price)); ?>

                  <a href="javascript:void(0)"  data-url="<?php echo e(route('admin.ordersAction',['remove-item',$order->id])); ?>" data-id="<?php echo e($item->id); ?>" style="float:right" class="btn btn-sm btn-danger itemRemove">
                      <i class="fa fa-trash"></i>
                  </a>
                </td>
        </tr>
       
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </tbody>
    <thead>
        <tr>
            <th colspan="4"></th>
            <th style="vertical-align: middle;" >Adjustment Amount</th>
            <th>
                <label><input type="checkbox" class="shippingChargeApply" data-id="0" data-url="<?php echo e(route('admin.ordersAction',['shipping-apply',$order->id])); ?>" <?php echo e($order->shipping_apply?'checked':''); ?> > Shipping apply</label> 
                <label><input type="checkbox" class="shippingChargeApply" data-id="0" data-url="<?php echo e(route('admin.ordersAction',['free-shipping',$order->id])); ?>" <?php echo e($order->shipping_free?'checked':''); ?> > Free Shipping</label> 
                <input type="number" class="form-control adjustmentUpdate" value="<?php echo e($order->adjustment_amount); ?>" placeholder="Amount" data-id="0" data-url="<?php echo e(route('admin.ordersAction',['adjustment-amount',$order->id])); ?>" style="width: 250px;margin: auto;height: 35px;">
            </th>
        </tr>
        <tr>
            <th colspan="4"></th>
			<th style="vertical-align: middle;" >Select Courier</th>
			<td style="padding:3px;">
			    <?php if($order->courier_id): ?>
			          <?php
                        $courierInfo = json_decode($order->courier_data, true);
                        $status = $courierInfo['data']['order_status'] ?? null;
                    ?>
			        <b><?php echo e($order->courier); ?></b> - Status: <?php echo e($status?:$order->courier_status); ?> <br>
			        <b>ID:</b> 
			        <?php if($order->courier=='Carrybee'): ?>
			        <a href="https://merchant.carrybee.com/tracking?consignment_id=<?php echo e($order->courier_id); ?>" target="_blank">
			         <?php echo e($order->courier_id); ?> Carrybee
			         </a>
			        <?php elseif($order->courier=='Steadfast'): ?>
			         <a href="https://steadfast.com.bd/t/<?php echo e($order->courier_id); ?>" target="_blank">
			         <?php echo e($order->courier_id); ?> Steadfast
			         </a>
			        <?php else: ?>
			        <a href="https://merchant.pathao.com/public-tracking?consignment_id=<?php echo e($order->courier_id); ?>&phone=<?php echo e($order->mobile); ?>" target="_blank">
			         <?php echo e($order->courier_id); ?> Pathao
			         </a>
			         <?php endif; ?>
			    <?php else: ?>
			    <select class="form-control mb-1 courierSelect" data-url="<?php echo e(route('admin.ordersAction',['courier-select',$order->id])); ?>" name="courier" style="width: 250px;margin: auto;height: 35px;">
			        <option value="">Select Courier</option>
			        <option value="Pathao" <?php echo e($order->courier=='Pathao'?'selected':''); ?>  >Pathao</option>
			        <option value="Carrybee" <?php echo e($order->courier=='Carrybee'?'selected':''); ?>  >Carrybee</option>
			        <option value="Steadfast" <?php echo e($order->courier=='Steadfast'?'selected':''); ?>  >Steadfast</option>
			    </select>
			    <div class="courierData" style="width: 250px;margin:auto;">
			    </div>
			    <?php endif; ?>
			</td>
		</tr>
		<tr>
            <th colspan="4"></th>
            <th style="vertical-align: middle;" >Special Instruction</th>
            <th style="padding: 5px;">
                <textarea name="special_msg" class="form-control" placeholder="Special Note" data-id="0"  style="width: 250px;margin: auto;"><?php echo e($order->delivered_msg); ?></textarea>
            </th>
        </tr>
        <tr>
            <th colspan="5" style="vertical-align: top;">

                <h4><b>Admin Note:</b></h4>
                <div class="adminNoteAdd mt-3" data-order-id="<?php echo e($order->id); ?>">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control note-input" placeholder="Enter note">
                        <div class="input-group-append">
                            <span class="input-group-text add-note-btn" style="cursor: pointer;">Add Note</span>
                        </div>
                    </div>
                
                    <!-- Notes List -->
                    <ul class="notes-list" style="padding-left: 10px;">
                        <?php
                            $notes = $order->admin_note ? json_decode($order->admin_note, true) : [];
                        ?>
                        <?php $__empty_1 = true; $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li class="note-item" data-index="<?php echo e($index); ?>">
                                <span>
                                    <?php echo e($note[0]); ?>

                                    - <small>Msg By: <?php echo e($note[1]); ?> <?php echo e(\Carbon\Carbon::parse($note[2])->format('d-m-Y h:i A')); ?></small>
                                </span>
                                <span class="btn btn-sm btn-danger remove-note-btn">Delete</span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            
                        <?php endif; ?>
                    </ul>
                </div>
                
            </th>
            <th>
                
                <label><input type="checkbox"  name="facebook_order"  <?php echo e($order->facebook_order?'checked':''); ?> > Facebook Order</label> 
                <div class="input-group input-group-sm">
                    <select class="form-control" name="order_status" id="order_status" style="width: 250px;border: 2px solid #009688;height: 35px;">
        			  	<option	option <?php echo e($order->order_status == 'pending' ? 'selected' : ''); ?> value="pending">Pending</option>
                        <option <?php echo e($order->order_status == 'confirmed' ? 'selected' : ''); ?> value="confirmed">Confirmed</option>
                        <option <?php echo e($order->order_status == 'shipped' ? 'selected' : ''); ?> value="shipped">Shipped</option>
                        <option <?php echo e($order->order_status == 'delivered' ? 'selected' : ''); ?> value="delivered">Delivered</option>
                        <option <?php echo e($order->order_status == 'returned' ? 'selected' : ''); ?> value="returned">Returned</option>
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
                    <button class="btn btn-success" onclick="this.disabled = true; this.form.submit();" type="submit" style="width: 100%;background-color: #e91e63 !important;border-color: #e91e63;">
                    <i class="fa fa-check"></i>
                    Order Update
                   </button>
                </div>
            </th>
        </tr>
    </thead>
</table><?php /**PATH /home/meghfash/public_html/resources/views/admin/orders/includes/orderItems.blade.php ENDPATH**/ ?>