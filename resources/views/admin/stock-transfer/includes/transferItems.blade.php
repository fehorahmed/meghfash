{!!$message!!}
<div class="table-responsive">                 
		<table class="table table-bordered">
			<tr>
				<th style="min-width:50px;width:50px;">SL</th>
				<th>Product Name</th>
				<th style="min-width:100px;width:100px;">Stock</th>
				<th style="min-width:100px;width:100px;">Quantity</th>
				<th style="min-width:60px;width:60px;">
					<i class="fa fa-trash"></i>
				</th>
			</tr>
			@foreach($invoice->items as $i=>$item)
			<tr>
				<td>{{++$i}}</td>
				<td>
				    @if(count($item->itemAttributes()) > 0)
					    @foreach($item->itemAttributes() as $i=>$attri)
					        @if(isset($attri['title']) && isset($attri['value']))
                            {{$i==0?'':','}} <span><b>{{$attri['title']}}</b> : {{$attri['value']}}</span>
                            @endif
                        @endforeach
                        -
					@endif
				    {{$item->product_name}}
				@if($item->barcode)
				    / <b>Barcode:</b> {{$item->barcode}}
				@endif
				</td>
				<td>
				@if($product=$item->product)
				{{$product->warehouseStock($invoice->user_id,$item->variant_id)}}
				@else
				0
				@endif
				{{$item->weight_unit}}
				</td>
				<td style="padding:3px;">
					<input type="text"  value="{{$item->quantity?:''}}"
					data-url="{{route('admin.stockTransferAction',['item-quantity',$invoice->id])}}"
					data-id="{{$item->id}}" class="form-control form-control-sm itemUpdatePurchase" placeholder="Enter Quantity" style="text-align: center;"
					>
				</td>
				<td style="text-align: center;">
    				<span class="badge badge-danger itemRemove" data-url="{{route('admin.stockTransferAction',['remove-item',$invoice->id])}}" data-id="{{$item->id}}" style="cursor:pointer;"> <i class="fa fa-trash"></i> </span>
				</td>
			</tr>
			@endforeach
			@if($invoice->items->count()==0)
			<tr>
			    <td colspan="5" style="text-align: center;">No Item found</td>
			</tr>
			@endif
			<tr>
				<th colspan="3" style="text-align: right;">Total QTY:</th>
				<td style="text-align: center;">
					{{priceFormat($invoice->items->sum('quantity'))}}
				</td>
				<td></td>
			</tr>
			<!--<tr>-->
			<!--	<th colspan="5" style="text-align: right;">Shipping Charge</th>-->
			<!--	<td >-->
			<!--		<input type="number" -->
			<!--		style="text-align: center;"-->
			<!--		data-id="{{$invoice->id}}"-->
			<!--		data-url="{{route('admin.purchasesAction',['shipping-charge',$invoice->id])}}"-->
			<!--		class="form-control form-control-sm itemUpdatePurchase" placeholder="0" step="any" value="{{$invoice->shipping_charge > 0 ?$invoice->shipping_charge:''}}">-->
			<!--	</td>-->
			<!--	<td>-->
					
			<!--	</td>-->
			<!--</tr>-->
			<!--<tr>-->
			<!--	<th colspan="5" style="text-align: right;">Tax(%)</th>-->
			<!--	<td style="text-align: center;">-->
			<!--		<div class="input-group">-->
			<!--			<input type="number" -->
			<!--			data-id="{{$invoice->id}}"-->
			<!--			data-url="{{route('admin.purchasesAction',['tax-charge',$invoice->id])}}"-->
			<!--			class="form-control form-control-sm itemUpdatePurchase" placeholder="0" step="any" value="{{$invoice->tax}}">-->
			<!--			<input type="text" readonly="" style="text-align: center;" class="form-control form-control-sm" placeholder="0" value="{{$invoice->tax_amount}}">-->
			<!--		</div>-->
			<!--	</td>-->
			<!--	<td>-->
			<!--	</td>-->
			<!--</tr>-->
			<!--<tr>-->
			<!--	<th colspan="5" style="text-align: right;">(-) Discount</th>-->
			<!--	<td style="text-align: center;">-->
			<!--	<input type="text" readonly=""  style="text-align: center;" class="form-control form-control-sm" placeholder="0" step="any" value="{{$invoice->discount_amount}}">-->
			<!--		<div class="input-group">-->
			<!--			<select -->
			<!--			data-id="{{$invoice->id}}"-->
			<!--			data-url="{{route('admin.purchasesAction',['discount-type',$invoice->id])}}"-->
			<!--			class="form-control form-control-sm itemUpdatePurchase">-->
			<!--				<option value="0" {{$invoice->discount_type=='percantage'?'selected':''}} >Percantage(%)</option>-->
			<!--				<option value="1" {{$invoice->discount_type=='flat'?'selected':''}}>Flat({{general()->currency}})</option>-->
			<!--			</select>-->
			<!--			<input type="text" -->
			<!--			data-id="{{$invoice->id}}"-->
			<!--			data-url="{{route('admin.purchasesAction',['discount',$invoice->id])}}"-->
			<!--			class="form-control form-control-sm itemUpdatePurchase" step="any" placeholder="0" value="{{$invoice->discount > 0 ?$invoice->discount:'' }}">-->
			<!--		</div>-->
			<!--	</td>-->
			<!--	<td>-->
			<!--	</td>-->
			<!--</tr>-->
			<!--<tr>-->
			<!--	<th colspan="5" style="text-align: right;">Grand Total</th>-->
			<!--	<td style="text-align: center;">-->
			<!--		{{priceFormat($invoice->grand_total)}}-->
			<!--	</td>-->
			<!--	<td></td>-->
			<!--</tr>-->
			<!--<tr>-->
			<!--	<th colspan="5" style="text-align: right;">Paid Amount</th>-->
			<!--	<td style="text-align: center;">-->
			<!--		{{priceFormat($invoice->paid_amount)}}-->
			<!--	</td>-->
			<!--	<td></td>-->
			<!--</tr>-->
			<!--<tr>-->
			<!--	<th colspan="5" style="text-align: right;">Due Amount</th>-->
			<!--	<td style="text-align: center;">-->
			<!--		{{priceFormat($invoice->due_amount)}}-->
			<!--	</td>-->
			<!--	<td></td>-->
			<!--</tr>-->
			<!--@if($invoice->extra_amount)-->
			<!--<tr>-->
			<!--	<th colspan="5" style="text-align: right;">Return Amount</th>-->
			<!--	<td style="text-align: center;">-->
			<!--		{{priceFormat($invoice->extra_amount)}}-->
			<!--	</td>-->
			<!--	<td></td>-->
			<!--</tr>-->
			<!--@endif-->
		</table>
	</div>

	<div class="row">
		<div class="col-md-8">

		</div>
		<div class="col-md-4">
		    @if($invoice->order_status=='delivered')
			    <input type="hidden" value="delivered" name="status">
    			@if($invoice->items->count() > 0)
    			<div class="form-group">
    				<button type="sumit" class="btn btn-block btn-info submitPurchase" >Update</button>
    			</div>
    			@endif
    		@else
    			<div class="form-group mb-1">
    				<label>Order Status</label>
    				
    				<select 
    				class="form-control" name="status" required="">
    					<option value="pending" {{$invoice->order_status=='pending'?'selected':''}}>Pending</option>
    					<option value="delivered" {{$invoice->order_status=='delivered'?'selected':''}}>Delivered</option>
    					<option value="cancelled" {{$invoice->order_status=='cancelled'?'selected':''}}>Cancelled</option>
    				</select>
    				@if ($errors->has('status'))
    				<p style="color: red; margin: 0;">{{ $errors->first('status') }}</p>
    				@endif
    			</div>
    			@if($invoice->items->count() > 0)
    			<div class="form-group">
    				<button type="sumit" class="btn btn-block btn-success submitPurchase" >Submit</button>
    			</div>
    			@endif
			@endif

		</div>
	</div>