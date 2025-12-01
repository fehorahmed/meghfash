 <?php $__env->startSection('title'); ?>
<title>Expenses Type - <?php echo e(general()->title); ?> | <?php echo e(general()->subtitle); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css"></style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Expenses Type</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Expenses Type</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
        
            <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#addType">
                Add Type
            </button>
            
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.expensesTypes')); ?>">
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
                                    style="background: #009688; padding: 10px; cursor: pointer; border: 1px solid #00b5b8;"
                                >
                                    Search click Here..
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="border: 1px solid #00b5b8; border-top: 0;">
                                    <div class="card-body">
                                        <form action="<?php echo e(route('admin.expensesTypes')); ?>">
                                            <div class="row">
                                                <div class="col-md-12 mb-0">
                                                    <div class="input-group">
                                                        <input type="text" name="search" value="<?php echo e(request()->search); ?>" placeholder="Head Name" class="form-control <?php echo e($errors->has('search')?'error':''); ?>" />
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
                        <h4 class="card-title">Expenses Type</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="min-width: 60px;">SL</th>
                                            <th style="min-width: 200px;width: 200px;">Head Name</th>
                                            <th style="min-width: 300px;">Description</th>
                                            <th style="min-width: 160px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                            <?php echo e($types->currentpage()==1?$i+1:$i+($types->perpage()*($types->currentpage() - 1))+1); ?>

                                            </td>
                                            <td><span><?php echo e($type->name); ?></span></td>
                                            <td style="padding: 5px; text-align: center;">
                                                <?php echo $type->description; ?>

                                            </td>
                                            <td class="center">

                                                <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#updateType<?php echo e($type->id); ?>">
                                                   Edit
                                                </button>

                                                <!-- Modal -->
                                                 <div class="modal fade text-left" id="updateType<?php echo e($type->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                   <div class="modal-dialog" role="document">
                                                     <div class="modal-content">
                                                        <form action="<?php echo e(route('admin.expensesTypesAction',['update',$type->id])); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                           <div class="modal-header">
                                                             <h4 class="modal-title" id="myModalLabel1">Update Head</h4>
                                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                               <span aria-hidden="true">&times; </span>
                                                             </button>
                                                           </div>
                                                           <div class="modal-body">
                                                                <div class="form-group">
                                                                        <label>Head Name*</label>
                                                                        <input type="text" name="name" value="<?php echo e($type->name); ?>" class="form-control" placeholder="Enter Head Name" required="">
                                                                </div>
                                                                <div class="form-group">
                                                                        <label>Description</label>
                                                                        <textarea class="form-control" name="description" placeholder="Write Description"><?php echo $type->description; ?></textarea>
                                                                </div>
                                                           </div>
                                                           <div class="modal-footer">
                                                             <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close </button>
                                                             <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Update Head</button>
                                                           </div>
                                                       </form>
                                                     </div>
                                                   </div>
                                                 </div>

                                                <a href="<?php echo e(route('admin.expensesTypesAction',['delete',$type->id])); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are You Want To Delete?')">Delete</a>
                                               
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <?php echo e($types->links('pagination')); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Basic Inputs end -->
</div>


 <!-- Modal -->
 <div class="modal fade text-left" id="addType" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
        <form action="<?php echo e(route('admin.expensesTypesAction','create')); ?>" method="post">
            <?php echo csrf_field(); ?>
           <div class="modal-header">
             <h4 class="modal-title" id="myModalLabel1">Add Expense Head</h4>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times; </span>
             </button>
           </div>
           <div class="modal-body">
                <div class="form-group">
                    <label>Head Name*</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter Head Name" required="">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" name="description" placeholder="Write Description"></textarea>
                </div>
           </div>
           <div class="modal-footer">
             <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close </button>
             <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add Head</button>
           </div>
       </form>
     </div>
   </div>
 </div>


<?php $__env->stopSection(); ?> 

<?php $__env->startPush('js'); ?> 

<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/accounts/expenses/expensesTypes.blade.php ENDPATH**/ ?>