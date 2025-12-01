 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Orders List')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css">
     .card .card-header {
        margin-bottom: 10px;
    }
    .orderItems table tr td {
        padding: 4px;
        text-align: center;
        vertical-align: middle;
    }

    .orderItems table tr th {
        color: white;
        padding: 5px;
        background: #17a2b8;
        text-align: center;
    }
    .orderItems {
        height: 200px;
        overflow: auto;
    }
    .orderItems::-webkit-scrollbar {
        width: 3px;
    }
    .orderItems::-webkit-scrollbar-track {
        background: #f1f1f1; 
    }
    .orderItems::-webkit-scrollbar-thumb {
        background: #888; 
    }
    .GrandTotal {
        background: #c1c513;
        text-align: center;
        font-size: 20px;
        padding: 5px;
        color: white;
        font-weight: bold;
    }
    .productList {
        height: 400px;
        overflow: auto;
    }
    .productList::-webkit-scrollbar {
        width: 3px;
    }
    .productList::-webkit-scrollbar-track {
        background: #f1f1f1; 
    }
    .productList::-webkit-scrollbar-thumb {
        background: #888; 
    }

    .addCart:hover .addItemCart{
        display:grid;
    }
    .addItemCart {
        color: #17a2b8;
        z-index: 9;
        position: absolute;
        height: 100%;
        width: 100%;
        background: #dcdcdc5c;
        vertical-align: middle;
        align-items: center;
        display: none;
        margin: auto;
        text-align: center;
        font-size: 50px;
    }
    .removeItem{
        background: #dc3545;
        padding: 5px 6px;
        display: inline-block;
        line-height: 10px;
        color: white;
        border-radius: 30px;
        font-size: 12px;
        cursor: pointer;
        margin-left: 5px;
        float: right;
    }

    .quantity input[type="number"]::-webkit-inner-spin-button,
    .quantity input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0; /* Optional: Remove margin */
    }
    .quantity input[type="number"] {
        -moz-appearance: textfield; /* Firefox */
    }
    .quantity input {
        width: 50px;
        text-align: center;
        border: none;
    }
    .minus, .plus {
        font-size: 14px;
        background: #17a2b8;
        padding: 1px 4px;
        padding-top: 2px;
        color: white;
        border-radius: 3px;
        cursor: pointer;
    }

    .summeryTable tr th {
        font-size: 12px;
        padding: 5px;
    }

    .summeryTable tr td {
        padding: 5px;
        font-size: 12px;
    }
    .transectionTable tr th {
        padding: 5px;
        font-size: 12px;
    }

    .transectionTable tr td {
        padding: 5px;
        font-size: 14px;
    }
    .removePayment {
        background: #e1000a;
        padding: 3px 5px;
        border-radius: 5px;
        font-size: 12px;
        float: right;
        color: white;
        cursor: pointer;
    }
    .invoiceHead {
        text-align: center;
    }

    .invoiceHead p span {
        display: block;
        font-size: 14px;
        line-height: 16px;
    }
    .invoiceBody tr th {
        padding: 2px 5px;
        border-bottom: 1px solid #eae7e7;
    }

    .invoiceBody tr td {
        padding: 2px 5px;
        font-size: 13px;
        border-bottom: 3px dotted #dddddd;
    }
    .paymentTable tr th {
        background: #eeeeee;
        padding: 3px 5px;
        font-size: 10px;
    }

    .paymentTable tr td {
        border-bottom: 3px dotted #ddd;
        padding: 2px 5px;
        font-size: 12px;
    }
    
    .searchCustomerResult ul {
        padding: 0;
        list-style: none;
        border: 1px solid #e8e6e6;
    }
    
    .searchCustomerResult {
        position: absolute;
        background: white;
        width: 100%;
        height: 170px;
        overflow: auto;
        display:none;
    }
    
    .searchCustomer {
        position: relative;
    }
    
    .searchCustomerResult ul li {
        padding: 0 10px;
        border-bottom: 1px solid #e4e4e4;
    }
    
    .searchCustomerResult::-webkit-scrollbar {
      width: 1px;
    }
    
    .searchCustomerResult::-webkit-scrollbar-track {
      background: #f1f1f1; 
    }
     
    .searchCustomerResult::-webkit-scrollbar-thumb {
      background: #888; 
    }
    
    
