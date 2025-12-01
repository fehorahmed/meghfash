<?php

namespace App\Http\Controllers\Customer;

use Auth;
use Hash;
use PDF;
use Session;
use Response;
use Cookie;
use Str;
use File;
use Validator;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Country;
use App\Models\Cart;
use App\Models\Review;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Media;
use App\Models\General;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderReturnItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
    
      
    public function __construct(){
        $this->middleware('cart');
    }

    public function dashboard(Request $request){
        $user =Auth::user();

        $user->image_url=asset($user->image());
        $user->dristicName=$user->districtN?$user->districtN->name:null;
        $user->cityName=$user->cityN?$user->cityN->name:null;
        $user->allOrder=$user->orders()->where('order_type','customer_order')->count();
        $user->pendingOrder=$user->orders()->where('order_type','customer_order')->where('order_status', 'pending')->count();
        $user->contrimedOrder=$user->orders()->where('order_type','customer_order')->where('order_status', 'confirmed')->count();
        $user->shippedOrder=$user->orders()->where('order_type','customer_order')->where('order_status', 'shipped')->count();
        $user->completedOrder=$user->orders()->where('order_type','customer_order')->where('order_status', 'delivered')->count();

        return Inertia::render('User/Dashboard',compact('user'));
    }

    public function profile(Request $r){
        $user =Auth::user();
       
        if($r->isMethod('post')){



            // $r->validate([
            //     'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', // Validate file
            // ]);
        
            // if ($r->hasFile('image')) {
            //     // $file = $request->file('image');
            //     // $path = $file->store('uploads', 'public'); // Save file to storage/app/public/uploads
        
            //     return response()->json([
            //         'message' => 'Image uploaded successfully!',
            //     ]);
            // }
        
            // return response()->json([
            //     'errors' => ['image' => 'Image upload failed!'],
            // ], 422);

          

            if($r->hasFile('image')){
                $check = $r->validate([
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                $file =$r->image;
                $src  =$user->id;
                $srcType  =6;
                $fileUse  =1;
                $author=$user->id;
                uploadFile($file,$src,$srcType,$fileUse,$author);
                
                return response()->json([
                  'success' => true,
                'message' => 'Your profile Photo successfully Uploade.',
                ]);
                    


            }
            
            ///////Image Upload End////////////


            $check = $r->validate([
                'name' => 'required|max:100',
                'email' => 'nullable|max:100|unique:users,email,'.$user->id,
                'mobile' => 'required|max:20|unique:users,mobile,'.$user->id,
                'district' => 'nullable|numeric',
                'city' => 'nullable|numeric',
                'postal_code' => 'nullable|max:20',
                'address' => 'nullable|max:200',
                // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $user->name =$r->name;
            $user->mobile =$r->mobile;
            $user->email =$r->email;
            $user->district =$r->district;
            $user->city =$r->city;
            $user->address_line1 =$r->address;
            $user->postal_code =$r->postal_code;


            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Your profile update successfully done.',
                'user' => $user, 
            ]);


        }




        if($r->district_id){

        $datas=Country::where('parent_id',$r->district_id)->get(['id','name']);
          return Response()->json([
            'success' => true,
            'datas' => $datas,
          ]);
      }


        $district=geoData(3);

        $user->image_url=asset($user->image());
        
        

        

    return Inertia::render('User/Profile',compact('district','user'));
    }
    

    public function changePassword(Request $r){
        $user = Auth::user();
        if($r->isMethod('post')){
            $check = $r->validate([
                'current_password' => 'required|string|min:8',
                'password' => 'required|string|min:8|confirmed|different:current_password',
            ]);
            
            if (Hash::check($r->current_password, $user->password)) {
              $user->password = Hash::make($r->password);
              $user->password_show = $r->password;
              $user->save();
      
              return redirect()->back()
              ->withErrors(['status'=>'success','message' => 'Your password has been changed successfully.']);
  
            }else{
  
              return redirect()->back()
                  ->withErrors(['status'=>'error','message' => 'Current password does not match.']);
            }
  
            if(Hash::check($r->current_password, $user->password)){
              $user->password_show=$r->password;
              $user->password=Hash::make($r->password);
              $user->save();
              return back()->withErrors(['status' => 'success','message' => 'Your password has been changed successfully.']);
              // return back()->with('status', 'success')->with('message', 'Your password has been changed successfully.');
            }else{
              return back()->withErrors(['status' => 'error','message' => 'Carrent Password Are Not Match']);
            }
  
          }

        return Inertia::render('User/ChangePassword');

    }

    public function myOrders(Request $r){

        $orders = Auth::user()->orders()->where('order_type','customer_order')
        ->latest()
        ->select(['id','invoice','order_status','payment_status','grand_total','created_at'])
        ->paginate(5);

        collect($orders->items())->map(function($item){
            $item->createdAt = $item->created_at->format('F m, Y');
            $item->paymentStatus = ucfirst($item->payment_status);
            $item->orderStatus = ucfirst($item->order_status);
            $item->grandTotal = priceFullFormat($item->grand_total);
            return $item;
        });

        return Inertia::render('User/Orders',compact('orders'));

    }

    public function orderDetails($invoice){

        $order = Order::where('order_type','customer_order')->where('invoice',$invoice)->first();
        if(!$order){
            Session::flash('error','This Order Invoice Are Not Found');
            return back();
        }


        // return view(welcomeTheme().'customer.invoice',compact('order'));
    }



    public function myReviews(){
        
        $reviews = OrderItem::latest()->whereHas('order',function($q){
                        $q->where('order_status','delivered');
                        $q->where('user_id',Auth::id());
                    })
                    ->select(['id','order_id','product_name','product_id','sku_value'])
                    ->paginate(10);
        
        collect($reviews->items())->map(function($item){
            $item->image_url = asset($item->image());
            $item->link_url = $item->product?route('productView',$item->product->slug):null;
            $item->variants = $item->itemAttributes();
            $item->review_rating = $item->review?$item->review->rating:0;
            $item->review_content = $item->review?$item->review->content:null;
            unset($item->product);
            return $item;
        });
        return Inertia::render('User/Reviews',compact('reviews'));
    }
    
    public function orderReview(Request $r,$id){
        
        $item = OrderItem::find($id);
        if(!$item){
            Session::flash('error','This Order Item Are Not Found');
            return back();
        }
        if($r->isMethod('post')){

            $rules = [
                'rating' => 'required|numeric|between:1,5',
                'review' => 'required|max:500',
              ];
              
            $validator = Validator::make($r->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->messages(), // Send errors separately
                ], 400); // Use 400 for client-side validation errors
            }

            $review =$item->review;
            if(!$review){
                $review =new Review();
                $review->type =0;
                $review->src_id =$item->product_id;
                $review->parent_id =$item->id;
                $review->status ='temp';
                $review->save();
            }
            $review->rating=$r->rating;
            $review->content=$r->review;
            $review->status ='active';
            $review->addedby_id =Auth::id();
            $review->save();

            return response()->json([
                'success' => true,
                'message' => 'Than you for your review.',
            ]);

        }

        $item->image_url = asset($item->image());
        $item->variants = $item->itemAttributes();
        $item->review_rating = $item->review?$item->review->rating:5;
        $item->review_content = $item->review?$item->review->content:null;
        
        return Inertia::render('User/ReviewsEdit',compact('item'));

    }


    



}
