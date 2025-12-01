@extends(welcomeTheme().'layouts.app') @section('title')
<title>{{websiteTitle('Change Password')}}</title>
@endsection @section('SEO')
<meta name="title" property="og:title" content="{{websiteTitle('Change Password')}}" />
<meta name="description" property="og:description" content="{!!general()->meta_description!!}" />
<meta name="keywords" content="{{general()->meta_keyword}}" />
<meta name="image" property="og:image" content="{{asset(general()->logo())}}" />
<meta name="url" property="og:url" content="{{route('customer.changePassword')}}" />
<link rel="canonical" href="{{route('customer.changePassword')}}" />
@endsection @push('css') @endpush @section('contents')

<!-- START SECTION SHOP -->
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
                            <h3>Change Password</h3>
                        </div>
                        <div class="card-body">
                            @include(welcomeTheme().'.alerts')
                            <form method="POST" action="{{route('customer.changePassword')}}">
                                @csrf
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3 col-form-label">Current password <span class="required">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" name="current_password" placeholder="Current Password" required="" />
                                        @if ($errors->has('current_password'))
                                        <p style="color: red; margin: 0;">{{ $errors->first('current_password') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3 col-form-label">Password <span class="required">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" name="password" placeholder="New Password" required="" />
                                        @if ($errors->has('password'))
                                        <p style="color: red; margin: 0;">{{ $errors->first('password') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3 col-form-label">Confirmed<span class="required">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required="" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION SHOP -->

@endsection @push('js') @endpush