@if(newArrivalProducts()->count() > 0)
<div class="newArrival">
    <div class="container">
        <div class="headTitle">
            <span>Give your home the JAT DECOR touch</span>
            <h1>New<br><div class="secontLine">Arraival</div></h1>
            <a href="#" class="viewAllProductFullBtn">View All</a>
        </div>
        <div class="productsLists">
            <div class="row">
                @foreach(newArrivalProducts()->limit(8)->get() as $product)
                <div class="col-md-3">
                    @include(welcomeTheme().'.products.includes.productCard')
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endif