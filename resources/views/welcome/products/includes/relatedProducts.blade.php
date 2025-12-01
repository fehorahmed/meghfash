@if($recommendProducts->count() > 0)
<div class="relatedProductMaindDiv">
    <div class="container-fluid">
        <h2>You may also like</h2>
        <div class="productsLists">
            <div class="row productRow">
                @foreach($recommendProducts as $product)
                <div class="col-md-3 col-6">
                    @include(welcomeTheme().'.products.includes.productCard')
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif