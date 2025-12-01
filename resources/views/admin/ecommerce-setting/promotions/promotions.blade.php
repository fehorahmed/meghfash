@extends(adminTheme().'layouts.app') @section('title')
<title>{{websiteTitle('Promotions List')}}</title>
@endsection @push('css')
<style type="text/css"></style>
@endpush @section('contents')


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Ecommerce Promotions</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item active">Ecommerce Promotions</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
        	<a class="btn btn-outline-primary" href="{{route('admin.ecommercePromotionsAction','create')}}">
                <i class="fa-solid fa-plus"></i> Add Promotion
            </a>
            <a class="btn btn-outline-primary" href="{{route('admin.ecommercePromotions')}}">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>


@include('admin.alerts')
<div class="card">
<div class="card-content">
        <div id="accordion">
            <div
                class="card-header collapsed"
                data-toggle="collapse"
                data-target="#collapseTwo"
                aria-expanded="false"
                aria-controls="collapseTwo"
                id="headingTwo"
                style="background:#009688;padding: 15px 20px; cursor: pointer;"
            >
               <i class="fa fa-filter"></i> Search click Here..
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="border: 1px solid #00b5b8; border-top: 0;">
                <div class="card-body">
                    <form action="{{route('admin.ecommercePromotions')}}">
                        <div class="row">
                            <div class="col-md-12 mb-0">
                                <div class="input-group">
                                    <input type="text" name="search" value="{{request()->search?request()->search:''}}" placeholder="Search promotion name" class="form-control {{$errors->has('search')?'error':''}}" />
                                    <button type="submit" class="btn btn-success btn-sm rounded-0"><i class="fa fa-search"></i> Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
</div>

<div class="card">
    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
        <h4 class="card-title">Promotions List</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
             <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Validity</th>
                        <th>Discount</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @foreach($coupons as $i=>$coupon)
                    <tr>
                        <td>{{$i+1}}</td>
                        <td>
                            
                        <a href="{{route('promotion',$coupon->slug?:'no-title')}}">{{$coupon->name}}</a>
                        
                        @if($coupon->shipping_free || $coupon->fetured)
                        <br>
                            @if($coupon->shipping_free)
                            <small style="background: #f44336;color: white;padding: 2px 10px;border-radius: 5px;">Free Shipping</small>
                            @endif
                            @if($coupon->fetured)
                            <small style="background: #FF9800;color: white;padding: 2px 10px;border-radius: 5px;">Show Home</small>
                            @endif
                        @endif
                        
                        </td>
                        <td>
                            
                            @if($coupon->start_date && $coupon->end_date)
                                {{carbon\carbon::parse($coupon->start_date)->format('d-m-Y')}} - 
                                {{carbon\carbon::parse($coupon->end_date)->format('d-m-Y')}} 
                                
                                @if(Carbon\Carbon::now()->startOfDay() <= Carbon\Carbon::parse($coupon->end_date)->startOfDay())
                                    ({{ Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($coupon->end_date)) + 1 }} Days)
                                @else
                                    <span class="text-danger">(Expired)</span>
                                @endif
                            @elseif($coupon->start_date && $coupon->end_date==null)
                                <span>{{carbon\carbon::parse($coupon->start_date)->format('d-m-Y')}} - Unlimited</span>
                            @elseif($coupon->start_date==null && $coupon->end_date)
                                <span>{{carbon\carbon::parse($coupon->end_date)->format('d-m-Y')}}
                                @if(Carbon\Carbon::now()->startOfDay() <= Carbon\Carbon::parse($coupon->end_date)->startOfDay())
                                    ({{ Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($coupon->end_date)) + 1 }} Days)
                                @else
                                    <span class="text-danger">(Expired)</span>
                                @endif
                                </span>
                            @else
                                <span>Unlimited</span>
                            @endif
                            
                        </td>
                        <td>
                            
                            @if($coupon->menu_type==1)
                            <span>{{priceFullFormat($coupon->amounts)}}</span>
                            @else
                            <span>{{$coupon->amounts>0?$coupon->amounts:0}}%</span>
                            @endif
                            
                            @if($coupon->min_shopping>0 && $coupon->max_shopping>0)
                            (Min:{{priceFullFormat($coupon->min_shopping)}} -  Max:{{priceFullFormat($coupon->max_shopping)}})
                            @elseif($coupon->min_shopping>0)
                            (Min:{{priceFullFormat($coupon->min_shopping)}})
                            @elseif($coupon->max_shopping>0)
                            (Max:{{priceFullFormat($coupon->max_shopping)}})
                            @endif
                            
                        </td>
                        <td>
                            @if($coupon->location=='category')
                            <span>Category Products</span>
                            @elseif($coupon->location=='product')
                            <span>Indivisual Products</span>
                            @else
                            <span>
                            All Products
                            </span>
                            @endif
                        </td>
                        <td>
                            @if($coupon->status=='active')
                            <span class="badge badge-success">{{ucfirst($coupon->status)}}</span>
                            @else
                            <span class="badge badge-danger">{{ucfirst($coupon->status)}}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('admin.ecommercePromotionsAction',['edit',$coupon->id])}}" class="badge badge-success" ><i class="fa fa-edit"></i></a>
                            <a href="{{route('admin.ecommercePromotionsAction',['delete',$coupon->id])}}" class="badge badge-danger" onclick="return confirm('Are You Want To Delete?')"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach

                </table>
             </div>
            {{$coupons->links('pagination')}}
        </div>
    </div>
</div>


@endsection @push('js')

<script>

          

</script>

@endpush
