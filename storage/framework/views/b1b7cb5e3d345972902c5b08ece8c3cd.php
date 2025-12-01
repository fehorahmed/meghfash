 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Post Edit')); ?></title>
<?php $__env->stopSection(); ?> 

<?php $__env->startPush('css'); ?>

<style type="text/css">
    .catagorydiv {
        max-height: 300px;
        overflow: auto;
    }
    .catagorydiv ul {
        padding-left: 20px;
    }
    .catagorydiv ul li {
        list-style: none;
    }
    .slugEditData{
        display:none;
    }
</style>
<?php $__env->stopPush(); ?> 
<?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Post Edit</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Post Edit</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.posts')); ?>">BACK</a>
            <?php if(isset(json_decode(Auth::user()->permission->permission, true)['posts']['add'])): ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.postsAction',['create'])); ?>">Add Post</a>
            <?php endif; ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.postsAction',['edit',$post->id])); ?>">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>

<div class="content-body">
    <!-- Basic Elements start -->
    <section class="basic-elements">
        <?php echo $__env->make(adminTheme().'alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <form action="<?php echo e(route('admin.postsAction',['update',$post->id])); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Post Edit</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Post Name </label>
                                    <input type="text" class="form-control <?php echo e($errors->has('name')?'error':''); ?>" name="name" placeholder="Enter Post Name" value="<?php echo e($post->name?:old('name')); ?>" required="" />
                                    <?php if($errors->has('name')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('name')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="short_description">Short Description </label>
                                    <textarea name="short_description" class="form-control <?php echo e($errors->has('short_description')?'error':''); ?>" placeholder="Enter Short Description"><?php echo $post->short_description; ?></textarea>
                                    <?php if($errors->has('short_description')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('short_description')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description </label>
                                    <textarea name="description" class="<?php echo e($errors->has('description')?'error':''); ?> tinyEditor" placeholder="Enter Description"><?php echo $post->description; ?></textarea>
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
                                    <input type="text" class="form-control <?php echo e($errors->has('seo_title')?'error':''); ?>" name="seo_title" placeholder="Enter SEO Meta Title" value="<?php echo e($post->seo_title?:old('seo_title')); ?>" />
                                    <?php if($errors->has('seo_title')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('seo_title')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="seo_description">SEO Meta Description </label>
                                    <textarea name="seo_description" class="form-control <?php echo e($errors->has('seo_description')?'error':''); ?>" placeholder="Enter SEO Meta Description"><?php echo $post->seo_description; ?></textarea>
                                    <?php if($errors->has('seo_description')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('seo_description')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="seo_keyword">SEO Meta Keyword </label>
                                    <textarea name="seo_keyword" class="form-control <?php echo e($errors->has('seo_keyword')?'error':''); ?>" placeholder="Enter SEO Meta Keyword"><?php echo $post->seo_keyword; ?></textarea>
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
                            <h4 class="card-title">Post Images</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="image">Post Image (600px X 350px)</label>
                                    <input type="file" name="image" class="form-control <?php echo e($errors->has('image')?'error':''); ?>" />
                                    <?php if($errors->has('image')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('image')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <img src="<?php echo e(asset($post->image())); ?>" style="max-width: 100px;" />
                                    <?php if(isset(json_decode(Auth::user()->permission->permission, true)['posts']['add'])): ?>
                                    <?php if($post->imageFile): ?>
                                    <a href="<?php echo e(route('admin.mediesDelete',$post->imageFile->id)); ?>" class="mediaDelete" style="color: red;"><i class="fa fa-trash"></i></a>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="banner">Post Banner</label>
                                    <input type="file" name="banner" class="form-control <?php echo e($errors->has('banner')?'error':''); ?>" />
                                    <?php if($errors->has('banner')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('banner')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <img src="<?php echo e(asset($post->banner())); ?>" style="max-width: 200px;" />
                                    <?php if(isset(json_decode(Auth::user()->permission->permission, true)['posts']['add'])): ?>
                                    <?php if($post->bannerFile): ?>
                                    <a href="<?php echo e(route('admin.mediesDelete',$post->bannerFile->id)); ?>" class="mediaDelete" style="color: red;"><i class="fa fa-trash"></i></a>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Post Category</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <?php if($errors->has('categoryid*')): ?>
                                <p style="color: red; margin: 0; font-size: 10px;">The Category Must Be a Number</p>
                                <?php endif; ?>
                                <div class="catagorydiv">
                                    <ul>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" value="<?php echo e($ctg->id); ?>" id="category_<?php echo e($ctg->id); ?>" name="categoryid[]" <?php $__currentLoopData = $post->postCtgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $postctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($postctg->reff_id==$ctg->id?'checked':''); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>/>
                                                <label class="custom-control-label" for="category_<?php echo e($ctg->id); ?>"><?php echo e($ctg->name); ?></label>
                                            </div>
                                            <?php if($ctg->subCtgs->count() >0): ?> <?php echo $__env->make(adminTheme().'posts.includes.postsEditSubctg',['subcategories' => $ctg->subCtgs,'i'=>1], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <?php endif; ?>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Post Tags</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!--<textarea id="hero-demo" name="tagskey"><?php echo $post->tags?:old('tagskey'); ?></textarea>-->
                                
                                
                                <?php if($errors->has('tags*')): ?>
                                <p style="color: red; margin: 0; font-size: 10px;">The Tags Must Be a Number</p>
                                <?php endif; ?>
                                <select data-placeholder="Select Tags..." name="tags[]" class="select2 form-control" multiple="multiple">
                                    <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tag->id); ?>" <?php $__currentLoopData = $post->postTags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $posttag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($posttag->reff_id==$tag->id?'selected':''); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>><?php echo e($tag->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Post Action</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="status">Post Status</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="status" name="status" <?php echo e($post->status=='active'?'checked':''); ?>/>
                                            <label class="custom-control-label" for="status">Active</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="fetured">Post Fetured</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="fetured" name="fetured" <?php echo e($post->fetured?'checked':''); ?>/>
                                            <label class="custom-control-label" for="fetured">Active</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Published Date</label>
                                    <input type="date" class="form-control form-control-sm" name="created_at" value="<?php echo e($post->created_at->format('Y-m-d')); ?>">
                                    <?php if($errors->has('created_at')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('created_at')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <?php if(isset(json_decode(Auth::user()->permission->permission, true)['posts']['add'])): ?>
                                <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save changes</button>
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

<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?>

    <script>
        $(function() {
            $('#hero-demo').tagEditor({
                placeholder: 'Enter tags ...',
            });
        });
    </script>
<script>
    $(document).ready(function(){
        $('.slugEdit').click(function(){
            $('.slugEditData').toggle();
        });
    });
</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/posts/postEdit.blade.php ENDPATH**/ ?>