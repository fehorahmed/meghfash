@extends(welcomeTheme().'layouts.app') @section('title')
<title>{{websiteTitle($brand->name)}}</title>
@endsection @section('SEO')
<meta name="title" property="og:title" content="{{websiteTitle($brand->seo_title?:$brand->name)}}" />
<meta name="description" property="og:description" content="{!!$brand->seo_description?:general()->meta_description!!}" />
<meta name="keywords" content="{{$brand->seo_keyword?:general()->meta_keyword}}" />
<meta name="image" property="og:image" content="{{asset($brand->image())}}" />
<meta name="url" property="og:url" content="{{route('productBrand',$brand->slug?:'no-title')}}" />
<link rel="canonical" href="{{route('productBrand',$brand->slug?:'no-title')}}">
@endsection @push('css')
<style>

</style>
@endpush 

@section('contents')


<div class="singleProHead">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$brand->name}}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="categoryMainDiv">
    <div class="container-fluid">
        <div class="productsLists">
            <div class="row productRow">
                @foreach($products as $product)
                <div class="col-md-3 col-6">
                    @include(welcomeTheme().'.products.includes.productCard')
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="paginationPart">
            {{$products->links('pagination')}}
        </div>
    </div>
</div>

@endsection
@push('js')
@endpush