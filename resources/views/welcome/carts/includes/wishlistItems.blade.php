@isset($wlCount)
    @if($wlCount > 0 && $products->count() > 0)
		<div class="row">
            <div class="col-12">
                <div class="table-responsive wishlist_table">
                	<table class="table">
                    	<thead>
                        	<tr>
                            	<th class="product-thumbnail">&nbsp;</th>
                                <th class="product-name" style="min-width: 250px;">Product</th>
                                <th class="product-price" style="min-width: 130px;">Price</th>
                                <th class="product-stock-status" style="min-width: 130px;">Stock Status</th>
                                <th class="product-remove">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
							@foreach($products as $product)
                        	<tr>
                            	<td class="product-thumbnail"><a href="{{route('productView',$product->slug?:Str::slug($product->name))}}"><img src="{{asset($product->image())}}" alt="{{$product->name}}" style="max-width:100px;"></a></td>
                                <td class="product-name" data-title="Product"><a href="{{route('productView',$product->slug?:Str::slug($product->name))}}">{{$product->name}}</a></td>
                                <td class="product-price" data-title="Price">{{priceFullFormat($product->offerPrice())}}</td>
                              	<td class="product-stock-status" data-title="Stock Status">
									@if($product->stockStatus())
									<span class="badge rounded-pill text-bg-success">In Stock</span>
									@else
									<span class="badge rounded-pill text-bg-danger">Stock Out</span>
									@endif
							</td>
                            <td class="product-remove" data-title="Remove"><a href="javascript:void(0)" data-url="{{route('wishlistCompareUpdate',[$product->id,'wishlist'])}}" class="wishlistCompareUpdate"><i class="text-danger fa fa-trash"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
				{{$products->links('pagination')}}
            </div>
        </div>
        
    @else

    <div class="emptyWishList" style="text-align:center;">
          <p>No Wishlist Product</p>
    </div>
    @endif

@endisset