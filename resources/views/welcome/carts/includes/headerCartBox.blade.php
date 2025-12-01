<a class="nav-link cart_trigger" href="#" data-bs-toggle="dropdown">
    <i class="linearicons-cart"></i>
    <span class="cart_count">{{$cartsCount}}</span>
</a>
<div class="cart_box dropdown-menu dropdown-menu-right">
    @if($carts->count() > 0)
        <ul class="cart_list">
            @foreach($carts as $cart)
            <li>
                <a href="javascript:void(0)" class="item_remove cartUpdate" data-url="{{ route('changeToCart', [$cart, 'delete']) }}" ><i class="ion-close"></i></a>
                <a href="{{route('productView',$cart->product->slug?:'no-title')}}"><img src="{{asset($cart->product->image())}}" alt="{{$cart->product->name}}">{{$cart->product->name}}</a>
                <span class="cart_quantity"> {{ $cart->quantity }} x {{priceFullFormat($cart->itemprice())}}</span>
            </li>
            @endforeach
        </ul>
        <div class="cart_footer">
            <p class="cart_total"><strong>Subtotal:</strong>{{priceFullFormat($cartTotalPrice)}}</p>
            <p class="cart_buttons"><a href="{{route('carts')}}" class="btn btn-fill-line rounded-0 view-cart">View Cart</a><a href="{{route('checkout')}}" class="btn btn-fill-out rounded-0 checkout">Checkout</a></p>
        </div>
    @else
    <div class="cart_empty">
        <i class="linearicons-cart"></i>
        <h4>Empty Cart</h4>
        <a href="{{route('index')}}" class="btn btn-fill-line rounded-0 view-cart">Shopping</a>
    </div>
    @endif 
</div>