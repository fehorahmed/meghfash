
    <div class="invoiceContainer">
        <div class="invoice-inner InnerInvoiePage" >
			<div class="invoice-header">
				<div class="row">
					<div class="col-4">
						<img src="{{asset(general()->logo())}}" style="max-width: 100%;">
					</div>
					<div class="col-1"></div>
					<div class="col-7" style="text-align: end;">
						<h6>CONTACT INFORMATION:</h6>
						<p>{{general()->address_one}}</p>
						<p>{{general()->mobile}}</p>
						<p>{{general()->email}}</p>
						<p>{{general()->website}}</p>
					</div>
				</div>
			</div>
			<hr style="border: 2px solid #00549e; margin: 0;">
			<h2 style="margin: 10px 0px;font-size: 41px;letter-spacing: 3px;color: #00549e;">INVOICE</h2>
			<div class="orderInfo">
				<div class="row" style="flex-wrap: wrap;">
					<div class="col-4">
						<p>
							<b>Order To:</b><br>
							<b>Name:</b> {{ $order->name }}<br>
							<b>Mobile:</b> {{ $order->mobile }}<br>
							<b>Address:</b> {{ $order->fullAddress() }}
							
							@if($order->courier && $order->courier_id)
    							<br>
    							<br>
    						    <b style="font-size: 16px;">Courier: {{$order->courier}} - {{ $order->courier_id}}</b>
							@endif
						</p>
					</div>
					<div class="col-2">
					</div>
					<div class="col-6">
						<div class="ordrinfotable">
							<table class="tableOrderinfo table">
							  <thead>
							    <tr>
							      <td style="width: 40%;">Invoice Number</td>
							      <td>: {{ $order->invoice }}</td>
							    </tr>
							    <tr>
							      <td style="width: 40%;">Invoice Date</td>
							      <td>: {{ $order->created_at->format('d-m-Y h:i A') }}</td>
							    </tr>
							    <tr>
							      <td style="width: 40%;">Order Status</td>
							      <td>: {{ucfirst($order->order_status)}}</td>
							    </tr>
							    <tr>
							      <td style="width: 40%;">Payment Method</td>
							      <td>: {{ucfirst($order->payment_method)}}</td>
							    </tr>
							  </thead>
							</table>
						</div>							
					</div>
				</div>
			</div>
            
            <div class="table-responsive">
    			<div class="mainTable" style="margin: 30px 0;">
    				<table class="table mainproducttable">
					  <thead>
					    <tr class="headerTable">
					      <th style="min-width:300px;">Product Name & Description</th>
					      <th style="width: 120px;min-width:120px; text-align: center;">Unit Price</th>
					      <th style="width: 100px;min-width:100px; text-align: center;">Quantity</th>
					      <th style="width: 120px;min-width:120px; text-align: center;">Total Price</th>
					    </tr>
					  </thead>
					  <tbody>
					      
					    @foreach($order->items as $i=>$item)
					    <tr>
					      <td>{{ $item->product_name }}
                            
                            @if(count($item->itemAttributes()) > 0)
                            <br>
							<span style="font-size: 14px;">
							    @foreach($item->itemAttributes() as $i=>$attri)
							        @if(isset($attri['title']) && isset($attri['value']))
                                    {{$i==0?'':','}} <span>{{$attri['title']}} : {{$attri['value']}}</span>
                                    @endif
                                @endforeach
                            </span>
							@endif
		
							
							@if($item->warranty_note)
							<br>
							 <small style="font-size: 12px;">{{$item->warranty_note}} -  <b>{{$item->warranty_charge > 0?priceFullFormat($item->warranty_charge):'Free'}}</b></small>
							@endif
					      </td>
					      <td style="text-align: center;">{{ priceFormat($item->price) }}</td>
					      <td style="text-align: center;">{{$item->quantity}}</td>
					      <td style="text-align: center;">{{ priceFormat($item->final_price) }}</td>
					    </tr>
					    @endforeach
					    
					    <tr>
					      <td colspan="3" style="text-align: end;">Subtotal</td>
					      <td style="text-align: center;">{{ priceFormat($order->total_price) }}</td>
					    </tr>
					    <tr>
					      <td colspan="3" style="text-align: end;">Discount</td>
					      <td style="text-align: center;">{{ priceFormat($order->coupon_discount + $order->items->sum('total_coupon_discount')) }}</td>
					    </tr>
					 
					    <tr>
					      <td colspan="3" style="text-align: end;">Shipping</td>
					      <td style="text-align: center;">
					      @if($order->shipping_charge>0)
					      {{priceFormat($order->shipping_charge)}}
					      @else
					      Free Shipping
					      @endif
					      </td>
					    </tr>
					    
					    <tr>
					      <td colspan="3" style="text-align: end;">Grand Total</td>
					      <td style="text-align: center;">{{ priceFormat($order->grand_total) }}</td>
					    </tr>
					    <tr>
					      <td colspan="3" style="text-align: end;">Paid Amount</td>
					      <td style="text-align: center;">{{priceFormat($order->paid_amount)}}</td>
					    </tr>
					    <tr>
					      <td colspan="3" style="text-align: end;">Due Amount</td>
					      <td style="text-align: center;">{{priceFormat($order->due_amount)}}</td>
					    </tr>
					  </tbody>
					</table>
    			</div>
			</div>

			<div class="frozenTable">
				<div class="row" style="display:flex;">
					<div class="col-md-12" style="">
					    @if($order->payment_status=='paid')
					    <div class="paidsStatus" style="text-align:right;">
					        <img src="{{asset('public/medies/paid.png')}}" style="max-width:80px;">
					    </div>
					     @endif
					</div>
					<!--@if($order->note)-->
    	<!--			<div class="col-12">-->
    	<!--			    <b>Order Note</b><br>-->
    	<!--			    <p>{!!$order->note!!}</p>-->
    	<!--			</div>-->
    	<!--			@endif-->
    				
				</div>
			</div>

			<div class="footerInvoice">
				<div class="row" style="dispaly:flex;">
					<div class="col-6" style="flex: 0 0 50%;max-width: 50%;">
						<p>Thank you for shopping from {{general()->title}}</p>
					</div>
					<div class="col-6" style="text-align: end;flex: 0 0 50%;max-width: 50%;">
						------------------------
						<p>Authorised Sign</p>
					</div>
				</div>
			</div>
		</div>
    </div>
