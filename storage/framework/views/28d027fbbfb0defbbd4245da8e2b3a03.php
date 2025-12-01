 <?php $__env->startSection('title'); ?>
<title>Expenses Report - <?php echo e(general()->title); ?> | <?php echo e(general()->subtitle); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css"></style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Expenses Report</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Expenses Report</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.expensesList')); ?>">
                Back
            </a>
            <button class="btn btn-success" id="PrintAction" ><i class="fa fa-print"></i> Print</button>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.expensesReports')); ?>">
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
                                    style="background: #009688;padding: 10px; cursor: pointer; border: 1px solid #00b5b8;"
                                >
                                    Search click Here..
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="border: 1px solid #00b5b8; border-top: 0;">
                                    <div class="card-body">
                                        <form action="<?php echo e(route('admin.expensesReports')); ?>">
                                            <div class="row">
                                                <div class="col-md-3 mb-0">
                                                    <div class="form-group">
                                                        <select class="form-control" name="type">
                                                            <option value="">All Type</option>
                                                            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($type->id); ?>" <?php echo e(request()->type==$type->id?'selected':''); ?>><?php echo e($type->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-0">
                                                    <div class="form-group">
                                                        <select class="form-control" name="warehouse_id">
                                                            <option value="">Select Store/Branch</option>
                                                            <?php $__currentLoopData = App\Models\Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($warehouse->id); ?>" <?php echo e(request()->warehouse_id==$warehouse->id?'selected':''); ?>><?php echo e($warehouse->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-0">
                                                    <div class="input-group">
                                                        <input type="date" name="startDate" value="<?php echo e($from->format('Y-m-d')); ?>" class="form-control <?php echo e($errors->has('startDate')?'error':''); ?>" />
                                                        <input type="date" value="<?php echo e($to->format('Y-m-d')); ?>" name="endDate" class="form-control <?php echo e($errors->has('endDate')?'error':''); ?>" />
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
                        <h4 class="card-title">Expenses Report</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            
                            
                            
                            <div class="invoice-inner invoicePage PrintAreaContact">
                                <style>
                                    .invoicePage{
                                        background:white;
                                    }
                                    .costAmount {
                                            border: 1px solid #e5e3e2;
                                            padding: 10px 15px;
                                            border-radius: 10px;
                                            /*height: 100px;*/
                                        }
                                        
                                        .costAmount h4 {
                                            font-weight: bold;
                                            font-family: sans-serif;
                                            height: 40px;
                                        }
                                </style>
                                
                                <div style="text-align:center;">
                                    <img src="<?php echo e(asset(general()->logo())); ?>" style="max-height:60px;">
                                    <p>
                                        <b>Mobile:</b> <?php echo e(general()->mobile); ?> <b>Email:</b> <?php echo e(general()->mobile); ?><br>
                                        <b>Location:</b> <?php echo e(general()->address_one); ?>

                                    </p>
                                    <h4 style="font-weight: bold;">Expenses Report</h4>
                                    <h3>Date: 
                                    <?php if($from->format('Y-m-d')==$to->format('Y-m-d')): ?>
                                    <?php echo e($from->format('d M, Y')); ?>

                                    <?php else: ?>
                                    <?php echo e($from->format('d M, Y')); ?> - <?php echo e($to->format('d M, Y')); ?>

                                    <?php endif; ?>
                                    </h3>
                                </div>
                                
                                <div class="row" style="margin:0 -5px;">
                                    <div class="col-md-3 col-3" style="padding:5px;">
                                        <div class="costAmount">
                                            <h4>Total</h4>
                                            <span><?php echo e(priceFullFormat($expenses->sum('amount'))); ?> <i class="fas fa-chart-line" style="color: green;"></i></span>
                                        </div>
                                    </div>
                                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-3 col-3" style="padding:5px;">
                                        <div class="costAmount">
                                            <h4><?php echo e(Str::limit($type->name,40)); ?></h4>
                                            <span><?php echo e(priceFullFormat($expenses->where('type_id',$type->id)->sum('amount'))); ?> <i class="fas fa-chart-line" style="color: green;"></i></span>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                
                                  <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="min-width: 120px;width: 120px;">Date</th>
                                                <th style="min-width: 200px;width: 200px;">Expense Head</th>
                                                <th style="min-width: 150px;width: 150px;">Amount</th>
                                                <th style="min-width: 200px;">Description</th>
                                                <th style="min-width: 150px;width: 150px;">Expense By</th>
                                                <th style="min-width: 150px;width: 150px;">Store/Branch</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <span><?php echo e($expense->created_at->format('d-m-Y')); ?></span>
                                                </td>
                                                <td>
                                                    <?php if($expense->imageFile): ?>
                                                    <a href="<?php echo e(asset($expense->imageFile->file_url)); ?>" target="_blank"><i class="fas fa-external-link-alt"></i></a>
                                                    <?php endif; ?>
                                                    <span><?php echo e($expense->head?$expense->head->name:'Others'); ?></span>
                                                    
                                                </td>
                                                <td>
                                                    <span><?php echo e(priceFullFormat($expense->amount)); ?></span>
                                                </td>
                                                <td>
                                                    <?php echo $expense->description; ?>

                                                </td>
                                                <td>
                                                    <span><?php echo e($expense->user?$expense->user->name:''); ?></span>
                                                </td>
                                                <td>
                                                    <span><?php echo e($expense->warehouse?$expense->warehouse->name:''); ?></span>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            
                                            <?php if($expenses->count()==0): ?>
                                            <tr>
                                                <td style="text-align:center;" colspan="7">No Expense</td>
                                            </tr>
                                            
                                            <?php else: ?>
                                            <tr>
                                                <td></td>
                                                <td>Total</td>
                                                <td><?php echo e(priceFullFormat($expenses->sum('amount'))); ?></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <?php endif; ?>
                                            
                                        </tbody>
                                        
                                    </table>
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



<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?> <?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/accounts/expenses/expensesReport.blade.php ENDPATH**/ ?>