@extends(welcomeTheme().'layouts.app') @section('title')
<title>{{$product->seo_title?:websiteTitle($product->name)}}</title>
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

.gallery-thumbs .swiper-slide img{
    max-width:100%;
    height: 100%;
    cursor: pointer;
}

.gallery-thumbs .swiper-slide {
    height: 120px;
    text-align: center;
    margin: 10px;
}


ul.colorList{
    display:inline-block;
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


</style>

@endpush 

@section('contents')

<div class="singleProHead">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$product->name}}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="singlePageMainDiv">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5">
                <div class="productGallery">
                     <!-- Swiper and EasyZoom plugins start -->
                      <div class="swiper-container gallery-top">
                        <div class="swiper-wrapper">
                            
                          <div class="swiper-slide easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                            <a href="{{asset($product->image())}}">
                              <img src="{{asset($product->image())}}" alt="{{$product->name}}"/> 
                            </a>
                          </div>
                          @foreach($product->galleryFiles as $gallery)
                          <div class="swiper-slide easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                            <a href="{{asset($gallery->image())}}">
                              <img src="{{asset($gallery->image())}}" alt="{{$product->name}}"/>
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
                            <img src="{{asset($product->image())}}" alt="">
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
            </div>
             <div class="col-md-7">
                <div class="productDetails">
                    
                    <h3>{{$product->name}}</h3>
                    @if($product->brand)
                    <span>Brand: <b>{{$product->brand->name}}</b></span>
                    @endif
                    <p>Price: 
                    
                    <b>
                    {{priceFullFormat($product->offerPrice())}}/-
                    @if($product->regular_price > $product->offerPrice())
                    <del>{{priceFullFormat($product->regular_price)}}/-</del>
                    @endif
                    </b>
                    </p>
                    <div class="descrBox">
                        {!!$product->short_description!!}
                    </div>
                    <div class="smalinfoBox">
                        <div class="row">
                            @if($product->sku_code)
                            <div class="col-md-4">
                                <h6>SKU <b>{{$product->sku_code}}</b></h6>
                            </div>
                            @endif
                            <div class="col-md-3">
                                <h6 class="wishlistCompareUpdate" data-url="{{route('wishlistCompareUpdate',[$product->id,'wishlist'])}}" style="cursor: pointer;"><i class="fa {{$product->isWl()?'fa-heart':'fa-heart-o'}}"></i> Wishlist</h6>
                            </div>
                            @if($product->warranty_note)
                            <div class="col-md-5">
                                <h6>{{$product->warranty_note}}</h6>
                            </div>
                            @endif
                        </div>
                    </div>
                    <form class="addToCartForm" action="{{route('addToCart',$product->id)}}" method="post">
                        @csrf
                    
                    <div class="smalOtherBox">
                        <div class="row">
                            @foreach($product->productAttibutesGroup() as $attri)
                            <div class="col-md-4">
                    
                                <h5 style="margin-bottom: 5px;">{{$attri->attribute->name}}: </h5>
                                
                                <ul class="colorList attributeItem">
                                    @foreach($product->productAttibutes()->whereHas('attributeItem')->where('reff_id',$attri->reff_id)->get() as $sku)
                                    <li>
                                        @if($attri->attribute->view==2)
                                    	<span class="colorItem" style="background-color:{{$sku->attributeItemValue()}}">
                                    	</span>
                                    	@elseif($attri->attribute->view==3)
                                    	<span class="imageItem"><img src="{{asset($sku->attributeItemValue())}}" /> </span>
                                    	@else
                                    	<span class="textItem">{{$sku->attributeItemValue()}}</span>
                                    	@endif
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endforeach
                            
                            <div class="col-md-4">
                                <h5>Stock: 
                                @if($product->stockStatus())
                                <b><i class="fa-regular fa-circle"></i> Available</b>
                                @else
                                <b style="color: red;"> Stock Out</b>
                                @endif
                                
                                </h5>
                            </div>
                            @if($product->productTagsList()->count() > 0)
                            <div class="col-md-4">
                                <h5>Tag: </h5>
                                <ul class="tagList">
                                    @foreach($product->productTagsList as $tag)
                                    <li><a href="#">{{$tag->name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="cardItemBox">
                        <div class="row">
                            <div class="col-md-4">
                                <h5>Quantity: </h5>
                                <input data-min="1" data-max="10" type="text" name="quantity" value="1" readonly="true" />
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
                                            @if($product->extraAttribute->count() > 0)
                                            <table class="table table-striped">
                                                <tbody>
                                                    @foreach($product->extraAttribute as $extraAttri)
                                                    <tr>
                                                        <td style="width: 30%; font-weight: bold;">{{$extraAttri->name}}</td>
                                                        <td>{{$extraAttri->content}}</td>
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
                                                    <p>{{$rProduct->name}}</p>
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
                <div class="rightOfferBox {{$i % 2 === 0?'':'blackBox'}}">
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
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@if($recommendProducts->count() > 0)
<div class="relatedProductMaindDiv">
    <div class="container-fluid">
        <h2>You may also like</h2>
        <div class="productsLists">
            <div class="row">
                @foreach($recommendProducts as $product)
                <div class="col-md-3">
                    @include(welcomeTheme().'.products.includes.productCard')
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

@endsection 
@push('js') 

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
        
        $(document).on('click','.addToCartSubmit',function(){
            
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
                    $('.succeMessage').empty().append('<span style="display: inline-block;background: #0ba350;padding: 5px 15px;border-radius: 5px;min-width: 250px;margin-top: 10px;color: white;"><b>Success:</b> Add To Cart Successfully Done</span>');
                    setTimeout(function() {
                        $('.succeMessage').empty();
                    }, 2000);
                    
                }
            })
            .fail(function () {

            });
                
        });
        
        $(".quantityValue").on("click", function(ev) {
          var currentQty = $('input[name="quantity"]').val();
          var qtyDirection = $(this).data("direction");
          var newQty = 0;
          
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
          
          if (newQty > 0) {
            newQty = newQty.toString();
            $('input[name="quantity"]').val(newQty);
          }
          else {
            $('input[name="quantity"]').val("1");
          }
        });
        
    });
</script>
@endpush