</style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="flex-grow-1">
    
    <div class="row">
        <div class="col-md-7">
            <div class="card mb-30">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>POS Sale</h3>
                </div>
                <div class="card-body">
                    <div class="SaleHead">
                        <div class="shoppingCart">
                            <?php echo $__env->make(adminTheme().'pos-orders.includes.shoppingCart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
        <div class="card mb-30">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Product Items</h3>
                </div>
                <div class="card-body">
                        <div class="row" style="margin:0 -5px;">
                            <div class="col-md-12" style="padding:5px;">
                                <label>Search Product</label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text" style="text-align: center;">
                                            <i class="fa fa-barcode"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control seachProduct" data-url="<?php echo e(route('admin.posOrdersAction',['productFilter',$invoice->id])); ?>" placeholder="Search Name,Barcode" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6" style="padding:5px;">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control form-control-sm categoryFilter" data-type="category" data-url="<?php echo e(route('admin.posOrdersAction',['productFilter',$invoice->id])); ?>">
                                        <option value="">Select Category</option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" ><?php echo e($category->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" style="padding:5px;">
                                <div class="form-group">
                                    <label>Brand</label>
                                    <select class="form-control form-control-sm brandFilter" data-type="brand" data-url="<?php echo e(route('admin.posOrdersAction',['productFilter',$invoice->id])); ?>">
                                        <option value="">Select Brand</option>
                                        <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($brand->id); ?>" ><?php echo e($brand->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                    <div class="productList">
                        <?php echo $__env->make(adminTheme().'pos-orders.includes.productsList', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Order List  Modal -->
<div class="modal fade text-left" id="orderListModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
    	   <div class="modal-header" style="padding: 5px 10px;background: #17a2b8;">
    		 <h4 class="modal-title" style="font-size: 20px;color: white;">Sales List</h4>
    		 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    		   <span aria-hidden="true">&times; </span>
    		 </button>
    	   </div>
    	   <div class="modal-body orderListAll">
                
            </div>
	    </div>
    </div>
 </div>



<?php $__env->stopSection(); ?> 
<?php $__env->startPush('js'); ?>
<script>
    $(document).ready(function(){
        $(document).on('click', function(event) {
            if (!$(event.target).closest('.searchCustomer').length) {
                $('.searchCustomerResult').hide();  // Hide result list if clicked outside
            }
        });
        
        $(document).on('click','.searchCustomer input',function(){
            $('.searchCustomerResult').show();
        })
        
        $(document).on('keyup','.searchCustomer input',function(){
            var query = $(this).val();
            if (query.length > 0) {
                var url =$(this).data('url');
                $('.searchCustomerResult').show();
                $.ajax({
                url:url,
                dataType: 'json',
                cache: false,
                data:{'search':query},
                success : function(data){
                    $('.searchCustomerResult').empty().append(data.view);
                },error: function () {
                    // alert('error');
                    }
                });
                
                  // Show the result list when typing
            } else {
                $('.searchCustomerResult').hide();  // Hide when input is empty
            }
        });
        
        $(document).on('click','.NewCustomerAdd',function(){
            var url =$(this).data('url');
            var mobile =$('.NewCustomerMobile').val();
            var name =$('.NewCustomerName').val();
            
            if(mobile==null || mobile=='' || mobile=='undefined'){
                alert('Please write Mobile number');
            }
            
            if(mobile.length > 0){
                
                $.ajax({
                    url:url,
                    dataType: 'json',
                    cache: false,
                    data:{'name':name,'mobile':mobile},
                    success : function(data){
                        $('.shoppingCart').empty().append(data.shoppingCart);
                        if(data.message){
                            $('.errorMsg').empty().append(data.message);
                        }
                    },error: function () {
                        // alert('error');
                        }
                });
            
            }
            
        });
        
        $(document).on('click','.shoppingCart .plus,.shoppingCart .minus,.shoppingCart .removeItem',function(){
            var url =$(this).data('url');
            var key;
            cartUpdate(url,key);
        });

        $(document).on('change','.quantity input',function(){
            var url =$(this).data('url');
            var key =$(this).val();
            if(key==null || key=='' || key=='undefined'){
                key =1;
            }
        });

        // $(document).on('change','.selectCustomer',function(){
        $(document).on('click','.selectCustomer',function(){
            var url =$(this).data('url');
            // var key =$(this).val();
            // if(key==null || key=='' || key=='undefined'){
            //     key =0;
            // }
            $.ajax({
            url:url,
            dataType: 'json',
            cache: false,
            // data:{'customer_id':key},
            success : function(data){
                $('.shoppingCart').empty().append(data.shoppingCart);
                if(data.message){
                    $('.errorMsg').empty().append(data.message);
                }
            },error: function () {
                // alert('error');
                }
            });
        });

        $(document).on('change','.selectWarehouse',function(){
            var url =$(this).data('url');
            var key =$(this).val();
            if(key==null || key=='' || key=='undefined'){
                key =0;
            }
            $.ajax({
            url:url,
            dataType: 'json',
            cache: false,
            data:{'warehouse_id':key},
            success : function(data){
                $('.shoppingCart').empty().append(data.shoppingCart);
                if(data.message){
                    $('.errorMsg').empty().append(data.message);
                }
                $('.productList').empty().append(data.view);
            },error: function () {
                // alert('error');
                }
            });
        });

        $(document).on('click','.UpdateDiscount',function(){
            var url =$(this).data('url');
            var key =$('.DiscountInput').val();
            if(key==null || key=='' || key=='undefined'){
                key =0;
            }
            var discountType =$('.DiscountType').val();
            if(discountType==null || discountType=='' || discountType=='undefined'){
                discountType ='percantage';
            }
            $('#DiscountAmount').modal('hide');
            $.ajax({
                url:url,
                dataType: 'json',
                cache: false,
                data:{'key':key,'discountType':discountType},
                success : function(data){
                    $('.shoppingCart').empty().append(data.shoppingCart);
                    if(data.message){
                        $('.errorMsg').empty().append(data.message);
                    }
                },error: function () {
                    // alert('error');
                    }
                });
        });

        
        
        $(document).on('click','.UpdateShipping',function(){
            var url =$(this).data('url');
            var key =$('.ShppingInput').val();
            if(key==null || key=='' || key=='undefined'){
                key =0;
            }
            $('#ShippingAmount').modal('hide');
            cartUpdate(url,key);
        });

        $(document).on('click','.UpdateTax',function(){
            var url =$(this).data('url');
            var key =$('.TaxInput').val();
            if(key==null || key=='' || key=='undefined'){
                key =0;
            }
            $('#TaxAmount').modal('hide');
            cartUpdate(url,key);
        });


        function cartUpdate(url,key){
            
            $.ajax({
            url:url,
            dataType: 'json',
            cache: false,
            data:{'key':key},
            success : function(data){
                $('.shoppingCart').empty().append(data.shoppingCart);
                if(data.message){
                    $('.errorMsg').empty().append(data.message);
                }
            },error: function () {
                // alert('error');
                }
            });
        }

        $(document).on('click','.errorMsg',function(){
            $('.errorMsg').empty();
        });
        $(document).on('click','.addItemCart',function(){
            var url =$(this).data('url');
            $.ajax({
            url:url,
            dataType: 'json',
            cache: false,
            success : function(data){
                $('.shoppingCart').empty().append(data.shoppingCart);
            },error: function () {
                // alert('error');
                }
            });
        });

        $(document).on('keyup','.seachProduct',function(){
            var name=$(this).val();
            var type='search';
            var url =$(this).data('url');
            searchProduct(name,type,url);
        });
        $(document).on('change','.categoryFilter,.brandFilter',function(){
            var name=$(this).val();
            var type=$(this).data('type');
            var url =$(this).data('url');
            searchProduct(name,type,url);
        });

        function searchProduct(name,type,url){
            $.ajax({
                url:url,
                dataType: 'json',
                cache: false,
                data: {'key':name,'type':type},
                success : function(data){
                    if(data.addCart){
                        $('.seachProduct').val('');
                        $('.shoppingCart').empty().append(data.shoppingCart);
                    }
                    $('.productList').empty().append(data.view);
                },error: function () {
                    // alert('error');
                    }
                });
        }

        $(document).on('keyup','.ReceivedAmount',function(){
            var amount =$(this).val();
            if(amount=='' || amount==null || amount=='undefined'){
                amount =0;
            }
            amount =parseInt(amount);
            var total =parseInt($(this).data('total'));
            if(total=='' || total==null || total=='undefined'){
                amount =0;
            }
            var returnAmount =0;
            if(amount > total ){
                returnAmount =amount -total;
            }
            $('.returnAmount').empty().append(returnAmount.toFixed(2));
        });

        $(document).on('click','.AddPayment',function(){
            var status=true;
            var url =$(this).data('url');
            var method =$('.paymentMethod').val();
            if(method=='' || method==null || method=='undefined'){
                $('.paymentMethodErr').empty().append('This Field is Required');
                status=false;
            }
            var amount =$('.ReceivedAmount').val();
            if(amount=='' || amount==null || amount=='undefined'){
                $('.receivedAmountErr').empty().append('This Field is Required');
                status=false;
            }

            if(status){
                $.ajax({
                url:url,
                dataType: 'json',
                cache: false,
                data: {'method':method,'amount':amount},
                success : function(data){
                    $('.paymentTransectionAll').empty().append(data.view);
                },error: function () {
                    // alert('error');
                    }
                });
            }

        });

        $(document).on('keyup','.saleNote',function(){
            var url =$(this).data('url');
            var key =$(this).val();
            $.ajax({
                url:url,
                dataType: 'json',
                cache: false,
                data:{'key':key},
                success : function(data){
                },error: function () {
                    // alert('error');
                }
            });
        });
        $(document).on('click','.removePayment',function(){
            if(confirm('Are You Want to Delete?')){
                var url =$(this).data('url');
                $.ajax({
                    url:url,
                    dataType: 'json',
                    cache: false,
                    success : function(data){
                        $('.paymentTransectionAll').empty().append(data.view);
                    },error: function () {
                        // alert('error');
                    }
                });
            }
        });
        
        $(document).on('click','.SalesList',function(){
        
            $('#orderListModal').modal('show');

            var url =$(this).data('url');
            $.ajax({
                url:url,
                dataType: 'json',
                cache: false,
                success : function(data){
                    $('.orderListAll').empty().append(data.view);
                },error: function () {
                        // alert('error');
                    }
            });

        });
                    
            
            
        $(document).on('click','.resetInvoice',function(){

            var url =$(this).data('url');
            $.ajax({
                url:url,
                dataType: 'json',
                cache: false,
                success : function(data){
                    $('.shoppingCart').empty().append(data.shoppingCart);
                },error: function () {
                        // alert('error');
                    }
            });

        });
        
        
        $(document).on('click','.CompletedOrder',function(){
            
            $('#PaymentAmount').modal('hide');

            var url =$(this).data('url');

            $.ajax({
                url:url,
                dataType: 'json',
                cache: false,
                success : function(data){
                    $('.shoppingCart').empty().append(data.shoppingCart);
                    $('.productList').empty().append(data.view);
                    setTimeout(function() {
                        $('.invoicePOS').empty().append(data.viewPOS);
                        $('#invoiceView').modal('show');
                    }, 1000);
                },error: function () {
                    // alert('error');
                }
            });

        });

    });
</script> 

<?php $__env->stopPush(); ?>
<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\posher-react-laravel\resources\views/admin/pos-orders/orderEdit.blade.php ENDPATH**/ ?>