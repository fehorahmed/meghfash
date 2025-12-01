@extends(welcomeTheme().'layouts.app') @section('title')
<title>{{$page->seo_title?:websiteTitle($page->name)}}</title>
@endsection @section('SEO')
<meta name="title" property="og:title" content="{{$page->seo_title?:general()->meta_title}}" />
        <meta name="description" property="og:description" content="{!!$page->seo_description?:general()->meta_description!!}" />
        <meta name="keywords" content="{{$page->seo_keyword?:general()->meta_keyword}}" />
        <meta name="image" property="og:image" content="{{asset($page->image())}}" />
        <meta name="url" property="og:url" content="{{route('pageView',$page->slug?:'no-title')}}" />
        <link rel="canonical" href="{{route('pageView',$page->slug?:'no-title')}}">
@endsection
 @push('css')
 <style>
.brand img {
    max-width: 100%;
    max-height:50px;
}

.brand {
    text-align: center;
    border: 1px solid #e5e2e2;
    height: 70px;
    padding: 10px;
    border-radius: 5px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.brand:hover {
    border-color: #0ba350;
}
 </style>
@endpush 

@section('contents')

<div class="singleProHead">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$page->name}}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="categoryMainDiv">
    <div class="container-fluid">
        <div class="productsLists">
            <div class="row" style="margin:0 -10px;">
                @foreach($brands as $brand)
                <div class="col-md-2 col-6" style="padding:10px;">
                    <div class="brand">
                        <a href="{{route('productBrand',$brand->slug?:'no-title')}}"><img src="{{asset($brand->image())}}" alt="{{$brand->name}}"></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="paginationPart">
            {{$brands->links('pagination')}}
        </div>
    </div>
</div>


@endsection @push('js') @endpush