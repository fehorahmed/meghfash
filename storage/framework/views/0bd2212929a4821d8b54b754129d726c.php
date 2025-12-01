
<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Theme Setting')); ?></title>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<style type="text/css">
	.SearchContain{
	    position:relative;
	}
	.searchResultlist {
	    position: absolute;
	    top: 30px;
	    left:0;
	    width: 100%;
	    z-index:9;
	}
	.searchResultlist ul {
	    border: 1px solid #ccd6e6;
	    padding: 0;
	    margin: 0;
	    list-style: none;
	    background: white;
	}

	.searchResultlist ul li {
	    padding: 2px 10px;
	    cursor: pointer;
	    border-bottom: 1px dotted #dcdee0;
	}
	
	.searchResultlist ul li:last-child {
		border-bottom: 0px dotted #dcdee0;
	}
	
	.ProductGridSection {
        border: 1px solid gray;
        padding: 5px;
        text-align: center;
    }
	
	.ProductGrid {
        min-height: 120px;
    }
    
    .ProductGrid img {
        max-width: 100%;
        max-height: 115px;
    }
	
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('contents'); ?>


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
     <h3 class="content-header-title mb-0">Theme Setting</h3>
     <div class="row breadcrumbs-top">
       <div class="breadcrumb-wrapper col-12">
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a>
           </li>
           <li class="breadcrumb-item active">Theme Setting</li>
         </ol>
       </div>
     </div>
   </div>
   <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
     <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
         <a class="btn btn-outline-primary" href="<?php echo e(route('admin.themeSetting')); ?>">Back</a>
       	<a class="btn btn-outline-primary" href="<?php echo e(route('admin.themeSettingAction',['edit',$homedata->id])); ?>">
       		<i class="fa-solid fa-rotate"></i>
       	</a>
     </div>
   </div>
