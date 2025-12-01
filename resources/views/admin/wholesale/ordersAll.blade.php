@extends('admin.layouts.app') @section('title')
<title>{{websiteTitle('Wholesale List')}}</title>
@endsection @push('css')
<style type="text/css"></style>
@endpush @section('contents')

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Wholesale List</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item active">Wholesale List</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            @isset(json_decode(Auth::user()->permission->permission, true)['products']['add'])
            <a class="btn btn-outline-primary" href="{{route('admin.wholeSalesAction','create')}}">Add Wholesale</a>
            @endisset
            <a class="btn btn-outline-primary" href="{{route('admin.wholeSales')}}">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>


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
                    style="background:#009688;padding: 15px 20px; cursor: pointer;"
                >
                   <i class="fa fa-filter"></i> Search click Here..
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="border: 1px solid #00b5b8; border-top: 0;">
                    <div class="card-body">
                        <form action="{{route('admin.wholeSales',$status)}}">
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <div class="input-group">
                                        <input type="date" name="startDate" value="{{request()->startDate?Carbon\Carbon::parse(request()->startDate)->format('Y-m-d') :''}}" class="form-control {{$errors->has('startDate')?'error':''}}" />
                                        <input type="date" value="{{request()->endDate?Carbon\Carbon::parse(request()->endDate)->format('Y-m-d') :''}}" name="endDate" class="form-control {{$errors->has('endDate')?'error':''}}" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <div class="input-group">
                                        <input type="text" name="search" value="{{request()->search?:''}}" placeholder="Wholesale Invoice, Customer Mobile, email" class="form-control {{$errors->has('search')?'error':''}}" />
                                        <button type="submit" class="btn btn-success rounded-0"><i class="fa fa-search"></i> Search</button>
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
        <h4 class="card-title">Wholesale List</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form action="{{route('admin.wholeSales',$status)}}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-1">
                            <select class="form-control form-control-sm rounded-0" name="action" required="">
                                <option value="">Select Action</option>
                                @isset(json_decode(Auth::user()->permission->permission, true)['orders']['manage'])
                                <option value="1">Pending</option>
                                <option value="2">Confirmed</option>
                                <option value="3">Shipped</option>
                                <option value="4">Delivered</option>
                                <option value="5">Cancelled</option>
                                @endisset
                                @isset(json_decode(Auth::user()->permission->permission, true)['orders']['delete'])
                                <option value="6">Delete</option>
                                @endisset
                            </select>
                            <button class="btn btn-sm btn-primary rounded-0" onclick="return confirm('Are You Want To Action?')">Action</button>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <ul class="statuslist">
                            <li><a href="{{route('admin.wholeSales')}}">All ({{$totals->total}})</a></li>
                            <li><a href="{{route('admin.wholeSales',['status'=>'pending'])}}">Pending ({{$totals->pending}})</a></li>
                            <li><a href="{{route('admin.wholeSales',['status'=>'delivered'])}}">Delivered ({{$totals->delivered}})</a></li>
                            <li><a href="{{route('admin.wholeSales',['status'=>'cancelled'])}}">Cancelled ({{$totals->cancelled}})</a></li>
                        </ul>
                    </div>
                </div>
        
                <div class="table-responsive">
                    
                <table class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th style="width:60px;min-width:60px;" ><label style="cursor: pointer; margin-bottom: 0;"> <input class="checkbox" type="checkbox" class="form-control" id="checkall" /> All <span class="checkCounter"></span> </label></th>
                                <th style="width:120px;min-width:120px;">Invoice</th>
                                <th style="min-width:200px;">Wholesale Customer</th>
                                <th style="width:200px;min-width:200px;">Note</th>
                                <th style="width:200px;min-width:200px;">Total Bill</th>
                                <th style="width:130px;min-width:130px;">Date</th>
                                <th style="width:100px;min-width:100px;">Status</th>

                                <th style="width:80px;min-width:80px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $i=>$order)
                            <tr>
                                <td><input class="checkbox" type="checkbox" name="checkid[]" value="{{$order->id}}" /> {{$i+1}}</td>
                                <td><a href="{{route('admin.wholeSalesAction',['invoice',$order->id])}}">{{$order->invoice}}</a></td>
                                <td>{{$order->company_name}}
                                @if($order->company_name && $order->name)
                                - 
                                @endif
                                {{$order->name}}
                                </td>
                                <td>{{$order->note}}</td>
                                <td style="display: flex;justify-content: space-between;">
                                    {{priceFullFormat($order->grand_total)}}
                                    @if($order->payment_status=='partial' || $order->payment_status=='paid')
                                    <span class="badge badge-success" style="background:#ff9800;">{{ucfirst('Paid')}}</span>
                                    @elseif($order->payment_status=='paid')
                                    <span class="badge badge-success" style="background:#673ab7;">{{ucfirst($order->payment_status)}}</span>
                                    @else
                                    <span class="badge badge-success" style="background:#f44336;">{{ucfirst($order->payment_status)}}</span>
                                    @endif
                                </td>
                                <td>{{$order->created_at->format('d M, Y')}}</td>
                                <td>

                                @if($order->order_status=='confirmed')
                                <span class="badge badge-success" style="background:#e91e63;">{{ucfirst($order->order_status)}}</span>
                                @elseif($order->order_status=='shipped')
                                <span class="badge badge-success" style="background:#673ab7;">{{ucfirst($order->order_status)}}</span>
                                @elseif($order->order_status=='delivered')
                                <span class="badge badge-success" style="background:#1c84c6;">{{ucfirst($order->order_status)}}</span>
                                @elseif($order->order_status=='cancelled')
                                <span class="badge badge-success" style="background:#f44336;">{{ucfirst($order->order_status)}}</span>
                                @else
                                <span class="badge badge-success" style="background:#ff9800;">{{ucfirst($order->order_status)}}</span>
                                @endif
                                </td>
                                <td>
                                    @isset(json_decode(Auth::user()->permission->permission, true)['orders']['manage'])
                                    <a href="{{route('admin.wholeSalesAction',['edit',$order->id])}}" class="btn btn-sm btn-success">Manage</a>
                                    @endisset
                                </td>
                            </tr>
                            
                            @endforeach
                            @if($orders->count()==0)
                            <tr><td colspan="7"><center>No Order Found</center></td></tr>
                            @endif
                        </tbody>

                    </table>

                    {{$orders->links('pagination')}}
                </div>
            </form>
        </div>
    </div>
</div>

@endsection @push('js')

@endpush
