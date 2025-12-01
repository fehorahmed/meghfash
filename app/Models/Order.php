<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public function cancelItems()
    {
        return $this->hasMany(OrderReturnItem::class,'order_id')->where('return_type',false);
    }
    
    public function returnItems()
    {
        return $items =$this->parentOrder?$this->parentOrder->items:null;
    }
    
    public function parentOrder()
    {
        return $this->belongsTo(Order::class,'parent_id');
    }
    
    public function returnOrder()
    {
        return $this->hasOne(Order::class,'parent_id');
    }
    
    public function branch(){
        return $this->belongsTo(Attribute::class,'branch_id')->where('type',5);
    }
    
    public function formBranch(){
        return $this->belongsTo(Attribute::class,'user_id')->where('type',5);
    }
    
    public function getDescription(){
        $text = '';
        $itemNumber = 1;
        
        foreach ($this->items as $ii => $item) {
            $text .= $ii == 0 ? $itemNumber . '. ' . $item->product_name : ', ' . $itemNumber . '. ' . $item->product_name;
            
            if (count($item->itemAttributes()) > 0) {
                foreach ($item->itemAttributes() as $i => $attri) {
                    if (isset($attri['title']) && isset($attri['value'])) {
                        $text .= $i == 0 ? ' - ' . $attri['title'] . ':' . $attri['value'] : ', ' . $attri['title'] . ':' . $attri['value'];
                    }
                }
            }
            $itemNumber++;
        }
        return $text;
    }
    
    public function TotalGramUnit(){
        $gram =0;
        $un='';
        foreach($this->items as $item){
            if($item->product){
                if($item->product->weight_unit=='gram'){
                    $gram+=  $item->quantity*$item->product->weight_amount;   
                }
            }
        }
        return $gram;
    }
    
    public function TotalLiterUnit(){
        $ml =0;
        foreach($this->items as $item){
            if($item->product){
               if($item->product->weight_unit=='ml'){
                   $ml+=$item->product->weight_amount?$item->product->weight_amount*$item->quantity:0;
               }
            }
            
        }
        
        return $ml;
    }
    
    public function discountAmount(){
        $amount =0;
        $totalAmount =0;
        foreach($this->items as $item){
            $totalAmount +=$item->regular_price*$item->quantity;
        }
        
        if($this->discount_type=='flat'){
            if($this->discount > $totalAmount){
                $amount =$totalAmount; //$this->total_price;
            }else{
                $amount =$this->discount;
            }
        }else{
            if($this->discount > 100){
                $amount =$totalAmount;
            }else{
                $amount =$totalAmount*$this->discount/100;
            }
        }
        return $amount;
    }
    
    
    public function itemDiscountAmount(){
        $amount =0;
        foreach($this->items as $item){
          $amount +=$item->regular_price-($item->regular_price*$this->discount/100);
        }
        return $amount;
    }
    
    public function taxAmount(){
        $amount =0;
        foreach($this->items as $item){
          $amount +=$item->tax_amount;
        }
        return $amount;
    }
    
    public function taxTotalAmount(){
        $amount =0;
        foreach($this->items as $item){
          $amount +=($item->regular_price*$item->tax/100)+$item->quantity;
        }
        return $amount;
    }
    
    public function totalRegularPrice(){
        $amount =0;
        foreach($this->items as $item){
        //   $amount +=($item->regular_price*$item->quantity);
          $amount +=($item->regular_price+($item->regular_price*$item->tax/100))*$item->quantity;
        }
        return $amount;
    }
    
    public function totalExchangeAmount(){
        $amount =0;
        if($this->returnItems()){
            
        foreach($this->returnItems() as $item){
          $amount +=$item->return_total;
        }
        }
        return $amount;
    }
    
    public function isStockUsed(){
        $status =false;
        foreach($this->items as $item){
            if($product =$item->product){
                if($item->variant_id){
                    if($variant =$item->productVariant){
                        if($item->quantity > $variant->quantity){
                            if($status==false){
                            $status =true;
                            }
                        }
                    }
                }else{
                    if($item->quantity > $product->quantity){
                        if($status==false){
                            $status =true;
                        }
                    }
                }
            }
        }
        return $status;
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function posByuser(){
        return $this->belongsTo(User::class,'pending_by');
    }

    public function soldBy(){
        return $this->belongsTo(User::class,'addedby_id');
    }

    public function customerDelivery(){
        return $this->belongsTo(User::class,'order_delivery_By');
    }
    
    public function transections()
    {
        return $this->hasMany(Transaction::class,'src_id')->whereIn('type',[0,1,3,8])->where('status','<>','temp');
    }
    
    public function transactionsAll()
    {
        return $this->hasMany(Transaction::class,'src_id')->whereIn('type',[0,3,2])->where('status','<>','temp');
    }

    public function transectionsTemp()
    {
        return $this->hasMany(Transaction::class,'src_id')->whereIn('type',[0,3])->where('type',3)->where('status','temp');
    }

    public function transactionsSuccess()
    {
        return $this->hasMany(Transaction::class,'src_id')->whereIn('type',[0,3])->where('status','success');
    }
    
    public function transactionsRefund()
    {
        return $this->hasMany(Transaction::class,'src_id')->whereIn('type',[2])->where('status','success');
    }

    
    public function returnTransections()
    {
        return $this->hasMany(Transaction::class,'order_id')->where('type',2);
    }
    
    public function countryN(){
        return $this->belongsTo(Country::class,'country');
    }
    
    public function divitionN(){
        return $this->belongsTo(Country::class,'division');
    }

    public function districtN(){
        return $this->belongsTo(Country::class,'district');
    }
    
    
    public function cityN(){
        return $this->belongsTo(Country::class,'city');
    }


    public function fullAddress(){
        
        $addr ='';
        if($this->address){
            $addr .=$this->address;  
        }
        
        if($this->cityN){
           $addr .=', '.$this->cityN->name;
        }
        if($this->districtN){
            $addr .=', '.$this->districtN->name;
         }
        if($this->postal_code){
            $addr .=' - '.$this->postal_code;
         }

        return $addr;
        
    }
    


}
