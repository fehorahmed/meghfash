 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Coupon Edit')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css">
    
    .searchResult {
        position: absolute;
        width: 100%;
        background: #f3f3f3;
        display:none;
        z-index: 99;
        max-height: 200px;
        overflow: auto;
    }
    
    .searchSection {
        position: relative;
    }
    
    .searchResult ul {
        margin: 0;
        padding: 0;
    }
    
    .searchResult ul li {
        list-style: none;
        padding: 5px 15px;
        border-bottom: 1px solid #e1e1e1;
        cursor: pointer;
    }
    .productGrid {
        border: 1px solid #e3e3e3;
        padding: 5px;
        text-align: center;
    }
    
    .productGrid img {
        max-width: 100%;
        max-height: 100px;
        margin: auto;
    }
</style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Coupon Edit</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Coupon Edit</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
        	<a class="btn btn-outline-primary" href="<?php echo e(route('admin.ecommerceCouponsAction','create')); ?>">
                <i class="fa-solid fa-plus"></i> Add Coupon
            </a>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.ecommerceCoupons')); ?>">
                Back
            </a>
        </div>
    </div>
</div>

<div class="content-body">
    <!-- Basic Elements start -->
    <section class="basic-elements">
        <?php echo $__env->make('admin.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Coupon Edit</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form action="<?php echo e(route('admin.ecommerceCouponsAction',['update',$coupon->id])); ?>" method="post">
                           		        <?php echo csrf_field(); ?>
                          			<div class="table-responsive">
                           				<table class="table table-borderless">
                           					<tr>
                           						<td style="width: 150px;">Coupon Code </td>
                           						<td style="width: 300px;min-width: 300px;">
                           							<input type="text" name="name" value="<?php echo e($coupon->name); ?>" class="form-control form-control-sm" placeholder="Enter Coupon Code" required="">
                           							<?php if($errors->has('name')): ?>
                                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('name')); ?></p>
                                                    <?php endif; ?>
                           						</td>
                           					</tr>
                                            <tr>
                                                <td>Discount</td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="number" name="discount" value="<?php echo e($coupon->amounts>0?$coupon->amounts:''); ?>" class="form-control form-control-sm" placeholder="Discount" required="">
                                                        <select class="form-control form-control-sm" name="discount_type">
                                                            <option value="0" <?php echo e($coupon->menu_type==0?'selected':''); ?> >Percentage(%)</option>
                                                            <option value="1" <?php echo e($coupon->menu_type==1?'selected':''); ?> >Flat(<?php echo e(general()->currency); ?>)</option>
                                                        </select>
                                                    </div>
                                                    <?php if($errors->has('discount')): ?>
                                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('discount')); ?></p>
                                                    <?php endif; ?>
                                                    <?php if($errors->has('discount_type')): ?>
                                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('discount_type')); ?></p>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Shopping</td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="number" name="min_shopping" value="<?php echo e($coupon->min_shopping>0?$coupon->min_shopping:''); ?>" class="form-control form-control-sm" placeholder="Min Shopping" >
                                                        <input type="number" name="max_shopping" value="<?php echo e($coupon->max_shopping>0?$coupon->max_shopping:''); ?>" class="form-control form-control-sm" placeholder="Max Shopping" >
                                                    </div>
                                                    <?php if($errors->has('min_shopping')): ?>
                                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('min_shopping')); ?></p>
                                                    <?php endif; ?>
                                                    <?php if($errors->has('max_shopping')): ?>
                                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('max_shopping')); ?></p>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Validity Date</td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="date" name="start_date" value="<?php echo e($coupon->start_date?carbon\carbon::parse($coupon->start_date)->format('Y-m-d'):''); ?>" class="form-control form-control-sm" >
                                                        <input type="date" name="end_date" value="<?php echo e($coupon->end_date?carbon\carbon::parse($coupon->end_date)->format('Y-m-d'):''); ?>" class="form-control form-control-sm" >
                                                    </div>
                                                    <?php if($errors->has('start_date')): ?>
                                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('start_date')); ?></p>
                                                    <?php endif; ?>
                                                    <?php if($errors->has('end_date')): ?>
                                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('end_date')); ?></p>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                           					<tr>
                           						<td>Coupon Descriptioin</td>
                           						<td>
                           							<textarea type="text" name="description" rows="5"  class="form-control form-control-sm" placeholder="Enter Coupon Description"><?php echo $coupon->description; ?></textarea>
                           						</td>
                           					</tr>
                           					<tr>
                           						<td>Coupon Type</td>
                           						<td>
                           							<select class="form-control form-control-sm" name="coupon_type" required="">
                           								<option value="order" <?php echo e($coupon->location=='product'?'selected':''); ?>>Order Coupon</option>
                           								<option value="product" <?php echo e($coupon->location=='product'?'selected':''); ?>>Product</option>
                           								<option value="category" <?php echo e($coupon->location=='category'?'selected':''); ?>>Category</option>
                           							</select>
                           						</td>
                           					</tr>
                           					<tr>
                           					    <td>Categories</td>
                           					    <td>
                           					        <select data-placeholder="Search Category..." name="categories[]" class="select2 form-control" multiple="multiple">
                                                        <option vaue="">Select Categories</option>
                                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($ctg->id); ?>"
                                                        <?php $__currentLoopData = $coupon->couponCtgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $postctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php echo e($postctg->reff_id==$ctg->id?'selected':''); ?> 
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        ><?php echo e($ctg->name); ?></option>
                                                        <?php if($ctg->subCtgs()->where('status','active')->count() > 0): ?>
                                                        <?php $__currentLoopData = $ctg->subCtgs()->where('status','active')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCtg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($subCtg->id); ?>" 
                                                        <?php $__currentLoopData = $coupon->couponCtgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $postctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php echo e($postctg->reff_id==$subCtg->id?'selected':''); ?> 
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        > - <?php echo e($subCtg->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                           					    </td>
                           					</tr>
                           					<tr>
                           						<td>Status</td>
                           						<td>
                           							<select class="form-control form-control-sm" name="status" required="">
                           								<option value="">Select Status</option>
                           								<option value="active" <?php echo e($coupon->status=='active'?'selected':''); ?>>Active</option>
                           								<option value="inactive" <?php echo e($coupon->status=='inactive'?'selected':''); ?>>Inactive</option>
                           							</select>
                           						</td>
                           					</tr>
                           					<tr>
                           						<td>Action</td>
                           						<td>
                           							<button type="submit" class="btn btn-primary">Submit</button>
                           						</td>
                           					</tr>
                           				</table>
                           			</div>
                               	</form>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Coupon Products</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body" style="min-height: 400px;">
                            <div class="row m-0">
                                <div class="col-md-6" style="padding:5px;">
                                    <div class="form-group searchSection">
                                        <input type="text" class="form-control searchProduct" data-url="<?php echo e(route('admin.ecommerceCouponsAction',['search-product',$coupon->id])); ?>" placeholder="Enter Search Product">
                                        <div class="searchResult"></div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="couponProduucts">
                                <?php echo $__env->make(adminTheme().'ecommerce-setting.includes.couponProductsList', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

            </div>


    </section>
    <!-- Basic Inputs end -->
</div>

<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?>

<script>

$(document).ready(function(){
    $('.searchProduct').click(function(){
        $(".searchResult").show();
    });
    
    $(document).click(function(event){
        if (!$(event.target).closest('.searchSection').length) {
            $(".searchResult").hide();
        }
    });
    
    
    $('.searchProduct').keyup(function(){
        var search =$(this).val();
        var url =$(this).data('url');
        
        if(url){
            $.ajax({
              url: url,
              type: 'GET',
              dataType: 'json',
              cache: false,
              data:{'search':search}
            })
            .done(function(data) {
                $(".searchResult").empty().append(data.view);
            })
            .fail(function() {
              // alert("error");
            });
        }
        
    });

    $(document).on("click", ".searchResult ul li", function(){
        $(this).remove();
        var url =$(this).data('url');
        if(url){
            $.ajax({
              url: url,
              type: 'GET',
              dataType: 'json',
              cache: false,
            })
            .done(function(data) {
                $(".couponProduucts").empty().append(data.view);
            })
            .fail(function() {
              // alert("error");
            });
        }
        
    });
    
    $(document).on('click','.checkAll',function(){
        var checked = $(this).prop('checked');
        $('input.counponCheck:checkbox').prop('checked', checked);
    });
    
    $(document).on('click','.counponProductDelete',function(){
        var checkedId = [];
        $('.counponCheck').each(function(){
            if($(this).prop('checked')) {
                checkedId.push($(this).val());
            }
        });
        var url =$(this).data('url');
        if(confirm('Are You Want To Delete?')){
            $.ajax({
              url: url,
              type: 'GET',
              dataType: 'json',
              cache: false,
              data:{'checkedId':checkedId}
            })
            .done(function(data) {
                $(".couponProduucts").empty().append(data.view);
            })
            .fail(function() {
              // alert("error");
            });
        }
        
    });
    
    
    
    
    
});
</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\poshak\resources\views/admin/ecommerce-setting/coupons/couponsEdit.blade.php ENDPATH**/ ?>