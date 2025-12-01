@extends(adminTheme().'layouts.app')
 @section('title')
<title>Stock Minus Invoice</title>
@endsection 
@push('css')
<style type="text/css">
    
</style>
@endpush 

@section('contents')

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Stock Minus invoice</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item active">Stock Minus invoice</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="{{route('admin.stockMinus')}}"><i class="fa fa-list"></i> Back</a>
            <a class="btn btn-outline-primary" href="{{route('admin.stockMinusAction',['edit',$invoice->id])}}"><i class="fa fa-edit"></i> Edit</a>
            <a href="javascript:void(0)" id="PrintAction22" class="btn btn-outline-primary">
                 <i class="bx bx-printer"></i> Print
             </a>
            <a class="btn btn-outline-primary" href="{{route('admin.stockMinusAction',['invoice',$invoice->id])}}">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>

<div class="content-body">
    <!-- Basic Elements start -->
    <section class="basic-elements">
        <div class="row">
            <div class="col-md-12">
			@include('admin.alerts')
            	<div class="card">
                    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                        <h4 class="card-title">Stock Minus Invoice</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                         <div class="invoice-inner invoicePage PrintAreaContact">
                            <style>
                                    .demo-info {
                                        text-align: center;
                                    }
                                
                                    .invoice-products table tr th {
                                        padding: 5px;
                                        font-size: 12px;
                                    }
                                    .invoice-products table tr td {
                                        padding: 2px 5px;
                                        text-align: center;
                                    }
                                    .terms-details{
                                        font-size: 14px;
                                    }
                                    .terms-details p {
                                        margin: 0;
                                        font-size: 11px;
                                        font-family: times new romance;
                                    }
                                    .invoice-info {
                                        text-align: right;
                                    }
                                    .footer-part{
                                        margin-top: 20px;
                                        text-align:center;
                                    }
                                    .footer-part p {
                                        font-size: 11px;
                                    }
                                    .footer-part p i.bx {
                                        font-weight: bold;
                                    }
                                    
                                    @media print {
                                        .table{
                                            border-collapse: collapse !important;
                                            margin-bottom: 15px;
                                        }
                                        .table-bordered td, .table-bordered th {
                                            border: 1px solid #dee2e6 !important;
                                        }
                                        .footer-part p {
                                            font-size: 10px !important;
                                        }
                                    }
                                    
                                    </style>
                            
                                    <div class="demo-info">
                                            <img src="{{asset(general()->logo())}}" alt="company-logo" style="max-width:400px;max-height: 100px;">
                                            <h6 style="font-size: 20px;border-top: 1px solid #cccccc;padding-top: 5px;margin:0;font-weight: bold;">STOCK MINUS INVOICE</h6>
                                    </div>
                                <div class="row">
                                    <div class="col-12">
                                        
                                    </div>
                                    <div class="col-4">
                                            <b>Invoice:</b> {{$invoice->invoice}}<br>
                                            <b>Date:</b> {{$invoice->created_at->format('d.m.Y')}}<br>
                                            <b>Status:</b> {{ucfirst($invoice->order_status)}}<br>
                                    </div>
                                    <div class="col-4"></div>
                                    <div class="col-4">
                                        <div class="invoice-info">
                                            <b>To Warehouse</b>: {{$invoice->branch?$invoice->branch->name:''}}<br>
                                            {{$invoice->branch?$invoice->branch->description:''}}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="invoice-products">
                                    <br>
                                    <table class="table table-bordered" style="width: 100% !important;">
                                        <thead>
                                        <tr>
                                            <th style="width: 60px;min-width: 60px;text-align: center;">SL.</th>
                                            <th style="min-width: 300px;text-align: left;">PRODUCT NAME</th>
                                            <th style="width: 100px;min-width: 100px;text-align: center;">QUANTITY</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($invoice->items as $i=>$item)
                                            <tr>
                                                <td>{{$i+1}}</td>
                                                <td style="text-align: left;">
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
                                                <td>{{$item->quantity}}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan="2" style="text-align: end;font-size:16px;">Total QTY</th>
                                            <th style="text-align: center;font-size:16px;">{{priceFormat($invoice->items->sum('quantity'))}}</th>
                                        </tr>
                                        </tbody>
                                    </table>
                                    
                                    <div class="terms-details" >
                                        @if($invoice->note)
                                        <span><b>PURCHASES NOTE:</b></span>
                                        <br>
                                        {!!$invoice->note!!}
                                        @endif
                                    </div>
                                    
                                    <div class="signature-part">
                                        <div class="row">
                                            <div class="col-6"><br><br>
                                                ------------------<br>
                                                <span style="font-size: 12px;"><b>RECEIVER'S SIGNATURE</b></span>
                                            </div>
                                            <div class="col-6" style="text-align: end;">
                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer-part">
                                        <p>@if(general()->address_one)<i class="bx bx-map"></i> Office: {{general()->address_one}}, @endif @if(general()->mobile) <i class="bx bx-phone"></i> Phone: {{general()->mobile}} @endif @if(general()->email) <i class="bx bx-envelope"></i> {{general()->email}} @endif<br> @if(general()->address_two) <i class="bx bx-map"></i>Factory: {{general()->address_two}}, @endif @if(general()->mobile2) <i class="bx bx-phone"></i> Phone: {{general()->mobile2}} @endif @if(general()->email2)<i class="bx bx-envelope"></i> factory: {{general()->email2}} @endif @if(general()->website) <i class='bx bx-globe'></i> {{general()->website}} @endif</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


@endsection @push('js')

<script>
    $(document).ready(function(){
        $('#PrintAction22').on("click", function () {
            $('.PrintAreaContact').printThis({
              	importCSS: false,
              	loadCSS: "https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap-grid.min.css",
            });
        });
    });
</script>

@endpush