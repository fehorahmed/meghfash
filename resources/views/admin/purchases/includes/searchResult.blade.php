@if($searchProducts)
<ul>
	@foreach($searchProducts as $searchProduct)
    	@if($searchProduct->variation_status)
            @foreach($searchProduct->productVariationActiveAttributeItems as $item)
        	<li data-url="{{route('admin.purchasesAction',['add-product',$invoice->id])}}" data-id="{{$searchProduct->id}}" data-variant="{{$item->id}}">
        	   <img src="{{asset($searchProduct->image())}}" style="max-height: 25px;margin-right: 5px;"> {{$searchProduct->name}} - {!!$item->variationItemValues()!!}
        	</li>
        	@endforeach
    	@else
    	<li data-url="{{route('admin.purchasesAction',['add-product',$invoice->id])}}" data-id="{{$searchProduct->id}}" data-variant="">
    		<img src="{{asset($searchProduct->image())}}" style="max-height: 25px;margin-right: 5px;"> {{$searchProduct->name}}
    	</li>
    	@endif
	@endforeach
	@if($searchProducts->count() ==0)
	<li><span>Not Found</span></li>
	@endif
</ul>
@endif