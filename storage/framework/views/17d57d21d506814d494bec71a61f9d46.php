 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Order List')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css"></style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Order List</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Order List</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.ordersAction','create')); ?>">Add Order</a>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.orders')); ?>">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>


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
                   <i class="fa fa-filter"></i> Search click Here..
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="border: 1px solid #00b5b8; border-top: 0;">
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.orders',$status)); ?>">
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <div class="input-group">
                                        <input type="date" name="startDate" value="<?php echo e(request()->startDate?Carbon\Carbon::parse(request()->startDate)->format('Y-m-d') :''); ?>" class="form-control <?php echo e($errors->has('startDate')?'error':''); ?>" />
                                        <input type="date" value="<?php echo e(request()->endDate?Carbon\Carbon::parse(request()->endDate)->format('Y-m-d') :''); ?>" name="endDate" class="form-control <?php echo e($errors->has('endDate')?'error':''); ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <div class="input-group">
                                        <input type="text" name="search" value="<?php echo e(request()->search?:''); ?>" placeholder="Order Invoice, Customer Mobile, email" class="form-control <?php echo e($errors->has('search')?'error':''); ?>" />
                                        <button type="submit" class="btn btn-success rounded-0"><i class="fa fa-search"></i> Search</button>
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
        <h4 class="card-title">Order List</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form action="<?php echo e(route('admin.orders',$status)); ?>" id="orderForm">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-1">
                            <select class="form-control form-control-sm rounded-0" name="action" required="">
                                <option value="">Select Action</option>
                                <option value="7">Print Invoice</option>
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
                            <button  class="btn btn-sm btn-primary rounded-0" onclick="return confirm('Are You Want To Action?')">Action</button>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <ul class="statuslist">
                            <li><a href="<?php echo e(route('admin.orders')); ?>">All (<?php echo e($totals->total); ?>)</a></li>
                            <li><a href="<?php echo e(route('admin.orders',['status'=>'pending'])); ?>">Pending (<?php echo e($totals->pending); ?>)</a></li>
                            <li><a href="<?php echo e(route('admin.orders',['status'=>'confirmed'])); ?>">Confirmed (<?php echo e($totals->confirmed); ?>)</a></li>
                            <li><a href="<?php echo e(route('admin.orders',['status'=>'shipped'])); ?>">Shipped (<?php echo e($totals->shipped); ?>)</a></li>
                            <li><a href="<?php echo e(route('admin.orders',['status'=>'delivered'])); ?>">Delivered (<?php echo e($totals->delivered); ?>)</a></li>
                            <li><a href="<?php echo e(route('admin.orders',['status'=>'returned'])); ?>">Returned (<?php echo e($totals->returned); ?>)</a></li>
                            <li><a href="<?php echo e(route('admin.orders',['status'=>'cancelled'])); ?>">Cancelled (<?php echo e($totals->cancelled); ?>)</a></li>
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
                                <td><a href="<?php echo e(route('admin.invoice',$order->id)); ?>"><?php echo e($order->invoice); ?></a></td>
                                <td>
                                    <?php echo e($order->name); ?> - <?php echo e($order->mobile); ?>

                                    
                                    <?php if($order->courier_id): ?>
                                        <?php if($order->courier=='Carrybee'): ?>
                                        <a  href="https://merchant.carrybee.com/tracking?consignment_id=<?php echo e($order->courier_id); ?>" target="_blank" style="color:#ff9800"><i class="fa fa-truck"></i> Carrybee</a> 
                                        <?php elseif($order->courier=='Steadfast'): ?>
                                        <a  href="https://steadfast.com.bd/t/<?php echo e($order->courier_id); ?>" target="_blank" style="color:#2196f3"><i class="fa fa-truck"></i> Steadfast</a> 
                                        <?php else: ?>
                                        <a  href="https://merchant.pathao.com/public-tracking?consignment_id=<?php echo e($order->courier_id); ?>&phone=<?php echo e($order->mobile); ?>" target="_blank"><i class="fa fa-truck"></i> Pathao</a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                    <?php if($order->facebook_order): ?>
                                    <span style="color: #03A9F4;margin-left: 5px;" class="fa-brands fa-facebook"></span>
                                    <?php endif; ?>
                                    
                                </td>
                                <td>
                                    <?php echo e(App\Models\General::first()->currency); ?>

                                    <?php echo e(number_format($order->grand_total)); ?>

                                    <?php if($order->payment_status=='partial' || $order->payment_status=='paid'): ?>
                                    <span class="badge badge-success" style="background:#ff9800;"><?php echo e(ucfirst('Paid')); ?></span>
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
                                <?php elseif($order->order_status=='returned'): ?>
                                <span class="badge badge-success" style="background:#f44336;"><?php echo e(ucfirst($order->order_status)); ?></span>
                                <?php if($order->returnOrder): ?>
                                <a href="<?php echo e(route('admin.ordersReturnAction',['invoice',$order->returnOrder->id])); ?>"><i class="fa fa-eye"></i></a>
                                <?php else: ?>
                                <a href="<?php echo e(route('admin.ordersReturnAction',['create','order_no'=>$order->invoice])); ?>"><i class="fa fa-edit"></i></a>
                                <?php endif; ?>
                                
                                <?php else: ?>
                                <span class="badge badge-success" style="background:#ff9800;"><?php echo e(ucfirst($order->order_status)); ?></span>
                                <?php endif; ?>
                                </td>
                                <td>
                                    <?php if(isset(json_decode(Auth::user()->permission->permission, true)['orders']['manage'])): ?>
                                    <a href="<?php echo e(route('admin.ordersAction',['view',$order->id])); ?>" class="btn btn-sm btn-success">Manage</a>
                                    <?php endif; ?>
                                    
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#AddInfo_<?php echo e($order->id); ?>" ><i class="fas fa-info"></i></a>
                                    <!-- Modal -->
                                    <div class="modal fade text-left" id="AddInfo_<?php echo e($order->id); ?>" tabindex="-1" >
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                        		 <h4 class="modal-title">Admin Note</h4>
                                        		 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        		   <span aria-hidden="true">&times; </span>
                                        		 </button>
                                        	   </div>
                                        	   <div class="modal-body">
                                                    
                                                <ul style="margin:0;padding-left: 20px;list-style: decimal;">
                                                     <?php
                                                        $notes = $order->admin_note ? json_decode($order->admin_note, true) : [];
                                                    ?>
                                                    <?php $__empty_1 = true; $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <li>
                                                            <span>
                                                                <?php echo e($note[0]); ?>

                                                                - <small>Msg By: <?php echo e($note[1]); ?> <?php echo e(\Carbon\Carbon::parse($note[2])->format('d-m-Y h:i A')); ?></small>
                                                            </span>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        <li>No  Note</li>
                                                    <?php endif; ?>
                                                </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

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

<?php $__env->stopSection(); ?> 
<?php $__env->startPush('js'); ?>
<script>

    
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/orders/ordersAll.blade.php ENDPATH**/ ?>