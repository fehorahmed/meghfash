<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryStock extends Model
{
    
    public function branch(){
        return $this->belongsTo(Attribute::class,'branch_id');
    }
    
    public function product(){
        return $this->belongsTo(Post::class,'src_id');
    }
    
    public function variant(){
        return $this->belongsTo(PostAttribute::class,'variant_id');
    }
    
    
}
