<table class="table table-borderless">
	    <tr>
			<th>Delivery Charge:</th>
			<td>{{general()->currency}} <span class="shippingCharge">{{$order->shipping_charge}}</span> </td>
		</tr>
		<tr>
			<th>Grand Total:</th>
			<td>{{priceFullFormat($order->grand_total)}}
			@if($order->return_amount>0)
			 <br> <span class="badge badge-success" style="background:#ff9800;">Refund</span> {{priceFullFormat($order->return_amount)}}
			@endif
			</td>
		</tr>
		<tr>
			<th>Paid:</th>
			<td>{{priceFullFormat($order->paid_amount)}}</td>
		</tr>
		<tr>
			<th>Due:</th>
			<td>{{priceFullFormat($order->due_amount)}}</td>
		</tr>
		@if($order->extra_amount)
		<tr>
			<th>Advence:</th>
			<td>{{priceFullFormat($order->extra_amount)}} 
			
			</td>
		</tr>
		@endif
		<tr>
			<th>Payment Method:</th>
			<td>{{$order->payment_method}}</td>
		</tr>
		
		<tr>
			<th>Payment:</th>
			<td>
			    @if($order->payment_status=='partial')
                <span class="badge badge-success" style="background:#ff9800;">{{ucfirst($order->payment_status)}}</span>
                @elseif($order->payment_status=='paid')
                <span class="badge badge-success" style="background:#673ab7;">{{ucfirst($order->payment_status)}}</span>
                @else
                <span class="badge badge-success" style="background:#f44336;">{{ucfirst($order->payment_status)}}</span>
                @endif
			</td>
		</tr>
		<tr>
			<th>Order Status:</th>
			<td>

	            @if($order->order_status=='confirmed')
	            <span class="badge badge-success" style="background:#e91e63;">{{ucfirst($order->order_status)}}</span>
	            @elseif($order->order_status=='shipped')
	            <span class="badge badge-success" style="background:#673ab7;">{{ucfirst($order->order_status)}}</span>
	            @elseif($order->order_status=='delivered')
	            <span class="badge badge-success" style="background:#1c84c6;">{{ucfirst($order->order_status)}}</span>
	            @elseif($order->order_status=='returned')
	            <span class="badge badge-success" style="background:#ff9800;">{{ucfirst($order->order_status)}}</span>
	            
	            @if($order->returnOrder)
                <a href="{{route('admin.ordersReturnAction',['invoice',$order->returnOrder->id])}}"><i class="fa fa-eye"></i></a>
                @else
                <a href="{{route('admin.ordersReturnAction',['create','order_no'=>$order->invoice])}}"><i class="fa fa-edit"></i></a>
                @endif
	            
	            @elseif($order->order_status=='cancelled')
	            <span class="badge badge-success" style="background:#f44336;">{{ucfirst($order->order_status)}}</span>
	            @else
	            <span class="badge badge-success" style="background:#ff9800;">{{ucfirst($order->order_status)}}</span>
	            @endif
			    
			</td>
		</tr>
		<tr>
			<th>Date:</th>
			<td>{{$order->created_at->format('d-m-Y')}}</td>
		</tr>
		<tr>
			<th>Total Items:</th>
			<td> {{$order->items->count()}} Items</td>
		</tr>
	</table>