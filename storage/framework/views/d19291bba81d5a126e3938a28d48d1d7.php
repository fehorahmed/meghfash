 <?php $__env->startSection('title'); ?>
<title>Today Reports - <?php echo e(general()->title); ?> | <?php echo e(general()->subtitle); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css">
    .summeryReport {
        margin-top: 50px;
        padding: 25px;
        border: 1px solid #e7e5e5;
        margin: auto;
    }
    
    .summeryReport table tr td {
        border: 1px solid #eeeeee;
    }
    
</style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Today Reports</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Today Reports</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <button class="btn btn-success" id="PrintAction" ><i class="fa fa-print"></i> Print</button>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.reportsAll',$type)); ?>">
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
                        <h4 class="card-title">Today Reports</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <form action="<?php echo e(route('admin.reportsAll',$type)); ?>">
                                        <div class="input-group">
                                            <input type="date" name="startDate" value="<?php echo e(request()->startDate); ?>" class="form-control">
                                            <button type="submit" class="btn btn-success rounded-0">Search</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <br>
                                    <div class="summeryReport PrintAreaContact">
                                        <style>
                                            .summeryReport {
                                                width: 350px;
                                                padding: 15px;
                                            }
                                            .table-borderless {
                                                border-collapse: collapse;
                                            }
                                            .table-borderless tr td{
                                                color:black;
                                                padding:5px;
                                            }
                                        </style>
                                        <p style="text-align: center;font-weight: bold;">Report Date : <?php echo e($startDate->format('d-m-Y')); ?></p>
                                        <h3 style="font-family: sans-serif;color: black;font-weight: bold;"><b>Account Summery</b></h3>
                                        <div class="table table-port">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td style="width:200px;">Online Sale</td>
                                                    <td style="text-align:right;"><?php echo e(priceFullFormat($reports['todaySale'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:200px;">Sale Shipping Charge</td>
                                                    <td style="text-align:right;"><?php echo e(priceFullFormat($reports['todaySaleShipping'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>POS Sale</td>
                                                    <td style="text-align:right;"><?php echo e(priceFullFormat($reports['posSale'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Wholesale</td>
                                                    <td style="text-align:right;"><?php echo e(priceFullFormat($reports['todayWholesale'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Return</td>
                                                    <td style="text-align:right;"><?php echo e(priceFullFormat($reports['todayReturnSale'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Total Sale</b></td>
                                                    <td style="text-align:right;"><?php echo e(priceFullFormat($reports['todaySale']+$reports['posSale']+$reports['todayWholesale'])); ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                        
                                        <h3 style="font-family: sans-serif;color: black;font-weight: bold;">Expenses</h3>
                                        <div class="table table-port">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td style="width:200px;">Expense Cost</td>
                                                    <td style="text-align:right;"><?php echo e(priceFullFormat($reports['todayExpense'])); ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                        
  
                                        <?php if($methods1->count() > 0): ?>
                                        <h3 style="font-family: sans-serif;color: black;font-weight: bold;"><b>Online Payment</b></h3>
                                        <div class="table table-port">
                                            <table class="table table-borderless">
                                                <?php $__currentLoopData = $methods1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td style="width:200px;"><?php echo e($method->name); ?></td>
                                                    <td style="text-align:right;"><?php echo e(priceFullFormat($method->collection)); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><b>Total</b></td>
                                                    <td style="text-align:right;"><?php echo e(priceFullFormat($methods1->sum('collection'))); ?> </td>
                                                </tr>
                                                
                                            </table>
                                        </div>
                                        <?php endif; ?>
                                        <?php if($methods2->count() > 0): ?>
                                        <h3 style="font-family: sans-serif;color: black;font-weight: bold;"><b>Wholesale Payment</b></h3>
                                        <div class="table table-port">
                                            <table class="table table-borderless">
                                                <?php $__currentLoopData = $methods2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td style="width:200px;"><?php echo e($method->name); ?></td>
                                                    <td style="text-align:right;"><?php echo e(priceFullFormat($method->collection)); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><b>Total</b></td>
                                                    <td style="text-align:right;"><?php echo e(priceFullFormat($methods2->sum('collection'))); ?> </td>
                                                </tr>
                                                
                                            </table>
                                        </div>
                                        <?php endif; ?>
                                        <?php if($methods3->count() > 0): ?>
                                        <h3 style="font-family: sans-serif;color: black;font-weight: bold;"><b>POS Payment</b></h3>
                                        <div class="table table-port">
                                            <table class="table table-borderless">
                                                <?php $__currentLoopData = $methods3; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td style="width:200px;"><?php echo e($method->name); ?></td>
                                                    <td style="text-align:right;"><?php echo e(priceFullFormat($method->collection)); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><b>Total</b></td>
                                                    <td style="text-align:right;"><?php echo e(priceFullFormat($methods3->sum('collection'))); ?> </td>
                                                </tr>
                                                
                                            </table>
                                        </div>
                                        <?php endif; ?>
 
                                        
                                        <h3 style="font-family: sans-serif;color: black;font-weight: bold;"><b>Cash Statement</b></h3>
                                        <div class="table table-port">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td style="width:200px;">Previus Cash</td>
                                                    <td style="text-align:right;"><?php echo e(priceFullFormat($reports['preCash'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:200px;">Today Cash</td>
                                                    <td style="text-align:right;"><?php echo e(priceFullFormat($reports['cash'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:200px;">Cash Expenses</td>
                                                    <td style="text-align:right;"><?php echo e(priceFullFormat($reports['expenses'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:200px;">Cash Withdrawal</td>
                                                    <td style="text-align:right;"><?php echo e(priceFullFormat($reports['withdrawal'])); ?></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="width:200px;"><b>Available Cash</b></td>
                                                    <td style="text-align:right;"><?php echo e(priceFullFormat($reports['available'])); ?></td>
                                                </tr>
                                            </table>
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
    <!-- Basic Inputs end -->
</div>

<?php $__env->stopSection(); ?> 

<?php $__env->startPush('js'); ?> 

<script type="text/javascript">
	$()
</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/reports/todayReports.blade.php ENDPATH**/ ?>