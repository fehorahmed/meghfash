 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Promotions List')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css"></style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Ecommerce Promotions</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Ecommerce Promotions</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
        	<a class="btn btn-outline-primary" href="<?php echo e(route('admin.ecommercePromotionsAction','create')); ?>">
                <i class="fa-solid fa-plus"></i> Add Promotion
            </a>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.ecommercePromotions')); ?>">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>


<?php echo $__env->make('admin.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                    <form action="<?php echo e(route('admin.ecommercePromotions')); ?>">
                        <div class="row">
                            <div class="col-md-12 mb-0">
                                <div class="input-group">
                                    <input type="text" name="search" value="<?php echo e(request()->search?request()->search:''); ?>" placeholder="Search promotion name" class="form-control <?php echo e($errors->has('search')?'error':''); ?>" />
                                    <button type="submit" class="btn btn-success btn-sm rounded-0"><i class="fa fa-search"></i> Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
</div>

<div class="card">
    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
        <h4 class="card-title">Promotions List</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
             <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Validity</th>
                        <th>Discount</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($i+1); ?></td>
                        <td>
                            
                        <a href="<?php echo e(route('promotion',$coupon->slug?:'no-title')); ?>"><?php echo e($coupon->name); ?></a>
                        
                        <?php if($coupon->shipping_free || $coupon->fetured): ?>
                        <br>
                            <?php if($coupon->shipping_free): ?>
                            <small style="background: #f44336;color: white;padding: 2px 10px;border-radius: 5px;">Free Shipping</small>
                            <?php endif; ?>
                            <?php if($coupon->fetured): ?>
                            <small style="background: #FF9800;color: white;padding: 2px 10px;border-radius: 5px;">Show Home</small>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        </td>
                        <td>
                            
                            <?php if($coupon->start_date && $coupon->end_date): ?>
                                <?php echo e(carbon\carbon::parse($coupon->start_date)->format('d-m-Y')); ?> - 
                                <?php echo e(carbon\carbon::parse($coupon->end_date)->format('d-m-Y')); ?> 
                                
                                <?php if(Carbon\Carbon::now()->startOfDay() <= Carbon\Carbon::parse($coupon->end_date)->startOfDay()): ?>
                                    (<?php echo e(Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($coupon->end_date)) + 1); ?> Days)
                                <?php else: ?>
                                    <span class="text-danger">(Expired)</span>
                                <?php endif; ?>
                            <?php elseif($coupon->start_date && $coupon->end_date==null): ?>
                                <span><?php echo e(carbon\carbon::parse($coupon->start_date)->format('d-m-Y')); ?> - Unlimited</span>
                            <?php elseif($coupon->start_date==null && $coupon->end_date): ?>
                                <span><?php echo e(carbon\carbon::parse($coupon->end_date)->format('d-m-Y')); ?>

                                <?php if(Carbon\Carbon::now()->startOfDay() <= Carbon\Carbon::parse($coupon->end_date)->startOfDay()): ?>
                                    (<?php echo e(Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($coupon->end_date)) + 1); ?> Days)
                                <?php else: ?>
                                    <span class="text-danger">(Expired)</span>
                                <?php endif; ?>
                                </span>
                            <?php else: ?>
                                <span>Unlimited</span>
                            <?php endif; ?>
                            
                        </td>
                        <td>
                            
                            <?php if($coupon->menu_type==1): ?>
                            <span><?php echo e(priceFullFormat($coupon->amounts)); ?></span>
                            <?php else: ?>
                            <span><?php echo e($coupon->amounts>0?$coupon->amounts:0); ?>%</span>
                            <?php endif; ?>
                            
                            <?php if($coupon->min_shopping>0 && $coupon->max_shopping>0): ?>
                            (Min:<?php echo e(priceFullFormat($coupon->min_shopping)); ?> -  Max:<?php echo e(priceFullFormat($coupon->max_shopping)); ?>)
                            <?php elseif($coupon->min_shopping>0): ?>
                            (Min:<?php echo e(priceFullFormat($coupon->min_shopping)); ?>)
                            <?php elseif($coupon->max_shopping>0): ?>
                            (Max:<?php echo e(priceFullFormat($coupon->max_shopping)); ?>)
                            <?php endif; ?>
                            
                        </td>
                        <td>
                            <?php if($coupon->location=='category'): ?>
                            <span>Category Products</span>
                            <?php elseif($coupon->location=='product'): ?>
                            <span>Indivisual Products</span>
                            <?php else: ?>
                            <span>
                            All Products
                            </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($coupon->status=='active'): ?>
                            <span class="badge badge-success"><?php echo e(ucfirst($coupon->status)); ?></span>
                            <?php else: ?>
                            <span class="badge badge-danger"><?php echo e(ucfirst($coupon->status)); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo e(route('admin.ecommercePromotionsAction',['edit',$coupon->id])); ?>" class="badge badge-success" ><i class="fa fa-edit"></i></a>
                            <a href="<?php echo e(route('admin.ecommercePromotionsAction',['delete',$coupon->id])); ?>" class="badge badge-danger" onclick="return confirm('Are You Want To Delete?')"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </table>
             </div>
            <?php echo e($coupons->links('pagination')); ?>

        </div>
    </div>
</div>


<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?>

<script>

          

</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/posherbd/public_html/resources/views/admin/ecommerce-setting/promotions/promotions.blade.php ENDPATH**/ ?>