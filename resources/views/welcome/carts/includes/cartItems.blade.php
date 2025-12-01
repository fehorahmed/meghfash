@if(isset($carts) && $carts->count() > 0)
<div class="row">
	<div class="col-12">
		@include(welcomeTheme().'.alerts')
		<div class="table-responsive shop_cart_table">
			<table class="table">
				<thead>
					<tr>
						<th class="product-thumbnail">&nbsp;</th>
						<th class="product-name" style="min-width: 250px;">Product</th>
						<th class="product-price" style="min-width: 130px;">Price</th>
						<th class="product-quantity" style="min-width: 160px;">Quantity</th>
						<th class="product-subtotal" style="min-width: 130px;">Total</th>
						<th class="product-remove">Remove</th>
					</tr>
				</thead>
				<tbody>
				@foreach($carts as $cart)
					<tr>
						<td class="product-thumbnail">
							<a href="{{route('productView',$cart->product->slug?:'no-title')}}">
								<img src="{{asset($cart->image())}}" alt="{{$cart->product->name}}" style="max-width:100px;">
							</a>
						</td>
						<td class="product-name" data-title="Product">
							<a href="{{route('productView',$cart->product->slug?:'no-title')}}">{{$cart->product->name}}</a>
							@if($cart->itemAttributes())
							<span style="font-size: 14px;">
                                @foreach($cart->itemAttributes() as $attributeName => $value)
                                    <b>{{ $attributeName }}</b>: {{ $value }}
                                    @if(!$loop->last)
                                        , 
                                    @endif
                                @endforeach
                            </span>
							@endif
							@if($cart->warranty_note)
							<br>
							 <small style="font-size: 12px;">{{$cart->warranty_note}} -  <b>{{$cart->warranty_charge > 0?priceFullFormat($cart->warranty_charge):'Free'}}</b></small>
							@endif
						</td>
						<td class="product-price" data-title="Price">{{priceFullFormat($cart->itemprice())}}</td>
						<td class="product-quantity" data-title="Quantity">
							<div class="quantity">
								<input type="button" value="-" class="minus cartUpdate" data-url="{{ route('changeToCart', [$cart, 'decrement']) }}">
								<input type="text" name="quantity" value="{{$cart->quantity}}" title="Qty" readonly="" class="qty" size="4">
								<input type="button" value="+" class="plus cartUpdate" data-url="{{ route('changeToCart', [$cart, 'increment']) }}">
							</div>
						</td>
						<td class="product-subtotal" data-title="Total">{{priceFullFormat($cart->subtotal())}}</td>
						<td class="product-remove" data-title="Remove"><a href="javascript:void(0)" class="cartUpdate" data-url="{{ route('changeToCart', [$cart, 'delete']) }}"><i class="text-danger fa fa-times"></i></a></td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="medium_divider"></div>
		<div class="divider center_icon"><i class="ti-shopping-cart-full"></i></div>
		<div class="medium_divider"></div>
	</div>
</div>
<div class="row mt-5">
	<div class="col-md-6">
		<form class="field_form shipping_calculator">
		    <div class="heading_s1 mb-3 text-center">
    			<h3>Pay with</h3>
    		</div>
			<div class="form-row">
				<div class="form-group col-lg-12 mb-3 text-center">
			            <img src="{{asset('public/welcome/images/paymentMethod.jpg')}}">
				</div>
			</div>
		</form>
	</div>
	<div class="col-md-6">
		<div class="cart-total border p-3 p-md-4">
			<div class="heading_s1 mb-3">
				<h6 style="font-weight: bold;">Cart Totals</h6>
			</div>
			<div class="table-responsive">
				<table class="table">
					<tbody>
						<tr>
							<td class="cart_total_label">Cart Subtotal</td>
							<td class="cart_total_amount">{{priceFullFormat($cartTotalPrice)}}</td>
						</tr>
						<tr>
							<td class="cart_total_label">Discount</td>
							<td class="cart_total_amount">{{priceFullFormat($couponDisc)}}</td>
						</tr>
						{{--
						<tr>
							<td class="cart_total_label">Shipping</td>
							<td class="cart_total_amount">
							@if($shippingCharge>0)
							{{priceFullFormat($shippingCharge)}}
							@else
							Free Shipping
							@endif
							</td>
						</tr>
						--}}
						<tr>
							<td class="cart_total_label">Total</td>
							<td class="cart_total_amount"><strong>{{priceFullFormat($grandTotal)}}</strong></td>
						</tr>
					</tbody>
					<tfoot>
    					<tr>
    						<td colspan="6" class="px-0">
    							<div class="row g-0 align-items-center">
    
    								<div class="col-md-12">
    									<form action="{{route('couponApply')}}" method="post">
    										@csrf
    										<div class="coupon field_form input-group">
    											<input type="text" value="{{old('coupon_code')}}" name="coupon_code" class="form-control form-control-sm" placeholder="Enter Coupon Code..">
    											<div class="input-group-append">
    												<button class="btn btn-info btn-sm" type="submit">Apply Coupon</button>
    											</div>
    										</div>
    									</form>
    								</div>
    							</div>
    						</td>
    					</tr>
    				</tfoot>
				</table>
			</div>
			<a href="{{route('checkout')}}" class="btn btn-success btn-chekout">Proceed To CheckOut</a>
		</div>
	</div>
</div>

@else
<div class="cart_empty">
	<i class="linearicons-cart"></i>
	<h4>Continue Shopping</h4>
	<a href="{{route('index')}}" class="btn btn-success rounded-0 view-cart">Shopping</a>
</div>
@endif
