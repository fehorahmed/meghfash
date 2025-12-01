
<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Theme Setting')); ?></title>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>

<style type="text/css">
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
           <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
           <li class="breadcrumb-item active">Theme Setting</li>
         </ol>
       </div>
     </div>
   </div>
   <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
     <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
       	<a class="btn btn-outline-primary" href="<?php echo e(route('admin.themeSetting')); ?>">
       		<i class="fa-solid fa-rotate"></i>
       	</a>
     </div>
   </div>
</div>
 

 <div class="content-body">
	 <section class="basic-elements">
	     <div class="row">
	         <div class="col-md-12">
	         	<?php echo $__env->make(adminTheme().'alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	             <div class="card">
	             	<div class="card-header " style="border-bottom: 1px solid #e3ebf3;">
						<h4 class="card-title">theme Setting</h4>
					</div>
	                 <div class="card-content">
	                     <div class="card-body">
	                         <div class="offer-notes-list">
                                <h3>Offer PopUp</h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 200px;min-width:200px;">Action</th>
                                            <th>Offer Text</th>
                                            <th style="width: 200px;min-width:200px;">Image</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Status:</b>
                                                <?php if($bannerNote->status=='active'): ?>
                                                <span class="badge badge-sm badge-success">
                                                <?php else: ?>
                                                <span class="badge badge-sm badge-danger">
                                                <?php endif; ?>
                                                <?php echo e(ucfirst($bannerNote->status)); ?>

                                                </span>
                                                <br>
                                                <a href="javascript:void(0)" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editBannerNote_<?php echo e($bannerNote->id); ?>" >Edit</a> 
                                            </td>
                                            <td>

                                                <b>Link:</b>
                                                <?php echo e($bannerNote->sub_title); ?>

                                            </td>
                                            <td>
                                                <img src="<?php echo e(asset($bannerNote->image())); ?>" style="max-height:60px;">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- <div class="Feature-notes-list">
                                <h3>Home Featured Text <span class="btn btn-sm btn-info" data-toggle="modal" data-target="#editFeaturedNote">Edit</span></h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Shipping</th>
                                            <th>Payment</th>
                                            <th>Return</th>
                                            <th>Support</th>
                                        </tr>
                                        <?php if($featuredNote): ?>
                                        <tr>
                                            <td><?php echo e($featuredNote->name); ?></td>
                                            <td><?php echo e($featuredNote->content); ?></td>
                                            <td><?php echo e($featuredNote->sub_title); ?></td>
                                            <td><?php echo e($featuredNote->description); ?></td>
                                        </tr>
                                        <?php endif; ?>
                                    </table>
                                </div>
                            </div> -->
	                         <div class="offer-notes-list">
                                <h3>Home Gallery Images 
                                    <!-- <a href="javascript:void(0)" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addOfferNote"><i class="fa fa-plus"></i> Add Note</a>  -->
                                </h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 200px;min-width:200px;">Action</th>
                                            <th>Note</th>
                                        </tr>
                                        <?php $__currentLoopData = $offerNotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n=>$note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <b>Status:</b>
                                                <?php if($note->status=='active'): ?>
                                                <span class="badge badge-sm badge-success">
                                                <?php else: ?>
                                                <span class="badge badge-sm badge-danger">
                                                <?php endif; ?>
                                                <?php echo e(ucfirst($note->status)); ?>

                                                </span>
                                                <br>
                                                <b>Date:</b> <?php echo e($note->created_at->format('d-m-Y')); ?><br>
                                               <a href="javascript:void(0)" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editOfferNote_<?php echo e($note->id); ?>" >Edit</a> 
                                               <!-- <a href="<?php echo e(route('admin.themeSettingAction',['delete-offer-note',$note->id])); ?>" class="btn btn-sm btn-danger mx-2" onclick="return confirm('Are You Want to Delete?')"><i class="fa fa-trash"></i></a>  -->
                                            </td>
                                            <td>
                                               <div class="row">
                                                    <div class="col-md-12">
                                                        <label>Link</label><br>
                                                        <?php echo e($note->content); ?>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Image:</label><br>
                                                        <img src="<?php echo e(asset($note->image())); ?>" style="max-height:60px;">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Hover Image:</label><br>
                                                        <img src="<?php echo e(asset($note->banner())); ?>" style="max-height:60px;">
                                                    </div>
                                               </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </table>
                                </div>
                            </div>
	                         <hr>
	                         <div class="row">
	                             <div class="col-md-8">
	                                 <h3>Home Page Product Manage  <a class="btn btn-sm btn-primary" href="<?php echo e(route('admin.themeSettingAction','create')); ?>" onclick="return confirm('Are You Want to Add?')"><i class="fa fa-plus"></i> Add</a></h3>
	                             </div>
	                         </div>
		                     <div class="table-responsive">
		                        <table class="table table-bordered">
		                             <tr>
		                                 <th style="width: 200px;min-width: 200px;">Title</th>
		                                 <th style="min-width: 100px;">Data Type</th>
		                                 <th style="min-width: 100px;">Image</th>
		                                 <th style="min-width: 120px;">Status</th>
		                                 <th style="min-width: 120px;">Date</th>
		                                 <th style="min-width: 100px;">Action</th>
		                             </tr>
		                             <?php $__currentLoopData = $homeDatas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $homedata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                             <tr>
		                                 <td><?php echo $homedata->name; ?></td>
		                                 <td>
		                                     <?php if($homedata->data_type): ?>
		                                     <span><?php echo e($homedata->data_type); ?></span>
		                                     <?php endif; ?>
		                                 </td>
		                                 <td>
		                                     <img src="<?php echo e(asset($homedata->image())); ?>" style="max-height:60px;max-width:80px;">
		                                 </td>
		                                 <td>
		                                     <?php if($homedata->status=='active'): ?>
		                                     <span class="badge badge-success">
		                                     <?php else: ?>
		                                     <span class="badge badge-danger">
		                                     <?php endif; ?>
		                                     <?php echo e(ucfirst($homedata->status)); ?>

		                                     </span>
		                                 </td>
		                                 <td>
		                                     <?php echo e($homedata->created_at->format('d-m-Y')); ?>

		                                 </td>
		                                 <td>
		                                     <a href="<?php echo e(route('admin.themeSettingAction',['edit',$homedata->id])); ?>" class="btn btn-sm btn-success">Edit</a>
		                                     <a href="<?php echo e(route('admin.themeSettingAction',['delete',$homedata->id])); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are You Want To Delete?')"><i class="fa fa-trash"></i></a>
		                                 </td>
		                             </tr>
		                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                         </table>    
		                     </div>
		                     <hr>
	                     </div>
	                     
	                 </div>
	             </div>


	         </div>
	     </div>
	 </section>
	 <!-- Basic Inputs end -->
</div>


<!-- Modal -->
<div class="modal fade text-left" id="editBannerNote_<?php echo e($bannerNote->id); ?>" tabindex="-1" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo e(route('admin.themeSettingAction',['update-banner-note',$bannerNote->id])); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h4 class="modal-title">Edit PopUp Banner</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Banner Link</label>
                        <input type="text" class="form-control <?php echo e($errors->has('sub_title')?'error':''); ?>" name="sub_title" placeholder="Enter Note" value="<?php echo e(old('sub_title')?:$bannerNote->sub_title); ?>" required="" />
                        <?php if($errors->has('sub_title')): ?>
                        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('sub_title')); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="image">Banner Image</label>
                        <input type="file" name="image" class="form-control <?php echo e($errors->has('image')?'error':''); ?>" />
                        <?php if($errors->has('image')): ?>
                        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('image')); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Status</label>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="status_banner" name="status" <?php echo e($bannerNote->status=='active'?'checked':''); ?>/>
                                <label class="custom-control-label" for="status_banner">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Update PopUp Banner</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if($featuredNote): ?>
