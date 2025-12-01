
 <?php $__env->startSection('title'); ?>
<title>Purchase Invoice</title>
<?php $__env->stopSection(); ?> 
<?php $__env->startPush('css'); ?>
<style type="text/css">
    
</style>
<?php $__env->stopPush(); ?> 

<?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Stock Manage</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Stock Manage</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.purchases')); ?>"><i class="fa fa-list"></i> Back</a>
            <a href="javascript:void(0)" id="PrintAction22" class="btn btn-outline-primary">
                 <i class="bx bx-printer"></i> Print
             </a>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.purchasesAction',$invoice->id)); ?>">
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
                        <h4 class="card-title">Stock Invoice</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                         <div class="invoice-inner invoicePage PrintAreaContact">
                            <style>
                                    .demo-info {
                                        text-align: center;
                                    }
                                
                                    .invoice-products table tr th {
                                        padding: 5px;
                                        font-size: 12px;
                                    }
                                    .invoice-products table tr td {
                                        padding: 2px 5px;
                                        text-align: center;
                                    }
                                    .terms-details{
                                        font-size: 14px;
                                    }
                                    .terms-details p {
                                        margin: 0;
                                        font-size: 11px;
                                        font-family: times new romance;
                                    }
                                    .invoice-info {
                                        text-align: right;
                                    }
                                    .footer-part{
                                        margin-top: 20px;
                                        text-align:center;
                                    }
                                    .footer-part p {
                                        font-size: 11px;
                                    }
                                    .footer-part p i.bx {
                                        font-weight: bold;
                                    }
                                    
                                    @media print {
                                        .table{
                                            border-collapse: collapse !important;
                                            margin-bottom: 15px;
                                        }
                                        .table-bordered td, .table-bordered th {
                                            border: 1px solid #dee2e6 !important;
                                        }
                                        .footer-part p {
                                            font-size: 10px !important;
                                        }
                                    }
                                    
                                    </style>
                            
                            <div class="demo-info">
                                            <img src="<?php echo e(asset(general()->logo())); ?>" alt="company-logo" style="max-width:400px;max-height: 100px;">
                                            <h6 style="font-size: 20px;border-top: 1px solid #cccccc;padding-top: 5px;margin:0;font-weight: bold;">PURCHASES INVOICE</h6>
                                        </div>
                                <div class="row">
                                    <div class="col-12">
                                        
                                    </div>
                                    <div class="col-4">
                                            <b>Invoice:</b> <?php echo e($invoice->invoice); ?><br>
                                            <b>Date:</b> <?php echo e($invoice->created_at->format('d.m.Y')); ?><br>
                                            <b>Status:</b> <?php echo e(ucfirst($invoice->order_status)); ?><br>
                                            <!--<b>Payment:</b> <?php echo e(ucfirst($invoice->payment_status)); ?>-->
                                    </div>
                                    <div class="col-4"></div>
                                    <div class="col-4">
                                        <div class="invoice-info">
                                            <b>Supplier</b>: <?php echo e($invoice->user?$invoice->user->name:''); ?><br>
                                            <b>Warehouse</b>: <?php echo e($invoice->branch?$invoice->branch->name:''); ?><br>
                                            <?php echo e($invoice->branch?$invoice->branch->description:''); ?>

                                        </div>
                                    </div>
                                </div>
                                
                                <div class="invoice-products">
                                    <br>
                                    <table class="table table-bordered" style="width: 100% !important;">
                                        <thead>
                                        <tr>
                                            <th style="width: 60px;min-width: 60px;text-align: center;">SL.</th>
                                            <th style="min-width: 300px;text-align: left;">PRODUCT NAME</th>
                                            <th style="width: 100px;min-width: 100px;text-align: center;">QUANTITY</th>
                                            <!--<th style="width: 100px;min-width: 100px;text-align: center;">PRICE (<?php echo e(general()->currency); ?>)</th>-->
                                            <!--<th style="width: 120px;min-width: 120px;text-align: center;">TOTAL PRICE (<?php echo e(general()->currency); ?>)</th>-->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($i+1); ?></td>
                                                <td style="text-align: left;">
                                                    <?php if(count($item->itemAttributes()) > 0): ?>
                                    					    <?php $__currentLoopData = $item->itemAttributes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$attri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    					        <?php if(isset($attri['title']) && isset($attri['value'])): ?>
                                                                <?php echo e($i==0?'':','); ?> <span><b><?php echo e($attri['title']); ?></b> : <?php echo e($attri['value']); ?></span>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            -
                                    					<?php endif; ?>
                                    				    <?php echo e($item->product_name); ?>

                                    				<?php if($item->barcode): ?>
                                    				    / <b>Barcode:</b> <?php echo e($item->barcode); ?>

                                    				<?php endif; ?>
                                                </td>
                                                <td><?php echo e($item->quantity); ?></td>
                                                <!--<td><?php echo e(priceFormat($item->price)); ?></td>-->
                                                <!--<td><?php echo e(priceFormat($item->total_price)); ?></td>-->
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <th colspan="2" style="text-align: end;font-size:16px;">Total QTY</th>
                                            <th style="text-align: center;font-size:16px;"><?php echo e(priceFormat($invoice->items->sum('quantity'))); ?></th>
                                        </tr>
                                        <!--<tr>-->
                                        <!--    <td></td>-->
                                        <!--    <td></td>-->
                                        <!--    <th colspan="2" style="text-align: end;font-size:16px;">Shipping Charge</th>-->
                                        <!--    <th style="text-align: center;font-size:16px;"><?php echo e(priceFormat($invoice->shipping_charge)); ?></th>-->
                                        <!--</tr>-->
                                        <!--<tr>-->
                                        <!--    <td></td>-->
                                        <!--    <td></td>-->
                                        <!--    <th colspan="2" style="text-align: end;font-size:16px;">Tax(<?php echo e($invoice->tax); ?>%)</th>-->
                                        <!--    <th style="text-align: center;font-size:16px;"><?php echo e(priceFormat($invoice->tax_amount)); ?></th>-->
                                        <!--</tr>-->
                                        <!--<tr>-->
                                        <!--    <td></td>-->
                                        <!--    <td></td>-->
                                        <!--    <th colspan="2" style="text-align: end;font-size:16px;">(-) Discount <?php if($invoice->discount_type!='flat'): ?>(<?php echo e($invoice->discount); ?>%)<?php endif; ?></th>-->
                                        <!--    <th style="text-align: center;font-size:16px;"><?php echo e(priceFormat($invoice->discount_amount)); ?></th>-->
                                        <!--</tr>-->
                                        <!--<tr>-->
                                        <!--    <td></td>-->
                                        <!--    <td></td>-->
                                        <!--    <th colspan="2" style="text-align: end;font-size:16px;">Grand Total</th>-->
                                        <!--    <th style="text-align: center;font-size:16px;"><?php echo e(priceFormat($invoice->grand_total)); ?></th>-->
                                        <!--</tr>-->
                                        </tbody>
                                    </table>
                                    
                                    <div class="terms-details" >
                                        <?php if($invoice->note): ?>
                                        <span><b>PURCHASES NOTE:</b></span>
                                        <br>
                                        <?php echo $invoice->note; ?>

                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="signature-part">
                                        <div class="row">
                                            <div class="col-6"><br><br>
                                                ------------------<br>
                                                <span style="font-size: 12px;"><b>RECEIVER'S SIGNATURE</b></span>
                                            </div>
                                            <div class="col-6" style="text-align: end;">
                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer-part">
                                        <p><?php if(general()->address_one): ?><i class="bx bx-map"></i> Office: <?php echo e(general()->address_one); ?>, <?php endif; ?> <?php if(general()->mobile): ?> <i class="bx bx-phone"></i> Phone: <?php echo e(general()->mobile); ?> <?php endif; ?> <?php if(general()->email): ?> <i class="bx bx-envelope"></i> <?php echo e(general()->email); ?> <?php endif; ?><br> <?php if(general()->address_two): ?> <i class="bx bx-map"></i>Factory: <?php echo e(general()->address_two); ?>, <?php endif; ?> <?php if(general()->mobile2): ?> <i class="bx bx-phone"></i> Phone: <?php echo e(general()->mobile2); ?> <?php endif; ?> <?php if(general()->email2): ?><i class="bx bx-envelope"></i> factory: <?php echo e(general()->email2); ?> <?php endif; ?> <?php if(general()->website): ?> <i class='bx bx-globe'></i> <?php echo e(general()->website); ?> <?php endif; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?>

<script>
    $(document).ready(function(){
        $('#PrintAction22').on("click", function () {
            $('.PrintAreaContact').printThis({
              	importCSS: false,
              	loadCSS: "https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap-grid.min.css",
            });
        });
    });
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\posher-react-laravel\resources\views/admin/purchases/purchasesInvoice.blade.php ENDPATH**/ ?>