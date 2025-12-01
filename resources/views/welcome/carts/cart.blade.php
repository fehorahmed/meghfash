@extends(welcomeTheme().'layouts.app') 
@section('title')
<title>{{websiteTitle('Cart Items')}}</title>
@endsection 
@section('SEO')
<meta name="title" property="og:title" content="{{websiteTitle('Cart Items')}}" />
<meta name="description" property="og:description" content="{!!general()->meta_description!!}" />
<meta name="keyword" property="og:keyword" content="{{general()->meta_keyword}}" />
<meta name="image" property="og:image" content="{{asset(general()->logo())}}" />
<meta name="url" property="og:url" content="{{route('carts')}}" />
<link rel="canonical" href="{{route('carts')}}">
@endsection 
@push('css')

<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
    textarea:focus, input:focus{
    outline: none;
    }
    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }
    .section {
        background-color: #f9f9f9;
    }

    .table-responsive.shop_cart_table {
        background-color: #ffff;
        padding: 30px;
    }
    .cartItemsList {
        padding: 50px 0;
    }
    .shop_cart_table tr {
        vertical-align: middle;
    }
    .shop_cart_table tr td.product-thumbnail {
        padding: 20px 0;
    }
    .shop_cart_table tr td.product-name a {
        color: #292b2c;
        transition: all .3s ease-in-out;
        font-size: 15px;
    }
    .shop_cart_table tr td.product-price {
        font-weight: 600;
    }
    .shop_cart_table tr td.product-subtotal {
        font-weight: 600;
    }
    .quantity .plus {
        background-color: #eee;
        border-radius: 50px;
        cursor: pointer;
        border: 0;
        padding: 0;
        width: 37px;
        font-size: 24px;
        height: 37px;
    }
    .quantity .minus  {
        background-color: #eee;
        border-radius: 50px;
        cursor: pointer;
        border: 0;
        padding: 0;
        width: 37px;
        font-size: 24px;
        height: 37px;
    }
    .quantity .qty {
        width: 55px;
        height: 36px;
        border: 1px solid #ddd;
        background-color: transparent;
        text-align: center;
        font-size: 18px;
    }
    .cartItemsList .form-control:focus {
        box-shadow: none;
    }
    .coupon input {
        padding: 10px 0;
        margin: 0;
        border-right: 0;
    }
    .coupon button {
        padding: 11px 25px;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        background-color: #e92734;
        color: #fff;
        border: 1px solid #e92734 ;
    }
    .coupon button:hover {
        background-color: #fff;
        color: #e92734;
        
    }
    
    .shipping_calculator {
        border: 1px solid lightgrey;
        padding: 30px;
        background-color: #fff;
    }
    .cart-total {
        padding: 30px;
        background-color: #fff;
    }
    .shipping_calculator h6 {
        font-weight: bold;
    }
    .shipping_calculator button {
        background-color: #e92734;
        color: #fff;
        padding: 8px 32px;
        border: 1px solid #e92734;
    }
    .shipping_calculator button:hover {
        background-color: #fff;
        color: #e92734;
    }
    .btn-chekout {
        background-color: #3ca549;
        padding: 9px 34px;
        border: 1px solid #3ca549;
    }
    .btn-chekout:hover {
        background-color: #fff;
        color: #e92734;
    }
    
    .cart_empty {
        width: 40%;
        margin: 0 auto;
        text-align: center;
        background-color: #fff;
        padding: 56px 0;
        box-shadow: 0px 0px 0px 2px #f5f5f5;
        
    }
    .cart_empty h4 {
        margin-bottom: 20px;
        font-weight: bold;
    }

</style>

@endpush 

@section('contents')
<div class="singleProHead">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
            </ol>
        </nav>
    </div>
</div>
<!-- START SECTION SHOP -->
<div class="section">
    <div class="container cartItemsList">
      @include(welcomeTheme().'.carts.includes.cartItems')
    </div>
</div>
<!-- END SECTION SHOP -->
@endsection 
@push('js') 

<script>
    $(document).ready(function(){
        
            $(document).on('change','.cartQtyChange',function(){

                  var url = $(this).data('url');
                  var qty = $(this).val();
                  var Dcharge =parseInt($('.cartDeliveryCharge').text());

                  if (isNaN(Dcharge)){
                    Dcharge =0;
                  }
                
                if(qty==''){
                    qty=1;
                }
                
                $.ajax({
                  url: url,
                  type: 'GET',
                  dataType: 'json',
                  cache: false,
                  data: {'qty':qty},
                })
                .done(function(data) {
                    $(".cartItemsList").empty().append(data.cartItems);
                    $(".headerCartItem").empty().append(data.headerCartItems);
                })
                .fail(function() {
                  // alert("error");
                });


            });
    });
</script>

@endpush