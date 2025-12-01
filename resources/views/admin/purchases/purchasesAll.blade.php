@extends(general()->adminTheme.'.layouts.app')
@section('title')
<title>{{websiteTitle('Stock Management')}}</title>
@endsection
@push('css')
<style type="text/css">
    .card .topBorderHeader{
        border-top: 3px solid #3d3196 !important;
    }
</style>
@endpush
@section('contents')

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Stock Management</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item active">Stock Management</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            @isset(json_decode(Auth::user()->permission->permission, true)['products']['add'])
            <a class="btn btn-outline-primary" href="{{route('admin.purchasesAction','create')}}">Add Stock</a>
            @endisset
            <a class="btn btn-outline-primary" href="{{route('admin.purchases')}}">
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
                    <form action="{{route('admin.purchases')}}">
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <div class="input-group">
                                    <input type="date" name="startDate" value="{{request()->startDate?Carbon\Carbon::parse(request()->startDate)->format('Y-m-d') :''}}" class="form-control {{$errors->has('startDate')?'error':''}}" />
                                    <input type="date" value="{{request()->endDate?Carbon\Carbon::parse(request()->endDate)->format('Y-m-d') :''}}" name="endDate" class="form-control {{$errors->has('endDate')?'error':''}}" />
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="input-group">
                                    <input type="text" name="search" value="{{request()->search?:''}}" placeholder="Stock Invoice no" class="form-control {{$errors->has('search')?'error':''}}" />
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
        <h4 class="card-title">Stock History List</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form action="{{route('admin.purchases')}}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-1">
                            <select class="form-control form-control-sm rounded-0" name="action" required="">
                                <option value="">Select Action</option>
                                <!--@isset(json_decode(Auth::user()->permission->permission, true)['orders']['manage'])-->
                                <!--<option value="1">Pending</option>-->
                                <!--<option value="2">Delivered</option>-->
                                <!--<option value="4">Cancelled</option>-->
                                <!--@endisset-->
                                @isset(json_decode(Auth::user()->permission->permission, true)['orders']['delete'])
                                <option value="5">Delete</option>
                                @endisset
                            </select>
                            <button class="btn btn-sm btn-primary rounded-0" onclick="return confirm('Are You Want To Action?')">Action</button>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <ul class="statuslist">
                            <li><a href="{{route('admin.purchases')}}">All ({{$totals->total}})</a></li>
                            <li><a href="{{route('admin.purchases',['status'=>'pending'])}}">Pending ({{$totals->pending}})</a></li>
                            <li><a href="{{route('admin.purchases',['status'=>'delivered'])}}">Delivered ({{$totals->delivered}})</a></li>
                            <li><a href="{{route('admin.purchases',['status'=>'cancelled'])}}">Cancelled ({{$totals->cancelled}})</a></li>
                        </ul>
                    </div>
                </div>
        
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><label style="cursor: pointer; margin-bottom: 0;"> <input class="checkbox" type="checkbox" class="form-control" id="checkall" /> All <span class="checkCounter"></span> </label></th>
                                <th style="min-width: 100px;">Invoice No</th>
                                <th style="min-width: 150px;">Supplier</th>
                                <th style="min-width: 150px;">Store/Branch</th>
                                <th style="min-width: 70px;">Stock</th>
                                <th style="min-width: 70px;">Bill</th>
                                <th style="min-width: 100px;">Status</th>
                                <th style="min-width: 100px;">Date</th>
                                <th style="min-width: 100px;">Created By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $i=>$invoice)
                                <tr>
                                    <td>
                                        <input class="checkbox" type="checkbox" name="checkid[]" value="{{$invoice->id}}"
                                        @if($invoice->isStockUsed())
                                        disabled=""
                                        @endif
                                        /> 
                                        {{$invoices->currentpage()==1?$i+1:$i+($invoices->perpage()*($invoices->currentpage() - 1))+1}}
                                    </td>
                                    <td>
                                        <a href="{{route('admin.purchasesAction',['invoice',$invoice->id])}}">{{$invoice->invoice}}</a>
                                        <a href="{{route('admin.purchasesAction',['edit',$invoice->id])}}" class="badge badge-info"><i class="fa fa-edit"></i></a>
                                    </td>
                                    <td>
                                        @if($invoice->user)
                                        {{$invoice->user->name}}
                                        @endif
                                    </td>
                                    <td>{{$invoice->branch?$invoice->branch->name:''}}</td>
                                    <td>{{$invoice->items()->sum('quantity')}}</td>
                                    <td>{{priceFormat($invoice->grand_total)}}</td>
                                    <td>{{ucfirst($invoice->order_status)}}</td>
                                    <td>{{$invoice->created_at->format('d.m.Y')}}</td>
                                    <td>{{$invoice->soldBy?$invoice->soldBy->name:''}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{$invoices->links('pagination')}}
            </form>
        </div>
    </div>
</div>






@endsection @push('js') @endpush