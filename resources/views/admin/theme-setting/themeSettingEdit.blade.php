@extends(adminTheme().'layouts.app')
@section('title')
<title>{{websiteTitle('Theme Setting')}}</title>
@endsection

@push('css')
<style type="text/css">
	.SearchContain{
	    position:relative;
	}
	.searchResultlist {
	    position: absolute;
	    top: 30px;
	    left:0;
	    width: 100%;
	    z-index:9;
	}
	.searchResultlist ul {
	    border: 1px solid #ccd6e6;
	    padding: 0;
	    margin: 0;
	    list-style: none;
	    background: white;
	}

	.searchResultlist ul li {
	    padding: 2px 10px;
	    cursor: pointer;
	    border-bottom: 1px dotted #dcdee0;
	}
	
	.searchResultlist ul li:last-child {
		border-bottom: 0px dotted #dcdee0;
	}
	
	.ProductGridSection {
        border: 1px solid gray;
        padding: 5px;
        text-align: center;
    }
	
	.ProductGrid {
        min-height: 120px;
    }
    
    .ProductGrid img {
        max-width: 100%;
        max-height: 115px;
    }
	
</style>
@endpush
@section('contents')


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
     <h3 class="content-header-title mb-0">Theme Setting</h3>
     <div class="row breadcrumbs-top">
       <div class="breadcrumb-wrapper col-12">
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a>
           </li>
           <li class="breadcrumb-item active">Theme Setting</li>
         </ol>
       </div>
     </div>
   </div>
   <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
     <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
         <a class="btn btn-outline-primary" href="{{route('admin.themeSetting')}}">Back</a>
       	<a class="btn btn-outline-primary" href="{{route('admin.themeSettingAction',['edit',$homedata->id])}}">
       		<i class="fa-solid fa-rotate"></i>
       	</a>
     </div>
   </div>
</div>
 
	


 @include(adminTheme().'alerts')
 
 
 <form action="{{route('admin.themeSettingAction',['update',$homedata->id])}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                    <h4 class="card-title">theme Setting</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title(*) </label>
                            <input type="text" class="form-control {{$errors->has('title')?'error':''}}" name="title" placeholder="Enter Title" value="{{$homedata->name?:old('title')}}" required="" />
                            @if ($errors->has('title'))
                            <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('title') }}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="sub_title">Sub Title </label>
                            <input type="text" class="form-control {{$errors->has('name')?'error':''}}" name="sub_title" placeholder="Enter Sub Title" value="{{$homedata->sub_title?:old('sub_title')}}" />
                            @if ($errors->has('sub_title'))
                            <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('sub_title') }}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control {{$errors->has('description')?'error':''}}" name="description" placeholder="Enter Description" value="{{$homedata->description?:old('description')}}" />
                            @if ($errors->has('description'))
                            <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('description') }}</p>
                            @endif
                        </div>
                        <!--<div class="form-group">-->
                        <!--    <label for="data_type">Data Type (*)</label>-->
                        <!--    <select class="form-control" name="data_type" required="">-->
                        <!--         <option value="">Select Type</option>-->
                        <!--         <option value="Banner Ads Group One" {{$homedata->data_type=='Banner Ads Group One'?'selected':''}}>Banner Ads Group One</option>-->
                        <!--         <option value="Time Offer Banner" {{$homedata->data_type=='Time Offer Banner'?'selected':''}}>Time Offer Banner</option>-->
                        <!--     </select>-->
                        <!--    @if ($errors->has('data_type'))-->
                        <!--    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('data_type') }}</p>-->
                        <!--    @endif-->
                        <!--</div>-->
                        <div class="row">
                            
                            <!--<div class="form-group col-md-8">-->
                            <!--    <label for="category_id">Category List</label>-->
                            <!--    <select class="form-control" name="category_id">-->
                            <!--         <option value="">Select Type</option>-->
                            <!--         @foreach($categories as $ctg)-->
                            <!--         <option value="{{$ctg->id}}" {{$homedata->category_id==$ctg->id?'selected':''}}>{{$ctg->name}}</option>-->
                            <!--         @endforeach-->
                            <!--     </select>-->
                            <!--    @if ($errors->has('category_id'))-->
                            <!--    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('category_id') }}</p>-->
                            <!--    @endif-->
                            <!--</div>-->
                            
                        </div>
                        <div class="row">
                            @if($homedata->data_type=='Time Offer Banner')
                            <div class="form-group col-md-4">
                                <label for="data_limit">Day Limit (*)</label>
                                <input type="number" class="form-control {{$errors->has('data_limit')?'error':''}}" name="data_limit" placeholder="Enter Data Limit" value="{{$homedata->data_limit?:old('data_limit')}}" required="" />
                                @if ($errors->has('data_limit'))
                                <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('data_limit') }}</p>
                                @endif
                            </div>
                            @endif
                            <div class="form-group col-md-4">
                                <label for="status"> Status</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="status" name="status" {{$homedata->status=='active'?'checked':''}}/>
                                    <label class="custom-control-label" for="status">Active</label>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Published Date</label>
                                <input type="date" class="form-control form-control-sm" name="created_at" value="{{$homedata->created_at->format('Y-m-d')}}">
                                @if ($errors->has('created_at'))
                                <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('created_at') }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save changes</button>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                    <h4 class="card-title">Images</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" class="form-control {{$errors->has('image')?'error':''}}" />
                            @if ($errors->has('image'))
                            <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('image') }}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <img src="{{asset($homedata->image())}}" style="max-width: 100px;" />
                            @if($homedata->imageFile)
                            <a href="{{route('admin.mediesDelete',$homedata->imageFile->id)}}" class="mediaDelete" style="color: red;"><i class="fa fa-trash"></i></a>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="image_link">Image/Button Link</label>
                            <input type="text" class="form-control {{$errors->has('image_link')?'error':''}}" name="image_link" placeholder="Enter Image Link" value="{{$homedata->image_link?:old('image_link')}}" />
                            @if ($errors->has('image_link'))
                            <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('image_link') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>



@endsection
@push('js')


<script>
    $(document).ready(function(){
        
        $(".searchResultlist").hide();

    	$(document).on('click', function(e) {
    
    	    var container = $(".SearchContain");
    	    var containerClose = $(".searchResultlist");
    	    
    	    if (!$(e.target).closest(container).length) {
    	        containerClose.hide();
    	    }else{
    	    	containerClose.show();
    	    }
    
    	});
        
        
        var url ="{{route('admin.themeSettingAction',['edit',$homedata->id])}}";
        var key;
        var type;
        
        $(document).on('keyup','.serchProducts',function(){
            type ='search';
    		key =$(this).val();

    		$.ajax({
              url:url,
              dataType: 'json',
              cache: false,
              data: {'key':key,'type':type},
               success : function(data){
    
                $('.searchResultlist').empty().append(data.view);
    
               },error: function () {
                 // alert('error');
    
                }
            });
    
    	});
    	
    	$(document).on('click','.searchResultlist ul li',function(){
    		id =$(this).data('id');
    		type =$(this).data('type');
    		
    		$(".searchResultlist").hide();
    		
    		$.ajax({
              url:url,
              dataType: 'json',
              cache: false,
              data: {'key':key,'id':id,'type':type},
               success : function(data){
    
                $('.HomeProducts').empty().append(data.view);
    
               },error: function () {
                 // alert('error');
    
                }
            });
    		
    		
    	});
    	
        
    });
</script>

@endpush