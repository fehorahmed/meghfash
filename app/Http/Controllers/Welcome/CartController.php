<?php

namespace App\Http\Controllers\Welcome;

use Mail;
use Auth;
use Cookie;
use Hash;
use Validator;
use Session;
use Http;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Cart;
use App\Models\General;
use App\Models\Country;
use App\Models\Order;
use App\Models\User;
use App\Models\Post;
use App\Models\PostExtra;
use App\Models\Transaction;
use App\Models\WishList;
use App\Models\Attribute;
use App\Jobs\LongProcessJob;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

use App\Library\SslCommerz\SslCommerzNotification;

class CartController extends Controller
{
    
    public function __construct(){
        $this->middleware('cart');
    }
    
    public function addToCart(Request $r,$id=null)
    {
    	
    	
    	
    	$product = Post::where('type',2)->find($id);
        if(!$product){
            $product = Post::where('type',2)->find($r->product_id);
        }
        
        
        
    	$qty = $r->quantity ?: 1;    
		$cookie = $r->cookie('carts');
        if($cookie && $product)
    	{
    	    
    	    
    	    if(Auth::check() &&  (Auth::id()=='663')){
    	    
                //Facebook Concersation API
                $eventId =$r->event_id?:uniqid('AddToCart_');
                
                $pixelData = facebookPixelData('AddToCart',$eventId, [
                    'content_type' => 'product',
                    'content_name' => $product->name,
                    'content_id' => $product->id,
                    'value' => $product->offerPrice(),
                    'currency' => 'BDT'
                ]);
                
                sendEvent('AddToCart', $eventId, [
                    'content_type' => 'product',
                    'content_name' => $product->name,
                    'content_id' => $product->id,
                    'value' => $product->offerPrice(),
                    'currency' => 'BDT'
                ]);
    	    }

      
    	$color = Attribute::where('id', $r->color)->first();
    	$size = Attribute::where('id', $r->size)->first();
    	
    	$ct = $r->color;
    	$st = $r->size;
    	
    	$options=$r->option;

    	// if($product->productAttibutesVariationGroup()->count() > 0 && $options==null){
    	//     if($r->ajax())
	    //     {
        //         return Response()->json([
		//             'success' => false,
		//             'message' => 'Please select product variation item.',
		//           ]);  
		          
	    //     }else{
	            
	    //         return back()->with('error', 'Please select product variation item.');
	    //     }
    	// }
    	
    	// $warranty =$r->warranty;
    	
    	// if($product->warranty_note || $product->warranty_note2){
    	//     if($warranty==null){
    	//         if($r->ajax())
    	//         {
        //             return Response()->json([
    	// 	            'success' => false,
    	// 	            'message' => 'Please select product warranty option.',
    	// 	          ]);  
    		          
    	//         }else{
    	            
    	//             return back()->with('error', 'Please select product warranty option.');
    	//         }
    	//     }   
    	// }
    	
    	
            // 	if($ct and $st)
            // 	{
            // 	    $sku = ProductSku::where('product_id', $product->id)->where('color_id', $ct)->where('size_id', $st)->first();
            // 	}
            // 	elseif($ct and !$st)
            // 	{
            // 	    $sku = ProductSku::where('product_id', $product->id)->where('color_id', $ct)->where('size_id', null)->first();
            // 	}
            // 	elseif(!$ct and $st)
            // 	{
            // 	    $sku = ProductSku::where('product_id', $product->id)->where('color_id', null)->where('size_id', $st)->first();
            // 	}
            // 	else
            // 	{
            // 	}
    	    $sku = null;

    		//$oldCart = Cart::where('cookie', $cookie)->where('product_id', $product->id)->where('color', $ct)->where('size', $st)->first();
			
			$cart = Cart::where('cookie', $cookie)->where('product_id', $product->id);
            if (!empty($options)) {
                $cart = $cart->whereJsonContains('sku_id', $options);
            }
            $cart = $cart->first();
            if(!$cart){
                $cart = new Cart;
                $cart->product_id = $product->id;
                $cart->cookie = $cookie;
                if (!empty($options)) {
                    $cart->sku_id = json_encode($options);
                    if (!empty($cart->itemAttributes())){
                      $cart->sku_value = json_encode($cart->itemAttributes());
                    }
                }
                
                $variant =$cart->itemVariantData();
                if($variant){
                    $cart->variant_id=$variant->id;
                    $cart->barcode=$variant->barcode;
                }
                $cart->save();
            }
    
            $totalQty =$cart->quantity+$qty;
            $cart->addedby_id = Auth::id();
            $cart->user_id = Auth::id();
            
            // if($warranty){
            // $cart->warranty_note = $warranty=='warranty_note2'?$product->warranty_note2:$product->warranty_note;
            // $cart->warranty_charge = $warranty=='warranty_note2'?$product->warranty_charge2:$product->warranty_charge;
            // }
            
            $cart->quantity =$totalQty;  //$totalQty < $product->productMinQty() ? $product->productMinQty() : ($totalQty > $product->productMaxQty()  ? $product->productMaxQty()  : $totalQty);
            $cart->save();

            $myCarts = myCart($cookie);  

            return Response()->json([
                'success' => true,
                'carts' => $myCarts
              ]);

		    // if($r->ajax())
	        // {	

		    //     return Response()->json([
		    //         'success' => true,
		    //         'cartCount' => $cartsCount,
		    //         'cartTotal' => priceFullFormat($cartTotalPrice),
		    //       ]);
	    	// }
        }else{
            
           if($r->ajax())
	        {
            
                return Response()->json([
		            'success' => false,
		          ]);  
		          
	        }else{
	            return redirect()->route('index');
	        }
        }

        if($r->orderNow)
        {
        	return redirect()->route('checkout');
        }
        else
        {
        	return back()->with('success', 'Product successfully added to cart');
        }

        // return back();
    }


