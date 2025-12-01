@extends('admin.layouts.app') @section('title')
<title>{{websiteTitle('Payment Methods')}}</title>
@endsection @push('css')
<style type="text/css"></style>
@endpush @section('contents')

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Payment Methods</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item active">Payment Methods</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
        
            <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#addMethod">
                New Method
            </button>
            
            <a class="btn btn-outline-primary" href="{{route('admin.paymentMethods')}}">
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
                        <h4 class="card-title">Account Methods</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="min-width: 60px;width: 60px;">SL</th>
                                            <th style="min-width: 200px;width: 200px;">Name</th>
                                            <th style="min-width: 100px;width: 100px;">Statement</th>
                                            <th style="min-width: 250px;">Description</th>
                                            <th style="min-width: 150px;width: 150px;">Type</th>
                                            <th style="min-width: 150px;width: 150px;">Balance</th>
                                            <th style="min-width: 100px;width:100px;">Status</th>
                                            <th style="min-width: 120px;width: 120px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($methods as $i=>$method)
                                        <tr>
                                            <td>
                                                <span>{{$i+1}}</span>
                                            </td>
                                            <td>
                                                {{$method->name}}
                                            </td>
                                            <td>
                                                <a href="{{route('admin.paymentMethods',['manage',$method->id])}}" class="btn btn-sm btn-success">Manage</a>
                                            </td>
                                            <td>
                                                {{$method->description}}
                                            </td>
                                            <td>
                                                @if($method->location=='pos_method')
                                                POS Method
                                                @elseif($method->location=='card_method')
                                                Card Method
                                                @elseif($method->location=='mobile_banking')
                                                Mobile Banking
                                                @else
                                                Cash Method
                                                @endif
                                            </td>
                                            <td>
                                                <span>{{priceFullFormat($method->amounts)}}</span>
                                            </td>
                                            
                                            <td style="padding: 5px;">
                                               {{ucfirst($method->status)}}
                                            </td>
                                            <td class="center">
                                                
                                                <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#updateMethod{{$method->id}}">
                                                   Edit
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade text-left" id="updateMethod{{$method->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                   <div class="modal-dialog" role="document">
                                                     <div class="modal-content">
                                                        <form action="{{route('admin.paymentMethods',['update',$method->id])}}" method="post">
                                                            @csrf
                                                           <div class="modal-header">
                                                             <h4 class="modal-title" id="myModalLabel1">Update Type</h4>
                                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                               <span aria-hidden="true">&times; </span>
                                                             </button>
                                                           </div>
                                                           <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="form-group col-8">
                                                                        <label>Method Name*</label>
                                                                        <input type="text" name="name"  class="form-control" value="{{$method->name}}" placeholder="Enter method name" required="">
                                                                    </div>
                                                                    
                                                                    <div class="form-group col-4">
                                                                        @if($method->id==87) @else
                                                                        <label>Method Type</label>
                                                                        <select class="form-control" name="method_type" >
                                                                            <option value="">Select Type</option>
                                                                            <option value="pos_method" {{$method->location=='pos_method'?'selected':''}} >POS Method</option>
                                                                            <option value="card_method" {{$method->location=='card_method'?'selected':''}} >Card Method</option>
                                                                            <option value="mobile_banking" {{$method->location=='mobile_banking'?'selected':''}} >Mobile Banking</option>
                                                                        </select>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Image</label>
                                                                    <input type="file" name="image" class="form-control">
                                                                </div>
                                                
                                                                <div class="form-group">
                                                                        <label>Description</label>
                                                                        <textarea class="form-control" name="description" placeholder="Write Description">{{$method->description}}</textarea>
                                                                </div>
                                                                <div>
                                                                    <label>Status*</label>
                                                                    <select class="form-control" name="status" required="">
                                                                        <option value="">Select Status</option>
                                                                        <option value="active" {{$method->status=='active'?'selected':''}} >Active</option>
                                                                        <option value="inactive" {{$method->status=='inactive'?'selected':''}}>Inactive</option>
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
                                                @if($method->id==87) @else
                                                <a href="{{route('admin.paymentMethods',['delete',$method->id])}}" class="btn btn-sm btn-danger" onclick="return confirm('Are You Want To Delete?')"><i class="fa fa-trash"></i></a>
                                               @endif
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
    <!-- Basic Inputs end -->
</div>


 <!-- Modal -->
 <div class="modal fade text-left" id="addMethod" >
   <div class="modal-dialog" role="document">
     <div class="modal-content">
        <form action="{{route('admin.paymentMethods','create')}}" method="post" enctype="multipart/form-data">
            @csrf
           <div class="modal-header">
             <h4 class="modal-title">New Method</h4>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times; </span>
             </button>
           </div>
           <div class="modal-body">
                <div class="row">
                    <div class="form-group col-8">
                        <label>Method Name*</label>
                        <input type="text" name="name"  class="form-control" placeholder="Enter method name" required="">
                    </div>
                    <div class="form-group col-4">
                        <label>Method Type</label>
                        <select class="form-control" name="method_type" >
                            <option value="">Select Type</option>
                            <option value="pos_method">POS Method</option>
                            <option value="card_method">Card Method</option>
                            <option value="mobile_banking">Mobile Banking</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" placeholder="Write Description"></textarea>
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
             <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add Method</button>
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
