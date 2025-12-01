@extends(adminTheme().'layouts.app') @section('title')
<title>{{websiteTitle('Sales Reports')}}</title>
@endsection @push('css')
<style type="text/css">
    
    .summery p{
        margin-bottom: 5px;
        color:gray;
    }
    
    .summery h5{
        font-weight: bold;
        font-family: sans-serif;
        color: #4a4a4a;
    }
    
</style>
@endpush @section('contents')


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Sales Reports</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item active">Sales Reports</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <button class="btn btn-success" id="PrintAction" ><i class="fa fa-print"></i> Print</button>
            <a class="btn btn-outline-primary" href="{{route('admin.posOrdersReports')}}">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>

@include('admin.alerts')
<div class="card">
    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
        <h4 class="card-title">Sales Reports</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form action="{{route('admin.posOrdersReports')}}">
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <div class="input-group">
                            <input type="date" name="startDate" value="{{$from->format('Y-m-d')}}" class="form-control {{$errors->has('startDate')?'error':''}}" />
                            <input type="date" value="{{$to->format('Y-m-d')}}" name="endDate" class="form-control {{$errors->has('endDate')?'error':''}}" />
                            <button type="submit" class="btn btn-success rounded-0"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                </div>
            </form>
            
            <br>
            <div class="invoice-inner invoicePage PrintAreaContact">
                
                    
                <style type="text/css">
                .invoicePage{
                    background:white;
                }
                </style>
                <div style="text-align:center;">
                    <img src="{{asset(general()->logo())}}" style="max-height:60px;">
                    <p>
                        <b>Mobile:</b> {{general()->mobile}} <b>Email:</b> {{general()->mobile}}<br>
                        <b>Location:</b> {{general()->address_one}}
                    </p>
                    <h3>Date: {{Carbon\Carbon::now()->format('d M, Y')}}</h3>
                </div>
                <div class="row" style="margin:0 -10px;">
                    <div class="col-md-3 col-3" style="padding:10px;">
                        <div class="card">
                            <div class="card-header" style="padding: 8px 15px;background: #4859b9;color:white;">
                                <h3 style="margin:0;">Total Sale</h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width:120px;">Total</th>
                                        <td>{{number_format($totalOrders->sum('grand_total'))}}</td>
                                    </tr>
                                    <tr>
                                        <th>Card</th>
                                        <td>{{number_format($totalOrders->sum('total_card'))}}</td>
                                    </tr>
                                    <tr>
                                        <th>Mobile B.</th>
                                        <td>{{number_format($totalOrders->sum('total_mobile'))}}</td>
                                    </tr>
                                    <tr>
                                        <th>Cash</th>
                                        <td>
                                            @if($totalOrders->sum('total_cash') >= $totalOrders->sum('changed_amount'))
                                            {{number_format($totalOrders->sum('total_cash')-$totalOrders->sum('changed_amount'))}}
                                            @else
                                            {{number_format($totalOrders->sum('total_cash'))}}
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-3" style="padding:10px;">
                        <div class="card">
                            <div class="card-header" style="padding: 8px 15px;background: #4859b9;color:white;">
                                <h3 style="margin:0;">Card</h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    @foreach($accountsMethods->where('location','card_method') as $card)
                                    <tr>
                                        <th style="width:120px;">{{$card->name}}</th>
                                        <td>{{priceFormat(reoportSummery($from,$to,'card',$card->id))}}</td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-3" style="padding:10px;">
                        <div class="card">
                            <div class="card-header" style="padding: 8px 15px;background: #4859b9;color:white;">
                                <h3 style="margin:0;">POS Receiver</h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    @foreach($accountsMethods->where('location','pos_method') as $pos)
                                    <tr>
                                        <th style="width:120px;">{{$pos->name}}</th>
                                        <td>{{priceFormat(reoportSummery($from,$to,'posmachine',$pos->id))}}</td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-3" style="padding:10px;">
                        <div class="card">
                            <div class="card-header" style="padding: 8px 15px;background: #4859b9;color:white;">
                                <h3 style="margin:0;">Mobile Banking</h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    @foreach($accountsMethods->where('location','mobile_banking') as $mobile)
                                    <tr>
                                        <th style="width:120px;">{{$mobile->name}}</th>
                                        <td>{{priceFormat(reoportSummery($from,$to,'mobile',$mobile->id))}}</td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header" style="padding: 8px 15px;background: #4859b9;color:white;">
                        <h3 style="margin:0;">Sales List</h3>
                    </div>
                    @foreach($orders as $salespersonId => $salesOrders)
                        @php
                            $salesperson = $salesOrders->first()->soldBy; // Get salesperson details
                            $totalCash = 0;
                            $totalCard = 0;
                            $totalMobile = 0;
                            $totalReceived = 0;
                            $totalRemaining = 0;
                        @endphp
                    
                        <h3 style="font-family: sans-serif;">Sold By: <span style="font-weight: bold;">{{ $salesperson->name ?? 'Unknown' }}</span></h3>
                    
                        <div class="table-responsiv">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#Invoice</th>
                                        <th style="min-width: 150px;">Customer</th>
                                        <th>Items</th>
                                        <th>VAT</th>
                                        <th>Discount</th>
                                        <th>Bill</th>
                                        <th>Cash</th>
                                        <th>Card</th>
                                        <th>Mobile</th>
                                        <th>Received</th>
                                        <th>Change</th>
                                        <th style="min-width: 120px;">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($salesOrders as $order)
                                        @php
                                            $cash = $order->transections->where('payment_method', 'Cash Method')->sum('received_amount');
                                            $card = $order->transections->where('payment_method', 'Card Method')->sum('received_amount');
                                            $mobile = $order->transections->where('payment_method', 'Mobile Method')->sum('received_amount');
                                            $received = $order->transections->sum('received_amount');
         
                                            if($received > $order->grand_total){
                                            $remaining = $received - $order->grand_total;
                                            }else{
                                            $remaining = 0;
                                            }
                                            
                    
                                            $totalCash += $cash;
                                            $totalCard += $card;
                                            $totalMobile += $mobile;
                                            $totalReceived += $received;
                                            $totalRemaining += $remaining;
                                        @endphp
                    
                                        <tr>
                                            <td>#{{ $order->invoice }}</td>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->items()->sum('quantity') }}</td>
                                            <td>{{ number_format($order->tax_amount) }}</td>
                                            <td>{{ number_format($order->discount_amount) }}</td>
                                            <td>{{ number_format($order->grand_total,0) }}</td>
                                            <td>{{ number_format($cash) }}</td>
                                            <td>{{ number_format($card) }}</td>
                                            <td>{{ number_format($mobile) }}</td>
                                            <td>{{ number_format($received,0) }}</td>
                                            <td>{{ intval($remaining) }}</td>
                                            <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                    
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Total</th>
                                        <th>{{ number_format($salesOrders->sum('total_qty')) }}</th>
                                        <th>{{ priceFormat($salesOrders->sum('tax_amount')) }}</th>
                                        <th>{{ priceFormat($salesOrders->sum('discount_amount')) }}</th>
                                        <th>{{ priceFormat($salesOrders->sum('grand_total')) }}</th>
                                        <th>{{ number_format($totalCash) }}</th>
                                        <th>{{ number_format($totalCard) }}</th>
                                        <th>{{ number_format($totalMobile) }}</th>
                                        <th>{{ number_format($totalReceived) }}</th>
                                        <th>{{ intval($totalRemaining) }}</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @endforeach
                </div>
            </div>
            
        </div>
    </div>
</div>


@endsection @push('js') @endpush