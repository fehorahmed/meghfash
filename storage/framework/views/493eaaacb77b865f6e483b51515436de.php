 
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
                        <input type="hidden" name="filter"  value="stock">
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
                                <div class="table-responive">
                                    <table class="table table-striped table-bordered table-hover dataex-html5-export">
                                        <thead>
                                            <tr>
                                                <th style="min-width: 130px;">Product</th>
                                                <th style="min-width: 120px;">Category</th>
                                                <th style="min-width: 120px;">Barcode</th>
                                                <th style="min-width: 120px;">Price</th>
                                                <th style="min-width: 100px;">Stock</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($product->variation_status): ?>
                                                    <?php $__currentLoopData = $product->productVariationActiveAttributeItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo $item->variationItemValues(); ?> - <?php echo e($product->name); ?>

                                                        <a href="<?php echo e(route('admin.productsAction',['edit',$product->id])); ?>" target="_blank"><i class="fa fa-edit"></i></a>
                                                        </td>
                                                        <td>
                                                            <?php if($ctg =$product->productCategories()->first()): ?>
        
                                                             <?php echo e($ctg->name); ?> 
                        
                                                             <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo e($product->import_status?'IM':'PO'); ?><?php echo e($item->barcode); ?>

                                                            <a href="<?php echo e(route('admin.productsAction',['barcode',$product->id,'variation_id'=>$item->id])); ?>" target="_blank" style="color: #ff864a;"><i class="fa fa-barcode" ></i> </a>
                                                        </td>
                                                        <td><?php echo e(priceFormat($item->final_price)); ?></td>
                                                        <td><?php echo e($item->quantity); ?></td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td><?php echo e($product->name); ?>

                                                        <a href="<?php echo e(route('admin.productsAction',['edit',$product->id])); ?>" target="_blank"><i class="fa fa-edit"></i></a>
                                                        </td>
                                                        <td>
                                                            <?php if($ctg =$product->productCategories()->first()): ?>
        
                                                             <?php echo e($ctg->name); ?> 
                        
                                                             <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo e($product->import_status?'IM':'PO'); ?><?php echo e($product->bar_code); ?>

                                                            <a href="<?php echo e(route('admin.productsAction',['barcode',$product->id])); ?>" target="_blank" style="color: #ff864a;"><i class="fa fa-barcode"></i> </a>
                                                        </td>
                                                        <td><?php echo e(priceFormat($product->final_price)); ?></td>
                                                        <td><?php echo e($product->quantity); ?></td>
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

<?php $__env->stopPush(); ?>
<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/posherbd/public_html/resources/views/admin/products/productLavelList.blade.php ENDPATH**/ ?>