<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PostAttributeVariation extends Model
{
    
    public function variationItem(){
        return $this->belongsTo(PostAttribute::class,'src_id');
    }
    
    public function variationItemCheck($proId,$variID){
        $id =null;
        $item =PostAttributeVariation::where('product_id',$proId)->where('attribute_id',$variID)->where('attribute_item_id',$this->attribute_item_id)->first();
        if($item){
           $id =$item->src_id;
        }
        return $id;
    }
    
    public function variationItemImage($proId){
        if($hasImage =PostAttribute::where('src_id',$proId)->where('reff_id',68)->where('parent_id',$this->attribute_item_id)->first()){
            if($hasImage){
             return $hasImage->variationImage();   
            }
        }
        return null;
    }
    
    public function attributeItem(){
        return $this->belongsTo(Attribute::class,'attribute_item_id');
    }
    
    public function attribute(){
        return $this->belongsTo(Attribute::class,'attribute_id');
    }
    
    public function attributeItemValue(){
        $value ='unknown';
        if($this->attributeItem && $this->attributeItem->parent){
            $parent =$this->attributeItem->parent;
            if($parent->view==2){
        	$value = $this->value_1 ?: $this->attributeItem->icon ?: 'black';
        	}elseif($parent->view==3){
        	$value =asset($this->imageFile?$this->image():$this->attributeItem->image());
        	}else{
        	$value =$this->attributeItem->name;
            }
        }
        return $value;
    }
    
    public function attributeItemName(){
        $value ='unknown';
        if($this->attributeItem && $this->attributeItem->parent){
        	$value =$this->attributeItem->name;
        }
        return $value;
    }
    
    
    
    
    
    
    
}