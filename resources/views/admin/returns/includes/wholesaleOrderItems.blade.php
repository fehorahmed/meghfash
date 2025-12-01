
{!!$message!!}
@if($parentOrder =$order->parentOrder)
    <h3>Order item</h3>
    <table class="table table-bordered">
        <tr>
            <td style="min-width:50px;width: 50px;">SL</td>
            <th style="min-width:60px;width:60px;">Image</th>
            <td style="min-width:200px;">Item description</td>
            <td style="min-width:120px;width: 120px;">Price</td>
            <td style="min-width:120px;width: 120px;">Order Qty</td>
            <td style="min-width:120px;width: 120px;">Return Qty</td>
            <td style="min-width:150px;width: 150px;">Total</td>
        </tr>
        @foreach($parentOrder->items as $i=>$rItem)
        <tr>
            <td>{{$i+1}}</td>
            <td><img src="{{asset($rItem->image())}}" style="max-height: 40px;max-width: 100%;"></td>
            <td>
                <b>{{$rItem->product_name}}</b> <br>
                @if(count($rItem->itemAttributes()) > 0)
				    @foreach($rItem->itemAttributes() as $i=>$attri)
				        @if(isset($attri['title']) && isset($attri['value']))
                        {{$i==0?'':','}} <span>{{$attri['title']}} : {{$attri['value']}}</span>
                        @endif
                    @endforeach
			    @endif
            </td>
            <td>{{$rItem->price}}</td>
            <td style="text-align: center;">{{$rItem->quantity}}</td>
            <td style="padding:5px;">
                <input type="number" value="{{$rItem->return_quantity}}" class="form-control form-control-sm itemUpdate" data-url="{{route('admin.wholesaleReturnAction',['item-quantity',$order->id])}}" data-id="{{$rItem->id}}" >
            </td>
            <td>{{$rItem->return_total}}</td>
        </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" style="text-align:right;">Return Amount</td>
            <td>{{$parentOrder->return_amount}}</td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td colspan="2">
                <div class="form-group">
                    <button class="btn btn-success" type="submit" style="width: 100%;background-color: #e91e63 !important;border-color: #e91e63;">
                    <i class="fa fa-check"></i>
                    Submit Return
                   </button>
                </div>
            </td>
        </tr>
    </table>
@endif