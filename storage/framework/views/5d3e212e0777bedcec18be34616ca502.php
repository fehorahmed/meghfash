<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    
    <url>
        <loc><?php echo e(route('index')); ?></loc>
        <lastmod><?php echo e(Carbon\Carbon::now()->toAtomString()); ?></lastmod>
        <priority>1.00</priority>
    </url>
    
    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <url>
            <loc><?php echo e(route('pageView',$page->slug?:'no-title')); ?></loc>
            <lastmod><?php echo e($page->updated_at->toAtomString()); ?></lastmod>
            <priority><?php if($page->fetured): ?> 0.9 <?php else: ?> 0.8 <?php endif; ?></priority>
        </url>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <url>
            <loc><?php echo e(route('productView',$product->slug?:'no-title')); ?></loc>
            <lastmod><?php echo e($product->updated_at->toAtomString()); ?></lastmod>
            <priority><?php if($product->fetured): ?> 0.5 <?php else: ?> 0.4 <?php endif; ?></priority>
        </url>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <url>
            <loc><?php echo e(route('blogView',$post->slug?:'no-title')); ?></loc>
            <lastmod><?php echo e($post->updated_at->toAtomString()); ?></lastmod>
            <priority><?php if($post->fetured): ?> 0.7 <?php else: ?> 0.6 <?php endif; ?></priority>
        </url>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    
    
</urlset><?php /**PATH /home/posherbd/public_html/resources/views/siteMap.blade.php ENDPATH**/ ?>