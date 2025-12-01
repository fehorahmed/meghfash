
<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Category Edit')); ?></title>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
<style type="text/css">

</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Category Edit</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Category Edit</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.productsCategories')); ?>">BACK</a>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.productsCategoriesAction','create')); ?>">Add Category</a>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.productsCategoriesAction',['edit',$category->id])); ?>">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>

<div class="content-body">
    <!-- Basic Elements start -->
    <section class="basic-elements">
        <?php echo $__env->make('admin.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <form action="<?php echo e(route('admin.productsCategoriesAction',['update',$category->id])); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Category Edit</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Category Name(*) </label>
                                    <input type="text" class="form-control <?php echo e($errors->has('name')?'error':''); ?>" name="name" placeholder="Enter Category Name" value="<?php echo e($category->name?:old('name')); ?>" required="" />
                                    <?php if($errors->has('name')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('name')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="parent_id">Parent Category</label>
                                    <select name="parent_id" class="form-control">
                                        <option value="">Select Category</option>

                                        <?php $__currentLoopData = $parents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php if($parent->id==$category->id): ?> <?php else: ?>
                                        <option value="<?php echo e($parent->id); ?>" <?php echo e($parent->id==$category->parent_id?'selected':''); ?>><?php echo e($parent->name); ?></option>
                                        <?php if($parent->subctgs->count() > 0): ?> <?php echo $__env->make('admin.products.includes.editSubcategory',['subcategories' =>$parent->subctgs, 'i'=>1], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <?php endif; ?> <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php if($errors->has('parent_id')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('parent_id')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description </label>
                                    <textarea name="description" class="<?php echo e($errors->has('description')?'error':''); ?> tinyEditor" placeholder="Enter Description"><?php echo $category->description; ?></textarea>
                                    <?php if($errors->has('description')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('description')); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">SEO Optimize</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="seo_title">SEO Meta Title</label>
                                    <input type="text" class="form-control <?php echo e($errors->has('seo_title')?'error':''); ?>" name="seo_title" placeholder="Enter SEO Meta Title" value="<?php echo e($category->seo_title?:old('seo_title')); ?>" />
                                    <?php if($errors->has('seo_title')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('seo_title')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="seo_description">SEO Meta Description </label>
                                    <textarea name="seo_description" class="form-control <?php echo e($errors->has('seo_description')?'error':''); ?>" placeholder="Enter SEO Meta Description"><?php echo $category->seo_description; ?></textarea>
                                    <?php if($errors->has('seo_description')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('seo_description')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="seo_keyword">SEO Meta Keyword </label>
                                    <textarea name="seo_keyword" class="form-control <?php echo e($errors->has('seo_keyword')?'error':''); ?>" placeholder="Enter SEO Meta Keyword"><?php echo $category->seo_keyword; ?></textarea>
                                    <?php if($errors->has('seo_keyword')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('seo_keyword')); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Category Images</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="image">Category Image (Size - 400X400)</label>
                                    <input type="file" name="image" class="form-control <?php echo e($errors->has('image')?'error':''); ?>" />
                                    <?php if($errors->has('image')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('image')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <img src="<?php echo e(asset($category->image())); ?>" style="max-width: 100px;" />
                                    <?php if($category->imageFile): ?>
                                    <a href="<?php echo e(route('admin.mediesDelete',$category->imageFile->id)); ?>" class="mediaDelete" style="color: red;"><i class="fa fa-trash"></i></a>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="banner">Category Banner (Size: 1500X400)</label>
                                    <input type="file" name="banner" class="form-control <?php echo e($errors->has('banner')?'error':''); ?>" />
                                    <?php if($errors->has('banner')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('banner')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <img src="<?php echo e(asset($category->banner())); ?>" style="max-width: 200px;" />
                                    <?php if($category->bannerFile): ?>
                                    <a href="<?php echo e(route('admin.mediesDelete',$category->bannerFile->id)); ?>" class="mediaDelete" style="color: red;"><i class="fa fa-trash"></i></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Category Action</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="status">Category Status</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="status" name="status" <?php echo e($category->status=='active'?'checked':''); ?>/>
                                            <label class="custom-control-label" for="status">Active</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="fetured">Featured</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="fetured" name="fetured" <?php echo e($category->fetured?'checked':''); ?>/>
                                            <label class="custom-control-label" for="fetured">Active</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Published Date</label>
                                    <input type="date" class="form-control form-control-sm" name="created_at" value="<?php echo e($category->created_at->format('Y-m-d')); ?>">
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
    </section>
</div>
<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make(general()->adminTheme.'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/posherbd/public_html/resources/views/admin/products/category/categoryEdit.blade.php ENDPATH**/ ?>