@extends('admin.layouts.app') @section('title')
<title>Today Reports - {{general()->title}} | {{general()->subtitle}}</title>
@endsection @push('css')
<style type="text/css">
    .summeryReport {
        margin-top: 50px;
        padding: 25px;
        border: 1px solid #e7e5e5;
        margin: auto;
    }
    
    .summeryReport table tr td {
        border: 1px solid #eeeeee;
    }
    
</style>
@endpush @section('contents')


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Today Reports</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item active">Today Reports</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <button class="btn btn-success" id="PrintAction" ><i class="fa fa-print"></i> Print</button>
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
                        <h4 class="card-title">Today Reports</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <form action="{{route('admin.reportsAll',$type)}}">
                                        <div class="input-group">
                                            <input type="date" name="startDate" value="{{request()->startDate}}" class="form-control">
                                            <button type="submit" class="btn btn-success rounded-0">Search</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <br>
                                    <div class="summeryReport PrintAreaContact">
                                        <style>
                                            .summeryReport {
                                                width: 350px;
                                                padding: 15px;
                                            }
                                            .table-borderless {
                                                border-collapse: collapse;
                                            }
                                            .table-borderless tr td{
                                                color:black;
                                                padding:5px;
                                            }
                                        </style>
                                        <p style="text-align: center;font-weight: bold;">Report Date : {{$startDate->format('d-m-Y')}}</p>
                                        <h3 style="font-family: sans-serif;color: black;font-weight: bold;"><b>Account Summery</b></h3>
                                        <div class="table table-port">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td style="width:200px;">Online Sale</td>
                                                    <td style="text-align:right;">{{priceFullFormat($reports['todaySale'])}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:200px;">Sale Shipping Charge</td>
                                                    <td style="text-align:right;">{{priceFullFormat($reports['todaySaleShipping'])}}</td>
                                                </tr>
                                                <tr>
                                                    <td>POS Sale</td>
                                                    <td style="text-align:right;">{{priceFullFormat($reports['posSale'])}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Wholesale</td>
                                                    <td style="text-align:right;">{{priceFullFormat($reports['todayWholesale'])}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Return</td>
                                                    <td style="text-align:right;">{{priceFullFormat($reports['todayReturnSale'])}}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Total Sale</b></td>
                                                    <td style="text-align:right;">{{priceFullFormat($reports['todaySale']+$reports['posSale']+$reports['todayWholesale'])}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        
                                        <h3 style="font-family: sans-serif;color: black;font-weight: bold;">Expenses</h3>
                                        <div class="table table-port">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td style="width:200px;">Expense Cost</td>
                                                    <td style="text-align:right;">{{priceFullFormat($reports['todayExpense'])}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        {{--
                                        @if($methods->count() > 0)
                                        <h3 style="font-family: sans-serif;color: black;font-weight: bold;"><b>Payment</b></h3>
                                        <div class="table table-port">
                                            <table class="table table-borderless">
                                                @foreach($methods as $method)
                                                <tr>
                                                    <td style="width:200px;">{{$method->name}}</td>
                                                    <td style="text-align:right;">{{priceFullFormat($method->collection)}}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td><b>Total</b></td>
                                                    <td style="text-align:right;">{{priceFullFormat($methods->sum('collection'))}} </td>
                                                </tr>
                                                
                                            </table>
                                        </div>
                                        @endif
                                        --}}
  
                                        @if($methods1->count() > 0)
                                        <h3 style="font-family: sans-serif;color: black;font-weight: bold;"><b>Online Payment</b></h3>
                                        <div class="table table-port">
                                            <table class="table table-borderless">
                                                @foreach($methods1 as $method)
                                                <tr>
                                                    <td style="width:200px;">{{$method->name}}</td>
                                                    <td style="text-align:right;">{{priceFullFormat($method->collection)}}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td><b>Total</b></td>
                                                    <td style="text-align:right;">{{priceFullFormat($methods1->sum('collection'))}} </td>
                                                </tr>
                                                
                                            </table>
                                        </div>
                                        @endif
                                        @if($methods2->count() > 0)
                                        <h3 style="font-family: sans-serif;color: black;font-weight: bold;"><b>Wholesale Payment</b></h3>
                                        <div class="table table-port">
                                            <table class="table table-borderless">
                                                @foreach($methods2 as $method)
                                                <tr>
                                                    <td style="width:200px;">{{$method->name}}</td>
                                                    <td style="text-align:right;">{{priceFullFormat($method->collection)}}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td><b>Total</b></td>
                                                    <td style="text-align:right;">{{priceFullFormat($methods2->sum('collection'))}} </td>
                                                </tr>
                                                
                                            </table>
                                        </div>
                                        @endif
                                        @if($methods3->count() > 0)
                                        <h3 style="font-family: sans-serif;color: black;font-weight: bold;"><b>POS Payment</b></h3>
                                        <div class="table table-port">
                                            <table class="table table-borderless">
                                                @foreach($methods3 as $method)
                                                <tr>
                                                    <td style="width:200px;">{{$method->name}}</td>
                                                    <td style="text-align:right;">{{priceFullFormat($method->collection)}}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td><b>Total</b></td>
                                                    <td style="text-align:right;">{{priceFullFormat($methods3->sum('collection'))}} </td>
                                                </tr>
                                                
                                            </table>
                                        </div>
                                        @endif
 
                                        
                                        <h3 style="font-family: sans-serif;color: black;font-weight: bold;"><b>Cash Statement</b></h3>
                                        <div class="table table-port">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td style="width:200px;">Previus Cash</td>
                                                    <td style="text-align:right;">{{priceFullFormat($reports['preCash'])}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:200px;">Today Cash</td>
                                                    <td style="text-align:right;">{{priceFullFormat($reports['cash'])}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:200px;">Cash Expenses</td>
                                                    <td style="text-align:right;">{{priceFullFormat($reports['expenses'])}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:200px;">Cash Withdrawal</td>
                                                    <td style="text-align:right;">{{priceFullFormat($reports['withdrawal'])}}</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="width:200px;"><b>Available Cash</b></td>
                                                    <td style="text-align:right;">{{priceFullFormat($reports['available'])}}</td>
                                                </tr>
                                            </table>
                                        </div>
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

<script type="text/javascript">
	$()
</script>

@endpush
