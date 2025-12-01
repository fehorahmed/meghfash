<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Str;
use Hash;
use File;
use DB;
use Session;
use Cookie;
use Validator;
use Redirect,Response;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Post;
use App\Models\Transaction;
use App\Models\CashHistory;
use App\Models\PostExtra;
use App\Models\Review;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Expense;
use App\Models\General;
use App\Models\Country;
use App\Models\Media;
use App\Models\Attribute;
use App\Models\Permission;
use App\Models\PostAttribute;
use GuzzleHttp\Client;

use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function dashboard(){
        

            
        ///Reports  Summery Dashboard
        $productsCount=Post::where('type',2)
        ->where('status','active')
        ->count();

        $customer=User::where('status','<>',2)->where('customer',true)->where('admin',false)->count();
        $admin=User::where('status','<>',2)->where('customer',true)->where('admin',true)->count();

        $pagesTotal=Post::where('type',0)->where('status','active')->count();

        $todayStockIn=OrderItem::whereHas('order',function($q){
          $q->whereIn('order_type',['purchase_order','order_return','wholesale_return'])
            ->whereNotIn('order_status',['temp','pending','cancelled'])
            ->whereDate('created_at', Carbon::now());
        })
        ->get();
        
        $totalDueSale = Order::whereIn('order_type', ['customer_order', 'wholesale_order', 'pos_order'])
            ->where('due_amount', '>', 0.99)
            ->when(true, function($q){
                $q->where(function($q){
                    // customer_order rules
                    $q->where(function($cq){
                        $cq->where('order_type', 'customer_order')
                           ->whereNotIn('order_status', ['delivered','temp','pending','cancelled','returned']);
                    });
        
                    // wholesale_order rules
                    $q->orWhere(function($wq){
                        $wq->where('order_type', 'wholesale_order')
                           ->whereNotIn('order_status', ['temp','pending','cancelled','returned']);
                    });
        
                    // pos_order rules
                    $q->orWhere(function($pq){
                        $pq->where('order_type', 'pos_order')
                           ->whereNotIn('order_status', ['temp','pending','cancelled']);
                    });
                });
            });
            

          $totalDueSale =$totalDueSale->sum('due_amount');


        
        $todayStockSale=OrderItem::whereHas('order',function($q){
          $q->whereIn('order_type',['customer_order','wholesale_order','pos_order'])
            ->whereNotIn('order_status',['temp','pending','cancelled'])
            ->whereDate('created_at', Carbon::now());
        })
        ->get();

        $todaySale=Order::latest()->where('order_type','customer_order')
        ->whereNotIn('order_status',['temp','pending','cancelled'])
        
        ->whereDate('created_at', Carbon::now())
        ->sum('grand_total');
        
        $todayWholesale=Order::latest()->where('order_type','wholesale_order')
        ->whereNotIn('order_status',['temp','pending','cancelled'])
        
        ->whereDate('created_at', Carbon::now())
        ->sum('grand_total');
        
        $todayStockPurchase=Order::latest()->where('order_type','purchase_order')
        ->whereNotIn('order_status',['temp','pending','cancelled'])
        
        ->whereDate('created_at', Carbon::now())
        ->sum('grand_total');
        
        $todayReturnSale=Order::latest()->where('order_type','order_return')
        ->whereNotIn('order_status',['temp','pending','cancelled'])
        
        ->whereDate('created_at', Carbon::now())
        ->sum('grand_total');
        
        $monthlytSale=Order::latest()->where('order_type','customer_order')
        ->whereNotIn('order_status',['temp','pending','cancelled'])
        ->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->sum('grand_total');
        
        $yearlySale=Order::latest()->where('order_type','customer_order')
        ->whereNotIn('order_status',['temp','pending','cancelled'])
        ->whereYear('created_at', Carbon::now()->year)
        ->sum('grand_total');
        
        $orderTotal = DB::table('orders')
        ->where('order_type','customer_order')
        ->selectRaw('count(*) as total')
        ->selectRaw("count(case when order_status = 'pending' then 1 end) as pending")
        ->selectRaw("count(case when order_status = 'confirmed' then 1 end) as confirmed")
        ->selectRaw("count(case when order_status = 'delivered' then 1 end) as delivered")
        ->first();
        
        $todayExpense=Expense::latest()->whereDate('created_at', Carbon::now())->sum('amount');
        
        $totalItems=Post::where('type',2)
        ->where('status','active')
        ->count();
        
        $totalStockOutItem=Post::where('type',2)
        ->where('status','active')
        ->where('quantity',0)
        ->count();
        
        $totalLowStockOutItem=Post::where('type',2)
        ->where('status','active')
        ->where('quantity','<',5)
        ->count();
        
        $totalStock=Post::where('type',2)
        ->where('status','active')
        ->where('variation_status',false)
        ->sum('quantity');
        
        
        $totalStockData =Post::where('type',2)->where('status','active')
                    ->where('variation_status',true)
                    ->select(['id','name'])
                    ->whereHas('productVariationAttributeItems')
                    ->withsum('productVariationActiveAttributeItems','quantity')
                    ->get();
        $totalStock +=$totalStockData->sum('product_variation_active_attribute_items_sum_quantity');
        
        $posSale = DB::table('orders')->where('order_type','pos_order')->where('order_status','delivered')->whereDate('created_at', Carbon::now())->get();
        
        
        
        
        $reports=array(
                    "product"=>$productsCount,
                    "customer"=>$customer,
                    "admin"=>$admin,
                    "pages"=>$pagesTotal,
                    "todaySale"=>$todaySale,
                    "todayWholesale"=>$todayWholesale,
                    "todayStockPurchase"=>$todayStockPurchase,
                    "todayReturnSale"=>$todayReturnSale,
                    "monthlytSale"=>$monthlytSale,
                    "yearlySale"=>$yearlySale,
                    "todayExpense"=>$todayExpense,
                    "totalStock"=>$totalStock,
                    "totalItems"=>$totalItems,
                    "totalStockOutItem"=>$totalStockOutItem,
                    "totalLowStockOutItem"=>$totalLowStockOutItem,
                    "totalDueSale"=>$totalDueSale,
                    "todayStockSale"=>$todayStockSale->sum('quantity'),
                    "todayStockSaleItem"=>$todayStockSale->unique('product_id')->count(),
                    "todayStockIn"=>$todayStockIn->sum('quantity'),
                    "todayStockInItem"=>$todayStockIn->unique('product_id')->count(),
                    "posOrder"=>$posSale->count(),
                    "posSale"=>$posSale->sum('grand_total'),
                );
        ///Reports  Summery Dashboard
        
        $products =Post::latest()->where('type',2)->where('status','<>','temp')->paginate(10);

        return view(adminTheme().'dashboard',compact('reports','products','orderTotal'));
      
    }


    public function myProfile(Request $r){
        
        
      $user =Auth::user();
      if($r->isMethod('post')){
        
        if($r->actionType=='profile'){
          $check = $r->validate([
            'name' => 'required|max:100|unique:users,name,'.$user->id,
            'email' => 'required|max:100|unique:users,email,'.$user->id,
            'mobile' => 'nullable|max:20|unique:users,mobile,'.$user->id,
            'gender' => 'nullable|max:10',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|max:191',
            'division' => 'nullable|numeric',
            'district' => 'nullable|numeric',
            'city' => 'nullable|numeric',
            'postal_code' => 'nullable|max:20',
            'profile' => 'nullable|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          ]);
          
          $user->name =$r->name;
          $user->mobile =$r->mobile;
          $user->email =$r->email;
          $user->gender =$r->gender;
          $user->dob =$r->date_of_birth;
          $user->profile =$r->profile;
          $user->address_line1 =$r->address;
          $user->division =$r->division;
          $user->district =$r->district;
          $user->city =$r->city;
          $user->postal_code =$r->postal_code;
          ///////Image UploadStart////////////
          if($r->hasFile('image')){
            $file =$r->image;
            $src  =$user->id;
            $srcType  =6;
            $fileUse  =1;
            $author=Auth::id();
            
            $loadImage =uploadFile($file,$src,$srcType,$fileUse,$author);
            // //Resize Image 
            // $w=250;
            // $h=250;
            // $type='md';
            // $this->resizeImage($loadImage,$type,$w,$h);
            
            // //Resize Image 
            // $w=50;
            // $h=50;
            // $type='sm';
            // $this->resizeImage($loadImage,$type,$w,$h);
            
            // //Resize Image 
            // $w=400;
            // $h=400;
            // $type='lg';
            // $this->resizeImage($loadImage,$type,$w,$h);
            
          }
          ///////Image Upload End////////////
          $user->save();
  
          Session()->flash('success','Your Updated Are Successfully Done!');
  
        }
        if($r->actionType=='change-password'){
  
          $check = $r->validate([
              'old_password' => 'required|string|min:8',
              'password' => 'required|string|min:8|confirmed|different:old_password',
          ]);
  
          if(Hash::check($r->old_password, $user->password)){
            $user->password_show=$r->password;
            $user->password=Hash::make($r->password);
            $user->update();
            Session()->flash('success','Your Are Successfully Done');
          }else{
            Session()->flash('error','Current Password Are Not Match');
          }
        }
        return back();
      }
        
      return view(adminTheme().'users.myProfile',compact('user'));
      
    }
  //Medias Library Route
  public function medies(Request $r){

    //Check Authorized User
    $allPer = empty(json_decode(Auth::user()->permission->permission, true)['medies']['all']);

    //Media Delete All Selected Images Start
    if($r->actionType=='allDelete'){

      $check = $r->validate([
          'mediaid.*' => 'required|numeric',
      ]);

      for ($i=0; $i < count($r->mediaid); $i++) { 
        $media =Media::find($r->mediaid[$i]);
        if($media){

          if($allPer && $media->addedby_id!=Auth::id()){
            //You are unauthorized Try!!;
          }else{

            if(File::exists($media->file_url)){
                File::delete($media->file_url);
            }
            $media->delete();

          }

        }
      }

      Session()->flash('success','Your Are Successfully Deleted');
      return redirect()->back();
    }

    //Media Delete All Selected Images End


    $medies =Media::latest()->where('src_type',0)
    ->where(function($q) use ($r,$allPer) {

      // Check Permission
      if($allPer){
        $q->where('addedby_id',auth::id()); 
      }

    })
    ->select(['id','file_url','file_size','file_type','file_name','alt_text','caption','description','addedby_id'])
    ->paginate(50);

    if($r->ajax())
      {

          return Response()->json([
              'success' => true,
              'view' => View(adminTheme().'medies.includes.mediesAll',[
                  'medies'=>$medies
              ])->render()
          ]);
      }

    return view(adminTheme().'medies.medies',compact('medies'));
  }

  public function mediesCreate(Request $r){

      $check = $r->validate([
          'images.*' => 'required|file|mimes:jpeg,png,jpg,gif,svg,webp,pdf,docx,zip,rar,mp4,webm,mov,wmv,mp3|max:25600',
      ]);

      if(!$check){
          Session::flash('error','Need To validation');
          return back();
      }   

     $files=$r->file('images');
      if($files){
          foreach($files as $file){

              $file =$file;
              $src  =null;
              $srcType  =0;
              $fileUse  =0;
              $fileStatus=false;
              $author=Auth::id();
              uploadFile($file,$src,$srcType,$fileUse,$author,$fileStatus);
              
          }
      }

    Session()->flash('success','Your Are Successfully Done');
     return redirect()->back();
     
  }

  public function mediesEdit(Request $r, $id){
    $media =Media::find($id);
    if(!$media){
      Session()->flash('error','This File Are Not Found');
      return redirect()->back();
    }

    if($media->src_type==0){
      //Check Authorized User
      $allPer = empty(json_decode(Auth::user()->permission->permission, true)['medies']['all']);
      if($allPer && $media->addedby_id!=Auth::id()){
        Session()->flash('error','You are unauthorized Try!!');
        return redirect()->route('admin.medies');
      }
    }

    if($r->isMethod('post')){
         $media->alt_text=$r->alt_text;
         $media->caption=$r->caption;
         $media->description=$r->description;
         $media->editedby_id=auth::id();
         $media->save();
         Session()->flash('success','Your Are Successfully Done');
         return redirect()->back();
    }

    return view(adminTheme().'medies.mediaImageEdit',compact('media'));
  }

  public function mediesDelete(Request $request,$id){

     if($request->ajax())
    {
   
    $media =Media::find($id);
    if(!$media){
      Session()->flash('error','This File Are Not Found');
     return Response()->json([
              'success' => false
          ]);
     }
     
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
    $media->delete();
      return Response()->json([
              'success' => true
          ]);
    }      

  }

    //Medias Library Route End


    // Page Management Function Start
    
    public function pages(Request $r){

      $allPer = empty(json_decode(Auth::user()->permission->permission, true)['pages']['all']);
        // Filter Action Start
  
      if($r->action){
        if($r->checkid){
  
        $datas=Post::latest()->where('type',0)->whereIn('id',$r->checkid)->get();
  
        foreach($datas as $data){
          if($allPer && $data->addedby_id!=Auth::id()){
            // You are unauthorized Try!!
          }else{
  
            if($r->action==1){
              $data->status='active';
              $data->save();
            }elseif($r->action==2){
              $data->status='inactive';
              $data->save();
            }elseif($r->action==3){
              $data->fetured=true;
              $data->save();
            }elseif($r->action==4){
              $data->fetured=false;
              $data->save();
            }elseif($r->action==5){
              //Page Extra Data Delete
              PostExtra::where('type',0)->where('src_id',$data->id)->delete();
              
              //Page Media File Delete
              $medias =Media::latest()->where('src_type',1)->where('src_id',$data->id)->get();
              foreach($medias as $media){
                if(File::exists($media->file_url)){
                  File::delete($media->file_url);
                }
                $media->delete();
              }
  
              $data->delete();
  
            }
  
          }
  
  
        }
  
        Session()->flash('success','Action Successfully Completed!');
  
        }else{
          Session()->flash('info','Please Need To Select Minimum One Post');
        }
  
        return redirect()->back();
      }
  
      //Filter Action End
  
      $pages=Post::latest()->where('type',0)->where('status','<>','temp')
      ->where(function($q) use ($r,$allPer) {
  
          if($r->search){
              $q->where('name','LIKE','%'.$r->search.'%');
          }
          
          if($r->startDate || $r->endDate)
          {
              if($r->startDate){
                  $from =$r->startDate;
              }else{
                  $from=Carbon::now()->format('Y-m-d');
              }
  
              if($r->endDate){
                  $to =$r->endDate;
              }else{
                  $to=Carbon::now()->format('Y-m-d');
              }
  
              $q->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);
  
          }
  
          if($r->status){
             $q->where('status',$r->status); 
          }
  
        // Check Permission
        if($allPer){
         $q->where('addedby_id',auth::id()); 
        }
  
      })
      ->select(['id','name','slug','view','type','template','created_at','addedby_id','status','fetured'])
      ->paginate(25)->appends([
        'search'=>$r->search,
        'status'=>$r->status,
        'startDate'=>$r->startDate,
        'endDate'=>$r->endDate,
      ]);
  
      //Total Count Results
      $totals = DB::table('posts')->where('status','<>','temp')
      ->where('type',0)
      ->selectRaw('count(*) as total')
      ->selectRaw("count(case when status = 'active' then 1 end) as active")
      ->selectRaw("count(case when status = 'inactive' then 1 end) as inactive")
      ->first();
  
      return view(adminTheme().'pages.pagesAll',compact('pages','totals'));
  
    }
  
    public function pagesAction(Request $r,$action,$id=null){
  
      if($action=='create'){
          $page =Post::where('type',0)->where('status','temp')->where('addedby_id',Auth::id())->first();
          if(!$page){
            $page =new Post();
            $page->type =0;
            $page->status ='temp';
            $page->addedby_id =Auth::id();
          }
          $page->created_at =Carbon::now();
          $page->save();
    
          return redirect()->route('admin.pagesAction',['edit',$page->id]);
        }
        $page =Post::find($id);
        if(!$page){
          Session()->flash('error','This Page Are Not Found');
          return redirect()->route('admin.pages');
        }
  
        //Check Authorized User
        $allPer = empty(json_decode(Auth::user()->permission->permission, true)['pages']['all']);
        if($allPer && $page->addedby_id!=Auth::id()){
          Session()->flash('error','You are unauthorized Try!!');
          return redirect()->route('admin.pages');
        }
  
        if($action=='update' && $r->isMethod('post')){
  
          $check = $r->validate([
              'name' => 'required|max:200',
              'template' => 'nullable|max:100',
              'seo_title' => 'nullable|max:120',
              'seo_description' => 'nullable|max:200',
              'seo_keyword' => 'nullable|max:300',
              'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
              'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
          ]);
  
          $createDate = $r->created_at ? Carbon::parse($r->created_at . ' ' . Carbon::now()->format('H:i:s')) : Carbon::now();
 
          $page->name=$r->name;
          $page->short_description=$r->short_description;
          $page->description=$r->description;
          $page->seo_title=$r->seo_title;
          $page->seo_description=$r->seo_description;
          $page->seo_keyword=$r->seo_keyword;
          $page->template=$r->template?:null;
          ///////Image Upload Start////////////
          if($r->hasFile('image')){
            $file =$r->image;
            $src  =$page->id;
            $srcType  =1;
            $fileUse  =1;
            $author=Auth::id();
            uploadFile($file,$src,$srcType,$fileUse,$author);
          }
          ///////Image Upload End////////////
  
          ///////Image Upload Start////////////
          if($r->hasFile('banner')){
            $file =$r->banner;
            $src  =$page->id;
            $srcType  =1;
            $fileUse  =2;
            $author=Auth::id();
            uploadFile($file,$src,$srcType,$fileUse,$author);
          }
          ///////Image Upload End////////////

          $slug =Str::slug($r->name);
  
          if($slug==null){
            $page->slug=$page->id;
          }else{
            if(Post::where('type',0)->where('slug',$slug)->whereNotIn('id',[$page->id])->count() >0){
            $page->slug=$slug.'-'.$page->id;
            }else{
            $page->slug=$slug;
            }
          }
  
          if (!$createDate->isSameDay($page->created_at)) {
            $page->created_at = $createDate;
          }
          $page->status =$r->status?'active':'inactive';
          $page->fetured =$r->fetured?1:0;
          $page->editedby_id =Auth::id();
          $page->save();
          
          //Gallery posts
          if($r->galleries){
  
            $page->postTags()->whereNotIn('reff_id',$r->galleries)->delete();
  
            for ($i=0; $i < count($r->galleries); $i++) {
              $tag = $page->postTags()->where('reff_id',$r->galleries[$i])->first();
  
                if($tag){}else{
                $tag =new PostAttribute();
                $tag->type=2;
                $tag->src_id=$page->id;
                $tag->reff_id=$r->galleries[$i];
                }
                $tag->save();
           }
         }else{
          $page->postTags()->delete();
         }
          
          
          Session()->flash('success','Your Are Successfully Done');
          return redirect()->back();
  
        }
  
        if($action=='delete'){
          
          //Page Extra Data Delete
          PostExtra::where('type',0)->where('src_id',$page->id)->delete();
  
          //Page Media File Delete
          $medies =Media::where('src_type',1)->where('src_id',$page->id)->get();
          foreach ($medies as  $media) {
              if(File::exists($media->file_url)){
                  File::delete($media->file_url);
              }
              $media->delete();
          }
  
          //Page Delete
          $page->delete();
          Session()->flash('success','Your Are Successfully Done');
          return redirect()->back();
  
        }
  
        $extraDatas=PostExtra::where('src_id',$id)->get();
        
        $galleries=Attribute::latest()->where('type',4)->where('status','<>','temp')->where('parent_id',null)
        ->select(['id','name'])
        ->get();
  
        return view(adminTheme().'pages.pageEdit',compact('page','extraDatas','galleries'));
    }
  // Page Management Function End


//Clients Function

public function clients(Request $r){
      
      
      if(Auth::id()==1){

          
        //   $duplicateBarcodes = PostAttribute::select('barcode')
        //     ->groupBy('barcode')
        //     ->havingRaw('COUNT(barcode) > 1')
        //     ->pluck('barcode');
        
        // //  $duplicateData = PostAttribute::whereIn('barcode', $duplicateBarcodes)->get();
         
        //  $duplicateData = PostAttribute::whereIn('barcode', $duplicateBarcodes)->get();
        // return $duplicateData;
        //  foreach($duplicateData as $duplicateDat){
             
        //     $duplicateDat->barcode =$duplicateDat->updated_at->format('ymd').$duplicateDat->src_id.rand(1111,9999);
        //     $duplicateDat->save();

        //  }
            
            // return 'success';
            
        //  $duplicateData = PostAttribute::where('barcode')->get();
          
      }
      
      
  $allPer = empty(json_decode(Auth::user()->permission->permission, true)['clients']['all']);
  
  // Filter Action Start
  if($r->action){
    if($r->checkid){

    $datas=Attribute::latest()->where('type',3)->whereIn('id',$r->checkid)->get();

    foreach($datas as $data){
      if($allPer && $data->addedby_id!=Auth::id()){
        // You are unauthorized Try!!
      }else{

        if($r->action==1){
          $data->status='active';
          $data->save();
        }elseif($r->action==2){
          $data->status='inactive';
          $data->save();
        }elseif($r->action==3){
          $data->fetured=true;
          $data->save();
        }elseif($r->action==4){
          $data->fetured=false;
          $data->save();
        }elseif($r->action==5){
          
          $medias =Media::latest()->where('src_type',3)->where('src_id',$data->id)->get();
          foreach($medias as $media){
            if(File::exists($media->file_url)){
              File::delete($media->file_url);
            }
            $media->delete();
          }

          $data->delete();
        }

      }


    }

    Session()->flash('success','Action Successfully Completed!');

    }else{
      Session()->flash('info','Please Need To Select Minimum One Post');
    }

    return redirect()->back();
  }

  //Filter Action End

  $clients=Attribute::latest()->where('type',3)->where('status','<>','temp')
    ->where(function($q) use ($r,$allPer) {

      if($r->search){
          $q->where('name','LIKE','%'.$r->search.'%');
      }

      if($r->status){
         $q->where('status',$r->status); 
      }

      // Check Permission
      if($allPer){
       $q->where('addedby_id',auth::id()); 
      }

  })
  ->select(['id','name','slug','type','created_at','addedby_id','status','fetured'])
  ->paginate(25)->appends([
    'search'=>$r->search,
    'status'=>$r->status,
  ]);

  //Total Count Results
  $totals = DB::table('attributes')
  ->where('type',3)
  ->selectRaw('count(*) as total')
  ->selectRaw("count(case when status = 'active' then 1 end) as active")
  ->selectRaw("count(case when status = 'inactive' then 1 end) as inactive")
  ->first();

  return view(adminTheme().'clients.clientsAll',compact('clients','totals'));
}

public function clientsAction(Request $r,$action,$id=null){
  // Add Client Action Start
  if($action=='create'){

    $client =Attribute::where('type',3)->where('status','temp')->where('addedby_id',Auth::id())->first();
    if(!$client){
      $client =new Attribute();
    }
    $client->type =3;
    $client->status ='temp';
    $client->addedby_id =Auth::id();
    $client->save();

    return redirect()->route('admin.clientsAction',['edit',$client->id]);

  } 

  // Add Client Action End
  
  
  $client =Attribute::where('type',3)->find($id);
  if(!$client){
    Session()->flash('error','This Client Are Not Found');
    return redirect()->route('admin.clients');
  }

  //Check Authorized User
  $allPer = empty(json_decode(Auth::user()->permission->permission, true)['clients']['all']);
  if($allPer && $client->addedby_id!=Auth::id()){
    Session()->flash('error','You are unauthorized Try!!');
    return redirect()->route('admin.clients');
  }

  // Update Client Action Start
  if($action=='update'){
      $check = $r->validate([
        'name' => 'required|max:191',
        'seo_title' => 'nullable|max:200',
        'seo_desc' => 'nullable|max:250',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $client->name=$r->name;
    $client->short_description=$r->short_description;
    $client->description=$r->description;
    $client->seo_title=$r->seo_title;
    $client->short_description=$r->short_description;
    $client->seo_keyword=$r->seo_keyword;

    ///////Image UploadStart////////////
  
    if($r->hasFile('image')){
      $file =$r->image;
      $src  =$client->id;
      $srcType  =3;
      $fileUse  =1;
      $author=Auth::id();
      uploadFile($file,$src,$srcType,$fileUse,$author);
    }
    
    ///////Image Upload End////////////

    ///////Banner Upload End////////////

    if($r->hasFile('banner')){

      $file =$r->banner;
      $src  =$client->id;
      $srcType  =3;
      $fileUse  =2;
      $author=Auth::id();
      uploadFile($file,$src,$srcType,$fileUse,$author);

    }

    ///////Banner Upload End////////////

    $slug =Str::slug($r->name);
     if($slug==null){
      $client->slug=$client->id;
     }else{
      if(Attribute::where('type',3)->where('slug',$slug)->whereNotIn('id',[$client->id])->count() >0){
      $client->slug=$slug.'-'.$client->id;
      }else{
      $client->slug=$slug;
      }
    }

    $client->status =$r->status?'active':'inactive';
    $client->fetured =$r->fetured?1:0;
    $client->editedby_id =Auth::id();
    $client->save();

    Session()->flash('success','Your Are Successfully Updated');
    return redirect()->back();

  }

  // Update Client Action End


  // Delete Client Action Start
  if($action=='delete'){
    $medias =Media::latest()->where('src_type',3)->where('src_id',$client->id)->get();
    foreach($medias as $media){
      if(File::exists($media->file_url)){
        File::delete($media->file_url);
      }
      $media->delete();
    }

    $client->delete();

    Session()->flash('success','Your Are Successfully Deleted');
    return redirect()->route('admin.clients');

  }
  // Delete Client Action End

  return view(adminTheme().'clients.clientsEdit',compact('client'));
}

//Clients Function End

//Brands Function

public function brands(Request $r){

  $allPer = empty(json_decode(Auth::user()->permission->permission, true)['brands']['all']);

  // Filter Action Start
  if($r->action){
    if($r->checkid){

    $datas=Attribute::latest()->where('type',2)->whereIn('id',$r->checkid)->get();

    foreach($datas as $data){
      if($allPer && $data->addedby_id!=Auth::id()){
        // You are unauthorized Try!!
      }else{

        if($r->action==1){
          $data->status='active';
          $data->save();
        }elseif($r->action==2){
          $data->status='inactive';
          $data->save();
        }elseif($r->action==3){
          $data->fetured=true;
          $data->save();
        }elseif($r->action==4){
          $data->fetured=false;
          $data->save();
        }elseif($r->action==5){
          
          $medias =Media::latest()->where('src_type',3)->where('src_id',$data->id)->get();
          foreach($medias as $media){
            if(File::exists($media->file_url)){
              File::delete($media->file_url);
            }
            $media->delete();
          }

          $data->delete();
        }

      }

    }

    Session()->flash('success','Action Successfully Completed!');

    }else{
      Session()->flash('info','Please Need To Select Minimum One Post');
    }

    return redirect()->back();
  }

  //Filter Action End

  $brands=Attribute::latest()->where('type',2)->where('status','<>','temp')
    ->where(function($q) use ($r,$allPer) {

      if($r->search){
          $q->where('name','LIKE','%'.$r->search.'%');
      }


      if($r->status){
         $q->where('status',$r->status); 
      }

      // Check Permission
      if($allPer){
       $q->where('addedby_id',auth::id()); 
      }

  })
  ->select(['id','name','slug','type','created_at','parent_id','addedby_id','status','fetured'])
  ->paginate(25)->appends([
    'search'=>$r->search,
    'status'=>$r->status,
  ]);

  //Total Count Results
  $totals = DB::table('attributes')
  ->where('type',2)
  ->selectRaw('count(*) as total')
  ->selectRaw("count(case when status = 'active' then 1 end) as active")
  ->selectRaw("count(case when status = 'inactive' then 1 end) as inactive")
  ->first();

  return view(adminTheme().'brands.brandsAll',compact('brands','totals'));

}

public function brandsAction(Request $r,$action,$id=null){
  // Add Brand Action Start
  if($action=='create'){

    $brand =Attribute::where('type',2)->where('status','temp')->where('addedby_id',Auth::id())->first();
    if(!$brand){
      $brand =new Attribute();
    }
    $brand->type =2;
    $brand->status ='temp';
    $brand->addedby_id =Auth::id();
    $brand->save();

    return redirect()->route('admin.brandsAction',['edit',$brand->id]);
  } 
  // Add Brand Action End
  
  $brand =Attribute::where('type',2)->find($id);
  if(!$brand){
    Session()->flash('error','This Brand Are Not Found');
    return redirect()->route('admin.brands');
  }

  //Check Authorized User
  $allPer = empty(json_decode(Auth::user()->permission->permission, true)['brands']['all']);
  if($allPer && $brand->addedby_id!=Auth::id()){
    Session()->flash('error','You are unauthorized Try!!');
    return redirect()->route('admin.brands');
  }

  // Update Brand Action Start
  if($action=='update'){

      $check = $r->validate([
          'name' => 'required|max:191',
          'seo_title' => 'nullable|max:200',
          'seo_desc' => 'nullable|max:250',
          'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
          'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
      ]);

      $createDate = $r->created_at ? Carbon::parse($r->created_at . ' ' . Carbon::now()->format('H:i:s')) : Carbon::now();
      
      $brand->name=$r->name;
      $brand->short_description=$r->short_description;
      $brand->description=$r->description;
      $brand->seo_title=$r->seo_title;
      $brand->short_description=$r->short_description;
      $brand->seo_keyword=$r->seo_keyword;
      $brand->location=$r->font_family;
      
        if($r->parent_id==$brand->parent_id){}else{
          $brand->parent_id=$r->parent_id;
        }
      

       ///////Image UploadStart////////////

        if($r->hasFile('image')){
          $file =$r->image;
          $src  =$brand->id;
          $srcType  =3;
          $fileUse  =1;
          $author=Auth::id();
          uploadFile($file,$src,$srcType,$fileUse,$author);
        }
        
        ///////Image Upload End////////////

        ///////Banner Upload End////////////

        if($r->hasFile('banner')){

          $file =$r->banner;
          $src  =$brand->id;
          $srcType  =3;
          $fileUse  =2;
          $author=Auth::id();
          uploadFile($file,$src,$srcType,$fileUse,$author);

        }

        ///////Banner Upload End////////////

        $slug =Str::slug($r->name);
        if($slug==null){
          $brand->slug=$brand->id;
        }else{
          if(Attribute::where('type',2)->where('slug',$slug)->whereNotIn('id',[$brand->id])->count() >0){
          $brand->slug=$slug.'-'.$brand->id;
          }else{
          $brand->slug=$slug;
          }
        }
        $brand->status =$r->status?'active':'inactive';
        $brand->fetured =$r->fetured?1:0;
        $brand->editedby_id =Auth::id();
        if (!$createDate->isSameDay($brand->created_at)) {
            $brand->created_at = $createDate;
          }
        $brand->save();

        Session()->flash('success','Your Are Successfully Done');
        return redirect()->back();

  }
  // Update Brand Action Start

  // Delete Brand Action Start
  if($action=='delete'){
      $medias =Media::latest()->where('src_type',3)->where('src_id',$brand->id)->get();
        foreach($medias as $media){
          if(File::exists($media->file_url)){
            File::delete($media->file_url);
          }
          $media->delete();
        }

        $brand->delete();

        Session()->flash('success','Your Are Successfully Done');
        return redirect()->route('admin.brands');
  }
  // Delete Brand Action End
   
   $parents =Attribute::where('type',2)->where('parent_id',null)->get();

  return view(adminTheme().'brands.brandsEdit',compact('brand','parents'));
}

//Brands Function End

    //Sliders Function
    public function sliders(Request $r){

      $allPer = empty(json_decode(Auth::user()->permission->permission, true)['sliders']['all']);

      // Add Slider Action Start
      if($r->actionType=='addSlider'){
        $slider =Attribute::latest()->where('type',1)->where('addedby_id',Auth::id())->where('status','temp')->first();
        if(!$slider){
        $slider =new Attribute();
        $slider->type =1;
        $slider->status ='temp';
        $slider->addedby_id =Auth::id();
        $slider->save();
        }else{
        $slider->created_at =Carbon::now();
        $slider->save();
        }
        return redirect()->route('admin.slidersEdit',$slider->id);
      }
      // Add Slider Action End

      $sliders=Attribute::latest()->where('type',1)->where('status','<>','temp')->where('parent_id',null)
      ->where(function($q) use ($allPer) {
          // Check Permission
          if($allPer){
            $q->where('addedby_id',auth::id()); 
          }
      })
      ->select(['id','name','location','type','created_at','addedby_id','status','fetured'])
      ->paginate(25);

      

      return view(adminTheme().'sliders.slidersAll',compact('sliders'));
    }

    public function slidersAction(Request $r,$action,$id=null){
      //Create Slider Start
      if($action=='create'){
        $slider =Attribute::latest()->where('type',1)->where('addedby_id',Auth::id())->where('status','temp')->first();
        if(!$slider){
        $slider =new Attribute();
        $slider->type =1;
        $slider->status ='temp';
        $slider->addedby_id =Auth::id();
        $slider->save();
        }else{
        $slider->created_at =Carbon::now();
        $slider->save();
        }
        return redirect()->route('admin.slidersAction',['edit',$slider->id]);
      }
      //Create Slider End
      
      $slider =Attribute::where('type',1)->find($id);
      if(!$slider){
        Session()->flash('error','This Slider Are Not Found');
        return redirect()->route('admin.sliders');
      }

      //Check Authorized User
      $allPer = empty(json_decode(Auth::user()->permission->permission, true)['sliders']['all']);
      if($allPer && $slider->addedby_id!=Auth::id()){
        Session()->flash('error','You are unauthorized Try!!');
        return redirect()->route('admin.sliders');
      }

      // Update Slider Action Start
      if($action=='update'){

        $check = $r->validate([
            'name' => 'required|max:191',
            'location' => 'nullable|max:200',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:25600',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $activeSlider =Attribute::where('type',1)->where('location',$r->location)->whereNotIn('id',[$slider->id])->first();
      
        if($activeSlider && $r->location){
          Session::flash('error','This Location Have Already a slider');
          return back();
        }

        $slider->name=$r->name;
        $slider->description=$r->description;
        $slider->location=$r->location;
        $slider->seo_title=$r->vediolink;

        ///////Image UploadStart////////////

        if($r->hasFile('image')){
          $file =$r->image;
          $src  =$slider->id;
          $srcType  =3;
          $fileUse  =1;
          $author=Auth::id();
          uploadFile($file,$src,$srcType,$fileUse,$author);
        }
        
        ///////Image Upload End////////////

        ///////Banner Upload End////////////

        if($r->hasFile('banner')){

          $file =$r->banner;
          $src  =$slider->id;
          $srcType  =3;
          $fileUse  =2;
          $author=Auth::id();
          uploadFile($file,$src,$srcType,$fileUse,$author);

        }

        ///////Banner Upload End////////////

        ///////Gallery Images UploadStart////////////
        
        $files=$r->file('images');
        if($files){
          
            foreach($files as $file)
            {

              $slide =new Attribute();
              $slide->type =1;
              $slide->parent_id =$slider->id;
              $slide->status ='active';
              $slide->addedby_id =Auth::id();
              $slide->save();

              $src  =$slide->id;
              $srcType  =3;
              $fileUse  =1;
              $author  =Auth::id();
              uploadFile($file,$src,$srcType,$fileUse,$author);

            }
          } 

        ///////Slide Drag Update Start////////////
        if(isset($r->slideid)){
          for ($i=0; $i < count($r->slideid); $i++) { 
            $slide =$slider->sliderItems->find($r->slideid[$i]);
            if($slide){
              $slide->view=$i;
              $slide->save();
            }
          }
        }
        ///////Slide Drag Update End////////////

        $slug =Str::slug($r->name);
        if($slug==null){
          $slider->slug=$slider->id;
        }else{
          if(Attribute::where('type',1)->where('slug',$slug)->whereNotIn('id',[$slider->id])->count() >0){
          $slider->slug=$slug.'-'.$slider->id;
          }else{
          $slider->slug=$slug;
          }
        }
        $slider->status =$r->status?'active':'inactive';
        $slider->editedby_id =Auth::id();
        $slider->save();

        Session()->flash('success','Your Are Successfully Done');
        return redirect()->back();

      }
      // Update Slider Action End

      // Delete Slider Action Start
      if($action=='delete'){
          //Sub Slider Items Delete
          foreach($slider->sliderItems as $slide){

            //Galleries  Media File Delete
              $medies =Media::where('src_type',3)->where('src_id',$slide->id)->get();
              foreach ($medies as  $media) {
                  if(File::exists($media->file_url)){
                      File::delete($media->file_url);
                  }
                  $media->delete();
              }

            $slide->delete();

          }

        //Galleries  Media File Delete
        $sliderMedies =Media::where('src_type',3)->where('src_id',$slider->id)->get();
        foreach ($sliderMedies as  $media) {
              if(File::exists($media->file_url)){
                  File::delete($media->file_url);
              }
              $media->delete();
          }

        $slider->delete();

        Session()->flash('success','Your Are Successfully Deleted');
        return redirect()->route('admin.sliders');

      }
      // Delete Slider Action End

      return view(adminTheme().'sliders.slidersEdit',compact('slider'));
    }

    public function slideAction(Request $r,$action,$id){
      $slide =Attribute::where('type',1)->find($id);
      if(!$slide){
        Session()->flash('error','This Slide Are Not Found');
        return redirect()->route('admin.sliders');
      }

      // Update Slide Slider Action Start
      if($action=='update'){
          $check = $r->validate([
              'name' => 'nullable|max:191',
              'buttonText' => 'nullable|max:200',
              'buttonLink' => 'nullable|max:200',
              'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
              'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
          ]);

        $slide->name =$r->name;
        $slide->seo_title=$r->buttonText?:null;
        $slide->seo_description=$r->buttonLink?:null;
        $slide->description=$r->description;

        ///////Image UploadStart////////////

        if($r->hasFile('image')){
          $file =$r->image;
          $src  =$slide->id;
          $srcType  =3;
          $fileUse  =1;
          $author  =Auth::id();
          uploadFile($file,$src,$srcType,$fileUse,$author);
        }
        
        ///////Image Upload End////////////
        
        ///////Banner UploadStart////////////

        if($r->hasFile('banner')){
          $file =$r->banner;
          $src  =$slide->id;
          $srcType  =3;
          $fileUse  =2;
          $author  =Auth::id();
          uploadFile($file,$src,$srcType,$fileUse,$author);
        }
        
        ///////Banner Upload End////////////

        $slug =Str::slug($r->name);
        if($slug==null){
          $slide->slug=$slide->id;
        }else{
          if(Attribute::where('type',1)->where('slug',$slug)->whereNotIn('id',[$slide->id])->count() >0){
          $slide->slug=$slug.'-'.$slide->id;
          }else{
          $slide->slug=$slug;
          }
        }
        $slide->status =$r->status?'active':'inactive';
        $slide->editedby_id =Auth::id();
        $slide->save();

        Session()->flash('success','Your Are Successfully Done');
        return redirect()->back();

      }
      // Update Slide Slider Action End

      // Delete Slide Slider Action Start
      if($action=='delete'){
        //Galleries  Media File Delete
        $medies =Media::where('src_type',3)->where('src_id',$slide->id)->get();
          foreach ($medies as  $media) {
              if(File::exists($media->file_url)){
                  File::delete($media->file_url);
              }
              $media->delete();
          }
        $slide->delete();
        Session()->flash('success','Your Are Successfully Deleted');
        return redirect()->back();
      }
      // Delete Slide Slider Action End


      return  view(adminTheme().'sliders.slideEdit',compact('slide'));
    }

    //Sliders Function End


    //Galleries Function Start

    public function galleries(Request $r){

      $allPer = empty(json_decode(Auth::user()->permission->permission, true)['galleries']['all']);

      $galleries=Attribute::latest()->where('type',4)->where('status','<>','temp')->where('parent_id',null)
      ->where(function($q) use ($allPer) {
          // Check Permission
          if($allPer){
            $q->where('addedby_id',auth::id()); 
          }
      })
      ->select(['id','name','location','type','created_at','addedby_id','status','fetured'])
      ->paginate(25);
      return view(adminTheme().'galleries.galleriesAll',compact('galleries'));

    }

    public function galleriesAction(Request $r,$action,$id=null){

      //Create Gallery Start
      if($action=='create'){
        $gallery =Attribute::latest()->where('type',4)->where('addedby_id',Auth::id())->where('status','temp')->first();
        if(!$gallery){
        $gallery =new Attribute();
        $gallery->type =4;
        $gallery->status ='temp';
        $gallery->addedby_id =Auth::id();
        $gallery->save();
        }else{
        $gallery->created_at =Carbon::now();
        $gallery->save();
        }
        return redirect()->route('admin.galleriesAction',['edit',$gallery->id]);
      }
      //Create Gallery End

      $gallery =Attribute::where('type',4)->find($id);
      if(!$gallery){
        Session()->flash('error','This Gallery Are Not Found');
        return redirect()->route('admin.galleries');
      }

      //Check Authorized User
      $allPer = empty(json_decode(Auth::user()->permission->permission, true)['galleries']['all']);
      if($allPer && $gallery->addedby_id!=Auth::id()){
        Session()->flash('error','You are unauthorized Try!!');
        return redirect()->route('admin.galleries');
      }

      //Update Gallery Start
      if($action=='update'){

        $check = $r->validate([
            'name' => 'required|max:191',
            'location' => 'nullable|max:200',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:25600',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        // $activeGallery =Attribute::where('type',4)->where('location',$r->location)->whereNotIn('id',[$gallery->id])->first();
      
        // if($activeGallery && $r->location){
        //   Session::flash('error','This Location Have Already a Gallery');
        //   return back();
        // }
        
        $gallery->name=$r->name;
        $gallery->description=$r->description;
        $gallery->location=$r->location;

        ///////Image UploadStart////////////

        if($r->hasFile('image')){
          $file =$r->image;
          $src  =$gallery->id;
          $srcType  =3;
          $fileUse  =1;
          $author =Auth::id();
          uploadFile($file,$src,$srcType,$fileUse,$author);
        }
        ///////Image Upload End////////////

        ///////Banner Upload End////////////

        if($r->hasFile('banner')){

          $file =$r->banner;
          $src  =$gallery->id;
          $srcType  =3;
          $fileUse  =2;
          $author=Auth::id();
          uploadFile($file,$src,$srcType,$fileUse,$author);

        }

        ///////Banner Upload End////////////

        ///////Gallery Images UploadStart////////////
        
        $files=$r->file('images');
        if($files){
          
            foreach($files as $file)
            {
              
              $file =$file;
              $src  =$gallery->id;
              $srcType  =3;
              $fileUse  =3;
              $fileStatus=false;
              $author=Auth::id();
              uploadFile($file,$src,$srcType,$fileUse,$author,$fileStatus);
            }
          }
            
        ///////Gallery Images Upload End////////////
      
        $slug =Str::slug($r->name);
        if($slug==null){
          $gallery->slug=$gallery->id;
        }else{
          if(Attribute::where('type',1)->where('slug',$slug)->whereNotIn('id',[$gallery->id])->count() >0){
          $gallery->slug=$slug.'-'.$gallery->id;
          }else{
          $gallery->slug=$slug;
          }
        }
        $gallery->status =$r->status?'active':'inactive';
        $gallery->editedby_id =Auth::id();
        $gallery->save();

        if(isset($r->imageid)){

          for ($i=0; $i < count($r->imageid); $i++) { 
              $image =$gallery->galleryImages()->where('id',$r->imageid[$i])->first();
  
              if($image){
                $image->drag=$i;
                $image->alt_text=$r->imageName[$i];
                $image->description=$r->imageDescription[$i];
                $image->save();
              }
          }
  
        }
        
        if(isset($r->checkid)){
  
          for ($i=0; $i < count($r->checkid); $i++) { 
              $image =$gallery->galleryImages()->where('id',$r->checkid[$i])->first();
              if($image){
                if(File::exists($image->file_url)){
                    File::delete($image->file_url);
                }
                $image->delete();
              }
            
            }
        }

        
        Session()->flash('success','Your Are Successfully Update');
        return redirect()->back();

      }
      //Update Gallery End

      //Delete Gallery Start
      if($action=='delete'){

        //Galleries  Media all File Delete
        $galleryMedies =Media::where('src_type',3)->where('src_id',$gallery->id)->get();

        foreach ($galleryMedies as  $media) {
              if(File::exists($media->file_url)){
                  File::delete($media->file_url);
              }
              $media->delete();
          }

        $gallery->delete();

        Session()->flash('success','Your Are Successfully Done');
        return redirect()->route('admin.galleries');

      }
      //Delete Gallery End

      return view(adminTheme().'galleries.galleriesEdit',compact('gallery'));

    }

    //Galleries Function End

  
    public function paymentMethods(Request $r,$action=null,$id=null){
        
        
      //Create Deposit Start
      if($action=='create'){
          
            $check = $r->validate([
                'name' => 'required|max:100',
                'method_type' => 'nullable|max:100',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'status' => 'required|max:12',
            ]);

            $method =new Attribute();
            $method->type=11;
            $method->name=$r->name;
            $method->location=$r->method_type;
            
            ///////Image Uploard Start////////////
            if($r->hasFile('image')){
              $file =$r->image;
              $src  =$method->id;
              $srcType  =3;
              $fileUse  =1;
              
              uploadFile($file,$src,$srcType,$fileUse);
            }
            ///////Image Uploard End////////////
        
            $method->description=$r->description;
            $method->status=$r->status?'active':'inactive';
            $method->addedby_id=Auth::id();
            $method->save();

          Session()->flash('success','Accounts Successfully Done!');
          return redirect()->route('admin.paymentMethods');
      }
      //Create Deposit End
      
      if($action=='update'){
            $method =Attribute::where('type',11)->where('status','<>','temp')->find($id);
            if(!$method){
                Session()->flash('error','This Method Are Not Found');
                return redirect()->route('admin.paymentMethods'); 
            }
            
            $method->name=$r->name;
            
            ///////Image Uploard Start////////////
            if($r->hasFile('image')){
              $file =$r->image;
              $src  =$method->id;
              $srcType  =3;
              $fileUse  =1;
              uploadFile($file,$src,$srcType,$fileUse);
            }
            ///////Image Uploard End////////////
        
            $method->location=$r->method_type;
            $method->description=$r->description;
            $method->status=$r->status?'active':'inactive';
            $method->addedby_id=Auth::id();
            $method->save();
         
            Session()->flash('success','Accounts Successfully Update!');
            return redirect()->route('admin.paymentMethods');
        
        
            
      }
      
      if($action=='delete'){
            
            if($id==47){
               Session()->flash('error','Cash Account method can not Delete!');
            return redirect()->back(); 
            }
            
            $method =Attribute::where('type',11)->where('status','<>','temp')->find($id);
            if(!$method){
                Session()->flash('error','This Method Are Not Found');
                return redirect()->route('admin.paymentMethods'); 
            }
            $method->delete();
            Session()->flash('success','Accounts Successfully Deleted!');
            return redirect()->back();
         
      }
      
      
      if($action=='manage'){
            $method =Attribute::where('type',11)->where('status','<>','temp')->find($id);
            if(!$method){
                Session()->flash('error','This Method Are Not Found');
                return redirect()->route('admin.paymentMethods'); 
            }
            
            if($r->startDate){
                $from =Carbon::parse($r->startDate);
            }else{
                $from=Carbon::now();
            }
    
            if($r->endDate){
                $to =Carbon::parse($r->endDate);
            }else{
                $to=Carbon::now();
            }
            
            if($r->transaction_id){
                
                $transaction =Transaction::whereIn('type',[4,6])->find($r->transaction_id);
                if($transaction){
                    $startDate =$transaction->created_at;
                    //minus balance
                    $method->amounts +=$transaction->amount;
                    $method->save();
                    
                    $transaction->delete();
                    
                    dailyCashMacting($startDate);
                }
                
                Session()->flash('success','Transaction are Successfully Deleted!');
                return redirect()->back();
                
            }
            
            if($r->isMethod('post')){
                
                $check = $r->validate([
                  'created_at' => 'required|date',
                  'amount' => 'required|numeric',
                //   'debit_type' => 'required|max:100',
                  'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
                ]);
                

                if($r->amount > $method->amounts){
                    Session()->flash('error','Balance Are Not Available');
                    return redirect()->back();
                }
                
                
                $transaction =new Transaction();
                // if($r->debit_type=='withdrawal'){
                // }else{
                //   $transaction->type =4; 
                // }
                $transaction->type =6;
                $transaction->status ='success';
                $transaction->method_id=$method->id;
                $transaction->transection_id=Carbon::now()->format('YmdHis');
                $transaction->amount=$r->amount;
                $transaction->billing_note=$r->description;
                $transaction->billing_name=general()->title;
                $transaction->billing_mobile=general()->mobile;
                $transaction->billing_email=general()->email;
                $transaction->billing_address=general()->address_one;
                $transaction->created_at=$r->created_at?:Carbon::now();
                $transaction->save();
                
                //minus balance
                $method->amounts -=$transaction->amount;
                $method->save();
                
                dailyCashMacting($transaction->created_at);
                
                Session()->flash('success','Debit are Successfully Done!');
                return redirect()->back();
            }
            
            $transactions = Transaction::latest()
            ->whereIn('type', [0, 1, 6, 4])
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->where(function ($query) use ($method) {
                // Type 0 and 1 with order type check
                $query->where(function ($q) use ($method) {
                    $q->whereIn('type', [0, 1])
                      ->where(function ($sub) use ($method) {
                          $sub->where(function ($qq) use ($method) {
                              $qq->whereHas('order', function ($q1) {
                                  $q1->where('order_type', 'customer_order');
                              })->where('method_id', $method->id);
                          })->orWhere(function ($qq) use ($method) {
                              $qq->whereHas('order', function ($q2) {
                                  $q2->where('order_type', 'pos_order');
                              })->where('payment_method_id', $method->id);
                          });
                      });
                });
        
                // Type 6 and 4 without order, just method_id
                $query->orWhere(function ($q) use ($method) {
                    $q->whereIn('type', [6, 4])
                      ->where('method_id', $method->id);
                });
            })
            ->get();
            



            return view(adminTheme().'accounts.accountsMethodManage',compact('method','from','to','transactions'));
      }
      
      $methods =Attribute::where('type',11)->where('status','<>','temp')->get();

      return view(adminTheme().'accounts.accountsMethod',compact('methods'));
        
    }
    
    
    //product Warehouse Function
    public function productsWarehouses(Request $r){
        //Filter Action Start
        if($r->action){
            if($r->checkid){
              $datas=Attribute::where('type',5)->whereIn('id',$r->checkid);
              if($r->action==1){
                $datas->update(['status'=>'active']);
              }elseif($r->action==2){
                $datas->update(['status'=>'inactive']);
              }elseif($r->action==5){
                foreach($datas->get() as $data){
                  $medias =Media::latest()->where('src_type',3)->where('src_id',$data->id)->get();
                  foreach($medias as $media){
                    if(File::exists($media->file_url)){
                      File::delete($media->file_url);
                    }
                    $media->delete();
                  }
                  //Post Category sub Category replace
                  foreach($data->subctgs as $subctg){
                    $subctg->parent_id=$data->parent_id;
                    $subctg->save();
                  }
                  $data->delete();
                }
              }
              Session()->flash('success','Action Successfully Completed!');
            }else{
                Session()->flash('info','Please Need To Select Minimum One Post');
            }
            return redirect()->back();
        }
        //Filter Action End

        $warehouses =Attribute::latest()->where('type',5)->where('status','<>','temp')
            ->where(function($q) use ($r) {
                  if($r->search){
                      $q->where('name','LIKE','%'.$r->search.'%');
                  }
                  if($r->status){
                    $q->where('status',$r->status); 
                  }
            })
            ->select(['id','name','description','created_at','status'])
                ->paginate(25)->appends([
                  'search'=>$r->search,
                  'status'=>$r->status,
                ]);
        
        return view(adminTheme().'products.warehouses.warehousesAll',compact('warehouses'));
    }

    public function productsWarehousesAction(Request $r,$action,$id=null){
        //Add Warehouse  Start
        if($action=='create'){
            
            $check = $r->validate([
                'name' => 'required|max:200',
            ]);
            
            $warehouse =new Attribute();
            $warehouse->type =5;
            $warehouse->name=$r->name;
            $warehouse->description=$r->address;
            $warehouse->status ='active';
            $warehouse->addedby_id =Auth::id();
            $warehouse->created_at =Carbon::now();
            
            $slug = Str::slug($warehouse->name);
            if ($slug && Attribute::where('type', 5)->where('slug', $slug)->first()) {
                $slug = $slug.'-'. $warehouse->id;
            }
            $warehouse->slug = $slug?:$warehouse->id;
            $warehouse->save();

            Session()->flash('success','You Are Successfully Added');
            return redirect()->back();
            
        }
        //Add Warehouse  End
        
        $warehouse =Attribute::where('type',5)->find($id);
        if(!$warehouse){
        Session()->flash('error','This Warehouse Are Not Found');
        return redirect()->route('admin.productsWarehouses');
        }
        
        //Update Warehouse  Start
        if($action=='update'){
            $check = $r->validate([
                'name' => 'required|max:191',
            ]);

            $warehouse->name=$r->name;
            $warehouse->description=$r->address;

            $slug = Str::slug($warehouse->name);
            if ($slug && Attribute::where('type', 5)->whereNot('id',$warehouse->id)->where('slug', $slug)->first()) {
                $slug = $slug.'-'. $warehouse->id;
            }
            $warehouse->slug = $slug?:$warehouse->id;
            $warehouse->status =$r->status?'active':'inactive';
            $warehouse->editedby_id =Auth::id();
            $warehouse->save();
        
            Session()->flash('success','Your Are Successfully Done');
            return redirect()->back();
        }
        //Update Warehouse  End
        
        //Delete Warehouse  Start
        if($action=='delete'){    
            $warehouse->delete();
            Session()->flash('success','Your Are Successfully Done');
            return redirect()->back();
        }
        //Delete Warehouse  End
        return redirect()->back();
        
    }
    //Product Warehouse Function End

    
    public function expensesReports(Request $r){
        
        $from = $r->startDate ? Carbon::parse($r->startDate): Carbon::now()->subDay(0);
        $to = $r->endDate ? Carbon::parse($r->endDate): Carbon::now();
        
        
        $expenses =Expense::latest()
        ->where(function($q) use($r,$from,$to){

            if($r->search){
                $q->where('name','LIKE','%'.$r->search.'%');
            }
            
            if($r->type){
                $q->where('type_id',$r->type);
            }
            
            if($r->warehouse_id){
                $q->where('warehouse_id',$r->warehouse_id);
            }

            $q->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);

        });
      
        $expenses = $expenses->get();
      
      $types =Attribute::where('type',12)->select(['id','name'])->get();

      return view('admin.accounts.expenses.expensesReport',compact('expenses','types','from','to'));

    }
    
    public function expensesTypes(Request $r){


    $types =Attribute::where('type',12)->latest()
        ->where(function($q) use($r) {
            if($r->search){
                $q->where('name','LIKE','%'.$r->search.'%');
            }
        })
        ->select(['id','type','name','description','addedby_id','created_at','status'])
        ->paginate(25);

      return view('admin.accounts.expenses.expensesTypes',compact('types'));
    }


    public function expensesTypesAction(Request $r,$action,$id=null){
        
        if($action=='create' && $r->isMethod('post')){

              $check = $r->validate([
                  'name' => 'required|max:191',
              ]);
    
              $expensesType  = new Attribute();
              $expensesType->type=12;
              $expensesType->name=$r->name;
              $expensesType->description=$r->description;
              $expensesType->status='active';
              $expensesType->addedby_id=Auth::id();
              $expensesType->save();
    
            Session()->flash('success','Type Added Successfully Done!');
            return redirect()->route('admin.expensesTypes');
            
        }
        
        
        
      $expensesType =Attribute::where('type',12)->find($id);
      if(!$expensesType){
        Session()->flash('error','This Type Are Not Found');
        return redirect()->route('admin.expensesTypes');
      }

      if($action=='update'){
          
        $check = $r->validate([
              'name' => 'required|max:191',
          ]);

        $expensesType->name=$r->name;
        $expensesType->description=$r->description;
        $expensesType->editedby_id=Auth::id();
        $expensesType->save();

        Session()->flash('success','Type Update Successfully Done!');
        return redirect()->route('admin.expensesTypes');

      }

      if($action=='delete'){

        $expensesType->delete();

        Session()->flash('success','Type Deleted Successfully Done!');
        return redirect()->route('admin.expensesTypes');
      }
      
      Session()->flash('error','Unknown Type Action Not Allowed');
      return redirect()->route('admin.expensesTypes');

    }


    
    public function expensesList(Request $r){
        

        
        $expenses =Expense::latest()
        
        ->where(function($q) use($r){

            if($r->search){
                $q->where('name','LIKE','%'.$r->search.'%');
            }
            
            if($r->type){
                $q->where('type_id',$r->type);
            }
            
            if($r->warehouse_id){
                $q->where('warehouse_id',$r->warehouse_id);
            }
            
            if($r->startDate || $r->endDate)
            {
                if($r->startDate){
                    $from =$r->startDate;
                }else{
                    $from=Carbon::now()->format('Y-m-d');
                }

                if($r->endDate){
                    $to =$r->endDate;
                }else{
                    $to=Carbon::now()->format('Y-m-d');
                }

                $q->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);
            }

        });
      
        $expenses = $expenses->paginate(25)->appends([
            'type'=>$r->type,
            'startDate'=>$r->startDate,
            'endDate'=>$r->endDate,
        ]);
      
      $types =Attribute::where('type',12)->select(['id','name'])->get();

      return view('admin.accounts.expenses.expensesList',compact('expenses','types'));
      
    }

    public function expensesListAction(Request $r,$action,$id=null){
        
        if($action=='create' && $r->isMethod('post')){
            $check = $r->validate([
                  'date' => 'required',
                  'type' => 'required|numeric',
                  'warehouse_id' => 'required|numeric',
                  'amount' => 'required|numeric',
                  'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
              ]);
              
               $method =Attribute::where('type',11)->where('status','<>','temp')->find(87);
                if(!$method){
                    Session()->flash('error','Cash Method Are Not Found');
                    return redirect()->back(); 
                }
                
                if($r->warehouse_id=='1020'){
                    if($r->amount > $method->amounts){
                        Session()->flash('error','Balance Are Not Available');
                        return redirect()->back();
                    }
                }
              
              $expense  = new Expense();
              $expense->type_id=$r->type;
              $expense->warehouse_id=$r->warehouse_id;
              $expense->amount=$r->amount?:0;
              $expense->description=$r->description;
              $expense->status='active';
              $expense->addedby_id=Auth::id();
              $expense->created_at=$r->date?:Carbon::now();
              $expense->save();
              
              ///////Image UploadStart////////////
             if($r->hasFile('attachment')){
               $file =$r->attachment;
               $src  =$expense->id;
               $srcType  =10;
               $fileUse  =1;
               $author=Auth::id();
               uploadFile($file,$src,$srcType,$fileUse,$author);
             }
             ///////Image Upload End////////////
             
            $transaction =new Transaction();
            $transaction->type =4;
            $transaction->src_id =$expense->id;
            $transaction->status ='success';
            $transaction->method_id=$method->id;
            $transaction->transection_id=Carbon::now()->format('YmdHis');
            $transaction->amount=$r->amount;
            $transaction->billing_note=$r->description;
            $transaction->billing_name=general()->title;
            $transaction->billing_mobile=general()->mobile;
            $transaction->billing_email=general()->email;
            $transaction->billing_address=general()->address_one;
            $transaction->created_at=$expense->created_at;
            $transaction->save();
            
            if($r->warehouse_id=='1020'){
                //minus balance
                $method->amounts -=$transaction->amount;
                $method->save();
            }
            
            dailyCashMacting($transaction->created_at);
            
              
              
            Session()->flash('success','Expense Added Successfully Done!');
            return redirect()->route('admin.expensesList');
        }
        
        
        $expense =Expense::find($id);
      
        if(!$expense){
          Session()->flash('error','Expense Are Not Found');
          return redirect()->route('admin.expensesList');
        }

        if($action=='update'){

            $check = $r->validate([
                'date' => 'required',
                'type' => 'required|numeric',
                'warehouse_id' => 'required|numeric',
                'amount' => 'required|numeric',
                'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            ]);
            
            
            $hasTransection =$expense->transection;
            if($hasTransection){
                if($expense->amount > $r->amount){
                    $needAmount =$expense->amount-$r->amount;
                    $method =$hasTransection->method;
                    if($method){
                        $method->amounts +=$needAmount;
                        $method->save();
                    }
                }elseif($r->amount > $expense->amount){
                    $needAmount =$r->amount -$expense->amount;
                    $method =$hasTransection->method;
                    if($method){
                        if($needAmount > $method->amounts){
                            Session()->flash('error','Cash Balance Are Not Over Expenses');
                            return redirect()->back();
                        }
                        $method->amounts -=$needAmount;
                        $method->save();
                    }
                }
                $hasTransection->amount=$r->amount;
                $hasTransection->created_at=$r->date?:Carbon::now();
                $hasTransection->save();
                dailyCashMacting($hasTransection->created_at);
            }
            

            $expense->type_id=$r->type;
            $expense->warehouse_id=$r->warehouse_id;
            $expense->amount=$r->amount?:0;
            $expense->description=$r->description;
            $expense->editedby_id=Auth::id();
            $expense->created_at=$r->date?:Carbon::now();
            $expense->save();
            
            
            
            ///////Image UploadStart////////////
             if($r->hasFile('attachment')){
               $file =$r->attachment;
               $src  =$expense->id;
               $srcType  =10;
               $fileUse  =1;
               $author=Auth::id();
               uploadFile($file,$src,$srcType,$fileUse,$author);
             }
             ///////Image Upload End////////////

          Session()->flash('success','Expense Update Successfully Done!');
          return redirect()->route('admin.expensesList');

        }

        if($action=='delete'){
          
            $hasTransection =$expense->transection;
            if($hasTransection){
                $startDate =$hasTransection->created_at;
                $method =$hasTransection->method;
                if($method && $expense->warehouse_id=='1020'){
                    $method->amounts +=$hasTransection->amount;
                    $method->save();
                }
                $hasTransection->delete();
                
                dailyCashMacting($startDate);
            }
            
            $expense->delete();

            Session()->flash('success','Type Deleted Successfully Done!');
            return redirect()->route('admin.expensesList');

        }

        Session()->flash('error','Unknown Type Action Not Allowed');
        return redirect()->route('admin.expensesList');

    }

    public function reportsAll(Request $r,$type){
        
        if($r->startDate){
            $from =Carbon::parse($r->startDate);
        }else{
            $from=Carbon::now();
        }

        if($r->endDate){
            $to =Carbon::parse($r->endDate);
        }else{
            $to=Carbon::now();
        }
        
        $startDay = clone $from;
        $daysDifference = $startDay->diffInDays($to);
        if($daysDifference > 0){
        $previousDate = $startDay->subDays($daysDifference);
        }else{
        $previousDate = $startDay->subDay();
        }
        
        if($type=='products'){
            
            $brands = Attribute::where('type',2)->where('status','<>','temp')->where('parent_id',null)->get();
            $categories = Attribute::where('type',0)->where('status','<>','temp')->where('parent_id',null)->get();
            
            $products = Post::latest()->where('type',2)->where('status', '<>','temp')
                ->where(function($qq)  use ($r)  {
    
                    if($r->brand)
                    {
                        $qq->where('brand_id',$r->brand);
                    }
                    if($r->category)
                    {
                        $qq->whereHas('ctgProducts',function($q) use($r){
                            $q->where('reff_id',$r->category);
                          });
                    }

                    if($r->status)
                    {
                        $qq->where('status',$r->status);
                    }
    
                    if($r->search)
                    {
                         $qq->where('name','like',"%{$r->search}%");
                    }
    
                    if($r->startDate || $r->endDate)
                    {
                        if($r->startDate){
                            $from =$r->startDate;
                        }else{
                            $from=Carbon::now()->format('Y-m-d');
                        }
    
                        if($r->endDate){
                            $to =$r->endDate;
                        }else{
                            $to=Carbon::now()->format('Y-m-d');
                        }
    
                        $qq->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);
    
                    }
    
                })->paginate(50);
            
            return view(adminTheme().'reports.productReports',compact('products','categories','brands','type'));
            
        }elseif($type=='history-of-product'){
            $summery =null;
            $stocksHistory=null;
            $stocksMinusHistory=null;
            $salesHistory=null;
            $allHistory=null;
            $transferHistory=null;
            if($r->item_search){
                $products = Post::latest()->where('type',2)->where('status', '<>','temp')->find($r->item_search);
                if(!$products){
                    return abort(404);
                }
                
          
                if($r->stock_qty){
                    
                    if($products->allTransferOrder()->count() > 0){
                        Session()->flash('success','Can Not Stock Adjustment already Transfer Quantity!');
                        return redirect()->back();
                    }
                    
                    if(count($r->stock_qty) > 0){
                        foreach($products->warehouseStores as $i=>$stock){
                            
                            $sales = $products->allSales()
                                ->where('variant_id',$stock->variant_id)
                                ->whereHas('order', function($q)use($stock){
                                    $q->where('branch_id',$stock->branch_id);
                                })
                                ->latest('created_at');
                                
                            $salesQty =$sales->sum('quantity') - $sales->sum('return_quantity');
                            
                            $status=true;
                            $qty =$r->stock_qty[$i]+$salesQty;
                            // return $qty;
                            $stockInventory =$products->allPurchases()->latest()->whereHas('order',function($q)use($stock){$q->where('branch_id',$stock->branch_id);})->where('variant_id',$stock->variant_id)->get();
                            
                            $lastIndex = count($stockInventory) - 1;

                            foreach($stockInventory as $j=>$invt){
                                
                                if($qty > $invt->quantity){
                                  
                                    if($j == $lastIndex) {
                                        $invt->quantity=$qty;
                                        $invt->save();
                                    }else{
                                       $qty -=$invt->quantity; 
                                    }
                                  
                                }else{
                                    if($qty > 0){
                                        $invt->quantity=$qty;
                                        $invt->save();
                                        $qty=0;
                                    }else{
                                        if($status){
                                            $invt->quantity=abs($qty);
                                            $invt->save();
                                            $status=false;
                                        }else{
                                            $invt->quantity=0;
                                            $invt->save();
                                        }
                                    }
                                }
                                
                            }
                            
                            
                            $stock->quantity =$r->stock_qty[$i];
                            $stock->save();
                        }
                        
                        foreach ($products->productVariationAttributeItems()->get() as $item) {
                            $warehouseRecords = $products->warehouseStores()->where('variant_id', $item->id);
                            $hasMinus = $warehouseRecords->where('quantity', '<', 0)->exists();
                            if ($hasMinus) {
                                $products->warehouseStores()
                                    ->where('variant_id', $item->id)
                                    ->where('quantity', '<', 0)
                                    ->update(['quantity' => 0]);
                            }
                            $totalQuantity = $products->warehouseStores()->where('variant_id', $item->id)->sum('quantity');
                            $item->quantity = max($totalQuantity, 0);
                            $item->save();
                        }
                        $products->warehouseStores()->whereDoesntHave('variant')->delete();
    
                        $products->quantity=$products->warehouseStores()->whereHas('variant')->sum('quantity');
                        $products->save();
                    }
                    Session()->flash('success','Stock Adjustment Updated!');
                    return redirect()->back();
                }   
   
                // if(Auth::id()==663){
                //   $qtys = [4,2,3,0];

                //   if($products->variation_status){
                //         // return $products->warehouseStores;
                //       foreach($products->warehouseStores as $i=>$stock){
                //           $stock->quantity =$qtys[$i];
                //           $stock->save();
                //       }
      
                //       foreach ($products->productVariationAttributeItems()->get() as $item) {
                //             $warehouseRecords = $products->warehouseStores()->where('variant_id', $item->id);
                //             $hasMinus = $warehouseRecords->where('quantity', '<', 0)->exists();
                //             if ($hasMinus) {
                //                 $products->warehouseStores()
                //                     ->where('variant_id', $item->id)
                //                     ->where('quantity', '<', 0)
                //                     ->update(['quantity' => 0]);
                //             }
                //             $totalQuantity = $products->warehouseStores()->where('variant_id', $item->id)->sum('quantity');
                //             $item->quantity = max($totalQuantity, 0);
                //             $item->save();
                //       }
                //     $products->warehouseStores()->whereDoesntHave('variant')->delete();

                //     $products->quantity=$products->warehouseStores()->whereHas('variant')->sum('quantity');
                //     $products->save();
                      
                //   }
                  
                //   return 'Success';
                // }
                
                $summery=[
                        'pos_sale_qty'=>$products->allSales()->whereHas('order',function($q){$q->where('order_type','pos_order');})->sum('quantity'),
                        'pos_sale_amount'=>$products->allSales()->whereHas('order',function($q){$q->where('order_type','pos_order');})->sum('final_price'),
                        'online_sale_qty'=>$products->allSales()->whereHas('order',function($q){$q->where('order_type','customer_order');})->sum('quantity'),
                        'online_sale_amount'=>$products->allSales()->whereHas('order',function($q){$q->where('order_type','customer_order');})->sum('final_price'),
                        'whole_sale_qty'=>$products->allSales()->whereHas('order',function($q){$q->where('order_type','wholesale_order');})->sum('quantity'),
                        'whole_sale_amount'=>$products->allSales()->whereHas('order',function($q){$q->where('order_type','wholesale_order');})->sum('total_price'),
                    ];
                $stocksHistory =$products->allPurchases()->latest()->get();
                $stocksMinusHistory =$products->allMinusStock()->latest()->get();
                $salesHistory =$products->allSales()->latest()->get();
                $transferHistory =$products->allTransferOrder()->latest()->get();
                
                // return Order::whereIn('order_type',['customer_order'])
                // ->whereNotIn('order_status',['temp','pending','cancelled','completed','shipped','delivered','confirmed'])
                // ->get();
                
                $allHistory = OrderItem::whereHas('order',function($q)use($products){
                            $q->where('order_status','<>','temp')->where('product_id',$products->id);
                        })->get();
                
                
            }elseif($r->startDate || $r->endDate || $r->search || $r->category){
                
                $from = $r->startDate ?? null;
                $to = $r->endDate ?? Carbon::now()->format('Y-m-d');
                
                $products = Post::where(function($q){
                        if(request()->category){
                            $q->whereHas('productCtgs',function($qq){
                              $qq->where('reff_id',request()->category);
                           });
                        }
                        if(request()->search){
                            $q->where('name','like','%'.request()->search.'%')->orWhere('id','like','%'.request()->search.'%');
                        }
                        
                    })
                    ->withSum(['allSales as total_sales_quantity' => function ($query) use ($from, $to) {
                        $query->whereHas('order', function($q) use ($from, $to){
                                if($from){
                                $q->whereDate('created_at', '>=', $from);
                                }
                                $q->whereDate('created_at', '<=', $to);
                              })
                              ->select(\DB::raw('SUM(quantity)'));
                    }], 'quantity')
                    ->withSum(['allSales as total_sales_amount' => function ($query) use ($from, $to) {
                        $query->whereHas('order', function($q) use ($from, $to){
                                if($from){
                                    $q->whereDate('created_at', '>=', $from);
                                }
                                $q->whereDate('created_at', '<=', $to);
                              })
                              ->select(\DB::raw('SUM(final_price)'));
                    }], 'final_price')
                    ->withCount(['allSales as total_sales_count' => function ($query) use ($from, $to) {
                        $query->whereHas('order', function($q) use ($from, $to){
                                if($from){
                                    $q->whereDate('created_at', '>=', $from);
                                }
                                $q->whereDate('created_at', '<=', $to);
                              });
                    }])
                    ->where('type', 2)
                    ->where('status', '<>', 'temp')
                    ->orderByDesc('total_sales_quantity')
                    ->get();
                    
            }else{
                $products = Post::withSum(['allSales as total_sales_quantity' => function ($query) {
                        $query->select(\DB::raw('SUM(quantity)'));
                    }], 'quantity')
                    ->withSum(['allSales as total_sales_amount' => function ($query) {
                        $query->select(\DB::raw('SUM(final_price)'));
                    }], 'final_price')
                    ->withCount(['allSales as total_sales_count'])
                    ->where('type', 2)
                    ->where('status', '<>', 'temp')
                    ->orderByDesc('total_sales_quantity')
                    ->take(20)
                    ->get();
                // return $products;
            }
            
            $categories =Attribute::where('type',0)->where('status','<>','temp')->where('parent_id',null)->get();
            
            return view(adminTheme().'reports.productHistoryReport',compact('products','categories','summery','stocksHistory','stocksMinusHistory','transferHistory','allHistory','salesHistory','type'));
            
            
        }elseif($type=='order-reports'){
            
            $orders = Order::latest()->where('order_type','customer_order')->where('order_status', '<>','temp')
                ->where(function($qq)  use ($r)  {
                    if($r->status){
                        $qq->where('order_status',$r->status);
                    }
    
                    if($r->search){
                           $qq->where('name','LIKE','%'.$r->search.'%')->orWhere('email','LIKE','%'.$r->search.'%')->orWhere('mobile','LIKE','%'.$r->search.'%'); 
                    }
    
                    if($r->startDate || $r->endDate){
                        if($r->startDate){
                            $from =$r->startDate;
                        }else{
                            $from=Carbon::now()->format('Y-m-d');
                        }
    
                        if($r->endDate){
                            $to =$r->endDate;
                        }else{
                            $to=Carbon::now()->format('Y-m-d');
                        }
    
                        $qq->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);
                    }
    
                })->paginate(50);
            
            return view(adminTheme().'reports.orderReports',compact('orders','type'));
        }elseif($type=='customer-reports'){
            
                $customers =User::latest()
                        ->where(function($qq)  use ($r)  {
        
                        if($r->search){
                           $qq->where('name','LIKE','%'.$r->search.'%')->orWhere('email','LIKE','%'.$r->search.'%')->orWhere('mobile','LIKE','%'.$r->search.'%'); 
                        }
                    
                    })
                    ->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)
                    ->get();
            
            
            return view(adminTheme().'reports.customerReports',compact('customers','from','to','type'));
            
        
            
        }elseif($type=='today-reports'){

            $startDate =$r->startDate?Carbon::parse($r->startDate):Carbon::now();
            $todayStockIn=OrderItem::whereHas('order',function($q)use($startDate){
              $q->whereIn('order_type',['purchase_order','order_return','wholesale_return'])
                ->whereNotIn('order_status',['temp','pending','cancelled'])
                ->whereDate('created_at', $startDate);
            })
            ->get();
            
            $totalDueSale=Order::whereIn('order_type',['customer_order','wholesale_order','pos_order'])
                ->whereNotIn('order_status',['temp','pending','cancelled'])
                ->where('due_amount', '>',0)
                ->sum('due_amount');
            
            $todayStockSale=OrderItem::whereHas('order',function($q)use($startDate){
              $q->whereIn('order_type',['customer_order','wholesale_order','pos_order'])
                ->whereNotIn('order_status',['temp','pending','cancelled'])
                ->whereDate('created_at', $startDate);
            })
            ->get();
    
            $todaySale=Order::latest()->where('order_type','customer_order')
            // ->whereNotIn('order_status',['temp','pending','cancelled'])
                ->whereIn('order_status',['confirmed','shipped','delivered','returned'])
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
            
            $todayStockPurchase=Order::latest()->where('order_type','purchase_order')
            ->whereNotIn('order_status',['temp','pending','cancelled'])
            
            ->whereDate('created_at', $startDate)
            ->sum('grand_total');
            
            $todayReturnSale=Order::latest()->whereIn('order_type',['order_return','wholesale_return'])
            ->whereNotIn('order_status',['temp','pending','cancelled'])
            ->whereDate('created_at', $startDate)
            ->sum('grand_total');
            
            $posSale = DB::table('orders')->where('order_type','pos_order')->where('order_status','delivered')->whereDate('created_at', $startDate)->sum('grand_total');
            
            $todayExpense=Expense::latest()->whereDate('created_at', $startDate)
                        ->where('warehouse_id','1020')
                        ->sum('amount');
            
            $methods = Attribute::where('type', 11)
            ->where('status', 'active')
            ->orderBy('name')
            ->select(['id','name','amounts'])
            ->get()
            ->filter(function ($item)use($startDate){
                $collection =0;
                
                $collection +=Transaction::whereHas('order',function($q)use($startDate){
                    $q->where('order_type','customer_order');
                    // ->whereDate('created_at', $startDate);
                })
                ->whereDate('created_at', $startDate)
                ->where('method_id',$item->id)->sum('amount');
                
                $collection +=Transaction::whereHas('order',function($q)use($startDate){
                    $q->where('order_type','wholesale_order');
                    // ->whereDate('created_at', $startDate);
                })
                ->whereDate('created_at', $startDate)
                ->where('method_id',$item->id)->sum('amount');
                
                $collection +=Transaction::whereHas('order',function($q)use($startDate){
                    $q->where('order_type','pos_order');
                    // ->whereDate('created_at', $startDate);
                })
                ->whereDate('created_at', $startDate)
                ->where('payment_method_id',$item->id)->sum('amount');
                
    
                $item->collection=$collection;
                return $collection > 0;
            })
            ->values();

                    
            $methods1 = Attribute::where('type', 11)
                ->where('status', 'active')
                ->orderBy('name')
                ->select(['id', 'name', 'amounts'])
                ->get()
                ->map(function ($item) use ($startDate) {
                    $collection = Transaction::whereHas('order', function ($q) {
                            $q->where('order_type', 'customer_order');
                        })
                        ->whereDate('created_at', $startDate)
                        ->where('method_id', $item->id)
                        ->sum('amount');
            
                    $item->collection = $collection;
                    return $item;
                })
                ->filter(function ($item) {
                    return $item->collection > 0;
                })
                ->values(); 
            
            $methods2 = Attribute::where('type', 11)
                ->where('status', 'active')
                ->orderBy('name')
                ->select(['id', 'name', 'amounts'])
                ->get()
                ->map(function ($item) use ($startDate) {
                    $collection = Transaction::whereHas('order', function ($q) {
                            $q->where('order_type', 'wholesale_order');
                        })
                        ->whereDate('created_at', $startDate)
                        ->where('method_id', $item->id)
                        ->sum('amount');
            
                    $item->collection = $collection;
                    return $item;
                })
                ->filter(function ($item) {
                    return $item->collection > 0;
                })
                ->values(); 
            
            $methods3 = Attribute::where('type', 11)
                ->where('status', 'active')
                ->orderBy('name')
                ->select(['id', 'name', 'amounts'])
                ->get()
                ->map(function ($item) use ($startDate) {
                    $collection = Transaction::whereHas('order', function ($q) {
                            $q->where('order_type', 'pos_order');
                        })
                        ->whereDate('created_at', $startDate)
                        ->where('payment_method_id', $item->id)
                        ->sum('amount');
            
                    $item->collection = $collection;
                    return $item;
                })
                ->filter(function ($item) {
                    return $item->collection > 0;
                })
                ->values(); 
     
            
                
            // dailyCashMacting($startDate);
            
            //Privius Cash Start
            $preCash =0;
            $formDate =Carbon::parse('2025-07-22');
            $hasDatePriviusData =CashHistory::latest()->whereDate('created_at','<',$startDate)->first();
            $priviusDate =$hasDatePriviusData?$hasDatePriviusData->created_at:$startDate->copy()->subDay();
            if($startDate->gt($formDate)){
                $cashData =CashHistory::whereDate('created_at', $priviusDate)->first();
                if($cashData){
                    $preCash =$cashData->available_cash;
                }
            }
            //Privius Cash End     
            
            // return  Transaction::whereHas('order',function($q){
            //         $q->where('order_type','customer_order');
            //     })
            //     ->whereDate('created_at', $startDate)
            //     ->where('method_id',87)->with('order')->get();
            
            
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
            $expenses =Transaction::where('type',4)->whereDate('created_at', $startDate)
                        ->whereHas('expense',function($q){
                            $q->where('warehouse_id','1020');
                        })
                        ->sum('amount');
            
            $cash =$cashSum;
            
            $available=($preCash+$cash) - ($expenses+$withdrawal);
            
            $reports=array(
                    "todaySale"=>$todaySale - $todaySaleShipping,
                    "todaySaleShipping"=>$todaySaleShipping,
                    "posSale"=>$posSale,
                    "todayWholesale"=>$todayWholesale,
                    "todayStockPurchase"=>$todayStockPurchase,
                    "todayReturnSale"=>$todayReturnSale,
                    "todayExpense"=>$todayExpense,
                    "preCash"=>$preCash,
                    "cash"=>$cash,
                    "available"=>$available,
                    "withdrawal"=>$withdrawal,
                    "expenses"=>$expenses,
                    "todayStockSale"=>$todayStockSale->sum('quantity'),
                    "todayStockSaleItem"=>$todayStockSale->unique('product_id')->count(),
                    "todayStockIn"=>$todayStockIn->sum('quantity'),
                    "todayStockInItem"=>$todayStockIn->unique('product_id')->count(),
                );
                
            // dailyCashMacting($startDate);
            
            return view(adminTheme().'reports.todayReports',compact('type','reports','methods','methods1','methods2','methods3','startDate','priviusDate'));
            
            
            $startDate =$r->startDate?Carbon::parse($r->startDate):Carbon::now();
            $todayStockIn=OrderItem::whereHas('order',function($q)use($startDate){
              $q->whereIn('order_type',['purchase_order','order_return','wholesale_return'])
                ->whereNotIn('order_status',['temp','pending','cancelled'])
                ->whereDate('created_at', $startDate);
            })
            ->get();
            
            $totalDueSale=Order::whereIn('order_type',['customer_order','wholesale_order','pos_order'])
                ->whereNotIn('order_status',['temp','pending','cancelled'])
                ->where('due_amount', '>',0)
                ->sum('due_amount');
            
            $todayStockSale=OrderItem::whereHas('order',function($q)use($startDate){
              $q->whereIn('order_type',['customer_order','wholesale_order','pos_order'])
                ->whereNotIn('order_status',['temp','pending','cancelled'])
                ->whereDate('created_at', $startDate);
            })
            ->get();
    
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
            
            $todayStockPurchase=Order::latest()->where('order_type','purchase_order')
            ->whereNotIn('order_status',['temp','pending','cancelled'])
            
            ->whereDate('created_at', $startDate)
            ->sum('grand_total');
            
            $todayReturnSale=Order::latest()->where('order_type','order_return')
            ->whereNotIn('order_status',['temp','pending','cancelled'])
            
            ->whereDate('created_at', $startDate)
            ->sum('grand_total');
            
            $posSale = DB::table('orders')->where('order_type','pos_order')->where('order_status','delivered')->whereDate('created_at', $startDate)->sum('grand_total');
            
            $todayExpense=Expense::latest()->whereDate('created_at', $startDate)->sum('amount');
            
            $methods = Attribute::where('type', 11)
            ->where('status', 'active')
            ->orderBy('name')
            ->select(['id','name','amounts'])
            ->get()
            ->filter(function ($item)use($startDate){
                $collection =0;
                
                $collection +=Transaction::whereHas('order',function($q)use($startDate){
                    $q->where('order_type','customer_order')->whereDate('created_at', $startDate);
                })->where('method_id',$item->id)->sum('amount');
                
                $collection +=Transaction::whereHas('order',function($q)use($startDate){
                    $q->where('order_type','wholesale_order')->whereDate('created_at', $startDate);
                })->where('method_id',$item->id)->sum('amount');
                
                $collection +=Transaction::whereHas('order',function($q)use($startDate){
                    $q->where('order_type','pos_order')->whereDate('created_at', $startDate);
                })->where('payment_method_id',$item->id)->sum('amount');
                
    
                $item->collection=$collection;
                return $collection > 0;
            })
            ->values();
            
            
            //Privius Cash Start
            $hasDatePriviusData =Transaction::latest()->whereIn('type',[0,1])->whereDate('created_at','<',$startDate)->first();
            $priviusDate =$hasDatePriviusData?$hasDatePriviusData->created_at:$startDate->copy()->subDay();
            $cashSumOld =Transaction::whereHas('order',function($q)use($priviusDate){
                    $q->where('order_type','customer_order')->whereDate('created_at', $priviusDate);
                })->where('method_id',87)->sum('amount');
            
            $cashSumOld +=Transaction::whereHas('order',function($q)use($priviusDate){
                    $q->where('order_type','wholesale_order')->whereDate('created_at', $priviusDate);
                })->where('method_id',87)->sum('amount');
                
            $cashSumOld +=Transaction::whereHas('order',function($q)use($priviusDate){
                    $q->where('order_type','pos_order')->whereDate('created_at', $priviusDate);
                })->where('payment_method_id',87)->sum('amount');
            
            
            $withdrawalOld =Transaction::where('type',6)->whereDate('created_at', $priviusDate)->sum('amount');
            $expensesOld =Transaction::where('type',4)->whereDate('created_at', $priviusDate)->sum('amount');
            
            // return $cashSumOld; $priviusDate->format('d-M-Y');
            
            
            $preCash =0;$cashSumOld - ($withdrawalOld+$expensesOld);
            
            
            //Privius Cash End            
            
            $cashSum =Transaction::whereHas('order',function($q)use($startDate){
                    $q->where('order_type','customer_order')->whereDate('created_at', $startDate);
                })->where('method_id',87)->sum('amount');
            
            $cashSum +=Transaction::whereHas('order',function($q)use($startDate){
                    $q->where('order_type','wholesale_order')->whereDate('created_at', $startDate);
                })->where('method_id',87)->sum('amount');
                
            $cashSum +=Transaction::whereHas('order',function($q)use($startDate){
                    $q->where('order_type','pos_order')->where('order_status','delivered')->whereDate('created_at', $startDate);
                })->where('payment_method_id',87)
                ->sum('amount');
            
            $withdrawal =Transaction::where('type',6)->whereDate('created_at', $startDate)->sum('amount');
            $expenses =Transaction::where('type',4)->whereDate('created_at', $startDate)->sum('amount');
            
            $cash =$cashSum;
            $available=$cash;
            if ($startDate->isToday()){
                $cashMethod = Attribute::find(87);
                if ($cashMethod){
                    $preCash = $cashMethod->amounts - $cash;
                }
                $available =($preCash+$cash) - ($withdrawal+$expenses);
            }

            
            
            $reports=array(
                    "todaySale"=>$todaySale - $todaySaleShipping,
                    "todaySaleShipping"=>$todaySaleShipping,
                    "posSale"=>$posSale,
                    "todayWholesale"=>$todayWholesale,
                    "todayStockPurchase"=>$todayStockPurchase,
                    "todayReturnSale"=>$todayReturnSale,
                    "todayExpense"=>$todayExpense,
                    "preCash"=>$preCash,
                    "cash"=>$cash,
                    "available"=>$available,
                    "withdrawal"=>$withdrawal,
                    "expenses"=>$expenses,
                    "todayStockSale"=>$todayStockSale->sum('quantity'),
                    "todayStockSaleItem"=>$todayStockSale->unique('product_id')->count(),
                    "todayStockIn"=>$todayStockIn->sum('quantity'),
                    "todayStockInItem"=>$todayStockIn->unique('product_id')->count(),
                );

            return view(adminTheme().'reports.todayReports',compact('type','reports','methods','startDate','priviusDate'));
        
            
        }elseif($type=='store-branch'){
            
            $products=null;
            if(request()->branch || request()->category || request()->search){
                $products =Post::latest()->where('type',2)->where('status','active')
                        ->where(function($q){
                            if(request()->category){
                                $q->whereHas('productCtgs',function($qq){
                                  $qq->where('reff_id',request()->category);
                               });
                            }
                            if(request()->search){
                                $q->where('id',request()->search)
                                ->orWhere('bar_code',request()->search)
                                ->orWhereHas('productVariationActiveAttributeItems', function ($q2){
                                  $q2->where('barcode', request()->search);
                              });
                            }
                        })
                        ->whereHas('warehouseStores',function($q){
                            $q->where('quantity','>',0)->where('branch_id',request()->branch);
                        })
                        ->get();
            }
            $warehouses =Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']);
            $categories =Attribute::where('type',0)->where('status','<>','temp')->where('parent_id',null)->get();
            return view(adminTheme().'reports.storeBranchReports',compact('type','warehouses','categories','products'));
        }else{
            
            
            $currentMonth = Carbon::now();
            $monthlyData = [];
            for ($i = 0,$currentMonth; $i < 12; $i++) {
                $month = $currentMonth->copy()->subMonths();
                $orders = Order::whereIn('order_type', ['customer_order','purchase_order', 'pos_order', 'wholesale_order'])
                                ->whereIn('order_status',['confirmed','shipped','delivered','returned'])
                                ->whereMonth('created_at', $month->format('m'))
                                ->whereYear('created_at', $month->format('Y'))
                                ->where(function($q){
                                    if(request()->warehouse){
                                        $q->where('branch_id',request()->warehouse);
                                    }
                                })
                                ->select(['id', 'grand_total','due_amount','total_price','adjustment_amount','paid_amount','profit_loss','shipping_charge', 'order_type'])
                                ->get();
                $returnOrders = Order::whereIn('order_type', ['wholesale_return','order_return'])
                                ->whereIn('order_status',['completed','delivered'])
                                ->whereMonth('created_at', $month->format('m'))
                                ->whereYear('created_at', $month->format('Y'))
                                ->where(function($q){
                                    if(request()->warehouse){
                                        $q->where('branch_id',request()->warehouse);
                                    }
                                })
                                ->sum('grand_total');
                $expensesTotal =Expense::latest()
                                ->whereMonth('created_at', $month->format('m'))
                                ->whereYear('created_at', $month->format('Y'))
                                ->where(function($q){
                                    if(request()->warehouse){
                                        $q->where('warehouse_id',request()->warehouse);
                                    }
                                })
                                ->sum('amount');
                
                $customerTotal =User::latest()->where('wholesale',false)->where('admin',false)
                                ->whereMonth('created_at', $month->format('m'))
                                ->whereYear('created_at', $month->format('Y'))
                                ->count();
                $monthlyData[] = [
                    'month' => $month->format('F Y'),  // Month name (e.g., March 2024)
                    'total' => $orders->whereIn('order_type', ['customer_order','pos_order','wholesale_order'])->sum('grand_total'),
                    'profitTotal' => $orders->whereIn('order_type', ['customer_order','pos_order','wholesale_order'])->sum('profit_loss'),
                    'onlineTotal' => $orders->where('order_type', 'customer_order')->sum('total_price') - $orders->where('order_type', 'customer_order')->sum('adjustment_amount'),
                    'posTotal' => $orders->where('order_type', 'pos_order')->sum('grand_total'),
                    'wholesaleTotal' => $orders->where('order_type', 'wholesale_order')->sum('grand_total'),
                    'purchaseTotal' => $orders->where('order_type', 'purchase_order')->sum('grand_total'),
                    'expensesTotal' => $expensesTotal,
                    'customerTotal' => $customerTotal, 
                    'returnTotal' => $returnOrders,  
                ];
                
                $currentMonth=$month;
            }
            
            $customerOrders  = Order::latest()->where('order_type','customer_order')->whereIn('order_status',['confirmed','shipped','delivered','returned'])
                            ->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)
                            ->where(function($q){
                                if(request()->warehouse){
                                    $q->where('branch_id',request()->warehouse);
                                }
                            })
                            ->get(['id','invoice','name','mobile','grand_total','total_price','adjustment_amount','branch_id','profit_loss','payment_status','order_status','created_at']);
            
            $posOrders  = Order::latest()->where('order_type','pos_order')->where('order_status','<>','temp')
                            ->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)
                            ->where(function($q){
                                if(request()->warehouse){
                                    $q->where('branch_id',request()->warehouse);
                                }
                            })
                            ->get(['id','invoice','name','mobile','grand_total','branch_id','profit_loss','payment_status','order_status','created_at']);
                            
            $purchasesOrders  = Order::latest()->where('order_type','purchase_order')->whereIn('order_status',['confirmed','shipped','delivered','returned'])
                                ->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)
                                ->where(function($q){
                                    if(request()->warehouse){
                                        $q->where('branch_id',request()->warehouse);
                                    }
                                })
                                ->get(['id','invoice','name','branch_id','mobile','grand_total','total_price','due_amount','paid_amount','shipping_charge','payment_status','adjustment_amount','order_status','created_at']);
            
            
            $wholesaleOrders  = Order::latest()->where('order_type','wholesale_order')->whereIn('order_status',['confirmed','shipped','delivered'])
                            ->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)
                            ->where(function($q){
                                if(request()->warehouse){
                                    $q->where('branch_id',request()->warehouse);
                                }
                            })
                            ->get(['id','invoice','branch_id','profit_loss','name','mobile','grand_total','total_price','adjustment_amount','due_amount','paid_amount','shipping_charge','payment_status','adjustment_amount','order_status','created_at']);
            
            $returnOrders  = Order::latest()->whereIn('order_type',['wholesale_return','order_return'])->whereIn('order_status',['delivered','completed'])
                            ->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)
                            ->where(function($q){
                                if(request()->warehouse){
                                    $q->where('branch_id',request()->warehouse);
                                }
                            })
                            ->get(['id','invoice','branch_id','parent_id','name','mobile','grand_total','total_price','due_amount','paid_amount','shipping_charge','payment_status','adjustment_amount','order_status','created_at']);
            
            $expensesOrders =Expense::latest()->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)
                                ->where(function($q){
                                    if(request()->warehouse){
                                        $q->where('warehouse_id',request()->warehouse);
                                    }
                                })
                                ->get();
            
            $customers  = User::where('status',1)->where('wholesale',false)->where('admin',false)
                            ->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)->get(['id','name','mobile','email','created_at']);
            
            collect($customers)->map(function($item){
                $item->total_revenue =$item->orders()->whereIn('order_status',['confirmed','shipped','delivered','returned'])->sum('grand_total');
                unset($item->orders);
                return $item;
            });
            
            $report =array(
                    'onlineSales'=>$customerOrders->sum('total_price') - $customerOrders->sum('adjustment_amount'),
                    'posSales'=>$posOrders->sum('grand_total'),
                    'purchase'=>$purchasesOrders->sum('grand_total'),
                    'wholesale'=>$wholesaleOrders->sum('grand_total'),
                    'expenses'=>$expensesOrders->sum('amount'),
                    'customer'=>$customers->count(),
                    'return'=>$returnOrders->sum('grand_total'),
                );

            return view(adminTheme().'reports.summeryReports1',compact('type','from','to','report','customerOrders','customers','posOrders','expensesOrders','purchasesOrders','wholesaleOrders','returnOrders','monthlyData'));
                
            $currentMonth = Carbon::now();
            $monthlyData = [];
            for ($i = 0,$currentMonth; $i < 12; $i++) {
                $month = $currentMonth->copy()->subMonths();
                $orders = Order::whereIn('order_type', ['customer_order', 'pos_order', 'wholesale_order'])
                    ->whereIn('order_status',['confirmed','shipped','delivered','returned'])
                    ->whereMonth('created_at', $month->format('m'))
                    ->whereYear('created_at', $month->format('Y'))
                    ->select(['id', 'grand_total','shipping_charge', 'order_type'])
                    ->get();
        
                $monthlyData[] = [
                    'month' => $month->format('F Y'),
                    'total' => $orders->sum('grand_total'),
                    'posTotal' => $orders->where('order_type', 'pos_order')->sum('grand_total'),
                    'onlineTotal' => $orders->where('order_type', 'customer_order')->sum('grand_total') - $orders->where('order_type', 'customer_order')->sum('shipping_charge'),
                    'wholesaleTotal' => $orders->where('order_type', 'wholesale_order')->sum('grand_total')
                ];
                $currentMonth =$month;
            }

            
            $customerOrders  = Order::latest()->where('order_type','customer_order')->whereIn('order_status',['confirmed','shipped','delivered','returned'])
                            ->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)->get(['id','invoice','name','mobile','grand_total','total_price','shipping_charge','payment_status','adjustment_amount','order_status','created_at']);
            
            $posOrders  = Order::latest()->where('order_type','pos_order')->where('order_status','<>','temp')
                            ->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)->get(['id','invoice','name','mobile','grand_total','payment_status','order_status','created_at']);
            
            $wholesaleOrders  = Order::latest()->where('order_type','wholesale_order')->whereIn('order_status',['confirmed','shipped','delivered'])
                            ->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)->get(['id','invoice','name','mobile','grand_total','total_price','shipping_charge','payment_status','adjustment_amount','order_status','created_at']);
            
            $users  = User::where('status',1)
                            ->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)->count();
            
            
            //Previus data get
            $preCustomerOrders  = Order::latest()->where('order_type','customer_order')->whereIn('order_status',['confirmed','shipped','delivered','returned'])
                            ->whereDate('created_at','>=',$previousDate)->whereDate('created_at','<',$from)->get(['id','invoice','name','mobile','grand_total','payment_status','order_status','created_at']);
            
            $prePosOrders  = Order::latest()->where('order_type','pos_order')->where('order_status','<>','temp')
                            ->whereDate('created_at','>=',$previousDate)->whereDate('created_at','<',$from)->get(['id','invoice','name','mobile','grand_total','payment_status','order_status','created_at']);
            
            $preWholesaleOrders  = Order::latest()->where('order_type','wholesale_order')->whereIn('order_status',['confirmed','shipped','delivered'])
                            ->whereDate('created_at','>=',$previousDate)->whereDate('created_at','<',$from)->get(['id','invoice','name','mobile','grand_total','payment_status','order_status','created_at']);
            
            $preUsers  = User::where('status',1)
                            ->whereDate('created_at','>=',$previousDate)->whereDate('created_at','<',$from)->count();
            
            
            $totalSales =($customerOrders->sum('total_price')-$customerOrders->sum('adjustment_amount'))+$posOrders->sum('grand_total')+$wholesaleOrders->sum('grand_total');
            $preTotalSales =$preCustomerOrders->sum('grand_total')+$prePosOrders->sum('grand_total')+$preWholesaleOrders->sum('grand_total');
            
            $report =array(
                    'totalSales'=>($customerOrders->sum('total_price')-$customerOrders->sum('adjustment_amount'))+$posOrders->sum('grand_total'),
                    'grothSales1'=>$preTotalSales,
                    'grothSales'=>($preTotalSales > 0) ? (($totalSales - $preTotalSales) / $preTotalSales) * 100 : 100,
                    'posSales'=>$posOrders->sum('grand_total'),
                    'posSales1'=>$prePosOrders->sum('grand_total'),
                    'grothPosSales'=>($prePosOrders->sum('grand_total') > 0) ? (($posOrders->sum('grand_total') - $prePosOrders->sum('grand_total')) / $prePosOrders->sum('grand_total')) * 100 : 100,
                    'onlineSales'=>$customerOrders->sum('total_price')-$customerOrders->sum('adjustment_amount'),
                    'onlineSales1'=>$preCustomerOrders->sum('grand_total'),
                    'grothOnlineSales'=>($preCustomerOrders->sum('grand_total') > 0) ? (($customerOrders->sum('total_price') - $preCustomerOrders->sum('grand_total')) / $preCustomerOrders->sum('grand_total')) * 100 : 100,
                    'customer'=>$wholesaleOrders->sum('grand_total'),
                    'customer1'=>$preWholesaleOrders->sum('grand_total'),
                    'preCustomer'=>($preWholesaleOrders->sum('grand_total') > 0) ? (($wholesaleOrders->sum('grand_total') - $preWholesaleOrders->sum('grand_total')) / $preWholesaleOrders->sum('grand_total')) * 100 : 100,
                );
            

                // $toEmail ='rabiulk449@gmail.com';
                // $toName =general()->title;
                // $subject ='Daily Report Summery Mail Form '.general()->title;
                // $datas =array('report'=>$report,'posOrders'=>$posOrders,'customerOrders'=>$customerOrders,'monthlyData'=>$monthlyData);
                // $template ='mails.summeryReportAdminMail';
                // sendMail($toEmail,$toName,$subject,$datas,$template);

                // return 'success';
            
        
            return view(adminTheme().'reports.summeryReports',compact('type','from','to','report','posOrders','customerOrders','wholesaleOrders','monthlyData'));
        }
         
        
    }



    public function themeSetting(Request $r){
      
      $homeDatas =PostExtra::where('type',4)->where('parent_id',null)->where('status','<>','temp')->latest()->get();
      
      $offerNotes =PostExtra::where('type',5)->latest()->get();
      
      $bannerNote =PostExtra::where('type',6)->first();
      if(!$bannerNote){
          $bannerNote =new PostExtra();
          $bannerNote->status='pending';
          $bannerNote->type=6;
          $bannerNote->save();
      }
      
      $featuredNote =PostExtra::where('type',7)->first();
      if(!$featuredNote){
          $featuredNote =new PostExtra();
          $featuredNote->status='active';
          $featuredNote->type=7;
          $featuredNote->save();
      }
      
      return view(adminTheme().'theme-setting.themeSetting',compact('homeDatas','offerNotes','bannerNote','featuredNote'));
    }
    
    public function themeSettingAction(Request $r,$action,$id=null){
        
        
        if($action=='add-offer-note'){
            
            $check = $r->validate([
              'note_title' => 'required',
            ]);
            
            $note =new PostExtra();
            $note->type=5;
            $note->content=$r->note_title;
            $note->status='active';
            $note->save();
            
            Session()->flash('success','Your Are Successfully Done');
            return redirect()->back();    
        }
        
        if($action=='update-banner-note'){
            
            $check = $r->validate([
                'sub_title' => 'nullable|max:200',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            $offerBanner =PostExtra::where('type',6)->find($id);
            if(!$offerBanner){
                Session()->flash('error','Offer banner Are Not Found');
                return redirect()->back();
            }
            $offerBanner->name=$r->title;
            $offerBanner->sub_title=$r->sub_title;
            $offerBanner->status=$r->status?'active':'pending';
            $offerBanner->featured=$r->featured?true:false;
            $offerBanner->save();
            
            ///////Image UploadStart////////////
             if($r->hasFile('image')){
               $file =$r->image;
               $src  =$offerBanner->id;
               $srcType  =9;
               $fileUse  =1;
               $author=Auth::id();
               uploadFile($file,$src,$srcType,$fileUse,$author);
             }
             ///////Image Upload End////////////
            
            
            Session()->flash('success','Data Updated Successfully Done');
            return redirect()->back();

            
        }
        
        if($action=='update-featured-note'){
            
            $check = $r->validate([
                'payment_delivery' => 'required|max:300',
                'return_refund' => 'required|max:300',
                'online_support' => 'required|max:300',
                'gift_card' => 'required|max:300',
            ]);
            $featuredText =PostExtra::where('type',7)->find($id);
            if(!$featuredText){
                Session()->flash('error','Featured Text Are Not Found');
                return redirect()->back();
            }
            
            $featuredText->name=$r->payment_delivery;
            $featuredText->content=$r->return_refund;
            $featuredText->sub_title=$r->online_support;
            $featuredText->description=$r->gift_card;
            $featuredText->save();
            
            Session()->flash('success','Data Updated Successfully Done');
            return redirect()->back();
            
        }
        
        if($action=='update-offer-note'){

            $check = $r->validate([
              'link_url' => 'nullable|max:100',
              'created_at' => 'required|date',
              'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
              'hover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            $note =PostExtra::where('type',5)->find($id);
            if(!$note){
                Session()->flash('error','Note Are Not Found');
                return redirect()->back();
            }
            
            $createDate =$r->created_at?Carbon::parse($r->created_at . ' ' . Carbon::now()->format('H:i:s')):Carbon::now();
            
            $note->content=$r->link_url;
            $note->status=$r->status?'active':'inactive';
            if (!$createDate->isSameDay($note->created_at)) {
                $note->created_at = $createDate;
            }

            ///////Image UploadStart////////////
            if($r->hasFile('image')){
              $file =$r->image;
              $src  =$note->id;
              $srcType  =9;
              $fileUse  =1;
              $author=Auth::id();
              uploadFile($file,$src,$srcType,$fileUse,$author);
            }
            ///////Image Upload End////////////

            ///////Image UploadStart////////////
            if($r->hasFile('hover_image')){
              $file =$r->hover_image;
              $src  =$note->id;
              $srcType  =9;
              $fileUse  =2;
              $author=Auth::id();
              uploadFile($file,$src,$srcType,$fileUse,$author);
            }
            ///////Image Upload End////////////


            $note->save();
            
            Session()->flash('success','Your Are Successfully Done');
            return redirect()->back();
            
        }
        
        if($action=='delete-offer-note'){
            $note =PostExtra::where('type',5)->find($id);
            if(!$note){
                Session()->flash('error','Note Are Not Found');
                return redirect()->back();
            }
            
            $note->delete();
            
            Session()->flash('success','Your Are Successfully Deleted');
            return redirect()->back();
        }
        
        if($action=='create'){
              $postData =PostExtra::where('type',4)->where('status','temp')->where('addedby_id',Auth::id())->first();
              if(!$postData){
                $postData =new PostExtra();
                $postData->type=4;
                $postData->status='temp';
                $postData->addedby_id=Auth::id();
              }
              $postData->created_at=Carbon::now();
              $postData->save();
              return redirect()->route('admin.themeSettingAction',['edit',$postData->id]);
        }
        $homedata =PostExtra::where('type',4)->find($id);
        if(!$homedata){
            Session()->flash('error','Home Data Not Found');
            return redirect()->route('admin.themeSetting');
        }
        
        
        if($action=="update"){
            
            $check = $r->validate([
                'title' => 'required|max:100',
                'sub_title' => 'nullable|max:100',
                'data_limit' => 'nullable|numeric',
                // 'data_type' => 'required|max:100',
                // 'category_id' => 'nullable|numeric',
                'image_link' => 'nullable',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);
            
            $createDate =$r->created_at?Carbon::parse($r->created_at . ' ' . Carbon::now()->format('H:i:s')):Carbon::now();
            
            $homedata->name=$r->title;
            $homedata->sub_title=$r->sub_title;
            $homedata->description=$r->description;
            $homedata->data_limit=$r->data_limit;
            // $homedata->data_type=$r->data_type?:null;
            // $homedata->category_id=$r->category_id;
            $homedata->image_link=$r->image_link;
            
            ///////Image UploadStart////////////
             if($r->hasFile('image')){
               $file =$r->image;
               $src  =$homedata->id;
               $srcType  =9;
               $fileUse  =1;
               $author=Auth::id();
               uploadFile($file,$src,$srcType,$fileUse,$author);
             }
             ///////Image Upload End////////////
            
            ///////Image UploadStart////////////
             if($r->hasFile('image2')){
               $file =$r->image2;
               $src  =$homedata->id;
               $srcType  =9;
               $fileUse  =2;
               $author=Auth::id();
               uploadFile($file,$src,$srcType,$fileUse,$author);
             }
             ///////Image Upload End////////////
            
            $homedata->status=$r->status?'active':'inactive';
            if (!$createDate->isSameDay($homedata->created_at)) {
                $homedata->created_at = $createDate;
            }
            $homedata->save();
            
            Session()->flash('success','Data Updated Successfully Done');
            return redirect()->back();

        }
        
        if($action=="delete"){
            $homedata->homeDataIds()->delete();
            
            $userFiles =Media::latest()->where('src_type',9)->where('src_id',$homedata->id)->get();
            foreach ($userFiles as $media) {
                if(File::exists($media->file_url)){
                      File::delete($media->file_url);
                  }
                $media->delete();
            }
            
            $homedata->delete();
            
            Session()->flash('success','Data Delete Successfully Done!');
            return redirect()->route('admin.themeSetting');
        }
        
        $searchProducts =null;
        
        if($r->ajax()){
            
            if($r->type=='search'){
                
                $searchProducts =Post::latest()->where('type',2)->where('status','active')->where('stock_status',true)->where('quantity','>',0)
                ->where(function($q) use($r){
                    
                    if($r->type=='search' && $r->key){
                        $q->where('name','like','%'.$r->key.'%');
                        $q->orWhere('sku_code','like','%'.$r->key.'%');
                        $q->orWhere('bar_code','like',$r->key);
                    }

                })
                ->select(['id','name','final_price','quantity','sku_code'])
                ->paginate(25)->appends([
                  'key'=>$r->key,
                  'barcode'=>$r->barcode,
                ]);
                
               $datas =view(adminTheme().'purchase.includes.searchResult',compact('searchProducts'))->render();
                
                return Response()->json([
                    'success' => true,
                    'view' => $datas,
                ]); 
            }
            
            if($r->type=='addproduct' && $r->id){

               $product =Post::latest()->where('type',2)->where('status','active')->find($r->id);

               if($product){
                   
                    $item =PostExtra::where('parent_id',$homedata->id)->where('src_id',$product->id)->first();
                            
                    if(!$item){
                        $item =new PostExtra();
                        $item->parent_id =$homedata->id;
                        $item->src_id =$product->id;
                        $item->type =4;
                        $item->save();
                    }
                    
               }
               
            }
            
            $datas =view(adminTheme().'theme-setting.includes.homeProducts',compact('homedata'))->render();
            
            return Response()->json([
                    'success' => true,
                    'view' => $datas,
                ]);
            
        }
        

        $categories =Attribute::where('type',0)->where('status','active')->where('parent_id',null)->get(['id','name']);
        
        return view(adminTheme().'theme-setting.themeSettingEdit',compact('homedata','searchProducts','categories'));
    }
    
    
    public function themeSettingUpdate(Request $r,$id){
        $homedata =PostExtra::where('type',4)->find($id);
        
        if(!$homedata){
            Session()->flash('error','Home Data Not Found');
            return redirect()->route('admin.themeSetting');
        }
        
        $check = $r->validate([
            'title' => 'required|max:191',
            'bg_color' => 'nullable|max:100',
            'title_color' => 'nullable|max:100',
            'serial' => 'required|numeric',
            'limit' => 'required|numeric',
            'product_view' => 'required|numeric',
            'product_type' => 'required|numeric',
            'status' => 'required',
        ]);

        $homedata->name = $r->title;
        $homedata->bg_color = $r->bg_color;
        $homedata->title_color = $r->title_color;
        $homedata->drag = $r->serial?:0;
        $homedata->product_limit = $r->limit?:0;
        $homedata->product_view = $r->product_view?:0;
        $homedata->product_type = $r->product_type?:0;
        $homedata->status = $r->status;
        $homedata->save();
        
        if(isset($r->delete)){
            
            $homedata->homeDataIds()->whereIn('src_id',$r->delete)->delete();
            
        }
        
        
        Session()->flash('success','Data Updated Successfully Done');
        return redirect()->back();
        
    }



  // User Management Function Start
  public function usersAdmin(Request $r){

    //Filter Actions Start
    if($r->action){
      if($r->checkid){

      $datas=User::latest()->whereIn('status',[0,1])->where('admin',true)
             ->where(function($q){
                if (general()->masterAdmins()) {
                    $q->where('id','<>',general()->masterAdmins());
                }
            })
            ->whereIn('id',$r->checkid)->get();

      foreach($datas as $data){

          if($r->action==1){
            $data->status=1;
            $data->save();
          }elseif($r->action==2){
            $data->status=0;
            $data->save();
          }elseif($r->action==3){
            $data->fetured=true;
            $data->save();
          }elseif($r->action==4){
            $data->fetured=false;
            $data->save();
          }elseif($r->action==5){
            
            //User Media File Delete
            $data->admin=false;
            $data->addedby_at=null;
            $data->permission_id=null;
            $data->addedby_id=null;
            $data->save();

          }

      }

      Session()->flash('success','Action Successfully Completed!');

      }else{
        Session()->flash('info','Please Need To Select Minimum One Post');
      }

      return redirect()->back();
    }

    //Filter Action End

  
    $users =User::latest()->whereIn('status',[0,1])->where('admin',true)->where('id','<>','671')
    ->where(function($q) use($r) {

        if (general()->masterAdmins()) {
            $q->where('id','<>',general()->masterAdmins());
        }

        if($r->search){
            $q->where('name','LIKE','%'.$r->search.'%');
            $q->orWhere('email','LIKE','%'.$r->search.'%');
            $q->orWhere('mobile','LIKE','%'.$r->search.'%');
        }

        if($r->role){
           $q->where('permission_id',$r->role);
        }
        
        if($r->startDate || $r->endDate)
        {
            if($r->startDate){
                $from =$r->startDate;
            }else{
                $from=Carbon::now()->format('Y-m-d');
            }

            if($r->endDate){
                $to =$r->endDate;
            }else{
                $to=Carbon::now()->format('Y-m-d');
            }

            $q->whereDate('addedby_at','>=',$from)->whereDate('addedby_at','<=',$to);
        }

    })
    ->select(['id','permission_id','name','email','mobile','addedby_at','addedby_id','status'])
    ->paginate(25)->appends([
      'search'=>$r->search,
      'startDate'=>$r->startDate,
      'endDate'=>$r->endDate,
    ]);

    //Total Count Results
    $totals = DB::table('users')->whereIn('status',[0,1])
    ->where('admin',true)
    ->where(function($q){
        if (general()->masterAdmins()) {
            $q->where('id','<>',general()->masterAdmins());
        }
    })
    ->selectRaw('count(*) as total')
    ->selectRaw("count(case when status = 1 then 1 end) as active")
    ->selectRaw("count(case when status = 0 then 1 end) as inactive")
    ->first();
   
    $roles =Permission::latest()->where('status','active')->get();

    return view(adminTheme().'users.admins.users',compact('users','totals','roles'));
  }

  public function usersAdminAction (Request $r,$action,$id=null){
    
    //Add Admin User Start
    if($action=='create' && $r->isMethod('post')){

      if(filter_var($r->username, FILTER_VALIDATE_EMAIL)){
        $hasUser =User::latest()->whereIn('status',[0,1])->where('email',$r->username)->first();
      }else{
        $hasUser =User::latest()->whereIn('status',[0,1])->where('mobile',$r->username)->first();
      }
  
      if(!$hasUser){
          Session()->flash('error','This User Are Not Register');
          return redirect()->route('admin.usersAdmin');
      }
  
      if($hasUser->admin){
          Session()->flash('error','This User Are already Admin Authorize');
          return redirect()->route('admin.usersAdmin');
      }
  
      $hasUser->admin=true;
      $hasUser->permission_id=1;
      $hasUser->addedby_at=Carbon::now();
      $hasUser->addedby_id=Auth::id();
      $hasUser->save();
     
      Session()->flash('success','User Are Successfully Admin Authorize Done!');
      return redirect()->route('admin.usersAdminAction',['edit',$hasUser->id]);

    }
    //Add Admin User End


    $user=User::whereIn('status',[0,1])->where('admin',true)->find($id);
    if(!$user){
      Session()->flash('error','This Admin User Are Not Found');
      return redirect()->route('admin.usersAdmin');
    }

      //Update User Profile Start
      if($action=='update' && $r->isMethod('post')){

          $check = $r->validate([
               'name' => 'required|max:100|unique:users,name,'.$user->id,
               'email' => 'required|max:100|unique:users,email,'.$user->id,
               'mobile' => 'nullable|max:20|unique:users,mobile,'.$user->id,
               'gender' => 'nullable|max:10',
               'address' => 'nullable|max:191',
               'division' => 'nullable|numeric',
               'district' => 'nullable|max:191',
               'city' => 'nullable|max:191',
               'postal_code' => 'nullable|max:20',
               'role' => 'nullable|numeric',
               'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
   
           ]);
   
         $user->name =$r->name;
         $user->mobile =$r->mobile;
         $user->email =$r->email;
         $user->gender =$r->gender;
         $user->address_line1 =$r->address;
         $user->division =$r->division;
         $user->district =$r->district;
         $user->city =$r->city;
         $user->postal_code =$r->postal_code;
         $user->profile =$r->profile;
         $user->permission_id =$r->role;
         
         ///////Image UploadStart////////////
         if($r->hasFile('image')){
           $file =$r->image;
           $src  =$user->id;
           $srcType  =6;
           $fileUse  =1;
           $author=Auth::id();
           uploadFile($file,$src,$srcType,$fileUse,$author);
         }
         ///////Image Upload End////////////
   
         $user->status=$r->status?true:false;
         $user->fetured=$r->featured?true:false;
         $user->save();
   
         Session()->flash('success','Your Updated Are Successfully Done!');
         return redirect()->route('admin.usersAdminAction',['edit',$user->id]);
      }
      //Update User Profile End

      //Update User Password Start
      if($action=='change-password' && $r->isMethod('post')){
        
        $validator = Validator::make($r->all(), [
            // 'old_password' => 'required|string|min:8',
            'password' => 'required|string|min:8|confirmed|different:old_password',
        ]);
      
        if($validator->fails()){
            return redirect()->route('admin.usersAdminAction',['edit',$user->id])->withErrors($validator)->withInput();
        }

        // if(Hash::check($r->old_password, $user->password)){
          $user->password_show=$r->password;
          $user->password=Hash::make($r->password);
          $user->update();

          Session()->flash('success','Your Are Successfully Done');
          return redirect()->route('admin.usersAdminAction',['edit',$user->id]);
        // }else{
        //   Session()->flash('error','Current Password Are Not Match');
        //   return redirect()->route('admin.usersAdminAction',['edit',$user->id]);
        // }
      }
      //Update User Password End

      //Delete User End
      if($action=='delete'){
        $user->admin=false;
        $user->addedby_at=null;
        $user->permission_id=null;
        $user->addedby_id=null;
        $user->save();

        Session()->flash('success','Admin User Are Removed Successfully Done');
        return redirect()->route('admin.usersAdmin');
      }
      //Delete User End
      $roles =Permission::latest()->where('status','active')->get();

      return view(adminTheme().'users.admins.editUser',compact('user','roles'));

    }
    
    public function usersSupplier(Request $r){

    //Filter Actions Start
      if($r->action){
        if($r->checkid){
        $datas=User::where('business',true)->whereIn('status',[0,1])
                ->where(function($q){
                    if (general()->masterAdmins()) {
                        $q->where('id','<>',general()->masterAdmins());
                    }
                })
                ->whereIn('id',$r->checkid)->get();
  
        foreach($datas as $data){
  
            if($r->action==1){
              $data->status=1;
              $data->save();
            }elseif($r->action==2){
              $data->status=0;
              $data->save();
            }elseif($r->action==5){
              
              $userFiles =Media::latest()->where('src_type',6)->where('src_id',$data->id)->get();
              foreach ($userFiles as $media) {
                  if(File::exists($media->file_url)){
                        File::delete($media->file_url);
                    }
                  $media->delete();
              }
              $data->delete();
  
            }
  
        }
  
        Session()->flash('success','Action Successfully Completed!');
  
        }else{
          Session()->flash('info','Please Need To Select Minimum One Post');
        }
  
        return redirect()->back();
      }
  
      //Filter Action End
  
      $users =User::latest()->where('business',true)->whereIn('status',[0,1])
      ->where(function($q) use($r) {

                    if (general()->masterAdmins()) {
                        $q->where('id','<>',general()->masterAdmins());
                    }
  
          if($r->search){
              $q->where('name','LIKE','%'.$r->search.'%');
              $q->orWhere('email','LIKE','%'.$r->search.'%');
              $q->orWhere('mobile','LIKE','%'.$r->search.'%');
          }
          if($r->status){
            $q->where('status',$r->status=='inactive'?0:1);
          }
          if($r->startDate || $r->endDate)
          {
              if($r->startDate){
                  $from =$r->startDate;
              }else{
                  $from=Carbon::now()->format('Y-m-d');
              }
  
              if($r->endDate){
                  $to =$r->endDate;
              }else{
                  $to=Carbon::now()->format('Y-m-d');
              }
  
              $q->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);
          }
  
      })
      ->select(['id','name','email','mobile','created_at','company_name','address_line1','addedby_id','status'])
        ->paginate(25)->appends([
          'search'=>$r->search,
          'status'=>$r->status,
          'startDate'=>$r->startDate,
          'endDate'=>$r->endDate,
        ]);

      //Total Count Results
      $totals = DB::table('users')->whereIn('status',[0,1])->where('business',true)
       ->where(function($q){
            if (general()->masterAdmins()) {
                $q->where('id','<>',general()->masterAdmins());
            }
        })
      ->selectRaw('count(*) as total')
      ->selectRaw("count(case when status = 1 then 1 end) as active")
      ->selectRaw("count(case when status = 0 then 1 end) as inactive")
      ->first();

    return view(adminTheme().'users.suppliers.users',compact('users','totals'));
  }

    public function usersSupplierAction(Request $r,$action,$id=null){
     
   //Add New User Start
      if($action=='create' && $r->isMethod('post')){
        $check = $r->validate([
          'name' => 'required|max:100',
          'email_mobile' => 'required|max:100',
          'address' => 'nullable|max:200',
        ]);

        $user =User::where('email',$r->email_mobile)->orWhere('mobile',$r->email_mobile)->first();
        if($user){
          Session()->flash('error','This User Are Already Account');
          return redirect()->back();
        }
        $password=Str::random(8);
        $user =new User();
        $user->name =$r->name;
        if(filter_var($r->email_mobile, FILTER_VALIDATE_EMAIL)){
          $user->email =$r->email_mobile;
        }else{
          $user->mobile =$r->email_mobile;
        }
        $user->address_line1=$r->address;
        $user->password_show=$password;
        $user->password=Hash::make($password);
        $user->business=true;
        $user->save();
        
        return redirect()->route('admin.usersSupplierAction',['edit',$user->id]);
      }
      //Add New User End
      
      
      $user=User::where('business',true)->whereIn('status',[0,1])->find($id);
      if(!$user){
        Session()->flash('error','This User Are Not Found');
        return redirect()->route('admin.usersSupplier');
      }
      
      if($action=='view'){
        $orders =$user->orders()->whereIn('order_type',['purchase_order'])
                ->paginate(10);
        return view(adminTheme().'users.suppliers.viewUser',compact('user','orders'));   
      }
  
      //Update User Profile Start
      if($action=='update' && $r->isMethod('post')){

          $check = $r->validate([
                'name' => 'required|max:100',
                'email' => 'nullable|max:100|unique:users,email,'.$user->id,
                'mobile' => 'required|max:20|unique:users,mobile,'.$user->id,
                'address' => 'nullable|max:200',
                'company_name' => 'nullable|max:200',
                'created_at' => 'nullable|date|max:50',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

          $createDate =$r->created_at?Carbon::parse($r->created_at . ' ' . Carbon::now()->format('H:i:s')):Carbon::now();
          if (!$createDate->isSameDay($user->created_at)) {
              $user->created_at = $createDate;
          }
       
          $user->name =$r->name;
          $user->mobile =$r->mobile;
          $user->email =$r->email;
          $user->company_name =$r->company_name;
          $user->address_line1 =$r->address;
          ///////Image UploadStart////////////
          if($r->hasFile('image')){
            $file =$r->image;
            $src  =$user->id;
            $srcType  =6;
            $fileUse  =1;
            $author =Auth::id();
            uploadFile($file,$src,$srcType,$fileUse,$author);
          }
          ///////Image Upload End////////////
          $user->status=$r->status?true:false;
          $user->save();
    
          Session()->flash('success','Your Updated Are Successfully Done!');
          return redirect()->back();
  
        }
        //Update User Profile End
  
        //Delete User Start
        if($action=='delete'){
  
          $userFiles =Media::latest()->where('src_type',6)->where('src_id',$user->id)->get();
          foreach ($userFiles as $media) {
              if(File::exists($media->file_url)){
                    File::delete($media->file_url);
                }
              $media->delete();
          }
          $user->delete();
          Session()->flash('success','User Are Deleted Successfully Deleted!');
          return redirect()->back();
        }
        //Delete User End
        
      return view(adminTheme().'users.suppliers.editUser',compact('user'));

  }


    public function usersCustomer(Request $r){

        //Filter Actions Start
        if($r->action){
          if($r->checkid){
    
          $datas=User::latest()->whereIn('status',[0,1])
           ->where(function($q){
                if (general()->masterAdmins()) {
                    $q->where('id','<>',general()->masterAdmins());
                }
            })
          ->whereIn('id',$r->checkid)->get();
    
          foreach($datas as $data){
    
              if($r->action==1){
                $data->status=1;
                $data->save();
              }elseif($r->action==2){
                $data->status=0;
                $data->save();
              }elseif($r->action==3){
                $data->fetured=true;
                $data->save();
              }elseif($r->action==4){
                $data->fetured=false;
                $data->save();
              }elseif($r->action==5){
                if($data=='621'){
                    
                }else{
                    $userFiles =Media::latest()->where('src_type',6)->where('src_id',$data->id)->get();
                    foreach ($userFiles as $media) {
                        if(File::exists($media->file_url)){
                              File::delete($media->file_url);
                          }
                        $media->delete();
                    }
                    $data->delete();
                }
    
              }
    
          }
    
          Session()->flash('success','Action Successfully Completed!');
    
          }else{
            Session()->flash('info','Please Need To Select Minimum One Post');
          }
    
          return redirect()->back();
        }
    
        //Filter Action End
    
        $users =User::latest()->whereIn('status',[0,1])->where('id','<>','671')
        ->where('wholesale',false)
        ->where('business',false)
        ->where(function($q) use($r) {
    
            if (general()->masterAdmins()) {
                $q->where('id','<>',general()->masterAdmins());
            }
            
            if($r->search){
                $q->where('name','LIKE','%'.$r->search.'%');
                $q->orWhere('email','LIKE','%'.$r->search.'%');
                $q->orWhere('mobile','LIKE','%'.$r->search.'%');
                $q->orWhere('member_card_id','LIKE','%'.$r->search.'%');
            }
            
            if($r->startDate || $r->endDate)
            {
                if($r->startDate){
                    $from =$r->startDate;
                }else{
                    $from=Carbon::now()->format('Y-m-d');
                }
    
                if($r->endDate){
                    $to =$r->endDate;
                }else{
                    $to=Carbon::now()->format('Y-m-d');
                }
    
                $q->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);
            }
    
        })
        ->select(['id','permission_id','name','email','mobile','member_card_id','created_at','addedby_id','status'])
          ->paginate(25)->appends([
            'search'=>$r->search,
            'startDate'=>$r->startDate,
            'endDate'=>$r->endDate,
          ]);
    
        //Total Count Results
        $totals = DB::table('users')->whereIn('status',[0,1])
        ->where('wholesale',false)
        ->where('business',false)
         ->where(function($q){
            if (general()->masterAdmins()) {
                $q->where('id','<>',general()->masterAdmins());
            }
        })
        ->selectRaw('count(*) as total')
        ->selectRaw("count(case when status = 1 then 1 end) as active")
        ->selectRaw("count(case when status = 0 then 1 end) as inactive")
        ->first();
    
        return view(adminTheme().'users.customers.users',compact('users','totals'));
    }

    public function usersCustomerAction(Request $r,$action,$id=null){
     
        //Add New User Start
        if($action=='create' && $r->isMethod('post')){
            
            $field='mobile';
            if(filter_var($r->mobile_email, FILTER_VALIDATE_EMAIL)){
                    $field = 'email';
            }
            
            
          $user =User::where($field,$r->mobile_email)->first();
          if(!$user){
            $password=Str::random(8);
            $user =new User();
            $user->name =$r->name;
            if($field=='email'){
            $user->email =$r->mobile_email;
            }else{
            $user->mobile =$r->mobile_email;
            }
            $user->password_show=$password;
            $user->password=Hash::make($password);
            $user->save();
          }
          
          return redirect()->route('admin.usersCustomerAction',['edit',$user->id]);
        }
        //Add New User End
        
        
        $user=User::whereIn('status',[0,1])->find($id);
        if(!$user){
          Session()->flash('error','This User Are Not Found');
          return redirect()->route('admin.usersCustomer');
        }
        
        if($action=='view'){
            
            $orders =$user->orders()->where('order_status','delivered')->whereIn('order_type',['customer_order','pos_order'])
                    ->where(function($q){
                        if(request()->payment_status=='due'){
                            $q->where('due_amount','>',0);
                        }
                    })
                    ->paginate(10);
            
            return view(adminTheme().'users.customers.viewUser',compact('user','orders'));
        }
    
        //Update User Profile Start
        if($action=='update' && $r->isMethod('post')){
    
            $check = $r->validate([
                  'name' => 'required|max:100',
                  'email' => 'nullable|email|max:100|unique:users,email,'.$user->id,
                  'mobile' => 'nullable|max:20|unique:users,mobile,'.$user->id,
                  'gender' => 'nullable|max:10',
                  'member_card_id' => 'nullable|max:100|unique:users,member_card_id,'.$user->id,
                  'address' => 'nullable|max:191',
                  'division' => 'nullable|numeric',
                  'district' => 'nullable|numeric',
                  'city' => 'nullable|numeric',
                  'created_at' => 'nullable|date|max:50',
                  'postal_code' => 'nullable|max:20',
                  'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
              ]);
             
    
            $createDate = $r->created_at ? Carbon::parse($r->created_at . ' ' . Carbon::now()->format('H:i:s')) : Carbon::now();
      
            $user->name =$r->name;
            $user->mobile =$r->mobile;
            $user->email =$r->email;
            $user->gender =$r->gender;
            $user->member_card_id =$r->member_card_id;
            $user->address_line1 =$r->address;
            $user->division =$r->division;
            $user->district =$r->district;
            $user->city =$r->city;
            $user->postal_code =$r->postal_code;
            if (!$createDate->isSameDay($user->created_at)) {
              $user->created_at = $createDate;
            }
            ///////Image UploadStart////////////
            if($r->hasFile('image')){
      
              $file =$r->image;
              $src  =$user->id;
              $srcType  =6;
              $fileUse  =1;
              $author =Auth::id();
              uploadFile($file,$src,$srcType,$fileUse,$author);
            }
            ///////Image Upload End////////////
      
            $user->status=$r->status?true:false;
            $user->save();
      
            Session()->flash('success','Your Updated Are Successfully Done!');
            return redirect()->back();
    
          }
          //Update User Profile End
    
          //Update User Password Change Start
          if($action=='change-password' && $r->isMethod('post')){
       
            $validator = Validator::make($r->all(), [
                'old_password' => 'required|string|min:8',
                'password' => 'required|string|min:8|confirmed|different:old_password',
            ]);
           
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            if(Hash::check($r->old_password, $user->password)){
              $user->password_show=$r->password;
              $user->password=Hash::make($r->password);
              $user->update();
             
              Session()->flash('success','Your Are Successfully Done');
              return redirect()->back();
            }else{
            Session()->flash('error','Current Password Are Not Match');
            return redirect()->back();
            }
    
          }
          //Update User Password Change End
    
          //Delete User Start
          if($action=='delete'){
            if($user->id=='621' || $user->id=='674' || $user->id=='671'){
                Session()->flash('error','This User can not Delete!');
                return redirect()->back();
            }
            $userFiles =Media::latest()->where('src_type',6)->where('src_id',$user->id)->get();
            foreach ($userFiles as $media) {
                if(File::exists($media->file_url)){
                      File::delete($media->file_url);
                  }
                $media->delete();
            }
            $user->delete();
            Session()->flash('success','User Are Deleted Successfully Deleted!');
            return redirect()->back();
          }
          //Delete User End
    
        return view(adminTheme().'users.customers.editUser',compact('user'));

    }
    
    public function usersWholesaleCustomer(Request $r){

        //Filter Actions Start
        if($r->action){
          if($r->checkid){
    
              $datas=User::latest()->whereIn('status',[0,1])->where('wholesale',true)
               ->where(function($q){
                    if (general()->masterAdmins()) {
                        $q->where('id','<>',general()->masterAdmins());
                    }
                })
              ->whereIn('id',$r->checkid)->get();
        
              foreach($datas as $data){
        
                  if($r->action==1){
                    $data->status=1;
                    $data->save();
                  }elseif($r->action==2){
                    $data->status=0;
                    $data->save();
                  }elseif($r->action==3){
                    $data->fetured=true;
                    $data->save();
                  }elseif($r->action==4){
                    $data->fetured=false;
                    $data->save();
                  }elseif($r->action==5){
                    if($data=='621' || '671'){
                        
                    }else{
                        $userFiles =Media::latest()->where('src_type',6)->where('src_id',$data->id)->get();
                        foreach ($userFiles as $media) {
                            if(File::exists($media->file_url)){
                                  File::delete($media->file_url);
                              }
                            $media->delete();
                        }
                        $data->delete();
                    }
        
                  }
        
              }
        
              Session()->flash('success','Action Successfully Completed!');
    
          }else{
            Session()->flash('info','Please Need To Select Minimum One Post');
          }
    
          return redirect()->back();
        }
    
        //Filter Action End
    
        $users =User::latest()->whereIn('status',[0,1])->where('wholesale',true)
        ->where(function($q) use($r) {
    
            if (general()->masterAdmins()) {
                $q->where('id','<>',general()->masterAdmins());
            }
            
            if($r->search){
                $q->where('name','LIKE','%'.$r->search.'%');
                $q->orWhere('email','LIKE','%'.$r->search.'%');
                $q->orWhere('mobile','LIKE','%'.$r->search.'%');
                $q->orWhere('member_card_id','LIKE','%'.$r->search.'%');
            }
            
            if($r->startDate || $r->endDate)
            {
                if($r->startDate){
                    $from =$r->startDate;
                }else{
                    $from=Carbon::now()->format('Y-m-d');
                }
    
                if($r->endDate){
                    $to =$r->endDate;
                }else{
                    $to=Carbon::now()->format('Y-m-d');
                }
    
                $q->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);
            }
    
        })
        ->select(['id','permission_id','name','email','mobile','member_card_id','company_name','created_at','addedby_id','status'])
          ->paginate(25)->appends([
            'search'=>$r->search,
            'startDate'=>$r->startDate,
            'endDate'=>$r->endDate,
          ]);
    
        //Total Count Results
        $totals = DB::table('users')->whereIn('status',[0,1])
         ->where('wholesale',true)
         ->where(function($q){
            if (general()->masterAdmins()) {
                $q->where('id','<>',general()->masterAdmins());
            }
        })
        ->selectRaw('count(*) as total')
        ->selectRaw("count(case when status = 1 then 1 end) as active")
        ->selectRaw("count(case when status = 0 then 1 end) as inactive")
        ->first();
    
        return view(adminTheme().'users.wholesale-customers.users',compact('users','totals'));
    }

    public function usersWholesaleCustomerAction(Request $r,$action,$id=null){
     
        //Add New User Start
        if($action=='create' && $r->isMethod('post')){
            
            $field='mobile';
            if(filter_var($r->mobile_email, FILTER_VALIDATE_EMAIL)){
                    $field = 'email';
            }
            
            
          $user =User::where($field,$r->mobile_email)->first();
          if($user){
            Session()->flash('error','This '.$field.' Already Register.');
            return redirect()->back();
          }
          
            $password=Str::random(8);
            $user =new User();
            $user->company_name =$r->company_name;
            $user->name =$r->name;
            if($field=='email'){
            $user->email =$r->mobile_email;
            }else{
            $user->mobile =$r->mobile_email;
            }
            $user->wholesale=true;
            $user->password_show=$password;
            $user->password=Hash::make($password);
            $user->save();
          
          
          return redirect()->route('admin.usersWholesaleCustomerAction',['edit',$user->id]);
        }
        //Add New User End
        
        
        $user=User::whereIn('status',[0,1])->where('wholesale',true)->find($id);
        if(!$user){
          Session()->flash('error','This User Are Not Found');
          return redirect()->route('admin.usersWholesaleCustomer');
        }
        
        if($action=='view'){
            
            $orders =$user->orders()->where('order_status','delivered')->where('order_type','wholesale_order')
                    ->where(function($q){
                        if(request()->payment_status=='due'){
                            $q->where('due_amount','>',0);
                        }
                    })
                    ->paginate(10);
            
            return view(adminTheme().'users.wholesale-customers.viewUser',compact('user','orders'));
        }
        
    
        //Update User Profile Start
        if($action=='update' && $r->isMethod('post')){
    
            $check = $r->validate([
                  'company_name' => 'required|max:100',
                  'name' => 'required|max:100',
                  'email' => 'nullable|email|max:100|unique:users,email,'.$user->id,
                  'mobile' => 'nullable|max:20|unique:users,mobile,'.$user->id,
                  'gender' => 'nullable|max:10',
                  'member_card_id' => 'nullable|max:100|unique:users,member_card_id,'.$user->id,
                  'address' => 'nullable|max:191',
                  'division' => 'nullable|numeric',
                  'district' => 'nullable|numeric',
                  'city' => 'nullable|numeric',
                  'created_at' => 'nullable|date|max:50',
                  'postal_code' => 'nullable|max:20',
                  'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
              ]);
             
    
            $createDate = $r->created_at ? Carbon::parse($r->created_at . ' ' . Carbon::now()->format('H:i:s')) : Carbon::now();
      
            $user->company_name =$r->company_name;
            $user->name =$r->name;
            $user->mobile =$r->mobile;
            $user->email =$r->email;
            $user->gender =$r->gender;
            $user->member_card_id =$r->member_card_id;
            $user->address_line1 =$r->address;
            $user->division =$r->division;
            $user->district =$r->district;
            $user->city =$r->city;
            $user->postal_code =$r->postal_code;
            if (!$createDate->isSameDay($user->created_at)) {
              $user->created_at = $createDate;
            }
            ///////Image UploadStart////////////
            if($r->hasFile('image')){
      
              $file =$r->image;
              $src  =$user->id;
              $srcType  =6;
              $fileUse  =1;
              $author =Auth::id();
              uploadFile($file,$src,$srcType,$fileUse,$author);
            }
            ///////Image Upload End////////////
      
            $user->status=$r->status?true:false;
            $user->save();
      
            Session()->flash('success','Your Updated Are Successfully Done!');
            return redirect()->back();
    
          }
          //Update User Profile End
    
          //Update User Password Change Start
          if($action=='change-password' && $r->isMethod('post')){
       
            $validator = Validator::make($r->all(), [
                'old_password' => 'required|string|min:8',
                'password' => 'required|string|min:8|confirmed|different:old_password',
            ]);
           
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            if(Hash::check($r->old_password, $user->password)){
              $user->password_show=$r->password;
              $user->password=Hash::make($r->password);
              $user->update();
             
              Session()->flash('success','Your Are Successfully Done');
              return redirect()->back();
            }else{
            Session()->flash('error','Current Password Are Not Match');
            return redirect()->back();
            }
    
          }
          //Update User Password Change End
    
          //Delete User Start
          if($action=='delete'){
            if($user->id=='621' || $user->id=='674' || $user->id=='671'){
                Session()->flash('error','This User can not Delete!');
                return redirect()->back();
            }
            $userFiles =Media::latest()->where('src_type',6)->where('src_id',$user->id)->get();
            foreach ($userFiles as $media) {
                if(File::exists($media->file_url)){
                      File::delete($media->file_url);
                  }
                $media->delete();
            }
            $user->delete();
            Session()->flash('success','User Are Deleted Successfully Deleted!');
            return redirect()->back();
          }
          //Delete User End
    
        return view(adminTheme().'users.wholesale-customers.editUser',compact('user'));

    }

    public function subscribes(Request $r){

      // Filter Action Start
        if($r->action){
          if($r->checkid){

          PostExtra::latest()->where('type',2)->whereIn('id',$r->checkid)->delete();

          Session()->flash('success','Action Successfully Completed!');

          }else{
            Session()->flash('info','Please Need To Select Minimum One Post');
          }

          return redirect()->back();
        }

        //Filter Action End

      $subscribes =PostExtra::where('type',1)
      ->where(function($q) use ($r){

        if($r->search){
              $q->where('name','LIKE','%'.$r->search.'%');
          }
          
          if($r->startDate || $r->endDate)
          {
              if($r->startDate){
                  $from =$r->startDate;
              }else{
                  $from=Carbon::now()->format('Y-m-d');
              }

              if($r->endDate){
                  $to =$r->endDate;
              }else{
                  $to=Carbon::now()->format('Y-m-d');
              }

              $q->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);
          }

      })
      ->select(['id','name','created_at'])
      ->paginate(50)->appends([
        'search'=>$r->search,
        'startDate'=>$r->startDate,
        'endDate'=>$r->endDate,
      ]);

      return view(adminTheme().'users.subscribes.subscribeAll',compact('subscribes','r'));
    }


  public function userRoles(Request $r){

    $roles =Permission::latest()
    ->where('status','active')
    ->where(function($q) use($r) {

        if($r->search){
            $q->where('search_key','LIKE','%'.$r->search.'%');
        }
        
        if($r->startDate || $r->endDate)
        {
            if($r->startDate){
                $from =$r->startDate;
            }else{
                $from=Carbon::now()->format('Y-m-d');
            }

            if($r->endDate){
                $to =$r->endDate;
            }else{
                $to=Carbon::now()->format('Y-m-d');
            }

            $q->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);

        }

    })
    ->select(['id','name','created_at','addedby_id','status'])
      ->paginate(25)->appends([
        'search'=>$r->search,
        'startDate'=>$r->startDate,
        'endDate'=>$r->endDate,
      ]);

    return view(adminTheme().'users.roles.userRoles',compact('roles'));
  }


  public function userRoleAction(Request $r,$action,$id=null){
      
      if($action=='create'){
        $role  =Permission::where('addedby_id',Auth::id())->where('status','temp')->first();
        if(!$role){
          $role = new Permission();
          $role->status='temp';
          $role->addedby_id=Auth::id();
        }
        $role->created_at=Carbon::now();
        $role->save();

        return redirect()->route('admin.userRoleAction',['edit',$role->id]);
    }

    $role=Permission::find($id);
    if(!$role){
      Session()->flash('error','This Role Are Not Found');
      return redirect()->route('admin.userRoles');
    }
    
    if($action=='update'){

      //Role Update
      $check = $r->validate([
          'name' => 'required|max:100',
      ]);

      $role->name =$r->name;
      if($role->id==1){
    //   $role->permission =$r->permission;
      }else{
        $role->permission =$r->permission;  
      }
      $role->status ='active';
      $role->save();

      Session()->flash('success','Role Updated Are Successfully Done!');
      return redirect()->back();
    }
    
    if($action=='delete'){
      //Role Delete
      $role->delete();

      Session()->flash('success','Role Deleted Are Successfully Done!');
      return redirect()->route('admin.userRoles');

    }

    return view(adminTheme().'users.roles.userRoleEdit',compact('role'));


  }

  // User Management Function End


  // Setting Function Start
  public function setting($type){

    $general =General::first();
    if($type=='general'){
      return view(adminTheme().'setting.general',compact('general','type'));
    }else if($type=='mail'){
      return view(adminTheme().'setting.mail',compact('general','type'));
    }else if($type=='sms'){
      return view(adminTheme().'setting.sms',compact('general','type'));
    }else if($type=='social'){
      return view(adminTheme().'setting.social',compact('general','type'));
    }else if($type=='document'){
      return view(adminTheme().'setting.document',compact('general','type'));
    }else if($type=='support'){
      return view(adminTheme().'setting.support',compact('general','type'));
    }else if($type=='logo'){

      if(File::exists($general->logo)){
            File::delete($general->logo);
      }
      $general->logo=null;
      $general->save();

      Session()->flash('success','Logo Deleted Are Successfully Done!');
      return redirect()->back();
    }else if($type=='pos_logo'){

      if(File::exists($general->pos_logo)){
            File::delete($general->pos_logo);
      }
      $general->pos_logo=null;
      $general->save();

      Session()->flash('success','Logo Deleted Are Successfully Done!');
      return redirect()->back();
    }else if($type=='favicon'){
       if(File::exists($general->favicon)){
            File::delete($general->favicon);
      }
      $general->favicon=null;
      $general->save();

      Session()->flash('success','Logo Deleted Are Successfully Done!');
      return redirect()->back();
    }else if($type=='banner'){
       if(File::exists($general->banner)){
            File::delete($general->banner);
      }
      $general->banner=null;
      $general->save();

      Session()->flash('success','Banner Deleted Are Successfully Done!');
      return redirect()->back();
    }else if($type=='cache-clear'){
      
      Artisan::call('cache:clear');
      Artisan::call('config:clear');
      Artisan::call('config:cache');
      Artisan::call('view:clear');
      Artisan::call('route:clear');
      Artisan::call('clear-compiled');

      Session()->flash('success','Cache Clear Are Successfully Done!');

      return redirect(url(adminTheme().'/admin/dashboard'));

    }else{
      return redirect()->route('admin.setting','general','type');
    }

  }


  public function settingUpdate(Request $r,$type){


    $general =General::first();

    if($type=='general'){

        $check = $r->validate([
            'title' => 'nullable|max:100',
            'subtitle' => 'nullable|max:200',
            'mobile' => 'nullable|max:100',
            'email' => 'nullable|max:100',
            'website' => 'nullable|max:100',
            'meta_author' => 'nullable|max:100',
            'patho_store_id' => 'nullable|max:100',
            'patho_client_id' => 'nullable|max:100',
            'patho_client_secret' => 'nullable|max:100',
            'patho_username' => 'nullable|max:100',
            'patho_password' => 'nullable|max:100',
            'pathao_webhook' => 'nullable|max:100',
            'carrybee_username' => 'nullable|max:100',
            'carrybee_password' => 'nullable|max:100',
            'carrybee_webhook' => 'nullable|max:100',
            'steadfast_api_key' => 'nullable|max:100',
            'steadfast_secret_key' => 'nullable|max:100',
            'fb_pixel_id' => 'nullable|max:100',
            'meta_title' => 'nullable|max:200',
            'meta_description' => 'nullable|max:200',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pos_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $general->title=$r->title;
        $general->subtitle=$r->subtitle;
        $general->mobile=$r->mobile;
        $general->email=$r->email;
        $general->address_one=$r->address_one;
        $general->address_two=$r->address_two;
        $general->website=$r->website;
        $general->patho_store_id=$r->patho_store_id;
        $general->patho_client_id=$r->patho_client_id;
        $general->patho_client_secret=$r->patho_client_secret;
        $general->patho_username=$r->patho_username;
        $general->patho_password=$r->patho_password;
        $general->pathao_webhook=$r->pathao_webhook;
        $general->carrybee_username=$r->carrybee_username;
        $general->carrybee_password=$r->carrybee_password;
        $general->carrybee_webhook=$r->carrybee_webhook;
        $general->steadfast_api_key=$r->steadfast_api_key;
        $general->steadfast_secret_key=$r->steadfast_secret_key;
        $general->meta_author=$r->meta_author;
        $general->meta_title=$r->meta_title;
        $general->meta_keyword=$r->meta_keyword;
        $general->meta_description=$r->meta_description;
        $general->script_head=$r->script_head;
        $general->script_body=$r->script_body;
        $general->custom_css=$r->custom_css;
        $general->custom_js=$r->custom_js;
        $general->copyright_text=$r->footer_text;
        $general->fb_pixel_id=$r->fb_pixel_id;
        $general->fb_access_token=$r->fb_access_token;
        

        ///////Image UploadStart////////////

        if($r->hasFile('logo')){

          $file=$r->logo;

          if(File::exists($general->logo)){
                File::delete($general->logo);
          }

          $name = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());
          $fullName = basename($file->getClientOriginalName());
          $ext =$file->getClientOriginalExtension();
          $size =$file->getSize();

          $year =carbon::now()->format('Y');
          $month =carbon::now()->format('M');
          $folder = $month.'_'.$year;

          $img =time().'.'.uniqid().'.'.$file->getClientOriginalExtension();
          $path ="medies/".$folder;
          $fullPath ="medies/".$folder.'/'.$img;

          $file->move(public_path($path), $img);
          $general->logo =$fullPath;

      }
        
        ///////pos_logo Image UploadStart////////////

        if($r->hasFile('pos_logo')){

          $file=$r->pos_logo;

          if(File::exists($general->pos_logo)){
                File::delete($general->pos_logo);
          }

          $name = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());
          $fullName = basename($file->getClientOriginalName());
          $ext =$file->getClientOriginalExtension();
          $size =$file->getSize();

          $year =carbon::now()->format('Y');
          $month =carbon::now()->format('M');
          $folder = $month.'_'.$year;

          $img =time().'.'.uniqid().'.'.$file->getClientOriginalExtension();
          $path ="medies/".$folder;
          $fullPath ="medies/".$folder.'/'.$img;

          $file->move(public_path($path), $img);
          $general->pos_logo =$fullPath;

      }

         ///////Image UploadStart////////////

        if($r->hasFile('favicon')){

            $file=$r->favicon;

            if(File::exists($general->favicon)){
                  File::delete($general->favicon);
            }

            $name = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());
            $fullName = basename($file->getClientOriginalName());
            $ext =$file->getClientOriginalExtension();
            $size =$file->getSize();

            $year =carbon::now()->format('Y');
            $month =carbon::now()->format('M');
            $folder = $month.'_'.$year;

            $img =time().'.'.uniqid().'.'.$file->getClientOriginalExtension();
            $path ="medies/".$folder;
            $fullPath ="medies/".$folder.'/'.$img;
            
            $file->move(public_path($path), $img);
            $general->favicon =$fullPath;

        }
        
        if($r->hasFile('banner')){

            $file=$r->banner;

            if(File::exists($general->banner)){
                  File::delete($general->banner);
            }

            $name = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());
            $fullName = basename($file->getClientOriginalName());
            $ext =$file->getClientOriginalExtension();
            $size =$file->getSize();

            $year =carbon::now()->format('Y');
            $month =carbon::now()->format('M');
            $folder = $month.'_'.$year;

            $img =time().'.'.uniqid().'.'.$file->getClientOriginalExtension();
            $path ="medies/".$folder;
            $fullPath ="medies/".$folder.'/'.$img;
            
            $file->move(public_path($path), $img);
            $general->banner =$fullPath;

        }
        $general->commingsoon_mode=$r->commingsoon_mode?true:false;
        $general->save();

        Session()->flash('success','General Updated Are Successfully Done!');

    }


    if($type=='mail'){

      $check = $r->validate([
            'mail_from_address' => 'nullable|max:100',
            'mail_from_name' => 'nullable|max:100',
            'mail_driver' => 'nullable|max:100',
            'mail_host' => 'nullable|max:100',
            'mail_port' => 'nullable|max:100',
            'mail_encryption' => 'nullable|max:100',
            'mail_username' => 'nullable|max:100',
            'mail_password' => 'nullable|max:100',
            'admin_mails' => 'nullable|max:1000',
        ]);

      $general->mail_from_address=$r->mail_from_address;
      $general->mail_from_name=$r->mail_from_name;
      $general->mail_driver=$r->mail_driver;
      $general->mail_host=$r->mail_host;
      $general->mail_port=$r->mail_port;
      $general->mail_encryption=$r->mail_encryption;
      $general->mail_username=$r->mail_username;
      $general->mail_password=$r->mail_password;
      $general->admin_mails=$r->admin_mails;
      $general->mail_status=$r->mail_status?true:false;
      $general->register_mail_user=$r->register_mail_user?true:false;
      $general->register_mail_author=$r->register_mail_author?true:false;
      $general->forget_password_mail_user=$r->forget_password_mail_user?true:false;
      $general->register_verify_mail_user=$r->register_verify_mail_user?true:false;
      $general->save();

      Session()->flash('success','Mail Updated Are Successfully Done!');

    }

    if($type=='sms'){

      $check = $r->validate([
            'sms_type' => 'nullable|max:50',
            'sms_senderid' => 'nullable|max:50',
            'sms_url_nonmasking' => 'nullable|max:200',
            'sms_url_masking' => 'nullable|max:200',
            'sms_username' => 'nullable|max:50',
            'sms_password' => 'nullable|max:50',
            'admin_numbers' => 'nullable|max:1000',
      ]);

      $general->sms_type=$r->sms_type;
      $general->sms_senderid=$r->sms_senderid;
      $general->sms_url_nonmasking=$r->sms_url_nonmasking;
      $general->sms_url_masking=$r->sms_url_masking;
      $general->sms_username=$r->sms_username;
      $general->sms_password=$r->sms_password;
      $general->admin_numbers=$r->admin_numbers;
      $general->sms_status=$r->sms_status?true:false;
      $general->register_sms_user=$r->register_sms_user?true:false;
      $general->register_sms_author=$r->register_sms_author?true:false;
      $general->forget_password_sms_user=$r->forget_password_sms_user?true:false;
      $general->register_verify_sms_user=$r->register_verify_sms_user?true:false;
      $general->save();

      Session()->flash('success','SMS Updated Are Successfully Done!');

    }

    if($type=='social'){
      

      $check = $r->validate([
            'facebook_link' => 'nullable|max:200',
            'twitter_link' => 'nullable|max:200',
            'instagram_link' => 'nullable|max:200',
            'linkedin_link' => 'nullable|max:200',
            'pinterest_link' => 'nullable|max:200',
            'youtube_link' => 'nullable|max:200',
            'fb_app_id' => 'nullable|max:100',
            'fb_app_secret' => 'nullable|max:100',
            'fb_app_redirect_url' => 'nullable|max:200',
            'google_client_id' => 'nullable|max:100',
            'google_client_secret' => 'nullable|max:100',
            'google_client_redirect_url' => 'nullable|max:200',
            'tw_app_id' => 'nullable|max:100',
            'tw_app_secret' => 'nullable|max:100',
            'tw_app_redirect_url' => 'nullable|max:200',
        ]);

        $general->facebook_link=$r->facebook_link;
        $general->twitter_link=$r->twitter_link;
        $general->instagram_link=$r->instagram_link;
        $general->linkedin_link=$r->linkedin_link;
        $general->pinterest_link=$r->pinterest_link;
        $general->youtube_link=$r->youtube_link;
        $general->fb_app_id=$r->fb_app_id;
        $general->fb_app_secret=$r->fb_app_secret;
        $general->fb_app_redirect_url=$r->fb_app_redirect_url;
        $general->google_client_id=$r->google_client_id;
        $general->google_client_secret=$r->google_client_secret;
        $general->google_client_redirect_url=$r->google_client_redirect_url;
        $general->tw_app_id=$r->tw_app_id;
        $general->tw_app_secret=$r->tw_app_secret;
        $general->tw_app_redirect_url=$r->tw_app_redirect_url;
        $general->save();

        Session()->flash('success','Advance Updated Are Successfully Done!');

    }

    
    return redirect()->route('admin.setting',$type);


  }

  // Setting Function End
    


}
