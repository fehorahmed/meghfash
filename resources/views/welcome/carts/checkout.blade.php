@extends(welcomeTheme().'layouts.app') 
@section('title')
<title>{{websiteTitle('Checkout')}}</title>
@endsection 
@section('SEO')
<meta name="title" property="og:title" content="{{websiteTitle('Checkout')}}" />
<meta name="description" property="og:description" content="{!!general()->meta_description!!}" />
<meta name="keyword" property="og:keyword" content="{{general()->meta_keyword}}" />
<meta name="image" property="og:image" content="{{asset(general()->logo())}}" />
<meta name="url" property="og:url" content="{{route('carts')}}" />
<link rel="canonical" href="{{route('carts')}}">
@endsection 
@push('css')
<style>
     .section {
        padding: 60px 0;
        background-color: #f9f9f9;
    }
    .orderForm {
        background-color: #fff;
        padding: 20px;
    }
    .orderForm h4 {
        padding-bottom: 8px;
    }
    .order_review {
        padding: 20px;
        background-color: #fff;
    }
    .payment_method h4 {
        color: #292b2c;
        font-weight: 700;
        padding-bottom: 20px;
    }
    p.payment-text {
        padding: 10px 0;
        font-size: 14px;
        font-weight: bold;
    }
    .order_review button {
        background-color: #e72834;
        width: 100%;
        border: none;
        padding: 10px 0;
        font-weight: bold;
        margin-top: 10px;
    }
    .orderForm .form-control:focus {
        box-shadow: none;
    }
    .orderForm .form-control {
        text-align: left;
        border-radius: 0;
        margin: 10px 0;
        font-size: 14px;
    }
    .payment_method .ui-tabs .ui-tabs-nav .ui-tabs-anchor {
        padding: 10px 10px;
        font-size: 14px;
    }
    .payment_method .ui-tabs .ui-tabs-nav {
        padding: 10px 5px;
        background-color: #fff;
         border: none;
    }
    .payment_method .ui-widget.ui-widget-content {
        border: none;
    }
    .payment_method .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, a.ui-button:active, .ui-button:active, .ui-button.ui-state-active:hover {
        border: 1px solid #20863a;
        background: #369943;
        font-weight: normal;
        color: #ffffff;
    }
    .payment_method .form-check-input:checked {
        background-color: #d55959;
        border-color: #d55959;
    }
    
     .payment_method .ui-tabs .ui-tabs-nav li {
        border: 1px solid lightgray;
    }
    .payment_method  .form-check {
        min-height: 0;
        margin-bottom: 0;
    }
        
   
    @media only screen and (max-width: 767px) {
          .payment_method .ui-tabs .ui-tabs-nav li {
            width: 100%;
            margin-bottom: 10px;
            border: 1px solid lightgray;
        }
    }
</style>
@endpush 

@section('contents')

<div class="singleProHead">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('carts')}}">Cart View</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
    </div>
</div>

<!-- START MAIN CONTENT -->
<div class="main_content">

