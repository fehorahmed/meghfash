<div class="row" style="margin:0 -5px;">
    <div class="col-md-6" style="padding:5px;">
        <div class="form-group">
            <label>Customer*</label>
            <div class="searchCustomer">
                <div class="input-group">
                    <input type="text" placeholder="Search Customer"
                    @if($invoice->order_status=='delivered')
                    disabled=""
                    @endif
                    value="@if($invoice->name || $invoice->mobile) {{$invoice->name}}{{$invoice->mobile}}@endif"
                    
                    data-url="{{route('admin.posOrdersAction',['searchCustomer',$invoice->id])}}" class="searchValue form-control form-control-sm">
                    <span style="padding: 5px;background: gainsboro;"><i class="fa fa-search"></i></span>
                </div>
                <div class="searchCustomerResult">
                    @include(adminTheme().'pos-orders.includes.searchCustomers')
                </div>
            </div>
            <!--@if($invoice->items()->count() > 0)-->
            <!--<input type="text" readonly value="{{$invoice->name}} {{$invoice->mobile}}" class="form-control form-control-sm">-->
            <!--@else-->
            <!--<select class="form-control form-control-sm selectCustomer" data-url="{{route('admin.posOrdersAction',['selectCustomer',$invoice->id])}}" name="customer" required="">-->
            <!--    <option value="">Select Customer</option>-->
            <!--    @foreach($customers as $customer)-->
            <!--    <option value="{{$customer->id}}" {{$customer->id==$invoice->user_id?'selected':''}}>{{$customer->name}}</option>-->
            <!--    @endforeach-->
            <!--</select>-->
            <!--@endif-->
        </div>
    </div>
    <div class="col-md-6" style="padding:5px;">
            <div class="form-group">
            <label>Warehouse/Branch*</label>
            @if($invoice->items()->count() > 0)
            <input type="text" readonly value="{{$invoice->branch?$invoice->branch->name:''}}" class="form-control form-control-sm">
            @else
            <select class="form-control form-control-sm selectWarehouse" data-url="{{route('admin.posOrdersAction',['selectWarehouse',$invoice->id])}}" name="customer" required="">
                <option value="">Select Warehouse</option>
                @foreach($warehouses as $warehouse)
                <option value="{{$warehouse->id}}" {{$warehouse->id==$invoice->branch_id?'selected':''}}>{{$warehouse->name}}</option>
                @endforeach
            </select>
            @endif
        </div>
    </div>
