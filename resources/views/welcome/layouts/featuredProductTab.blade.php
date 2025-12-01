
<div class="allProd">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <h1>All Products</h1>
            </div>
            <div class="col-md-8">
                <div class="proCtgTab">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">New Arraival</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Best Selling</button>
                            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Featured</button>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="col-md-2">
                @if($pPg =pageTemplate('Latest Products'))
                <a href="{{route('pageView',$pPg->slug?:'no-title')}}" class="showMoreLink">Show More</a>
                @endif
            </div>
            <div class="col-md-12">
                <hr />
            </div>
            <div class="col-md-12">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row productRow">
                            @foreach($latestProducts as $product)
                            <div class="col-md-3 col-6">
                                @include(welcomeTheme().'.products.includes.productCard')
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="row productRow">
                            @foreach($bestProducts as $product)
                            <div class="col-md-3 col-6">
                                @include(welcomeTheme().'.products.includes.productCard')
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <div class="row productRow">
                            @foreach($featuresProducts as $product)
                            <div class="col-md-3 col-6">
                                @include(welcomeTheme().'.products.includes.productCard')
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
