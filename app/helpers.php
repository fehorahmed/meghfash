<?php

use App\Models\General;
use App\Models\Media;
use App\Models\Country;
use App\Models\Cart;
use App\Models\WishList;
use App\Models\Post;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\CashHistory;
use App\Models\PostExtra;
use App\Models\Attribute;
use Carbon\Carbon;
use Http;

function general(){
  $general =General::first();
  $general->logo_url = asset($general->logo());
  $general->banner_url = asset($general->banner());
  $general->web_title = $general->websiteTitle();
  return $general;
}

function websiteTitle($title=null){
  
  $hasTitle =$title?' - ':'';
  $text =general()->title;
  $text1=general()->subtitle;
  $text2=$text&&$text1?' - ':'';
  return $title.$hasTitle.$text.$text2.$text1;
}

function isMobileDevice() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    return preg_match(
        "/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i",
        $userAgent
    );
}


function adminTheme(){
  $theme=general()->adminTheme.'.';
  if(isMobileDevice()){
    $theme=general()->adminTheme.'.';
  }
  return $theme;
}

function welcomeTheme(){
  $theme=general()->theme.'.';
  if(isMobileDevice()){
    $theme=general()->theme.'.';
  }
  return $theme;
}

function deviceMode(){
  $theme='desktop';
  if(isMobileDevice()){
    $theme='mobile';
  }
  return $theme;
}

function assetLink(){
  return general()->theme;
}

function assetLinkAdmin(){
  return general()->adminTheme;
}

function geoData($type=null,$parent=null,$id=null){

  $data =Country::orderBy('name')->select(['id','type','parent_id','name']);
  if($type){
    $data =$data->where('type',$type);
  }

  if($parent){
    $data =$data->where('parent_id',$parent);
  }

  if($id){
    $data =$data->find($id);
  }else{
    $data =$data->get();
  }
  
  return $data;
}

function reoportSummery($from,$to,$type,$id=null){
    
    $allPer = empty(json_decode(Auth::user()->permission->permission, true)['posUrders']['all']);
    
    if($type=='card'){
        $amount =Transaction::whereHas('order',function($q)use($from,$to,$allPer){
            $q->where('order_type', 'pos_order')
            ->where('order_status','delivered');
            // ->where('payment_status','paid')
            if($allPer){
             $q->where('addedby_id',auth::id()); 
            }
            
            if (general()->masterAdmins() && !in_array(Auth::id(),general()->masterAdmins())) {
                $q->where(function($query) {
                    $query->where('addedby_id', '<>', 671)
                          ->orWhereDate('created_at', '=', now()->toDateString());
                });
            }
            $q->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to);
        })->where('payment_method', 'Card Method')->where('payment_method_id',$id)->sum('received_amount');
        
        return $amount;
    }elseif($type=='posmachine'){
        $amount =Transaction::whereHas('order',function($q)use($from,$to,$allPer){
            $q->where('order_type', 'pos_order')
            ->where('order_status','delivered');
            // ->where('payment_status','paid')
            if($allPer){
             $q->where('addedby_id',auth::id()); 
            }
            
            if (general()->masterAdmins() && !in_array(Auth::id(),general()->masterAdmins())) {
                $q->where(function($query) {
                    $query->where('addedby_id', '<>', 671)
                          ->orWhereDate('created_at', '=', now()->toDateString());
                });
            }
            $q->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to);
        })->where('payment_method', 'Card Method')->where('method_id',$id)->sum('received_amount');
        
        return $amount;
    }elseif($type=='mobile'){
        $amount =Transaction::whereHas('order',function($q)use($from,$to,$allPer){
            $q->where('order_type', 'pos_order')
            ->where('order_status','delivered');
            // ->where('payment_status','paid')
            if($allPer){
             $q->where('addedby_id',auth::id()); 
            }
            
            if (general()->masterAdmins() && !in_array(Auth::id(),general()->masterAdmins())) {
                $q->where(function($query) {
                    $query->where('addedby_id', '<>', 671)
                          ->orWhereDate('created_at', '=', now()->toDateString());
                });
            }
            $q->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to);
        })->where('payment_method', 'Mobile Method')->where('payment_method_id',$id)->sum('received_amount');
        
        return $amount;
    }
    
    return 0;
}

