 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Invoice')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>



<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Invoice</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Invoice</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.orders')); ?>">Back</a>
        </div>
    </div>
</div>

<div class="content-body">
    <!-- Basic Elements start -->
    <section class="basic-elements">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-9">
                <div class="card">
                    
                    <div>
                        <ul class="nav nav-tabs" role="tablist" style="border-bottom: none;">
                             <li class="nav-item">
                                 <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" role="tab" aria-selected="true"><i class="fas fa-file"></i>Full Invoice</a>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" role="tab" aria-selected="false"><i class="fas fa-truck"></i> Invoice Delivery Slip</a>
                             </li>
                        </ul>
                    </div>
                    
                    <div>
                        <div class="tab-content px-1 pt-1" style="border: 1px solid #ddd;">
                            <div class="tab-pane active" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
                                <button class="btn btn-success" id="PrintAction" ><i class="fa fa-print"></i> Print</button>
                                <div class="invoice-inner invoicePage PrintAreaContact">
                                    <style type="text/css">
                                        .invoice-inner {
                                            /*box-shadow: 0px 0px 5px #ccc;*/
                                            padding: 10px 20px;
                                        }
                                        
                                        .invoice-header {
                                            padding: 20px 0px 35px;
                                        }
                                    
                                        
                                        .invoice-header h6{
                                            margin-top: 15px!important;
                                        }
                                        
                                        .invoice-header h6, p{
                                            margin: 0;
                                            line-height: 15px;
                                            font-size: 12px;
                                        }
                                        
                                        .invoice-inner h2{
                                            margin: 10px 0px;
                                            font-size: 41px;
                                            letter-spacing: 3px;
                                            color: #00549e;
                                        }
                                        
                                        .ordrinfotable {
                                            padding: 10px 12px;
                                            border: 1px solid #ccc;
                                        }
                                        
                                        table.tableOrderinfo.table {
                                            margin: 0;
                                            padding: 0;
                                        }
                                        
                                        .tableOrderinfo td{
                                            padding: 0;
                                            font-size: 13px;
                                            line-height: 17px;
                                            border: none;
                                        }
                                        
                                        .mainTable{
                                            margin: 30px 0;
                                        }
                                        
                                        .mainproducttable{
                                            margin: 0;
                                            padding: 0;
                                            width: 100%;
                                        }
                                        
                                        .mainproducttable td{
                                            padding: 5px 7px;
                                            font-size: 12px;
                                            border: 1px solid #ccc;
                                        }
                                        
                                        .mainproducttable th{
                                            padding: 5px 7px;
                                            font-size: 12px;
                                            border: 1px solid #ccc;
                                        }
                                        
                                        tr.headerTable {
                                            background-color: #e2e2e2 !importent;
                                        }
                                        
                                        tr.headerTable td{
                                            font-size: 13px;
                                            padding: 7px;
                                        }
                                        
                                        .footerInvoice{
                                            margin-top: 100px;
                                        }
                                    
                                        @media only screen and (max-width: 567px) {
                                            .invoice-inner {
                                                padding: 10px;
                                                margin: 10px 0px;
                                            }
                                            .invoiceContainer{
                                                padding:0;
                                            }
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
                                    
                                    <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo $__env->make(adminTheme().'orders.includes.invoiceView', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <div style="page-break-after: always;"></div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                </div>
                            </div>
                            <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
                                <button class="btn btn-success" id="PrintAction2" ><i class="fa fa-print"></i> Print</button>
                                
                                <div class="SlipInvoice PrintAreaContact2">
                                    <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo $__env->make(adminTheme().'orders.includes.slipView', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>

            	    
                </div>

            </div>
        </div>
    </section>
    <!-- Basic Inputs end -->
</div>

<?php $__env->stopSection(); ?> 

<?php $__env->startPush('js'); ?> 


<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/admin/orders/multiInvoices.blade.php ENDPATH**/ ?>