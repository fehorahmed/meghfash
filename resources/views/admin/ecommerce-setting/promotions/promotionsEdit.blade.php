@extends(adminTheme().'layouts.app') @section('title')
<title>{{websiteTitle('Promotion Edit')}}</title>
@endsection @push('css')
<style type="text/css">
    
    .searchResult {
        position: absolute;
        width: 100%;
        background: #f3f3f3;
        display:none;
        z-index: 99;
        max-height: 200px;
        overflow: auto;
    }
    
    .searchSection {
        position: relative;
    }
    
    .searchResult ul {
        margin: 0;
        padding: 0;
    }
    
    .searchResult ul li {
        list-style: none;
        padding: 5px 15px;
        border-bottom: 1px solid #e1e1e1;
        cursor: pointer;
    }
    .productGrid {
        border: 1px solid #e3e3e3;
        padding: 5px;
        text-align: center;
    }
    
    .productGrid img {
        max-width: 100%;
        max-height: 100px;
        margin: auto;
        display:block;
    }
</style>
@endpush @section('contents')


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Promotion Edit</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item active">Promotion Edit</li>
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
                Back
            </a>
        </div>
    </div>
</div>

<div class="content-body">
    <!-- Basic Elements start -->
    <section class="basic-elements">
        @include('admin.alerts')

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Promotion Edit</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form action="{{route('admin.ecommercePromotionsAction',['update',$promotion->id])}}" method="post" enctype="multipart/form-data">
                           		        @csrf
                          			<div class="table-responsive">
                           				<table class="table table-borderless">
                           					<tr>
                           						<td style="width: 200px;min-width:200px;">Promotion Name </td>
                           						<td style="min-width: 300px;">
                           							<input type="text" name="name" value="{{$promotion->name}}" class="form-control form-control-sm" placeholder="Enter Promotion Name" required="">
                           							@if ($errors->has('name'))
                                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('name') }}</p>
                                                    @endif
                           						</td>
                           					</tr>
                                            <tr>
                                                <td>Discount</td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="number" name="discount" value="{{$promotion->amounts}}" class="form-control form-control-sm" placeholder="Discount" required="">
                                                        <select class="form-control form-control-sm" name="discount_type">
                                                            <option value="0" {{$promotion->menu_type==0?'selected':''}} >Percentage(%)</option>
                                                            <!--<option value="1" {{$promotion->menu_type==1?'selected':''}} >Flat({{general()->currency}})</option>-->
                                                        </select>
                                      <!--                  <label style="margin-left: 10px;">-->
                               							<!--    <input type="checkbox" name="shipping_free" {{$promotion->shipping_free?'checked':''}} /> Shipping Free-->
                               							<!--</label>-->
                                                    </div>
                                                    @if ($errors->has('discount'))
                                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('discount') }}</p>
                                                    @endif
                                                    @if ($errors->has('discount_type'))
                                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('discount_type') }}</p>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Image</td>
                                                <td>
                                                    <div class="input-group" style="max-width: 300px;">
                                                        <input type="file" name="image" class="form-control form-control-sm" >
                                                        <div>
                                                            <img src="{{asset($promotion->image())}}" style="max-width:200px;max-height:50px;margin-left: 10px;">
                                                            @if($promotion->imageFile)
                                                            <a href="{{route('admin.mediesDelete',$promotion->imageFile->id)}}" class="mediaDelete" style="color: red;"><i class="fa fa-trash"></i></a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Validity Date</td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="date" name="start_date" value="{{$promotion->start_date?carbon\carbon::parse($promotion->start_date)->format('Y-m-d'):''}}" class="form-control form-control-sm" >
                                                        <input type="date" name="end_date" value="{{$promotion->end_date?carbon\carbon::parse($promotion->end_date)->format('Y-m-d'):''}}" class="form-control form-control-sm" >
                                                    </div>
                                                    @if ($errors->has('start_date'))
                                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('start_date') }}</p>
                                                    @endif
                                                    @if ($errors->has('end_date'))
                                                    <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('end_date') }}</p>
                                                    @endif
                                                </td>
                                            </tr>
                           					<tr>
                           						<td>Promotion Descriptioin</td>
                           						<td>
                           							<textarea type="text" name="description" rows="5"  class="form-control" placeholder="Enter Description">{!!$promotion->description!!}</textarea>
                           						</td>
                           					</tr>
                           					<tr>
                           						<td>Promotion Type</td>
                           						<td>
                           							<select class="form-control form-control-sm" name="coupon_type" required="">
                           								<option value="all" {{$promotion->location=='all'?'selected':''}}>All Products</option>
                           								<option value="product" {{$promotion->location=='product'?'selected':''}}>Indivisual Products</option>
                           								<option value="category" {{$promotion->location=='category'?'selected':''}}>Category Products</option>
                           							</select>
                           						</td>
                           					</tr>
                           					<tr>
                           					    <td>Categories</td>
                           					    <td>
                           					        <select data-placeholder="Search Category..." name="categories[]" class="select2 form-control" multiple="multiple">
                                                        <option vaue="">Select Categories</option>
                                                        @foreach($categories as $ctg)
                                                        <option value="{{$ctg->id}}"
                                                        @foreach($promotion->couponCtgs as $postctg)
                                                        {{$postctg->reff_id==$ctg->id?'selected':''}} 
                                                        @endforeach
                                                        >{{$ctg->name}}</option>
                                                        @if($ctg->subCtgs()->where('status','active')->count() > 0)
                                                        @foreach($ctg->subCtgs()->where('status','active')->get() as $subCtg)
                                                        <option value="{{$subCtg->id}}" 
                                                        @foreach($promotion->couponCtgs as $postctg)
                                                        {{$postctg->reff_id==$subCtg->id?'selected':''}} 
                                                        @endforeach
                                                        > - {{$subCtg->name}}</option>
                                                        @endforeach
                                                        @endif
                                                        @endforeach
                                                    </select>
                           					    </td>
                           					</tr>
                           					<tr>
                           						<td>Status</td>
                           						<td>
                           						    <div class="input-group">
                               							<select class="form-control form-control-sm" name="status" required="">
                               								<option value="">Select Status</option>
                               								<option value="active" {{$promotion->status=='active'?'selected':''}}>Active</option>
                               								<option value="inactive" {{$promotion->status=='inactive'?'selected':''}}>Inactive</option>
                               							</select>
                               							<label style="margin-left: 10px;">
                               							    <input type="checkbox" name="fetured" {{$promotion->fetured?'checked':''}} /> Set Home Page
                               							</label>
                           						    </div>
                           						</td>
                           					</tr>
                           					<tr>
                           						<td>Created Date</td>
                           						<td>
                           							<input type="date" name="created_at" value="{{$promotion->created_at->format('Y-m-d')}}" class="form-control form-control-sm">
                           						</td>
                           					</tr>
                           					<tr>
                           						<td>Action</td>
                           						<td>
                           							<button type="submit" class="btn btn-primary">Submit</button>
                           						</td>
                           					</tr>
                           				</table>
                           			</div>
                               	</form>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Promotion Products</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body" style="min-height: 400px;">
                            <div class="row m-0">
                                <div class="col-md-6" style="padding:5px;">
                                    <div class="form-group searchSection">
                                        <input type="text" class="form-control searchProduct" data-url="{{route('admin.ecommercePromotionsAction',['search-product',$promotion->id])}}" placeholder="Enter Search Product">
                                        <div class="searchResult"></div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="couponProduucts">
                                @include(adminTheme().'ecommerce-setting.includes.promotionProductsList')
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

            </div>


    </section>
    <!-- Basic Inputs end -->
