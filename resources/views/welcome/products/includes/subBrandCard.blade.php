<a href="{{route('productBrand',$subBrand->slug?:'no-title')}}" class="brandGrid2">
    <img src="{{route('imageView2',['resize',$subBrand->imageName(),'w'=>400,'h'=>400])}}" alt="{{$subBrand->name}}" />
    <p>{{$subBrand->name}}</p>
</a>