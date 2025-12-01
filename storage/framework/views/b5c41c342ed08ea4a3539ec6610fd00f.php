 <?php $__env->startSection('title'); ?>
<title>Products List - <?php echo e(general()->title); ?> | <?php echo e(general()->subtitle); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css">
    .card .card-header::before {
        content: '';
        width: 0;
        height: 0;
        border-top: 20px solid #37a000;
        border-right: 20px solid transparent;
        position: absolute;
        left: 0;
        top: 0;
    }
</style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Products List</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Products List</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.products')); ?>">Back All</a>
            <?php if(isset(json_decode(Auth::user()->permission->permission, true)['products']['add'])): ?>
            <a class="btn btn-outline-success" href="<?php echo e(route('admin.productsAction',['edit',$product->id])); ?>">Edit</a>
            <?php endif; ?>
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
                        <h4 class="card-title">Products View</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                           <div class="row">
                           	
	                           <div class="col-md-4">
	                           	<div class="productImage">
	                           		<img src="<?php echo e(asset($product->image())); ?>" style="max-width:100%;">
	                           	</div>
	                           </div>
	                           <div class="col-md-8">
	                           	   <table class="table table-bordered">
                                    <tr>
                                        <th style="min-width:250px;width:250px;">Name</th>
                                        <td><?php echo e($product->name); ?></td>
                                    </tr> 
                                    <tr>
                                        <th>ID </th>
                                        <td><?php echo e($product->id); ?></td>
                                    </tr>  
                                    <tr>
                                        <th>Price</th>
                                        <td><?php echo e(general()->currency); ?> <?php echo e(priceFormat($product->final_price)); ?></td>
                                    </tr>  
                                    <tr>
                                        <th>Category </th>
                                        <td>
                                        <?php $__currentLoopData = $product->productCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$ctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                         <?php echo e($i==0?'':'-'); ?> <?php echo e($ctg->name); ?> 
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <th>Brand </th>
                                        <td><?php echo e($product->brand?$product->brand->name:''); ?></td>
                                    </tr> 
                                    <tr>
                                        <th>Stock </th>
                                        <td><?php echo e($product->quantity); ?> Qty
                                        
                                        
                                        
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Store/Branch Stock </th>
                                        <td style="padding: 2px;">
                                            <?php $__currentLoopData = $product->warehouseStores()->where('quantity','>',0)->groupBy('branch_id')->selectRaw('branch_id, SUM(quantity) as total_quantity')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                             <span style="border: 1px solid #d8cfcf;display: inline-block;padding: 2px 15px;border-radius: 15px;margin: 3px 1px;">   <?php echo e($store->branch?$store->branch->name:'Not Found'); ?> - <?php echo e($store->total_quantity); ?> Qty</span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>SKU </th>
                                        <td><?php echo e($product->sku_code); ?></td>
                                    </tr>  
                                    <tr>
                                        <th>Barcode </th>
                                        <td>
                                            <?php if($product->bar_code && $product->variation_status==false): ?>
                                            <?php echo e($product->bar_code); ?> 
                                            <a class="badge badge-sm badge-primary" href="<?php echo e(route('admin.productsAction',['barcode',$product->id])); ?>" target="_blank" style="color: white;padding: 5px 15px;" >
                                                Print  <i class="fa fa-barcode" style="color: black;"></i> </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <td>
                                            <a href="<?php echo e(route('admin.reportsAll',['history-of-product','item_search'=>$product->id])); ?>" target="_blank">View History</a>
                                        </td>
                                    </tr>
                                   </table>
	                           </div>

                           </div>


                           <?php if($product->variation_status==true): ?>
                           <br>
                           <div class="table-responsive">
                               
                               <table class="table table-bordered">
                                   <tr>
                                       <th style="width: 60px;min-width: 60px;">SL</th>
                                       <th style="width: 80px;min-width: 80px;">Image</th>
                                       <?php $__currentLoopData = $product->productVariationAttibutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <th style="min-width: 120px;width: 120px;" ><?php echo e($att->attribute?$att->attribute->name:'Not found'); ?></th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       <th>Purchase Price</th>
                                       <th>Wholesale</th>
                                       <th>Sale Price</th>
                                       <th>Barcode</th>
                                       <th style="width: 100px;min-width: 100px;">Qty</th>
                                       <th style="width: 200px;min-width: 200px;">Wherehouse</th>
                                   </tr>
                                   <?php $__currentLoopData = $product->productVariationAttributeItems()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vi=>$variationItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   <tr>
                                       <td><?php echo e($vi+1); ?></td>
                                       <td>
                                           <img src="<?php echo e(asset($variationItem->variationItemImage())); ?>" style="max-width:70px;max-height:40px;">
                                       </td>
                                       <?php $__currentLoopData = $product->productVariationAttibutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($attValue =$variationItem->attributeVatiationItems()->where('attribute_id',$att->reff_id)->first()): ?>
                                        <td style="vertical-align: middle;padding:5px;">
                                            <?php echo e($attValue->attribute_item_value); ?>

                                        </td>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       <td><?php echo e(priceFullFormat($variationItem->purchase_price)); ?></td>
                                       <td><?php echo e(priceFullFormat($variationItem->wholesale_price)); ?></td>
                                       <td><?php echo e(priceFullFormat($variationItem->final_price)); ?></td>
                                       <td>
                                        <?php if($variationItem->barcode): ?>
                                        <?php echo e($variationItem->barcode); ?>

                                        <a href="<?php echo e(route('admin.productsAction',['barcode',$product->id,'variation_id'=>$variationItem->id])); ?>" target="_blank" style="color: #ff864a;font-size: 12px;font-weight: bold;">Print  <i class="fa fa-barcode" style="color: black;"></i> </a>
                                        <?php endif; ?>
                                       </td>
                                       <td><?php echo e($variationItem->quantity); ?></td>
                                       <td>
                                            <?php $__currentLoopData = $product->warehouseStores()->where('variant_id', $variationItem->id)->where('quantity','>',0)->groupBy('branch_id')->selectRaw('branch_id, SUM(quantity) as total_quantity')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                             <span style="border: 1px solid #d8cfcf;display: inline-block;padding: 2px 15px;border-radius: 15px;margin: 3px 1px;">  <?php echo e($store->branch?$store->branch->name:'Not Found'); ?> - <?php echo e($store->total_quantity); ?> Qty</span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       </td>
                                   </tr>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                               </table>
                           
                           </div>
                           
                           <?php endif; ?>
                           
                           
                           
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Basic Inputs end -->
</div>


 <!-- Modal -->
 <div class="modal fade text-left" id="barcode" >
   <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content">

       <div class="modal-header">
         <h4 class="modal-title" id="myModalLabel1">Barcode</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times; </span>
         </button>
       </div>
       <div class="modal-body" style="max-height:300px;overflow: auto;">
        <?php if($product->bar_code): ?>
            <div class="printArea printable-content PrintAreaContact" >
                
               <div class="BarcodSection">
                <?php for($i=0;$i < 50;$i++): ?>
                <img id="barcode1"/>
                <script>
                var name ="<?php echo e($product->bar_code); ?>";
                JsBarcode("#barcode1", name ,{format:"CODE128",});
                </script>
                <?php endfor; ?>
               </div>

            </div>
        <?php else: ?>
        <p>No Barcode</p>
        <?php endif; ?>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close </button>
         <button type="submit" id="PrintAction" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
       </div>

     </div>
   </div>
 </div>

<?php $__env->stopSection(); ?> 

<?php $__env->startPush('js'); ?>



<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/products/productsView.blade.php ENDPATH**/ ?>