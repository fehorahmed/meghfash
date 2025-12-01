<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Str;
use Hash;
use Mail;
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
use App\Models\Country;
use App\Models\PostExtra;
use App\Models\InventoryStock;
use App\Models\Review;
use App\Models\General;
use App\Models\Media;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderReturnItem;
use App\Models\Attribute;
use App\Models\Permission;
use App\Models\PostAttribute;
use GuzzleHttp\Client;

use App\Providers\PathaoCourierService;

use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    
    protected $pathaoService;

    public function __construct(PathaoCourierService $pathaoService){
        $this->pathaoService = $pathaoService;
    }
    
	public function orders(Request $r,$status=null){
	    
	    if(Auth::id()==663){
	        
	       $action='carrybee';
	       $cityId='1';
	       //$ok =$this->pathaoService->getZones($action,$cityId);
	       //$ok =$this->pathaoService->getZones($action,$cityId);
	       //$ok =$this->pathaoService->getDistricts($action);
	       //$ok =$this->pathaoService->getStores($action);
	       //$ok =$this->pathaoService->authenticate2($action);
	       //return $ok;
	        
	    // $orders = Order::where('order_type', 'customer_order')
        //     //   ->where('order_status', 'confirmed')
        //     //   ->where('courier', 'Pathao')
        //     //   ->whereNull('branch_id')
        //       ->where('created_at', '<=', '2024-12-31')
        //     //   ->where('auto_courier_check',0)
        //     //   ->limit(50)
        //       ->get();
           
        //     return $orders;
	        
	       // $orders = Order::where('order_type', 'customer_order')
        //       ->where('order_status', 'confirmed')
        //       ->where('courier', 'Pathao')
        //       ->whereNotNull('courier_id')
        //     //   ->where('created_at', '>=', now()->subDays(7))
        //       ->where('auto_courier_check',0)
        //     //   ->limit(50)
        //       ->get();
   
        //     if($orders->count() > 0){
        //         foreach($orders as $order){
        //             // $status = $this->pathaoService->StatusCourierOrder($order);
        //             // if(isset($status['error'])) {
        //             //     $this->pathaoService->authenticate();
        //             // }
                    
        //             $order->auto_courier_check=true;
        //             $order->save();   
        //         }
        //     }else{
        //         // return 'd';
        //      Order::where('order_type', 'customer_order')
        //       ->where('order_status', 'confirmed')
        //       ->where('courier', 'Pathao')
        //       ->whereNotNull('courier_id')
        //       ->where('auto_courier_check',1)
        //       ->update(['auto_courier_check'=>false]);
        //     }
	        
	       // return $orders;
	       // foreach($orders as $order){
	            
	       //     $order->branch_id =general()->online_store_id;
	       //     $order->save();
	            
	       //    // $status = $this->pathaoService->StatusCourierOrder($order);
        //         //         if(isset($status['error'])) {
        //         //             $this->pathaoService->authenticate();
        //         //         }
	       // }
	       // return 'success';
	    }
	    
        
        // Filter Action Start
        if($r->action){
            if($r->checkid){
                
                $datas=Order::latest()->where('order_type','customer_order')->whereIn('id',$r->checkid);
                if($r->action==1){
                    
                    foreach($datas->where('order_status','<>','pending')->get() as $data){
                        $hasStock =$this->getStockAdjustment($data,'pending');
                        if($hasStock!='stockout'){
                            $data->order_status='pending';
                            $data->save();
                        }
                    }
                    
                }elseif($r->action==2){
                    
                    foreach($datas->where('order_status','<>','confirmed')->get() as $data){
                        $hasStock =$this->getStockAdjustment($data,'confirmed');
                        if($hasStock!='stockout'){
                            $data->order_status='confirmed';
                            $data->save();
                        }
                    }
                    
                }elseif($r->action==3){
                    
                    foreach($datas->where('order_status','<>','shipped')->get() as $data){
                        $hasStock =$this->getStockAdjustment($data,'shipped');
                        if($hasStock!='stockout'){
                            $data->order_status='shipped';
                            $data->save();
                        }
                    }
                    
                }elseif($r->action==4){
                    
                    foreach($datas->where('order_status','<>','delivered')->get() as $data){
                        $hasStock =$this->getStockAdjustment($data,'delivered');
                        if($hasStock!='stockout'){
                            $data->order_status='delivered';
                            $data->save();
                        }
                    }
                    
                }elseif($r->action==5){
                    
                    foreach($datas->where('order_status','<>','cancelled')->get() as $data){
                        $hasStock =$this->getStockAdjustment($data,'cancelled');
                        if($hasStock!='stockout'){
                            $data->order_status='cancelled';
                            $data->save();
                        }
                    }
                    
                }elseif($r->action==6){
                    foreach($datas->get(['id']) as $data){
                        
                        $data->transections()->delete();
                        $data->items()->delete();
                        $data->delete();
                    }
                }elseif($r->action==7){
                    
                    $datas = $datas->get();
     
                    return view(adminTheme().'orders.multiInvoices',compact('datas'));
                }
            Session()->flash('success','Action Successfully Completed!');
            }else{
              Session()->flash('info','Please Need To Select Minimum One Post');
            }
            return redirect()->back();
        }
      
        //Filter Action End

        if($status==null || $status=='pending-payment' || $status=='unpaid' || $status=='pending' || $status=='confirmed' || $status=='shipped' || $status=='delivered' || $status=='returned' || $status=='cancelled'){

            $orders =Order::latest()->where('order_type','customer_order')->where('order_status','<>','temp')
            ->where(function($qq)  use ($status,$r)  {
                if($status){
                    if($status=='pending-payment'){
                        $qq->where('payment_method',null);
                    }else if($status=='unpaid'){
                        $qq->whereIn('payment_status',['unpaid','partial']);
                    }else{
                        $qq->where('order_status',$status);
                    }
                }
                
                if($r->search){
                   $qq->where('invoice','LIKE','%'.$r->search.'%')->orWhere('email','LIKE','%'.$r->search.'%')->orWhere('mobile','LIKE','%'.$r->search.'%'); 
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

                
            })
            ->paginate(25)->appends(['search'=>$r->search,'status'=>$r->status,'startDate'=>$r->startDate,'endDate'=>$r->endDate]);

            //Total Count Results
            $totals = DB::table('orders')
            ->where('order_type','customer_order')
            ->selectRaw('count(*) as total')
            ->selectRaw("count(case when order_status = 'pending' then 1 end) as pending")
            ->selectRaw("count(case when order_status = 'confirmed' then 1 end) as confirmed")
            ->selectRaw("count(case when order_status = 'shipped' then 1 end) as shipped")
            ->selectRaw("count(case when order_status = 'delivered' then 1 end) as delivered")
            ->selectRaw("count(case when order_status = 'returned' then 1 end) as returned")
            ->selectRaw("count(case when order_status = 'cancelled' then 1 end) as cancelled")
            ->first();

            return view(adminTheme().'orders.ordersAll',compact('orders','totals','status'));


        }else{
            Session()->flash('error','Order Status Un-known Type');
            return redirect()->route('admin.orders');
        }

    }
    
    public function getStockAdjustment($order, $orderStatus){
        
            $previousStatus = $order->order_status;
            $newStatus = $orderStatus;
            if (in_array($newStatus, ['pending', 'cancelled']) && in_array($previousStatus, ['confirmed', 'delivered', 'shipped'])) {
                //   {{$item->itemVariantData()}}
                foreach($order->items as $item){
                    $item->order_status=$order->order_status;
                    if($product=$item->product){
                        $variantId =null;
                        if($product->variation_status){
                            if($data =$item->itemVariantData()){
                                $data->quantity +=$item->quantity;
                                $data->save();
                                $variantId =$data->id;
                            }
                        }
                        $store =$product->warehouseStores()->where('branch_id',$order->branch_id)->where('variant_id',$variantId)->first();
                        if($store){
                          $store->quantity +=$item->quantity;
                          $store->save();
                        }
                        $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                        $product->save();
                    }
                    $item->save();
                }
            }
        
            // Conditions for increasing stock ("plus")
            if (in_array($newStatus, ['confirmed', 'delivered', 'shipped']) && in_array($previousStatus, ['temp','pending', 'cancelled'])){
                
                $stockStatus=true;
                foreach($order->items as $item){
                    if($stockStatus==true){
                        if($product=$item->product){
                            if($item->quantity > $product->warehouseStock($order->branch_id,$item->variant_id)){
                                $stockStatus=false;
                            }
                        }
                        // if($item->quantity > $item->itemStock()){
                        //     $stockStatus=false;
                        // }
                    }
                }
                
                if($stockStatus){
                    
                    foreach($order->items as $item){
                        $item->order_status=$order->order_status;
                        if($product=$item->product){
                            
                            $variantId=null;
                            if($product->variation_status){
                                if($data =$item->itemVariantData()){
                                    $data->quantity -=$item->quantity;
                                    $data->save();
                                    
                                    $variantId =$data->id;
                                }
                            }
                            
                            $store =$product->warehouseStores()->where('branch_id',$order->branch_id)->where('variant_id',$variantId)->first();
                            if($store){
                              $store->quantity -=$item->quantity;
                              $store->save();
                            }
                            
                            $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                            $product->save();
                            
                        } 
                    }
                    
                }else{
                return 'stockout';
                }
               
                
            }
        
            // // No stock change cases
            // if (
            //     ($previousStatus == 'confirmed' && $newStatus == 'delivered') ||
            //     ($previousStatus == 'delivered' && $newStatus == 'confirmed') ||
            //     ($previousStatus == 'cancelled' && $newStatus == 'pending')
            // ) {
            //     return 'no_change';
            // }
        
            return 'no_change';
    }

    public function ordersAction(Request $r,$action,$id=null){
        
        if($action=='create'){
            $order =Order::where('order_type','customer_order')->where('order_status','temp')->where('addedby_id',Auth::id())->first();
            if(!$order){
                $order =new Order();
                $order->order_type ='customer_order';
                $order->order_status ='temp';
                $order->addedby_id =Auth::id();
                $order->save();
            }
            $order->branch_id =general()->online_store_id;
            $order->created_at =Carbon::now();
            $order->invoice =$order->created_at->format('Ymd').$order->id;
            $order->save();
            
            return redirect()->route('admin.ordersAction',['edit',$order->id]);
            
        }
        
        $order =Order::find($id);
        if(!$order){
            Session()->flash('error','Order Are Not Found');
            return redirect()->route('admin.orders');
        }
        
        
        
        if(Auth::id()==663){
            // return $order;
            // $status = $this->pathaoService->authenticate2('Pathao');
            // $status = $this->pathaoService->StatusCourierOrder($order);
            // $accessToken = $this->authenticate2('Pathao');
            // return $status;
            // $order->courier=null;
            // $order->courier_status=null;
            // $order->courier_data=null;
            // $order->courier_id=null;
            // $order->save();
            
            // return $this->pathaoService->placeNewOrder($order);
            
            // foreach($order->items as $i=>$item){
            //         if($stockStatus==true){
            //             if($product=$item->product){
                  
                   
            //                 if($item->quantity > $product->warehouseStock($order->branch_id,$item->variant_id)){
            //                     $stockStatus=false;
            //                 }
            //             }
            //             // if($item->quantity > $item->itemStock()){
            //             //     $stockStatus=false;
            //             // }
            //         }
            //     }
                
            // return 'sdf';
            
            // $order->transections()->delete();
            // $order->items()->delete();
            // $order->delete();
            // return '$st';
            //     // return OrderItem::whereHas('order',function($q){$q->whereIn('order_type',['customer_order','pos_order','wholesale_order']);})->where('variant_id',null)->get();
            //     // foreach(OrderItem::whereHas('order',function($q){$q->whereIn('order_type',['customer_order','pos_order','wholesale_order']);})->where('variant_id',null)->get() as $item){
            //     //     $variant =$item->itemVariantData();
            //     //     if($variant){
            //     //         $item->variant_id=$variant->id;
            //     //         $item->barcode=$variant->barcode;
            //     //         $item->save();
            //     //     }
            //     // }
            //     // return 'sto';
        
        }
        
        
        $message=null;
        
        if($action=='user-courier-status'){
            $number =$r->key?:'0174522';
            $status =null;
            $data = $this->pathaoService->userDeliveryStatus($number);
            if ($data && isset($data['data'])) {
                
                if(isset($data['data']['customer'])){
                    
                    $rate = $data['data']['success_rate'] ?? 0;
                    $delivery = $data['data']['customer']['total_delivery'] ?? 0;
                    $processed = $data['data']['customer']['successful_delivery'] ?? 0;
                    $returned = $delivery - $processed;
                    $status = [
                        'success_rate' => $rate,
                        'processed' => $processed,
                        'delivered' => $delivery,
                        'returned' => $returned,
                    ];
                }
            
            }
            
            $view =view(adminTheme().'orders.includes.customerCourierStatus',compact('status'))->render();
            
            return Response()->json([
                'success' => true,
                'view' => $view,
                'data' => $data,
            ]); 
        }
        
        if($action=='search-product'){

            $searchProducts =Post::latest()->where('type',2)->where('status','active');
                            
                            $barcode =$r->key;
                            if ($r->key && is_numeric($barcode) && strlen($barcode) > 6) {
                                $searchProducts =$searchProducts
                                    ->where('bar_code','like','%'.$barcode.'%')
                                    ->orWhereHas('productVariationActiveAttributeItems', function ($q) use ($barcode) {
                                        $q->where('stock_status',true)->where('barcode','like','%'.$barcode.'%');
                                    });
                            }else{
                                $searchTerms = preg_split('/\s+/', trim($r->key));
                                $searchProducts =$searchProducts->where(function ($query) use ($searchTerms) {
                                    foreach ($searchTerms as $term) {
                                        $query->where(function ($q) use ($term) {
                                            $q->where('name', 'like', '%' . $term . '%');
                                            $q->orWhere('id', 'like', '%' . $term . '%');
                                        });
                                    }
                                });
                            }
                            
            $searchProducts=$searchProducts->with('productVariationActiveAttributeItems')
                            ->get(['id','variation_status','name', 'purchase_price', 'quantity', 'sku_code', 'bar_code']);
    
            $view =view(adminTheme().'orders.includes.searchResult',compact('searchProducts','order'))->render();
            
            return Response()->json([
                'success' => true,
                'view' => $view,
            ]);

        }
         
        if($action=='district-filter'){
            
            $datas=Country::where('parent_id',$r->key?:0)->get(['id','name']);
            $geoData =View('geofilter',compact('datas'))->render();
            
            $order->district=$r->key?:null;

            $shippingCharge=0;
            if($order->total_price < 1000 || $order->shipping_apply){
                if($order->district==73){
                $shippingCharge=general()->inside_dhaka_shipping_charge?:0;
                }else{
                $shippingCharge=general()->outside_dhaka_shipping_charge?:0;
                }
            }
            
            if($shippingCharge > 0 && $order->shipping_free){
                $shippingCharge =0;   
            }
            
            $order->shipping_charge =$shippingCharge;
            
            $order->grand_total =($order->total_price + $order->shipping_charge + $order->tax) - ($order->coupon_discount+$order->adjustment_amount);
            if($order->grand_total >= $order->paid_amount){
                $order->due_amount=$order->grand_total-$order->paid_amount;
                $order->extra_amount=0;
            }else{
                $order->due_amount=0; 
                $order->extra_amount=$order->paid_amount-$order->grand_total; 
            }
            
            if($order->due_amount==0){
            $order->payment_status='paid';
            }elseif($order->due_amount==$order->grand_total){
            $order->payment_status='unpaid';
            }else{
            $order->payment_status='partial';
            }
            $order->save();
            
            
            
            $infoView =view(adminTheme().'orders.includes.orderSummery',compact('order'))->render();

            return response()->json([
                'infoView' => $infoView,
                'geoData' => $geoData,
            ]);
            
        }
        
        if($action=='shipping-apply' || $action=='free-shipping'){
            
            if($action=='shipping-apply'){
                $order->shipping_apply=$order->shipping_apply?false:true;
            }
            
            if($action=='free-shipping'){
                $order->shipping_free=$order->shipping_free?false:true;
            }

            $shippingCharge=0;
            if($order->total_price < 1000 || $order->shipping_apply){
                if($order->district==73){
                $shippingCharge=general()->inside_dhaka_shipping_charge?:0;
                }else{
                $shippingCharge=general()->outside_dhaka_shipping_charge?:0;
                }
            }
            
            if($shippingCharge > 0 && $order->shipping_free){
                $shippingCharge =0;   
            }
            
            
            $order->shipping_charge =$shippingCharge;
            
            $order->grand_total =($order->total_price + $order->shipping_charge + $order->tax) - ($order->coupon_discount+$order->adjustment_amount);
            if($order->grand_total >= $order->paid_amount){
                $order->due_amount=$order->grand_total-$order->paid_amount;
                $order->extra_amount=0;
            }else{
                $order->due_amount=0; 
                $order->extra_amount=$order->paid_amount-$order->grand_total; 
            }
            
            if($order->due_amount==0){
            $order->payment_status='paid';
            }elseif($order->due_amount==$order->grand_total){
            $order->payment_status='unpaid';
            }else{
            $order->payment_status='partial';
            }
            $order->save();
            

            $infoView =view(adminTheme().'orders.includes.orderSummery',compact('order'))->render();

            return response()->json([
                'infoView' => $infoView,
            ]);
            
        }
        
        if($action=='courier-district'){
            $zones =null;
            if($order->courier){
                $cityId = $r->city_id;
                try {
                    $zones = $this->pathaoService->getZones($order->courier,$cityId);
                } catch (\Exception $e) {
                }
            }
            return response()->json([
                'zones' => $zones ?? [],
            ]);
            
        }
        
        if ($action === 'admin-note-add'){

            $existingNotes = $order->admin_note ? json_decode($order->admin_note, true) : [];

            $newNote = [
                $r->note,
                auth()->user()->name ?? 'Admin',
                Carbon::now()->format('Y-m-d H:i:s')
            ];
    
            $existingNotes[] = $newNote;
    
            $order->admin_note = json_encode($existingNotes);
            $order->save();
    
            return response()->json([
                'status' => 'success',
                'note' => $newNote,
                'index' => count($existingNotes) - 1
            ]);
            
        }
        
        if ($action === 'admin-note-remove'){
            $existingNotes = $order->admin_note ? json_decode($order->admin_note, true) : [];
            if (isset($existingNotes[$r->index])) {
                unset($existingNotes[$r->index]);
                $existingNotes = array_values($existingNotes); // Re-index array
                $order->admin_note = json_encode($existingNotes);
                $order->save();
            }
    
            return response()->json(['status' => 'success']);
        }
        
        // if($action=='courier-cancelled'){
            
        //     if($order->courier_id){
            
        //         try {
        //             $cancel =$this->pathaoService->cancelCourierOrder($order->courier_id);
        //             return $cancel;
        //             if (isset($cancel['error'])) {
        //                 $msg='Courier Data cancelled Not Working';
        //             }else{
        //                 $order->courier=null;
        //                 $order->courier_id=null;
        //                 $order->courier_store=null;
        //                 $order->courier_city=null;
        //                 $order->courier_zone=null;
        //                 $order->courier_data=null;
        //                 $order->save();
        //                 $msg='Courier Data cancelled Success';
        //             }
        //         } catch (\Exception $e) {
        //             if ($this->isTokenExpired($e)) {
        //                 $this->pathaoService->authenticate();
        //                 $cancel =$this->pathaoService->cancelCourierOrder($order->courier_id);
        //                 if (isset($cancel['error'])) {
        //                     $msg='Courier Data cancelled Not Working';
        //                 }else{
        //                     $order->courier=null;
        //                     $order->courier_id=null;
        //                     $order->courier_store=null;
        //                     $order->courier_city=null;
        //                     $order->courier_zone=null;
        //                     $order->courier_data=null;
        //                     $order->save();
        //                     $msg='Courier Data cancelled Success';
        //                 }
                       
        //             } else {
        //                 throw $e;
        //                 $msg='Courier Data cancelled get Fail';
        //             }
        //         }
        //     }else{
        //         $msg='The order has not been submitted to the courier yet.';
        //     }
            
        //     Session()->flash('success',$msg);
        //     return redirect()->back();
            
        // }
        
        if($action=='courier-select'){
            
            if($order->courier_id==null){
                $order->courier=$r->key?:null;
                $order->save();
            }
            
            $msg=null;
            $stores=null;
            $districts=null;
            
            if($order->courier && ($order->courier=='Pathao' || $order->courier=='Carrybee')){
                try {
                    $stores = $this->pathaoService->getStores($order->courier);
                    $districts = $this->pathaoService->getDistricts($order->courier);
            
                    // Check for errors safely
                    if ((is_array($stores) && isset($stores['error'])) || (is_array($districts) && isset($districts['error']))) {
                        $msg = 'Courier Data fetch failed.';
                    } else {
                        $msg = 'Courier Data fetched successfully.';
                    }
                } catch (\Exception $e) {
                    throw $e;
                    $msg='Courier Data get Fail';
                }
            }
            
            $view = view(adminTheme().'orders.includes.courierData', compact('order', 'stores','msg','districts'))->render();
            return Response()->json([
                'success' => true,
                'view' => $view,
            ]);       
        }
        
        if($action=='remove-item' || $action=='item-quantity' || $action=='warehouse-select' || $action=='item-price'){
            $item =$order->items()->find($r->item_id);
            if(!$item){
                $message='<span style="color:red;">Product Item Not found</span>';
            }
            
            if($action=='warehouse-select'){
              $order->branch_id=$r->key?:null;
              $order->save();
            }
            
            if($action=='remove-item' && $message==null){
                
                if(in_array($order->order_status, ['confirmed', 'delivered', 'shipped'])){
                    if($product=$item->product){
                        $variantId=null;
                        if($product->variation_status){
                            if($data =$item->itemVariantData()){
                                $data->quantity +=$item->quantity;
                                $data->save();
                                
                                $variantId =$data->id;
                            }
                        }
                        
                        $store =$product->warehouseStores()->where('branch_id',$order->branch_id)->where('variant_id',$variantId)->first();
                        if($store){
                          $store->quantity +=$item->quantity;
                          $store->save();
                        }
                        
                        $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                        $product->save();
                        
                    }
                }
                
                $item->delete();
            
            }
            
            if($action=='item-quantity' && $message==null){
                
                $oldQty =$item->quantity;
                $qty =$r->key?:0;
                $status =true;
                
                if(in_array($order->order_status, ['confirmed', 'delivered', 'shipped'])){
                    if($product=$item->product){
                        
                        $store =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$order->branch_id)->where('variant_id',$item->variant_id)->first();
                        if(!$store){
                          $store =new InventoryStock();
                          $store->src_id=$item->product_id;
                          $store->branch_id=$order->branch_id;
                          $store->variant_id=$item->variant_id;
                          $store->barcode=$item->barcode?:$product->bar_code;
                          $store->save();
                        }
                        if($oldQty > $qty){
                            $needQty =$oldQty - $qty;
                            
                            $store->quantity +=$needQty;
                            $store->save();
                            
                            // if($needQty > $product->warehouseStock($order->branch_id,$item->variant_id)){
                            //     $message='<span style="color:red;">Product Stock Already used.Can not Change Qty</span>';
                            //     $status=false;
                            // }else{
                                
                            // }
                        }elseif($oldQty < $qty){
                            $needQty =$qty - $oldQty;
                            
                            if($needQty > $product->warehouseStock($order->branch_id,$item->variant_id)){
                                $message='<span style="color:red;">Product Stock Already used.Can not Change Qty</span>';
                                $status=false;
                            }else{
                                $store->quantity -=$needQty;
                                $store->save();
                            }
                            
                            // $store->quantity -=$needQty;
                            // $store->save();
                        }
                        
                        if($variant =$item->productVariant){
                            $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                            $variant->save();
                        }
                        
                        $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                        $product->save();
                    }
                    
                }
                
                if($status){
                    $item->quantity=$qty;
                    $item->weight_unit =$item->product?$item->product->weight_unit:null;
                    $item->final_price=($item->quantity*$item->price)+($item->quantity*$item->tax_amount);
                    $item->total_price=($item->quantity*$item->price) - ($item->quantity*$item->discount_amount)+($item->quantity*$item->tax_amount);
                    $item->purchase_total=$item->purchase_price*$item->quantity;
                    $item->profit_loss=$item->final_price-$item->purchase_total;
                    $item->save();
                }
            }
            
            if($action=='item-price' && $message==null){
                $item->price=$r->key?:0;
                $item->final_price=($item->quantity*$item->price)+($item->quantity*$item->tax_amount);
                $item->total_price=($item->quantity*$item->price) - ($item->quantity*$item->discount_amount)+($item->quantity*$item->tax_amount);
                
                if($item->productVariant){
                $item->purchase_price=$item->productVariant->purchase_price > 0?$item->productVariant->purchase_price:$item->productVariant->final_price;
                }else{
                $item->purchase_price=$item->product?$item->product->purchase_price:0;
                }
                $item->purchase_total=$item->purchase_price*$item->quantity;
                $item->profit_loss=$item->final_price-$item->purchase_total;
                $item->save();
            }
            
            $order->total_price=$order->items->sum('final_price');
            $order->total_purchase=$order->items->sum('purchase_total');
            $order->profit_loss=$order->items->sum('profit_loss');
            
            $shippingCharge=0;
            if($order->total_price < 1000 || $order->shipping_apply){
                if($order->district==73){
                $shippingCharge=general()->inside_dhaka_shipping_charge?:0;
                }else{
                $shippingCharge=general()->outside_dhaka_shipping_charge?:0;
                }
            }
            
            if($shippingCharge > 0 && $order->shipping_free){
                $shippingCharge =0;   
            }
            
            $order->shipping_charge =$shippingCharge;
            
            $order->grand_total =($order->total_price + $order->shipping_charge + $order->tax) - ($order->coupon_discount+$order->adjustment_amount);
            if($order->grand_total >= $order->paid_amount){
                $order->due_amount=$order->grand_total-$order->paid_amount;
                $order->extra_amount=0;
            }else{
                $order->due_amount=0; 
                $order->extra_amount=$order->paid_amount-$order->grand_total; 
            }
            if($order->due_amount==0){
            $order->payment_status='paid';
            }elseif($order->due_amount==$order->grand_total){
            $order->payment_status='unpaid';
            }else{
            $order->payment_status='partial';
            }
            $order->save();
            
            $methods =Attribute::where('type',11)->where('status','active')->get();
            $infoView =view(adminTheme().'orders.includes.orderSummery',compact('order'))->render();
            $view =view(adminTheme().'orders.includes.orderItems',compact('order','message'))->render();
            $datasBill =view(adminTheme().'orders.includes.paymentModal',compact('order','methods'))->render();
            return Response()->json([
                'success' => true,
                'view' => $view,
                'infoView' => $infoView,
                'datasBill' => $datasBill,
            ]);
            
        }
        
        if($action=='adjustment-amount'){
           
            $order->adjustment_amount=$r->key?:0;
            
            $order->grand_total =($order->total_price + $order->shipping_charge + $order->tax) - ($order->coupon_discount+$order->adjustment_amount);
            if($order->grand_total >= $order->paid_amount){
                $order->due_amount=$order->grand_total-$order->paid_amount;
                $order->extra_amount=0;
            }else{
                $order->due_amount=0; 
                $order->extra_amount=$order->paid_amount-$order->grand_total; 
            }
            if($order->due_amount==0){
            $order->payment_status='paid';
            }elseif($order->due_amount==$order->grand_total){
            $order->payment_status='unpaid';
            }else{
            $order->payment_status='partial';
            }
            $order->save();
            
            $methods =Attribute::where('type',11)->where('status','active')->get();
            $infoView =view(adminTheme().'orders.includes.orderSummery',compact('order'))->render();
            $view =view(adminTheme().'orders.includes.orderItems',compact('order','message'))->render();
            $datasBill =view(adminTheme().'orders.includes.paymentModal',compact('order','methods'))->render();
            return Response()->json([
                'success' => true,
                'view' => $view,
                'infoView' => $infoView,
                'datasBill' => $datasBill,
            ]);
            
        }
        
        if($action=='add-product'){
            
            $product =Post::latest()->where('type',2)->where('status','active')->find($r->item_id);
            if(!$product){
                $message='<span style="color:red;">Product Not found</span>';
            }
            
            if($order->branch){
              
                $variant=null;
                $variantId=null;
    
                if($product->variation_status){
                    $variant = $product->productVariationActiveAttributeItems()->where('id',$r->variant_id)->first();
                    if($variant){
                        $variantId=$variant->id;
                    }else{
                        $message='<span style="color:red;">Please Select product variant item (Color, size)</span>';
                    }
                }
                
                $item = $order->items()->where('product_id', $product->id);
                if ($variant){
                    $item = $item->whereJsonContains('sku_id', $variant->attributeVatiationItems->pluck('attribute_item_id', 'attribute_id'));
                }
                $item = $item->first();
                if(!$item){
                    $branchId =$order->branch_id?:0;
                    if($product->warehouseStock($branchId,$variantId) >= 1){
                        $item =new OrderItem();
                        $item->order_id =$order->id;
                        $item->user_id =$order->user_id;
                        $item->product_id =$product->id;
                        $item->quantity =0;
                        
                        $item->product_name =$product->name;
                        $item->weight_unit =$product->weight_unit;
                        if($variant){
                          $item->barcode =$variant->barcode;
                          $item->variant_id =$variant->id;
                          $item->sku_id =json_encode($variant->attributeVatiationItems->pluck('attribute_item_id', 'attribute_id'));
                          $item->sku_value =json_encode($item->itemMakeAttributes());
                          $item->regular_price =$variant->reguler_price;
                          $item->purchase_price =$variant->purchase_price;
                          $item->price=$variant->final_price;
                          $item->tax =$variant->taxPercentage();
                          if($order->discount > 0){
                          $item->discount =$order->discount;
                          }else{
                          $item->discount =$variant->discountPercent();
                          }
                        }else{
                          $item->barcode =$r->barcode?:null;
                          $item->variant_id=null;
                          $item->sku_id=null;
                          $item->sku_value=null;
                          $item->regular_price =$product->regular_price;
                          $item->purchase_price=$product->purchase_price;
                          $item->price=$product->final_price;
                          $item->tax =$product->taxPercentage();
                          if($order->discount > 0){
                          $item->discount =$order->discount;
                          }else{
                          $item->discount =$product->discountPercent();
                          }
                        }
                        
                        $item->discount_amount =0;
                        $item->total_price=0;
                        $item->tax_amount =0;
                        $item->final_price=0;
                        $item->save();
                
                    }else{
                        $message='<span style="color:red;">Stock Limit Over Cannot Order</span>';
                    }
                }
            }else{
               $message='<span style="color:red;">Please Select tore/Branch</span>'; 
            }
            $methods =Attribute::where('type',11)->where('status','active')->get();
            $infoView =view(adminTheme().'orders.includes.orderSummery',compact('order'))->render();
            $view =view(adminTheme().'orders.includes.orderItems',compact('order','message'))->render();
            $datasBill =view(adminTheme().'orders.includes.paymentModal',compact('order','methods'))->render();
            return Response()->json([
                'success' => true,
                'view' => $view,
                'infoView' => $infoView,
                'datasBill' => $datasBill,
            ]);
            
            Session()->flash('success','Product Added Successfully Done!');
            return redirect()->back();
            
        }
        
        if($action=='update'){
            
            
            
            $check = $r->validate([
                'name' => 'required|max:100',
                'mobile' => 'required|max:15',
                'email' => 'nullable|email|max:100',
                'courier' => 'nullable|max:100',
                'district' => 'required|numeric',
                'city' => 'required|numeric',
                'address' => 'nullable|max:100',
                'order_status' => 'required',
                'created_at' => 'required|date',
            ]);
            
            if(!$order->branch){
              Session()->flash('error','Please Select Supplier and Store');
              return redirect()->back();
            }
            
            if($order->order_status=='returned' && ($r->order_status=='pending' || $r->order_status=='cancelled')){
                Session()->flash('error','Return Order Status can not change pending or cancelled status!');
                return redirect()->back();
            }
            
            $order->name =$r->name;
            $order->facebook_order =$r->facebook_order?true:false;
            $order->mobile =$r->mobile;
            $order->email =$r->email;
            $order->district =$r->district;
            $order->city =$r->city;
            $order->address =$r->address;
            if($r->courier){
                $order->courier =$r->courier;
            }
            
            $order->delivered_msg =$r->special_msg;
            
            if($r->courier_store){
                $order->courier_store =$r->courier_store;
            }

            if($r->courier_district){
                $order->courier_city =$r->courier_district;
            }
            
            if($r->courier_city){
                $order->courier_zone =$r->courier_city;
            }
            
            $order->note =$r->note;
            $order->created_at =$r->created_at;
            
            $shippingCharge=0;
            if($order->total_price < 1000 || $order->shipping_apply){
                if($order->district==73){
                $shippingCharge=general()->inside_dhaka_shipping_charge?:0;
                }else{
                $shippingCharge=general()->outside_dhaka_shipping_charge?:0;
                }
            }
            
            if($shippingCharge > 0 && $order->shipping_free){
                $shippingCharge =0;   
            }
            
            $order->shipping_charge =$shippingCharge;
            
            $order->grand_total =($order->total_price + $order->shipping_charge + $order->tax) - ($order->coupon_discount+$order->adjustment_amount);
            if($order->grand_total >= $order->paid_amount){
                $order->due_amount=$order->grand_total-$order->paid_amount;
                $order->extra_amount=0;
            }else{
                $order->due_amount=0; 
                $order->extra_amount=$order->paid_amount-$order->grand_total; 
            }
            
            if($order->due_amount==0){
            $order->payment_status='paid';
            }elseif($order->due_amount==$order->grand_total){
            $order->payment_status='unpaid';
            }else{
            $order->payment_status='partial';
            }
            $order->save();
            
            if($order->order_status!=$r->order_status){
                $data =$this->getStockAdjustment($order,$r->order_status);
                if($data=='stockout'){
                     Session()->flash('error','Order Status can not change product stock are not available!');
                     return redirect()->back();
                }

                $order->order_status=$r->order_status;
                $orderStatus =$r->order_status;
                if($orderStatus=='pending' || $orderStatus=='confirmed' || $orderStatus=='shipped' || $orderStatus=='delivered' || $orderStatus=='cancelled' ){
                    $columD =$orderStatus.'_at';
                    $columBy =$orderStatus.'_by';
                    $order[$columD]=Carbon::now();
                    $order[$columBy]=Auth::id();
                }
                $order->save();
            }
            
            //send mail or sms
            
            //**********Send Mail***************//
            if(general()->mail_status && $order->email && $r->mail_send){
                //Mail Data
                $datas =array('order'=>$order);
                $template ='mails.InvoiceMail';
                $toEmail =$order->email;
                $toName =$order->name;
                $subject ='Order Successfully Completed in '.general()->title;
            
                sendMail($toEmail,$toName,$subject,$datas,$template);
            }

            //**********Send Mail***************//
            
            //Send SMS 
            if(general()->sms_status && $order->mobile && $r->sms_send){
                $msg ='Your order is '.$order->order_status.' #'.$order->invoice.' Thank you for your shopping';
                sendSMS($order->mobile,$msg);
            }
            $message =null;
            if($order->courier && $order->courier_id==null){
                   $this->pathaoService->placeNewOrder($order);
                try {
                    
                    $message=' and Courier Order Send Success';
                } catch (\Exception $e) {
                    throw $e;
                    $message=' and Courier Order Send Fail';
                }
            }
            
            Session()->flash('success','Order Update Successfully Done!'.$message);
            return redirect()->back();

        }

        if($action=='payment'){
       
            $check = $r->validate([
                'created_at' => 'required|date',
                'amount' => 'required|numeric',
                'method' => 'required|numeric',
            ]);
            $method =Attribute::where('type',11)->find($r->method);
            if(!$method){
                Session()->flash('error','Method Type Are Found');
                return redirect()->back();
            }

            $transaction =new Transaction();
            $transaction->src_id =$order->id;
            if($r->transaction_type==1){
                $transaction->type =2;
            }else{
               $transaction->type =0; 
            }
            $transaction->status ='success';
            $transaction->method_id=$method->id;
            $transaction->transection_id=Carbon::now()->format('YmdHis');
            $transaction->amount=$r->amount;
            $transaction->billing_note=$r->note;
            $transaction->billing_name=$order->name;
            $transaction->billing_mobile=$order->mobile;
            $transaction->billing_email=$order->email;
            $transaction->billing_address=$order->address;
            $transaction->created_at=$r->created_at;
            $transaction->save();
            
            dailyCashMacting($transaction->created_at);
            
            //Method Balance Update
            if($transaction->type==1){
                $method->amounts -=$transaction->amount;
            }else{
                $method->amounts +=$transaction->amount;
            }            
            $method->save();

            //Order payment Update
            $order->paid_amount=$order->transactionsSuccess->sum('amount');
            $order->return_amount=$order->transactionsRefund->sum('amount');

            if($order->grand_total >= $order->paid_amount){
                $order->due_amount=$order->grand_total-$order->paid_amount;
                $order->extra_amount=0;
            }else{
                $order->due_amount=0; 
                $order->extra_amount=$order->paid_amount-$order->grand_total; 
            }
            
            if($order->due_amount==0){
            $order->payment_status='paid';
            }elseif($order->due_amount==$order->grand_total){
            $order->payment_status='unpaid';
            }else{
            $order->payment_status='partial';
            }
            $order->save();
            if($transaction->type==1){
                Session()->flash('success','Payment Refund Successfully Done!');
            }else{
                Session()->flash('success','Payment Added Successfully Done!');
            }
            return redirect()->back();
        }
        
        if($action=='payment-delete'){
            
            $transaction =$order->transactionsAll()->find($r->transection_id);
            if($transaction){
                $startDate =$transaction->created_at;
                if($method =$transaction->method){
                    //Method Balance Update
                    if($transaction->type==1){
                        $method->amounts +=$transaction->amount;
                    }else{
                        $method->amounts -=$transaction->amount;
                    }            
                    $method->save();
                }
                $transaction->delete();
                
                //Update Cash
                dailyCashMacting($startDate);

            }
            
            $order->paid_amount=$order->transactionsSuccess->sum('amount');
            $order->return_amount=$order->transactionsRefund->sum('amount');

            if($order->grand_total >= $order->paid_amount){
                $order->due_amount=$order->grand_total-$order->paid_amount;
                $order->extra_amount=0;
            }else{
                $order->due_amount=0; 
                $order->extra_amount=$order->paid_amount-$order->grand_total; 
            }
            
            if($order->due_amount==0){
            $order->payment_status='paid';
            }elseif($order->due_amount==$order->grand_total){
            $order->payment_status='unpaid';
            }else{
            $order->payment_status='partial';
            }
            $order->save();
            
            Session()->flash('success','Payment Deleted Successfully Done!');
            return redirect()->back();
        }

        $methods =Attribute::where('type',11)->where('status','active')->get();
        
        
        
        if($order->order_status=='confirmed' && $order->courier_id && ($order->courier=='Pathao' || $order->courier=='Steadfast')){
            $status = $this->pathaoService->StatusCourierOrder($order);
            if(isset($status['error'])) {
                $this->pathaoService->authenticate2($order->courier);
            }
        }
        
        if($order->order_status=='pending'){
            foreach($items =$order->items()->whereNull('variant_id')->get() as $item){
                $variant =$item->itemVariantData();
                if($variant){
                    $item->variant_id=$variant->id;
                    $item->barcode=$variant->barcode;
                }
                $item->save();
            }
        }
        
        // if($order->courier_id==null && $order->courier){
        //     $order->courier=null;
        //     $order->save();
        // }
        
      
        return view(adminTheme().'orders.ordersManage',compact('order','methods','message')); 
    }
    
    public function sendPathoCourier($order){
        
        $general =general();
        
        
        
        return $general->patho_access_token;
    }
    
    public function isTokenExpired($exception)
    {
        return strpos($exception->getMessage(), 'token_expired') !== false;
    }

    public function invoice($id){
        $order =Order::find($id);
        if(!$order){
            Session()->flash('error','Order Are Not Found');
            return redirect()->route('admin.orders');
        }
        
        $gram =0;
        $ml =0;
        
        foreach($order->items as $item){
            if($item->product){
                if($item->product->weight_unit){
                    $gram+= $item->quantity*$item->product->weight_amount;   
                }
            }
        }
        
        return view(adminTheme().'orders.invoice',compact('order'));
    }
    
    public function ordersReturn(Request $r){
        $orders =Order::latest()->where('order_type','order_return')->where('order_status','<>','temp')
            ->where(function($qq)  use ($r)  {
                
                if($r->status){
                    if($r->status=='pending-payment'){
                        $qq->where('payment_method',null);
                    }else if($r->status=='unpaid'){
                        $qq->whereIn('payment_status',['unpaid','partial']);
                    }else{
                        $qq->where('order_status',$r->status);
                    }
                }
                
                if($r->search){
                   $qq->where('invoice','LIKE','%'.$r->search.'%')->orWhere('email','LIKE','%'.$r->search.'%')->orWhere('mobile','LIKE','%'.$r->search.'%'); 
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

                
            })
            ->paginate(25)->appends(['search'=>$r->search,'status'=>$r->status,'startDate'=>$r->startDate,'endDate'=>$r->endDate]);
            
        return view(adminTheme().'returns.ordersReturn',compact('orders'));
    }
    
    public function ordersReturnAction(Request $r,$action,$id=null){
        
        if($action=='create'){
            $hasOrder =null;
            if($r->order_no){
                $hasOrder=Order::where('order_type','customer_order')
                          ->whereIn('order_status',['returned'])
                          ->where('invoice',$r->order_no)
                          ->first();
                
                if(!$hasOrder){
                    Session()->flash('error','Your Order no is not valid. Only shipped or complated order allow');
                    return redirect()->back();
                }
                
                $alreadyReturn =Order::where('order_type','order_return')->where('order_status','<>','temp')->where('parent_id',$hasOrder->id)->first();
                if($alreadyReturn){
                    Session()->flash('error','This Order already Return');
                    return redirect()->back();
                }
            }
            
            $order =Order::where('order_type','order_return')->where('order_status','temp')->where('addedby_id',Auth::id())->first();
            if(!$order){
                $order =new Order();
                $order->order_type ='order_return';
                $order->order_status ='temp';
                $order->addedby_id =Auth::id();
                $order->save();
            }
            
            if($hasOrder){
                $order->parent_id=$hasOrder->id;
                $order->branch_id=$hasOrder->branch_id;
                $order->user_id =$hasOrder->user_id;
                $order->name =$hasOrder->name;
                $order->mobile =$hasOrder->mobile;
                $order->email =$hasOrder->email;
                $order->district =$hasOrder->district;
                $order->city =$hasOrder->city;
                $order->address =$hasOrder->address;
            }else{
                $order->parent_id=null;
                $order->branch_id=general()->online_store_id;
                $order->user_id =null;
                $order->name =null;
                $order->mobile =null;
                $order->email =null;
                $order->district =null;
                $order->city =null;
                $order->address =null;
            }
            $order->created_at =Carbon::now();
            $order->tax =general()->tax;
            $order->invoice =$order->created_at->format('Ymd').$order->id;
            $order->save();
            
            return redirect()->route('admin.ordersReturnAction',['edit',$order->id]);
        }
        
        $order =Order::find($id);
        if(!$order){
            Session()->flash('error','Order return Are Not Found');
            return redirect()->route('admin.ordersReturn');
        }
        
        if($action=='invoice'){
            
            
            return view(adminTheme().'returns.orderReturnInvoice',compact('order')); 
        }
        
        $message=null;
        if($action=='item-quantity'){
            
            $item =$order->parentOrder->items()->find($r->item_id);
            if($item){
                $oldQty =$item->return_quantity;
                $qty =$r->key?:0;
 
                $status=true; 
                if($qty > $item->quantity){
                    
                    $message ='<span style="color:red;">Order Quantity can not return over quantity</span>';
                    
                }else{
                    
                    if($product=$item->product){
                        $store =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$order->branch_id)->where('variant_id',$item->variant_id)->first();
                        if($store){
                            if($qty > $oldQty){
                                $needQty =$qty - $oldQty;
                                
                                $store->quantity +=$needQty;
                                $store->save();
                           
                            }elseif($qty < $oldQty){
                                $needQty =$oldQty - $qty;
                                if($needQty > $product->warehouseStock($order->branch_id,$item->variant_id)){
                                    $message='<span style="color:red;">Product Stock Already used.Can not Change Qty</span>';
                                    $status=false;
                                }else{
                                    $store->quantity -=$needQty;
                                    $store->save();
                                }
                            }
                            
                            if($variant =$item->productVariant){
                                $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                                $variant->save();
                            }
                            
                            $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                            $product->save();
                        }
                    }
                    
                    if($status){
                        $item->return_quantity=$qty;
                        $item->return_total =$item->price*$qty;
                        $item->save();
                        
                        $return =$order->parentOrder;
    
                        $order->total_price=$return->items()->sum('return_total');
                        $order->total_items=$return->items()->where('return_quantity','>',0)->count();
                        $order->total_qty=$return->items()->sum('return_quantity');
                        $order->tax_amount=0;
                        $order->discount_amount=0;
                        $order->discount_price=0;
                        $order->exchange_amount=0;
                        $order->grand_total=$order->total_price;
                        
                        $order->paid_amount=$order->transactionsSuccess->sum('amount');
                        if($order->grand_total >= $order->paid_amount){
                            $order->due_amount=$order->grand_total-$order->paid_amount;
                            $order->extra_amount=0;
                        }else{
                            $order->due_amount=0; 
                            $order->extra_amount=$order->paid_amount-$order->grand_total; 
                        }
                        
                        if($order->due_amount==0){
                        $order->payment_status='paid';
                        }elseif($order->due_amount==$order->grand_total){
                        $order->payment_status='unpaid';
                        }else{
                        $order->payment_status='partial';
                        }
                        
                        $order->order_status='completed';
                        $order->save();
                        
                        $return->return_amount =$order->grand_total;
                        $return->save();
                    }
                    
                }
            }
            
            // $infoView =view(adminTheme().'orders.includes.orderSummery',compact('order'))->render();
            $view =view(adminTheme().'returns.includes.orderItems',compact('order','message'))->render();
            return Response()->json([
                'success' => true,
                'view' => $view,
                // 'infoView' => $infoView,
            ]);
        }
        
        
        if($action=='update'){
            
            $check = $r->validate([
                'created_at' => 'required|date',
                'note' => 'nullable|max:1000',
            ]);
            $order->note =$r->note;
            $order->order_status='completed';
            $order->created_at=$r->created_at?:Carbon::now();
            $order->invoice =$order->created_at->format('Ymd').$order->id;
            $order->save();
            
            Session()->flash('success','Order Update Successfully Done!');
            return redirect()->route('admin.ordersReturnAction',['invoice',$order->id]);
            
        }
        
        
        if($action=='payment'){
       
            $check = $r->validate([
                'amount' => 'required|numeric',
                'method' => 'required|numeric',
            ]);
            $method =Attribute::where('type',11)->find($r->method);
            if(!$method){
                Session()->flash('error','Method Type Are Found');
                return redirect()->back();
            }

            $transaction =new Transaction();
            $transaction->src_id =$order->id;
            if($r->transaction_type==1){
               $transaction->type =2;
            }else{
               $transaction->type =2; 
            }
            $transaction->status ='success';
            $transaction->method_id=$method->id;
            $transaction->transection_id=Carbon::now()->format('YmdHis');
            $transaction->amount=$r->amount;
            $transaction->billing_note=$r->note;
            $transaction->billing_name=$order->name;
            $transaction->billing_mobile=$order->mobile;
            $transaction->billing_email=$order->email;
            $transaction->billing_address=$order->address;
            $transaction->save();

            //Method Balance Update
            if($transaction->type==2){
                $method->amounts -=$transaction->amount;
            }else{
                $method->amounts +=$transaction->amount;
            }            
            $method->save();

            //Order payment Update
            $order->paid_amount=$order->transactionsSuccess->sum('amount');
            $order->paid_amount=$order->transactionsRefund->sum('amount');

            if($order->grand_total >= $order->paid_amount){
                $order->due_amount=$order->grand_total-$order->paid_amount;
                $order->extra_amount=0;
            }else{
                $order->due_amount=0; 
                $order->extra_amount=$order->paid_amount-$order->grand_total; 
            }
            
            if($order->due_amount==0){
            $order->payment_status='paid';
            }elseif($order->due_amount==$order->grand_total){
            $order->payment_status='unpaid';
            }else{
            $order->payment_status='partial';
            }
            $order->save();
            if($transaction->type==2){
                Session()->flash('success','Payment Refund Successfully Done!');
            }else{
                Session()->flash('success','Payment Added Successfully Done!');
            }
            return redirect()->back();
        }
        
        if($action=='payment-delete'){
            
            $transaction =$order->transactionsAll()->find($r->transection_id);
            if($transaction){
                
                if($method =$transaction->method){
                    //Method Balance Update
                    if($transaction->type==2){
                        $method->amounts +=$transaction->amount;
                    }            
                    $method->save();
                }
                
               $transaction->delete(); 
            }
            
            $order->paid_amount=$order->transactionsSuccess->sum('amount');
            $order->paid_amount=$order->transactionsRefund->sum('amount');

            if($order->grand_total >= $order->paid_amount){
                $order->due_amount=$order->grand_total-$order->paid_amount;
                $order->extra_amount=0;
            }else{
                $order->due_amount=0; 
                $order->extra_amount=$order->paid_amount-$order->grand_total; 
            }
            
            if($order->due_amount==0){
            $order->payment_status='paid';
            }elseif($order->due_amount==$order->grand_total){
            $order->payment_status='unpaid';
            }else{
            $order->payment_status='partial';
            }
            $order->save();
            
            Session()->flash('success','Payment Deleted Successfully Done!');
            return redirect()->back();
        }
        
        $methods =Attribute::where('type',11)->where('status','active')->get();
        
        
        return view(adminTheme().'returns.ordersReturnEdit',compact('order','methods','message')); 
        
        
        
    }
    
    
    public function wholesaleReturn(Request $r){
        
        $orders =Order::latest()->where('order_type','wholesale_return')->where('order_status','<>','temp')
            ->where(function($qq)  use ($r)  {
                
                if($r->status){
                    if($r->status=='pending-payment'){
                        $qq->where('payment_method',null);
                    }else if($r->status=='unpaid'){
                        $qq->whereIn('payment_status',['unpaid','partial']);
                    }else{
                        $qq->where('order_status',$r->status);
                    }
                }
                
                if($r->search){
                   $qq->where('invoice','LIKE','%'.$r->search.'%')->orWhere('email','LIKE','%'.$r->search.'%')->orWhere('mobile','LIKE','%'.$r->search.'%'); 
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

                
            })
            ->paginate(25)->appends(['search'=>$r->search,'status'=>$r->status,'startDate'=>$r->startDate,'endDate'=>$r->endDate]);
            
        return view(adminTheme().'returns.wholesaleReturn',compact('orders'));
    }
    
    
    public function wholesaleReturnAction(Request $r,$action,$id=null){
        
        if($action=='create'){
            $hasOrder =null;
            if($r->order_no){
                $hasOrder=Order::where('order_type','wholesale_order')
                          ->whereIn('order_status',['shipped','delivered'])
                          ->where('invoice',$r->order_no)
                          ->first();
                
                if(!$hasOrder){
                    Session()->flash('error','Your Order no is not valid. Only shipped or complated order allow');
                    return redirect()->back();
                }
                
                $alreadyReturn =Order::where('order_type','wholesale_return')->where('order_status','<>','temp')->where('parent_id',$hasOrder->id)->first();
                if($alreadyReturn){
                    Session()->flash('error','This Order already Return');
                    return redirect()->back();
                }
            }
            
            $order =Order::where('order_type','wholesale_return')->where('order_status','temp')->where('addedby_id',Auth::id())->first();
            if(!$order){
                $order =new Order();
                $order->order_type ='wholesale_return';
                $order->order_status ='temp';
                $order->addedby_id =Auth::id();
                $order->save();
            }
            
            if($hasOrder){
                $order->parent_id=$hasOrder->id;
                $order->branch_id=$hasOrder->branch_id;
                $order->user_id =$hasOrder->user_id;
                $order->name =$hasOrder->name;
                $order->mobile =$hasOrder->mobile;
                $order->email =$hasOrder->email;
                $order->district =$hasOrder->district;
                $order->city =$hasOrder->city;
                $order->address =$hasOrder->address;
            }else{
                $order->parent_id=null;
                $order->branch_id=null;
                $order->user_id =null;
                $order->name =null;
                $order->mobile =null;
                $order->email =null;
                $order->district =null;
                $order->city =null;
                $order->address =null;
            }
            $order->created_at =Carbon::now();
            $order->tax =general()->tax;
            $order->invoice =$order->created_at->format('Ymd').$order->id;
            $order->save();
            
            return redirect()->route('admin.wholesaleReturnAction',['edit',$order->id]);
        }
        
        $order =Order::find($id);
        if(!$order){
            Session()->flash('error','Order return Are Not Found');
            return redirect()->route('admin.wholesaleReturn');
        }
        
        if($action=='invoice'){
            
            return view(adminTheme().'returns.wholesaleReturnInvoice',compact('order')); 
        }
        
        $message=null;
        if($action=='item-quantity'){
            
            $item =$order->parentOrder->items()->find($r->item_id);
            if($item){
                $oldQty =$item->return_quantity;
                $qty =$r->key?:0;
 
                $status=true; 
                if($qty > $item->quantity){
                    
                    $message ='<span style="color:red;">Order Quantity can not return over quantity</span>';
                    
                }else{
                    
                    if($product=$item->product){
                        $store =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$order->branch_id)->where('variant_id',$item->variant_id)->first();
                        if($store){
                            if($qty > $oldQty){
                                $needQty =$qty - $oldQty;
                                
                                $store->quantity +=$needQty;
                                $store->save();
                                
                            }elseif($qty < $oldQty){
                                $needQty =$oldQty - $qty;
                                if($needQty > $product->warehouseStock($order->branch_id,$item->variant_id)){
                                    $message='<span style="color:red;">Product Stock Already used.Can not Change Qty</span>';
                                    $status=false;
                                }else{
                                $store->quantity -=$needQty;
                                $store->save();
                                }
                            }
                            
                            if($variant =$item->productVariant){
                                $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                                $variant->save();
                            }
                            
                            $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                            $product->save();
                        }
                    }
                    
                    if($status){
                        $item->return_quantity=$qty;
                        $item->return_total =$item->price*$qty;
                        $item->save();
                        
                        $return =$order->parentOrder;
    
                        $order->total_price=$return->items()->sum('return_total');
                        $order->total_items=$return->items()->where('return_quantity','>',0)->count();
                        $order->total_qty=$return->items()->sum('return_quantity');
                        $order->tax_amount=0;
                        $order->discount_amount=0;
                        $order->discount_price=0;
                        $order->exchange_amount=0;
                        $order->grand_total=$order->total_price;
                        
                        $order->paid_amount=$order->transactionsSuccess->sum('amount');
                        if($order->grand_total >= $order->paid_amount){
                            $order->due_amount=$order->grand_total-$order->paid_amount;
                            $order->extra_amount=0;
                        }else{
                            $order->due_amount=0; 
                            $order->extra_amount=$order->paid_amount-$order->grand_total; 
                        }
                        
                        if($order->due_amount==0){
                        $order->payment_status='paid';
                        }elseif($order->due_amount==$order->grand_total){
                        $order->payment_status='unpaid';
                        }else{
                        $order->payment_status='partial';
                        }
                        
                        $order->order_status='completed';
                        $order->save();
                        
                        $return->return_amount =$order->grand_total;
                        $return->save();
                    }
                    
                }
            }
            
            // $infoView =view(adminTheme().'orders.includes.orderSummery',compact('order'))->render();
            $view =view(adminTheme().'returns.includes.wholesaleOrderItems',compact('order','message'))->render();
            return Response()->json([
                'success' => true,
                'view' => $view,
                // 'infoView' => $infoView,
            ]);
        }
        
        
        if($action=='update'){
            
            $check = $r->validate([
                'created_at' => 'required|date',
                'note' => 'nullable|max:1000',
            ]);

            $order->note =$r->note;
            $order->created_at =$r->created_at?:Carbon::now();
            $order->order_status='completed';
            $order->save();
            
            Session()->flash('success','Order Update Successfully Done!');
            return redirect()->route('admin.wholesaleReturnAction',['invoice',$order->id]);
            
        }
        
        
        if($action=='payment'){
       
            $check = $r->validate([
                'amount' => 'required|numeric',
                'method' => 'required|numeric',
            ]);
            $method =Attribute::where('type',11)->find($r->method);
            if(!$method){
                Session()->flash('error','Method Type Are Found');
                return redirect()->back();
            }

            $transaction =new Transaction();
            $transaction->src_id =$order->id;
            if($r->transaction_type==1){
               $transaction->type =2;
            }else{
               $transaction->type =2; 
            }
            $transaction->status ='success';
            $transaction->method_id=$method->id;
            $transaction->transection_id=Carbon::now()->format('YmdHis');
            $transaction->amount=$r->amount;
            $transaction->billing_note=$r->note;
            $transaction->billing_name=$order->name;
            $transaction->billing_mobile=$order->mobile;
            $transaction->billing_email=$order->email;
            $transaction->billing_address=$order->address;
            $transaction->save();

            //Method Balance Update
            if($transaction->type==2){
                $method->amounts -=$transaction->amount;
            }else{
                $method->amounts +=$transaction->amount;
            }            
            $method->save();

            //Order payment Update
            $order->paid_amount=$order->transactionsSuccess->sum('amount');
            $order->paid_amount=$order->transactionsRefund->sum('amount');

            if($order->grand_total >= $order->paid_amount){
                $order->due_amount=$order->grand_total-$order->paid_amount;
                $order->extra_amount=0;
            }else{
                $order->due_amount=0; 
                $order->extra_amount=$order->paid_amount-$order->grand_total; 
            }
            
            if($order->due_amount==0){
            $order->payment_status='paid';
            }elseif($order->due_amount==$order->grand_total){
            $order->payment_status='unpaid';
            }else{
            $order->payment_status='partial';
            }
            $order->save();
            if($transaction->type==2){
                Session()->flash('success','Payment Refund Successfully Done!');
            }else{
                Session()->flash('success','Payment Added Successfully Done!');
            }
            return redirect()->back();
        }
        
        if($action=='payment-delete'){
            
            $transaction =$order->transactionsAll()->find($r->transection_id);
            if($transaction){
                if($method =$transaction->method){
                    //Method Balance Update
                    if($transaction->type==2){
                        $method->amounts +=$transaction->amount;
                    }            
                    $method->save();
                }
               $transaction->delete(); 
            }
            
            $order->paid_amount=$order->transactionsSuccess->sum('amount');
            $order->paid_amount=$order->transactionsRefund->sum('amount');

            if($order->grand_total >= $order->paid_amount){
                $order->due_amount=$order->grand_total-$order->paid_amount;
                $order->extra_amount=0;
            }else{
                $order->due_amount=0; 
                $order->extra_amount=$order->paid_amount-$order->grand_total; 
            }
            
            if($order->due_amount==0){
            $order->payment_status='paid';
            }elseif($order->due_amount==$order->grand_total){
            $order->payment_status='unpaid';
            }else{
            $order->payment_status='partial';
            }
            $order->save();
            
            Session()->flash('success','Payment Deleted Successfully Done!');
            return redirect()->back();
        }
        
        $methods =Attribute::where('type',11)->where('status','active')->get();
        
        
        return view(adminTheme().'returns.wholesaleReturnEdit',compact('order','methods','message')); 
        
        
        
    }
    
    public function wholeSales(Request $r,$status=null){

        
        // Filter Action Start
        if($r->action){
            if($r->checkid){
                $datas=Order::latest()->where('order_type','wholesale_order')->whereIn('id',$r->checkid);
                if($r->action==1){
                    $datas->update(['order_status'=>'pending']);
                }elseif($r->action==2){
                    $datas->update(['order_status'=>'confirmed']);
                }elseif($r->action==3){
                    $datas->update(['order_status'=>'shipped']);
                }elseif($r->action==4){
                    $datas->update(['order_status'=>'delivered']);
                }elseif($r->action==5){
                    $datas->update(['order_status'=>'cancelled']);
                }elseif($r->action==6){
                    foreach($datas->get(['id']) as $data){
                        $data->items()->delete();
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

        if($status==null || $status=='pending-payment' || $status=='unpaid' || $status=='pending' || $status=='confirmed' || $status=='shipped' || $status=='delivered' || $status=='cancelled'){

            $orders =Order::latest()->where('order_type','wholesale_order')->where('order_status','<>','temp')
            ->where(function($qq)  use ($status,$r)  {
                if($status){
                    if($status=='pending-payment'){
                        $qq->where('payment_method',null);
                    }else if($status=='unpaid'){
                        $qq->whereIn('payment_status',['unpaid','partial']);
                    }else{
                        $qq->where('order_status',$status);
                    }
                }
                
                if($r->search){
                   $qq->where('invoice','LIKE','%'.$r->search.'%')->orWhere('email','LIKE','%'.$r->search.'%')->orWhere('mobile','LIKE','%'.$r->search.'%'); 
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

                
            })
            ->paginate(25)->appends(['search'=>$r->search,'status'=>$r->status,'startDate'=>$r->startDate,'endDate'=>$r->endDate]);

            //Total Count Results
            $totals = DB::table('orders')
            ->where('order_type','wholesale_order')
            ->selectRaw('count(*) as total')
            ->selectRaw("count(case when order_status = 'pending' then 1 end) as pending")
            ->selectRaw("count(case when order_status = 'confirmed' then 1 end) as confirmed")
            ->selectRaw("count(case when order_status = 'shipped' then 1 end) as shipped")
            ->selectRaw("count(case when order_status = 'delivered' then 1 end) as delivered")
            ->selectRaw("count(case when order_status = 'cancelled' then 1 end) as cancelled")
            ->first();

            return view(adminTheme().'wholesale.ordersAll',compact('orders','totals','status'));


        }else{
            Session()->flash('error','Order Status Un-known Type');
            return redirect()->route('admin.wholeSales');
        }

        
    }
    
    
    public function wholeSalesAction(Request $r,$action,$id=null){
        
        if($action=='create'){
            $order =new Order();
            $order->order_type ='wholesale_order';
            $order->order_status ='temp';
            $order->addedby_id =Auth::id();
            $order->save();
            $order->created_at =Carbon::now();
            $order->tax =general()->tax;
            $order->invoice =$order->created_at->format('Ymd').$order->id;
            $order->save();
            
            return redirect()->route('admin.wholeSalesAction',['edit',$order->id]);
        }
        
        $searchProducts =null;
        $message =null;
        $invoice =Order::where('order_type','wholesale_order')->find($id);
        if(!$invoice){
          Session()->flash('error','This Purchase Invoice Are Not Found');
          return redirect()->route('admin.wholeSales');
        }
        
        if($action=='invoice'){
        
            return view(adminTheme().'wholesale.invoice',compact('invoice'));
        }

    //   if($invoice->order_status=='delivered'){
    //     Session()->flash('error','This Invoice Are Delivered Can Not  Allow Modify');
    //     return redirect()->route('admin.purchases');
    //   }
      
        if($action=='update'){

            $check = $r->validate([
                'invoice' => 'required|max:100',
                'created_at' => 'required|date',
                'company_name' => 'required|max:100',
                'name' => 'required|max:100',
                'mobile_email' => 'required|max:100',
                'address' => 'required|max:100',
                'note' => 'nullable|max:1000',
                'status' => 'required|max:20',
            ]);

            if(!$invoice->branch){
              Session()->flash('error','Please Select Supplier and Store');
              return redirect()->back();
            }
            
            try {
                DB::transaction(function () use ($r, $invoice) {
                    
                    $createDate =$r->created_at?Carbon::parse($r->created_at . ' ' . Carbon::now()->format('H:i:s')):Carbon::now();
                    if (!$createDate->isSameDay($invoice->created_at)) {
                        $invoice->created_at = $createDate;
                    }
                    $invoice->invoice=$r->invoice;
                    if($invoice->user==null){
                        
                        $data =$invoice->mobile?:$invoice->email;
                        if($data){
                            if(filter_var($data, FILTER_VALIDATE_EMAIL)){
                                $user =User::where('email',$data)->first();
                            }else{
                                $user =User::where('mobile',$data)->first();
                            }
                            
                            if(!$user){
                                $password=Str::random(8);
                                $user =new User();
                                $user->name =$r->name;
                                $user->company_name =$r->company_name;
                                $user->address_line1 =$r->address;
                                if(filter_var($data, FILTER_VALIDATE_EMAIL)){
                                $user->email =$data;
                                }else{
                                $user->mobile =$data;
                                }
                                $user->password_show=$password;
                                $user->password=Hash::make($password);
                                $user->wholesale=true;
                                $user->save();
                            }
                            if($user->wholesale==false){
                                $user->wholesale=true;
                                $user->save();
                            }
                            $invoice->user_id=$user->id;
                        }
                    }
        
                    if($invoice->order_status!='delivered' && $r->status=='delivered'){
                        //Update Stock 
                        foreach($invoice->items as $item){
                          if($product=$item->product){
                            $warehouse =$invoice->branch;
                            $store =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                            if(!$store){
                              $store =new InventoryStock();
                              $store->src_id=$item->product_id;
                              $store->branch_id=$invoice->branch_id;
                              $store->variant_id=$item->variant_id;
                              $store->barcode=$item->barcode?:$product->bar_code;
                              $store->save();
                            }
                            $store->quantity -=$item->quantity;
                            $store->save();
                            
                            if($variant =$item->productVariant){
                                $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                                $variant->save();
                            }
                            $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                            $product->save();
                          }
                        }
                    }
                    if($invoice->order_status!='delivered'){
                    $invoice->order_status=$r->status?:'pending';
                    }
                    $invoice->note=$r->note;
                    $invoice->save();
                });
                if($invoice->order_status=='delivered'){
                  Session()->flash('success','This Invoice Are Delivered Successfully Done');
                  return redirect()->route('admin.wholeSalesAction',['invoice',$invoice->id]);
                }
                
                Session()->flash('success','You Are Successfully Done');
                return redirect()->back();
            
            } catch (\Exception $e) {
                Session()->flash('error', 'Something went wrong: ' . $e->getMessage());
                return redirect()->back();
            }

      }
        
        if($action=='company-name' || $action=='customer-name' || $action=='mobile-email' || $action=='address'){
            
            if($action=='company-name'){
                $invoice->company_name=$r->key?:null;
            }
            
            if($action=='customer-name'){
                $invoice->name=$r->key?:null;
            }
            
            if($action=='mobile-email'){
                $data =$r->key?:null;
                if($data && filter_var($data, FILTER_VALIDATE_EMAIL)){
                    $invoice->email=$data;
                    $invoice->mobile=null;
                }else{
                    $invoice->email=null;
                    $invoice->mobile=$data;
                }
            }
            
            if($action=='address'){
                $invoice->address=$r->key?:null;
            }
            
            $invoice->save();
              
            return Response()->json([
                'success' => true,
            ]);
        }
        
        if($action=='customer-select' || $action=='warehouse-select' || $action=='add-product' || $action=='remove-item' || $action=='item-quantity' || $action=='item-price' || $action=='shipping-charge' || $action=='adjustment-amount'  || $action=='tax-charge' || $action=='discount' || $action=='discount-type'){
            if($action=='customer-select'){
              $customer =User::find($r->key);
              $invoice->name=$customer?$customer->name:null;
              $invoice->company_name=$customer?$customer->company_name:null;
              $invoice->mobile=$customer?$customer->mobile:null;
              $invoice->email=$customer?$customer->email:null;
              $invoice->division=$customer?$customer->division:null;
              $invoice->district=$customer?$customer->district:null;
              $invoice->city=$customer?$customer->city:null;
              $invoice->address=$customer?$customer->address_line1:null;
              $invoice->user_id=$r->key?:null;
              $invoice->save();
            }

            if($action=='warehouse-select'){
              $invoice->branch_id=$r->key?:null;
              $invoice->save();
            }
            if($action=='add-product'){
              if($invoice->branch){
                $product =Post::latest()->where('type',2)->where('status','active')->find($r->item_id);
                if($product){
                    if($product->variation_status){
                        
                        foreach($product->productVariationActiveAttributeItems as $variantItem)
                        {
                            $item =$invoice->items()->where('product_id', $product->id)->whereJsonContains('sku_id',$variantItem->attributeVatiationItems->pluck('attribute_item_id','attribute_id'))->first();
                            if(!$item){
                                $item =new OrderItem();
                                $item->order_id =$invoice->id;
                                $item->user_id =$invoice->user_id;
                                $item->product_id =$product->id;
                                $item->product_name =$product->name;
                                $item->barcode =$variantItem->barcode;
                                $item->variant_id =$variantItem->id;
                                $item->sku_id =json_encode($variantItem->attributeVatiationItems->pluck('attribute_item_id','attribute_id'));
                                $item->sku_value =json_encode($item->itemMakeAttributes());
                                $item->weight_unit =$product->weight_unit;
                                $item->price =$variantItem->wholesale_price > 0 ? $variantItem->wholesale_price : ($variantItem->final_price > 0 ? $variantItem->final_price : 0);
                                $item->purchase_price=$variantItem->purchase_price;
                                $item->save();
                            }
                        }
                        
                    }else{
                        $item = $invoice->items()->where('product_id', $product->id)->first();
                        if(!$item){
                            $item =new OrderItem();
                            $item->order_id =$invoice->id;
                            $item->user_id =$invoice->user_id;
                            $item->product_id =$product->id;
                            $item->product_name =$product->name;
                            $item->weight_unit =$product->weight_unit;
                            $item->price =$product->wholesale_price > 0 ? $product->wholesale_price : ($product->final_price > 0 ? $product->final_price : 0);
                            $item->purchase_price=$product->purchase_price;
                            $item->save();
                        }
                    }
    
                }
              }
              
              if(!$invoice->branch){
                $message='<span style="color:red;">Please Select Store</span>';
              }
    
            }
    
            if($action=='remove-item'){
              $item =$invoice->items()->find($r->item_id);
              if($item){
                  
                if($invoice->order_status=='delivered'){
                    if($product=$item->product){
                        $store =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                        if(!$store){
                          $store =new InventoryStock();
                          $store->src_id=$item->product_id;
                          $store->branch_id=$invoice->branch_id;
                          $store->variant_id=$item->variant_id;
                          $store->barcode=$item->barcode?:$product->bar_code;
                          $store->save();
                        }
                        if($item->quantity > 0){
                            $store->quantity +=$item->quantity;
                            $store->save();
                            
                            if($variant =$item->productVariant){
                                $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                                $variant->save();
                            }
                            $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                            $product->save();
    
                        }
                    }
                }
                
                if($message==null){
                    $item->delete();
                }
                
                
              }
            }
    
            if($action=='item-quantity'){
              $item =$invoice->items()->find($r->item_id);
              if($item){
                $oldQty =$item->quantity;
                $qty =$r->key?:0;
                $status =true;
                
                if($product=$item->product){
                    $store =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                    if(!$store){
                      $store =new InventoryStock();
                      $store->src_id=$item->product_id;
                      $store->branch_id=$invoice->branch_id;
                      $store->variant_id=$item->variant_id;
                      $store->barcode=$item->barcode?:$product->bar_code;
                      $store->save();
                    }
                    
                    if($invoice->order_status=='delivered'){
                        if($qty > $oldQty){
                            $needQty =$qty - $oldQty;
                            if($needQty > $product->warehouseStock($invoice->branch_id,$item->variant_id)){
                                $message='<span style="color:red;">Product Stock are not available</span>';
                                $status=false;
                            }
                        }
                    }else{
                        if($qty > $product->warehouseStock($invoice->branch_id,$item->variant_id)){
                            $message='<span style="color:red;">Product Stock are not available</span>';
                            $status=false;
                        }
                    }
                    
                
                    if($invoice->order_status=='delivered' && $status){
                        
                        if($qty > $oldQty){
                            $needQty =$qty - $oldQty;
                            $store->quantity -=$needQty;
                            $store->save();
                        }elseif($qty < $oldQty){
                            $needQty =$oldQty - $qty;
                            $store->quantity +=$needQty;
                            $store->save();
                        }
                        
                        if($variant =$item->productVariant){
                            $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                            $variant->save();
                        }
                        
                        $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                        $product->save();
                    }
                }
                
                if($status){
                    $item->quantity=$qty;
                    $item->weight_unit =$item->product?$item->product->weight_unit:null;
                    $item->total_price=($item->quantity*$item->price) - ($item->quantity*$item->discount_amount)+($item->quantity*$item->tax_amount);
                    if($item->productVariant){
                    $item->purchase_price=$item->productVariant->purchase_price > 0?$item->productVariant->purchase_price:$item->productVariant->final_price;
                    }else{
                    $item->purchase_price=$item->product?$item->product->purchase_price:0;
                    }
                    $item->purchase_total=$item->purchase_price*$item->quantity;
                    $item->profit_loss=$item->total_price-$item->purchase_total;
                    $item->save();
                }
              }
            }
            if($action=='item-price'){
              $item =$invoice->items()->find($r->item_id);
              if($item){
                $item->price=$r->key?:0;
                $item->total_price=($item->quantity*$item->price) - ($item->quantity*$item->discount_amount)+($item->quantity*$item->tax_amount);
                if($item->productVariant){
                $item->purchase_price=$item->productVariant->purchase_price > 0?$item->productVariant->purchase_price:$item->productVariant->final_price;
                }else{
                $item->purchase_price=$item->product?$item->product->purchase_price:0;
                }
                $item->purchase_total=$item->purchase_price*$item->quantity;
                $item->profit_loss=$item->total_price-$item->purchase_total;
                $item->save();
              }
            }
            if($action=='shipping-charge'){
              $invoice->shipping_charge=$r->key?:0;
            }
    
            if($action=='tax-charge'){
              $invoice->tax=$r->key?:0;
              $invoice->tax_amount=$invoice->total_price*$invoice->tax/100;
            }
    
            if($action=='discount-type'){
              $invoice->discount_type=$r->key?'flat':'percantage';
              $invoice->discount_price=$invoice->discountAmount();
            }
            if($action=='discount'){
              $invoice->discount=$r->key?:0;
              $invoice->discount_price=$invoice->discountAmount();
            }
            
            if($action=='adjustment-amount'){
            $invoice->adjustment_amount=$r->key?:0;
            }
            
            $invoice->total_price=$invoice->items()->sum('total_price');
            $invoice->total_purchase=$invoice->items->sum('purchase_total');
            $invoice->profit_loss=$invoice->items->sum('profit_loss');
            $invoice->total_items=$invoice->items()->count();
            $invoice->total_qty=$invoice->items()->sum('quantity');
            $invoice->grand_total=($invoice->total_price+$invoice->shipping_charge+$invoice->tax_amount)-($invoice->discount_price+$invoice->adjustment_amount);
            $invoice->paid_amount=0;
            $invoice->due_amount=$invoice->grand_total-$invoice->paid_amount;
            $invoice->save();
    
            $customers =User::latest()->where('wholesale',true)->whereIn('status',[0,1])->get(['id','name']);
            $warehouses =Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']);
            $methods =Attribute::where('type',11)->where('status','active')->get();
            $infoView =view(adminTheme().'wholesale.includes.saleInformation',compact('invoice','customers','warehouses'))->render();
            $view =view(adminTheme().'wholesale.includes.orderItems',compact('invoice','message'))->render();
            $datasBill =view(adminTheme().'wholesale.includes.paymentModal',compact('invoice','methods'))->render();
            return Response()->json([
                'success' => true,
                'view' => $view,
                'infoView' => $infoView,
                'datasBill' => $datasBill,
            ]);
      }
      
        if($action=='search-product' || $action=='search-barcode-product'){

            if($action=='search-product'){
              $searchProducts =Post::latest()->where('type',2)->where('status','active')
              ->where(function($q)use($r){
                $q->where('name','like','%'.$r->key.'%');
                $q->orWhere('id','like','%'.$r->key.'%');
              })
              ->with('productVariationActiveAttributeItems')
              ->get(['id','variation_status','name', 'purchase_price', 'quantity', 'sku_code', 'bar_code']);
            }
            
            if($action=='search-barcode-product'){
                $barcode = $r->key;
                $searchProducts = Post::latest()->where('type',2)->where('status','active')
                    ->where(function($q)use($barcode){
                        $q->orWhere('bar_code',$barcode)
                          ->orWhereHas('productVariationActiveAttributeItems', function ($q2) use ($barcode) {
                              $q2->where('stock_status', true)
                                 ->where('barcode',$barcode);
                          });
                    })
                    ->limit(10)->get(['id','variation_status','name', 'purchase_price', 'quantity', 'sku_code', 'bar_code']);
                    
                    if(!$invoice->branch){
                        $message='<span style="color:red;">Please Select Store</span>';
                    }else{
                        
                        if($searchProducts->first()){
                            $product=$searchProducts->first();
                            if($invoice->branch){
                                if($product->variation_status){
                                    foreach($product->productVariationActiveAttributeItems as $variantItem)
                                    {
                                        $item =$invoice->items()->where('product_id', $product->id)->whereJsonContains('sku_id',$variantItem->attributeVatiationItems->pluck('attribute_item_id','attribute_id'))->first();
                                        if(!$item){
                                            $item =new OrderItem();
                                            $item->order_id =$invoice->id;
                                            $item->user_id =$invoice->user_id;
                                            $item->product_id =$product->id;
                                            $item->product_name =$product->name;
                                            $item->barcode =$variantItem->barcode;
                                            $item->variant_id =$variantItem->id;
                                            $item->sku_id =json_encode($variantItem->attributeVatiationItems->pluck('attribute_item_id','attribute_id'));
                                            $item->sku_value =json_encode($item->itemMakeAttributes());
                                            $item->weight_unit =$product->weight_unit;
                                            $item->price =$variantItem->wholesale_price > 0 ? $variantItem->wholesale_price : ($variantItem->final_price > 0 ? $variantItem->final_price : 0);
                                            $item->save();
                                        }
                                    }
                                    
                                }else{
                                    $item = $invoice->items()->where('product_id', $product->id)->first();
                                    if(!$item){
                                        $item =new OrderItem();
                                        $item->order_id =$invoice->id;
                                        $item->user_id =$invoice->user_id;
                                        $item->product_id =$product->id;
                                        $item->product_name =$product->name;
                                        $item->weight_unit =$product->weight_unit;
                                        $item->price =$product->wholesale_price > 0 ? $product->wholesale_price : ($product->final_price > 0 ? $product->final_price : 0);
                                        $item->save();
                                    }
                                }
                            }
                        }else{
                            $message='<span style="color:red;">Product Not Found</span>';
                        }
                            
                    }
                }

            $customers =User::latest()->where('customer',true)->whereIn('status',[0,1])->get(['id','name']);
            $warehouses =Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']);
            $methods =Attribute::where('type',11)->where('status','active')->get();
            
            
            $infoView =view(adminTheme().'wholesale.includes.saleInformation',compact('invoice','customers','warehouses'))->render();
            $datasItems =view(adminTheme().'wholesale.includes.orderItems',compact('invoice','methods','message'))->render();
            $datasBill =view(adminTheme().'wholesale.includes.paymentModal',compact('invoice','methods'))->render();
            
            $view =view(adminTheme().'wholesale.includes.searchResult',compact('searchProducts','invoice'))->render();
            
            return Response()->json([
                'success' => true,
                'view' => $view,
                'count' => $searchProducts->count(),
                'datasItems' => $datasItems,
                'datasBill' => $datasBill,
                'infoView' => $infoView,
            ]);

      }
        
        if($action=='payment'){
       
            $check = $r->validate([
                'created_at' => 'required|date',
                'amount' => 'required|numeric',
                'method' => 'required|numeric',
            ]);
            $method =Attribute::where('type',11)->find($r->method);
            if(!$method){
                Session()->flash('error','Method Type Are Found');
                return redirect()->back();
            }

            $transaction =new Transaction();
            $transaction->src_id =$invoice->id;
            if($r->transaction_type==1){
                $transaction->type =2;
            }else{
               $transaction->type =0; 
            }
            $transaction->status ='success';
            $transaction->method_id=$method->id;
            $transaction->transection_id=Carbon::now()->format('YmdHis');
            $transaction->amount=$r->amount;
            $transaction->billing_note=$r->note;
            $transaction->billing_name=$invoice->name;
            $transaction->billing_mobile=$invoice->mobile;
            $transaction->billing_email=$invoice->email;
            $transaction->billing_address=$invoice->address;
            $transaction->created_at=$r->created_at;
            $transaction->save();
            
            dailyCashMacting($transaction->created_at);

            //Method Balance Update
            if($transaction->type==1){
                $method->amounts -=$transaction->amount;
            }else{
                $method->amounts +=$transaction->amount;
            }            
            $method->save();

            //Order payment Update
            $invoice->paid_amount=$invoice->transactionsSuccess->sum('amount');
            $invoice->return_amount=$invoice->transactionsRefund->sum('amount');

            if($invoice->grand_total >= $invoice->paid_amount){
                $invoice->due_amount=$invoice->grand_total-$invoice->paid_amount;
                $invoice->extra_amount=0;
            }else{
                $invoice->due_amount=0; 
                $invoice->extra_amount=$invoice->paid_amount-$invoice->grand_total; 
            }
            
            if($invoice->due_amount==0){
            $invoice->payment_status='paid';
            }elseif($invoice->due_amount==$invoice->grand_total){
            $invoice->payment_status='unpaid';
            }else{
            $invoice->payment_status='partial';
            }
            $invoice->save();
            if($transaction->type==1){
                Session()->flash('success','Payment Refund Successfully Done!');
            }else{
                Session()->flash('success','Payment Added Successfully Done!');
            }
            return redirect()->back();
        }
        
        if($action=='payment-delete'){
            
            $transaction =$invoice->transactionsAll()->find($r->transection_id);
            if($transaction){
               $starDate =$transaction->created_at;
                if($method =$transaction->method){
                    //Method Balance Update
                    if($transaction->type==1){
                        $method->amounts +=$transaction->amount;
                    }else{
                        $method->amounts -=$transaction->amount;
                    }            
                    $method->save();
                }
                $transaction->delete();
                
                dailyCashMacting($starDate); 
            }
            
            $invoice->paid_amount=$invoice->transactionsSuccess->sum('amount');
            $invoice->return_amount=$invoice->transactionsRefund->sum('amount');

            if($invoice->grand_total >= $invoice->paid_amount){
                $invoice->due_amount=$invoice->grand_total-$invoice->paid_amount;
                $invoice->extra_amount=0;
            }else{
                $invoice->due_amount=0; 
                $invoice->extra_amount=$invoice->paid_amount-$invoice->grand_total; 
            }
            
            if($invoice->due_amount==0){
            $invoice->payment_status='paid';
            }elseif($invoice->due_amount==$invoice->grand_total){
            $invoice->payment_status='unpaid';
            }else{
            $invoice->payment_status='partial';
            }
            $invoice->save();
            
            Session()->flash('success','Payment Deleted Successfully Done!');
            return redirect()->back();
        }
        

          $customers =User::latest()->where('wholesale',true)->whereIn('status',[0,1])->get(['id','name']);
          $warehouses =Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']);
          
          $methods =Attribute::where('type',11)->where('status','active')->get();
      
      return view(adminTheme().'wholesale.ordersManage',compact('invoice','customers','searchProducts','warehouses','methods','message')); 
    }
    
    public function posOrders(Request $r){
        
        $allPer = empty(json_decode(Auth::user()->permission->permission, true)['posUrders']['all']);
        
        
        
        
        // Filter Action Start
            if($r->action){
         
                if($r->checkid){
                    
                    $datas=Order::latest()->where('order_type','pos_order')->whereIn('id',$r->checkid)->get();
                    foreach($datas as $data){
                        
                        if($r->action==1){
                            
                            //Store adjust
                            if($data->order_status=='delivered'){
                                foreach($data->items as $item){
                                    if($product =$item->product){
                                        $store =$product->warehouseStores()->where('branch_id',$data->branch_id)->where('variant_id',$item->variant_id)->first();
                                        if($store){
                                            $store->quantity +=$item->quantity;
                                            $store->save();
                                        }
                                        if($variant =$item->productVariant){
                                            $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                                            $variant->save();
                                        }
                                        $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                                        $product->save();
                                    }
                                }
                            }
                            
                            $data->order_status ='pending';
                            $data->save();
                            
                        }elseif($r->action==2){
                            
                            if($data->order_status=='delivered'){
                                
                            }else{
                                $status =true;
                                foreach($data->items as $item){
                                    if($product =$item->product){
                                        if($item->quantity > $product->warehouseStock($data->branch_id,$item->variant_id)){
                                            $status =false;
                                        }
                                    }
                                }

                                if($status){
                                    foreach($data->items as $item){
                                        if($product =$item->product){
                                            $store =$product->warehouseStores()->where('branch_id',$data->branch_id)->where('variant_id',$item->variant_id)->first();
                                            if($store){
                                                $store->quantity -=$item->quantity;
                                                $store->save();
                                            }
                                            
                                            if($variant =$item->productVariant){
                                                $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                                                $variant->save();
                                            }
                                            $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                                            $product->save();
                                        }
                                    }
                                    
                                    $data->order_status ='delivered';
                                    $data->save();
                                }
                                
                            }
                        }elseif($r->action==4){
                            
                            //Store adjust
                            if($data->order_status=='delivered'){
                                
                                foreach($data->items as $item){
                                    
                                    if($product =$item->product){
                                        $store =$product->warehouseStores()->where('branch_id',$data->branch_id)->where('variant_id',$item->variant_id)->first();
                                        if($store){
                                            $store->quantity +=$item->quantity;
                                            $store->save();
                                        }
                                        if($variant =$item->productVariant){
                                            $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                                            $variant->save();
                                        }
                                        $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                                        $product->save();
                                    }
                                }
                            }
                            
                            $data->order_status ='cancelled';
                            $data->save();
                            
                        }elseif($r->action==6){
                            $data->items()->delete();
                            $data->transections()->delete();
                            $data->delete();
                        }
 
                    }
                    
                
                Session()->flash('success','Action Successfully Completed!');
    
            }else{
              Session()->flash('info','Please Need To Select Minimum One Post');
            }
    
            return redirect()->back();
          }
        
        // Filter Action Start
        
        $orders =Order::latest()->where('order_type','pos_order')
                ->where('order_status','<>','temp')
                ->where(function($q) use ($r,$allPer) {
        
                if($r->search){
                    $q->where(function($qq)use($r){
                        $qq->where('invoice','LIKE','%'.$r->search.'%')->orWhere('mobile','LIKE','%'.$r->search.'%');
                        ;
                    });
                }else{
                    if (general()->masterAdmins() && !in_array(Auth::id(),general()->masterAdmins())) {
                        // $q->where('addedby_id','<>',671);
                        $q->where(function($query) {
                            $query->where('addedby_id', '<>', 671);
                                //   ->orWhereDate('created_at', '=', now()->toDateString());
                        });
                    }
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
                   $q->where('order_status',$r->status); 
                }
                // Check Permission
                if($allPer){
                 $q->where('addedby_id',auth::id()); 
                }
                
        
            })
            ->paginate(25)->appends([
              'search'=>$r->search,
              'status'=>$r->status,
              'startDate'=>$r->startDate,
              'endDate'=>$r->endDate,
            ]);
        
        
        //Total Count Results
        $totals = DB::table('orders')
        ->where('order_type','pos_order')
        ->where(function($q){
            if (general()->masterAdmins() && !in_array(Auth::id(),general()->masterAdmins())) {
                $q->where('hidden_status', false);
            }
        })
        ->where('order_status','<>','temp')
        ->where(function($q)use($allPer){
            // Check Permission
            if($allPer){
             $q->where('addedby_id',auth::id()); 
            }
        })
        ->selectRaw('count(*) as total')
        ->selectRaw("count(case when order_status = 'pending' then 1 end) as pending")
        ->selectRaw("count(case when order_status = 'confirmed' then 1 end) as confirmed")
        ->selectRaw("count(case when order_status = 'delivered' then 1 end) as delivered")
        ->selectRaw("count(case when order_status = 'cancelled' then 1 end) as cancelled")
        ->first();
        
        return view(adminTheme().'pos-orders.ordersAll',compact('orders','totals'));
    }

     public function posOrdersAction(Request $r,$action,$id=null){

      if($action=='create'){

        $invoice =new Order();
        $invoice->order_type ='pos_order';
        $invoice->order_status ='temp';
        $invoice->addedby_id =Auth::id();
        $invoice->save();
        
        $invoice->created_at =Carbon::now();
        $warehouse =Attribute::latest()->where('type',5)->where('status','active')->first();
        if($warehouse){
            $invoice->branch_id =general()->online_store_id?:$warehouse->id;
        }
        $customer =User::find(621);
        if($customer){
            $invoice->user_id =$customer->id;
            $invoice->name =$customer->name;
            $invoice->mobile =$customer->mobile;
            $invoice->email =$customer->email;
            $invoice->address =$customer->fullAddress();
        }
        $invoice->tax =general()->tax;
        $invoice->invoice =$invoice->created_at->format('Ymd').$invoice->id;
        $invoice->save();
        
        return redirect()->route('admin.posOrdersAction',['edit',$invoice->id]);
      }
      
      $message =null;
      $invoice =Order::where('order_type','pos_order')->find($id);
      if(!$invoice){
          Session()->flash('error','This Order Invoice Are Not Found');
          return redirect()->route('admin.posOrders');
      }
      
        if(Auth::id()==663){
        //  202508063830 
        
        // $trans = $invoice->transections->first();
        // return $trans;
        // $trans->amount =760;
        // $trans->save();
        
        // $invoice->adjustment_amount =15;
        // $methodCash =$trans->methodOption;
        // if($methodCash){
        //     $methodCash->amounts -=10;
        //     $methodCash->save(); 
        // }
        
        // $invoice->exchange_amount=$invoice->totalExchangeAmount();
        // $invoice->grand_total=($invoice->total_price+$invoice->shipping_charge-($invoice->exchange_amount+$invoice->adjustment_amount));
         
         
        // $invoice->received_amount=$invoice->transections()->where('status','success')->sum('received_amount');
        // if($invoice->grand_total >=$invoice->received_amount){
        //   $invoice->paid_amount =$invoice->received_amount;
        //   $invoice->due_amount =$invoice->grand_total -$invoice->received_amount;
        //   $invoice->changed_amount=0;
        // }else{
        //   $invoice->paid_amount =$invoice->grand_total;
        //   $invoice->due_amount =0; 
        //   $invoice->changed_amount=$invoice->received_amount - $invoice->grand_total;
        // }
        
        // if($invoice->due_amount==0){
        //   $invoice->payment_status='paid';
        // }elseif($invoice->grand_total > $invoice->due_amount){
        //   $invoice->payment_status='partial';
        // }else{
        //   $invoice->payment_status='unpaid';
        // }
        // $invoice->save();
        
        //  return $invoice;
      }
        
              
        if($action=='exchange'){
        if($invoice->order_status!='delivered'){
              Session()->flash('error','Incompleted Sales can not exchange allow');
              return redirect()->route('admin.posOrders');
        }
        $Ninvoice =Order::where('order_type','pos_order')->where('parent_id',$invoice->id)->where('order_status','temp')->where('addedby_id',Auth::id())->first();
        if(!$Ninvoice){
          $Ninvoice =new Order();
          $Ninvoice->order_type ='pos_order';
          $Ninvoice->order_status ='temp';
          $Ninvoice->addedby_id =Auth::id();
          $Ninvoice->parent_id =$invoice->id;
          $Ninvoice->save();
        }
        
        $Ninvoice->created_at =Carbon::now();
        $Ninvoice->branch_id =$invoice->branch_id;
        $Ninvoice->user_id =$invoice->user_id;
        $Ninvoice->name =$invoice->name;
        $Ninvoice->mobile =$invoice->mobile;
        $Ninvoice->email =$invoice->email;
        $Ninvoice->address =$invoice->address;
        $Ninvoice->invoice =$Ninvoice->created_at->format('Ymd').$Ninvoice->id;
        $Ninvoice->save();
        
        return redirect()->route('admin.posOrdersAction',['edit',$Ninvoice->id]);

      }
     
        if($action=='invoice'){
            $cashMethod =$invoice->transections()->where('status','success')->where('payment_method','Cash Method')->first();
            $cardMethod =$invoice->transections()->where('status','success')->where('payment_method','Card Method')->first();
            $mobileMethod =$invoice->transections()->where('status','success')->where('payment_method','Mobile Method')->first();
  
            return view(adminTheme().'pos-orders.PosInvoice',compact('invoice','cashMethod','cardMethod','mobileMethod'));

            return view(adminTheme().'pos-orders.orderPosInvoice',compact('invoice','cashMethod','cardMethod','mobileMethod'));
      }
      
        if($invoice->order_status=='delivered'){
          Session()->flash('error','Sales status Delivered can not allow edit');
          return redirect()->route('admin.posOrders');
        }
      
      $accountsMethods =Attribute::where('type',11)->where('status','active')->get(['id','name','amounts','location']);
      

      if($action=='cartminus' || $action=='cartreturnplus' || $action=='cartreturnminus' || $action=='cartplus' || $action=='cartremove' || $action=='cartquantity' || $action=='taxupdate' || $action=='shippingupdate' || $action=='discountupdate' || $action=='adjustmentupdate'){
        $invoice =Order::where('order_type','pos_order')->find($id);
        if($invoice){
            
            if($action=='cartreturnminus' && $invoice->returnItems()){
                
                $item =$invoice->returnItems()->find($r->item_id);
                if($item){
                    if($item->quantity > $item->return_quantity){
                        $item->return_quantity +=1;
                        $item->return_discount =$item->discountAmount()*$item->return_quantity;
                        $item->return_total_price =($item->regular_price*$item->return_quantity)-$item->return_discount;
                        $item->return_vat =($item->return_total_price*$item->tax/100);
                        $item->return_total =$item->return_total_price+$item->return_vat;
                        $item->save();
                    }else{
                        $message ='<span style="background: #e1000a;display: block;color: white;padding: 2px 10px;">Return can not more plus form quantity</span>';
                    }
                }
                
            }
            
            if($action=='cartreturnplus' && $invoice->returnItems()){
                $item =$invoice->returnItems()->find($r->item_id);
                if($item){
                    if($item->return_quantity > 0 && $item->quantity >= $item->return_quantity){
                        $item->return_quantity -=1;
                        $item->return_discount =$item->discountAmount()*$item->return_quantity;
                        $item->return_total_price =($item->regular_price*$item->return_quantity)-$item->return_discount;
                        $item->return_vat =($item->return_total_price*$item->tax/100);
                        $item->return_total =$item->return_total_price+$item->return_vat;
                        $item->save();
                    }else{
                        $message ='<span style="background: #e1000a;display: block;color: white;padding: 2px 10px;">Return can not more minus form quantity</span>';
                    }
                }
                
            }

            
          $item =$invoice->items()->find($r->item_id);
          if($item){
            if($action=='cartminus' && $item->quantity > 1){

              $product=$item->product;
              if($product && $invoice->order_status=='delivered'){
                $store =$product->warehouseStores()->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                if($store){
                  $store->quantity +=1;
                  $store->save();
                }
                
                if($variant =$item->productVariant){
                    $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                    $variant->save();
                }
                
                $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                $product->save();
              }
              $item->quantity -=1;
              $item->discount =$invoice->discount;
              $item->discount_amount =$item->discountAmount()*$item->quantity;
              $item->price=($item->regular_price*$item->quantity);
              $item->total_price=$item->price-$item->discount_amount;
              $item->tax_amount =$item->taxAmount();
              $item->final_price=$item->total_price + $item->tax_amount;
              
              if($item->productVariant){
                $item->purchase_price=$item->productVariant->purchase_price > 0?$item->productVariant->purchase_price:$item->productVariant->final_price;
              }else{
                $item->purchase_price=$item->product?$item->product->purchase_price:0;
              }
              $item->purchase_total=$item->purchase_price*$item->quantity;
              $item->profit_loss=$item->final_price-$item->purchase_total;
              $item->save();
            }
            
            if($action=='cartplus'){
              $product=$item->product;
              if($product){
                if($invoice->order_status=='delivered'){
                  if($product->warehouseStock($invoice->branch_id,$item->variant_id) >= 1){

                    $store =$product->warehouseStores()->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                    if($store){
                      $store->quantity -=1;
                      $store->save();
                    }
                    
                    if($variant =$item->productVariant){
                        $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                        $variant->save();
                    }
                    
                    $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                    $product->save();

                    $item->quantity +=1;
                    $item->discount_amount =$item->discountAmount()*$item->quantity;
                    $item->price=($item->regular_price*$item->quantity);
                    $item->total_price=$item->price-$item->discount_amount;
                    $item->tax_amount =$item->taxAmount();
                    $item->final_price=$item->total_price + $item->tax_amount;
                    if($item->productVariant){
                        $item->purchase_price=$item->productVariant->purchase_price > 0?$item->productVariant->purchase_price:$item->productVariant->final_price;
                      }else{
                        $item->purchase_price=$item->product?$item->product->purchase_price:0;
                      }
                      $item->purchase_total=$item->purchase_price*$item->quantity;
                      $item->profit_loss=$item->final_price-$item->purchase_total;
                    $item->save();

                  }else{
                    $message ='<span style="background: #e1000a;display: block;color: white;padding: 2px 10px;">Stock Limit Over Cannot Order</span>';
                  }
                  
                }else{

                  if($product->warehouseStock($invoice->branch_id,$item->variant_id) > $item->quantity){
                    $item->quantity +=1;
                    $item->discount_amount =$item->discountAmount()*$item->quantity;
                    $item->price=($item->regular_price*$item->quantity);
                    $item->total_price=$item->price-$item->discount_amount;
                    $item->tax_amount =$item->taxAmount();
                    $item->final_price=$item->total_price + $item->tax_amount;
                    if($item->productVariant){
                        $item->purchase_price=$item->productVariant->purchase_price > 0?$item->productVariant->purchase_price:$item->productVariant->final_price;
                      }else{
                        $item->purchase_price=$item->product?$item->product->purchase_price:0;
                      }
                      $item->purchase_total=$item->purchase_price*$item->quantity;
                      $item->profit_loss=$item->final_price-$item->purchase_total;
                    $item->save();
                    
                  }else{
                    $message ='<span style="background: #e1000a;display: block;color: white;padding: 2px 10px;">Stock Limit Over Cannot Order</span>';
                  }

                }
              }else{
                $message ='<span style="background: #e1000a;display: block;color: white;padding: 2px 10px;">Product Not found</span>';
              }
            }
            if($action=='cartquantity'){
              $product=$item->product;
              if($product){
                if($r->key){
                  $qty =$r->key;
                //Need to modify when status delivered..

                  if($product->warehouseStock($invoice->branch_id,$item->variant_id) >=$qty){
                    $item->quantity=$qty;
                    $item->discount_amount =$item->discountAmount()*$item->quantity;
                    $item->price=($item->regular_price*$item->quantity);
                    $item->total_price=$item->price-$item->discount_amount;
                    $item->tax_amount =$item->taxAmount();
                    $item->final_price=$item->total_price + $item->tax_amount;
                    if($item->productVariant){
                        $item->purchase_price=$item->productVariant->purchase_price > 0?$item->productVariant->purchase_price:$item->productVariant->final_price;
                      }else{
                        $item->purchase_price=$item->product?$item->product->purchase_price:0;
                      }
                      $item->purchase_total=$item->purchase_price*$item->quantity;
                      $item->profit_loss=$item->final_price-$item->purchase_total;
                    $item->save();
                  }else{
                    $message ='<span style="background: #e1000a;display: block;color: white;padding: 2px 10px;">Stock Limit Over Cannot Order</span>';
                  }

                }
              }
            }
            if($action=='cartremove'){
              $product=$item->product;
              if($product && $invoice->order_status=='delivered'){
                $store =$product->warehouseStores()->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                if($store){
                  $store->quantity +=$item->quantity;
                  $store->save();
                }
                if($variant =$item->productVariant){
                    $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                    $variant->save();
                }
                $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                $product->save();
              }
              $item->delete();
            }
          }
        
        //   if($action=='taxupdate'){
        //       $invoice->tax=$r->key?:0;
        //       $invoice->tax_amount=$invoice->total_price*$invoice->tax/100;
        //   }
          
        //   if($action=='shippingupdate'){
        //       $invoice->shipping_charge=$r->key?:0;
        //   }

          if($action=='discountupdate'){
              $invoice->discount_type=$r->discountType?:null;
              $invoice->discount=$r->key?:0;
              
              foreach($invoice->items as $item){
                    
                    if($invoice->discount > 0){
                      $item->discount =$invoice->discount;
                    }else{
                        $product =$item->product;
                        $variant =$item->productVariant;
                        if($item->variant_id && $variant){
                        $item->discount =$variant->discountPercent();
                        }else{
                        $item->discount =$product->discountPercent();
                        }
                    }
                    
                    $item->discount_amount =$item->discountAmount()*$item->quantity;
                    $item->price=($item->regular_price*$item->quantity);
                    $item->total_price=$item->price-$item->discount_amount;
                    $item->tax_amount =$item->taxAmount();
                    $item->final_price=$item->total_price + $item->tax_amount;
                    $item->save();
              }
              
            //   $invoice->discount_price=$invoice->discountAmount();
          }
          
          if($action=='adjustmentupdate'){
              $invoice->adjustment_amount=$r->key?:0;
          }

          if($action=='cartreset'){

            foreach($invoice->items as $item){
              $product=$item->product;
              if($product && $invoice->order_status=='delivered'){
                $store =$product->warehouseStores()->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                if($store){
                  $store->quantity +=$item->quantity;
                  $store->save();
                }
                if($variant =$item->productVariant){
                    $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                    $variant->save();
                }
                $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                $product->save();
              }
              $item->delete();
            }

          }

          $invoice->total_price=$invoice->items()->sum('final_price');
          $invoice->total_purchase=$invoice->items->sum('purchase_total');
          $invoice->profit_loss=$invoice->items->sum('profit_loss');
          $invoice->total_items=$invoice->items()->count();
          $invoice->total_qty=$invoice->items()->sum('quantity');
          $invoice->tax_amount=$invoice->items()->sum('tax_amount');
          $invoice->discount_amount=$invoice->items()->sum('discount_amount');
          $invoice->discount_price=0;
          $invoice->exchange_amount=$invoice->totalExchangeAmount();
          $invoice->grand_total=($invoice->total_price+$invoice->shipping_charge-($invoice->exchange_amount+$invoice->adjustment_amount));
          
          $invoice->received_amount=$invoice->transections()->where('status','success')->sum('received_amount');
            if($invoice->grand_total >=$invoice->received_amount){
               $invoice->paid_amount =$invoice->received_amount;
               $invoice->due_amount =$invoice->grand_total -$invoice->received_amount;
               $invoice->changed_amount=0;
            }else{
               $invoice->paid_amount =$invoice->grand_total;
               $invoice->due_amount =0; 
               $invoice->changed_amount=$invoice->received_amount - $invoice->grand_total;
            }
            
            if($invoice->due_amount==0){
              $invoice->payment_status='paid';
            }elseif($invoice->grand_total > $invoice->due_amount){
              $invoice->payment_status='partial';
            }else{
              $invoice->payment_status='unpaid';
            }
          
        //   if($invoice->grand_total >=$invoice->paid_amount){
        //       $invoice->due_amount =$invoice->grand_total -$invoice->paid_amount;
        //       $invoice->extra_amount=0;
        //     }else{
        //       $invoice->due_amount =0; 
        //       $invoice->extra_amount=$invoice->paid_amount - $invoice->grand_total;
        //     }
        // //   $invoice->paid_amount=$invoice->transections()->where('status','success')->sum('amount');
        // //   $invoice->due_amount=$invoice->grand_total-$invoice->paid_amount;
          
        //   if($invoice->due_amount==0){
        //     $invoice->payment_status='paid';
        //   }elseif($invoice->grand_total > $invoice->due_amount){
        //     $invoice->payment_status='partial';
        //   }else{
        //     $invoice->payment_status='unpaid';
        //   }
          $invoice->save();
        }
        $customers =User::latest()->where('customer',true)->whereIn('status',[0,1])->where('admin',false)->where('business',false)->where('employee',false)->get(['id','name']);
        $warehouses =Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']);
        $shoppingCart =view(adminTheme().'pos-orders.includes.shoppingCart',compact('invoice','customers','warehouses','accountsMethods','message'))->render();
        return Response()->json([
            'success' => true,
            'shoppingCart' => $shoppingCart
        ]);
      }
      
      if($action=='addCart' || $action=='selectCustomer' || $action=='searchCustomer' || $action=='invoiceFilter' || $action=='addCustomer' || $action=='selectWarehouse'){
        
        if($action=='invoiceFilter'){
            $order =Order::latest()->where('order_type','pos_order')
                    ->where('order_status','delivered')->where('invoice',$r->search)->first();
            $url =null;
            if($order){
                $url =route('admin.posOrdersAction',['exchange',$order->id]);
            }
            return Response()->json([
                'success' => true,
                'url' => $url,
            ]);
        }
        
        if($action=='searchCustomer'){
            $customers =User::latest()->where('customer',true)->whereIn('status',[0,1])
                        // ->where('admin',false)
                        ->where('business',false)
                        ->where('employee',false)
                        ->where(function($q)use($r){
                            $q->where('name','like','%'.$r->search.'%')->orWhere('mobile','like','%'.$r->search.'%')->orWhere('email','like','%'.$r->search.'%')->orWhere('member_card_id','like','%'.$r->search.'%');
                        })
                        ->limit(10)
                        ->get(['id','name','email','mobile','member_card_id']);
                        
            $view =view(adminTheme().'pos-orders.includes.searchCustomers',compact('customers','invoice'))->render();
            return Response()->json([
                'success' => true,
                'view' => $view,
            ]);
        }
        
        if($action=='addCustomer'){
          
            $username = $r->mobile;
            
            if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
                $field = 'email';
            } else {
                $field = 'mobile';
            }
          
            $customer =User::where($field,$username)->first();
            if(!$customer){
                $password= Str::random(8);
                $customer =new User();
                if($field=='email'){
                $customer->email=$username;
                }else{
                $customer->mobile=$username;
                }
                $customer->name=$r->name?:'Unknown Customer';
                $customer->member_card_id=$r->card;
                $customer->password=Hash::make($password);
                $customer->password_show=$password;
                $customer->country=1;
                $customer->status=1;
                $customer->save();
            }
        
            $invoice->user_id =$customer->id;
            $invoice->name =$customer->name;
            $invoice->mobile =$customer->mobile;
            $invoice->email =$customer->email;
            $invoice->member_card_id =$customer->member_card_id;
            $invoice->address =$customer->fullAddress();
            $invoice->save();
        }
        
        if($action=='selectCustomer'){
          $customer =User::find($r->customer_id);
          if($customer){
            $invoice->user_id =$customer->id;
            $invoice->name =$customer->name;
            $invoice->mobile =$customer->mobile;
            $invoice->email =$customer->email;
            $invoice->member_card_id =$customer->member_card_id;
            $invoice->address =$customer->fullAddress();
            $invoice->save();
          }
        }

        if($action=='selectWarehouse'){
          $invoice->branch_id =$r->warehouse_id?:null;
          $invoice->save();
        }

        if($action=='addCart'){
          $product =Post::latest()->where('type',2)->where('status','active')->find($r->product_id);
          if($product){
            if($invoice->user && $invoice->branch){
                $vars=true;
                $variant=null;
                $variantId=null;
                if($product->variation_status){
                    $variant = $product->productVariationActiveAttributeItems()->where('barcode',$r->barcode)->first();
                    if($variant){
                        $variantId=$variant->id;
                    }else{
                        $vars=false;
                        $message='<span style="color:red;">Please Select product variant item (Color, size)</span>';
                    }
                }
                
                if($vars){
                    $item = $invoice->items()->where('product_id', $product->id);
                    if ($variant) {
                        $item = $item->whereJsonContains('sku_id', $variant->attributeVatiationItems->pluck('attribute_item_id', 'attribute_id'));
                    }
                    $item = $item->first();
                    if(!$item){
                      $item =new OrderItem();
                      $item->order_id =$invoice->id;
                      $item->user_id =$invoice->user_id;
                      $item->product_id =$product->id;
                      $item->quantity =1;
                    }else{
                        $item->quantity +=1;
                    }
                    $itemQty =$item->quantity;
                    if($invoice->order_status=='delivered'){
                        $itemQty =1;
                    }
                    
                    if($vars){
                        if($product->warehouseStock($invoice->branch_id,$variantId) >= $itemQty){
                            $item->product_name =$product->name;
                            $item->weight_unit =$product->weight_unit;
                            if($variant){
                              $item->barcode =$variant->barcode;
                              $item->variant_id =$variant->id;
                              $item->sku_id =json_encode($variant->attributeVatiationItems->pluck('attribute_item_id', 'attribute_id'));
                              $item->sku_value =json_encode($item->itemMakeAttributes());
                              $item->regular_price =$variant->reguler_price;
                              $item->tax =$variant->taxPercentage();
                              if($invoice->discount > 0){
                              $item->discount =$invoice->discount;
                              }else{
                              $item->discount =$variant->discountPercent();
                              }
                              $item->purchase_price=$variant->purchase_price > 0?$variant->purchase_price:$variant->final_price;
                            }else{
                              $item->barcode =$r->barcode?:null;
                              $item->variant_id=null;
                              $item->sku_id=null;
                              $item->sku_value=null;
                              $item->regular_price =$product->regular_price;
                              $item->tax =$product->taxPercentage();
                              if($invoice->discount > 0){
                              $item->discount =$invoice->discount;
                              }else{
                              $item->discount =$product->discountPercent();
                              }
                              $item->purchase_price=$product->purchase_price;
                            }
                            
                            $item->discount_amount =$item->discountAmount()*$item->quantity;
                            $item->price=($item->regular_price*$item->quantity);
                            $item->total_price=$item->price-$item->discount_amount;
                            $item->tax_amount =$item->taxAmount();
                            $item->final_price=$item->total_price + $item->tax_amount;
                            $item->purchase_total=$item->purchase_price*$item->quantity;
                            $item->profit_loss=$item->final_price-$item->purchase_total;
                            $item->save();
      
                          
                          //Delivery stock update
                          if($invoice->order_status=='delivered'){
                            $store =$product->warehouseStores()->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                            if($store){
                              $store->quantity -=$itemQty;
                              $store->save();
                            }
                            if($variant =$item->productVariant){
                                $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                                $variant->save();
                            }
                            $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                            $product->save();
                          }
                          
                          
                        }else{
                            $message ='<span style="background: #e1000a;display: block;color: white;padding: 2px 10px;">Stock Limit Over Cannot Order</span>';
                        }
                    }
                }
            }

            if(!$invoice->user && !$invoice->branch){
              $message='<span style="color:red;">Please Select Customer and warehouse</span>';
            }elseif(!$invoice->user){
              $message='<span style="color:red;">Please Select Customer</span>';
            }elseif(!$invoice->branch){
              $message='<span style="color:red;">Please Select warehouse</span>';
            }

          }

          $invoice->total_price=$invoice->items()->sum('final_price');
          $invoice->total_purchase=$invoice->items->sum('purchase_total');
          $invoice->profit_loss=$invoice->items->sum('profit_loss');
          $invoice->total_items=$invoice->items()->count();
          $invoice->total_qty=$invoice->items()->sum('quantity');
          $invoice->tax_amount=$invoice->items()->sum('tax_amount');
          $invoice->discount_amount=$invoice->items()->sum('discount_amount');
          $invoice->discount_price=0;
          $invoice->exchange_amount=$invoice->totalExchangeAmount();
          $invoice->grand_total=($invoice->total_price+$invoice->shipping_charge-($invoice->exchange_amount+$invoice->adjustment_amount));
          
          $invoice->received_amount=$invoice->transections()->where('status','success')->sum('received_amount');
            if($invoice->grand_total >=$invoice->received_amount){
               $invoice->paid_amount =$invoice->received_amount;
               $invoice->due_amount =$invoice->grand_total -$invoice->received_amount;
               $invoice->changed_amount=0;
            }else{
               $invoice->paid_amount =$invoice->grand_total;
               $invoice->due_amount =0; 
               $invoice->changed_amount=$invoice->received_amount - $invoice->grand_total;
            }
            
            if($invoice->due_amount==0){
              $invoice->payment_status='paid';
            }elseif($invoice->grand_total > $invoice->due_amount){
              $invoice->payment_status='partial';
            }else{
              $invoice->payment_status='unpaid';
            }
          
        //     if($invoice->grand_total >=$invoice->paid_amount){
        //       $invoice->due_amount =$invoice->grand_total -$invoice->paid_amount;
        //       $invoice->extra_amount=0;
        //     }else{
        //       $invoice->due_amount =0; 
        //       $invoice->extra_amount=$invoice->paid_amount - $invoice->grand_total;
        //     }

        //   if($invoice->due_amount==0){
        //     $invoice->payment_status='paid';
        //   }elseif($invoice->grand_total > $invoice->due_amount){
        //     $invoice->payment_status='partial';
        //   }else{
        //     $invoice->payment_status='unpaid';
        //   }
          $invoice->save();
        }
        $products = Post::latest()->where('type',2)->where('status','active')->limit(10)->get(['id','name','final_price','quantity','variation_status','sku_code','bar_code','weight_unit']);
        $customers =User::latest()->where('customer',true)->whereIn('status',[0,1])->where('admin',false)->where('business',false)->where('employee',false)->get(['id','name','email','mobile']);
        $warehouses =Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']);
        $shoppingCart =view(adminTheme().'pos-orders.includes.shoppingCart',compact('invoice','customers','warehouses','accountsMethods','message'))->render();
        $view =view(adminTheme().'pos-orders.includes.productsList',compact('products','invoice'))->render();
        return Response()->json([
            'success' => true,
            'shoppingCart' => $shoppingCart,
            'view' => $view,
        ]);

      }

      if($action=='productFilter'){

        $cart=false;
        $products = Post::latest()->where('type',2)->where('status','active');
            
            $barcode = $r->key;
            if($r->type=='search' && $r->key){
                
                if($r->key && is_numeric($barcode) && strlen($barcode) > 6){
                
                  $products =$products
                        // ->where('variation_status', true)
                        ->where('bar_code','like','%'.$barcode.'%')
                        ->orWhereHas('productVariationActiveAttributeItems', function ($q) use ($barcode) {
                            $q->where('stock_status',true)->where('barcode','like','%'.$barcode.'%');
                        });
                }else{
                  $products =$products->where('name','like','%'.$r->key.'%')->orWhere('id','like','%'.$r->key.'%');
                }
            }
          
            if($r->type=='category' && $r->key){
                $products =$products->whereHas('ctgProducts',function($q) use($r){
                    $q->where('reff_id',$r->key);
                });
            }
        
            if($r->type=='brand' && $r->key){
                $products =$products->where('brand_id',$r->key);
            }
            $products =$products->limit(40)
            ->with('productVariationActiveAttributeItems')
            ->get();


        $shoppingCart=null;
        if($r->type=='search' && $r->key && is_numeric($barcode) && $products->count()==1){
          $product =$products->first();
          if($invoice->user && $invoice->branch){
              
                $vars =true;
                $variant=null;
                $variantId=null;
                
                if($r->key && is_numeric($barcode) && $product->variation_status){
                    $variant = $product->productVariationActiveAttributeItems()->where('barcode',$barcode)->first();
                    $variantId=$variant?$variant->id:null;
                    if($product->variation_status){
                        if(!$variant){
                            $vars=false;
                            if(strlen($barcode) > 6){
                            $message='<span style="color:red;">Please Select product variant item (Color, size)</span>';
                            }
                        }
                    }
                }
                
                if($vars){
                    
                    if($product->warehouseStock($invoice->branch_id,$variantId) > 0){
                        
                        $item = $invoice->items()->where('product_id', $product->id);
                        if ($variant) {
                            $item = $item->whereJsonContains('sku_id', $variant->attributeVatiationItems->pluck('attribute_item_id', 'attribute_id'));
                        }
                        $item = $item->first();
                        if(!$item){
                            $item =new OrderItem();
                            $item->order_id =$invoice->id;
                            $item->user_id =$invoice->user_id;
                            $item->product_id =$product->id;
                            $item->product_name =$product->name;
                            $item->weight_unit =$product->weight_unit;
                            $item->quantity=1;
                            // if($invoice->order_status=='delivered'){
                            //     $item->exchange_status=true;
                            // }
                        }else{
                            // if($invoice->order_status=='delivered'){
                            //     $vars=false;
                            //     $message='<span style="color:red;">Please Exchange product need to diffrent product</span>';
                            // }
                            $item->quantity +=1;
                        }
                        
                        $itemQty =$item->quantity;
                        if($invoice->order_status=='delivered'){
                            $itemQty =1;
                        }
                        
                        
                        if($vars){
                            if($product->warehouseStock($invoice->branch_id,$variantId) >= $itemQty){
                                $item->product_name =$product->name;
                                $item->weight_unit =$product->weight_unit;
                                if($variant){
                                  $item->barcode =$variant->barcode;
                                  $item->variant_id =$variant->id;
                                  $item->sku_id =json_encode($variant->attributeVatiationItems->pluck('attribute_item_id', 'attribute_id'));
                                  $item->sku_value =json_encode($item->itemMakeAttributes());
                                  $item->regular_price =$variant->reguler_price;
                                  $item->tax =$variant->taxPercentage();
                                  if($invoice->discount > 0){
                                  $item->discount =$invoice->discount;
                                  }else{
                                  $item->discount =$variant->discountPercent();
                                  }
                                  $item->purchase_price=$variant->purchase_price > 0?$variant->purchase_price:$variant->final_price;
                                }else{
                                  $item->barcode =$r->barcode?:null;
                                  $item->variant_id=null;
                                  $item->sku_id=null;
                                  $item->sku_value=null;
                                  $item->regular_price =$product->regular_price;
                                  $item->tax =$product->taxPercentage();
                                  if($invoice->discount > 0){
                                  $item->discount =$invoice->discount;
                                  }else{
                                  $item->discount =$product->discountPercent();
                                  }
                                  $item->purchase_price=$product->purchase_price;
                                }
                                
                                $item->discount_amount =$item->discountAmount()*$item->quantity;
                                $item->price=($item->regular_price*$item->quantity);
                                $item->total_price=$item->price-$item->discount_amount;
                                $item->tax_amount =$item->taxAmount();
                                $item->final_price=$item->total_price + $item->tax_amount;
                                $item->purchase_total=$item->purchase_price*$item->quantity;
                                $item->profit_loss=$item->final_price-$item->purchase_total;
                                $item->save();
                                
                                //Delivery stock update
                              if($invoice->order_status=='delivered'){
                                $store =$product->warehouseStores()->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                                if($store){
                                  $store->quantity -=$itemQty;
                                  $store->save();
                                }
                                if($variant =$item->productVariant){
                                    $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                                    $variant->save();
                                }
                                $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                                $product->save();
                              }
                                
                            }else{
                              $message ='<span style="background: #e1000a;display: block;color: white;padding: 2px 10px;">Stock Limit Over Cannot Order</span>';
                            }
                        }
                        
                        
                    }else{
                      $message ='<span style="background: #e1000a;display: block;color: white;padding: 2px 10px;">Stock Limit Over Cannot Order</span>';
                    }
            
            }
          }

          if(!$invoice->user && !$invoice->branch){
            $message='<span style="color:red;">Please Select Customer and warehouse</span>';
          }elseif(!$invoice->user){
            $message='<span style="color:red;">Please Select Customer</span>';
          }elseif(!$invoice->branch){
            $message='<span style="color:red;">Please Select warehouse</span>';
          }

          $invoice->total_price=$invoice->items()->sum('final_price');
          $invoice->total_purchase=$invoice->items->sum('purchase_total');
          $invoice->profit_loss=$invoice->items->sum('profit_loss');
          $invoice->total_items=$invoice->items()->count();
          $invoice->total_qty=$invoice->items()->sum('quantity');
          $invoice->tax_amount=$invoice->items()->sum('tax_amount');
          $invoice->discount_amount=$invoice->items()->sum('discount_amount');
          $invoice->discount_price=0;
          $invoice->exchange_amount=$invoice->totalExchangeAmount();
          $invoice->grand_total=($invoice->total_price+$invoice->shipping_charge-($invoice->exchange_amount+$invoice->adjustment_amount));
          
          $invoice->received_amount=$invoice->transections()->where('status','success')->sum('received_amount');
            if($invoice->grand_total >=$invoice->received_amount){
               $invoice->paid_amount =$invoice->received_amount;
               $invoice->due_amount =$invoice->grand_total -$invoice->received_amount;
               $invoice->changed_amount=0;
            }else{
               $invoice->paid_amount =$invoice->grand_total;
               $invoice->due_amount =0; 
               $invoice->changed_amount=$invoice->received_amount - $invoice->grand_total;
            }
            
            if($invoice->due_amount==0){
              $invoice->payment_status='paid';
            }elseif($invoice->grand_total > $invoice->due_amount){
              $invoice->payment_status='partial';
            }else{
              $invoice->payment_status='unpaid';
            }
          
        //   if($invoice->grand_total >=$invoice->paid_amount){
        //       $invoice->due_amount =$invoice->grand_total -$invoice->paid_amount;
        //       $invoice->extra_amount=0;
        //     }else{
        //       $invoice->due_amount =0; 
        //       $invoice->extra_amount=$invoice->paid_amount - $invoice->grand_total;
        //     }

        //   if($invoice->due_amount==0){
        //     $invoice->payment_status='paid';
        //   }elseif($invoice->grand_total > $invoice->due_amount){
        //     $invoice->payment_status='partial';
        //   }else{
        //     $invoice->payment_status='unpaid';
        //   }
          $invoice->save();
          $cart=true;

          $customers =User::latest()->where('customer',true)->whereIn('status',[0,1])->where('admin',false)->where('business',false)->where('employee',false)->get(['id','name']);
          $warehouses =Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']);
          $shoppingCart =view(adminTheme().'pos-orders.includes.shoppingCart',compact('invoice','customers','warehouses','accountsMethods','message'))->render();
        }

        $view =view(adminTheme().'pos-orders.includes.productsList',compact('products','invoice'))->render();
        return Response()->json([
            'success' => true,
            'addCart' => $cart,
            'view' => $view,
            'shoppingCart' => $shoppingCart,
        ]);

      }

      if($action=='completed-invoice'){
            
            $invoice->name =$r->name?:'Walk Customer';
            $invoice->mobile =$r->mobile;
            $invoice->email =$r->email;
            
            $customer =User::where('mobile',$invoice->mobile)->first();
            if(!$customer){
                $customer =new User();
                $customer->name =$invoice->name;
                $customer->mobile =$invoice->mobile;
                $noUser =User::where('email',$invoice->email)->first();
                if(!$noUser){
                    $customer->email =$invoice->email;
                }
                $password= Str::random(8);
                $customer->password=Hash::make($password);
                $customer->password_show=$password;
                $customer->country=1;
                $customer->status=1;
                $customer->save();
            }
            
            $invoice->user_id =$customer->id;
            
            $cardAmount =$r->card_amount?:0;
            $cardAmountF =$cardAmount > $invoice->grand_total?$cardAmount - $invoice->grand_total:0;
            $cardAmountR =$cardAmount - $cardAmountF;
            if($cardAmount > 0){
                $methodPos =Attribute::where('type',11)->find($r->pos_method);
                $methodCard =Attribute::where('type',11)->find($r->card_method);
                $payment =Transaction::where('src_id',$invoice->id)->where('payment_method','Card Method')->first();
                if(!$payment){
                  $payment =new Transaction();
                  $payment->src_id=$invoice->id;
                  $payment->payment_method='Card Method';
                  $payment->type=1;
                }
                
                $payment->user_id=$invoice->user_id;
                $payment->branch_id=$invoice->branch_id;
                $payment->billing_name=$invoice->name;
                $payment->billing_mobile=$invoice->mobile;
                $payment->billing_email=$invoice->email;
                $payment->billing_address=$invoice->address;
                $payment->billing_note='Pos Order payment';
                $payment->transection_id=$r->card_digit;
                
                $payment->method_id=$methodPos?$methodPos->id:null;
                $payment->payment_method_id=$methodCard?$methodCard->id:null;
                $payment->received_amount=$cardAmount;
                $payment->balance=$cardAmount;
                $payment->amount=$cardAmountR;
                $payment->currency=general()->currency;
                $payment->status='success';
                $payment->addedby_id=Auth::id();
                $payment->save();
                
                if($methodCard){
                $methodCard->amounts +=$payment->amount;
                $methodCard->save(); 
                }
            }
            
            $mobileAmount=$r->mobile_amount?:0;
            $mobileAmountF =$mobileAmount > ($invoice->grand_total-$cardAmountR)?$mobileAmount - ($invoice->grand_total-$cardAmountR):0;
            $mobileAmountR =$mobileAmount - $mobileAmountF;
            if($mobileAmount > 0){
                $methodMobile =Attribute::where('type',11)->find($r->mobile_method);
                $payment =Transaction::where('src_id',$invoice->id)->where('payment_method','Mobile Method')->first();
                if(!$payment){
                  $payment =new Transaction();
                  $payment->src_id=$invoice->id;
                  $payment->payment_method='Mobile Method';
                  $payment->type=1;
                }
                $payment->user_id=$invoice->user_id;
                $payment->branch_id=$invoice->branch_id;
                $payment->billing_name=$invoice->name;
                $payment->billing_mobile=$invoice->mobile;
                $payment->billing_email=$invoice->email;
                $payment->billing_address=$invoice->address;
                $payment->billing_note='Pos Order payment';
                $payment->transection_id=$r->mobile_tnx;
                
                $payment->payment_method_id=$methodMobile?$methodMobile->id:null;
                $payment->received_amount=$mobileAmount;
                $payment->balance=$mobileAmount;
                $payment->amount=$mobileAmountR;
                $payment->currency=general()->currency;
                $payment->status='success';
                $payment->addedby_id=Auth::id();
                $payment->save();
                
                if($methodMobile){
                $methodMobile->amounts +=$payment->amount;
                $methodMobile->save(); 
                }
            }
            
            $cashAmount =$r->cash_amount?:0;
            $cashAmountF =$cashAmount > ($invoice->grand_total-($cardAmountR+$mobileAmountR))?$cashAmount - ($invoice->grand_total-($cardAmountR+$mobileAmountR)):0;
            $cashAmountR =$cashAmount - $cashAmountF;
            if($cashAmount > 0){
                $methodCash =Attribute::where('type',11)->find(87);
                $payment =Transaction::where('src_id',$invoice->id)->where('payment_method','Cash Method')->first();
                if(!$payment){
                $payment =new Transaction();
                $payment->src_id=$invoice->id;
                $payment->payment_method='Cash Method';
                $payment->type=1;
                }
                $payment->user_id=$invoice->user_id;
                $payment->branch_id=$invoice->branch_id;
                $payment->billing_name=$invoice->name;
                $payment->billing_mobile=$invoice->mobile;
                $payment->billing_email=$invoice->email;
                $payment->billing_address=$invoice->address;
                $payment->billing_note='Pos Order payment';
                $payment->transection_id=rand(11111,9999).'P'.$invoice->id;
                $payment->payment_method_id=$methodCash?$methodCash->id:null;
                $payment->received_amount=$cashAmount;
                $payment->balance=$cashAmount;
                $payment->amount=$cashAmountR;
                $payment->currency=general()->currency;
                $payment->status='success';
                $payment->addedby_id=Auth::id();
                $payment->save();
                
                if($methodCash){
                    $methodCash->amounts +=$payment->amount;
                    $methodCash->save(); 
                }
            }
            
            $startDate =Carbon::now();
            
            dailyCashMacting($startDate);
            
            $invoice->received_amount=$invoice->transections()->where('status','success')->sum('received_amount');
            
            if($invoice->grand_total >=$invoice->received_amount){
            $invoice->paid_amount =$invoice->received_amount;
            $invoice->due_amount =$invoice->grand_total -$invoice->received_amount;
            $invoice->changed_amount=0;
            }else{
            $invoice->paid_amount =$invoice->grand_total;
            $invoice->due_amount =0; 
            $invoice->changed_amount=$invoice->received_amount - $invoice->grand_total;
            }
            
            if($invoice->due_amount==0){
            $invoice->payment_status='paid';
            }elseif($invoice->grand_total > $invoice->due_amount){
            $invoice->payment_status='partial';
            }else{
            $invoice->payment_status='unpaid';
            }
            $invoice->created_at=$startDate;
            $invoice->save();

            if($invoice->order_status !='delivered'){
                
                if($invoice->due_amount >= 1){
                    Session()->flash('error','Please pay sales due amount first.');
                    return redirect()->route('admin.posOrdersAction',['edit',$invoice->id]);
                }
                
                foreach($invoice->items as $item){
                  if($product=$item->product){
                    $warehouse =$invoice->branch;
                    if($warehouse){
                        $store =$product->warehouseStores()->where('branch_id',$warehouse->id)->where('variant_id',$item->variant_id)->first();
                        if($store){
                          $store->quantity -=$item->quantity;
                          $store->save();
                        }
                        
                        if($variant =$item->productVariant){
                            $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                            $variant->save();
                        }
                        
                        $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                        $product->save();
                    }
                  }
                }
            
            //Exchange Return Stock
            if($invoice->returnItems()){
                foreach($invoice->returnItems() as $item){
                  if($product=$item->product){
                    $warehouse =$invoice->parentOrder->branch;
                    if($warehouse){
                        $store =$product->warehouseStores()->where('branch_id',$warehouse->id)->where('variant_id',$item->variant_id)->first();
                        if($store){
                          $store->quantity +=$item->return_quantity;
                          $store->save();
                        }
                        
                        if($variant =$item->productVariant){
                            $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                            $variant->save();
                        }
                        
                        $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                        $product->save();
                    }
                  }
                }
            }    
            
            $invoice->order_status='delivered';
            $invoice->created_at=Carbon::now();
            $invoice->invoice=$invoice->created_at->format('Ymd').$invoice->id;
            $invoice->save();
          }

          return redirect()->route('admin.posOrdersAction',['invoice',$invoice->id]);

          $view =view(adminTheme().'pos-orders.includes.productsList',compact('products','invoice'))->render();
          return Response()->json([
              'success' => true,
              'shoppingCart' => $shoppingCart,
              'viewPOS' => $viewPOS,
              'view' => $view,
          ]);
      }

      $message =null;
      $products = Post::latest()->where('type',2)->where('status','active')->limit(10)->with('productVariationActiveAttributeItems')->get(['id','name','final_price','quantity','variation_status','sku_code','bar_code','weight_unit']);
      $customers =User::latest()->where('customer',true)->whereIn('status',[0,1])->where('admin',false)->where('business',false)->where('employee',false)->get(['id','name','mobile','email']);
      $warehouses =Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']);
      $categories =Attribute::where('type',0)->where('status','active')->where('parent_id',null)->get(['id','name']);
      $brands =Attribute::where('type',2)->where('status','active')->where('parent_id',null)->get(['id','name']);
      

      return view(adminTheme().'pos-orders.orderEdit',compact('invoice','products','customers','warehouses','categories','brands','accountsMethods','message'));
    }

    
    public function posOrdersReports(Request $r){
        
        $allPer = empty(json_decode(Auth::user()->permission->permission, true)['posUrders']['all']);
        
        $from = $r->startDate ? Carbon::parse($r->startDate): Carbon::now()->subDay(0);
        $to = $r->endDate ? Carbon::parse($r->endDate): Carbon::now();
        
        $orders = Order::latest()
        ->where('order_type', 'pos_order')
        // ->where('payment_status','paid')
        ->where('order_status','delivered')
        ->whereDate('created_at', '>=', $from)
        ->whereDate('created_at', '<=', $to)
        ->where(function($q) use ($r,$allPer) {
            if ($r->status) {
                $q->where('order_status', $r->status);
            }
            // Check Permission
            if($allPer){
             $q->where('addedby_id',auth::id()); 
            }
            
            if (general()->masterAdmins() && !in_array(Auth::id(),general()->masterAdmins())) {
                $q->where(function($query) {
                    $query->where('addedby_id', '<>', 671);
                        //   ->orWhereDate('created_at', '=', now()->toDateString());
                });
            }
            
        })
        ->select(['id','invoice','name','grand_total','discount_price','discount_amount','total_qty','tax_amount','order_status','payment_status','created_at','addedby_id'])
        ->get()->groupBy('addedby_id');
            
        
        $totalOrders = Order::latest()
            ->where('order_type', 'pos_order')
            ->where('order_status','delivered')
            // ->where('payment_status','paid')
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->where(function($q) use ($r,$allPer) {
                if ($r->status) {
                    $q->where('order_status', $r->status);
                }
                // Check Permission
                if($allPer){
                 $q->where('addedby_id',auth::id()); 
                }
                if (general()->masterAdmins() && !in_array(Auth::id(),general()->masterAdmins())) {
                    $q->where(function($query) {
                        $query->where('addedby_id', '<>', 671);
                            //   ->orWhereDate('created_at', '=', now()->toDateString());
                    });
                }
            })
            ->select(['id','invoice','name','grand_total','hidden_status','discount_price','total_qty','tax_amount','order_status','payment_status','received_amount','changed_amount','created_at','addedby_id'])
            ->get();
            collect($totalOrders)->map(function($item){
                $item->total_cash =$item->transections->where('payment_method', 'Cash Method')->sum('received_amount');
                $item->total_card =$item->transections->where('payment_method', 'Card Method')->sum('received_amount');
                $item->total_mobile =$item->transections->where('payment_method', 'Mobile Method')->sum('received_amount');
                unset($item->transections);
                return $item;
            });
        
        $accountsMethods =Attribute::where('type',11)->where('status','active')->get(['id','name','amounts','location']);
        
        return view(adminTheme().'pos-orders.ordersReports',compact('orders','allPer','from','to','totalOrders','accountsMethods')); 
    }
    
    
    public function posOrdersToday(Request $r){
        if(Auth::id()!=1){
            return abort(401);
        }
        $allPer = empty(json_decode(Auth::user()->permission->permission, true)['posUrders']['todaySale']);
        
        $from = $r->startDate ? Carbon::parse($r->startDate): Carbon::now()->subDay(0);
        
        
        if($r->isMethod('post')){
            
            Order::latest()->where('order_type', 'pos_order')->where('order_status','delivered')->whereDate('created_at',$from)->update(['hidden_status'=>false]);
            if($r->checkid){
            Order::latest()->where('order_type', 'pos_order')->where('order_status','delivered')->whereDate('created_at',$from)->whereIn('id',$r->checkid)->update(['hidden_status'=>true]);
            }
            
            $GOrders =Order::latest()->where('order_type', 'pos_order')->where('order_status','delivered')->whereDate('created_at',$from)->where('assignby_id','<>',null)->select(['id','hidden_status','addedby_id','assignby_id'])->get();
            foreach($GOrders as $GOrder){
                $GOrder->addedby_id =$GOrder->assignby_id;
                $GOrder->assignby_id=null;
                $GOrder->save();
            }
            
            $AOrders =Order::latest()->where('order_type', 'pos_order')->where('order_status','delivered')->whereDate('created_at',$from)->whereIn('id',$r->checkid)->select(['id','hidden_status','addedby_id','assignby_id'])->get();
            foreach($AOrders as $AOrder){
                $AOrder->assignby_id =$AOrder->addedby_id;
                $AOrder->addedby_id=671;
                $AOrder->save();
            }
            
            Session()->flash('success','Your Are Successfully Done');
            return redirect()->back();

        }
        
        
        
        $orders = Order::latest()
        ->where('order_type', 'pos_order')
        ->where('order_status','delivered')
        ->whereDate('created_at',$from)
        ->where(function($q) use ($r) {
            if ($r->status) {
                $q->where('order_status', $r->status);
            }
        })
        ->select(['id','invoice','name','grand_total','hidden_status','discount_price','total_qty','tax_amount','order_status','payment_status','received_amount','changed_amount','created_at','addedby_id'])
        ->get();
        collect($orders)->map(function($item){
            $item->total_cash =$item->transections->where('payment_method', 'Cash Method')->sum('received_amount');
            $item->total_card =$item->transections->where('payment_method', 'Card Method')->sum('received_amount');
            $item->total_mobile =$item->transections->where('payment_method', 'Mobile Method')->sum('received_amount');
            unset($item->transections);
            return $item;
        });
      
        
      
        
        return view(adminTheme().'pos-orders.ordersTodayReports',compact('orders','from')); 
    }
    
    
    
    // Purchase Management Function
    public function purchases(Request $r){


      // Filter Action Start
        if($r->action){
                  
          if($r->checkid){
                  
                  $datas=Order::latest()->where('order_type','purchase_order')->whereIn('id',$r->checkid)->get();
                
                  if($r->action==1){
                      foreach($datas as $data){
                          if($data->order_status!='delivered'){
                              $data->order_status='pending';
                              $data->save();
                          }
                      }
                  }elseif($r->action==2){
                      foreach($datas as $data){
                          if($data->order_status!='delivered'){

                              //Update Stock 
                              foreach($data->items as $item){
                                if($product=$item->product){
                                  $product->quantity +=$item->quantity;
                                  $product->save();
                                }
                              }
                              $data->order_status='delivered';
                              $data->save();
                          }
                      }
                  }elseif($r->action==4){
                      foreach($datas as $data){
                          if($data->order_status!='delivered'){
                              $data->order_status='cancelled';
                              $data->save();
                          }
                      }
                  }elseif($r->action==5){
                  
                    foreach($datas as $data){
                        if($data->order_status=='delivered'){
                            if($data->isStockUsed()==false){
                              //Update Stock
                                foreach($data->items as $item){
                                    if($product=$item->product){
                                        $store =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$data->branch_id)->where('variant_id',$item->variant_id)->first();
                                        if($item->quantity > 0 && $store){
                                            $store->quantity -=$item->quantity;
                                            $store->save();
                                            
                                            if($variant =$item->productVariant){
                                                $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                                                $variant->save();
                                            }
                                            $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                                            $product->save();
                                        }
                                      
                                    }
                                }
                                $data->items()->delete();
                                $data->delete();
                            }
                        }else{
                            $data->items()->delete();
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
      
      // Filter Action Start

      $invoices =Order::latest()->where('order_type','purchase_order')->where('order_status','<>','temp')
          ->where(function($q) use ($r) {
      
              if($r->search){
                  $q->where('invoice','LIKE','%'.$r->search.'%');
                  $q->orWhereHas('user',function($qq) use($r){
                        $qq->where('name','LIKE','%'.$r->search.'%');
                    });
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
                $q->where('order_status',$r->status); 
              }
      
          })
          ->paginate(25)->appends([
            'search'=>$r->search,
            'status'=>$r->status,
            'startDate'=>$r->startDate,
            'endDate'=>$r->endDate,
          ]);
    
      //Total Count Results
      $totals = DB::table('orders')
      ->where('order_type','purchase_order')->where('order_status','<>','temp')
      ->selectRaw('count(*) as total')
      ->selectRaw("count(case when order_status = 'pending' then 1 end) as pending")
      ->selectRaw("count(case when order_status = 'delivered' then 1 end) as delivered")
      ->selectRaw("count(case when order_status = 'cancelled' then 1 end) as cancelled")
      ->first();
      
      return view(adminTheme().'purchases.purchasesAll',compact('invoices','totals'));


    }

    public function purchasesAction(Request $r,$action,$id=null){

      if($action=='create'){
        $invoice =Order::where('order_type','purchase_order')->where('order_status','temp')->where('addedby_id',Auth::id())->first();
          if(!$invoice){
            $invoice =new Order();
            $invoice->order_type ='purchase_order';
            $invoice->order_status ='temp';
            $invoice->addedby_id =Auth::id();
            $invoice->created_at =Carbon::now();
            $invoice->save();
          }
          $invoice->created_at =Carbon::now();
          $invoice->invoice =$invoice->created_at->format('Ymd').$invoice->id;
          $invoice->save();

          return redirect()->route('admin.purchasesAction',['edit',$invoice->id]);
      }
      $searchProducts =null;
      $message =null;
      $invoice =Order::where('order_type','purchase_order')->find($id);
      if(!$invoice){
          Session()->flash('error','This Purchase Invoice Are Not Found');
          return redirect()->route('admin.purchases');
      }

      if($action=='invoice'){

        return view(adminTheme().'purchases.purchasesInvoice',compact('invoice'));
      }
      
      if(Auth::id()==663){
          
        //     foreach($invoice->items as $item){
        //         if($item->product){
        //             $product =$item->product;
        //             $warehouse =$invoice->branch;
        //             $store =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
        //             // return $item->product->allSales()->count();
        //             if($store && $item->product->allSales()->count()==0){
        //                 $purchase =$item->product->purchases()
        //                     ->whereHas('order',function($q)use($invoice){
        //                         $q->where('order_type','purchase_order')->where('branch_id',$invoice->branch_id);
        //                     })->where('variant_id',$item->variant_id)->sum('quantity');
                            
        //                 $store->quantity =$purchase;
        //                 $store->save();
                        
        //                 if($variant =$item->productVariant){
        //                     $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
        //                     $variant->save();
        //                 }
        //                 $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
        //                 $product->save();
        //             }
        //             // return $purchase;
        //             // return $store;
        //         }
        //     }
        //   return 'Success'; //$invoice->items;
      }

    //   if($invoice->order_status=='delivered'){
    //     Session()->flash('error','This Invoice Are Delivered Can Not  Allow Modify');
    //     return redirect()->route('admin.purchases');
    //   }
      
      if($action=='update'){
          
        $check = $r->validate([
            'invoice' => 'required|max:100',
            'created_at' => 'required|date',
            'note' => 'nullable|max:1000',
            'status' => 'required|max:20',
        ]);

        if(!$invoice->user && !$invoice->branch){
          Session()->flash('error','Please Select Supplier and Store');
          return redirect()->back();
        }
        
        try {
            
            DB::transaction(function () use ($r, $invoice) {
            
                $createDate =$r->created_at?Carbon::parse($r->created_at . ' ' . Carbon::now()->format('H:i:s')):Carbon::now();
                if (!$createDate->isSameDay($invoice->created_at)) {
                    $invoice->created_at = $createDate;
                }
                $invoice->invoice=$r->invoice;
        
                if($invoice->order_status!='delivered' && $r->status=='delivered'){
                    //Update Stock 
                    foreach($invoice->items as $item){
                      if($product=$item->product){
                        $warehouse =$invoice->branch;
                        $store =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                        if(!$store){
                          $store =new InventoryStock();
                          $store->src_id=$item->product_id;
                          $store->branch_id=$invoice->branch_id;
                          $store->variant_id=$item->variant_id;
                          $store->barcode=$item->barcode?:$product->bar_code;
                          $store->save();
                        }
                        $store->quantity +=$item->quantity;
                        $store->save();
                        
                        if($variant =$item->productVariant){
                            $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                            $variant->save();
                        }
                        $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                        $product->save();
                      }
                    }
                    $invoice->order_status = 'delivered';
                }else{
                    if($invoice->order_status!='delivered'){
                        $invoice->order_status=$r->status?:'pending';
                    }
                }
                $invoice->note=$r->note;
                $invoice->save();
                
            });
    
            if($invoice->order_status=='delivered'){
              Session()->flash('success','This Invoice Are Delivered Successfully Done');
              return redirect()->route('admin.purchasesAction',['invoice',$invoice->id]);
            }
            
            Session()->flash('success','You Are Successfully Done');
            return redirect()->back();
            
        } catch (\Exception $e) {
            Session()->flash('error','Something went wrong: ' . $e->getMessage());
            return redirect()->back();
        }
        
        
      }

      if($action=='supplier-select' || $action=='warehouse-select' || $action=='add-product' || $action=='remove-item' || $action=='item-quantity' || $action=='item-price' || $action=='shipping-charge' || $action=='tax-charge' || $action=='discount' || $action=='discount-type'){
        if($action=='supplier-select'){
          $customer =User::find($r->key);
          $invoice->name=$customer?$customer->name:null;
          $invoice->mobile=$customer?$customer->mobile:null;
          $invoice->email=$customer?$customer->email:null;
          $invoice->division=$customer?$customer->division:null;
          $invoice->district=$customer?$customer->district:null;
          $invoice->city=$customer?$customer->city:null;
          $invoice->address=$customer?$customer->address_line1:null;
          $invoice->user_id=$r->key?:null;
          $invoice->save();
        }

        if($action=='warehouse-select'){
          $invoice->branch_id=$r->key?:null;
          $invoice->save();
        }
        if($action=='add-product'){
          if($invoice->user && $invoice->branch){
            $product =Post::latest()->where('type',2)->where('status','active')->find($r->item_id);
            if($product){
                $vars =true;
                $variant=null;
                if($product->variation_status){
                    $variant =$product->productVariationActiveAttributeItems()->find($r->variant_id);
                    if(!$variant){
                        $vars=false;
                        $message='<span style="color:red;">Please Select product variant item (Color, size)</span>';
                    }
                }
                
                if($vars){
                    $item = $invoice->items()->where('product_id', $product->id);
                    if ($variant) {
                        $item = $item->whereJsonContains('sku_id', $variant->attributeVatiationItems->pluck('attribute_item_id', 'attribute_id'));
                    }
                    $item = $item->first();
                    if(!$item){
                        $item =new OrderItem();
                        $item->order_id =$invoice->id;
                        $item->user_id =$invoice->user_id;
                        $item->product_id =$product->id;
                        $item->product_name =$product->name;
                        if($variant){
                          $item->barcode =$variant->barcode;
                          $item->variant_id =$variant->id;
                          $item->sku_id =json_encode($variant->attributeVatiationItems->pluck('attribute_item_id', 'attribute_id'));
                          $item->sku_value =json_encode($item->itemMakeAttributes());
                        }
                        $item->weight_unit =$product->weight_unit;
                        $item->price =$product->purchase_price?:0;
                        $item->save();
                    }
                    $item->quantity +=1;
                    $item->total_price=($item->quantity*$item->price) - ($item->quantity*$item->discount_amount)+($item->quantity*$item->tax_amount);
                    $item->save();
                    
                    if($invoice->order_status=='delivered'){
                
                        $store =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                        if(!$store){
                          $store =new InventoryStock();
                          $store->src_id=$item->product_id;
                          $store->branch_id=$invoice->branch_id;
                          $store->variant_id=$item->variant_id;
                          $store->barcode=$item->barcode?:$product->bar_code;
                          $store->save();
                        }
                        
                        $store->quantity +=1;
                        $store->save();
                        
                        if($variant =$item->productVariant){
                            $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                            $variant->save();
                        }
                        $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                        $product->save();
                    }
                    
                    
                }
            }
          }
          
          if(!$invoice->user && !$invoice->branch){
            $message='<span style="color:red;">Please Select Supplier and Store</span>';
          }elseif(!$invoice->user){
            $message='<span style="color:red;">Please Select Supplier</span>';
          }elseif(!$invoice->branch){
            $message='<span style="color:red;">Please Select Store</span>';
          }

        }

        if($action=='remove-item'){
          $item =$invoice->items()->find($r->item_id);
          if($item){
              
            if($invoice->order_status=='delivered'){
                if($product=$item->product){
                    $store =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                    if(!$store){
                      $store =new InventoryStock();
                      $store->src_id=$item->product_id;
                      $store->branch_id=$invoice->branch_id;
                      $store->variant_id=$item->variant_id;
                      $store->barcode=$item->barcode?:$product->bar_code;
                      $store->save();
                    }
                    if($item->quantity > 0){
                        
                        if($item->quantity > $product->warehouseStock($invoice->branch_id,$item->variant_id)){
                            $message='<span style="color:red;">Product Stock Already used.Can not Change Qty</span>';
                        }else{
                            $store->quantity -=$item->quantity;
                            $store->save();
                            
                            if($variant =$item->productVariant){
                                $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                                $variant->save();
                            }
                            $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                            $product->save();
                            
                        }
                    }
                }
            }
            
            if($message==null){
                $item->delete();
            }
            
            
          }
        }

        if($action=='item-quantity'){
          $item =$invoice->items()->find($r->item_id);
          if($item){
            $oldQty =$item->quantity;
            $qty =$r->key?:0;
            $status =true;
            
            if($invoice->order_status=='delivered'){
                if($product=$item->product){
                    
                    $store =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                    if(!$store){
                      $store =new InventoryStock();
                      $store->src_id=$item->product_id;
                      $store->branch_id=$invoice->branch_id;
                      $store->variant_id=$item->variant_id;
                      $store->barcode=$item->barcode?:$product->bar_code;
                      $store->save();
                    }
                    if($oldQty > $qty){
                        $needQty =$oldQty - $qty;
                        if($needQty > $product->warehouseStock($invoice->branch_id,$item->variant_id)){
                            $message='<span style="color:red;">Product Stock Already used.Can not Change Qty</span>';
                            $status=false;
                        }else{
                            $store->quantity -=$needQty;
                            $store->save();
                        }
                    }elseif($oldQty < $qty){
                        $needQty =$qty - $oldQty;
                        $store->quantity +=$needQty;
                        $store->save();
                    }
                    
                    if($variant =$item->productVariant){
                        $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                        $variant->save();
                    }
                    
                    $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                    $product->save();
                }
                
            }
            
            if($status){
                $item->quantity=$qty;
                $item->weight_unit =$item->product?$item->product->weight_unit:null;
                $item->total_price=($item->quantity*$item->price) - ($item->quantity*$item->discount_amount)+($item->quantity*$item->tax_amount);
                $item->save();
            }
          }
        }
        if($action=='item-price'){
          $item =$invoice->items()->find($r->item_id);
          if($item){
            $item->price=$r->key?:0;
            $item->total_price=($item->quantity*$item->price) - ($item->quantity*$item->discount_amount)+($item->quantity*$item->tax_amount);
            $item->save();
          }
        }
        if($action=='shipping-charge'){
          $invoice->shipping_charge=$r->key?:0;
        }

        if($action=='tax-charge'){
          $invoice->tax=$r->key?:0;
          $invoice->tax_amount=$invoice->total_price*$invoice->tax/100;
        }

        if($action=='discount-type'){
          $invoice->discount_type=$r->key?'flat':'percantage';
          $invoice->discount_price=$invoice->discountAmount();
        }
        if($action=='discount'){
          $invoice->discount=$r->key?:0;
          $invoice->discount_price=$invoice->discountAmount();
        }
        $invoice->total_price=$invoice->items()->sum('total_price');
        $invoice->total_items=$invoice->items()->count();
        $invoice->total_qty=$invoice->items()->sum('quantity');
        $invoice->grand_total=($invoice->total_price+$invoice->shipping_charge+$invoice->tax_amount)-$invoice->discount_price;
        $invoice->paid_amount=0;
        $invoice->due_amount=$invoice->grand_total-$invoice->paid_amount;
        $invoice->save();

        $suppliers =User::latest()->where('business',true)->whereIn('status',[0,1])->get(['id','name']);
        $warehouses =Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']);
        $infoView =view(adminTheme().'purchases.includes.purchaseInformation',compact('invoice','suppliers','warehouses'))->render();
        $view =view(adminTheme().'purchases.includes.purchaseItems',compact('invoice','message'))->render();
        return Response()->json([
            'success' => true,
            'view' => $view,
            'infoView' => $infoView,
        ]);
      }
      
      if($action=='search-product' || $action=='search-barcode-product'){

        if($action=='search-product'){
          $searchProducts =Post::latest()->where('type',2)->where('status','active')
          ->where(function($q)use($r){
                $q->where('name','like','%'.$r->key.'%');
                $q->orWhere('id','like','%'.$r->key.'%');
            })
          ->with('productVariationActiveAttributeItems')->get(['id','variation_status','name', 'purchase_price', 'quantity', 'sku_code', 'bar_code']);
        }

        if($action=='search-barcode-product'){
                $variantStatus =false;
                
                $barcode = $r->key; // Example: "IM12345" or "PO67890"

                if (strpos($barcode, 'IM') === 0 || strpos($barcode, 'PO') === 0) {
                    $barcode = substr($barcode, 2);
                }
                
                $searchProducts = Post::latest()->where('type',2)->where('status','active')
                    //->where('variation_status', false)
                    ->where('bar_code', $barcode)
                    ->limit(10)->get(['id', 'name', 'purchase_price', 'quantity', 'sku_code', 'bar_code']);
                if ($searchProducts->count()==0) {
                    $searchProducts = Post::latest()->where('type',2)->where('status','active')
                    //->where('variation_status', true)
                    ->whereHas('productVariationActiveAttributeItems', function ($q) use ($barcode) {
                        $q->where('stock_status',true)->where('barcode', $barcode);
                    })
                    ->with('productVariationActiveAttributeItems')
                    ->limit(10)->get(['id', 'name', 'purchase_price', 'quantity', 'sku_code', 'bar_code']);
                    
                    $variantStatus =true;
                }
            

        }
        
        if($action=='search-barcode-product' && $searchProducts->count()==1){

          if($invoice->user && $invoice->branch){
             
            $product =$searchProducts->first();
            $variant=null;
            if($variantStatus){
                $variant = $product->productVariationActiveAttributeItems()->where('barcode',$r->key)->first();
            }
            // $item =$invoice->items()->where('product_id',$product->id)->first();
            $item = $invoice->items()->where('product_id', $product->id);
            if ($variant) {
                $item = $item->whereJsonContains('sku_id', $variant->attributeVatiationItems->pluck('attribute_item_id', 'attribute_id'));
            }
            $item = $item->first();
            if(!$item){
              $item =new OrderItem();
              $item->order_id =$invoice->id;
              $item->user_id =$invoice->user_id;
              $item->product_id =$product->id;
              if($variant){
                  $item->barcode =$variant->barcode;
                  $item->variant_id =$variant->id;
                  $item->sku_id =json_encode($variant->attributeVatiationItems->pluck('attribute_item_id', 'attribute_id'));
                  $item->sku_value =json_encode($item->itemMakeAttributes());
                }
            }
            $item->product_name =$product->name;
            $item->quantity +=1;
            $item->price =$product->purchase_price?:0;
            $item->total_price=($item->quantity*$item->price) - ($item->quantity*$item->discount_amount)+($item->quantity*$item->tax_amount);
            $item->save();

            if($invoice->order_status=='delivered'){
                
                $store =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                if(!$store){
                  $store =new InventoryStock();
                  $store->src_id=$item->product_id;
                  $store->branch_id=$invoice->branch_id;
                  $store->variant_id=$item->variant_id;
                  $store->barcode=$item->barcode?:$product->bar_code;
                  $store->save();
                }
                
                $store->quantity +=1;
                $store->save();
                
                if($variant =$item->productVariant){
                    $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                    $variant->save();
                }
                $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                $product->save();
            }
            
          }

          if(!$invoice->user && !$invoice->branch){
            $message='<span style="color:red;">Please Select Supplier and Store</span>';
          }elseif(!$invoice->user){
            $message='<span style="color:red;">Please Select Supplier</span>';
          }elseif(!$invoice->branch){
            $message='<span style="color:red;">Please Select Store</span>';
          }

          $invoice->total_price=$invoice->items()->sum('total_price');
          $invoice->total_items=$invoice->items()->count();
          $invoice->total_qty=$invoice->items()->sum('quantity');
          $invoice->grand_total=($invoice->total_price+$invoice->shipping_charge+$invoice->tax_amount)-$invoice->discount_price;
          $invoice->paid_amount=0;
          $invoice->due_amount=$invoice->grand_total-$invoice->paid_amount;

        }

        $suppliers =User::latest()->where('business',true)->whereIn('status',[0,1])->get(['id','name']);
        $warehouses =Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']);
        $infoView =view(adminTheme().'purchases.includes.purchaseInformation',compact('invoice','suppliers','warehouses'))->render();
        $datasItems =view(adminTheme().'purchases.includes.purchaseItems',compact('invoice','message'))->render();
        
        $view =view(adminTheme().'purchases.includes.searchResult',compact('searchProducts','invoice'))->render();
        
        return Response()->json([
            'success' => true,
            'view' => $view,
            'count' => $searchProducts->count(),
            'datasItems' => $datasItems,
            'infoView' => $infoView,
        ]);

      }



      $suppliers =User::latest()->where('business',true)->whereIn('status',[0,1])->get(['id','name']);
      $warehouses =Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']);
      return view(adminTheme().'purchases.purchasesEdit',compact('invoice','suppliers','searchProducts','warehouses','message'));
    }
    //Purchase Management Function End
    
    
    public function stocksList(Request $r){

      
      $products =null;
      
      if($r->filter){
          
      $products =Post::where('type',2)->where('status','<>','temp')
        ->where(function($q) use ($r) {

            if($r->search){
                $q->where('name','LIKE','%'.$r->search.'%');
            }
            if($r->bar_code){
                $barcode = $r->bar_code;
                if (strpos($barcode, 'IM') === 0 || strpos($barcode, 'PO') === 0) {
                    $barcode = substr($barcode, 2);
                }
                $q->where('bar_code',$barcode)
                ->orWhereHas('productVariationActiveAttributeItems', function ($q) use ($barcode) {
                    $q->where('stock_status',true)->where('barcode',$barcode);
                });
            }

            if($r->category){
                $q->whereHas('ctgProducts',function($q) use($r){
                  $q->where('reff_id',$r->category);
                });
            }
            
            if($r->brand){
              $q->where('brand_id',$r->brand); 
            }

            if($r->status){
                $q->where('status',$r->status); 
            }

        })
        ->select(['id','name','final_price','slug','purchase_price','type','brand_id','bar_code','created_at','variation_status','quantity','weight_unit','status','fetured','import_status']);
        
        if($r->filter_by==1){
        $products = $products->orderBy('final_price','asc')->get();
        }elseif($r->filter_by==2){
        $products = $products->orderBy('final_price','desc')->get();
        }elseif($r->filter_by==3){
        $products = $products->orderBy('quantity','asc')->get();
        }elseif($r->filter_by==4){
        $products = $products->orderBy('quantity','desc')->get();
        }else{
        $products = $products->latest()->get();
        }
        
      }

      $categories =Attribute::where('type',0)->where('status','<>','temp')->where('parent_id',null)->get(['id','name']);
      $brands =Attribute::where('type',2)->where('status','<>','temp')->where('parent_id',null)->get(['id','name']);
      $warehouses =Attribute::latest()->where('type',5)->where('status','<>','temp')->get(['id','name','description']);
      return view(adminTheme().'purchases.stocksAll',compact('products','categories','brands','warehouses'));
    }
    
    public function stockTransfer(Request $r){
        
        
        $invoices =Order::latest()->where('order_type','transfers_order')->where('order_status','<>','temp')
          ->where(function($q) use ($r) {
      
              if($r->search){
                  $q->where('invoice','LIKE','%'.$r->search.'%');
                  $q->orWhereHas('user',function($qq) use($r){
                        $qq->where('name','LIKE','%'.$r->search.'%');
                    });
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
                $q->where('order_status',$r->status); 
              }
      
          })
          ->paginate(25)->appends([
            'search'=>$r->search,
            'status'=>$r->status,
            'startDate'=>$r->startDate,
            'endDate'=>$r->endDate,
          ]);
        
        //Total Count Results
        $totals = DB::table('orders')
          ->where('order_type','transfers_order')->where('order_status','<>','temp')
          ->selectRaw('count(*) as total')
          ->selectRaw("count(case when order_status = 'pending' then 1 end) as pending")
          ->selectRaw("count(case when order_status = 'delivered' then 1 end) as delivered")
          ->selectRaw("count(case when order_status = 'cancelled' then 1 end) as cancelled")
          ->first();
       
       return view(adminTheme().'stock-transfer.orderList',compact('invoices','totals')); 
    }
    
    public function stockTransferAction(Request $r,$action,$id=null){

      if($action=='create'){
        $invoice =Order::where('order_type','transfers_order')->where('order_status','temp')->where('addedby_id',Auth::id())->first();
          if(!$invoice){
            $invoice =new Order();
            $invoice->order_type ='transfers_order';
            $invoice->order_status ='temp';
            $invoice->addedby_id =Auth::id();
            $invoice->created_at =Carbon::now();
            $invoice->save();
          }
          $invoice->created_at =Carbon::now();
          $invoice->invoice =$invoice->created_at->format('Ymd').$invoice->id;
          $invoice->save();

          return redirect()->route('admin.stockTransferAction',['edit',$invoice->id]);
      }
      $searchProducts =null;
      $message =null;
      $invoice =Order::where('order_type','transfers_order')->find($id);
      if(!$invoice){
          Session()->flash('error','This Transfer Invoice Are Not Found');
          return redirect()->route('admin.stockTransfer');
      }

      if($action=='invoice'){

        return view(adminTheme().'stock-transfer.transferInvoice',compact('invoice'));
      }

    //   if($invoice->order_status=='delivered'){
    //     Session()->flash('error','This Invoice Are Delivered Can Not  Allow Modify');
    //     return redirect()->route('admin.purchases');
    //   }
      
        if($action=='update'){
            $check = $r->validate([
                'invoice' => 'required|max:100',
                'created_at' => 'required|date',
                'note' => 'nullable|max:1000',
                'status' => 'required|max:20',
            ]);

            if(!$invoice->formBranch && !$invoice->branch){
              Session()->flash('error','Please Select Store/Branch');
              return redirect()->back();
            }
            
            try {
                DB::transaction(function () use ($r, $invoice) {
            
                    $createDate =$r->created_at?Carbon::parse($r->created_at . ' ' . Carbon::now()->format('H:i:s')):Carbon::now();
                    if (!$createDate->isSameDay($invoice->created_at)) {
                        $invoice->created_at = $createDate;
                    }
                    $invoice->invoice=$r->invoice;
            
                    if($invoice->order_status!='delivered' && $r->status=='delivered'){
                        //Update Stock 
                        foreach($invoice->items as $item){
                          if($product=$item->product){
                            
                            $formStore =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$invoice->user_id)->where('variant_id',$item->variant_id)->first();
                            if(!$formStore){
                              $formStore =new InventoryStock();
                              $formStore->src_id=$item->product_id;
                              $formStore->branch_id=$invoice->user_id;
                              $formStore->variant_id=$item->variant_id;
                              $formStore->barcode=$item->barcode?:$product->bar_code;
                              $formStore->save();
                            }
                            $formStore->quantity -=$item->quantity;
                            $formStore->save();
                            
                            $store =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                            if(!$store){
                              $store =new InventoryStock();
                              $store->src_id=$item->product_id;
                              $store->branch_id=$invoice->branch_id;
                              $store->variant_id=$item->variant_id;
                              $store->barcode=$item->barcode?:$product->bar_code;
                              $store->save();
                            }
                            $store->quantity +=$item->quantity;
                            $store->save();
        
                          }
                        }
                    }
                    
                    if($invoice->order_status!='delivered'){
                    $invoice->order_status=$r->status?:'pending';
                    }
                    $invoice->note=$r->note;
                    $invoice->save();
                });
                
                if($invoice->order_status=='delivered'){
                  Session()->flash('success','This Invoice Are Delivered Successfully Done');
                  return redirect()->route('admin.stockTransferAction',['invoice',$invoice->id]);
                }
                
                Session()->flash('success','You Are Successfully Done');
                return redirect()->back();
            
            } catch (\Exception $e) {
                Session()->flash('error', 'Something went wrong: ' . $e->getMessage());
                return redirect()->back();
            }
            
            
        }

        if($action=='formwarehouse-select' || $action=='towarehouse-select' || $action=='add-product' || $action=='remove-item' || $action=='item-quantity' || $action=='item-price' || $action=='shipping-charge' || $action=='tax-charge' || $action=='discount' || $action=='discount-type'){
        
            if($action=='formwarehouse-select'){
                
                if($invoice->branch_id!=null && $invoice->branch_id==$r->key){
                    $message='<span style="color:red;">Already selected This Store/Branch, Choose Diffrent</span>';
                }else{
                    $invoice->user_id=$r->key?:null;
                    $invoice->save();
                }
                
            }
    
            if($action=='towarehouse-select'){
                if($invoice->user_id!=null && $invoice->user_id==$r->key){
                    $message='<span style="color:red;">Already selected This Store/Branch, Choose Diffrent</span>';
                }else{
                    $invoice->branch_id=$r->key?:null;
                    $invoice->save();
                }
            }
            
            if($action=='add-product'){
              if($invoice->formBranch && $invoice->branch){
                $product =Post::latest()->where('type',2)->where('status','active')->find($r->item_id);
                if($product){
                    $vars =true;
                    $variant=null;
                    if($product->variation_status){
                        $variant =$product->productVariationActiveAttributeItems()->find($r->variant_id);
                        if(!$variant){
                            $vars=false;
                            $message='<span style="color:red;">Please Select product variant item (Color, size)</span>';
                        }
                    }
                    
                    if($vars){
                        $item = $invoice->items()->where('product_id', $product->id);
                        if ($variant) {
                            $item = $item->whereJsonContains('sku_id', $variant->attributeVatiationItems->pluck('attribute_item_id', 'attribute_id'));
                        }
                        $item = $item->first();
                        if(!$item){
                            $item =new OrderItem();
                            $item->order_id =$invoice->id;
                            $item->user_id =$invoice->user_id;
                            $item->product_id =$product->id;
                            $item->product_name =$product->name;
                            if($variant){
                              $item->barcode =$variant->barcode;
                              $item->variant_id =$variant->id;
                              $item->sku_id =json_encode($variant->attributeVatiationItems->pluck('attribute_item_id', 'attribute_id'));
                              $item->sku_value =json_encode($item->itemMakeAttributes());
                            }
                            $item->weight_unit =$product->weight_unit;
                            $item->save();
                        }
                        $item->quantity +=1;
                        $item->save();
                        
                        if($invoice->order_status=='delivered'){
                    
                            $store =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                            if(!$store){
                              $store =new InventoryStock();
                              $store->src_id=$item->product_id;
                              $store->branch_id=$invoice->branch_id;
                              $store->variant_id=$item->variant_id;
                              $store->barcode=$item->barcode?:$product->bar_code;
                              $store->save();
                            }
                            
                            $store->quantity +=1;
                            $store->save();
                            
                            if($variant =$item->productVariant){
                                $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                                $variant->save();
                            }
                            $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                            $product->save();
                        }
                        
                        
                    }
                }
              }
              
              if(!$invoice->formBranch || !$invoice->branch){
                $message='<span style="color:red;">Please Select Store/Branch</span>';
              }
    
            }
    
            if($action=='remove-item'){
              $item =$invoice->items()->find($r->item_id);
              if($item){
                  
                if($invoice->order_status=='delivered'){
                    if($product=$item->product){
                        $formStore =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$invoice->user_id)->where('variant_id',$item->variant_id)->first();
                        if(!$formStore){
                          $formStore =new InventoryStock();
                          $formStore->src_id=$item->product_id;
                          $formStore->branch_id=$invoice->user_id;
                          $formStore->variant_id=$item->variant_id;
                          $formStore->barcode=$item->barcode?:$product->bar_code;
                          $formStore->save();
                        }
                        
                        $store =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                        if(!$store){
                          $store =new InventoryStock();
                          $store->src_id=$item->product_id;
                          $store->branch_id=$invoice->branch_id;
                          $store->variant_id=$item->variant_id;
                          $store->barcode=$item->barcode?:$product->bar_code;
                          $store->save();
                        }
                        
                        if($item->quantity > 0){
                            
                            if($item->quantity > $product->warehouseStock($invoice->branch_id,$item->variant_id)){
                                $message='<span style="color:red;">Product Stock Already used.Can not Change Qty</span>';
                            }else{
                                $store->quantity -=$item->quantity;
                                $store->save();
                                
                                $formStore->quantity +=$item->quantity;
                                $formStore->save();
                                
                            }
                        }
                    }
                }
                
                if($message==null){
                    $item->delete();
                }
                
                
              }
            }
    
            if($action=='item-quantity'){
              $item =$invoice->items()->find($r->item_id);
              if($item){
                $oldQty =$item->quantity;
                $qty =$r->key?:0;
                $status =true;
                
                if($invoice->order_status=='delivered'){
                    if($product=$item->product){
                        //Form Store
                        $formStore =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$invoice->user_id)->where('variant_id',$item->variant_id)->first();
                        if(!$formStore){
                          $formStore =new InventoryStock();
                          $formStore->src_id=$item->product_id;
                          $formStore->branch_id=$invoice->user_id;
                          $formStore->variant_id=$item->variant_id;
                          $formStore->barcode=$item->barcode?:$product->bar_code;
                          $formStore->save();
                        }
                        if($qty > $oldQty){
                            $needQty2 =$qty - $oldQty;
                            if($needQty2 > $product->warehouseStock($invoice->user_id,$item->variant_id)){
                                $message='<span style="color:red;">Product Stock Already used.Can not Change Qty</span>';
                                $status=false;
                            }
                        }
                        
                        ///to store
                        $store =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                        if(!$store){
                          $store =new InventoryStock();
                          $store->src_id=$item->product_id;
                          $store->branch_id=$invoice->branch_id;
                          $store->variant_id=$item->variant_id;
                          $store->barcode=$item->barcode?:$product->bar_code;
                          $store->save();
                        }
                        if($oldQty > $qty){
                            $needQty =$oldQty - $qty;
                            if($needQty > $product->warehouseStock($invoice->branch_id,$item->variant_id)){
                                $message='<span style="color:red;">Product Stock Already used.Can not Change Qty</span>';
                                $status=false;
                            }
                        }
                        
                        if($status){
                            
                            if($qty > $oldQty){
                                $needQty =$qty - $oldQty;
                                $formStore->quantity -=$needQty;
                                $formStore->save();
                                
                                $store->quantity +=$needQty;
                                $store->save();

                            }elseif($qty < $oldQty){
                                $needQty =$oldQty - $qty;
                                $formStore->quantity +=$needQty;
                                $formStore->save();
                                
                                $store->quantity -=$needQty;
                                $store->save();
                                
                            }
                            
                        }
                        
                    }
                    
                }
                
                if($status){
                    $item->quantity=$qty;
                    $item->weight_unit =$item->product?$item->product->weight_unit:null;
                    $item->total_price=($item->quantity*$item->price) - ($item->quantity*$item->discount_amount)+($item->quantity*$item->tax_amount);
                    $item->save();
                }
              }
            }
            
            $invoice->total_qty=$invoice->items()->sum('quantity');
            $invoice->save();
    
            $suppliers =User::latest()->where('business',true)->whereIn('status',[0,1])->get(['id','name']);
            $warehouses =Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']);
            $infoView =view(adminTheme().'stock-transfer.includes.transferInformation',compact('invoice','suppliers','warehouses'))->render();
            $view =view(adminTheme().'stock-transfer.includes.transferItems',compact('invoice','message'))->render();
            return Response()->json([
                'success' => true,
                'view' => $view,
                'infoView' => $infoView,
            ]);
      }
      
        if($action=='search-product' || $action=='search-barcode-product'){

        if($action=='search-product'){
            $searchProducts =Post::latest()->where('type',2)->where('status','active')
            ->where(function($q)use($r){
                $q->where('name','like','%'.$r->key.'%');
                $q->orWhere('id','like','%'.$r->key.'%');
            })
            ->with('productVariationActiveAttributeItems')->get(['id','variation_status','name', 'purchase_price', 'quantity', 'sku_code', 'bar_code']);
        }

        if($action=='search-barcode-product'){
            $variantStatus =false;
            $barcode = $r->key;

            if (strpos($barcode, 'IM') === 0 || strpos($barcode, 'PO') === 0) {
                $barcode = substr($barcode, 2);
            }
            
            $searchProducts = Post::latest()->where('type',2)->where('status','active')
                //->where('variation_status', false)
                ->where('bar_code', $barcode)
                ->limit(10)->get(['id', 'name', 'purchase_price', 'quantity', 'sku_code', 'bar_code']);
            if ($searchProducts->count()==0) {
                $searchProducts = Post::latest()->where('type',2)->where('status','active')
                //->where('variation_status', true)
                ->whereHas('productVariationActiveAttributeItems', function ($q) use ($barcode) {
                    $q->where('stock_status',true)->where('barcode', $barcode);
                })
                ->with('productVariationActiveAttributeItems')
                ->limit(10)->get(['id', 'name', 'purchase_price', 'quantity', 'sku_code', 'bar_code']);
                
                $variantStatus =true;
            }
    
        }
        
        if($action=='search-barcode-product' && $searchProducts->count()==1){

          if($invoice->formBranch && $invoice->branch){
             
            $product =$searchProducts->first();
            $variant=null;
            if($variantStatus){
                $variant = $product->productVariationActiveAttributeItems()->where('barcode',$r->key)->first();
            }
            // $item =$invoice->items()->where('product_id',$product->id)->first();
            $item = $invoice->items()->where('product_id', $product->id);
            if ($variant) {
                $item = $item->whereJsonContains('sku_id', $variant->attributeVatiationItems->pluck('attribute_item_id', 'attribute_id'));
            }
            $item = $item->first();
            if(!$item){
              $item =new OrderItem();
              $item->order_id =$invoice->id;
              $item->user_id =$invoice->user_id;
              $item->product_id =$product->id;
              if($variant){
                  $item->barcode =$variant->barcode;
                  $item->variant_id =$variant->id;
                  $item->sku_id =json_encode($variant->attributeVatiationItems->pluck('attribute_item_id', 'attribute_id'));
                  $item->sku_value =json_encode($item->itemMakeAttributes());
                }
            }
            $item->product_name =$product->name;
            $item->quantity +=1;
            $item->save();

            if($invoice->order_status=='delivered'){
                
                $store =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                if(!$store){
                  $store =new InventoryStock();
                  $store->src_id=$item->product_id;
                  $store->branch_id=$invoice->branch_id;
                  $store->variant_id=$item->variant_id;
                  $store->barcode=$item->barcode?:$product->bar_code;
                  $store->save();
                }
                
                $store->quantity +=1;
                $store->save();
                
                if($variant =$item->productVariant){
                    $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                    $variant->save();
                }
                $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                $product->save();
            }
            
          }

          if(!$invoice->formBranch && !$invoice->branch){
            $message='<span style="color:red;">Please Select Supplier and Store</span>';
          }elseif(!$invoice->formBranch){
            $message='<span style="color:red;">Please Select Supplier</span>';
          }elseif(!$invoice->branch){
            $message='<span style="color:red;">Please Select Store</span>';
          }

          $invoice->total_items=$invoice->items()->count();
          $invoice->total_qty=$invoice->items()->sum('quantity');
          $invoice->save();

        }

        $suppliers =User::latest()->where('business',true)->whereIn('status',[0,1])->get(['id','name']);
        $warehouses =Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']);
        $infoView =view(adminTheme().'stock-transfer.includes.transferInformation',compact('invoice','suppliers','warehouses'))->render();
        $datasItems =view(adminTheme().'stock-transfer.includes.transferItems',compact('invoice','message'))->render();
        
        $view =view(adminTheme().'stock-transfer.includes.searchResult',compact('searchProducts','invoice'))->render();
        
        return Response()->json([
            'success' => true,
            'view' => $view,
            'count' => $searchProducts->count(),
            'datasItems' => $datasItems,
            'infoView' => $infoView,
        ]);

      }


      $suppliers =User::latest()->where('business',true)->whereIn('status',[0,1])->get(['id','name']);
      $warehouses =Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']);
      return view(adminTheme().'stock-transfer.transferEdit',compact('invoice','suppliers','searchProducts','warehouses','message'));
    }
    
    public function stockMinus(Request $r){
        
        
        $invoices =Order::latest()->where('order_type','minus_order')->where('order_status','<>','temp')
          ->where(function($q) use ($r) {
      
              if($r->search){
                  $q->where('invoice','LIKE','%'.$r->search.'%');
                  $q->orWhereHas('user',function($qq) use($r){
                        $qq->where('name','LIKE','%'.$r->search.'%');
                    });
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
                $q->where('order_status',$r->status); 
              }
      
          })
          ->paginate(25)->appends([
            'search'=>$r->search,
            'status'=>$r->status,
            'startDate'=>$r->startDate,
            'endDate'=>$r->endDate,
          ]);
        
        //Total Count Results
        $totals = DB::table('orders')
          ->where('order_type','minus_order')->where('order_status','<>','temp')
          ->selectRaw('count(*) as total')
          ->selectRaw("count(case when order_status = 'pending' then 1 end) as pending")
          ->selectRaw("count(case when order_status = 'delivered' then 1 end) as delivered")
          ->selectRaw("count(case when order_status = 'cancelled' then 1 end) as cancelled")
          ->first();
       
       return view(adminTheme().'stock-minus.orderList',compact('invoices','totals')); 
    }
    
    public function stockMinusAction(Request $r,$action,$id=null){

      if($action=='create'){
        $invoice =Order::where('order_type','minus_order')->where('order_status','temp')->where('addedby_id',Auth::id())->first();
          if(!$invoice){
            $invoice =new Order();
            $invoice->order_type ='minus_order';
            $invoice->order_status ='temp';
            $invoice->addedby_id =Auth::id();
            $invoice->created_at =Carbon::now();
            $invoice->save();
          }
          $invoice->created_at =Carbon::now();
          $invoice->invoice =$invoice->created_at->format('Ymd').$invoice->id;
          $invoice->save();

          return redirect()->route('admin.stockMinusAction',['edit',$invoice->id]);
      }
      $searchProducts =null;
      $message =null;
      $invoice =Order::where('order_type','minus_order')->find($id);
      if(!$invoice){
          Session()->flash('error','This Transfer Invoice Are Not Found');
          return redirect()->route('admin.stockTransfer');
      }
      

      if($action=='invoice'){

        return view(adminTheme().'stock-minus.transferInvoice',compact('invoice'));
      }

    //   if($invoice->order_status=='delivered'){
    //     Session()->flash('error','This Invoice Are Delivered Can Not  Allow Modify');
    //     return redirect()->route('admin.purchases');
    //   }
      
    if($action=='update'){
        
            $check = $r->validate([
                'invoice' => 'required|max:100',
                'created_at' => 'required|date',
                'note' => 'nullable|max:1000',
                'status' => 'required|max:20',
            ]);

            if(!$invoice->branch){
              Session()->flash('error','Please Select Store/Branch');
              return redirect()->back();
            }
    
            try {
                DB::transaction(function () use ($r, $invoice) {
                    $createDate =$r->created_at?Carbon::parse($r->created_at . ' ' . Carbon::now()->format('H:i:s')):Carbon::now();
                    if (!$createDate->isSameDay($invoice->created_at)) {
                        $invoice->created_at = $createDate;
                    }
                    $invoice->invoice=$r->invoice;
            
                      if($invoice->order_status!='delivered' && $r->status=='delivered'){
                        //Update Stock 
                        foreach($invoice->items as $item){
                            if($product=$item->product){
                        
                                $store =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                                if(!$store){
                                  $store =new InventoryStock();
                                  $store->src_id=$item->product_id;
                                  $store->branch_id=$invoice->branch_id;
                                  $store->variant_id=$item->variant_id;
                                  $store->barcode=$item->barcode?:$product->bar_code;
                                  $store->save();
                                }
                                $store->quantity -=$item->quantity;
                                $store->save();
                                
                                if($variant =$item->productVariant){
                                    $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                                    $variant->save();
                                }
                                $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                                $product->save();
        
                            }
                        }
                    }
                    
                    if($invoice->order_status!='delivered'){
                        $invoice->order_status=$r->status?:'pending';
                    }
                    $invoice->note=$r->note;
                    $invoice->save();
                });
                
                if($invoice->order_status=='delivered'){
                  Session()->flash('success','This Invoice Are Delivered Successfully Done');
                  return redirect()->route('admin.stockMinusAction',['invoice',$invoice->id]);
                }
                
                Session()->flash('success','You Are Successfully Done');
                return redirect()->back();
                    
            } catch (\Exception $e) {
                Session()->flash('error', 'Something went wrong: ' . $e->getMessage());
                return redirect()->back();
            }
            
        }

    if($action=='warehouse-select' || $action=='add-product' || $action=='remove-item' || $action=='item-quantity'){
        
            if($action=='warehouse-select'){
                if($invoice->user_id!=null && $invoice->user_id==$r->key){
                    $message='<span style="color:red;">Already selected This Store/Branch, Choose Diffrent</span>';
                }else{
                    $invoice->branch_id=$r->key?:null;
                    $invoice->save();
                }
            }
            
            if($action=='add-product'){
              if($invoice->branch){
                $product =Post::latest()->where('type',2)->where('status','active')->find($r->item_id);
                if($product){
                    $vars =true;
                    $variant=null;
                    if($product->variation_status){
                        $variant =$product->productVariationActiveAttributeItems()->find($r->variant_id);
                        if(!$variant){
                            $vars=false;
                            $message='<span style="color:red;">Please Select product variant item (Color, size)</span>';
                        }
                    }
                    
                    if($vars){
                        $item = $invoice->items()->where('product_id', $product->id);
                        if ($variant) {
                            $item = $item->whereJsonContains('sku_id', $variant->attributeVatiationItems->pluck('attribute_item_id', 'attribute_id'));
                        }
                        $item = $item->first();
                        if(!$item){
                            $item =new OrderItem();
                            $item->order_id =$invoice->id;
                            $item->user_id =$invoice->user_id;
                            $item->product_id =$product->id;
                            $item->product_name =$product->name;
                            if($variant){
                              $item->barcode =$variant->barcode;
                              $item->variant_id =$variant->id;
                              $item->sku_id =json_encode($variant->attributeVatiationItems->pluck('attribute_item_id', 'attribute_id'));
                              $item->sku_value =json_encode($item->itemMakeAttributes());
                            }
                            $item->weight_unit =$product->weight_unit;
                            $item->save();
                        }
                        $item->quantity +=1;
                        $item->save();
                        
                        if($invoice->order_status=='delivered'){
                    
                            $store =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                            if(!$store){
                              $store =new InventoryStock();
                              $store->src_id=$item->product_id;
                              $store->branch_id=$invoice->branch_id;
                              $store->variant_id=$item->variant_id;
                              $store->barcode=$item->barcode?:$product->bar_code;
                              $store->save();
                            }
                            
                            $store->quantity -=1;
                            $store->save();
                            
                            if($variant =$item->productVariant){
                                $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                                $variant->save();
                            }
                            $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                            $product->save();
                        }
                        
                    }

                }
                
              }
              
              if(!$invoice->branch){
                $message='<span style="color:red;">Please Select Store/Branch</span>';
              }
            }
    
            if($action=='remove-item'){
              $item =$invoice->items()->find($r->item_id);
              if($item){
                  
                if($invoice->order_status=='delivered'){
                    if($product=$item->product){
                        
                        $store =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                        if(!$store){
                          $store =new InventoryStock();
                          $store->src_id=$item->product_id;
                          $store->branch_id=$invoice->branch_id;
                          $store->variant_id=$item->variant_id;
                          $store->barcode=$item->barcode?:$product->bar_code;
                          $store->save();
                        }
                        
                        if($item->quantity > 0){
                            $store->quantity +=$item->quantity;
                            $store->save();
                            
                            if($variant =$item->productVariant){
                                $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                                $variant->save();
                            }
                            $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                            $product->save();
                        }
                    }
                }
                
                if($message==null){
                    $item->delete();
                }
                
                
              }
            }
    
            if($action=='item-quantity'){
                $item =$invoice->items()->find($r->item_id);
                if($item){
                    $oldQty =$item->quantity;
                    $qty =$r->key?:0;
                    $status =true;
                
                    if($product=$item->product){
                        ///to store
                        $store =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                        if(!$store){
                          $store =new InventoryStock();
                          $store->src_id=$item->product_id;
                          $store->branch_id=$invoice->branch_id;
                          $store->variant_id=$item->variant_id;
                          $store->barcode=$item->barcode?:$product->bar_code;
                          $store->save();
                        }
                        if($qty > $oldQty){
                            $needQty =$qty - $oldQty;
                            if($needQty > $product->warehouseStock($invoice->branch_id,$item->variant_id)){
                                $message='<span style="color:red;">Product Stock Already used.Can not Change Qty</span>';
                                $status=false;
                            }
                        }
                    }
                
                    if($invoice->order_status=='delivered' && $status){

                        if($qty > $oldQty){
                            $needQty =$qty - $oldQty;
                            $store->quantity -=$needQty;
                            $store->save();
                        }
                        
                        if($variant =$item->productVariant){
                            $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                            $variant->save();
                        }
                        
                        $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                        $product->save();

                    }
    
                    if($status){
                        $item->quantity=$qty;
                        $item->weight_unit =$item->product?$item->product->weight_unit:null;
                        $item->total_price=($item->quantity*$item->price) - ($item->quantity*$item->discount_amount)+($item->quantity*$item->tax_amount);
                        $item->save();
                    }
                }
            }
            
            $invoice->total_qty=$invoice->items()->sum('quantity');
            $invoice->save();
    
            $warehouses =Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']);
            $infoView =view(adminTheme().'stock-minus.includes.transferInformation',compact('invoice','warehouses'))->render();
            $view =view(adminTheme().'stock-minus.includes.transferItems',compact('invoice','message'))->render();
            return Response()->json([
                'success' => true,
                'view' => $view,
                'infoView' => $infoView,
            ]);
      }
      
    if($action=='search-product' || $action=='search-barcode-product'){

            if($action=='search-product'){
                $searchProducts =Post::latest()->where('type',2)->where('status','active')
                ->where(function($q)use($r){
                    $q->where('name','like','%'.$r->key.'%');
                    $q->orWhere('id','like','%'.$r->key.'%');
                })
                ->with('productVariationActiveAttributeItems')->get(['id','variation_status','name', 'purchase_price', 'quantity', 'sku_code', 'bar_code']);
            }
    
            if($action=='search-barcode-product'){
                $variantStatus =false;
                $barcode = $r->key;
                
                $searchProducts = Post::latest()->where('type',2)->where('status','active')
                    //->where('variation_status', false)
                    ->where('bar_code', $barcode)
                    ->limit(10)->get(['id', 'name', 'purchase_price', 'quantity', 'sku_code', 'bar_code']);
                if ($searchProducts->count()==0) {
                    $searchProducts = Post::latest()->where('type',2)->where('status','active')
                    //->where('variation_status', true)
                    ->whereHas('productVariationActiveAttributeItems', function ($q) use ($barcode) {
                        $q->where('stock_status',true)->where('barcode', $barcode);
                    })
                    ->with('productVariationActiveAttributeItems')
                    ->limit(10)->get(['id', 'name', 'purchase_price', 'quantity', 'sku_code', 'bar_code']);
                    
                    $variantStatus =true;
                }
        
            }
            
            if($action=='search-barcode-product' && $searchProducts->count()==1){
    
              if($invoice->branch){
                 
                $product =$searchProducts->first();
                $variant=null;
                if($variantStatus){
                    $variant = $product->productVariationActiveAttributeItems()->where('barcode',$r->key)->first();
                }
                // $item =$invoice->items()->where('product_id',$product->id)->first();
                $item = $invoice->items()->where('product_id', $product->id);
                if ($variant) {
                    $item = $item->whereJsonContains('sku_id', $variant->attributeVatiationItems->pluck('attribute_item_id', 'attribute_id'));
                }
                $item = $item->first();
                if(!$item){
                  $item =new OrderItem();
                  $item->order_id =$invoice->id;
                  $item->user_id =$invoice->user_id;
                  $item->product_id =$product->id;
                  if($variant){
                      $item->barcode =$variant->barcode;
                      $item->variant_id =$variant->id;
                      $item->sku_id =json_encode($variant->attributeVatiationItems->pluck('attribute_item_id', 'attribute_id'));
                      $item->sku_value =json_encode($item->itemMakeAttributes());
                    }
                }
                $item->product_name =$product->name;
                $item->quantity +=1;
                $item->save();
    
                if($invoice->order_status=='delivered'){
                    
                    $store =InventoryStock::where('src_id',$item->product_id)->where('branch_id',$invoice->branch_id)->where('variant_id',$item->variant_id)->first();
                    if(!$store){
                      $store =new InventoryStock();
                      $store->src_id=$item->product_id;
                      $store->branch_id=$invoice->branch_id;
                      $store->variant_id=$item->variant_id;
                      $store->barcode=$item->barcode?:$product->bar_code;
                      $store->save();
                    }
                    
                    $store->quantity -=1;
                    $store->save();
                    
                    if($variant =$item->productVariant){
                        $variant->quantity=$product->warehouseStores()->where('variant_id',$item->variant_id)->sum('quantity');
                        $variant->save();
                    }
                    $product->quantity=$product->variation_status?$product->warehouseStores()->whereHas('variant')->sum('quantity'):$product->warehouseStores()->sum('quantity');
                    $product->save();
                }
                
              }
    
              if(!$invoice->branch){
                $message='<span style="color:red;">Please Select Store</span>';
              }
    
              $invoice->total_items=$invoice->items()->count();
              $invoice->total_qty=$invoice->items()->sum('quantity');
              $invoice->save();
    
            }
    
            $suppliers =User::latest()->where('business',true)->whereIn('status',[0,1])->get(['id','name']);
            $warehouses =Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']);
            $infoView =view(adminTheme().'stock-minus.includes.transferInformation',compact('invoice','suppliers','warehouses'))->render();
            $datasItems =view(adminTheme().'stock-minus.includes.transferItems',compact('invoice','message'))->render();
            
            $view =view(adminTheme().'stock-minus.includes.searchResult',compact('searchProducts','invoice'))->render();
            
            return Response()->json([
                'success' => true,
                'view' => $view,
                'count' => $searchProducts->count(),
                'datasItems' => $datasItems,
                'infoView' => $infoView,
            ]);

        }


      $warehouses =Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']);
      return view(adminTheme().'stock-minus.stockMinusEdit',compact('invoice','searchProducts','warehouses','message'));
    }
    
    


}