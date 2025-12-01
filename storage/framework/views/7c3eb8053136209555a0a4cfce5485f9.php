
<div class="newsLetter" style="background-position: center; background-size: cover; background-repeat: no-repeat;">
    <div class="newsLetOverlay">
        <div class="container-fluid">
            <div class="newLetBox">
                <div class="row">
                    <div class="col-md-5">
                        <h3>Sign Up For Newsletter<br>$ Get 20% Off</h3>
                    </div>
                    <div class="col-md-7">
                        <form id="subscirbeForm" data-url="<?php echo e(route('subscribe')); ?>">
                            <div class="input-group">
                                <input type="text" class="form-control" id="subscribeEmail" placeholder="Enter Email Address">
                                <span class="input-group-text subsriberbtm">Subscribe</span>
                            </div>
                        </form>
                         <div id="subscribeemailMsg"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- footer part start  -->
<footer>
    <div class="footPart">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-12">
                    <div class="aboutCompa">
                        <a href="<?php echo e(route('index')); ?>">
                            <img src="<?php echo e(asset(general()->logo())); ?>" alt="<?php echo e(general()->title); ?>">
                        </a>
                        <?php if(general()->copyright_text): ?>
                        <p>
                            <?php echo general()->copyright_text; ?>

                        </p>
                        <?php endif; ?>
                        <h4>Social Media Links</h4>
                        <ul class="socialLinks">
                            <?php if(general()->facebook_link): ?>
                            <li>
                                <a href="<?php echo e(general()->facebook_link); ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            </li>
                            <?php endif; ?>
                            <?php if(general()->linkedin_link): ?>
                            <li>
                                <a href="<?php echo e(general()->linkedin_link); ?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                            </li>
                            <?php endif; ?>
                            <?php if(general()->twitter_link): ?>
                            <li>
                                <a href="<?php echo e(general()->twitter_link); ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                            </li>
                            <?php endif; ?>
                            <?php if(general()->youtube_link): ?>
                            <li>
                                <a href="<?php echo e(general()->youtube_link); ?>" target="_blank"><i class="fa fa-instagram"></i></a>
                            </li>
                            <?php endif; ?>
                            <?php if(general()->youtube_link): ?>
                            <li>
                                <a href="<?php echo e(general()->youtube_link); ?>" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    
                    <div class="footListPart">
                        <?php if($menu = menu('Footer Two')): ?>
                        <h4><?php echo e($menu->name); ?></h4>
                        <ul class="footList">
                            <?php $__currentLoopData = $menu->subMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><a href="<?php echo e(asset($menu->menuLink())); ?>"><?php echo e($menu->menuName()); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="footListPart">
                        <?php if($menu = menu('Footer Three')): ?>
                        <h4><?php echo e($menu->name); ?></h4>
                        <ul class="footList">
                            <?php $__currentLoopData = $menu->subMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><a href="<?php echo e(asset($menu->menuLink())); ?>"><?php echo e($menu->menuName()); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="footListPart">
                        <?php if($menu = menu('Footer Four')): ?>
                        <h4><?php echo e($menu->name); ?></h4>
                        <ul class="footList">
                            <?php $__currentLoopData = $menu->subMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><a href="<?php echo e(asset($menu->menuLink())); ?>"><?php echo e($menu->menuName()); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bootmFot">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <p>2024 Copyright <a href="<?php echo e(route('index')); ?>">©<?php echo e(general()->title); ?>. </a>All Rights Reserved.</p>
                </div>
                <div class="col-md-6">
                    <a href="#" class="paymentImg"><img src="<?php echo e(asset('public/welcome/images/image 37.png')); ?>" alt="<?php echo e(general()->title); ?>"></a>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer part end  --><?php /**PATH /home/posherbd/public_html/resources/views/welcome/layouts/footer.blade.php ENDPATH**/ ?>