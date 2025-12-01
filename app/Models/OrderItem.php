<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    public function order(){
        return $this->belongsTo(Order::class);
    }
    
    public function branch(){
            return $this->belongsTo(Attribute::class,'branch_id');
        }
    public function productColor()
    {
    	return $this->belongsTo(Attribute::class, 'color')->where('type',9);
    }
    
    public function productSize()
    {
    	return $this->belongsTo(Attribute::class, 'size')->where('type',9);
    }
    
    public function productVariant()
    {
    	return $this->belongsTo(PostAttribute::class, 'variant_id')->where('type',8);
    }
    
    public function review(){
        return $this->hasOne(Review::class,'parent_id')->where('type',0);
    }
        
    public function taxAmount(){
        $taxAmount =0;
        if($this->product){
            if($this->product->import_status){
                $taxAmount =$this->total_price*general()->import_tax/100;
            }else{
                $taxAmount =$this->total_price*general()->tax/100;
            }
        }
        return $taxAmount;
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
    
    public function itemStock()
    {
        $stock=0;
        if($this->product){
            if($this->product->productAttibutesVariationGroup()->count() > 0 and $this->sku_id){
                $selectedIds = json_decode($this->sku_id, true);
                $proDatas = $this->product->productVariationAttributeItems()->get(['id', 'src_id', 'reguler_price', 'discount', 'final_price', 'quantity', 'stock_status']);
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
                            'stock' => $status?$data->quantity:0,
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
                if($firstProduct && isset($firstProduct['stock'])){
                    return $firstProduct['stock'];
                }
                
            }
            if($this->product->stockStatus()){
                $stock = $this->product->quantity;
            }else{
                $stock =0;
            }
            
        }
        return $stock;

    }
    
    public function discountAmount(){
        $disAmount =$this->regular_price*$this->discount/100;
        return $disAmount;
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
            return 'medies/noimage.jpg';
        }
    }
    
    public function itemAttributes(){
        $options = []; // Initialize as an empty array
        if ($this->product && $this->sku_value) {
            $skuData = json_decode($this->sku_value, true);
            return $skuData;
            // foreach($skuData as $title => $sku) {
            //     $hasAttri = $this->product->productVariationAttributeList()->find($sku); // Find the attribute
            //     if ($hasAttri) {
            //         $parent = $hasAttri->parent;
            //         $options[$parent->name] = $hasAttri->name; // Use the parent name as key, and attribute name as value
            //     }
            // }
        }
        return $options;
    }
    
    public function itemMakeAttributes(){
        $options = array();
        if ($this->product && $this->sku_id) {
            $skuData = json_decode($this->sku_id, true);
            foreach($skuData as $title => $sku) {
                $hasAttri = $this->product->productVariationAttributeList()->find($sku);
                if ($hasAttri) {
                    $parent = $hasAttri->parent;
                    // $options[$parent->name] = $hasAttri->name; // Use the parent name as key, and attribute name as value
                    $options[] =[
                        'title'=>$parent->name,
                        'value'=>$hasAttri->name,
                    ];
                }
            }
        }
        return $options;
    }
    
    public function returnItems(){
            return $this->hasMany(OrderReturnItem::class,'order_item_id')->where('return_type',true);
        }

    public function seller(){
        return $this->belongsTo(Seller::class);
    }

    public function product(){
        return $this->belongsTo(Post::class,'product_id')->where('type',2);
    }
    
    public function productWeightTotal(){
        
        $unit =$this->product->weight_unit?:'';
        
        $UnitWeight =$this->product->weight_amount?$this->product->weight_amount*$this->quantity:0;
        
        if($UnitWeight >= 1000){

            if($unit=='gram'){
                $unit='Kg';
            }elseif($unit=='ml'){
                $unit='Liter';
            }
            
            $UnitWeight=$UnitWeight/1000;
            
        }
        
        return $UnitWeight.' '.$unit; 
    }


}
