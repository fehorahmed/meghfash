 <?php $__env->startSection('title'); ?>
<title>Summery Reports - <?php echo e(general()->title); ?> | <?php echo e(general()->subtitle); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css">
	.summeryPartsbox {
        background: #f1f1f1;
        padding: 15px;
        box-shadow: 4px 7px 7px 0px #ccc;
        /*color: #fff;*/
        border-radius:10px;
    }
    
    .summeryPartsbox p{
        font-family: 'Montserrat';
        font-weight: 500;
    }
    
    .summeryPartsbox p b{
        font-size: 22px;
</style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Summery Reports</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Summery Report</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">

            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.reportsAll',$type)); ?>"> <i class="fa-solid fa-rotate"></i> </a>

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
                	<div class="card-header" style="border-bottom: 1px solid #e3ebf3;padding: 1rem;border-top: 2px solid #4859b9;">
                        <h4 class="card-title" style="padding: 5px;">Summery Reports</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.reportsAll',$type)); ?>">
                                <div class="row">
                                    <div class="col-md-3" style="padding: 15px">
                                        <input class="form-control" type="date" name="startDate" value="<?php echo e($from->format('Y-m-d')); ?>" placeholder="Start Date">
                                    </div>
                                    <div class="col-md-3" style="padding: 15px">
                                        <input class="form-control" type="date" name="endDate" value="<?php echo e($to->format('Y-m-d')); ?>" placeholder="End Date">
                                    </div>
                                    <div class="col-md-2" style="padding: 15px">
                                        <button class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="summeryParts" style="background: #f8f9f9;padding: 30px;">
                                
                                <div class="headPart" style="text-align: center;">
                                    <img src="<?php echo e(asset(general()->logo())); ?>" style="max-width:250px;" />
                                    <p>
                                        <b>Mobile:</b> <?php echo e(general()->mobile); ?>, <b>Email:</b> <?php echo e(general()->email); ?> <br>
                                        <b>Address:</b> <?php echo e(general()->address_one); ?>

                                    </p>
                                    <p>
                                        Date: <?php if($from->format('Y-m-d')==$to->format('Y-m-d')): ?> <?php echo e($from->format('Y-m-d')); ?> <?php else: ?> <?php echo e($from->format('Y-m-d')); ?> - <?php echo e($to->format('Y-m-d')); ?> <?php endif; ?>
                                    </p>
                                    
                                </div>
                                
                                <h3>Today Report</h3>    
                                <div class="row">
                                    <div class="col-md-3">
                                        <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                                            <div style="color: #959595;">Total Sales <small>(BDT)</small></div>
                                            <div style="color: black;font-size: 20px;font-weight: bold;"><?php echo e(number_format($report['totalSales'])); ?></div>
                                            
                                            <?php if($report['grothSales'] > 0): ?>
                                            <div style="color: green;">
                                            <?php else: ?>
                                            <div style="color: red;">
                                            <?php endif; ?>
                                            
                                            :<?php echo e(number_format($report['grothSales'],1)); ?>

                                            %</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                                            <div style="color: #959595;">POS Sales <small>(BDT)</small></div>
                                            <div style="color: black;font-size: 20px;font-weight: bold;"><?php echo e(number_format($report['posSales'])); ?></div>
                                            <?php if($report['grothPosSales'] > 0): ?>
                                            <div style="color: green;">
                                            <?php else: ?>
                                            <div style="color: red;">
                                            <?php endif; ?>
                                                :<?php echo e(number_format($report['grothPosSales'],1)); ?>

                                                %</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                                            <div style="color: #959595;">Online Sales <small>(BDT)</small></div>
                                            <div style="color: black;font-size: 20px;font-weight: bold;"><?php echo e(number_format($report['onlineSales'])); ?></div>
                                            <?php if($report['grothOnlineSales'] > 0): ?>
                                            <div style="color: green;">
                                            <?php else: ?>
                                            <div style="color: red;">
                                            <?php endif; ?>
                                                :<?php echo e(number_format($report['grothOnlineSales'],1)); ?>

                                                %</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                                            <div style="color: #959595;">New Customer</div>
                                            <div style="color: black;font-size: 20px;font-weight: bold;"><?php echo e(number_format($report['customer'])); ?></div>
                                            <?php if($report['preCustomer'] > 0): ?>
                                            <div style="color: green;">
                                            <?php else: ?>
                                            <div style="color: red;">
                                            <?php endif; ?>
                                                :<?php echo e(number_format($report['preCustomer'],1)); ?>

                                                %</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div style="padding: 15px;background: white;margin-top: 20px;">
                                    <h3>POS Sales List</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Invoice</th>
                                                    <th>Customer</th>
                                                    <th>Items</th>
                                                    <th>Bill</th>
                                                    <th>Payment</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <trbody>
                                                <?php $__currentLoopData = $posOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>#<?php echo e($pOrder->invoice); ?></td>
                                                    <td><?php echo e($pOrder->name); ?></td>
                                                    <td><?php echo e($pOrder->items()->count()); ?></td>
                                                    <td><?php echo e(priceFullFormat($pOrder->grand_total)); ?></td>
                                                    <td><?php echo e(ucfirst($pOrder->payment_status)); ?></td>
                                                    <td><?php echo e($pOrder->created_at->format('d-m-Y')); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($posOrders->count()==0): ?>
                                                <tr>
                                                    <td style="text-align:center;" colspan="6">No Sales Order</td>
                                                </tr>
                                                <?php endif; ?>
                                            </trbody>
                                        </table>
                                    </div>
                                </div>
                                <div style="padding: 15px;background: white;margin-top: 20px;">
                                    <h3>Online Sales List</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Invoice</th>
                                                    <th>Customer</th>
                                                    <th>Items</th>
                                                    <th>Bill</th>
                                                    <th>Payment</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <trbody>
                                                <?php $__currentLoopData = $customerOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>#<?php echo e($pOrder->invoice); ?></td>
                                                    <td><?php echo e($pOrder->name); ?></td>
                                                    <td><?php echo e($pOrder->items()->count()); ?></td>
                                                    <td><?php echo e(priceFullFormat($pOrder->grand_total)); ?></td>
                                                    <td><?php echo e(ucfirst($pOrder->payment_status)); ?></td>
                                                    <td><?php echo e($pOrder->created_at->format('d-m-Y')); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($customerOrders->count()==0): ?>
                                                <tr>
                                                    <td style="text-align:center;" colspan="6">No Customer Order</td>
                                                </tr>
                                                <?php endif; ?>
                                            </trbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div style="padding: 15px;background: white;margin-top: 20px;">
                                    <h3>Yearly Total Sales</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Month</th>
                                                    <th>Total Sales</th>
                                                    <th>POS Sales</th>
                                                    <th>Online Sales</th>
                                                    <th>New Customer</th>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                <?php $__currentLoopData = $monthlyData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($data['month']); ?></td>
                                                        <td><?php echo e(priceFullFormat($data['total'], 2)); ?></td> 
                                                        <td><?php echo e(priceFullFormat($data['posTotal'], 2)); ?></td>
                                                        <td><?php echo e(priceFullFormat($data['onlineTotal'], 2)); ?></td>
                                                        <td><?php echo e(priceFormat($data['customerTotal'])); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
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



<?php $__env->stopSection(); ?> 

<?php $__env->startPush('js'); ?> 


<script type="text/javascript">
	
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/admin/reports/summeryReports.blade.php ENDPATH**/ ?>