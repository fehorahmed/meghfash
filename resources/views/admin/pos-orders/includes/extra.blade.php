<div class="boxBar">
    <h4>Total Payable</h4>
    <div class="row" style="margin:0 -2px;">
        <label class="col-12" style="padding:2px;font-weight:bold;">
            Payment Getway
        </label>
        <div class="col-12" style="padding:2px;">
            <label><input type="checkbox" name="payment_method[]" value="Cash" 
            @if($invoice->order_status!='temp')
                @if($invoice->transections()->where('status','success')->where('payment_method','Cash Method')->first())
                checked
                @endif
            @else
                checked
            @endif
            > Cash</label>
            <label><input type="checkbox" name="payment_method[]" value="Card_payment"
            @if($invoice->transections()->where('status','success')->where('payment_method','Card Method')->first())
                checked
            @endif
            > Card</label>
            <label><input type="checkbox" name="payment_method[]" value="mobile_payment"
            @if($invoice->transections()->where('status','success')->where('payment_method','Mobile Method')->first())
                checked
            @endif
            
            > Mobile Payment</label>
            <!--<label><input type="checkbox" name="payment_method" value="Gift_voucher"> Gift Voucher</label>-->
            <!--<label><input type="checkbox" name="payment_method" value="discount_card"> Discount Card</label>-->
        </div>
    </div>
    
    @php
        $cardMethod =$invoice->transections()->where('status','success')->where('payment_method','Card Method')->first();
    @endphp
    
    <div class="Card_payment"
    
    @if($cardMethod)
        style="display:block;"
    @endif
    
    >
        <div class="row" style="margin:0 -2px;">
            <label class="col-12" style="padding:2px;font-weight:bold;">
                Payment Getway
            </label>
            <div class="col-12" style="padding:2px;">
                <select class="form-control form-control-sm" name="pos_method">
                    <option value="">Select POS</option>
                    
                    @foreach($accountsMethods->where('location','pos_method') as $posMethod)
                    <option value="{{$posMethod->id}}"
                    @if($cardMethod)
                    {{$posMethod->id==$cardMethod->method_id?'selected':''}}
                    @endif
                    
                    >{{$posMethod->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row" style="margin:0 -2px;">
            <label class="col-12" style="padding:2px;font-weight:bold;">
                Select Card
            </label>
            <div class="col-12" style="padding:2px;">
                <select class="form-control form-control-sm" name="card_method">
                    <option value="">Select Card</option>
                    @foreach($accountsMethods->where('location','card_method') as $caMethod)
                    <option value="{{$caMethod->id}}"
                    
                    @if($cardMethod)
                    {{$caMethod->id==$cardMethod->payment_method_id?'selected':''}}
                    @endif
                    
                    >{{$caMethod->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row" style="margin:0 -2px;">
            <label class="col-6" style="padding:2px;font-weight:bold;">
               Amount
            </label>
            <div class="col-6" style="padding:2px;">
                <input type="number" class="form-control form-control-sm ReceivedAmountNew" name="card_amount" step="any" value="{{$cardMethod?$cardMethod->received_amount:''}}" placeholder="Amount" >
            </div>
        </div>
        <div class="row" style="margin:0 -2px;">
            <label class="col-6" style="padding:2px;font-weight:bold;font-size:14px;">
                CARD Digit
            </label>
            <div class="col-6" style="padding:2px;">
                <input type="text" class="form-control form-control-sm" name="card_digit" value="{{$cardMethod?$cardMethod->transection_id:''}}"  placeholder="Enter CARD Digit">
            </div>
        </div>
    </div>
    @php
        $mobileMethod =$invoice->transections()->where('status','success')->where('payment_method','Mobile Method')->first();
    @endphp
    <div class="mobile_payment"
    @if($mobileMethod)
        style="display:block;"
    @endif
    >
         <hr>
        <div class="row" style="margin:0 -2px;">
            <label class="col-12" style="padding:2px;font-weight:bold;">
                Mobile Banking
            </label>
            <div class="col-12" style="padding:2px;">
                <select class="form-control form-control-sm" name="mobile_method">
                    <option value="">Select Banking</option>
                     @foreach($accountsMethods->where('location','mobile_banking') as $mobMethod)
                    <option value="{{$mobMethod->id}}"
                    
                    @if($mobileMethod)
                    {{$mobMethod->id==$mobileMethod->payment_method_id?'selected':''}}
                    @endif
                    
                    >{{$mobMethod->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row" style="margin:0 -2px;">
            <label class="col-6" style="padding:2px;font-weight:bold;">
               Amount
            </label>
            <div class="col-6" style="padding:2px;">
                <input type="number" class="form-control form-control-sm ReceivedAmountNew" name="mobile_amount" value="{{$mobileMethod?$mobileMethod->received_amount:''}}" step="any" placeholder="Amount" >
            </div>
        </div>
        <div class="row" style="margin:0 -2px;">
            <label class="col-6" style="padding:2px;font-weight:bold;font-size:14px;">
                TNX Number
            </label>
            <div class="col-6" style="padding:2px;">
                <input type="text" class="form-control form-control-sm" name="mobile_tnx" value="{{$mobileMethod?$mobileMethod->transection_id:''}}"  placeholder="Enter TNX Number">
            </div>
        </div>
    </div>
    <hr>
    @php
        $cashMethod =$invoice->transections()->where('status','success')->where('payment_method','Cash Method')->first();
    @endphp
    <div class="row" style="margin:0 -2px;">
        <label class="col-6" style="padding:2px;font-weight:bold;">
           Cash Received
        </label>
        <div class="col-6" style="padding:2px;">
            <input type="number" class="form-control form-control-sm ReceivedAmountNew TotalAmount" name="cash_amount" value="{{$cashMethod?$cashMethod->received_amount:''}}" data-total="{{$invoice->grand_total}}" step="any" placeholder="Amount">
            <div class="form-group m-0" style="font-size: 14px;color: #ff425c;font-weight: bold;">
                <label class="m-0">Change:</label><span class="returnAmount">0</span>
            </div>
        </div>
    </div>
</div>