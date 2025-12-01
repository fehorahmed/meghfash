<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="<?php echo e(asset(general()->favicon())); ?>">
<title>Welcome to <?php echo e(general()->title); ?>! Confirm Your Registration.</title>
<!-- Google Font CDN-->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
<style>

    body{
        margin:0;
        background:#f1f1f1;
        font-family: sans-serif;
    }
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }
    
    td, th {
      border: 1px solid #dddddd;
      text-align: left;
      font-size:14px;
      padding: 8px;
    }
    ul.pageLink {
        margin: 0;
        padding: 0;
        list-style: none;
        text-align: center;
    }
    
    ul.pageLink li {
        display: inline-block;
        border-right: 1px solid #dbdada;
        line-height: 14px;
    }
    
    ul.pageLink li a {
        padding: 0 15px;
        color: gray;
        text-decoration: none;
    }
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        font-size: 14px;
        padding: 8px;
    }
	@media only screen and (max-width: 600px){
        
        

	}

</style>

</head>
<body style="background:#f1f1f1;padding: 15px;">
<div style="margin:25px auto;max-width:600px;width:600px;overflow:auto;padding:15px;background:#fff;">

<p style="text-align:center;">
<a href="<?php echo e(route('index')); ?>" target="_blank"><img src="<?php echo e(URL::asset(general()->logo())); ?>" style="max-width:200px;"></a>
</p>

