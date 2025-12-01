<a href="{{route('productBrand',$brand->slug?:'no-title')}}" class="brandGrid">
    <img src="{{route('imageView2',['resize',$brand->imageName(),'w'=>400,'h'=>400])}}" alt="{{$brand->name}}" />
    <p class="{{$brand->location}}">{{$brand->name}}</p>
</a>