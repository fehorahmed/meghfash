@extends(welcomeTheme().'layouts.app') @section('title')
<title>{{websiteTitle()}}</title>
@endsection @section('SEO')
<meta name="title" property="og:title" content="{{general()->meta_title}}" />
<meta name="description" property="og:description" content="{!!general()->meta_description!!}" />
<meta name="keyword" property="og:keyword" content="{{general()->meta_keyword}}" />
<meta name="image" property="og:image" content="{{asset(general()->logo())}}" />
<meta name="url" property="og:url" content="{{route('index')}}" />
<link rel="canonical" href="{{route('index')}}" />
@endsection 

@push('css') 

@endpush 
@section('contents')

<!--Slider Part Include Start-->
@include(general()->theme.'.layouts.slider')

@if($featuredText)
<div class="punchLine">
    <div class="container-fluid">
        <div class="row" style="margin:0 -5px">
            <div class="col-md-3 col-6" style="padding:5px">
                <div class="punchBox">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{asset('public/welcome/images/Layer_1.png')}}" alt="Byteblis" />
                        </div>
                        <div class="col-md-9">
                            <h5>Payment & Delivery</h5>
                            <p>{!!$featuredText->name!!}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6" style="padding:5px">
                <div class="punchBox">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{asset('public/welcome/images/Layer_1 (1).png')}}" alt="Byteblis" />
                        </div>
                        <div class="col-md-9">
                            <h5>Return & Refund</h5>
                            <p>{!!$featuredText->content!!}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6" style="padding:5px">
                <div class="punchBox">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{asset('public/welcome/images/Layer_1 (2).png')}}" alt="Byteblis" />
                        </div>
                        <div class="col-md-9">
                            <h5>24x7 Free Support</h5>
                            <p>{!!$featuredText->sub_title!!}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6" style="padding:5px">
                <div class="punchBox">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{asset('public/welcome/images/Vector.png')}}" alt="Byteblis" />
                        </div>
                        <div class="col-md-9">
                            <h5>Special Gift Cards</h5>
                            <p>{!!$featuredText->description!!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if($bannerGroupOne->count() > 0)
<div class="offerProducts">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                @if($data=$bannerGroupOne->first())
                {{--<div class="leftOfferBox">
                    <span>
                       {!!$data->sub_title!!}
                    </span>
                    <h2>{!!$data->name!!}</h2>
                    @if($data->image_link)
                    <a href="{{$data->image_link}}">Shop Now <i class="fa fa-long-arrow-right"></i></a>
                    @endif
                    <div class="newArImg">
                        <a href="{{$data->image_link}}">
                            <img src="{{asset($data->image())}}" alt="{{$data->name}}" />
                        </a>
                    </div>
                </div>--}}
                <div class="leftOfferBox">
                    <a href="{{$data->image_link}}">
                        <img src="{{asset($data->image())}}" alt="{{$data->name}}" />
                    </a>
                </div>
                @endif
            </div>
            <div class="col-md-6">
                @foreach($bannerGroupOne as $i=>$data)
                    @if($i==0) @else
                    {{--<div class="rightOfferBox">
                        <h1>{!!$data->name!!}</h1>
                        <p>
                           {!!$data->sub_title!!}
                        </p>
                        @if($data->image_link)
                        <a href="{{$data->image_link}}">Shop Now <i class="fa fa-long-arrow-right"></i></a>
                        @endif
                        <div class="newleftArImg">
                            <img src="{{asset($data->image())}}" alt="{{$data->name}}" />
                        </div>
                    </div>--}}
                    <div class="rightOfferBox">
                        <a href="{{$data->image_link}}">
                            <img src="{{asset($data->image())}}" alt="{{$data->name}}" />
                        </a>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<div class="featuredCtgs">
    <div class="container-fluid">
        <h2>Featured Categories</h2>
        <div class="feaCtgSlick">
            @foreach($category as $hCtg)
            <div class="slick-box">
                <a href="{{route('productCategory',$hCtg->slug?:'no-title')}}" class="deatVtgGrid">
                    <img src="{{asset($hCtg->image())}}" alt="{{$hCtg->name}}" />
                    <p>{{$hCtg->name}}</p>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>



@include(general()->theme.'.layouts.featuredProductTab')

@foreach($largeBannerOne as $data)
<div class="smartPart">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="smartPartImg">
                    <img src="{{asset($data->image())}}" alt="{{$data->name}}" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="smartContent">
                    <span>{!!$data->sub_title!!}</span>
                    <h1>
                        {!!$data->name!!}
                    </h1>
                    <p>
                    {!!$data->description!!}
                    </p>
                    @if($data->image_link)
                    <a href="#">Shop Now</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach




@if($bannerGroupTwo->count() > 0)
<div class="twoPartBanner">
    <div class="container-fluid">
        <div class="row">
            @foreach($bannerGroupTwo as $i=>$data)
            <div class="col-md-6">
                {{--<div class="rightOfferBox {{$i % 2 === 0?'':'blackBox'}}">
                    <h1>{!!$data->name!!}</h1>
                    <p>
                       {!!$data->sub_title!!}
                    </p>
                    @if($data->image_link)
                    <a href="{{$data->image_link}}">Shop Now <i class="fa fa-long-arrow-right"></i></a>
                    @endif
                    <div class="newleftArImg">
                        <img src="{{asset($data->image())}}" alt="{{$data->name}}" /><img src="{{asset($data->image())}}" alt="{{$data->name}}" /><img src="{{asset($data->image())}}" alt="{{$data->name}}" />
                    </div>
                </div>--}}
                <div class="rightOfferBox {{$i % 2 === 0?'':'blackBox'}}">
                    <a href="{{$data->image_link}}">
                        <img src="{{asset($data->image())}}" alt="{{$data->name}}" />
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@foreach($categoryGroupOne as $data)
<div class="allProd">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10">
                <h1>{!!$data->name!!}</h1>
            </div>
            <div class="col-md-2">
                 @if($ctg =$data->category)
                <a href="{{route('productCategory',$ctg->slug?:'no-title')}}" class="showMoreLink">Show More</a>
                @endif
            </div>
            <div class="col-md-12">
                <hr />
            </div>
            <div class="col-md-12">
                <div class="row productRow">
                    @foreach($data->products() as $product)
                    <div class="col-md-3 col-6">
                        @include(welcomeTheme().'.products.includes.productCard')
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($largeBannerTwo as $data)
<div class="bannerMiddlw">
    <div class="container-fluid">
        <a href="{{$data->image_link?:'javascript:void(0)'}}">
            <img src="{{asset($data->image())}}" alt="{{$data->name}}" />
        </a>
    </div>
</div>
@endforeach

@foreach($categoryGroupTwo as $data)
<div class="allProd">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10">
                <h1>{!!$data->name!!}</h1>
            </div>
            <div class="col-md-2">
                @if($ctg =$data->category)
                <a href="{{route('productCategory',$ctg->slug?:'no-title')}}" class="showMoreLink">Show More</a>
                @endif
            </div>
            <div class="col-md-12">
                <hr />
            </div>
            <div class="col-md-12">
                <div class="row productRow">
                    @foreach($data->products() as $product)
                    <div class="col-md-3 col-6">
                        @include(welcomeTheme().'.products.includes.productCard')
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@if($data =$timeOfferBanner)
<div class="superSale">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <img class="superImg" src="{{asset($data->image())}}" alt="{{$data->name}}" />
            </div>
            <div class="col-md-6">
                <div class="offerCounter">
                    <h4>{!!$data->sub_title!!}</h4>
                    <h2>{!!$data->name!!}</h2>
                    
                    <div class="mainOfferq" data-date="{{Carbon\Carbon::now()->addDay($data->data_limit)->format('d/m/Y')}}">
                        <ul>
                            <li><span id="days"></span>days</li>
                            <li><span id="hours"></span>Hours</li>
                            <li><span id="minutes"></span>Minutes</li>
                            <li><span id="seconds"></span>Seconds</li>
                        </ul>
                    </div>
                    
                    @if($data->image_link)
                    <a href="{{$data->image_link}}">Shop Now</a>
                    @endif
                    
                </div>
            </div>
            <div class="col-md-3">
                <img class="superImg" src="{{asset($data->banner())}}" alt="{{$data->name}}" />
            </div>
        </div>
    </div>
</div>
@endif

@if($brands->count() > 0)


@include(general()->theme.'.layouts.brandsProduct')


@endif


@if($bannerGroupThree->count() > 0)
<div class="twoPartBanner">
    <div class="container-fluid">
        <div class="row">
            @foreach($bannerGroupThree as $i=>$data)
            <div class="col-md-6">
                {{--<div class="rightOfferBox {{$i % 2 === 0?'':'blackBox'}}">
                    <h1>{!!$data->name!!}</h1>
                    <p>
                       {!!$data->sub_title!!}
                    </p>
                    @if($data->image_link)
                    <a href="{{$data->image_link}}">Shop Now <i class="fa fa-long-arrow-right"></i></a>
                    @endif
                    <div class="newleftArImg">
                        <img src="{{asset($data->image())}}" alt="{{$data->name}}" />
                    </div>
                </div>--}}
                <div class="rightOfferBox {{$i % 2 === 0?'':'blackBox'}}">
                    <a href="{{$data->image_link}}">
                        <img src="{{asset($data->image())}}" alt="{{$data->name}}" />
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@if($page->description)
<div class="homeSeoContent">
    <div class="container-fluid">
        <div class="homeTextBox pageContents">
            {!!$page->description!!}
        </div>
    </div>
</div>
@endif

@endsection 
@push('js') 

<script type="text/javascript">
    $(document).ready(function () {
        const second = 1000,
              minute = second * 60,
              hour = minute * 60,
              day = hour * 24;

        // Get the date from the data attribute (d/m/Y format from Carbon)
        let birthday = $('.mainOfferq').data('date');

        // Split the date (d/m/Y) into day, month, year
        let dateParts = birthday.split('/');
        let dayOfMonth = dateParts[0];
        let month = dateParts[1] - 1; // Month is 0-based in JavaScript (0 = January)
        let year = dateParts[2];

        // Create a JavaScript Date object in MM/DD/YYYY format
        let formattedBirthday = new Date(year, month, dayOfMonth).getTime();

        // Get today's date in MM/DD/YYYY format
        let today = new Date(),
            dd = String(today.getDate()).padStart(2, '0'),
            mm = String(today.getMonth() + 1).padStart(2, '0'),
            yyyy = today.getFullYear();

        today = mm + '/' + dd + '/' + yyyy;

        // If today's date is greater than the birthday, set the birthday to the next year
        if (today > birthday) {
            formattedBirthday = new Date(yyyy + 1, month, dayOfMonth).getTime();
        }

        // Countdown target date
        const countDown = formattedBirthday;

        // Update the countdown every second
        const x = setInterval(function () {
            const now = new Date().getTime(),
                  distance = countDown - now;

            $('#days').text(Math.floor(distance / day));
            $('#hours').text(Math.floor((distance % day) / hour));
            $('#minutes').text(Math.floor((distance % hour) / minute));
            $('#seconds').text(Math.floor((distance % minute) / second));

            // If the countdown reaches 0, display the message and hide countdown
            if (distance < 0) {
                $('#headline').text("Today is the Day!");
                $('#countdown').hide();
                $('#content').show();
                clearInterval(x);
            }
        }, 1000);
    });
</script>

@endpush