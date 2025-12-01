@extends('admin.layouts.app') 
@section('title')
<title>{{websiteTitle('Order Manage')}}</title>
@endsection
@push('css')
<style type="text/css">
    .SearchContain{
        position: relative;
    }
    .searchResultlist {
        position: absolute;
        top: 38px;
        left: 0;
        width: 100%;
        z-index: 9;
	}

	.searchResultlist ul {
	    border: 1px solid #ccd6e6;
	    padding: 0;
	    margin: 0;
	    list-style: none;
	    background: white;
	    height: 250px;
        overflow: auto;
	}

	.searchResultlist ul li {
	    padding: 2px 10px;
	    cursor: pointer;
	    border-bottom: 1px dotted #dcdee0;
	}
    .searchResultlist ul li:hover {
        background: gainsboro;
    }
	.searchResultlist ul li:last-child {
		border-bottom: 0px dotted #dcdee0;
	}
</style>
@endpush @section('contents')


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Order Manage</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item active">Order Manage</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="{{route('admin.orders')}}"><i class="fa fa-list"></i> Back</a>
            
            <a class="btn btn-success" href="{{route('admin.invoice',$order->id)}}"><i class="fa fa-print"></i> Invoice</a>
            
            <a class="btn btn-outline-primary" href="{{route('admin.ordersAction',['manage',$order->id])}}">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>


