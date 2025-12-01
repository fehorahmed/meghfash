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
    <h2 style="margin: 0;padding: 5px 0;">Welcome to <?php echo e(general()->title); ?>,</h2>
    <div>
    <p>
    New customer inquiry received! Please review and respond to the message at your earliest convenience.
    </p>
    </div>
    <h4 style="text-align:center;">
        <span style="font-size: 24px;">Contact Information</span>
    </h4>
    <div class="buttonClick">
            <p>
               <b>Name: </b><?php echo e($datas['r']->name); ?><br>
               <b>Email: </b><?php echo e($datas['r']->email); ?><br>
               <b>Mobile: </b><?php echo e($datas['r']->mobile); ?><br>
            </p>
            <p>
                <?php echo e($datas['r']->message); ?>

            </p>
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
</html>
<?php /**PATH /home/meghfash/public_html/resources/views/mails/ContactMail.blade.php ENDPATH**/ ?>