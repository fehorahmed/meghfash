<div class="row" style="margin:0 -5px;">
    <div class="col-md-6" style="padding:5px;">
        <div class="form-group">
            <label>Customer*</label>
            <?php if($invoice->items()->count() > 0): ?>
            <input type="text" readonly value="<?php echo e($invoice->name); ?>" class="form-control form-control-sm">
            <?php else: ?>
            <select class="form-control form-control-sm selectCustomer" data-url="<?php echo e(route('admin.posOrdersAction',['selectCustomer',$invoice->id])); ?>" name="customer" required="">
                <option value="">Select Customer</option>
                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($customer->id); ?>" <?php echo e($customer->id==$invoice->user_id?'selected':''); ?>><?php echo e($customer->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-md-6" style="padding:5px;">
            <div class="form-group">
            <label>Warehouse/Branch*</label>
            <?php if($invoice->items()->count() > 0): ?>
            <input type="text" readonly value="<?php echo e($invoice->branch?$invoice->branch->name:''); ?>" class="form-control form-control-sm">
            <?php else: ?>
            <select class="form-control form-control-sm selectWarehouse" data-url="<?php echo e(route('admin.posOrdersAction',['selectWarehouse',$invoice->id])); ?>" name="customer" required="">
                <option value="">Select Warehouse</option>
                <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($warehouse->id); ?>" <?php echo e($warehouse->id==$invoice->branch_id?'selected':''); ?>><?php echo e($warehouse->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="orderItems">
    <?php echo $message; ?>

    <div class="errorMsg"></div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th style="min-width: 150px;text-align:left;">Item</th>
                <th style="width: 120px;min-width: 120px;">Price</th>
                <th style="width: 70px;min-width: 70px;">QTY</th>
                <th style="width: 120px;min-width: 120px;">Subtotal (<?php echo e(general()->currency); ?>)</th>
            </tr>
            <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td style="text-align:left;">
                <?php echo e($item->product_name); ?>

                </td>
                <td><?php echo e(priceFormat($item->price)); ?></td>
                <td >
                    <div style="display:flex;">
                        <span class="minus" data-url="<?php echo e(route('admin.posOrdersAction',['cartminus',$invoice->id,'item_id'=>$item->id])); ?>"><i class="fa fa-minus"></i></span>    
                        <span class="quantity"><input type="number" readonly="" value="<?php echo e($item->quantity); ?>" placeholder="0" data-url="<?php echo e(route('admin.posOrdersAction',['cartquantity',$invoice->id,'item_id'=>$item->id])); ?>" /></span>
                        <span class="plus" data-url="<?php echo e(route('admin.posOrdersAction',['cartplus',$invoice->id,'item_id'=>$item->id])); ?>"><i class="fa fa-plus"></i></span>    
                    </div>
                </td>
                <td><?php echo e(priceFormat($item->total_price)); ?>


                <span class="removeItem" data-url="<?php echo e(route('admin.posOrdersAction',['cartremove',$invoice->id,'item_id'=>$item->id])); ?>"><i class="fa fa-trash"></i></span>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <?php if($invoice->items->count()==0): ?>
            <tr>
                <td colspan="4" style="text-align:center;">No Item found</td>
            </tr>
            <?php endif; ?>
        </table>
    </div>
</div>
<div class="totalInfo">
    <div class="GrandTotal">
        Total Payable : <?php echo e(priceFullFormat($invoice->grand_total)); ?>

    </div>
    <div class="SaleInfo">
        <div  class="row" style="margin:0 -10px;">
            <div class="col-md-3" style="padding:10px;text-align:center;">
                <h4 style="margin: 0;font-size: 16px;font-weight: bold;">Dicount <i style="cursor:pointer;" data-toggle="modal" data-target="#DiscountAmount" class="fa fa-edit"></i></h4>
                <span style="font-size: 14px;"><?php echo e(priceFullFormat($invoice->discount_price)); ?></span>
            </div>
            <div class="col-md-3" style="padding:10px;text-align:center;">
                <h4 style="margin: 0;font-size: 16px;font-weight: bold;">Shipping <i style="cursor:pointer;" data-toggle="modal" data-target="#ShippingAmount" class="fa fa-edit"></i></h4>
                <span style="font-size: 14px;"><?php echo e(priceFullFormat($invoice->shipping_charge)); ?></span>
            </div>
            <div class="col-md-3" style="padding:10px;text-align:center;">
                <h4 style="margin: 0;font-size: 16px;font-weight: bold;">Tax <i style="cursor:pointer;" data-toggle="modal" data-target="#TaxAmount" class="fa fa-edit"></i></h4>
                <span style="font-size: 14px;">(<?php echo e($invoice->tax); ?>%) <?php echo e(priceFullFormat($invoice->tax_amount)); ?></span>
            </div>
            <div class="col-md-3" style="padding:10px;text-align:center;">
                <h4 style="margin: 0;font-size: 16px;font-weight: bold;">Sub Total</h4>
                <span style="font-size: 14px;"><?php echo e(priceFullFormat($invoice->total_price)); ?></span>
            </div>
        </div>
        <div  class="row">
            <div class="col-md-6">
                <button class="btn btn-block btn-success" data-toggle="modal" data-target="#PaymentAmount">Pay Now</button>
            </div>
            <div class="col-md-3">
                <button class="btn btn-danger resetInvoice" data-url="<?php echo e(route('admin.posOrdersAction',['cartreset',$invoice->id])); ?>">Reset</button>
            </div>
            <div class="col-md-3">
                <!-- <button class="btn btn-primary SalesList" data-url="<?php echo e(route('admin.posOrders')); ?>">Sales List</button> -->
            </div>
        </div>
    </div>