function salesMonthlyReport($month){
    
    
    // $orders =Order::whereIn('order_type',['customer_order','pos_order'])->where('order_status','<>','temp')->whereMonth('created_at',$month->format('m'))->whereYear('created_at',$month->format('Y'))->select(['id','grand_total','order_type'])->get();
    // $customers =User::where('status',1)->where('order_status','<>','temp')->whereMonth('created_at',$month->format('m'))->whereYear('created_at',$month->format('Y')) ->count();
    
    // $report =array(
    //         'total'=>$orders->sum('grand_total'),
    //         'posTotal'=>$orders->where('order_type','pos_order')->sum('grand_total'),
    //         'onlineTotal'=>$orders->where('order_type','customer_order')->sum('grand_total'),,
    //         'customerTotal'=>$customers,
    //     );
        
    return 'd'; //$report;
}

function dailyCashMacting($date){
    
    $today = Carbon::today();
    
    for ($startDate = $date->copy()->startOfDay(); $startDate->lte($today); $startDate->addDay()) {
        
        $todaySale=Order::latest()->where('order_type','customer_order')
        ->whereNotIn('order_status',['temp','pending','cancelled'])
        ->whereDate('created_at', $startDate)
        ->sum('grand_total');
       
        $todaySaleShipping=Order::latest()->where('order_type','customer_order')
        ->whereNotIn('order_status',['temp','pending','cancelled'])
        ->whereDate('created_at', $startDate)
        ->sum('shipping_charge');
        
        $todayWholesale=Order::latest()->where('order_type','wholesale_order')
        ->whereNotIn('order_status',['temp','pending','cancelled'])
        
        ->whereDate('created_at', $startDate)
        ->sum('grand_total');
        
        $todayReturnSale=Order::latest()->where('order_type','order_return')
        ->whereNotIn('order_status',['temp','pending','cancelled'])
        ->whereDate('created_at', $startDate)
        ->sum('grand_total');
        
        $posSale = Order::where('order_type','pos_order')->where('order_status','delivered')->whereDate('created_at', $startDate)->sum('grand_total');
        
        
        $preCash =0;
        $formDate =Carbon::parse('2025-07-19')->startOfDay();
        $hasDatePriviusData =CashHistory::latest()->whereDate('created_at','<',$startDate)->first();
        $priviusDate =$hasDatePriviusData?$hasDatePriviusData->created_at:$startDate->copy()->subDay();
        if($startDate->gt($formDate)){
            $cashData =CashHistory::whereDate('created_at', $priviusDate)->first();
            if($cashData){
                $preCash =$cashData->available_cash;
            }
        }
        //Privius Cash End            
        
        $cashSum =Transaction::whereHas('order',function($q){
                $q->where('order_type','customer_order');
            })
            ->whereDate('created_at', $startDate)
            ->where('method_id',87)->sum('amount');
        
        $cashSum +=Transaction::whereHas('order',function($q){
                $q->where('order_type','wholesale_order');
            })
            ->whereDate('created_at', $startDate)
            ->where('method_id',87)->sum('amount');
            
        $cashSum +=Transaction::whereHas('order',function($q){
                $q->where('order_type','pos_order')->where('order_status','delivered');
            })
            ->whereDate('created_at', $startDate)
            ->where('payment_method_id',87)
            ->sum('amount');
        
        $withdrawal =Transaction::where('type',6)->whereDate('created_at', $startDate)->sum('amount');
        $expenses =Transaction::where('type',4)
                                ->whereDate('created_at', $startDate)
                                ->whereHas('expense',function($q){
                                    $q->where('warehouse_id','1020');
                                })
                                ->sum('amount');
        
        $cash =$cashSum;
        $available=($preCash+$cash) - ($expenses+$withdrawal);
        
        if($startDate->gte($formDate) && $startDate->lte(Carbon::now())){
            $cashData =CashHistory::whereDate('created_at', $startDate)->first();
            if(!$cashData){
                $cashData =new CashHistory();
                $cashData->created_at =Carbon::parse($startDate)->setTimeFrom(Carbon::now());
            }
            $cashData->previus_date=Carbon::parse($priviusDate)->setTimeFrom(Carbon::now());
            $cashData->previus_cash=$preCash;
            $cashData->available_cash=$available;
            $cashData->today_cash=$cash;
            $cashData->online_sale=$todaySale - $todaySaleShipping;
            $cashData->online_shipping_charge=$todaySaleShipping;
            $cashData->wholse_sale=$todayWholesale;
            $cashData->pos_sale=$posSale;
            $cashData->expense=$expenses;
            $cashData->withdrawal_amount=$withdrawal;
            $cashData->return_amount=$todayReturnSale;
            $cashData->save();
        }
    
    }
    return true;
}


