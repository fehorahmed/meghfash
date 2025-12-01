
<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Attribute Item Edit')); ?></title>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
<style type="text/css">

</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('contents'); ?>
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
     <h3 class="content-header-title mb-0">Attribute Edit</h3>
     <div class="row breadcrumbs-top">
       <div class="breadcrumb-wrapper col-12">
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a>
           </li>
           <li class="breadcrumb-item active">Attribute Edit</li>
         </ol>
       </div>
     </div>
   </div>
   <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
     <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
       	<a class="btn btn-outline-primary" href="<?php echo e(route('admin.productsAttributesAction',['edit',$attribute->parent_id])); ?>">BACK</a>
       	<a class="btn btn-outline-success" href="<?php echo e(route('admin.productsAttributesItemAction',['create',$attribute->parent_id])); ?>">Add Item</a>
       	<a class="btn btn-outline-primary reloadPage" href="javascript:void(0)">
       		<i class="fa-solid fa-rotate"></i>
       	</a>
     </div>
   </div>
</div>
	

 <div class="content-body">
 	<!-- Basic Elements start -->
	 <section class="basic-elements">
	 	<?php echo $__env->make('admin.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	    <form action="<?php echo e(route('admin.productsAttributesItemAction',['update',$attribute->id])); ?>" method="post" enctype="multipart/form-data">
	    <?php echo csrf_field(); ?>
	     <div class="row">
	        <div class="col-md-5">
	         		
	            <div class="card">
	             	<div class="card-header " style="border-bottom: 1px solid #e3ebf3;">
					 	<h4 class="card-title">Attribute Edit</h4>
				 	</div>
	                 <div class="card-content">
	                     <div class="card-body">
                        	<div class="form-group">
		                     	<label for="name">Attribute Name(*) </label>
		                     	<input type="text" class="form-control <?php echo e($errors->has('name')?'error':''); ?>" name="name" placeholder="Enter Attribute Name" value="<?php echo e($attribute->name?:old('name')); ?>" required="" />
		                    	<?php if($errors->has('name')): ?>
		                    	<p style="color: red;margin: 0;font-size: 10px;"><?php echo e($errors->first('name')); ?></p>
		                    	<?php endif; ?>
		             		</div>
		             		<div class="form-group">
								<label for="description">Description </label>
								<textarea name="description" class="form-control <?php echo e($errors->has('description')?'error':''); ?>" placeholder="Enter Description"><?php echo $attribute->description; ?></textarea>
								<?php if($errors->has('description')): ?>
								<p style="color: red;margin: 0;font-size: 10px;"><?php echo e($errors->first('description')); ?></p>
								<?php endif; ?>
		             		</div>
		             		<div class="form-group">
		             			<?php if($attribute->parent): ?>

		             			<?php if($attribute->parent->view==2): ?>
		             			<input type="color" name="color" value="<?php echo e($attribute->icon?:old('color')); ?>">

		             			<?php elseif($attribute->parent->view==3): ?>
		             			
		             			<input type="file" name="image" class="form-control">
		             			<img src="<?php echo e(asset($attribute->image())); ?>" style="max-width:50px;">
		             			<?php if($attribute->imageFile): ?>
              				        <a href="<?php echo e(route('admin.mediesDelete',$attribute->imageFile->id)); ?>" class="mediaDelete" style="color:red;"><i class="fa fa-trash"></i></a>
		             			<?php endif; ?>
		             			
		             			<?php endif; ?>

		             			<?php endif; ?>

		             		</div>
	                    <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
		                                  changes </button>

		                 </div>
		             </div>
		         	</div>

				</div>

		    </div>
	     </form>
	 </section>
	 <!-- Basic Inputs end -->
</div>



<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>


<?php $__env->stopPush(); ?>
<?php echo $__env->make(general()->adminTheme.'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/admin/products/attributes/attributesItemEdit.blade.php ENDPATH**/ ?>