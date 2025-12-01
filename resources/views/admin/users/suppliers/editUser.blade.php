@extends(adminTheme().'layouts.app')
@section('title')
<title>{{websiteTitle('Supplier Profile')}}</title>
@endsection

@push('css')
<style type="text/css">
    .showPassword {
    right: 0 !important;
    cursor: pointer;
    }
    .ProfileImage{
        max-width: 64px;
        max-height: 64px;
    }
</style>
@endpush
@section('contents')


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
     <h3 class="content-header-title mb-0">Supplier Profile</h3>
     <div class="row breadcrumbs-top">
       <div class="breadcrumb-wrapper col-12">
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a>
           </li>
           <li class="breadcrumb-item active">Supplier Profile</li>
         </ol>
       </div>
     </div>
    </div>
   <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
     <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
       
       <a class="btn btn-outline-primary" href="{{route('admin.usersSupplier')}}">
       		Back
       	</a>
       	<a class="btn btn-outline-primary" href="{{route('admin.usersSupplierAction',['edit',$user->id])}}">
       		<i class="fa-solid fa-rotate"></i>
       	</a>
     </div>
   </div>
</div>
 
	

    @include(adminTheme().'alerts')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                    <h4 class="card-title">Supplier Profile</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form action="{{route('admin.usersSupplierAction',['update',$user->id])}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="media">
                                <a href="javascript: void(0);">
                                    <img src="{{asset($user->image())}}"  class="ProfileImage image_{{$user->id}} rounded mr-75" style="max-height: 100px;" alt="profile image" />
                                </a>
                                <div class="media-body" style="padding: 0 10px;">
                                    <div style="display:flex;">
                                        <label class="btn btn-sm btn-primary cursor-pointer" for="account-upload" >Upload photo </label>
                                        <input type="file" name="image" id="account-upload" class="account-upload" data-imageshow="image_{{$user->id}}" hidden="" />
                                        @if($user->imageFile)
                                        <a href="{{route('admin.mediesDelete',$user->imageFile->id)}}" class="mediaDelete btn btn-sm btn-secondary" style="margin: 0 10px;height:31px;">Reset </a>
                                        @endif
                                    </div>
                                    @if ($errors->has('image'))
                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('image') }}</p>
                                    @endif
                                    <p class="text-muted"><small>Allowed JPG, GIF or PNG. Max size of 2048kB</small></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xl-4 col-lg-4 col-md-12">
                                    <label for="name">Name* </label>
                                    <input type="text" class="form-control {{$errors->has('name')?'error':''}}" name="name" placeholder="Enter Name" value="{{$user->name?:old('name')}}" required="" />
                                    @if ($errors->has('name'))
                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-xl-4 col-lg-4 col-md-12">
                                    <label for="mobile">Mobile* </label>
                                    <input type="text" class="form-control {{$errors->has('mobile')?'error':''}}" name="mobile" placeholder="Enter Mobile" value="{{$user->mobile?:old('mobile')}}" required="" />
                                    @if ($errors->has('mobile'))
                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('mobile') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-xl-4 col-lg-4 col-md-12">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control {{$errors->has('email')?'error':''}}" name="email" placeholder="Enter Email" value="{{$user->email?:old('email')}}" required="" />
                                    @if ($errors->has('email'))
                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('email') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-xl-4 col-lg-4 col-md-4">
                                    <label for="company_name">Company Name</label>
                                    <input type="text" class="form-control {{$errors->has('company_name')?'error':''}}" name="company_name" placeholder="Enter company name" value="{{$user->company_name?:old('company_name')}}" />
                                    @if ($errors->has('company_name'))
                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('company_name') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-xl-8 col-lg-8 col-md-8">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control {{$errors->has('address')?'error':''}}" name="address" placeholder="Enter Address" value="{{$user->address_line1?:old('address')}}" />
                                    @if ($errors->has('address'))
                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('address') }}</p>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="status">Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="status" id="status" {{$user->status?'checked':''}}/>
                                        <label class="custom-control-label" for="status">User Active</label>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="created_at">Created Date</label>
                                    <input type="date" name="created_at" value="{{$user->created_at?$user->created_at->format('Y-m-d'):old('created_at')}}" class="form-control {{$errors->has('created_at')?'error':''}}">
                                    @if ($errors->has('created_at'))
                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('created_at') }}</p>
                                    @endif
                                </div>
                            </div>                        
                            <button type="submit" class="btn btn-primary btn-md rounded-0">Save changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--<div class="col-md-5">-->
        <!--    <div class="card">-->
        <!--        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">-->
        <!--            <h4 class="card-title">Change Password</h4>-->
        <!--        </div>-->
        <!--        <div class="card-content">-->
        <!--            <div class="card-body">-->
        <!--                <form action="{{route('admin.usersCustomerAction',['change-password',$user->id])}}" method="post">-->
        <!--                    @csrf-->
        <!--                    <div class="row">-->
        <!--                        <div class="col-xl-12 col-lg-12 col-md-12 form-group">-->
        <!--                            <label for="old_password">Old password </label>-->
        <!--                            <div class="input-group">-->
        <!--                                <input type="password" class="form-control password" placeholder="Old Password" name="old_password" value="{{$user->password_show?:old('old_password')}}" required="" />-->
        <!--                                <div class="input-group-append">-->
        <!--                                    <span class="input-group-text showPassword"><i class="fa fa-eye-slash"></i></span>-->
        <!--                                </div>-->
        <!--                            </div>-->
        <!--                            @if ($errors->has('old_password'))-->
        <!--                            <p style="color: red; margin: 0;">{{ $errors->first('old_password') }}</p>-->
        <!--                            @endif-->
        <!--                        </div>-->
        <!--                        <div class="col-xl-12 col-lg-12 col-md-12 form-group">-->
        <!--                            <label for="password">New Password </label>-->
        <!--                            <input type="password" class="form-control password {{$errors->has('password')?'error':''}}" name="password" placeholder="New password" required="" />-->
        <!--                            @if ($errors->has('password'))-->
        <!--                            <p style="color: red; margin: 0;">{{ $errors->first('password') }}</p>-->
        <!--                            @endif-->
        <!--                        </div>-->
        <!--                        <div class="col-xl-12 col-lg-12 col-md-12 form-group">-->
        <!--                            <label for="password_confirmation">Confirmed Password </label>-->
        <!--                            <input type="password" class="form-control password {{$errors->has('password_confirmation')?'error':''}}" name="password_confirmation" placeholder="Confirmed password" required="" />-->
        <!--                            @if ($errors->has('password_confirmation'))-->
        <!--                            <p style="color: red; margin: 0;">{{ $errors->first('password_confirmation') }}</p>-->
        <!--                            @endif-->
        <!--                        </div>-->
        <!--                        <div class="col-12">-->
        <!--                            <button type="submit" class="btn btn-danger">Change Password</button>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </form>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
    </div>



@endsection
@push('js')



@endpush