function bn2enNumber ($number){
  $search_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
  $replace_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
  $en_number = str_replace($search_array, $replace_array, $number);

  return $en_number;
}

function en2bnNumber ($number){
  $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
  $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
  $en_number = str_replace($search_array, $replace_array, $number);

  return $en_number;
}

function en2bnMonth($month){
  $search_array= array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October","November","December","Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct","Nov","Dec","01", "02", "03", "04", "05", "06", "07", "08", "09", "10","11","12");
  $replace_array= array("জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগষ্ট", "সেপ্টেম্বর", "অক্টোবর","নভেম্বর","ডিসেম্বর","জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগষ্ট", "সেপ্টেম্বর", "অক্টোবর","নভেম্বর","ডিসেম্বর","জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগষ্ট", "সেপ্টেম্বর", "অক্টোবর","নভেম্বর","ডিসেম্বর");
  $en_number = str_replace($search_array, $replace_array, $month);
  return $en_number;
}

function priceFormat($amount=0)
{
  $formatAmount ='';
  $formatAmount = number_format($amount,general()->currency_decimal);
  return $formatAmount;
}

function priceFullFormat($amount=0)
{
  $formatAmount ='';
  $amountFormat = number_format($amount,general()->currency_decimal);
  if(general()->currency_position==0){
    $formatAmount = general()->currency.' '.$amountFormat;
  }else{
     $formatAmount = $amountFormat.' '.general()->currency;
  }
  return $formatAmount;
}

function sendMail($toEmail,$toName,$subject,$datas,$template,$attachments=null){
    
  try {
    Mail::send($template,compact('datas'), function ($message) use ($toEmail,$toName,$subject,$attachments) {
        $message->from(general()->mail_from_address, general()->mail_from_name);
        $message->to($toEmail,$toName)
        ->subject($subject);
        
        if($attachments){
            // Attachments
            foreach ($attachments as $attachment) {
                $message->attach($attachment['path'], [
                    'as' => $attachment['name'],
                    'mime' => $attachment['mime'],
                ]);
            }
        }
    });
      return true;
  } catch (Exception $ex) {
      // Debug via $ex->getMessage();
      return false;
  }

}

function sendSMS($to,$msg){
    $userId = general()->sms_username;
    $api_key = general()->sms_password;
    $senderid = general()->sms_senderid;
    $url =general()->sms_url_nonmasking;
    $data = [
        "api_key" => $api_key,
        "senderid" => $senderid,
        "number" => $to,
        "message" => $msg
    ];

    try {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      $response = curl_exec($ch);
      curl_close($ch);
      return $response;
    } catch (Exception $ex) {
      // Debug via $ex->getMessage();
      return false;
    }
  
}

function slider($location=null){
  return Attribute::latest()->where('type',1)->where('status','active')->where('location',$location)->first();
}

function gallery($location=null){
  return Attribute::latest()->where('type',4)->where('status','active')->where('location',$location)->first();
}

function categories(){
  $categories =Attribute::latest()->where('type',0)->where('status','active')->where('parent_id',null)->get(['id', 'name','slug',]);
  collect($categories)->map(function($item){
      $item->image_url = asset($item->image());
  unset($item->imageFile);
  return $item;
  });
  return  $categories;
}

function menu($location=null){
  return Attribute::latest()->where('type',8)->where('status','active')->where('location',$location)->first();
}

function page($id=null){
  return Post::where('type',0)->find($id);
}

function pageTemplate($template=null){
  return Post::where('type',0)->where('template',$template)->first();
}