    public function changeToCart(Request $r,$id,$type){

        	$cart =Cart::find($id);
	    	$cookie = $r->cookie('carts');
	    	if($cookie && $cart)
	    	{
	    	    $s=true;
	    		if($type == 'increment')
		    	{
		    		$qty = $cart->quantity + 1;
                    // $cart->quantity=$qty;
                    // $cart->save();
		    		$cart->update(['quantity'=> $qty]);

		    		// $maxLimit = $cart->product->max_order_quantity ?: $cart->product->quantity;
		    		// if($qty <= $maxLimit){

		    		// 	$cart->update(['quantity'=> $qty]);
		    		// 	$s = true; 

		    		// }else{
		    		// 	$s = false;
		    		// }



		    	}elseif($type == 'decrement'){
		    		
		    		if($cart->quantity > 1){
		    		    $qty = $cart->quantity - 1;
                        $cart->update(['quantity'=> $qty]);
		    		}
                    
		    		// $minLimit = $cart->product->min_order_quantity ?: 1;

		    		// if($qty >= 1 && $qty >= $minLimit)
		    		// {
		    		// 	$cart->update(['quantity'=> $qty]);
		    		// 	$s = true;
		    		// }else{
		    		// 	$s = false;
		    		// }

		    	}elseif($type == 'quantity'){
		    	    
		    	    $qty =$r->qty?:1;
		    	    $cart->update(['quantity'=> $qty]);
		    	      
		    	 //   $maxLimit = $cart->product->max_order_quantity ?: $cart->product->quantity;
		    	 //   $minLimit = $cart->product->min_order_quantity ?: 1;
		    		// if($qty <= $maxLimit && $qty >= $minLimit && $qty >= 1){

		    		// 	$cart->update(['quantity'=> $qty]);
		    		// 	$s = true; 

		    		// }else{
		    		// 	$s = false;
		    		// }
		    	    
		    	}elseif($type == 'delete'){
		    		$cart->delete();
		    	}

                $myCarts = myCart($cookie);  

                return Response()->json([
                    'success' => true,
                    'carts' => $myCarts
                ]);

		    }else{

		    	return Response()->json([
			            'success' => false,
			          ]);

		    }


    }

