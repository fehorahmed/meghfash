<div class="sliderPart">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3"></div>
            <div class="col-xl-9">
                @if($slider =slider('Front Page Slider'))
                <div class="sliderImages">
                    <div class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($slider->subSliders as $i=>$slider)
                            <a href="{{$slider->seo_description?:'javascript:void(0);'}}">
                            <div class="carousel-item {{$i==0?'active':''}}" style="background-image:url({{asset($slider->image())}})">
                                <div class="sliderContent">
                                    <!--<span>HP</span>-->
                                    @if($slider->name)
                                    <h1>{!!$slider->name!!}</h1>
                                    @endif
                                    @if($slider->description)
                                    <p>{!!$slider->description!!}</p>
                                    @endif
                                    @if($slider->seo_title && $slider->seo_description)
                                    <a href="{{$slider->seo_description}}" class="shopNowBtn">{!!$slider->seo_title!!}</a>
                                    @endif
                                </div>
                            </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>