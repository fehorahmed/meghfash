<div class="row">
    <div class="col-md-6">
        <div class="table-responsive">
            <table class="table table-borderless">
                <tr>
                    <td>Invoice No*</td>
                    <td style="padding:1px;">
                        <input type="text" name="invoice" value="{{$invoice->invoice}}" readonly="" class="form-control" placeholder="Enter Invoice No" required="">
                        @if ($errors->has('invoice'))
                        <p style="color: red; margin: 0;">{{ $errors->first('invoice') }}</p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Wholesale Date*</td>
                    <td style="padding:1px;">
                        <input type="date" value="{{$invoice->created_at->format('Y-m-d')}}" name="created_at" class="form-control" required="">
                        @if ($errors->has('created_at'))
                        <p style="color: red; margin: 0;">{{ $errors->first('created_at') }}</p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Store/Branch*</td>
                    <td style="padding:1px;">
                        @if($invoice->items()->count() > 0)
                        <input type="text" readonly value="{{$invoice->branch?$invoice->branch->name:''}}" class="form-control">
                        @else
                        <select class="form-control selectWarehouse"  data-url="{{route('admin.wholeSalesAction',['warehouse-select',$invoice->id])}}">
                            <option value="">Select Store/Branch</option>
                            @foreach($warehouses as $warehouse)
                            <option value="{{$warehouse->id}}" {{$warehouse->id==$invoice->branch_id?'selected':''}}>{{$warehouse->name}}</option>
                            @endforeach
                        </select>
                        @endif
                        <span class="warehouseErro" style="color:red;"></span>
                    </td>
                </tr>
                <tr>
                    <td>Customer*</td>
                    <td style="padding:1px;">
                        @if($invoice->items()->count() > 0)
                        <input type="text" readonly value="{{$invoice->company_name}} / {{$invoice->name}}" class="form-control">
                        @else
                        <select class="form-control selectSupplier"  data-url="{{route('admin.wholeSalesAction',['customer-select',$invoice->id])}}">
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                            <option value="{{$customer->id}}" {{$customer->id==$invoice->user_id?'selected':''}}>{{$customer->name}}</option>
                            @endforeach
                        </select>
                        @endif
                        <span class="supplierErro" style="color:red;"></span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="table-responsive">
            <table class="table table-borderless">
                <tr>
                    <td>Company name*</td>
                    <td style="padding:1px;">
                        <input type="text" name="company_name" value="{{$invoice->company_name}}" class="form-control updateInfo" data-url="{{route('admin.wholeSalesAction',['company-name',$invoice->id])}}" placeholder="Enter company name" required="">
                        @if ($errors->has('company_name'))
                        <p style="color: red; margin: 0;">{{ $errors->first('company_name') }}</p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Customer name*</td>
                    <td style="padding:1px;">
                        <input type="text" name="name" value="{{$invoice->name}}" class="form-control updateInfo" data-url="{{route('admin.wholeSalesAction',['customer-name',$invoice->id])}}" placeholder="Enter Customer name" required="">
                        @if ($errors->has('name'))
                        <p style="color: red; margin: 0;">{{ $errors->first('name') }}</p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Mobile/Email*</td>
                    <td style="padding:1px;">
                        <input type="text" name="mobile_email" value="{{$invoice->mobile?:$invoice->email}}" data-url="{{route('admin.wholeSalesAction',['mobile-email',$invoice->id])}}" class="form-control updateInfo" placeholder="Enter mobile/Email " required="">
                        @if ($errors->has('mobile_email'))
                        <p style="color: red; margin: 0;">{{ $errors->first('mobile_email') }}</p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td style="padding:1px;">
                        <input type="text" name="address" value="{{$invoice->address}}" class="form-control updateInfo" data-url="{{route('admin.wholeSalesAction',['address',$invoice->id])}}" placeholder="Enter Address" >
                        @if ($errors->has('address'))
                        <p style="color: red; margin: 0;">{{ $errors->first('address') }}</p>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
    {{--
    <div class="col-md-3">
        <div class="form-group">
            <label>Customer*</label>
            @if($invoice->items()->count() > 0)
            <input type="text" readonly value="{{$invoice->name}}" class="form-control">
            @else
            <select class="form-control selectSupplier"  data-url="{{route('admin.wholeSalesAction',['customer-select',$invoice->id])}}">
                <option value="">Select Customer</option>
                @foreach($customers as $customer)
                <option value="{{$customer->id}}" {{$customer->id==$invoice->user_id?'selected':''}}>{{$customer->name}}</option>
                @endforeach
            </select>
            @endif
            <span class="supplierErro" style="color:red;"></span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Store/Branch*</label>
            @if($invoice->items()->count() > 0)
            <input type="text" readonly value="{{$invoice->branch?$invoice->branch->name:''}}" class="form-control">
            @else
            <select class="form-control selectWarehouse"  data-url="{{route('admin.wholeSalesAction',['warehouse-select',$invoice->id])}}">
                <option value="">Select Store/Branch</option>
                @foreach($warehouses as $warehouse)
                <option value="{{$warehouse->id}}" {{$warehouse->id==$invoice->branch_id?'selected':''}}>{{$warehouse->name}}</option>
                @endforeach
            </select>
            @endif
            <span class="warehouseErro" style="color:red;"></span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Invoice No*</label>
            <input type="text" name="invoice" value="{{$invoice->invoice}}" class="form-control" placeholder="Enter Invoice No" required="">
            @if ($errors->has('invoice'))
            <p style="color: red; margin: 0;">{{ $errors->first('invoice') }}</p>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Stock Date*</label>
            <input type="date" value="{{$invoice->created_at->format('Y-m-d')}}" name="created_at" class="form-control" required="">
            @if ($errors->has('created_at'))
            <p style="color: red; margin: 0;">{{ $errors->first('created_at') }}</p>
            @endif
        </div>
    </div>
    --}}
    <div class="col-md-12">
        <div class="form-group">
            <label>Note</label>
            <textarea class="form-control" name="note" placeholder="Write Invoice Note.">{{$invoice->note}}</textarea>
            @if ($errors->has('note'))
            <p style="color: red; margin: 0;">{{ $errors->first('note') }}</p>
            @endif
        </div>
    </div>
</div>