<?php

namespace App\Http\Controllers\Auth;


use Auth;
use Str;
use Hash;
use File;
use Http;
use url;
use Session;
use Cookie;
use Socialite;
use Validator;
use Redirect,Response;
use Carbon\Carbon;
use App\Models\User;
use App\Models\SocialIdentity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthController extends Controller
{
    
    public function __construct()
    {
    	$this->middleware('authCheck');
    }
    
    public function login(Request $r){

        if ($r->isMethod('post'))
        {
            $check = $r->validate([
            'email' => 'required|max:100',
            'password' => 'required|max:50'
            ]);

            if(!$check){
                Session::flash('error','Need To validation');
                return back();
            }

            $login = $r->email;

            $remember_me  = ( !empty( $r->remember ) )? TRUE : FALSE;
            
            if(is_numeric($login)){
                $field = 'mobile';
            } elseif (filter_var($login, FILTER_VALIDATE_EMAIL)) {
                $field = 'email';
            } else {
                $field = 'name';
            }

            $user =User::where($field,$login)->first();

            if($user){
                if(Hash::check($r->password, $user->password)){
                    Auth::login($user, $remember_me);

                    $redirect =Session::get('url.intended');
                    //Session::forget('url.intended');
                    if($redirect){
                        return Redirect::to($redirect);
                    }
                    
                    if($user->id=='674'){
                        return Redirect()->route('admin.posOrdersReports');
                    }
                    return Redirect()->route('customer.dashboard');
                    
                }else{
                    Session::flash('error','Your Acounts Password Are Incorrect');
                    return back();
                }
            }else{
                Session::flash('error','Your No Accounts Have With Us');
                return back();
            }

            //Login Post Action End

        }


        
        

        return Inertia::render('Auth/Login');
    	
    }


    public function register(Request $r){

        if ($r->isMethod('post'))
        {

            if($r->has('email_phone')){

                if(filter_var($r->email_phone, FILTER_VALIDATE_EMAIL)) {
                    $hasUser = User::where('email', $r->email_phone)->where('status','<>',2)->first();
                    if($hasUser){
                        return response()->json([
                            'success' => false,
                            'message' => 'Your email address is already register. Try login'
                        ], 200);
                    }
                }elseif(is_numeric($r->email_phone)){
                    if(strlen($r->email_phone)!=11){
                        return response()->json([
                            'success' => false,
                            'message' => 'Mobile Number mustbe 11 digits'
                        ], 200);
                    }

                    $hasUser = User::where('mobile', $r->email_phone)->where('status','<>',2)->first();
                    if($hasUser){
                        return response()->json([
                            'success' => false,
                            'message' => 'Your Mobile number is already register. Try login'
                        ], 200);
                    }

                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Your input are invalied'
                    ], 200);
                }
                
                if($r->has('otpCode')){
                    if(strlen($r->otpCode)!=6){
                        return response()->json([
                            'success' => false,
                            'message' => 'OTP code  mustbe 6 digits'
                        ], 200);
                    }

                    if(filter_var($r->email_phone, FILTER_VALIDATE_EMAIL)) {
                        $user = User::where('email', $r->email_phone)->where('status',2)->first();
                        if(!$user){
                            return response()->json([
                                'success' => false,
                                'message' => 'Somthing is worng. try again register.'
                            ], 200);
                        }
                    }else{
                        $user = User::where('mobile', $r->email_phone)->where('status',2)->first();
                        if(!$user){
                            return response()->json([
                                'success' => false,
                                'message' => 'Somthing is worng. try again register.'
                            ], 200);
                        }
                    }


                    if($r->has('name') && $r->has('password')){

                        $rules = [
                            'name' => 'required|max:100',
                            'password' => 'required|min:8',
                          ];
                          
                          $validator = Validator::make($r->all(), $rules);
                    
                    
                          if ($validator->fails()) {
                            return response()->json([
                                'success' => false,
                                'message' => 'Validation failed',
                                'errors' => $validator->messages(),
                            ], 200); 
                          }
                        
                        if($r->name && $r->password){
                            $password= $r->password;
                            $user->verify_code=null;
                            $user->name=$r->name;
                            $user->password=Hash::make($password);
                            $user->password_show=$password;
                            $user->status=1;
                            $user->save();

                            Auth::login($user, true);

                            //Send Mail 
                            if(general()->mail_status && $user->email){
                                $toEmail =$user->email;
                                $toName =$user->name;
                                $subject ='Register Success Mail Form '.general()->title;
                                $datas =array('name'=>$user->name);
                                $template ='mails.registrationMail';
                                sendMail($toEmail,$toName,$subject,$datas,$template);
                            }

                            //Send SMS 
                            if(general()->sms_status && $user->mobile){
                                $msg ='Congratulations! Your registration is complete. Enjoy using '.general()->website.'!';
                                sendSMS($user->mobile,$msg);
                            }

                            return response()->json([
                                'success' => true,
                                'message' => 'Successfully'
                            ], 200);

                        }else{
                            return response()->json([
                                'success' => false,
                                'message' => 'Somthing is worng. try again register.'
                            ], 200);
                        }

                    }else{
                        if($r->otpCode == $user->verify_code){
                            return response()->json([
                                'success' => true,
                                'message' => 'You are verrifyed'
                            ], 200);
                        }else{
                            return response()->json([
                                'success' => false,
                                'message' => 'Your 6 digit code not matching'
                            ], 200);
                        }
                    }

                }else{

                    if(filter_var($r->email_phone, FILTER_VALIDATE_EMAIL)) {
                        $user = User::where('email', $r->email_phone)->where('status',2)->first();
                        if(!$user){
                            $password= Str::random(8);
                            $user =new User();
                            $user->email=$r->email_phone;
                            $user->password=Hash::make($password);
                            $user->password_show=$password;
                            $user->country=1;
                            $user->status=2;
                            $user->save();
                        }
                        
                        $code=rand(111111,999999);
                        $user->verify_code=$code;
                        $user->save();

                        //Send Mail 
                        if(general()->mail_status && $user->email){
                            $toEmail =$user->email;
                            $toName =$user->name;
                            $subject ='Register Verify Mail Form '.general()->title;
                            $datas =array('verifycode'=>$user->verify_code);
                            $template ='mails.registerVerify';
                            sendMail($toEmail,$toName,$subject,$datas,$template);
                        }


                        return response()->json([
                            'success' => true,
                            'message' => 'We are send 6 digit code your email address.'
                        ], 200);

                    }else{

                        $user = User::where('mobile', $r->email_phone)->where('status',2)->first();
                        if(!$user){
                            $password= Str::random(8);
                            $user =new User();
                            $user->mobile=$r->email_phone;
                            $user->password=Hash::make($password);
                            $user->password_show=$password;
                            $user->country=1;
                            $user->status=2;
                            $user->save();
                        }
                        $code=rand(111111,999999);
                        $user->verify_code=$code;
                        $user->save();

                        //Send SMS 
                        if(general()->sms_status && $user->mobile){
                            $msg ='Your '.general()->title.' register verify OTP is '.$user->verify_code;
                            sendSMS($user->mobile,$msg);
                        }

                        return response()->json([
                            'success' => true,
                            'message' => 'We are send 6 digit code your phone number.'
                        ], 200);

                    }
                }

            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Eamil or Mobile number must be required'
                ], 200);
            }

        }






        if ($r->isMethod('post'))
        {

            $check = $r->validate([
                'name' => 'required|max:100',
                'email' => 'required|max:100|unique:users,email',
                'password' => 'required|min:5'
            ]);

            if(!$check){
                return back();
            }
            
            //User Create
            $user =new User();
            $user->name=$r->name;
            $user->email=$r->email;
            $user->password=Hash::make($r->password);
            $user->password_show=$r->password;
            $user->country=1;
            $user->save();

            Auth::login($user);
            
            //Mail Send/SMS Send
            
            //**********Send Mail***************//

            if(general()->mail_status && $user->email){
                //Mail Data
                $datas =array('user'=>$user);
                $template ='mails.registrationMail';
                $toEmail =$user->email;
                $toName =$user->name;
                $subject ='Registration Successfully Completed in '.general()->title;
            
                sendMail($toEmail,$toName,$subject,$datas,$template);
            }
            //**********Send Mail***************//
            

            if(Auth::check()){
                return Redirect()->route('customer.dashboard');
            }else{
                Session::flash('success','Your Registration Successfully Done!');
                return Redirect()->route('login');
            }

        }

        return Inertia::render('Auth/Register');

    }


    public function forgotPassword(Request $r){
        
        if ($r->isMethod('post'))
        {

            if($r->has('email_phone')){

                if(filter_var($r->email_phone, FILTER_VALIDATE_EMAIL)) {
                    $user = User::where('email', $r->email_phone)->where('status','<>',2)->first();
                    if(!$user){
                        return response()->json([
                            'success' => false,
                            'message' => 'Your email address are not  register. Try registration'
                        ], 200);
                    }
                }elseif(is_numeric($r->email_phone)){
                    if(strlen($r->email_phone)!=11){
                        return response()->json([
                            'success' => false,
                            'message' => 'Mobile Number mustbe 11 digits'
                        ], 200);
                    }

                    $user = User::where('mobile', $r->email_phone)->where('status','<>',2)->first();

                    if(!$user){
                        return response()->json([
                            'success' => false,
                            'message' => 'Your Mobile number are not  register. Try registration'
                        ], 200);
                    }
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Your input are invalied'
                    ], 200);
                }
                
                if($r->has('otpCode')){
                    if($r->has('password') && $r->has('confirm_password')){
                        
                        if($r->confirm_password && $r->password){
                            $password= $r->password;
                            $user->verify_code=null;
                            $user->remember_token=null;
                            $user->password=Hash::make($password);
                            $user->password_show=$password;
                            $user->status=1;
                            $user->save();

                            Auth::login($user, true);

                            return response()->json([
                                'success' => true,
                                'message' => 'Successfully'
                            ], 200);

                        }else{
                            return response()->json([
                                'success' => false,
                                'message' => 'Somthing is worng. try again register.'
                            ], 200);
                        }

                    }else{
                        if($r->otpCode == $user->verify_code){
                            return response()->json([
                                'success' => true,
                                'message' => 'You are verrifyed'
                            ], 200);
                        }else{
                            return response()->json([
                                'success' => false,
                                'message' => 'Your 6 digit code not matching'
                            ], 200);
                        }
                    }

                }else{

                    if(filter_var($r->email_phone, FILTER_VALIDATE_EMAIL)) {

                        
                        $code=rand(111111,999999);
                        $user->verify_code=$code;
                        $token =strtolower(Str::random(90));
                        $user->remember_token=$token;
                        $user->save();

                        //Send Mail 
                        if(general()->mail_status && $user->email){
                            $toEmail =$user->email;
                            $toName =$user->name;
                            $subject ='Forget Password Mail Form '.general()->title;
                            $datas =array('name'=>$user->name,'verifycode'=>$user->verify_code);
                            $template ='mails.passwordResetVerify';
                            sendMail($toEmail,$toName,$subject,$datas,$template);
                        }
                        return response()->json([
                            'success' => true,
                            'message' => 'We are send 6 digit code your email address.'
                        ], 200);


                    }else{

                        
                        $code=rand(111111,999999);
                        $user->verify_code=$code;
                        $token =strtolower(Str::random(90));
                        $user->remember_token=$token;
                        $user->save();

                        //Send SMS 
                        if(general()->sms_status && $user->mobile){
                            $msg ='Your '.general()->title.' forget password verify OTP is '.$user->verify_code;
                            sendSMS($user->mobile,$msg);
                        }
                        return response()->json([
                            'success' => true,
                            'message' => 'We are send 6 digit code your phone number.'
                        ], 200);

                    }
                }

            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Eamil or Mobile number must be required'
                ], 200);
            }


            $check = $r->validate([
                'email' => 'required|email|max:100',
            ]);
            
            $user =User::where('email',$r->email)->first();
            if($user){
                $token =strtolower(Str::random(90));
                $user->verify_code=str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $user->remember_token=$token;
                $user->auth_activity_at=Carbon::now();
                $user->save();

                return response()->json([
                    'success' => true,
                    'message' => 'We send Reset Link with 6 digit Code Your Email address!'
                ], 200);
    
                //Send Mail 
                if(general()->mail_status && $user->email){
                    $toEmail =$user->email;
                    $toName =$user->name;
                    $subject ='Forget Password Mail Form '.general()->title;
                    $datas =array('user'=>$user);
                    $template ='mails.passwordResetVerify';
                    sendMail($toEmail,$toName,$subject,$datas,$template);
                }
                Session::flash('success','We send Reset Link with 6 digit Code Your Email address!');
                return Redirect()->route('resetPassword',$token);
            }
            Session::flash('error','There is no account associated with the email address you provided');
            return Redirect()->back()->withInput();
        }

        
        
        return Inertia::render('Auth/ForgotPassword');
        
    }

    public function resetPassword(Request $r,$token){
        $user =User::where('remember_token',$token)->first();
        if(!$user){
            Session::flash('error','Your Reset Password Are Expired.');
            return Redirect()->route('forgotPassword');
        }
        if($r->isMethod('post')){
            $check = $r->validate([
                'verify_code' => 'required|numeric|digits:6',
                'password' => 'required|min:5|max:50'
            ]);
            if($user->verify_code ==$r->verify_code){
                
                $user->remember_token=null;
                $user->verify_code=null;
                $user->password=Hash::make($r->password);
                $user->password_show=$r->password;
                $user->save();

                Auth::login($user);
                if(Auth::check()){
                    return Redirect()->route('customer.dashboard');
                }
                Session::flash('success','Your Reset Password Successfully Done!');
                return Redirect()->route('login');
            }

            Session::flash('error','Your Verify Code Are Incorrect!!');
            return Redirect()->back()->withInput();
        }

        return view('auth.confirm-password',compact('user'));

    }

    public function resetPasswordCheck(Request $r){

         $check = $r->validate([
            'token' => 'required',
            'verifycode' => 'required|numeric|digits:6',
            'password' => 'required|min:6',
        ]);


        if(!$check){
            Session::flash('error','Need To validation');
            return back();
        }

        $user =$user =User::where('remember_token',$r->token)->first();

        
        if($user){
           
            if($user->verify_code ==$r->verifycode){
                
                $user->remember_token=null;
                $user->verify_code=null;
                $user->password=Hash::make($r->password);
                $user->password_show=$r->password;
                $user->save();

                Auth::loginUsingId($user->id);
                if(Auth::check()){
                    return Redirect()->route('customer.dashboard');
                }else{
                    Session::flash('success','Your Reset Password Successfully Done!');
                    return Redirect()->route('login');
                }

            }else{
                Session::flash('error','Your Verify Code Are Incorrect!!');
                return Redirect()->back();
            }

        }else{
        Session::flash('error','Your reset link are exprired');
        return Redirect()->route('forgotPassword');
        }
    }

    public function logout(){
    	Auth::logout();
        session()->flush();
    	return Redirect()->route('index');
    }




      
       //Social login/Registration Function
       
      public function redirectToProvider($provider)
       {
                if($provider === 'facebook') {
                    $appId = general()->fb_app_id;
                    $redirectUri = general()->fb_app_redirect_url;
                    $state = bin2hex(random_bytes(16));
                    Session::put('facebook_state', $state);
                    $loginUrl = "https://www.facebook.com/v12.0/dialog/oauth?client_id={$appId}&redirect_uri={$redirectUri}&response_type=code&state={$state}";
                    return redirect()->away($loginUrl);
                }
           
           return Socialite::driver($provider)->redirect();
       }
       
       
       
       public function handleProviderCallback($provider, Request $request)
       {
           
            if($provider === 'facebook') {
                if ($request->has('error')) {
                    return redirect()->route('login')->with('error', 'Facebook login failed.');
                }
                
                if (!$request->has('code') || !$request->has('state') || $request->state !== Session::get('facebook_state')) {
                    return redirect()->route('login')->with('error', 'Invalid Facebook login state.');
                }
                
                $code = $request->code;
                $appId = general()->fb_app_id;
                $appSecret = general()->fb_app_secret;
                $redirectUri = general()->fb_app_redirect_url;
                
                // Request access token
                $response = Http::get("https://graph.facebook.com/v12.0/oauth/access_token", [
                    'client_id' => $appId,
                    'client_secret' => $appSecret,
                    'redirect_uri' => $redirectUri,
                    'code' => $code
                ]);
                
                $data = $response->json();
                
                if (!isset($data['access_token'])) {
                    return redirect()->route('login')->with('error', 'Failed to retrieve access token.');
                }
                
                $accessToken = $data['access_token'];
                
                // Get user details
                $userInfoResponse = Http::get("https://graph.facebook.com/me", [
                    'access_token' => $accessToken,
                    'fields' => 'id,name,email'
                ]);
                
                $getUser = $userInfoResponse->json();

                if (!isset($getUser['id']) && !isset($getUser['email'])) {
                    return redirect()->route('login')->with('error', 'Failed to retrieve user information.');
                }
                
                $account = SocialIdentity::whereProviderName($provider)
                      ->whereProviderId($getUser['id'])
                      ->first();
                   if ($account) {
                       $user = $account->user;
                   } else {
                    
                        $user = User::whereEmail($getUser['email'])->where('email', '<>', null)->first();
                        if (!$user) {
                           
                           $rand =rand(100000,999999);
                           $user = User::create([
                               'email' => $getUser['email'],
                               'name'  => isset($getUser['name'])?$getUser['name']:'unknwon',
                               'email_verified_at' => Carbon::now(),
                               'password'=> Hash::make($rand),
                               'password_show'=> $rand,
                           ]);
                  
                       }
                       
                       $user->identities()->create([
                           'provider_id'   => $getUser['id'],
                           'provider_name' => $provider,
                           'provider_token'=> $accessToken,
                       ]);
                   }
                
                $request->session()->regenerate();
               Auth::login($user, true);
               return Redirect()->route('customer.dashboard');
            }
           
           try {
    
               $user = Socialite::driver($provider)->stateless()->user();
    
           } catch (Exception $e) {
               return redirect('/login');
           }
    
           $authUser = $this->findOrCreateUser($user, $provider);
           
           $request->session()->regenerate();
           Auth::login($authUser, true);
           return Redirect()->route('customer.dashboard');

       }
       
       
        public function findOrCreateUser($providerUser, $provider)
       {
           
           $account = SocialIdentity::whereProviderName($provider)
                      ->whereProviderId($providerUser->getId())
                      ->first();
    
           if ($account) {
               return $account->user;
           } else {
               $user = User::whereEmail($providerUser->getEmail())->where('email', '<>', null)->first();
    
               if (! $user) {
                   
                   $rand =rand(100000,999999);
                   
                   $user = User::create([
                       'email' => $providerUser->getEmail(),
                       'name'  => $providerUser->getName(),
                       'email_verified_at' => Carbon::now(),
                       'password'=> Hash::make($rand),
                       'password_show'=> $rand,
                   ]);
                    $user->save();
          
               }
               
               $user->identities()->create([
                   'provider_id'   => $providerUser->getId(),
                   'provider_name' => $provider,
                   'provider_token'=> $providerUser->token,
                   'provider_img_url'=> $providerUser->getAvatar(),
               ]);
    
               return $user;
           }
       }





}