</div>

@endsection @push('js')

<script>

$(document).ready(function(){
    $('.searchProduct').click(function(){
        $(".searchResult").show();
    });
    
    $(document).click(function(event){
        if (!$(event.target).closest('.searchSection').length) {
            $(".searchResult").hide();
        }
    });
    
    
    $('.searchProduct').keyup(function(){
        var search =$(this).val();
        var url =$(this).data('url');
        
        if(url){
            $.ajax({
              url: url,
              type: 'GET',
              dataType: 'json',
              cache: false,
              data:{'search':search}
            })
            .done(function(data) {
                $(".searchResult").empty().append(data.view);
            })
            .fail(function() {
              // alert("error");
            });
        }
        
    });

    $(document).on("click", ".searchResult ul li", function(){
        $(this).remove();
        var url =$(this).data('url');
        if(url){
            $.ajax({
              url: url,
              type: 'GET',
              dataType: 'json',
              cache: false,
            })
            .done(function(data) {
                $(".couponProduucts").empty().append(data.view);
            })
            .fail(function() {
              // alert("error");
            });
        }
        
    });
    
    $(document).on('click','.checkAll',function(){
        var checked = $(this).prop('checked');
        $('input.counponCheck:checkbox').prop('checked', checked);
    });
    
    $(document).on('click','.counponProductDelete',function(){
        var checkedId = [];
        $('.counponCheck').each(function(){
            if($(this).prop('checked')) {
                checkedId.push($(this).val());
            }
        });
        var url =$(this).data('url');
        if(confirm('Are You Want To Delete?')){
            $.ajax({
              url: url,
              type: 'GET',
              dataType: 'json',
              cache: false,
              data:{'checkedId':checkedId}
            })
            .done(function(data) {
                $(".couponProduucts").empty().append(data.view);
            })
            .fail(function() {
              // alert("error");
            });
        }
        
    });
    
    
});
</script>

@endpush