<!-- Modal -->
<div class="modal fade text-left" id="editFeaturedNote" tabindex="-1" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo e(route('admin.themeSettingAction',['update-featured-note',$featuredNote->id])); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h4 class="modal-title">Edit Featured Text</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Shipping</label>
                        <input type="text" class="form-control <?php echo e($errors->has('payment_delivery')?'error':''); ?>" name="payment_delivery" placeholder="Enter Note" value="<?php echo e(old('payment_delivery')?:$featuredNote->name); ?>" required="" />
                        <?php if($errors->has('payment_delivery')): ?>
                        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('payment_delivery')); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label>Payment</label>
                        <input type="text" class="form-control <?php echo e($errors->has('return_refund')?'error':''); ?>" name="return_refund" placeholder="Enter Note" value="<?php echo e(old('return_refund')?:$featuredNote->content); ?>" required="" />
                        <?php if($errors->has('return_refund')): ?>
                        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('return_refund')); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label>Return</label>
                        <input type="text" class="form-control <?php echo e($errors->has('online_support')?'error':''); ?>" name="online_support" placeholder="Enter Note" value="<?php echo e(old('online_support')?:$featuredNote->sub_title); ?>" required="" />
                        <?php if($errors->has('online_support')): ?>
                        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('online_support')); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label>Support</label>
                        <input type="text" class="form-control <?php echo e($errors->has('gift_card')?'error':''); ?>" name="gift_card" placeholder="Enter Note" value="<?php echo e(old('gift_card')?:$featuredNote->description); ?>" required="" />
                        <?php if($errors->has('gift_card')): ?>
                        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('gift_card')); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Update Text</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>


