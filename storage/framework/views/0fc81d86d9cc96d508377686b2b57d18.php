 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Store/Branch')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css"></style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Store/Branch</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Store/Branch</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
        
            <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#addWarehouse">
                New Store
            </button>
            
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.productsWarehouses')); ?>">
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
                        <h4 class="card-title">Store/Branch</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="min-width: 60px;width: 60px;">SL</th>
                                            <th style="min-width: 200px;width: 200px;">Name</th>
                                            <th style="min-width: 250px;">Address</th>
                                            <th style="min-width: 100px;width:100px;">Status</th>
                                            <th style="min-width: 120px;width: 120px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <span><?php echo e($i+1); ?></span>
                                            </td>
                                            <td>
                                                <?php echo e($warehouse->name); ?>

                                            </td>
                                            <td>
                                                <?php echo e($warehouse->description); ?>

                                            </td>
                                            <td style="padding: 5px;">
                                               <?php echo e(ucfirst($warehouse->status)); ?>

                                            </td>
                                            <td class="center">

                                                <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#updateWarehouse<?php echo e($warehouse->id); ?>">
                                                   Edit
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade text-left" id="updateWarehouse<?php echo e($warehouse->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                   <div class="modal-dialog" role="document">
                                                     <div class="modal-content">
                                                        <form action="<?php echo e(route('admin.productsWarehousesAction',['update',$warehouse->id])); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                           <div class="modal-header">
                                                             <h4 class="modal-title" id="myModalLabel1">Update Type</h4>
                                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                               <span aria-hidden="true">&times; </span>
                                                             </button>
                                                           </div>
                                                           <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Store Name*</label>
                                                                    <input type="text" name="name"  class="form-control" value="<?php echo e($warehouse->name); ?>" placeholder="Enter Store name" required="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Image</label>
                                                                    <input type="file" name="image" class="form-control">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Address</label>
                                                                    <textarea class="form-control" name="address" placeholder="Write Address"><?php echo e($warehouse->description); ?></textarea>
                                                                </div>
                                                                <div>
                                                                    <label>Status*</label>
                                                                    <select class="form-control" name="status" required="">
                                                                        <option value="">Select Status</option>
                                                                        <option value="active" <?php echo e($warehouse->status=='active'?'selected':''); ?> >Active</option>
                                                                        <option value="inactive" <?php echo e($warehouse->status=='inactive'?'selected':''); ?>>Inactive</option>
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

                                                <a href="<?php echo e(route('admin.productsWarehousesAction',['delete',$warehouse->id])); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are You Want To Delete?')"><i class="fa fa-trash"></i></a>
                                               
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
</div>


 <!-- Modal -->
 <div class="modal fade text-left" id="addWarehouse" >
   <div class="modal-dialog" role="document">
     <div class="modal-content">
        <form action="<?php echo e(route('admin.productsWarehousesAction','create')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
           <div class="modal-header">
             <h4 class="modal-title">New Store</h4>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times; </span>
             </button>
           </div>
           <div class="modal-body">
                <div class="form-group">
                    <label>Name*</label>
                    <input type="text" name="name"  class="form-control" placeholder="Enter method name" required="">
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea class="form-control" name="address" placeholder="Write address"></textarea>
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
             <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add Warehouse</button>
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
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/products/warehouses/warehousesAll.blade.php ENDPATH**/ ?>