</div>
<div class="orderItems">
    {!!$message!!}
    <div class="errorMsg"></div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th style="min-width: 150px;text-align:left;">Product Name</th>
                <th style="width: 120px;min-width: 120px;">Barcode</th>
                <th 
                @if($invoice->order_status=='delivered')
                style="width: 100px;min-width: 100px;"
                @else
                style="width: 80px;min-width: 80px;"
                @endif
                
                >QTY</th>
                <th style="width: 70px;min-width: 70px;">Unit Price</th>
                <th style="width: 70px;min-width: 70px;">Unit Total</th>
                <!--<th style="width: 80px;min-width: 80px;">Disc %</th>-->
                <th style="width: 100px;min-width: 100px;">Disc UP</th>
                <th style="width: 120px;min-width: 120px;">TP Without VAT ({{general()->currency}})</th>
                <th style="width: 100px;min-width: 100px;">VAT %</th>
                <th style="width: 120px;min-width: 120px;">TP + VAT ({{general()->currency}})</th>
            </tr>
            @if($invoice->returnItems())
            @foreach($invoice->returnItems() as $ritem)
            <tr
                @if($ritem->return_quantity > 0)
                style="background: #ff864a;color: white;"
                @else
                style="background: #ff425c;color: white;"
                @endif
            >
                <td style="text-align:left;">
                    {{$ritem->id}}
                    {{$ritem->product_name}} ({{(float) $ritem->tax}}%+VAT)
                    @if(count($ritem->itemAttributes()) > 0)
                    <br>
                    <span>
    				    @foreach($ritem->itemAttributes() as $i=>$attri)
    				        @if(isset($attri['title']) && isset($attri['value']))
                            {{$i==0?'':','}} <span><b>{{$attri['title']}}</b> : {{$attri['value']}}</span>
                            @endif
                        @endforeach
                    </span>
    				@endif
                </td>
                <td>{{$ritem->barcode}}</td>
                <td>
                    <span>Return</span><br>
                    <span class="returnMinus" data-url="{{route('admin.posOrdersAction',['cartreturnminus',$invoice->id,'item_id'=>$ritem->id])}}"><i class="fa fa-minus"></i></span>
                    <span class="returnPlus" data-url="{{route('admin.posOrdersAction',['cartreturnplus',$invoice->id,'item_id'=>$ritem->id])}}"><i class="fa fa-plus"></i></span> 
                    {{$ritem->return_quantity}}/{{$ritem->quantity}}
                </td>
                
                <td>{{priceFormat($ritem->regular_price)}}</td>
                <td>{{priceFormat($ritem->regular_price*$ritem->quantity)}}</td>
                <td>{{priceFormat($ritem->regular_price-($ritem->regular_price*$ritem->discount/100))}} ({{(float)$ritem->discount}}%)</td>
                <td>{{priceFormat(($ritem->regular_price-($ritem->regular_price*$ritem->discount/100))*$ritem->quantity)}}</td>
                <td>{{priceFormat($ritem->tax_amount)}}</td>
                <td>{{priceFormat($ritem->final_price)}}</td>
            </tr>
            @endforeach
            
            @endif
            
            
            @foreach($invoice->items as $item)
            <tr>
                <td style="text-align:left;">
                    {{$item->product_name}} ({{(float) $item->tax}}%+VAT)
                    @if(count($item->itemAttributes()) > 0)
                    <br>
                    <span>
    				    @foreach($item->itemAttributes() as $i=>$attri)
    				        @if(isset($attri['title']) && isset($attri['value']))
                            {{$i==0?'':','}} <span><b>{{$attri['title']}}</b> : {{$attri['value']}}</span>
                            @endif
                        @endforeach
                    </span>
    				@endif
                </td>
                <td>{{$item->barcode}}</td>
                <td>
                    <div style="display:flex;">
                        <span class="minus" data-url="{{route('admin.posOrdersAction',['cartminus',$invoice->id,'item_id'=>$item->id])}}"><i class="fa fa-minus"></i></span>    
                        <span class="quantity"><input type="number" readonly="" value="{{$item->quantity}}" placeholder="0" data-url="{{route('admin.posOrdersAction',['cartquantity',$invoice->id,'item_id'=>$item->id])}}" /></span>
                        <span class="plus" data-url="{{route('admin.posOrdersAction',['cartplus',$invoice->id,'item_id'=>$item->id])}}"><i class="fa fa-plus"></i></span>    
                    </div>
                </td>
                
                <td>{{priceFormat($item->regular_price)}}</td>
                <td>{{priceFormat($item->regular_price*$item->quantity)}}</td>
                <!--<td>{{priceFormat($item->tax_amount)}} ({{(float) $item->tax}}%) </td>-->
                <!--<td>{{(float) $item->discount}}</td>-->
                <td>{{priceFormat($item->regular_price-($item->regular_price*$item->discount/100))}} ({{(float)$item->discount}}%)</td>
                <td>{{priceFormat(($item->regular_price-($item->regular_price*$item->discount/100))*$item->quantity)}}</td>
                <td>{{priceFormat($item->tax_amount)}}</td>
                <td>{{priceFormat($item->final_price)}}
                <span class="removeItem" data-url="{{route('admin.posOrdersAction',['cartremove',$invoice->id,'item_id'=>$item->id])}}"><i class="fa fa-trash"></i></span>
                </td>
            </tr>
            @endforeach
            
            @if($invoice->items->count()==0)
            <tr>
                <td colspan="9" style="text-align:center;">No Item found</td>
            </tr>
            @endif
        </table>
    </div>