<?php $__currentLoopData = $offerNotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<!-- Modal -->
<div class="modal fade text-left" id="editOfferNote_<?php echo e($note->id); ?>" tabindex="-1" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo e(route('admin.themeSettingAction',['update-offer-note',$note->id])); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h4 class="modal-title">Edit Gallery</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Link</label>
                        <input type="text" class="form-control <?php echo e($errors->has('link_url')?'error':''); ?>" name="link_url" placeholder="Enter Note" value="<?php echo e(old('link_url')?:$note->content); ?>" required="" />
                        <?php if($errors->has('link_url')): ?>
                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('link_url')); ?></p>
                            <?php endif; ?>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" class="form-control <?php echo e($errors->has('image')?'error':''); ?>" />
                            <?php if($errors->has('image')): ?>
                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('image')); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="image">Hover Image</label>
                            <input type="file" name="hover_image" class="form-control <?php echo e($errors->has('hover_image')?'error':''); ?>" />
                            <?php if($errors->has('hover_image')): ?>
                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('hover_image')); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Status</label>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="status_<?php echo e($note->id); ?>" name="status" <?php echo e($note->status=='active'?'checked':''); ?>/>
                                <label class="custom-control-label" for="status_<?php echo e($note->id); ?>">Active</label>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Created Date</label>
                            <input type="date" class="form-control <?php echo e($errors->has('note_title')?'error':''); ?>" name="created_at" value="<?php echo e($note->created_at->format('Y-m-d')); ?>" required="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Update Gallery</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<!-- Modal -->
<div class="modal fade text-left" id="addOfferNote" tabindex="-1" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo e(route('admin.themeSettingAction','add-offer-note')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h4 class="modal-title">Add Offer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Enter Note</label>
                        <input type="text" class="form-control <?php echo e($errors->has('note_title')?'error':''); ?>" name="note_title" placeholder="Enter Note" value="<?php echo e(old('note_title')); ?>" required="" />
                        <?php if($errors->has('note_title')): ?>
                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('note_title')); ?></p>
                            <?php endif; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add Note</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\poshak\resources\views/admin/theme-setting/themeSetting.blade.php ENDPATH**/ ?>