<div class="content-body">
    <!-- Basic Elements start -->
    <section class="basic-elements">
        <div class="row">
            <div class="col-md-12">
			    @include('admin.alerts')
			    <form  method="post" action="{{route('admin.ordersAction',['update',$order->id])}}">
				@csrf
            	<div class="card">
                    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                        <h4 class="card-title">Customer Info</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                        	<div class="row">
                        		<div class="col-md-6">
                        		    <div class="customerStatus"></div>

                        		    <div class="table-responsive">
                        			<table class="table table-borderless">
                        			    <tr>
		                        			<th style="width: 150px;min-width: 150px;">INVOICE:</th>
		                        			<td>{{$order->invoice}}</td>
		                        		</tr>
		                        		<tr>
		                        			<th>Created Date*</th>
		                        			<td style="padding:3px;">
		                        			    <input type="datetime-local" name="created_at" value="{{ $order->created_at->format('Y-m-d\TH:i') }}" class="form-control form-control-sm" required>
		                        			 </td>
		                        		</tr>
		                        		<tr>
		                        			<th>Store/Branch*</th>
		                        			<td style="padding:3px;">
                                                @if($order->order_status == 'confirmed' || $order->order_status == 'shipped' || $order->order_status == 'delivered' || $order->order_status == 'returned'  || $order->order_status == 'cancelled')
                                                <input type="text" readonly value="{{$order->branch?$order->branch->name:''}}" class="form-control form-control-sm">
                                                @else
                                                <select class="form-control form-control-sm selectWarehouse" data-id="{{$order->id}}"  data-url="{{route('admin.ordersAction',['warehouse-select',$order->id])}}">
                                                    <option value="">Select Store/Branch</option>
                                                    @foreach(App\Models\Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']) as $warehouse)
                                                    <option value="{{$warehouse->id}}" {{$warehouse->id==$order->branch_id?'selected':''}}>{{$warehouse->name}}</option>
                                                    @endforeach
                                                </select>
                                                @endif
                                                <span class="warehouseErro" style="color:red;"></span>
                                            </td>
		                        		</tr>
		                        		<tr>
		                        			<th>Name*</th>
		                        			<td style="padding:3px;">
		                        			    <input type="text" name="name" value="{{$order->name}}" placeholder="Enter name" class="form-control form-control-sm" required="">
		                        			    @if ($errors->has('name'))
                                                <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('name') }}</p>
                                                @endif
		                        			 </td>
		                        		</tr>
		                        		<tr>
		                        			<th>Mobile*</th>
		                        			<td style="padding:3px;">
		                        			    <input type="text" name="mobile" value="{{$order->mobile}}" placeholder="Enter mobile" class="form-control form-control-sm  mobileNumberChange" data-url="{{route('admin.ordersAction',['user-courier-status',$order->id])}}" required="" >
		                        			    @if ($errors->has('mobile'))
                                                <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('mobile') }}</p>
                                                @endif
		                        			</td>
		                        		</tr>
		                        		<tr>
		                        			<th>Email</th>
		                        			<td style="padding:3px;" >
		                        			    <input type="email" name="email" value="{{$order->email}}" placeholder="Enter email" class="form-control form-control-sm">
		                        			</td>
		                        		</tr>
		                        		<tr>
		                        			<th>Address:</th>
		                        			<td style="padding:3px;" >
		                        			    <div class="input-group">
		                        			        <select name="district"  
		                        			        class="form-control form-control-sm districtFilter" data-url="{{route('admin.ordersAction',['district-filter',$order->id])}}" >
		                        			            <option value="" >Select District</option>
		                        			            @foreach(geoData(3) as $data)
                                                        <option value="{{$data->id}}" {{$order->district==$data->id?'selected':''}} >{{$data->name}}</option>
                                                        @endforeach
		                        			        </select>
		                        			        <select name="city" id="city" class="form-control form-control-sm">
		                        			            <option value="" >Select City</option>
		                        			            @if($order->district)
		                        			            @foreach(geoData(4,$order->district) as $data)
                                                        <option value="{{$data->id}}" {{$order->city==$data->id?'selected':''}} >{{$data->name}}</option>
                                                        @endforeach
                                                        @endif
		                        			        </select>
		                        			    </div>
		                        			    @if ($errors->has('district'))
                                                <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('district') }}</p>
                                                @endif
		                        			    @if ($errors->has('city'))
                                                <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('city') }}</p>
                                                @endif
		                        			    <input type="text" name="address" value="{{$order->address}}" placeholder="Enter address" class="form-control form-control-sm">
		                        			    @if ($errors->has('address'))
                                                <p style="color: red; margin: 0; font-size: 10px;">{{ $errors->first('address') }}</p>
                                                @endif
		                        			</td>
		                        		</tr>
										
		                        		<tr>
		                        			<th>Note:</th>
		                        			<td style="padding:3px;">
		                        			    <textarea name="note" placeholder="Write Note" class="form-control" >{{$order->note}}</textarea>
		                        			 </td>
		                        		</tr>
		                        		
		                        	</table>
		                        	</div>
                        		</div>
                        		<div class="col-md-6">
                        		    <div class="table-responsive orderSummery">
                        			    @include(adminTheme().'orders.includes.orderSummery')
		                        	</div>
                        		</div>
                        	</div>
                        	
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                        <h4 class="card-title">Orders Item</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6" style="padding:15px;">
                                    <div class="SearchContain">
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="text-align: center;padding: 10px;">
                                                    <i class="fa fa-search"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control serchProducts" data-url="{{route('admin.ordersAction',['search-product',$order->id])}}" placeholder="Search Product Name,ID, Barcode" autocomplete="off">
                                        </div>
                                        <div class="searchResultlist">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
			                <div class="table-responsive m-t orderItem">
			                    @include(adminTheme().'orders.includes.orderItems')
			                </div>
			                <!-- /table-responsive -->
                        </div>
                    </div>
                </div>
                
                </form>
                
                <div class="card">
                    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;padding: 1rem;">
                        <div class="row">
                        	<div class="col-md-6">
                        		<h4 class="card-title" style="padding: 5px;">Order Payment</h4>
                        	</div>
                        	<div class="col-md-6">
                        		<div class="left-tools" style="text-align: right;">
                        			<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#payment" style="padding: 8px 15px;border-radius: 0;"> <i class="fas fa-money"></i> payment</button>
                        		</div>
                        	</div>
                        </div>
                        
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                        	<h4>All Transactions:</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th style="min-width:150px;">Billing By</th>
                                    <th style="min-width:300px;">Billing Info</th>
                                    <th style="min-width:300px;">Note</th>
                                    <th style="min-width:150px;">Amount</th>
                                </tr>
                               @foreach($order->transactionsAll as $i=>$transaction)
                               <tr>
                                <td>
                                    <b>TNX:</b> {{$transaction->transection_id}}<br>
                                    <b>Method:</b> {{$transaction->method?$transaction->method->name:''}}<br>
                                    
                                    <b>Date:</b> {{$transaction->created_at->format('Y-m-d h:i A')}}
                                </td>
                                <td>
                                    <b>Name:</b> {{$transaction->billing_name}} <br>
                                    <b>Mobile:</b> {{$transaction->billing_mobile}} <br>
                                    <b>E-mail:</b> {{$transaction->billing_email}} <br>
                                </td>
                                <td>
                                    <b>Type: </b>@if($transaction->type==1)
                                    <span class="badge badge-success" style="background:#00bcd4;">Recharge</span>
                                    @elseif($transaction->type==2)
                                    <span class="badge badge-success" style="background:#ff9800;">Re-fund Order</span>
                                    @else
                                    <span class="badge badge-success" style="background:#8bc34a;">Order Payment</span>
                                    @endif <br>
                                    <b>Address:</b> {{$transaction->billing_address}}<br>
                                    <b>Note:</b> {{$transaction->billing_note}}
                                </td>
                                <td>{{$transaction->currency}} {{number_format($transaction->amount,2)}}
                                    <br>
                                    <b>Status:</b> {{ucfirst($transaction->status)}}
                                    <br>
                                    <a href="{{route('admin.ordersAction',['payment-delete',$order->id,'transection_id'=>$transaction->id])}}" class="btn btn-danger btn-sm" onclick="return confirm('Are You Want To Delete?')">Delete</a>
                                </td>
                               </tr>
                               @endforeach
                               @if($order->transactionsAll->count()==0)
                               <tr>
                                   <td colspan="4" style="text-align:center;">
                                           <span>No Transaction</span>
                                   </td>
                               </tr>
                               @endif
                            </table>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </section>
