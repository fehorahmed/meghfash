@foreach($product->productAttibutesVariationGroup() as $ii=>$attri)
    <div class="row" style="margin:0 -10px;">
        <div class="col-md-3" style="padding:10px;">
            <h5 style="margin-bottom: 5px;font-weight: bold;">{{$attri->name}} : </h5>
        </div>
        <div class="col-md-9" style="padding:0 5px;">
            <ul class="colorList attributeItem">
                @foreach($product->productVariationAttributeItemsList()->whereHas('attributeItem')->where('attribute_id',$attri->id)->select('attribute_item_id')->groupBy('attribute_item_id')->get() as $k=>$sku)
                <li>
                    <!--{{$sku->variationItemCheck($product->id,$attri->id)}}-->
                    <!--{{$sku->attribute_item_id}}-->
                    <input type="radio" class="attributeValue"
                    value="{{$sku->attribute_item_id}}"
                    data-vlueid="{{$sku->attribute_item_id}}"
                    name="option[{{$attri->id}}]"
                    data-name="{{$attri->name}}"
                    data-group="{{$ii}}"
                    id="for_{{$attri->name}}_{{$k+1}}"
                    
                    @if($selectVariation)
                	@foreach($selectVariation->attributeVatiationItems as $item)
                	{{$item->attribute_item_id==$sku->attribute_item_id?'checked':''}}
                	@endforeach
                	@endif
                    
                    required=""
                    >
                    @if($attri->view==2)
                	<label class="colorItem 
                	@if($selectVariation)
                	@foreach($selectVariation->attributeVatiationItems as $item)
                	{{$item->attribute_item_id==$sku->attribute_item_id?'active':''}}
                	@endforeach
                	@endif
                	"
                	data-name="{{$attri->name}}"
                	@if($sku->variationItemImage($product->id))
                    data-image="{{asset($sku->variationItemImage($product->id))}}"
                    @endif
                	for="for_{{$attri->name}}_{{$k+1}}"
                	style="background-color:{{$sku->attributeItemValue()}}">
                	</label>
                	@elseif($attri->view==3)
                	<label class="imageItem
                	@if($selectVariation)
                	@foreach($selectVariation->attributeVatiationItems as $item)
                	{{$item->attribute_item_id==$sku->attribute_item_id?'active':''}}
                	@endforeach
                	@endif
                	"
                	data-name="{{$attri->name}}"
                	@if($sku->variationItemImage($product->id))
                    data-image="{{asset($sku->variationItemImage($product->id))}}"
                    @endif
                	for="for_{{$attri->name}}_{{$k+1}}"
                	><img src="{{asset($sku->attributeItemValue())}}" /> </label>
                	@else
                	<label class="textItem
                	@if($selectVariation)
                	@foreach($selectVariation->attributeVatiationItems as $item)
                	{{$item->attribute_item_id==$sku->attribute_item_id?'active':''}}
                	@endforeach
                	@endif
                	"
                	data-name="{{$attri->name}}"
                	@if($sku->variationItemImage($product->id))
                    data-image="{{asset($sku->variationItemImage($product->id))}}"
                    @endif
                	for="for_{{$attri->name}}_{{$k+1}}"
                	>{{$sku->attributeItemValue()}}</label>
                	@endif
                </li>
                @endforeach
            </ul>
        </div>
    </div>
@endforeach