    public function couponApply(Request $r){

        $cookie = $r->cookie('carts');
        if($cookie){
            
            $rules = [
                'coupon_code' => 'required|max:100',
            ];
            
            $validator = Validator::make($r->all(), $rules);
        
        
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->messages(),
                ], 200); 
            }

            $coupon = Attribute::where('name', $r->coupon_code)
                ->where('type',13)
                ->where('status','active')
                ->whereDate('start_date', '<=', date('Y-m-d'))
                ->whereDate('end_date', '>=', date('Y-m-d'))
                ->first();

            if(!$coupon){
                $r->session()->forget(['my_coupon_id']);
                $myCarts = myCart($cookie);
                return response()->json([
                    'success' => false,
                    'carts' => $myCarts,
                    'message' => 'Sorry, your coupon is invalid. Please, try again with another coupon code',
                ], 200);
            }

            $cartTotalPrice =0;
            $myCarts = myCart($cookie);
            $cartTotalPrice =$myCarts['cartTotalPrice'];

            if($coupon->min_shopping > 0 && $coupon->max_shopping > 0){
                if($cartTotalPrice >= $coupon->min_shopping && $cartTotalPrice <= $coupon->max_shopping){}else{
                    $r->session()->forget(['my_coupon_id']);
                    $myCarts = myCart($cookie);
                    return response()->json([
                        'success' => false,
                        'carts' => $myCarts,
                        'message' => 'Sorry, you can not use coupon reason shopping Amount limit. Please, Minimum shopping '.priceFullFormat($coupon->min_shopping),
                    ], 200);
                    return back()->with('info', 'Sorry, you can not use coupon reason shopping Amount limit. Please, Minimum shopping '.priceFullFormat($coupon->min_shopping));
                }
            }elseif($coupon->min_shopping > 0){
                if($cartTotalPrice >= $coupon->min_shopping){}else{
                    $r->session()->forget(['my_coupon_id']);
                    $myCarts = myCart($cookie);
                    return response()->json([
                        'success' => false,
                        'carts' => $myCarts,
                        'message' => 'Sorry, you can not use coupon reason shopping Amount limit. Please, Minimum shopping '.priceFullFormat($coupon->min_shopping),
                    ], 200);
                    return back()->with('info', 'Sorry, you can not use coupon reason shopping Amount limit. Please, Minimum shopping '.priceFullFormat($coupon->min_shopping));
                }
            }elseif($coupon->max_shopping > 0){
                if($cartTotalPrice <= $coupon->max_shopping){}else{
                    $r->session()->forget(['my_coupon_id']);
                    $myCarts = myCart($cookie);
                    return response()->json([
                        'success' => false,
                        'carts' => $myCarts,
                        'message' => 'Sorry, you can not use coupon reason shopping Amount limit. Please, Maximum shopping '.priceFullFormat($coupon->max_shopping),
                    ], 200);
                    return back()->with('info', 'Sorry, you can not use coupon reason shopping Amount limit. Please, Maximum shopping '.priceFullFormat($coupon->max_shopping));
                }
            }

            if($coupon->location=='product'){
                $couponCarProducts =$carts->whereIn('product_id',$coupon->couponProductPosts()->pluck('reff_id'));

                

                if($couponCarProducts->count()== 0){
                    $myCarts = myCart($cookie);
                    return response()->json([
                        'success' => false,
                        'carts' => $myCarts,
                        'message' => 'Sorry, your coupon can not apply this product',
                    ], 200);
                }
            }elseif($coupon->location=='category'){
                $hasCouponProducts = Post::whereIn('id',$carts->pluck('product_id'))->whereHas('ctgProducts',function($q)use($coupon){
                            $q->whereIn('reff_id',$coupon->couponCtgs()->pluck('reff_id'));
                        })->pluck('id');
                $couponCarProducts =$carts->whereIn('product_id',$hasCouponProducts);
                if($couponCarProducts->count()== 0){
                    $myCarts = myCart($cookie);
                    return response()->json([
                        'success' => false,
                        'carts' => $myCarts,
                        'message' => 'Sorry, your coupon can not apply this product',
                    ], 200);
                }
            }

            $r->session()->put(['my_coupon_id'=>$coupon->id]);

            $myCarts = myCart($cookie);

            return response()->json([
                'success' => true,
                'carts' => $myCarts,
                'message' => 'Your coupon code is valid and successfully added',
            ], 200);



        }else{
            return response()->json([
                'success' => false,
                'message' => 'Sorry, your cart is empty ',
            ], 200);
        }
        


    }


    public function carts(Request $r){
        Session::forget('selectZone');
        $myCarts = myCart($r->cookie('carts'));    

        $latestProducts =Post::latest()->where('type',2)
        ->where('status','active')->where('new_arrival',true)
        ->whereDate('created_at','<=',Carbon::now())
        ->limit(8)
        ->get(['id','name','slug','final_price','regular_price','variation_status','discount_type','discount','brand_id']);
  
        collect($latestProducts)->map(function($item){
            $item->finalPrice = priceFullFormat($item->final_price);
            $item->image_url = asset($item->image());
            $item->wishListStatus = $item->isWl();
            $item->discountPercent = $item->discountPercent();
            $item->rating = $item->productRating();
            
            if($item->galleryFiles->count() > 0){
              $item->hoverImage_url = asset($item->galleryFiles->first()->image());
            }else{
              $item->hoverImage_url = asset($item->image());
            }
            unset($item->imageFile);
            unset($item->galleryFiles);
            return $item;
        });
            
            $pixelData=[];
            
            if(Auth::check() &&  (Auth::id()=='663')){
                //Facebook Concersation API
                $eventId =uniqid('cartview_');
                $pixelData = facebookPixelData('PageView',$eventId, [
                    'page_name' => 'Cart Page'
                ]);
                
                sendEvent('PageView', $eventId, [
                    'page_name' => 'Cart Page',
                ]);
            }
  
        return Inertia::render('Cart',compact('latestProducts','pixelData'));
    }
    
    

    public function checkout(Request $r){
    	$user =Auth::user();
        if($user){
            Session::put('selectZone',$user->district);
        }
        
        

        $myCarts = myCart($r->cookie('carts'));         
        if(count($myCarts['carts']) ==0)
        {
            return redirect()->route('carts')->with('info', 'Sorry, Your Cart Is empty.');
        }

        if($r->isMethod('post')){
            
            $check = $r->validate([
                'name' => 'required|max:100',
                'email' => 'nullable|max:100',
                'mobile' => 'required|max:20',
                'district' => 'required|numeric',
                'city' => 'required|numeric',
                'address' => 'required|max:500',
                'payment_option' => 'required',
            ]);
           
            $order =new Order();
            $order->user_id=Auth::check()?$user->id:null;
            $order->branch_id =general()->online_store_id;
            $order->name=$r->name;
            $order->mobile=$r->mobile;
            $order->email=$r->email;
            $order->district=$r->district;
            $order->city=$r->city;
            $order->address=$r->address;
            $order->postal_code=$r->postal_code;
            $order->note=$r->note;
            $order->order_status='pending';
            $order->pending_at=Carbon::now();
            $order->pending_by=Auth::check()?$user->id:null;
            $order->save();
            $order->invoice=$order->created_at->format('Ymd').$order->id;
            $order->save();
            
            // \Log::info('Order Created: '.Carbon::now()->format('Y-m-d H:i:s'));

            if($user){

                if($user->mobile==null && $order->mobile){
                    $hasUser=User::where('mobile',$order->mobile)->first();
                    if(!$hasUser){
                        $user->mobile=$order->mobile;
                    }
                }
                if($user->email==null && $order->email){
                    $hasUser=User::where('email',$order->email)->first();
                    if(!$hasUser){
                        $user->email=$order->email;
                    }
                }
                if($user->district==null && $order->district){
                    $user->district=$order->district;
                }
                if($user->city==null && $order->city){
                    $user->city=$order->city;
                }
                if($user->address_line1==null && $order->address){
                    $user->address_line1=$order->address;
                }
                $user->save();
            }
            
            // \Log::info('Order Item Ready: '.Carbon::now()->format('Y-m-d H:i:s'));

            foreach($myCarts['carts'] as $cart){
                // return $cart;
                $item = new OrderItem;
                $item->order_id = $order->id;
                $item->user_id = Auth::check()?$user->id:null;
                $item->invoice = $order->invoice;
                $item->product_id = $cart->product_id;
                $item->product_name = $cart->product?$cart->product->name:null;
                $item->quantity = $cart->quantity;
                $item->price = $cart->price; 
                $item->sku_value = $cart->sku_value;
                $item->sku_id = $cart->sku_id;
                $item->variant_id=$cart->variant_id;
                $item->barcode=$cart->barcode;
                $item->color = $cart->color; 
                $item->size = $cart->size; 
                $item->warranty_note = $cart->warranty_note; 
                $item->warranty_charge = $cart->warranty_charge?:0; 
                $item->total_price = $item->price*$item->quantity;
                $item->final_price = $item->total_price-$item->discount_amount;
                $item->purchase_price=$cart->product?$cart->product->purchase_price:0;
                $item->purchase_total=$item->purchase_price*$item->quantity;
                $item->profit_loss=$item->final_price-$item->purchase_total;
                $item->pending_at = Carbon::now();
                $item->pending_by = Auth::check()?$user->id:null;
                $item->addedby_id = Auth::check()?$user->id:null;
                $item->status=$order->order_status;
                $item->order_status=$order->order_status;
                $item->save();
                
                $cart->delete();
                
                // \Log::info('Order Iitem Add: '.Carbon::now()->format('Y-m-d H:i:s'));
            }


            $shippingCharge=0;
            if($order->items->sum('final_price') < 1000){
                if($order->district==73){
                $shippingCharge=general()->inside_dhaka_shipping_charge?:0;
                }else{
                $shippingCharge=general()->outside_dhaka_shipping_charge?:0;
                }
            }
            $trans =uniqid();
            $order->transection=$trans;
            $order->coupon_discount=$myCarts['couponDisc'];
            $order->shipping_charge =$shippingCharge;
            $order->total_price=$order->items->sum('final_price');
            $order->total_purchase=$order->items->sum('purchase_total');
            $order->profit_loss=$order->items->sum('profit_loss');
            $order->tax=0;
            $order->grand_total =$order->total_price + $order->shipping_charge + $order->tax - $order->coupon_discount;
            $order->paid_amount=0;
            $order->payment_method=$r->payment_option;
            $order->due_amount=$order->grand_total;
            $order->save();
            
            if($order->payment_method=='online'){
                
                $cityName=$order->cityN?$order->cityN->name:'Uttara';
                $stateName=$order->districtN?$order->districtN->name:'Uttara';
                $datas =[
                    'name'=>$r->name,
                    'email'=>$r->email,
                    'mobile'=>$r->mobile,
                    'address'=>$r->address,
                    'cityName'=>$cityName,
                    'stateName'=>$stateName,
                    'postCode'=>null,
                    'country'=>'Bangladesh',
                    'transection'=>$trans,
                    'currency'=>'BDT',
                    'grand_total'=>$order->grand_total,
                ];

                
                return  $this->sslCommercePay($datas);
                return response()->json([
                    'status' => 'success',
                    'data' => $paymentResponse,
                ]);
                return $paymentResponse;
                // response()->json([
                //     'status' => 'success',
                //     'data' => $paymentResponse,
                // ]);

                return redirect()->away($respons);
                if($respons->status=='success'){
                    return redirect()->away($respons->data);
                }
                 return "success";
            }
            
            
            //**********Send Mail***************//
            // if(general()->mail_status && $order->email){
            //     //Mail Data
            //     $datas =array('order'=>$order);
            //     $template ='mails.InvoiceMail';
            //     $toEmail =$order->email;
            //     $toName =$order->name;
            //     $subject ='Order Successfully Completed in '.general()->title;
            
            //     sendMail($toEmail,$toName,$subject,$datas,$template);
            // }
           
            // if(general()->mail_status && general()->mail_from_address){
            //     //Mail Data
            //     $datas =array('order'=>$order);
            //     $template ='mails.InvoiceMail';
            //     $toEmail =general()->mail_from_address;
            //     $toName =general()->mail_from_name;
            //     $subject ='Order Successfully Completed in '.general()->title;
            
            //     sendMail($toEmail,$toName,$subject,$datas,$template);
            // }

            //**********Send Mail***************//
            
            //Send SMS 
            // if(general()->sms_status && $order->mobile){
            //     $msg ='Your order is success. #'.$order->invoice.' Thank you for your shopping';
            //     sendSMS($order->mobile,$msg);
            // }
            
            
            // if(general()->fb_pageId){
            //     // Meta Pixel Server Side Call
            //     $this->sendPurchaseEvent($order);
            // }
            
            // \Log::info('Order Finish: '.Carbon::now()->format('Y-m-d H:i:s'));
            // return redirect()->route('invoiceView',$order->invoice)->with('success', 'Order successfully submitted');  
            
            
            return response()->json([
                'status' => 'success',
                'data' => route('invoiceView',$order->invoice),
            ]);

        }
	    if($r->district_id){
	          $datas=Country::where('parent_id',$r->district_id)->get(['id','name']);
	        //   $areaId =PostExtra::where('type',3)->where('parent_id','<>',null)->where('src_id',$r->district_id)->first();
    	    //   if($areaId){
            //      Session::put('selectZone',$r->district_id);
            //     }else{
            //         Session::forget('selectZone');
            //     }
            
            Session::put('selectZone',$r->district_id);
            

            $myCarts = myCart($r->cookie('carts'));  

	        return Response()->json([
              'success' => true,
              'datas' => $datas,
              'carts' => $myCarts,
            ]);
	    }

        $district=geoData(3);
        
        foreach($myCarts['carts'] as $cart){
            $variant =$cart->itemVariantData();
            if($variant){
                $cart->variant_id=$variant->id;
                $cart->barcode=$variant->barcode;
            }
            if (!empty($cart->itemAttributes())) {
            $cart->sku_value = json_encode($cart->itemAttributes());
            }
            $cart->price = $cart->itemprice();
            $cart->save();
        }
        
        // if(Auth::check() && Auth::id()==663){
            //Facebook Concersation API
            
            
            $pixelData=[];
            $pixelData2=[];
            
            if(Auth::check() &&  (Auth::id()=='663')){
                $eventId =uniqid('page_');
                
                $pixelData = facebookPixelData('PageView',$eventId, [
                    'page_name' => 'Home Page'
                ]);
                
                $data = sendEvent('PageView', $eventId, [
                    'page_name' => 'Checkout Page'
                ]);
                
                $user = Auth::user();
                $cart = $myCarts['carts'];
            
                // Prepare "contents"
                $contents = [];
                $contentsName = [];
                foreach ($cart as $item) {
                    $contentsName[] = [
                        'name'       => (string) $item->product?$item->product->name:'',
                    ];
                }
                
                foreach ($cart as $item) {
                    $contents[] = [
                        'id'       => (string) $item->product_id,
                        'quantity' => (int) $item->quantity,
                    ];
                }
            
                $user_data = [
                    'em' => hash('sha256', strtolower(trim($user->email ?? ''))),
                    'ph' => hash('sha256', preg_replace('/[^0-9]/', '', $user->mobile ?? '')),
                    'fn' => hash('sha256', strtolower(trim($user->name ?? ''))),
                    'country' => hash('sha256', strtoupper('BD')),
                    'client_ip_address' => request()->ip(),
                    'client_user_agent' => request()->userAgent(),
                ];
                
                $eventId2 =uniqid('initiateCheckout_');
            
                $pixelData2 = facebookPixelData('InitiateCheckout',$eventId2, [
                    'content_type' => 'product',
                    'content_ids'  => collect($contents)->pluck('id')->toArray(),
                    'contents_name'  => collect($contentsName)->pluck('name')->toArray(),
                    'contents'     => $contents,
                    'currency'     => 'BDT',
                    'value'        => (float) $myCarts['cartTotalPrice'],
                    'num_items'    => count($contents),
                ],$user_data);
            
                $response = sendEvent(
                    'InitiateCheckout',
                    $eventId2,
                    [
                        'content_type' => 'product',
                        'content_ids'  => collect($contents)->pluck('id')->toArray(),
                        'contents_name'  => collect($contentsName)->pluck('name')->toArray(),
                        'contents'     => $contents,
                        'currency'     => 'BDT',
                        'value'        => (float) $myCarts['cartTotalPrice'],
                        'num_items'    => count($contents),
                    ],
                    $user_data
                );
            }
        // }
        
        return Inertia::render('CheckOut',compact('district','pixelData','pixelData2'));
    }
    
    public function orderStatus(Request $r,$id){
        $order = Order::where('order_type','customer_order')->where('mail_send_status',false)->find($id);
        if($order){
            LongProcessJob::dispatch($id);
            return Response()->json([
                'success' => true,
              ],200);
        }
        return Response()->json([
                'success' => false,
              ],404);
    }
    
    public function checkOutDistricFilter($id){
        $datas=Country::where('parent_id',$id)->get(['id','name']);

         return Response()->json([
                'success' => true,
                'shipping' => 0,
                'datas' => $datas,
  
              ]);
    }
    
    
    public function sslCommercePay($datas){
        
        $post_data = array();
        $post_data['total_amount'] = $datas['grand_total']; # You cant not pay less than 10
        $post_data['currency'] = $datas['currency'];
        $post_data['tran_id'] = $datas['transection']; // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $datas['name'];
        $post_data['cus_email'] = $datas['email'];
        $post_data['cus_add1'] = $datas['address'];
        $post_data['cus_city'] = $datas['cityName'];
        $post_data['cus_state'] = $datas['stateName'];
        $post_data['cus_postcode'] =$datas['postCode'];
        $post_data['cus_country'] = $datas['country'];
        $post_data['cus_phone'] = $datas['mobile'];
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        $sslc = new SslCommerzNotification();
        // $payment_options = $sslc->makePayment($post_data, 'hosted');
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');
        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }


    
    }
    
    
    public function sslPayment(Request $request,$action){

        if($action=='pay-via-ajax'){
            $post_data = array();
            $post_data['total_amount'] = '10'; # You cant not pay less than 10
            $post_data['currency'] = "BDT";
            $post_data['tran_id'] = uniqid(); // tran_id must be unique
    
            # CUSTOMER INFORMATION
            $post_data['cus_name'] = 'Customer Name';
            $post_data['cus_email'] = 'customer@mail.com';
            $post_data['cus_add1'] = 'Customer Address';
            $post_data['cus_add2'] = "";
            $post_data['cus_city'] = "";
            $post_data['cus_state'] = "";
            $post_data['cus_postcode'] = "";
            $post_data['cus_country'] = "Bangladesh";
            $post_data['cus_phone'] = '8801XXXXXXXXX';
            $post_data['cus_fax'] = "";
    
            # SHIPMENT INFORMATION
            $post_data['ship_name'] = "Store Test";
            $post_data['ship_add1'] = "Dhaka";
            $post_data['ship_add2'] = "Dhaka";
            $post_data['ship_city'] = "Dhaka";
            $post_data['ship_state'] = "Dhaka";
            $post_data['ship_postcode'] = "1000";
            $post_data['ship_phone'] = "";
            $post_data['ship_country'] = "Bangladesh";
    
            $post_data['shipping_method'] = "NO";
            $post_data['product_name'] = "Computer";
            $post_data['product_category'] = "Goods";
            $post_data['product_profile'] = "physical-goods";
    
            # OPTIONAL PARAMETERS
            $post_data['value_a'] = "ref001";
            $post_data['value_b'] = "ref002";
            $post_data['value_c'] = "ref003";
            $post_data['value_d'] = "ref004";

            $sslc = new SslCommerzNotification();
            $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');
            return $payment_options; //response()->json();
            if (!is_array($payment_options)) {
                return response()->json(['error' => 'Payment initiation failed'], 500);
            }

            return response()->json(['redirect_url' => $payment_options['GatewayPageURL']]);

        }
        if($action=='again-pay'){
            $order =Order::find($request->order_id);
            if($order){
                
                $datas =[
                    'name'=>$order->name,
                    'email'=>$order->email,
                    'mobile'=>$order->mobile,
                    'district'=>$order->district,
                    'city'=>$order->city,
                    'address'=>$order->address,
                    'cityName'=>$order->cityN?$order->cityN->name:null,
                    'stateName'=>$order->districtN?$order->districtN->name:null,
                    'postCode'=>null,
                    'country'=>'Bangladesh',
                    'payment_option'=>'Online Payment',
                    'note'=>null,
                    'status'=>$order->order_status,
                    'transection'=>$order->transection,
                    'currency'=>'BDT',
                    'grand_total'=>$order->grand_total,
                ];
                
                return $this->sslCommercePay($datas);
                
            }else{
                return abort(404);
            }
        }
        
        if($action=='success'){
            
            $tran_id = $request->input('tran_id');
            $amount = $request->input('amount');
            $currency = $request->input('currency');
    
            $sslc = new SslCommerzNotification();
            
            $order = Order::latest()->where('transection', $tran_id)->first();
            if($order){
                if ($order->order_status == 'pending') {
                    $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);
                    if ($validation) {
                        $order->order_status='confirmed';
                        $order->paid_amount=$order->grand_total;
                        $order->due_amount=0;
                        $order->payment_status='paid';
                        $order->save();
                        
                        $transection =new Transaction();
                        $transection->billing_name=$order->name;
                        $transection->billing_email=$order->email;
                        $transection->billing_mobile=$order->mobile;
                        $transection->billing_address=$order->fullAddress();
                        $transection->transection_id=$tran_id;
                        $transection->payment_method=$order->payment_method;
                        $transection->currency='BDT';
                        $transection->status='Success';
                        $transection->type=0;
                        $transection->save();

                    }
                }
            
            $status='success';
            $message= 'Your order is successfully Completed';
            Session::flash($status,$message);
            return redirect()->route('invoiceView',$order->invoice);
            
            }else {
                $status='error';
                $message= 'Order Invalid Transaction';   
            }

            Session::flash($status,$message);
            return redirect()->route('checkout');
            
            
        }
        
        if($action=='fail'){
            $tran_id = $request->input('tran_id');
            if($tran_id){
                $order = Order::latest()->where('transection', $tran_id)->first();
                if($order){
                    if ($order->order_status != 'pending') {
                        $status='success';
                        $message= 'Transaction is successfully Completed';
                    }
                    $status='error';
                    $message= 'Transaction is Cancel';
                    
                    Session::flash($status,$message);
                    return redirect()->route('invoiceView',$order->invoice);
                    
                }else{
                    
                    $status='error';
                    $message= 'Order Invalid Transaction';    
                }

            }else{
                $status='error';
                $message= 'Order information Invalid Data';
            }

            Session::flash($status,$message);
            return redirect()->route('checkout');
            
        }
        
        if($action=='cancel'){
            
            $tran_id = $request->input('tran_id');
            if($tran_id){
                $order = Order::latest()->where('transection', $tran_id)->first();
                if($order){
                    if ($order->order_status != 'pending') {
                        $status='success';
                        $message= 'Transaction is successfully Completed';
                    }
                    $status='error';
                    $message= 'Transaction is Cancel';
                    
                    Session::flash($status,$message);
                    return redirect()->route('invoiceView',$order->invoice);
                    
                }else{
                    
                    $status='error';
                    $message= 'Order Invalid Transaction';    
                }

            }else{
                $status='error';
                $message= 'Order information Invalid Data';
            }

            Session::flash($status,$message);
            return redirect()->route('checkout');
        }
        
        if($action=='ipn'){
            if ($request->input('tran_id'))
            {
                $tran_id = $request->input('tran_id');
                
                $order = Order::latest()->where('transection', $tran_id)->first();
                if($order){
                    if($order->order_status == 'pending') {
                        $sslc = new SslCommerzNotification();
                        $validation = $sslc->orderValidate($request->all(), $tran_id, $order->grand_total, 'BDT');
                        if ($validation == TRUE) {
                            $order->order_status='confirmed';
                            $order->paid_amount=$order->grand_total;
                            $order->due_amount=0;
                            $order->payment_status='paid';
                            $order->save();
                            
                            
                            $transection =new Transaction();
                            $transection->billing_name=$order->name;
                            $transection->billing_email=$order->email;
                            $transection->billing_mobile=$order->mobile;
                            $transection->billing_address=$order->fullAddress();
                            $transection->transection_id=$tran_id;
                            $transection->payment_method=$order->payment_method;
                            $transection->currency='BDT';
                            $transection->status='Success';
                            $transection->type=0;
                            $transection->save();
                            
                            // $status='success';
                            // $message= 'Transaction is successfully Completed';
                            // Session::flash($status,$message);
                            // return redirect()->route('invoiceView',$order->invoice);
                        }
                    }
                    
                }else {
                    $status='error';
                    $message= 'Order Invalid Transaction';
                    Session::flash($status,$message);
                    return redirect()->route('checkout');
                }
            } else {
                $status='error';
                $message= 'Order information Invalid Data';
                Session::flash($status,$message);
                return redirect()->route('checkout');
            }
            
        }
        
        return abort(404);
        
    }
    
    
    public function sendPurchaseEvent($order){
        $pixelId = general()->fb_pageId;
        $accessToken = null;
        if($pixelId && $accessToken){

            $eventTime = time();
            $eventId = 'order_' . $order->id;

            $userData = [
                'em' => [hash('sha256', strtolower(trim($order->email)))],
                'ph' => [hash('sha256', preg_replace('/[^0-9]/', '', $order->phone))],
                'fn' => [hash('sha256', strtolower($order->first_name))],
                'ln' => [hash('sha256', strtolower($order->last_name))],
                'ct' => [hash('sha256', strtolower($order->city))],
                'st' => [hash('sha256', strtolower($order->state))],
                'zp' => [hash('sha256', $order->postal_code)],
                'country' => [hash('sha256', strtolower($order->country))],
                'client_user_agent' => request()->header('User-Agent'),
                'ip_address' => request()->ip(),
            ];

            $customData = [
                'value' => $order->sub_total,
                'currency' => $order->currency,
                'order_id' => $order->invoice,
                'contents' => collect($order->items)->map(function ($item) {
                    return [
                        'id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'item_price' => $item->price,
                    ];
                }),
                'content_type' => 'product',
            ];

            $payload = [
                'data' => [[
                    'event_name' => 'Purchase',
                    'event_time' => $eventTime,
                    'event_id' => $eventId,
                    'user_data' => $userData,
                    'custom_data' => $customData,
                    'action_source' => 'website'
                ]]
            ];

            $response = Http::post("https://graph.facebook.com/v18.0/{$pixelId}/events", array_merge($payload, [
                'access_token' => $accessToken
            ]));
        }
        return 'success';

    }
    
    
    public function invoiceView($invoice){
        
        $order = Order::where('order_type','customer_order')->where('invoice',$invoice)->first();
        if(!$order){
            return abort(404);
        }
        $pixelData=[];
        $pixelData2=[];
        
        if(Auth::check() &&  (Auth::id()=='663')){
            if($order->search_key==null){
            $order->search_key='purchase';
            $order->save();
                
                $eventId =uniqid('page_');
        
                $pixelData = facebookPixelData('PageView',$eventId, [
                    'page_name' => 'Success Order'
                ]);
                
                $data = sendEvent('PageView', $eventId, [
                    'page_name' => 'Success Order'
                ]);    
            
                //Facebook Concersation API
                $contents = [];
                foreach ($order->items as $item) {
                    $contents[] = [
                        'id' => $item->product_id,
                        'quantity' => $item->quantity,
                    ];
                }
                
                $cityName=$order->cityN?$order->cityN->name:'Uttara';
                $stateName=$order->districtN?$order->districtN->name:'Uttara';
                
                $user_data = [
                    'em'       => hash('sha256', strtolower(trim($order->email ?? ''))),
                    'ph'       => hash('sha256', preg_replace('/[^0-9]/', '', $order->mbbile ?? '')),
                    'fn'       => hash('sha256', strtolower(trim($order->name ?? ''))),
                    'ln'       => hash('sha256', strtolower(trim(''))),
                    'ct'       => hash('sha256', strtolower(trim($cityName))),
                    'st'       => hash('sha256', strtolower(trim($stateName))),
                    'zp'       => hash('sha256', trim('')),
                    'country'  => hash('sha256', strtoupper(trim('BD'))),
                    'client_ip_address' => request()->ip(),
                    'client_user_agent' => request()->header('User-Agent'),
                ];
                
                $eventId2 =uniqid('purchase_');
                $pixelData2 = facebookPixelData('Purchase',$eventId2, [
                    'content_type' => 'Product',
                    'value'    => $order->grand_total,
                    'currency' => 'BDT',
                    'content_ids'  => collect($contents)->pluck('id')->toArray(),
                    'contents_name' => $order->items()->pluck('product_name')->toArray(),
                    'contents' => $contents,
                    'order_id' => $order->invoice,
                ],$user_data);
                
                $data =sendEvent('Purchase', $eventId2, [
                        'content_type' => 'Product',
                        'value'    => $order->grand_total,
                        'currency' => 'BDT',
                        'content_ids'  => collect($contents)->pluck('id')->toArray(),
                        'contents_name' => $order->items()->pluck('product_name')->toArray(),
                        'contents' => $contents,
                        'order_id' => $order->invoice,
                    ], $user_data);

            }
        }
        
        $order->grandTotal=priceFullFormat($order->grand_total);
        $order->subTotal=$order->total_price;
        $order->discountTotal=priceFullFormat($order->coupon_discount);
        $order->chargeTotal=priceFullFormat($order->shipping_charge);
        $order->stateName=$order->districtN?$order->districtN->name:null;
        $order->cityName=$order->cityN?$order->cityN->name:null;
        $order->full_address=$order->fullAddress();
        $order->nameSha256=hash('sha256',strtolower(trim($order->name)));
        $order->phoneSha256=hash('sha256',strtolower(trim($order->mobile)));
        $order->emailSha256=$order->email?hash('sha256',strtolower(trim($order->email))):null;
        $order->stateSha256=hash('sha256',strtolower(trim($order->stateName)));
        $order->citySha256=hash('sha256',strtolower(trim($order->cityName)));
        $order->countrySha256=hash('sha256','bd');
        $cartItems=[];
        foreach($order->items as $cart){

            // $variant=array();
            $variant=$cart->itemAttributes();
            // if(1==1){
            //   $variant[]=[
            //     'title'=>'Color',
            //     'value'=>'Green',
            //   ];
            //   $variant[]=[
            //     'title'=>'Size',
            //     'value'=>'L',
            //   ];
            // }

            $cartItems[]=[
              'id'=>$cart->product_id,
              'productName'=>$cart->product_name,
              'productImage'=>asset($cart->image()),
              'finalPrice'=>priceFullFormat($cart->price),
              'quantity'=>$cart->quantity,
              'subTotal'=>priceFullFormat($cart->final_price),
              'variants'=>$variant,
            ];
            unset($cart->product);
            
        }
        $order->cartItems=$cartItems;
         $order->completeNote="ধন্যবাদ মেঘে অর্ডার দেয়ার জন্য। আমাদের ডেলিভারি সেকশন থেকে ফোন কলের মাধ্যমে আপনার অর্ডারটি কনফার্ম করা হবে। দয়া করে পণ্য ডেলিভারির সময় ডেলিভারি ম্যান সামনে থাকা অবস্থায় চেক করে গ্রহণ করবেন এবং পণ্য পছন্দ না হলে ডেলিভারি চার্জ দিয়ে রিটার্ন করতে পারবেন (যদি আগে ডেলিভারি চার্চ না দিয়ে থাকেন)।ডেলিভারি ম্যানের সামনে চেক করার সুযোগ না পেলে, বাসায় গিয়ে চেক করে পছন্দ না হলে রিটার্ন করা ঝামেলা তবে চেন্জ করা যাবে। আমাদের দিক থেকে কোনো রকম সমস্যা হলে কোন সার্ভিস চার্জ ছাড়াই চেন্জ করে দেয়া হবে। সে ক্ষেত্রে সরাসরি আমাদের সাথে ফোন কল এর মাধ্যমে যোগাযোগ করবেন। 01831999899 অথবা 0161163442";
        unset($order->items);
     
        // return $order;
        return Inertia::render('Invoice',compact('order','pixelData','pixelData2'));

    }

    public function cartCount(Request $r){

        $myCarts = myCart($r->cookie('carts'));
        $cartsCount = 0;     
        if(count($myCarts['carts']) > 0)
        {
            $cartsCount = $myCarts['cartsCount'];
        }
        
        return Response()->json([
            'success' => true,
            'cart_count' => $cartsCount
          ]);
    }
    

    public function orderPayment($id){

        $order =Order::find($id);

        if(!$order){
            Session::flash('error','This Order Invoic Are Not Found');
            return redirect()->route('customer.myOrders');
        }
        $active='';
        $general =General::first();

        if($general->online_payment){
            $active ='handcash_payment';
        }elseif($general->wallet_payment){
            $active ='wallet_payment';
        }else{
            $active ='online_payment';
        }
        
        //Mail Send / SMS Send
        
        //**********Send Mail***************//
        
        if($general->mail_status && $order->email){

            Mail::to($order->email)->send(new orderInvoiceMail($order));
            
        }
        
        //**********Send Mail***************//
        
         //**********Send SMS ***************//
            if($general->sms_status){
        
                //Send SMS User
                if($general->order_place_sms_customer && $order->mobile){
                    
                    $m =$order->mobile;
                    
                    $to =bdMobile($m);
                    
                    if(strlen($to) != 13)
                    {
                        return true;
                    }
                    $msg = urlencode("Your order #{$order->invoice} is Successfully Place in {$general->title}. Total Invoice Cost is {$general->currency} {$order->grand_total}."); //150 characters allowed here
        
                    $url = smsUrl($to,$msg);
                
                    $client = new Client();
                    
                    try {
                            $r = $client->request('GET', $url);
                        } catch (\GuzzleHttp\Exception\ConnectException $e) {
                        } catch (\GuzzleHttp\Exception\ClientException $e) {
                        }
                    
                    
                }
                
                //Send SMS Vendor User
                if($general->order_place_sms_vendor){
                    
                    foreach($order->items as $item){
                        
                        if($item->seller){
                            
                            if($item->seller->user){
                                
                                if($item->seller->user->mobile){
                                    
                                    $m =$item->seller->user->mobile;
                    
                                    $to =bdMobile($m);
                                    
                                    if(strlen($to) != 13)
                                    {
                                        return true;
                                    }
                                    $msg = urlencode("Your Product New order #{$order->invoice} is Successfully Place in {$general->title}. Total Cost is {$general->currency} {$item->seller_paid}."); //150 characters allowed here
                        
                                    $url = smsUrl($to,$msg);
                                
                                    $client = new Client();
                                    
                                    try {
                                            $r = $client->request('GET', $url);
                                        } catch (\GuzzleHttp\Exception\ConnectException $e) {
                                        } catch (\GuzzleHttp\Exception\ClientException $e) {
                                        }
                                    
                                }
                                
                                
                            }
                            
                        }
                        
                    }
                    
                }
                
                //Send SMS Admin
                if($general->order_place_sms_admin && $general->admin_numbers){
                    
                    $to =$general->admin_numbers;

                    $msg = urlencode("New Order in {$general->title}. Invoice: {$order->invoice}, Total Cost: {$order->grand_total}."); //150 characters allowed here
        
                    $url = smsUrl($to,$msg);
                
                    $client = new Client();
                    
                    try {
                            $r = $client->request('GET', $url);
                        } catch (\GuzzleHttp\Exception\ConnectException $e) {
                        } catch (\GuzzleHttp\Exception\ClientException $e) {
                        }
                }
                
                
                
            }
            
        //**********Send SMS ***************//
        

        // return view(welcomeTheme().'carts.orderPayment',compact('order','active'));
    }
    
    public function orderPaymentSend($type,$id){
         $order =Order::find($id);

        if(!$order){
            Session::flash('error','This Order Invoic Are Not Found');
            return redirect()->route('customer.myOrders');
        }
        $general =General::first();
        $user =Auth::user();
        
        if($type=='wallet'){
            
            if($order->due_amount > $user->balance){
                Session::flash('error','Your Wallet Balance Are Not available.Please Re-charge.');
                return redirect()->route('customer.myOrders');
            }
            
            $balance =new Transaction();
            $balance->type=0;
            $balance->order_id=$order->id;
            $balance->user_id=$user->id;
            $balance->billing_name=$order->name;
            $balance->billing_mobile=$order->mobile;
            $balance->billing_email=$order->email;
            $balance->billing_address=$order->address;
            $balance->billing_note='Customer pay bill by wallet method.';
            $balance->transection_id=mt_rand(100000,999999).'TSBD'.$order->id;
            $balance->payment_method='wallet';
            $balance->amount=$order->due_amount;
            $balance->currency=$general->currency;
            $balance->status='success';
            $balance->addedby_id=Auth::id();
            $balance->save();

            $general->balance+=$balance->amount;
            $general->save();

            $user->balance -=$balance->amount;
            $user->save();

            $order->paid_amount +=$balance->amount;

            if($order->paid_amount >=$order->grand_total){
            $order->extra_amount=$order->paid_amount - $order->grand_total;
            $order->due_amount=0;
            
            }else{
            $order->extra_amount=0;
            $order->due_amount=$order->grand_total-$order->paid_amount;
            }
            
            if($order->due_amount==0){
            $order->payment_status='paid';
            }elseif($order->due_amount==$order->grand_total){
            $order->payment_status='unpaid';
            }else{
            $order->payment_status='partial';
            }

            $order->payment_method='wallet';
            $order->save();
            
            foreach($order->items as $item){
                $item->payment_status=$order->payment_status;
                $item->save();
            }
            
            //send SMS
            
            //Send Mail
            
            Session::flash('success','You Order Is Successfully Place. Thank You for Shopping!');
            return redirect()->route('customer.orderDetails',$order->id);
             
        }else if($type=='handcash'){
            
            $order->payment_method='Cash On Delivery';
            $order->save();
            
            Session::flash('success','You Order Is Successfully Place. Thank You for Shopping!');
            return redirect()->route('customer.orderDetails',$order->id);
            
        }else{
            
             Session::flash('error','Worng Paydment Method is not Allow');
            return redirect()->route('customer.myOrders');
        }
    }
    



    public function wishlistCompareUpdate(Request $r,$id,$action){  
        $product =Post::where('type',2)->find($id);
        if(!$product){
            return abort(404);
        }
		$cookie = $r->cookie('carts');
        if(!$cookie){
            return redirect()->route('index');
        }
        $message=null;

        if($action=='wishlist'){
            $statusType =0;
            $overCount =48;
        }else{
            $statusType =1;
            $overCount =20;
        }

					
        $oldData = WishList::where('cookie', $cookie)->where('type',$statusType)->where('product_id', $product->id)->first();
        if($oldData){
            $oldData->delete();
            $status =false;
            $alert=false;
            $message=$action.' remove successfully';
        }else{
            $totalCount =WishList::where('cookie',$cookie)->where('type',$statusType)->count();
            if($overCount > $totalCount){
                $data = new WishList;
                $data->user_id = Auth::id();
                $data->product_id = $product->id;
                $data->cookie = $cookie;
                $data->type =$statusType;
                $data->save();
                $status =true;
                $alert=false;
                $message=$action.' added successfully';
            }else{
                $status =false;
                $alert=true;
                $message=$action.' can not added more';
            }
        }

        if($action=='wishlist'){
            $wlCount =WishList::where('cookie',$cookie)->where('type',$statusType)->count();
            
            $products = Post::whereHas('wishlists',function($qq)use($cookie){
                $qq->where('cookie',$cookie);
            })->get();

            collect($products)->map(function($item){
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


            // $itemsView = view(welcomeTheme().'carts.includes.wishlistItems',compact('products','wlCount'))->render();

        }else{
            
            $cpCount =WishList::where('cookie',$cookie)->where('type',$statusType)->count();

            $products = Post::whereHas('comparelists',function($qq)use($cookie){
                $qq->where('cookie', $cookie);
            })->paginate(20);

            // $itemsView = view(welcomeTheme().'carts.includes.compareItems',compact('products','cpCount'))->render();
        }

        return Response()->json([
            'success' => true,	
            'status' => $status,
            'alert' => $alert,
            'statusType' => $statusType,
            'count' => WishList::where('cookie',$cookie)->whereHas('product')->where('type',$statusType)->count(),		        
            // 'itemsView' => $itemsView,	        
            'message' => $message,
            'products' => $products,

        ]);

        if($r->ajax()){

            
            
        }else{

            return back()->with('success', 'Your Action successfully Done');;
        }


		
	}


	public function myWishlist(Request $r){



			$products = Post::whereHas('wishlists',function($qq){
			 		$qq->where('cookie', Cookie::get('carts'));
			 	})
                ->select(['id','name','slug','final_price','regular_price','stock_status','quantity','stock_out_limit','variation_status','brand_id'])
                ->whereDate('created_at','<=',date('Y-m-d'))->get();
       
               collect($products)->map(function($item){
                 $item->finalPrice = priceFullFormat($item->final_price);
                 if($item->final_price < $item->regular_price){
                   $item->regularPrice =  priceFullFormat($item->regularPrice());
                 }else{
                   $item->regularPrice = null;
                 }
                 
                 $item->stock = $item->stockStatus();
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
            return Inertia::render('WishList', compact('products'));
	}


	public function myCompare(Request $r){
        $cookie = $r->cookie('carts');
        if(!$cookie){
            return redirect()->route('index');
        }
        $products =Post::whereHas('comparelists',function($qq)use($cookie){
            $qq->where('cookie', $cookie);
        })->paginate(20);

		// return view(welcomeTheme().'carts.myCompare',compact('products'));
	}

    public function orderNow(Request $r,$id){
        $product =Post::find($id);
        if(!$product){
            Session::flash('error','Product Not Found');
            return redirect()->route('index');
        }
        $check = $r->validate([
            'name' => 'required|max:100',
            'email' => 'nullable|max:100',
            'transection' => 'nullable|max:100',
            'payment_method' => 'required|max:100',
            'mobile' => 'required|numeric',
            'address' => 'required|max:500',
        ]);

        if(!$check){
            return back();
        }
        
        $user =Auth::user();
        
        $order =new Order();
       $order->save();
       $order->invoice=$order->created_at->format('ymd').$order->id;
       $order->user_id=$user?$user->id:null;
       $order->name=$r->name;
       $order->mobile=$r->mobile;
       $order->email=$r->email;
       $order->address=$r->address;
      
       $addr =$order->address;

       $order->full_address=$addr;
       
       $order->order_status='pending';
       $order->pending_at=Carbon::now();
       $order->pending_by=$user?$user->id:null;
       $order->save();

            $item = new OrderItem;
      		$item->order_id = $order->id;
            $item->user_id = $user?$user->id:null;
            $item->invoice = $order->invoice;
            $item->seller_id = $product->seller_id;
            $item->product_id = $product->id;
            $item->product_name = $product->title;
            $item->quantity = 1;

            if($product->price_variation){
                
            }else{
                if($product->quantity > $item->quantity){
                    $product->quantity-=$item->quantity;
                    $product->sell_count+=1;
                    $product->save();
                }
            }

            $item->price = $product->final_price;
            $item->total_price = $product->final_price;
        
            $item->final_price = $product->final_price;
            $item->pending_at = Carbon::now();
            $item->pending_by =null;
            $item->addedby_id =null;
            $item->status='pending';
            $item->order_status='pending';
            $item->seller_paid=$item->final_price;
            
            $key =$order->invoice;
            if($order->name){
            $key.=' '.$order->name;
            }
            if($order->mobile){
            $key.=' '.$order->mobile;
      	    }
      	    if($order->email){
            $key.=' '.$order->email;
            }
            $item->seller_paid=$item->final_price;
            $item->search_key=$key;
            $item->save();

        $general =General::first();

        $order->total_price=$item->final_price;
        $order->grand_total =$item->final_price;
        $order->paid_amount=0;
        $order->payment_method=$r->payment_method;
        $order->transection=$r->transection;
        $order->due_amount=$order->grand_total;
        $order->save();
        
        // $order =new ProductSize();
        // $order->product_id=$product->id;
        // $order->title=$r->name;
        // $order->email=$r->email;
        // $order->mobile=$r->mobile;
        // $order->address=$r->address;
        // $order->transection=$r->transection;
        // $order->addedby_id=0;
        // $order->save();
        Session::flash('success','Your Order is Success. We are contact as soon as possible.');
        return redirect()->back();
    }













}
