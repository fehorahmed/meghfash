@extends(welcomeTheme().'layouts.app') @section('title')
<title>{{websiteTitle($category->seo_title?:$category->name)}}</title>
@endsection @section('SEO')
<meta name="title" property="og:title" content="{{websiteTitle($category->seo_title?:$category->name)}}" />
<meta name="description" property="og:description" content="{!!$category->seo_description?:general()->meta_description!!}" />
<meta name="keywords" content="{{$category->seo_keyword?:general()->meta_keyword}}" />
<meta name="image" property="og:image" content="{{asset($category->image())}}" />
<meta name="url" property="og:url" content="{{route('blogCategory',$category->slug?:'no-title')}}" />
<link rel="canonical" href="{{route('blogCategory',$category->slug?:'no-title')}}">
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
                <li class="breadcrumb-item active" aria-current="page">{{$category->name}}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="blogCompany">
    <div class="container-fluid">
		<div class="row">
            @foreach($posts as $post)
            <div class="col-md-3">
                @include(welcomeTheme().'blogs.includes.blogGrid')
            </div>
            @endforeach
        </div>
		<!-- pagination -->
		{{$posts->links(welcomeTheme().'blogs.pagination')}}
	</div>
</div>

{{--
<div class="blogCompany">
    <div class="container">
		<div class="row">
		<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
            <div class="row">
                @foreach($posts as $post)
                <div class="col-md-6">
                    @include(welcomeTheme().'blogs.includes.blogGrid')
                </div>
                @endforeach
            </div>
			<!-- pagination -->
			{{$posts->links(welcomeTheme().'blogs.pagination')}}
		</div>
		<div class="col-lg-4 col-md-5  col-sm-12 col-xs-12">
			@include(welcomeTheme().'blogs.includes.sideBar')
		</div>
		</div>
	</div>
</div>
--}}

@endsection @push('js') @endpush