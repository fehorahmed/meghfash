@extends(welcomeTheme().'layouts.app')  @section('title')
<title>{{websiteTitle('Login')}}</title>
@endsection @section('SEO')
<meta name="title" property="og:title" content="{{general()->meta_title}}" />
<meta name="description" property="og:description" content="{!!general()->meta_description!!}" />
<meta name="keyword" property="og:keyword" content="{{general()->meta_keyword}}" />
<meta name="image" property="og:image" content="{{asset(general()->logo())}}" />
<meta name="url" property="og:url" content="{{route('login')}}" />
<link rel="canonical" href="{{route('login')}}">
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
    border: 1px solid #ededed;
    border-radius: 10px;
}
.loginForm h4 {
    text-align: center;
    font-weight: bold;
    color: #0ba350;
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
    background-color: #0ba350;
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

<div class="loginPage">
    <div class="container">
           <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <form class="loginForm" action="{{route('login')}}" method="post">
                        @csrf
                        
                        <div class="loginFormHeader">
                            <h4>Login Your Account</h4>
                            <p style="text-align: center;margin: 10px 0;color: gray;">
                               Access your account by logging in below 
                            </p>
                        </div>
    
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
                            <div class="col-md-6">
                                <button type="submit" class="btn-auth">Login</button>
                            </div>
                            <div class="col-md-6">
                                <p><a href="{{route('forgotPassword')}}">Forgot Password?</a></p>
                            </div>
                        </div>
                        <p style="text-align: center;margin-top: 30px;">
                            You have not account? click <a  href="{{route('register')}}" style="display:inline;">Sign Up</a>
                        </p>
                    </form>
                </div>
                <div class="col-md-3"></div>
        </div>
    </div>
</div>

@endsection @push('js') @endpush