 <?php $__env->startSection('title'); ?>
<title>Customer Reports - <?php echo e(general()->title); ?> | <?php echo e(general()->subtitle); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css"></style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Customer Reports</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Customer Reports</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">

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
                    <div class="card-content">
                            <div id="accordion">
                                <div
                                    class="card-header collapsed"
                                    data-toggle="collapse"
                                    data-target="#collapseTwo"
                                    aria-expanded="false"
                                    aria-controls="collapseTwo"
                                    id="headingTwo"
                                    style="background:#009688;padding: 15px 20px; cursor: pointer;"
                                >
                                    Search click Here..
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="border: 1px solid #00b5b8; border-top: 0;">
                                    <div class="card-body">
                                        <form action="<?php echo e(route('admin.reportsAll',$type)); ?>">
                                            <div class="row">
                                                <div class="col-md-5 mb-1">
                                                    <div class="input-group">
                                                        <input type="date" name="startDate" value="<?php echo e(request()->startDate); ?>" class="form-control" />
                                                        <input type="date" name="endDate"  value="<?php echo e(request()->endDate); ?>" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-md-7 mb-1">
                                                    <div class="input-group">
                                                        <input type="text" name="search" value="<?php echo e(request()->search); ?>" placeholder="Search Customer Name, Email" class="form-control" />
                                                        <button type="submit" class="btn btn-success rounded-0">Search</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                        <h4 class="card-title">Customer Reports</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="min-width: 60px;">
                                                    <label style="cursor: pointer; margin-bottom: 0;"> S:L </label>
                                                </th>
                                                <th style="min-width: 130px;">Name</th>
                                                <th style="min-width: 120px;">Email</th>
                                                <th style="min-width: 120px;">Mobile</th>
                                                <th style="min-width: 100px;">Orders</th>
                                                <th style="min-width: 100px;">Purchase</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($customers->currentpage()==1?$i+1:$i+($customers->perpage()*($customers->currentpage() - 1))+1); ?></td>
                                                <td><?php echo e($customer->name); ?></td>
                                                <td><?php echo e($customer->email); ?></td>
                                                <td><?php echo e($customer->mobile); ?></td>
                                                <td><?php echo e($customer->orders()->where('order_type','customer_order')->count()); ?></td>
                                                <td><?php echo e(priceFullFormat($customer->orders()->where('order_type','customer_order')->sum('grand_total'))); ?></td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                    
                                </div>
                                
                                <?php echo e($customers->links('pagination')); ?>


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

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/posherbd/public_html/resources/views/admin/reports/customerReports.blade.php ENDPATH**/ ?>