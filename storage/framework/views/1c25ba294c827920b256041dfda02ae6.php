 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('General Setting')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css"></style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">General Setting</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">General Setting</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary reloadPage" href="javascript:void(0)">
                <i class="fa-solid fa-rotate"></i>
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
                            <h4 class="card-title">General Setting</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="table-responsive">
                                            <form action="<?php echo e(route('admin.ecommerceSetting','general')); ?>" method="post">
                               				        <?php echo csrf_field(); ?>
                                                    <table class="table table-borderless">
                                                    <tr>
                                                        <td style="min-width:150px;"></td>
                                                        <td style="min-width:350px;"></td>
                                                    </tr>
                                                     <tr>
                                                         <td>Finance Currency</td>
                                                         <td style="padding: 3px;">
                                                             <div class="form-group">
                        	                                     <div class="input-group">
                        	                                     <input type="text" name="currency" value="<?php echo e(general()->currency); ?>" placeholder="Finanmce Currency" class="form-control-sm form-control <?php echo e($errors->has('currency')?'error':''); ?>" />
                        	                                     <select class="form-control form-control-sm" name="currency_decimal">
                        	                                     		<option value="0" <?php echo e(general()->currency_decimal==0?'selected':''); ?> >0 Decimal</option>
                        	                                     		<option value="1" <?php echo e(general()->currency_decimal==1?'selected':''); ?> >0.0 Decimal</option>
                        	                                     		<option value="2" <?php echo e(general()->currency_decimal==2?'selected':''); ?> >0.00 Decimal</option>
                        	                                     </select>
                        	                                     <select class="form-control form-control-sm" name="currency_position">
                        	                                     		<option value="0" <?php echo e(general()->currency_position==0?'selected':''); ?> >Left Position</option>
                        	                                     		<option value="1" <?php echo e(general()->currency_position==1?'selected':''); ?> >Right Position</option>
                        	                                     </select>
                        	                                     </div>
                        	                                     <?php if($errors->has('currency')): ?>
            												    	<p style="color: red;margin: 0;font-size: 10px;"><?php echo e($errors->first('currency')); ?></p>
            												     <?php endif; ?>
                        	                                 </div>
                                                         </td>
                                                     </tr>
                                                      <tr>
                                                         <th>VAT (%)</th>
                                                         <td style="padding:3px;">
                                                                <div class="row m-0">
                                                                     <div class="col-6 p-0">
                                                                        <label>General Vat (%)</label>
                                                                        <input type="number" class="form-control form-control-sm" name="tax" value="<?php echo e((float)general()->tax); ?>" step="any" placeholder="Enter Vat">
                                                                     </div>
                                                                     <div class="col-6 p-0">
                                                                        <label>Import Vat (%)</label>
                                                                        <input type="number" class="form-control form-control-sm" name="import_tax" value="<?php echo e((float)general()->import_tax); ?>" step="any" placeholder="Enter Import Vat">
                                                                     </div>
                                                                </div>
                                                             <!--<div class="input-group">-->
                                                             <!--  <input type="number" class="form-control form-control-sm" name="tax" value="<?php echo e(general()->tax); ?>" placeholder="Enter Tax">-->
                                                               <!--<select class="form-control form-control-sm" name="tax_status">-->
                                                               <!--    <option value="1" <?php echo e(general()->tax_status==1?'selected':''); ?>>Tax applicable</option>-->
                                                               <!--    <option value="0" <?php echo e(general()->tax_status==0?'selected':''); ?>>No Tax</option>-->
                                                               <!--</select>-->
                                                             <!--</div>-->
                                                         </td>
                                                     </tr>
                                                     <tr>
                                                         <th>Shipping Charge</th>
                                                         <td style="padding:3px;">
                                                            <div class="input-group">
                                                                <div style="width: 50%">
                                                                    <label>In Dhaka</label>
                                                                    <input type="number" class="form-control form-control-sm" name="inside_dhaka_shipping_charge" value="<?php echo e(general()->inside_dhaka_shipping_charge); ?>" placeholder="Inside Dhaka Shipping Charge">
                                                                </div>
                                                                <div style="width: 50%">
                                                                    <label>Out of Dhaka</label>
                                                                    <input type="number" class="form-control form-control-sm" name="outside_dhaka_shipping_charge" value="<?php echo e(general()->outside_dhaka_shipping_charge); ?>" placeholder="OUtside Dhaka Shipping Charge">
                                                                </div>
                                                            </div>
                                                         </td>
                                                     </tr>
                                                     <tr>
                                                         <th>Order Store</th>
                                                         <td style="padding:3px;">
                                                             <select class="form-control form-control-sm" name="online_store_id" required="">
                                                                 <option value="">Select Store</option>
                                                                 <?php $__currentLoopData = App\Models\Attribute::latest()->where('type',5)->where('status','active')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                 <option value="<?php echo e($store->id); ?>" <?php echo e(general()->online_store_id==$store->id?'selected':''); ?> ><?php echo e($store->name); ?></option>
                                                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                             </select>
                                                         </td>
                                                     </tr>
                                                     
                                                    
                                                     
                                                     <tr>
                                                         <th>Action</th>
                                                         <td style="padding:3px;">
                                                            <button type="submit" class="btn btn-info" style="padding:5px 10px;">Update</button>
                                                         </td>
                                                     </tr>
                                                 </table>
                                            </form>
                                        </div>
                                    </div>
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

          

</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/admin/ecommerce-setting/settings.blade.php ENDPATH**/ ?>