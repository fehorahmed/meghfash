@extends(general()->adminTheme.'.layouts.app')
@section('title')
<title>{{websiteTitle('Products List')}}</title>
@endsection
@push('css')
<style type="text/css">
    .card .topBorderHeader{
        border-top: 3px solid #3d3196 !important;
    }
</style>
@endpush
@section('contents')

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Products List</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item active">Products List</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            @isset(json_decode(Auth::user()->permission->permission, true)['products']['add'])
            <a class="btn btn-outline-primary" href="{{route('admin.productsAction','create')}}">Add Product</a>
            @endisset
            <a class="btn btn-outline-primary" href="{{route('admin.products')}}">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>


@include('admin.alerts')
<div class="card">
    <div class="card-content">
        <div id="accordion">
                <div
                    class="card-header collapsed"
                    data-toggle="collapse"
                    data-target="#collapseTwo"
                    aria-expanded="false"
                    aria-controls="collapseTwo"
                    id="headingTwo"
                    style="background:#009688;padding: 15px 20px; cursor: pointer;"
                >
                   <i class="fa fa-filter"></i> Search click Here..
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="border: 1px solid #00b5b8; border-top: 0;">
                    <div class="card-body">
                        <form action="{{route('admin.products')}}">
                            <div class="row">
                                <div class="col-md-4 mb-1">
                                    <div class="input-group">
                                        <input type="date" name="startDate" value="{{$r->startDate?Carbon\Carbon::parse($r->startDate)->format('Y-m-d') :''}}" class="form-control {{$errors->has('startDate')?'error':''}}" />
                                        <input type="date" value="{{$r->endDate?Carbon\Carbon::parse($r->endDate)->format('Y-m-d') :''}}" name="endDate" class="form-control {{$errors->has('endDate')?'error':''}}" />
                                    </div>
                                </div>
                                <div class="col-md-3 mb-1">
                                    <select  name="category" class="form-control" >
                                        <option value="" >Select Category</option>
                                        @foreach($categories as $i=>$ctg)
                                        <option value="{{$ctg->id}}" {{$r->category==$ctg->id?'selected':''}} >{{$ctg->name}}</option>
                                        @foreach($ctg->subctgs as $ctg)
                                        <option value="{{$ctg->id}}" {{$r->category==$ctg->id?'selected':''}}> - {{$ctg->name}}</option>
                                        @foreach($ctg->subctgs as $ctg)
                                        <option value="{{$ctg->id}}" {{$r->category==$ctg->id?'selected':''}}> - - {{$ctg->name}}</option>
                                        @endforeach
                                        @endforeach
                                        
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5 mb-1">
                                    <div class="input-group">
                                        <input type="text" name="search" value="{{$r->search?$r->search:''}}" placeholder="Product Name, Barcode" class="form-control {{$errors->has('search')?'error':''}}" />
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
    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
        <h4 class="card-title">Products List</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form action="{{route('admin.products')}}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group mb-1">
                            <select class="form-control form-control-sm rounded-0" name="action" required="">
                                <option value="">Select Action</option>
                                <option value="1">Products Active</option>
                                <option value="2">Products InActive</option>
                                <option value="5">Products Delete</option>
                            </select>
                            <button class="btn btn-sm btn-primary rounded-0" onclick="return confirm('Are You Want To Action?')">Action</button>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <ul class="statuslist">
                            <li><a href="{{route('admin.products')}}">All ({{$totals->total}})</a></li>
                            <li><a href="{{route('admin.products',['status'=>'active'])}}">Active ({{$totals->active}})</a></li>
                            <li><a href="{{route('admin.products',['status'=>'web_view'])}}">For Web ({{$totals->inactiveView}})</a></li>
                            <li><a href="{{route('admin.products',['status'=>'inactive'])}}">Inactive ({{$totals->inactive}})</a></li>
                            <li><a href="{{route('admin.products',['status'=>'new_arrival'])}}">New Arrival ({{$totals->new_arrival}})</a></li>
                            <li><a href="{{route('admin.products',['status'=>'top_sale'])}}">Top Sale ({{$totals->top_sale}})</a></li>
                            <li><a href="{{route('admin.products',['status'=>'tranding'])}}">Tranding ({{$totals->tranding}})</a></li>
                        </ul>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="min-width: 60px;">
                                    <label style="cursor: pointer; margin-bottom: 0;"> <input class="checkbox" type="checkbox" class="form-control" id="checkall" /> All <span class="checkCounter"></span> </label>
                                </th>
                                <th style="min-width: 350px;">Product Name</th>
                                <th style="min-width: 80px;">Image</th>
                                <th style="min-width: 200px;">Catagory</th>
                                <th style="min-width: 80px;">Status</th>
                                <th style="min-width: 160px;width: 160px;">Action/Author</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($products as $i=>$product)
                            <tr>
                                <td>
                                    <input class="checkbox" type="checkbox" name="checkid[]" value="{{$product->id}}" /><br />
                                    {{$products->currentpage()==1?$i+1:$i+($products->perpage()*($products->currentpage() - 1))+1}}
                                    <b>ID:</b> {{$product->id}}
                                </td>
                                <td>
                                    <span><a href="{{route('productView',$product->slug?:'no-slug')}}" target="_blank">{{$product->name}}</a></span>
                                    <br/>
                                    <span style="color: #ccc;"><b style="color: #1ab394;">{{general()->currency}}</b> 
                                    {{priceFormat($product->offerPrice())}}
                                    @if($product->offerPrice() < $product->regular_price)
                                    <del style="color: #FF5722;font-size: 12px;">{{$product->regularPrice()}}</del>
                                    @endif
                                    </span>
                                                
                                    @if($product->brand)
                                    <span style="color: #ccc;"><b style="color: #1ab394;">Brand:</b> {{$product->brand->name}}</span>
                                    @endif

                                    @if($product->fetured==true)
                                    <span><i class="fa fa-star" style="color: #1ab394;"></i></span>
                                    @endif
                                    @if($product->new_arrival==true)
                                    <span ><i class="fa-solid fa-bookmark" style="color: #ff864a;"></i></span>
                                    @endif
                                    
                                    @if($product->import_status==true)
                                    <span ><i class="fas fa-ship" style="color: #ff864a;"></i></span>
                                    @endif
                                    <span style="color: #ccc;"><i class="fa fa-calendar" style="color: #1ab394;"></i> {{$product->created_at->format('d-m-Y')}}</span>
                                    
                                    <b>QTY:</b> {{$product->quantity}}
        
                                </td>
                                <td style="padding: 5px; text-align: center;">
                                    <img src="{{asset($product->image())}}" style="max-width: 70px; max-height: 50px;" />
                                </td>
                                <td>
                                    @foreach($product->productCategories as $i=>$ctg)

                                     {{$i==0?'':'-'}} {{$ctg->name}} 

                                     @endforeach
                                </td>
                                <td>
                                    @if($product->status=='active')
                                    <span class="badge badge-success">Active </span>
                                    @elseif($product->status=='inactive')
                                    <span class="badge badge-danger">Inactive </span>
                                    @else
                                    <span class="badge badge-danger">Draft </span>
                                    @endif 
                                </td>
                                <td style="padding: 5px;">
                                    @isset(json_decode(Auth::user()->permission->permission, true)['products']['add'])
                                    <a href="{{route('admin.productsAction',['edit',$product->id])}}" class="btn btn-sm btn-info">Edit</a>
                                    @endisset
                                    <a href="{{route('admin.productsAction',['view',$product->id])}}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                    @isset(json_decode(Auth::user()->permission->permission, true)['products']['delete'])
                                    <a href="{{route('admin.productsAction',['delete',$product->id])}}" class="btn btn-sm btn-danger" onclick="return confirm('Are You Want To Delete?')"><i class="fa fa-trash"></i></a>
                                    @endisset
                                    
                                    <br />
                                    <span style="color: #ccc;">
                                        <i class="fa fa-user" style="color: #1ab394;"></i>
                                        {{Str::limit($product->user?$product->user->name:'No Author',15)}}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{$products->links('pagination')}}
                </div>
            </form>
        </div>
    </div>
</div>


@endsection @push('js') @endpush
