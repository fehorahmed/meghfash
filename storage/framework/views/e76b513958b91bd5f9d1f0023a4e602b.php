 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Sales Today Report')); ?></title>
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
    
    .selectPercentage {
        display: inline-block;
        margin-right: 10px;
        border: 1px solid gray;
        color: #000000;
        margin-bottom: 10px;
        width: 100px;
        text-align: center;
        background: #e2dfdf;
        cursor: pointer;
    }
    
</style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Sales Today Report</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Sales Today Report</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.posOrdersToday')); ?>">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>

<?php echo $__env->make('admin.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="card">
    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
        <h4 class="card-title">Sales Today Report</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form action="<?php echo e(route('admin.posOrdersToday')); ?>">
                <div class="row">
                    <div class="col-md-3 mb-1">
                        <div class="input-group">
                            <input type="date" name="startDate" value="<?php echo e($from->format('Y-m-d')); ?>" class="form-control <?php echo e($errors->has('startDate')?'error':''); ?>" />
                            <button type="submit" class="btn btn-success rounded-0"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                    <div class="col-md-7 mb-1">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="summery">
                                    <p>Today Sale (<?php echo e(number_format(0)); ?>)</p>
                                    <h5>
                                        <i class="fas fa-chart-line" style="color: green;"></i>
                                        <?php echo e(priceFullFormat($orders->sum('grand_total'))); ?></h5>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="summery">
                                    <p>Card (<?php echo e(number_format(0)); ?>)</p>
                                    <h5>
                                        <i class="fas fa-chart-line" style="color: green;"></i>
                                        <?php echo e(priceFullFormat($orders->sum('total_card'))); ?></h5>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="summery">
                                    <p>Mobile (<?php echo e(number_format(0)); ?>)</p>
                                    <h5>
                                        <i class="fas fa-chart-line" style="color: green;"></i>
                                        <?php echo e(priceFullFormat($orders->sum('total_mobile'))); ?></h5>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="summery">
                                    <p>Cash (<?php echo e(number_format(0)); ?>)</p>
                                    <h5>
                                        <i class="fas fa-chart-line" style="color: green;"></i>
                                        <?php echo e(priceFullFormat($orders->sum('total_cash')-$orders->sum('changed_amount'))); ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
      
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
        <h4 class="card-title">Today Sale List</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form action="<?php echo e(route('admin.posOrdersToday')); ?>" method="post">
                <?php echo csrf_field(); ?>
            <input type="hidden" name="startDate" value="<?php echo e($from->format('Y-m-d')); ?>">
            <div class="row">
                <div class="col-md-8">
                    <span class="selectPercentage" data-percent="0">
                        0%
                    </span>
                    <span class="selectPercentage" data-percent="30">
                        30%
                    </span>
                    <span class="selectPercentage" data-percent="50">
                        50%
                    </span>
                    <span class="selectPercentage" data-percent="80">
                        80%
                    </span>
                    <span class="selectPercentage" data-percent="90">
                        90%
                    </span>
                    <span class="selectPercentage" data-percent="100">
                        100%
                    </span>
                    <p style="color: #F44336;font-weight: bold;">
                        How many order hidden form today sales.
                    </p>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success" onclick="return confirm('Are you want to Update?')">Update Status</button>
                </div>
            </div>
            
                <?php
                    $totalCash = 0;
                    $totalCard = 0;
                    $totalMobile = 0;
                    $totalReceived = 0;
                    $totalRemaining = 0;
                ?>
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>#Invoice</th>
                                <th style="min-width: 140px;">Customer</th>
                                <th>Items</th>
                                <th>VAT</th>
                                <th>Discount</th>
                                <th>Bill</th>
                                <th>Cash</th>
                                <th>Card</th>
                                <th>Mobile</th>
                                <th>Received</th>
                                <th>Change</th>
                                <th style="min-width: 120px;">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $cash = $order->transections->where('payment_method', 'Cash Method')->sum('received_amount');
                                    $card = $order->transections->where('payment_method', 'Card Method')->sum('received_amount');
                                    $mobile = $order->transections->where('payment_method', 'Mobile Method')->sum('received_amount');
                                    $received = $order->transections->sum('received_amount');
 
                                    if($received > $order->grand_total){
                                    $remaining = $received - $order->grand_total;
                                    }else{
                                    $remaining = 0;
                                    }
                                    
            
                                    $totalCash += $cash;
                                    $totalCard += $card;
                                    $totalMobile += $mobile;
                                    $totalReceived += $received;
                                    $totalRemaining += $remaining;
                                ?>
            
                                <tr>
                                    <td><input type="checkbox" name="checkid[]" <?php echo e($order->addedby_id==671?'checked':''); ?> value="<?php echo e($order->id); ?>"></td>
                                    <td>#<?php echo e($order->invoice); ?></td>
                                    <td><?php echo e($order->name); ?></td>
                                    <td><?php echo e($order->items()->sum('quantity')); ?></td>
                                    <td><?php echo e(number_format($order->tax_amount)); ?></td>
                                    <td><?php echo e(number_format($order->discount_price)); ?></td>
                                    <td><?php echo e(number_format($order->grand_total,0)); ?></td>
                                    <td><?php echo e(number_format($cash)); ?></td>
                                    <td><?php echo e(number_format($card)); ?></td>
                                    <td><?php echo e(number_format($mobile)); ?></td>
                                    <td><?php echo e(number_format($received,0)); ?></td>
                                    <td><?php echo e(intval($remaining)); ?></td>
                                    <td><?php echo e($order->created_at->format('d-m-Y')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
            
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Total</th>
                                <th><?php echo e(number_format($orders->sum('total_qty'))); ?></th>
                                <th><?php echo e(priceFormat($orders->sum('tax_amount'))); ?></th>
                                <th><?php echo e(priceFormat($orders->sum('discount_price'))); ?></th>
                                <th><?php echo e(priceFormat($orders->sum('grand_total'))); ?></th>
                                <th><?php echo e(number_format($totalCash-$totalRemaining)); ?></th>
                                <th><?php echo e(number_format($totalCard)); ?></th>
                                <th><?php echo e(number_format($totalMobile)); ?></th>
                                <th><?php echo e(number_format($totalReceived)); ?></th>
                                <th><?php echo e(intval($totalRemaining)); ?></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </form>
       </div>
    </div>
</div>



<?php $__env->stopSection(); ?> 
<?php $__env->startPush('js'); ?> 

<script>
    $(document).ready(function() {
        $('.selectPercentage').on('click', function() {
            // Get the percentage value
            var percent = $(this).data('percent');
            
            // Select all checkboxes with name "checkid"
            var checkboxes = $('input[name="checkid[]"]');
            
            // Calculate how many checkboxes to check
            var numToCheck = Math.round((percent / 100) * checkboxes.length);
            
            // Uncheck all checkboxes first
            checkboxes.prop('checked', false);
            
            // Check the required number of checkboxes
            checkboxes.slice(0, numToCheck).prop('checked', true);
        });
    });
</script>


<?php $__env->stopPush(); ?>
<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/posherbd/public_html/resources/views/admin/pos-orders/ordersTodayReports.blade.php ENDPATH**/ ?>