<?php

namespace App\Models;

use Cookie;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    
    //Models Information Data
    /********
     * 
     * type ==0 : Page
     * type ==1 : Post
     * type ==2 : Product
     * 
     * ------------------------
     *  Status==temp, active, inactive
     * ------------------------
     * 
     * Column:
     * 
     * id            =bigint(20):None,
     * name          =varchar(200):null,
     * slug          =varchar(250):null,
     * short_description =text:null,
     * description   =longtext:null,
     * view          =bigint(20):0
     * type          =int(1):0
     * seo_title     =varchar(191):null
     * seo_desc      =text:null
     * seo_keyword   =text:null
     * search_key    =text:null
     * status        =varchar(10):null
     * fetured       =tinyint(1):null
     * addedby_id    =bigint(20):null
     * editedby_id   =bigint(20)::null
     * created_at    =timestamp:null
     * updated_at    =timestamp:null
     * 
     * 
     * 
     ****/


    //Image and Banner Functions Start
    /********
     * 
     * *********/

    public function imageFile(){
    	return $this->hasOne(Media::class,'src_id')->where('src_type',1)->where('use_Of_file',1);
    }

    public function image(){
        if($this->imageFile){
            return $this->imageFile->file_url;
        }else{
            if($imageFile = $this->productVariationAttributeItemsValues()->whereHas('imageFile')->where('reff_id', 68)->first()){
                return $imageFile->image();
            }
            // if($varia =$this->productVariationAttributeItems()->first()){
            //     if($variaActive =$this->productVariationAttributeItems()->where('stock_status',true)->first()){
            //         return $variaActive->variationItemImage();
            //     }else{
            //         return $varia->variationItemImage();
            //     }
            // }
            return 'medies/noimage.jpg';
        }
    }
    
    public function imageName(){
        if($this->imageFile){
            return $this->imageFile->file_rename;
        }else{
            return 'noimage.jpg';
        }
    }

    public function bannerFile(){
        return $this->hasOne(Media::class,'src_id')->where('src_type',1)->where('use_Of_file',2);
    }

    public function banner(){
        if($this->bannerFile){
            return $this->bannerFile->file_url;
        }else{
            return 'medies/no-banner.png';
        }
    }
    
    public function bannerName(){
        
        if($this->bannerFile){
            return $this->bannerFile->file_rename;
        }else{
            return 'noimage.jpg';
        }
    }

    public function galleryFiles(){
        return $this->hasMany(Media::class,'src_id')->where('src_type',1)->where('use_Of_file',3);
    }
    
    public function variationGallery(){
        $imagesFile = $this->productVariationAttributeItemsValues()->whereHas('imageFile')->where('reff_id', 68)->get();
        $gallery = [];
        foreach ($imagesFile as $image) {
            $gallery[] = [
                'id' => $image->id,
                'image' => $image->variationImage(),
            ];
        }
        return $gallery;
    }

    public function getSpecifications(){
        $specifications = [];
        $attris = $this->productAttibutes()->whereHas('attribute')->select('reff_id', 'drag')->groupBy('reff_id', 'drag')->get();
        foreach ($attris as $item) {
            $subAttry = $this->productAttibutes()->where('reff_id', $item->reff_id)->get();
            $speciValue = [];
            foreach ($subAttry as $sub) {
                $speciValue[] = [
                    'name' => $sub->attributeItem ? $sub->attributeItem->name : ''
                ];
            }
            $specifications[] = [
                'name' => $item->attribute->name,
                'values' => $speciValue
            ];
        }
        if ($this->extraAttribute->count() > 0) {
            foreach ($this->extraAttribute as $item) {
                $specifications[] = [
                    'name' => $item->name,
                    'value' => $item->content,
                ];
            }
        }
        unset($this->extraAttribute);
        return $specifications;
    }
    
    public function warehouseStores($variant=null){
        return $this->hasMany(InventoryStock::class,'src_id')
        ->where(function($q)use($variant){
            if($variant){
                $q->where('variant_id',$variant);
            }
        });
    }
    
    public function warehouseStock($branch,$variant=null){
        $stock=0;
        if($this->warehouseStores->count() > 0 && $branch){
            // return dd($this->warehouseStores);
           $store =$this->warehouseStores()
                ->where('branch_id',$branch)
                ->where(function($q)use($variant){
                    if($variant){
                        $q->where('variant_id',$variant);
                    }
                })
               ->first();
           if($store){
            $stock =$store->quantity;
           }
        }
        return $stock;
    }
    
    
    public function productGalleries(){
        $b = array('c', 'd');
        
        //$gallery[]=$this->image();
        
        
        return $b;
    }
    //Image and Banner Functions End


    //Post Category tag, comments Functions 
    public function postCtgs(){
        return $this->hasMany(PostAttribute::class,'src_id')->where('type',1)->orderBy('drag','asc');
    }
    
    public function postDatas(){
        return $this->hasMany(PostExtra::class,'src_id')->where('type',4);
    }

    public function postTags(){
        return $this->hasMany(PostAttribute::class,'src_id')->where('type',2)->orderBy('drag','asc');
    }
    
    public function relatedPosts(){
        return Post::whereHas('ctgPosts',function($q){
                    $q->whereIn('reff_id',$this->ctgPosts->pluck('reff_id'));
                })
                ->whereNot('id',$this->id)
                ->where('status','active')
                ->whereDate('created_at','<=',date('Y-m-d'));
 
    }
    
    
    
    

    public function postComments(){
        return $this->hasMany(Review::class,'src_id')->where('type',1);
    }
    
    public function postCategories(){
        return $this->belongsToMany(Attribute::class, PostAttribute::class,'src_id','reff_id')->wherePivot('type',1)->orderBy('drag', 'asc');
    }
    
     public function Tags(){
        return $this->belongsToMany(Attribute::class, PostAttribute::class,'src_id','reff_id')->wherePivot('type',2)->orderBy('drag', 'asc');
    }
    
    public function productTagsList(){
        return $this->belongsToMany(Attribute::class, PostAttribute::class,'src_id','reff_id')->wherePivot('type',4)->orderBy('drag', 'asc');
    }

    public function ctgPosts(){
        return $this->hasMany(PostAttribute::class,'src_id')->where('type',1);
    }

    public function tagPosts(){
        return $this->hasMany(PostAttribute::class,'src_id')->where('type',2);
    }

    //Post Category tag, comments Functions End


    //Product Functions 
    public function productCtgs(){
        return $this->hasMany(PostAttribute::class,'src_id')->where('type',0)->orderBy('drag','asc');
    }

    public function productTags(){
        return $this->hasMany(PostAttribute::class,'src_id')->where('type',4)->orderBy('drag','asc');
    }
    
    public function productFullStock(){
        return $this->productBranchesStock()+$this->quantity;
    }
    
    public function taxAmount(){
        $taxAmount =0;
        if($this->import_status){
            $taxAmount =$this->final_price*general()->import_tax/100;
        }else{
            $taxAmount =$this->final_price*general()->tax/100;
        }
        return $taxAmount;
    }
    
    public function taxPercentage(){
        $tax =0;
        if($this->import_status){
            $tax =general()->import_tax;
        }else{
            $tax =general()->tax;
        }
        return $tax;
    }
    public function productWeight(){
        $unit =$this->weight_unit?:'';
        
        $UnitWeight ='';
        
        if($this->weight_amount >= 1000){

            if($unit=='gram'){
                $unit='Kg';
            }elseif($unit=='ml'){
                $unit='Liter';
            }
            
            $UnitWeight=$this->weight_amount/1000;
            
        }else{
            $UnitWeight =$this->weight_amount?:'';
        }
        
        return $UnitWeight.' '.$unit;
        
    }
    
    public function productWeightUnit(){

        $UnitWeight ='';
        
        if($this->weight_amount >= 1000){

            if($unit=='gram'){
                $unit='Kg';
            }elseif($unit=='ml'){
                $unit='Liter';
            }
            
            $UnitWeight=$this->weight_amount/1000;
            
        }else{
            $UnitWeight =$this->weight_amount?:'';
        }
        
        return $UnitWeight;
        
    }

    public function productCategories(){
        return $this->belongsToMany(Attribute::class, PostAttribute::class,'src_id','reff_id')->wherePivot('type',0)->orderBy('drag', 'asc');
    }

    public function ctgProducts(){
        return $this->hasMany(PostAttribute::class,'src_id')->where('type',0);
    }

    public function extraAttribute(){
        return $this->hasMany(PostExtra::class,'src_id')->where('type',2)->orderBy('drag','asc');
    }

    public function productAttibutes(){
        return $this->hasMany(PostAttribute::class,'src_id')->where('type',3)->where('parent_id','<>',null)->orderBy('drag','asc');
    }
    
    public function productVariationAttibutes(){
        return $this->hasMany(PostAttribute::class,'src_id')->where('type',7)->where('parent_id',null)->orderBy('drag','asc');
    }
    
    public function productVariationAttributeItems(){
        return $this->hasMany(PostAttribute::class,'src_id')->where('type',8)->orderBy('drag','asc');
    }
    
    public function productVariationActiveAttributeItems(){
        return $this->hasMany(PostAttribute::class,'src_id')->where('type',8)->where('stock_status',true)->orderBy('drag','asc')->whereHas('attributeVatiationItems',function($q){$q->whereHas('attribute')->whereHas('attributeItem');});
    }
    
    public function productVariantItemArray($id){
        $value =null;
        if($data =$this->productVariationActiveAttributeItems()->find($id)){
           $value .='<b>'.$item->attribute->name.'</b>: '.$item->attributeItem->name.', ';
        }
        return $value;
    }
    
    
    public function productVariationAttributeItemsValues(){
        return $this->hasMany(PostAttribute::class,'src_id')->where('type',9)->orderBy('drag','asc');
    }
    
    public function productVariationAttributeItemsList(){
        return $this->hasMany(PostAttributeVariation::class,'product_id');
    }
    
    
    public function productVariationAttributeList(){
        
        $ids =$this->productVariationAttributeItemsList()->pluck('attribute_item_id');
        
        return Attribute::where('status','active')->whereHas('parent')->whereIn('id',$ids);
    }
    
    
    public function productVariationAttributeItemsCheck($ids){
        $status=true;
        if($ids){
            foreach($this->productVariationAttributeItems as $item){
                $hasItem =$item->attributeVatiationItems()->whereIn('attribute_item_id',$ids)->count();
                if($hasItem==$item->attributeVatiationItems()->count()){
                    $status=false;
                }
            }
        }

        return $status;
    }
    
    
    
    public function productAttibutesGroup(){
        return $this->hasMany(PostAttribute::class, 'src_id')
        ->where('type', 3)
        ->whereNotNull('parent_id')
        ->whereHas('attribute')->select('reff_id')->groupBy('reff_id')->limit(2)->get();
    }
    
    public function productAttibutesVariationGroup(){

        return Attribute::latest()->whereIn('id',$this->productVariationAttributeItemsList()->select('attribute_id')->groupBy('attribute_id')->pluck('attribute_id'))->get();
    }

    public function productSkus(){
        return $this->hasMany(PostAttribute::class,'src_id')->where('type',4)->where('parent_id','<>',null)->orderBy('drag','asc');
    }
    
    public function productReviews(){
        return $this->hasMany(Review::class,'src_id')->where('type',0);
    }
    
    public function reviewTotal(){
       return $this->productReviews->count();
    }
    
    public function productRating(){
        $reviews =$this->productReviews->count();
        $totalRating =$this->productReviews->sum('rating');
        
        $averageRating =0;
        
        if($reviews > 0 && $totalRating > 0){
            (int)$averageRating = number_format($totalRating/$reviews,2);
        }
        
        if($averageRating > 5){
            $averageRating =5;
        }
        
        return $averageRating;
        
    }
    
    public function isRollCalculate(){
        $status=false;
        $collHasCalculateIDs =Attribute::where('type',0)->where('fetured',true)->pluck('id');
        $hasRollCulculateId =$this->productCtgs()->whereIn('reff_id',$collHasCalculateIDs)->pluck('reff_id');
        if(count($hasRollCulculateId) > 0){
            $status=true;
        }
        return $status;   
    }

    public function brand(){
        return $this->belongsTo(Attribute::class,'brand_id');
    }
    
    public function productMinQty(){
        $min =1;
        if($this->min_order_quantity){
           $min =$this->min_order_quantity;
        }
        
        return $min;
    }
    
    public function productMaxQty(){
        $max =$this->quantity;
        if($this->max_order_quantity){
           $max =$this->max_order_quantity;
        }
        
        return $max;
    }
    
    public function activeVariationPrice(){
        $price=null;
        if($varia =$this->productVariationAttributeItems()->whereHas('attributeVatiationItems')->first()){
            if($variaActive =$this->productVariationAttributeItems()->whereHas('attributeVatiationItems')->where('stock_status',true)->first()){
                $price =$variaActive->final_price;
            }else{
                $price =$varia->final_price;
            }
        }
        return $price;
    }
    public function activeVariationDiscount(){
        $price=null;
        if($varia =$this->productVariationAttributeItems()->whereHas('attributeVatiationItems')->first()){
            if($variaActive =$this->productVariationAttributeItems()->whereHas('attributeVatiationItems')->where('stock_status',true)->first()){
                $price =$variaActive->discount;
            }else{
                $price =$varia->discount;
            }
        }
        return $price;
    }
    public function activeVariationRegularPrice(){
        $price=null;
        if($varia =$this->productVariationAttributeItems()->whereHas('attributeVatiationItems')->first()){
            if($variaActive =$this->productVariationAttributeItems()->whereHas('attributeVatiationItems')->where('stock_status',true)->first()){
                $price =$variaActive->reguler_price;
            }else{
                $price =$varia->reguler_price;
            }
        }
        return $price;
    }
    
    public function offerPrice(){
        $price =$this->regular_price - ($this->regular_price*$this->discountPercent()/100);
        return $price;
    }
    
    public function regularPrice(){
        $price =$this->regular_price;
        return $price;
    }
    
    public function hasPromotion(){
        $promotion =null;
        
        $allProductPromotion = Attribute::latest()->where('type',14)->where('status','active')->where('parent_id',null)
                    ->whereDate('end_date','>=',Carbon::now())
                    ->first();
        if($allProductPromotion){
            $promotion =$allProductPromotion;
        }
        
        return $promotion;
    }
    
    public function discountPercent(){
        $discount =0;
        
        //All product
        $hasPromotion =Attribute::latest()->where('type',14)->where('status','active')->where('parent_id',null)->where('location','all')
                    ->whereDate('end_date','>=',Carbon::now())
                    ->first();
        if($hasPromotion){
            $discount=round($hasPromotion->amounts);
        }else{
            //Category
            $hasPromotion =Attribute::latest()->where('type',14)->where('status','active')->where('parent_id',null)->where('location','category')
                    ->whereDate('end_date','>=',Carbon::now())
                    ->whereHas('couponCtgs',function($q){
                        $q->whereIn('reff_id',$this->productCtgs()->pluck('reff_id'));
                    })
                    ->first();
            if($hasPromotion){
                $discount=round($hasPromotion->amounts);
            }else{
                //Induvitual
                $hasPromotion =Attribute::latest()->where('type',14)->where('status','active')->where('parent_id',null)->where('location','product')
                    ->whereDate('end_date','>=',Carbon::now())
                    ->whereHas('couponProductPosts',function($q){
                        $q->where('reff_id',$this->id);
                    })
                    ->first();
                if($hasPromotion){
                    $discount=round($hasPromotion->amounts);
                }else{
                    if($this->regular_price > $this->final_price){
                        if($this->discount_type=='flat'){
                            $discount = round($this->final_price / $this->regular_price * 100);
                        }else{
                            $discount=round($this->discount);
                        }
                    }
                }
            }
        }
        return $discount;
    }
    
    public function itemType(){
        $hasFrozen =$this->productCtgs->where('reff_id',166)->first();
        $hasDye =$this->productCtgs->where('reff_id',165)->first();
        if($hasFrozen){
            return 1;
        }elseif($hasDye){
            return 2;
        }else{
            return 0;
        }
    }
    
    public function stockStatus(){
        $status = true;
        
        if($this->stock_status){
            if($this->quantity){
                if($this->quantity > $this->stock_out_limit){
                    if($this->quantity==0){
                        $status = false;
                    }
                }else{
                    $status = false;
                }
            }
        }else{
         $status = false;  
        }
        
        
        return $status;
    }

    public function relatedProducts(){
        return Post::whereHas('ctgProducts',function($q){
                    $q->whereIn('reff_id',$this->ctgProducts->pluck('reff_id'));
                })
                // ->orWhereHas('productTags',function($q){
                //     $q->whereIn('reff_id',$this->productTags->pluck('reff_id'));
                // })
                // ->whereHas('productTags',function($q){
                //     $q->whereIn('reff_id',$this->productTags->pluck('reff_id'));
                // })
                ->inRandomOrder()
                ->whereNot('id',$this->id)
                ->where('status','active')
                ->whereDate('created_at','<=',date('Y-m-d'));
 
    }
    
    public function transfers(){
        return $this->hasMany(OrderItem::class,'product_id')->whereHas('order',function($q){
            $q->where('order_type','transfers_order');
        });
    }
    
    public function purchases(){
        return $this->hasMany(OrderItem::class,'product_id')->whereHas('order',function($q){
            $q->where('order_type','purchase_order');
        });
    }
    
    public function allPurchases(){
        return $this->hasMany(OrderItem::class,'product_id')->whereHas('order',function($q){
            $q->where('order_type','purchase_order')->whereIn('order_status',['confirmed','shipped','delivered']);
        });
    }
    
    public function allMinusStock(){
        return $this->hasMany(OrderItem::class,'product_id')->whereHas('order',function($q){
            $q->where('order_type','minus_order')->whereIn('order_status',['confirmed','shipped','delivered']);
        });
    }
    
    public function salesAll(){
        return $this->hasMany(OrderItem::class,'product_id')->whereHas('order',function($q){
            $q->whereIn('order_type',['customer_order']);
        });
    }
    
    public function allSales(){
        return $this->hasMany(OrderItem::class,'product_id')->whereHas('order',function($q){
            $q->whereIn('order_type',['customer_order','pos_order','wholesale_order'])->whereIn('order_status',['confirmed','shipped','delivered','returned']);
        });
    }
    
    public function allTransferOrder(){
        return $this->hasMany(OrderItem::class,'product_id')->whereHas('order',function($q){
            $q->whereIn('order_type',['transfers_order'])->whereIn('order_status',['confirmed','shipped','delivered','returned']);
        });
    }
    
    public function lastSale(){
        return $this->hasOne(OrderItem::class, 'product_id')
            ->whereHas('order',function($q){
                $q->whereIn('order_type',['customer_order','pos_order','wholesale_order'])->whereIn('order_status',['confirmed','shipped','delivered']);
            })
            ->latest('created_at'); // latest sale based on created_at
    }
    
    public function wishlists()
    {
        return $this->hasMany(WishList::class,'product_id')->where('type',0);
    }

    
    public function comparelists()
    {
        return $this->hasMany(WishList::class,'product_id')->where('type',1);
    }
    

    public function isWl()
    {
        
        
        return (bool) $this->wishlists()->where('cookie', Cookie::get('carts'))->where('type',0)->count();
    }
    
    public function isCP()
    {
        return (bool) $this->comparelists()->where('cookie', Cookie::get('carts'))->where('type',1)->count();
    }

    //Product Functions End


    
    public function user(){
    	return $this->belongsTo(User::class,'addedby_id');
    }

    

    

    
}
