 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Invoice View')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css"></style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>


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
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.posOrdersAction','create')); ?>">New Order</a>
            <button class="btn btn-success" id="PrintAction" ><i class="fa fa-print"></i> Print</button>
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
                    <div class="col-3"></div>
                    <div class="col-6">
                        <div class="PrintAreaContact">

                                   
                        <style type="text/css">
                            .PrintAreaContact{
                                    max-width: 350px;
                                    margin:auto;
                            }
                            .invoiceHead {
                                text-align: center;
                            }

                            .invoiceHead p span {
                                display: block;
                                font-size: 14px;
                                line-height: 16px;
                            }
                            .invoiceBody tr th {
                                padding: 2px 5px;
                                border-bottom: 1px solid #eae7e7;
                                text-align:left;
                            }

                            .invoiceBody tr td {
                                padding: 2px 5px;
                                font-size: 13px;
                                border-bottom: 3px dotted #dddddd;
                            }
                            .paymentTable tr th {
                                background: #eeeeee;
                                padding: 3px 5px;
                                font-size: 10px;
                                    border-bottom: unset !important;
                            }

                            .paymentTable tr td {
                                border-bottom: 3px dotted #ddd;
                                padding: 2px 5px;
                                font-size: 12px;
                            }
                            @media print {
                                body {
                                    background-color: #ffffff;
                                    height: 100%;
                                    overflow: hidden;
                                }
                                .invoice-products {
                                    overflow: unset;
                                }
                            }
                        </style>

                            <div class="invoiceHead">
                                <!--<img src="<?php echo e(asset(general()->logo())); ?>" style="max-height: 100px;max-width: 100%;">-->
                                <h1 style="text-transform: uppercase;"><?php echo e(general()->title); ?></h1>
                                <p>
                                    <span><b>Date :</b> <?php echo e($invoice->created_at->format('d-m-Y')); ?></span>
                                    <span><b>Address :</b> <?php echo e(general()->address_one); ?></span>
                                    <span><b>Email :</b> <?php echo e(general()->email); ?></span>
                                    <span><b>Hotline :</b> <?php echo e(general()->mobile); ?></span>
                                    <span><b>Customer :</b> <?php echo e($invoice->name?:'Walk-In-Customer'); ?></span>
                                </p>
                            </div>
                            <div class="invoiceBody">
                                <table class="table table-borderless" style="min-width:100%;">
                                    <tr>
                                        <th>Items</th>
                                        <th style="text-align:end;">Price</th>
                                    </tr>
                                    <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($item->product_name); ?> <br> <?php echo e($item->quantity); ?> X <?php echo e(priceFormat($item->price)); ?></td>
                                        <td style="text-align:end;"><?php echo e(priceFormat($item->total_price)); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <tr style="border-bottom: 3px dotted #ddd;">
                                        <th>Sub Total</th>
                                        <td style="text-align:end;"><?php echo e(priceFormat($invoice->total_price)); ?></td>
                                    </tr>
                                    <tr style="border-bottom: 3px dotted #ddd;">
                                        <th >Shipping Charge</th>
                                        <td style="text-align:end;"><?php echo e(priceFormat($invoice->shipping_charge)); ?></td>
                                    </tr>
                                    <tr style="border-bottom: 3px dotted #ddd;">
                                        <th >Order Tax</th>
                                        <td style="text-align:end;">(<?php echo e($invoice->tax); ?>%)<?php echo e(priceFormat($invoice->tax_amount)); ?></td>
                                    </tr>
                                    <tr style="border-bottom: 3px dotted #ddd;">
                                        <th>Discount</th>
                                        <td style="text-align:end;"><?php echo e(priceFormat($invoice->discount_amount)); ?></td>
                                    </tr>
                                    <tr style="border-bottom: 3px dotted #ddd;">
                                        <th >Grand Total</th>
                                        <td style="text-align:end;"><?php echo e(priceFormat($invoice->grand_total)); ?></td>
                                    </tr>
                                    <tr style="border-bottom: 3px dotted #ddd;">
                                        <th>Due Total</th>
                                        <td style="text-align:end;"><?php echo e(priceFormat($invoice->due_amount)); ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="invoicBottom">
                                <hr>
                                <div class="paymentTable">
                                    <table class="table table-borderless" style="min-width:100%;">
                                        <tr>
                                            <th style="text-align:left;">Paid By</th>
                                            <th style="width: 100px;text-align: center;">Amount</th>
                                            <th style="width: 80px;text-align: end;">Change</th>
                                        </tr>
                                        <?php $__currentLoopData = $invoice->transections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($transection->payment_method); ?></td>
                                            <td style="text-align: center;"><?php echo e(priceFormat($transection->received_amount)); ?></td>
                                            <td style="text-align: end;"><?php echo e(priceFormat($transection->return_amount)); ?></td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <?php if($invoice->transections->count()==0): ?>
                                        <tr>
                                            <td colspan="3" style="text-align: center;">No Payment Received</td>
                                        </tr>
                                        <?php endif; ?>

                                        <tr>
                                            <th style="text-align:left;">Total</th>
                                            <td style="text-align: center;"><?php echo e(priceFormat($invoice->transections->sum('received_amount'))); ?></td>
                                            <td style="text-align: end;"><?php echo e(priceFormat($invoice->transections->sum('return_amount'))); ?></td>
                                        </tr>
                                        

                                    </table>
                                </div>
                                <p style="text-align: center;">
                                Thank You For Shopping With Us . Please Come Again
                                </p>
                            </div>
                        </div>     
                    </div>
                </div>
            </div>
                
            
                        
        </div>
    </div>
</div>

<?php echo $__env->make('admin.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?> <?php $__env->stopPush(); ?>
<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/posherbd/public_html/posher.com.bd/resources/views/admin/pos-orders/orderPosInvoice.blade.php ENDPATH**/ ?>