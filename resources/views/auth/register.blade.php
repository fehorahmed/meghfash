@extends(welcomeTheme().'layouts.app')  @section('title')
<title>{{websiteTitle('Register')}}</title>
@endsection @section('SEO')
<meta name="title" property="og:title" content="{{general()->meta_title}}" />
<meta name="description" property="og:description" content="{!!general()->meta_description!!}" />
<meta name="keyword" property="og:keyword" content="{{general()->meta_keyword}}" />
<meta name="image" property="og:image" content="{{asset(general()->logo())}}" />
<meta name="url" property="og:url" content="{{route('register')}}" />
<link rel="canonical" href="{{route('register')}}">
@endsection
@push('css')

<style>

.regisPage {
    padding: 50px 0;
    background-color: #f9f9f9;
}
a.regisLogin {
    display: block;
    text-align: center;
    font-size: 20px;
    color: darkred;
    margin-top: 15px;
    font-weight: bold;
    letter-spacing: 1px;
}
a.regisLogin span{
    color: blue;
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

<div class="regisPage">
    <div class="container">
        <div class="row">
              <div class="col-md-3"></div>
              <div class="col-md-6">
                  @include(welcomeTheme().'.alerts')
                  <form class="loginForm" action="{{route('register')}}" method="post">
                      @csrf
                      <h5>Become User</h5>
                      <span>if your new to our store, we glad to have you as member.</span>
                      <div class="mb-3">
                          <label for="name" class="form-label">Name*</label>
                          <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="Enter Your Name">
                          @if($errors->has('name'))
                            <span style="color:red;display: block;">{{ $errors->first('name') }}</span>
                          @endif
                     </div>
                     <div class="mb-3">
                          <label for="email" class="form-label">Email*</label>
                          <input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="Enter Your Email">
                          @if($errors->has('email'))
                              <span style="color:red;display: block;">{{ $errors->first('email') }}</span>
                          @endif
                     </div>
                      <div class="mb-3">
                          <label for="exampleFormControlInput1" class="form-label">Password*</label>
                          <input type="password" name="password" class="form-control" placeholder="Enter Your Password">
                          @if($errors->has('password'))
                            <span style="color:red;display: block;">{{ $errors->first('password') }}</span>
                          @endif
                     </div>
                     <button type="submit" class="btn-auth">Sign Up</button>
                 </form>
              </div>
              <div class="col-md-3"></div>
              <div class="col-md-12">
                <a class="regisLogin" href="{{route('login')}}">Alrady Have An Account? <span>Log-In</span></a>
              </div>
        </div>
    </div>
</div>

@endsection @push('js') @endpush
