<!DOCTYPE html>
<html lang="en">
    <head>
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

        <?php echo $__env->yieldContent('title'); ?>
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset(general()->favicon())); ?>" />
        <?php echo $__env->yieldContent('SEO'); ?>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Parkinsans:wght@300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        <!-- Bootstrap CS CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />

        <!-- Font Awesome CSS CDN-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@5.2.0/css/swiper.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easyzoom@2.5.2/css/easyzoom.css" />

        <!-- Slick Slider CSS CDN-->
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('welcome/css/slick.css')); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('welcome/css/slick-theme.css')); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('welcome/css/jquery.fancybox.css')); ?>" />

        <!-- Matis Menus CSS -->
        <link rel="stylesheet" href="<?php echo e(asset('welcome/css/metisMenu.css')); ?>" />
        <!-- Custom Css for this Design -->
        <link rel="stylesheet" href="<?php echo e(asset('welcome/css/style-v2.8.css')); ?>" />
        
        <style>
            .section.customInvoice {
                margin: 30px 0;
            }
            
            .loading{
                position: relative;
            }
            
            .loading::after {
                content:'';
                height: 0;
                width: 0;
                padding: 8px;
                border: 4px solid #ccc;
                border-right-color: #a01a22;
                border-radius: 22px;
                -webkit-animation: spin 1s infinite linear;
                position: absolute;
                left: 20%;
                top: 20%;
            }
            
            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }
                100% {
                    transform: rotate(360deg);
                }
            }
            
            <?php if(!Request::is('/')): ?>
                .ctgScrolBar {
                    display: none;
                }
            <?php endif; ?>
            
        </style>
        
        <?php echo $__env->yieldPushContent('css'); ?>

    </head>
    
    <body>
        
        <!--Header Part Include Start-->
        <?php echo $__env->make(general()->theme.'.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!--Main Section Start-->
        <div style="min-height:500px;">
        <?php echo $__env->yieldContent('contents'); ?>
        </div>
        <!--Main Section End-->
        
         <!--Footer Part Include Start-->
        <?php echo $__env->make(general()->theme.'.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
        <div class="hamburger-menu">
            <div class="bar"></div> 
        </div>
        
        <nav class="mobile-menu">
            <?php if($menu = menu('Category Menus')): ?>
            <ul>
                <?php $__currentLoopData = $menu->subMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="has-children"><?php echo e($menu->menuName()); ?> 
                    <?php if($menu->subMenus()->count() > 0): ?>
                    <span class="icon-arrow"></span>
                    <?php endif; ?>
                    <ul class="children">
                        <?php $__currentLoopData = $menu->subMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a href="<?php echo e(asset($menu->menuLink())); ?>"><?php echo e($menu->menuName()); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>        
            </ul>
            <?php endif; ?>
        </nav>
        
        <div class="mobileCarts">
            <ul>
                <li>
                    <a href="<?php echo e(route('index')); ?>">
                        <div class="countPosiMobile">
                            <i class="fa fa-home"></i>
                            <span>Home</span>
                        </div>
                    </a>
                </li>
                
                <li>
                    <a href="<?php echo e(route('myWishlist')); ?>">
                        <div class="countPosiMobile">
                            <i class="fa fa-heart-o"></i>
                            <span>Wishlist</span>
                        </div>
                    </a>
                </li>

                <li>
                    <a href="<?php echo e(route('carts')); ?>">
                        <div class="countPosiMobile">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span>Cart</span>
                        </div>
                    </a>
                </li>
                
                <li>
                    <a href="#">
                        <div class="countPosiMobile Bar">
                            <i class="fa-solid fa-bars"></i>
                            <span>Menu</span>
                        </div>
                    </a>
                </li>
                
                <li>
                    <?php if(Auth::check()): ?>
                    <a href="<?php echo e(route('customer.dashboard')); ?>">
                    <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>">
                    <?php endif; ?>
                        <div class="countPosiMobile">
                            <i class="fa fa-user-o"></i>  
                            <span>Login</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Jquery Script  CDN-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- Bootstrap Script  CDN-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        
        <script src="https://cdn.jsdelivr.net/npm/swiper@5.2.0/js/swiper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/easyzoom@2.5.2/dist/easyzoom.js"></script>

        <!-- Metis Menus Script -->
        <script src="<?php echo e(asset('welcome/js/metisMenu.min.js')); ?>"></script>

        <!-- Slick slider CDN -->
        <script type="text/javascript" src="<?php echo e(asset('welcome/js/slick.min.js')); ?>"></script>

        <!--iconify Script CDN-->
        <script src="https://code.iconify.design/1/1.0.7/iconify.min.js')}}"></script>

        <!-- Custom Script for this Design -->
        <script src="<?php echo e(asset('welcome/js/myScript.js')); ?>"></script>

        <script type="text/javascript">
        
            (function () {
                
                $('.hamburger-menu').on('click', function() {
                    $('.bar').toggleClass('animate');
                $('.mobile-menu').toggleClass('active');
                return false;
                });
                
                $('.countPosiMobile.Bar').on('click', function() {
                    $('.bar').toggleClass('animate');
                $('.mobile-menu').toggleClass('active');
                return false;
                });
                
              $('.has-children').on ('click', function() {
                       $(this).children('ul').slideToggle('slow', 'swing');
                   $('.icon-arrow').toggleClass('open');
                });
            })();
        </script>

        <script>
            function openSearch() {
                document.getElementById("myOverlay").style.display = "block";
            }

            function closeSearch() {
                document.getElementById("myOverlay").style.display = "none";
            }
        </script>

        <script type="text/javascript">
        /** CSRF Token Header Set **/
            $.ajaxSetup({
        	    headers: {
        	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        	    }
        	});
            // home page banner slider script start
              $(".headerTopPart").slick({
                dots: false,
                autoplay: true,
                autoplaySpeed: 5000,
                infinite: true,
                speed: 1500,
                prevArrow: '',
                nextArrow: '',
                slidesToShow: 1,
                slidesToScroll: 1,
                
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            infinite: true,
                        },
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        },
                    },
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ],
            });
        
            $(".feaCtgSlick").slick({
                autoplay: true,
                autoplaySpeed: 3000,
                dots: false,
                infinite: true,
                speed: 300,
                prevArrow: '<i class="fa fa-angle-left"></i>',
                nextArrow: '<i class="fa fa-angle-right"></i>',
                slidesToShow: 8,
                slidesToScroll: 1,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 1,
                            infinite: true,
                            dots: true,
                        },
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        },
                    },
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ],
            });
        </script>

        <script type="text/javascript">
            $(".brandSlick").slick({
                autoplay: true,
                autoplaySpeed: 3000,
                dots: false,
                infinite: true,
                speed: 300,
                prevArrow: '<i class="fa fa-angle-left"></i>',
                nextArrow: '<i class="fa fa-angle-right"></i>',
                slidesToShow: 8,
                slidesToScroll: 1,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 1,
                            infinite: true,
                            dots: true,
                        },
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        },
                    },
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ],
            });
        </script>

        <script>
            $(document).ready(function(){
                
                 $("#district").on("change", function(){
                    var id = $(this).val();
                      if(id==''){
                       $('#city').empty().append('<option value="">No City</option>');
                      }
                      var url ='<?php echo e(url('geo/filter')); ?>' + '/'+id;
                      $.get(url,function(data){
                        $('#city').empty().append(data.geoData);  
                      });   
                });
                
                $(document).on("click", ".ajaxaddToCart", function () {
                  var that = $( this );
                  var url = that.data('url');
                    that.addClass('loading');
                    $.ajax({
                      url: url,
                      type: 'GET',
                      dataType: 'json',
                      cache: false,
                    })
                    .done(function(data) {
                        that.removeClass('loading');
                        if(data.success){
                            $(".cartCounter").empty().append(data.cartCount);
                            $(".cartTotal").empty().append(data.cartTotal);
                        }
                        that.empty().append('Cart Added');
                        setTimeout(function() {
                            that.empty().append('Add to Cart');
                        }, 2000);
                    })
                    .fail(function() {
                      // alert("error");
                      that.removeClass('loading');
                    });
                    
                });
                
                 $(document).on('click','.cartUpdate',function(){
    
                      var url = $(this).data('url');
                      var Dcharge =parseInt($('.cartDeliveryCharge').text());
        
                      if (isNaN(Dcharge)){
                        Dcharge =0;
                      }
        
                        $.ajax({
                          url: url,
                          type: 'GET',
                          dataType: 'json',
                          cache: false,
                        })
                        .done(function(data) {
                            $(".cartItemsList").empty().append(data.cartItems);
                            $(".cartCounter").empty().append(data.cartCount);
                            $(".cartTotal").empty().append(data.cartTotal);
                        })
                        .fail(function() {
                          // alert("error");
                        });
                    
                });
                
                
                $(document).on('click','.wishlistCompareUpdate',function(){
                  var that = $( this );
                  var url = that.data('url');
                  that.addClass('loading');
                  $.ajax({
                      url: url,
                      type: 'GET',
                      dataType: 'json',
                      cache: false,
                    })
                    .done(function(data) {
                        that.removeClass('loading');
                        if(data.success)
                           {
                            $(".viewItemsLists").empty().append(data.itemsView);
    
                            if(data.status==true){
                              that.find('.fa').toggleClass('fa-heart-o fa-heart');
                            }else{
                              that.find('.fa').toggleClass('fa-heart fa-heart-o');
                            }
                            if(data.statusType==0){
                              $(".wlcounter").empty().append(data.count);
                              if(data.alert==true){
                                alert('Wishlist Are Full. Cannot Added Over 48 Items.');
                              }
                            }else{
                              $(".cpcounter").empty().append(data.count);
                              if(data.alert==true){
                                alert('Compare Are Full. Cannot Added Over 20 Items.');
                              }
                            }
    
                           }
                    })
                    .fail(function() {
                      // alert("error");
                      that.removeClass('loading');
                    });
    
                });
                
                
            
                $(".categoryListMain").hide();
                $(".navCtg").click(function(){
                    $(".categoryListMain").toggle("slow");
                });
                
            });
        </script>
        
        <script>
            $(document).on('click','.subsriberbtm',function(e){
              e.preventDefault();
               var url = $('#subscirbeForm').data('url');
               var subscribeEmail =$('#subscribeEmail').val();
                    $.ajax({
                      url: url,
                      type: 'POST',
                      dataType: 'json',
                      data: {email : subscribeEmail},
                      cache: false,
                    })
                    .done(function(data) {
                        if(data.success)
                          {
                            $("#subscribeemailMsg").html("<span style='color: #339642;padding: 5px 15px;margin-bottom: 10px;display: inline-block;'>"+ data.message +"</span>");
                            $("#subscribeEmail").css("border","");
                            $("#subscirbeForm")[0].reset();
                          }else{
                            $("#subscribeemailMsg").html("<span style='color: #e52734;padding: 5px 15px;margin-bottom: 10px;display: inline-block;'>"+ data.message +"</span>");
                          }
                    })
                    .fail(function() {
                      // alert("error");
                    });
        
            });
        
            $("#subscribeEmail").keyup(function(){
                  if(validateEmail()){
                      $("#subscribeEmail").css("border","2px solid #339642");
                      //$("#subscribeemailMsg").html("<span style='background: #339642;padding: 5px 15px;'>Validated Email</span>");
                  }else{
                        var subscribeEmail=$("#subscribeEmail").val();
                       if(subscribeEmail==''||subscribeEmail==null || subscribeEmail=='undefined'){
                            //$("#subscribeemailMsg").html("<span style='background: #e52734;padding: 5px 15px;'>Please Get a Verified Email</span>");
                        }else{
                          $("#subscribeEmail").css("border","2px solid #e52734");
                          $("#subscribeemailMsg").html("");
                        }
                  }
              });
        
            function validateEmail(){
                  var subscribeEmail=$("#subscribeEmail").val();
        
                   var reg =/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                   if(reg.test(subscribeEmail)){
                      return true;
                   }else{
                      return false;
              }
        
            }
        </script>
        
        <?php echo $__env->yieldPushContent('js'); ?>
        
    </body>
</html>
<?php /**PATH /home/posherbd/public_html/posher.com.bd/resources/views/welcome/layouts/app.blade.php ENDPATH**/ ?>