 
<?php $__env->startSection('title'); ?>
<title>Product History - <?php echo e(general()->title); ?> | <?php echo e(general()->subtitle); ?></title>
<?php $__env->stopSection(); ?> 
<?php $__env->startPush('css'); ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<style type="text/css"></style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Product History Reports</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Product History</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">

            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.reportsAll',$type)); ?>">
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
                        <h4 class="card-title">Product History</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.reportsAll',$type)); ?>">
                                <div class="row">
                                    <div class="col-md-5 mb-1">
                                        <div class="input-group">
                                            <input type="date" name="startDate" value="<?php echo e(request()->startDate); ?>" class="form-control" />
                                            <input type="date" name="endDate"  value="<?php echo e(request()->endDate); ?>" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-1">
                                        <select  name="category" class="form-control" >
                                            <option value="" >Select Category</option>
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$ctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($ctg->id); ?>" <?php echo e(request()->category==$ctg->id?'selected':''); ?> ><?php echo e($ctg->name); ?></option>
                                                <?php $__currentLoopData = $ctg->subctgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($ctg->id); ?>" <?php echo e(request()->category==$ctg->id?'selected':''); ?>> - <?php echo e($ctg->name); ?></option>
                                                <?php $__currentLoopData = $ctg->subctgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($ctg->id); ?>" <?php echo e(request()->category==$ctg->id?'selected':''); ?>> - - <?php echo e($ctg->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <div class="input-group">
                                            <input type="text" name="search" value="<?php echo e(request()->search); ?>" placeholder="Search Product Name, ID" class="form-control" />
                                            <button type="submit" class="btn btn-success rounded-0">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
                            <hr>
                            
                            <?php if(request()->item_search): ?>
                            <div>
                                
                                <div class="row" style="margin:0 -10px;">
                                    <div class="col-md-6" style="padding:10px;" >
                                        <div style="padding: 20px;border: 1px solid #d2c8c8;">
                                            <h2>Sales Diagram</h2>
                                            <div id="donutchart" style="min-width: 360px;width:100%; min-height: 300;"></div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Sales</th>
                                                        <th style="min-width: 100px;width: 100px;">Qty</th>
                                                        <th style="min-width: 180px;width: 180px;">Amount</th>
                                                    </tr>
                                                    <tr>
                                                        <td>POS Sale</td>
                                                        <td><?php echo e($summery['pos_sale_qty']); ?></td>
                                                        <td><?php echo e(priceFullFormat($summery['pos_sale_amount'])); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Online Sale</td>
                                                        <td><?php echo e($summery['online_sale_qty']); ?></td>
                                                        <td><?php echo e(priceFullFormat($summery['online_sale_amount'])); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>whole Sale</td>
                                                        <td><?php echo e($summery['whole_sale_qty']); ?></td>
                                                        <td><?php echo e(priceFullFormat($summery['whole_sale_amount'])); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total</th>
                                                        <th><?php echo e(number_format($summery['pos_sale_qty']+$summery['online_sale_qty']+$summery['whole_sale_qty'])); ?></th>
                                                        <th><?php echo e(priceFullFormat($summery['pos_sale_amount']+$summery['online_sale_amount']+$summery['whole_sale_amount'])); ?></th>
                                                    </tr>
                                                </table>
                                            </div>
                                            
                                            <script type="text/javascript">
                                                  google.charts.load("current", {packages:["corechart"]});
                                                  google.charts.setOnLoadCallback(drawChart);
                                                  function drawChart() {
                                                    var data = google.visualization.arrayToDataTable([
                                                      ['Task', 'Type Of Sale'],
                                                      ['POS',     <?php echo e($summery['pos_sale_qty']); ?>],
                                                      ['Online',      <?php echo e($summery['online_sale_qty']); ?>],
                                                      ['Wholesale',  <?php echo e($summery['whole_sale_qty']); ?>]
                                                    ]);
                                            
                                                    var options = {
                                                      title: 'Product Sales',
                                                      pieHole: 0.2,
                                                    };
                                            
                                                    var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
                                                    chart.draw(data, options);
                                                  }
                                            </script>
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="padding:10px;">
                                        <div style="padding:10px;border: 1px solid #d2c8c8;">
                                            <h2>Quantity Information 
                                            
                                            <?php if($products->variation_status && Auth::user()->permission_id==1 && $transferHistory==null): ?>
                                            <!--<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#editQty" style="float:right">Edit</button>-->
                                            <?php endif; ?>
                                            </h2>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <th>Wherehouse</th>
                                                        <th>Now Qty</th>
                                                        <th>Sale Qty</th>
                                                        <th>Last Sale Date</th>
                                                    </tr>
                                                    <?php if($products->variation_status): ?>
                                                        <?php
                                                            $totalSalesQty =0;
                                                        ?>
                                                        
                                                        
                                                        <?php $__currentLoopData = $products->productVariationAttributeItems()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vi=>$variationItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($products->name); ?> - <?php echo $variationItem->variationItemValues(); ?>

                                                            
                                                                <!---<?php echo e($variationItem->id); ?>-->
                                                            
                                                                <?php
                                                                    
                                                                    $sales = $products->allSales()
                                                                        ->where('variant_id',$variationItem->id)
                                                                        ->whereHas('order', function($q){
                                                                            if(request()->startDate){
                                                                                $q->whereDate('created_at', '>=', request()->startDate);
                                                                            }
                                                                        })
                                                                        ->latest('created_at');
                                                                        
                                                                    $salesQty =$sales->sum('quantity') - $sales->sum('return_quantity');
                                                                    
                                                                    $lastSale =$sales->first();
                                                                    
                                                                    $totalSalesQty +=$salesQty;
                                                                    
                                                                ?>
                                                            </td>
                                                            <td style="padding:2px;">
                                                                <?php $__currentLoopData = $products->warehouseStores()->where('variant_id', $variationItem->id)->where('quantity','>',0)->groupBy('branch_id')->selectRaw('branch_id, SUM(quantity) as total_quantity')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                 <span style="border: 1px solid #d8cfcf;display: inline-block;padding: 1px 5px;border-radius: 5px;margin: 1px 1px;font-size: 14px" <?php echo e($store->id); ?>>   <?php echo e($store->branch?$store->branch->name:'Not Found'); ?> - <?php echo e($store->total_quantity); ?> Qty</span>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </td>
                                                            <td><?php echo e($variationItem->quantity); ?></td>
                                                            <td><?php echo e($salesQty); ?></td>
                                                            <td>
                                                                <?php echo e($lastSale ? $lastSale->created_at->format('d M, Y') : 'No Sale Yet'); ?>

                                                            </td>
                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td></td>
                                                            <td>Total</td>
                                                            <td><?php echo e($products->productVariationAttributeItems()->sum('quantity')); ?></td>
                                                            <td><?php echo e($totalSalesQty); ?></td>
                                                            <td>=<?php echo e($products->productVariationAttributeItems()->sum('quantity')+$totalSalesQty); ?> Qty</td>
                                                        </tr>
                                                    <?php else: ?>
                                                    <tr>
                                                        <td><?php echo e($products->name); ?>

                                                            <?php
                                                                $sales = $products->allSales()
                                                                    ->whereHas('order', function($q){
                                                                        if(request()->startDate){
                                                                            $q->whereDate('created_at', '>=', request()->startDate);
                                                                        }
                                                                    })
                                                                    ->latest('created_at');
                                                                
                                                                $salesQty =$sales->sum('quantity') - $sales->sum('return_quantity');
                                                                    
                                                                $lastSale =$sales->first();
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php $__currentLoopData = $products->warehouseStores()->where('quantity','>',0)->groupBy('branch_id')->selectRaw('branch_id, SUM(quantity) as total_quantity')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                             <span style="border: 1px solid #d8cfcf;display: inline-block;padding: 1px 5px;border-radius: 5px;margin: 1px 1px;font-size: 14px">   <?php echo e($store->branch?$store->branch->name:'Not Found'); ?> - <?php echo e($store->total_quantity); ?> Qty</span>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </td>
                                                        <td><?php echo e($products->quantity); ?></td>
                                                        <td><?php echo e($salesQty); ?></td>
                                                        <td>
                                                            
                                                            
                                                            <?php echo e($lastSale ? $lastSale->created_at->format('d M, Y') : 'No Sale Yet'); ?>

                                                        </td>
                                                    </tr>
                                                    <?php endif; ?>
                                                </table>
                                            </div>
                                            
                                            
                                            <?php if($products->variation_status && Auth::user()->permission_id==1): ?>
                                            <!-- Modal -->
                                            <div class="modal fade text-left" id="editQty" tabindex="-1" >
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('admin.reportsAll',$type)); ?>">
                                                            <input type="hidden" value="<?php echo e($products->id); ?>" name="item_search">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel1">Qty Edit</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times; </span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered">
                                                                        <tr>
                                                                            <th>Stock Item</th>
                                                                            <th style="width: 80px;min-width:80px;">Qty</th>
                                                                        </tr>
                                                                        
                                                                        <?php $__currentLoopData = $products->warehouseStores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr>
                                                                            <td>
                                                                                <?php echo e($stock->product?$stock->product->name:''); ?>

                                                                                <?php echo $stock->variant?$stock->variant->variationItemValues():''; ?>

                                                                                <br>
                                                                                <span><?php echo e($stock->branch?$stock->branch->name:'Not Found'); ?></span>
                                                                            </td>
                                                                            <td style="text-align: center;">
                                                                                <?php echo e($stock->quantity); ?> <br>
                                                                                <input type="number" name="stock_qty[]" value="<?php echo e($stock->quantity); ?>" placeholder="Qty" style="width: 70px;" />
                                                                            </td>
                                                                        </tr>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </table>
                                                                    <button type="submit" class="btn btn-success" style="float: right;">Submit</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            
                                        </div>
                                    </div>
                                    
                                    <?php if($stocksHistory): ?>
                                    <div class="col-md-6" style="padding:10px;">
                                        <div style="padding:10px;border: 1px solid #d2c8c8;">
                                            <h2>Product Stock Inventory</h2>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th style="max-width:140px;width:140px;">Date</th>
                                                        <th>Item</th>
                                                        <th>Qty</th>
                                                        <th>Store/Branch</th>
                                                    </tr>
                                                    <?php $__currentLoopData = $stocksHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($stock->order->created_at->format('d-m-Y')); ?>

                                                        <a href="<?php echo e(route('admin.purchasesAction',['invoice',$stock->order->id])); ?>"><i class="fas fa-external-link-alt"></i></a>
                                                        </td>
                                                        <td>
                                                            <?php echo e($stock->product?$stock->product->name:$stock->product_name); ?>

                                                            
                                                            <?php if(count($stock->itemAttributes()) > 0): ?>
                                    					    -
                                    					    <?php $__currentLoopData = $stock->itemAttributes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$attri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    					        <?php if(isset($attri['title']) && isset($attri['value'])): ?>
                                                                <?php echo e($i==0?'':','); ?> <span><b><?php echo e($attri['title']); ?></b> : <?php echo e($attri['value']); ?></span>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            
                                    					<?php endif; ?>
                                                            
                                                        </td>
                                                        <td><?php echo e($stock->quantity); ?></td>
                                                        <td><?php echo e($stock->order->branch?$stock->order->branch->name:'Not Found'); ?></td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td></td>
                                                        <td style="text-align:right;" >Stock Total</td>
                                                        <td><?php echo e($stocksHistory->sum('quantity')); ?></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td style="text-align:right;" >Minus Stock</td>
                                                        <td><?php echo e($stocksMinusHistory->sum('quantity')); ?></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td style="text-align:right;" ></td>
                                                        <td><?php echo e($stocksHistory->sum('quantity') - $stocksMinusHistory->sum('quantity')); ?></td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if($salesHistory): ?>
                                    <div class="col-md-6" style="padding:10px;">
                                        <div style="padding:10px;border: 1px solid #d2c8c8;">
                                            <h2>Product Sales History</h2>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th style="max-width:140px;width:140px;">Date</th>
                                                        <th>Item</th>
                                                        <th>Qty</th>
                                                        <th>R.Qty</th>
                                                        <th style="max-width:170px;width:170px;">Store/Branch</th>
                                                        <th style="max-width:110px;width:110px;">Type</th>
                                                    </tr>
                                                    <?php $__currentLoopData = $salesHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo e($stock->order->created_at->format('d-m-Y')); ?>

                                                            <?php if($stock->order->order_type=='wholesale_order'): ?>
                                                            <a href="<?php echo e(route('admin.wholeSalesAction',['invoice',$stock->order->id])); ?>"><i class="fas fa-external-link-alt"></i></a>
                                                            <?php elseif($stock->order->order_type=='pos_order'): ?>
                                                            <a href="<?php echo e(route('admin.posOrdersAction',['invoice',$stock->order->id])); ?>"><i class="fas fa-external-link-alt"></i></a>
                                                            <?php else: ?>
                                                            <a href="<?php echo e(route('admin.invoice',$stock->order->id)); ?>"><i class="fas fa-external-link-alt"></i></a>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo e($stock->product?$stock->product->name:$stock->product_name); ?>

                                                            
                                                            <?php if(count($stock->itemAttributes()) > 0): ?>
                                    					    -
                                    					    <?php $__currentLoopData = $stock->itemAttributes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$attri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    					        <?php if(isset($attri['title']) && isset($attri['value'])): ?>
                                                                <?php echo e($i==0?'':','); ?> <span><b><?php echo e($attri['title']); ?></b> : <?php echo e($attri['value']); ?></span>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            
                                    					<?php endif; ?>
                                                            
                                                        </td>
                                                        <td><?php echo e($stock->quantity); ?></td>
                                                        <td><?php echo e($stock->return_quantity); ?></td>
                                                        <td>
                                                            <?php echo e($stock->order->branch?$stock->order->branch->name:'Not Found'); ?>

                                                        </td>
                                                        <td>
                                                        <?php if($stock->order->order_type=='wholesale_order'): ?>
                                                        <span>Wholesale</span>
                                                        <?php elseif($stock->order->order_type=='pos_order'): ?>
                                                        <span>POS Sale</span>
                                                        <?php else: ?>
                                                        <span>Online</span>
                                                        <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td></td>
                                                        <td style="text-align:right;">Total</td>
                                                        <td><?php echo e($salesHistory->sum('quantity')); ?></td>
                                                        <td><?php echo e($salesHistory->sum('return_quantity')); ?></td>
                                                        <td>=<?php echo e($salesHistory->sum('quantity') - $salesHistory->sum('return_quantity')); ?></td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if($transferHistory): ?>
                                    <div class="col-md-6" style="padding:10px;">
                                        <div style="padding:10px;border: 1px solid #d2c8c8;">
                                            <h2>Product Transfer History</h2>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th style="max-width:140px;width:140px;">Date</th>
                                                        <th>Item</th>
                                                        <th>Qty</th>
                                                        <th>Store/Branch From</th>
                                                        <th>Store/Branch To</th>
                                                    </tr>
                                                    <?php $__currentLoopData = $transferHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($stock->order->created_at->format('d-m-Y')); ?>

                                                        <a href="<?php echo e(route('admin.stockTransferAction',['invoice',$stock->order->id])); ?>"><i class="fas fa-external-link-alt"></i></a>
                                                        </td>
                                                        <td>
                                                            <?php echo e($stock->product?$stock->product->name:$stock->product_name); ?>

                                                            
                                                            <?php if(count($stock->itemAttributes()) > 0): ?>
                                    					    -
                                    					    <?php $__currentLoopData = $stock->itemAttributes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$attri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    					        <?php if(isset($attri['title']) && isset($attri['value'])): ?>
                                                                <?php echo e($i==0?'':','); ?> <span><b><?php echo e($attri['title']); ?></b> : <?php echo e($attri['value']); ?></span>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            
                                    					<?php endif; ?>
                                                            
                                                        </td>
                                                        <td><?php echo e($stock->quantity); ?></td>
                                                        <td><?php echo e($stock->order->formBranch?$stock->order->formBranch->name:'Not Found'); ?></td>
                                                        <td><?php echo e($stock->order->branch?$stock->order->branch->name:'Not Found'); ?></td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td></td>
                                                        <td style="text-align:right;" >Total</td>
                                                        <td><?php echo e($transferHistory->sum('quantity')); ?></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if($stocksMinusHistory): ?>
                                    <div class="col-md-6" style="padding:10px;">
                                        <div style="padding:10px;border: 1px solid #d2c8c8;">
                                            <h2>Product Stock Minus History</h2>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th style="max-width:140px;width:140px;">Date</th>
                                                        <th>Item</th>
                                                        <th>Qty</th>
                                                        <th>Note</th>
                                                        <th>Store/Branch</th>
                                                    </tr>
                                                    <?php $__currentLoopData = $stocksMinusHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($stock->order->created_at->format('d-m-Y')); ?>

                                                        <a href="<?php echo e(route('admin.stockMinusAction',['invoice',$stock->order->id])); ?>"><i class="fas fa-external-link-alt"></i></a>
                                                        </td>
                                                        <td>
                                                            <?php echo e($stock->product?$stock->product->name:$stock->product_name); ?>

                                                            
                                                            <?php if(count($stock->itemAttributes()) > 0): ?>
                                    					    -
                                    					    <?php $__currentLoopData = $stock->itemAttributes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$attri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    					        <?php if(isset($attri['title']) && isset($attri['value'])): ?>
                                                                <?php echo e($i==0?'':','); ?> <span><b><?php echo e($attri['title']); ?></b> : <?php echo e($attri['value']); ?></span>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            
                                    					<?php endif; ?>
                                                            
                                                        </td>
                                                        <td><?php echo e($stock->quantity); ?></td>
                                                        <td><?php echo e($stock->order->note); ?></td>
                                                        <td><?php echo e($stock->order->branch?$stock->order->branch->name:'Not Found'); ?></td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td></td>
                                                        <td style="text-align:right;" >Total</td>
                                                        <td><?php echo e($stocksMinusHistory->sum('quantity')); ?></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    
                                </div>
                            </div>
                            <?php elseif(request()->startDate || request()->endDate || request()->category || request()->search): ?>
                            
                            <h2 style="color: #0ab90a;font-weight: bold;font-family: sans-serif;">Products List</h2>
                            
                            <div class="table-responsive">
                                
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 50px;min-width: 50px;">SL</th>
                                        <th style="min-width: 60px;width:60px;padding:7px 5px;">Image</th>
                                        <th style="min-width: 300px;">Product Information</th>
                                        <th style="width: 100px;min-width: 100px;">Now Qty</th>
                                        <th style="width: 100px;min-width: 100px;">Sale Qty </th>
                                        <th style="width: 100px;min-width: 100px;"> Sale Amount </th>
                                        <th style="width: 100px;min-width: 100px;"> Last Sold Date </th>
                                    </tr>
                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($i+1); ?></td>
                                        <td style="padding:1px;text-align: center;">
                                            <img src="<?php echo e(asset($product->image())); ?>" style="max-height:35px;max-width:60px;" />
                                        </td>
                                        <td>
                                            <?php echo e($product->name); ?>

                                            <a href="<?php echo e(route('admin.reportsAll',[$type,'item_search'=>$product->id])); ?>"><i class="fas fa-external-link-alt"></i></a>
                                        </td>
                                        <td><?php echo e(number_format($product->quantity)); ?></td>
                                        <td><?php echo e(number_format($product->total_sales_quantity)); ?></td>
                                        <td><?php echo e(number_format($product->total_sales_amount)); ?></td>
                                        <td>
                                            <?php
                                                $lastSale = $product->allSales()
                                                    ->whereHas('order', function($q){
                                                        if(request()->startDate){
                                                            $q->whereDate('created_at', '>=', request()->startDate);
                                                        }
                                                    })
                                                    ->latest('created_at')
                                                    ->first();
                                            ?>
                                            
                                            <?php echo e($lastSale ? $lastSale->created_at->format('d M, Y') : 'No Sale Yet'); ?>

                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                </table>
                                
                            </div>
                            
                            <?php else: ?>
                            
                            
                            <h2 style="color: #0ab90a;font-weight: bold;font-family: sans-serif;">Top Sales 20 Products</h2>
                            
                            <div class="table-responsive">
                                
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 50px;min-width: 50px;">SL</th>
                                        <th style="min-width: 60px;width:60px;padding:7px 5px;">Image</th>
                                        <th style="min-width: 300px;">Product Information</th>
                                        <th style="width: 100px;min-width: 100px;">Now Qty</th>
                                        <th style="width: 100px;min-width: 100px;">Sale Qty </th>
                                        <th style="width: 100px;min-width: 100px;"> Sale Amount </th>
                                        <th style="width: 100px;min-width: 100px;"> Last Sold Date </th>
                                    </tr>
                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($i+1); ?></td>
                                        <td style="padding:1px;text-align: center;">
                                            <img src="<?php echo e(asset($product->image())); ?>" style="max-height:35px;max-width:60px;" />
                                        </td>
                                        <td><?php echo e($product->name); ?>

                                        
                                        <a href="<?php echo e(route('admin.reportsAll',[$type,'item_search'=>$product->id])); ?>"><i class="fas fa-external-link-alt"></i></a>
                                        </td>
                                        <td><?php echo e(number_format($product->quantity)); ?></td>
                                        <td><?php echo e(number_format($product->total_sales_quantity)); ?></td>
                                        <td><?php echo e(number_format($product->total_sales_amount)); ?></td>
                                        <td>
                                            <?php echo e($product->lastSale ?$product->lastSale->created_at->format('d M, Y') : 'No Sale Yet'); ?>

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

<?php $__env->stopSection(); ?> 

<?php $__env->startPush('js'); ?> 


<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/reports/productHistoryReport.blade.php ENDPATH**/ ?>