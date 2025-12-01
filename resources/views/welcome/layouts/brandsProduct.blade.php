
<div class="allProd">
    <div class="container-fluid">
        <h3>Shop by Brands</h3>
        <div class="row">
            <div class="col-md-10">
                <div class="proCtgTab">
                    <nav>
                        <div class="nav nav-tabs brandSlick" id="nav-tab" role="tablist">
                            @foreach($brands as $i=>$brd)
                            <button class="nav-link {{$i==0?'active':''}} slick-box" id="nav-brand_{{$brd->id}}-tab" data-bs-toggle="tab" data-bs-target="#nav-brand_{{$brd->id}}" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                                <img src="{{asset($brd->image())}}" alt="{{$brd->name}}" />
                            </button>
                            @endforeach
                        </div>
                    </nav>
                </div>
            </div>
            <div class="col-md-2">
                @if($bPg =pageTemplate('All Brands'))
                <a href="{{route('pageView',$bPg->slug?:'no-title')}}" class="showMoreLink">Show More</a>
                @endif
            </div>
            <div class="col-md-12">
                <hr />
            </div>
            <div class="col-md-12">
                <div class="tab-content" id="nav-tabContent">
                    @foreach($brands as $bb=>$brand)
                    <div class="tab-pane fade {{$bb==0?'show active':''}}" id="nav-brand_{{$brand->id}}" role="tabpanel" aria-labelledby="nav-brand_{{$brand->id}}-tab">
                        <div class="row">
                            @foreach($brand->brandProducts()->latest()->where('status','active')->limit(8)->get() as $product)
                            <div class="col-md-3 col-6">
                                @include(welcomeTheme().'.products.includes.productCard')
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

