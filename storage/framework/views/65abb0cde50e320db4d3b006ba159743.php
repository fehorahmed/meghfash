 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle($post->seo_title?:$post->name)); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startSection('SEO'); ?>
<meta name="title" property="og:title" content="<?php echo e(websiteTitle($post->seo_title?:$post->name)); ?>" />
<meta name="description" property="og:description" content="<?php echo $post->seo_description?:general()->meta_description; ?>" />
<meta name="keywords" content="<?php echo e($post->seo_keyword?:general()->meta_keyword); ?>" />
<meta name="image" property="og:image" content="<?php echo e(asset($post->image())); ?>" />
<meta name="url" property="og:url" content="<?php echo e(route('blogView',$post->slug?:'no-title')); ?>" />
<link rel="canonical" href="<?php echo e(route('blogView',$post->slug?:'no-title')); ?>" />
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?> <?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="singleProHead">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('index')); ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo e($post->name); ?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="blogCompany">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="blog_title">
                    <h2><?php echo e($post->name); ?></h2>
                    <span><i class="fa fa-calendar"></i> <?php echo e($post->created_at->format('d F, Y')); ?></span>
                    <a href="javascript:void(0)"> <i class="fa fa-user"></i> <?php echo e($post->user?$post->user->name:'No Author'); ?> </a>
                </div>
                <div class="single_blog_thumb" style="padding: 10px 0;">
                    <img src="<?php echo e(route('imageView2',['resize',$post->imageName()])); ?>" alt="<?php echo e($post->name); ?>" />
                </div>
                <div class="single-blog-content">
                    <?php echo $post->short_description; ?>

                    <hr />
                    <div class="detilsContentText">
                        <?php echo $post->description; ?>

                    </div>
                </div>
                
            </div>
            <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
                <?php echo $__env->make(welcomeTheme().'blogs.includes.sideBar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <hr />
                    <div class="realated-blogs">
                        <h2>Related Blogs</h2>

                        <div class="row" style="padding: 10px 0;">
                            <?php $__currentLoopData = $relatedPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-3">
                                <?php echo $__env->make(welcomeTheme().'.blogs.includes.blogGrid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        
                    </div>
            </div>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?> <?php $__env->stopPush(); ?>
<?php echo $__env->make(welcomeTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\poshak\resources\views/welcome/blogs/blogView.blade.php ENDPATH**/ ?>