</div>

<!-- Payment  Modal -->
<div class="modal fade text-left" id="PaymentAmount" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
    	   <div class="modal-header" style="padding: 5px 10px;background: #17a2b8;">
    		 <h4 class="modal-title" style="font-size: 20px;color: white;">Payment Bill <?php echo e(priceFullFormat($invoice->grand_total)); ?></h4>
    		 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    		   <span aria-hidden="true">&times; </span>
    		 </button>
    	   </div>
    	   <div class="modal-body paymentTransectionAll">
                <?php echo $__env->make(adminTheme().'pos-orders.includes.invoiceTansection', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
	    </div>
    </div>
 </div>

 <!-- Payment  Modal -->
<div class="modal fade text-left" id="invoiceView" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="max-width: 330px;margin: auto;margin-top: 50px;">
        <div class="modal-content">
    	   <div class="modal-header" style="padding: 5px 10px;background: #17a2b8;">
    		 <h4 class="modal-title" style="font-size: 20px;color: white;">Invoice POS</h4>
    		 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    		   <span aria-hidden="true">&times; </span>
    		 </button>
    	   </div>
    	   <div class="modal-body invoicePOS">
            
            </div>
	    </div>
    </div>
 </div>

<!-- Discount Modal -->
<div class="modal fade text-left" id="DiscountAmount" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
    	   <div class="modal-header" style="padding: 5px 10px;background: #17a2b8;">
    		 <h4 class="modal-title" style="font-size: 20px;color: white;">Shipping</h4>
    		 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    		   <span aria-hidden="true">&times; </span>
    		 </button>
    	   </div>
    	   <div class="modal-body">
    	   		<div class="form-group">
                    <label>Discount</label>
                    <div class="input-group">
                        <select class="form-control DiscountType">
							<option value="percantage" <?php echo e($invoice->discount_type=='percantage'?'selected':''); ?> >Percantage(%)</option>
							<option value="flat" <?php echo e($invoice->discount_type=='flat'?'selected':''); ?>>Flat(<?php echo e(general()->currency); ?>)</option>
						</select>
                        <input type="number" class="form-control DiscountInput" value="<?php echo e($invoice->discount > 0?$invoice->discount:''); ?>" placeholder="Enter Shipping">
                        <div class="input-group-append">
                            <span class="input-group-text UpdateDiscount" data-url="<?php echo e(route('admin.posOrdersAction',['discountupdate',$invoice->id])); ?>" style="text-align: center;cursor:pointer;">
                                <i class="bx bx-check"></i> Update
                            </span>
                        </div>
                    </div>
                </div>
    	   </div>
	    </div>
    </div>
 </div>

<!-- Shipping Modal -->
<div class="modal fade text-left" id="ShippingAmount" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
    	   <div class="modal-header" style="padding: 5px 10px;background: #17a2b8;">
    		 <h4 class="modal-title" style="font-size: 20px;color: white;">Shipping</h4>
    		 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    		   <span aria-hidden="true">&times; </span>
    		 </button>
    	   </div>
    	   <div class="modal-body">
    	   		<div class="form-group">
                    <label>Shipping (<?php echo e(general()->currency); ?>)</label>
                    <div class="input-group">
                        <input type="number" class="form-control ShppingInput" value="<?php echo e($invoice->shipping_charge > 0?$invoice->shipping_charge:''); ?>" placeholder="Enter Shipping">
                        <div class="input-group-append">
                            <span class="input-group-text UpdateShipping" data-url="<?php echo e(route('admin.posOrdersAction',['shippingupdate',$invoice->id])); ?>" style="text-align: center;cursor:pointer;">
                                <i class="bx bx-check"></i> Update
                            </span>
                        </div>
                    </div>
                </div>
    	   </div>
	    </div>
    </div>
 </div>

<!-- Tax Modal -->
<div class="modal fade text-left" id="TaxAmount" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
    	   <div class="modal-header" style="padding: 5px 10px;background: #17a2b8;">
    		 <h4 class="modal-title" style="font-size: 20px;color: white;">Tax</h4>
    		 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    		   <span aria-hidden="true">&times; </span>
    		 </button>
    	   </div>
    	   <div class="modal-body">
    	   		<div class="form-group">
                    <label>Tax (%)</label>
                    <div class="input-group">
                        <input type="number" class="form-control TaxInput" value="<?php echo e($invoice->tax > 0 ?$invoice->tax:''); ?>" placeholder="Enter Tax">
                        <div class="input-group-append">
                            <span class="input-group-text UpdateTax" data-url="<?php echo e(route('admin.posOrdersAction',['taxupdate',$invoice->id])); ?>" style="text-align: center;cursor:pointer;">
                                <i class="bx bx-check"></i> Update
                            </span>
                        </div>
                    </div>
                </div>
    	   </div>
	    </div>
    </div>
 </div><?php /**PATH /home/posherbd/public_html/posher.com.bd/resources/views/admin/pos-orders/includes/shoppingCart.blade.php ENDPATH**/ ?>