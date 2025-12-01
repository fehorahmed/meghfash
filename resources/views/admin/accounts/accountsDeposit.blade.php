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
    background: white;
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

</style>
@endpush @section('contents')

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Deposit List</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item active">Deposit List</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#WithdrawalDeposit">
              <i class="fa fa-plus"></i>  Deposit
            </button>
            <a class="btn btn-outline-primary" href="{{route('admin.accountsDeposit')}}">
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
                                        <form action="{{route('admin.accountsDeposit')}}">
                                            <div class="row">
                                                <div class="col-md-4 mb-0">
                                                    <div class="form-group">
                                                        <select class="form-control" name="method">
                                                            <option value="">Select Method</option>
                                                            @foreach($methods as $method)
                                                            <option value="{{$method->id}}" {{$r->method==$method->id?'selected':''}}>{{$method->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 mb-0">
                                                    <div class="input-group">
                                                        <input type="date" name="startDate" value="{{$r->startDate?Carbon\Carbon::parse($r->startDate)->format('Y-m-d') :''}}" class="form-control {{$errors->has('startDate')?'error':''}}" />
                                                        <input type="date" value="{{$r->endDate?Carbon\Carbon::parse($r->endDate)->format('Y-m-d') :''}}" name="endDate" class="form-control {{$errors->has('endDate')?'error':''}}" />
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
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                        <h4 class="card-title">Deposit</h4>
                    </div>
                    <div class="card-content">

                        <div class="card-body">
                            
                              <div class="table-responsive">
                                 <table class="table table-bordered">
                                      <tr>
                                          <th style="min-width:170px;width:170px;">Date</th>
                                          <th style="min-width:150px;width:150px;">Amount</th>
                                          <th style="min-width:150px;width:150px;">Method</th>
                                          <th style="min-width:200px;width:200px;">Note</th>
                                          <th style="min-width:100px;width:100px;">Action</th>
                                      </tr>
                                      @foreach($deposits as $i=>$deposit)
                                      <tr>
                                          <td><span>{{$deposit->created_at->format('d-m-Y h:i A')}}</span></td>
                                          <td><span>{{priceFormat($deposit->amount)}}</span></td>
                                          <td><span>{{$deposit->method?$deposit->method->name:''}}</span></td>
                                          <td>{!!$deposit->billing_note!!}</td>
                                          <td>
                                            <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#updateDeposit{{$deposit->id}}">
                                                   Edit
                                            </button>
                                             <!-- Modal -->
                                            <div class="modal fade text-left" id="updateDeposit{{$deposit->id}}" >
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{route('admin.accountsDeposit',['update',$deposit->id])}}" method="post">
                                                        @csrf
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel1">Deposit</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times; </span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                            <div class="form-group">
                                                                <label>Date*</label>
                                                                <input type="date" name="date" value="{{$deposit->created_at->format('Y-m-d')}}" class="form-control"required="">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Amount*</label>
                                                                <input type="number" name="amount" value="{{$deposit->amount}}" class="form-control" placeholder="0" required="">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Method Type*</label>
                                                                <select class="form-control" name="method" required="">
                                                                    <option value="">Select Method</option>
                                                                    @foreach($methods as $method)
                                                                    <option value="{{$method->id}}" {{$deposit->method_id==$method->id?'selected':''}}>{{$method->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                    <label>Description</label>
                                                                    <textarea class="form-control" name="description" placeholder="Write Description">{!!$deposit->billing_note!!}</textarea>
                                                            </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close </button>
                                                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Submit</button>
                                                    </div>
                                                </form>
                                                </div>
                                            </div>
                                            </div>
                                            <a href="{{route('admin.accountsDeposit',['delete',$deposit->id])}}" class="btn btn-sm btn-danger" onclick="return confirm('Are You Want To Delete?')"><i class="fa fa-trash"></i></a>
                                          </td>
                                      </tr>
                                      @endforeach
                                  </table>
                                  {{$deposits->links('pagination')}}
                              </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Basic Inputs end -->
</div>


 <!-- Modal -->
 <div class="modal fade text-left" id="WithdrawalDeposit" >
   <div class="modal-dialog" role="document">
     <div class="modal-content">
        <form action="{{route('admin.accountsDeposit','create')}}" method="post">
            @csrf
           <div class="modal-header">
             <h4 class="modal-title" id="myModalLabel1">Deposit</h4>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times; </span>
             </button>
           </div>
           <div class="modal-body">

                <div class="form-group">
                    <label>Date*</label>
                    <input type="date" name="date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" class="form-control"required="">
                </div>

                <div class="form-group">
                    <label>Amount*</label>
                    <input type="number" name="amount" class="form-control" placeholder="0" required="">
                </div>

                <div class="form-group">
                    <label>Method Type*</label>
                    <select class="form-control paymentMethod" name="method" required="">
                        <option value="">Select Method</option>
                        @foreach($methods as $method)
                        <option value="{{$method->id}}" >{{$method->name}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" placeholder="Write Description"></textarea>
                </div>

           </div>
           <div class="modal-footer">
             <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close </button>
             <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Submit</button>
           </div>
       </form>
     </div>
   </div>
 </div>



@endsection 

@push('js') 

@endpush
