@extends(adminTheme().'layouts.app') 
@section('title')
<title>{{websiteTitle('Product Lavel Print')}}</title>
@endsection 
@push('css')

@endpush 
@section('contents')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Product Lavel Print</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item active">Product Lavel Print</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="{{route('admin.productsLabelPrint')}}">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>

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
                    <form action="{{route('admin.productsLabelPrint')}}">
                         <div class="row">
                            <div class="col-md-4 mb-1">
                                <select name="category" class="form-control">
                                    <option value="">All Category</option>
                                    @foreach($categories as $ctg)
                                    <option value="{{$ctg->id}}" {{request()->category==$ctg->id?'selected':''}} >{{$ctg->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-8 mb-1">
                                <div class="input-group">
                                    <input type="text" name="search" value="{{request()->search}}" placeholder="Search Product name , Barcode" class="form-control" />
                                    <button type="submit" class="btn btn-success rounded-0">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
                        <h4 class="card-title">Product Barcode List</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="min-width: 130px;">Product</th>
                                                <th style="min-width: 120px;width:200px;">Category</th>
                                                <th style="min-width: 120px;width:120px;">Barcode</th>
                                                <th style="min-width: 80px;width: 80px;">Image</th>
                                                <th style="min-width: 120px;width:120px;padding:1px;">
                                                    <a href="{{route('admin.productsLabelPrint',['preview'=>'view'])}}" class="btn btn-info"><i class="fa fa-barcode" style=""></i> Print Barcode  </a>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($products as $i=>$product)
                                                @if($product->variation_status)
                                                    @foreach($product->productVariationActiveAttributeItems as $item)
                                                    <tr>
                                                        <td>{{$product->name}}<br> {!!$item->variationItemValues()!!}
                                                            <a href="{{route('admin.productsAction',['edit',$product->id])}}" target="_blank"><i class="fa fa-edit"></i></a>
                                                            <b>Qty:</b> {{$item->quantity}}
                                                        </td>
                                                        <td>
                                                            @foreach($product->productCategories as $i=>$ctg)

                                                             {{$i==0?'':'-'}} {{$ctg->name}} 
                        
                                                             @endforeach
                                                        </td>
                                                        <td>
                                                            {{$item->barcode}} <br>
                                                            <small>{{priceFullFormat($item->final_price)}}</small>
                                                        </td>
                                                        <td>
                                                            <img src="{{asset($item->variationImage())}}" style="max-width: 70px; max-height: 50px;" />
                                                        </td>
                                                        <td>
                                                             <span class="btn btn-sm btn-danger printAdd" data-url="{{route('admin.productsLabelPrint',['product_id'=>$product->id,'variant_id'=>$item->id,'actiontype'=>1])}}">Add Print</span>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td>{{$product->name}}<br>
                                                        <a href="{{route('admin.productsAction',['edit',$product->id])}}" target="_blank"><i class="fa fa-edit"></i></a>
                                                        <b>Qty:</b> {{$product->quantity}}
                                                        </td>
                                                        <td>
                                                            @foreach($product->productCategories as $i=>$ctg)

                                                             {{$i==0?'':'-'}} {{$ctg->name}} 
                        
                                                             @endforeach
                                                        </td>
                                                        <td>
                                                            {{$product->bar_code}}<br>
                                                            <small>{{priceFullFormat($product->final_price)}}</small>
                                                            <!--<a href="{{route('admin.productsAction',['barcode',$product->id])}}" target="_blank" style="color: #ff864a;"><i class="fa fa-barcode"></i> </a>-->
                                                        </td>
                                                        <td>
                                                            <img src="{{asset($product->image())}}" style="max-width: 70px; max-height: 50px;" />
                                                        </td>
                                                        <td>
                                                            <span class="btn btn-sm btn-danger printAdd" data-url="{{route('admin.productsLabelPrint',['product_id'=>$product->id,'variant_id'=>null,'actiontype'=>1])}}">Add Print</span>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            {{$products->links('pagination')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



@endsection 
@push('js')
<script>

    $(document).ready(function() {
        $(document).on('click', '.printAdd', function() {
            var $btn = $(this); // store reference to the clicked button
            var url = $btn.data('url');
    
            // Add spinning icon
            $btn.html('<i class="fas fa-sync fa-spin"></i>');
    
            $.ajax({
                url: url,
                dataType: 'json',
                cache: false,
                success: function(data) {
                    $btn.html('Added');
                },
                error: function() {
                    $btn.html('Add Print');
                }
            });
        });
    });

    
    
</script>
@endpush