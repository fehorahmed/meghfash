@extends(adminTheme().'layouts.app')
 @section('title')
<title>Wholesale manage</title>
@endsection 
@push('css')
<style type="text/css">
    .table td, .table th {
        padding: .5rem;
        vertical-align: middle;
    }
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
	    height:250px;
	    overflow:auto;
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
@endpush 

@section('contents')


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Wholesale Manage</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item active">Wholesale Manage</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="{{route('admin.wholeSales')}}"><i class="fa fa-list"></i> Back</a>
            <a class="btn btn-outline-primary" href="{{route('admin.wholeSalesAction',$invoice->id)}}">
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
            	<div class="card">
                    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                        <h4 class="card-title">Stock Manage</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="{{route('admin.wholeSalesAction',['update',$invoice->id])}}" method="post">
                                    @csrf
                                <div class="updateForm">
                            
                                <div class="orderInformation">
                                    @include(adminTheme().'wholesale.includes.saleInformation')
                                </div>
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-5" style="padding:15px;">
                                        <div class="SearchContain">
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" style="text-align: center;padding: 10px;">
                                                        <i class="fa fa-search"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control serchProducts" data-url="{{route('admin.wholeSalesAction',['search-product',$invoice->id])}}" placeholder="Search Product Name, ID" autocomplete="off">
                                            </div>
                                            <div class="searchResultlist">
                                                @include(adminTheme().'wholesale.includes.searchResult')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-4" style="padding:15px;">
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="text-align: center;padding: 10px;">
                                                    <i class="fa fa-barcode"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control serchBarcodeProdut" data-url="{{route('admin.wholeSalesAction',['search-barcode-product',$invoice->id])}}" placeholder="Search Product Barcode" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                    
                                <div class="purchaseItemsSection">
                                            		
                    	            @include(adminTheme().'wholesale.includes.orderItems')
                    
                                </div>
                            </div>
                                </form>
                        </div>
                    </div>
                </div>
                
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
                               @foreach($invoice->transactionsAll as $i=>$transaction)
                               <tr>
                                <td>
                                    <b>TNX:</b> {{$transaction->transection_id}}<br>
                                    <b>Method:</b> {{$transaction->method?$transaction->method->name:''}}<br>
                                    
                                    <b>Date:</b> {{$transaction->created_at->format('Y-m-d')}}
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
                                    <a href="{{route('admin.wholeSalesAction',['payment-delete',$invoice->id,'transection_id'=>$transaction->id])}}" class="btn btn-danger btn-sm" onclick="return confirm('Are You Want To Delete?')">Delete</a>
                                </td>
                               </tr>
                               @endforeach
                               @if($invoice->transactionsAll->count()==0)
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
    @include(adminTheme().'wholesale.includes.paymentModal')
</div>



@endsection @push('js')

<script>
    $(document).ready(function () {
        
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

        var status=true;
        var url; 
        var key;
        var id;

        $(document).on('change','.updateInfo',function(){
            url =$(this).data('url');
            key =$(this).val();
            
            $.ajax({
                url:url,
                dataType: 'json',
                cache: false,
                data: {'key':key},
                success : function(data){
                    // $('.orderInformation').empty().append(data.infoView);
                    // $('.purchaseItemsSection').empty().append(data.view);
                },error: function () {
                    // alert('error');
                    }
            });
            
        });
        
        $(document).on('change','.selectSupplier',function(){
            url =$(this).data('url');
            key =$(this).val();
            // $('.supplierErro').empty();
            // if(key =='' || key==null || key=='undefined' || isNaN(key)){
            //     $('.supplierErro').empty().append('This Field is Required');
            //     status=false;
            // }
            // if(status){
            // }
            AjaxSelectCustomerWarehouse(url,key);
        });

        $(document).on('change','.selectWarehouse',function(){
            url =$(this).data('url');
            key =$(this).val();
            $('.warehouseErro').empty();
            if(key =='' || key==null || key=='undefined' || isNaN(key)){
                $('.warehouseErro').empty().append('This Field is Required');
                status=false;
            }
            if(status){
                AjaxSelectCustomerWarehouse(url,key);
            }
        });

        function AjaxSelectCustomerWarehouse(url,key){
            $.ajax({
            url:url,
            dataType: 'json',
            cache: false,
            data: {'key':key},
            success : function(data){
                $('.orderInformation').empty().append(data.infoView);
                $('.paymentBill').empty().append(data.datasBill);
                $('.purchaseItemsSection').empty().append(data.view);
            },error: function () {
                // alert('error');
                }
            });
        }
	
        $(document).on('click','.searchResultlist ul li,.itemRemove',function(){
            url =$(this).data('url');
            id =$(this).data('id');
            variant =$(this).data('variant');
            AjaxParchaseItems(url,id,key,variant);
            $(".searchResultlist").hide();
        });

        $(document).on('change','.itemUpdatePurchase',function(){
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
                $('.orderInformation').empty().append(data.infoView);
                $('.paymentBill').empty().append(data.datasBill);
                $('.purchaseItemsSection').empty().append(data.view);
            },error: function () {
                // alert('error')
                }
            });

        }

        $(document).on('change','.serchBarcodeProdut',function(e){
            e.preventDefault();
            key =$(this).val();
            url =$(this).data('url');
        
            if(key.length > 2){
                $.ajax({
                url:url,
                dataType: 'json',
                cache: false,
                data: {'key':key},
                success : function(data){
                    if(data.count > 1){
                        
                        $('.searchResultlist').empty().append(data.view);
                        $(".searchResultlist").show();
                        console.log('bouble');
                    }else{
                        console.log('singl');
                        $('.serchBarcodeProdut').val('');
                    }
                    $('.orderInformation').empty().append(data.infoView);
                    $('.purchaseItemsSection').empty().append(data.datasItems);
                },error: function () {
                    // alert('error');
                    }
                });
            }

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