
<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Stock Management')); ?></title>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
<style type="text/css">
    .card .topBorderHeader{
        border-top: 3px solid #3d3196 !important;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Stock Management</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Stock Management</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <?php if(isset(json_decode(Auth::user()->permission->permission, true)['products']['add'])): ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.purchasesAction','create')); ?>">Add Stock</a>
            <?php endif; ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.purchases')); ?>">
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
                    <form action="<?php echo e(route('admin.purchases')); ?>">
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <div class="input-group">
                                    <input type="date" name="startDate" value="<?php echo e(request()->startDate?Carbon\Carbon::parse(request()->startDate)->format('Y-m-d') :''); ?>" class="form-control <?php echo e($errors->has('startDate')?'error':''); ?>" />
                                    <input type="date" value="<?php echo e(request()->endDate?Carbon\Carbon::parse(request()->endDate)->format('Y-m-d') :''); ?>" name="endDate" class="form-control <?php echo e($errors->has('endDate')?'error':''); ?>" />
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="input-group">
                                    <input type="text" name="search" value="<?php echo e(request()->search?:''); ?>" placeholder="Stock Invoice no" class="form-control <?php echo e($errors->has('search')?'error':''); ?>" />
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
        <h4 class="card-title">Stock History List</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form action="<?php echo e(route('admin.purchases')); ?>">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-1">
                            <select class="form-control form-control-sm rounded-0" name="action" required="">
                                <option value="">Select Action</option>
                                <!--<?php if(isset(json_decode(Auth::user()->permission->permission, true)['orders']['manage'])): ?>-->
                                <!--<option value="1">Pending</option>-->
                                <!--<option value="2">Delivered</option>-->
                                <!--<option value="4">Cancelled</option>-->
                                <!--<?php endif; ?>-->
                                <?php if(isset(json_decode(Auth::user()->permission->permission, true)['orders']['delete'])): ?>
                                <option value="5">Delete</option>
                                <?php endif; ?>
                            </select>
                            <button class="btn btn-sm btn-primary rounded-0" onclick="return confirm('Are You Want To Action?')">Action</button>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <ul class="statuslist">
                            <li><a href="<?php echo e(route('admin.purchases')); ?>">All (<?php echo e($totals->total); ?>)</a></li>
                            <li><a href="<?php echo e(route('admin.purchases',['status'=>'pending'])); ?>">Pending (<?php echo e($totals->pending); ?>)</a></li>
                            <li><a href="<?php echo e(route('admin.purchases',['status'=>'delivered'])); ?>">Delivered (<?php echo e($totals->delivered); ?>)</a></li>
                            <li><a href="<?php echo e(route('admin.purchases',['status'=>'cancelled'])); ?>">Cancelled (<?php echo e($totals->cancelled); ?>)</a></li>
                        </ul>
                    </div>
                </div>
        
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><label style="cursor: pointer; margin-bottom: 0;"> <input class="checkbox" type="checkbox" class="form-control" id="checkall" /> All <span class="checkCounter"></span> </label></th>
                                <th style="min-width: 100px;">Invoice No</th>
                                <th style="min-width: 150px;">Supplier</th>
                                <th style="min-width: 150px;">Store/Branch</th>
                                <th style="min-width: 70px;">Stock</th>
                                <th style="min-width: 100px;">Status</th>
                                <th style="min-width: 100px;">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <input class="checkbox" type="checkbox" name="checkid[]" value="<?php echo e($invoice->id); ?>"
                                        <?php if($invoice->isStockUsed()): ?>
                                        disabled=""
                                        <?php endif; ?>
                                        /> 
                                        <?php echo e($invoices->currentpage()==1?$i+1:$i+($invoices->perpage()*($invoices->currentpage() - 1))+1); ?>

                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.purchasesAction',['invoice',$invoice->id])); ?>"><?php echo e($invoice->invoice); ?></a>
                                        <a href="<?php echo e(route('admin.purchasesAction',['edit',$invoice->id])); ?>" class="badge badge-info"><i class="fa fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <?php if($invoice->user): ?>
                                        <?php echo e($invoice->user->name); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($invoice->branch?$invoice->branch->name:''); ?></td>
                                    <td><?php echo e($invoice->items()->sum('quantity')); ?></td>
                                    <td><?php echo e(ucfirst($invoice->order_status)); ?></td>
                                    <td><?php echo e($invoice->created_at->format('d.m.Y')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php echo e($invoices->links('pagination')); ?>

            </form>
        </div>
    </div>
</div>






<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?> <?php $__env->stopPush(); ?>
<?php echo $__env->make(general()->adminTheme.'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\posher-react-laravel\resources\views/admin/purchases/purchasesAll.blade.php ENDPATH**/ ?>