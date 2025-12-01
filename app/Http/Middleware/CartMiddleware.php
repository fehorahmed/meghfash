<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Response;
use Cookie;
use App\Models\Cart;
use App\Models\Post;
use App\Models\Attribute;
use App\Models\General;
use App\Models\WishList;
use Illuminate\Support\Str;

class CartMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        
        
        $cookie = $request->cookie('carts');
        
         if (!$request->hasCookie('_fbexternal_id')) {
            $id = hash('sha256', time() . '-' . Str::random(16));
            setcookie('_fbexternal_id', $id, time() + (60 * 60 * 24 * 365), '/', '.meghfashion.com', true, true);
        }
        
        
        $locale=session()->get('locale')?:'en';
        session()->put('locale', $locale); 
        app()->setlocale($locale);
    
        if( $cookie)
        {
    
            if(!$request->ajax())
            {
                $carts = Cart::where('cookie', $cookie)->latest()->whereHas('product')->get();
                $cartsCount =$carts->sum('quantity');
                $cartTotalPrice = 0;
                $DShipingCharge = 0;
                $ODhakaShippingcharge = 0;
                $deliveryCharge = 0;
                $couponDisc = 0;
                
                $wp =General::first();
                
                foreach ($carts as $cart) 
                {
                    if($cart->product){
                        $cartTotalPrice +=  $cart->subtotal();
                        $cart->save();
                    }else{
                        $cart->delete();  
                    }
                    
                }

                if ($mci = Session::get('my_coupon_id')) 
                {
                    $mc =Attribute::where('type',13)->where('id',$mci)->first();

                    if($mc)
                    {
                        if($mc->location=='product'){
                            $couponCarProducts =$carts->whereIn('product_id',$mc->couponProductPosts()->pluck('reff_id'));
                            foreach($couponCarProducts as $ctp){
                                $couponDisc += $mc->couponDiscountAmount($ctp->subtotal());
                            }
                        }elseif($mc->location=='category'){
                            $hasCouponProducts = Post::whereIn('id',$carts->pluck('product_id'))->whereHas('ctgProducts',function($q)use($mc){
                                        $q->whereIn('reff_id',$mc->couponCtgs()->pluck('reff_id'));
                                      })->pluck('id');
                        
                            $couponCarProducts =$carts->whereIn('product_id',$hasCouponProducts);
                            foreach($couponCarProducts as $ctp){
                                $couponDisc += $mc->couponDiscountAmount($ctp->subtotal());
                            }
                        }else{
                            $couponDisc = $mc->couponDiscountAmount($cartTotalPrice);
                        }
                      
                    }
                }

                $gtD=0;
                $gtOD=0;
                $gtODShipping=0;


                $wlCount = WishList::where('cookie',$cookie)->whereHas('product')->where('type',0)->count();
                
                $cpCount = WishList::where('cookie',$cookie)->whereHas('product')->where('type',2)->count();
                
                // Shipping Charge
                $shippingCharge=0;

                //Tax Charge
                $cartTax =0;

                
                $grandTotal = $cartTotalPrice + $shippingCharge + $cartTax - $couponDisc;

                view()->share('cartsCount',  $cartsCount);
                view()->share('carts',  $carts);
                view()->share('cartTotalPrice',$cartTotalPrice);
                view()->share('couponDisc', $couponDisc);
                view()->share('grandTotal', $grandTotal);
                view()->share('cartTax', $cartTax);
                view()->share('gtD', $gtD);
                view()->share('shippingCharge', $shippingCharge);
                view()->share('gtOD', $gtOD);
                view()->share('gtODShipping', $gtODShipping);
                view()->share('wlCount', $wlCount);
                view()->share('cpCount', $cpCount);
                
            }            

            return $next($request);  
        }
        else
        {
            view()->share('cartsCount',  0);
            view()->share('carts', null);
            view()->share('cartTotalPrice', 0);
            view()->share('couponDisc', 0);
            view()->share('grandTotal', 0);
            view()->share('cartTax', 0);
            view()->share('shippingCharge', 0);
            view()->share('wlCount', 0);
            view()->share('cpCount', 0);
            
            $response = $next($request);
           
           //Cookie::queue(Cookie::make('rabiul', time().'-'.Str::random(15).' browser: '.$_SERVER['HTTP_USER_AGENT'].' ip: '.$request->ip() , 43200));
            
           //Cookie::queue('carts', time().'-'.Str::random(15).' browser: '.$_SERVER['HTTP_USER_AGENT'].' ip: '.$request->ip(), 43200);
          return $response->withCookie(cookie('carts', time().'-'.Str::random(15).' browser: '.$_SERVER['HTTP_USER_AGENT'].' ip: '.$request->ip(), 43200));
          //return dd($response);
            return $next($request);
            
            //return $response->withCookie($cokki);
            //return $response->withCookie(cookie('cart', time().'-'.Str::random(15).' browser: '.$_SERVER['HTTP_USER_AGENT'].' ip: '.$request->ip(), 43200));
            
        }

        

    }
         
}
