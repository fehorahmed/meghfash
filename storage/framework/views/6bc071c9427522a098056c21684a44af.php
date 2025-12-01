 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Sales Reports')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css">
    
    .summery p{
        margin-bottom: 5px;
        color:gray;
    }
    
    .summery h5{
        font-weight: bold;
        font-family: sans-serif;
        color: #4a4a4a;
    }
    
</style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Sales Reports</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Sales Reports</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.posOrdersReports')); ?>">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>

<?php echo $__env->make('admin.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="card">
    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
        <h4 class="card-title">Sales Reports</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form action="<?php echo e(route('admin.posOrdersReports')); ?>">
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <div class="input-group">
                            <input type="date" name="startDate" value="<?php echo e(request()->startDate?Carbon\Carbon::parse(request()->startDate)->format('Y-m-d') :''); ?>" class="form-control <?php echo e($errors->has('startDate')?'error':''); ?>" />
                            <input type="date" value="<?php echo e(request()->endDate?Carbon\Carbon::parse(request()->endDate)->format('Y-m-d') :''); ?>" name="endDate" class="form-control <?php echo e($errors->has('endDate')?'error':''); ?>" />
                            <button type="submit" class="btn btn-success rounded-0"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                </div>
            </form>
            
            <br>
            
            
            <div class="row">
                <div class="col-md-3">
                    <div class="summery">
                        <p>Today Sale (<?php echo e(number_format($report['today']['count'])); ?>)</p>
                        <h5>
                            <i class="fas fa-chart-line" style="color: green;"></i>
                            <?php echo e(priceFullFormat($report['today']['total'])); ?></h5>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="summery">
                        <p>Monthly Sale (<?php echo e(number_format($report['monthly']['count'])); ?>)</p>
                        <h5>
                            <i class="fas fa-chart-line" style="color: green;"></i>
                            <?php echo e(priceFullFormat($report['monthly']['total'])); ?></h5>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="summery">
                        <p>Yearly Sale (<?php echo e(number_format($report['yearly']['count'])); ?>)</p>
                        <h5>
                            <i class="fas fa-chart-line" style="color: green;"></i>
                            <?php echo e(priceFullFormat($report['yearly']['total'])); ?></h5>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="summery">
                        <p>Total Sale (<?php echo e(number_format($report['total']['count'])); ?>)</p>
                        <h5>
                            <i class="fas fa-chart-line" style="color: green;"></i>
                            <?php echo e(priceFullFormat($report['total']['total'])); ?></h5>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
        <h4 class="card-title">Sales List</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th>#Invoice</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Bill</th>
                        <th>Paid</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>#<?php echo e($order->invoice); ?></td>
                        <td><?php echo e($order->name); ?></td>
                        <td><?php echo e($order->items()->sum('quantity')); ?></td>
                        <td><?php echo e(priceFullFormat($order->grand_total)); ?></td>
                        <td><?php echo e($order->payment_status); ?></td>
                        <td><?php echo e($order->order_status); ?></td>
                        <td><?php echo e($order->created_at->format('d-m-Y')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>
            </div>            
       </div>
    </div>
</div>



<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?> <?php $__env->stopPush(); ?>
<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/posherbd/public_html/posher.com.bd/resources/views/admin/pos-orders/ordersReports.blade.php ENDPATH**/ ?>