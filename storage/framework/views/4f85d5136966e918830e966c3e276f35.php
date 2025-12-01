 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle($product->name)); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startSection('SEO'); ?>
<meta name="title" property="og:title" content="<?php echo e($product->seo_title?:websiteTitle($product->name)); ?>" />
<meta name="description" property="og:description" content="<?php echo $product->seo_description?:general()->meta_description; ?>" />
<meta name="keywords" content="<?php echo e($product->seo_keyword?:general()->meta_keyword); ?>" />
<meta name="image" property="og:image" content="<?php echo e(asset($product->image())); ?>" />
<meta name="url" property="og:url" content="<?php echo e(route('productView',$product->slug?:'no-title')); ?>" />
<link rel="canonical" href="<?php echo e(route('productView',$product->slug?:'no-title')); ?>">
<?php $__env->stopSection(); ?>
 <?php $__env->startPush('css'); ?>

<style>

.gallery-thumbs .swiper-slide img {
    max-width: 95%;
    border: 1px solid #0ba350;
    cursor: pointer;
    padding: 10px;
    border-radius: 8px;
    background-color: #f7f7f7;
}

.twoPartBanner {
    margin-top: 50px;
}

.gallery-thumbs .swiper-slide {
    height: 120px;
    text-align: center;
    margin: 10px 0;
}

ul.colorList{
    display:inline-block;
    margin-top:0;
}

ul.colorList li{
    background-color: unset;
    color:unset;
    float: left;
    padding:0;
    padding-right: 10px;
}

.attributeItem .colorItem {
    height: 25px;
    width: 25px;
    border-radius: 100%;
    cursor:pointer;
    margin-bottom: 5px;
}

.attributeItem .colorItem.active {
    box-shadow: 0px 1px 8px 2px #444;
}

.attributeItem .textItem {
    /*height: 25px;*/
    min-width: 25px;
    border-radius: 5px;
    background: #f1f1f1;
    text-align: center;
    padding: 8px 20px;
    text-transform: uppercase;
    cursor: pointer;
    border: 1px solid #e9dce2;
    margin-bottom: 5px;
    line-height: 18px;
}

.attributeItem .textItem.active {
    border-color: #0ba350;
}

.attributeItem .imageItem {
    margin-bottom: 5px;
}

.attributeItem .imageItem img {
    width: 25px;
    height: 25px;
    border-radius: 5px;
    border: 1px solid #dfdede;
    padding: 1px;
}

.attributeItem .imageItem.active img {
    border-color: #0ba350;
}

.attributeValue {
    width: 1px;
    position: absolute;
    z-index: -9;
}

.speceficate tr td {
    vertical-align: middle;
}

.descrBox p{
    text-align:left;
}

.cardItemBox input:focus-visible {
    outline: none;
}

.addToSinBtn[disabled] {
    opacity: 0.5;
    cursor: no-drop;
}

.buyNowSinBtn[disabled] {
    opacity: 0.5;
    cursor: no-drop;
}

.warrantyNote{
    display: flex;
    align-items: center;
    width: 100%;
    background: white;
    padding: 15px 20px;
    border-radius: 5px;
    border: 1px solid #dbdbdb;
    height: 55px;
    cursor: pointer;
    margin-bottom: 10px;
}

.warrantyNote p {
    font-size: 12px;
    color: #767676;
    line-height: 14px;
}
.warrantyNote p b {
    font-size: 14px;
    margin: 0;
    display: inline-block;
    height:unset;
}

.productImageGallery .largeImage {
    margin-bottom: 10px;
    border: 1px solid #e9e9e9;
    border-radius: 6px;
    overflow: hidden;
    position: relative;
    text-align: center;
}
.imageGallery {
    border: 1px solid #e9e9e9;
    border-radius: 6px;
    overflow: hidden;
    padding: 12px 24px;
}

.imageGallery ul {
    text-align: center;
}

.imageGallery ul li {
    display: inline-block;
    height: 80px;
    width: 80px;
    text-align: center;
}

