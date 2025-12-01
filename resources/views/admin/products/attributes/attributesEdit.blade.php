@extends(general()->adminTheme.'.layouts.app')
@section('title')
<title>{{websiteTitle('Attribute Edit')}}</title>
@endsection
@push('css')
<style type="text/css">

</style>
@endpush
@section('contents')


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
     <h3 class="content-header-title mb-0">Attribute Edit</h3>
     <div class="row breadcrumbs-top">
       <div class="breadcrumb-wrapper col-12">
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a>
           </li>
           <li class="breadcrumb-item active">Attribute Edit</li>
         </ol>
       </div>
     </div>
   </div>
   <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
     <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
       	<a class="btn btn-outline-primary" href="{{route('admin.productsAttributes')}}">BACK</a>
       	<a class="btn btn-outline-primary" href="{{route('admin.productsAttributesAction',['edit',$attribute->id])}}">
       		<i class="fa-solid fa-rotate"></i>
       	</a>
     </div>
   </div>
</div>
 
	

 <div class="content-body">
 	<!-- Basic Elements start -->
	 <section class="basic-elements">
	 	@include('admin.alerts')
	    
	     <div class="row">
	        <div class="col-md-4">
	         	<form action="{{route('admin.productsAttributesAction',['update',$attribute->id])}}" method="post" enctype="multipart/form-data">
	    		@csrf
	            <div class="card">
	             	<div class="card-header " style="border-bottom: 1px solid #e3ebf3;">
					 	<h4 class="card-title">Attribute Edit</h4>
				 	</div>
	                 <div class="card-content">
	                     <div class="card-body">
                        	<div class="form-group">
		                     	<label for="name">Attribute Name(*) </label>
		                     	<input type="text" class="form-control {{$errors->has('name')?'error':''}}" name="name" placeholder="Enter Attribute Name" value="{{$attribute->name?:old('name')}}" required="" />
		                    	@if ($errors->has('name'))
		                    	<p style="color: red;margin: 0;font-size: 10px;">{{ $errors->first('name') }}</p>
		                    	@endif
		             		</div>
		             		<div class="form-group">
							<label for="description">Description </label>
							<textarea name="description" class="form-control {{$errors->has('description')?'error':''}}" placeholder="Enter Description">{!!$attribute->description!!}</textarea>
							@if ($errors->has('description'))
							<p style="color: red;margin: 0;font-size: 10px;">{{ $errors->first('description') }}</p>
							@endif
		             		</div>
		             		<div class="form-group">
		             			<label>Attribute Type <small>(How to show Attribute)</small></label>
		             			<select class="form-control" name="type">
		             				<option value="1" {{$attribute->view==1?'selected':''}} >Text</option>
		             				<option value="2" {{$attribute->view==2?'selected':''}} >Color</option>
		             				<option value="3" {{$attribute->view==3?'selected':''}} >Image</option>
		             				
		             			</select>
		             		</div>
		             		<div class="row">
    		             		<div class="form-group col-6">
                        			<label for="status">Status</label>
    				               	<div class="custom-control custom-checkbox">
    				                 <input type="checkbox" class="custom-control-input" id="status" name="status"  {{$attribute->status=='active'?'checked':''}}/>
    				                 <label class="custom-control-label" for="status">Active</label>
    				               </div>
    	                        </div> 
    		             		<div class="form-group col-6">
                        			<label for="status">Variation Status</label>
    				               	<div class="custom-control custom-checkbox">
    				                 <input type="checkbox" class="custom-control-input" id="featered" name="fetured"  {{$attribute->fetured?'checked':''}}/>
    				                 <label class="custom-control-label" for="featered">Active</label>
    				               </div>
    	                        </div> 
	                            <div class="form-group col-12">
	                                <label for="status">Date</label>
	                                <input type="date" class="form-control" name="created_at" value="{{$attribute->created_at->format('Y-m-d')}}" />
	                            </div>
		             		</div>
	                       
	                        <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
		                                  changes </button>

		                 </div>
		             </div>
		         	</div>
		         	</form>
				</div>


				<div class="col-md-8">
	         		
		            <div class="card">
		             	<div class="card-header " style="border-bottom: 1px solid #e3ebf3;">
						 	<h4 class="card-title">Attribute Items</h4>
					 	</div>
		                 <div class="card-content">
		                     <div class="card-body">
		                     	<div class="row">
		                     		<div class="col-md-4">
		                     		<a href="{{route('admin.productsAttributesItemAction',['create',$attribute->id])}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Item</a>
    		                     		<!--<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#AddItem">-->
                             <!--              <i class="fa fa-plus"></i> Add Item-->
                             <!--           </button>-->
		                     		</div>
		                     		<div class="col-md-8">
		                     			<form action="{{route('admin.productsAttributesAction',['edit',$attribute->id])}}">
    		                     			<div class="input-group">
    			                         		<input type="text" name="search" value="{{$r->search?$r->search:''}}" placeholder="Attribute Item Name" class="form-control {{$errors->has('search')?'error':''}}">
    			                         		<button type="submit" class="btn btn-success rounded-0">Search</button>
    			                 			</div>
			                 			</form>
		                     		</div>
		                     	</div>
		                     	<hr>
		                     	<form action="{{route('admin.productsAttributesAction',['items-delete',$attribute->id])}}">
	                     		<div class="row">
	                     			<div class="col-md-4">
	                     				<div class="input-group mb-1">
	                     					<select class="form-control form-control-sm rounded-0" name="action" required="">
	                     						<option value="">Select Action</option>
	                     						<option value="5">Attributes Delete</option>
	                     					</select>
	                     					<button class="btn btn-sm btn-primary rounded-0" onclick="return confirm('Are You Want To Action?')">Action</button>
	                     				</div>
	                     			</div>
	                     		</div>
		                     	<div class="table-responsive">
    		                     	<table class="table table-striped table-bordered table-hover" >
    								    <thead>
    								        <tr>
    								            <th style="min-width: 60px;">
    								                <label style="cursor: pointer;margin-bottom: 0;">
    					                                <input class="checkbox" type="checkbox" class="form-control" id="checkall">  All <span class="checkCounter"></span>
    					                            </label>
    					                        </th>
    								            <th>Attributes Name</th>
    								            <th width="25%">Action</th>
    								        </tr>
    								    </thead>
    								    <tbody>
    								        @foreach($items as $i=>$item)
    								        <tr>
    								            <td>
    								            <input class="checkbox" type="checkbox" name="checkid[]" value="{{$item->id}}">
    								            {{$i+1}}
    								            </td>
    								            <td>
    								            <span>
    								                <a href="" target="_blank">{{$item->name}}</a></span>
    								              @if($item->parent)
    								              @if($item->parent->view==2)
    								            	<span style="background:{{$item->icon?:'black'}};height: 10px;width: 50px;display: inline-block;"></span>
    								            	@elseif($item->parent->view==3)
    								            	<img src="{{asset($item->parent->image())}}" style="max-width:50px;">
    								            	@else
    								            	@endif 
    								            	@endif 
    								               
    								            </td>
    								            <td class="center">
    								            <a href="{{route('admin.productsAttributesItemAction',['edit',$item->id])}}" class="btn btn-sm btn-info">Edit</a>  
    								            </td>
    								        </tr>
    								        @endforeach
    								    </tbody>
    								</table>
    								{{$items->links('pagination')}}
		                    	 </div>
		                    </form>
		                     </div>
		                 </div>
		             </div>
		         </div>
		    </div>
	 </section>
	 <!-- Basic Inputs end -->
</div>

<!-- Modal -->
<div class="modal fade text-left" id="AddItem" tabindex="-1" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('admin.productsAttributesItemAction',['create',$attribute->id])}}" method="post">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel1">Add Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                     	<label for="name">Item Name(*) </label>
                     	<input type="text" class="form-control {{$errors->has('name')?'error':''}}" name="name" placeholder="Enter Item Name" value="{{old('name')}}" required="" />
                    	@if ($errors->has('name'))
                    	<p style="color: red;margin: 0;font-size: 10px;">{{ $errors->first('name') }}</p>
                    	@endif
             		</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add Item</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
@push('js')


@endpush