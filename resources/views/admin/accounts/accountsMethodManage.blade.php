@extends('admin.layouts.app') @section('title')
<title>Account Method manage - {{general()->title}}{{general()->title && general()->subtitle?' | ':''}}{{general()->subtitle}}</title>
@endsection @push('css')
<style type="text/css">

</style>
@endpush @section('contents')

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Account Method manage</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item active">Statement List</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#WithdrawalDeposit">
              <i class="fa fa-plus"></i>  Withdrawal Amount
            </button>
            <a class="btn btn-outline-primary" href="{{route('admin.paymentMethods',['manage',$method->id])}}">
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
                        <h4 class="card-title">{{$method->name}} Statement</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            
                            <form action="{{route('admin.paymentMethods',['manage',$method->id])}}">
                                <div class="row">
                                    <div class="col-md-4 mb-0">
                                        <h3 style="padding: 8px;border: 1px solid #e5e4e4;background: #00b5b8;border-radius: 5px;color: white;font-weight: bold;font-family: sans-serif;">
                                          <span style="font-size: 14px;">{{$method->name}}  Balance:</span><br> {{priceFullFormat($method->amounts)}}
                                        </h3>
                                    </div>
                                    <div class="col-md-8 mb-0">
                                        <div class="input-group">
                                            <input type="date" name="startDate" value="{{$from->format('Y-m-d')}}" class="form-control {{$errors->has('startDate')?'error':''}}" />
                                            <input type="date" value="{{$to->format('Y-m-d')}}" name="endDate" class="form-control {{$errors->has('endDate')?'error':''}}" />
                                            <button type="submit" class="btn btn-success rounded-0">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
                              <div class="table-responsive">
                                  <table class="table table-bordered">
                                    <tr>
                                        <th style="min-width:60px;width:60px;">SL</th>
                                        <th style="min-width:170px;width:170px;">Date</th>
                                        <th style="min-width:150px;">Description</th>
                                        <th style="min-width:150px;width:150px;">Debit</th>
                                        <th style="min-width:200px;width:200px;">Credit</th>
                                        <th style="min-width:200px;width:200px;">Balance</th>
                                    </tr>
                                    @php
                                        $debit = 0;
                                        $credit = 0;
                                        $balance = 0;
                                    @endphp
                                
                                    @foreach($transactions as $i => $transection)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $transection->created_at->format('d-m-Y') }}
                                            
                                            @if($transection->type == 6)
                                            <a href="{{route('admin.paymentMethods',['manage',$method->id,'transaction_id'=>$transection->id])}}" class="btn btn-sm btn-danger" onclick="return confirm('Are you want to Delete?')"><i class="fa fa-trash"></i></a>
                                            @endif
                                            </td>
                                            <td>
                                                @if($transection->type == 1)
                                                    <span>POS Sale Collection</span>
                                                @elseif($transection->type == 4)
                                                    <span>Expenses | {{ $transection->billing_note }}</span>
                                                @elseif($transection->type == 6)
                                                    <span>Withdrawal | {{ $transection->billing_note }}</span>
                                                @else
                                                    <span>Online Sale Collection</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($transection->type == 4 || $transection->type == 6)
                                                    {{ priceFullFormat($transection->amount) }}
                                                    @php
                                                        $debit += $transection->amount;
                                                        $balance -= $transection->amount; // decrease
                                                    @endphp
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td>
                                                @if($transection->type == 1 || $transection->type == 0)
                                                    {{ priceFullFormat($transection->amount) }}
                                                    @php
                                                        $credit += $transection->amount;
                                                        $balance += $transection->amount; // increase
                                                    @endphp
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td>
                                                {{ priceFullFormat($balance) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td style="text-align: right;"><strong>Total</strong></td>
                                        <td><strong>{{ priceFullFormat($debit) }}</strong></td>
                                        <td><strong>{{ priceFullFormat($credit) }}</strong></td>
                                        <td><strong>{{ priceFullFormat($credit - $debit) }}</strong></td>
                                    </tr>
                                </table>


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
        <form action="{{route('admin.paymentMethods',['manage',$method->id])}}" method="post">
            @csrf
           <div class="modal-header">
             <h4 class="modal-title" id="myModalLabel1">Withdrawal Amount</h4>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times; </span>
             </button>
           </div>
           <div class="modal-body">
                <div class="form-group">
                    <label>Date*</label>
                    <input type="date" name="created_at" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" class="form-control"required="">
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Withdrawal Amount*</label>
                        <input type="number" name="amount" class="form-control" value="{{old('amount')}}" placeholder="0" required="">
                    </div>
                    <!--<div class="form-group col-md-6">-->
                    <!--    <label>Debit Type*</label>-->
                    <!--    <select class="form-control" name="debit_type" required="" >-->
                    <!--        <option value="">Select Type</option>-->
                    <!--        <option value="withdrawal">Withdrawal Balance</option>-->
                    <!--        <option value="expenses">Expenses Cost</option>-->
                    <!--    </select>-->
                    <!--</div>-->
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
