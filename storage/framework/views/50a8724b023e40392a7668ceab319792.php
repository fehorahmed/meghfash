<?php if(isset($wlCount)): ?>
    <?php if($wlCount > 0 && $products->count() > 0): ?>
		<div class="row">
            <div class="col-12">
                <div class="table-responsive wishlist_table">
                	<table class="table">
                    	<thead>
                        	<tr>
                            	<th class="product-thumbnail">&nbsp;</th>
                                <th class="product-name" style="min-width: 250px;">Product</th>
                                <th class="product-price" style="min-width: 130px;">Price</th>
                                <th class="product-stock-status" style="min-width: 130px;">Stock Status</th>
                                <th class="product-remove">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
							<?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        	<tr>
                            	<td class="product-thumbnail"><a href="<?php echo e(route('productView',$product->slug?:Str::slug($product->name))); ?>"><img src="<?php echo e(asset($product->image())); ?>" alt="<?php echo e($product->name); ?>" style="max-width:100px;"></a></td>
                                <td class="product-name" data-title="Product"><a href="<?php echo e(route('productView',$product->slug?:Str::slug($product->name))); ?>"><?php echo e($product->name); ?></a></td>
                                <td class="product-price" data-title="Price"><?php echo e(priceFullFormat($product->offerPrice())); ?></td>
                              	<td class="product-stock-status" data-title="Stock Status">
									<?php if($product->stockStatus()): ?>
									<span class="badge rounded-pill text-bg-success">In Stock</span>
									<?php else: ?>
									<span class="badge rounded-pill text-bg-danger">Stock Out</span>
									<?php endif; ?>
							</td>
                            <td class="product-remove" data-title="Remove"><a href="javascript:void(0)" data-url="<?php echo e(route('wishlistCompareUpdate',[$product->id,'wishlist'])); ?>" class="wishlistCompareUpdate"><i class="text-danger fa fa-trash"></i></a></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
				<?php echo e($products->links('pagination')); ?>

            </div>
        </div>
        
    <?php else: ?>

    <div class="emptyWishList" style="text-align:center;">
          <p>No Wishlist Product</p>
    </div>
    <?php endif; ?>

<?php endif; ?><?php /**PATH D:\xampp\htdocs\poshak\resources\views/welcome//carts/includes/wishlistItems.blade.php ENDPATH**/ ?>