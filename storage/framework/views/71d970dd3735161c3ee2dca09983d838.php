<div class="row" style="margin:0 -5px;">
    <div class="col-md-6" style="padding:5px;">
        <div class="form-group">
            <label>Customer*</label>
            <div class="searchCustomer">
                <div class="input-group">
                    <input type="text" placeholder="Search Customer"
                    <?php if($invoice->order_status=='delivered'): ?>
                    disabled=""
                    <?php endif; ?>
                    value="<?php if($invoice->name || $invoice->mobile): ?> <?php echo e($invoice->name); ?><?php echo e($invoice->mobile); ?><?php endif; ?>"
                    
                    data-url="<?php echo e(route('admin.posOrdersAction',['searchCustomer',$invoice->id])); ?>" class="searchValue form-control form-control-sm">
                    <span style="padding: 5px;background: gainsboro;"><i class="fa fa-search"></i></span>
                </div>
                <div class="searchCustomerResult">
                    <?php echo $__env->make(adminTheme().'pos-orders.includes.searchCustomers', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
            <!--<?php if($invoice->items()->count() > 0): ?>-->
            <!--<input type="text" readonly value="<?php echo e($invoice->name); ?> <?php echo e($invoice->mobile); ?>" class="form-control form-control-sm">-->
            <!--<?php else: ?>-->
            <!--<select class="form-control form-control-sm selectCustomer" data-url="<?php echo e(route('admin.posOrdersAction',['selectCustomer',$invoice->id])); ?>" name="customer" required="">-->
            <!--    <option value="">Select Customer</option>-->
            <!--    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>-->
            <!--    <option value="<?php echo e($customer->id); ?>" <?php echo e($customer->id==$invoice->user_id?'selected':''); ?>><?php echo e($customer->name); ?></option>-->
            <!--    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>-->
            <!--</select>-->
            <!--<?php endif; ?>-->
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
                <th style="min-width: 150px;text-align:left;">Product Name</th>
                <th style="width: 120px;min-width: 120px;">Barcode</th>
                <th 
                <?php if($invoice->order_status=='delivered'): ?>
                style="width: 100px;min-width: 100px;"
                <?php else: ?>
                style="width: 80px;min-width: 80px;"
                <?php endif; ?>
                
                >QTY</th>
                <th style="width: 70px;min-width: 70px;">Unit Price</th>
                <th style="width: 70px;min-width: 70px;">Unit Total</th>
                <!--<th style="width: 80px;min-width: 80px;">Disc %</th>-->
                <th style="width: 100px;min-width: 100px;">Disc UP</th>
                <th style="width: 120px;min-width: 120px;">TP Without VAT (<?php echo e(general()->currency); ?>)</th>
                <th style="width: 100px;min-width: 100px;">VAT %</th>
                <th style="width: 120px;min-width: 120px;">TP + VAT (<?php echo e(general()->currency); ?>)</th>
            </tr>
            <?php if($invoice->returnItems()): ?>
            <?php $__currentLoopData = $invoice->returnItems(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ritem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr
                <?php if($ritem->return_quantity > 0): ?>
                style="background: #ff864a;color: white;"
                <?php else: ?>
                style="background: #ff425c;color: white;"
                <?php endif; ?>
            >
                <td style="text-align:left;">
                    <?php echo e($ritem->id); ?>

                    <?php echo e($ritem->product_name); ?> (<?php echo e((float) $ritem->tax); ?>%+VAT)
                    <?php if(count($ritem->itemAttributes()) > 0): ?>
                    <br>
                    <span>
    				    <?php $__currentLoopData = $ritem->itemAttributes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$attri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    				        <?php if(isset($attri['title']) && isset($attri['value'])): ?>
                            <?php echo e($i==0?'':','); ?> <span><b><?php echo e($attri['title']); ?></b> : <?php echo e($attri['value']); ?></span>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </span>
    				<?php endif; ?>
                </td>
                <td><?php echo e($ritem->barcode); ?></td>
                <td>
                    <span>Return</span><br>
                    <span class="returnMinus" data-url="<?php echo e(route('admin.posOrdersAction',['cartreturnminus',$invoice->id,'item_id'=>$ritem->id])); ?>"><i class="fa fa-minus"></i></span>
                    <span class="returnPlus" data-url="<?php echo e(route('admin.posOrdersAction',['cartreturnplus',$invoice->id,'item_id'=>$ritem->id])); ?>"><i class="fa fa-plus"></i></span> 
                    <?php echo e($ritem->return_quantity); ?>/<?php echo e($ritem->quantity); ?>

                </td>
                
                <td><?php echo e(priceFormat($ritem->regular_price)); ?></td>
                <td><?php echo e(priceFormat($ritem->regular_price*$ritem->quantity)); ?></td>
                <td><?php echo e(priceFormat($ritem->regular_price-($ritem->regular_price*$ritem->discount/100))); ?> (<?php echo e((float)$ritem->discount); ?>%)</td>
                <td><?php echo e(priceFormat(($ritem->regular_price-($ritem->regular_price*$ritem->discount/100))*$ritem->quantity)); ?></td>
                <td><?php echo e(priceFormat($ritem->tax_amount)); ?></td>
                <td><?php echo e(priceFormat($ritem->final_price)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <?php endif; ?>
            
            
            <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td style="text-align:left;">
                    <?php echo e($item->product_name); ?> (<?php echo e((float) $item->tax); ?>%+VAT)
                    <?php if(count($item->itemAttributes()) > 0): ?>
                    <br>
                    <span>
    				    <?php $__currentLoopData = $item->itemAttributes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$attri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    				        <?php if(isset($attri['title']) && isset($attri['value'])): ?>
                            <?php echo e($i==0?'':','); ?> <span><b><?php echo e($attri['title']); ?></b> : <?php echo e($attri['value']); ?></span>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </span>
    				<?php endif; ?>
                </td>
                <td><?php echo e($item->barcode); ?></td>
                <td>
                    <div style="display:flex;">
                        <span class="minus" data-url="<?php echo e(route('admin.posOrdersAction',['cartminus',$invoice->id,'item_id'=>$item->id])); ?>"><i class="fa fa-minus"></i></span>    
                        <span class="quantity"><input type="number" readonly="" value="<?php echo e($item->quantity); ?>" placeholder="0" data-url="<?php echo e(route('admin.posOrdersAction',['cartquantity',$invoice->id,'item_id'=>$item->id])); ?>" /></span>
                        <span class="plus" data-url="<?php echo e(route('admin.posOrdersAction',['cartplus',$invoice->id,'item_id'=>$item->id])); ?>"><i class="fa fa-plus"></i></span>    
                    </div>
                </td>
                
                <td><?php echo e(priceFormat($item->regular_price)); ?></td>
                <td><?php echo e(priceFormat($item->regular_price*$item->quantity)); ?></td>
                <!--<td><?php echo e(priceFormat($item->tax_amount)); ?> (<?php echo e((float) $item->tax); ?>%) </td>-->
                <!--<td><?php echo e((float) $item->discount); ?></td>-->
                <td><?php echo e(priceFormat($item->regular_price-($item->regular_price*$item->discount/100))); ?> (<?php echo e((float)$item->discount); ?>%)</td>
                <td><?php echo e(priceFormat(($item->regular_price-($item->regular_price*$item->discount/100))*$item->quantity)); ?></td>
                <td><?php echo e(priceFormat($item->tax_amount)); ?></td>
                <td><?php echo e(priceFormat($item->final_price)); ?>

                <span class="removeItem" data-url="<?php echo e(route('admin.posOrdersAction',['cartremove',$invoice->id,'item_id'=>$item->id])); ?>"><i class="fa fa-trash"></i></span>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <?php if($invoice->items->count()==0): ?>
            <tr>
                <td colspan="9" style="text-align:center;">No Item found</td>
            </tr>
            <?php endif; ?>
        </table>
    </div>
</div>
<div class="totalInfo">
        <div class="GrandTotal">
            <span style="margin-right: 50px;">Total Qty: <?php echo e(number_format($invoice->items()->sum('quantity'))); ?></span>
            <span style="margin-right: 50px;">Total Unit Price (<?php echo e(number_format($invoice->totalRegularPrice())); ?>) + VAT (<?php echo e(number_format($invoice->tax_amount)); ?>) = <?php echo e(number_format($invoice->totalRegularPrice()+$invoice->tax_amount)); ?></span>
            <span>Total Payable : <?php echo e(priceFormat($invoice->grand_total)); ?></span>
        </div>
        <form class="SaleInfo" action="<?php echo e(route('admin.posOrdersAction',['completed-invoice',$invoice->id])); ?>" method="post">
            <?php echo csrf_field(); ?>
        <div class="row" style="margin:0 -10px;">
            <div class="col-md-8" style="padding:10px;">
                <div class="row payInformation" style="margin:0 -5px;">
                    <div class="col-md-6" style="padding:5px;">
                        
                        <div class="boxBar">
                            <h4>Card Payment</h4>
                            <?php
                                $cardMethod =$invoice->transections()->where('status','success')->where('payment_method','Card Method')->first();
                            ?>
                            <div class="Card_payent">
                                <div class="row" style="margin:0 -2px;">
                                    <label class="col-6" style="padding:2px;font-weight:bold;">
                                        Payment Getway
                                    </label>
                                    <div class="col-6" style="padding:2px;">
                                        <select class="form-control form-control-sm" name="pos_method">
                                            <option value="">Select POS</option>
                                            
                                            <?php $__currentLoopData = $accountsMethods->where('location','pos_method'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $posMethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($posMethod->id); ?>"><?php echo e($posMethod->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" style="margin:0 -2px;">
                                    <label class="col-6" style="padding:2px;font-weight:bold;">
                                        Select Card
                                    </label>
                                    <div class="col-6" style="padding:2px;">
                                        <select class="form-control form-control-sm" name="card_method">
                                            <option value="">Select Card</option>
                                            <?php $__currentLoopData = $accountsMethods->where('location','card_method'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $caMethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($caMethod->id); ?>"><?php echo e($caMethod->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" style="margin:0 -2px;">
                                    <label class="col-6" style="padding:2px;font-weight:bold;">
                                       Amount
                                    </label>
                                    <div class="col-6" style="padding:2px;">
                                        <input type="number" class="form-control form-control-sm ReceivedAmountNew CardAmountInput" name="card_amount" step="any"  placeholder="Amount" >
                                    </div>
                                </div>
                                <div class="row" style="margin:0 -2px;">
                                    <label class="col-6" style="padding:2px;font-weight:bold;font-size:14px;">
                                        CARD Digit
                                    </label>
                                    <div class="col-6" style="padding:2px;">
                                        <input type="text" class="form-control form-control-sm" name="card_digit"  placeholder="Enter CARD Digit">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="boxBar">
                            <h4>Mobile Banking</h4>
                            <div class="mobile_ayment">
                                <div class="row" style="margin:0 -2px;">
                                    <label class="col-6" style="padding:2px;font-weight:bold;">
                                        Mobile Banking
                                    </label>
                                    <div class="col-6" style="padding:2px;">
                                        <select class="form-control form-control-sm" name="mobile_method">
                                            <option value="">Select Banking</option>
                                             <?php $__currentLoopData = $accountsMethods->where('location','mobile_banking'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mobMethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($mobMethod->id); ?>"><?php echo e($mobMethod->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" style="margin:0 -2px;">
                                    <label class="col-6" style="padding:2px;font-weight:bold;">
                                       Amount
                                    </label>
                                    <div class="col-6" style="padding:2px;">
                                        <input type="number" class="form-control form-control-sm ReceivedAmountNew mobileAmountInput" name="mobile_amount" step="any" placeholder="Amount" >
                                    </div>
                                </div>
                                <div class="row" style="margin:0 -2px;">
                                    <label class="col-6" style="padding:2px;font-weight:bold;font-size:14px;">
                                        TNX Number
                                    </label>
                                    <div class="col-6" style="padding:2px;">
                                        <input type="text" class="form-control form-control-sm" name="mobile_tnx"  placeholder="Enter TNX Number">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-6" style="padding:5px;">
                       
                        <div class="boxBar">
                            <h4>Cash</h4>
                            <hr>
                            <div class="row" style="margin:0 -2px;">
                                <label class="col-6" style="padding:2px;font-weight:bold;">
                                   Cash Received
                                </label>
                                <div class="col-6" style="padding:2px;">
                                    <input type="number" class="form-control form-control-sm ReceivedAmountNew TotalAmount" name="cash_amount"  data-total="<?php echo e(str_replace(',', '', number_format($invoice->due_amount))); ?>" step="any" placeholder="Amount">
                                    <!--<div class="form-group m-0" style="font-size: 14px;color: #ff425c;font-weight: bold;">-->
                                    <!--    <label class="m-0">Change:</label><span class="returnAmount">0</span>-->
                                    <!--</div>-->
                                </div>
                            </div>
                               
                        </div>
                            <hr>
                        <div class="boxBar">
                            <h4>Customer & Discount</h4>
                            <div class="row" style="margin:0 -2px;">
                                <label class="col-6" style="padding:2px;">
                                    <select class="form-control form-control-sm DiscountType" data-url="<?php echo e(route('admin.posOrdersAction',['discountupdate',$invoice->id])); ?>">
            							<option value="" >No Discount</option>
            							<option value="percantage" <?php echo e($invoice->discount_type=='percantage'?'selected':''); ?> >Percantage(%)</option>
            							<!--<option value="flat" <?php echo e($invoice->discount_type=='flat'?'selected':''); ?>>Flat(<?php echo e(general()->currency); ?>)</option>-->
            						</select>
                                </label>
                                <div class="col-6" style="padding:2px;">
                                    <!--<select class="form-control form-control-sm DiscountInput"-->
                                    
                                    <!--<?php if($invoice->discount_type=='flat' || $invoice->discount_type=='percantage'): ?>-->
                                    <!--<?php else: ?>-->
                                    <!--disabled-->
                                    <!--<?php endif; ?> >-->
                                        
                                    <!--    <option value="">Select Discount</option>-->
                                    <!--    <option value="5" <?php echo e($invoice->discount ==5?'selected':''); ?> >5%</option>-->
                                    <!--    <option value="10" <?php echo e($invoice->discount ==10?'selected':''); ?> >10%</option>-->
                                    <!--    <option value="15" <?php echo e($invoice->discount ==15?'selected':''); ?> >15%</option>-->
                                    <!--    <option value="20" <?php echo e($invoice->discount ==20?'selected':''); ?> >20%</option>-->
                                    <!--    <option value="30" <?php echo e($invoice->discount ==30?'selected':''); ?> >30%</option>-->
                                    <!--    <option value="40" <?php echo e($invoice->discount ==40?'selected':''); ?> >40%</option>-->
                                    <!--    <option value="50" <?php echo e($invoice->discount ==50?'selected':''); ?> >50%</option>-->
                                        
                                    <!--</select>-->
                                    <input type="number" class="form-control form-control-sm DiscountInput"
                                    
                                    <?php if($invoice->discount_type=='flat' || $invoice->discount_type=='percantage'): ?>
                                    <?php else: ?>
                                    disabled
                                    <?php endif; ?>
                                    value="<?php echo e($invoice->discount > 0?$invoice->discount:''); ?>" placeholder="Enter Discount">
                                </div>
                            </div>
                            <div class="row" style="margin:0 -2px;">
                                <label class="col-6" style="padding:2px;">
                                    Adjustment Discount
                                </label>
                                <div class="col-6" style="padding:2px;">
                                    <input type="number" class="form-control form-control-sm adJustmentDiscount" data-url="<?php echo e(route('admin.posOrdersAction',['adjustmentupdate',$invoice->id])); ?>" value="<?php echo e($invoice->adjustment_amount > 0?$invoice->adjustment_amount:''); ?>" placeholder="Enter Amount">
                                </div>
                            </div>
                            <div class="row" style="margin:0 -2px;">
                                <label class="col-6" style="padding:2px;">
                                    Customer Name
                                </label>
                                <div class="col-6" style="padding:2px;">
                                    <input type="text" class="form-control form-control-sm" name="name" value="<?php echo e($invoice->name); ?>" placeholder="Enter Name">
                                </div>
                            </div>
                            <div class="row" style="margin:0 -2px;">
                                <label class="col-6" style="padding:2px;">
                                    Customer Mobile
                                </label>
                                <div class="col-6" style="padding:2px;">
                                    <input type="text" class="form-control form-control-sm" name="mobile" value="<?php echo e($invoice->mobile); ?>" placeholder="Enter Mobile">
                                </div>
                            </div>
                            <div class="row" style="margin:0 -2px;">
                                <label class="col-6" style="padding:2px;">
                                    Customer Email
                                </label>
                                <div class="col-6" style="padding:2px;">
                                    <input type="text" class="form-control form-control-sm" name="email" value="<?php echo e($invoice->email); ?>" placeholder="Enter email">
                                </div>
                            </div>
                            <?php if($invoice->member_card_id): ?>
                            <div class="row" style="margin:0 -2px;">
                                <label class="col-6" style="padding:2px;font-weight: bold;color: #ff864a;">
                                    Member Card
                                </label>
                                <div class="col-6" style="padding:2px;">
                                    <input type="text" class="form-control form-control-sm" readonly="" value="<?php echo e($invoice->member_card_id); ?>" placeholder="Enter Card ID">
                                </div>
                            </div>
                            <?php endif; ?>
                            <!--<button type="button" class="btn btn-md btn-info">Customer All</button>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="padding:10px;">
                <table class="table table-bordered summeryTable">
                    <tr>
                        <th>Sub Total</th>
                        <td style="min-width:100px;"><?php echo e(number_format($invoice->totalRegularPrice(),2)); ?></td>
                    </tr>
                    <!--<tr>-->
                    <!--    <th>Adjustment</th>-->
                    <!--    <td>-->
                    <!--        <input type="number" name="adjustment" class="form-control form-control-sm" placeholder="Enter Amount">-->
                    <!--    </td>-->
                    <!--</tr>-->
                    
                    <tr>
                        <th>Discount (-)</th>
                        <td><?php echo e(number_format($invoice->discount_amount,2)); ?></td>
                    </tr>
                    <tr>
                        <th>Total without VAT</th>
                        <td><?php echo e(number_format($invoice->totalRegularPrice()-$invoice->discount_amount,2)); ?></td>
                    </tr>
                    <tr>
                        <th>VAT (+)</th>
                        <td><?php echo e(number_format($invoice->tax_amount,2)); ?></td>
                    </tr>
                    <?php if($invoice->exchange_amount > 0): ?>
                    <tr>
                        <th>Exchange (-)</th>
                        <th style="text-align: center;font-size: 18px;"><?php echo e(priceFormat($invoice->exchange_amount,2)); ?></th>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th>Adjustment (-)</th>
                        <th style="text-align: center;font-size: 18px;"><?php echo e(priceFormat($invoice->adjustment_amount,2)); ?></th>
                    </tr>
                    
                    <tr>
                        <th>Grand Total</th>
                        <th style="text-align: center;font-size: 18px;"><?php echo e(number_format($invoice->grand_total,2)); ?></th>
                    </tr>
                    
                    <tr>
                        <th>Rounding (+/-)</th>
                        <td><?php echo e(number_format($invoice->grand_total - floor($invoice->grand_total),2)); ?></td>
                    </tr>
                    <tr>
                        <th>Total Payable</th>
                        <th style="text-align: center;font-size: 18px;"><?php echo e(priceFormat($invoice->grand_total,2)); ?></th>
                    </tr>
                    
                    <tr>
                        <th>Paid Amount</th>
                        <td><?php echo e(priceFormat($invoice->paid_amount)); ?></td>
                    </tr>
                    <?php if($invoice->extra_amount > 0): ?>
                    <tr>
                        <th>Extra Amount</th>
                        <td><?php echo e(priceFormat($invoice->extra_amount)); ?></td>
                    </tr>
                    <?php else: ?>
                    <tr>
                        <th>Due Amount</th>
                        <td style="color: #ffffff;background: #f44336;font-weight: bold;" class="dueAmountTotal" data-amount="<?php echo e(number_format($invoice->due_amount)); ?>"><?php echo e(priceFormat($invoice->due_amount)); ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th>Received Amount</th>
                        <td class="receivedTotalAmount"><?php echo e(priceFormat($invoice->received_amount)); ?></td>
                    </tr>
                    <tr>
                        <th>Change Amount</th>
                        <td class="returnAmount" style="color: green;"><?php echo e(priceFormat($invoice->changed_amount)); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div  class="row" style="margin:0 -5px;">
            <div class="col-md-3" style="padding:5px;">
                <button type="button" class="btn btn-block btn-success confirmInvoice" <?php echo e($invoice->items()->count()==0?'disabled':''); ?> <?php echo e($invoice->due_amount < 1?'':'disabled'); ?> >Confrim Order [F2]</button>
            </div>
            <div class="col-md-4" style="display: flex;justify-content: space-between;padding:5px;">
                <!--<a  class="btn btn-danger" href="<?php echo e(route('admin.posOrdersAction',['cartreset',$invoice->id])); ?>" onclick="return confirm('Are you want to Reset?')">Reset</a>-->
                <?php if($invoice->items()->count() > 0): ?>
                <!--<a  class="btn" href="<?php echo e(route('admin.posOrdersAction',['neworder',$invoice->id])); ?>" onclick="return confirm('Are you want to New order?')" target="_blank" style="background-color: #11a578;border-color: #11a578;color:white;">New Order</a>-->
                <?php endif; ?>
            </div>
            <div class="col-md-5" style="padding:5px;text-align: center;">
                <div class="" style="display: flex;justify-content: end;">
                    <!--<a href="<?php echo e(route('admin.posOrders')); ?>" class="btn btn-primary" data-url="<?php echo e(route('admin.posOrders')); ?>">Sales</a>-->
                    
                    <?php if($invoice->order_status!='delivered'): ?>
                    <div class="searchInvoice" style="width: 250px;position: relative;">
                        <span class="searchInviceFilterErr"></span>
                        <div class="input-group">
                            <span class="btn btn-danger" style="border-radius:0;">Exchange</span> 
                            <input type="text" class="form-control searchInviceFilter" data-url="<?php echo e(route('admin.posOrdersAction',['invoiceFilter',$invoice->id])); ?>" placeholder="Search Invoice No" autocomplete="off" style="border-radius:0;" >
                        </div>
                        <!--<div class="filterResult">-->
                        <!--    <ul>-->
                        <!--        <li>#252125145 - Bill: BDT 20,252</li>-->
                        <!--        <li>#2521251452 - Bill: BDT 1,020</li>-->
                        <!--    </ul>-->
                        <!--</div>-->
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        </form>
</div><?php /**PATH /home/meghfash/public_html/resources/views/admin/pos-orders/includes/shoppingCart.blade.php ENDPATH**/ ?>