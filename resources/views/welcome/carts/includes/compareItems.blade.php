
@if($products->count() > 0)

<div class="row">
	<div class="col-md-12">
		<div class="compare_box">
			<div class="table-responsive">
				<table class="table table-bordered text-center">
				<tbody>
					<tr class="pr_image">
						<td class="row_title">Product Image</td>
						@foreach($products as $product)
						<td class="row_img"><img src="{{asset($product->image())}}" alt="compare-img"></td>
						@endforeach
					</tr>
					<tr class="pr_title">
						<td class="row_title">Product Name</td>
						@foreach($products as $product)
						<td class="product_name"><a href="{{route('productView',$product->slug?:Str::slug($product->name))}}">{{$product->name}}</a></td>
						@endforeach
					</tr>
					<tr class="pr_price">
						<td class="row_title">Price</td>
						@foreach($products as $product)
						<td class="product_price"><span class="price">{{priceFullFormat($product->offerPrice())}}</span></td>
						@endforeach
					</tr>
					<tr class="pr_rating">
						<td class="row_title">Rating</td>
						@foreach($products as $product)
						<td>
							<div class="rating_wrap">
								<div class="rating">
									<div class="product_rate" style="width:80%"></div>
								</div>
								<span class="rating_num">(21)</span>
							</div>
						</td>
						@endforeach
					</tr>
					<tr class="pr_add_to_cart">
						<td class="row_title">Add To Cart</td>
						@foreach($products as $product)
						<td class="row_btn">
							@if($product->stockStatus())
							<a href="#" class="btn btn-fill-out"><i class="icon-basket-loaded"></i> Add To Cart</a>
							@endif
						</td>
						@endforeach
					</tr>
					<tr class="description">
						<td class="row_title">Description</td>
						@foreach($products as $product)
						<td class="row_text"><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and </p></td>
						@endforeach
					</tr>
					<tr class="pr_color">
						<td class="row_title">Color</td>
						@foreach($products as $product)
						<td class="row_color">
							<div class="product_color_switch">
								<span data-color="#87554B" style="background-color: rgb(135, 85, 75);"></span>
								<span data-color="#333333" style="background-color: rgb(51, 51, 51);"></span>
								<span data-color="#DA323F" style="background-color: rgb(218, 50, 63);"></span>
							</div>
						</td>
						@endforeach
					</tr>
					<tr class="pr_size">
						<td class="row_title">Sizes Available</td>
						@foreach($products as $product)
						<td class="row_size"><span>S, M, L, XL</span></td>
						@endforeach
					</tr>
					<tr class="pr_stock">
						<td class="row_title">Item Availability</td>
						@foreach($products as $product)
						<td class="row_stock">
							@if($product->stockStatus())
							<span class="in-stock">In Stock</span>
							@else
							<span class="out-stock">Out Of Stock</span>
							@endif
						</td>
						@endforeach
					</tr>
					<tr class="pr_weight">
						<td class="row_title">Weight</td>
						@foreach($products as $product)
						<td class="row_weight"></td>
						@endforeach
					</tr>
					<tr class="pr_dimensions">
						<td class="row_title">Dimensions</td>
						@foreach($products as $product)
						<td class="row_dimensions">N/A</td>
						@endforeach
					</tr>
					<tr class="pr_remove">
						<td class="row_title"></td>
						@foreach($products as $product)
						<td class="row_remove">
							<a href="javascript:void(0)"  data-url="{{route('wishlistCompareUpdate',[$product->id,'compare'])}}" class="wishlistCompareUpdate" ><span>Remove</span> <i class="fa fa-times"></i></a>
						</td>
						@endforeach
					</tr>
				</tbody>
			</table>
			</div>
		</div>
	</div>
</div>


 @else

<div class="emptyCompare" style="text-align:center;">
    <p>No Compare Product</p>
</div>

@endif