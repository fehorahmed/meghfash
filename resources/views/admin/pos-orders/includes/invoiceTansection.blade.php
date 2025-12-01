<div class="row" style="margin:0 -5px;">
    <div class="col-md-7" style="padding:5px;">
        <table class="table table-bordered summeryTable">
            <tr>
                <th>Sub Total</th>
                <td>{{priceFullFormat($invoice->total_price)}}</td>
            </tr>
            <tr>
                <th>Shipping Charge</th>
                <td>{{priceFullFormat($invoice->shipping_charge)}}</td>
            </tr>
            <tr>
                <th>Tax ({{$invoice->tax}}%)</th>
                <td>{{priceFullFormat($invoice->tax_amount)}}</td>
            </tr>
            <tr>
                <th>Discount</th>
                <td>{{priceFullFormat($invoice->discount_amount)}}</td>
            </tr>
            <tr>
                <th>Grand Total</th>
                <td>{{priceFullFormat($invoice->grand_total)}}</td>
            </tr>
            <tr>
                <th>Paid Amount</th>
                <td>{{priceFullFormat($invoice->paid_amount)}}</td>
            </tr>
            <tr>
                <th>Due Amount</th>
                <td>{{priceFullFormat($invoice->due_amount)}}</td>
            </tr>
        </table>    
    </div>
    <div class="col-md-5" style="padding:5px;">
        <div class="form-group" style="margin-bottom:5px;">
            <label class="m-0">Payment Method </label>
            <select class="form-control form-control-sm paymentMethod">
                @foreach($accountsMethods as $method)
                    <option value="{{$method->id}}">{{$method->name}}</option>
                @endforeach
            </select>
            <span class="paymentMethodErr"></span>
        </div>
        <div class="form-group" style="margin-bottom:5px;">
            <label class="m-0">Received Amount {{priceFormat($invoice->due_amount)}}</label>
            <Input type="number" class="form-control form-control-sm ReceivedAmount" data-total="{{$invoice->due_amount}}" value="{{number_format($invoice->due_amount, 2, '.', '')}}" step="any" placeholder="Amount">
            <span class="receivedAmountErr"></span>
        </div>
        <div class="form-group m-0">
            <label class="m-0">Return BDT </label><span class="returnAmount">0</span>
        </div>
        <div class="form-group m-0">
            <button type="button" class="btn btn-md btn-block btn-success {{$invoice->due_amount==0?'':'AddPayment'}}" data-url="{{route('admin.posOrdersAction',['addPayment',$invoice->id])}}" {{$invoice->due_amount==0?'disabled':''}}   >Add Payment</button>
        </div>
    </div>
    <div class="col-md-12" style="padding:5px;">
        <h4 style="font-size: 18px;">All Tansection</h4>
        <div class="table-responsive">
            <table class="table table-bordered transectionTable">
                <tr>
                    <th style="min-width: 120px;">Method</th>
                    <th style="min-width: 120px;">Amount</th>
                    <th style="min-width: 100px;">Return</th>
                </tr>
                @foreach($invoice->transections as $transection)
                <tr>
                    <td>{{$transection->payment_method}}</td>
                    <td>{{priceFullFormat($transection->received_amount)}}</td>
                    <td>{{priceFormat($transection->return_amount)}}

                    <span class="removePayment" data-url="{{route('admin.posOrdersAction',['removepayment',$invoice->id,'transection_id'=>$transection->id])}}"><i class="fa fa-trash"></i></span>
                    </td>
                </tr>
                @endforeach
                @if($invoice->transections->count()==0)
                <tr>
                    <td colspan="4" style="text-align:center;">
                        No Transaction
                    </td>
                </tr>
                @endif
            </table>
        </div>
        <form action="{{route('admin.posOrdersAction',['completed-invoice',$invoice->id])}}" method="post">
            @csrf
            <div class="form-group">
                <label>Sale Note</label>
                <textarea class="form-control saleNote" data-url="{{route('admin.posOrdersAction',['salesnote',$invoice->id])}}" placeholder="Write sale note">{!!$invoice->note!!}</textarea>
            </div>
            <button type="submit" data-url="{{route('admin.posOrdersAction',['completed-invoice',$invoice->id])}}" class="btn btn-primary btn-block CompletedOrder1">Completed Order</button>
        </form>
    </div>
</div>