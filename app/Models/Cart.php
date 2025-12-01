<?php

namespace App\Models;

use App\Model\ProductSku;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
	protected $fillable = [
        'user_id', 
        'product_id', 
        'quantity', 
		'trans_date',
		'color',
		'size',
		'cookie',

    ];

    public function product()
    {
    	return $this->belongsTo(Post::class, 'product_id');
    }
    
    public function productColor()
    {
    	return $this->belongsTo(Attribute::class, 'color')->where('type',9);
    }
    
    public function productSize()
    {
    	return $this->belongsTo(Attribute::class, 'size')->where('type',9);
    }
    
    public function image(){
        if($this->product){
            
            if($this->product->productAttibutesVariationGroup()->count() > 0 and $this->sku_id)
            {
                $skuData = json_decode($this->sku_id, true);
                foreach($skuData as $title => $sku) {
                    if($title==68){
                        $hasImage =PostAttribute::where('src_id',$this->product_id)->where('type',9)->where('reff_id',$title)->where('parent_id',$sku)->first();
                        if($hasImage){
                         return $hasImage->variationImage();   
                        }
                    }
                }
            }
            return $this->product->image();
            
        }else{
            return 'public/medies/noimage.jpg';
        }
    }
    
    public function itemAttributes(){
        $options = array();
        if ($this->product && $this->sku_id) {
            $skuData = json_decode($this->sku_id, true);
            foreach($skuData as $title => $sku) {
                $hasAttri = $this->product->productVariationAttributeList()->find($sku);
                if ($hasAttri) {
                    $parent = $hasAttri->parent;
                    if($parent){
                        $options[] =[
                            'title'=>$parent->name,
                            'value'=>$hasAttri->name,
                        ];
                    }
                }
            }
        }
        return $options;
    }

    public function itemprice()
    {
        if($this->product){
            

            if($this->product->productAttibutesVariationGroup()->count() > 0 and $this->sku_id)
            {
                $selectedIds = json_decode($this->sku_id, true);
                $proDatas = $this->product->productVariationAttributeItems()->get(['id', 'src_id', 'reguler_price', 'discount', 'final_price', 'quantity', 'stock_status']);
                    $datas = [];
                    foreach ($proDatas as $data) {
                        $attributeItemIds = $data->attributeVatiationItems()->get(['attribute_item_id']);
                        $datas[] = [
                            'price' => $data->offerPrice(),
                            'stock_status' => $data->stock_status,
                            'items' => $attributeItemIds
                        ];
                    }
    
                $filteredDatas = array_filter($datas, function($product) use ($selectedIds) {
                    return collect($selectedIds)->every(function($selectedId, $attributeId) use ($product) {
                        return collect($product['items'])->contains(function($item) use ($selectedId) {
                            return $item['attribute_item_id'] == $selectedId;
                        });
                    });
                });
    
                $firstProduct = array_shift($filteredDatas);
                if($firstProduct && isset($firstProduct['price'])){
                    return $firstProduct['price'];
                }
                
            }
            return $this->product->offerPrice();
        }else{
            return 0;
        }

    }
    
    public function itemVariantData()
    {
        $variant=null;
        if($this->product){
            if($this->product->productAttibutesVariationGroup()->count() > 0 and $this->sku_id){
                $selectedIds = json_decode($this->sku_id, true);
                $proDatas = $this->product->productVariationAttributeItems()->get(['id', 'src_id', 'reguler_price','discount', 'final_price', 'quantity', 'stock_status']);
                    $datas = [];
                    foreach ($proDatas as $data) {
                        $attributeItemIds = $data->attributeVatiationItems()->get(['attribute_item_id']);
                        $status=false;
                        if($data->stock_status){
                            if($data->quantity > 0){
                                $status=true;
                            }
                        }
                        
                        $datas[] = [
                            'data_id' => $data->id,
                            'items' => $attributeItemIds
                        ];
                    }
    
                $filteredDatas = array_filter($datas, function($product) use ($selectedIds) {
                    return collect($selectedIds)->every(function($selectedId, $attributeId) use ($product) {
                        return collect($product['items'])->contains(function($item) use ($selectedId) {
                            return $item['attribute_item_id'] == $selectedId;
                        });
                    });
                });
                $DataId =null;
                $firstProduct = array_shift($filteredDatas);
                if($firstProduct && isset($firstProduct['data_id'])){
                    $DataId = $firstProduct['data_id'];
                }
                
                if($DataId){
                 $variant = $this->product->productVariationAttributeItems()->find($DataId);
                }
                
            }
            
        }
        return $variant;

    }

    public function subtotal()
    {
        return $this->quantity * $this->itemprice();
    }
    
    public function InDhakaDeliveryCharge()
    {
        if($this->product){
         return   $this->quantity * $this->product->shipping_cost;
        }else{
         return   $this->quantity*0;
        }
    }
    public function OurOfDhakaDeliveryCharge()
    {
        if($this->product){
         return   $this->quantity * $this->product->shipping_cost2;
        }else{
         return   $this->quantity*0;
        }
        
        
    }
}
