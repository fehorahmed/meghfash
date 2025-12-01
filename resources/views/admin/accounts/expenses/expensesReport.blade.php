@extends('admin.layouts.app') @section('title')
<title>Expenses Report - {{general()->title}} | {{general()->subtitle}}</title>
@endsection @push('css')
<style type="text/css"></style>
@endpush @section('contents')

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Expenses Report</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item active">Expenses Report</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            
            <a class="btn btn-outline-primary" href="{{route('admin.expensesList')}}">
                Back
            </a>
            <button class="btn btn-success" id="PrintAction" ><i class="fa fa-print"></i> Print</button>
            <a class="btn btn-outline-primary" href="{{route('admin.expensesReports')}}">
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
                    <div class="card-content">

                            <div id="accordion">
                                <div
                                    class="card-header collapsed"
                                    data-toggle="collapse"
                                    data-target="#collapseTwo"
                                    aria-expanded="false"
                                    aria-controls="collapseTwo"
                                    id="headingTwo"
                                    style="background: #009688;padding: 10px; cursor: pointer; border: 1px solid #00b5b8;"
                                >
                                    Search click Here..
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="border: 1px solid #00b5b8; border-top: 0;">
                                    <div class="card-body">
                                        <form action="{{route('admin.expensesReports')}}">
                                            <div class="row">
                                                <div class="col-md-3 mb-0">
                                                    <div class="form-group">
                                                        <select class="form-control" name="type">
                                                            <option value="">All Type</option>
                                                            @foreach($types as $type)
                                                            <option value="{{$type->id}}" {{request()->type==$type->id?'selected':''}}>{{$type->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-0">
                                                    <div class="form-group">
                                                        <select class="form-control" name="warehouse_id">
                                                            <option value="">Select Store/Branch</option>
                                                            @foreach(App\Models\Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']) as $warehouse)
                                                            <option value="{{$warehouse->id}}" {{request()->warehouse_id==$warehouse->id?'selected':''}}>{{$warehouse->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-0">
                                                    <div class="input-group">
                                                        <input type="date" name="startDate" value="{{$from->format('Y-m-d')}}" class="form-control {{$errors->has('startDate')?'error':''}}" />
                                                        <input type="date" value="{{$to->format('Y-m-d')}}" name="endDate" class="form-control {{$errors->has('endDate')?'error':''}}" />
                                                        <button type="submit" class="btn btn-success rounded-0">Search</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                       
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                        <h4 class="card-title">Expenses Report</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            
                            
                            
                            <div class="invoice-inner invoicePage PrintAreaContact">
                                <style>
                                    .invoicePage{
                                        background:white;
                                    }
                                    .costAmount {
                                            border: 1px solid #e5e3e2;
                                            padding: 10px 15px;
                                            border-radius: 10px;
                                            /*height: 100px;*/
                                        }
                                        
                                        .costAmount h4 {
                                            font-weight: bold;
                                            font-family: sans-serif;
                                            height: 40px;
                                        }
                                </style>
                                
                                <div style="text-align:center;">
                                    <img src="{{asset(general()->logo())}}" style="max-height:60px;">
                                    <p>
                                        <b>Mobile:</b> {{general()->mobile}} <b>Email:</b> {{general()->mobile}}<br>
                                        <b>Location:</b> {{general()->address_one}}
                                    </p>
                                    <h4 style="font-weight: bold;">Expenses Report</h4>
                                    <h3>Date: 
                                    @if($from->format('Y-m-d')==$to->format('Y-m-d'))
                                    {{$from->format('d M, Y')}}
                                    @else
                                    {{$from->format('d M, Y')}} - {{$to->format('d M, Y')}}
                                    @endif
                                    </h3>
                                </div>
                                
                                <div class="row" style="margin:0 -5px;">
                                    <div class="col-md-3 col-3" style="padding:5px;">
                                        <div class="costAmount">
                                            <h4>Total</h4>
                                            <span>{{priceFullFormat($expenses->sum('amount'))}} <i class="fas fa-chart-line" style="color: green;"></i></span>
                                        </div>
                                    </div>
                                    @foreach($types as $type)
                                    <div class="col-md-3 col-3" style="padding:5px;">
                                        <div class="costAmount">
                                            <h4>{{Str::limit($type->name,40)}}</h4>
                                            <span>{{priceFullFormat($expenses->where('type_id',$type->id)->sum('amount'))}} <i class="fas fa-chart-line" style="color: green;"></i></span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                
                                  <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="min-width: 120px;width: 120px;">Date</th>
                                                <th style="min-width: 200px;width: 200px;">Expense Head</th>
                                                <th style="min-width: 150px;width: 150px;">Amount</th>
                                                <th style="min-width: 200px;">Description</th>
                                                <th style="min-width: 150px;width: 150px;">Expense By</th>
                                                <th style="min-width: 150px;width: 150px;">Store/Branch</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($expenses as $i=>$expense)
                                            <tr>
                                                <td>
                                                    <span>{{$expense->created_at->format('d-m-Y')}}</span>
                                                </td>
                                                <td>
                                                    @if($expense->imageFile)
                                                    <a href="{{asset($expense->imageFile->file_url)}}" target="_blank"><i class="fas fa-external-link-alt"></i></a>
                                                    @endif
                                                    <span>{{$expense->head?$expense->head->name:'Others'}}</span>
                                                    
                                                </td>
                                                <td>
                                                    <span>{{priceFullFormat($expense->amount)}}</span>
                                                </td>
                                                <td>
                                                    {!!$expense->description!!}
                                                </td>
                                                <td>
                                                    <span>{{$expense->user?$expense->user->name:''}}</span>
                                                </td>
                                                <td>
                                                    <span>{{$expense->warehouse?$expense->warehouse->name:''}}</span>
                                                </td>
                                            </tr>
                                            @endforeach
                                            
                                            @if($expenses->count()==0)
                                            <tr>
                                                <td style="text-align:center;" colspan="7">No Expense</td>
                                            </tr>
                                            
                                            @else
                                            <tr>
                                                <td></td>
                                                <td>Total</td>
                                                <td>{{priceFullFormat($expenses->sum('amount'))}}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @endif
                                            
                                        </tbody>
                                        
                                    </table>
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



@endsection @push('js') @endpush
