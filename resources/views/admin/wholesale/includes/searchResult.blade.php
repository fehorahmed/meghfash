@if($searchProducts)
<ul>
	@foreach($searchProducts as $searchProduct)
    	@if($searchProduct->variation_status)
    	    <li data-url="{{route('admin.wholeSalesAction',['add-product',$invoice->id])}}" data-id="{{$searchProduct->id}}" data-variant="">
        		<img src="{{asset($searchProduct->image())}}" style="max-height: 25px;margin-right: 5px;">
        		{{$searchProduct->name}}
        		<br>
        		@foreach($searchProduct->productAttibutesVariationGroup() as $ii=>$attri)
        		   <b>{{$attri->name}}:</b> 
        		   @foreach($searchProduct->productVariationAttributeItemsList()->whereHas('attributeItem')->where('attribute_id',$attri->id)->select('attribute_item_id')->groupBy('attribute_item_id')->get() as $k=>$sku)
        		    {{$sku->attributeItemValue()}} ,
        		   @endforeach
        		@endforeach
        	</li>
    	@else
    	<li data-url="{{route('admin.wholeSalesAction',['add-product',$invoice->id])}}" data-id="{{$searchProduct->id}}" data-variant="">
    		<img src="{{asset($searchProduct->image())}}" style="max-height: 25px;margin-right: 5px;"> {{$searchProduct->name}} {{$searchProduct->bar_code?'| '.$searchProduct->bar_code:''}}
    	</li>
    	@endif
	@endforeach
	@if($searchProducts->count() ==0)
	<li><span>Not Found</span></li>
	@endif
</ul>
@endif