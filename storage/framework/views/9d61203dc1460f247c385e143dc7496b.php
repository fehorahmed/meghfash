 
<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Order Manage')); ?></title>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
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
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Order Manage</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Order Manage</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.orders')); ?>"><i class="fa fa-list"></i> Back</a>
            
            <a class="btn btn-success" href="<?php echo e(route('admin.invoice',$order->id)); ?>"><i class="fa fa-print"></i> Invoice</a>
            
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.ordersAction',['manage',$order->id])); ?>">
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
			    <?php echo $__env->make('admin.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			    <form  method="post" action="<?php echo e(route('admin.ordersAction',['update',$order->id])); ?>">
				<?php echo csrf_field(); ?>
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
		                        			<td><?php echo e($order->invoice); ?></td>
		                        		</tr>
		                        		<tr>
		                        			<th>Created Date*</th>
		                        			<td style="padding:3px;">
		                        			    <input type="datetime-local" name="created_at" value="<?php echo e($order->created_at->format('Y-m-d\TH:i')); ?>" class="form-control form-control-sm" required>
		                        			 </td>
		                        		</tr>
		                        		<tr>
		                        			<th>Store/Branch*</th>
		                        			<td style="padding:3px;">
                                                <?php if($order->order_status == 'confirmed' || $order->order_status == 'shipped' || $order->order_status == 'delivered' || $order->order_status == 'returned'  || $order->order_status == 'cancelled'): ?>
                                                <input type="text" readonly value="<?php echo e($order->branch?$order->branch->name:''); ?>" class="form-control form-control-sm">
                                                <?php else: ?>
                                                <select class="form-control form-control-sm selectWarehouse" data-id="<?php echo e($order->id); ?>"  data-url="<?php echo e(route('admin.ordersAction',['warehouse-select',$order->id])); ?>">
                                                    <option value="">Select Store/Branch</option>
                                                    <?php $__currentLoopData = App\Models\Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($warehouse->id); ?>" <?php echo e($warehouse->id==$order->branch_id?'selected':''); ?>><?php echo e($warehouse->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php endif; ?>
                                                <span class="warehouseErro" style="color:red;"></span>
                                            </td>
		                        		</tr>
		                        		<tr>
		                        			<th>Name*</th>
		                        			<td style="padding:3px;">
		                        			    <input type="text" name="name" value="<?php echo e($order->name); ?>" placeholder="Enter name" class="form-control form-control-sm" required="">
		                        			    <?php if($errors->has('name')): ?>
                                                <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('name')); ?></p>
                                                <?php endif; ?>
		                        			 </td>
		                        		</tr>
		                        		<tr>
		                        			<th>Mobile*</th>
		                        			<td style="padding:3px;">
		                        			    <input type="text" name="mobile" value="<?php echo e($order->mobile); ?>" placeholder="Enter mobile" class="form-control form-control-sm  mobileNumberChange" data-url="<?php echo e(route('admin.ordersAction',['user-courier-status',$order->id])); ?>" required="" >
		                        			    <?php if($errors->has('mobile')): ?>
                                                <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('mobile')); ?></p>
                                                <?php endif; ?>
		                        			</td>
		                        		</tr>
		                        		<tr>
		                        			<th>Email</th>
		                        			<td style="padding:3px;" >
		                        			    <input type="email" name="email" value="<?php echo e($order->email); ?>" placeholder="Enter email" class="form-control form-control-sm">
		                        			</td>
		                        		</tr>
		                        		<tr>
		                        			<th>Address:</th>
		                        			<td style="padding:3px;" >
		                        			    <div class="input-group">
		                        			        <select name="district"  
		                        			        class="form-control form-control-sm districtFilter" data-url="<?php echo e(route('admin.ordersAction',['district-filter',$order->id])); ?>" >
		                        			            <option value="" >Select District</option>
		                        			            <?php $__currentLoopData = geoData(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($data->id); ?>" <?php echo e($order->district==$data->id?'selected':''); ?> ><?php echo e($data->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                        			        </select>
		                        			        <select name="city" id="city" class="form-control form-control-sm">
		                        			            <option value="" >Select City</option>
		                        			            <?php if($order->district): ?>
		                        			            <?php $__currentLoopData = geoData(4,$order->district); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($data->id); ?>" <?php echo e($order->city==$data->id?'selected':''); ?> ><?php echo e($data->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
		                        			        </select>
		                        			    </div>
		                        			    <?php if($errors->has('district')): ?>
                                                <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('district')); ?></p>
                                                <?php endif; ?>
		                        			    <?php if($errors->has('city')): ?>
                                                <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('city')); ?></p>
                                                <?php endif; ?>
		                        			    <input type="text" name="address" value="<?php echo e($order->address); ?>" placeholder="Enter address" class="form-control form-control-sm">
		                        			    <?php if($errors->has('address')): ?>
                                                <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('address')); ?></p>
                                                <?php endif; ?>
		                        			</td>
		                        		</tr>
										
		                        		<tr>
		                        			<th>Note:</th>
		                        			<td style="padding:3px;">
		                        			    <textarea name="note" placeholder="Write Note" class="form-control" ><?php echo e($order->note); ?></textarea>
		                        			 </td>
		                        		</tr>
		                        		
		                        	</table>
		                        	</div>
                        		</div>
                        		<div class="col-md-6">
                        		    <div class="table-responsive orderSummery">
                        			    <?php echo $__env->make(adminTheme().'orders.includes.orderSummery', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                                            <input type="text" class="form-control serchProducts" data-url="<?php echo e(route('admin.ordersAction',['search-product',$order->id])); ?>" placeholder="Search Product Name,ID, Barcode" autocomplete="off">
                                        </div>
                                        <div class="searchResultlist">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
			                <div class="table-responsive m-t orderItem">
			                    <?php echo $__env->make(adminTheme().'orders.includes.orderItems', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                               <?php $__currentLoopData = $order->transactionsAll; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                               <tr>
                                <td>
                                    <b>TNX:</b> <?php echo e($transaction->transection_id); ?><br>
                                    <b>Method:</b> <?php echo e($transaction->method?$transaction->method->name:''); ?><br>
                                    
                                    <b>Date:</b> <?php echo e($transaction->created_at->format('Y-m-d h:i A')); ?>

                                </td>
                                <td>
                                    <b>Name:</b> <?php echo e($transaction->billing_name); ?> <br>
                                    <b>Mobile:</b> <?php echo e($transaction->billing_mobile); ?> <br>
                                    <b>E-mail:</b> <?php echo e($transaction->billing_email); ?> <br>
                                </td>
                                <td>
                                    <b>Type: </b><?php if($transaction->type==1): ?>
                                    <span class="badge badge-success" style="background:#00bcd4;">Recharge</span>
                                    <?php elseif($transaction->type==2): ?>
                                    <span class="badge badge-success" style="background:#ff9800;">Re-fund Order</span>
                                    <?php else: ?>
                                    <span class="badge badge-success" style="background:#8bc34a;">Order Payment</span>
                                    <?php endif; ?> <br>
                                    <b>Address:</b> <?php echo e($transaction->billing_address); ?><br>
                                    <b>Note:</b> <?php echo e($transaction->billing_note); ?>

                                </td>
                                <td><?php echo e($transaction->currency); ?> <?php echo e(number_format($transaction->amount,2)); ?>

                                    <br>
                                    <b>Status:</b> <?php echo e(ucfirst($transaction->status)); ?>

                                    <br>
                                    <a href="<?php echo e(route('admin.ordersAction',['payment-delete',$order->id,'transection_id'=>$transaction->id])); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are You Want To Delete?')">Delete</a>
                                </td>
                               </tr>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                               <?php if($order->transactionsAll->count()==0): ?>
                               <tr>
                                   <td colspan="4" style="text-align:center;">
                                           <span>No Transaction</span>
                                   </td>
                               </tr>
                               <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </section>
</div>


<div class="paymentBill">
    <?php echo $__env->make(adminTheme().'orders.includes.paymentModal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div> 

<?php $__env->stopSection(); ?> 

<?php $__env->startPush('js'); ?>

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
                url: "<?php echo e(route('admin.ordersAction', ['admin-note-add', $order->id])); ?>".replace("<?php echo e($order->id); ?>", orderId),
                type: "POST",
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
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
                url: "<?php echo e(route('admin.ordersAction', ['admin-note-remove', $order->id])); ?>".replace("<?php echo e($order->id); ?>", orderId),
                type: "POST",
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
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

<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/orders/ordersManage.blade.php ENDPATH**/ ?>