 
<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Order Return Manage')); ?></title>
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
        <h3 class="content-header-title mb-0">Order Return Manage</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Order Return Manage</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.wholesaleReturn')); ?>"><i class="fa fa-list"></i> Back</a>
            
            <a class="btn btn-success" href="<?php echo e(route('admin.wholesaleReturnAction',['invoice',$order->id])); ?>"><i class="fa fa-print"></i> Invoice</a>
            
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.wholesaleReturnAction',['update',$order->id])); ?>">
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
			    <form  method="post" action="<?php echo e(route('admin.wholesaleReturnAction',['update',$order->id])); ?>">
    				<?php echo csrf_field(); ?>
    				
                	<div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Customer Info</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            	<div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Customer*</label>
                                            <input type="text" readonly value="<?php echo e($order->name); ?>" class="form-control">
                                            <span class="supplierErro" style="color:red;"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Store/Branch*</label>
                                            <input type="text" readonly value="<?php echo e($order->branch?$order->branch->name:''); ?>" class="form-control">
                                            <span class="warehouseErro" style="color:red;"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Invoice No*</label>
                                            <input type="text" name="invoice" value="<?php echo e($order->invoice); ?>" readonly class="form-control" placeholder="Enter Invoice No">
                                            <?php if($errors->has('invoice')): ?>
                                            <p style="color: red; margin: 0;"><?php echo e($errors->first('invoice')); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Stock Date*</label>
                                            <input type="date" value="<?php echo e($order->created_at->format('Y-m-d')); ?>" name="created_at" class="form-control" required="">
                                            <?php if($errors->has('created_at')): ?>
                                            <p style="color: red; margin: 0;"><?php echo e($errors->first('created_at')); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Note</label>
                                            <textarea class="form-control" name="note" placeholder="Write Invoice Note."><?php echo e($order->note); ?></textarea>
                                            <?php if($errors->has('note')): ?>
                                            <p style="color: red; margin: 0;"><?php echo e($errors->first('note')); ?></p>
                                            <?php endif; ?>
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
                                
                                <!--<div class="row">-->
                                <!--    <div class="col-md-3"></div>-->
                                <!--    <div class="col-md-6" style="padding:15px;">-->
                                <!--        <div class="SearchContain">-->
                                <!--            <div class="input-group">-->
                                <!--                <div class="input-group-append">-->
                                <!--                    <span class="input-group-text" style="text-align: center;padding: 10px;">-->
                                <!--                        <i class="fa fa-search"></i>-->
                                <!--                    </span>-->
                                <!--                </div>-->
                                <!--                <input type="text" class="form-control serchProducts" data-url="<?php echo e(route('admin.ordersAction',['search-product',$order->id])); ?>" placeholder="Search Product Name" autocomplete="off">-->
                                <!--            </div>-->
                                <!--            <div class="searchResultlist">-->
                                                
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                
				                <div class="table-responsive m-t orderItem">
                                    <?php echo $__env->make(adminTheme().'returns.includes.wholesaleOrderItems', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				                </div>


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
                        			<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#payment" style="padding: 8px 15px;border-radius: 0;"> <i class="fas fa-money"></i>Return payment</button>
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
                                    <a href="<?php echo e(route('admin.wholesaleReturnAction',['payment-delete',$order->id,'transection_id'=>$transaction->id])); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are You Want To Delete?')">Delete</a>
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


 <!-- Modal -->
 <div class="modal fade text-left" id="payment">
   <div class="modal-dialog" role="document">
	 <div class="modal-content">
	   <div class="modal-header">
		 <h4 class="modal-title">Return Payment</h4>
		 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		   <span aria-hidden="true">&times; </span>
		 </button>
	   </div>
	   <div class="modal-body">
	   		<ul class="nav nav-tabs" role="tablist" style="border-bottom: none;">
				<li class="nav-item">
					<a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" role="tab" aria-selected="true"> Return Payment</a>
				</li>
			</ul>
			<div class="tab-content px-1 pt-1" style="border: 1px solid #ddd;">
				<div class="tab-pane active" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
				<form action="<?php echo e(route('admin.wholesaleReturnAction',['payment',$order->id])); ?>" method="post">
					<?php echo csrf_field(); ?>
					<input type="hidden" value="0" name="transaction_type">
					<div class="form-group">
						<label>Return Amount</label>
						<input type="number" class="form-control PayAmount" step="any" name="amount" placeholder="Enter Amount" value="<?php echo e($order->due_amount?:''); ?>">
					</div>
					<div class="form-group">
						<label>Method</label>
						<div class="input-group">
						<select class="form-control" name="method" required="">
							<option value="">Select Method</option>
						<?php $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($method->id); ?>" ><?php echo e($method->name); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
						</div>
					</div>
					<div class="form-group">
						<label>Note</label>
						<textarea name="note" class="form-control" placeholder="Write Note.."></textarea>
					</div>
					<div class="input-group input-group-sm" style="width: 250px;margin:5px 0;">
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
					<br>
				</form>
				</div>

				
            </div>
	   </div>
	 </div>
   </div>
 </div>

<?php $__env->stopSection(); ?> 

<?php $__env->startPush('js'); ?>

<script>
    $(document).ready(function(){
        
        var id;
        var url;
        var key;
        
        $(document).on('change','.itemUpdate',function(){
            id =$(this).data('id');
            url =$(this).data('url');
            key =$(this).val();
            if(isNaN(key)){
                key=0;
            }
            AjaxParchaseItems(url,id,key);
        });
        
        function AjaxParchaseItems(url,id,key){

            $.ajax({
            url:url,
            dataType: 'json',
            cache: false,
            data: {'key':key,'item_id':id},
            success : function(data){
                // $('.orderSummery').empty().append(data.infoView);
                $('.orderItem').empty().append(data.view);
            },error: function () {
                // alert('error')
                }
            });

        }
        
    });
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/admin/returns/wholesaleReturnEdit.blade.php ENDPATH**/ ?>