.productPrice .offerPrice{
    display:inline-block;
    font-size:unset;
    margin: 0;
}

.smalOtherBox .row .col-md-3 {
    max-width: 100px;
}

</style>

<?php $__env->stopPush(); ?> 

<?php $__env->startSection('contents'); ?>

<div class="singleProHead">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('index')); ?>">Home</a></li>
                <?php $__currentLoopData = $product->productCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$ctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="breadcrumb-item"><a href="<?php echo e(route('productCategory',$ctg->slug?:'no-title')); ?>"><?php echo e($ctg->name); ?></a></li>
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <!--<li class="breadcrumb-item active" aria-current="page"><?php echo e($product->name); ?></li>-->
            </ol>
        </nav>
    </div>
</div>

<div class="singlePageMainDiv">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5">
                <?php if($product->productAttibutesVariationGroup()->count() > 0): ?>
                
                <div class="productImageGallery">
                    <div class="largeImage">
                        <img src="<?php echo e(asset($product->image())); ?>" alt="<?php echo e($product->name); ?>" style="max-width:100%;max-height:100%;"/>
                    </div>
                    <div class="imageGallery">
                        <ul>
                            <?php $__currentLoopData = $product->variationGallery(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <img src="<?php echo e(asset($img['image'])); ?>" alt="<?php echo e($product->name); ?>" style="max-width: 100%;max-height:100%;cursor: pointer;">
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
                <?php else: ?>
                <div class="productGallery">
                     <!-- Swiper and EasyZoom plugins start -->
                      <div class="swiper-container gallery-top">
                        <div class="swiper-wrapper">
                          <div class="swiper-slide easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                            <a href="<?php echo e(asset($product->image())); ?>">
                              <img src="<?php echo e(asset($product->image())); ?>" alt="<?php echo e($product->name); ?>" style="max-width:100%;"/> 
                            </a>
                          </div>
                          <?php $__currentLoopData = $product->galleryFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <div class="swiper-slide easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                            <a href="<?php echo e(asset($gallery->image())); ?>">
                              <img src="<?php echo e(asset($gallery->image())); ?>" alt="<?php echo e($product->name); ?>" style="max-width:100%;"/>
                            </a>
                          </div>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <!-- Add Arrows -->
                        <div class="swiper-button-next swiper-button-white"></div>
                        <div class="swiper-button-prev swiper-button-white"></div>
                      </div>
                      <div class="swiper-container gallery-thumbs">
                        <div class="swiper-wrapper">
                          <div class="swiper-slide">
                            <img src="<?php echo e(asset($product->image())); ?>" alt="<?php echo e($product->name); ?>">
                          </div>
                          <?php $__currentLoopData = $product->galleryFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <div class="swiper-slide">
                            <img src="<?php echo e(asset($gallery->image())); ?>" alt="<?php echo e($product->name); ?>">
                          </div>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                      </div>
                      <!-- Swiper and EasyZoom plugins end -->
                </div>
                <?php endif; ?>
            </div>
             <div class="col-md-7">
                <div class="productDetails">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h3><?php echo e($product->name); ?></h3>
                            <?php if($product->brand): ?>
                            <span>Brand: <b><?php echo e($product->brand->name); ?></b></span>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-12">
                            <div class="productPrice">
                                <p>
                                <!--<span>Price:</span>-->
                                <?php if($product->productAttibutesVariationGroup()->count() > 0 && $selectVariation): ?>
                                <b class="productPriceAppend">
                                    <span class="offerPrice" data-price="<?php echo e($selectVariation->offerPrice()); ?>"><?php echo e(priceFullFormat($selectVariation->offerPrice())); ?></span>/-<br>
                                <?php if($selectVariation->reguler_price > $selectVariation->offerPrice()): ?>
                                <del class="regularPrice" data-price="<?php echo e($selectVariation->reguler_price); ?>"><?php echo e(priceFullFormat($selectVariation->reguler_price)); ?>/-</del>
                                <?php endif; ?>
                                </b>
                                <?php else: ?>
                                <b>
                                <span class="offerPrice" data-price="<?php echo e($product->offerPrice()); ?>"><?php echo e(priceFullFormat($product->offerPrice())); ?></span>/-<br>
                                <?php if($product->regular_price > $product->offerPrice()): ?>
                                <del class="regularPrice" data-price="<?php echo e($product->regular_price); ?>"><?php echo e(priceFullFormat($product->regular_price)); ?>/-</del>
                                <?php endif; ?>
                                </b>
                                <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="descrBox" style="margin: 0;">
                                <?php echo $product->short_description; ?>

                            </div>
                        </div>
                        
                    </div>
                    
                    <form class="addToCartForm" action="<?php echo e(route('addToCart',$product->id)); ?>" method="post">
                        <?php echo csrf_field(); ?>
                    <div class="smalinfoBox">
                        <div class="row">
                            <?php if($product->sku_code): ?>
                            <div class="col-lg-4">
                                <h6>SKU <b><?php echo e($product->sku_code); ?></b></h6>
                            </div>
                            <?php endif; ?>
                            <div class="col-lg-3">
                                <h6 class="wishlistCompareUpdate" data-url="<?php echo e(route('wishlistCompareUpdate',[$product->id,'wishlist'])); ?>" style="cursor: pointer;"><i class="fa <?php echo e($product->isWl()?'fa-heart':'fa-heart-o'); ?>"></i> Wishlist</h6>
                            </div>
                            <div class="col-lg-5">
                                <h6>Status: 
                                <div class="productStock" style="display: inline-block;">
                                <?php if($product->stockStatus()): ?>
                                <b>Stock Available</b>
                                <?php else: ?>
                                <b style="color: red;"> Stock Out</b>
                                <?php endif; ?>
                                </div>
                                </h6>
                            </div>
                        </div>
                        <?php if($product->warranty_note || $product->warranty_note2): ?>
                        <br>
                        <div class="row">
                            <?php if($product->warranty_note): ?>
                            <div class="col-md-6">
                                <label class="warrantyNote">
                                    <input type="radio" name="warranty" value="warranty_note" style="margin-right:10px;" data-price="<?php echo e($product->warranty_charge); ?>" checked="" required="">
                                    <div class="warrantyTitle">
                                        <p>
                                        <!--<b>Warranty Charge: <?php echo e($product->warranty_charge > 0 ?priceFullFormat($product->warranty_charge):'Free'); ?></b>-->
                                        <!--<br>-->
                                        <?php echo e($product->warranty_note); ?></p>
                                    </div>
                                </label>
                            </div>
                            <?php endif; ?>
                            <?php if($product->warranty_note2): ?>
                            <div class="col-md-6">
                                <label class="warrantyNote">
                                    <input type="radio" name="warranty" value="warranty_note2" style="margin-right:10px;" data-price="<?php echo e($product->warranty_charge2); ?>" <?php echo e($product->warranty_note==null?'checked':''); ?> required="">
                                    <div class="warrantyTitle">
                                        <p>
                                            <!--<b>Warranty Charge: <?php echo e($product->warranty_charge2 > 0 ?priceFullFormat($product->warranty_charge2):'Free'); ?></b>-->
                                            <!--<br>-->
                                            <?php echo e($product->warranty_note2); ?></p>
                                    </div>
                                </label>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if($product->productAttibutesVariationGroup()->count() > 0): ?>
                    <div class="smalOtherBox">
                        
                        <?php echo $__env->make(welcomeTheme().'products.includes.productVariation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        
                    </div>
                    <?php endif; ?>
                    <div class="cardItemBox">
                        <div class="row">
                            <div class="col-md-4">
                                <h5>Quantity: </h5>
                                <input data-min="<?php echo e($product->productMinQty()); ?>" 
                                <?php if($product->productAttibutesVariationGroup()->count() > 0 && $selectVariation): ?>
                                data-max="<?php echo e($selectVariation->quantity); ?>"
                                <?php else: ?>
                                data-max="<?php echo e($product->productMaxQty()); ?>"
                                <?php endif; ?>
                                type="text" name="quantity" value="1" class="productQtyValue" readonly="true" />
                                <div class="quantity-selectors-container">
                                    <div class="quantity-selectors">
                                        <button type="button" class="increment-quantity quantityValue" aria-label="Add one" data-direction="1">&#43;</button>
                                        <button type="button" class="decrement-quantity quantityValue" aria-label="Subtract one" data-direction="-1" disabled="disabled">&#8722;</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" name="orderNow" value="order Now" class="buyNowSinBtn">Buy Now</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="addToSinBtn addToCartSubmit">Add To Cart</button>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="succeMessage"></div>
                    </div>
                    <br>
                    <div>
                        <?php if($product->productTagsList()->count() > 0): ?>
                            <b>Tag: </b>
                            <?php $__currentLoopData = $product->productTagsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="#" style="color: #464444;"><?php echo e($tag->name); ?></a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12">
                <div class="fullDetailsPart">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="fullDetailsPartRight">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Specification</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Description</button>
                                    </li>
                                    
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="table-responsive" style="min-height:300px;">
                                            <?php if($product->extraAttribute->count() > 0): ?>
                                            <table class="table table-striped speceficate">
                                                <tbody>
                                                    <?php $__currentLoopData = $product->extraAttribute; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $extraAttri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td style="width: 30%; font-weight: bold;"><?php echo $extraAttri->name; ?></td>
                                                        <td><?php echo $extraAttri->content; ?></td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                            <?php else: ?>
                                            <span>No Specification</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="product_description" style="min-height:300px;">
                                            <?php if($product->description): ?>
                                            <?php echo $product->description; ?>

                                            <?php else: ?>
                                            <span>No Description</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="fullDetailsPartLeft">
                                <h3>Similer Products</h3>
                                <?php if($relatedProducts->count() > 0): ?>
                                <ul>
                                    <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a href="<?php echo e(route('productView',$rProduct->slug?:Str::slug($rProduct->name))); ?>">
                                            <div class="row">
                                                <div class="col-4">
                                                    <img src="<?php echo e(asset($rProduct->image())); ?>" alt="<?php echo e($rProduct->name); ?>">
                                                </div>
                                                <div class="col-8">
                                                    <p style="font-size: 13px;"><?php echo e($rProduct->name); ?></p>
                                                    <span>
                                                        <?php echo e(priceFullFormat($rProduct->offerPrice())); ?>/-
                                                        <?php if($rProduct->regular_price > $rProduct->offerPrice()): ?>
                                                        <del><?php echo e(priceFullFormat($rProduct->regular_price)); ?>/-</del>
                                                        <?php endif; ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                <?php else: ?>
                                <span>No Related Product</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


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


<?php echo $__env->make(welcomeTheme().'products.includes.relatedProducts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php $__env->stopSection(); ?> 
<?php $__env->startPush('js'); ?> 

<script>
    const allStar = document.querySelectorAll('.rating .star')
    const ratingValue = document.querySelector('.rating input')
    
    allStar.forEach((item, idx)=> {
    	item.addEventListener('click', function () {
    		let click = 0
    		ratingValue.value = idx + 1
    
    		allStar.forEach(i=> {
    			i.classList.replace('bxs-star', 'bx-star')
    			i.classList.remove('active')
    		})
    		for(let i=0; i<allStar.length; i++) {
    			if(i <= idx) {
    				allStar[i].classList.replace('bx-star', 'bxs-star')
    				allStar[i].classList.add('active')
    			} else {
    				allStar[i].style.setProperty('--i', click)
    				click++
    			}
    		}
    	})
    })
</script>

<script>
    $(document).ready(function(){
        
        // activation carousel plugin
        var galleryThumbs = new Swiper('.gallery-thumbs', {
            spaceBetween: 5,
            freeMode: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            breakpoints: {
                0: {
                    slidesPerView: 3,
                },
                992: {
                    slidesPerView: 4,
                },
            }
        });
        
        var galleryTop = new Swiper('.gallery-top', {
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: galleryThumbs
            },
        });
        
        // change carousel item height
        // gallery-top
        let productCarouselTopWidth = $('.gallery-top').outerWidth();
        $('.gallery-top').css('height', productCarouselTopWidth);
    
        // gallery-thumbs
        let productCarouselThumbsItemWith = $('.gallery-thumbs .swiper-slide').outerWidth();
        $('.gallery-thumbs').css('height', productCarouselThumbsItemWith);
        
        $('.easyzoom').easyZoom();
        
        
        $(document).on('click','.imageGallery ul li img',function(){
            var imgSrc = $(this).attr('src');
            $('.largeImage img').attr('src', imgSrc);
        });
        
        getPrice();
        
        function getPrice(){
            setTimeout(function() {
                
                var charge = 0;
                var offerPrice = 0;
                var regularPrice = 0;
                
                // Check if a warranty option is checked
                if ($('.warrantyNote input[name="warranty"]:checked').length > 0) {
                charge = parseFloat($('.warrantyNote input[name="warranty"]:checked').data('price'));
                }
                
                // Check if offerPrice and regularPrice elements exist and have data
                if ($('.productPrice .offerPrice').length > 0) {
                offerPrice = parseFloat($('.productPrice .offerPrice').data('price')); 
                }
                if ($('.productPrice .regularPrice').length > 0) {
                regularPrice = parseFloat($('.productPrice .regularPrice').data('price'));
                }
                
                var finalPrice = offerPrice + charge;
                var finalRPrice = regularPrice + charge;
                
                $('.productPrice .offerPrice').empty().append("BDT " + finalPrice.toLocaleString('en-IN', { 
                  minimumFractionDigits: 0, 
                  maximumFractionDigits: 0 
                }));
                $('.productPrice .regularPrice').empty().append("BDT " + finalRPrice.toLocaleString('en-IN', { 
                  minimumFractionDigits: 0, 
                  maximumFractionDigits: 0 
                }) + '/-');

            }, 1);
            
            
        }
        
        $(document).on('click','.warrantyNote',function(){
           getPrice();
        });
        
        $(document).on('click','.addToCartSubmit',function(){
            var status =true;
            
            // if($('.attributeValue[name="color"]').length > 0) {
            //     if($('.attributeValue[name="color"]:checked').length === 0){
            //         var dataNameValue = $('input.attributeValue[name="color"]').first().data('name');
            //         alert('Please select '+dataNameValue);
            //         status=false;
            //     }
            // }
            
            // if(status){
                
            //     if($('.attributeValue[name="size"]').length > 0) {
            //         if($('.attributeValue[name="size"]:checked').length === 0){
            //             var dataNameValue = $('.attributeValue[name="size"]').first().data('name');
            //             alert('Please select '+dataNameValue);
            //             status=false;
            //         }
            //     }
            // }

            if(status){
                
                var url =$('.addToCartForm').attr('action');
                var data = $('.addToCartForm').serialize();

                $.ajax({
                    url: url,
                    method: "POST",
                    data: data,
                })
                .done(function (data) {
                    if(data.success){
                        $(".cartCounter").empty().append(data.cartCount);
                        $(".cartTotal").empty().append(data.cartTotal);
                        $('.succeMessage').empty().append('<span style="display: inline-block;background: #0ba350;padding: 5px 15px;border-radius: 5px;min-width: 250px;margin-top: 10px;color: white;"><b>Success:</b> Add To Cart Successfully Done</span>');
                        
                    }
                    
                    if(data.success==false && data.message){
                        $('.succeMessage').empty().append('<span style="display: inline-block;background: #fa5661;padding: 5px 15px;border-radius: 5px;min-width: 250px;margin-top: 10px;color: white;"><b>Alert:</b> '+data.message+'</span>');
                    }
                    
                    setTimeout(function() {
                        $('.succeMessage').empty();
                    }, 3000);
                })
                .fail(function () {
    
                });
            
            }
                
        });
        
        
       function filterProductsBySelectedAttributes(datas, selectedIds) {
            return datas.filter(function(product) {
                
                return selectedIds.every(function(selectedId) {
                    return product.items.some(function(item) {
                        return item.attribute_item_id == selectedId;
                    });
                });
                
                // return product.items.some(function(item) {
                //     return selectedIds.includes(item.attribute_item_id);
                // });
            });
        }
        
        
       $('.attributeItem li label').click(function() {
           
            var dataName = $(this).data('name');
            $('.attributeItem li label[data-name="'+dataName+'"]').removeClass('active');
            
            $(this).addClass('active');
            
            var image = $(this).data('image');
            if (image) {
                //alert('Image URL: ' + image);
                $('.largeImage img').attr('src', image);
            }
            
            
            setTimeout(function() {
                var selectedIds = [];
                $('.attributeItem li .attributeValue:checked').each(function() {
                    selectedIds.push($(this).data('vlueid'));
                });
                
                var datas = <?php echo json_encode($datas, 15, 512) ?>;
                
                var filteredProducts = filterProductsBySelectedAttributes(datas, selectedIds);
                
                if(filteredProducts.length > 0) {
                    var priceText = '';
                    var stutas =true;
                    var qtyVari =0;
                    filteredProducts.forEach(function(product) {
                        priceText += product.price;
                        stutas =product.stock_status?true:false;
                        qtyVari =product.quantity;
                    });
                    
                    if(stutas){
                        
                        $('.buyNowSinBtn, .addToSinBtn').prop('disabled', false);
                        if($('.productQtyValue').val()==0){
                            $('.productQtyValue').val(1);
                            $('.productQtyValue').prop('disabled', false);
                        }
                        
                        $('.productQtyValue').attr('data-max',qtyVari);
                        $('.productPriceAppend').empty().append(priceText);
                        $('.productStock').empty().append('<b>Stock Available</b>');
                    
                    }else{
                        $('.buyNowSinBtn, .addToSinBtn').prop('disabled', true);
                        $('.productQtyValue').val(0);
                        $('.productQtyValue').prop('disabled', true);
                        $('.productStock').empty().append('<b style="color:red;">Stock Out</b>');
                    }
                    
                } else {
                    $('.buyNowSinBtn, .addToSinBtn').prop('disabled', true);
                    $('.productQtyValue').val(0);
                    $('.productQtyValue').prop('disabled', true);
                    $('.productStock').empty().append('<b style="color:red;">Stock Out</b>');
                }
                
                $('.succeMessage').empty()
                console.log(filteredProducts);
                console.log(selectedIds);
                getPrice();
            }, 10);
            
        });
        
        
        
        
        $(".quantityValue").on("click", function(ev) {
            
            if($('.productQtyValue').prop('disabled')){
                $('.succeMessage').empty().append('<span style="color: #fa5661;padding: 10px;">Insufficient stock, please call <?php echo e(general()->mobile); ?> for detail!</span>');
            }else{
                
            
              var currentQty = $('input[name="quantity"]').val();
            //   var maxQty = $('input[name="quantity"]').data('max');
              var maxQty =  $('.productQtyValue').data('max');
              var qtyDirection = $(this).data("direction");
              var newQty = 0;
              
              console.log(maxQty);
              
              if (qtyDirection == "1") {
                newQty = parseInt(currentQty) + 1;
              }
              else if (qtyDirection == "-1") {
                newQty = parseInt(currentQty) - 1;
              }
            
              // make decrement disabled at 1
              if (newQty == 1) {
                $(".decrement-quantity").attr("disabled", "disabled");
              }
              
              // remove disabled attribute on subtract
              if (newQty > 1) {
                $(".decrement-quantity").removeAttr("disabled");
              }
              
              if (newQty > 0){
                // newQty = newQty.toString();
                if(newQty < maxQty){
                $('input[name="quantity"]').val(newQty);
                }else{
                $('input[name="quantity"]').val(maxQty);
                }
              } else {
                $('input[name="quantity"]').val("1");
              }
          
            }
          
        });
        
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make(welcomeTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\poshak\resources\views/welcome/products/productView.blade.php ENDPATH**/ ?>