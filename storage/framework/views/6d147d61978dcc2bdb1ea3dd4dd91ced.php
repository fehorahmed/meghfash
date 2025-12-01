<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Attribute Edit')); ?></title>
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
       	<a class="btn btn-outline-primary" href="<?php echo e(route('admin.productsAttributes')); ?>">BACK</a>
       	<a class="btn btn-outline-primary" href="<?php echo e(route('admin.productsAttributesAction',['edit',$attribute->id])); ?>">
       		<i class="fa-solid fa-rotate"></i>
       	</a>
     </div>
   </div>
</div>
 
	

 <div class="content-body">
 	<!-- Basic Elements start -->
	 <section class="basic-elements">
	 	<?php echo $__env->make('admin.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	    
	     <div class="row">
	        <div class="col-md-4">
	         	<form action="<?php echo e(route('admin.productsAttributesAction',['update',$attribute->id])); ?>" method="post" enctype="multipart/form-data">
	    		<?php echo csrf_field(); ?>
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
		             			<label>Attribute Type <small>(How to show Attribute)</small></label>
		             			<select class="form-control" name="type">
		             				<option value="1" <?php echo e($attribute->view==1?'selected':''); ?> >Text</option>
		             				<option value="2" <?php echo e($attribute->view==2?'selected':''); ?> >Color</option>
		             				<option value="3" <?php echo e($attribute->view==3?'selected':''); ?> >Image</option>
		             				
		             			</select>
		             		</div>
		             		<div class="row">
    		             		<div class="form-group col-6">
                        			<label for="status">Status</label>
    				               	<div class="custom-control custom-checkbox">
    				                 <input type="checkbox" class="custom-control-input" id="status" name="status"  <?php echo e($attribute->status=='active'?'checked':''); ?>/>
    				                 <label class="custom-control-label" for="status">Active</label>
    				               </div>
    	                        </div> 
    		             		<div class="form-group col-6">
                        			<label for="status">Variation Status</label>
    				               	<div class="custom-control custom-checkbox">
    				                 <input type="checkbox" class="custom-control-input" id="featered" name="fetured"  <?php echo e($attribute->fetured?'checked':''); ?>/>
    				                 <label class="custom-control-label" for="featered">Active</label>
    				               </div>
    	                        </div> 
	                            <div class="form-group col-12">
	                                <label for="status">Date</label>
	                                <input type="date" class="form-control" name="created_at" value="<?php echo e($attribute->created_at->format('Y-m-d')); ?>" />
	                            </div>
		             		</div>
	                       
	                        <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
		                                  changes </button>

		                 </div>
		             </div>
		         	</div>
		         	</form>
				</div>


				<div class="col-md-8">
	         		
		            <div class="card">
		             	<div class="card-header " style="border-bottom: 1px solid #e3ebf3;">
						 	<h4 class="card-title">Attribute Items</h4>
					 	</div>
		                 <div class="card-content">
		                     <div class="card-body">
		                     	<div class="row">
		                     		<div class="col-md-4">
		                     		<a href="<?php echo e(route('admin.productsAttributesItemAction',['create',$attribute->id])); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add Item</a>
    		                     		<!--<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#AddItem">-->
                             <!--              <i class="fa fa-plus"></i> Add Item-->
                             <!--           </button>-->
		                     		</div>
		                     		<div class="col-md-8">
		                     			<form action="<?php echo e(route('admin.productsAttributesAction',['edit',$attribute->id])); ?>">
    		                     			<div class="input-group">
    			                         		<input type="text" name="search" value="<?php echo e($r->search?$r->search:''); ?>" placeholder="Attribute Item Name" class="form-control <?php echo e($errors->has('search')?'error':''); ?>">
    			                         		<button type="submit" class="btn btn-success rounded-0">Search</button>
    			                 			</div>
			                 			</form>
		                     		</div>
		                     	</div>
		                     	<hr>
		                     	<form action="<?php echo e(route('admin.productsAttributesAction',['items-delete',$attribute->id])); ?>">
	                     		<div class="row">
	                     			<div class="col-md-4">
	                     				<div class="input-group mb-1">
	                     					<select class="form-control form-control-sm rounded-0" name="action" required="">
	                     						<option value="">Select Action</option>
	                     						<option value="5">Attributes Delete</option>
	                     					</select>
	                     					<button class="btn btn-sm btn-primary rounded-0" onclick="return confirm('Are You Want To Action?')">Action</button>
	                     				</div>
	                     			</div>
	                     		</div>
		                     	<div class="table-responsive">
    		                     	<table class="table table-striped table-bordered table-hover" >
    								    <thead>
    								        <tr>
    								            <th style="min-width: 60px;">
    								                <label style="cursor: pointer;margin-bottom: 0;">
    					                                <input class="checkbox" type="checkbox" class="form-control" id="checkall">  All <span class="checkCounter"></span>
    					                            </label>
    					                        </th>
    								            <th>Attributes Name</th>
    								            <th width="25%">Action</th>
    								        </tr>
    								    </thead>
    								    <tbody>
    								        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    								        <tr>
    								            <td>
    								            <input class="checkbox" type="checkbox" name="checkid[]" value="<?php echo e($item->id); ?>">
    								            <?php echo e($i+1); ?>

    								            </td>
    								            <td>
    								            <span>
    								                <a href="" target="_blank"><?php echo e($item->name); ?></a></span>
    								              <?php if($item->parent): ?>
    								              <?php if($item->parent->view==2): ?>
    								            	<span style="background:<?php echo e($item->icon?:'black'); ?>;height: 10px;width: 50px;display: inline-block;"></span>
    								            	<?php elseif($item->parent->view==3): ?>
    								            	<img src="<?php echo e(asset($item->parent->image())); ?>" style="max-width:50px;">
    								            	<?php else: ?>
    								            	<?php endif; ?> 
    								            	<?php endif; ?> 
    								               
    								            </td>
    								            <td class="center">
    								            <a href="<?php echo e(route('admin.productsAttributesItemAction',['edit',$item->id])); ?>" class="btn btn-sm btn-info">Edit</a>  
    								            </td>
    								        </tr>
    								        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    								    </tbody>
    								</table>
    								<?php echo e($items->links('pagination')); ?>

		                    	 </div>
		                    </form>
		                     </div>
		                 </div>
		             </div>
		         </div>
		    </div>
	 </section>
	 <!-- Basic Inputs end -->
</div>

<!-- Modal -->
<div class="modal fade text-left" id="AddItem" tabindex="-1" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo e(route('admin.productsAttributesItemAction',['create',$attribute->id])); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel1">Add Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                     	<label for="name">Item Name(*) </label>
                     	<input type="text" class="form-control <?php echo e($errors->has('name')?'error':''); ?>" name="name" placeholder="Enter Item Name" value="<?php echo e(old('name')); ?>" required="" />
                    	<?php if($errors->has('name')): ?>
                    	<p style="color: red;margin: 0;font-size: 10px;"><?php echo e($errors->first('name')); ?></p>
                    	<?php endif; ?>
             		</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add Item</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>


<?php $__env->stopPush(); ?>
<?php echo $__env->make(general()->adminTheme.'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\poshak\resources\views/admin/products/attributes/attributesEdit.blade.php ENDPATH**/ ?>