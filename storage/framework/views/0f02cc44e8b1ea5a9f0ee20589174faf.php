 
<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Product Lavel Print')); ?></title>
<?php $__env->stopSection(); ?> 
<?php $__env->startPush('css'); ?>

<?php $__env->stopPush(); ?> 
<?php $__env->startSection('contents'); ?>
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Product Lavel Print</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Product Lavel Print</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.productsLabelPrint')); ?>">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-content">
        <div id="accordion">
            <div
                class="card-header collapsed"
                data-toggle="collapse"
                data-target="#collapseTwo"
                aria-expanded="false"
                aria-controls="collapseTwo"
                id="headingTwo"
                style="background:#009688;padding: 15px 20px; cursor: pointer;"
            >
               <i class="fa fa-filter"></i> Search click Here..
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="border: 1px solid #00b5b8; border-top: 0;">
                <div class="card-body">
                    <form action="<?php echo e(route('admin.productsLabelPrint')); ?>">
                         <div class="row">
                            <div class="col-md-4 mb-1">
                                <select name="category" class="form-control">
                                    <option value="">All Category</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($ctg->id); ?>" <?php echo e(request()->category==$ctg->id?'selected':''); ?> ><?php echo e($ctg->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-8 mb-1">
                                <div class="input-group">
                                    <input type="text" name="search" value="<?php echo e(request()->search); ?>" placeholder="Search Product name , Barcode" class="form-control" />
                                    <button type="submit" class="btn btn-success rounded-0">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content-body">
    <!-- Basic Elements start -->
    <section class="basic-elements">
        <div class="row">
            <div class="col-md-12">
			<?php echo $__env->make('admin.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            	<div class="card">
                    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                        <h4 class="card-title">Product Barcode List</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="min-width: 130px;">Product</th>
                                                <th style="min-width: 120px;width:200px;">Category</th>
                                                <th style="min-width: 120px;width:120px;">Barcode</th>
                                                <th style="min-width: 80px;width: 80px;">Image</th>
                                                <th style="min-width: 120px;width:120px;padding:1px;">
                                                    <a href="<?php echo e(route('admin.productsLabelPrint',['preview'=>'view'])); ?>" class="btn btn-info"><i class="fa fa-barcode" style=""></i> Print Barcode  </a>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($product->variation_status): ?>
                                                    <?php $__currentLoopData = $product->productVariationActiveAttributeItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($product->name); ?><br> <?php echo $item->variationItemValues(); ?>

                                                            <a href="<?php echo e(route('admin.productsAction',['edit',$product->id])); ?>" target="_blank"><i class="fa fa-edit"></i></a>
                                                            <b>Qty:</b> <?php echo e($item->quantity); ?>

                                                        </td>
                                                        <td>
                                                            <?php $__currentLoopData = $product->productCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$ctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                             <?php echo e($i==0?'':'-'); ?> <?php echo e($ctg->name); ?> 
                        
                                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo e($item->barcode); ?> <br>
                                                            <small><?php echo e(priceFullFormat($item->final_price)); ?></small>
                                                        </td>
                                                        <td>
                                                            <img src="<?php echo e(asset($item->variationImage())); ?>" style="max-width: 70px; max-height: 50px;" />
                                                        </td>
                                                        <td>
                                                             <span class="btn btn-sm btn-danger printAdd" data-url="<?php echo e(route('admin.productsLabelPrint',['product_id'=>$product->id,'variant_id'=>$item->id,'actiontype'=>1])); ?>">Add Print</span>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td><?php echo e($product->name); ?><br>
                                                        <a href="<?php echo e(route('admin.productsAction',['edit',$product->id])); ?>" target="_blank"><i class="fa fa-edit"></i></a>
                                                        <b>Qty:</b> <?php echo e($product->quantity); ?>

                                                        </td>
                                                        <td>
                                                            <?php $__currentLoopData = $product->productCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$ctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                             <?php echo e($i==0?'':'-'); ?> <?php echo e($ctg->name); ?> 
                        
                                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo e($product->bar_code); ?><br>
                                                            <small><?php echo e(priceFullFormat($product->final_price)); ?></small>
                                                            <!--<a href="<?php echo e(route('admin.productsAction',['barcode',$product->id])); ?>" target="_blank" style="color: #ff864a;"><i class="fa fa-barcode"></i> </a>-->
                                                        </td>
                                                        <td>
                                                            <img src="<?php echo e(asset($product->image())); ?>" style="max-width: 70px; max-height: 50px;" />
                                                        </td>
                                                        <td>
                                                            <span class="btn btn-sm btn-danger printAdd" data-url="<?php echo e(route('admin.productsLabelPrint',['product_id'=>$product->id,'variant_id'=>null,'actiontype'=>1])); ?>">Add Print</span>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php echo e($products->links('pagination')); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



<?php $__env->stopSection(); ?> 
<?php $__env->startPush('js'); ?>
<script>

    $(document).ready(function() {
        $(document).on('click', '.printAdd', function() {
            var $btn = $(this); // store reference to the clicked button
            var url = $btn.data('url');
    
            // Add spinning icon
            $btn.html('<i class="fas fa-sync fa-spin"></i>');
    
            $.ajax({
                url: url,
                dataType: 'json',
                cache: false,
                success: function(data) {
                    $btn.html('Added');
                },
                error: function() {
                    $btn.html('Add Print');
                }
            });
        });
    });

    
    
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/products/productLavelList.blade.php ENDPATH**/ ?>