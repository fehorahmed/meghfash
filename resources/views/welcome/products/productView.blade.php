@extends(welcomeTheme().'layouts.app') @section('title')
<title>{{websiteTitle($product->name)}}</title>
@endsection @section('SEO')
<meta name="title" property="og:title" content="{{$product->seo_title?:websiteTitle($product->name)}}" />
<meta name="description" property="og:description" content="{!!$product->seo_description?:general()->meta_description!!}" />
<meta name="keywords" content="{{$product->seo_keyword?:general()->meta_keyword}}" />
<meta name="image" property="og:image" content="{{asset($product->image())}}" />
<meta name="url" property="og:url" content="{{route('productView',$product->slug?:'no-title')}}" />
<link rel="canonical" href="{{route('productView',$product->slug?:'no-title')}}">
@endsection
 @push('css')

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

@endpush 

@section('contents')

<div class="singleProHead">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                @foreach($product->productCategories as $i=>$ctg)
                <li class="breadcrumb-item"><a href="{{route('productCategory',$ctg->slug?:'no-title')}}">{{$ctg->name}}</a></li>
                 @endforeach
                <!--<li class="breadcrumb-item active" aria-current="page">{{$product->name}}</li>-->
            </ol>
        </nav>
    </div>
</div>

<div class="singlePageMainDiv">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5">
                @if($product->productAttibutesVariationGroup()->count() > 0)
                
                <div class="productImageGallery">
                    <div class="largeImage">
                        <img src="{{asset($product->image())}}" alt="{{$product->name}}" style="max-width:100%;max-height:100%;"/>
                    </div>
                    <div class="imageGallery">
                        <ul>
                            @foreach($product->variationGallery() as $img)
                            <li>
                                <img src="{{asset($img['image'])}}" alt="{{$product->name}}" style="max-width: 100%;max-height:100%;cursor: pointer;">
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @else
                <div class="productGallery">
                     <!-- Swiper and EasyZoom plugins start -->
                      <div class="swiper-container gallery-top">
                        <div class="swiper-wrapper">
                          <div class="swiper-slide easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                            <a href="{{asset($product->image())}}">
                              <img src="{{asset($product->image())}}" alt="{{$product->name}}" style="max-width:100%;"/> 
                            </a>
                          </div>
                          @foreach($product->galleryFiles as $gallery)
                          <div class="swiper-slide easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                            <a href="{{asset($gallery->image())}}">
                              <img src="{{asset($gallery->image())}}" alt="{{$product->name}}" style="max-width:100%;"/>
                            </a>
                          </div>
                          @endforeach
                        </div>
                        <!-- Add Arrows -->
                        <div class="swiper-button-next swiper-button-white"></div>
                        <div class="swiper-button-prev swiper-button-white"></div>
                      </div>
                      <div class="swiper-container gallery-thumbs">
                        <div class="swiper-wrapper">
                          <div class="swiper-slide">
                            <img src="{{asset($product->image())}}" alt="{{$product->name}}">
                          </div>
                          @foreach($product->galleryFiles as $gallery)
                          <div class="swiper-slide">
                            <img src="{{asset($gallery->image())}}" alt="{{$product->name}}">
                          </div>
                          @endforeach
                        </div>
                      </div>
                      <!-- Swiper and EasyZoom plugins end -->
                </div>
                @endif
            </div>
             <div class="col-md-7">
                <div class="productDetails">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h3>{{$product->name}}</h3>
                            @if($product->brand)
                            <span>Brand: <b>{{$product->brand->name}}</b></span>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <div class="productPrice">
                                <p>
                                <!--<span>Price:</span>-->
                                @if($product->productAttibutesVariationGroup()->count() > 0 && $selectVariation)
                                <b class="productPriceAppend">
                                    <span class="offerPrice" data-price="{{$selectVariation->offerPrice()}}">{{priceFullFormat($selectVariation->offerPrice())}}</span>/-<br>
                                @if($selectVariation->reguler_price > $selectVariation->offerPrice())
                                <del class="regularPrice" data-price="{{$selectVariation->reguler_price}}">{{priceFullFormat($selectVariation->reguler_price)}}/-</del>
                                @endif
                                </b>
                                @else
                                <b>
                                <span class="offerPrice" data-price="{{$product->offerPrice()}}">{{priceFullFormat($product->offerPrice())}}</span>/-<br>
                                @if($product->regular_price > $product->offerPrice())
                                <del class="regularPrice" data-price="{{$product->regular_price}}">{{priceFullFormat($product->regular_price)}}/-</del>
                                @endif
                                </b>
                                @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="descrBox" style="margin: 0;">
                                {!!$product->short_description!!}
                            </div>
                        </div>
                        
                    </div>
                    
                    <form class="addToCartForm" action="{{route('addToCart',$product->id)}}" method="post">
                        @csrf
                    <div class="smalinfoBox">
                        <div class="row">
                            @if($product->sku_code)
                            <div class="col-lg-4">
                                <h6>SKU <b>{{$product->sku_code}}</b></h6>
                            </div>
                            @endif
                            <div class="col-lg-3">
                                <h6 class="wishlistCompareUpdate" data-url="{{route('wishlistCompareUpdate',[$product->id,'wishlist'])}}" style="cursor: pointer;"><i class="fa {{$product->isWl()?'fa-heart':'fa-heart-o'}}"></i> Wishlist</h6>
                            </div>
                            <div class="col-lg-5">
                                <h6>Status: 
                                <div class="productStock" style="display: inline-block;">
                                @if($product->stockStatus())
                                <b>Stock Available</b>
                                @else
                                <b style="color: red;"> Stock Out</b>
                                @endif
                                </div>
                                </h6>
                            </div>
                        </div>
                        @if($product->warranty_note || $product->warranty_note2)
                        <br>
                        <div class="row">
                            @if($product->warranty_note)
                            <div class="col-md-6">
                                <label class="warrantyNote">
                                    <input type="radio" name="warranty" value="warranty_note" style="margin-right:10px;" data-price="{{$product->warranty_charge}}" checked="" required="">
                                    <div class="warrantyTitle">
                                        <p>
                                        <!--<b>Warranty Charge: {{$product->warranty_charge > 0 ?priceFullFormat($product->warranty_charge):'Free'}}</b>-->
                                        <!--<br>-->
                                        {{$product->warranty_note}}</p>
                                    </div>
                                </label>
                            </div>
                            @endif
                            @if($product->warranty_note2)
                            <div class="col-md-6">
                                <label class="warrantyNote">
                                    <input type="radio" name="warranty" value="warranty_note2" style="margin-right:10px;" data-price="{{$product->warranty_charge2}}" {{$product->warranty_note==null?'checked':''}} required="">
                                    <div class="warrantyTitle">
                                        <p>
                                            <!--<b>Warranty Charge: {{$product->warranty_charge2 > 0 ?priceFullFormat($product->warranty_charge2):'Free'}}</b>-->
                                            <!--<br>-->
                                            {{$product->warranty_note2}}</p>
                                    </div>
                                </label>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                    
                    @if($product->productAttibutesVariationGroup()->count() > 0)
                    <div class="smalOtherBox">
                        
                        @include(welcomeTheme().'products.includes.productVariation')
                        
                    </div>
                    @endif
                    <div class="cardItemBox">
                        <div class="row">
                            <div class="col-md-4">
                                <h5>Quantity: </h5>
                                <input data-min="{{$product->productMinQty()}}" 
                                @if($product->productAttibutesVariationGroup()->count() > 0 && $selectVariation)
                                data-max="{{$selectVariation->quantity}}"
                                @else
                                data-max="{{$product->productMaxQty()}}"
                                @endif
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
                        @if($product->productTagsList()->count() > 0)
                            <b>Tag: </b>
                            @foreach($product->productTagsList as $tag)
                            <a href="#" style="color: #464444;">{{$tag->name}}</a>
                            @endforeach
                        @endif
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
                                    {{--
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="question-tab" data-bs-toggle="tab" data-bs-target="#question" type="button" role="tab" aria-controls="question" aria-selected="false">Question</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab" aria-controls="review" aria-selected="false">Review</button>
                                    </li>
                                    --}}
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="table-responsive" style="min-height:300px;">
                                            @if($product->extraAttribute->count() > 0)
                                            <table class="table table-striped speceficate">
                                                <tbody>
                                                    @foreach($product->extraAttribute as $extraAttri)
                                                    <tr>
                                                        <td style="width: 30%; font-weight: bold;">{!!$extraAttri->name!!}</td>
                                                        <td>{!!$extraAttri->content!!}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @else
                                            <span>No Specification</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="product_description" style="min-height:300px;">
                                            @if($product->description)
                                            {!!$product->description!!}
                                            @else
                                            <span>No Description</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    {{--
                                    <div class="tab-pane fade" id="question" role="tabpanel" aria-labelledby="question-tab">
                                        <div class="product_review" style="min-height:300px;">
                                            <div class="wrapper">
                                        		<h3>Write a Question...</h3>
                                        		<form action="#">
                                        			<textarea name="opinion" cols="30" rows="5" placeholder="Your opinion..."></textarea>
                                        			<div class="btn-group">
                                        				<button type="submit" class="btn submit">Submit</button>
                                        				<button class="btn cancel">Cancel</button>
                                        			</div>
                                        		</form>
                                        	</div>
                                        	<hr>
                                            <div class="reviewView">
                                        	    <div class="row">
                                        	        <div class="col-md-2 col-2">
                                        	            <div class="rwviwerImg">
                                        	                <img src="{{asset('public/welcome/images/review.png')}}" alt="Bytebliss" />
                                        	            </div>
                                        	        </div>
                                        	        <div class="col-md-10 col-10">
                                        	            <h3>Client Name</h3>
                                        				<p>
                                        	                Question Here
                                        	            </p>
                                        	        </div>
                                        	    </div>
                                        	</div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                                        <div class="product_review" style="min-height:300px;">
                                            <div class="wrapper">
                                        		<h3>Write a Review...</h3>
                                        		<form action="#">
                                        			<div class="rating">
                                        				<input type="number" name="rating" hidden>
                                        				<i class='fa fa-star' style="--i: 0;"></i>
                                        				<i class='fa fa-star' style="--i: 1;"></i>
                                        				<i class='fa fa-star' style="--i: 2;"></i>
                                        				<i class='fa fa-star' style="--i: 3;"></i>
                                        				<i class='fa fa-star' style="--i: 4;"></i>
                                        			</div>
                                        			<textarea name="opinion" cols="30" rows="5" placeholder="Your opinion..."></textarea>
                                        			<div class="btn-group">
                                        				<button type="submit" class="btn submit">Submit</button>
                                        				<button class="btn cancel">Cancel</button>
                                        			</div>
                                        		</form>
                                        	</div>
                                        	<hr>
                                        	<div class="reviewView">
                                        	    <div class="row">
                                        	        <div class="col-md-2 col-2">
                                        	            <div class="rwviwerImg">
                                        	                <img src="{{asset('public/welcome/images/review.png')}}" alt="Bytebliss" />
                                        	            </div>
                                        	        </div>
                                        	        <div class="col-md-10 col-10">
                                        	            <h3>Client Name</h3>
                                        	            <i class='fa fa-star' style="color: #ff8f00;"></i>
                                        				<i class='fa fa-star' style="color: #ff8f00;"></i>
                                        				<i class='fa fa-star' style="color: #ff8f00;"></i>
                                        				<i class='fa fa-star' style="color: #ff8f00;"></i>
                                        				<i class='fa fa-star' style="color: #ff8f00;"></i>
                                        				<p>
                                        	                Client Review Description
                                        	            </p>
                                        	        </div>
                                        	    </div>
                                        	</div>
                                        </div>
                                    </div>
                                    --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="fullDetailsPartLeft">
                                <h3>Similer Products</h3>
                                @if($relatedProducts->count() > 0)
                                <ul>
                                    @foreach($relatedProducts as $rProduct)
                                    <li>
                                        <a href="{{route('productView',$rProduct->slug?:Str::slug($rProduct->name))}}">
                                            <div class="row">
                                                <div class="col-4">
                                                    <img src="{{asset($rProduct->image())}}" alt="{{$rProduct->name}}">
                                                </div>
                                                <div class="col-8">
                                                    <p style="font-size: 13px;">{{$rProduct->name}}</p>
                                                    <span>
                                                        {{priceFullFormat($rProduct->offerPrice())}}/-
                                                        @if($rProduct->regular_price > $rProduct->offerPrice())
                                                        <del>{{priceFullFormat($rProduct->regular_price)}}/-</del>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @else
                                <span>No Related Product</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@if($bannerGroupTwo->count() > 0)
<div class="twoPartBanner">
    <div class="container-fluid">
        <div class="row">
            @foreach($bannerGroupTwo as $i=>$data)
            <div class="col-md-6">
                {{--<div class="rightOfferBox {{$i % 2 === 0?'':'blackBox'}}">
                    <h1>{!!$data->name!!}</h1>
                    <p>
                       {!!$data->sub_title!!}
                    </p>
                    @if($data->image_link)
                    <a href="{{$data->image_link}}">Shop Now <i class="fa fa-long-arrow-right"></i></a>
                    @endif
                    <div class="newleftArImg">
                        <img src="{{asset($data->image())}}" alt="{{$data->name}}" />
                    </div>
                </div>--}}
                <div class="rightOfferBox {{$i % 2 === 0?'':'blackBox'}}">
                    <a href="{{$data->image_link}}">
                        <img src="{{asset($data->image())}}" alt="{{$data->name}}" />
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif


@include(welcomeTheme().'products.includes.relatedProducts')


@endsection 
@push('js') 

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
                
                var datas = @json($datas);
                
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
                $('.succeMessage').empty().append('<span style="color: #fa5661;padding: 10px;">Insufficient stock, please call {{general()->mobile}} for detail!</span>');
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
@endpush