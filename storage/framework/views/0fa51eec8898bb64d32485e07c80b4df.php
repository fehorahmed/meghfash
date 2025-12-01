
<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Customer Profile')); ?></title>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<style type="text/css">
    .showPassword {
    right: 0 !important;
    cursor: pointer;
    }
    .ProfileImage{
        max-width: 64px;
        max-height: 64px;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('contents'); ?>


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
     <h3 class="content-header-title mb-0">Customer Profile</h3>
     <div class="row breadcrumbs-top">
       <div class="breadcrumb-wrapper col-12">
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a>
           </li>
           <li class="breadcrumb-item active">Customer Profile</li>
         </ol>
       </div>
     </div>
    </div>
   <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
     <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
       
       <a class="btn btn-outline-primary" href="<?php echo e(route('admin.usersCustomer')); ?>">
       		Back
       	</a>
       	<a class="btn btn-outline-primary" href="<?php echo e(route('admin.usersWholesaleCustomerAction',['view',$user->id])); ?>">
       		<i class="fa-solid fa-rotate"></i>
       	</a>
     </div>
   </div>
</div>
 
	

    <?php echo $__env->make(adminTheme().'alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                    <h4 class="card-title">Customer Profile</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="min-width: 120px;width: 120px;" >Name</th>
                                    <td style="min-width: 200px;"><?php echo e($user->name); ?></td>
                                </tr>
                                <tr>
                                    <th>Mobile</th>
                                    <td><?php echo e($user->mobile); ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?php echo e($user->email); ?></td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td><?php echo e($user->address_line1); ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <?php if($user->status): ?>
                                        <span class="badge badge-success">Active </span>
                                        <?php else: ?>
                                        <span class="badge badge-danger">Inactive </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Join Date</th>
                                    <td><?php echo e($user->created_at->format('d M, Y')); ?></td>
                                </tr>
                                <tr>
                                    <th>Total Sale</th>
                                    <td><?php echo e(priceFullFormat($user->orders->where('order_status','delivered')->where('order_type','wholesale_order')->sum('grand_total'))); ?></td>
                                </tr>
                                <tr>
                                    <th>Total Due</th>
                                    <td><?php echo e(priceFullFormat($user->orders->where('order_status','delivered')->where('order_type','wholesale_order')->sum('due_amount'))); ?>

                                        
                                        <a href="<?php echo e(route('admin.usersWholesaleCustomerAction',['view',$user->id,'payment_status'=>'due'])); ?>"><i class="fas fa-external-link-alt"></i></a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                    <h4 class="card-title">Sales List</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" >
                                <thead>
                                    <tr>
                                        <th style="width:60px;min-width:60px;" >SL</th>
                                        <th style="width:120px;min-width:120px;">Invoice</th>
                                        <th style="min-width:200px;">Wholesale Customer</th>
                                        <th style="width:200px;min-width:200px;">Total Bill</th>
                                        <th style="width:130px;min-width:130px;">Date</th>
                                        <th style="width:100px;min-width:100px;">Status</th>
        
                                        <th style="width:80px;min-width:80px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($i+1); ?></td>
                                        <td><a href="<?php echo e(route('admin.wholeSalesAction',['invoice',$order->id])); ?>"><?php echo e($order->invoice); ?></a></td>
                                        <td><?php echo e($order->company_name); ?>

                                        <?php if($order->company_name && $order->name): ?>
                                        - 
                                        <?php endif; ?>
                                        <?php echo e($order->name); ?>

                                        </td>
                                        <td style="display: flex;justify-content: space-between;">
                                            <?php echo e(priceFullFormat($order->grand_total)); ?>

                                            <?php if($order->payment_status=='partial' || $order->payment_status=='paid'): ?>
                                            <span class="badge badge-success" style="background:#ff9800;"><?php echo e(ucfirst('Paid')); ?></span>
                                            <?php elseif($order->payment_status=='paid'): ?>
                                            <span class="badge badge-success" style="background:#673ab7;"><?php echo e(ucfirst($order->payment_status)); ?></span>
                                            <?php else: ?>
                                            <span class="badge badge-success" style="background:#f44336;"><?php echo e(ucfirst($order->payment_status)); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($order->created_at->format('d M, Y')); ?></td>
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
                                            <a href="<?php echo e(route('admin.wholeSalesAction',['edit',$order->id])); ?>" class="btn btn-sm btn-success">Manage</a>
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
                        
                    </div>
                </div>
            </div>
        </div>
    </div>



<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>



<?php $__env->stopPush(); ?>
<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/users/wholesale-customers/viewUser.blade.php ENDPATH**/ ?>