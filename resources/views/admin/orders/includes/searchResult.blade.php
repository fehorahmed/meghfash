@if($searchProducts)
<ul>
	@foreach($searchProducts as $searchProduct)
    	@if($searchProduct->variation_status)
            @foreach($searchProduct->productVariationAttributeItems()->get() as $item)
        	<li data-url="{{route('admin.ordersAction',['add-product',$order->id])}}" data-id="{{$searchProduct->id}}" data-variant="{{$item->id}}">
        	    <img src="{{asset($item->variationItemImage())}}" style="max-height: 25px;margin-right: 5px;"> {!!$item->variationItemValues()!!} -	{{$searchProduct->name}} {{$item->barcode?'| '.$item->barcode:''}}
        	</li>
        	@endforeach
    	@else
    	<li data-url="{{route('admin.ordersAction',['add-product',$order->id])}}" data-id="{{$searchProduct->id}}" data-variant="">
    		<img src="{{asset($searchProduct->image())}}" style="max-height: 25px;margin-right: 5px;"> {{$searchProduct->name}} {{$searchProduct->bar_code?'| '.$searchProduct->bar_code:''}}
    	</li>
    	@endif
	@endforeach
	@if($searchProducts->count() ==0)
	<li><span>Not Found</span></li>
	@endif
</ul>
@endif