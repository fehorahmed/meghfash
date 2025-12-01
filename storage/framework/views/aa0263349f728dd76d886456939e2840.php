 <?php $__env->startSection('title'); ?>
<title>Products Parcode Print - <?php echo e(general()->title); ?> | <?php echo e(general()->subtitle); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
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
    .printAreaBarcode{
        display:none;
    }
    input.itemUpdate::-webkit-inner-spin-button,
    input.itemUpdate::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0; /* Optional: Remove margin */
    }
    input.itemUpdate {
        -moz-appearance: textfield; /* Firefox */
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jsbarcode/3.5.1/JsBarcode.all.min.js"></script>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Products Barcode Print</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Products Barcode Print</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <?php if(isset(json_decode(Auth::user()->permission->permission, true)['products']['add'])): ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.products')); ?>">Back All</a>
            <a class="btn btn-outline-success" href="<?php echo e(route('admin.productsAction',['edit',$product->id])); ?>">Edit</a>
            <?php endif; ?>
            <button class="btn btn-success" id="PrintAction" ><i class="fa fa-print"></i> Print</button>
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
                        <h4 class="card-title">Products Barcode Print</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body" >
                            <!--<div style="padding:10px;max-width: 960px;">-->
                            <!--    <form class="<?php echo e(route('admin.productsAction',['barcode',$product->id])); ?>">-->
                            <!--        <input type="hidden" value="<?php echo e(request()->variation_id); ?>" name="variation_id">-->
                            <!--        <div class="input-group">-->
                            <!--            <input type="number" class="form-control" name="printItems" value="<?php echo e($printCount); ?>" placeholder="Print item count">-->
                            <!--            <div class="input-group-append">-->
                            <!--                <button class="input-group-text generate_Barcode" type="submit" style="cursor:pointer;" data-id="0">Update</button>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </form>-->
                            <!--</div>-->
                            
                           <div class="invoice-inner invoicePage PrintAreaContact" >
                                <style type="text/css">
                                    
                                    @media only screen and (max-width: 567px) {

                                    }
                                    
                                    @media print {
                                        body {
                                            background-color: #ffffff;
                                            height: 100%;
                                            overflow: hidden;
                                        }
                                        
                                    }
                                    
                                </style>
                                <div class="invoiceContainer">
                                
                                        <div>
                                            <style>
                                                #barcodeContainer {
                                                    display: -ms-flexbox;
                                                    display: flex;
                                                    -ms-flex-wrap: wrap;
                                                    flex-wrap: wrap;
                                                    padding:50px 0 0 0;
                                                    width: 960px;
                                                    max-width:960px;
                                                }
                                        
                                                #barcodeContainer .item {
                                                    /*-ms-flex: 0 0 150px;*/
                                                    /*flex: 0 0 150px;*/
                                                    width: 280px;
                                                    height: 180px;
                                                    text-align: center;
                                                    color: #000;
                                                    padding: 15px 5px;
                                                    /*border: 1px dashed #000;*/
                                                    margin: 10px 15px;
                                                    /*transform: rotate(90deg);*/
                                                    /*margin-left: -60px;*/
                                                    /*margin-bottom: -10px;*/
                                                    /*margin-left: -40px;*/
                                                    /*margin-bottom: -17px;*/
                                                    /*margin-top: 35px;*/
                                                    
                                                }
                                                .item .title {
                                                    display: block;
                                                    font-size: 14px;
                                                    margin-bottom:-4px;
                                                    color:black;
                                                }
                                                .item .title b b {
                                                    font-size: 16px;
                                                }
                                                .item .price {
                                                    display: block;
                                                    font-weight: bold;
                                                }
                                                .item svg {
                                                    width: 100%;
                                                }
                                            </style>
                                            <div id="barcodeContainer"></div>
                                            <script>
                                                var products = [];
                                                <?php if(!empty($items)): ?>
                                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    for($ii=0;$ii < <?php echo e($item['quantity']); ?>;$ii++){
                                                        products.push({
                                                            id: <?php echo e($item['id']); ?>,
                                                            name: "<?php echo $item['name']; ?>",
                                                            barcode: "<?php echo e($item['bar_code']); ?>",
                                                            price: "<?php echo e($item['price']); ?>"
                                                        });
                                                    }
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                                // Loop through products array to generate barcodes
                                                products.forEach(function(product){
                                                    // Create a new <div> element for each product
                                                    var $barcodeDiv = $("<div class='item'>");
                                                    <?php if($title=='yes'): ?>
                                                    $barcodeDiv.append("<span class='title'><b>" + product.name + "</b></span>");
                                                    <?php endif; ?>
                                                    $barcodeDiv.append("<svg class='barcode"+product.id+"'></svg>");
                                                    <?php if($price=='yes'): ?>
                                                    $barcodeDiv.append("<span class='price'>" + product.price + "</span>");
                                                    <?php endif; ?>
                                                    $barcodeDiv.append("</div>");
                                                    $("#barcodeContainer").append($barcodeDiv);
                                                });
                                                products.forEach(function(product){
                                                JsBarcode(".barcode"+product.id, product.barcode, {
                                                        textAlign: "center",
                                                        textPosition: "center",
                                                        format: "CODE128",
                                                        font: "cursive",
                                                        fontSize: 18,
                                                        height: 40,
                                                        textMargin: 1,
                                                        displayValue: true
                                                        });
                                                });
                                                
                                            </script>
                                        </div>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                


            </div>
        </div>
    </section>
    <!-- Basic Inputs end -->
</div>

<?php $__env->stopSection(); ?> 

<?php $__env->startPush('js'); ?>



<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/products/productsPrintBarcode.blade.php ENDPATH**/ ?>