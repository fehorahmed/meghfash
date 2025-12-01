<div class="productGridBox">
    <a href="{{route('productView',$product->slug?:Str::slug($product->name))}}" class="imgPro"><img src="{{asset($product->image())}}" alt="{{$product->name}}" /></a>
    <span>{{$product->brand?$product->brand->name:''}}</span>
    <a href="{{route('productView',$product->slug?:Str::slug($product->name))}}" class="titlePro">{{Str::limit($product->name,50)}}</a>
    <h5>
        {{priceFullFormat($product->offerPrice())}}/-
        @if($product->regularPrice() > $product->offerPrice())
        <del>{{priceFullFormat($product->regularPrice())}}/-</del>
        @endif
    </h5>
    <div class="row" style="margin:0 -5px">
        <div class="col-md-6" style="0 5px;">
            <a 
            @if($product->variation_status)
            href="{{route('productView',$product->slug?:Str::slug($product->name))}}"
            @else
            href="{{route('addToCart',[$product->id,'orderNow'=>'order'])}}"
            @endif
            class="buyBtn">Buy Now</a>
        </div>
        <div class="col-md-6" style="0 5px;">
            <a 
            @if($product->variation_status)
            href="{{route('productView',$product->slug?:Str::slug($product->name))}}"
            @else
            href="javascript:void(0)"
            @endif
            data-id="{{$product->id}}" data-url="{{route('addToCart',$product->id)}}" 
            class="addCart {{$product->variation_status?'':'ajaxaddToCart'}}"
            
            >Add To Cart</a>
        </div>
    </div>
</div>