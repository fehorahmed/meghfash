
 <?php $__env->startSection('title'); ?>
<title>Wholesale Invoice</title>
<?php $__env->stopSection(); ?> 
<?php $__env->startPush('css'); ?>
<style type="text/css">
    
</style>
<?php $__env->stopPush(); ?> 

<?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Wholesale Manage</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Wholesale Manage</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.wholeSales')); ?>"><i class="fa fa-list"></i> Back</a>
            <a href="javascript:void(0)" id="PrintAction22" class="btn btn-outline-primary">
                 <i class="bx bx-printer"></i> Print
             </a>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.wholeSalesAction',$invoice->id)); ?>">
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
                        <h4 class="card-title">Wholesale Invoice</h4>
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
                                            <p>
                                                <b>Mobile:</b> <?php echo e(general()->mobile); ?> , <b>Email:</b> <?php echo e(general()->mobile); ?> <br>
                                                <?php echo e(general()->address_one); ?>

                                            </p>
                                            <h6 style="font-size: 20px;border-top: 1px solid #cccccc;padding-top: 5px;margin:0;font-weight: bold;text-transform: uppercase;font-family: sans-serif;">Wholesale INVOICE</h6>
                                    </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="table-responsive">
                                            
                                            <table style="width: 400px;text-align:left;">
                                                <tr>
                                                    <th style="width: 100px;">Invoice</th>
                                                    <th style="width: 20px;">:</th>
                                                    <td><?php echo e($invoice->invoice); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Sale Date</th>
                                                    <th style="width: 20px;">:</th>
                                                    <td><?php echo e($invoice->created_at->format('d.m.Y')); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <th style="width: 20px;">:</th>
                                                    <td><?php echo e(ucfirst($invoice->order_status)); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Payment</th>
                                                    <th style="width: 20px;">:</th>
                                                    <td>
                                                        <?php echo e(ucfirst($invoice->payment_status)); ?>

                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-4"></div>
                                    <div class="col-4">
                                        <div class="table-responsive" style="float: right;">
                                            <table style="width: 400px;text-align:left;">
                                                <tr>
                                                    <th style="width: 150px;">Company</th>
                                                    <th style="width: 20px;">:</th>
                                                    <td><?php echo e($invoice->company_name); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Customer Name</th>
                                                    <th style="width: 20px;">:</th>
                                                    <td><?php echo e($invoice->name); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Mobile/Email</th>
                                                    <th style="width: 20px;">:</th>
                                                    <td><?php echo e($invoice->mobile?:$invoice->email); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Warehouse</th>
                                                    <th style="width: 20px;">:</th>
                                                    <td>
                                                        <?php echo e($invoice->branch?$invoice->branch->name:''); ?><br>
                                                        <?php echo e($invoice->branch?$invoice->branch->description:''); ?>

                                                    </td>
                                                </tr>
                                            </table>
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
                                            <th style="width: 130px;min-width: 130px;text-align: center;">PRICE (<?php echo e(general()->currency); ?>)</th>
                                            <th style="width: 150px;min-width: 150px;text-align: center;">TOTAL PRICE (<?php echo e(general()->currency); ?>)</th>
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

                                                </td>
                                                <td><?php echo e($item->quantity); ?></td>
                                                <td><?php echo e(priceFormat($item->price)); ?></td>
                                                <td><?php echo e(priceFormat($item->total_price)); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <th colspan="2" style="text-align: end;font-size:16px;">Total QTY</th>
                                            <th style="text-align: center;font-size:16px;"><?php echo e(priceFormat($invoice->items->sum('quantity'))); ?></th>
                                            <th style="font-size:16px;text-align:right;">Grand Total</th>
                                            <th style="text-align: center;font-size:16px;"><?php echo e(priceFormat($invoice->grand_total)); ?></th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <th colspan="2" style="text-align: end;font-size:16px;">Paid Amount</th>
                                            <th style="text-align: center;font-size:16px;"><?php echo e(priceFormat($invoice->paid_amount)); ?></th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <th colspan="2" style="text-align: end;font-size:16px;">Due Amount</th>
                                            <th style="text-align: center;font-size:16px;"><?php echo e(priceFormat($invoice->due_amount)); ?></th>
                                        </tr>
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
<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/admin/wholesale/invoice.blade.php ENDPATH**/ ?>