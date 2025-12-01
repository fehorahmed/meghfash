 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Slider Edit')); ?></title>
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
        <h3 class="content-header-title mb-0">Slider Edit</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Slider Edit</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.sliders')); ?>">BACK</a>
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
                <form action="<?php echo e(route('admin.slidersAction',['update',$slider->id])); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Slider Edit</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="name">Slider Name(*) </label>
                                        <input type="text" class="form-control <?php echo e($errors->has('name')?'error':''); ?>" name="name" placeholder="Enter Slider Name" value="<?php echo e($slider->name?:old('name')); ?>" required="" />
                                        <?php if($errors->has('name')): ?>
                                        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('name')); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="fetured">Slider Location</label>
                                        <select class="form-control" name="location">
                                            <option value="">Select Location</option>
                                            <option value="Front Page Slider" <?php echo e($slider->location=='Front Page Slider'?'selected':''); ?>>Front Page Slider</option>
                                            <option value="Interior Design Slider" <?php echo e($slider->location=='Interior Design Slider'?'selected':''); ?>>Interior Design Slider</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="fetured">Featured Image</label>
                                        <input type="file" name="image" class="form-control <?php echo e($errors->has('image')?'error':''); ?>" />
                                        <?php if($errors->has('image')): ?>
                                        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('image')); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <img src="<?php echo e(asset($slider->image())); ?>" style="max-width: 100px;" />
                                        <?php if(isset(json_decode(Auth::user()->permission->permission, true)['sliders']['add'])): ?>
                                        <?php if($slider->imageFile): ?>
                                        <a href="<?php echo e(route('admin.mediesDelete',$slider->imageFile->id)); ?>" class="mediaDelete" style="color: red;"><i class="fa fa-trash"></i></a>
                                        <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="description">Description </label>
                                    <textarea name="description" rows="5" class="form-control <?php echo e($errors->has('description')?'error':''); ?>" placeholder="Enter Description"><?php echo $slider->description; ?></textarea>
                                    <?php if($errors->has('description')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('description')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <?php if(isset(json_decode(Auth::user()->permission->permission, true)['sliders']['add'])): ?>
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
                                    <br>
                                <?php endif; ?>
                                <div>
                                    <?php echo $__env->make(adminTheme().'sliders.includes.slideItems', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="status">Slider Status</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="status" name="status" <?php echo e($slider->status=='active'?'checked':''); ?>/>
                                            <label class="custom-control-label" for="status">Active</label>
                                        </div>
                                    </div>
                                </div>
                                <?php if(isset(json_decode(Auth::user()->permission->permission, true)['sliders']['add'])): ?>
                                <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save changes</button>
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

<?php $__env->stopSection(); ?> 

<?php $__env->startPush('js'); ?>


<?php $__env->stopPush(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\poshak\resources\views/admin/sliders/slidersEdit.blade.php ENDPATH**/ ?>