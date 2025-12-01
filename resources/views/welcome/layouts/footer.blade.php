
<div class="newsLetter" style="background-position: center; background-size: cover; background-repeat: no-repeat;">
    <div class="newsLetOverlay">
        <div class="container-fluid">
            <div class="newLetBox">
                <div class="row">
                    <div class="col-md-5">
                        <h3>Sign Up For Newsletter<br>$ Get 20% Off</h3>
                    </div>
                    <div class="col-md-7">
                        <form id="subscirbeForm" data-url="{{route('subscribe')}}">
                            <div class="input-group">
                                <input type="text" class="form-control" id="subscribeEmail" placeholder="Enter Email Address">
                                <span class="input-group-text subsriberbtm">Subscribe</span>
                            </div>
                        </form>
                         <div id="subscribeemailMsg"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- footer part start  -->
<footer>
    <div class="footPart">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-12">
                    <div class="aboutCompa">
                        <a href="{{route('index')}}">
                            <img src="{{asset(general()->logo())}}" alt="{{general()->title}}">
                        </a>
                        @if(general()->copyright_text)
                        <p>
                            {!!general()->copyright_text!!}
                        </p>
                        @endif
                        <h4>Social Media Links</h4>
                        <ul class="socialLinks">
                            @if(general()->facebook_link)
                            <li>
                                <a href="{{general()->facebook_link}}" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            </li>
                            @endif
                            @if(general()->linkedin_link)
                            <li>
                                <a href="{{general()->linkedin_link}}" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                            </li>
                            @endif
                            @if(general()->twitter_link)
                            <li>
                                <a href="{{general()->twitter_link}}" target="_blank"><i class="fa fa-twitter"></i></a>
                            </li>
                            @endif
                            @if(general()->youtube_link)
                            <li>
                                <a href="{{general()->youtube_link}}" target="_blank"><i class="fa fa-instagram"></i></a>
                            </li>
                            @endif
                            @if(general()->youtube_link)
                            <li>
                                <a href="{{general()->youtube_link}}" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    
                    <div class="footListPart">
                        @if($menu = menu('Footer Two'))
                        <h4>{{$menu->name}}</h4>
                        <ul class="footList">
                            @foreach($menu->subMenus as $menu)
                            <li><a href="{{asset($menu->menuLink())}}">{{$menu->menuName()}}</a></li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="footListPart">
                        @if($menu = menu('Footer Three'))
                        <h4>{{$menu->name}}</h4>
                        <ul class="footList">
                            @foreach($menu->subMenus as $menu)
                            <li><a href="{{asset($menu->menuLink())}}">{{$menu->menuName()}}</a></li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="footListPart">
                        @if($menu = menu('Footer Four'))
                        <h4>{{$menu->name}}</h4>
                        <ul class="footList">
                            @foreach($menu->subMenus as $menu)
                            <li><a href="{{asset($menu->menuLink())}}">{{$menu->menuName()}}</a></li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bootmFot">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <p>2024 Copyright <a href="{{route('index')}}">©{{general()->title}}. </a>All Rights Reserved.</p>
                </div>
                <div class="col-md-6">
                    <a href="#" class="paymentImg"><img src="{{asset('public/welcome/images/image 37.png')}}" alt="{{general()->title}}"></a>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer part end  -->