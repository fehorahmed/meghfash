
 <?php $__env->startSection('title'); ?>
<title>Stock manage</title>
<?php $__env->stopSection(); ?> 
<?php $__env->startPush('css'); ?>
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
<?php $__env->stopPush(); ?> 

<?php $__env->startSection('contents'); ?>


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Stock Manage</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Stock Manage</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.stockTransfer')); ?>"><i class="fa fa-list"></i> Back</a>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.stockTransferAction',$invoice->id)); ?>">
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
            	<div class="card">
                    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                        <h4 class="card-title">Stock Manage</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.stockTransferAction',['update',$invoice->id])); ?>" method="post">
                                    <?php echo csrf_field(); ?>
                            <div class="updateForm">
                            
                                <div class="orderInformation">
                                    <?php echo $__env->make(adminTheme().'stock-transfer.includes.transferInformation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                                                <input type="text" class="form-control serchProducts" data-url="<?php echo e(route('admin.stockTransferAction',['search-product',$invoice->id])); ?>" placeholder="Search Product Name" autocomplete="off">
                                            </div>
                                            <div class="searchResultlist">
                                                <?php echo $__env->make(adminTheme().'stock-transfer.includes.searchResult', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                                            <input type="text" class="form-control serchBarcodeProdut" data-url="<?php echo e(route('admin.stockTransferAction',['search-barcode-product',$invoice->id])); ?>" placeholder="Search Product Barcode" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                    
                                <div class="purchaseItemsSection">
                                            		
                    	            <?php echo $__env->make(adminTheme().'stock-transfer.includes.transferItems', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    
                                </div>
                            </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?>

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

        $(document).on('change','.selectWarehouse2',function(){
            url =$(this).data('url');
            key =$(this).val();
            $('.supplierErro').empty();
            if(key =='' || key==null || key=='undefined' || isNaN(key)){
                $('.supplierErro').empty().append('This Field is Required');
                status=true;
            }
            if(status){
                AjaxSelectCustomerWarehouse(url,key);
            }
        });

        $(document).on('change','.selectWarehouse',function(){
            url =$(this).data('url');
            key =$(this).val();
            $('.warehouseErro').empty();
            if(key =='' || key==null || key=='undefined' || isNaN(key)){
                $('.warehouseErro').empty().append('This Field is Required');
                status=true;
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

<?php $__env->stopPush(); ?>
<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/admin/stock-transfer/transferEdit.blade.php ENDPATH**/ ?>