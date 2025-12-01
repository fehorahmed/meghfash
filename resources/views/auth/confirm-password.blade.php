@extends(welcomeTheme().'layouts.app')  @section('title')
<title>{{websiteTitle('Forget Password')}}</title>
@endsection @section('SEO')
<meta name="title" property="og:title" content="{{general()->meta_title}}" />
<meta name="description" property="og:description" content="{!!general()->meta_description!!}" />
<meta name="keyword" property="og:keyword" content="{{general()->meta_keyword}}" />
<meta name="image" property="og:image" content="{{asset(general()->logo())}}" />
<meta name="url" property="og:url" content="{{route('resetPassword',$user->remember_token?:'no-token')}}" />
<link rel="canonical" href="{{route('resetPassword',$user->remember_token?:'no-token')}}">
@endsection
@push('css')

<style>

    .lostpass{
        padding: 50px 0;
        background-color: #f9f9f9;
    }
    
    .forgetPassPage{
        padding:30px;
        background-color: #fff;
        border: 1px solid darkred;
    }
    
    .forgetPassPage p {
        font-size: 15px;
        margin-bottom: 20px;
    }
    
    .forgetPassPage .form-control {
        text-align: left;
        border-radius: 0;
        padding: 10px 20px;
        margin: 0;
    }
    .forgetPassPage  .form-control:focus {
        border-color: #86b7fe;
        box-shadow: none;
    }
    
    .forgetPassPage button.btn.submitbutton {
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
    
    .forgetPassPage label {
        display: block;
        margin-bottom: 5px;
    }
    
</style>

@endpush 

@section('contents')


<div class="lostpass">
	<div class="container">
	    <div class="row">
		    <div class="col-md-3"></div>
		    <div class="col-md-6">
		        <div class="forgetPassPage">
		            <p>
            			Lost your password? Please check  your email address. You will receive a Verify Code to create a new password.
            		</p>
            
            		<form  method="POST" action="{{route('resetPassword',$user->remember_token?:'no-token')}}">
                        @csrf
                        @include(welcomeTheme().'.alerts')
                        <label for="verify_code">
            				 Verify Code*
            			</label>
            			<div class="form-group form-group-section">
            			    <input type="number" class="form-control control-section {{$errors->has('verify_code')?'error':''}}" id="tb-verify" value="{{old('verify_code')}}" name="verify_code" placeholder="Enter Verify Code" required />
            			    @if($errors->has('verify_code'))
                                <span style="color:red;display: block;">{{ $errors->first('verify_code') }}</span>
                            @endif
            			</div>
            			<label for="password">
            				 New Password*
            			</label>
            			<div class="form-group form-group-section">
            			    <input type="password" name="password" value="{{old('password')}}" class="form-control control-section" placeholder="Enter New Password" required="">
            			    @if($errors->has('password'))
                                <span style="color:red;display: block;">{{ $errors->first('password') }}</span>
                            @endif
            			</div>
            			<div>
            				<button type="submit" class="btn submitbutton">RESET PASSWORD</button>
            			</div>
            		</form>
            	</div>
		    </div>
		    <div class="col-md-3"></div>
		</div>
	</div>
</div>


@endsection @push('js') @endpush