function offerNotes(){
    return PostExtra::latest()->where('type',5)->where('status','active')->get(['id','content']);
}

function newArrivalProducts(){
    return Post::latest()->where('type',2)->where('status','active');
}


function uploadFile($file,$src,$srcType,$fileUse,$author=null,$fileStatus=true){


  if($fileStatus){
      $media = Media::where('src_type',$srcType)->where('use_Of_file',$fileUse)->where('src_id',$src)->first();
  }else{
      $media = null;
  }

  if(!$media){
    $media =new Media();
    }else{
      if(File::exists($media->file_url)){
            File::delete($media->file_url);
        }
        if(File::exists($media->file_url_sm)){
            File::delete($media->file_url_sm);
        }
        if(File::exists($media->file_url_md)){
            File::delete($media->file_url_md);
        }
        if(File::exists($media->file_url_lg)){
            File::delete($media->file_url_lg);
        }
    }
    
    $name = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());
    $fullname = basename($file->getClientOriginalName());
    $ext =$file->getClientOriginalExtension();
    $size =$file->getSize();
    $mimeType = $file->getMimeType();

    $year =carbon::now()->format('Y');
    $month =carbon::now()->format('M');
    $folder = $month.'-'.$year;

    $img =time().'.'.uniqid().'.'.$file->getClientOriginalExtension();
    $path ="medies/".$folder;
    $fullpath ="medies/".$folder.'/'.$img;
    $media->src_type=$srcType;
    $media->use_Of_file=$fileUse;
    $media->src_id=$src;
    $media->file_name=Str::limit($fullname,250);
    $media->alt_text=Str::limit($name,250);
    $media->file_rename=Str::limit($img,100);
    $media->file_size=$size;
    $media->mine_type=$mimeType;
    if($ext=='png' || $ext=='jpeg' || $ext=='svg' || $ext=='gif' || $ext=='jpg' || $ext=='webp'){
      $media->file_type=1;
      }elseif($ext=='pdf'){
      $media->file_type=2;
      }elseif($ext=='docx'){
      $media->file_type=3;
      }elseif($ext=='zip' || $ext=='rar'){
      $media->file_type=4;
      }elseif($ext=='mp4' || $ext=='webm' || $ext=='mov' || $ext=='wmv'){
      $media->file_type=5;
      }elseif($ext=='mp3'){
      $media->file_type=6;
    }
    $file->move(public_path($path), $img);
    $media->file_url =$fullpath;
    $media->file_path =$path;
    $media->addedby_id=$author;
    $media->save();

    return $media;

}


function myCouponCheck($totalAmount,$uniqCartPrice){
    
  $total =$totalAmount;
  $message =null;
  $discount =0;
  $status=true;
  $coupon=null;
  
  $cId =Session::get('my_coupon_id');
  
  $coupon =Attribute::latest()->where('type',13)->where('status','active')->where('parent_id',null)
          ->where('id',$cId)
          ->first();

  if(!$coupon){
      $message='Coupon Are Not Found';
      $status =false;
  }else{

      if($status==true && $coupon->min_shopping && $coupon->min_shopping > $total){
          $message ='Sorry,Your coupon Are Invalid. Please, minimum Shopping '.priceFullFormat($coupon->min_shopping);
          $status =false;
      }

      if($status==true && $coupon->max_shopping && $coupon->max_shopping < $total){
          $message ='Sorry, Your coupon Are Invalid. Because, maximum Shopping '.priceFullFormat($coupon->max_shopping);
          $status =false;
      }

      if($status==true && $coupon->menu_type==1 && $coupon->amounts > $total){
          $message = 'Sorry, Your coupon Are Invalid. Because, Discount Big Amount ('.priceFullFormat($coupon->amounts).') Over Shopping Amount';
          $status =false;
      }

      if($status==true && $coupon->menu_type==0 && $coupon->amounts > 100){
          $status =false;
          $message ='Sorry, your coupon Are Invalid. Because, Discount Can Not Over 100%';

      }
      
      if($status==true){
            

      }
      
  }
  
  return compact('discount','message','coupon','status');

}


