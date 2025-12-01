@extends('admin.layouts.app') @section('title')
<title>Products List - {{general()->title}} | {{general()->subtitle}}</title>
@endsection @push('css')
<style type="text/css">
    .card .card-header::before {
        content: '';
        width: 0;
        height: 0;
        border-top: 20px solid #37a000;
        border-right: 20px solid transparent;
        position: absolute;
        left: 0;
        top: 0;
    }
</style>
@endpush @section('contents')

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
            <a class="btn btn-outline-primary" href="{{route('admin.products')}}">Back All</a>
            @isset(json_decode(Auth::user()->permission->permission, true)['products']['add'])
            <a class="btn btn-outline-success" href="{{route('admin.productsAction',['edit',$product->id])}}">Edit</a>
            @endisset
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
                        <h4 class="card-title">Products View</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                           <div class="row">
                           	
	                           <div class="col-md-4">
	                           	<div class="productImage">
	                           		<img src="{{asset($product->image())}}" style="max-width:100%;">
	                           	</div>
	                           </div>
	                           <div class="col-md-8">
	                           	   <table class="table table-bordered">
                                    <tr>
                                        <th style="min-width:250px;width:250px;">Name</th>
                                        <td>{{$product->name}}</td>
                                    </tr> 
                                    <tr>
                                        <th>ID </th>
                                        <td>{{$product->id}}</td>
                                    </tr>  
                                    <tr>
                                        <th>Price</th>
                                        <td>{{general()->currency}} {{priceFormat($product->final_price)}}</td>
                                    </tr>  
                                    <tr>
                                        <th>Category </th>
                                        <td>
                                        @foreach($product->productCategories as $i=>$ctg)
                                         {{$i==0?'':'-'}} {{$ctg->name}} 
                                         @endforeach
                                        </td>
                                    </tr> 
                                    <tr>
                                        <th>Brand </th>
                                        <td>{{$product->brand?$product->brand->name:''}}</td>
                                    </tr> 
                                    <tr>
                                        <th>Stock </th>
                                        <td>{{$product->quantity}} Qty
                                        
                                        
                                        
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Store/Branch Stock </th>
                                        <td style="padding: 2px;">
                                            @foreach($product->warehouseStores()->where('quantity','>',0)->groupBy('branch_id')->selectRaw('branch_id, SUM(quantity) as total_quantity')->get() as $store)
                                             <span style="border: 1px solid #d8cfcf;display: inline-block;padding: 2px 15px;border-radius: 15px;margin: 3px 1px;">   {{$store->branch?$store->branch->name:'Not Found'}} - {{$store->total_quantity}} Qty</span>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>SKU </th>
                                        <td>{{$product->sku_code}}</td>
                                    </tr>  
                                    <tr>
                                        <th>Barcode </th>
                                        <td>
                                            @if($product->bar_code && $product->variation_status==false)
                                            {{$product->bar_code}} 
                                            <a class="badge badge-sm badge-primary" href="{{route('admin.productsAction',['barcode',$product->id])}}" target="_blank" style="color: white;padding: 5px 15px;" >
                                                Print  <i class="fa fa-barcode" style="color: black;"></i> </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <td>
                                            <a href="{{route('admin.reportsAll',['history-of-product','item_search'=>$product->id])}}" target="_blank">View History</a>
                                        </td>
                                    </tr>
                                   </table>
	                           </div>

                           </div>


                           @if($product->variation_status==true)
                           <br>
                           <div class="table-responsive">
                               
                               <table class="table table-bordered">
                                   <tr>
                                       <th style="width: 60px;min-width: 60px;">SL</th>
                                       <th style="width: 80px;min-width: 80px;">Image</th>
                                       @foreach($product->productVariationAttibutes as $att)
                                        <th style="min-width: 120px;width: 120px;" >{{$att->attribute?$att->attribute->name:'Not found'}}</th>
                                        @endforeach
                                       <th>Purchase Price</th>
                                       <th>Wholesale</th>
                                       <th>Sale Price</th>
                                       <th>Barcode</th>
                                       <th style="width: 100px;min-width: 100px;">Qty</th>
                                       <th style="width: 200px;min-width: 200px;">Wherehouse</th>
                                   </tr>
                                   @foreach($product->productVariationAttributeItems()->get() as $vi=>$variationItem)
                                   <tr>
                                       <td>{{$vi+1}}</td>
                                       <td>
                                           <img src="{{asset($variationItem->variationItemImage())}}" style="max-width:70px;max-height:40px;">
                                       </td>
                                       @foreach($product->productVariationAttibutes as $att)
                                        @if($attValue =$variationItem->attributeVatiationItems()->where('attribute_id',$att->reff_id)->first())
                                        <td style="vertical-align: middle;padding:5px;">
                                            {{$attValue->attribute_item_value}}
                                        </td>
                                        @endif
                                        @endforeach
                                       <td>{{priceFullFormat($variationItem->purchase_price)}}</td>
                                       <td>{{priceFullFormat($variationItem->wholesale_price)}}</td>
                                       <td>{{priceFullFormat($variationItem->final_price)}}</td>
                                       <td>
                                        @if($variationItem->barcode)
                                        {{$variationItem->barcode}}
                                        <a href="{{route('admin.productsAction',['barcode',$product->id,'variation_id'=>$variationItem->id])}}" target="_blank" style="color: #ff864a;font-size: 12px;font-weight: bold;">Print  <i class="fa fa-barcode" style="color: black;"></i> </a>
                                        @endif
                                       </td>
                                       <td>{{$variationItem->quantity}}</td>
                                       <td>
                                            @foreach($product->warehouseStores()->where('variant_id', $variationItem->id)->where('quantity','>',0)->groupBy('branch_id')->selectRaw('branch_id, SUM(quantity) as total_quantity')->get() as $store)
                                             <span style="border: 1px solid #d8cfcf;display: inline-block;padding: 2px 15px;border-radius: 15px;margin: 3px 1px;">  {{$store->branch?$store->branch->name:'Not Found'}} - {{$store->total_quantity}} Qty</span>
                                            @endforeach
                                       </td>
                                   </tr>
                                   @endforeach
                               </table>
                           
                           </div>
                           
                           @endif
                           
                           
                           
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Basic Inputs end -->
</div>


 <!-- Modal -->
 <div class="modal fade text-left" id="barcode" >
   <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content">

       <div class="modal-header">
         <h4 class="modal-title" id="myModalLabel1">Barcode</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times; </span>
         </button>
       </div>
       <div class="modal-body" style="max-height:300px;overflow: auto;">
        @if($product->bar_code)
            <div class="printArea printable-content PrintAreaContact" >
                
               <div class="BarcodSection">
                @for($i=0;$i < 50;$i++)
                <img id="barcode1"/>
                <script>
                var name ="{{$product->bar_code}}";
                JsBarcode("#barcode1", name ,{format:"CODE128",});
                </script>
                @endfor
               </div>

            </div>
        @else
        <p>No Barcode</p>
        @endif
       </div>
       <div class="modal-footer">
         <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close </button>
         <button type="submit" id="PrintAction" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
       </div>

     </div>
   </div>
 </div>

@endsection 

@push('js')



@endpush