<!-- START SECTION SHOP -->
<div class="section">
    <div class="container">
    @isset($carts)
    @if($carts->count() > 0)
    <form action="{{route('checkout')}}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="orderForm">
                <div class="heading_s1">
                    <h4>Billing Details</h4>
                </div>
                    <div class="form-group mb-3">
                        <input type="text" required class="form-control" name="name" value="{{old('name')}}" placeholder="Enter Your name *">
                    </div>
                    <div class="form-group mb-3">
                        <input class="form-control" required type="text" name="email" value="{{old('email')}}" placeholder="Email address *">
                    </div>
                    <div class="form-group mb-3">
                        <input class="form-control" required type="text" name="mobile" value="{{old('mobile')}}" placeholder="Phone *">
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <div class="custom_select">
                                <select name="district"  class="form-control" id="district" required>
                                    <option value="">Select District*</option>
                                    @foreach(geoData(3) as $data)
                                    <option value="{{$data->id}}" >{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <div class="custom_select">
                                <select name="city" id="city" class="form-control"  required>
                                    <option value="">Select City*</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <input class="form-control" required type="text" name="address" value="{{old('address')}}" placeholder="Address line*">
                    </div>
                    <div class="heading_s1">
                        <h4>Additional information</h4>
                    </div>
                    <div class="form-group mb-0">
                        <textarea rows="5" class="form-control" name="name" placeholder="Order notes"></textarea>
                    </div> 
                  </div>
            </div>
            <div class="col-md-6">
                <div class="order_review">
                    <div class="heading_s1">
                        <h4>Your Orders</h4>
                    </div>
                    <div class="table-responsive order_table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th style="width: 120px;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($carts as $cart)
                                <tr>
                                    <td>
                                    {{$cart->product->name}}
                                    @if($cart->itemAttributes())
                                    <small style="color: gray;">(
                                    @foreach($cart->itemAttributes() as $attributeName => $value)
        								{{ $value }}
        								@if(!$loop->last)
        									| 
        								@endif
        								@endforeach
                                    )
                                    </small>
                                    @endif
                                    <span class="product-qty">x {{$cart->quantity}}</span>
                                    
                                    </td>
                                    <td>{{priceFullFormat($cart->subtotal())}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>SubTotal</th>
                                    <td class="product-subtotal">{{priceFullFormat($cartTotalPrice)}}</td>
                                </tr>
                                <tr>
                                    <th>Discount</th>
                                    <td>{{priceFullFormat($couponDisc)}}</td>
                                </tr>
                                {{--
                                <tr>
                                    <th>Shipping</th>
                                    <td>
                                    @if($shippingCharge>0)
                                    {{priceFullFormat($shippingCharge)}}
                                    @else
                                    Free Shipping
                                    @endif
                                    </td>
                                </tr>
                                --}}
                                <tr>
                                    <th>Total</th>
                                    <td class="product-subtotal">{{priceFullFormat($grandTotal)}}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="payment_method">
                        <div class="heading_s1">
                            <h4>Payment</h4>
                        </div>
                        <div class="payment_option">
                            <div class="custome-radio">
                                <input class="form-check-input" type="radio" name="payment_option" id="cash_hand" value="Cash on Hand" checked="">
                                <label class="form-check-label" for="cash_hand">Cash on Hand</label>
                                <p data-method="cash_hand" class="payment-text">You will pay after get your goods items.</p>
                            </div>
                            {{--
                            <div class="custome-radio">
                                <input class="form-check-input" type="radio" name="payment_option" id="cash_delivery" value="Cash on Delivery">
                                <label class="form-check-label" for="cash_delivery">Cash on Delivery</label>
                                <p data-method="cash_delivery" class="payment-text">You will pay after get your goods items delivery.</p>
                            </div>
                            <div class="custome-radio">
                                <input class="form-check-input" type="radio" name="payment_option" id="payment_Delivery" value="Payment on Delivery">
                                <label class="form-check-label" for="payment_Delivery">Payment on Delivery</label>
                                <p data-method="payment_Delivery" class="payment-text">You will pay after get your goods items Delivery.</p>
                                <div class="methodList">
                                    
                                    <div class="row">
                                        <div class="col-3 pe-0">
                                            <img src="https://iconape.com/wp-content/png_logo_vector/bkash-logo.png" style="width: 100px;max-width:100%;">
                                        </div>
                                        <div class="col-9">
                                            <b>Bkash</b><br> 01742XXXXXXX (Personal)
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="custome-radio">-->
                            <!--    <h4>We are also Accept</h4>-->
                            <!--    <img src="{{asset('public/welcome/images/paymentMethod.jpg')}}" style="max-width: 100%;max-height: 60px;">-->
                            <!--    <input class="form-check-input" type="radio" name="payment_option" id="other" value="other">-->
                            <!--    <label class="form-check-label" for="paypal">Paypal</label>-->
                            <!--    <p data-method="paypal" class="payment-text">Pay via PayPal; you can pay with your credit card if you don't have a PayPal account.</p>-->
                            <!--</div>-->
                            --}}
                        </div>
                        <div id="tabs">
                          <ul>
                              {{--
                            <li>
                                <a href="#tabs-1">
                                    <div class="form-check">
                                      <input class="form-check-input" type="radio" name="payment_option" value="Cash on Hand" id="flexRadioDefault1"checked=""  >
                                      <label class="form-check-label" for="flexRadioDefault1">
                                       Cash on Hand
                                      </label>
                                    </div>
                                    <!--<div class="custome-radio">-->
                                    <!--    <input class="form-check-input" type="radio" name="payment_option" id="cash_hand" value="Cash on Hand" checked="">-->
                                    <!--    <label class="form-check-label" for="cash_hand">Cash on Hand</label>-->
                                    <!--</div>-->
                                </a>
                            </li>
                            
                            <li>
                                <a href="#tabs-2">
                                    <div class="form-check">
                                      <input class="form-check-input" type="radio" name="payment_option" value="Cash on Delivery" id="flexRadioDefault2" >
                                      <label class="form-check-label" for="flexRadioDefault2">
                                       Cash on Delivery
                                      </label>
                                    </div>
                                    <!--<div class="custome-radio">-->
                                    <!--    <input class="form-check-input" type="radio" name="payment_option" id="cash_delivery" value="Cash on Delivery">-->
                                    <!--    <label class="form-check-label" for="cash_delivery">Cash on Delivery</label>-->
                                    <!--</div>-->
                                </a>
                            </li>
                            <li>
                                <a href="#tabs-3">
                                     <div class="form-check">
                                      <input class="form-check-input" type="radio" name="payment_option" value="Payment on Delivery" id="flexRadioDefault3" >
                                      <label class="form-check-label" for="flexRadioDefault3">
                                       Payment on Delivery
                                      </label>
                                    </div>
                                    <!--<div class="custome-radio">-->
                                    <!--    <input class="form-check-input" type="radio" name="payment_option" id="payment_Delivery" value="Payment on Delivery">-->
                                    <!--    <label class="form-check-label" for="payment_Delivery">Payment on Delivery</label>-->
                                    <!--</div>-->
                                </a>
                            </li>
                            --}}
                          </ul>
                          {{--
                          <div id="tabs-1">
                            <p data-method="cash_hand" class="payment-text">You will pay after get your goods items.</p>
                          </div>
                          <div id="tabs-2">
                                <p data-method="cash_delivery" class="payment-text">You will pay after get your goods items delivery.</p>
                          </div>
                          <div id="tabs-3">
                                <p data-method="payment_Delivery" class="payment-text">You will pay after get your goods items Delivery.</p>
                                <div class="methodList">
                                    <img src="{{asset('public/welcome/images/paymentMethod.jpg')}}" style="max-width: 100%;">
                                    <!--<div class="row">-->
                                    <!--    <div class="col-3 pe-0">-->
                                    <!--        <img src="https://iconape.com/wp-content/png_logo_vector/bkash-logo.png" style="width: 100px;max-width:100%;">-->
                                    <!--    </div>-->
                                    <!--    <div class="col-9">-->
                                    <!--        <b>Bkash</b><br> 01742XXXXXXX (Personal)-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                </div>
                          </div>
                          --}}
                        </div>
                    </div>
                    <br>
                    <p style="font-size: 14px;">
                        
                    <input type="checkbox" name="terms" required="" checked="" value="true">
                    I accept the <a href="{{asset('/terms-and-conditions')}}" target="_blank">Terms And Conditions</a> outlined, including <a href="{{asset('/return-policy')}}" target="_blank" >Return Policy</a>,<a href="{{asset('/refund-policy')}}" target="_blank">Refund Policy</a>, <a href="{{asset('/privacy-policy')}}" target="_blank">Privacy Policy</a> . I agree to comply before placing my order.
                    </p>
                    <button type="submit" class="btn btn-success btn-block">Place Order</button>
                </div>
            </div>
        </div>
    </form>
    </div>
    @else
    <div class="cart_empty">
        <i class="linearicons-cart"></i>
        <h4>Empty Cart</h4>
        <a href="{{route('index')}}" class="btn btn-success rounded-0 view-cart">Shopping</a>
    </div>
    @endif
    @endisset
</div>
<!-- END SECTION SHOP -->


</div>
<!-- END MAIN CONTENT -->



@endsection 

@push('js') 

<script>
    $(document).ready(function(){
        
        
        $('.ui-tabs .ui-tabs-nav li').click(function(){
            $(this).find('input').prop('checked',true);
        });
        
        
        $('.selectDateDelivery').change(function(date){
            var dateV =$(this).val();
            var lastDay =3;
            $( "#datepicker" ).datepicker({
            	minDate: +lastDay,
       			maxDate: "+30D"
            });
                
            if(dateV!=''){
                alert(dateV);
            }
                
        });
        
        $('.prefectureArea').change(function(date){
            var areaId =$(this).val();
            
            var url = "{{route('checkout')}}";

            $.ajax({
              url: url,
              type: 'GET',
              dataType: 'json',
              cache: false,
              data:{'areaId':areaId}
            })
            .done(function(data) {
                $(".selectDateDelivery").empty().append(data.view);
            })
            .fail(function() {
              // alert("error");
            });
                
        });
        
    });
</script>

@endpush