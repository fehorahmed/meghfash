{!!$message!!}
<table class="table table-sm table-bordered table-striped">
        <thead>
            <tr>
                <th style="min-width: 50px;width:50px;padding: 8px 10px;">SL</th>
                <th style="min-width: 70px;width:50px">Image</th>
                <th style="min-width: 300px;">Items</th>
                <th style="min-width: 120px;width: 120px;">QTY</th>
                <th style="min-width: 120px;width: 120px;">Price</th>
                <th style="width: 250px;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $i=>$item)
            <tr>
                <td style="padding: 8px 10px;">{{ $i+1 }}</td>
               
                <td>
                    <img src="{{asset($item->image())}}" style="max-height: 40px;max-width: 100%;">
                </td>
                
                <td>
                  <div><strong>{{ $item->product_name }}</strong></div>
                    <small>
                        ID:{{ $item->product_id }}
    					@if(count($item->itemAttributes()) > 0)
    					    @foreach($item->itemAttributes() as $i=>$attri)
    					        @if(isset($attri['title']) && isset($attri['value']))
                                {{$i==0?'':','}} <span>{{$attri['title']}} : {{$attri['value']}}</span>
                                @endif
                            @endforeach
    					@endif
    					
    					@if($item->warranty_note)
    					<br>
    					 <small style="font-size: 12px;">{{$item->warranty_note}} -  <b>{{$item->warranty_charge > 0?priceFullFormat($item->warranty_charge):'Free'}}</b></small>
    					@endif
                        
                        
                        @if($item->sku_code)
                        , SKU: {{ $item->sku_code }} 
                        @endif
                        
                        @if($item->weight_unit && $item->weight_amount)
                        , Weight: {{ $item->weight_amount }} {{ $item->weight_unit }} 
                        @endif
                        
                        @if($item->dimensions_unit && $item->dimensions_length || $item->dimensions_width  || $item->dimensions_height )
                        , Dimensions($item->dimensions_unit): L-{{ $item->dimensions_length }} W-{{ $item->dimensions_width }} H-{{ $item->dimensions_height }}
                        @endif
                    </small>
                    
                    @if($item->returnItems->count() > 0)
                    @if($item->return_type)
                    <span class="badge badge-info" style="background: #ff9800;">Return</span>
                    @else
                    <span class="badge badge-primary" style="background: #ff5722;">Cancel</span>
                    @endif
                    @endif
                    
                    <b>Stock:</b>
                    @if($product=$item->product)
    				{{$product->warehouseStock($order->branch_id,$item->variant_id)}}
    				@else
    				0
    				@endif
                    
                </td>
                 <td style="padding: 8px;">
                    <input type="number" name="quantity" placeholder="Enter quantity" value="{{$item->quantity}}" data-url="{{route('admin.ordersAction',['item-quantity',$order->id])}}" data-id="{{$item->id}}" class="form-control itemUpdatePurchase">
                 </td>
                 <td style="padding: 8px;">
                    <input type="number" name="price" placeholder="Enter Price" value="{{$item->price}}" data-url="{{route('admin.ordersAction',['item-price',$order->id])}}" data-id="{{$item->id}}" class="form-control itemUpdatePurchase">
                 </td>
                 <td>
                  {{ priceFullFormat($item->total_price) }}
                  <a href="javascript:void(0)"  data-url="{{route('admin.ordersAction',['remove-item',$order->id])}}" data-id="{{$item->id}}" style="float:right" class="btn btn-sm btn-danger itemRemove">
                      <i class="fa fa-trash"></i>
                  </a>
                </td>
        </tr>
       
        @endforeach

    </tbody>
    <thead>
        <tr>
            <th colspan="4"></th>
            <th style="vertical-align: middle;" >Adjustment Amount</th>
            <th>
                <label><input type="checkbox" class="shippingChargeApply" data-id="0" data-url="{{route('admin.ordersAction',['shipping-apply',$order->id])}}" {{$order->shipping_apply?'checked':''}} > Shipping apply</label> 
                <label><input type="checkbox" class="shippingChargeApply" data-id="0" data-url="{{route('admin.ordersAction',['free-shipping',$order->id])}}" {{$order->shipping_free?'checked':''}} > Free Shipping</label> 
                <input type="number" class="form-control adjustmentUpdate" value="{{$order->adjustment_amount}}" placeholder="Amount" data-id="0" data-url="{{route('admin.ordersAction',['adjustment-amount',$order->id])}}" style="width: 250px;margin: auto;height: 35px;">
            </th>
        </tr>
        <tr>
            <th colspan="4"></th>
			<th style="vertical-align: middle;" >Select Courier</th>
			<td style="padding:3px;">
			    @if($order->courier_id)
			          @php
                        $courierInfo = json_decode($order->courier_data, true);
                        $status = $courierInfo['data']['order_status'] ?? null;
                    @endphp
			        <b>{{$order->courier}}</b> - Status: {{ $status?:$order->courier_status }} <br>
			        <b>ID:</b> 
			        @if($order->courier=='Carrybee')
			        <a href="https://merchant.carrybee.com/tracking?consignment_id={{$order->courier_id}}" target="_blank">
			         {{$order->courier_id}} Carrybee
			         </a>
			        @elseif($order->courier=='Steadfast')
			         <a href="https://steadfast.com.bd/t/{{$order->courier_id}}" target="_blank">
			         {{$order->courier_id}} Steadfast
			         </a>
			        @else
			        <a href="https://merchant.pathao.com/public-tracking?consignment_id={{$order->courier_id}}&phone={{$order->mobile}}" target="_blank">
			         {{$order->courier_id}} Pathao
			         </a>
			         @endif
			    @else
			    <select class="form-control mb-1 courierSelect" data-url="{{route('admin.ordersAction',['courier-select',$order->id])}}" name="courier" style="width: 250px;margin: auto;height: 35px;">
			        <option value="">Select Courier</option>
			        <option value="Pathao" {{$order->courier=='Pathao'?'selected':''}}  >Pathao</option>
			        <option value="Carrybee" {{$order->courier=='Carrybee'?'selected':''}}  >Carrybee</option>
			        <option value="Steadfast" {{$order->courier=='Steadfast'?'selected':''}}  >Steadfast</option>
			    </select>
			    <div class="courierData" style="width: 250px;margin:auto;">
			    </div>
			    @endif
			</td>
		</tr>
		<tr>
            <th colspan="4"></th>
            <th style="vertical-align: middle;" >Special Instruction</th>
            <th style="padding: 5px;">
                <textarea name="special_msg" class="form-control" placeholder="Special Note" data-id="0"  style="width: 250px;margin: auto;">{{$order->delivered_msg}}</textarea>
            </th>
        </tr>
        <tr>
            <th colspan="5" style="vertical-align: top;">

                <h4><b>Admin Note:</b></h4>
                <div class="adminNoteAdd mt-3" data-order-id="{{ $order->id }}">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control note-input" placeholder="Enter note">
                        <div class="input-group-append">
                            <span class="input-group-text add-note-btn" style="cursor: pointer;">Add Note</span>
                        </div>
                    </div>
                
                    <!-- Notes List -->
                    <ul class="notes-list" style="padding-left: 10px;">
                        @php
                            $notes = $order->admin_note ? json_decode($order->admin_note, true) : [];
                        @endphp
                        @forelse($notes as $index => $note)
                            <li class="note-item" data-index="{{ $index }}">
                                <span>
                                    {{ $note[0] }}
                                    - <small>Msg By: {{ $note[1] }} {{ \Carbon\Carbon::parse($note[2])->format('d-m-Y h:i A') }}</small>
                                </span>
                                <span class="btn btn-sm btn-danger remove-note-btn">Delete</span>
                            </li>
                        @empty
            
                        @endforelse
                    </ul>
                </div>
                
            </th>
            <th>
                
                <label><input type="checkbox"  name="facebook_order"  {{$order->facebook_order?'checked':''}} > Facebook Order</label> 
                <div class="input-group input-group-sm">
                    <select class="form-control" name="order_status" id="order_status" style="width: 250px;border: 2px solid #009688;height: 35px;">
        			  	<option	option {{ $order->order_status == 'pending' ? 'selected' : '' }} value="pending">Pending</option>
                        <option {{ $order->order_status == 'confirmed' ? 'selected' : '' }} value="confirmed">Confirmed</option>
                        <option {{ $order->order_status == 'shipped' ? 'selected' : '' }} value="shipped">Shipped</option>
                        <option {{ $order->order_status == 'delivered' ? 'selected' : '' }} value="delivered">Delivered</option>
                        <option {{ $order->order_status == 'returned' ? 'selected' : '' }} value="returned">Returned</option>
                        <option {{ $order->order_status == 'cancelled' ? 'selected' : '' }} value="cancelled">Cancelled</option>   
                    </select>
                </div>
                <div class="input-group input-group-sm" style="width: 250px;margin:5px 0;">
            		@if(general()->sms_status)
                    <label style="cursor: pointer;padding: 0 5px;"><input type="checkbox" name="sms_send"> Send SMS</label>
                    @endif
            		@if(general()->mail_status)
            		<label style="cursor: pointer;padding: 0 5px;"><input type="checkbox" name="mail_send"> Send Mail</label>
                	@endif
        		</div>
                <div class="form-group">
                    <button class="btn btn-success" onclick="this.disabled = true; this.form.submit();" type="submit" style="width: 100%;background-color: #e91e63 !important;border-color: #e91e63;">
                    <i class="fa fa-check"></i>
                    Order Update
                   </button>
                </div>
            </th>
        </tr>
    </thead>
</table>