<div class="row">
    @foreach($products as $product)
    <div class="{{$colName}} col-6">
        @include(welcomeTheme().'.products.includes.productCard')
    </div>
    @endforeach
</div>

<div class="paginationPart">
    {{$products->links('pagination')}}
</div>