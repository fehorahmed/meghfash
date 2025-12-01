@extends(welcomeTheme().'layouts.app') @section('title')
<title>{{websiteTitle('Dashboard')}}</title>
@endsection @section('SEO')
<meta name="title" property="og:title" content="{{websiteTitle('Dashboard')}}" />
<meta name="description" property="og:description" content="{!!general()->meta_description!!}" />
<meta name="keywords" content="{{general()->meta_keyword}}" />
<meta name="image" property="og:image" content="{{asset(general()->logo())}}" />
<meta name="url" property="og:url" content="{{route('customer.dashboard')}}" />
<link rel="canonical" href="{{route('customer.dashboard')}}" />
@endsection @push('css') @endpush @section('contents')

<div class="section customInvoice">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                @include(welcomeTheme().'.customer.includes.sidebar')
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="dashboard_content">
                    <div class="card">
                        <div class="card-header">
                            <h3>Dashboard</h3>
                        </div>
                        <div class="card-body">
                            @include(welcomeTheme().'.alerts')
                            @if(Auth::user()->admin)
                            <p>
                                Go To <b> <a href="{{route('admin.dashboard')}}">Admin Dashboard</a></b>
                            </p>
                            @endif
                            <p>
                                From your account dashboard. you can easily check view your <b><a href="{{route('customer.profile')}}">edit your password and account details.</a></b>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection @push('js') @endpush