</div>


<div class="paymentBill">
    @include(adminTheme().'orders.includes.paymentModal')
</div> 

@endsection 

@push('js')

<script>
    $(document).ready(function(){
        
        $(".searchResultlist").hide();
        $(document).on('click', function(e) {
            var container = $(".SearchContain");
            var containerClose = $(".searchResultlist");
            if (!$(e.target).closest(container).length) {
                containerClose.hide();
            }else{
                containerClose.show();
            }
        });
        
        $(document).on("click", ".add-note-btn", function() {
            let parent = $(this).closest(".adminNoteAdd");
            let orderId = parent.data("order-id");
            let input = parent.find(".note-input");
            let noteText = input.val().trim();
    
            if (noteText === "") {
                alert("Please enter a note!");
                return;
            }
    
            $.ajax({
                url: "{{ route('admin.ordersAction', ['admin-note-add', $order->id]) }}".replace("{{ $order->id }}", orderId),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    note: noteText
                },
                success: function(response) {
                    if (response.status === "success") {
                        let newNote = `
                            <li class="note-item" data-index="${response.index}">
                                <span>${response.note[0]} - <small>Msg By: ${response.note[1]} ${response.note[2]}</small></span>
                                <span class="btn btn-sm btn-danger remove-note-btn">Delete</span>
                            </li>`;
                        parent.find(".notes-list").append(newNote);
                        input.val("");
                    } else {
                        alert("Failed to add note!");
                    }
                }
            });
        });
        
        $(document).on("click", ".remove-note-btn", function() {
            if (!confirm("Are you sure you want to delete this note?")) return;
    
            let parent = $(this).closest(".adminNoteAdd");
            let orderId = parent.data("order-id");
            let noteItem = $(this).closest(".note-item");
            let noteIndex = noteItem.data("index");
    
            $.ajax({
                url: "{{ route('admin.ordersAction', ['admin-note-remove', $order->id]) }}".replace("{{ $order->id }}", orderId),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    index: noteIndex
                },
                success: function(response) {
                    if (response.status === "success") {
                        noteItem.remove();
                    } else {
                        alert("Failed to delete note!");
                    }
                }
            });
        });
        
        var key;
        
        $(document).on('click','.searchResultlist ul li, .itemRemove',function(){
            url =$(this).data('url');
            id =$(this).data('id');
            variant =$(this).data('variant');
            AjaxParchaseItems(url,id,key,variant);
            $(".searchResultlist").hide();
        });
        
        $('.paymentType').click(function(){
            var amount =$(this).data('amount');
            
            if(amount==0){
                amount='';
            }
            $('.PayAmount').val(amount);

        });
        
        $(document).on('change','.selectWarehouse',function(){
            url =$(this).data('url');
            id =$(this).data('id');
            key =$(this).val();
            var status =true;
            $('.warehouseErro').empty();
            if(key =='' || key==null || key=='undefined' || isNaN(key)){
                $('.warehouseErro').empty().append('This Field is Required');
                status=false;
            }
            if(status){
                AjaxParchaseItems(url,id,key);
            }
        });
        
        
        $(document).on('change keyup', '.mobileNumberChange', function() {
            let url = $(this).data('url');
            let key = $(this).val();
        
            if (key.length === 11) {
                $.ajax({
                    url: url,
                    dataType: 'json',
                    cache: false,
                    data: { 'key': key },
                    success: function(data) {
                        $('.customerStatus').empty().append(data.view);
                    },
                    error: function() {
                        // Optional: handle error case
                        $('.customerStatus').empty().append('<span style="color:red;">Error fetching data.</span>');
                    }
                });
            } else {
                $('.customerStatus').empty();
            }
        });

        $(document).on('change','.courierSelect',function(){
            url =$(this).data('url');
            key =$(this).val();
            $.ajax({
                url:url,
                dataType: 'json',
                cache: false,
                data: {'key':key},
                success : function(data){
                    $('.courierData').empty().append(data.view);
                },error: function () {
                    // alert('error')
                    }
                });
                
        });
        
        $(document).on('change', '.courierDistrict', function () {

            url =$(this).data('url');
            key =$(this).val();
        
            if(key){
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: { city_id: key },
                    success: function (res) {
                        let cityDropdown = $('.courierCity');
                        cityDropdown.empty().append('<option value="">Select Area</option>');
        
                        $.each(res.zones, function (index, zone) {
                            cityDropdown.append('<option value="' + zone.zone_id + '">' + zone.zone_name + '</option>');
                        });
                        console.log(res.zones);
                    }
                });
            }
        });

        
        $(document).on('change','.itemUpdatePurchase, .adjustmentUpdate',function(){
            id =$(this).data('id');
            url =$(this).data('url');
            key =$(this).val();
            if(isNaN(key)){
                key=0;
            }
            AjaxParchaseItems(url,id,key);
        });
        
        function AjaxParchaseItems(url,id,key,variant=null){

            $.ajax({
            url:url,
            dataType: 'json',
            cache: false,
            data: {'key':key,'item_id':id,'variant_id':variant},
            success : function(data){
                $('.orderSummery').empty().append(data.infoView);
                $('.paymentBill').empty().append(data.datasBill);
                $('.orderItem').empty().append(data.view);
            },error: function () {
                // alert('error')
                }
            });

        }
        
        $(document).on('change','.districtFilter',function(){
            var url =$(this).data('url');
            key =$(this).val();
            if(key==''){
               $('#city').empty().append('<option value="">No City</option>');
            }
            $.ajax({
            url:url,
            dataType: 'json',
            cache: false,
            data: {'key':key},
            success : function(data){
                $('#city').empty().append(data.geoData);
                $('.orderSummery').empty().append(data.infoView);
            },error: function () {
                // alert('error')
                }
            });
        });
        
        $(document).on('change','.shippingChargeApply',function(){
            var url =$(this).data('url');
            $.ajax({
            url:url,
            dataType: 'json',
            cache: false,
            success : function(data){
                $('.orderSummery').empty().append(data.infoView);
            },error: function () {
                // alert('error')
                }
            });
        });
        
        $(document).on('keyup','.serchProducts',function(){

            key =$(this).val();
            url =$(this).data('url');
            if(key.length > 0){
                $.ajax({
                url:url,
                dataType: 'json',
                cache: false,
                data: {'key':key},
                success : function(data){
                    $('.searchResultlist').empty().append(data.view);
                    $(".searchResultlist").show();
                },error: function () {
                    // alert('error');
        
                    }
                });
            
            }
        });
        
        
    });
</script>

@endpush