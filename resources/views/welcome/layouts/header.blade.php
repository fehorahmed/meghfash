
<!-- header part start -->
<header>
    <div class="topHeader">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <p class="welcomeText">Welcome To <b></b> Online Shopping Store.</p>
                </div>
                <div class="col-md-4">
                    @if(offerNotes()->count() > 0)
                    <div class="headerTopPart">
                        @foreach(offerNotes() as $note)
                        <a class="slick-box selectedItem" href="javascript:void(0)">{!!$note->content!!}</a>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="col-md-4">
                    <ul class="accountList">
                        @if(Auth::check())
                        <li>
                            <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form-head').submit();" ><i class="fa fa-user-plus"></i> Log-out</a>
                            <form id="logout-form-head" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                        @else
                        <li>
                            <a href="{{route('login')}}"><i class="fa fa-user-o"></i> Login</a>
                        </li>
                        <li>
                            <a href="{{route('register')}}"><i class="fa fa-user-plus"></i> Register</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="middleHeader">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-2">
                    <div class="logoHeader">
                        <a href="{{route('index')}}" class="mainLogo">
                            <img src="{{asset(general()->logo())}}" alt="{{general()->title}}" />
                        </a>
                    </div>
                </div>
                <div class="col-xl-7 col-12">
                    <div class="searchBox">
                        <form action="{{route('search')}}" class="searchHeaderArea" style="position:relative;" >
                            <div class="input-group" id="searchHeaderInput">
                                <input type="text" class="form-control" name="search" value="{{request()->search}}" placeholder="Search For Products..." />
                                <button type="submit" class="input-group-text" style="background-color: unset;"><i class="fa fa-search"></i></button>
                            </div>
                            <div class="searchResultAjax"></div>
                        </form>
                    </div>
                </div>
                <div class="col-xl-3 col-12 p-0">
                    <ul class="cartWish">
                        <li>
                            @if(Auth::check())
                            <a href="{{route('customer.dashboard')}}">
                            @else
                            <a href="{{route('login')}}">
                            @endif
                                <div class="countPosi">
                                    <img src="{{asset('public/welcome/images/User.png')}}" alt="Bytebliss" />    
                                </div>
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{route('myWishlist')}}">
                                <div class="countPosi">
                                    <img src="{{asset('public/welcome/images/icon.png')}}" alt="Bytebliss" />
                                    <span class="wlcounter">@isset($wlCount){{$wlCount}}@endisset</span>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('carts')}}">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="countPosi">
                                            <img src="{{asset('public/welcome/images/Shopping_Cart.png')}}" alt="Bytebliss" />   
                                            <span class="cartCounter">@isset($cartsCount){{$cartsCount}}@endisset</span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <p>Total</p>
                                        <h5 class="cartTotal">@isset($cartTotalPrice){{priceFullFormat($cartTotalPrice)}}@endisset</h5>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="bottomHeader">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="toglerCtg">
                        <h3>Browse All Category <i class="fa fa-angle-down"></i></h3>
                        <div class="ctgScrolBar">
                            @if($menu = menu('Category Menus'))
                            <ul class="allctgList">
                                
                                @foreach($menu->subMenus as $menu)
                                <li>
                                    <a href="{{asset($menu->menuLink())}}">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <!--<i class="fa fa-mobile"></i>-->
                                                <img src="{{asset($menu->image())}}" class="" alt="Bytebliss"/>
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <span>{{$menu->menuName()}}</span>
                                            </div>
                                        </div>
                                    </a>
                                    @if($menu->subMenus()->count() > 0)
                                    <i class="fa fa-angle-right"></i>
                                    @endif
                                    @if($menu->subMenus()->count() > 0)
                                    <ul class="subCtg">
                                        @foreach($menu->subMenus as $menu)
                                        <li>
                                            <a href="{{asset($menu->menuLink())}}">{{$menu->menuName()}}</a>
                                            @if($menu->subMenus()->count() > 0)
                                            <i class="fa fa-angle-right"></i>
                                            @endif
                                            @if($menu->subMenus()->count() > 0)
                                            <ul class="subsubCtg">
                                                @foreach($menu->subMenus as $menu)
                                                <li>
                                                    <a href="{{asset($menu->menuLink())}}">{{$menu->menuName()}}</a>
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="menuList">
                        @if($menu = menu('Header Menus'))
                        <ul>
                            <li><a href="{{route('index')}}">Home</a></li>
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
</header>
<!-- header part end -->