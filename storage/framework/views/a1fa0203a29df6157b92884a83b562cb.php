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
                            
                            <div class="summeryParts">
                                <div class="row">
                                    <div class="col-md-4" style="padding: 15px">
                                        <div class="summeryPartsbox">
                                            <p><b><?php echo e(priceFullFormat($report['sales'])); ?></b><br>Sales</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="padding: 15px">
                                        <div class="summeryPartsbox">
                                            <p><b><?php echo e(priceFullFormat($report['paid'])); ?></b><br>Paid</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="padding: 15px">
                                        <div class="summeryPartsbox">
                                            <p><b><?php echo e(priceFullFormat($report['unpaid'])); ?></b><br>Due</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="padding: 15px">
                                        <div class="summeryPartsbox">
                                            <p><b><?php echo e(number_format($report['orders'])); ?></b><br>Orders</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="padding: 15px">
                                        <div class="summeryPartsbox">
                                            <p><b><?php echo e(number_format($report['pending'])); ?></b><br>Pending</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="padding: 15px">
                                        <div class="summeryPartsbox">
                                            <p><b><?php echo e(number_format($report['confirmed'])); ?></b><br>Confirmed</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="padding: 15px">
                                        <div class="summeryPartsbox">
                                            <p><b><?php echo e(number_format($report['delivered'])); ?></b><br>Delivered</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="padding: 15px">
                                        <div class="summeryPartsbox">
                                            <p><b><?php echo e(number_format($report['shipped'])); ?></b><br>Shipped</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="padding: 15px">
                                        <div class="summeryPartsbox">
                                            <p><b><?php echo e(number_format($report['cancelled'])); ?></b><br>Cancelled</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="padding: 15px">
                                        <div class="summeryPartsbox">
                                            <p><b><?php echo e(number_format($report['paidOrder'])); ?></b><br>Paid</p>
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



<?php $__env->stopSection(); ?> 

<?php $__env->startPush('js'); ?> 


<script type="text/javascript">
	
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/posherbd/public_html/posher.com.bd/resources/views/admin/reports/summeryReports.blade.php ENDPATH**/ ?>