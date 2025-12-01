@extends(welcomeTheme().'layouts.app') @section('title')
<title>{{websiteTitle($brand->seo_title?:$brand->name)}}</title>
@endsection @section('SEO')
<meta name="title" property="og:title" content="{{websiteTitle($brand->seo_title?:$brand->name)}}" />
<meta name="description" property="og:description" content="{!!$brand->seo_description?:general()->meta_description!!}" />
<meta name="keywords" content="{{$brand->seo_keyword?:general()->meta_keyword}}" />
<meta name="image" property="og:image" content="{{asset($brand->image())}}" />
<meta name="url" property="og:url" content="{{route('productBrand',$brand->slug?:'no-title')}}" />
<link rel="canonical" href="{{route('productBrand',$brand->slug?:'no-title')}}">
@endsection @push('css')

<style>

    .brandGrid2 {
        border: 1px solid #ffffff;
        display: block;
        border-radius: 10px;
        margin: 10px 0;
        box-shadow: 0px 0px 20px #eee;
    }
    
    .brandGrid2 img {
        max-width: 100%;
        max-height: 100%;
    }
    
    .brandGrid2 p {
        text-align: center;
        font-size: 25px;
        color: #818181;
        padding: 10px 0;
    }
    
    .brandGrid2:hover {
        border: 1px solid #ede7e7;
        /* box-shadow: 0px 0px 20px #eee; */
    }
    
    .brandGrid2 img {
        border-top-right-radius: 10px;
        border-top-left-radius: 10px;
        display: block;
        width: 100%;
    }
</style>

@endpush 

@section('contents')

<div class="categoryMainDiv">
    <div class="container">
        <div class="headTitle">
            <h1>{{$brand->name}}</h1>
        </div>
        <div class="productsLists">
            <div class="row">
                @foreach($subBrands as $subBrand)
                <div class="col-md-4">
                    @include(welcomeTheme().'.products.includes.subBrandCard')
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="paginationPart">
            {{$subBrands->links('pagination')}}
        </div>
    </div>
</div>

@endsection
@push('js')
@endpush