<div style="padding:10px;margin: 10px 0;">
    <h2 style="margin: 0;padding: 5px 0;text-align:center;">Welcome to <?php echo e(general()->title); ?>!</h2>
    
    <p>
        Hi <?php echo e($datas['order']->name); ?>,
    </p>
    <p>
        Thank you for choosing <?php echo e(general()->title); ?>! Item(s) from your order <b>#<?php echo e($datas['order']->invoice); ?></b> has been <?php echo e(ucfirst($datas['order']->order_status)); ?>.
    </p>
    <div>
    <h3>Order Details</h3>
    <p style="margin: 0;"><span style="min-width: 70px;display: inline-block;">Name:</span> <?php echo e($datas['order']->name); ?></p>
    <?php if($datas['order']->mobile): ?>
    <p style="margin: 0;"><span style="min-width: 70px;display: inline-block;">Mobile:</span> <?php echo e($datas['order']->mobile); ?></p>
    <?php endif; ?>
    <?php if($datas['order']->email): ?>
    <p style="margin: 0;"><span style="min-width: 70px;display: inline-block;">Email:</span> <?php echo e($datas['order']->email); ?></p>
    <?php endif; ?>
    <p style="margin: 0;"><span style="min-width: 70px;display: inline-block;">Address:</span> <?php echo e($datas['order']->fullAddress()); ?></p>
    <br />
    <table class="table" style="background: white;">
        <thead>
            <tr>
                <th style="min-width: 200px">Product Description</th>
                <th style="text-align: center;width: 130px;min-width: 130px;">Price/Qty</th>
                <th style="text-align: center;width: 130px;min-width: 130px;">Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $datas['order']->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td>
                    <div style="display: flex">
                        <div>
                            <img src="<?php echo e(asset($item->image())); ?>" style="max-width: 100px;max-height: 80px;margin-right:5px;">
                        </div>
                        <div>
                            <?php echo e($item->product_name); ?>

                            <?php if(count($item->itemAttributes()) > 0): ?>
                            <br>
                            <span style="font-size: 14px;display:inline-block;">
                                <?php $__currentLoopData = $item->itemAttributes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$attri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(isset($attri['title']) && isset($attri['value'])): ?>
                                    <?php echo e($i==0?'':','); ?> <span><?php echo e($attri['title']); ?> : <?php echo e($attri['value']); ?></span>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </span>
                            <?php endif; ?>
                            
                            <?php if($item->warranty_note): ?>
                            <br>
                            <small style="font-size: 12px;"><?php echo e($item->warranty_note); ?> -  <b><?php echo e($item->warranty_charge > 0?priceFullFormat($item->warranty_charge):'Free'); ?></b></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
                <td style="text-align: center;"><?php echo e(priceFullFormat($item->price)); ?> X <?php echo e($item->quantity); ?></td>
                <td style="text-align: center;"><?php echo e(priceFullFormat($item->final_price)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td colspan="2" style="text-align: end;">Subtotal</td>
                <td style="text-align: center;"><?php echo e(priceFullFormat($datas['order']->total_price)); ?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: end;">Discount</td>
                <td style="text-align: center;"><?php echo e(priceFullFormat($datas['order']->coupon_discount)); ?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: end;">Delivery Charge</td>
                <td style="text-align: center;"><?php echo e(priceFullFormat($datas['order']->shipping_charge)); ?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: end;">Grand Total</td>
                <td style="text-align: center;"><?php echo e(priceFullFormat($datas['order']->grand_total)); ?></td>
            </tr>
            
        </tbody>
    </table>
    <br />
</div>
    
  <br>
  <p style="margin:0;">If You Have any questions, please email us at <a href="mailto:<?php echo e(general()->email); ?>" ><?php echo e(general()->email); ?></a> or visit our 
  <?php if($pg =pageTemplate('Contact Us')): ?>
  <a href="<?php echo e(route('pageView',$pg->slug?:'no-title')); ?>" target="_blank"><?php echo e($pg->name); ?></a>
  <?php endif; ?>
  .</p>
  <br>
</div>

<div style="padding:10px;margin: 10px 0;border-top: 1px solid #ededed;">
   <p style="text-align: center;">
       
       <?php if(general()->facebook_link): ?>
       <a href="<?php echo e(general()->facebook_link); ?>" target="_blank" style="display: inline-block;padding: 0 10px;"><img style="width:25px;" src="<?php echo e(URL::asset('welcome/social/facebook.png')); ?>"></a>
       <?php endif; ?>
       
       <?php if(general()->instagram_link): ?>
       <a href="<?php echo e(general()->instagram_link); ?>" target="_blank" style="display: inline-block;padding: 0 10px;"><img style="width:25px;" src="<?php echo e(URL::asset('welcome/social/instagram.png')); ?>"></a>
       <?php endif; ?>
        
       <?php if(general()->pinterest_link): ?>
       <a href="<?php echo e(general()->pinterest_link); ?>" target="_blank" style="display: inline-block;padding: 0 10px;"><img style="width:25px;" src="<?php echo e(URL::asset('welcome/social/pinterest.png')); ?>"></a>
       <?php endif; ?>
       
       <?php if(general()->twitter_link): ?>
       <a href="<?php echo e(general()->twitter_link); ?>" target="_blank" style="display: inline-block;padding: 0 10px;"><img style="width:25px;" src="<?php echo e(URL::asset('welcome/social/twitter-alt.png')); ?>"></a>
       <?php endif; ?>
        
       <?php if(general()->youtube_link): ?>
       <a href="<?php echo e(general()->youtube_link); ?>" target="_blank" style="display: inline-block;padding: 0 10px;"><img style="width:25px;" src="<?php echo e(URL::asset('welcome/social/youtube.png')); ?>"></a>
       <?php endif; ?>
   </p>
   <p>
       <ul class="pageLink">
           
           <li><a href="<?php echo e(route('index')); ?>">Home</a></li>
           
           <li>
              <?php if($pg =pageTemplate('About Us')): ?>
              <a href="<?php echo e(route('pageView',$pg->slug?:'no-title')); ?>" target="_blank"><?php echo e($pg->name); ?></a>
              <?php endif; ?>
           </li>
           
           <li style="border-right: 1px solid #fff;">
              <?php if($pg =pageTemplate('Contact Us')): ?>
              <a href="<?php echo e(route('pageView',$pg->slug?:'no-title')); ?>" target="_blank"><?php echo e($pg->name); ?></a>
              <?php endif; ?>
           </li>
       </ul>
   </p>
  <p style="text-align: center;">you have received this email as a registered user of <a href="<?php echo e(route('index')); ?>"><?php echo e(general()->website); ?></a> can <a href="<?php echo e(route('index')); ?>">unsubscribe</a> from these emails here.</p>
</div>

</div>
</body>
</html><?php /**PATH /home/posherbd/public_html/resources/views/mails/InvoiceMail.blade.php ENDPATH**/ ?>