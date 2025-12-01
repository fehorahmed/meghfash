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
        background: #168d09;
        text-align: right;
        font-size: 18px;
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
    .returnMinus, .returnPlus {
        font-size: 14px;
        background: #f7f7f7;
        padding: 1px 4px;
        padding-top: 2px;
        color: #ff0000;
        border-radius: 3px;
        cursor: pointer;
    }
    .summeryTable tr th {
        font-size: 18px;
        padding: 5px;
    }

    .summeryTable tr td {
        padding: 5px;
        font-size: 20px;
        text-align:center;
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
    .boxBar {
        border: 1px solid #168d09;
        padding: 10px;
        border-radius: 5px;
        background: #f9f9f9;
        /*min-height: 280px;*/
    }
    .boxBar h4 {
        font-weight: bold;
        font-family: sans-serif;
        border-bottom: 2px dotted #168d09;
        padding-bottom: 5px;
    }
    .Card_payment, .mobile_payment{
        display:none;
    }
    .returnQty {
        width: 50px !important;
        max-width: 50px;
        display: inline-block;
    }

    .filterResult {
        position: absolute;
        top: 45px;
        width: 100%;
    }
    
    .filterResult ul {
        padding: 0;
        margin: 0;
        background: white;
        width: 100%;
        list-style: none;
    }
    .filterResult ul li {
        cursor: pointer;
        border-bottom: 1px solid #e1dbdb;
    }
</style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="flex-grow-1">
    <?php echo $__env->make(adminTheme().'alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-md-9">
            <div class="card mb-30">
                <div class="card-header d-flex justify-content-between align-items-center" style="padding: 10px 15px;margin:0;">
                    <h3 style="margin:0;">POS Sale</h3>
                </div>
                <div class="card-body" style="padding:10px;">
                    <div class="SaleHead">
                        <div class="shoppingCart">
                            <?php echo $__env->make(adminTheme().'pos-orders.includes.shoppingCart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
        <div class="card mb-30">
                <div class="card-header d-flex justify-content-between align-items-center" style="padding: 10px 15px;">
                    <h3 style="margin:0;">Product Items</h3>
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
                                    <div class="input-group-append">
                                        <span class="input-group-text" style="text-align: center;cursor:pointer;">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    </div>
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
        });
        
        $(document).on('change','.searchInviceFilter',function(){
            var query = $(this).val();
            var url =$(this).data('url');
            $.ajax({
                url:url,
                dataType: 'json',
                cache: false,
                data:{'search':query},
                success : function(data){
                    
                    if(data.url){
                        $('.searchInviceFilterErr').empty().append('<span style="color:green;">Order has found wait..</span>');
                        window.location.replace(data.url);
                    }else{
                        $('.searchInviceFilterErr').empty().append('<span style="color:red;">Order can not Found</span>');
                    }
                    console.log(data);
                    
                    
                },error: function () {
                    // alert('error');
                }
            });
        });
        
        $(document).on('keyup','.searchCustomer input.searchValue',function(){
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
        
        
        $(document).on("click",".confirmInvoice", function () {
            submitOrder();
        });
        
        $(document).keydown(function(event) {
            if (event.key === "F2") {
               submitOrder();
            }
        });
        
        function submitOrder(){
            var amount = 0;
            $(".ReceivedAmountNew").each(function () {
                var value = parseFloat($(this).val().replace(/,/g, "")) || 0;
                amount += value;
            });
            var total = parseFloat($('.TotalAmount').attr('data-total')) || 0;
            if(total==0){
                alert('Minmum order item need to purchase.');
            }else if(total > amount){
                alert('Pay your due amount.');
                $('.confirmInvoice').attr('disabled',true);
            }else{
                
                let form = $('.SaleInfo');
                let redirectUrl = "<?php echo e(route('admin.posOrdersAction', 'create')); ?>";
                
                form.attr("target", "_blank");
                form.submit();
                
                setTimeout(function() {
                    window.location.href = redirectUrl;
                }, 100);
             
            }
        }
        
        $(document).on('click','.NewCustomerAdd',function(){
            var url =$(this).data('url');
            var mobile =$('.NewCustomerMobile').val();
            var name =$('.NewCustomerName').val();
            var card =$('.NewCustomerCard').val();
            
            if(mobile==null || mobile=='' || mobile=='undefined'){
                alert('Please write Mobile number');
            }
            
            if(mobile.length > 0){
                
                $.ajax({
                    url:url,
                    dataType: 'json',
                    cache: false,
                    data:{'name':name,'mobile':mobile,'card':card},
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
        
        function togglePaymentDivs() {
            // Get selected payment methods as an array
            var selectedValues = $('input[name="payment_method[]"]:checked').map(function () {
                return $(this).val();
            }).get();
        
            console.log("Selected Payment Methods:", selectedValues); // Debugging
        
            // Loop through each payment div and toggle visibility
            $(".Card_payment, .mobile_payment, .Gift_voucher, .discount_card").each(function () {
                var divClass = $(this).attr("class").split(" "); // Get all classes of the div
                var shouldShow = divClass.some(cls => selectedValues.includes(cls)); // Check if any class matches selected values
        
                if (shouldShow) {
                    $(this).show();
                } else {
                    $(this).hide();
                    $(this).find("input").val(""); // Clear input fields inside hidden divs
                }
            });
        }
        
        // Run function on checkbox change
        $(document).on("change", 'input[name="payment_method[]"]', function () {
            togglePaymentDivs();
        });
        
        // Run on page load to apply correct state
        $(document).ready(function () {
            togglePaymentDivs();
        });
        
        
        $(document).on('click','.shoppingCart .plus,.shoppingCart .minus, .shoppingCart .returnMinus, .shoppingCart .returnPlus , .shoppingCart .removeItem',function(){
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

        // $(document).on('change','.DiscountType',function(){
        //     var val =$(this).val();
        //      if (val === 'flat' || val === 'percantage') { 
        //         $('.DiscountInput').attr('disabled', false); // Enable input
        //     } else {
        //         $('.DiscountInput').attr('disabled', true); // Disable input
        //     }
        //     console.log(val);
        // });
        
        // $(document).on('click','.UpdateDiscount',function(){
        $(document).on('change','.DiscountInput , .DiscountType',function(){
            var url =$('.DiscountType').data('url');
            var key =$('.DiscountInput').val();
            if(key==null || key=='' || key=='undefined'){
                key =0;
            }
            var discountType =$('.DiscountType').val();
            if(discountType=='undefined'){
                discountType =null;
            }
            
            if (discountType === 'flat' || discountType === 'percantage') { 
                $('.DiscountInput').attr('disabled', false); // Enable input
            } else {
                key =0;
                $('.DiscountInput').attr('disabled', true); // Disable input
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

        $(document).on('change','.seachProduct',function(){
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

        $(document).on('keyup','.ReceivedAmountNew',function(){
            var amount = 0;

            $(".ReceivedAmountNew").each(function () {
                var value = parseFloat($(this).val().replace(/,/g, "")) || 0;
                amount += value;
            });

            var total = parseFloat($('.TotalAmount').attr('data-total')) || 0;
            var returnAmount = 0;
            if (amount > total) {
                returnAmount = amount - total;
            }
        
            var dueAmount = 0;
            if (total > amount) {
                dueAmount =total - amount;
            }
            
            if(total > amount){
                $('.confirmInvoice').attr('disabled',true);
            }else{
                if(total > 0){
                $('.confirmInvoice').attr('disabled',false);
                }else{
                    $('.confirmInvoice').attr('disabled',true);
                }
            }
            
            $('.dueAmountTotal').text(dueAmount.toFixed(2));
            $('.returnAmount').text(returnAmount.toFixed(2));
            $('.receivedTotalAmount').text(amount.toFixed(2));
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
<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/posherbd/public_html/resources/views/admin/pos-orders/orderEdit.blade.php ENDPATH**/ ?>