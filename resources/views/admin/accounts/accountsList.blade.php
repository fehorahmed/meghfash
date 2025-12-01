@extends('admin.layouts.app') @section('title')
<title>Accounts - {{general()->title}}{{general()->title && general()->subtitle?' | ':''}}{{general()->subtitle}}</title>
@endsection @push('css')
<style type="text/css">
    .summeryInfo span.amount {
    font-size: 25px;
    color: #4aab4e;
}

.summeryInfo {
    border: 1px solid #e9e4e4;
    /*box-shadow: -2px -3px 6px 1px #b2a5a5;*/
    background:white;
    padding: 10px;
}

.summeryInfo span {
    font-size: 50px;
    color: #3f51b5;
}

.summeryInfo p {
    color: #3f51b5;
    font-weight: bold;
}
.infoDetails{
    cursor:pointer;
}
</style>
@endpush @section('contents')


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Accounts List</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item active">Accounts List</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="{{route('admin.accountsList',['type'=>'add-method'])}}">
                <i class="fa-solid fa-money"></i> Add Method
            </a>
            <a class="btn btn-outline-primary" href="{{route('admin.accountsList')}}">
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
                <div class="row">
                    @php
                    $totals =0;
                    @endphp
                    @foreach($methods as $method)
	                <div class="col-md-4" style="padding:15px;">
	                    <div class="summeryInfo">
	                        <div class="row">
	                            <div class="col-md-8">
	                                <span class="amount"
	                                
	                                @if($method->amounts<0)
	                                style="color:#ff2946;"
	                                @endif
	                                >
	                               @php
	                               $totals +=$method->amounts;
	                               @endphp
	                               {{priceFullFormat($method->amounts)}}</span>
	                                <p>{{$method->name}}</p>
	                            </div>
	                            <div class="col-md-4">
	                                <span><i class="fa fa-money"></i></span>
	                            </div>
	                        </div>
	                    </div>
	                </div>
                    @endforeach
                    
	                <div class="col-md-4" style="padding:15px;">
	                    <div class="summeryInfo">
	                        <div class="row">
	                            <div class="col-md-8">
	                                <span class="amount"
	                                @if($totals<0)
	                                style="color:#ff2946;"
	                                @endif
	                                >{{priceFullFormat($totals)}}</span>
	                                <p>Total Balances</p>
	                            </div>
	                            <div class="col-md-4">
	                                <span><i class="fa fa-money"></i></span>
	                            </div>
	                        </div>
	                    </div>
	                </div>
            	</div>
            	<!--Search Transection Start-->
            	<div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div id="accordion">
                                <div
                                    class="card-header collapsed"
                                    data-toggle="collapse"
                                    data-target="#collapseTwo"
                                    aria-expanded="false"
                                    aria-controls="collapseTwo"
                                    id="headingTwo"
                                    style="background: #f5f7fa; padding: 10px; cursor: pointer; border: 1px solid #00b5b8;"
                                >
                                    Search click Here..
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="border: 1px solid #00b5b8; border-top: 0;">
                                    <div class="card-body">
                                        <form action="{{route('admin.accountsList')}}">
                                            <div class="row">
                                                <div class="col-md-6 mb-0">
                                                    <div class="input-group">
                                                        <input type="date" name="startDate" value="{{$r->startDate?Carbon\Carbon::parse($r->startDate)->format('Y-m-d') :''}}" class="form-control {{$errors->has('startDate')?'error':''}}" />
                                                        <input type="date" value="{{$r->endDate?Carbon\Carbon::parse($r->endDate)->format('Y-m-d') :''}}" name="endDate" class="form-control {{$errors->has('endDate')?'error':''}}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-0">
                                                    <div class="form-group">
                                                        <select class="form-control" name="method">
                                                            <option value="">Select Method</option>
                                                            @foreach($methods as $method)
                                                            <option value="{{$method->id}}" {{$r->method==$method->id?'selected':''}}>{{$method->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-0">
                                                    <div class="form-group">
                                                        <select class="form-control" name="source">
                                                            <option value="">Select Source</option>
                                                            
                                                            <option value="0" {{$r->type==0?'selected':''}}>By Order</option>
                                                            <option value="1" {{$r->type==1?'selected':''}}>Recharge</option>
                                                            <option value="2" {{$r->type==2?'selected':''}}>By Refund</option>
                                                            <option value="3" {{$r->type==3?'selected':''}}>POS Order</option>
                                                            <option value="3" {{$r->type==4?'selected':''}}>By Expenses</option>
                                                            <option value="4" {{$r->type==5?'selected':''}}>By Transfer</option>
                                                            <option value="4" {{$r->type==6?'selected':''}}>By Withdrawal</option>
                                                            <option value="4" {{$r->type==7?'selected':''}}>By Deposit</option>
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-0">
                                                    <div class="input-group">
                                                        <input type="text" name="search" value="{{$r->search}}" class="form-control {{$errors->has('search')?'error':''}}" placeholder="Search here.." />
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
                </div>
                
                <!--Search Transection End-->
                

                <div class="card">
                    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                        <h4 class="card-title">All Transections
                        </h4>
                    </div>
                    <div class="card-content">

                        <div class="card-body">
                            
                              <div class="table-responsive">
                                  <table class="table table-bordered">
                                      <tr>
                                          <th>Date</th>
                                          <th>Method</th>
                                          <th>Amount</th>
                                          <th>Source</th>
                                          <th>Status</th>
                                          <th>Note</th>
                                      </tr>
                                     @foreach($transections as $transection)
                                      <tr>
                                          <td>{{$transection->created_at->format('d-m-Y h:i A')}}</td>
                                          <td>{{$transection->method?$transection->method->name:'Not Found'}}</td>
                                          <td>{{priceFullFormat($transection->amount)}}</td>
                                          <td>
                                              @if($transection->type==0)
                                              <span class="badge badge-success infoDetails" style="background-color: #179bad;">By Order <i class="fa fa-file"></i></span>
                                              @elseif($transection->type==1)
                                              <span class="badge badge-success infoDetails" style="background-color: #fb9562;">By Recharge <i class="fa fa-file"></i></span>
                                              @elseif($transection->type==2)
                                              <span class="badge badge-success infoDetails" style="background-color: #fb9562;">By Refund <i class="fa fa-file"></i></span>
                                              @elseif($transection->type==3)
                                              <span class="badge badge-success infoDetails">POS Order</span> 
                                              @elseif($transection->type==4)
                                              <span class="badge badge-success infoDetails" style="background-color: #fbc02d;">By Expenses <i class="fa fa-file"></i></span>
                                              @elseif($transection->type==5)
                                              <span class="badge badge-success infoDetails" style="background-color: #00b5b8;">By Transfer <i class="fa fa-file"></i></span>
                                              @elseif($transection->type==6)
                                              <span class="badge badge-success infoDetails" style="background-color: #008385;">By Withdrawal <i class="fa fa-file"></i></span>
                                              @elseif($transection->type==7)
                                              <span class="badge badge-success infoDetails" style="background-color: #006a6c;">By Deposit <i class="fa fa-file"></i></span>
                                              @else
                                              <span class="badge badge-danger infoDetails">Unknown <i class="fa fa-file text-success"></i></span>
                                              @endif
                                          </td>
                                          <td>
                                            @if($transection->status=='success')
                                            <span class="badge badge-success">{{ucfirst($transection->status)}}</span>
                                            @else
                                            <span class="badge badge-danger">{{ucfirst($transection->status)}}</span>
                                            @endif
                                        </td>
                                          <td>
                                              {!!$transection->billing_note!!}
                                          </td>
                                      </tr>
                                     @endforeach
                                  </table>
                                  {{$transections->links('pagination')}}
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

@endpush