if (!function_exists('sendEvent')) {
    
function sendEvent($event_name, $event_id, $custom_data = [], $extra_user_data = [],$test_event_code = 'TEST64478'){
        $pixel  = general()->fb_pixel_id ?? null;
        $access = general()->fb_access_token ?? null;
        if (!$pixel || !$access) return;
    
        $endpoint = "https://graph.facebook.com/v18.0/{$pixel}/events";
        
        $fbc = $_COOKIE['_fbc'] ?? null;
        $fbp = $_COOKIE['_fbp'] ?? null;
        $exUserID = $_COOKIE['external_id'] ?? null;

        // Default web user data
        $user_data = [
            'client_ip_address' => request()->ip(),
            'client_user_agent' => request()->header('User-Agent'),
            'country' => hash('sha256', strtoupper('BD')),
        ];
        
        if($fbc) {
            $user_data['fbc'] = $fbc;
        }
        if($fbp){
            $user_data['fbp'] = $fbp;
        }
        
        if (Auth::check()) {
            $user = Auth::user();

            $user_data += [
                'em'  => hash('sha256', strtolower(trim($user->email ?? ''))),
                'ph'  => hash('sha256', preg_replace('/[^0-9]/', '', $user->phone ?? '')),
                'fn'  => hash('sha256', strtolower(trim($user->first_name ?? ''))),
                'ln'  => hash('sha256', strtolower(trim($user->last_name ?? ''))),
                'external_id' => hash('sha256', $user->id),
            ];
        }else if($exUserID){
            $user_data['external_id'] = $exUserID;
        }
        // Merge extra (hashed) data if provided
        if (!empty($extra_user_data)) {
            $user_data = array_merge($user_data, $extra_user_data);
        }
    
        $payload = [
            'data' => [
                [
                    'event_name'        => $event_name,
                    'event_time'        => time(),
                    'event_id'          => $event_id,
                    'action_source'     => 'website',
                    'event_source_url'  => request()->fullUrl(),
                    'user_data'         => $user_data,
                    'custom_data'       => $custom_data,
                ]
            ],
            'access_token' => $access,
        ];
    
        if ($test_event_code) {
            $payload['test_event_code'] = $test_event_code;
        }
        try {
            $response = Http::post($endpoint, $payload);
            // return $response;
            // \Log::info('Payload',$payload);
            // \Log::info($response);
        } catch (\Exception $e) {
            \Log::error('FB Event Send Error: ' . $e->getMessage());
        }
    }
    
}

if (!function_exists('facebookPixelData')) {
    function facebookPixelData($eventName = 'PageView', $eventId, $customData = [],$extra_user_data=[])
    {
        
        $exUserID = $_COOKIE['external_id'] ?? null;
        $user_data = [
            'client_ip_address' => Request::ip(),
            'client_user_agent' => Request::userAgent(),
            'country' => hash('sha256', strtoupper('BD')),
        ];

        // Authenticated user or guest
        if (Auth::check()) {
            $user = Auth::user();
            $user_data += [
                'em'  => hash('sha256', strtolower(trim($user->email ?? ''))),
                'ph'  => hash('sha256', preg_replace('/[^0-9]/', '', $user->phone ?? '')),
                'fn'  => hash('sha256', strtolower(trim($user->first_name ?? ''))),
                'ln'  => hash('sha256', strtolower(trim($user->last_name ?? ''))),
                'external_id' => hash('sha256', $user->id),
            ];
        } else if ($exUserID) {
            $user_data +=['external_id' => $exUserID];
        }
        
        
        if (!empty($extra_user_data)) {
            $user_data = array_merge($user_data, $extra_user_data);
        }
        

        $data = [
            'event_name' => $eventName,
            'event_time' => time(),
            'event_id' => $eventId,
            'action_source' => 'website',
            'event_source_url' => request()->fullUrl(),
            'user_data' => $user_data,
            'custom_data' => $customData,
        ];
        // \Log::info('Payload',$data);
        return $data;
    }
}

// function sendEvent($event_name, $event_id, $data = []){
//     $pixel =general()->fb_pixel_id;
//     $access =general()->fb_access_token;
//     if($pixel && $access){
        
