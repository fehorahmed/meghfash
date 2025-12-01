 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Payment Methods')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css"></style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Payment Methods</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Payment Methods</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
        
            <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#addMethod">
                New Method
            </button>
            
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.paymentMethods')); ?>">
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
                    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                        <h4 class="card-title">Account Methods</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="min-width: 60px;width: 60px;">SL</th>
                                            <th style="min-width: 200px;width: 200px;">Name</th>
                                            <th style="min-width: 250px;">Description</th>
                                            <th style="min-width: 150px;width: 150px;">Type</th>
                                            <th style="min-width: 150px;width: 150px;">Balance</th>
                                            <th style="min-width: 100px;width:100px;">Status</th>
                                            <th style="min-width: 120px;width: 120px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <span><?php echo e($i+1); ?></span>
                                            </td>
                                            <td>
                                                <?php echo e($method->name); ?>

                                            </td>
                                            <td>
                                                <?php echo e($method->description); ?>

                                            </td>
                                            <td>
                                                <?php if($method->location=='pos_method'): ?>
                                                POS Method
                                                <?php elseif($method->location=='card_method'): ?>
                                                Card Method
                                                <?php elseif($method->location=='mobile_banking'): ?>
                                                Mobile Banking
                                                <?php else: ?>
                                                Cash Method
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span><?php echo e(priceFullFormat($method->amounts)); ?></span>
                                            </td>
                                            
                                            <td style="padding: 5px;">
                                               <?php echo e(ucfirst($method->status)); ?>

                                            </td>
                                            <td class="center">
                                                
                                                <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#updateMethod<?php echo e($method->id); ?>">
                                                   Edit
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade text-left" id="updateMethod<?php echo e($method->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                   <div class="modal-dialog" role="document">
                                                     <div class="modal-content">
                                                        <form action="<?php echo e(route('admin.paymentMethods',['update',$method->id])); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                           <div class="modal-header">
                                                             <h4 class="modal-title" id="myModalLabel1">Update Type</h4>
                                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                               <span aria-hidden="true">&times; </span>
                                                             </button>
                                                           </div>
                                                           <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="form-group col-8">
                                                                        <label>Method Name*</label>
                                                                        <input type="text" name="name"  class="form-control" value="<?php echo e($method->name); ?>" placeholder="Enter method name" required="">
                                                                    </div>
                                                                    
                                                                    <div class="form-group col-4">
                                                                        <?php if($method->id==87): ?> <?php else: ?>
                                                                        <label>Method Type</label>
                                                                        <select class="form-control" name="method_type" >
                                                                            <option value="">Select Type</option>
                                                                            <option value="pos_method" <?php echo e($method->location=='pos_method'?'selected':''); ?> >POS Method</option>
                                                                            <option value="card_method" <?php echo e($method->location=='card_method'?'selected':''); ?> >Card Method</option>
                                                                            <option value="mobile_banking" <?php echo e($method->location=='mobile_banking'?'selected':''); ?> >Mobile Banking</option>
                                                                        </select>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Image</label>
                                                                    <input type="file" name="image" class="form-control">
                                                                </div>
                                                
                                                                <div class="form-group">
                                                                        <label>Description</label>
                                                                        <textarea class="form-control" name="description" placeholder="Write Description"><?php echo e($method->description); ?></textarea>
                                                                </div>
                                                                <div>
                                                                    <label>Status*</label>
                                                                    <select class="form-control" name="status" required="">
                                                                        <option value="">Select Status</option>
                                                                        <option value="active" <?php echo e($method->status=='active'?'selected':''); ?> >Active</option>
                                                                        <option value="inactive" <?php echo e($method->status=='inactive'?'selected':''); ?>>Inactive</option>
                                                                    </select>
                                                                </div>
                                                                
                                                           </div>
                                                            <div class="modal-footer">
                                                             <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close </button>
                                                             <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Update</button>
                                                            </div>
                                                       </form>
                                                     </div>
                                                   </div>
                                                </div>
                                                <?php if($method->id==87): ?> <?php else: ?>
                                                <a href="<?php echo e(route('admin.paymentMethods',['delete',$method->id])); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are You Want To Delete?')"><i class="fa fa-trash"></i></a>
                                               <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>

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
 <div class="modal fade text-left" id="addMethod" >
   <div class="modal-dialog" role="document">
     <div class="modal-content">
        <form action="<?php echo e(route('admin.paymentMethods','create')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
           <div class="modal-header">
             <h4 class="modal-title">New Method</h4>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times; </span>
             </button>
           </div>
           <div class="modal-body">
                <div class="row">
                    <div class="form-group col-8">
                        <label>Method Name*</label>
                        <input type="text" name="name"  class="form-control" placeholder="Enter method name" required="">
                    </div>
                    <div class="form-group col-4">
                        <label>Method Type</label>
                        <select class="form-control" name="method_type" >
                            <option value="">Select Type</option>
                            <option value="pos_method">POS Method</option>
                            <option value="card_method">Card Method</option>
                            <option value="mobile_banking">Mobile Banking</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" placeholder="Write Description"></textarea>
                </div>
                <div>
                    <label>Status*</label>
                    <select class="form-control" name="status" required="">
                        <option value="">Select Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
           </div>
           <div class="modal-footer">
             <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close </button>
             <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add Method</button>
           </div>
       </form>
     </div>
   </div>
</div>

<?php $__env->stopSection(); ?> 

<?php $__env->startPush('js'); ?> 
<script type="text/javascript">

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/admin/accounts/accountsMethod.blade.php ENDPATH**/ ?>