<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Supplier*</label>
            @if($invoice->items()->count() > 0)
            <input type="text" readonly value="{{$invoice->name}}" class="form-control">
            @else
            <select class="form-control selectSupplier"  data-url="{{route('admin.purchasesAction',['supplier-select',$invoice->id])}}">
                <option value="">Select Supplier</option>
                @foreach($suppliers as $supplier)
                <option value="{{$supplier->id}}" {{$supplier->id==$invoice->user_id?'selected':''}}>{{$supplier->name}}</option>
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
            <select class="form-control selectWarehouse"  data-url="{{route('admin.purchasesAction',['warehouse-select',$invoice->id])}}">
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
            <label>Create Date*</label>
            <input type="date" value="{{$invoice->created_at->format('Y-m-d')}}" name="created_at" class="form-control" required="">
            @if ($errors->has('created_at'))
            <p style="color: red; margin: 0;">{{ $errors->first('created_at') }}</p>
            @endif
        </div>
    </div>
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