//         $endpoint = "https://graph.facebook.com/v18.0/{$pixel}/events";
//         $payload = [
//             'data' => [
//                 [
//                     'event_name' => $event_name,
//                     'event_time' => time(),
//                     'event_id' => $event_id,
//                     'action_source' => 'website',
//                     'user_data' => [
//                         'client_ip_address' => request()->ip(),
//                         'client_user_agent' => request()->header('User-Agent'),
//                     ],
//                     'custom_data' => $data
//                 ]
//             ],
//             'access_token' => $access,
//         ];
//       $response = Http::post($endpoint, $payload);
//     //   return $response;
//     }
// }

function menuItem($location){
  $menu =null;
    if($location){

        $hasMenu =menu($location);

        if($hasMenu){
            
            $menuItems = array();

            foreach ($hasMenu->subMenus as $menu) {
                $subMenuItems = array();

                foreach ($menu->subMenus as $subMenu) {
                    $subSubMenuItems = array();

                    foreach ($subMenu->subMenus as $subSubMenu) {
                      $subSubSubMenuItems =array();
                      foreach ($subSubMenu->subMenus as $subSubSubMenu) {
                        
                        $subSubSubMenuItems[] = array(
                            'title' => $subSubSubMenu->menuName(),
                            'icon'  => '',
                            'src_id'  => $subSubSubMenu->src_id,
                            'slug'  => $subSubSubMenu->menuSlug(),
                            'type'  => $subSubSubMenu->menu_type,
                            'items'=>'',
                            'id' => $subSubSubMenu->id,
                        );
                      }

                      $subSubMenuItems[] = array(
                          'title' => $subSubMenu->menuName(),
                          'icon'  => '',
                          'src_id'  => $subSubMenu->src_id,
                          'slug'  => $subSubMenu->menuSlug(),
                          'type'  => $subSubMenu->menu_type,
                          'items'=>$subSubSubMenuItems,
                          'id' => $subSubMenu->id,
                      );
                    }

                    $subMenuItems[] = array(
                        'title' => $subMenu->menuName(),
                        'icon'  => '',
                        'src_id'  => $subMenu->src_id,
                        'slug'  => $subMenu->menuSlug(),
                        'type'  => $subMenu->menu_type,
                        'items' => $subSubMenuItems,
                        'id' => $subMenu->id,
                    );
                }

                $menuItems[] = array(
                    'title' => $menu->menuName(),
                    'icon'  => '',
                    'src_id'  => $menu->src_id,
                    'slug'  => $menu->menuSlug(),
                    'type'  => $menu->menu_type,
                    'items' => $subMenuItems,
                    'id' => $menu->id,
                );
            }

            $menu = array(
                'title' => $hasMenu->name,
                'items' => $menuItems,
            );
        }
    }
    return $menu;
}


