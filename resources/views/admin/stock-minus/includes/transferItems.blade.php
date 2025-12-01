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
				{{$product->warehouseStock($invoice->branch_id,$item->variant_id)}}
				@else
				0
				@endif
				{{$item->weight_unit}}
				</td>
				<td style="padding:3px;">
					<input type="text"  value="{{$item->quantity?:''}}"
					data-url="{{route('admin.stockMinusAction',['item-quantity',$invoice->id])}}"
					data-id="{{$item->id}}" class="form-control form-control-sm itemUpdatePurchase" placeholder="Enter Quantity" style="text-align: center;"
					>
				</td>
				<td style="text-align: center;">
    				<span class="badge badge-danger itemRemove" data-url="{{route('admin.stockMinusAction',['remove-item',$invoice->id])}}" data-id="{{$item->id}}" style="cursor:pointer;"> <i class="fa fa-trash"></i> </span>
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