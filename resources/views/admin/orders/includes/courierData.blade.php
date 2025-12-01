
@if(is_array($stores) && isset($stores[0]))
<select class="form-control form-control-sm courierStore" name="courier_store">
    <option value="">Select Store</option>
    
    @foreach($stores as $store)
        <option value="{{ $store['store_id'] }}">{{ $store['store_name'] }}</option>
    @endforeach

</select>
@endif

@if(is_array($districts) && isset($districts[0]))
<div class="input-group">
    <select class="form-control form-control-sm courierDistrict" name="courier_district" data-url="{{route('admin.ordersAction',['courier-district',$order->id])}}">
        <option value="">Select District</option>
        @foreach($districts as $district)
            <option value="{{ $district['city_id'] }}">{{ $district['city_name'] }}</option>
        @endforeach
    </select>

    <select class="form-control form-control-sm courierCity" name="courier_city">
        <option value="">Select Area</option>
    </select>
</div>
@endif