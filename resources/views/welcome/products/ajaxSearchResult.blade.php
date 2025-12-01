<ul>
    @if($products->count() > 0)
    @foreach($products as $pd)
    <li>
    <a href="{{route('productView',$pd->slug?:Str::slug($pd->name))}}">
        <img src="{{asset($pd->image())}}">
        <div class="desc">{{Str::limit($pd->name,30)}}</div>
        <div class="price">{{priceFullFormat($pd->offerPrice())}}</div>
    </a>
    </li>
    @endforeach
    @else
    <li><a href="javascript:void(0)">No Result Found</a></li>
    @endif
</ul>