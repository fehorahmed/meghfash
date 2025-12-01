
<div class="ProAttributesItems">
    @if($product->productAttibutes->count() > 0)
    <span class="btn"  style="border: 1px solid #e7e3e3;margin-bottom: 10px;background: #f7f7f7;" data-toggle="modal" data-target="#AddAttributes" >Edit Attributes</span>
    <br>
    <div class="table-responsive">
        <table class="table table-bordered">
            @foreach($product->productAttibutes()->whereHas('attribute')->select('reff_id', 'drag')->groupBy('reff_id', 'drag')->get() as $attri)
            <tr>
                <th style="width: 200px;min-width: 200px;vertical-align: middle;">{{$attri->attribute->name}}</th>
                <td style="padding: 3px;min-width:300px;">
                    @foreach($product->productAttibutes()->whereHas('attributeItem')->where('reff_id',$attri->reff_id)->get() as $item)
                    <span style="vertical-align: middle;border: 1px solid #dfd9d9;display: inline-block;margin-bottom: 5px;padding: 5px 10px;border-radius: 5px;">{{$item->attributeItem?$item->attributeItem->name:'Not Found'}}</span>
                    @endforeach
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    @else
    <span class="btn"  style="border: 1px solid #e7e3e3;margin-bottom: 10px;background: #f7f7f7;" data-toggle="modal" data-target="#AddAttributes" >Add Attributes</span>
    <br>
    <span style="color: #b7b7b7;">
        Adding new attributes helps the product to have many attributes.
    </span>
    @endif
</div>
<hr>

<div class="ProVariationAttribute">
    @if($product->productVariationAttibutes->count() > 0)
    <span class="btn" style="border: 1px solid #e7e3e3;margin-bottom: 10px;background: #e8edef;"  data-toggle="modal" data-target="#AddAttributesVaritaionItem" >Add Variation Item</span>
    @if($attri =$product->productVariationAttibutes()->where('reff_id','68')->first())
    <span class="btn" style="border: 1px solid #83fcff;margin-bottom: 10px;background: #83fcff;margin-left: 10px;"  data-toggle="modal" data-target="#EditAttributesVaritaionList" >Edit Variation Image</span>
    @endif
    <span class="btn deleteBtnStatus variationItemsDeleteBtn" 
    data-url="{{route('admin.productsUpdateAjax',['attributesItemDeletesIds',$product->id])}}"
    style="border: 1px solid #e7e3e3;margin-bottom: 10px;background: #ff425c;color: white;display:none;"  
    onclick="return confirm('Are you want to variation item delete?')">
    <i class="fa fa-trash"></i></span>
    <br>
    <div class="attributErrorMsg">
        {!!$attriMessage!!}
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th styl="min-width: 50px;width: 50px;text-align:center;">
                    <label style="cursor: pointer; margin-bottom: 0;"> 
                    @if($product->productVariationAttributeItems()->count() > 0)
                    <input class="checkbox" type="checkbox" class="form-control" id="checkall" />
                    @endif
                    ID </label>
                </th>
                <th style="min-width: 70px;text-align:center;">Image</th>
                @foreach($product->productVariationAttibutes as $att)
                <th style="min-width: 120px;width: 120px;" >{{$att->attribute?$att->attribute->name:'Not found'}}</th>
                @endforeach
                <th style="min-width: 120px;width: 120px;">Price</th>
                <th style="min-width: 100px;width: 100px;text-align:center;">Qty</th>
                <th style="min-width: 45px;width: 45px;"></th>
            </tr>
            @foreach($product->productVariationAttributeItems()->get() as $vi=>$variationItem)
            <tr>
                <td style="vertical-align: middle;padding:5px;text-align:center;">
                <input class="checkbox" type="checkbox" name="checkid[]" value="{{$variationItem->id}}" />
                    {{$vi+1}}
                </td>
                <td style="vertical-align: middle;padding:5px;text-align:center;">
                    <img src="{{asset($variationItem->variationItemImage())}}" style="max-width:100px;max-height:40px;">
                </td>
                @foreach($product->productVariationAttibutes as $att)
                @if($attValue =$variationItem->attributeVatiationItems()->where('attribute_id',$att->reff_id)->first())
                <td style="vertical-align: middle;padding:5px;">
                    {{$attValue->attribute_item_value}}
                </td>
                @endif
                @endforeach
                <td style="vertical-align: middle;padding:5px;">
                    {{priceFullFormat($variationItem->final_price)}}
                    @if($variationItem->barcode)
                    <a href="{{route('admin.productsAction',['barcode',$product->id,'variation_id'=>$variationItem->id])}}" target="_blank" style="color: #ff864a;font-size: 12px;font-weight: bold;display: block;">Print  <i class="fa fa-barcode" style="color: black;"></i> </a>
                    @endif
                </td>
                <td style="vertical-align: middle;padding:5px;text-align:center;">{{$variationItem->quantity}}
                @if($variationItem->stock_status)
                <span style="color: #11a578;font-size: 12px;font-weight: bold;display: block;">Stock In</span>
                @else
                <span style="color: #ff0000;font-size: 12px;font-weight: bold;display: block;">Stock Out</span>
                @endif
                </td>
                <td style="padding: 5px;vertical-align: middle;">
                    <span class="btn btn-sm btn-info btn-block" data-toggle="modal" data-target="#editAttributesVaritaionItem_{{$variationItem->id}}" ><i class="fa fa-edit"></i></span>
                </td>
            </tr>
            @endforeach

            @if($product->productVariationAttributeItems()->get()->count()==0)
            <tr>
                <td colspan="{{5+$product->productVariationAttibutes->count()}}"  style="text-align:center;color: #afafaf;"> No Variation Item</td>
            </tr>
            @endif
        </table>
    </div>
    
    @else
    <span class="btn" style="border: 1px solid #e7e3e3;margin-bottom: 10px;background: #e8edef;"  data-toggle="modal" data-target="#AddAttributesVaritaion" >Add Variation Attributes</span>
    <br>
    <span style="color: #b7b7b7;">
         Adding new <b>Variation</b> attributes helps the product to have many price Variation.
    </span>
    <br>
    <br>
    @endif
