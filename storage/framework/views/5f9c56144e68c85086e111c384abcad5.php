 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('POS Orders List')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css"></style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">POS Orders List</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">POS Orders List</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.posOrdersAction','create')); ?>">New Order</a>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.posOrders')); ?>">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>

<?php echo $__env->make('admin.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="card">
    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
        <h4 class="card-title">Order List</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form action="<?php echo e(route('admin.posOrders')); ?>">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-1">
                            <select class="form-control form-control-sm rounded-0" name="action" required="">
                                <option value="">Select Action</option>
                                <?php if(isset(json_decode(Auth::user()->permission->permission, true)['orders']['manage'])): ?>
                                <option value="1">Pending</option>
                                <option value="2">Confirmed</option>
                                <option value="3">Shipped</option>
                                <option value="4">Delivered</option>
                                <option value="5">Cancelled</option>
                                <?php endif; ?>
                                <?php if(isset(json_decode(Auth::user()->permission->permission, true)['orders']['delete'])): ?>
                                <option value="6">Delete</option>
                                <?php endif; ?>
                            </select>
                            <button class="btn btn-sm btn-primary rounded-0" onclick="return confirm('Are You Want To Action?')">Action</button>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <ul class="statuslist">
                            <li><a href="<?php echo e(route('admin.posOrders')); ?>">All (<?php echo e($totals->total); ?>)</a></li>
                            <li><a href="<?php echo e(route('admin.posOrders',['status'=>'pending'])); ?>">Pending (<?php echo e($totals->pending); ?>)</a></li>
                            <li><a href="<?php echo e(route('admin.posOrders',['status'=>'confirmed'])); ?>">Confirmed (<?php echo e($totals->confirmed); ?>)</a></li>
                            <li><a href="<?php echo e(route('admin.posOrders',['status'=>'delivered'])); ?>">Delivered (<?php echo e($totals->delivered); ?>)</a></li>
                            <li><a href="<?php echo e(route('admin.posOrders',['status'=>'cancelled'])); ?>">Cancelled (<?php echo e($totals->cancelled); ?>)</a></li>
                        </ul>
                    </div>
                </div>
        
                <div class="table-responsive">
                    
                <table class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th><label style="cursor: pointer; margin-bottom: 0;"> <input class="checkbox" type="checkbox" class="form-control" id="checkall" /> All <span class="checkCounter"></span> </label></th>
                                <th width="10%">invoice NO</th>
                                <th width="25%">Customer</th>
                                <th>Price (BDT)</th>
                                <th width="18%">Date</th>
                                <th>Status</th>

                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><input class="checkbox" type="checkbox" name="checkid[]" value="<?php echo e($order->id); ?>" /> <?php echo e($i+1); ?></td>
                                <td><a href="<?php echo e(route('admin.posOrdersAction',['invoice',$order->id])); ?>"><?php echo e($order->invoice); ?></a></td>
                                <td><?php echo e($order->name); ?> - <?php echo e($order->mobile); ?></td>
                                <td>
                                    <?php echo e(App\Models\General::first()->currency); ?>

                                    <?php echo e(number_format($order->grand_total)); ?>

                                    <?php if($order->payment_status=='partial'): ?>
                                    <span class="badge badge-success" style="background:#ff9800;"><?php echo e(ucfirst($order->payment_status)); ?></span>
                                    <?php elseif($order->payment_status=='paid'): ?>
                                    <span class="badge badge-success" style="background:#673ab7;"><?php echo e(ucfirst($order->payment_status)); ?></span>
                                    <?php else: ?>
                                    <span class="badge badge-success" style="background:#f44336;"><?php echo e(ucfirst($order->payment_status)); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($order->created_at->format('Y-m-d h:i A')); ?></td>
                                <td>

                                <?php if($order->order_status=='confirmed'): ?>
                                <span class="badge badge-success" style="background:#e91e63;"><?php echo e(ucfirst($order->order_status)); ?></span>
                                <?php elseif($order->order_status=='shipped'): ?>
                                <span class="badge badge-success" style="background:#673ab7;"><?php echo e(ucfirst($order->order_status)); ?></span>
                                <?php elseif($order->order_status=='delivered'): ?>
                                <span class="badge badge-success" style="background:#1c84c6;"><?php echo e(ucfirst($order->order_status)); ?></span>
                                <?php elseif($order->order_status=='cancelled'): ?>
                                <span class="badge badge-success" style="background:#f44336;"><?php echo e(ucfirst($order->order_status)); ?></span>
                                <?php else: ?>
                                <span class="badge badge-success" style="background:#ff9800;"><?php echo e(ucfirst($order->order_status)); ?></span>
                                <?php endif; ?>

                                </td>
                                <td>
                                    <?php if(isset(json_decode(Auth::user()->permission->permission, true)['orders']['manage'])): ?>
                                    <a href="<?php echo e(route('admin.posOrdersAction',['edit',$order->id])); ?>" class="btn btn-sm btn-success">Edit</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($orders->count()==0): ?>
                            <tr><td colspan="7"><center>No Order Found</center></td></tr>
                            <?php endif; ?>
                        </tbody>

                    </table>

                    <?php echo e($orders->links('pagination')); ?>

                </div>
            </form>
        </div>
    </div>
</div>



<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?> <?php $__env->stopPush(); ?>
<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/posherbd/public_html/posher.com.bd/resources/views/admin/pos-orders/ordersAll.blade.php ENDPATH**/ ?>