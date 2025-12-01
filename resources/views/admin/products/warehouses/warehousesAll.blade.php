@extends('admin.layouts.app') @section('title')
<title>{{websiteTitle('Store/Branch')}}</title>
@endsection @push('css')
<style type="text/css"></style>
@endpush @section('contents')

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Store/Branch</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item active">Store/Branch</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
        
            <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#addWarehouse">
                New Store
            </button>
            
            <a class="btn btn-outline-primary" href="{{route('admin.productsWarehouses')}}">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>

<div class="content-body">
    <!-- Basic Elements start -->
    <section class="basic-elements">
        <div class="row">
            <div class="col-md-12">
                @include('admin.alerts')

                <div class="card">
                    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                        <h4 class="card-title">Store/Branch</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="min-width: 60px;width: 60px;">SL</th>
                                            <th style="min-width: 200px;width: 200px;">Name</th>
                                            <th style="min-width: 250px;">Address</th>
                                            <th style="min-width: 100px;width:100px;">Status</th>
                                            <th style="min-width: 120px;width: 120px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($warehouses as $i=>$warehouse)
                                        <tr>
                                            <td>
                                                <span>{{$i+1}}</span>
                                            </td>
                                            <td>
                                                {{$warehouse->name}}
                                            </td>
                                            <td>
                                                {{$warehouse->description}}
                                            </td>
                                            <td style="padding: 5px;">
                                               {{ucfirst($warehouse->status)}}
                                            </td>
                                            <td class="center">

                                                <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#updateWarehouse{{$warehouse->id}}">
                                                   Edit
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade text-left" id="updateWarehouse{{$warehouse->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                   <div class="modal-dialog" role="document">
                                                     <div class="modal-content">
                                                        <form action="{{route('admin.productsWarehousesAction',['update',$warehouse->id])}}" method="post">
                                                            @csrf
                                                           <div class="modal-header">
                                                             <h4 class="modal-title" id="myModalLabel1">Update Type</h4>
                                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                               <span aria-hidden="true">&times; </span>
                                                             </button>
                                                           </div>
                                                           <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Store Name*</label>
                                                                    <input type="text" name="name"  class="form-control" value="{{$warehouse->name}}" placeholder="Enter Store name" required="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Image</label>
                                                                    <input type="file" name="image" class="form-control">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Address</label>
                                                                    <textarea class="form-control" name="address" placeholder="Write Address">{{$warehouse->description}}</textarea>
                                                                </div>
                                                                <div>
                                                                    <label>Status*</label>
                                                                    <select class="form-control" name="status" required="">
                                                                        <option value="">Select Status</option>
                                                                        <option value="active" {{$warehouse->status=='active'?'selected':''}} >Active</option>
                                                                        <option value="inactive" {{$warehouse->status=='inactive'?'selected':''}}>Inactive</option>
                                                                    </select>
                                                                </div>
                                                           </div>
                                                            <div class="modal-footer">
                                                             <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close </button>
                                                             <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Update</button>
                                                            </div>
                                                       </form>
                                                     </div>
                                                   </div>
                                                </div>

                                                <a href="{{route('admin.productsWarehousesAction',['delete',$warehouse->id])}}" class="btn btn-sm btn-danger" onclick="return confirm('Are You Want To Delete?')"><i class="fa fa-trash"></i></a>
                                               
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


 <!-- Modal -->
 <div class="modal fade text-left" id="addWarehouse" >
   <div class="modal-dialog" role="document">
     <div class="modal-content">
        <form action="{{route('admin.productsWarehousesAction','create')}}" method="post" enctype="multipart/form-data">
            @csrf
           <div class="modal-header">
             <h4 class="modal-title">New Store</h4>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times; </span>
             </button>
           </div>
           <div class="modal-body">
                <div class="form-group">
                    <label>Name*</label>
                    <input type="text" name="name"  class="form-control" placeholder="Enter method name" required="">
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea class="form-control" name="address" placeholder="Write address"></textarea>
                </div>
                <div>
                    <label>Status*</label>
                    <select class="form-control" name="status" required="">
                        <option value="">Select Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
           </div>
           <div class="modal-footer">
             <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close </button>
             <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add Warehouse</button>
           </div>
       </form>
     </div>
   </div>
</div>

@endsection 

@push('js') 
<script type="text/javascript">

</script>
@endpush