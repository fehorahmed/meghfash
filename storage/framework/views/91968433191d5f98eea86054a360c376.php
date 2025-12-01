
<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Attributes List')); ?></title>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
<style type="text/css">

</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('contents'); ?>

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
         <h3 class="content-header-title mb-0">Attributes List</h3>
         <div class="row breadcrumbs-top">
           <div class="breadcrumb-wrapper col-12">
             <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a>
               </li>
               <li class="breadcrumb-item active">Attributes List</li>
             </ol>
           </div>
         </div>
       </div>
       <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
         <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
           	<a class="btn btn-outline-primary" href="<?php echo e(route('admin.productsAttributesAction','create')); ?>">Add Attribute</a>
           	<a class="btn btn-outline-primary reloadPage1" href="<?php echo e(route('admin.productsAttributes')); ?>">
           		<i class="fa-solid fa-rotate"></i>
           	</a>
         </div>
       </div>
    </div>
	

 	<?php echo $__env->make('admin.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 	<div class="card">
 		<div class="card-content">
 			 <div id="accordion">
			    <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" id="headingTwo" style="background:#009688;padding: 15px 20px; cursor: pointer;">
			       <i class="fa fa-filter"></i>   Search click Here..
			    </div>
			    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="border: 1px solid #00b5b8;border-top: 0;">
			      <div class="card-body">
		       		<form action="<?php echo e(route('admin.productsAttributes')); ?>">
			       		<div class="row">
			       			<div class="col-md-12 mb-0">
			       				<div class="input-group">
                             		<input type="text" name="search" value="<?php echo e(request()->search?request()->search:''); ?>" placeholder="Attribute Name" class="form-control <?php echo e($errors->has('search')?'error':''); ?>">
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
 	<div class="card-header " style="border-bottom: 1px solid #e3ebf3;">
	 	<h4 class="card-title">Attributes List</h4>
 	</div>
     <div class="card-content">
         <div class="card-body">
             <div class="table-responsive">

             	<table class="table table-striped table-bordered table-hover" >
				    <thead>
				        <tr>
				            <th style="min-width: 60px;">SL</th>
				            <th style="min-width: 200px;">Attributes Name</th>
				            <th style="min-width: 250px;">Items</th>
				            <th style="min-width: 180px;width: 180px;">Action</th>
				        </tr>
				    </thead>
				    <tbody>
				        <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				        <tr>
				            <td>
				            <?php echo e($i+1); ?>

				            </td>
				            <td>
				                <span>
				                <?php echo e($attribute->name); ?>

				                <?php if($attribute->view==2): ?>
				            	<small style="color:#a3a3a3;">(Color)</small>
				            	<?php elseif($attribute->view==3): ?>
				            	<small style="color:#a3a3a3;">(Image)</small>
				            	<?php else: ?>
				            	<small style="color:#a3a3a3;">(Text)</small>
				            	<?php endif; ?> 
				                </span><br>

				               <?php if($attribute->status=='active'): ?>
				               <span><i class="fa fa-check" style="color: #1ab394;"></i></span>
				               <?php else: ?>
				               <span><i class="fa fa-times" style="color: #ed5565;"></i></span>
				               <?php endif; ?>
				               
				               <?php if($attribute->fetured): ?>
				               <span><i class="fa fa-star" style="color: #ff864a;"></i></span>
				               <?php endif; ?>

				                <span style="font-size: 10px;"><i class="fa fa-calendar" style="color: #1ab394;"></i>
				                <?php echo e($attribute->created_at->format('d-m-Y')); ?>

				              </span>
				            </td>
				            <td>
				            	<?php $__currentLoopData = $attribute->subAttributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				            	<span style="padding: 3px 10px;border: 1px solid #e5e5e5;border-radius: 5px;display: inline-block;margin-bottom: 5px;"><?php echo e($item->name); ?>

				            	<?php if($item->parent->view==2): ?>
				            	<span style="background:<?php echo e($item->icon?:'black'); ?>;height: 10px;width: 20px;display: inline-block;"></span>
				            	<?php elseif($item->parent->view==3): ?>
				            	<img src="<?php echo e(asset($item->parent->image())); ?>" style="max-width:50px;max-height: 20px;">
				            	<?php endif; ?>
				            	</span>
				            	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				            </td>
				            <td class="center">
				            <a href="<?php echo e(route('admin.productsAttributesAction',['edit',$attribute->id])); ?>" class="btn btn-md btn-info">Config</a>
				            <?php if($attribute->id==68 || $attribute->id==73): ?> <?php else: ?>
				                <a href="<?php echo e(route('admin.productsAttributesAction',['delete',$attribute->id])); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are You Want To Delete?')">Delete</a>
				            <?php endif; ?>
				            </td>
				        </tr>
				        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				    </tbody>
				</table>
				<?php echo e($attributes->links('pagination')); ?>

                
             </div>

         </div>
     </div>
 </div>



<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make(general()->adminTheme.'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\poshak\resources\views/admin/products/attributes/attributesAll.blade.php ENDPATH**/ ?>