<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostAttribute extends Model
{

    //Models Information Data
    /********
     * type ==0 : Category Post
     * type ==1 : blog Category Post
     * type ==2 : Blog Tags post
     * type ==3 : Product Attribute post
     * 
     * ------------------------
     *  Status==
     * ------------------------
     * 
     * 
     * Column:
     * 
     * id            =bigint(20):None,
     * src_id        =bigint(20):null
     * parent_id     =bigint(20):null
     * reff_id       =bigint(20):null
     * type          =tinyint(1):null
     * status        =varchar(20):null
     * duration      =int(6):null
     * drag          =bigint(20):null
     * addedby_id    =bigint(20):null
     * created_at    =timestamp:null
     * updated_at    =timestamp:null
     * 
     * 
     * 
     ****/

    public function imageFile(){
        return $this->hasOne(Media::class,'src_id')->where('src_type',8)->where('use_Of_file',1);
    }

    public function image(){
        if($this->imageFile){
            return $this->imageFile->file_url;
        }else{
            return 'medies/noimage.jpg';
        }
    }
    
    public function variationImage(){
        if($this->imageFile){
            return $this->imageFile->file_url;
        }else{
            if($this->post){
                return $this->post->image();
            }
            return 'pudgdfgblic/medies/noimage.jpg';
        }
    }
    
    public function variationItemImage(){
        if($item =$this->attributeVatiationItems()->where('attribute_id',68)->first()){
            $hasImage =PostAttribute::where('src_id',$item->product_id)->where('type',9)->where('reff_id',68)->where('parent_id',$item->attribute_item_id)->first();
            if($hasImage){
             return $hasImage->variationImage();   
            }
        }else{
            if($this->post){
                return $this->post->image();
            }
        }
        return 'medies/noimage.jpg';
    }


    public function post(){
        return $this->belongsTo(Post::class,'src_id');
    }

    public function attributeItem(){
        return $this->belongsTo(Attribute::class,'parent_id');
    }
    
    public function attributeVatiationItems(){
        return $this->hasMany(PostAttributeVariation::class,'src_id');
    }
    
    
    public function variationItemValues(){
        $value =null;
        foreach($this->attributeVatiationItems()->whereHas('attributeItem')->whereHas('attribute')->get() as $item){
           $value .='<b>'.$item->attribute->name.'</b>: '.$item->attributeItem->name.', ';
        }
        return $value;
    }
    
    
    public function offerPrice(){
        
        
        if(1==1){
        $price =$this->reguler_price - ($this->reguler_price*$this->discountPercent()/100);
        }else{
        $price =$this->final_price;
        }
        
        
        return $price;
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
                        if($this->post){
                            $q->whereIn('reff_id',$this->post->productCtgs()->pluck('reff_id'));
                        }else{
                            $q->whereIn('reff_id',[0001]);
                        }
                    })
                    ->first();
            if($hasPromotion){
                $discount=round($hasPromotion->amounts);
            }else{
                
                //Induvitual
                $hasPromotion =Attribute::latest()->where('type',14)->where('status','active')->where('parent_id',null)->where('location','product')
                    ->whereDate('end_date','>=',Carbon::now())
                    ->whereHas('couponProductPosts',function($q){
                        if($this->post){
                            $q->where('reff_id',$this->post->id);
                        }else{
                            $q->where('reff_id','0001');
                        }
                    })
                    ->first();
                if($hasPromotion){
                    $discount=round($hasPromotion->amounts);
                }else{
                    if($this->reguler_price > $this->final_price){
                        if($this->discount_type=='flat'){
                            $discount = round($this->final_price / $this->reguler_price * 100);
                        }else{
                            $discount=round($this->discount);
                        }
                    }
                }
            }
        }
        return $discount;
    }
    
    public function showPrice(){
        $price ='';
        if($this->reguler_price > $this->offerPrice()){
        $price ='<span class="offerPrice" data-price="'.$this->offerPrice().'">'.priceFullFormat($this->offerPrice()).'</span>/-<br><del class="regularPrice" data-price="'.$this->reguler_price.'">'.priceFullFormat($this->reguler_price).'/-</del>';
        }else{
        $price ='<span class="offerPrice" data-price="'.$this->offerPrice().'">'.priceFullFormat($this->offerPrice()).'</span>/-';
        }
        return $price;
    }
    
    public function taxAmount(){
        $taxAmount =0;
        if($this->post && $this->post->import_status){
            $taxAmount =$this->final_price*general()->import_tax/100;
        }else{
            $taxAmount =$this->final_price*general()->tax/100;
        }
        return $taxAmount;
    }
    
    public function taxPercentage(){
        $tax =0;
        if($this->post && $this->post->import_status){
            $tax =general()->import_tax;
        }else{
            $tax =general()->tax;
        }
        return $tax;
    }
    
    public function stockStatus(){
        $status = true;
        
        if($this->stock_status){
            if($this->quantity){
                if($this->quantity==0){
                    $status = false;
                }
            }
        }else{
         $status = false;  
        }
        
        
        return $status;
    }

    public function attributeItemValue(){
        $value ='unknown';
        if($this->attributeItem && $this->attributeItem->parent){
            $parent =$this->attributeItem->parent;
            if($parent->view==2){
        	$value =$this->value_1?:$this->attributeItem->icon;
        	}elseif($parent->view==3){
        	$value =$this->imageFile?$this->image():$this->attributeItem->image();
        	}else{
        	$value =$this->attributeItem->name;
            }
        }
        return $value;
    }
    
    public function product(){
        return $this->belongsTo(Post::class,'reff_id');
    }

    public function attribute(){
        return $this->belongsTo(Attribute::class,'reff_id');
    }
    
    public function branch(){
        return $this->belongsTo(Attribute::class,'reff_id')->where('type',13);
    }

    public function attributeCheck(){
        return $this->belongsTo(PostAttribute::class,'reff_id','reff_id')->where('type',4);
    }

    public function skuList(){
        return $this->hasMany(PostAttribute::class,'sku_id','sku_id')->where('type',4);
    }

    public function skuLists(){
        return $this->hasMany(PostAttribute::class,'reff_id','reff_id')->where('type',3)->orderBy('drag','asc');
    }

    public function skuCheck(){
        return $this->belongsTo(PostAttribute::class,'parent_id','parent_id')->where('type',4);
    }



}
