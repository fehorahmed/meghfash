<rss xmlns:g="http://base.google.com/ns/1.0" xmlns:c="http://base.google.com/cns/1.0" version="2.0">
    <channel>
        <title>
        <![CDATA[ <?php echo e(general()->meta_title); ?> ]]>
        </title>
        <link>
        <![CDATA[ <?php echo e(route('index')); ?> ]]>
        </link>
        <description>
        <![CDATA[ <?php echo general()->meta_description; ?> ]]>
        </description>
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <item>
            <g:id><?php echo e($product->id); ?></g:id>
            <g:title><![CDATA[ <?php echo e($product->name); ?> ]]></g:title>
            <g:description><![CDATA[ <?php echo $product->description; ?> ]]></g:description>
            <g:link><?php echo e(route('productView',$product->slug?:'no-title')); ?></g:link>
            <g:product_type><?php $__currentLoopData = $product->productCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$ctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($i==0?'':'>'); ?> <?php echo e($ctg->name); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></g:product_type>
            <g:image_link><?php echo e(asset($product->image())); ?></g:image_link>
            <g:condition>new</g:condition>
            <g:availability>in stock</g:availability>
            <g:currency><?php echo e(general()->currency); ?></g:currency>
            <g:price><?php echo e(priceFormat($product->regular_price)); ?></g:price>
            <g:sale_price><?php echo e(priceFormat($product->final_price)); ?></g:sale_price>
        </item>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </channel>
</rss><?php /**PATH /home/meghfash/public_html/resources/views/productFeedXml.blade.php ENDPATH**/ ?>