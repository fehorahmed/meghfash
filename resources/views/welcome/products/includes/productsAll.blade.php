@if($products->count() > 0)
<div class="row productRow">
    @foreach($products as $product)
    <div class="{{$colName}} col-6">
        @include(welcomeTheme().'.products.includes.productCard')
    </div>
    @endforeach
</div>

<div class="paginationPart">
    {{$products->links('pagination')}}
</div>

@else
<div>
    <p style="text-align: center;font-size: 24px;color: gray;margin-top: 100px;">No Product found</p>
</div>

@endif