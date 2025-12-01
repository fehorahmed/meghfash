
<!-- header part start -->
<header>
    <div class="topHeader">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <p class="welcomeText">Welcome To <b></b> Online Shopping Store.</p>
                </div>
                <div class="col-md-4">
                    <?php if(offerNotes()->count() > 0): ?>
                    <div class="headerTopPart">
                        <?php $__currentLoopData = offerNotes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a class="slick-box selectedItem" href="javascript:void(0)"><?php echo $note->content; ?></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <ul class="accountList">
                        <?php if(Auth::check()): ?>
                        <li>
                            <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form-head').submit();" ><i class="fa fa-user-plus"></i> Log-out</a>
                            <form id="logout-form-head" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                <?php echo csrf_field(); ?>
                            </form>
                        </li>
                        <?php else: ?>
                        <li>
                            <a href="<?php echo e(route('login')); ?>"><i class="fa fa-user-o"></i> Login</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('register')); ?>"><i class="fa fa-user-plus"></i> Register</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="middleHeader">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-2">
                    <div class="logoHeader">
                        <a href="<?php echo e(route('index')); ?>" class="mainLogo">
                            <img src="<?php echo e(asset(general()->logo())); ?>" alt="<?php echo e(general()->title); ?>" />
                        </a>
                    </div>
                </div>
                <div class="col-xl-7 col-12">
                    <div class="searchBox">
                        <form action="<?php echo e(route('search')); ?>" class="searchHeaderArea" style="position:relative;" >
                            <div class="input-group" id="searchHeaderInput">
                                <input type="text" class="form-control" name="search" value="<?php echo e(request()->search); ?>" placeholder="Search For Products..." />
                                <button type="submit" class="input-group-text" style="background-color: unset;"><i class="fa fa-search"></i></button>
                            </div>
                            <div class="searchResultAjax"></div>
                        </form>
                    </div>
                </div>
                <div class="col-xl-3 col-12 p-0">
                    <ul class="cartWish">
                        <li>
                            <?php if(Auth::check()): ?>
                            <a href="<?php echo e(route('customer.dashboard')); ?>">
                            <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>">
                            <?php endif; ?>
                                <div class="countPosi">
                                    <img src="<?php echo e(asset('public/welcome/images/User.png')); ?>" alt="Bytebliss" />    
                                </div>
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo e(route('myWishlist')); ?>">
                                <div class="countPosi">
                                    <img src="<?php echo e(asset('public/welcome/images/icon.png')); ?>" alt="Bytebliss" />
                                    <span class="wlcounter"><?php if(isset($wlCount)): ?><?php echo e($wlCount); ?><?php endif; ?></span>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('carts')); ?>">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="countPosi">
                                            <img src="<?php echo e(asset('public/welcome/images/Shopping_Cart.png')); ?>" alt="Bytebliss" />   
                                            <span class="cartCounter"><?php if(isset($cartsCount)): ?><?php echo e($cartsCount); ?><?php endif; ?></span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <p>Total</p>
                                        <h5 class="cartTotal"><?php if(isset($cartTotalPrice)): ?><?php echo e(priceFullFormat($cartTotalPrice)); ?><?php endif; ?></h5>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="bottomHeader">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="toglerCtg">
                        <h3>Browse All Category <i class="fa fa-angle-down"></i></h3>
                        <div class="ctgScrolBar">
                            <?php if($menu = menu('Category Menus')): ?>
                            <ul class="allctgList">
                                
                                <?php $__currentLoopData = $menu->subMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <a href="<?php echo e(asset($menu->menuLink())); ?>">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <!--<i class="fa fa-mobile"></i>-->
                                                <img src="<?php echo e(asset($menu->image())); ?>" class="" alt="Bytebliss"/>
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <span><?php echo e($menu->menuName()); ?></span>
                                            </div>
                                        </div>
                                    </a>
                                    <?php if($menu->subMenus()->count() > 0): ?>
                                    <i class="fa fa-angle-right"></i>
                                    <?php endif; ?>
                                    <?php if($menu->subMenus()->count() > 0): ?>
                                    <ul class="subCtg">
                                        <?php $__currentLoopData = $menu->subMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <a href="<?php echo e(asset($menu->menuLink())); ?>"><?php echo e($menu->menuName()); ?></a>
                                            <?php if($menu->subMenus()->count() > 0): ?>
                                            <i class="fa fa-angle-right"></i>
                                            <?php endif; ?>
                                            <?php if($menu->subMenus()->count() > 0): ?>
                                            <ul class="subsubCtg">
                                                <?php $__currentLoopData = $menu->subMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <a href="<?php echo e(asset($menu->menuLink())); ?>"><?php echo e($menu->menuName()); ?></a>
                                                </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                            <?php endif; ?>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                    <?php endif; ?>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="menuList">
                        <?php if($menu = menu('Header Menus')): ?>
                        <ul>
                            <li><a href="<?php echo e(route('index')); ?>">Home</a></li>
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
</header>
<!-- header part end --><?php /**PATH /home/meghfash/public_html/resources/views/welcome/layouts/header.blade.php ENDPATH**/ ?>