</div>
<div class="totalInfo">
        <div class="GrandTotal">
            <span style="margin-right: 50px;">Total Qty: {{number_format($invoice->items()->sum('quantity'))}}</span>
            <span style="margin-right: 50px;">Total Unit Price ({{number_format($invoice->totalRegularPrice())}}) + VAT ({{number_format($invoice->tax_amount)}}) = {{number_format($invoice->totalRegularPrice()+$invoice->tax_amount)}}</span>
            <span>Total Payable : {{priceFormat($invoice->grand_total)}}</span>
        </div>
        <form class="SaleInfo" action="{{route('admin.posOrdersAction',['completed-invoice',$invoice->id])}}" method="post">
            @csrf
        <div class="row" style="margin:0 -10px;">
            <div class="col-md-8" style="padding:10px;">
                <div class="row payInformation" style="margin:0 -5px;">
                    <div class="col-md-6" style="padding:5px;">
                        
                        <div class="boxBar">
                            <h4>Card Payment</h4>
                            @php
                                $cardMethod =$invoice->transections()->where('status','success')->where('payment_method','Card Method')->first();
                            @endphp
                            <div class="Card_payent">
                                <div class="row" style="margin:0 -2px;">
                                    <label class="col-6" style="padding:2px;font-weight:bold;">
                                        Payment Getway
                                    </label>
                                    <div class="col-6" style="padding:2px;">
                                        <select class="form-control form-control-sm" name="pos_method">
                                            <option value="">Select POS</option>
                                            
                                            @foreach($accountsMethods->where('location','pos_method') as $posMethod)
                                            <option value="{{$posMethod->id}}">{{$posMethod->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row" style="margin:0 -2px;">
                                    <label class="col-6" style="padding:2px;font-weight:bold;">
                                        Select Card
                                    </label>
                                    <div class="col-6" style="padding:2px;">
                                        <select class="form-control form-control-sm" name="card_method">
                                            <option value="">Select Card</option>
                                            @foreach($accountsMethods->where('location','card_method') as $caMethod)
                                            <option value="{{$caMethod->id}}">{{$caMethod->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row" style="margin:0 -2px;">
                                    <label class="col-6" style="padding:2px;font-weight:bold;">
                                       Amount
                                    </label>
                                    <div class="col-6" style="padding:2px;">
                                        <input type="number" class="form-control form-control-sm ReceivedAmountNew CardAmountInput" name="card_amount" step="any"  placeholder="Amount" >
                                    </div>
                                </div>
                                <div class="row" style="margin:0 -2px;">
                                    <label class="col-6" style="padding:2px;font-weight:bold;font-size:14px;">
                                        CARD Digit
                                    </label>
                                    <div class="col-6" style="padding:2px;">
                                        <input type="text" class="form-control form-control-sm" name="card_digit"  placeholder="Enter CARD Digit">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="boxBar">
                            <h4>Mobile Banking</h4>
                            <div class="mobile_ayment">
                                <div class="row" style="margin:0 -2px;">
                                    <label class="col-6" style="padding:2px;font-weight:bold;">
                                        Mobile Banking
                                    </label>
                                    <div class="col-6" style="padding:2px;">
                                        <select class="form-control form-control-sm" name="mobile_method">
                                            <option value="">Select Banking</option>
                                             @foreach($accountsMethods->where('location','mobile_banking') as $mobMethod)
                                            <option value="{{$mobMethod->id}}">{{$mobMethod->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row" style="margin:0 -2px;">
                                    <label class="col-6" style="padding:2px;font-weight:bold;">
                                       Amount
                                    </label>
                                    <div class="col-6" style="padding:2px;">
                                        <input type="number" class="form-control form-control-sm ReceivedAmountNew mobileAmountInput" name="mobile_amount" step="any" placeholder="Amount" >
                                    </div>
                                </div>
                                <div class="row" style="margin:0 -2px;">
                                    <label class="col-6" style="padding:2px;font-weight:bold;font-size:14px;">
                                        TNX Number
                                    </label>
                                    <div class="col-6" style="padding:2px;">
                                        <input type="text" class="form-control form-control-sm" name="mobile_tnx"  placeholder="Enter TNX Number">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-6" style="padding:5px;">
                       
                        <div class="boxBar">
                            <h4>Cash</h4>
                            <hr>
                            <div class="row" style="margin:0 -2px;">
                                <label class="col-6" style="padding:2px;font-weight:bold;">
                                   Cash Received
                                </label>
                                <div class="col-6" style="padding:2px;">
                                    <input type="number" class="form-control form-control-sm ReceivedAmountNew TotalAmount" name="cash_amount"  data-total="{{str_replace(',', '', number_format($invoice->due_amount))}}" step="any" placeholder="Amount">
                                    <!--<div class="form-group m-0" style="font-size: 14px;color: #ff425c;font-weight: bold;">-->
                                    <!--    <label class="m-0">Change:</label><span class="returnAmount">0</span>-->
                                    <!--</div>-->
                                </div>
                            </div>
                               
                        </div>
                            <hr>
                        <div class="boxBar">
                            <h4>Customer & Discount</h4>
                            <div class="row" style="margin:0 -2px;">
                                <label class="col-6" style="padding:2px;">
                                    <select class="form-control form-control-sm DiscountType" data-url="{{route('admin.posOrdersAction',['discountupdate',$invoice->id])}}">
            							<option value="" >No Discount</option>
            							<option value="percantage" {{$invoice->discount_type=='percantage'?'selected':''}} >Percantage(%)</option>
            							<!--<option value="flat" {{$invoice->discount_type=='flat'?'selected':''}}>Flat({{general()->currency}})</option>-->
            						</select>
                                </label>
                                <div class="col-6" style="padding:2px;">
                                    <!--<select class="form-control form-control-sm DiscountInput"-->
                                    
                                    <!--@if($invoice->discount_type=='flat' || $invoice->discount_type=='percantage')-->
                                    <!--@else-->
                                    <!--disabled-->
                                    <!--@endif >-->
                                        
                                    <!--    <option value="">Select Discount</option>-->
                                    <!--    <option value="5" {{$invoice->discount ==5?'selected':''}} >5%</option>-->
                                    <!--    <option value="10" {{$invoice->discount ==10?'selected':''}} >10%</option>-->
                                    <!--    <option value="15" {{$invoice->discount ==15?'selected':''}} >15%</option>-->
                                    <!--    <option value="20" {{$invoice->discount ==20?'selected':''}} >20%</option>-->
                                    <!--    <option value="30" {{$invoice->discount ==30?'selected':''}} >30%</option>-->
                                    <!--    <option value="40" {{$invoice->discount ==40?'selected':''}} >40%</option>-->
                                    <!--    <option value="50" {{$invoice->discount ==50?'selected':''}} >50%</option>-->
                                        
                                    <!--</select>-->
                                    <input type="number" class="form-control form-control-sm DiscountInput"
                                    
                                    @if($invoice->discount_type=='flat' || $invoice->discount_type=='percantage')
                                    @else
                                    disabled
                                    @endif
                                    value="{{$invoice->discount > 0?$invoice->discount:''}}" placeholder="Enter Discount">
                                </div>
                            </div>
                            <div class="row" style="margin:0 -2px;">
                                <label class="col-6" style="padding:2px;">
                                    Adjustment Discount
                                </label>
                                <div class="col-6" style="padding:2px;">
                                    <input type="number" class="form-control form-control-sm adJustmentDiscount" data-url="{{route('admin.posOrdersAction',['adjustmentupdate',$invoice->id])}}" value="{{$invoice->adjustment_amount > 0?$invoice->adjustment_amount:''}}" placeholder="Enter Amount">
                                </div>
                            </div>
                            <div class="row" style="margin:0 -2px;">
                                <label class="col-6" style="padding:2px;">
                                    Customer Name
                                </label>
                                <div class="col-6" style="padding:2px;">
                                    <input type="text" class="form-control form-control-sm" name="name" value="{{$invoice->name}}" placeholder="Enter Name">
                                </div>
                            </div>
                            <div class="row" style="margin:0 -2px;">
                                <label class="col-6" style="padding:2px;">
                                    Customer Mobile
                                </label>
                                <div class="col-6" style="padding:2px;">
                                    <input type="text" class="form-control form-control-sm" name="mobile" value="{{$invoice->mobile}}" placeholder="Enter Mobile">
                                </div>
                            </div>
                            <div class="row" style="margin:0 -2px;">
                                <label class="col-6" style="padding:2px;">
                                    Customer Email
                                </label>
                                <div class="col-6" style="padding:2px;">
                                    <input type="text" class="form-control form-control-sm" name="email" value="{{$invoice->email}}" placeholder="Enter email">
                                </div>
                            </div>
                            @if($invoice->member_card_id)
                            <div class="row" style="margin:0 -2px;">
                                <label class="col-6" style="padding:2px;font-weight: bold;color: #ff864a;">
                                    Member Card
                                </label>
                                <div class="col-6" style="padding:2px;">
                                    <input type="text" class="form-control form-control-sm" readonly="" value="{{$invoice->member_card_id}}" placeholder="Enter Card ID">
                                </div>
                            </div>
                            @endif
                            <!--<button type="button" class="btn btn-md btn-info">Customer All</button>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="padding:10px;">
                <table class="table table-bordered summeryTable">
                    <tr>
                        <th>Sub Total</th>
                        <td style="min-width:100px;">{{number_format($invoice->totalRegularPrice(),2)}}</td>
                    </tr>
                    <!--<tr>-->
                    <!--    <th>Adjustment</th>-->
                    <!--    <td>-->
                    <!--        <input type="number" name="adjustment" class="form-control form-control-sm" placeholder="Enter Amount">-->
                    <!--    </td>-->
                    <!--</tr>-->
                    
                    <tr>
                        <th>Discount (-)</th>
                        <td>{{number_format($invoice->discount_amount,2)}}</td>
                    </tr>
                    <tr>
                        <th>Total without VAT</th>
                        <td>{{number_format($invoice->totalRegularPrice()-$invoice->discount_amount,2)}}</td>
                    </tr>
                    <tr>
                        <th>VAT (+)</th>
                        <td>{{number_format($invoice->tax_amount,2)}}</td>
                    </tr>
                    @if($invoice->exchange_amount > 0)
                    <tr>
                        <th>Exchange (-)</th>
                        <th style="text-align: center;font-size: 18px;">{{priceFormat($invoice->exchange_amount,2)}}</th>
                    </tr>
                    @endif
                    <tr>
                        <th>Adjustment (-)</th>
                        <th style="text-align: center;font-size: 18px;">{{priceFormat($invoice->adjustment_amount,2)}}</th>
                    </tr>
                    
                    <tr>
                        <th>Grand Total</th>
                        <th style="text-align: center;font-size: 18px;">{{number_format($invoice->grand_total,2)}}</th>
                    </tr>
                    
                    <tr>
                        <th>Rounding (+/-)</th>
                        <td>{{number_format($invoice->grand_total - floor($invoice->grand_total),2)}}</td>
                    </tr>
                    <tr>
                        <th>Total Payable</th>
                        <th style="text-align: center;font-size: 18px;">{{priceFormat($invoice->grand_total,2)}}</th>
                    </tr>
                    
                    <tr>
                        <th>Paid Amount</th>
                        <td>{{priceFormat($invoice->paid_amount) }}</td>
                    </tr>
                    @if($invoice->extra_amount > 0)
                    <tr>
                        <th>Extra Amount</th>
                        <td>{{priceFormat($invoice->extra_amount)}}</td>
                    </tr>
                    @else
                    <tr>
                        <th>Due Amount</th>
                        <td style="color: #ffffff;background: #f44336;font-weight: bold;" class="dueAmountTotal" data-amount="{{number_format($invoice->due_amount)}}">{{priceFormat($invoice->due_amount)}}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Received Amount</th>
                        <td class="receivedTotalAmount">{{priceFormat($invoice->received_amount)}}</td>
                    </tr>
                    <tr>
                        <th>Change Amount</th>
                        <td class="returnAmount" style="color: green;">{{priceFormat($invoice->changed_amount)}}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div  class="row" style="margin:0 -5px;">
            <div class="col-md-3" style="padding:5px;">
                <button type="button" class="btn btn-block btn-success confirmInvoice" {{$invoice->items()->count()==0?'disabled':''}} {{$invoice->due_amount < 1?'':'disabled'}} >Confrim Order [F2]</button>
            </div>
            <div class="col-md-4" style="display: flex;justify-content: space-between;padding:5px;">
                <!--<a  class="btn btn-danger" href="{{route('admin.posOrdersAction',['cartreset',$invoice->id])}}" onclick="return confirm('Are you want to Reset?')">Reset</a>-->
                @if($invoice->items()->count() > 0)
                <!--<a  class="btn" href="{{route('admin.posOrdersAction',['neworder',$invoice->id])}}" onclick="return confirm('Are you want to New order?')" target="_blank" style="background-color: #11a578;border-color: #11a578;color:white;">New Order</a>-->
                @endif
            </div>
            <div class="col-md-5" style="padding:5px;text-align: center;">
                <div class="" style="display: flex;justify-content: end;">
                    <!--<a href="{{route('admin.posOrders')}}" class="btn btn-primary" data-url="{{route('admin.posOrders')}}">Sales</a>-->
                    
                    @if($invoice->order_status!='delivered')
                    <div class="searchInvoice" style="width: 250px;position: relative;">
                        <span class="searchInviceFilterErr"></span>
                        <div class="input-group">
                            <span class="btn btn-danger" style="border-radius:0;">Exchange</span> 
                            <input type="text" class="form-control searchInviceFilter" data-url="{{route('admin.posOrdersAction',['invoiceFilter',$invoice->id])}}" placeholder="Search Invoice No" autocomplete="off" style="border-radius:0;" >
                        </div>
                        <!--<div class="filterResult">-->
                        <!--    <ul>-->
                        <!--        <li>#252125145 - Bill: BDT 20,252</li>-->
                        <!--        <li>#2521251452 - Bill: BDT 1,020</li>-->
                        <!--    </ul>-->
                        <!--</div>-->
                    </div>
                    @endif
                </div>
            </div>
        </div>
        </form>
</div>