 <?php $__env->startSection('title'); ?>
<title>Summery Reports - <?php echo e(general()->title); ?> | <?php echo e(general()->subtitle); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>

<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Summery Reports</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Summery Report</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <button class="btn btn-success" id="PrintAction" ><i class="fa fa-print"></i> Print</button>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.reportsAll',$type)); ?>"> <i class="fa-solid fa-rotate"></i> </a>

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
                	<div class="card-header" style="border-bottom: 1px solid #e3ebf3;padding: 1rem;border-top: 2px solid #4859b9;">
                        <h4 class="card-title" style="padding: 5px;">Summery Reports</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.reportsAll',$type)); ?>">
                                <div class="row">
                                    <div class="col-md-3" style="padding: 15px">
                                        <input class="form-control" type="date" name="startDate" value="<?php echo e($from->format('Y-m-d')); ?>" placeholder="Start Date">
                                    </div>
                                    <div class="col-md-3" style="padding: 15px">
                                        <input class="form-control" type="date" name="endDate" value="<?php echo e($to->format('Y-m-d')); ?>" placeholder="End Date">
                                    </div>
                                    <div class="col-md-3" style="padding: 15px">
                                        <select class="form-control" name="warehouse">
                                            <option value="">Select Store/Branch</option>
                                            <?php $__currentLoopData = App\Models\Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($warehouse->id); ?>" <?php echo e(request()->warehouse==$warehouse->id?'selected':''); ?> ><?php echo e($warehouse->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2" style="padding: 15px">
                                        <button class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="summeryParts PrintAreaContact" style="background: #f8f9f9;padding: 30px;">
                                <style type="text/css">
                                	.summeryPartsbox {
                                        background: #f1f1f1;
                                        padding: 15px;
                                        box-shadow: 4px 7px 7px 0px #ccc;
                                        /*color: #fff;*/
                                        border-radius:10px;
                                    }
                                    
                                    .summeryPartsbox p{
                                        font-family: 'Montserrat';
                                        font-weight: 500;
                                    }
                                    
                                    .summeryPartsbox p b{
                                        font-size: 22px;
                                    }
                                    .rowCustom{
                                        margin:0 -5px;
                                    }
                                    .row.rowCustom .col-2 {
                                        flex: 0 0 14.28571%;
                                        max-width: 14.28571%;
                                        padding:5px;
                                    }
                                    
                                    .summeryParts .table tr td {
                                        padding: 5px 6px;
                                    }
                                    
                                    .summeryParts .table tr th {
                                        padding: 5px 6px;
                                    }
                                </style>
                                <div class="headPart" style="text-align: center;">
                                    <img src="<?php echo e(asset(general()->logo())); ?>" style="max-width:250px;" />
                                    <p>
                                        <b>Mobile:</b> <?php echo e(general()->mobile); ?>, <b>Email:</b> <?php echo e(general()->email); ?> <br>
                                        <b>Address:</b> <?php echo e(general()->address_one); ?>

                                    </p>
                                    <p>
                                        Date: <?php if($from->format('Y-m-d')==$to->format('Y-m-d')): ?> <?php echo e($from->format('Y-m-d')); ?> <?php else: ?> <?php echo e($from->format('Y-m-d')); ?> - <?php echo e($to->format('Y-m-d')); ?> <?php endif; ?>
                                    </p>
                                    
                                </div>
                                
                                <h3>Today Report</h3>    
                                <div class="row rowCustom">
                                    
                                    <div class="col-2">
                                        <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                                            <div style="color: #959595;">Online <small>(BDT)</small></div>
                                            <div style="color: black;font-size: 20px;font-weight: bold;"><?php echo e(number_format($report['onlineSales'])); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                                            <div style="color: #959595;">POS <small>(BDT)</small></div>
                                            <div style="color: black;font-size: 20px;font-weight: bold;"><?php echo e(number_format($report['posSales'])); ?></div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-2">
                                        <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                                            <div style="color: #959595;">Wholesale  <small>(BDT)</small></div>
                                            <div style="color: black;font-size: 20px;font-weight: bold;"><?php echo e(number_format($report['wholesale'])); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                                                <div style="color: #959595;">Stock <small>(BDT)</small></div>
                                                <div style="color: black;font-size: 20px;font-weight: bold;"><?php echo e(number_format($report['purchase'])); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                                            <div style="color: #959595;">Expenses <small>(BDT)</small></div>
                                            <div style="color: black;font-size: 20px;font-weight: bold;"><?php echo e(number_format($report['expenses'])); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                                            <div style="color: #959595;">Customer</div>
                                            <div style="color: black;font-size: 20px;font-weight: bold;"><?php echo e(number_format($report['customer'])); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                                            <div style="color: #959595;">Return <small>(BDT)</small></div>
                                            <div style="color: black;font-size: 20px;font-weight: bold;"><?php echo e(number_format($report['return'])); ?></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div style="padding: 15px;background: white;margin-top: 20px;">
                                    <h3>Online Sales List</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Items</th>
                                                    <th>Bill</th>
                                                    <th>Invoice</th>
                                                    <th>Customer</th>
                                                    <th>Date</th>
                                                    <th>Store/Branch</th>
                                                    <th>Profit/Loss</th>
                                                </tr>
                                            </thead>
                                            <trbody>
                                                <?php $__currentLoopData = $customerOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$pOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($i+1); ?></td>
                                                    <td>
                                                        <?php $__currentLoopData = $pOrder->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php echo e($item->product_name); ?> X <?php echo e($item->quantity); ?>, <?php echo e(priceFullFormat($item->price)); ?> <br>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </td>
                                                    <td><?php echo e(priceFullFormat($pOrder->total_price -$pOrder->adjustment_amount)); ?></td>
                                                    <td>#<?php echo e($pOrder->invoice); ?></td>
                                                    <td><?php echo e($pOrder->name); ?></td>
                                                    <td><?php echo e($pOrder->created_at->format('d-m-Y')); ?></td>
                                                    <td><?php echo e($pOrder->branch?$pOrder->branch->name:''); ?></td>
                                                    <td><?php echo e(priceFullFormat($pOrder->profit_loss)); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($customerOrders->count()==0): ?>
                                                <tr>
                                                    <td style="text-align:center;" colspan="8">No Online Sales Order</td>
                                                </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td><?php echo e(priceFullFormat($customerOrders->sum('total_price')-$customerOrders->sum('adjustment_amount'))); ?></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><?php echo e(priceFullFormat($customerOrders->sum('profit_loss'))); ?></td>
                                                </tr>
                                            </trbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div style="padding: 15px;background: white;margin-top: 20px;">
                                    <h3>POS Sales List</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Items</th>
                                                    <th>Bill</th>
                                                    <th>Invoice</th>
                                                    <th>Customer</th>
                                                    <th>Date</th>
                                                    <th>Store/Branch</th>
                                                    <th>Profit/Loss</th>
                                                </tr>
                                            </thead>
                                            <trbody>
                                                <?php $__currentLoopData = $posOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$pOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($i+1); ?></td>
                                                    <td>
                                                        <?php $__currentLoopData = $pOrder->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php echo e($item->product_name); ?> X <?php echo e($item->quantity); ?><br>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </td>
                                                    <td><?php echo e(priceFullFormat($pOrder->grand_total)); ?></td>
                                                    <td>#<?php echo e($pOrder->invoice); ?></td>
                                                    <td><?php echo e($pOrder->name); ?></td>
                                                    <td><?php echo e($pOrder->created_at->format('d-m-Y')); ?></td>
                                                    <td><?php echo e($pOrder->branch?$pOrder->branch->name:''); ?></td>
                                                    <td><?php echo e(priceFullFormat($pOrder->profit_loss)); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($posOrders->count()==0): ?>
                                                <tr>
                                                    <td style="text-align:center;" colspan="8">No POS Sales</td>
                                                </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td><?php echo e(priceFullFormat($posOrders->sum('grand_total'))); ?></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><?php echo e(priceFullFormat($posOrders->sum('profit_loss'))); ?></td>
                                                </tr>
                                            </trbody>
                                        </table>
                                    </div>
                                </div>
                                
                                
                                <div style="padding: 15px;background: white;margin-top: 20px;">
                                    <h3>Wholesale Sales List</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Items</th>
                                                    <th>Sale</th>
                                                    <th>Due</th>
                                                    <th>Paid</th>
                                                    <th>Customer</th>
                                                    <th style="min-width:115px;">Date</th>
                                                    <th style="min-width:115px;">Store/Branch</th>
                                                    <th>Profit/Loss</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $wholesaleOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$pOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($i+1); ?></td>
                                                    <td>
                                                        <?php $__currentLoopData = $pOrder->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php echo e($item->product_name); ?> X <?php echo e($item->quantity); ?>, <?php echo e(priceFullFormat($item->price)); ?> <br>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($pOrder->adjustment_amount): ?>
                                                            <b>Adjustment Amount:</b>  (-) <?php echo e(priceFullFormat($pOrder->adjustment_amount)); ?>

                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo e(priceFullFormat($pOrder->grand_total)); ?></td>
                                                    <td><?php echo e(priceFullFormat($pOrder->due_amount)); ?></td>
                                                    <td><?php echo e(priceFullFormat($pOrder->paid_amount)); ?></td>
                                                    <td><?php echo e($pOrder->name); ?></td>
                                                    <td><?php echo e($pOrder->created_at->format('d-m-Y')); ?></td>
                                                    <td><?php echo e($pOrder->branch?$pOrder->branch->name:''); ?></td>
                                                    <td><?php echo e(priceFullFormat($pOrder->profit_loss)); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($wholesaleOrders->count()==0): ?>
                                                <tr>
                                                    <td style="text-align:center;" colspan="9">No Wholesale Order</td>
                                                </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td><?php echo e(priceFullFormat($wholesaleOrders->sum('grand_total'))); ?></td>
                                                    <td><?php echo e(priceFullFormat($wholesaleOrders->sum('due_amount'))); ?></td>
                                                    <td><?php echo e(priceFullFormat($wholesaleOrders->sum('paid_amount'))); ?></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><?php echo e(priceFullFormat($wholesaleOrders->sum('profit_loss'))); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div style="padding: 15px;background: white;margin-top: 20px;">
                                    <h3>Return Sales List</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Items</th>
                                                    <th>Return Sale</th>
                                                    <th>Customer</th>
                                                    <th style="min-width:115px;">Return Date</th>
                                                    <th style="min-width:115px;">Store/Branch</th>
                                                    <th style="min-width:115px;">Sale Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $returnOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$pOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($i+1); ?></td>
                                                    <td>
                                                        <?php if($rerurn =$pOrder->parentOrder): ?>
            						                    <?php $__currentLoopData = $rerurn->items()->where('return_quantity','>',0)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php echo e($item->product_name); ?> X <?php echo e($item->return_quantity); ?>, <?php echo e(priceFullFormat($item->price)); ?> <br>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo e(priceFullFormat($pOrder->grand_total)); ?></td>
                                                    <td><?php echo e($pOrder->name); ?></td>
                                                    <td><?php echo e($pOrder->created_at->format('d-m-Y')); ?></td>
                                                    <td>
                                                        <?php if($rerurn =$pOrder->parentOrder): ?>
                                                        <?php echo e($rerurn->branch?$rerurn->branch->name:''); ?>

                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if($rerurn =$pOrder->parentOrder): ?>
                                                        <?php echo e($rerurn->created_at->format('d-m-Y')); ?>

                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($returnOrders->count()==0): ?>
                                                <tr>
                                                    <td style="text-align:center;" colspan="9">No Return Order</td>
                                                </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td><?php echo e(priceFullFormat($returnOrders->sum('grand_total'))); ?></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div style="padding: 15px;background: white;margin-top: 20px;">
                                    <h3>Purchases List</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Items</th>
                                                    <th>Sale</th>
                                                    <th>Due</th>
                                                    <th>Paid</th>
                                                    <th>Supplier</th>
                                                    <th style="min-width:115px;">Date</th>
                                                    <th style="min-width:115px;">Store/Branch</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $purchasesOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$pOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($i+1); ?></td>
                                                    <td>
                                                        <?php $__currentLoopData = $pOrder->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php echo e($item->product_name); ?> X <?php echo e($item->quantity); ?>, <?php echo e(priceFullFormat($item->price)); ?> <br>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($pOrder->adjustment_amount): ?>
                                                            <b>Adjustment Amount:</b>  (-) <?php echo e(priceFullFormat($pOrder->adjustment_amount)); ?>

                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo e(priceFullFormat($pOrder->grand_total)); ?></td>
                                                    <td><?php echo e(priceFullFormat($pOrder->due_amount)); ?></td>
                                                    <td><?php echo e(priceFullFormat($pOrder->paid_amount)); ?></td>
                                                    <td><?php echo e($pOrder->name); ?></td>
                                                    <td><?php echo e($pOrder->created_at->format('d-m-Y')); ?></td>
                                                    <td><?php echo e($pOrder->branch?$pOrder->branch->name:''); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($purchasesOrders->count()==0): ?>
                                                <tr>
                                                    <td style="text-align:center;" colspan="8">No Purchases Order</td>
                                                </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td><?php echo e(priceFullFormat($purchasesOrders->sum('grand_total'))); ?></td>
                                                    <td><?php echo e(priceFullFormat($purchasesOrders->sum('due_amount'))); ?></td>
                                                    <td><?php echo e(priceFullFormat($purchasesOrders->sum('paid_amount'))); ?></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div style="padding: 15px;background: white;margin-top: 20px;">
                                    <h3>Expenses List</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Expense Head</th>
                                                    <th>Amount</th>
                                                    <th>Description</th>
                                                    <th>Expense By</th>
                                                    <th style="min-width:115px;">Date</th>
                                                    <th>Store/Branch</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $expensesOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($i+1); ?></td>
                                                    <td>
                                                        <?php echo e($expense->head?$expense->head->name:'Others'); ?>

                                                    </td>
                                                    <td><?php echo e(priceFullFormat($expense->amount)); ?></td>
                                                    <td><?php echo $expense->description; ?></td>
                                                    <td><span><?php echo e($expense->user?$expense->user->name:''); ?></span></td>
                                                    <td><?php echo e($expense->created_at->format('d-m-Y')); ?></td>
                                                    <td><?php echo e($expense->warehouse?$expense->warehouse->name:''); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($expensesOrders->count()==0): ?>
                                                <tr>
                                                    <td style="text-align:center;" colspan="7">No Expenses </td>
                                                </tr>
                                                <?php endif; ?>  
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td><?php echo e(priceFullFormat($expensesOrders->sum('amount'))); ?></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div style="padding: 15px;background: white;margin-top: 20px;">
                                    <h3>Customer List</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Name</th>
                                                    <th>Mobile/Email</th>
                                                    <th>Total Revenue</th>
                                                    <th style="min-width:115px;">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($i+1); ?></td>
                                                    <td>
                                                        <?php echo e($customer->name); ?>

                                                    </td>
                                                    <td><?php echo e($customer->mobile?:$customer->email); ?></td>
                                                    <td><?php echo e(priceFullFormat($customer->total_revenue)); ?></td>
                                                    <td><?php echo e($customer->created_at->format('d-m-Y')); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($customers->count()==0): ?>
                                                <tr>
                                                    <td style="text-align:center;" colspan="6">No Customer </td>
                                                </tr>
                                                <?php endif; ?>  
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td> 
                                                    <td><?php echo e(priceFullFormat($customers->sum('total_revenue'))); ?></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div style="padding: 15px;background: white;margin-top: 20px;">
                                    <h3>Yearly Total Summery</h3>
                                    <div class="table-responsive">
                                        <?php
                                            $totalTotal = 0;
                                            $totalProfit = 0;
                                            $totalOnline = 0;
                                            $totalPos = 0;
                                            $totalWholesale = 0;
                                            $totalPurchase = 0;
                                            $totalExpenses = 0;
                                            $totalCustomer = 0;
                                            $totalReturn = 0;
                                        ?>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Month</th>
                                                    <th>Total <small>(Online+POS+Wholesale)</small></th>
                                                    <th>Online Sales</th>
                                                    <th>POS Sales</th>
                                                    <th>Wholesale Sales</th>
                                                    <th>Profit</th>
                                                    <th>Stock</th>
                                                    <th>Expenses</th>
                                                    <th>Customer</th>
                                                    <th>Return</th>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                <?php $__currentLoopData = $monthlyData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $totalTotal += $data['total'];
                                                        $totalProfit += $data['profitTotal'];
                                                        $totalOnline += $data['onlineTotal'];
                                                        $totalPos += $data['posTotal'];
                                                        $totalWholesale += $data['wholesaleTotal'];
                                                        $totalPurchase += $data['purchaseTotal'];
                                                        $totalExpenses += $data['expensesTotal'];
                                                        $totalCustomer += $data['customerTotal'];
                                                        $totalReturn += $data['returnTotal'];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo e($data['month']); ?></td>
                                                        <td><?php echo e(priceFullFormat($data['total'], 2)); ?></td> 
                                                        <td><?php echo e(priceFullFormat($data['onlineTotal'], 2)); ?></td>
                                                        <td><?php echo e(priceFullFormat($data['posTotal'], 2)); ?></td>
                                                        <td><?php echo e(priceFullFormat($data['wholesaleTotal'])); ?></td>
                                                        <td><?php echo e(priceFullFormat($data['profitTotal'], 2)); ?></td> 
                                                        <td><?php echo e(priceFullFormat($data['purchaseTotal'], 2)); ?></td>
                                                        <td><?php echo e(priceFullFormat($data['expensesTotal'], 2)); ?></td>
                                                        <td><?php echo e(priceFormat($data['customerTotal'], 2)); ?></td>
                                                        <td><?php echo e(priceFullFormat($data['returnTotal'], 2)); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>Total</td>
                                                    <td><?php echo e(priceFullFormat($totalTotal, 2)); ?></td>
                                                    <td><?php echo e(priceFullFormat($totalOnline, 2)); ?></td>
                                                    <td><?php echo e(priceFullFormat($totalPos, 2)); ?></td>
                                                    <td><?php echo e(priceFullFormat($totalWholesale, 2)); ?></td>
                                                    <td><?php echo e(priceFullFormat($totalProfit, 2)); ?></td>
                                                    <td><?php echo e(priceFullFormat($totalPurchase, 2)); ?></td>
                                                    <td><?php echo e(priceFullFormat($totalExpenses, 2)); ?></td>
                                                    <td><?php echo e(priceFormat($totalCustomer, 2)); ?></td>
                                                    <td><?php echo e(priceFullFormat($totalReturn, 2)); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
</div>



<?php $__env->stopSection(); ?> 

<?php $__env->startPush('js'); ?> 


<script type="text/javascript">
	
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/reports/summeryReports1.blade.php ENDPATH**/ ?>