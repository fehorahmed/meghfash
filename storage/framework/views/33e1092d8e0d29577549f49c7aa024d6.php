
<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Slide Edit')); ?></title>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<style type="text/css">

</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('contents'); ?>


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
     <h3 class="content-header-title mb-0">Slide Edit</h3>
     <div class="row breadcrumbs-top">
       <div class="breadcrumb-wrapper col-12">
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a>
           </li>
           <li class="breadcrumb-item active">Slide Edit</li>
         </ol>
       </div>
     </div>
   </div>
   <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
     <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
       	<a class="btn btn-outline-primary" href="<?php echo e(route('admin.slidersAction',['edit',$slide->parent_id])); ?>">BACK</a>
       	<a class="btn btn-outline-primary reloadPage" href="javascript:void(0)">
       		<i class="fa-solid fa-rotate"></i>
       	</a>
     </div>
   </div>
</div>
 
	

 <div class="content-body">
 	<!-- Basic Elements start -->
	 <section class="basic-elements">
	 	<?php echo $__env->make(adminTheme().'alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	    <form action="<?php echo e(route('admin.slideAction',['update',$slide->id])); ?>" method="post" enctype="multipart/form-data">
	    	<?php echo csrf_field(); ?>
	     <div class="row">

	     		<div class="col-md-8">
			     	<div class="card">
		             	<div class="card-header " style="border-bottom: 1px solid #e3ebf3;">
						 	<h4 class="card-title">Slide Edit</h4>
					 	</div>
		                <div class="card-content">
		                    <div class="card-body">
			                    <div class="form-group">
			                     	<label for="name">Slide Name</label>
			                     	<input type="text" class="form-control <?php echo e($errors->has('name')?'error':''); ?>" name="name" placeholder="Enter Slider Name" value="<?php echo e($slide->name?:old('name')); ?>"  />
			                    	<?php if($errors->has('name')): ?>
			                    	<p style="color: red;margin: 0;font-size: 10px;"><?php echo e($errors->first('name')); ?></p>
			                    	<?php endif; ?>
			             		</div>
								 
			             		<div class="form-group">
									<label for="description">Description </label>
									<textarea name="description" rows="8" class="form-control <?php echo e($errors->has('description')?'error':''); ?>" placeholder="Enter Description"><?php echo $slide->description; ?></textarea>
									<?php if($errors->has('description')): ?>
									<p style="color: red;margin: 0;font-size: 10px;"><?php echo e($errors->first('description')); ?></p>
									<?php endif; ?>
	             				</div>

								<div class="row">
									<div class="form-group col-md-6">
										<label for="buttonText">Button Text </label>
										<input type="text" class="form-control <?php echo e($errors->has('buttonText')?'error':''); ?>" name="buttonText" placeholder="Enter Button Text" value="<?php echo e($slide->seo_title?:old('buttonText')); ?>" />
										<?php if($errors->has('buttonText')): ?>
										<p style="color: red;margin: 0;font-size: 10px;"><?php echo e($errors->first('buttonText')); ?></p>
										<?php endif; ?>
									</div>
									<div class="form-group col-md-6">
										<label for="buttonLink">Button Link </label>
										<input type="text" class="form-control <?php echo e($errors->has('buttonLink')?'error':''); ?>" name="buttonLink" placeholder="Enter Button Link" value="<?php echo e($slide->seo_description?:old('buttonLink')); ?>"  />
										<?php if($errors->has('buttonLink')): ?>
										<p style="color: red;margin: 0;font-size: 10px;"><?php echo e($errors->first('buttonLink')); ?></p>
										<?php endif; ?>
									</div>
								</div>
		                    </div>
		                 </div>
			     	</div>
				</div>
				<div class="col-md-4">
					<div class="card">
		             	<div class="card-header " style="border-bottom: 1px solid #e3ebf3;">
						 	<h4 class="card-title">Slide Layer</h4>
					 	</div>
		                <div class="card-content">
		                    <div class="card-body">
		                    	<div class="form-group">
	            					<label for="image">Slide Image (Size: 1500X550 px)</label>
	            					<input type="file" name="image" class="form-control <?php echo e($errors->has('image')?'error':''); ?>" >
	            					<?php if($errors->has('image')): ?>
	                              	<p style="color: red;margin: 0;font-size: 10px;"><?php echo e($errors->first('image')); ?></p>
	                               	<?php endif; ?>
	                			</div>
	                    		<div class="form-group">
	                				<img src="<?php echo e(asset($slide->image())); ?>" style="max-width: 100px;">
	                				<?php if($slide->imageFile): ?>
	                				<a href="<?php echo e(route('admin.mediesDelete',$slide->imageFile->id)); ?>" class="mediaDelete" style="color:red;"><i class="fa fa-trash"></i></a>
	                				<?php endif; ?>
	                			</div>
	                			<div class="form-group">
	            					<label for="banner">Slide Mobile Image (Size: 600X800 px)</label>
	            					<input type="file" name="banner" class="form-control <?php echo e($errors->has('banner')?'error':''); ?>" >
	            					<?php if($errors->has('banner')): ?>
	                              	<p style="color: red;margin: 0;font-size: 10px;"><?php echo e($errors->first('banner')); ?></p>
	                               	<?php endif; ?>
	                			</div>
	                			<div class="form-group">
	                				<img src="<?php echo e(asset($slide->banner())); ?>" style="max-width: 100px;">
	                				<?php if($slide->bannerFile): ?>
	                				<a href="<?php echo e(route('admin.mediesDelete',$slide->bannerFile->id)); ?>" class="mediaDelete" style="color:red;"><i class="fa fa-trash"></i></a>
	                				<?php endif; ?>
	                			</div>
	            				<div class="row">
		                     		<div class="form-group col-6">
		                    			<label for="status">Slider Status</label>
						               	<div class="custom-control custom-checkbox">
							                 <input type="checkbox" class="custom-control-input" id="status" name="status"  <?php echo e($slide->status=='active'?'checked':''); ?>/>
							                 <label class="custom-control-label" for="status">Active</label>
						               </div>
			                        </div> 
			                    </div>
			                    <?php if(isset(json_decode(Auth::user()->permission->permission, true)['sliders']['add'])): ?>
	                          	<button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
		                                  changes </button>
		                      <?php endif; ?>

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
<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/sliders/slideEdit.blade.php ENDPATH**/ ?>