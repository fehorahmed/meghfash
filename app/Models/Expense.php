<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    //Models Information Data
    /********
     * 
     * Column:
     * 
     * id               =bigint(20):None,
     * name             =varchar(250):null,
     * description      =Text:null,
     * amount           =floor(11):null,
     * created_at       =timestamp:null
     * updated_at       =timestamp:null
     * 
     * 
     ****/
    
    public function head(){
        return $this->belongsTo(Attribute::class,'type_id')->where('type',12);
    }
    
    public function user(){
        return $this->belongsTo(User::class,'addedby_id');
    }
    
    public function imageFile(){
    	return $this->hasOne(Media::class,'src_id')->where('src_type',10)->where('use_Of_file',1);
    }
    
    public function transection(){
    	return $this->hasOne(Transaction::class,'src_id')->where('type',4);
    }
    
    public function warehouse(){
        return $this->belongsTo(Attribute::class,'warehouse_id');
    }
    
    
    
}
