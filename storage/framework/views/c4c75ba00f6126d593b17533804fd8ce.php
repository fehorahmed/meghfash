 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Invoice View')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css"></style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jsbarcode/3.5.1/JsBarcode.all.min.js"></script>
<?php $__env->stopPush(); ?> 
<?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Invoice View</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Invoice View</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <button class="btn btn-success" id="PrintAction" ><i class="fa fa-print"></i> Print  [F2]</button>
            <a class="btn btn-outline-primary closePrint" href="javascript:void(0)">Close [F4]</a>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.posOrders')); ?>">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
        <h4 class="card-title">Invoice</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            
                <div class="invoice-design">
                
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="PrintAreaContact">
                         
                        <style type="text/css">
                            .PrintAreaContact{
                                    /*max-width: 350px;*/
                                    width: 380px;
                                    /*margin:auto;*/
                                    padding-left: 10px;
                            }
                            .invoiceHead {
                                text-align: center;
                            }

                            .invoiceHead p span {
                                display: block;
                                font-size: 14px;
                                line-height: 16px;
                                font-weight:bold;
                            }
                            .invoiceBody tr th {
                                padding: 2px 5px;
                                text-align:left;
                                color:black;
                            }

                            .invoiceBody tr td {
                                padding: 2px 5px;
                                font-size: 16px;
                                color:black;
                                font-weight:bold;
                            }
                            .paymentTable tr th {
                                background: #eeeeee;
                                padding: 3px 5px;
                                font-size: 10px;
                                color:black;
                                   
                            }

                            .paymentTable tr td {
                               
                                padding: 2px 5px;
                                font-size: 12px;
                                color:black;
                            }
                            
                            .table th, 
                            .table td {
                                border: none; 
                            }
                            
                       
                            .invoiceBody tr td {
                                border-bottom: 0 !important;
                            }
                            
                            .invoiceBody tr th {
                                border-top: 0 !important;
                            }
                                                        
                            @media print {
                                body {
                                    background-color: #ffffff;
                                    height: 100%;
                                    overflow: hidden;
                                    color:black;
                                }
                                .invoice-products {
                                    overflow: unset;
                                }
                            }
                        </style>

                            <div class="invoiceHead">
                                <img src="<?php echo e(asset(general()->posLogo())); ?>" style="max-height: 100px;max-width: 100%; margin-bottom: 5px;">
                                <p>
                                    <span style="margin-bottom: 10px;color: black;"><?php echo e(general()->address_one); ?></span>
                                    <span style="margin-bottom: 10px;color: black;"><b>Contact : </b><?php echo e(general()->email); ?>, <?php echo e(general()->mobile); ?> </span>
                                   
                                </p>
                            </div>
                            <!--<p style="margin-bottom: 10px;  text-align: center;"> ===Receipt=== </p>-->
                            <div style="text-align:center;">
                                <span style="font-size: 16px;color: black;display:inline-block;"><b>VAT Reg. No:</b>  006685006-0102 Mushak 6.3 </span>  
                            </div>
                            <div style="text-align:center;">
                                <span style="font-size: 14px;color: black;font-weight: bold;"><b>Invoice No:</b> #<?php echo e($invoice->invoice); ?></span> ,  <span style="font-size: 14px;color: black;font-weight: bold;"><b>Date: </b> <?php echo e($invoice->created_at->format('d M y h:i A')); ?></span> 
                            </div>
                          
                            <div style="text-align:center;margin-bottom: 8px;">
                                <span style="font-size: 14px;"><b>Invoice By:</b>  <?php echo e($invoice->soldBy?$invoice->soldBy->name:'Staff'); ?></span>   
                            </div>
                            <p style="text-align: center;"><b>BILL</b></p>
                            <div class="invoiceBody top">
                                <table class="table" style="min-width:100%;">
                                    <tbody>
                                    <tr>
                                        <th>Items</th>
                                        <th style="text-align: center;">Qty</th>
                                        <th style="text-align: center;">Rate</th>
                                        <!--<th>VAT</th>-->
                                        <th style="text-align:end;">Price</th>
                                    </tr>
                                    <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <?php echo e(Str::limit($item->product_name,25)); ?>

                                            <!--<br>-->
                                            <!--<small>(<?php echo e($item->tax); ?>% + VAT)</small>-->
                                        </td>
                                        <td style="text-align: center"><?php echo e($item->quantity); ?></td>
                                        <td style="text-align: center"><?php echo e(priceFormat($item->regular_price+($item->regular_price*$item->tax/100))); ?></td>
                                        <!--<td style="text-align: center"><?php echo e(priceFormat($item->tax_amount)); ?>-->
                                        <!--(<?php echo e((float) $item->tax); ?>%)-->
                                        <!--</td>-->
                                        <td style="text-align:end;"><?php echo e(priceFormat(($item->regular_price+($item->regular_price*$item->tax/100))*$item->quantity)); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  
                                                                        
                                </tbody></table>
                                <table style="width: 100%;">
                                    <tbody><tr style="">
                                        <th style="font-size: 16px;text-align: right;">Total Product Price
                                        <span style="font-size:15px;font-weight: normal;">(Inclusive VAT)</span>:
                                        </th>
                                        <td style="text-align:end;width:60px;min-width:60px;"><?php echo e(number_format($invoice->totalRegularPrice(),2)); ?></td>
                                    </tr>
                                    <tr style="">
                                        <th style="font-size: 16px;text-align: right;">Discount Percent:</th>
                                        <td style="text-align:end;"><?php echo e(number_format($invoice->discount,0)); ?>%</td>
                                    </tr>
                                    <tr style="">
                                        <th style="font-size: 16px;text-align: right;">Discount Amount:</th>
                                        <td style="text-align:end;"><?php echo e(number_format($invoice->discount_amount,2)); ?></td>
                                    </tr>
                                    <tr style="">
                                        <th style="font-size: 16px; font-weight: 500; text-align: right;">Adjustment:</th>
                                        <td style="text-align:end;">0</td>
                                    </tr>
                                    <!--<tr style="">-->
                                    <!--    <th style="font-size: 16px; font-weight: 500; text-align: right;">VAT:</th>-->
                                    <!--    <td style="text-align:end;"><?php echo e(number_format($invoice->tax_amount,2)); ?></td>-->
                                    <!--</tr>-->
                                    <?php if($invoice->exchange_amount > 0): ?>
                                    <tr style="">
                                        <th style="font-size: 16px; font-weight: 500; text-align: right;">Exchange (-):</th>
                                        <td style="text-align:end;"><?php echo e(number_format($invoice->exchange_amount,2)); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr style="">
                                        <th style="font-size: 16px; font-weight: 500; text-align: right;">Grand Total:</th>
                                        <td style="text-align:end;"><?php echo e(number_format($invoice->grand_total,2)); ?></td>
                                    </tr>
                                    <tr style="">
                                        <th style="font-size: 16px; font-weight: 500; text-align: right;">Rounding (+/-):</th>
                                        <td style="text-align:end;"><?php echo e(number_format($invoice->grand_total - floor($invoice->grand_total),2)); ?></td>
                                    </tr>
                                    
                                    <tr style="">
                                        <th style="font-size: 16px; font-weight: 500; text-align: right;"><b>Total Payable:</b></th>
                                        <td style="text-align:end;"><?php echo e(number_format($invoice->grand_total,0)); ?></td>
                                    </tr>
                                    <tr style="">
                                        <th style="font-size: 16px; font-weight: 500; text-align: right;">Paid Amount:</th>
                                        <td style="text-align:end;"><?php echo e(number_format($invoice->paid_amount,0)); ?></td>
                                    </tr>
                                    <tr style="">
                                        <th style="font-size: 16px; font-weight: 500; text-align: right;">Due Total:</th>
                                        <td style="text-align:end;"><?php echo e(number_format($invoice->due_amount,0)); ?></td>
                                    </tr>
                                    
                                    
                                    <tr style="">
                                        <th style="font-size: 16px; font-weight: 500; text-align: right;">Cash Amount:</th>
                                        <td style="text-align:end;">
                                            <?php if($cashMethod): ?>
                                            <?php echo e((float) $cashMethod->received_amount); ?>

                                            <?php else: ?>
                                            0
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr style="">
                                        <th style="font-size: 16px; font-weight: 500; text-align: right;">Card Amount:</th>
                                        <td style="text-align:end;">
                                            
                                            <?php if($cardMethod): ?>
                                            <?php echo e((float) $cardMethod->received_amount); ?>

                                            <?php else: ?>
                                            0
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr style="">
                                        <th style="font-size: 16px; font-weight: 500; text-align: right;">Mobile Payment Amount:</th>
                                        <td style="text-align:end;">
                                            <?php if($mobileMethod): ?>
                                            <?php echo e((float) $mobileMethod->received_amount); ?>

                                            <?php else: ?>
                                            0
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr style="">
                                        <th style="font-size: 16px; font-weight: 500; text-align: right;">Credit Slip Amount:</th>
                                        <td style="text-align:end;">0</td>
                                    </tr>
                                    <tr style="">
                                        <th style="font-size: 16px; font-weight: 500; text-align: right;">Voucher Amount:</th>
                                        <td style="text-align:end;">0</td>
                                    </tr>
                                    <tr style="">
                                        <th style="font-size: 16px; font-weight: 500; text-align: right;">Total Received:</th>
                                        <td style="text-align:end;"><?php echo e(priceFormat($invoice->transections->sum('received_amount'))); ?></td>
                                    </tr>
                                    <tr style="">
                                        <th style="font-size: 16px; font-weight: 500; text-align: right;">Change:</th>
                                        <td style="text-align:end;">
                                            <?php if($invoice->transections->sum('received_amount') > $invoice->grand_total): ?>
                                            <?php echo e(intval($invoice->transections->sum('received_amount')- (int) str_replace(',', '', number_format($invoice->grand_total)))); ?>

                                            <?php else: ?>
                                            0
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr style="">
                                        <th style="font-size: 16px; font-weight: 500; text-align: right;"><b>Payment Mode:</b></th>
                                        <td style="text-align:end;">
                                            <?php if($cardMethod): ?>
                                            Card ,
                                            <?php endif; ?>
                                            <?php if($mobileMethod): ?>
                                            Mobile Banking ,
                                            <?php endif; ?>
                                            <?php if($cashMethod): ?>
                                            Cash 
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </tbody></table>
                            </div>
                            <div class="invoicBottom">
                                <p style="text-align: justify; margin-top:30px; margin-bottom: 10px; font-size: 15px;color: black;font-weight: bold;line-height: 18px;">
                                    Items may be exchanged subject to Posher policies within 10 days,  An item may be exchanged only once.
                                    A product price tag and billing invoice may be required to exchange or refund. The product should be in 
                                    fresh condition. " Jewellery, beauty items, leather items. blazers, undergarments & accessories items 
                                    cannot be exchanged or refunded. A credit note may be issued at the same value of the returned product or 
                                    the same value of the invoice. Any discounted items cannot be refunded. <?php echo e(general()->tax); ?>% VAT on Pohser 
                                     products. <?php echo e(general()->import_tax); ?>% VAT on all other's item.
                                </p>
                                <p style="text-align: center; font-size: 13px;color: black;font-weight: bold;">
                                Thank You For Shopping With Us . Please Come Again
                                </p>
                                <div id="barcodeContainer"></div>
                                <script>
                                    var barcode ="<?php echo e($invoice->invoice); ?>";
                                    var $barcodeDiv = $("<div class='item' style='text-align:center;'>");
                                    $barcodeDiv.append("<svg class='barcode'></svg>");
                                    $barcodeDiv.append("</div>");
                                    $("#barcodeContainer").append($barcodeDiv);

                                    JsBarcode(".barcode", barcode, {
                                            textAlign: "center",
                                            textPosition: "center",
                                            format: "CODE128",
                                            font: "cursive",
                                            fontSize: 18,
                                            height: 40,
                                            textMargin: 1,
                                            displayValue: true
                                            });
                                </script>
                            </div>
                        </div>     
                    </div>
                </div>
                </div>
            </div>
                
            
                        
        </div>
    </div>
</div>

<?php echo $__env->make('admin.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
<script>
    $('.closePrint').click(function(){
        window.close();
    });
    
    $(document).keydown(function(event) {
        if (event.key === "F4") {
            window.close();
        }else if(event.key === "F2"){
             $('.PrintAreaContact').printThis();
        }
    });
    
    $(document).ready(function(){
        $('.PrintAreaContact').printThis();
    });
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/posherbd/public_html/resources/views/admin/pos-orders/PosInvoice.blade.php ENDPATH**/ ?>