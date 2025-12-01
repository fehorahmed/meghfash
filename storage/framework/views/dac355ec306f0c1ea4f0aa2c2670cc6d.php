 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Gallery Edit')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>

<style type="text/css">
    .fileUpload-div {
        border: 2px dotted #e3e3e3;
        padding: 25px;
        text-align: center;
    }

    .fileUpload-div p {
        font-size: 20px;
        color: silver;
        text-transform: uppercase;
    }
    .fileUpload-div label {
        margin: 0;
        border: 1px solid #dc379b;
    }
    .fileUpload-div i {
        font-size: 60px;
        cursor: pointer;
        color: #c6c2c2;
    }
</style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Gallery Edit</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Gallery Edit</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.galleries')); ?>">BACK</a>
            <?php if(isset(json_decode(Auth::user()->permission->permission, true)['galleries']['add'])): ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.galleriesAction',['create'])); ?>">Add Gallery</a>
          	<?php endif; ?>
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

        <div class="row">
            <div class="col-md-12">
                <form action="<?php echo e(route('admin.galleriesAction',['update',$gallery->id])); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Gallery Edit</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="name">Gallery Name(*) </label>
                                        <input type="text" class="form-control <?php echo e($errors->has('name')?'error':''); ?>" name="name" placeholder="Enter Gallery Name" value="<?php echo e($gallery->name?:old('name')); ?>" required="" />
                                        <?php if($errors->has('name')): ?>
                                        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('name')); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="fetured">Gallery Location</label>
                                        <select class="form-control" name="location">
                                            <option value="">Select Location</option>
                                            <option value="Home Gallery" <?php echo e($gallery->location=='Home Gallery'?'selected':''); ?>>Home Gallery</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="image">Featured Image</label>
                                        <input type="file" name="image" class="form-control <?php echo e($errors->has('image')?'error':''); ?>" />
                                        <?php if($errors->has('image')): ?>
                                        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('image')); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <img src="<?php echo e(asset($gallery->image())); ?>" style="max-width: 100px;" />
                                        <?php if(isset(json_decode(Auth::user()->permission->permission, true)['galleries']['add'])): ?>
                                        <?php if($gallery->imageFile): ?>
                                        <a href="<?php echo e(route('admin.mediesDelete',$gallery->imageFile->id)); ?>" class="mediaDelete" style="color: red;"><i class="fa fa-trash"></i></a>
                                        <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description </label>
                                    <textarea name="description" rows="5" class="form-control <?php echo e($errors->has('description')?'error':''); ?>" placeholder="Enter Description"><?php echo $gallery->description; ?></textarea>
                                    <?php if($errors->has('description')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('description')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <?php if(isset(json_decode(Auth::user()->permission->permission, true)['galleries']['add'])): ?>
                                    <div class="fileUpload-div">
                                        <div>
                                            <p>Click To Upload Images (Multiple)</p>
                                        </div>
                                        <div>
                                            <?php if($errors->has('images')): ?>
                                            <p style="color: red; margin: 0; font-size: 10px;">The Tags Must Be (jpeg,png,jpg,gif,svg) max:2024 MB</p>
                                            <?php endif; ?>
                                            <small>(jpeg,png,jpg,gif,svg) max:25 MB</small>
                                        </div>
                                        <div>
                                            <label>
                                                <input type="file" name="images[]" multiple="" class="fileUpload" />
                                            </label>
                                            
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <hr>
                                <div class="sliderImagesList">
                                <?php echo $__env->make('admin.galleries.includes.galleriesImages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label for="status">Gallery Status</label>
                                        <select class="form-control" name="status">
                                            <option value="active" <?php echo e($gallery->status=='active'?'checked':''); ?>>Active</option>
                                            <option value="inactive" <?php echo e($gallery->status=='inactive' || $gallery->status=='temp'?'checked':''); ?>>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <?php if(isset(json_decode(Auth::user()->permission->permission, true)['galleries']['add'])): ?>
                                <button type="submit" class="btn btn-primary btn-md mr-sm-1 mb-1 mb-sm-0">Save changes</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Basic Inputs end -->
</div>

<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?>
<script type="text/javascript">

</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/admin/galleries/galleriesEdit.blade.php ENDPATH**/ ?>