</div>


@if($product->productVariationAttibutes->count() > 0)
<!-- Modal -->
<div class="modal fade text-left" id="AddAttributesVaritaionItem" tabindex="-1" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Variation Item</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times; </span>
                </button>
            </div>
            <div class="modal-body">
                
                <div class="varitaionItemproduct">
                    <div class="row">
                        @foreach($product->productVariationAttibutes as $atti)
                        <div class="col-md-4 form-group">
                            <label>{{$atti->attribute?$atti->attribute->name:''}}* <span class="errorMsg"></span></label>
                            <select class="form-control attributeAddItemIds" name="itemsIds[]" >
                                <option value="">Select Option</option>
                                @if($attribute =$atti->attribute)
                                @foreach($attribute->subAttributes as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        @endforeach
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Regular Price</label>
                            <input type="number" class="form-control variationPriceUpdate variation_price_0" data-id="0" name="variation_price"  value="{{$product->regular_price}}" placeholder="Price">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Discount</label>
                            <div class="input-group">
                                <input type="number" class="form-control variationPriceUpdate variation_discount_0" data-id="0" name="variation_discount"  value="{{$product->discount}}" placeholder="Discount">
                                <select class="form-control variationPriceUpdate variation_discount_type_0" name="variation_discount_type" data-id="0" >
                                    <option value="percent" {{$product->discount_type=='percent'?'selected':''}} >Percent(%)</option>
                                    <!--<option value="flat" {{$product->discount_type=='flat'?'selected':''}}>Flat({{general()->currency}})</option>-->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Sale Price</label>
                            <input type="number" class="form-control final_price_0" data-id="0" readonly=""  value="{{$product->final_price}}" placeholder="Sale Price">
                        </div>
                    </div>
                    <!--<div class="row">-->
                    <!--    <div class="col-md-6 form-group">-->
                    <!--        <div class="input-group">-->
                    <!--            <span>Warrenty Charge 1</span>-->
                    <!--            <input type="number" class="form-control form-control-sm" name="variation_warrenty_charge"  placeholder="Warrenty Charge">-->
                    <!--        </div>-->
                    <!--        <div class="input-group">-->
                    <!--            <span>Warrenty Charge 2</span>-->
                    <!--            <input type="number" class="form-control form-control-sm" name="variation_warrenty_charge2"  placeholder="Warrenty Charge">-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                    
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Purchase Price <small>(50%)</small></label>
                            <input type="number" class="form-control purchase_price_0" name="variation_purchase_price" value="{{$product->purchase_price}}"  placeholder="Purchase price">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Wholesale Price <small>(40%)</small></label>
                            <input type="number" class="form-control wholesale_price_0" name="variation_wholesale_price" value="{{$product->wholesale_price}}"  placeholder="Wholesale price">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Quantity</label>
                            <input type="number" class="form-control" readonly="" value="{{$product->quantity}}" placeholder="Quantity">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Stock Status</label>
                            <select class="form-control" name="variation_stock">
                                <option value="1" {{$product->stock_status==1?'selected':''}} >Stock In</option>
                                <option value="0" {{$product->stock_status==0?'selected':''}}>Stock Out</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Barcode</label>
                            <div class="input-group">
                                <input type="text" class="form-control variation_barcode" name="variation_barcode" value="{{Carbon\Carbon::now()->format('ymd').$product->id.rand(1111,9999)}}" placeholder="Barcode">
                                <!--<div class="input-group-append">-->
                                <!--    <span class="input-group-text generate_Barcode" style="cursor:pointer;" data-id="0"><i class="fa fa-refresh"></i></span>-->
                                <!--</div>-->
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <span class="btn btn-success variationItemAttribute" data-url="{{route('admin.productsUpdateAjax',['attributesVariationItemAdd',$product->id])}}" >Save Continue</span>
                <br>
            </div>
        </div>
    </div>
</div>

@if($attri =$product->productVariationAttibutes()->where('reff_id','68')->first())
<!-- Modal -->
<div class="modal fade text-left" id="EditAttributesVaritaionList" tabindex="-1" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Add Variation Images</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times; </span>
                </button>
            </div>
            <div class="modal-body">
                    <p>
                        {{$attri->attribute?$attri->attribute->name:'Not Found'}}
                    </p>
                    @if($product->productVariationAttributeItemsValues()->where('reff_id',$attri->reff_id)->count() > 0)
                    <div class="variationItemImageUpdateform">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 150px;min-width: 150px;">Item</th>
                                    <th style="min-width:200px;">Image</th>
                                </tr>
                                @foreach($product->productVariationAttributeItemsValues()->where('reff_id',$attri->reff_id)->get() as $attriValue)
                                <tr>
                                    <td>{{$attriValue->attributeItem?$attriValue->attributeItem->name:'Not Found'}}
                                    <input type="hidden" name="valueItems[]" value="{{$attriValue->id}}">
                                    </td>
                                    <td style="padding:2px;">
                                        <div class="input-group">
                                            <input type="file" name="variation_image_{{$attriValue->id}}" class="form-control changeImage" data-image=".variaValueImage_{{$attriValue->id}}" accept="image/*" >
                                            <div style="width: 80px;text-align: center;">
                                                <img src="{{asset($attriValue->variationImage())}}" class="variaValueImage_{{$attriValue->id}}" style="height: 40px;max-width: 100%;">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <br>
                        <span class="btn btn-success variationItemImageUpdate" data-url="{{route('admin.productsUpdateAjax',['attributesVariationImageUpdate',$product->id])}}" >Save Continue</span>
                        <br>
                    </div>
                    @else
                    <p>
                        Please add variation item colors. 
                    </p>
                    @endif
                    

                <br>
            </div>
        </div>
    </div>
</div>
@endif

@foreach($product->productVariationAttributeItems()->get() as $itemEdit)
<!-- Modal -->
<div class="modal fade text-left" id="editAttributesVaritaionItem_{{$itemEdit->id}}" tabindex="-1" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Variation Item</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times; </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="varitaionItemproduct_{{$itemEdit->id}}">
                    <input type="hidden" value="{{$itemEdit->id}}" name="variation_id">
                    <div class="row">
                        @foreach($product->productVariationAttibutes as $atti)
                        <div class="col-md-4 form-group">
                            <label>{{$atti->attribute?$atti->attribute->name:''}}*</label>
                            <select class="form-control" name="itemsIds[]" >
                                <option value="">Select Option</option>
                                @if($attribute =$atti->attribute)
                                @foreach($attribute->subAttributes as $item)
                                <option value="{{$item->id}}"
                                
                                @foreach($itemEdit->attributeVatiationItems()->where('attribute_id',$atti->reff_id)->get() as $checkItem)
                                    {{$checkItem->attribute_item_id==$item->id?'selected':''}}
                                @endforeach

                                >{{$item->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        @endforeach
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Regular Price</label>
                            <input type="number" class="form-control variationPriceUpdate variation_price_{{$itemEdit->id}}" data-id="{{$itemEdit->id}}" name="variation_price"  value="{{$itemEdit->reguler_price}}" placeholder="Price">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Discount</label>
                            <div class="input-group">
                                <input type="number" class="form-control variationPriceUpdate variation_discount_{{$itemEdit->id}}" data-id="{{$itemEdit->id}}" name="variation_discount"  value="{{$itemEdit->discount}}" placeholder="Discount">
                                <select class="form-control variationPriceUpdate variation_discount_type_{{$itemEdit->id}}" data-id="{{$itemEdit->id}}" name="variation_discount_type" >
                                    <option value="percent" {{$itemEdit->discount_type=='percent'?'selected':''}} >Percent(%)</option>
                                    <!--<option value="flat" {{$itemEdit->discount_type=='flat'?'selected':''}} >Flat({{general()->currency}})</option>-->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Sale Price</label>
                            <input type="number" class="form-control final_price_{{$itemEdit->id}}" data-id="{{$itemEdit->id}}" readonly=""  value="{{$itemEdit->final_price}}" placeholder="Sale Price">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Purchase Price <small>(50%)</small></label>
                            <input type="number" class="form-control purchase_price_{{$itemEdit->id}}" name="variation_purchase_price" value="{{$itemEdit->purchase_price}}"  placeholder="Purchase price">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Wholesale Price <small>(40%)</small></label>
                            <input type="number" class="form-control wholesale_price_{{$itemEdit->id}}" name="variation_wholesale_price" value="{{$itemEdit->wholesale_price}}"  placeholder="Wholesale price">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Quantity</label>
                            <input type="number" class="form-control" readonly="" value="{{$itemEdit->quantity}}" placeholder="Quantity">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Stock Status</label>
                            <select class="form-control" name="variation_stock">
                                <option value="1" {{$itemEdit->stock_status?'selected':''}} >Stock In</option>
                                <option value="0" {{$itemEdit->stock_status==false?'selected':''}} >Stock Out</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Barcode</label>
                            <div class="input-group">
                                <input type="text" class="form-control variation_barcode" name="variation_barcode"
                                {{$itemEdit->barcode?'readonly':''}}
                                value="{{$itemEdit->barcode?:Carbon\Carbon::now()->format('ymd').$product->id.rand(1111,9999)}}" placeholder="Barcode">
                                <!--<div class="input-group-append">-->
                                <!--    <span class="input-group-text generate_Barcode" style="cursor:pointer;" data-id="{{$itemEdit->id}}"><i class="fa fa-refresh"></i></span>-->
                                <!--</div>-->
                            </div>
                        </div>
                    </div>
                </div>
                
                <br>
                <br>
                <span class="btn btn-success variationItemAttributeUpdate" data-id="{{$itemEdit->id}}" data-url="{{route('admin.productsUpdateAjax',['attributesVariationItemUpdate',$product->id])}}" >Save Continue</span>
                <br>
            </div>
        </div>
    </div>
</div>
@endforeach

@endif

<!-- Modal -->
<div class="modal fade text-left" id="AddAttributesVaritaion" tabindex="-1" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Select Variation Attributes</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times; </span>
                </button>
            </div>
            <div class="modal-body">
                @foreach($variationAttributes->get() as $attri)
                <label style="margin: 5px;border: 1px solid #dfd9d9;padding: 5px 10px;border-radius: 5px;">
                    <input type="checkbox" value="{{$attri->id}}"  name="attributesVariationAddItemId[]"> {{$attri->name}}
                </label>
                @endforeach
                <br><br>
                <span class="btn btn-success attributesVariationAddItem" data-url="{{route('admin.productsUpdateAjax',['attributesVariationItemAddIds',$product->id])}}" >Save Continue</span>
                <br>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade text-left" id="AddAttributes" tabindex="-1" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Select Attributes</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times; </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="attributeAreaSelect" style="height: 300px;overflow: auto;margin-bottom: 10px;">
                    <div class="row m-0">
                        @foreach($attributes->get() as $attri)
                        <div class="col-md-12">
                            <div class="attributeTitle">
                                <p style="margin-bottom: 5px; font-weight: bold;">
                                    {{$attri->name}}
                                </p>
                                <ul style="list-style: none; background: #f6f8fb; padding: 10px; border: 1px solid #dce1e7; border-radius: 5px;">
                                    @foreach($attri->subCtgs as $item)
                                        <li style="display:inline-block;">
                                            <label style="margin:0;margin-right: 10px;">
                                                <input type="checkbox" value="{{$item->id}}"  name="attributesAddItemId[]"
                                                
                                                @foreach($product->productAttibutes()->whereHas('attributeItem')->where('reff_id',$attri->id)->get() as $itm)
                                                {{$itm->parent_id==$item->id?'checked':''}}
                                                @endforeach
                                                
                                                > {{$item->name}}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <span class="btn btn-success attributesAddItem" data-url="{{route('admin.productsUpdateAjax',['attributesItemAddIds',$product->id])}}" >Save Continue</span>
            </div>
        </div>
    </div>
</div>