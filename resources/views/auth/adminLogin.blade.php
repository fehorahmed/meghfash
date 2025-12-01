@extends('auth.layouts.app')  @section('title')
<title>{{websiteTitle('Admin Login')}}</title>
@endsection @section('SEO')
<meta name="title" property="og:title" content="{{general()->meta_title}}" />
<meta name="description" property="og:description" content="{!!general()->meta_description!!}" />
<meta name="keyword" property="og:keyword" content="{{general()->meta_keyword}}" />
<meta name="image" property="og:image" content="{{asset(general()->logo())}}" />
<meta name="url" property="og:url" content="{{route('admin')}}" />
<link rel="canonical" href="{{route('admin')}}">
@endsection
@push('css')

<style>

.loginPage {
    padding: 50px 0;
    background-color: #f9f9f9;
}
.loginForm {
    padding: 22px 30px;
    background-color: #fff;
    border: 1px solid #a01a22;
}
.loginForm h4 {
    text-align: center;
    font-weight: bold;
    color: #c56d6d;
}
.loginForm .form-label {
    font-weight: 600;
    font-size: 14px;
    color: #726161;
    margin-bottom: 2px;
}
.loginForm .form-control {
    text-align: left;
    border-radius: 0;
    padding: 10px 20px;
    margin: 0;
}
.loginForm  .form-control:focus {
    border-color: #86b7fe;
    box-shadow: none;
}
.loginForm p {
    text-align: right;
}
.loginForm p a {
    color: #a01a22;
    display: block;
    text-align: center;
    margin-top: 20px;
    letter-spacing: 1px;
}
a.signBtn {
    display: block;
    background-color: #000;
    text-align: center;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-top: 20px;
    padding: 10px 0;
    transition-duration: 0.2s;
}
.loginForm button.btn-auth {
    background-color: #a01a22;
    color: #fff;
    font-size: 16px;
    display: block;
    text-transform: uppercase;
    border: none;
    padding: 10px 0;
    display: block;
    width: 100%;
    margin-top: 15px;
    transition: .2s all;
    letter-spacing: 1px;
}
.loginForm button.btn-auth:hover {
    background-color: #7a1219;
}
</style>

@endpush 

@section('contents')


 <div class="content-header row"></div>
    <div class="content-body">
        <section class="row flexbox-container">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
                    <div class="card border-grey border-lighten-3 m-0">
                        <div class="card-header border-0">
                            <div class="card-title text-center">
                                <div class="p-1"><a href="{{route('index')}}"><img src="{{asset(general()->logo())}}" alt="{{general()->title}}" style="max-width: 100%;max-height: 50px;" /></a></div>
                            </div>
                            <h6 class="card-subtitle line-on-side text-muted text-center pt-2" style="font-size: 24px;"><span>Admin Login </span></h6>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                @include(adminTheme().'.alerts')
                                <form class="form-horizontal form-simple" action="{{route('admin')}}"  method="post">
                                    @csrf
                                    <fieldset class="form-group position-relative has-icon-left mb-0">
                                        <input type="email" class="form-control form-control-lg" name="email"  value="{{old('email')}}" placeholder="Your Email" required="" />
                                        <div class="form-control-position">
                                            <i class="fa-solid fa-envelope"></i>
                                        </div>
                                    </fieldset>
                                    @if($errors->has('email'))
                                        <span style="color:red;display: block;">{{ $errors->first('email') }}</span>
                                    @endif
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input type="password" class="form-control form-control-lg" name="password" value="{{old('password')}}" placeholder="Enter Password" required="" />
                                        <div class="form-control-position">
                                            <i class="fa fa-key"></i>
                                        </div>
                                    </fieldset>
                                    @if($errors->has('password'))
                                        <span style="color:red;display: block;">{{ $errors->first('password') }}</span>
                                    @endif
                                    <div class="form-group row">
                                        <div class="col-sm-6 col-12 text-center text-sm-left">
                                            <fieldset>
                                                <input type="checkbox" name="remember" id="remember-me" class="chk-remember" />
                                                <label for="remember-me"> Remember Me </label>
                                            </fieldset>
                                        </div>
                                        <div class="col-sm-6 col-12 text-center text-sm-right">
                                            
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="fa-solid fa-unlock"></i> Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


{{--
<div class="loginPage">
    <div class="container">
           <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <form class="loginForm" action="{{route('admin')}}" method="post">
                        @csrf
                        <h4>Admin Login</h4>
                        
                        @include(welcomeTheme().'.alerts')
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" value="{{old('email')}}" name="email" class="form-control" placeholder="Enter Your Email">
                            @if($errors->has('email'))
                                <span style="color:red;display: block;">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password*</label>
                            <input type="password" name="password" class="form-control"  placeholder="Enter Your Password">
                            @if($errors->has('password'))
                                <span style="color:red;display: block;">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn-auth">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3"></div>
        </div>
    </div>
</div>
--}}

@endsection @push('js') @endpush