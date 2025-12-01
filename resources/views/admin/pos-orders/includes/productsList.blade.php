<div class="row" style="margin:0 -1px;">
    @foreach($products as $product)
        @if($product->variation_status)
            @foreach($product->productVariationActiveAttributeItems as $item)
            <div class="col-md-6 col-6" style="padding:1px">
                <div class="addCart" style="border: 1px solid #17a2b8;cursor: pointer;">
                    <div style="position: relative;">
                        <span class="addItemCart" data-url="{{route('admin.posOrdersAction',['addCart',$invoice->id,'product_id'=>$product->id,'barcode'=>$item->barcode])}}">
                            @if($product->warehouseStock($invoice->branch_id,$item->id)==0)
                            <span style="font-size: 16px;color: red;">Stock Out</span>
                            @else
                            <i class="bx bx-plus"></i>
                            @endif
                        </span>
                        <span style="position: absolute;display: inline-block;background: rebeccapurple;color: white;padding: 3px 10px;font-size: 12px;border-radius: 10px;margin: 2px;">
                        {{$product->warehouseStock($invoice->branch_id,$item->id)}} {{$product->weight_unit}}
                        </span>
                        <img src="{{asset($item->variationItemImage())}}" style="height: 155px;width: 100%;">
        
                        <span style="position: absolute;bottom: 0;left: 0;width: 100%;text-align: center;background: #dc3545e0;font-size: 12px;color: white;">
                        <i class="bx bx-barcode"></i> {{$item->barcode}}
                        <span>
        
                    </div>
                    <div style="text-align:center;">
                        <span style="display: block;font-size: 13px;line-height: 14px;height: 30px;overflow: hidden;">{!!$item->variationItemValues()!!} - {{$product->name}}</span>
                        <span style="display: block;background: #17a2b8;font-size: 12px;color: white;padding: 3px 10px;">{{priceFullFormat($item->final_price)}}</span>
                    </div>
                </div>
            </div>
            @endforeach
        @else
        <div class="col-md-6 col-6" style="padding:1px">
            <div class="addCart" style="border: 1px solid #17a2b8;cursor: pointer;">
                <div style="position: relative;">
                    <span class="addItemCart" data-url="{{route('admin.posOrdersAction',['addCart',$invoice->id,'product_id'=>$product->id,'barcode'=>$product->bar_code])}}">
                        @if($product->warehouseStock($invoice->branch_id)==0)
                        <span style="font-size: 16px;color: red;">Stock Out</span>
                        @else
                        <i class="bx bx-plus"></i>
                        @endif
                    </span>
                    <span style="position: absolute;display: inline-block;background: rebeccapurple;color: white;padding: 3px 10px;font-size: 12px;border-radius: 10px;margin: 2px;">
                    {{$product->warehouseStock($invoice->branch_id)}} {{$product->weight_unit}}
                    </span>
                    <img src="{{asset($product->image())}}" style="height: 155px;width: 100%;">
    
                    <span style="position: absolute;bottom: 0;left: 0;width: 100%;text-align: center;background: #dc3545e0;font-size: 12px;color: white;">
                    <i class="bx bx-barcode"></i> {{$product->bar_code}}
                    <span>
    
                </div>
                <div style="text-align:center;">
                    <span style="display: block;font-size: 13px;line-height: 14px;height: 30px;overflow: hidden;">{{$product->name}}</span>
                    <span style="display: block;background: #17a2b8;font-size: 12px;color: white;padding: 3px 10px;">{{priceFullFormat($product->final_price)}}</span>
                </div>
            </div>
        </div>
        @endif
        
    @endforeach
</div>