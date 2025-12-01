@if($product->variation_status)
<table class="table table-bordered areaChargeTable">
	@if($product->productAttibutes->count() > 0)
	<tr>
		@foreach($product->productAttibutes->unique('reff_id') as $pAttri)
		@if($pAttri->attribute)
		<td>
			<select class="form-control form-control-sm variationItemsValue" name="variationItems[]">
				<option value="">Select {{ucfirst($pAttri->attribute->name)}}</option>
				@foreach($pAttri->attribute->attributeItems as $subAttri)
				@if($subAttri->attributeItem)
				<option value="{{$subAttri->attributeItem->id}}">{{$subAttri->attributeItem->name}}</option>
				@endif
				@endforeach
			</select>
		</td>
		@endif
		@endforeach
		<td style="width:100px;min-width: 100px;">
		<span href="" class="btn btn-primary btn-sm variationItemsAdd"
		data-url="{{route('admin.productsUpdateAjax',['variationItemsAdd',$product->id])}}"
		 style="padding:8px 15px;"><i class="fa fa-plus"></i> Add</span>
		</td>
	</tr>
	
	@else
	<tr>
		<td style="text-align:center;color: red;">No Attribute. Please Add Attribute items</td>
	</tr>
	@endif
</table>

<h4>Variation SKU List</h4>
{!!$attriMessage!!}
<table class="table table-bordered areaChargeTable">
	<tr>
		{{--<th>Sku ID</th>--}}
		<th>Sku Name</th>
		<th style="width: 120px;">Price</th>
		<th style="width: 120px;">Qunatity</th>
		<th style="width: 100px;">Action</th>
	</tr>

	@foreach($product->productSkus->unique('sku_id') as $sku)
	<tr>
		{{--<td>{{$product->id}}_ @foreach($sku->skuList as $i=>$list) {{$i==0?'':'_'}}{{$list->attributeItem?$list->attributeItem->name:'Not Found'}} @endforeach
		</td>--}}
		<th>
			<span>
			@foreach($sku->skuList as $i=>$list)
			 {{$i==0?'':'-'}} {{$list->attributeItem?$list->attributeItem->name:'Not Found'}}
			@endforeach
			</span>
		</th>
		<td>
			<input type="number" name="price" placeholder="Price" value="{{$sku->reguler_price}}" style="width: 120px;">
		</td>
		<td><input type="number" name="quantity" placeholder="Quantity" value="{{$sku->stock}}" style="width: 120px;"></td>
		<td>
			<a href="javascript:void(0)" class="btn btn-sm btn-danger variationItemsDelete"
			data-id="{{$sku->sku_id}}"
			data-url="{{route('admin.productsUpdateAjax',['variationItemsDelete',$product->id])}}"
			><i class="fa fa-trash"></i></a>
		</td>
	</tr>
	@endforeach

</table>

@endif