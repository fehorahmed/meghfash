<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostExtra extends Model
{
    
    //Models Information Data
    /********
     * 
     * type ==0 : Page
     * 
     * ------------------------
     *  Status==
     * ------------------------
     * 
     * Column:
     * 
     * id            =bigint(20):None,
     * src_id        =bigint(20):null,
     * name          =varchar(191):null,
     * content       =text:null,
     * parent_id     =bigint(20):null,
     * drag          =int(5):0
     * type          =int(1):0
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
     
    public function imageFile(){
    	return $this->hasOne(Media::class,'src_id')->where('src_type',9)->where('use_Of_file',1);
    }

    public function image(){
        if($this->imageFile){
            return $this->imageFile->file_url;
        }else{
            return 'medies/noimage.jpg';
        }
    }
    
    public function bannerFile(){
        return $this->hasOne(Media::class,'src_id')->where('src_type',9)->where('use_Of_file',2);
    }

    public function banner(){
        if($this->bannerFile){
            return $this->bannerFile->file_url;
        }else{
            return 'medies/noimage.jpg';
        }
    }
     
    public function zoneLists(){
         return $this->hasMany(PostExtra::class,'parent_id')->where('type',3);
     }
     
     public function zoneId(){
         return $this->belongsTo(Country::class,'src_id');
     }
     
     public function category(){
         return $this->belongsTo(Attribute::class,'category_id');
     }
     
     public function parentId(){
         return $this->belongsTo(PostExtra::class,'parent_id');
     }
     
     public function product(){
         return $this->belongsTo(Post::class,'src_id');
     }
     
     
     public function products(){
         
         $products = Post::where('type',2)->where('status','active')
                    ->whereHas('postDatas',function($q) { 
                            $q->where('parent_id',$this->id);
                    })->limit($this->data_limit)->get();
         
         if($this->data_type=='Category Product Group One' || $this->data_type=='Category Product Group Two' && $this->data_limit){
             

                $products = Post::where('type',2)->where('status','active');
                
                $products =$products->latest()->whereHas('ctgProducts',function($q){
                            $q->where('reff_id',$this->category_id);
                          });
             $products =$products->limit($this->data_limit)->get();
         
         }
         
         return $products;
     }
     
     public function homeDataIds(){
         return $this->hasMany(PostExtra::class,'parent_id')->where('type',4);
     }
     
     

}
