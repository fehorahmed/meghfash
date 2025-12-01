@extends(general()->adminTheme.'.layouts.app')
@section('title')
<title>{{websiteTitle('Attributes List')}}</title>
@endsection
@push('css')
<style type="text/css">

</style>
@endpush
@section('contents')

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
         <h3 class="content-header-title mb-0">Attributes List</h3>
         <div class="row breadcrumbs-top">
           <div class="breadcrumb-wrapper col-12">
             <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a>
               </li>
               <li class="breadcrumb-item active">Attributes List</li>
             </ol>
           </div>
         </div>
       </div>
       <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
         <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
           	<a class="btn btn-outline-primary" href="{{route('admin.productsAttributesAction','create')}}">Add Attribute</a>
           	<a class="btn btn-outline-primary reloadPage1" href="{{route('admin.productsAttributes')}}">
           		<i class="fa-solid fa-rotate"></i>
           	</a>
         </div>
       </div>
    </div>
	

 	@include('admin.alerts')
 	<div class="card">
 		<div class="card-content">
 			 <div id="accordion">
			    <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" id="headingTwo" style="background:#009688;padding: 15px 20px; cursor: pointer;">
			       <i class="fa fa-filter"></i>   Search click Here..
			    </div>
			    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="border: 1px solid #00b5b8;border-top: 0;">
			      <div class="card-body">
		       		<form action="{{route('admin.productsAttributes')}}">
			       		<div class="row">
			       			<div class="col-md-12 mb-0">
			       				<div class="input-group">
                             		<input type="text" name="search" value="{{request()->search?request()->search:''}}" placeholder="Attribute Name" class="form-control {{$errors->has('search')?'error':''}}">
                             		<button type="submit" class="btn btn-success rounded-0"><i class="fa fa-search"></i> Search</button>
                 				</div>
			       			</div>
			       		</div>
				    </form>
			      </div>
			    </div>
			</div>
 		</div>
 	</div>

 <div class="card">
 	<div class="card-header " style="border-bottom: 1px solid #e3ebf3;">
	 	<h4 class="card-title">Attributes List</h4>
 	</div>
     <div class="card-content">
         <div class="card-body">
             <div class="table-responsive">

             	<table class="table table-striped table-bordered table-hover" >
				    <thead>
				        <tr>
				            <th style="min-width: 60px;">SL</th>
				            <th style="min-width: 200px;">Attributes Name</th>
				            <th style="min-width: 250px;">Items</th>
				            <th style="min-width: 180px;width: 180px;">Action</th>
				        </tr>
				    </thead>
				    <tbody>
				        @foreach($attributes as $i=>$attribute)
				        <tr>
				            <td>
				            {{$i+1}}
				            </td>
				            <td>
				                <span>
				                {{$attribute->name}}
				                @if($attribute->view==2)
				            	<small style="color:#a3a3a3;">(Color)</small>
				            	@elseif($attribute->view==3)
				            	<small style="color:#a3a3a3;">(Image)</small>
				            	@else
				            	<small style="color:#a3a3a3;">(Text)</small>
				            	@endif 
				                </span><br>

				               @if($attribute->status=='active')
				               <span><i class="fa fa-check" style="color: #1ab394;"></i></span>
				               @else
				               <span><i class="fa fa-times" style="color: #ed5565;"></i></span>
				               @endif
				               
				               @if($attribute->fetured)
				               <span><i class="fa fa-star" style="color: #ff864a;"></i></span>
				               @endif

				                <span style="font-size: 10px;"><i class="fa fa-calendar" style="color: #1ab394;"></i>
				                {{$attribute->created_at->format('d-m-Y')}}
				              </span>
				            </td>
				            <td>
				            	@foreach($attribute->subAttributes as $item)
				            	<span style="padding: 3px 10px;border: 1px solid #e5e5e5;border-radius: 5px;display: inline-block;margin-bottom: 5px;">{{$item->name}}
				            	@if($item->parent->view==2)
				            	<span style="background:{{$item->icon?:'black'}};height: 10px;width: 20px;display: inline-block;"></span>
				            	@elseif($item->parent->view==3)
				            	<img src="{{asset($item->parent->image())}}" style="max-width:50px;max-height: 20px;">
				            	@endif
				            	</span>
				            	@endforeach
				            </td>
				            <td class="center">
				            <a href="{{route('admin.productsAttributesAction',['edit',$attribute->id])}}" class="btn btn-md btn-info">Config</a>
				            @if($attribute->id==68 || $attribute->id==73) @else
				                <a href="{{route('admin.productsAttributesAction',['delete',$attribute->id])}}" class="btn btn-sm btn-danger" onclick="return confirm('Are You Want To Delete?')">Delete</a>
				            @endif
				            </td>
				        </tr>
				        @endforeach
				    </tbody>
				</table>
				{{$attributes->links('pagination')}}
                
             </div>

         </div>
     </div>
 </div>



@endsection
@push('js')

@endpush