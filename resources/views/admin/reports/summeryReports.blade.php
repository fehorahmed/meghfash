@extends('admin.layouts.app') @section('title')
<title>Summery Reports - {{general()->title}} | {{general()->subtitle}}</title>
@endsection @push('css')
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
</style>
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
                                    <div class="col-md-2" style="padding: 15px">
                                        <button class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="summeryParts" style="background: #f8f9f9;padding: 30px;">
                                
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
                                <div class="row">
                                    <div class="col-md-3">
                                        <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                                            <div style="color: #959595;">Total Sales <small>(BDT)</small></div>
                                            <div style="color: black;font-size: 20px;font-weight: bold;">{{number_format($report['totalSales'])}}</div>
                                            
                                            @if($report['grothSales'] > 0)
                                            <div style="color: green;">
                                            @else
                                            <div style="color: red;">
                                            @endif
                                            
                                            :{{number_format($report['grothSales'],1)}}
                                            %</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                                            <div style="color: #959595;">POS Sales <small>(BDT)</small></div>
                                            <div style="color: black;font-size: 20px;font-weight: bold;">{{number_format($report['posSales'])}}</div>
                                            @if($report['grothPosSales'] > 0)
                                            <div style="color: green;">
                                            @else
                                            <div style="color: red;">
                                            @endif
                                                :{{number_format($report['grothPosSales'],1)}}
                                                %</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                                            <div style="color: #959595;">Online Sales <small>(BDT)</small></div>
                                            <div style="color: black;font-size: 20px;font-weight: bold;">{{number_format($report['onlineSales'])}}</div>
                                            @if($report['grothOnlineSales'] > 0)
                                            <div style="color: green;">
                                            @else
                                            <div style="color: red;">
                                            @endif
                                                :{{number_format($report['grothOnlineSales'],1)}}
                                                %</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                                            <div style="color: #959595;">Wholesale Sales <small>(BDT)</small></div>
                                            <div style="color: black;font-size: 20px;font-weight: bold;">{{number_format($report['customer'])}}</div>
                                            @if($report['preCustomer'] > 0)
                                            <div style="color: green;">
                                            @else
                                            <div style="color: red;">
                                            @endif
                                                :{{number_format($report['preCustomer'],1)}}
                                                %</div>
                                        </div>
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
                                                </tr>
                                            </thead>
                                            <trbody>
                                                @foreach($posOrders as $i=>$pOrder)
                                                <tr>
                                                    <td>{{$i+1}}</td>
                                                    <td>
                                                        @foreach($pOrder->items as $item)
                                                        {{$item->product_name}} X {{$item->quantity}}, {{priceFullFormat($item->price)}} <br>
                                                        @endforeach
                                                    </td>
                                                    <td>{{priceFullFormat($pOrder->grand_total)}}</td>
                                                    <td>#{{$pOrder->invoice}}</td>
                                                    <td>{{$pOrder->name}}</td>
                                                    <td>{{$pOrder->created_at->format('d-m-Y')}}</td>
                                                </tr>
                                                @endforeach
                                                @if($posOrders->count()==0)
                                                <tr>
                                                    <td style="text-align:center;" colspan="6">No Sales Order</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{priceFullFormat($posOrders->sum('grand_total'))}}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </trbody>
                                        </table>
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
                                                    <th>Sale</th>
                                                    <th>Charge</th>
                                                    <th>Customer</th>
                                                    <th style="min-width:115px;">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($customerOrders as $i=>$pOrder)
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
                                                    <td>{{priceFullFormat($pOrder->grand_total-$pOrder->shipping_charge)}}</td>
                                                    <td>{{priceFullFormat($pOrder->shipping_charge)}}</td>
                                                    <td>{{$pOrder->name}}</td>
                                                    <td>{{$pOrder->created_at->format('d-m-Y')}}</td>
                                                </tr>
                                                @endforeach
                                                @if($customerOrders->count()==0)
                                                <tr>
                                                    <td style="text-align:center;" colspan="6">No Customer Order</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{priceFullFormat($customerOrders->sum('grand_total')-$customerOrders->sum('shipping_charge'))}}</td>
                                                    <td>{{priceFullFormat($customerOrders->sum('shipping_charge'))}}</td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
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
                                                    <th>Customer</th>
                                                    <th style="min-width:115px;">Date</th>
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
                                                    <td>{{$pOrder->name}}</td>
                                                    <td>{{$pOrder->created_at->format('d-m-Y')}}</td>
                                                </tr>
                                                @endforeach
                                                @if($wholesaleOrders->count()==0)
                                                <tr>
                                                    <td style="text-align:center;" colspan="6">No Wholesale Order</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{priceFullFormat($wholesaleOrders->sum('grand_total'))}}</td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div style="padding: 15px;background: white;margin-top: 20px;">
                                    <h3>Yearly Total Sales</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Month</th>
                                                    <th>Total Sales</th>
                                                    <th>POS Sales</th>
                                                    <th>Online Sales</th>
                                                    <th>Wholesale Sales</th>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                @foreach($monthlyData as $data)
                                                    <tr>
                                                        <td>{{$data['month']}}</td>
                                                        <td>{{ priceFullFormat($data['total'], 2) }}</td> 
                                                        <td>{{ priceFullFormat($data['posTotal'], 2) }}</td>
                                                        <td>{{ priceFullFormat($data['onlineTotal'], 2) }}</td>
                                                        <td>{{ priceFullFormat($data['wholesaleTotal']) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                
                                {{--
                                
                                <div class="row">
                                    <div class="col-md-4" style="padding: 15px">
                                        <div class="summeryPartsbox">
                                            <p><b>{{priceFullFormat($report['sales'])}}</b><br>Sales</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="padding: 15px">
                                        <div class="summeryPartsbox">
                                            <p><b>{{priceFullFormat($report['paid'])}}</b><br>Paid</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="padding: 15px">
                                        <div class="summeryPartsbox">
                                            <p><b>{{priceFullFormat($report['unpaid'])}}</b><br>Due</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="padding: 15px">
                                        <div class="summeryPartsbox">
                                            <p><b>{{number_format($report['orders'])}}</b><br>Orders</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="padding: 15px">
                                        <div class="summeryPartsbox">
                                            <p><b>{{number_format($report['pending'])}}</b><br>Pending</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="padding: 15px">
                                        <div class="summeryPartsbox">
                                            <p><b>{{number_format($report['confirmed'])}}</b><br>Confirmed</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="padding: 15px">
                                        <div class="summeryPartsbox">
                                            <p><b>{{number_format($report['delivered'])}}</b><br>Delivered</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="padding: 15px">
                                        <div class="summeryPartsbox">
                                            <p><b>{{number_format($report['shipped'])}}</b><br>Shipped</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="padding: 15px">
                                        <div class="summeryPartsbox">
                                            <p><b>{{number_format($report['cancelled'])}}</b><br>Cancelled</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="padding: 15px">
                                        <div class="summeryPartsbox">
                                            <p><b>{{number_format($report['paidOrder'])}}</b><br>Paid</p>
                                        </div>
                                    </div>
                                </div>
                                --}}
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