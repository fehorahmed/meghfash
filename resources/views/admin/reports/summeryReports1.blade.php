@extends('admin.layouts.app') @section('title')
<title>Summery Reports - {{general()->title}} | {{general()->subtitle}}</title>
@endsection @push('css')

@endpush @section('contents')

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Summery Reports</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item active">Summery Report</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <button class="btn btn-success" id="PrintAction" ><i class="fa fa-print"></i> Print</button>
            <a class="btn btn-outline-primary" href="{{route('admin.reportsAll',$type)}}"> <i class="fa-solid fa-rotate"></i> </a>

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
                	<div class="card-header" style="border-bottom: 1px solid #e3ebf3;padding: 1rem;border-top: 2px solid #4859b9;">
                        <h4 class="card-title" style="padding: 5px;">Summery Reports</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="{{route('admin.reportsAll',$type)}}">
                                <div class="row">
                                    <div class="col-md-3" style="padding: 15px">
                                        <input class="form-control" type="date" name="startDate" value="{{$from->format('Y-m-d')}}" placeholder="Start Date">
                                    </div>
                                    <div class="col-md-3" style="padding: 15px">
                                        <input class="form-control" type="date" name="endDate" value="{{$to->format('Y-m-d')}}" placeholder="End Date">
                                    </div>
                                    <div class="col-md-3" style="padding: 15px">
                                        <select class="form-control" name="warehouse">
                                            <option value="">Select Store/Branch</option>
                                            @foreach(App\Models\Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']) as $warehouse)
                                            <option value="{{$warehouse->id}}" {{request()->warehouse==$warehouse->id?'selected':''}} >{{$warehouse->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2" style="padding: 15px">
                                        <button class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="summeryParts PrintAreaContact" style="background: #f8f9f9;padding: 30px;">
                                <style type="text/css">
                                	.summeryPartsbox {
                                        background: #f1f1f1;
                                        padding: 15px;
                                        box-shadow: 4px 7px 7px 0px #ccc;
                                        /*color: #fff;*/
                                        border-radius:10px;
                                    }
                                    
                                    .summeryPartsbox p{
                                        font-family: 'Montserrat';
                                        font-weight: 500;
                                    }
                                    
                                    .summeryPartsbox p b{
                                        font-size: 22px;
                                    }
                                    .rowCustom{
                                        margin:0 -5px;
                                    }
                                    .row.rowCustom .col-2 {
                                        flex: 0 0 14.28571%;
                                        max-width: 14.28571%;
                                        padding:5px;
                                    }
                                    
                                    .summeryParts .table tr td {
                                        padding: 5px 6px;
                                    }
                                    
                                    .summeryParts .table tr th {
                                        padding: 5px 6px;
                                    }
                                </style>
                                <div class="headPart" style="text-align: center;">
                                    <img src="{{asset(general()->logo())}}" style="max-width:250px;" />
                                    <p>
                                        <b>Mobile:</b> {{general()->mobile}}, <b>Email:</b> {{general()->email}} <br>
                                        <b>Address:</b> {{general()->address_one}}
                                    </p>
                                    <p>
                                        Date: @if($from->format('Y-m-d')==$to->format('Y-m-d')) {{$from->format('Y-m-d')}} @else {{$from->format('Y-m-d')}} - {{$to->format('Y-m-d')}} @endif
                                    </p>
                                    
                                </div>
                                
                                <h3>Today Report</h3>    
                                <div class="row rowCustom">
                                    
                                    <div class="col-2">
                                        <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                                            <div style="color: #959595;">Online <small>(BDT)</small></div>
                                            <div style="color: black;font-size: 20px;font-weight: bold;">{{number_format($report['onlineSales'])}}</div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                                            <div style="color: #959595;">POS <small>(BDT)</small></div>
                                            <div style="color: black;font-size: 20px;font-weight: bold;">{{number_format($report['posSales'])}}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-2">
                                        <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                                            <div style="color: #959595;">Wholesale  <small>(BDT)</small></div>
                                            <div style="color: black;font-size: 20px;font-weight: bold;">{{number_format($report['wholesale'])}}</div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                                                <div style="color: #959595;">Stock <small>(BDT)</small></div>
                                                <div style="color: black;font-size: 20px;font-weight: bold;">{{number_format($report['purchase'])}}</div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                                            <div style="color: #959595;">Expenses <small>(BDT)</small></div>
                                            <div style="color: black;font-size: 20px;font-weight: bold;">{{number_format($report['expenses'])}}</div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                                            <div style="color: #959595;">Customer</div>
                                            <div style="color: black;font-size: 20px;font-weight: bold;">{{number_format($report['customer'])}}</div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                                            <div style="color: #959595;">Return <small>(BDT)</small></div>
                                            <div style="color: black;font-size: 20px;font-weight: bold;">{{number_format($report['return'])}}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div style="padding: 15px;background: white;margin-top: 20px;">
                                    <h3>Online Sales List</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Items</th>
                                                    <th>Bill</th>
                                                    <th>Invoice</th>
                                                    <th>Customer</th>
                                                    <th>Date</th>
                                                    <th>Store/Branch</th>
                                                    <th>Profit/Loss</th>
                                                </tr>
                                            </thead>
                                            <trbody>
                                                @foreach($customerOrders as $i=>$pOrder)
                                                <tr>
                                                    <td>{{$i+1}}</td>
                                                    <td>
                                                        @foreach($pOrder->items as $item)
                                                        {{$item->product_name}} X {{$item->quantity}}, {{priceFullFormat($item->price)}} <br>
                                                        @endforeach
                                                    </td>
                                                    <td>{{priceFullFormat($pOrder->total_price -$pOrder->adjustment_amount)}}</td>
                                                    <td>#{{$pOrder->invoice}}</td>
                                                    <td>{{$pOrder->name}}</td>
                                                    <td>{{$pOrder->created_at->format('d-m-Y')}}</td>
                                                    <td>{{$pOrder->branch?$pOrder->branch->name:''}}</td>
                                                    <td>{{priceFullFormat($pOrder->profit_loss)}}</td>
                                                </tr>
                                                @endforeach
                                                @if($customerOrders->count()==0)
                                                <tr>
                                                    <td style="text-align:center;" colspan="8">No Online Sales Order</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{priceFullFormat($customerOrders->sum('total_price')-$customerOrders->sum('adjustment_amount'))}}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{priceFullFormat($customerOrders->sum('profit_loss'))}}</td>
                                                </tr>
                                            </trbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div style="padding: 15px;background: white;margin-top: 20px;">
                                    <h3>POS Sales List</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Items</th>
                                                    <th>Bill</th>
                                                    <th>Invoice</th>
                                                    <th>Customer</th>
                                                    <th>Date</th>
                                                    <th>Store/Branch</th>
                                                    <th>Profit/Loss</th>
                                                </tr>
                                            </thead>
                                            <trbody>
                                                @foreach($posOrders as $i=>$pOrder)
                                                <tr>
                                                    <td>{{$i+1}}</td>
                                                    <td>
                                                        @foreach($pOrder->items as $item)
                                                        {{$item->product_name}} X {{$item->quantity}}<br>
                                                        @endforeach
                                                    </td>
                                                    <td>{{priceFullFormat($pOrder->grand_total)}}</td>
                                                    <td>#{{$pOrder->invoice}}</td>
                                                    <td>{{$pOrder->name}}</td>
                                                    <td>{{$pOrder->created_at->format('d-m-Y')}}</td>
                                                    <td>{{$pOrder->branch?$pOrder->branch->name:''}}</td>
                                                    <td>{{priceFullFormat($pOrder->profit_loss)}}</td>
                                                </tr>
                                                @endforeach
                                                @if($posOrders->count()==0)
                                                <tr>
                                                    <td style="text-align:center;" colspan="8">No POS Sales</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{priceFullFormat($posOrders->sum('grand_total'))}}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{priceFullFormat($posOrders->sum('profit_loss'))}}</td>
                                                </tr>
                                            </trbody>
                                        </table>
                                    </div>
                                </div>
                                
                                
                                <div style="padding: 15px;background: white;margin-top: 20px;">
                                    <h3>Wholesale Sales List</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Items</th>
                                                    <th>Sale</th>
                                                    <th>Due</th>
                                                    <th>Paid</th>
                                                    <th>Customer</th>
                                                    <th style="min-width:115px;">Date</th>
                                                    <th style="min-width:115px;">Store/Branch</th>
                                                    <th>Profit/Loss</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($wholesaleOrders as $i=>$pOrder)
                                                <tr>
                                                    <td>{{$i+1}}</td>
                                                    <td>
                                                        @foreach($pOrder->items as $item)
                                                        {{$item->product_name}} X {{$item->quantity}}, {{priceFullFormat($item->price)}} <br>
                                                        @endforeach
                                                        @if($pOrder->adjustment_amount)
                                                            <b>Adjustment Amount:</b>  (-) {{priceFullFormat($pOrder->adjustment_amount)}}
                                                        @endif
                                                    </td>
                                                    <td>{{priceFullFormat($pOrder->grand_total)}}</td>
                                                    <td>{{priceFullFormat($pOrder->due_amount)}}</td>
                                                    <td>{{priceFullFormat($pOrder->paid_amount)}}</td>
                                                    <td>{{$pOrder->name}}</td>
                                                    <td>{{$pOrder->created_at->format('d-m-Y')}}</td>
                                                    <td>{{$pOrder->branch?$pOrder->branch->name:''}}</td>
                                                    <td>{{priceFullFormat($pOrder->profit_loss)}}</td>
                                                </tr>
                                                @endforeach
                                                @if($wholesaleOrders->count()==0)
                                                <tr>
                                                    <td style="text-align:center;" colspan="9">No Wholesale Order</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{priceFullFormat($wholesaleOrders->sum('grand_total'))}}</td>
                                                    <td>{{priceFullFormat($wholesaleOrders->sum('due_amount'))}}</td>
                                                    <td>{{priceFullFormat($wholesaleOrders->sum('paid_amount'))}}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{priceFullFormat($wholesaleOrders->sum('profit_loss'))}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div style="padding: 15px;background: white;margin-top: 20px;">
                                    <h3>Return Sales List</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Items</th>
                                                    <th>Return Sale</th>
                                                    <th>Customer</th>
                                                    <th style="min-width:115px;">Return Date</th>
                                                    <th style="min-width:115px;">Store/Branch</th>
                                                    <th style="min-width:115px;">Sale Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($returnOrders as $i=>$pOrder)
                                                <tr>
                                                    <td>{{$i+1}}</td>
                                                    <td>
                                                        @if($rerurn =$pOrder->parentOrder)
            						                    @foreach($rerurn->items()->where('return_quantity','>',0)->get() as $i=>$item)
                                                        {{$item->product_name}} X {{$item->return_quantity}}, {{priceFullFormat($item->price)}} <br>
                                                        @endforeach
                                                        @endif
                                                    </td>
                                                    <td>{{priceFullFormat($pOrder->grand_total)}}</td>
                                                    <td>{{$pOrder->name}}</td>
                                                    <td>{{$pOrder->created_at->format('d-m-Y')}}</td>
                                                    <td>
                                                        @if($rerurn =$pOrder->parentOrder)
                                                        {{$rerurn->branch?$rerurn->branch->name:''}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($rerurn =$pOrder->parentOrder)
                                                        {{$rerurn->created_at->format('d-m-Y')}}
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @if($returnOrders->count()==0)
                                                <tr>
                                                    <td style="text-align:center;" colspan="9">No Return Order</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{priceFullFormat($returnOrders->sum('grand_total'))}}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div style="padding: 15px;background: white;margin-top: 20px;">
                                    <h3>Purchases List</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Items</th>
                                                    <th>Sale</th>
                                                    <th>Due</th>
                                                    <th>Paid</th>
                                                    <th>Supplier</th>
                                                    <th style="min-width:115px;">Date</th>
                                                    <th style="min-width:115px;">Store/Branch</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($purchasesOrders as $i=>$pOrder)
                                                <tr>
                                                    <td>{{$i+1}}</td>
                                                    <td>
                                                        @foreach($pOrder->items as $item)
                                                        {{$item->product_name}} X {{$item->quantity}}, {{priceFullFormat($item->price)}} <br>
                                                        @endforeach
                                                        @if($pOrder->adjustment_amount)
                                                            <b>Adjustment Amount:</b>  (-) {{priceFullFormat($pOrder->adjustment_amount)}}
                                                        @endif
                                                    </td>
                                                    <td>{{priceFullFormat($pOrder->grand_total)}}</td>
                                                    <td>{{priceFullFormat($pOrder->due_amount)}}</td>
                                                    <td>{{priceFullFormat($pOrder->paid_amount)}}</td>
                                                    <td>{{$pOrder->name}}</td>
                                                    <td>{{$pOrder->created_at->format('d-m-Y')}}</td>
                                                    <td>{{$pOrder->branch?$pOrder->branch->name:''}}</td>
                                                </tr>
                                                @endforeach
                                                @if($purchasesOrders->count()==0)
                                                <tr>
                                                    <td style="text-align:center;" colspan="8">No Purchases Order</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{priceFullFormat($purchasesOrders->sum('grand_total'))}}</td>
                                                    <td>{{priceFullFormat($purchasesOrders->sum('due_amount'))}}</td>
                                                    <td>{{priceFullFormat($purchasesOrders->sum('paid_amount'))}}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div style="padding: 15px;background: white;margin-top: 20px;">
                                    <h3>Expenses List</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Expense Head</th>
                                                    <th>Amount</th>
                                                    <th>Description</th>
                                                    <th>Expense By</th>
                                                    <th style="min-width:115px;">Date</th>
                                                    <th>Store/Branch</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($expensesOrders as $i=>$expense)
                                                <tr>
                                                    <td>{{$i+1}}</td>
                                                    <td>
                                                        {{$expense->head?$expense->head->name:'Others'}}
                                                    </td>
                                                    <td>{{priceFullFormat($expense->amount)}}</td>
                                                    <td>{!!$expense->description!!}</td>
                                                    <td><span>{{$expense->user?$expense->user->name:''}}</span></td>
                                                    <td>{{$expense->created_at->format('d-m-Y')}}</td>
                                                    <td>{{$expense->warehouse?$expense->warehouse->name:''}}</td>
                                                </tr>
                                                @endforeach
                                                @if($expensesOrders->count()==0)
                                                <tr>
                                                    <td style="text-align:center;" colspan="7">No Expenses </td>
                                                </tr>
                                                @endif  
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{priceFullFormat($expensesOrders->sum('amount'))}}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div style="padding: 15px;background: white;margin-top: 20px;">
                                    <h3>Customer List</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Name</th>
                                                    <th>Mobile/Email</th>
                                                    <th>Total Revenue</th>
                                                    <th style="min-width:115px;">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($customers as $i=>$customer)
                                                <tr>
                                                    <td>{{$i+1}}</td>
                                                    <td>
                                                        {{$customer->name}}
                                                    </td>
                                                    <td>{{$customer->mobile?:$customer->email}}</td>
                                                    <td>{{priceFullFormat($customer->total_revenue)}}</td>
                                                    <td>{{$customer->created_at->format('d-m-Y')}}</td>
                                                </tr>
                                                @endforeach
                                                @if($customers->count()==0)
                                                <tr>
                                                    <td style="text-align:center;" colspan="6">No Customer </td>
                                                </tr>
                                                @endif  
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td> 
                                                    <td>{{priceFullFormat($customers->sum('total_revenue'))}}</td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div style="padding: 15px;background: white;margin-top: 20px;">
                                    <h3>Yearly Total Summery</h3>
                                    <div class="table-responsive">
                                        @php
                                            $totalTotal = 0;
                                            $totalProfit = 0;
                                            $totalOnline = 0;
                                            $totalPos = 0;
                                            $totalWholesale = 0;
                                            $totalPurchase = 0;
                                            $totalExpenses = 0;
                                            $totalCustomer = 0;
                                            $totalReturn = 0;
                                        @endphp
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Month</th>
                                                    <th>Total <small>(Online+POS+Wholesale)</small></th>
                                                    <th>Online Sales</th>
                                                    <th>POS Sales</th>
                                                    <th>Wholesale Sales</th>
                                                    <th>Profit</th>
                                                    <th>Stock</th>
                                                    <th>Expenses</th>
                                                    <th>Customer</th>
                                                    <th>Return</th>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                @foreach($monthlyData as $data)
                                                    @php
                                                        $totalTotal += $data['total'];
                                                        $totalProfit += $data['profitTotal'];
                                                        $totalOnline += $data['onlineTotal'];
                                                        $totalPos += $data['posTotal'];
                                                        $totalWholesale += $data['wholesaleTotal'];
                                                        $totalPurchase += $data['purchaseTotal'];
                                                        $totalExpenses += $data['expensesTotal'];
                                                        $totalCustomer += $data['customerTotal'];
                                                        $totalReturn += $data['returnTotal'];
                                                    @endphp
                                                    <tr>
                                                        <td>{{$data['month']}}</td>
                                                        <td>{{ priceFullFormat($data['total'], 2) }}</td> 
                                                        <td>{{ priceFullFormat($data['onlineTotal'], 2) }}</td>
                                                        <td>{{ priceFullFormat($data['posTotal'], 2) }}</td>
                                                        <td>{{ priceFullFormat($data['wholesaleTotal']) }}</td>
                                                        <td>{{ priceFullFormat($data['profitTotal'], 2) }}</td> 
                                                        <td>{{ priceFullFormat($data['purchaseTotal'], 2) }}</td>
                                                        <td>{{ priceFullFormat($data['expensesTotal'], 2) }}</td>
                                                        <td>{{ priceFormat($data['customerTotal'], 2) }}</td>
                                                        <td>{{ priceFullFormat($data['returnTotal'], 2) }}</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td>Total</td>
                                                    <td>{{priceFullFormat($totalTotal, 2)}}</td>
                                                    <td>{{priceFullFormat($totalOnline, 2)}}</td>
                                                    <td>{{priceFullFormat($totalPos, 2)}}</td>
                                                    <td>{{priceFullFormat($totalWholesale, 2)}}</td>
                                                    <td>{{priceFullFormat($totalProfit, 2)}}</td>
                                                    <td>{{priceFullFormat($totalPurchase, 2)}}</td>
                                                    <td>{{priceFullFormat($totalExpenses, 2)}}</td>
                                                    <td>{{priceFormat($totalCustomer, 2)}}</td>
                                                    <td>{{priceFullFormat($totalReturn, 2)}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
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



@endsection 

@push('js') 


<script type="text/javascript">
	
</script>

@endpush