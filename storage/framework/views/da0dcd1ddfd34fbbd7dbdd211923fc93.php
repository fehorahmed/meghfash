<div class="productGridBox">
    <a href="<?php echo e(route('productView',$product->slug?:Str::slug($product->name))); ?>" class="imgPro"><img src="<?php echo e(asset($product->image())); ?>" alt="<?php echo e($product->name); ?>" /></a>
    <span><?php echo e($product->brand?$product->brand->name:''); ?></span>
    <a href="<?php echo e(route('productView',$product->slug?:Str::slug($product->name))); ?>" class="titlePro"><?php echo e(Str::limit($product->name,50)); ?></a>
    <h5>
        <?php echo e(priceFullFormat($product->offerPrice())); ?>/-
        <?php if($product->regularPrice() > $product->offerPrice()): ?>
        <del><?php echo e(priceFullFormat($product->regularPrice())); ?>/-</del>
        <?php endif; ?>
    </h5>
    <div class="row" style="margin:0 -5px">
        <div class="col-md-6" style="0 5px;">
            <a 
            <?php if($product->variation_status): ?>
            href="<?php echo e(route('productView',$product->slug?:Str::slug($product->name))); ?>"
            <?php else: ?>
            href="<?php echo e(route('addToCart',[$product->id,'orderNow'=>'order'])); ?>"
            <?php endif; ?>
            class="buyBtn">Buy Now</a>
        </div>
        <div class="col-md-6" style="0 5px;">
            <a 
            <?php if($product->variation_status): ?>
            href="<?php echo e(route('productView',$product->slug?:Str::slug($product->name))); ?>"
            <?php else: ?>
            href="javascript:void(0)"
            <?php endif; ?>
            data-id="<?php echo e($product->id); ?>" data-url="<?php echo e(route('addToCart',$product->id)); ?>" 
            class="addCart <?php echo e($product->variation_status?'':'ajaxaddToCart'); ?>"
            
            >Add To Cart</a>
        </div>
    </div>
</div><?php /**PATH D:\xampp\htdocs\poshak\resources\views/welcome//products/includes/productCard.blade.php ENDPATH**/ ?>