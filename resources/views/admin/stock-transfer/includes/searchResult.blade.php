@if($searchProducts)
<ul>
	@foreach($searchProducts as $searchProduct)
    	@if($searchProduct->variation_status)
            @foreach($searchProduct->productVariationActiveAttributeItems as $item)
        	<li data-url="{{route('admin.stockTransferAction',['add-product',$invoice->id])}}" data-id="{{$searchProduct->id}}" data-variant="{{$item->id}}">
        	    {!!$item->variationItemValues()!!} -	{{$searchProduct->name}} {{$item->barcode?'| '.$item->barcode:''}}
        	</li>
        	@endforeach
    	@else
    	<li data-url="{{route('admin.stockTransferAction',['add-product',$invoice->id])}}" data-id="{{$searchProduct->id}}" data-variant="">
    		{{$searchProduct->name}} {{$searchProduct->bar_code?'| '.$searchProduct->bar_code:''}}
    	</li>
    	@endif
	@endforeach
	@if($searchProducts->count() ==0)
	<li><span>Not Found</span></li>
	@endif
</ul>
@endif