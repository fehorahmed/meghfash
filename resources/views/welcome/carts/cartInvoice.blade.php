@extends(welcomeTheme().'layouts.app') 
@section('title')
<title>{{websiteTitle('Checkout')}}</title>
@endsection 
@section('SEO')
<meta name="description" content="{!!general()->meta_description!!}" />
<meta name="keywords" content="{{general()->meta_keyword}}" />
<meta property="og:title" content="{{general()->meta_title}}" />
<meta property="og:description" content="{!!general()->meta_description!!}" />
<meta property="og:image" content="{!!general()->meta_description!!}" />
<meta property="og:url" content="{{route('index')}}" />
@endsection @push('css')
<style type="text/css">
    .invoice-inner {
        box-shadow: 0px 0px 5px #ccc;
        padding: 10px 20px;
    }

    .invoice-header {
        padding: 20px 0px 35px;
    }

    .invoice-header img {
        width: 100%;
    }

    .invoice-header h6 {
        margin-top: 15px !important;
    }

    .invoice-header h6,
    p {
        margin: 0;
        line-height: 15px;
        font-size: 12px;
    }

    .invoice-inner h2 {
        margin: 10px 0px;
        font-size: 41px;
        letter-spacing: 3px;
        color: #00549e;
    }

    .ordrinfotable {
        padding: 10px 12px;
        border: 1px solid #ccc;
    }

    table.tableOrderinfo.table {
        margin: 0;
        padding: 0;
    }

    .tableOrderinfo td {
        padding: 0;
        font-size: 13px;
        line-height: 17px;
        border: none;
    }

    .mainTable {
        margin: 30px 0;
    }

    .mainproducttable {
        margin: 0;
        padding: 0;
        width: 100%;
    }

    .mainproducttable td {
        padding: 5px 7px;
        font-size: 12px;
        border: 1px solid #ccc;
    }

    tr.headerTable {
        background-color: #e2e2e2;
    }

    tr.headerTable td {
        font-size: 13px;
        padding: 7px;
    }

    .boxFrozen {
        border: 1px solid #ccc;
        text-align: center;
        margin-bottom: 6px;
        border-bottom: 0px solid #ccc;
    }

    .boxFrozen h3 {
        padding: 5px;
        color: #fff;
        margin: 0;
        background-color: #ff1414;
        font-size: 16px;
    }

    .boxFrozen p {
        font-size: 16px;
        padding: 5px 0px;
        border-bottom: 1px solid #ccc;
    }

    .footerInvoice {
        margin-top: 100px;
    }

    @media only screen and (max-width: 567px) {
        .invoice-inner {
            padding: 10px;
            margin: 10px 0px;
        }
        .invoiceContainer {
            padding: 0;
        }
    }
</style>
@endpush @section('contents')

<div class="main-home-page">
    <div class="container">
        <div class="cart-page">
            <div class="Invoice-table">
                <div class="row" style="margin: 0;">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8" style="padding: 0;">
                        <br>
                        @include(welcomeTheme().'.alerts')
                        <div class="invoicePage PrintAreaContact">
                                <div class="container invoiceContainer">
                                    <div class="invoice-inner">
                                        <div class="invoice-header">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <img src="{{asset(general()->logo())}}" />
                                                </div>
                                                <div class="col-md-1"></div>
                                                <div class="col-md-7" style="text-align: end;">
                                                    <h6>CONTACT INFORMATION:</h6>
                                                    <p>
                                                        {{general()->address_one}}<br />
                                                        {{general()->mobile}}<br />
                                                        {{general()->website}}<br />
                                                        {{general()->email}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <hr style="margin: 0;" />
                                        <h2>INVOICE</h2>
                                        <div class="orderInfo">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <p>
                                                        <b>Order To:</b><br />
                                                        <b>Name:</b> {{ $order->name }}<br />
                                                        <b>Mobile:</b> {{ $order->mobile }}<br />
                                                        <b>Address:</b> {{ $order->fullAddress() }}
                                                    </p>
                                                </div>
                                                <div class="col-md-3"></div>
                                                <div class="col-md-6">
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
                                            <div class="mainTable">
                                                <table class="table mainproducttable">
                                                    <thead>
                                                        <tr class="headerTable">
                                                            <td style="width: 40%;">Product Name & Description</td>
                                                            <td style="width: 10%; text-align: center;">Price</td>
                                                            <td style="width: 15%; text-align: center;">Quantity</td>
                                                            <td style="width: 15%; text-align: center;">Discount</td>
                                                            <td style="width: 15%; text-align: center;">Total Price</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($order->items as $i=>$item)
                                                        <tr>
                                                            <td>{{ $item->product_name }}</td>
                                                            <td style="text-align: center;">{{ priceFormat($item->price) }}</td>
                                                            <td style="text-align: center;">{{$item->quantity}}</td>
                                                            <td style="text-align: center;">{{$item->total_coupon_discount}}</td>
                                                            <td style="text-align: center;">{{ priceFormat($item->final_price) }}</td>
                                                        </tr>
                                                        @endforeach

                                                        <tr>
                                                            <td colspan="4" style="text-align: end;">Subtotal</td>
                                                            <td style="text-align: center;">{{ priceFormat($order->total_price) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" style="text-align: end;">Discount</td>
                                                            <td style="text-align: center;">{{ priceFormat($order->coupon_discount + $order->items->sum('total_coupon_discount')) }}</td>
                                                        </tr>
                                                        {{--
                                                        <tr>
                                                            <td colspan="4" style="text-align: end;">Shipping</td>
                                                            <td style="text-align: center;">
                                                                @if($order->shipping_charge>0) {{priceFormat($order->shipping_charge)}} @else Free Shipping @endif
                                                            </td>
                                                        </tr>
                                                        --}}
                                                        <tr>
                                                            <td colspan="4" style="text-align: end;">Grand Total</td>
                                                            <td style="text-align: center;">{{ priceFormat($order->grand_total) }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="frozenTable">
                                            <div class="row">
                                                <div class="col-md-5"></div>
                                                <div class="col-md-7">
                                                    @if($order->payment_status=='paid')
                                                    <div class="paidsStatus" style="text-align: center;">
                                                        <img src="{{asset('public/medies/paid.png')}}" style="max-width: 120px;" />
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="footerInvoice">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p>Thank you for shopping from {{general()->title}}</p>
                                                </div>
                                                <div class="col-md-6" style="text-align: end;">
                                                    ------------------------
                                                    <p>Authorized Sign</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection @push('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js"></script>
<script src="{{asset('public/batikrom/js/inword.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        var date = new Date();
        date.setDate(date.getDate() + 7);

        console.log(date);

        var words = "";

        $(function () {
            var totalamount = Number($("#inWordTotal").data("amount"));
            words = toWords(totalamount);
            $("#inWordTotal")
                .empty()
                .append(words + "Taka only");
        });
    });
</script>

<script src="{{asset('public/app-assets/js/printThis.js')}}"></script>

<script type="text/javascript">
    $("#PrintAction").on("click", function () {
        $(".PrintAreaContact").printThis();
    });
</script>

@endpush