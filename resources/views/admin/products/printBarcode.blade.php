@extends('admin.layouts.app') @section('title')
<title>Products Parcode Print - {{general()->title}} | {{general()->subtitle}}</title>
@endsection @push('css')
<style type="text/css">
    .SearchContain{
        position: relative;
    }
    .searchResultlist {
        position: absolute;
        top: 38px;
        left: 0;
        width: 100%;
        z-index: 9;
	}

	.searchResultlist ul {
	    border: 1px solid #ccd6e6;
	    padding: 0;
	    margin: 0;
	    list-style: none;
	    background: white;
	}

	.searchResultlist ul li {
	    padding: 2px 10px;
	    cursor: pointer;
	    border-bottom: 1px dotted #dcdee0;
	}
    .searchResultlist ul li:hover {
        background: gainsboro;
    }
	.searchResultlist ul li:last-child {
		border-bottom: 0px dotted #dcdee0;
	}
    .printAreaBarcode{
        display:none;
    }
    input.itemUpdate::-webkit-inner-spin-button,
    input.itemUpdate::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0; /* Optional: Remove margin */
    }
    input.itemUpdate {
        -moz-appearance: textfield; /* Firefox */
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jsbarcode/3.5.1/JsBarcode.all.min.js"></script>
@endpush @section('contents')

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Products Barcode Print</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item active">Products Barcode Print</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <button class="btn btn-success" id="PrintAction" ><i class="fa fa-print"></i> Print</button>
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
                        <h4 class="card-title">Products Barcode Print</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body" >
                            <div style="padding:10px;max-width: 960px;">
                                
                                <div class="table-responsive" style="height: 200px;">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="min-width: 50px;width: 50px;" >SL</th>
                                            <th style="min-width: 250px;">Product</th>
                                            <th style="min-width: 100px;width: 100px;">Print</th>
                                        </tr>
                                        @if(!empty($items))
                                        @foreach($items as $k=>$item)
                                            <tr>
                                                <td>
                                                    {{$k+1}}<br>
                                                    <span class="btn btn-sm btn-danger removeBtn" data-url="{{route('admin.productsLabelPrint',['product_id'=>$item['id'],'variant_id'=>$item['variant_id'],'actiontype'=>3])}}" ><i class="fa fa-trash"></i></span>
                                                </td>
                                                <td>{!!$item['name']!!} {{$item['bar_code']}}
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control updateQty" value="{{$item['quantity']}}" data-url="{{route('admin.productsLabelPrint',['product_id'=>$item['id'],'variant_id'=>$item['variant_id'],'actiontype'=>2])}}" placeholder="Qty">
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="3" style="text-align:center;">No item</td>
                                        </tr>
                                        @endif                                
                                    </table>
                                </div>
                                <hr>
                                <a href="{{route('admin.productsLabelPrint',['preview'=>'remove'])}}" class="btn btn-danger btn-md" onclick="return confirm('Are you want to reset?')">Reset</a>
                                <a href="{{route('admin.productsLabelPrint',['preview'=>'view'])}}" class="btn btn-info btn-md" style="float: right;">Refresh</a>
                            </div>
                            
                           <div class="invoice-inner invoicePage PrintAreaContact" >
                                <style type="text/css">
                                    
                                    @media only screen and (max-width: 567px) {

                                    }
                                    
                                    @media print {
                                        body {
                                            background-color: #ffffff;
                                            height: 100%;
                                            overflow: hidden;
                                        }
                                        
                                    }
                                    
                                </style>
                                <div class="invoiceContainer">
                                
                                        <div>
                                            <style>
                                                #barcodeContainer {
                                                    display: -ms-flexbox;
                                                    display: flex;
                                                    -ms-flex-wrap: wrap;
                                                    flex-wrap: wrap;
                                                    padding:0;
                                                    width: 960px;
                                                    max-width:960px;
                                                }
                                        
                                                #barcodeContainer .item {
                                                    /*-ms-flex: 0 0 150px;*/
                                                    /*flex: 0 0 150px;*/
                                                    width: 270px;
                                                    height: 180px;
                                                    text-align: center;
                                                    color: #000;
                                                    padding: 15px 5px;
                                                    /*border: 1px dashed #000;*/
                                                    margin: 10px 15px;
                                                    /*transform: rotate(90deg);*/
                                                    /*margin-left: -60px;*/
                                                    /*margin-bottom: -10px;*/
                                                    /*margin-left: -40px;*/
                                                    /*margin-bottom: -17px;*/
                                                    /*margin-top: 35px;*/
                                                    
                                                }
                                                .item .title {
                                                    display: block;
                                                    font-size: 14px;
                                                    margin-bottom:-4px;
                                                    color:black;
                                                }
                                                .item .title b b {
                                                    font-size: 16px;
                                                }
                                                .item .price {
                                                    display: block;
                                                    font-weight: bold;
                                                }
                                                .item svg {
                                                    width: 65%;
                                                }
                                                .page-break {
                                                    flex-wrap: wrap;
                                                    display: flex;
                                                    page-break-after: always;
                                                    padding:55px 0 0 0;
                                                    width: 960px;
                                                    max-width: 960px;
                                                }
                                            </style>
                                            <div id="barcodeContainer"></div>
                                            
                                            <script>
                                                var products = [];
                                                    @if(!empty($items))
                                                    @foreach($items as $itm)
                                                        for($ii=0; $ii < {{ $itm['quantity'] }}; $ii++){
                                                            products.push({
                                                                id: "{{ $itm['id'] }}",
                                                                name: "{!! $itm['name'] !!}",
                                                                barcode: "{!!$itm['bar_code']!!}",
                                                                price: "{{ $itm['price'] }}",
                                                            });
                                                        }
                                                    @endforeach
                                                    @endif
                                                    
                                                    var $pageDiv = $("<div class='page-break'>");
                                                    
                                                    products.forEach(function(product, index){
                                                        var $barcodeDiv = $("<div class='item'>");
                                                    
                                                        @if($title=='yes')
                                                        $barcodeDiv.append("<span class='title'><b>" + product.name + "</b></span>");
                                                        @endif
                                                    
                                                        $barcodeDiv.append("<svg class='barcode" + product.barcode + "'></svg>");
                                                    
                                                        @if($price=='yes')
                                                        $barcodeDiv.append("<span class='price'>" + product.price + "</span>");
                                                        @endif
                                                    
                                                        $pageDiv.append($barcodeDiv);
                                                    
                                                        // After every 15 products, add the page break div
                                                        if ((index + 1) % 15 === 0 || index === products.length - 1) {
                                                            $("#barcodeContainer").append($pageDiv);
                                                            $pageDiv = $("<div class='page-break'>");
                                                        }
                                                    });
                                                    
                                                    console.log(products);
            
                                                    // Initialize barcodes
                                                    products.forEach(function(product){
                                                        JsBarcode(".barcode" + product.barcode, product.barcode, {
                                                            textAlign: "center",
                                                            textPosition: "center",
                                                            format: "CODE128",
                                                            font: "cursive",
                                                            fontSize: 18,
                                                            height: 40,
                                                            textMargin: 1,
                                                            displayValue: true
                                                        });
                                                    });
                                            
                                                // var products = [];
                                                // @if(!empty($items))
                                                // @foreach($items as $item)
                                                //     for($ii=0;$ii < {{$item['quantity']}};$ii++){
                                                //         products.push({
                                                //             id: {{ $item['id'] }},
                                                //             name: "{!! $item['name'] !!}",
                                                //             barcode: "{{ $item['bar_code'] }}",
                                                //             price: "{{ $item['price'] }}"
                                                //         });
                                                //     }
                                                // @endforeach
                                                // @endif
                                                // // Loop through products array to generate barcodes
                                                // products.forEach(function(product){
                                                //     // Create a new <div> element for each product
                                                //     var $barcodeDiv = $("<div class='item'>");
                                                //     @if($title=='yes')
                                                //     $barcodeDiv.append("<span class='title'><b>" + product.name + "</b></span>");
                                                //     @endif
                                                //     $barcodeDiv.append("<svg class='barcode"+product.id+"'></svg>");
                                                //     @if($price=='yes')
                                                //     $barcodeDiv.append("<span class='price'>" + product.price + "</span>");
                                                //     @endif
                                                //     $barcodeDiv.append("</div>");
                                                //     $("#barcodeContainer").append($barcodeDiv);
                                                // });
                                                // products.forEach(function(product){
                                                // JsBarcode(".barcode"+product.id, product.barcode, {
                                                //         textAlign: "center",
                                                //         textPosition: "center",
                                                //         format: "CODE128",
                                                //         font: "cursive",
                                                //         fontSize: 18,
                                                //         height: 40,
                                                //         textMargin: 1,
                                                //         displayValue: true
                                                //         });
                                                // });
                                                
                                            </script>
                                        </div>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Basic Inputs end -->
</div>

@endsection 

@push('js')

<script>

    $(document).ready(function() {
        $(document).on('change keyup', '.updateQty', function() {
            var url = $(this).data('url');
            var quantity = $(this).val();
            if (isNaN(quantity) || quantity < 1){
                quantity = 1;
            }
            
            $.ajax({
                url: url,
                dataType: 'json',
                cache: false,
                data: {'quantity':quantity},
                success: function(data) {

                },
                error: function() {
                    alert('Error');
                }
            });
            
        });
        
        $(document).on('click', '.removeBtn', function() {
            
            if(confirm('Are you want to remove?')){
                var $btn = $(this);
                var url = $btn.data('url');
                
                $.ajax({
                    url: url,
                    dataType: 'json',
                    cache: false,
                    success: function(data) {
                        $btn.closest('tr').remove();
                    },
                    error: function() {
                        alert('Error');
                    }
                });
                
            }
            
            
        });
        
        
        
        
        
        
        
        
        
        
    });
    
</script>

@endpush
