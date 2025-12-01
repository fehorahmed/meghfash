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
use App\Models\PostExtra;
use App\Models\Review;
use App\Models\General;
use App\Models\Country;
use App\Models\Media;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderReturnItem;
use App\Models\Attribute;
use App\Models\Permission;
use App\Models\PostAttribute;
use App\Models\PostAttributeVariation;
use GuzzleHttp\Client;

use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EcommerceController extends Controller
{

 	// Product management Function
     public function products(Request $r){
         
        if(Auth::id()==663){
            
            // $products = Post::latest()
            //     ->where('type', 2)
            //     ->where('status', '<>', 'temp')
            //     ->get(['id']) // get collection first
            //     ->filter(function($product){
            //         // Total sales quantity for this variation
            //         $sales = $product->allSales()
            //             ->whereHas('order');
            
            //         $totalSalesQty = $sales->sum('quantity') - $sales->sum('return_quantity');
            
            //         // Available stock quantity
            //         $availableQty = $product->productVariationAttributeItems()->sum('quantity');
            
            //         // Total = available + sold
            //         $total = $availableQty + $totalSalesQty;
            
            //         // Total purchased quantity
            //         $pQty = $product->allPurchases()->sum('quantity');
            
            //         // Return true if mismatch
            //         return $total != $pQty;
            //     });
            
            // return $products;
            
            // {"374":{"id":2645},"412":{"id":2619},"418":{"id":2625},"466":{"id":2549},"471":{"id":2554},"476":{"id":2559},"482":{"id":2522},"485":{"id":2525},"487":{"id":2527},"498":{"id":2539},"520":{"id":2492},"547":{"id":2461},"548":{"id":2462},"559":{"id":2435},"560":{"id":2436},"564":{"id":2440},"565":{"id":2441},"584":{"id":2431},"588":{"id":2411},"598":{"id":2422},"602":{"id":2426},"604":{"id":1984},"606":{"id":1987},"607":{"id":1989},"624":{"id":2369},"627":{"id":2392},"632":{"id":2389},"643":{"id":2364},"651":{"id":2355},"654":{"id":2359},"656":{"id":2361},"691":{"id":2310},"692":{"id":2311},"698":{"id":2102},"699":{"id":2308},"701":{"id":2286},"702":{"id":2287},"704":{"id":2289},"707":{"id":2292},"708":{"id":2293},"709":{"id":2294},"710":{"id":2295},"712":{"id":2297},"718":{"id":2303},"719":{"id":2304},"771":{"id":2203},"811":{"id":2174},"824":{"id":2103},"830":{"id":2110},"836":{"id":2118},"837":{"id":2119},"838":{"id":2120},"839":{"id":2121},"873":{"id":2167},"883":{"id":2046},"884":{"id":2047},"890":{"id":2053},"897":{"id":2061},"900":{"id":2064},"903":{"id":2070},"907":{"id":2074},"917":{"id":2084},"924":{"id":2044},"931":{"id":2025},"932":{"id":2026},"933":{"id":2027},"936":{"id":2034},"951":{"id":2005},"974":{"id":2342},"979":{"id":2428},"983":{"id":2193},"989":{"id":2980},"995":{"id":2957}} 
           
        }
         
         
      
      $allPer = empty(json_decode(Auth::user()->permission->permission, true)['products']['all']);
      // Filter Action Start

      if($r->action){
        if($r->checkid){

        $datas=Post::latest()->where('type',2)->whereIn('id',$r->checkid)->get();

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
              
              $medias =Media::latest()->where('src_type',1)->where('src_id',$data->id)->get();
              foreach($medias as $media){
                if(File::exists($media->file_url)){
                  File::delete($media->file_url);
                }
                $media->delete();
              }
                $data->productAttibutes()->delete();
                $data->productVariationAttibutes()->delete();
                $data->productVariationAttributeItems()->delete();
                $data->productVariationAttributeItemsList()->delete();
                foreach($data->productVariationAttributeItemsValues as $value){
                   $medies =Media::where('src_type',8)->where('src_id',$value->id)->get();
                    foreach ($medies as  $media) {
                        if(File::exists($media->file_url)){
                            File::delete($media->file_url);
                        }
                        $media->delete();
                    }
                    $value->delete();
                }
        
                $data->productCtgs()->delete();
                $data->productTags()->delete();
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
      
      $products =Post::latest()->where('type',2)->where('status','<>','temp')
        ->where(function($q) use ($r,$allPer) {

            if($r->search){
                $searchTerms = preg_split('/\s+/', trim($r->search));
                $q->where(function ($query) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $query->where(function ($q) use ($term) {
                            $q->where('name', 'like', '%' . $term . '%')
                              ->orWhere('bar_code', 'like', '%' . $term . '%')
                              ->orWhereHas('productVariationActiveAttributeItems', function ($q2) use ($term) {
                                  $q2->where('stock_status', true)
                                     ->where('barcode', 'like', '%' . $term . '%');
                              });
                        });
                    }
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
            
            if($r->category){
               $q->whereHas('productCtgs',function($qq)use($r){
                  $qq->where('reff_id',$r->category);
               });
            }

            if($r->status){
                if($r->status=='new_arrival'){
                    $q->where('new_arrival',true);
                }elseif($r->status=='top_sale'){
                    $q->where('top_sale',true);
                }elseif($r->status=='tranding'){
                    $q->where('fetured',true);
                }elseif($r->status=='web_view'){
                    $q->where('for_website',true);
                }else{
                    $q->where('status',$r->status); 
                }
             
            }

            // Check Permission
            if($allPer){
             $q->where('addedby_id',auth::id()); 
            }


        })
        ->select(['id','name','final_price','regular_price','slug','view','type','brand_id','created_at','addedby_id','status','import_status','discount_type','discount','quantity','fetured','new_arrival'])
        ->paginate(25)->appends([
          'search'=>$r->search,
          'status'=>$r->status,
          'category'=>$r->category,
          'startDate'=>$r->startDate,
          'endDate'=>$r->endDate,
        ]);
        
         
        //collect();
        
        
        //Total Count Results
        $totals = DB::table('posts')
        ->where('status','<>','temp')
        ->where(function($q)use($allPer){
            if($allPer){
            $q->where('addedby_id',auth::id());
            }
        })
        ->where('type',2)
        ->selectRaw('count(*) as total')
        ->selectRaw("count(case when status = 'active' then 1 end) as active")
        ->selectRaw("count(case when status = 'inactive' then 1 end) as inactive")
        ->selectRaw("count(case when for_website = true then 1 end) as inactiveView")
        ->selectRaw("count(case when new_arrival = true then 1 end) as new_arrival")
        ->selectRaw("count(case when top_sale = true then 1 end) as top_sale")
        ->selectRaw("count(case when fetured = true then 1 end) as tranding")
        ->first();
        
        
        $categories =Attribute::where('type',0)->where('status','<>','temp')->where('parent_id',null)->get();

        return view(adminTheme().'products.productsAll',compact('products','totals','r','categories'));
    }

    public function productsAction(Request $r,$action,$id=null){
        
        if($action=='create'){
          $product =Post::where('type',2)->where('status','temp')->where('addedby_id',Auth::id())->first();
          if(!$product){
            $product =new Post();
            $product->type =2;
            $product->status ='temp';
            $product->addedby_id =Auth::id();
          }
          $product->created_at =Carbon::now();
          $product->save();
   
          return redirect()->route('admin.productsAction',['edit',$product->id]);
        }

        $product =Post::where('type',2)->find($id);
        if(!$product){
          Session()->flash('error','This Product Are Not Found');
          return redirect()->route('admin.products');
        }
            
        // return $product->offerPrice();
        
        //Check Authorized User
        $allPer = empty(json_decode(Auth::user()->permission->permission, true)['products']['all']);
        if($allPer && $product->addedby_id!=Auth::id()){
          Session()->flash('error','You are unauthorized Try!!');
          return redirect()->route('admin.products');
        }

        if($action=='view'){
            
            // if(Auth::id()==663){
            //     return $product->warehouseStock(1020,19507);
            //     return $product->warehouseStores()->where('branch_id',1020)->get();
            //     return $product->warehouseStock(1020);
            //     return $product->productVariationActiveAttributeItems;
            //     return $product->warehouseStores;
                
                
            // }
            
            foreach ($product->productVariationAttributeItems()->get() as $item) {
                $warehouseRecords = $product->warehouseStores()->where('variant_id', $item->id);
                $hasMinus = $warehouseRecords->where('quantity', '<', 0)->exists();
                if ($hasMinus) {
                    $product->warehouseStores()
                        ->where('variant_id', $item->id)
                        ->where('quantity', '<', 0)
                        ->update(['quantity' => 0]);
                }
                $totalQuantity = $product->warehouseStores()->where('variant_id', $item->id)->sum('quantity');
                $item->quantity = max($totalQuantity, 0);
                $item->save();
            }
            if($product->variation_status){
                $product->warehouseStores()->whereDoesntHave('variant')->delete();
                $product->quantity=$product->warehouseStores()->whereHas('variant')->sum('quantity');
            }else{
                $product->quantity=$product->warehouseStores()->sum('quantity');
            }
            $product->save();
            
            if(Auth::id()==663){
                
            // return $product->warehouseStores()
            //         ->where('variant_id', $item->id)
            //         ->groupBy('branch_id')
            //         ->selectRaw('branch_id, SUM(quantity) as total_quantity')->get();
            
                // return PostAttribute::where('src_id',$product->id)->where('reff_id',68)->get();
                // $data = $product->productVariationAttributeItems()->where('id','16255')->first();
                
                // $ddd = $data->attributeVatiationItems()->where('attribute_id',68)->first();
                // // return $data;
                // // return $data->variationItemImage();
                
                // $hasImage =PostAttribute::where('src_id','2347')->where('reff_id',68)->where('type',9)->where('parent_id',$ddd->attribute_item_id)->first();
                // if($hasImage){
                //  return $hasImage->variationImage();   
                // }
                
                // // return $data->variationImage();
                // $hasImage =$product->productVariationAttributeItemsValues()->where('reff_id',68)->where('parent_id',$ddd->attribute_item_id)->first();
                // if($hasImage){
                //  return $hasImage->variationImage();   
                // }
                // return $hasImage;
                
                // $datas = $product->productVariationAttributeItemsValues()->where('reff_id',68)->whereHas('imageFile')->get();
                // return $datas;
                // foreach($datas as $i=>$data){
                //     if($i==1){
                //       return $data;
                //     }
                //     // return $data->imageFile;
                // }
            }
            
            return view(adminTheme().'products.productsView',compact('product'));
        }
        if($action=='duplicate'){
            
            $newProduct = $product->replicate(); // Duplicate the basic attributes of the product
            $newProduct->status = 'active';
            
            $newProduct->addedby_id = Auth::id();
            $newProduct->created_at = Carbon::now();
            $newProduct->quantity=0;
            $newProduct->save();
            
            $newProduct->slug=$product->slug.'-'.$newProduct->id;
            $newProduct->save();

            // Duplicate product categories
            foreach ($product->productCtgs as $category) {
                $newCategory = $category->replicate();
                $newCategory->src_id = $newProduct->id;
                $newCategory->save();
            }
            
            // Duplicate product tags
            foreach ($product->productTags as $tag) {
                $newTag = $tag->replicate();
                $newTag->src_id = $newProduct->id;
                $newTag->save();
            }
            
            // Duplicate product Extra Attri tags
            foreach ($product->extraAttribute as $extra) {
                $newExtra = $extra->replicate();
                $newExtra->src_id = $newProduct->id;
                $newExtra->save();
            }
            
            // Duplicate product attributes
            foreach($product->productAttibutes as $attribute) {
                $newAttribute = $attribute->replicate(); // Clone the attribute
                $newAttribute->src_id = $newProduct->id; // Assign to the new product
                $newAttribute->save();
            }
            
            // Duplicate product variation attributes
            foreach ($product->productVariationAttibutes as $variationAttribute) {
                $newVariationAttribute = $variationAttribute->replicate();
                $newVariationAttribute->src_id = $newProduct->id;
                $newVariationAttribute->save();
            }
            
            // Duplicate product variation attributes
            foreach ($product->productVariationAttributeItems as $variationAttributeItem) {
                $newVariationAttributeItem = $variationAttributeItem->replicate();
                $newVariationAttributeItem->src_id = $newProduct->id;
                $newVariationAttributeItem->quantity = 0;

                $variItems = $variationAttributeItem->attributeVatiationItems;
                foreach($variItems as $vaIt){
                    $newVariationItem = $vaIt->replicate();
                    $newVariationItem->src_id = $newVariationAttributeItem->id;
                    $newVariationItem->product_id = $newProduct->id;
                    $newVariationItem->save();
                }
            }
            
            // Duplicate product variation attributes
            foreach($product->productVariationAttributeItemsValues as $variationAttributeValue) {
                $newVariationAttributeValue = $variationAttributeValue->replicate();
                $newVariationAttributeValue->src_id = $newProduct->id;
                $newVariationAttributeValue->save();
            }
            
            return redirect()->route('admin.productsAction',['edit',$newProduct->id]);
             
        }
        
        if($action=='barcode'){
            
            // $productId =$product->id;
            
            // if($product->variation_status && $r->variation_id){
            //     $variantId =$r->variation_id;
            // }else{
            //     $variantId =null;
            // }
            
            // $quantity = 1;
        
            // $barCodePrint = session()->get('barcode_items', []);
        
            // $found = false;
        
            // foreach($barCodePrint as &$item){
            //     if ($item['product_id'] == $productId && $item['variant_id'] == $variantId) {
            //         $item['quantity'] += $quantity;
            //         $found = true;
            //         break;
            //     }
            // }
        
            // if (!$found) {
            //     $barCodePrint[] = [
            //         'product_id' => $productId,
            //         'variant_id' => $variantId,
            //         'quantity' => $quantity
            //     ];
            // }
        
            // session()->put('barcode_items', $barCodePrint);
            
            
            // return redirect()->route('admin.productsLabelPrint',['preview'=>'view']);
            
            
            
            
            $title ='yes';
            $price =null;
            $name =$product->name;
            // if($product->import_status){
            //     $barcode ='IM';
            // }else{
            //     $barcode ='MF';
            // }
            $barcode =null;
            if($code =$product->productVariationAttributeItems()->find($r->variation_id)){
                
                if(!$code->barcode){
                   $code->barcode=Carbon::now()->format('ymd').$product->id.rand(1111,9999);
                   $code->save();
                }
                
                $barcode .=$code->barcode;
                
                $priceRate =$code->final_price;
                if($product->import_status){
                    $vat =$priceRate*general()->import_tax/100;
                }else{
                    $vat =$priceRate*general()->tax/100;
                }
                $priceRate =$priceRate+$vat;
                
                $priceAt='<br><b>Price: TK '.priceFormat($priceRate).'</b> (Inc. VAT)';
                
                $name .=$priceAt;
                $attri=null;
                foreach($code->attributeVatiationItems()->whereHas('attribute')->get() as $att){
                  $attri .=' '.$att->attribute->name.': '.$att->attributeItemName();
                }
                if($attri){
                    $name .='<br>'.$attri;
                }

            }else{
                $barcode .=$product->bar_code?:Carbon::now()->format('ymd').$product->id;
              
                $priceRate =$product->final_price;
                if($product->import_status){
                    $vat =$priceRate*general()->import_tax/100;
                }else{
                    $vat =$priceRate*general()->tax/100;
                }
                $priceRate =$priceRate+$vat;
                $priceAt ='<br><b >Price: TK '.priceFormat($priceRate).'</b> (Inc. VAT)';
              
                $name .=$priceAt; 
            }
            
            $printCount=1;
            
            $hasitems[] = [
                'id' => $product->id,
                'name' => $name,
                'bar_code' => $barcode,
                // 'price' => priceFullFormat($product->final_price),
                'price' => priceFullFormat($priceRate),
                'quantity' => $printCount
            ];
            $r->session()->put('items', $hasitems);
            
            $items = $r->session()->get('items', []);
        
       
            return view(adminTheme().'products.productsPrintBarcode2',compact('product','items','title','price','printCount'));
        }
        
        if($action=='update'){
          $check = $r->validate([
            'name' => 'required|max:191',
            'video_link' => 'nullable|max:200',
            'seo_title' => 'nullable|max:200',
            'seo_description' => 'nullable|max:250',
            'catagoryid.*' => 'nullable|numeric',
            'brand' => 'nullable|numeric',
            'sub_brand' => 'nullable|numeric',
            'tags.*' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'gallery_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
          ]);

            if(!$check){
                Session::flash('error','Need To validation');
                return back();
            }

       
        $product->name=$r->name;
        $product->short_description=$r->short_description;
        $product->description=$r->description;
        $product->seo_title=$r->seo_title;
        $product->seo_description=$r->seo_description;
        $product->seo_keyword=$r->seo_keyword;
        $product->brand_id=$r->brand;
        $product->video_link=$r->video_link;

        ///////Image Uploard Start////////////
        if($r->hasFile('image')){
          $file =$r->image;
          $src  =$product->id;
          $srcType  =1;
          $fileUse  =1;
          
          uploadFile($file,$src,$srcType,$fileUse);
        }
        ///////Image Uploard End////////////
        
        ///////Image Uploard Start////////////
        if($r->hasFile('thumbnail')){
          $file =$r->thumbnail;
          $src  =$product->id;
          $srcType  =1;
          $fileUse  =2;
          
          uploadFile($file,$src,$srcType,$fileUse);
        }
        ///////Image Uploard End////////////

        ///////Gallery Uploard Start////////////
        $files=$r->file('gallery_image');
        if($files){
            foreach($files as $file)
            {
                $file =$file;
                $src  =$product->id;
                $srcType  =1;
                $fileUse  =3;
                $fileStatus=false;
                $author=Auth::id();
                uploadFile($file,$src,$srcType,$fileUse,$author,$fileStatus);
            }
        }
        ///////Gallery Uploard End////////////

        $slug =Str::slug($r->name);
        if($slug==null){
        $product->slug=$product->id;
        }else{
        if(Post::where('type',2)->where('slug',$slug)->whereNotIn('id',[$product->id])->count() >0){
        $product->slug=$slug.'-'.$product->id;
        }else{
        $product->slug=$slug;
        }
        }
        if($r->created_at){
          $product->created_at =$r->created_at;
        }
        $product->status =$r->status?'active':'inactive';
        $product->for_website =$r->for_website?1:0;
        $product->fetured =$r->fetured?1:0;
        $product->new_arrival =$r->new_arrival?1:0;
        $product->top_sale =$r->top_sale?1:0;
        $product->sale_label =$r->sale_label?1:0;
        $product->import_status =$r->import_status?1:0;
        $product->editedby_id =Auth::id();
        $product->save();

      //Category posts
      if($r->categoryid){

      $product->productCtgs()->whereNotIn('reff_id',$r->categoryid)->delete();

       for ($i=0; $i < count($r->categoryid); $i++) {

        $ctg = $product->productCtgs()->where('reff_id',$r->categoryid[$i])->first();

        if($ctg){}else{
        $ctg =new PostAttribute();
        $ctg->src_id=$product->id;
        $ctg->reff_id=$r->categoryid[$i];
        $ctg->type=0;
        }
        $ctg->drag=$i;
        $ctg->save();
       }

     }else{
        $product->productCtgs()->delete();
     }


       //Tags posts
      if($r->tags){

      $product->productTags()->whereNotIn('reff_id',$r->tags)->delete();

       for ($i=0; $i < count($r->tags); $i++) {

        $tag = $product->productTags()->where('reff_id',$r->tags[$i])->first();

        if($tag){}else{
        $tag =new PostAttribute();
        $tag->src_id=$product->id;
        $tag->reff_id=$r->tags[$i];
        $tag->type=4;
        }
        $tag->drag=$i;
        $tag->save();
       }

     }else{
        $product->productTags()->delete();
     }
       
       
      //Attribute Serialize Date
      if($r->attributeSerial){
        for ($i=0; $i < count($r->attributeSerial); $i++) {
          $data = $product->productAttibutes()->find($r->attributeSerial[$i]);
          if($data){
            $data->drag=$i;
            $data->save();
          }
        }
      }

      if($r->extraAttributeSerial){
        for ($i=0; $i < count($r->extraAttributeSerial); $i++) {
          $data = $product->extraAttribute()->find($r->extraAttributeSerial[$i]);
          if($data){
            $data->drag=$i+1;
            $data->save();
          }
        }
      }
      //Attribute Serialize Date

        Session()->flash('success','Your Are Successfully Done');
        return redirect()->back();
      }

      if($action=='delete'){
        $medias =Media::latest()->where('src_type',1)->where('src_id',$product->id)->get();
        foreach($medias as $media){
            if(File::exists($media->file_url)){
              File::delete($media->file_url);
            }
            $media->delete();
        }
        
        $product->productAttibutes()->delete();
        $product->productVariationAttibutes()->delete();
        $product->productVariationAttributeItems()->delete();
        $product->productVariationAttributeItemsList()->delete();
        foreach($product->productVariationAttributeItemsValues as $value){
           $medies =Media::where('src_type',8)->where('src_id',$value->id)->get();
            foreach ($medies as  $media) {
                if(File::exists($media->file_url)){
                    File::delete($media->file_url);
                }
                $media->delete();
            }
            $value->delete();
        }

        $product->productCtgs()->delete();
        $product->productTags()->delete();
        $product->delete();

        Session()->flash('success','Your Are Successfully Done');
        return redirect()->back();
      }
      
      if($product->bar_code==null){
          $product->bar_code=Carbon::now()->format('ymd').$product->id;
          $product->save();
      }

      $categories =Attribute::where('type',0)->where('status','<>','temp')->where('parent_id',null)->get();
      $brands =Attribute::where('type',2)->where('status','<>','temp')->where('parent_id',null)->get();
      $attributes =Attribute::where('type',9)->where('status','<>','temp')->where('parent_id',null);
      $variationAttributes =Attribute::where('type',9)->where('status','<>','temp')->where('fetured',true)
                            //->whereIn('id',[68,73])
                            ->where('parent_id',null);
      $tags =Attribute::where('type',10)->where('status','<>','temp')->where('parent_id',null)->get();
      $attriMessage ='';
      $brand =$product->brand;

      return view(adminTheme().'products.productsEdit',compact('product','categories','brands','attributes','variationAttributes','tags','brand','attriMessage'));

    }


    public function productsUpdateAjax(Request $r,$column,$id){

      $product =Post::where('type',2)->find($id);
      $attriMessage='';
      if($r->ajax() && $product){

        //Product Attribute Filters
        if($column=='attributesItemFilter'){
          $attri =Attribute::where('type',9)->where('parent_id',null)->find($r->attriID);
          if($attri){
            $viewData = view(adminTheme().'products.includes.attritubeItems',compact('product','attri'))->render();
            return Response()->json([
                'success' => true,
                'viewData' => $viewData,
            ]);

          }
        }
        
        //Product Brand Filters
        if($column=='brandFilter'){
          $brand =Attribute::where('type',2)->where('parent_id',null)->find($r->brandId);
          if($brand){
            $viewData = view(adminTheme().'products.includes.productsBrands',compact('product','brand'))->render();
            return Response()->json([
                'success' => true,
                'viewData' => $viewData,
            ]);
          }
        }
        
        if($column=='attributesItemAddIds' || $column=='attributesVariationItemAddIds' || $column=='attributesVariationItemAdd' || $column=='attributesVariationItemUpdate' || $column=='attributesVariationImageUpdate' || $column=='attributesItemDeletesIds'){
            
            if($column=='attributesItemAddIds'){
                if (!empty($r->attriID)) {
                    $product->productAttibutes()->whereNotIn('parent_id', $r->attriID)->delete();
                    
                    for ($i = 0; $i < count($r->attriID); $i++) {
                        $data = $product->productAttibutes()->where('parent_id', $r->attriID[$i])->first();
                        if (!$data) {
                            $data = new PostAttribute();
                            $data->src_id = $product->id;           // Product ID
                            $data->parent_id = $r->attriID[$i];     // Attribute Item ID
                            $attri = Attribute::find($r->attriID[$i]); // Find the main attribute using the current attriID
                            $data->reff_id = $attri?$attri->parent_id:null;     // Main Attribute ID (parent of the current attribute)
                            $data->type = 3;
                            $data->addedby_id = auth::id();         // The currently authenticated user's ID
                            $data->save();
                        }
                    }
                }else{
                    $product->productAttibutes()->delete();
                }
            }
            
            
            if($column=='attributesVariationItemAddIds'){
                if (!empty($r->attriID)) {
                    $product->productVariationAttibutes()->whereNotIn('parent_id', $r->attriID)->delete();
                    
                    for ($i = 0; $i < count($r->attriID); $i++) {
                        $data = $product->productVariationAttibutes()->where('parent_id', $r->attriID[$i])->first();
                        if (!$data) {
                            $data = new PostAttribute();
                            $data->src_id = $product->id;           // Product ID
                            $data->reff_id = $r->attriID[$i];     // Attribute Item ID
                            // $attri = Attribute::find($r->attriID[$i]); // Find the main attribute using the current attriID
                            // $data->reff_id = $attri->parent_id;     // Main Attribute ID (parent of the current attribute)
                            $data->type = 7;
                            $data->addedby_id = auth::id();         // The currently authenticated user's ID
                            $data->save();
                        }
                    }
                }else{
                    $product->productVariationAttibutes()->delete();
                }
            }
            
            if($column=='attributesVariationItemAdd'){
                $ids =$r->itemsIds;
                if($r->itemsIds && $product->productVariationAttributeItemsCheck($r->itemsIds)){
                  $data = new PostAttribute();
                  $data->src_id = $product->id;
                  $data->reguler_price = $r->variation_price?:0;
                  $data->discount = $r->variation_discount?:0;
                  $data->discount_type = $r->variation_discount_type?:'percent';
                  $data->purchase_price = $r->variation_purchase_price?:0;
                  $data->wholesale_price = $r->variation_wholesale_price?:0;

                  if($data->discount_type=='flat' && $data->discount < $data->reguler_price){
                    $data->final_price =$data->reguler_price - $data->discount;
                  }elseif($data->discount_type=='percent' &&  $data->discount < 100 || $data->reguler_price > 0){
                    $data->final_price =$data->reguler_price - ($data->reguler_price * $data->discount/100);
                  }else{
                    $data->final_price=$data->reguler_price;
                  }

                //   $data->quantity = $r->variation_quantity?:0;
                  $data->stock_status = $r->variation_stock?true:false;
                  $data->barcode = $r->variation_barcode;
                  $data->type = 8;
                  $data->addedby_id = auth::id();
                  $data->save();
                  

                  for($i=0; $i <count($r->itemsIds);$i++){
                    $attri =Attribute::where('type',9)->find($r->itemsIds[$i]);
                    if($attri){
                      $item = new PostAttributeVariation();
                      $item->src_id =$data->id;
                      $item->product_id =$product->id;
                      $item->attribute_id =$attri->parent_id;
                      $item->attribute_item_id =$attri->id;
                      $item->attribute_item_value =$attri->name;
                      $item->save();
                      
                        $itemValue =$product->productVariationAttributeItemsValues()->where('parent_id',$attri->id)->where('reff_id',$attri->parent_id)->first();
                        if(!$itemValue){
                          $itemValue = new PostAttribute();
                          $itemValue->src_id =$product->id;
                          $itemValue->parent_id =$attri->id;
                          $itemValue->reff_id =$attri->parent_id;
                          $itemValue->type = 9;
                          $itemValue->addedby_id = auth::id();
                          $itemValue->save(); 
                        }
                    }
                    
                  }
              }else{
                  $attriMessage ="<span style='color:red;'>This Attribute already added</span>";
              }



            }
            
            if($column=='attributesVariationItemUpdate'){

                $data =$product->productVariationAttributeItems()->find($r->variation_id);
                if($data){
                    
                    $ids =$r->itemsIds;
                    $hasItem =$data->attributeVatiationItems()->whereIn('attribute_item_id',$ids)->count();
                    
                    $status =true;
                    
                    if($hasItem!=$data->attributeVatiationItems()->count()){
                        if($product->productVariationAttributeItemsCheck($ids)){
                            $status=true;
                        }else{
                            
                        $status=false;
                        }
                    }
                    
                    if($status){
                        $data->reguler_price = $r->variation_price?:0;
                        $data->discount = $r->variation_discount?:0;
                        $data->discount_type = $r->variation_discount_type?:'percent';
                        $data->purchase_price = $r->variation_purchase_price?:0;
                        $data->wholesale_price = $r->variation_wholesale_price?:0;
                        
                        if($data->discount_type=='flat' && $data->discount < $data->reguler_price){
                        $data->final_price =$data->reguler_price - $data->discount;
                        }elseif($data->discount_type=='percent' &&  $data->discount < 100 || $data->reguler_price > 0){
                        $data->final_price =$data->reguler_price - ($data->reguler_price * $data->discount/100);
                        }else{
                        $data->final_price=$data->reguler_price;
                        }
                        
                        // $data->quantity = $r->variation_quantity?:0;
                        $data->stock_status = $r->variation_stock?true:false;
                        $data->barcode = $r->variation_barcode;
                        $data->save();
                        
                        $data->attributeVatiationItems()->whereNotIn('attribute_item_id', $r->itemsIds)->delete();
                        
                        for($i=0; $i <count($r->itemsIds);$i++){
                            $item =$data->attributeVatiationItems()->where('attribute_item_id',$r->itemsIds[$i])->first();
                            if(!$item){
                                $attri =Attribute::where('type',9)->find($r->itemsIds[$i]);
                                if($attri){
                                  $item = new PostAttributeVariation();
                                  $item->src_id =$data->id;
                                  $item->product_id =$product->id;
                                  $item->attribute_id =$attri->parent_id;
                                  $item->attribute_item_id =$attri->id;
                                  $item->attribute_item_value =$attri->name;
                                  $item->save();
                                  
                                    $itemValue =$product->productVariationAttributeItemsValues()->where('parent_id',$attri->id)->where('reff_id',$attri->parent_id)->first();
                                    if(!$itemValue){
                                      $itemValue = new PostAttribute();
                                      $itemValue->src_id =$product->id;
                                      $itemValue->parent_id =$attri->id;
                                      $itemValue->reff_id =$attri->parent_id;
                                      $itemValue->type = 9;
                                      $itemValue->addedby_id = auth::id();
                                      $itemValue->save(); 
                                    }
                                }
                            }
                        }
                        
                        
                    }else{
                        $attriMessage ="<span style='color:red;'>This Attribute already added</span>";
                    }
              
                }else{
                    $attriMessage ="<span style='color:red;'>This Attribute are not found</span>";  
                } 
                
            }
            
            if($column=='attributesVariationImageUpdate'){
                if(!empty($r->valueItems)) {
                    for($i=0; $i < count($r->valueItems); $i++){
                        $hasValue =$product->productVariationAttributeItemsValues()->find($r->valueItems[$i]);
                        if($hasValue){
                            ///////Image Uploard Start////////////
                            if($r->hasFile('variation_image_'.$r->valueItems[$i])) {
                                $file = $r->file('variation_image_'.$r->valueItems[$i]);  // Get the uploaded file
                                $src = $hasValue->id;
                                $srcType = 8;  // As per your code
                                $fileUse = 1;  // As per your code
                                uploadFile($file, $src, $srcType, $fileUse);  // Call the upload function
                            }
                            ///////Image Uploard End////////////
                        }
                    }
                }
            }
            
            if($column=='attributesItemDeletesIds'){
              if (!empty($r->attriID)) {
                $items =$product->productVariationAttributeItems()->whereIn('id',$r->attriID)->get();
                foreach($items as $item){
                  $item->attributeVatiationItems()->delete();
                  $item->delete();
                }

                if($product->productVariationAttributeItems()->count()==0){
                  $product->productVariationAttibutes()->delete();
                  foreach($product->productVariationAttributeItemsValues as $value){
                       $medies =Media::where('src_type',8)->where('src_id',$value->id)->get();
                        foreach ($medies as  $media) {
                            if(File::exists($media->file_url)){
                                File::delete($media->file_url);
                            }
                            $media->delete();
                        }
                        $value->delete();
                  }
                }
              }
            }
            
            $extraValues =$product->productVariationAttributeItemsValues()->whereNotIn('parent_id',$product->productVariationAttributeItemsList()->pluck('attribute_item_id'))->get();
            foreach($extraValues as $extraValue){
                $medies =Media::where('src_type',8)->where('src_id',$extraValue->id)->get();
                foreach ($medies as  $media) {
                    if(File::exists($media->file_url)){
                        File::delete($media->file_url);
                    }
                    $media->delete();
                }
                $extraValue->delete();
            }

            if($product->productAttibutesVariationGroup()->count() > 0){
              $product->min_price=$product->productVariationAttributeItems()->min('final_price');
              $product->max_price=$product->productVariationAttributeItems()->max('final_price');
              $product->variation_status=true;
              $product->final_price=$product->activeVariationPrice();
              $product->regular_price=$product->activeVariationRegularPrice();
              $product->discount= $product->activeVariationDiscount();
              $product->save();
          }else{
            $product->min_price=$product->final_price;
            $product->max_price=$product->final_price;
            $product->final_price=0;
            $product->discount=0;
            $product->regular_price=0;
            $product->variation_status=false;
            $product->save();
          }
            
            $attributes =Attribute::where('type',9)->where('status','<>','temp')->where('parent_id',null);
            $variationAttributes =Attribute::where('type',9)->where('status','<>','temp')->where('fetured',true)->where('parent_id',null);
            $viewData = view(adminTheme().'products.includes.productsDataAttributes2',compact('product','attributes','variationAttributes','attriMessage'))->render();
            return Response()->json([
                'success' => true,
                'viewData' => $viewData,
            ]);

        }

        //Product Attribute 
        if($column=='attributesItemAdd' || $column=='attributesItemDelete' || $column=='attributesItemColor' || $column=='attributesItemImage'){


          if($column=='attributesItemAdd'){
            $attri =Attribute::where('type',9)->where('parent_id','<>',null)->find($r->attriID);
            if($attri){
              $data =$product->productAttibutes()->where('parent_id',$attri->id)->first();
              if(!$data){
                $data =new PostAttribute();
                $data->src_id=$product->id; //Product ID
                $data->parent_id=$attri->id; //Attribute Items ID
                $data->reff_id=$attri->parent_id; //Main Attribute ID
                $data->type=3;
                $data->addedby_id=auth::id();
                $data->save();
              }else{
                $attriMessage='<span class="text-danger">Already Added Attribute item!</span>';
              }
            }
          }

          if($column=='attributesItemColor'){
            $data =$product->productAttibutes()->find($r->attriID);
            if($data){
              $data->value_1=$r->attriValue?:null;
              $data->save();
            }
          }


          if($column=='attributesItemImage'){
            $data =$product->productAttibutes()->find($r->attriID);
            if($r->hasFile('attriValue')){
              $file =$r->attriValue;
              $src  =$data->id;
              $srcType  =8;
              $fileUse  =1;
              uploadFile($file,$src,$srcType,$fileUse);
            }
            ///////Image Uploard End////////////
        }
        


        if($column=='attributesItemDelete'){
            $data =$product->productAttibutes()->find($r->attriID);
            if($data){
              //More Additional Work..
              if($data->imageFile){
                if(File::exists($data->imageFile->file_url)){
                      File::delete($data->imageFile->file_url);
                  }
              }
              if(count($product->productSkus()->where('parent_id',$data->parent_id)->pluck('sku_id'))>0){
                $product->productSkus()->whereIn('sku_id',$product->productSkus()->where('parent_id',$data->parent_id)->pluck('sku_id'))->delete();
              }
              $data->delete();
            }
        }

          $viewData = view(adminTheme().'products.includes.attributeItemsList',compact('product','attriMessage'))->render();
          $viewData2 = view(adminTheme().'products.includes.productVariation',compact('product','attriMessage'))->render();
          return Response()->json([
              'success' => true,
              'viewData' => $viewData,
              'viewData2' => $viewData2,
          ]);
        //Product Attribute End
        }


        //Product Variations Start
        if($column=='priceVariationStatus'){
          $product->variation_status=$product->variation_status?false:true;
          $product->save();

          $viewData = view(adminTheme().'products.includes.productVariation',compact('product','attriMessage'))->render();

          return Response()->json([
              'success' => true,
              'viewData' => $viewData,
          ]);

        }

        if($column=='variationItemsAdd' || $column=='variationItemsDelete'){
            
            if($column=='variationItemsDelete'){
                $product->productSkus()->where('sku_id',$r->skuId)->delete();
            }
            
            if($column=='variationItemsAdd'){
    
              if($r->variationItems){
    
                $uniIDS =$product->id;
                for ($i=0; $i < count($r->variationItems); $i++) {
                  $uniIDS.=$r->variationItems[$i];
                }
    
                $checkSku =$product->productSkus()->where('sku_id',$uniIDS)->first();
    
                if($checkSku){
                  $attriMessage ='<span class="text-danger">Already Added Items!!</span>';
                }else{
                    //Sku Items 
                    for ($i=0; $i < count($r->variationItems); $i++) {
                      if($r->variationItems[$i]!=null){
    
                          $attri =Attribute::where('type',9)->where('parent_id','<>',null)->find($r->variationItems[$i]);
                          if($attri){
                            $data =new PostAttribute();
                            $data->src_id=$product->id; //Product ID
                            $data->parent_id=$attri->id; //Attribute Items ID
                            $data->reff_id=$attri->parent_id; //Main Attribute ID
                            $data->sku_id=$uniIDS; //Sku  ID
                            $data->type=4;
                            $data->addedby_id=auth::id();
                            $data->save();
                          }
                      }
                    }
                  
                }
    
              }else{
                $attriMessage ='<span class="text-danger">Please Select Variation Items!!</span>';
              }
            }
            
              $viewData = view(adminTheme().'products.includes.productVariation',compact('product','attriMessage'))->render();
              return Response()->json([
                  'success' => true,
                  'viewData' => $viewData,
              ]);
           
            
        }
        
        //Product Variations End


        //Extra Product Attribute
        if($column=='extraAttributeAdd' || $column=='extraAttributeDelete'){

          //Extra Product Attribute Add
          if($column=='extraAttributeAdd'){
            $extraAttribue =$product->extraAttribute()->find($r->attri_id);
            if(!$extraAttribue){
                $lastCount =$product->extraAttribute()->count();
                $extraAttribue =new PostExtra();
                $extraAttribue->src_id=$product->id;
                $extraAttribue->type=2;
                $extraAttribue->drag=$lastCount+1;
            }
            $extraAttribue->name=Str::limit($r->title,280);
            $extraAttribue->content=nl2br($r->value);//$r->value;
            $extraAttribue->save(); 
          }

          //Extra Product Attribute Delete
          if($column=='extraAttributeDelete'){
                $extraAttri =$product->extraAttribute()->find($r->attriID);
                if($extraAttri){
                    $extraAttri->delete();
                }
              
                foreach($product->extraAttribute as $i=>$attr) {
                    $attr->drag=$i+1;
                    $attr->save();
                }
              
          }
          

          $viewData = view(adminTheme().'products.includes.extraAttributeList',compact('product'))->render();

          return Response()->json([
                'success' => true,
                'viewData' => $viewData,
            ]);

        }
        
        if($column=='discount_type'){
          $product->discount_type=$r->data?:null;
          $product->save();
        }

        if($column=='discount'){
          if($product->discount_type=='flat'){
              if($product->discount > $product->regular_price){
                $product->discount=$product->regular_price;
              }else{
                $product->discount=$r->data?:0;
              }
          }else{
              if($product->discount > 100){
                $product->discount=100;
              }else{
                $product->discount=$r->data?:0;
              }
          }
          $product->save();
          
          foreach($product->productVariationAttributeItems()->get() as $data){
                $data->discount = $product->discount;
                $data->discount_type = $product->discount_type?:'percent';
                if($data->discount_type=='flat' && $data->discount < $data->reguler_price){
                    $data->final_price =$data->reguler_price - $data->discount;
                }elseif($data->discount_type=='percent' &&  $data->discount < 100 || $data->reguler_price > 0){
                    $data->final_price =$data->reguler_price - ($data->reguler_price * $data->discount/100);
                }else{
                    $data->final_price=$data->reguler_price;
                }
                $data->save();
          }
          
        }
        
        if($column=='pos_price'){
          $product->pos_price=$r->data?:0;
          $product->save();
        }
        
        

        

        if($column=='regular_price'){
          $product->regular_price=$r->data?:0;
          $product->save();
        }

        if($column=='discount' || $column=='discount_type' || $column=='regular_price'){

              if($product->discount_type=='flat' && $product->discount < $product->regular_price){
                $product->final_price =$product->regular_price - $product->discount;
              }elseif($product->discount_type=='percent' &&  $product->discount < 100 || $product->regular_price > 0){
                $product->final_price =$product->regular_price - ($product->regular_price * $product->discount/100);
              }else{
                $product->final_price=$product->regular_price;
              }
          
           if($product->productAttibutesVariationGroup()->count() > 0){
                $product->min_price=$product->productVariationAttributeItems()->min('final_price');
                $product->max_price=$product->productVariationAttributeItems()->max('final_price');
                $product->variation_status=true;
            }else{
                $product->min_price=$product->final_price;
                $product->max_price=$product->final_price;
                $product->variation_status=false;
            }
          
          $product->purchase_price=$product->regular_price * (1 - 0.50);
          $product->wholesale_price=$product->regular_price * (1 - 0.40);
          $product->save();

        }


        if($column=='purchase_price'){
          $product->purchase_price=$r->data?:0;
          $product->save();
        }
        
        if($column=='wholesale_price'){
          $product->wholesale_price=$r->data?:0;
          $product->save();
        }

        if($column=='quantity'){
          $product->quantity=$r->data?:null;
          $product->save();
        }

        if($column=='stock_out_limit'){
          $product->stock_out_limit=$r->data?:0;
          $product->save();
        }

        if($column=='sku_code'){
          $product->sku_code=$r->data?:null;
          $product->save();
        }
        if($column=='warranty_note'){
          $product->warranty_note=$r->data?:null;
          $product->save();
        }
        if($column=='warranty_charge'){
          $product->warranty_charge=$r->data?:0;
          $product->save();
        }
        if($column=='warranty_note2'){
          $product->warranty_note2=$r->data?:null;
          $product->save();
        }
        if($column=='warranty_charge2'){
          $product->warranty_charge2=$r->data?:0;
          $product->save();
        }
        
        if($column=='stock_status'){
          $product->stock_status=$r->data==0?0:1;
          $product->save();
        }

        if($column=='bar_code'){
          $product->bar_code=$r->data?:null;
          $product->save();
        }

        if($column=='offer_start_date'){
          $product->offer_start_date=$r->data?:null;
          
          $product->save();
        }

        if($column=='offer_end_date'){
          $product->offer_end_date=$r->data?:null;
          $product->save();
        }

        if($column=='min_order_quantity'){
          $product->min_order_quantity=$r->data?:1;
          $product->save();
        }

        if($column=='max_order_quantity'){
          $product->max_order_quantity=$r->data?:null;
          $product->save();
        }

        if($column=='weight_unit'){
          $product->weight_unit=$r->data?Str::limit($r->data,100):null;
          $product->save();
        }
        if($column=='weight_amount'){
          $product->weight_amount=$r->data?Str::limit($r->data,50):null;
          $product->save();
        }
        if($column=='dimensions_unit'){
          $product->dimensions_unit=$r->data?Str::limit($r->data,100):null;
          $product->save();
        }

        if($column=='dimensions_length'){
          $product->dimensions_length=$r->data?Str::limit($r->data,50):null;
          $product->save();
        }

        if($column=='dimensions_width'){
          $product->dimensions_width=$r->data?Str::limit($r->data,50):null;
          $product->save();
        }

        if($column=='dimensions_height'){
          $product->dimensions_height=$r->data?Str::limit($r->data,50):null;
          $product->save();
        }


        return Response()->json([
                'success' => true,
            ]);

      }
    }
  // Products Management Function End
 
 public function productsLabelPrint(Request $r){
    
    if($r->ajax() ){
        
        if($r->actiontype==1){
            $productId = $r->product_id;
            $variantId = $r->variant_id; // can be null
            $quantity = 1;
        
            $barCodePrint = session()->get('barcode_items', []);
        
            $found = false;
        
            foreach($barCodePrint as &$item){
                if ($item['product_id'] == $productId && $item['variant_id'] == $variantId) {
                    $item['quantity'] += $quantity;
                    $found = true;
                    break;
                }
            }
        
            if (!$found) {
                $barCodePrint[] = [
                    'product_id' => $productId,
                    'variant_id' => $variantId,
                    'quantity' => $quantity
                ];
            }
        
            session()->put('barcode_items', $barCodePrint);
        }
        
        if($r->actiontype==2){
            $productId = $r->product_id;
            $variantId = $r->variant_id?:null; 
            $quantity = $r->quantity?:1; 
            $barCodePrint = session()->get('barcode_items', []); // here need to find  $productId and $variantId if
            
            foreach ($barCodePrint as &$item) {
                if ($item['product_id'] == $productId && $item['variant_id'] == $variantId) {
                    $item['quantity'] = $quantity;
                    break;
                }
            }
            
            session()->put('barcode_items', $barCodePrint);
        }
        
        if($r->actiontype==3){
            $productId = $r->product_id;
            $variantId = $r->variant_id ?: null;
        
            $barCodePrint = session()->get('barcode_items', []);
        
            $barCodePrint = array_filter($barCodePrint, function ($item) use ($productId, $variantId) {
                return !($item['product_id'] == $productId && $item['variant_id'] == $variantId);
            });
        
            session()->put('barcode_items', array_values($barCodePrint));
        }
        
        return Response()->json([
            'success' => true,
        ]);
        
    }
    
    if ($r->preview == 'remove') {
        
        session()->forget('barcode_items');
        
        return redirect()->route('admin.productsLabelPrint');
    }
    if ($r->preview == 'view') {
        $title = 'yes';
        $price = null;
        $barcode = null;
        $hasitems = [];
    
        $barCodePrint = session()->get('barcode_items', []);
    
        foreach ($barCodePrint as $code) {
            $product = Post::where('type', 2)
                ->where('status', '<>', 'temp')
                ->find($code['product_id']);
    
            if (!$product) {
                continue; // Skip if product not found
            }
    
            $name = $product->name;
            $barcode = '';
            $priceRate = 0;
    
            // If product has variant
            if ($product->variation_status && $code['variant_id']) {
                $variant = $product->productVariationAttributeItems()->find($code['variant_id']);
    
                if (!$variant) {
                    continue; // Skip if variant not found
                }
    
                if (!$variant->barcode) {
                    $variant->barcode = now()->format('ymd') . $product->id . rand(1111, 9999);
                    $variant->save();
                }
    
                $barcode = $variant->barcode;
                $priceRate = $variant->final_price;
    
                $vat = $product->import_status
                    ? $priceRate * general()->import_tax / 100
                    : $priceRate * general()->tax / 100;
    
                $priceRate += $vat;
    
                $priceAt = '<br><b>Price: TK ' . priceFormat($priceRate) . '</b> (Inc. VAT)';
                $name .= $priceAt;
    
                $attri = '';
                foreach ($variant->attributeVatiationItems()->whereHas('attribute')->get() as $att) {
                    $attri .= ' ' . $att->attribute->name . ': ' . $att->attributeItemName();
                }
                if ($attri) {
                    $name .= '<br>' . $attri;
                }
            } else {
                // No variant
                $barcode = $product->bar_code ?: (now()->format('ymd') . $product->id);
                $priceRate = $product->final_price;
    
                $vat = $product->import_status
                    ? $priceRate * general()->import_tax / 100
                    : $priceRate * general()->tax / 100;
    
                $priceRate += $vat;
                $priceAt = '<br><b>Price: TK ' . priceFormat($priceRate) . '</b> (Inc. VAT)';
                $name .= $priceAt;
            }
    
            $printCount = $code['quantity'] ?? 1;
    
            $hasitems[] = [
                'id' => $product->id,
                'name' => $name,
                'bar_code' => $barcode,
                'variant_id' => $code['variant_id'],
                'price' => priceFullFormat($priceRate),
                'quantity' => $printCount
            ];
        }
    
        $r->session()->put('items', $hasitems);
    
        $items = $r->session()->get('items', []);
    
        return view(adminTheme() . 'products.printBarcode', compact('items', 'title', 'price'));
    }
    
    $products =Post::latest()->where('type',2)->where('status','<>','temp')
        ->where(function($q) use ($r) {

            if($r->search){
                $searchTerms = preg_split('/\s+/', trim($r->search));
                $q->where(function ($query) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $query->where(function ($q) use ($term) {
                            $q->where('name', 'like', '%' . $term . '%')
                              ->orWhere('bar_code', 'like', '%' . $term . '%')
                              ->orWhereHas('productVariationActiveAttributeItems', function ($q2) use ($term) {
                                  $q2->where('stock_status', true)
                                     ->where('barcode', 'like', '%' . $term . '%');
                              });
                        });
                    }
                });

                // $q->where('name','LIKE','%'.$r->search.'%');
                // ->orWhereHas('productCategories',function($qq) use($r){
                //   $qq->where('name','LIKE','%'.$r->search.'%');
                // });
                
            }
            
            if($r->category)
            {
                $q->whereHas('productCtgs',function($qq) use($r){
                  $qq->where('reff_id',$r->category);
                });
            }

        })
        ->select(['id','name','regular_price','final_price','slug','view','type','brand_id','bar_code','created_at','addedby_id','status','import_status','quantity','fetured','variation_status'])
        ->paginate(25)->appends([
          'search'=>$r->search,
          'status'=>$r->status,
          'startDate'=>$r->startDate,
          'endDate'=>$r->endDate,
        ]);  
        
        $categories =Attribute::where('type',0)->where('status','<>','temp')->where('parent_id',null)->get();
        // return $products;
        
    return view(adminTheme().'products.productLavelList',compact('products','categories'));
  }
   

  //Products Category Function
  public function productsCategories(Request $r){

    $allPer = empty(json_decode(Auth::user()->permission->permission, true)['productsCtg']['all']);
    // Filter Action Start

      if($r->action){
        if($r->checkid){

          $datas=Attribute::where('type',0)->whereIn('id',$r->checkid)->get();

          foreach($datas as $data){

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

      $categories =Attribute::latest()->where('type',0)->where('status','<>','temp')
      ->where(function($q) use ($r) {

            if($r->search){
                $q->where('name','LIKE','%'.$r->search.'%');
            }

            if($r->status){
              if($r->status=='featured'){
              $q->where('fetured',true); 
              }else{
              $q->where('status',$r->status); 
              }
            }


      })
      ->select(['id','name','slug','parent_id','view','type','created_at','addedby_id','status','fetured'])
          ->paginate(25)->appends([
            'search'=>$r->search,
            'status'=>$r->status,
          ]);

      //Total Count Results
      $totals = DB::table('attributes')->where('status','<>','temp')
      ->where('type',0)
      ->selectRaw('count(*) as total')
      ->selectRaw("count(case when status = 'active' then 1 end) as active")
      ->selectRaw("count(case when status = 'inactive' then 1 end) as inactive")
      ->selectRaw("count(case when fetured = true then 1 end) as featured")
      ->first();

      
      return view(adminTheme().'products.category.categoriesAll',compact('categories','totals','r'));

  }

  public function productsCategoriesAction(Request $r,$action,$id=null){
      if($action=='create'){

        $category =Attribute::where('type',0)->where('status','temp')->where('addedby_id',Auth::id())->first();
        if(!$category){
          $category =new Attribute();
          $category->type =0;
          $category->status ='temp';
          $category->addedby_id =Auth::id();
        }
        $category->created_at =Carbon::now();
        $category->save();
        return redirect()->route('admin.productsCategoriesAction',['edit',$category->id]);
      }
      $category =Attribute::where('type',0)->find($id);
      if(!$category){
        Session()->flash('error','This Category Are Not Found');
        return redirect()->route('admin.productsCategories');
      }


      
      if($action=='update'){
        $check = $r->validate([
            'name' => 'required|max:191',
            'seo_title' => 'nullable|max:200',
            'seo_description' => 'nullable|max:200',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $category->name=$r->name;
        $category->description=$r->description;
        $category->seo_title=$r->seo_title;
        $category->seo_description=$r->seo_description;
        $category->seo_keyword=$r->seo_keyword;
        if($r->parent_id==$category->parent_id){}else{
          $category->parent_id=$r->parent_id;
        }
        
        ///////Image Uploard Start////////////
        if($r->hasFile('image')){
          $file =$r->image;
          $src  =$category->id;
          $srcType  =3;
          $fileUse  =1;
          
          uploadFile($file,$src,$srcType,$fileUse);
        }
        ///////Image Uploard End////////////

      ///////Banner Uploard End////////////

        if($r->hasFile('banner')){
          $file =$r->banner;
          $src  =$category->id;
          $srcType  =3;
          $fileUse  =2;
          
          uploadFile($file,$src,$srcType,$fileUse);
        }

      ///////Banner Uploard End////////////


        $slug =Str::slug($r->name);
        if($slug==null){
          $category->slug=$category->id;
        }else{
          if(Attribute::where('type',0)->where('slug',$slug)->whereNotIn('id',[$category->id])->count() >0){
          $category->slug=$slug.'-'.$category->id;
          }else{
          $category->slug=$slug;
          }
        }
        $category->status =$r->status?'active':'inactive';
        $category->fetured =$r->fetured?1:0;
        $category->editedby_id =Auth::id();
        $category->save();
        Session()->flash('success','Your Are Successfully Done');
        return redirect()->back();
      }

      if($action=='delete'){
        //Category Media File Delete
        $medias =Media::latest()->where('src_type',3)->where('src_id',$category->id)->get();
        foreach($medias as $media){
          if(File::exists($media->file_url)){
            File::delete($media->file_url);
          }
          $media->delete();
        }

        //Product Category sub Category replace
        foreach($category->subctgs as $subctg){
          $subctg->parent_id=$category->parent_id;
          $subctg->save();
        }
        
        $category->delete();

        Session()->flash('success','Your Are Successfully Done');
        return redirect()->back();
      }

      $parents =Attribute::where('type',0)->where('status','<>','temp')->where('parent_id',null)->get();

      return view(adminTheme().'products.category.categoryEdit',compact('category','parents'));


  }

    //Product Category Function End

    //Product Tags Function
  
  public function productsTags(Request $r){

      $allPer = empty(json_decode(Auth::user()->permission->permission, true)['productsCtg']['all']);
      // Filter Action Start

      if($r->action){
        if($r->checkid){

        $datas=Attribute::where('type',10)->whereIn('id',$r->checkid)->get();

        foreach($datas as $data){

            if($r->action==1){
              $data->status='active';
              $data->save();
            }elseif($r->action==2){
              $data->status='inactive';
              $data->save();
            }elseif($r->action==5){
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

      $tags =Attribute::latest()->where('type',10)
      ->where(function($q) use($r){

        if($r->search){
          $q->where('name','like','%'.$r->search.'%');
        }
        
      })
      ->paginate(25);

      //Total Count Results
    $totals = DB::table('attributes')
    ->where('type',10)
    ->selectRaw('count(*) as total')
    ->selectRaw("count(case when status = 'active' then 1 end) as active")
    ->selectRaw("count(case when status = 'inactive' then 1 end) as inactive")
    ->first();

      return view(adminTheme().'products.tags.tagsAll',compact('tags','totals','r'));
  }

  public function productsTagsAction(Request $r,$action,$id=null){
      if($action=='create'){
        $tag =Attribute::where('type',10)->where('status','temp')->where('addedby_id',Auth::id())->first();
        if(!$tag){
          $tag =new Attribute();
          $tag->type =10;
          $tag->status ='temp';
          $tag->addedby_id =Auth::id();
        }
        $tag->created_at=Carbon::now();
        $tag->save();
        return redirect()->route('admin.productsTagsAction',['edit',$tag->id]);
      }

      $tag =Attribute::where('type',10)->find($id);
      if(!$tag){
        Session()->flash('error','This Tag Are Not Found');
        return redirect()->route('admin.productsTags');
      }


      if($action=='update'){
        $check = $r->validate([
            'name' => 'required|max:191|unique:attributes,name,'.$tag->id,
        ]);

        $tag->name=$r->name;
        $tag->description=$r->description;
        $tag->status =$r->status?'active':'inactive';
        $tag->addedby_id =Auth::id();
        $tag->save();

        Session()->flash('success','Your Are Successfully Done');
        return redirect()->back();
      }

      if($action=='delete'){
        $tag->delete();
        Session()->flash('success','Your Are Successfully Done');
        return redirect()->back();
      }

      return view(adminTheme().'products.tags.tagEdit',compact('tag'));
  }

    //Product Tags Function End

    //Product Attributes Function 
  public function productsAttributes(Request $r){
      // Filter Action Start
      if($r->action){
        if($r->checkid){

        $datas=Attribute::latest()->where('type',9)->where('status','<>','temp')->whereIn('id',$r->checkid)->get();

        foreach($datas as $data){

            if($r->action==1){
              $data->status='active';
              $data->save();
            }elseif($r->action==2){
              $data->status='inactive';
              $data->save();
            }elseif($r->action==5){
              
              foreach($data->subAttributes as $item){

                $medias =Media::latest()->where('src_type',3)->where('src_id',$item->id)->get();
                foreach($medias as $media){
                  if(File::exists($media->file_url)){
                    File::delete($media->file_url);
                  }
                  $media->delete();
                }

                $item->delete();

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

      $attributes=Attribute::latest()->where('type',9)->where('status','<>','temp')->where('parent_id',null)
        ->where(function($q) use ($r) {

          if($r->search){
              $q->where('name','LIKE','%'.$r->search.'%');
          }

      })
      ->paginate(25)->appends([
        'search'=>$r->search,
      ]);

      return view(adminTheme().'products.attributes.attributesAll',compact('attributes'));
  }

  public function productsAttributesAction(Request $r,$action,$id=null){
    if($action=='create'){
          $attribute =Attribute::latest()->where('type',9)->where('addedby_id',Auth::id())->where('status','temp')->first();
          if(!$attribute){
          $attribute =new Attribute();
          $attribute->type =9;
          $attribute->status ='temp';
          $attribute->addedby_id =Auth::id();
          $attribute->save();
          }else{
          $attribute->parent_id =null;
          $attribute->created_at =Carbon::now();
          $attribute->save();
          }
          return redirect()->route('admin.productsAttributesAction',['edit',$attribute->id]);
    }

    $attribute =Attribute::where('type',9)->where('parent_id',null)->find($id);
    if(!$attribute){
      Session()->flash('error','This Attribute Are Not Found');
      return redirect()->route('admin.productsAttributes');
    }

    if($action=='update'){
      
      $check = $r->validate([
          'name' => 'required|max:100',
          'created_at' => 'required|date',
      ]);

      $hasAttribute =Attribute::where('type',9)->where('parent_id',null)->where('id', '!=', $id)->where('name',$r->name)->first();
      if($hasAttribute){
        Session::flash('error', $r->name.' attribute has already been added');
        return back();
      }

      //View =1=text,2=color,3=image
      $attribute->name=$r->name;
      $attribute->description=$r->description;
      $attribute->view=$r->type;
      $slug =Str::slug($r->name);
      if($slug==null){
        $attribute->slug=$attribute->id;
      }else{
        if(Attribute::where('type',9)->where('slug',$slug)->whereNotIn('id',[$attribute->id])->count() >0){
        $attribute->slug=$slug.'-'.$attribute->id;
        }else{
        $attribute->slug=$slug;
        }
      }
      $attribute->status =$r->status?'active':'inactive';
      $attribute->fetured =$r->fetured?1:0;
      $attribute->editedby_id =Auth::id();
      $attribute->created_at =$r->created_at?:Carbon::now();
      $attribute->save();

      Session()->flash('success','Your Are Successfully Done');
      return redirect()->back();
    }
    
    if($action=='delete'){

      foreach($attribute->subAttributes as $item){
        $medias =Media::latest()->where('src_type',3)->where('src_id',$item->id)->get();
        foreach($medias as $media){
          if(File::exists($media->file_url)){
            File::delete($media->file_url);
          }
          $media->delete();
        }
        $item->delete();
      }
      $attribute->delete();

      Session()->flash('success','Your Are Successfully Done');
      return redirect()->back();
    }


    if($r->checkid){

      $datas=$attribute->subAttributes()->whereIn('id',$r->checkid)->get();

      foreach($datas as $data){

          if($r->action==5){
            
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

      Session()->flash('success','Action Successfully Completed!');
      return back();
    }

    $items=$attribute->subAttributes()
        ->where(function($q) use ($r) {

          if($r->search){
              $q->where('name','LIKE','%'.$r->search.'%');
          }

      })
      ->paginate(50)->appends([
        'search'=>$r->search,
      ]);


    return view(adminTheme().'products.attributes.attributesEdit',compact('attribute','r','items'));
  }

  public function productsAttributesItemAction(Request $r,$action,$id){
      
    if($action=='create'){
          $attribute =Attribute::where('type',9)->find($id);
          if(!$attribute){
            Session()->flash('error','This Attribute Are Not Found');
            return redirect()->route('admin.productsAttributes');
          }
          $attributeItem =Attribute::latest()->where('type',9)->where('parent_id',$attribute->id)->where('addedby_id',Auth::id())->where('status','temp')->first();
          if(!$attributeItem){
              $attributeItem =new Attribute();
              $attributeItem->type =9;
              $attributeItem->parent_id =$attribute->id;
              $attributeItem->status ='temp';
              $attributeItem->addedby_id =Auth::id();
              $attributeItem->save();
          }else{
              $attributeItem->parent_id =$attribute->id;
              $attributeItem->created_at =Carbon::now();
              $attributeItem->save();
          }
          return redirect()->route('admin.productsAttributesItemAction',['edit',$attributeItem->id]);

    }

    $attribute =Attribute::where('type',9)->find($id);
    if(!$attribute){
      Session()->flash('error','This Attribute Item Are Not Found');
      return redirect()->route('admin.productsAttributes');
    }
    
    $parentAttribute =$attribute->parent;
    if(!$parentAttribute){
      Session()->flash('error','This Attribute Item Are Not Found');
      return redirect()->route('admin.productsAttributes');
    }

    if($action=='update'){
      $check = $r->validate([
          'name' => 'required|max:191',
          'color' => 'nullable|max:191',
          'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);
      
      $hasAttribute =$parentAttribute->subAttributes()->where('id','<>',$attribute->id)->where('name',$r->name)->first();
      if($hasAttribute){
        Session()->flash('error',$r->name.' Attribute Item Are Already Found');
        return redirect()->back();
      }

      //View =1=text,2=color,3=image
      $attribute->name=$r->name;
      $attribute->description=$r->description;
      $attribute->icon=$r->color;

      ///////Image Uploard Start////////////
        if($r->hasFile('image')){
          $file =$r->image;
          $src  =$attribute->id;
          $srcType  =3;
          $fileUse  =1;
          
          uploadFile($file,$src,$srcType,$fileUse);
        }
        ///////Image Uploard End////////////


      $slug =Str::slug($r->name);
      if($slug==null){
        $attribute->slug=$attribute->id;
      }else{
        if(Attribute::where('type',9)->where('slug',$slug)->whereNotIn('id',[$attribute->id])->count() >0){
        $attribute->slug=$slug.'-'.$attribute->id;
        }else{
        $attribute->slug=$slug;
        }
      }
      $attribute->status ='active';
      $attribute->editedby_id =Auth::id();
      $attribute->save();
      Session()->flash('success','Your Are Successfully Done');
      return redirect()->back();
    }

    return view(adminTheme().'products.attributes.attributesItemEdit',compact('attribute'));

  }


    public function ecommerceSetting(Request $r,$action,$id=null){
        $general =General::first();
        if($action=='general'){
            
        if($r->isMethod('post')){
            
            $check = $r->validate([
              'currency' => 'nullable|max:10',
              'currency_decimal' => 'nullable|numeric',
              'currency_position' => 'nullable|numeric',
              'inside_dhaka_shipping_charge' => 'nullable|numeric',
              'outside_dhaka_shipping_charge' => 'nullable|numeric',
              'tax' => 'nullable|numeric',
              'import_tax' => 'nullable|numeric',
              'tax_status' => 'nullable|numeric',
              'online_store_id' => 'nullable|numeric',
            ]);
  
            $general->currency=$r->currency;
            $general->currency_decimal=$r->currency_decimal;
            $general->currency_position=$r->currency_position;
            $general->inside_dhaka_shipping_charge=$r->inside_dhaka_shipping_charge?:0;
            $general->outside_dhaka_shipping_charge=$r->outside_dhaka_shipping_charge?:0;
            $general->tax=$r->tax?:0;
            $general->import_tax=$r->import_tax?:0;
            $general->online_store_id=$r->online_store_id?:0;
            $general->tax_status=1; //$r->tax_status?:0;
            $general->save();

            Session::flash('success','General Information Are Update Successfully Done!');
            return redirect()->back();
        }
        
        
        
        $offernotes =PostExtra::where('type',5)->latest()->get();
        
        return view(adminTheme().'ecommerce-setting.settings',compact('offernotes'));
      }else{

        Session()->flash('error','Unknown Type Action Not Allow');
        return redirect()->route('admin.ecommerceSetting',['type'=>'general']);
      }
      
    }
    
    public function ecommerceCoupons(Request $r){
        
        $coupons =Attribute::latest()->where('type',13)->where('status','<>','temp')->where('parent_id',null)
                    ->where(function($q) use ($r) {
                      if($r->search){
                        $q->where('name','LIKE','%'.$r->search.'%');
                      }
                    })
                    ->paginate(10);
                    
        return view(adminTheme().'ecommerce-setting.coupons.couponsAll',compact('coupons'));
    }
    
    public function ecommerceCouponsAction(Request $r,$action,$id=null){
        
        if($action=='create'){
            $coupon =Attribute::where('type',13)->where('status','temp')->where('addedby_id',Auth::id())->first();
            if(!$coupon){
                $coupon =new Attribute();
                $coupon->type=13;
                $coupon->status='temp';
                $coupon->addedby_id=Auth::id();
            }
            $coupon->created_at=Carbon::now();
            $coupon->save();
            
            return redirect()->route('admin.ecommerceCouponsAction',['edit',$coupon->id]);
            
        }
        
        $coupon =Attribute::where('type',13)->find($id);
        if(!$coupon){
            Session()->flash('error','Coupon Are Not Found');
            return redirect()->route('admin.ecommerceCoupons');
        }
        
        if($action=='search-product'){
            
            $products =Post::where('type',2)->where('status','active')->where('name','like','%'.$r->search.'%')->limit(10)->get(['id','name']);
            
            if($r->ajax()){
                $view = view(adminTheme().'ecommerce-setting.includes.searchProduct',compact('products','coupon'))->render();
                  return Response()->json([
                      'view' => $view
                  ]);
            }
        }
        
        if($action=='add-product'){
            
            $postProduct =$coupon->couponProductPosts()->where('reff_id',$r->product_id)->first();
            if(!$postProduct){
                $postProduct =new PostAttribute();
                $postProduct->src_id=$coupon->id;
                $postProduct->reff_id=$r->product_id;
                $postProduct->type=6;
                $postProduct->save();
            }
            if($r->ajax()){
                $view = view(adminTheme().'ecommerce-setting.includes.couponProductsList',compact('coupon'))->render();
                  return Response()->json([
                      'view' => $view
                  ]);
            }
        }
        
        if($action=='delete-product'){
            
            $coupon->couponProductPosts()->whereIn('id',$r->checkedId)->delete();
            
            if($r->ajax()){
                $view = view(adminTheme().'ecommerce-setting.includes.couponProductsList',compact('coupon'))->render();
                  return Response()->json([
                      'view' => $view
                  ]);
            }
        }
        
        
        if($action=='update'){
            $check = $r->validate([
              'name' => 'required|max:100',
              'discount' => 'nullable|numeric',
              'discount_type' => 'nullable|max:100',
              'min_shopping' => 'nullable|numeric',
              'max_shopping' => 'nullable|numeric',
              'start_date' => 'nullable|date',
              'end_date' => 'nullable|date',
              'status' => 'required|max:20',
            ]);
 
            $coupon->name=$r->name;
            $coupon->amounts=$r->discount;
            $coupon->menu_type=$r->discount_type;
            $coupon->min_shopping=$r->min_shopping;
            $coupon->max_shopping=$r->max_shopping;
            $coupon->start_date=$r->start_date;
            $coupon->end_date=$r->end_date;
            $coupon->location=$r->coupon_type;

            $slug =Str::slug($r->name);
            if($slug==null){
              $coupon->slug=$coupon->id;
            }else{
              if(Attribute::where('type',13)->where('slug',$slug)->whereNotIn('id',[$coupon->id])->count() >0){
              $coupon->slug=$slug.'-'.$coupon->id;
              }else{
              $coupon->slug=$slug;
              }
            }
            $coupon->status =$r->status?'active':'inactive';
            $coupon->editedby_id =Auth::id();
            $coupon->save();
            
            if($r->categories){
              $coupon->couponCtgs()->whereNotIn('reff_id',$r->categories)->delete();
               for ($i=0; $i < count($r->categories); $i++) {
                $ctg = $coupon->couponCtgs()->where('reff_id',$r->categories[$i])->first();
                if($ctg){}else{
                $ctg =new PostAttribute();
                $ctg->src_id=$coupon->id;
                $ctg->reff_id=$r->categories[$i];
                $ctg->type=5;
                }
                $ctg->drag=$i;
                $ctg->save();
               }
            }else{
                $coupon->couponCtgs()->delete();
            }
            
            
            Session()->flash('success','Your Are Successfully Done');
            return redirect()->back();

        }
        
        if($action=='delete'){
            $coupon->delete();
            Session()->flash('success','Your Are Successfully Done');
            return redirect()->route('admin.ecommerceCoupons');
        }
        
        $categories =Attribute::where('type',0)->where('status','active')->where('parent_id',null)->get();
        
        return view(adminTheme().'ecommerce-setting.coupons.couponsEdit',compact('coupon','categories'));
    }

    
    public function ecommercePromotions(Request $r){
        
        $coupons =Attribute::latest()->where('type',14)->where('status','<>','temp')->where('parent_id',null)
                    ->where(function($q) use ($r) {
                      if($r->search){
                        $q->where('name','LIKE','%'.$r->search.'%');
                      }
                    })
                    ->paginate(10);
                    
        return view(adminTheme().'ecommerce-setting.promotions.promotions',compact('coupons'));
    }
    
    public function ecommercePromotionsAction(Request $r,$action,$id=null){
        
        if($action=='create'){
            $promotion =Attribute::where('type',14)->where('status','temp')->where('addedby_id',Auth::id())->first();
            if(!$promotion){
                $promotion =new Attribute();
                $promotion->type=14;
                $promotion->status='temp';
                $promotion->addedby_id=Auth::id();
            }
            $promotion->created_at=Carbon::now();
            $promotion->save();
            
            return redirect()->route('admin.ecommercePromotionsAction',['edit',$promotion->id]);
            
        }
        
        $promotion =Attribute::where('type',14)->find($id);
        if(!$promotion){
            Session()->flash('error','Promotion Are Not Found');
            return redirect()->route('admin.ecommercePromotions');
        }
        
        if($action=='search-product'){
            
            $products =Post::where('type',2)->where('status','active')->where('name','like','%'.$r->search.'%')->limit(10)->get(['id','name']);
            
            if($r->ajax()){
                $view = view(adminTheme().'ecommerce-setting.includes.searchPromotionProduct',compact('products','promotion'))->render();
                  return Response()->json([
                      'view' => $view
                  ]);
            }
        }
        
        if($action=='add-product'){
            
            $postProduct =$promotion->couponProductPosts()->where('reff_id',$r->product_id)->first();
            if(!$postProduct){
                $postProduct =new PostAttribute();
                $postProduct->src_id=$promotion->id;
                $postProduct->reff_id=$r->product_id;
                $postProduct->type=6;
                $postProduct->save();
            }
            if($r->ajax()){
                $view = view(adminTheme().'ecommerce-setting.includes.promotionProductsList',compact('promotion'))->render();
                  return Response()->json([
                      'view' => $view
                  ]);
            }
        }
        
        if($action=='delete-product'){
            
            $promotion->couponProductPosts()->whereIn('id',$r->checkedId)->delete();
            
            if($r->ajax()){
                $view = view(adminTheme().'ecommerce-setting.includes.promotionProductsList',compact('promotion'))->render();
                  return Response()->json([
                      'view' => $view
                  ]);
            }
        }
        
        
        if($action=='update'){
            
            $check = $r->validate([
              'name' => 'required|max:100',
              'discount' => 'nullable|numeric',
              'discount_type' => 'nullable|max:100',
              'start_date' => 'nullable|date',
              'end_date' => 'nullable|date',
              'status' => 'required|max:20',
              'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $promotion->name=$r->name;
            $promotion->amounts=$r->discount;
            $promotion->menu_type=$r->discount_type;
            $promotion->start_date=$r->start_date;
            $promotion->end_date=$r->end_date;
            $promotion->location=$r->coupon_type;
            
            ///////Image Uploard Start////////////
            if($r->hasFile('image')){
              $file =$r->image;
              $src  =$promotion->id;
              $srcType  =3;
              $fileUse  =1;
              
              uploadFile($file,$src,$srcType,$fileUse);
            }
            ///////Image Uploard End////////////
            

            $slug =Str::slug($r->name);
            if($slug==null){
              $promotion->slug=$promotion->id;
            }else{
              if(Attribute::where('type',14)->where('slug',$slug)->whereNotIn('id',[$promotion->id])->count() >0){
              $promotion->slug=$slug.'-'.$promotion->id;
              }else{
              $promotion->slug=$slug;
              }
            }
        
            $promotion->status =$r->status?:'inactive';
            $promotion->fetured =$r->fetured?true:false;
            $promotion->shipping_free =$r->shipping_free?true:false;
            $promotion->editedby_id =Auth::id();
            $promotion->created_at =$r->created_at?:Carbon::now();
            $promotion->save();
            
            if($r->categories){
              $promotion->couponCtgs()->whereNotIn('reff_id',$r->categories)->delete();
               for ($i=0; $i < count($r->categories); $i++) {
                $ctg = $promotion->couponCtgs()->where('reff_id',$r->categories[$i])->first();
                if($ctg){}else{
                $ctg =new PostAttribute();
                $ctg->src_id=$promotion->id;
                $ctg->reff_id=$r->categories[$i];
                $ctg->type=5;
                }
                $ctg->drag=$i;
                $ctg->save();
               }
            }else{
                $promotion->couponCtgs()->delete();
            }
            
            
            Session()->flash('success','Your Are Successfully Done');
            return redirect()->back();

        }
        
        if($action=='delete'){
            $promotion->delete();
            Session()->flash('success','Your Are Successfully Done');
            return redirect()->route('admin.ecommercePromotions');
        }
        
        $categories =Attribute::where('type',0)->where('status','active')->where('parent_id',null)->get(['id','name','parent_id']);

        return view(adminTheme().'ecommerce-setting.promotions.promotionsEdit',compact('promotion','categories'));
    }










}