</div>
 
	


 <?php echo $__env->make(adminTheme().'alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 
 
 <form action="<?php echo e(route('admin.themeSettingAction',['update',$homedata->id])); ?>" method="post" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                    <h4 class="card-title">theme Setting</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title(*) </label>
                            <input type="text" class="form-control <?php echo e($errors->has('title')?'error':''); ?>" name="title" placeholder="Enter Title" value="<?php echo e($homedata->name?:old('title')); ?>" required="" />
                            <?php if($errors->has('title')): ?>
                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('title')); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="sub_title">Sub Title </label>
                            <input type="text" class="form-control <?php echo e($errors->has('name')?'error':''); ?>" name="sub_title" placeholder="Enter Sub Title" value="<?php echo e($homedata->sub_title?:old('sub_title')); ?>" />
                            <?php if($errors->has('sub_title')): ?>
                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('sub_title')); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control <?php echo e($errors->has('description')?'error':''); ?>" name="description" placeholder="Enter Description" value="<?php echo e($homedata->description?:old('description')); ?>" />
                            <?php if($errors->has('description')): ?>
                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('description')); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="data_type">Data Type (*)</label>
                            <select class="form-control" name="data_type" required="">
                                 <option value="">Select Type</option>
                                 <option value="Banner Ads Group One" <?php echo e($homedata->data_type=='Banner Ads Group One'?'selected':''); ?>>Banner Ads Group One</option>
                                 <option value="Banner Ads Group Two" <?php echo e($homedata->data_type=='Banner Ads Group Two'?'selected':''); ?>>Banner Ads Group Two</option>
                                 <option value="Banner Ads Group Three" <?php echo e($homedata->data_type=='Banner Ads Group Three'?'selected':''); ?>>Banner Ads Group Three</option>
                                 <option value="Large Banner One" <?php echo e($homedata->data_type=='Large Banner One'?'selected':''); ?>>Large Banner One</option>
                                 <option value="Large Banner Two" <?php echo e($homedata->data_type=='Large Banner Two'?'selected':''); ?>>Large Banner Two</option>
                                 <option value="Category Product Group One" <?php echo e($homedata->data_type=='Category Product Group One'?'selected':''); ?>>Category Product Group One</option>
                                 <option value="Category Product Group Two" <?php echo e($homedata->data_type=='Category Product Group Two'?'selected':''); ?>>Category Product Group Two</option>
                                 <option value="Time Offer Banner" <?php echo e($homedata->data_type=='Time Offer Banner'?'selected':''); ?>>Time Offer Banner</option>
                             </select>
                            <?php if($errors->has('data_type')): ?>
                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('data_type')); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="row">
                            
                            <div class="form-group col-md-8">
                                <label for="category_id">Category List</label>
                                <select class="form-control" name="category_id">
                                     <option value="">Select Type</option>
                                     <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                     <option value="<?php echo e($ctg->id); ?>" <?php echo e($homedata->category_id==$ctg->id?'selected':''); ?>><?php echo e($ctg->name); ?></option>
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 </select>
                                <?php if($errors->has('category_id')): ?>
                                <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('category_id')); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="data_limit">Data Limit (*)</label>
                                <input type="number" class="form-control <?php echo e($errors->has('data_limit')?'error':''); ?>" name="data_limit" placeholder="Enter Data Limit" value="<?php echo e($homedata->data_limit?:old('data_limit')); ?>" required="" />
                                <?php if($errors->has('data_limit')): ?>
                                <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('data_limit')); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                    <h4 class="card-title">Images</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" class="form-control <?php echo e($errors->has('image')?'error':''); ?>" />
                            <?php if($errors->has('image')): ?>
                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('image')); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <img src="<?php echo e(asset($homedata->image())); ?>" style="max-width: 100px;" />
                            <?php if($homedata->imageFile): ?>
                            <a href="<?php echo e(route('admin.mediesDelete',$homedata->imageFile->id)); ?>" class="mediaDelete" style="color: red;"><i class="fa fa-trash"></i></a>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="image_link">Image/Button Link</label>
                            <input type="text" class="form-control <?php echo e($errors->has('image_link')?'error':''); ?>" name="image_link" placeholder="Enter Image Link" value="<?php echo e($homedata->image_link?:old('image_link')); ?>" />
                            <?php if($errors->has('image_link')): ?>
                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('image_link')); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="image2">Image 2</label>
                            <input type="file" name="image2" class="form-control <?php echo e($errors->has('image2')?'error':''); ?>" />
                            <?php if($errors->has('image2')): ?>
                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('image2')); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <img src="<?php echo e(asset($homedata->banner())); ?>" style="max-width: 100px;" />
                            <?php if($homedata->bannerFile): ?>
                            <a href="<?php echo e(route('admin.mediesDelete',$homedata->bannerFile->id)); ?>" class="mediaDelete" style="color: red;"><i class="fa fa-trash"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                    <h4 class="card-title"> Action</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="status"> Status</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="status" name="status" <?php echo e($homedata->status=='active'?'checked':''); ?>/>
                                    <label class="custom-control-label" for="status">Active</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Published Date</label>
                            <input type="date" class="form-control form-control-sm" name="created_at" value="<?php echo e($homedata->created_at->format('Y-m-d')); ?>">
                            <?php if($errors->has('created_at')): ?>
                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('created_at')); ?></p>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>



<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>


<script>
    $(document).ready(function(){
        
        $(".searchResultlist").hide();

    	$(document).on('click', function(e) {
    
    	    var container = $(".SearchContain");
    	    var containerClose = $(".searchResultlist");
    	    
    	    if (!$(e.target).closest(container).length) {
    	        containerClose.hide();
    	    }else{
    	    	containerClose.show();
    	    }
    
    	});
        
        
        var url ="<?php echo e(route('admin.themeSettingAction',['edit',$homedata->id])); ?>";
        var key;
        var type;
        
        $(document).on('keyup','.serchProducts',function(){
            type ='search';
    		key =$(this).val();

    		$.ajax({
              url:url,
              dataType: 'json',
              cache: false,
              data: {'key':key,'type':type},
               success : function(data){
    
                $('.searchResultlist').empty().append(data.view);
    
               },error: function () {
                 // alert('error');
    
                }
            });
    
    	});
    	
    	$(document).on('click','.searchResultlist ul li',function(){
    		id =$(this).data('id');
    		type =$(this).data('type');
    		
    		$(".searchResultlist").hide();
    		
    		$.ajax({
              url:url,
              dataType: 'json',
              cache: false,
              data: {'key':key,'id':id,'type':type},
               success : function(data){
    
                $('.HomeProducts').empty().append(data.view);
    
               },error: function () {
                 // alert('error');
    
                }
            });
    		
    		
    	});
    	
        
    });
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\poshak\resources\views/admin/theme-setting/themeSettingEdit.blade.php ENDPATH**/ ?>