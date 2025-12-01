 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle()); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startSection('SEO'); ?>
<meta name="title" property="og:title" content="<?php echo e(general()->meta_title); ?>" />
<meta name="description" property="og:description" content="<?php echo general()->meta_description; ?>" />
<meta name="keyword" property="og:keyword" content="<?php echo e(general()->meta_keyword); ?>" />
<meta name="image" property="og:image" content="<?php echo e(asset(general()->logo())); ?>" />
<meta name="url" property="og:url" content="<?php echo e(route('index')); ?>" />
<link rel="canonical" href="<?php echo e(route('index')); ?>" />
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?> <?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<!--Slider Part Include Start-->
<?php echo $__env->make(general()->theme.'.layouts.slider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php if($featuredText): ?>
<div class="punchLine">
    <div class="container-fluid">
        <div class="row" style="margin:0 -5px">
            <div class="col-md-3 col-6" style="padding:5px">
                <div class="punchBox">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?php echo e(asset('public/welcome/images/Layer_1.png')); ?>" alt="Byteblis" />
                        </div>
                        <div class="col-md-9">
                            <h5>Payment & Delivery</h5>
                            <p><?php echo $featuredText->name; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6" style="padding:5px">
                <div class="punchBox">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?php echo e(asset('public/welcome/images/Layer_1 (1).png')); ?>" alt="Byteblis" />
                        </div>
                        <div class="col-md-9">
                            <h5>Return & Refund</h5>
                            <p><?php echo $featuredText->content; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6" style="padding:5px">
                <div class="punchBox">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?php echo e(asset('public/welcome/images/Layer_1 (2).png')); ?>" alt="Byteblis" />
                        </div>
                        <div class="col-md-9">
                            <h5>24x7 Free Support</h5>
                            <p><?php echo $featuredText->sub_title; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6" style="padding:5px">
                <div class="punchBox">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?php echo e(asset('public/welcome/images/Vector.png')); ?>" alt="Byteblis" />
                        </div>
                        <div class="col-md-9">
                            <h5>Special Gift Cards</h5>
                            <p><?php echo $featuredText->description; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if($bannerGroupOne->count() > 0): ?>
<div class="offerProducts">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <?php if($data=$bannerGroupOne->first()): ?>
                
                <div class="leftOfferBox">
                    <a href="<?php echo e($data->image_link); ?>">
                        <img src="<?php echo e(asset($data->image())); ?>" alt="<?php echo e($data->name); ?>" />
                    </a>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <?php $__currentLoopData = $bannerGroupOne; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($i==0): ?> <?php else: ?>
                    
                    <div class="rightOfferBox">
                        <a href="<?php echo e($data->image_link); ?>">
                            <img src="<?php echo e(asset($data->image())); ?>" alt="<?php echo e($data->name); ?>" />
                        </a>
                    </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="featuredCtgs">
    <div class="container-fluid">
        <h2>Featured Categories</h2>
        <div class="feaCtgSlick">
            <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hCtg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="slick-box">
                <a href="<?php echo e(route('productCategory',$hCtg->slug?:'no-title')); ?>" class="deatVtgGrid">
                    <img src="<?php echo e(asset($hCtg->image())); ?>" alt="<?php echo e($hCtg->name); ?>" />
                    <p><?php echo e($hCtg->name); ?></p>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>



<?php echo $__env->make(general()->theme.'.layouts.featuredProductTab', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__currentLoopData = $largeBannerOne; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="smartPart">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="smartPartImg">
                    <img src="<?php echo e(asset($data->image())); ?>" alt="<?php echo e($data->name); ?>" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="smartContent">
                    <span><?php echo $data->sub_title; ?></span>
                    <h1>
                        <?php echo $data->name; ?>

                    </h1>
                    <p>
                    <?php echo $data->description; ?>

                    </p>
                    <?php if($data->image_link): ?>
                    <a href="#">Shop Now</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




<?php if($bannerGroupTwo->count() > 0): ?>
<div class="twoPartBanner">
    <div class="container-fluid">
        <div class="row">
            <?php $__currentLoopData = $bannerGroupTwo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6">
                
                <div class="rightOfferBox <?php echo e($i % 2 === 0?'':'blackBox'); ?>">
                    <a href="<?php echo e($data->image_link); ?>">
                        <img src="<?php echo e(asset($data->image())); ?>" alt="<?php echo e($data->name); ?>" />
                    </a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $__currentLoopData = $categoryGroupOne; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="allProd">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10">
                <h1><?php echo $data->name; ?></h1>
            </div>
            <div class="col-md-2">
                 <?php if($ctg =$data->category): ?>
                <a href="<?php echo e(route('productCategory',$ctg->slug?:'no-title')); ?>" class="showMoreLink">Show More</a>
                <?php endif; ?>
            </div>
            <div class="col-md-12">
                <hr />
            </div>
            <div class="col-md-12">
                <div class="row productRow">
                    <?php $__currentLoopData = $data->products(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-3 col-6">
                        <?php echo $__env->make(welcomeTheme().'.products.includes.productCard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__currentLoopData = $largeBannerTwo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="bannerMiddlw">
    <div class="container-fluid">
        <a href="<?php echo e($data->image_link?:'javascript:void(0)'); ?>">
            <img src="<?php echo e(asset($data->image())); ?>" alt="<?php echo e($data->name); ?>" />
        </a>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__currentLoopData = $categoryGroupTwo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="allProd">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10">
                <h1><?php echo $data->name; ?></h1>
            </div>
            <div class="col-md-2">
                <?php if($ctg =$data->category): ?>
                <a href="<?php echo e(route('productCategory',$ctg->slug?:'no-title')); ?>" class="showMoreLink">Show More</a>
                <?php endif; ?>
            </div>
            <div class="col-md-12">
                <hr />
            </div>
            <div class="col-md-12">
                <div class="row productRow">
                    <?php $__currentLoopData = $data->products(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-3 col-6">
                        <?php echo $__env->make(welcomeTheme().'.products.includes.productCard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php if($data =$timeOfferBanner): ?>
<div class="superSale">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <img class="superImg" src="<?php echo e(asset($data->image())); ?>" alt="<?php echo e($data->name); ?>" />
            </div>
            <div class="col-md-6">
                <div class="offerCounter">
                    <h4><?php echo $data->sub_title; ?></h4>
                    <h2><?php echo $data->name; ?></h2>
                    
                    <div class="mainOfferq" data-date="<?php echo e(Carbon\Carbon::now()->addDay($data->data_limit)->format('d/m/Y')); ?>">
                        <ul>
                            <li><span id="days"></span>days</li>
                            <li><span id="hours"></span>Hours</li>
                            <li><span id="minutes"></span>Minutes</li>
                            <li><span id="seconds"></span>Seconds</li>
                        </ul>
                    </div>
                    
                    <?php if($data->image_link): ?>
                    <a href="<?php echo e($data->image_link); ?>">Shop Now</a>
                    <?php endif; ?>
                    
                </div>
            </div>
            <div class="col-md-3">
                <img class="superImg" src="<?php echo e(asset($data->banner())); ?>" alt="<?php echo e($data->name); ?>" />
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if($brands->count() > 0): ?>


<?php echo $__env->make(general()->theme.'.layouts.brandsProduct', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php endif; ?>


<?php if($bannerGroupThree->count() > 0): ?>
<div class="twoPartBanner">
    <div class="container-fluid">
        <div class="row">
            <?php $__currentLoopData = $bannerGroupThree; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6">
                
                <div class="rightOfferBox <?php echo e($i % 2 === 0?'':'blackBox'); ?>">
                    <a href="<?php echo e($data->image_link); ?>">
                        <img src="<?php echo e(asset($data->image())); ?>" alt="<?php echo e($data->name); ?>" />
                    </a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if($page->description): ?>
<div class="homeSeoContent">
    <div class="container-fluid">
        <div class="homeTextBox pageContents">
            <?php echo $page->description; ?>

        </div>
    </div>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?> 
<?php $__env->startPush('js'); ?> 

<script type="text/javascript">
    $(document).ready(function () {
        const second = 1000,
              minute = second * 60,
              hour = minute * 60,
              day = hour * 24;

        // Get the date from the data attribute (d/m/Y format from Carbon)
        let birthday = $('.mainOfferq').data('date');

        // Split the date (d/m/Y) into day, month, year
        let dateParts = birthday.split('/');
        let dayOfMonth = dateParts[0];
        let month = dateParts[1] - 1; // Month is 0-based in JavaScript (0 = January)
        let year = dateParts[2];

        // Create a JavaScript Date object in MM/DD/YYYY format
        let formattedBirthday = new Date(year, month, dayOfMonth).getTime();

        // Get today's date in MM/DD/YYYY format
        let today = new Date(),
            dd = String(today.getDate()).padStart(2, '0'),
            mm = String(today.getMonth() + 1).padStart(2, '0'),
            yyyy = today.getFullYear();

        today = mm + '/' + dd + '/' + yyyy;

        // If today's date is greater than the birthday, set the birthday to the next year
        if (today > birthday) {
            formattedBirthday = new Date(yyyy + 1, month, dayOfMonth).getTime();
        }

        // Countdown target date
        const countDown = formattedBirthday;

        // Update the countdown every second
        const x = setInterval(function () {
            const now = new Date().getTime(),
                  distance = countDown - now;

            $('#days').text(Math.floor(distance / day));
            $('#hours').text(Math.floor((distance % day) / hour));
            $('#minutes').text(Math.floor((distance % hour) / minute));
            $('#seconds').text(Math.floor((distance % minute) / second));

            // If the countdown reaches 0, display the message and hide countdown
            if (distance < 0) {
                $('#headline').text("Today is the Day!");
                $('#countdown').hide();
                $('#content').show();
                clearInterval(x);
            }
        }, 1000);
    });
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make(welcomeTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\poshak\resources\views/welcome/index.blade.php ENDPATH**/ ?>