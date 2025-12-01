
<?php $__env->startSection('title'); ?>
<title>My Review | <?php echo e(App\Models\General::first()->title); ?> | <?php echo e(App\Models\General::first()->subtitle); ?></title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('SEO'); ?>
<meta name="description" content="<?php echo App\Models\General::latest()->first()->meta_dsc; ?>">
<meta name="keywords" content="<?php echo e(App\Models\General::latest()->first()->meta_key); ?>">
<meta property="og:title" content="<?php echo e(App\Models\General::latest()->first()->name); ?>">
<meta property="og:description" content="<?php echo App\Models\General::latest()->first()->meta_dsc; ?>">
<meta property="og:image" content="<?php echo App\Models\General::latest()->first()->meta_dsc; ?>">
<meta property="og:url" content="<?php echo e(route('index')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>

<style type="text/css">
    .myrecentorder tr td,th{
        padding:5px !important;
    }
</style>

<?php $__env->stopPush(); ?>
<?php $__env->startSection('contents'); ?>

<div class="userdashboard">
    <div class="container">
    <div class="row" style="margin:0;">
        <div class="col-lg-3 usersidebardiv">
            <?php echo $__env->make(App\Models\General::first()->theme.'.customer.includes.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
        </div>
        <div class="col-lg-9 usermainbody">
            <div class="usercontent">
                <div class="myrecentorder" style="min-height: 300px;">
                    <p style="font-weight: bold;border-bottom: 1px solid #eaeded;padding: 5px 0;">My Reviews</p>
                    <div  class="table-responsive">
                    <table class="table table-bordered">

                    <tr style="background: #f3f3f3;">
                        <th style="width: 50px;min-width: 50px;">SL</th>
                        <th colspan="2" style="min-width: 300px;">Product</th>
                        <th style="width: 170px;min-width: 170px;">date</th>
                    </tr>

                    <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                     <tr>
                        <td rowspan="2" style="text-align: center;"><?php echo e($reviews->currentpage()==1?$i+1:$i+($reviews->perpage()*($reviews->currentpage() - 1))+1); ?></td>
                        <td>
                            <img width="30" class="rounded p-0 m-0" src="<?php echo e(asset($review->post->image())); ?>" alt="<?php echo e($review->post->name); ?>">
                          </td>
                          <td><a href="<?php echo e(route('productView',$review->post->slug)); ?>"><?php echo e(Str::limit($review->post->name,35,'..')); ?></a></td>
                          <td>
                              <?php echo e($review->created_at->format('d-m-Y h:i A')); ?>

                          </td>
                    </tr>
                    <tr style="background: #f3f3f3;">
                        <td colspan="3"><?php echo $review->content; ?></td>
                    </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                    </div>
                    <?php echo e($reviews->links('pagination')); ?>

                </div>
                
            </div>
        </div>
    </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make(App\Models\General::first()->theme.'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\poshak\resources\views/welcome/customer/myReviews.blade.php ENDPATH**/ ?>