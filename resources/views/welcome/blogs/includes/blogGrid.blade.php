<div class="blogGrid">
    <div class="image">
        <a href="{{route('blogView',$post->slug?:'no-title')}}">
            <img src="{{asset($post->image())}}" alt="{{$post->name}}">
        </a>
        @if($ctg =$post->postCategories()->first())
        <a href="{{route('blogCategory',$ctg->slug?:'no-title')}}" class="ctg">{{$ctg->name}}</a>
        @endif
    </div>
    <div class="title">
        <a href="{{route('blogView',$post->slug?:'no-title')}}">{{$post->name}}</a>
    </div>
    <div class="author">
        <div class="row m-0">
            <div class="col-6 p-0">
                <i class="fa fa-user"></i> By <a href="javascript:void(0)" style="color: #0ba350;">Bytebliss</a>
            </div>
            <div class="col-6 p-0" style="text-align:right;">
                <i class="fa fa-calander"></i> {{$post->created_at->format('d M Y')}}
            </div>
        </div>
    </div>
</div>
