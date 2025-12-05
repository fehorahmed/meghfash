<?php

namespace App\Http\Controllers\Welcome;

use Image;
use Auth;
use Hash;
use Str;
use Session;
use Http;
use Validator;
use Carbon\Carbon;
use App\Models\Country;
use App\Models\Post;
use App\Models\Order;
use App\Models\Media;
use App\Models\PostExtra;
use App\Models\User;
use App\Models\Attribute;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WelcomeController extends Controller
{



    public function __construct(){
        $this->middleware('cart');
    }

	public function geo_filter($id){

      $datas=Country::where('parent_id',$id)->get(['id','name']);

      $geoData =View('geofilter',compact('datas'))->render();

       return Response()->json([
              'success' => true,
              'geoData' => $geoData,
              'datas' => $datas,

            ]);
    }

    public function imageView(Request $r){
        if($r->imageUrl && is_numeric($r->weight) && is_numeric($r->height)){
          $image = Image::make($r->imageUrl)->fit($r->weight,$r->height)->response();
        }else{
          $image = Image::make('public/medies/noimage.jpg')->fit(200,200)->response();
        }
        return $image;
    }

    public function imageView2(Request $r,$template=null,$image=null){
        $weight=null;
        $height=null;

        if(is_numeric($r->w)){
          $weight=$r->w;
        }
        if(is_numeric($r->h)){
          $height=$r->h;
        }

        $filePath='public/medies/noimage.jpg';

        if($image){
            $file =Media::where('file_rename',$image)->select(['file_url'])->first();
            if($file){
                $filePath = $file->file_url;
            }
        }

        $mImage =Image::make($filePath);

        if($template=='s-profile'){

            if($image && $image!='profile.png' && $file){
                $filePath = $file->file_url;
            }else{
                $filePath ='public/medies/profile.png';
            }
        }elseif($template=='sm-resize'){
            if($weight && $height){
                $mImage=$mImage->resize($weight,$height);
            }
        }elseif($template=='resize'){
            if($weight && $height){
                $mImage=$mImage->resize($weight,$height);
            }
        }elseif($template=='brand-fit'){
            if($weight && $height){
                $mImage=$mImage->fit($weight,$height);
            }
        }
        $mImage=$mImage->response();

        return $mImage;
    }


    public function siteMapXml(Request $r){

      $pages = Post::latest()->where('type',0)->where('status','active')->select(['slug','updated_at','status'])->limit(200)->get();
      $posts = Post::latest()->where('type',1)->where('status','active')->select(['slug','updated_at','status'])->limit(500)->get();
      $products = Post::latest()->where('type',2)->where('status','active')->select(['slug','updated_at','status'])->limit(300)->get();

      return response()->view('siteMap',compact('pages','posts','products'))->header('Content-Type', 'text/xml');
    }

    public function productFeedXml(Request $r){
      $products = Post::latest()->where('type',2)->where('status','active')->where('for_website',true)->select(['id','name','description','regular_price','final_price','slug','updated_at','status'])->limit(1000)->get();
      return response()->view('productFeedXml',compact('products'))->header('Content-Type', 'text/xml');
    }

    public function language($lang=null){
      if($lang){
          Session::put('lang',$lang);
      }else{
          Session::put('lang','en');
      }
      return redirect()->back();
    }

    public function courierCallBack(Request $r,$type){
        if($type=='carrybee'){
            $xKey = $r->header('X-BEE-Signature');
            $webhook=general()->carrybee_webhook;
            if($webhook==$xKey){
                $data =$r->all();
                $id =isset($data['merchant_booking_id'])?$data['merchant_booking_id']:00;
                $order =Order::where('order_type','customer_order')->where('invoice',$id)->first();
                if(!$order){
                    $order =Order::where('order_type','customer_order')->find($id);
                }
                if(!$order){
                    $id = $data['consignment_id'] ?? 0;
                    $order = Order::where('order_type', 'customer_order')->where('courier','Carrybee')->where('courier_id',$id)->first();
                }
                if($order){
                    $order->courier_data = json_encode($data);
                    if(isset($data['order_status'])){
                        if($data['order_status'] === 'Delivered' || $data['order_status']==='Exchange') {
                            $order->order_status='delivered';
                        }elseif($data['order_status'] === 'Paid Return' || $data['data']['order_status'] === 'Return'){
                            $order->order_status='returned';
                        }
                        $order->courier_status=$data['order_status'];
                    }
                    $order->save();
                }
                return Response()->json([
                  'success' => true,
                ]);

            }
            return Response()->json([
              'success' => false,
            ],401);

        }elseif($type == 'steadfast') {

            $token = $r->header('Authorization');
            $expectedToken = "Bearer " . general()->steadfast_api_key;
            if ($token !== $expectedToken) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized request.'
                ], 401);
            }

            $data = $r->all();
            if (isset($data['notification_type'])) {

                if($data['notification_type'] === 'tracking_update') {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Tracking update received successfully.'
                    ], 200);

                }

                if ($data['notification_type'] === 'delivery_status') {
                    $id = $data['invoice'] ?? 0;
                    $order = Order::where('order_type', 'customer_order')
                                ->where('invoice', $id)
                                ->first();
                    if(!$order){
                        $id = $data['consignment_id'] ?? 0;
                        $order = Order::where('order_type', 'customer_order')->where('courier','Steadfast')->where('courier_id',$id)->first();
                    }

                    if($order){
                        $order->courier_data = json_encode($data);
                        if (isset($data['status'])) {
                            $status = ucwords(str_replace('_', ' ', strtolower($data['status'])));
                            if ($status === 'Delivered' || $status === 'Exchange') {
                                $order->order_status = 'delivered';
                            } elseif ($status === 'Paid Return' || $status === 'Return') {
                                $order->order_status = 'returned';
                            }
                            $order->courier_status = $status;
                        }
                        $order->save();
                    }
                }

            }

            return response()->json([
                'status' => 'success',
                'message' => 'Delivery status updated successfully.'
            ], 200);


        }elseif($type == 'pathao') {

            $xKey = $r->header('X-PATHAO-Signature');
            $webhook = general()->pathao_webhook;

            if ($webhook == $xKey) {
                $data = $r->all();
                if (isset($data['event']) && $data['event'] === 'webhook_integration') {
                    return response()->json([
                        'success' => true,
                        'message' => 'Integration success',
                    ], 202)->header(
                        'X-Pathao-Merchant-Webhook-Integration-Secret',
                        $xKey
                    );
                }
                $id = $data['merchant_order_id'] ?? 0;
                $order = Order::where('order_type', 'customer_order')
                            ->where('invoice', $id)
                            ->first();

                if (!$order) {
                    $order = Order::where('order_type', 'customer_order')->find($id);
                }

                if(!$order){
                    $id = $data['consignment_id'] ?? 0;
                    $order = Order::where('order_type', 'customer_order')->where('courier','Pathao')->where('courier_id',$id)->first();
                }
                if ($order) {
                    $order->courier_data = json_encode($data);
                    if (isset($data['event'])) {
                        $status = ucwords(str_replace(['order.', '-'], ['', ' '], $data['event']));
                        if ($status === 'Delivered' || $status === 'Exchange') {
                            $order->order_status = 'delivered';
                        } elseif ($status === 'Paid Return' || $status === 'Return') {
                            $order->order_status = 'returned';
                        }
                        $order->courier_status = $status;
                    }

                    $order->save();
                }
                return response()->json([
                    'success' => true,
                ], 202)->header('X-Pathao-Merchant-Webhook-Integration-Secret', $xKey);
            }

            return response()->json([
                'success' => false,
            ], 401)->header('X-Pathao-Merchant-Webhook-Integration-Secret', $xKey);
        }
        return redirect()->route('index');
    }


    public function index(Request $r){


            $pixelData=[];
            if(Auth::check() && (Auth::id()=='663')){

                //Facebook Concersation API
                $eventId =uniqid('page_');

                $pixelData = facebookPixelData('PageView',$eventId, [
                    'page_name' => 'Home Page'
                ]);

                $data = sendEvent('PageView', $eventId, [
                    'page_name' => 'Home Page'
                ]);

            }
            // dd(Auth::check());
            $promotions =Attribute::latest()->where('type',14)->where('status','active')
                    ->where('parent_id',null)
                    ->where('fetured',true)
                    ->where(function($q){
                      if($q->getModel()->start_date && $q->getModel()->end_date){
                          $q->whereDate('start_date','>=',Carbon::now())->whereDate('end_date','<=',Carbon::now());
                      }elseif($q->getModel()->start_date){
                          $q->whereDate('start_date','>=',Carbon::now());
                      }elseif($q->getModel()->end_date){
                          $q->whereDate('end_date','<=',Carbon::now());
                      }
                    })
                    ->select(['id','name','slug','start_date','end_date','location'])
                    ->get();



        collect($promotions)->map(function($item){

            $item->image_url = $item->imageFile?asset($item->image()):null;
            $item->image_link =null;

            $products =$item->couponProducts()->where('for_website',true)->limit(10)->get(['id','name','slug','final_price','regular_price','variation_status','discount_type','discount','brand_id','sale_label']);

            collect($products)->map(function($item){
                $item->finalPrice = priceFullFormat($item->offerPrice());
                $item->wishListStatus = $item->isWl();
                $item->discountPercent = $item->discountPercent();
                $item->rating = $item->productRating();

                $item->sale_label = $item->sale_label?true:false;

                if($item->offerPrice() < $item->regular_price){
                  $item->regularPrice =  priceFullFormat($item->regularPrice());
                }else{
                  $item->regularPrice = null;
                }

                $item->image_url = asset($item->image());
                if($item->galleryFiles->count() > 0){
                  $item->hoverImage_url = asset($item->galleryFiles->first()->file_url);
                }else{
                  $item->hoverImage_url = asset($item->image());
                }
                unset($item->imageFile);
                unset($item->galleryFiles);
                return $item;
              });


            $item->products =$products;
            return $item;

        });


      $page =pageTemplate('Front Page');

      $topProducts =Post::latest()->where('type',2)
      ->where('status','active')->where('for_website',true)
      ->where('top_sale', true)
      ->whereDate('created_at','<=',Carbon::now())
      ->limit(20)
      ->get(['id','name','slug','final_price','regular_price','variation_status','discount_type','top_sale','discount','brand_id','sale_label']);

      collect($topProducts)->map(function($item){
        $item->finalPrice = priceFullFormat($item->offerPrice());
        $item->wishListStatus = $item->isWl();
        $item->discountPercent = $item->discountPercent();
        $item->rating = $item->productRating();

        $item->sale_label = $item->sale_label?true:false;

        if($item->offerPrice() < $item->regular_price){
          $item->regularPrice =  priceFullFormat($item->regularPrice());
        }else{
          $item->regularPrice = null;
        }

        $item->image_url = asset($item->image());
        if($item->galleryFiles->count() > 0){
          $item->hoverImage_url = asset($item->galleryFiles->first()->file_url);
        }else{
          $item->hoverImage_url = asset($item->image());
        }
        unset($item->imageFile);
        unset($item->galleryFiles);
        return $item;
      });

    //   return $topProducts;
      $trandingProducts =Post::latest()->where('type',2)
      ->where('status','active')->where('for_website',true)
      ->where('fetured',true)
      ->whereDate('created_at','<=',Carbon::now())
      ->limit(20)
      ->get(['id','name','slug','final_price','regular_price','variation_status','discount_type','discount','brand_id','sale_label']);

      collect($trandingProducts)->map(function($item){
        $item->finalPrice = priceFullFormat($item->offerPrice());
        $item->image_url = asset($item->image());
        $item->wishListStatus = $item->isWl();
        $item->discountPercent = $item->discountPercent();
        $item->rating = $item->productRating();

        $item->sale_label = $item->sale_label?true:false;

        if($item->offerPrice() < $item->regular_price){
          $item->regularPrice =  priceFullFormat($item->regularPrice());
        }else{
          $item->regularPrice = null;
        }

        if($item->galleryFiles->count() > 0){
          $item->hoverImage_url = asset($item->galleryFiles->first()->file_url);
        }else{
          $item->hoverImage_url = asset($item->image());
        }
        unset($item->imageFile);
        unset($item->galleryFiles);
        return $item;
      });

      $latestProducts =Post::latest()->where('type',2)
      ->where('status','active')->where('for_website',true)
      ->where('new_arrival',true)
      ->whereDate('created_at','<=',Carbon::now())
      ->limit(20)
      ->get(['id','name','slug','final_price','regular_price','variation_status','discount_type','discount','brand_id','sale_label']);

      collect($latestProducts)->map(function($item){
        $item->finalPrice = priceFullFormat($item->offerPrice());
        $item->image_url = asset($item->image());
        $item->wishListStatus = $item->isWl();
        $item->discountPercent = $item->discountPercent();
        $item->rating = $item->productRating();

        $item->sale_label = $item->sale_label?true:false;

        if($item->offerPrice() < $item->regular_price){
          $item->regularPrice =  priceFullFormat($item->regularPrice());
        }else{
          $item->regularPrice = null;
        }

        if($item->galleryFiles->count() > 0){
          $item->hoverImage_url = asset($item->galleryFiles->first()->image());
        }else{
          $item->hoverImage_url = asset($item->image());
        }
        unset($item->imageFile);
        unset($item->galleryFiles);
        return $item;
      });

      $category =Attribute::latest()->where('status','active')->where('fetured',true)->where('type',0)->get();

      $blogs =Post::latest()->where('type',1)
      ->where('status','active')
      ->whereDate('created_at','<=',Carbon::now())
      ->limit(4)
      ->get(['id','name','slug','created_at']);

      collect($blogs)->map(function($item){
        $item->createdAt = $item->created_at->format('F d, Y');
        $item->image_url = asset($item->image());
        unset($item->imageFile);
        return $item;
      });


      $brands =Attribute::latest()->where('type',2)->where('status','active')->where('fetured',true)
                ->whereHas('brandProducts',function($q){
                    $q->where('status','active');
                })
                ->limit(12)->get(['id','name','slug']);

      $bannerGroupOne =PostExtra::latest()->where('type',4)->where('parent_id',null)->where('status','active')
                       ->where('data_type','Banner Ads Group One')
                       ->limit(4)
                       ->get(['id','name','sub_title','category_id','image_link']);

      collect($bannerGroupOne)->map(function($item){
        $item->link = $item->image_link?:null;
        $item->image_url = asset($item->image());
        unset($item->imageFile);
        return $item;
      });

      $galleries =PostExtra::latest()->where('type',5)->where('parent_id',null)->where('status','active')
                      ->limit(4)
                      ->get(['id','name','content']);

      collect($galleries)->map(function($item){
        $item->image_url = asset($item->image());
        unset($item->imageFile);
        $item->hoverimage_url = asset($item->banner());
        unset($item->bannerFile);
        return $item;
      });

      $bannerGroupThree =PostExtra::latest()->where('type',4)->where('parent_id',null)->where('status','active')
                       ->where('data_type','Banner Ads Group Three')
                       ->get();

      $largeBannerOne =PostExtra::latest()->where('type',4)->where('parent_id',null)->where('status','active')
                       ->where('data_type','Large Banner One')
                       ->get();
      $largeBannerTwo =PostExtra::latest()->where('type',4)->where('parent_id',null)->where('status','active')
                       ->where('data_type','Large Banner Two')
                       ->get();

      $categoryGroupOne =PostExtra::latest()->where('type',4)->where('parent_id',null)->where('status','active')
                       ->where('data_type','Category Product Group One')
                       ->get();

      $categoryGroupTwo =PostExtra::latest()->where('type',4)->where('parent_id',null)->where('status','active')
                       ->where('data_type','Category Product Group Two')
                       ->get();

      $timeOfferBanner =PostExtra::latest()->where('type',4)->where('parent_id',null)->where('status','active')
                       ->where('data_type','Time Offer Banner')
                       ->where('data_limit','>',0)
                       ->whereDate('created_at','<=',Carbon::now())
                       ->first();
      if($timeOfferBanner){
        $timeOfferBanner->createdAt =$timeOfferBanner->created_at->addDays($timeOfferBanner->data_limit)->format('Y-m-d');
        $timeOfferBanner->link = $timeOfferBanner->image_link?:null;
        $timeOfferBanner->image_url = asset($timeOfferBanner->image());
        unset($timeOfferBanner->imageFile);
      }


        $popupActive =PostExtra::where('type',6)->where('status','active')->first();
      if($popupActive){
        $popupActive->image =asset($popupActive->image());
      }

      $featuredText =PostExtra::where('type',7)->first();
      $sliders =array();
      if($slider =slider('Front Page Slider')){
          foreach($slider->subSliders as $slider){
              if(deviceMode()=='mobile'){
                $slider->image =asset($slider->banner());
              }else{
                $slider->image =asset($slider->image());
              }

              $sliders[]=[
                  'image'=>$slider->image,
                  'title'=>$slider->name,
                  'description'=>$slider->description,
                  'button_text'=>$slider->seo_title,
                  'button_link'=>$slider->seo_description,
              ];
          }
      }

      $clients =Attribute::latest()->where('type',3)->where('status','active')
                ->limit(12)->get(['id','name','short_description']);

      collect($clients)->map(function($item){
        $item->rating =5;
        $item->image_url = asset($item->image());
        unset($item->imageFile);
        return $item;
      });

       $meta=[
         'title'=>general()->meta_title,
         'description'=>general()->meta_description,
         'keywords'=>general()->meta_keyword,
         'image'=>general()->logo_url,
         'url'=>route('index'),
       ];


      return Inertia::render('Welcome',compact('popupActive','pixelData','meta','sliders','clients','blogs','latestProducts','topProducts','trandingProducts','bannerGroupOne','timeOfferBanner','galleries', 'promotions'));
    }


    public function promotion(Request $r,$slug){

        $promotions =Attribute::latest()->where('type',14)->where('status','active')
                    ->where('parent_id',null)
                    // ->where('fetured',true)
                    ->where(function($q){
                      if($q->getModel()->start_date && $q->getModel()->end_date){
                          $q->whereDate('start_date','>=',Carbon::now())->whereDate('end_date','<=',Carbon::now());
                      }elseif($q->getModel()->start_date){
                          $q->whereDate('start_date','>=',Carbon::now());
                      }elseif($q->getModel()->end_date){
                          $q->whereDate('end_date','<=',Carbon::now());
                      }
                    })
                    ->where('slug',$slug)
                    ->select(['id','name','slug','start_date','end_date','location'])
                    ->first();

        if(!$promotions){
            return abort(404);
        }

        $promotions->image_url = $promotions->imageFile?asset($promotions->image()):null;
        $promotions->image_link =null;

        $products =$promotions->couponProducts()->where('for_website',true)->limit(12)->get(['id','name','slug','final_price','regular_price','variation_status','discount_type','discount','brand_id']);

        collect($products)->map(function($item){
            $item->finalPrice = priceFullFormat($item->offerPrice());
            $item->image_url = asset($item->image());
            $item->wishListStatus = $item->isWl();
            $item->discountPercent = $item->discountPercent();
            $item->rating = $item->productRating();

            if($item->offerPrice() < $item->regular_price){
              $item->regularPrice =  priceFullFormat($item->regularPrice());
            }else{
              $item->regularPrice = null;
            }

            if($item->galleryFiles->count() > 0){
              $item->hoverImage_url = asset($item->galleryFiles->first()->file_url);
            }else{
              $item->hoverImage_url = asset($item->image());
            }
            unset($item->imageFile);
            unset($item->galleryFiles);
            return $item;
          });

        $promotions->products =$products;

         return Inertia::render('Promotions', compact('promotions'));


    }

    public function productCategory(Request $r,$slug){
      $category =Attribute::latest()->where('type',0)->where('slug',$slug)->first();
      if(!$category){
          return abort('404');
      }

        $pixelData =[];
        if(Auth::check() && (Auth::id()=='663')){
            //Facebook Concersation API

            $eventId =uniqid('page_');

            $pixelData = facebookPixelData('PageView',$eventId, [
                'page_name' => $category->name
            ]);

            $data = sendEvent('PageView', $eventId, [
                    'page_name' => $category->name
                ]);

        }
        $category->meta_image =$category->imageFile?asset($category->image()):null;


      $parentCtgs =array();

      if($pCtg =$category->parent){
        if($p2Ctg =$pCtg->parent){
          if($p3Ctg =$p2Ctg->parent){
            if($p4Ctg =$p3Ctg->parent){
              if($p5Ctg =$p4Ctg->parent){
                $parentCtgs[] =['name'=>$p5Ctg->name,'slug'=>$p5Ctg->slug];
              }
              $parentCtgs[] =['name'=>$p4Ctg->name,'slug'=>$p4Ctg->slug];
            }
            $parentCtgs[] =['name'=>$p3Ctg->name,'slug'=>$p3Ctg->slug];
          }
          $parentCtgs[] =['name'=>$p2Ctg->name,'slug'=>$p2Ctg->slug];
        }
        $parentCtgs[]=['name'=>$pCtg->name,'slug'=>$pCtg->slug];
      }

      $category->parentCtgs=$parentCtgs;

      $attributes = Attribute::latest()->where('type', 9)
                      ->where('status', 'active')
                      // ->whereNotIn('id',[73,68])
                      ->whereNull('parent_id');

      $attributes = $attributes->whereHas('subCtgs', function ($q) use($category){
                              $q->whereHas('postsAttribute', function ($qq) use($category){
                                  $qq->where('posts.status', 'active')->whereHas('productCtgs',function($qqq) use($category){
                                      $qqq->where('reff_id',$category->id);
                                  });
                              });
                          })->select(['id','name','parent_id','created_at'])->get();
                          collect($attributes)->map(function($item){
                            $item->subAttr =$item->subAttributes()->get(['id', 'name']);
                            unset($item->subAttributes);
                            return $item;
                          });


      $subCtg=$category->subctgs()->where('status', 'active')->get(['id', 'name']);


      $query = Post::where('status','active')->where('for_website',true)->whereHas('ctgProducts',function($q) use($category){
          $q->where('reff_id',$category->id);
        })
        ->select(['id','name','slug','final_price','regular_price','variation_status','discount_type','discount','brand_id','sale_label'])
        ->whereDate('created_at','<=',date('Y-m-d'));

      $products = $query->latest()->paginate(12);

      collect($products->items())->map(function($item){
        $item->finalPrice = priceFullFormat($item->offerPrice());
        $item->wishListStatus = $item->isWl();
        $item->discountPercent = $item->discountPercent();
        $item->rating = $item->productRating();
        $item->sale_label = $item->sale_label?true:false;

        if($item->offerPrice() < $item->regular_price){
          $item->regularPrice =  priceFullFormat($item->regularPrice());
        }else{
          $item->regularPrice = null;
        }

        $item->image_url = asset($item->image());
        if($item->galleryFiles->count() > 0){
          $item->hoverImage_url = asset($item->galleryFiles->first()->file_url);
        }else{
          $item->hoverImage_url = asset($item->image());
        }
        unset($item->imageFile);
        unset($item->galleryFiles);
        return $item;
      });

      // Get min and max final_price
      $maxPrice = round($query->max('max_price'));

    return Inertia::render('ProductCategory', compact('category','pixelData','products','subCtg','attributes','maxPrice'));
  }

    public function offerProduct(Request $r){

          $offerCtgProducts=[];
                if($r->category){
                    $ctg =Attribute::where('type',0)->where('status','active')->where('slug',$r->category)->first();
                    if(!$ctg){
                        return abort('404');
                    }

                    $query = Post::where('status','active')->where('for_website',true)
                        ->whereHas('ctgProducts',function($q) use($ctg){
                          $q->where('reff_id',$ctg->id);
                        })
                        ->where(function($q) {

                            $q->where(function($qq) {
                                $qq->where('variation_status', false)->where('discount', '>', 0);
                            });


                            $q->orWhere(function($qq) {
                                $qq->where('variation_status', true)
                                  ->whereHas('productVariationAttributeItems', function($q3) {
                                      $q3->where('discount', '>', 0);
                                  });
                            });
                        })
                        ->select(['id','name','slug','final_price','regular_price','variation_status','discount_type','discount','brand_id','sale_label'])
                        ->whereDate('created_at','<=',date('Y-m-d'));

                      $products = $query->latest()->paginate(12)->appends(['category'=>$r->category]);


                      collect($products->items())->map(function($item){
                        $item->finalPrice = priceFullFormat($item->offerPrice());
                        $item->wishListStatus = $item->isWl();
                        $item->discountPercent = $item->discountPercent();
                        $item->rating = $item->productRating();
                        $item->sale_label = $item->sale_label?true:false;

                        if($item->offerPrice() < $item->regular_price){
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
                    // return $products;
                    $offerCtgProducts= [
                        'ctg_name' => $ctg->name,
                        'ctg_slug' => $ctg->slug ?: 'no-title',
                        'products'=>$products,
                    ];
                    return Inertia::render('OfferProductCtg', compact('products','offerCtgProducts'));

                }else{

                    $menu =menu('Offer Category');
                    if($menu){
                        foreach($menu->subMenus()->where('menu_type',3)->get() as $ctgItem){
                            $ctg =$ctgItem->productCtglink;
                            if($ctg && $ctg->status=='active'){

                                $query = Post::where('status','active')->where('for_website',true)
                                    ->whereHas('ctgProducts',function($q) use($ctg){
                                      $q->where('reff_id',$ctg->id);
                                    })
                                    ->where(function($q) {

                                        $q->where(function($qq) {
                                            $qq->where('variation_status', false)->where('discount', '>', 0);
                                        });


                                        $q->orWhere(function($qq) {
                                            $qq->where('variation_status', true)
                                              ->whereHas('productVariationAttributeItems', function($q3) {
                                                  $q3->where('discount', '>', 0);
                                              });
                                        });
                                    })
                                    ->select(['id','name','slug','final_price','regular_price','variation_status','discount_type','discount','brand_id','sale_label'])
                                    ->whereDate('created_at','<=',date('Y-m-d'));

                                  $products = $query->latest()->limit(4)->get();


                                  collect($products)->map(function($item){
                                    $item->finalPrice = priceFullFormat($item->offerPrice());
                                    $item->wishListStatus = $item->isWl();
                                    $item->discountPercent = $item->discountPercent();
                                    $item->rating = $item->productRating();
                                    $item->sale_label = $item->sale_label?true:false;

                                    if($item->offerPrice() < $item->regular_price){
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

                                $offerCtgProducts[]=[
                                        'ctg_name'=>$ctg->name,
                                        'ctg_slug'=>$ctg->slug,
                                        'products'=>$products,
                                    ];
                            }
                        }
                    }
                }




return Inertia::render('OfferProduct2', compact('offerCtgProducts'));


            $attributes = Attribute::latest()->where('type', 9)
                          ->where('status', 'active')
                          // ->whereNotIn('id',[73,68])
                          ->whereNull('parent_id');

            $attributes = $attributes->whereHas('subCtgs', function ($q){
                                  $q->whereHas('postsAttribute', function ($qq){
                                      $qq->where('posts.status', 'active');
                                  });
                              })->select(['id','name','parent_id','created_at'])->get();
                              collect($attributes)->map(function($item){
                                $item->subAttr =$item->subAttributes()->get(['id', 'name']);
                                unset($item->subAttributes);
                                return $item;
                              });


          $query = Post::where('status','active')->where('for_website',true)
            ->where(function($q) {

                $q->where(function($qq) {
                    $qq->where('variation_status', false)->where('discount', '>', 0);
                });


                $q->orWhere(function($qq) {
                    $qq->where('variation_status', true)
                      ->whereHas('productVariationAttributeItems', function($q3) {
                          $q3->where('discount', '>', 0);
                      });
                });
            })
            ->select(['id','name','slug','final_price','regular_price','variation_status','discount_type','discount','brand_id','sale_label'])
            ->whereDate('created_at','<=',date('Y-m-d'));

          $products = $query->latest()->paginate(12);


          collect($products->items())->map(function($item){
            $item->finalPrice = priceFullFormat($item->offerPrice());
            $item->wishListStatus = $item->isWl();
            $item->discountPercent = $item->discountPercent();
            $item->rating = $item->productRating();
            $item->sale_label = $item->sale_label?true:false;

            if($item->offerPrice() < $item->regular_price){
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

          // Get min and max final_price
          $maxPrice = round($query->max('max_price'));



        return Inertia::render('OfferProduct', compact('products','attributes','maxPrice'));
      }

//     public function productFilterCategory(Request $r,$slug){

//       $category =Attribute::latest()->where('type',0)->where('slug',$slug)->first();
//       if($category){
//         $ctgIds[]=$category->id;
//       }else{
//         $ctgIds=array();
//       }

//       if($r->category){
//         $ctgIds=explode(",", $r->category);
//       }

//       $query = Post::where('type',2)->where('status','active')->where('for_website',true)->where(function($qq)use($r,$category,$ctgIds){
//             if($category){
//               $qq->whereHas('ctgProducts',function($q) use($ctgIds){
//                 $q->whereIn('reff_id',$ctgIds);
//               });
//             }
//         })
//         ->where(function($qq)use($r){

//           if($r->search){
//             $qq->where(function($q) use($r){
//               $q->where('name','LIKE','%'.$r->search.'%');
//               $q->orWhereHas('productCategories',function($qq) use($r){
//                   $qq->where('name','LIKE','%'.$r->search.'%');
//               });
//             });
//           }

//           if($r->min_price || $r->max_price){

//               $qq->where(function($query) use ($r) {

//                   if ($r->min_price) {
//                       $query->where('min_price', '>=', $r->min_price);
//                   }

//                   if ($r->max_price) {
//                       $query->where('max_price', '<=', $r->max_price);
//                   }
//               });
//           }
//           if($r->fabric){
//               $qq->whereHas('productAttibutes',function($qqq)use($r){
//                 $options=explode(",", $r->fabric);
//                   $qqq->whereIn('parent_id',$options);
//               });
//           }

//         })
//         ->select(['id','name','slug','final_price','regular_price','variation_status','discount_type','discount','brand_id','sale_label'])
//         ->whereDate('created_at','<=',date('Y-m-d'));
//       if($r->sort_by=='high'){
//         $products = $query->orderBy('final_price','desc')->paginate(12);
//       }else if($r->sort_by=='low'){

//         $products = $query->orderBy('final_price','asc')->paginate(12);

//       }else{

//         $products = $query->latest()->paginate(12);
//       }

//       collect($products->items())->map(function($item){
//         $item->finalPrice = priceFullFormat($item->offerPrice());
//         $item->wishListStatus = $item->isWl();
//         $item->discountPercent = $item->discountPercent();
//         $item->rating = $item->productRating();

//         $item->sale_label = $item->sale_label?true:false;

//         if($item->offerPrice() < $item->regular_price){
//           $item->regularPrice =  priceFullFormat($item->regularPrice());
//         }else{
//           $item->regularPrice = null;
//         }

//         $item->image_url = asset($item->image());
//         if($item->galleryFiles->count() > 0){
//           $item->hoverImage_url = asset($item->galleryFiles->first()->file_url);
//         }else{
//           $item->hoverImage_url = asset($item->image());
//         }
//         unset($item->imageFile);
//         unset($item->galleryFiles);
//         return $item;
//       });

//       return Response()->json([
//         'success' => true,
//         'products' => $products,
//       ]);
//   }



 public function productFilterCategory(Request $r, $slug)
{
    $category = Attribute::latest()
        ->where('type', 0)
        ->where('slug', $slug)
        ->first();

    $ctgIds = $category ? [$category->id] : [];

    if ($r->category) {
        $ctgIds = explode(",", $r->category);
    }

    $query = Post::where('type', 2)
        ->where('status', 'active')
        ->where('for_website', true)
        ->whereDate('created_at', '<=', date('Y-m-d'))
        ->where(function ($qq) use ($r, $category, $ctgIds) {
            if ($category) {
                $qq->whereHas('ctgProducts', function ($q) use ($ctgIds) {
                    $q->whereIn('reff_id', $ctgIds);
                });
            }
        })
        ->where(function ($qq) use ($r) {
            if ($r->search) {
                $qq->where(function ($q) use ($r) {
                    $q->where('name', 'LIKE', '%' . $r->search . '%')
                      ->orWhereHas('productCategories', function ($qq) use ($r) {
                          $qq->where('name', 'LIKE', '%' . $r->search . '%');
                      });
                });
            }

            if ($r->min_price || $r->max_price) {
                $qq->where(function ($query) use ($r) {
                    if ($r->min_price) {
                        $query->where('min_price', '>=', $r->min_price);
                    }
                    if ($r->max_price) {
                        $query->where('max_price', '<=', $r->max_price);
                    }
                });
            }

            if ($r->fabric) {
                $qq->whereHas('productAttibutes', function ($qqq) use ($r) {
                    $options = explode(",", $r->fabric);
                    $qqq->whereIn('parent_id', $options);
                });
            }
        })
        ->select(['id', 'name', 'slug', 'final_price', 'regular_price', 'variation_status', 'discount_type', 'discount', 'brand_id', 'sale_label']);

    // Sorting
    if ($r->sort_by == 'high') {
        $products = $query->orderBy('final_price', 'desc')->paginate(12)->withQueryString();
    } elseif ($r->sort_by == 'low') {
        $products = $query->orderBy('final_price', 'asc')->paginate(12)->withQueryString();
    } else {
        $products = $query->latest()->paginate(12)->withQueryString();
    }

    // Format each product item
    $products->getCollection()->transform(function ($item) {
        $item->finalPrice = priceFullFormat($item->offerPrice());
        $item->wishListStatus = $item->isWl();
        $item->discountPercent = $item->discountPercent();
        $item->rating = $item->productRating();
        $item->sale_label = (bool) $item->sale_label;
        $item->regularPrice = $item->offerPrice() < $item->regular_price
            ? priceFullFormat($item->regularPrice())
            : null;
        $item->image_url = asset($item->image());
        $item->hoverImage_url = $item->galleryFiles->count()
            ? asset($item->galleryFiles->first()->image())
            : asset($item->image());

        unset($item->imageFile, $item->galleryFiles);

        return $item;
    });

    $filters = $r->only(['search', 'category', 'min_price', 'max_price', 'fabric', 'sort_by', 'page']);


      $parentCtgs =array();

      if($pCtg =$category->parent){
        if($p2Ctg =$pCtg->parent){
          if($p3Ctg =$p2Ctg->parent){
            if($p4Ctg =$p3Ctg->parent){
              if($p5Ctg =$p4Ctg->parent){
                $parentCtgs[] =['name'=>$p5Ctg->name,'slug'=>$p5Ctg->slug];
              }
              $parentCtgs[] =['name'=>$p4Ctg->name,'slug'=>$p4Ctg->slug];
            }
            $parentCtgs[] =['name'=>$p3Ctg->name,'slug'=>$p3Ctg->slug];
          }
          $parentCtgs[] =['name'=>$p2Ctg->name,'slug'=>$p2Ctg->slug];
        }
        $parentCtgs[]=['name'=>$pCtg->name,'slug'=>$pCtg->slug];
      }

       $category->parentCtgs=$parentCtgs;

      $attributes = Attribute::latest()->where('type', 9)
                      ->where('status', 'active')
                      // ->whereNotIn('id',[73,68])
                      ->whereNull('parent_id');

      $attributes = $attributes->whereHas('subCtgs', function ($q) use($category){
            $q->whereHas('postsAttribute', function ($qq) use($category){
                $qq->where('posts.status', 'active')->whereHas('productCtgs',function($qqq) use($category){
                    $qqq->where('reff_id',$category->id);
                });
            });
        })->select(['id','name','parent_id','created_at'])->get();
        collect($attributes)->map(function($item){
          $item->subAttr =$item->subAttributes()->get(['id', 'name']);
          unset($item->subAttributes);
          return $item;
        });


      $subCtg=$category->subctgs()->where('status', 'active')->get(['id', 'name']);


    // ✅ If it's a fetch (AJAX) request → return JSON
    if ($r->expectsJson()) {
        return response()->json([
            'success' => true,
            'products' => $products,
        ]);
    }

    // ✅ If it's an Inertia page load → return Inertia page
    return Inertia::render('ProductCategory', [
        'category' => $category,
        'products' => $products,
        'filters' => $filters,
        'attributes' => $attributes,
        'subCtg' => $subCtg,
    ]);
}




    public function productBrand($slug){
        $brand =Attribute::latest()->where('type',2)->where('slug',$slug)->first();
          if(!$brand){
            return abort('404');
          }


          if($brand->subbrands()->where('status','active')->count() > 0){
              $subBrands =$brand->subbrands()->where('status','active')->select(['id','name','slug','parent_id'])->paginate(100);

              // return view(welcomeTheme().'products.brandsList',compact('brand','subBrands'));
          }

          if($brand->parent_id==null){
          $products = Post::latest()->where('brand_id',$brand->id);
          }else{
          $products = Post::latest()->where('subbrand_id',$brand->id);
          }


          $products =$products->where(function($qq){
            $qq->where('status','active')->where('for_website',true);
          })
          //->select(['id','name','slug','addedby_id','created_at'])
          ->whereDate('created_at','<=',date('Y-m-d'))
          ->paginate(12);



        // return view(welcomeTheme().'products.brandProducts',compact('brand','products'));
    }

    public function productView($slug){
        $product =Post::latest()->where('type',2)->where('slug',$slug)->first();
        if(!$product){
            return abort('404');
        }


            $pixelData =[];
            $pixelData2 =[];
            if(Auth::check() && (Auth::id()=='663')){

                $eventId =uniqid('page_');
                $pixelData = facebookPixelData('PageView',$eventId, [
                    'page_name' => 'Content View'
                ]);

                $data = sendEvent('PageView', $eventId, [
                    'page_name' => 'Content View'
                ]);


                $eventId2 =uniqid('viewcontent_');
                $pixelData2 = facebookPixelData('ViewContent',$eventId2, [
                    'content_type' => 'product',
                    'content_ids'   => $product->id,
                    'content_name' => $product->name,
                    'value'        => $product->offerPrice(),
                    'currency'     => 'BDT',
                ]);

                sendEvent('ViewContent', $eventId2, [
                    'content_type' => 'product',
                    'content_id'   => $product->id,
                    'content_name' => $product->name,
                    'value'        => $product->offerPrice(),
                    'currency'     => 'BDT',
                ]);
            }

        $product->finalPrice = priceFullFormat($product->offerPrice());
        if($product->offerPrice() < $product->regular_price){
          $product->regularPrice =  priceFullFormat($product->regularPrice());
        }else{
          $product->regularPrice = null;
        }
        $product->image_url = asset($product->image());
        $images = [];
        $images[] = asset($product->image());
        foreach($product->galleryFiles as $item){
          $images[] =asset($item->file_url);
        }

        $product->specifications =$product->getSpecifications();
        $product->brandName =$product->brand?$product->brand->name:null;
        $product->totalReview =$product->reviewTotal();
        $product->rating = $product->productRating();
        $product->wishListStatus = $product->isWl();

        $ctgs =array();

        foreach($product->productCategories as $ctg){
          $ctgs[]=['name'=>$ctg->name, 'slug'=>$ctg->slug?:'no-title'];
        }
        $product->ctgs= $ctgs;

        $product->images =$images;

        $product->video =['image_url'=>$product->bannerFile?asset($product->banner()):null,'video_url'=>$product->video_link?asset($product->video_link):null];

         $product->productContact="01831999899(bkash), 01611634423";
        $product->deliverySystem="inside dhaka city cash on delivery,delivery charge-50 taka, outside dhaka delivery charge -100 taka, delivery location outside dhaka hole delivery charge 100tk advance bkash korte hobe and product er price cash on delivery.
        ঢাকার ভিতরে ডেলিভারি চার্জ ৫০/- টাকা। ঢাকার বাইরে ১০০/- টাকা।  ঠিকানা যদি ঢাকার বাইরে হয় তবে  ১০০/- টাকা অগ্রিম বিকাশ/নগদ করতে হবে* ( যদি প্রথম মেঘে অর্ডার করে থাকেন)। পন্যের টাকা ক্যাশঅন হোম ডেলিভারি। দয়া করে পণ্য ডেলিভারির সময় ডেলিভারি ম্যান সামনে থাকা অবস্থায় চেক করে গ্রহণ করবেন এবং পণ্য পছন্দ না হলে ডেলিভারি চার্জ দিয়ে রিটার্ন করতে পারবেন (যদি আগে ডেলিভারি চার্চ না দিয়ে থাকেন)।ডেলিভারি ম্যানের সামনে চেক করার সুযোগ না পেলে,  বাসায় গিয়ে চেক করে পছন্দ না হলে রিটার্ন করা ঝামেলা তবে চেন্জ করা যাবে। আমাদের দিক থেকে কোনো রকম সমস্যা হলে কোন সার্ভিস চার্জ ছাড়াই চেন্জ করে দিয়া হবে। সে ক্ষেত্রে সরাসরি আমাদের সাথে যোগাযোগ করবেন। SMS না করে সরাসরি এই নাম্বারে কল করবেন। 01831999 899-01611634423।
        ";

        unset($product->imageFile);
        unset($product->galleryFiles);
        unset($product->ctgProducts);
        unset($product->productCategories);

        $selectVariation = [];
        if($varia =$product->productVariationAttributeItems()->whereHas('attributeVatiationItems')->where('stock_status',true)->first()){
            foreach($varia->attributeVatiationItems as $item){
              $selectVariation[$item->attribute_id] = (string) $item->attribute_item_id;
            }
        }

        $variation =array();
        foreach($product->productAttibutesVariationGroup() as $ii=>$attri){
          $variItems =array();
          foreach($product->productVariationAttributeItemsList()->whereHas('attributeItem')->where('attribute_id',$attri->id)->select('attribute_item_id')->groupBy('attribute_item_id')->get() as $k=>$sku){
            $variItems[]=[
              'id' =>(int) $sku->attribute_item_id,
              'title' => $sku->attributeItemValue(),
            ];
          }

          $variation[] = [
              'id' => $attri->id,
              'title' => $attri->name,
              'type' => $attri->view,
              'items' => $variItems

          ];

        }

        $product->variations =$variation;


        $proDatas = $product->productVariationAttributeItems()->get(['id', 'src_id', 'reguler_price', 'discount', 'final_price', 'quantity', 'stock_status']);
        $datas = [];
        foreach ($proDatas as $data) {
            // $attributeItemIds = $data->attributeVatiationItems()->get(['attribute_item_id']);
            $attributeItemIds=[];
            foreach($data->attributeVatiationItems as $aitem){

            $attributeItemIds[]=[
                'attribute_item_id'=>(int) $aitem->attribute_item_id,
                ];
            }


            $status=false;
            if($data->stock_status){
                if($data->quantity > 0){
                    $status=true;
                }
            }

            $datas[] = [
                'price' => $data->showPrice(),
                'image' => asset($data->variationImage()),
                'stock_status' => $status,
                'quantity' => (int)$data->quantity,
                'items' => $attributeItemIds
            ];
        }


        $product->variationDatas =$datas;


        $relatedProducts = $product->relatedProducts()->where('for_website',true)->limit(6)->get();


        collect($relatedProducts)->map(function($item){
          $item->finalPrice = priceFullFormat($item->offerPrice());
          $item->wishListStatus = $item->isWl();
          $item->discountPercent = $item->discountPercent();
          $item->rating = $item->productRating();

          $item->sale_label = $item->sale_label?true:false;

          if($item->offerPrice() < $item->regular_price){
            $item->regularPrice =  priceFullFormat($item->regularPrice());
          }else{
            $item->regularPrice = null;
          }

          $item->image_url = asset($item->image());
          if($item->galleryFiles->count() > 0){
            $item->hoverImage_url = asset($item->galleryFiles->first()->file_url);
          }else{
            $item->hoverImage_url = asset($item->image());
          }
          unset($item->imageFile);
          unset($item->galleryFiles);
          return $item;
        });

      $reviews =$product->productReviews()->latest()->where('status','active')
                ->select(['id','created_at','addedby_id','rating','content'])
                ->paginate(5);

      collect($reviews->items())->map(function($item){
        $item->name = $item->user?$item->user->name:'Unknown';
        $item->createdAt = $item->created_at->format('F d, Y');
        unset($item->user);
        return $item;
      });

        $structuredData = [
            "@context" => "https://schema.org",
            "@type" => "Product",
            "productID" => $product->id,
            "name" => $product->name,
            "description" => strip_tags($product->description),
            "url" => route('productView',$product->slug),
            "image" => $product->image_url,
            "brand" => [
                "@type" => "Brand",
                "name" => $product->brandName?:'PosherBD'
            ],
            "offers" => [
                "@type" => "Offer",
                "price" => $product->offerPrice(),
                "priceCurrency" => general()->currency,
                "itemCondition" => "https://schema.org/NewCondition",
                "availability" => "https://schema.org/InStock",
                "url" => route('productView',$product->slug),
            ],
            "additionalProperty" => [
                "@type" => "PropertyValue",
                "propertyID" => "item_group_id",
                "value" => $product->slug ?: 'no-title',
            ]
        ];

      $meta=[
        'title'=>$product->seo_title?:$product->name,
        'description'=>$product->seo_description?:general()->meta_description,
        'keywords'=>$product->seo_keyword?:general()->meta_keyword,
        'image'=>$product->image_url,
        'brand'=>$product->brandName,
        'stock'=>'In Stock',
        'condition'=>'new',
        'price'=>$product->offerPrice(),
        'sale_price'=>$product->offerPrice(),
        'currency'=>general()->currency,
        'images'=>$product->images,
        'item_group_id'=>$product->slug ?:'no-title',
        'url'=>route('productView', $product->slug ?:'no-title'),
        'structuredData'=>$structuredData,
      ];




      return Inertia::render('ProductDetail', compact('meta','pixelData','pixelData2','product','relatedProducts','reviews','selectVariation'));


    }

    public function blogCategory($slug){
      $category =Attribute::latest()->where('type',6)->where('slug',$slug)->first();
      if(!$category){
        return abort('404');
      }

      $blogs = $category->activePosts()->latest()
      ->select(['id','name','slug','created_at'])
      ->paginate(12);

      collect($blogs->items())->map(function($item){
        $item->createdAt = $item->created_at->format('F d, Y');
        $item->image_url = asset($item->image());
        unset($item->imageFile);
        return $item;
      });

      $recentBlogs = Post::latest()
        ->where('type',1)
        ->where('status','active')
        ->whereDate('created_at','<=',Carbon::now())
        ->limit(5)
        ->get(['id','name','slug','created_at']);

      collect($recentBlogs)->map(function($item){
        $item->createdAt = $item->created_at->format('F d, Y');
        $item->image_url = asset($item->image());
        unset($item->imageFile);
        return $item;
      });

      $categories =Attribute::latest()->where('type',6)->where('status','active')->where('parent_id',null)->limit(10)->get(['id','name','slug']);
      $tags = Attribute::latest()
      ->where('type', 7)
      ->where('status', 'active')
      ->where('parent_id', null)
      ->limit(10)
      ->inRandomOrder()
      ->get(['id', 'name', 'slug']);

      return Inertia::render('BlogCategory', compact('category','blogs','tags','categories','recentBlogs'));

    }

    public function blogTag($slug){
      $tag =Attribute::latest()->where('type',7)->where('slug',$slug)->first();
      if(!$tag){
        return abort('404');
      }

      $blogs = Post::whereHas('tagPosts',function($q) use($tag){
        $q->where('reff_id',$tag->id);
      })
      ->where(function($qq){
        $qq->where('status','active');
      })
      ->whereDate('created_at','<=',date('Y-m-d'))
      ->select(['id','name','slug','created_at'])
      ->paginate(12);

      collect($blogs->items())->map(function($item){
        $item->createdAt = $item->created_at->format('F d, Y');
        $item->image_url = asset($item->image());
        unset($item->imageFile);
        return $item;
      });


      $recentBlogs = Post::latest()
        ->where('type',1)
        ->where('status','active')
        ->whereDate('created_at','<=',Carbon::now())
        ->limit(5)
        ->get(['id','name','slug','created_at']);

      collect($recentBlogs)->map(function($item){
        $item->createdAt = $item->created_at->format('F d, Y');
        $item->image_url = asset($item->image());
        unset($item->imageFile);
        return $item;
      });

      $categories =Attribute::latest()->where('type',6)->where('status','active')->where('parent_id',null)->limit(10)->get(['id','name','slug']);
      $tags = Attribute::latest()
      ->where('type', 7)
      ->where('status', 'active')
      ->where('parent_id', null)
      ->limit(10)
      ->inRandomOrder()
      ->get(['id', 'name', 'slug']);

      return Inertia::render('BlogTag', compact('tag','blogs','tags','categories','recentBlogs'));

    }

    public function blogAuthor($id,$slug){
      $author =User::find($id);
      if(!$author){
        return abort('404');
      }
      $posts =$author->posts()->latest()->where('type',1)->where('status','active')
      ->select(['id','name','slug','short_description','addedby_id','created_at'])
      ->whereDate('created_at','<=',date('Y-m-d'))
      ->paginate(10);
      // return view(welcomeTheme().'blogs.authorPosts',compact('author','posts'));

    }

    public function blogView($slug){
      $blog =Post::where('type',1)->where('slug',$slug)->first();
      if(!$blog){
        return abort('404');
      }
      $blog->image_url = asset($blog->image());
      $blog->createdAt = $blog->created_at->format('F d, Y');
      $blog->authorName = $blog->user?$blog->user->name:'Unknown';

      $postCtg=array();
      foreach($blog->postCategories as $ctg){
        $postCtg[] =[
          'name'=>$ctg->name,
          'slug'=>$ctg->slug,
        ];
      }
      $blog->postCtg= $postCtg;

      unset($blog->user);
      unset($blog->imageFile);
      unset($blog->postCategories);

      $relatedBlog =$blog->relatedPosts()
      ->limit(4)->select(['id','name','slug','short_description','addedby_id','created_at'])->get();
      collect($relatedBlog)->map(function($item){
        $item->createdAt = $item->created_at->format('F d, Y');
        $item->image_url = asset($item->image());
        unset($item->imageFile);
        return $item;
      });
      $comments =$blog->postComments()->where('status','active')->select(['id','name','content','created_at'])->paginate(10);

      $recentBlogs = Post::latest()
        ->where('type',1)
        ->where('status','active')
        ->whereDate('created_at','<=',Carbon::now())
        ->limit(5)
        ->whereNot('id',$blog->id)
        ->get(['id','name','slug','created_at']);

      collect($recentBlogs)->map(function($item){
        $item->createdAt = $item->created_at->format('F d, Y');
        $item->image_url = asset($item->image());
        unset($item->imageFile);
        return $item;
      });

      $categories =Attribute::latest()->where('type',6)->where('status','active')->where('parent_id',null)->limit(10)->get(['id','name','slug']);
      $tags = Attribute::latest()
      ->where('type', 7)
      ->where('status', 'active')
      ->where('parent_id', null)
      ->limit(10)
      ->inRandomOrder()
      ->get(['id', 'name', 'slug']);

      $meta=[
        'title'=>$blog->seo_title?:$blog->name,
        'description'=>$blog->seo_description?:general()->meta_description,
        'keywords'=>$blog->seo_keyword?:general()->meta_keyword,
        'image'=>$blog->image_url,
        'url'=>route('blogView', $blog->slug ?:'no-title'),
      ];

      return Inertia::render('BlogDetail', compact('meta','blog','relatedBlog','tags','categories','recentBlogs','comments'));

    }

    public function blogSearch(Request $r){

      $blogs =Post::latest()->where('type',1)->where('status','active')
      ->where(function($q) use ($r) {
        if($r->blog_search){
          $q->where('name','LIKE','%'.$r->blog_search.'%');
        }
      })
      ->select(['id','name','slug','created_at'])
      ->whereDate('created_at','<=',date('Y-m-d'))
      ->paginate(10)->appends([
        'blog_search'=>$r->blog_search,
      ]);

      collect($blogs->items())->map(function($item){
        $item->createdAt = $item->created_at->format('F d, Y');
        $item->image_url = asset($item->image());
        unset($item->imageFile);
        return $item;
      });

      $recentBlogs = Post::latest()
        ->where('type',1)
        ->where('status','active')
        ->whereDate('created_at','<=',Carbon::now())
        ->limit(5)
        ->get(['id','name','slug','created_at']);

      collect($recentBlogs)->map(function($item){
        $item->createdAt = $item->created_at->format('F d, Y');
        $item->image_url = asset($item->image());
        unset($item->imageFile);
        return $item;
      });

      $categories =Attribute::latest()->where('type',6)->where('status','active')->where('parent_id',null)->limit(10)->get(['id','name','slug']);
      $tags = Attribute::latest()
      ->where('type', 7)
      ->where('status', 'active')
      ->where('parent_id', null)
      ->limit(10)
      ->inRandomOrder()
      ->get(['id', 'name', 'slug']);

      return Inertia::render('BlogSearch', compact('blogs','tags','categories','recentBlogs'));

    }

    public function blogComments(Request $r,$slug){
      $post =Post::where('type',1)->where('slug',$slug)->first();
      if(!$post){
        return abort('404');
      }

      $check = $r->validate([
          'name' => 'required|max:100',
          'email' => 'required|max:100',
          'website' => 'required|max:100',
          'comment' => 'required|max:1000',
      ]);

      $comments =new Review();

      if(Auth::check()){
      $comments->addedby_id=Auth::id();
      }
      $comments->src_id=$post->id;
      $comments->type=1;
      $comments->name=$r->name;
      $comments->email=$r->email;
      $comments->website=$r->website;
      $comments->content=$r->comment;
      $comments->save();

      Session()->flash('success','Your Comments successfully Submitted.');

      return back();


    }


    public function pageView($slug){
      $page =Post::latest()->where('type',0)->where('slug',$slug)->first();
      if(!$page){
        return abort('404');
      }
      //If deferent Design or Condition Page Return by ID.

      //Font Home Page
      if($page->template=='Front Page'){
        return redirect()->route('index');
      }

      //Contact Us Page
      if($page->template=='Contact Us'){
        return Inertia::render('ContactUs', compact('page'));
      }

      //Track Your Page
      if($page->template=='Track Order'){
        return Inertia::render('TrackYourOrder', compact('page'));
      }

      //About Us Page
      if($page->template=='About Us'){
        return Inertia::render('AboutUs', compact('page'));
      }

      //Latest Blog Page
      if($page->template=='Latest Blog'){
        $blogs = Post::latest()->where('type',1)->where('status','active')
        ->select(['id','name','slug','short_description','addedby_id','created_at'])
        ->whereDate('created_at','<=',date('Y-m-d'))
        ->paginate(12);

        collect($blogs->items())->map(function($item){
          $item->createdAt = $item->created_at->format('F d, Y');
          $item->image_url = asset($item->image());
          unset($item->imageFile);
          return $item;
        });

        $recentBlogs = Post::latest()
        ->where('type',1)
        ->where('status','active')
        ->whereDate('created_at','<=',Carbon::now())
        ->limit(5)
        ->get(['id','name','slug','created_at']);

      collect($recentBlogs)->map(function($item){
        $item->createdAt = $item->created_at->format('F d, Y');
        $item->image_url = asset($item->image());
        unset($item->imageFile);
        return $item;
      });

      $categories =Attribute::latest()->where('type',6)->where('status','active')->where('parent_id',null)->limit(10)->get(['id','name','slug']);
      $tags = Attribute::latest()
      ->where('type', 7)
      ->where('status', 'active')
      ->where('parent_id', null)
      ->limit(10)
      ->inRandomOrder()
      ->get(['id', 'name', 'slug']);

        return Inertia::render('Blog', compact('page','blogs','tags','categories','recentBlogs'));
      }

      //Latest Services Page
      if($page->template=='Latest Products'){
        $products =Post::latest()->where('type',2)
          ->where('status','active')
          ->whereDate('created_at','<=',Carbon::now())
          ->select(['id','name','slug','final_price','regular_price','variation_status','discount_type','discount','brand_id','sale_label'])
          ->paginate(16);

          collect($products->items())->map(function($item){
            $item->finalPrice = priceFullFormat($item->offerPrice());
            $item->wishListStatus = $item->isWl();
            $item->discountPercent = $item->discountPercent();
            $item->rating = $item->productRating();

            $item->sale_label = $item->sale_label?true:false;

            if($item->offerPrice() < $item->regular_price){
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
        //   return $products;
        return Inertia::render('ProductAll', compact('page','products'));
      }

      return Inertia::render('PageView', compact('page'));

    }

    public function contactMail(Request $r){

      $rules = [
        'name' => 'required|max:100',
        'email' => 'required|max:100',
        'message' => 'nullable|max:500',
        'mobile' => 'nullable|max:500',
      ];

      $validator = Validator::make($r->all(), $rules);

      if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $validator->messages(), // Send errors separately
        ], 400); // Use 400 for client-side validation errors
      }

      if(general()->mail_status && general()->mail_from_address){
            //Mail Data
            $datas =array('r'=>$r);
            $template ='mails.ContactMail';
            $toEmail ='rabiulk449@gmail.com'; //general()->mail_from_address;
            $toName =general()->mail_from_name;
            $subject ='Contact Mail Form '.general()->title;
            sendMail($toEmail,$toName,$subject,$datas,$template);
        }

      return response()->json([
          'success' => true,
          'message' => 'Your form has been sent successfully. We will respond as soon as possible.',
      ]);


      Session()->flash('success','Your Form send successfully done. We are response as soon as possible.');
      return back();
    }

    public function inquerySend(Request $r,$slug){

        $product =Post::latest()->where('type',2)->where('slug',$slug)->first();
        if(!$product){
            return abort('404');
        }

        $check = $r->validate([
          'name' => 'required|max:100',
          'mobile' => 'required|max:100',
          'email' => 'nullable|max:100',
          'message' => 'required|max:500',
        ]);

        if(general()->mail_status && general()->mail_from_address){
            //Mail Data
            $datas =array('r'=>$r,'product'=>$product);
            $template ='mails.enquireMail';
            $toEmail =general()->mail_from_address;
            $toName =general()->mail_from_name;
            $subject ='Enquery Mail Form '.general()->title;
            sendMail($toEmail,$toName,$subject,$datas,$template);
        }

      Session()->flash('success','Your Inquery send successfully done. We are response as soon as possible.');
      return back();
    }

    public function search(Request $r){
      $category =Attribute::latest()->where('type',0)->where('status','active')->find($r->category_id);
      if($category){
        $subCtg=$category->subctgs()->where('status', 'active')->get(['id', 'name']);
      }else{
        $subCtg =array();
      }


      $query = Post::where('type',2)->where('status','active')->where('for_website',true)->where(function($qq)use($r,$category){
          if($category){
            $qq->whereHas('ctgProducts',function($q) use($category){
              $q->where('reff_id',$category->id);
            });
          }

          if($r->search){
            $qq->where(function($q) use($r){
              $q->where('name','LIKE','%'.$r->search.'%');
              $q->orWhere('id','LIKE','%'.$r->search.'%');
              $q->orWhereHas('productCategories',function($qq) use($r){
                  $qq->where('name','LIKE','%'.$r->search.'%');
              });
            });
          }

        })
        ->select(['id','name','slug','final_price','regular_price','variation_status','discount_type','discount','brand_id','sale_label'])
        ->whereDate('created_at','<=',date('Y-m-d'));





      $products = $query->latest()->paginate(12);



      collect($products->items())->map(function($item){
        $item->finalPrice = priceFullFormat($item->offerPrice());
        $item->wishListStatus = $item->isWl();
        $item->discountPercent = $item->discountPercent();
        $item->rating = $item->productRating();

        $item->sale_label = $item->sale_label?true:false;

        if($item->offerPrice() < $item->regular_price){
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


      if($r->autoSearch){
        return Response()->json([
          'results' => $products,
        ]);
      }

      if($category){

        $attributes = Attribute::latest()->where('type', 9)
                        ->where('status', 'active')
                        // ->whereNotIn('id',[73,68])
                        ->whereNull('parent_id');

        $attributes = $attributes->whereHas('subCtgs', function ($q) use($category){
                                  $q->whereHas('postsAttribute', function ($qq) use($category){
                                    $qq->where('posts.status', 'active')->whereHas('productCtgs',function($qqq) use($category){
                                      $qqq->where('reff_id',$category->id);
                                    });
                                  });
                            })->select(['id','name','parent_id','created_at'])->get();

        collect($attributes)->map(function($item){
          $item->subAttr =$item->subAttributes()->get(['id', 'name']);
          unset($item->subAttributes);
          return $item;
        });

      }else{
        $attributes =array();
      }

      // Get min and max final_price
      $maxPrice = round($query->max('max_price'));

      return Inertia::render('ProductSearch', compact('products','subCtg','category','attributes','maxPrice'));

    }



    public function orderTracking(Request $r){
      $order =array();
      if($r->orderNumber){



      $order=Order::latest()->where('invoice',$r->orderNumber)->first();
      if($order){
      $order->grandTotal=priceFullFormat($order->grand_total);
        $order->subTotal=priceFullFormat($order->total_price);
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
              'id'=>$cart->id,
              'productName'=>$cart->product_name,
              'productImage'=>$cart->product?asset($cart->product->image()):null,
              'finalPrice'=>priceFullFormat($cart->price),
              'quantity'=>$cart->quantity,
              'subTotal'=>priceFullFormat($cart->final_price),
              'variants'=>$variant,
            ];
            unset($cart->product);

        }
        $order->cartItems=$cartItems;
        unset($order->items);
      }

      return Response()->json([
                  'order' => $order,
                  'status' => $order?1:2,

                ]);

      }

      return Inertia::render('TrackYourOrder', compact('order'));

    }

    public function subscribe(Request $r){

      if(filter_var($r->email, FILTER_VALIDATE_EMAIL)){
        $subscribe =PostExtra::latest()->where('type',1)->where('name',$r->email)->first();

        if(!$subscribe){
            $subscribe =new PostExtra();
            $subscribe->type=1;
            $subscribe->name=$r->email;
            $subscribe->save();
          $status=true;
          $message ='You Are Successfully Subsribe.';
        }else{
          $status=true;
          $message ='You Are Already Subsribe.Thank You.';
        }


      }else{
        $status=false;
        $message ='Error: Email Are Not validated';
      }

      return Response()->json([
              'success' => $status,
              'message' => $message,
            ]);


      Session()->flash($status?'success':'error',$message);
      return redirect()->back();

    }





}
