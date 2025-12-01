@extends(welcomeTheme().'layouts.app') @section('title')
<title>{{$page->seo_title?:websiteTitle($page->name)}}</title>
@endsection @section('SEO')
<meta name="title" property="og:title" content="{{$page->seo_title?:websiteTitle($page->name)}}" />
<meta name="description" property="og:description" content="{!!$page->seo_description?:general()->meta_description!!}" />
<meta name="keywords" content="{{$page->seo_keyword?:general()->meta_keyword}}" />
<meta name="image" property="og:image" content="{{asset($page->image())}}" />
<meta name="url" property="og:url" content="{{route('pageView',$page->slug?:'no-title')}}" />
<link rel="canonical" href="{{route('pageView',$page->slug?:'no-title')}}">
@endsection
@push('css')
<style>
.contactFormGrid .form-control {
    text-align: left;
    margin: 0;
}

</style>
@endpush 

@section('contents')

<div class="singleProHead">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$page->name}}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="cotactMainDiv">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                @include(welcomeTheme().'.alerts')
                <form class="formDiv" action="{{route('contactMail')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="contactFormGrid">
                                <div class="mb-3">
                                  <label  class="form-label">Full Name*</label>
                                  <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="Enter Your Name" required="">
                                  @if ($errors->has('name'))
                                <p style="color: red; margin: 0;">{{ $errors->first('name') }}</p>
                                @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="contactFormGrid">
                                <div class="mb-3">
                                  <label  class="form-label">Mobile No*</label>
                                  <input type="text" name="mobile" class="form-control" value="{{old('mobile')}}" placeholder="Enter Your Mobile Number" required="">
                                  @if ($errors->has('mobile'))
                                <p style="color: red; margin: 0;">{{ $errors->first('mobile') }}</p>
                                @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="contactFormGrid">
                                <div class="mb-3">
                                  <label class="form-label">Email</label>
                                  <input type="email" name="email" class="form-control" value="{{old('email')}}" placeholder="Enter Your Email" >
                                  @if ($errors->has('email'))
                                <p style="color: red; margin: 0;">{{ $errors->first('email') }}</p>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="textArea">
                                <div class="mb-3">
                                    <label class="form-label">Message</label>
                                    <textarea class="form-control" name="message"  placeholder="Message" rows="3" required="" style="text-align:left;">{{old('message')}}</textarea>
                                    @if ($errors->has('message'))
                                    <p style="color: red; margin: 0;">{{ $errors->first('message') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="contactSubmit">Submit Now</button>
                </form>
            </div>
            <div class="col-md-4">
                <div class="infoBoxContact">
                    <h4>Address</h4>
                    <p>
                       {!!general()->address_one!!}
                    </p>
                </div>
                
                <div class="infoBoxContact">
                    <h4>Call Us</h4>
                    <p>
                        For any queries call us on<br><a href="tel:{{general()->mobile}}">{{general()->mobile}}</a>
                    </p>
                </div>
                
                <div class="infoBoxContact">
                    <h4>Email Us</h4>
                    <p>
                        For any queries write to us on<br><a href="mailto:{{general()->email}}">{{general()->email}}</a>
                    </p>
                </div>
                
                <div class="infoBoxContact">
                    <h4>Follow Us</h4>
                    <ul class="socalLInk">
                        @if(general()->facebook_link)
                        <li>
                            <a href="{{general()->facebook_link}}" target="_blank"><i class="fa-brands fa-facebook" aria-hidden="true"></i></a>
                        </li>
                        @endif
                        @if(general()->linkedin_link)
                        <li>
                            <a href="{{general()->linkedin_link}}" target="_blank"><i class="fa-brands fa-linkedin" aria-hidden="true"></i></a>
                        </li>
                        @endif
                        @if(general()->twitter_link)
                        <li>
                            <a href="{{general()->twitter_link}}" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
                        </li>
                        @endif
                        @if(general()->youtube_link)
                        <li>
                            <a href="{{general()->youtube_link}}" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                        </li>
                        @endif
                        @if(general()->youtube_link)
                        <li>
                            <a href="{{general()->youtube_link}}" target="_blank"><i class="fa-brands fa-youtube" aria-hidden="true"></i></a>
                        </li>
                        @endif
                     </ul>
                </div>
            </div>
        </div>
        
        <div class="mapLocation mt-5">
            <div class="container-fluid">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d233667.49930141334!2d90.25487247764767!3d23.781067239454273!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8b087026b81%3A0x8fa563bbdd5904c2!2sDhaka!5e0!3m2!1sen!2sbd!4v1710478711621!5m2!1sen!2sbd" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>

@endsection @push('js') @endpush