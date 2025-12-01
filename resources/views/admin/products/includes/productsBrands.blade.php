
<option value="">Select Sub Brand</option>
@if($brand)
@foreach($brand->subbrands as $brand)
<option value="{{$brand->id}}">{{$brand->name}} </option>
@endforeach
@endif