@extends('admin.layouts.app') 
@section('title')
<title>Product History - {{general()->title}} | {{general()->subtitle}}</title>
@endsection 
@push('css')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<style type="text/css"></style>
@endpush @section('contents')


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Product History Reports</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item active">Product History</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">

            <a class="btn btn-outline-primary" href="{{route('admin.reportsAll',$type)}}">
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
                        <h4 class="card-title">Product History</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="{{route('admin.reportsAll',$type)}}">
                                <div class="row">
                                    <div class="col-md-5 mb-1">
                                        <div class="input-group">
                                            <input type="date" name="startDate" value="{{request()->startDate}}" class="form-control" />
                                            <input type="date" name="endDate"  value="{{request()->endDate}}" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-1">
                                        <select  name="category" class="form-control" >
                                            <option value="" >Select Category</option>
                                            @foreach($categories as $i=>$ctg)
                                                <option value="{{$ctg->id}}" {{request()->category==$ctg->id?'selected':''}} >{{$ctg->name}}</option>
                                                @foreach($ctg->subctgs as $ctg)
                                                <option value="{{$ctg->id}}" {{request()->category==$ctg->id?'selected':''}}> - {{$ctg->name}}</option>
                                                @foreach($ctg->subctgs as $ctg)
                                                <option value="{{$ctg->id}}" {{request()->category==$ctg->id?'selected':''}}> - - {{$ctg->name}}</option>
                                                @endforeach
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <div class="input-group">
                                            <input type="text" name="search" value="{{request()->search}}" placeholder="Search Product Name, ID" class="form-control" />
                                            <button type="submit" class="btn btn-success rounded-0">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
                            <hr>
                            
                            @if(request()->item_search)
                            <div>
                                
                                <div class="row" style="margin:0 -10px;">
                                    <div class="col-md-6" style="padding:10px;" >
                                        <div style="padding: 20px;border: 1px solid #d2c8c8;">
                                            <h2>Sales Diagram</h2>
                                            <div id="donutchart" style="min-width: 360px;width:100%; min-height: 300;"></div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Sales</th>
                                                        <th style="min-width: 100px;width: 100px;">Qty</th>
                                                        <th style="min-width: 180px;width: 180px;">Amount</th>
                                                    </tr>
                                                    <tr>
                                                        <td>POS Sale</td>
                                                        <td>{{$summery['pos_sale_qty']}}</td>
                                                        <td>{{priceFullFormat($summery['pos_sale_amount'])}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Online Sale</td>
                                                        <td>{{$summery['online_sale_qty']}}</td>
                                                        <td>{{priceFullFormat($summery['online_sale_amount'])}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>whole Sale</td>
                                                        <td>{{$summery['whole_sale_qty']}}</td>
                                                        <td>{{priceFullFormat($summery['whole_sale_amount'])}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total</th>
                                                        <th>{{number_format($summery['pos_sale_qty']+$summery['online_sale_qty']+$summery['whole_sale_qty'])}}</th>
                                                        <th>{{priceFullFormat($summery['pos_sale_amount']+$summery['online_sale_amount']+$summery['whole_sale_amount'])}}</th>
                                                    </tr>
                                                </table>
                                            </div>
                                            
                                            <script type="text/javascript">
                                                  google.charts.load("current", {packages:["corechart"]});
                                                  google.charts.setOnLoadCallback(drawChart);
                                                  function drawChart() {
                                                    var data = google.visualization.arrayToDataTable([
                                                      ['Task', 'Type Of Sale'],
                                                      ['POS',     {{$summery['pos_sale_qty']}}],
                                                      ['Online',      {{$summery['online_sale_qty']}}],
                                                      ['Wholesale',  {{$summery['whole_sale_qty']}}]
                                                    ]);
                                            
                                                    var options = {
                                                      title: 'Product Sales',
                                                      pieHole: 0.2,
                                                    };
                                            
                                                    var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
                                                    chart.draw(data, options);
                                                  }
                                            </script>
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="padding:10px;">
                                        <div style="padding:10px;border: 1px solid #d2c8c8;">
                                            <h2>Quantity Information 
                                            
                                            @if($products->variation_status && Auth::user()->permission_id==1 && $transferHistory==null)
                                            <!--<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#editQty" style="float:right">Edit</button>-->
                                            @endif
                                            </h2>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <th>Wherehouse</th>
                                                        <th>Now Qty</th>
                                                        <th>Sale Qty</th>
                                                        <th>Last Sale Date</th>
                                                    </tr>
                                                    @if($products->variation_status)
                                                        @php
                                                            $totalSalesQty =0;
                                                        @endphp
                                                        
                                                        
                                                        @foreach($products->productVariationAttributeItems()->get() as $vi=>$variationItem)
                                                        <tr>
                                                            <td>{{$products->name}} - {!!$variationItem->variationItemValues()!!}
                                                            
                                                                <!---{{$variationItem->id}}-->
                                                            
                                                                @php
                                                                    
                                                                    $sales = $products->allSales()
                                                                        ->where('variant_id',$variationItem->id)
                                                                        ->whereHas('order', function($q){
                                                                            if(request()->startDate){
                                                                                $q->whereDate('created_at', '>=', request()->startDate);
                                                                            }
                                                                        })
                                                                        ->latest('created_at');
                                                                        
                                                                    $salesQty =$sales->sum('quantity') - $sales->sum('return_quantity');
                                                                    
                                                                    $lastSale =$sales->first();
                                                                    
                                                                    $totalSalesQty +=$salesQty;
                                                                    
                                                                @endphp
                                                            </td>
                                                            <td style="padding:2px;">
                                                                @foreach($products->warehouseStores()->where('variant_id', $variationItem->id)->where('quantity','>',0)->groupBy('branch_id')->selectRaw('branch_id, SUM(quantity) as total_quantity')->get() as $store)
                                                                 <span style="border: 1px solid #d8cfcf;display: inline-block;padding: 1px 5px;border-radius: 5px;margin: 1px 1px;font-size: 14px" {{$store->id}}>   {{$store->branch?$store->branch->name:'Not Found'}} - {{$store->total_quantity}} Qty</span>
                                                                @endforeach
                                                            </td>
                                                            <td>{{$variationItem->quantity}}</td>
                                                            <td>{{$salesQty}}</td>
                                                            <td>
                                                                {{ $lastSale ? $lastSale->created_at->format('d M, Y') : 'No Sale Yet' }}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td></td>
                                                            <td>Total</td>
                                                            <td>{{$products->productVariationAttributeItems()->sum('quantity')}}</td>
                                                            <td>{{$totalSalesQty}}</td>
                                                            <td>={{$products->productVariationAttributeItems()->sum('quantity')+$totalSalesQty}} Qty</td>
                                                        </tr>
                                                    @else
                                                    <tr>
                                                        <td>{{$products->name}}
                                                            @php
                                                                $sales = $products->allSales()
                                                                    ->whereHas('order', function($q){
                                                                        if(request()->startDate){
                                                                            $q->whereDate('created_at', '>=', request()->startDate);
                                                                        }
                                                                    })
                                                                    ->latest('created_at');
                                                                
                                                                $salesQty =$sales->sum('quantity') - $sales->sum('return_quantity');
                                                                    
                                                                $lastSale =$sales->first();
                                                            @endphp
                                                        </td>
                                                        <td>
                                                            @foreach($products->warehouseStores()->where('quantity','>',0)->groupBy('branch_id')->selectRaw('branch_id, SUM(quantity) as total_quantity')->get() as $store)
                                                             <span style="border: 1px solid #d8cfcf;display: inline-block;padding: 1px 5px;border-radius: 5px;margin: 1px 1px;font-size: 14px">   {{$store->branch?$store->branch->name:'Not Found'}} - {{$store->total_quantity}} Qty</span>
                                                            @endforeach
                                                        </td>
                                                        <td>{{$products->quantity}}</td>
                                                        <td>{{$salesQty}}</td>
                                                        <td>
                                                            
                                                            
                                                            {{ $lastSale ? $lastSale->created_at->format('d M, Y') : 'No Sale Yet' }}
                                                        </td>
                                                    </tr>
                                                    @endif
                                                </table>
                                            </div>
                                            
                                            
                                            @if($products->variation_status && Auth::user()->permission_id==1)
                                            <!-- Modal -->
                                            <div class="modal fade text-left" id="editQty" tabindex="-1" >
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{route('admin.reportsAll',$type)}}">
                                                            <input type="hidden" value="{{$products->id}}" name="item_search">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel1">Qty Edit</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times; </span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered">
                                                                        <tr>
                                                                            <th>Stock Item</th>
                                                                            <th style="width: 80px;min-width:80px;">Qty</th>
                                                                        </tr>
                                                                        
                                                                        @foreach($products->warehouseStores as $i=>$stock)
                                                                        <tr>
                                                                            <td>
                                                                                {{$stock->product?$stock->product->name:''}}
                                                                                {!!$stock->variant?$stock->variant->variationItemValues():''!!}
                                                                                <br>
                                                                                <span>{{$stock->branch?$stock->branch->name:'Not Found'}}</span>
                                                                            </td>
                                                                            <td style="text-align: center;">
                                                                                {{$stock->quantity}} <br>
                                                                                <input type="number" name="stock_qty[]" value="{{$stock->quantity}}" placeholder="Qty" style="width: 70px;" />
                                                                            </td>
                                                                        </tr>
                                                                        @endforeach
                                                                    </table>
                                                                    <button type="submit" class="btn btn-success" style="float: right;">Submit</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            
                                        </div>
                                    </div>
                                    
                                    @if($stocksHistory)
                                    <div class="col-md-6" style="padding:10px;">
                                        <div style="padding:10px;border: 1px solid #d2c8c8;">
                                            <h2>Product Stock Inventory</h2>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th style="max-width:140px;width:140px;">Date</th>
                                                        <th>Item</th>
                                                        <th>Qty</th>
                                                        <th>Store/Branch</th>
                                                    </tr>
                                                    @foreach($stocksHistory as $stock)
                                                    <tr>
                                                        <td>{{$stock->order->created_at->format('d-m-Y')}}
                                                        <a href="{{route('admin.purchasesAction',['invoice',$stock->order->id])}}"><i class="fas fa-external-link-alt"></i></a>
                                                        </td>
                                                        <td>
                                                            {{$stock->product?$stock->product->name:$stock->product_name}}
                                                            
                                                            @if(count($stock->itemAttributes()) > 0)
                                    					    -
                                    					    @foreach($stock->itemAttributes() as $i=>$attri)
                                    					        @if(isset($attri['title']) && isset($attri['value']))
                                                                {{$i==0?'':','}} <span><b>{{$attri['title']}}</b> : {{$attri['value']}}</span>
                                                                @endif
                                                            @endforeach
                                                            
                                    					@endif
                                                            
                                                        </td>
                                                        <td>{{$stock->quantity}}</td>
                                                        <td>{{$stock->order->branch?$stock->order->branch->name:'Not Found'}}</td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td></td>
                                                        <td style="text-align:right;" >Stock Total</td>
                                                        <td>{{$stocksHistory->sum('quantity')}}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td style="text-align:right;" >Minus Stock</td>
                                                        <td>{{$stocksMinusHistory->sum('quantity')}}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td style="text-align:right;" ></td>
                                                        <td>{{$stocksHistory->sum('quantity') - $stocksMinusHistory->sum('quantity')}}</td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if($salesHistory)
                                    <div class="col-md-6" style="padding:10px;">
                                        <div style="padding:10px;border: 1px solid #d2c8c8;">
                                            <h2>Product Sales History</h2>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th style="max-width:140px;width:140px;">Date</th>
                                                        <th>Item</th>
                                                        <th>Qty</th>
                                                        <th>R.Qty</th>
                                                        <th style="max-width:170px;width:170px;">Store/Branch</th>
                                                        <th style="max-width:110px;width:110px;">Type</th>
                                                    </tr>
                                                    @foreach($salesHistory as $stock)
                                                    <tr>
                                                        <td>
                                                            {{$stock->order->created_at->format('d-m-Y')}}
                                                            @if($stock->order->order_type=='wholesale_order')
                                                            <a href="{{route('admin.wholeSalesAction',['invoice',$stock->order->id])}}"><i class="fas fa-external-link-alt"></i></a>
                                                            @elseif($stock->order->order_type=='pos_order')
                                                            <a href="{{route('admin.posOrdersAction',['invoice',$stock->order->id])}}"><i class="fas fa-external-link-alt"></i></a>
                                                            @else
                                                            <a href="{{route('admin.invoice',$stock->order->id)}}"><i class="fas fa-external-link-alt"></i></a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{$stock->product?$stock->product->name:$stock->product_name}}
                                                            
                                                            @if(count($stock->itemAttributes()) > 0)
                                    					    -
                                    					    @foreach($stock->itemAttributes() as $i=>$attri)
                                    					        @if(isset($attri['title']) && isset($attri['value']))
                                                                {{$i==0?'':','}} <span><b>{{$attri['title']}}</b> : {{$attri['value']}}</span>
                                                                @endif
                                                            @endforeach
                                                            
                                    					@endif
                                                            
                                                        </td>
                                                        <td>{{$stock->quantity}}</td>
                                                        <td>{{$stock->return_quantity}}</td>
                                                        <td>
                                                            {{$stock->order->branch?$stock->order->branch->name:'Not Found'}}
                                                        </td>
                                                        <td>
                                                        @if($stock->order->order_type=='wholesale_order')
                                                        <span>Wholesale</span>
                                                        @elseif($stock->order->order_type=='pos_order')
                                                        <span>POS Sale</span>
                                                        @else
                                                        <span>Online</span>
                                                        @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td></td>
                                                        <td style="text-align:right;">Total</td>
                                                        <td>{{$salesHistory->sum('quantity')}}</td>
                                                        <td>{{$salesHistory->sum('return_quantity')}}</td>
                                                        <td>={{$salesHistory->sum('quantity') - $salesHistory->sum('return_quantity')}}</td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if($transferHistory)
                                    <div class="col-md-6" style="padding:10px;">
                                        <div style="padding:10px;border: 1px solid #d2c8c8;">
                                            <h2>Product Transfer History</h2>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th style="max-width:140px;width:140px;">Date</th>
                                                        <th>Item</th>
                                                        <th>Qty</th>
                                                        <th>Store/Branch From</th>
                                                        <th>Store/Branch To</th>
                                                    </tr>
                                                    @foreach($transferHistory as $stock)
                                                    <tr>
                                                        <td>{{$stock->order->created_at->format('d-m-Y')}}
                                                        <a href="{{route('admin.stockTransferAction',['invoice',$stock->order->id])}}"><i class="fas fa-external-link-alt"></i></a>
                                                        </td>
                                                        <td>
                                                            {{$stock->product?$stock->product->name:$stock->product_name}}
                                                            
                                                            @if(count($stock->itemAttributes()) > 0)
                                    					    -
                                    					    @foreach($stock->itemAttributes() as $i=>$attri)
                                    					        @if(isset($attri['title']) && isset($attri['value']))
                                                                {{$i==0?'':','}} <span><b>{{$attri['title']}}</b> : {{$attri['value']}}</span>
                                                                @endif
                                                            @endforeach
                                                            
                                    					@endif
                                                            
                                                        </td>
                                                        <td>{{$stock->quantity}}</td>
                                                        <td>{{$stock->order->formBranch?$stock->order->formBranch->name:'Not Found'}}</td>
                                                        <td>{{$stock->order->branch?$stock->order->branch->name:'Not Found'}}</td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td></td>
                                                        <td style="text-align:right;" >Total</td>
                                                        <td>{{$transferHistory->sum('quantity')}}</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if($stocksMinusHistory)
                                    <div class="col-md-6" style="padding:10px;">
                                        <div style="padding:10px;border: 1px solid #d2c8c8;">
                                            <h2>Product Stock Minus History</h2>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th style="max-width:140px;width:140px;">Date</th>
                                                        <th>Item</th>
                                                        <th>Qty</th>
                                                        <th>Note</th>
                                                        <th>Store/Branch</th>
                                                    </tr>
                                                    @foreach($stocksMinusHistory as $stock)
                                                    <tr>
                                                        <td>{{$stock->order->created_at->format('d-m-Y')}}
                                                        <a href="{{route('admin.stockMinusAction',['invoice',$stock->order->id])}}"><i class="fas fa-external-link-alt"></i></a>
                                                        </td>
                                                        <td>
                                                            {{$stock->product?$stock->product->name:$stock->product_name}}
                                                            
                                                            @if(count($stock->itemAttributes()) > 0)
                                    					    -
                                    					    @foreach($stock->itemAttributes() as $i=>$attri)
                                    					        @if(isset($attri['title']) && isset($attri['value']))
                                                                {{$i==0?'':','}} <span><b>{{$attri['title']}}</b> : {{$attri['value']}}</span>
                                                                @endif
                                                            @endforeach
                                                            
                                    					@endif
                                                            
                                                        </td>
                                                        <td>{{$stock->quantity}}</td>
                                                        <td>{{$stock->order->note}}</td>
                                                        <td>{{$stock->order->branch?$stock->order->branch->name:'Not Found'}}</td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td></td>
                                                        <td style="text-align:right;" >Total</td>
                                                        <td>{{$stocksMinusHistory->sum('quantity')}}</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    {{--
                                    <div class="col-md-12" style="padding:10px;">
                                        <div style="padding:10px;border: 1px solid #d2c8c8;">
                                            <h2>All Data History</h2>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th style="max-width:140px;width:140px;">Date</th>
                                                        <th>Item</th>
                                                        <th>Stock In</th>
                                                        <th>Transfer</th>
                                                        <th>Online</th>
                                                        <th>Wholesale</th>
                                                        <th>POS Sale</th>
                                                        <th style="max-width:170px;width:170px;">Store/Branch</th>
                                                        <th style="max-width:110px;width:110px;">Type</th>
                                                    </tr>
                                                    @foreach($allHistory as $stock)
                                                    <tr>
                                                        <td>
                                                            {{$stock->order->created_at->format('d-m-Y')}}
                                                            @if($stock->order->order_type=='wholesale_order')
                                                            <a href="{{route('admin.wholeSalesAction',['invoice',$stock->order->id])}}"><i class="fas fa-external-link-alt"></i></a>
                                                            @elseif($stock->order->order_type=='pos_order')
                                                            <a href="{{route('admin.posOrdersAction',['invoice',$stock->order->id])}}"><i class="fas fa-external-link-alt"></i></a>
                                                            @elseif($stock->order->order_type=='purchase_order')
                                                            <a href="{{route('admin.purchasesAction',['invoice',$stock->order->id])}}"><i class="fas fa-external-link-alt"></i></a>
                                                            @elseif($stock->order->order_type=='transfers_order')
                                                            <a href="{{route('admin.stockTransferAction',['invoice',$stock->order->id])}}"><i class="fas fa-external-link-alt"></i></a>
                                                            @else
                                                            <a href="{{route('admin.invoice',$stock->order->id)}}"><i class="fas fa-external-link-alt"></i></a>
                                                            @endif
                                                        </td>
                      
                                                        <td>
                                                            {{$stock->product?$stock->product->name:$stock->product_name}}
                                                            
                                                            @if(count($stock->itemAttributes()) > 0)
                                    					    -
                                    					    @foreach($stock->itemAttributes() as $i=>$attri)
                                    					        @if(isset($attri['title']) && isset($attri['value']))
                                                                {{$i==0?'':','}} <span><b>{{$attri['title']}}</b> : {{$attri['value']}}</span>
                                                                @endif
                                                            @endforeach
                                                            
                                    					@endif
                                                            
                                                        </td>
                                                        <td>
                                                            @if($stock->order->order_type=='purchase_order')
                                                            {{$stock->quantity}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($stock->order->order_type=='transfers_order')
                                                            {{$stock->quantity}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($stock->order->order_type=='customer_order')
                                                            {{$stock->quantity}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($stock->order->order_type=='wholesale_order')
                                                            {{$stock->quantity}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($stock->order->order_type=='pos_order')
                                                            {{$stock->quantity}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{$stock->order->branch?$stock->order->branch->name:'Not Found'}}
                                                        </td>
                                                        <td>
                                                        @if($stock->order->order_type=='wholesale_order')
                                                        <span>Wholesale</span>
                                                        @elseif($stock->order->order_type=='purchase_order')
                                                        <span>Stock In</span>
                                                        @elseif($stock->order->order_type=='pos_order')
                                                        <span>POS Sale</span>
                                                        @elseif($stock->order->order_type=='transfers_order')
                                                        <span>Transfer</span>
                                                        @else
                                                        <span>Online</span>
                                                        @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td></td>
                                                    
                                                        <td style="text-align:right;">Total</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    --}}
                                </div>
                            </div>
                            @elseif(request()->startDate || request()->endDate || request()->category || request()->search)
                            
                            <h2 style="color: #0ab90a;font-weight: bold;font-family: sans-serif;">Products List</h2>
                            
                            <div class="table-responsive">
                                
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 50px;min-width: 50px;">SL</th>
                                        <th style="min-width: 60px;width:60px;padding:7px 5px;">Image</th>
                                        <th style="min-width: 300px;">Product Information</th>
                                        <th style="width: 100px;min-width: 100px;">Now Qty</th>
                                        <th style="width: 100px;min-width: 100px;">Sale Qty </th>
                                        <th style="width: 100px;min-width: 100px;"> Sale Amount </th>
                                        <th style="width: 100px;min-width: 100px;"> Last Sold Date </th>
                                    </tr>
                                    @foreach($products as $i=>$product)
                                    <tr>
                                        <td>{{$i+1}}</td>
                                        <td style="padding:1px;text-align: center;">
                                            <img src="{{asset($product->image())}}" style="max-height:35px;max-width:60px;" />
                                        </td>
                                        <td>
                                            {{$product->name}}
                                            <a href="{{route('admin.reportsAll',[$type,'item_search'=>$product->id])}}"><i class="fas fa-external-link-alt"></i></a>
                                        </td>
                                        <td>{{number_format($product->quantity)}}</td>
                                        <td>{{number_format($product->total_sales_quantity)}}</td>
                                        <td>{{number_format($product->total_sales_amount)}}</td>
                                        <td>
                                            @php
                                                $lastSale = $product->allSales()
                                                    ->whereHas('order', function($q){
                                                        if(request()->startDate){
                                                            $q->whereDate('created_at', '>=', request()->startDate);
                                                        }
                                                    })
                                                    ->latest('created_at')
                                                    ->first();
                                            @endphp
                                            
                                            {{ $lastSale ? $lastSale->created_at->format('d M, Y') : 'No Sale Yet' }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    
                                </table>
                                
                            </div>
                            
                            @else
                            
                            
                            <h2 style="color: #0ab90a;font-weight: bold;font-family: sans-serif;">Top Sales 20 Products</h2>
                            
                            <div class="table-responsive">
                                
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 50px;min-width: 50px;">SL</th>
                                        <th style="min-width: 60px;width:60px;padding:7px 5px;">Image</th>
                                        <th style="min-width: 300px;">Product Information</th>
                                        <th style="width: 100px;min-width: 100px;">Now Qty</th>
                                        <th style="width: 100px;min-width: 100px;">Sale Qty </th>
                                        <th style="width: 100px;min-width: 100px;"> Sale Amount </th>
                                        <th style="width: 100px;min-width: 100px;"> Last Sold Date </th>
                                    </tr>
                                    @foreach($products as $i=>$product)
                                    <tr>
                                        <td>{{$i+1}}</td>
                                        <td style="padding:1px;text-align: center;">
                                            <img src="{{asset($product->image())}}" style="max-height:35px;max-width:60px;" />
                                        </td>
                                        <td>{{$product->name}}
                                        
                                        <a href="{{route('admin.reportsAll',[$type,'item_search'=>$product->id])}}"><i class="fas fa-external-link-alt"></i></a>
                                        </td>
                                        <td>{{number_format($product->quantity)}}</td>
                                        <td>{{number_format($product->total_sales_quantity)}}</td>
                                        <td>{{number_format($product->total_sales_amount)}}</td>
                                        <td>
                                            {{ $product->lastSale ?$product->lastSale->created_at->format('d M, Y') : 'No Sale Yet' }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    
                                </table>
                                
                            </div>
                            @endif

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


@endpush