function myCart($cookie=null){

  $carts = array();
  $cartItems = array();
  $cartsProductIds = array();
  $wlProducts = array();
  $cartsCtgIds = array();
  $shippingZones=array();
  $wlCount = 0;
  $cpCount = 0;
  $cartsCount = 0;
  $shippingCharge = 0;
  $cartTax = 0;
  $couponDisc = 0;
  $grandTotal = 0;
  $cartTotalPrice = 0;
  $shippingActive = null;
  $myCoupon=null;
  $myCouponMessage=null;
  $shippingActiveClass=null;
  $shippingNote =null;
  $shippingAddress=null;
  if( $cookie)
  {
    
    $shippingSelect =Session::get('selectZone');
    if($shippingSelect){
      if($shippingSelect==73){
        $shippingCharge =general()->inside_dhaka_shipping_charge;
      }else{
        $shippingCharge =general()->outside_dhaka_shipping_charge;
      }
    }
    
    
    $carts = Cart::where('cookie', $cookie)->latest()->select(['id','user_id','product_id','sku_id','color','size','price','sku_value','cookie','quantity','emi','coupon_id','warranty_charge','warranty_note'])->get();
    $cartsCount=$carts->sum('quantity');
    $uniqCartPrice=0;
    $mci =0;
    if ($mci = Session::get('my_coupon_id')) 
    {
        $myCoupon =Attribute::latest()->where('type',13)->where('status','active')->where('parent_id',null)->where('id',$mci)->first();
    }

    foreach ($carts as $cart) 
        {
            $itemPrice =$cart->itemprice();
            if($cart->product){
                $cartTotalPrice += $itemPrice*$cart->quantity;
            }else{
                $cart->delete();  
            }

            $variant=$cart->itemAttributes();

            $cartItems[]=[
              'id'=>$cart->id,
              'productId'=>$cart->product_id,
              'productName'=>$cart->product?$cart->product->name:null,
              'productImage'=>asset($cart->image()),
              'finalPrice'=>priceFullFormat($itemPrice),
              'final_price'=>$itemPrice,
              'regularPrice'=>0,
              'quantity'=>$cart->quantity,
              'subTotal'=>priceFullFormat($itemPrice*$cart->quantity),
              'variants'=>$variant,
            ];
            unset($cart->product);
        }
    
    $wlCount = WishList::where('cookie',$cookie)->where('type',0)->count();

    $wlProducts = Post::whereHas('wishlists',function($qq)use($cookie){
      $qq->where('cookie',$cookie);
    })
      ->select(['id','name','slug','final_price','regular_price','variation_status','brand_id'])
      ->whereDate('created_at','<=',date('Y-m-d'))->get();

    collect($wlProducts)->map(function($item){
      $item->finalPrice = priceFullFormat($item->final_price);
      if($item->final_price < $item->regular_price){
        $item->regularPrice =  priceFullFormat($item->regularPrice());
      }else{
        $item->regularPrice = null;
      }
      
      $item->image_url = asset($item->image());
      if($item->galleryFiles->count() > 0){
        $item->hoverImage_url = asset($item->galleryFiles->first()->image());
      }else{
        $item->hoverImage_url = asset($item->image());
      }
      unset($item->imageFile);
      unset($item->galleryFiles);
      return $item;
    });
            
    $cpCount = WishList::where('cookie',$cookie)->where('type',2)->count();
    
    // Coupon Apply
    $couponData = myCouponCheck($cartTotalPrice,$uniqCartPrice);
    
    if ($couponData){
        
        if($couponData['status']){
            if($myCoupon){
                if($myCoupon->location=='product'){
                    $couponCarProducts =$carts->whereIn('product_id',$myCoupon->couponProductPosts()->pluck('reff_id'));
                    foreach($couponCarProducts as $ctp){
                        $couponDisc += $myCoupon->couponDiscountAmount($ctp->subtotal());
                    }
                }elseif($myCoupon->location=='category'){
                    $hasCouponProducts = Post::whereIn('id',$carts->pluck('product_id'))->whereHas('ctgProducts',function($q)use($myCoupon){
                                $q->whereIn('reff_id',$myCoupon->couponCtgs()->pluck('reff_id'));
                              })->pluck('id');
                
                    $couponCarProducts =$carts->whereIn('product_id',$hasCouponProducts);
                    foreach($couponCarProducts as $ctp){
                        $couponDisc += $myCoupon->couponDiscountAmount($ctp->subtotal());
                    }
                }else{
                    $couponDisc = $myCoupon->couponDiscountAmount($cartTotalPrice);
                }
              
            }
            $myCouponMessage=$couponData['message'];
        }
    }
            
    //Tax Charge
    $cartTax =0;
    
    if(general()->tax_status==2){
      $cartTax =  ($cartTotalPrice*general()->tax)/100;
    }
    
    if($cartTotalPrice >= 1000){
        $shippingCharge =0;
    }
    
    $grandTotal = $cartTotalPrice + $shippingCharge + $cartTax - $couponDisc;
    
  }

  $cartTotalPriceFormat=priceFullFormat($cartTotalPrice);
  $grandTotalFormat=priceFullFormat($grandTotal);
  $couponDiscFormat=priceFullFormat($couponDisc);
  $shippingChargeFormat=priceFullFormat($shippingCharge);

  return compact('carts','cartItems','cartTotalPrice','cartTotalPriceFormat','wlCount','wlProducts','cpCount','cartsCount','shippingZones','shippingActiveClass','shippingActive','shippingNote','shippingAddress','shippingChargeFormat','shippingCharge','cartTax','couponDiscFormat','couponDisc','myCoupon','myCouponMessage','grandTotal','grandTotalFormat');

}
