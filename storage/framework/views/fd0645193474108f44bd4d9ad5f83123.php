 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Dashboard')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css">
    .BillingSummery tr td {
        padding: 5px;
    }
    .BillingSummery .Amount {
        font-size: 15px;
        font-weight: bold;
        color: #3f51b5;
    }
    .BillingSummery .Text {
        color: #6c6c6c;
    }
</style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>
<div class="content-header row"></div>
<div class="content-body">
    <!-- Grouped multiple cards for statistics starts here -->
    <div class="row grouped-multiple-statistics-card">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                            <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon success d-flex justify-content-center mr-3">
                                    <i class="fas fa-chart-line customize-icon font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                    <h3 class="heading-text text-bold-600"><?php echo e($reports['posSale']); ?></h3>
                                    <p class="sub-heading">POS Report</p>
                                </div>
                                <span class="inc-dec-percentage">
                                    <a href="<?php echo e(route('admin.posOrdersReports')); ?>" class="primary"><i class="fa fa-arrow-up"></i> View </a>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                            <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon primary d-flex justify-content-center mr-3">
                                    <i class="fas fa-desktop font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                    <h3 class="heading-text text-bold-600"><?php echo e($reports['posOrder']); ?></h3>
                                    <p class="sub-heading">POS Sale</p>
                                </div>
                                <span class="inc-dec-percentage">
                                    <a href="<?php echo e(route('admin.posOrders')); ?>" class="info"><i class="fa fa-arrow-up"></i> View</a>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                            <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon danger d-flex justify-content-center mr-3">
                                    <i class="fas fa-chart-line font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                    <h3 class="heading-text text-bold-600"><?php echo e($reports['totalStock']); ?></h3>
                                    <p class="sub-heading">Stock Report</p>
                                </div>
                                <span class="inc-dec-percentage">
                                    <a href="<?php echo e(route('admin.stocksList')); ?>" class="success"><i class="fa fa-arrow-up"></i> View </a>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                            <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon success d-flex justify-content-center mr-3">
                                    <i class="fas fa-list font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                    <h3 class="heading-text text-bold-600"><?php echo e($reports['todayExpense']); ?></h3>
                                    <p class="sub-heading">Expenses</p>
                                </div>
                                <span class="inc-dec-percentage">
                                    <a href="<?php echo e(route('admin.expensesReports')); ?>" class="primary"><i class="fa fa-arrow-up"></i> View </a>
                                </span>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Grouped multiple cards for statistics starts here -->
    <div class="row grouped-multiple-statistics-card">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                            <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon primary d-flex justify-content-center mr-3">
                                    <i class="fas fa-stream font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                    <h3 class="heading-text text-bold-600"><?php echo e($reports['product']); ?></h3>
                                    <p class="sub-heading">Products</p>
                                </div>
                                <span class="inc-dec-percentage">
                                    <small class="info"><i class="fa fa-arrow-up"></i> Total</small>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                            <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon danger d-flex justify-content-center mr-3">
                                    <i class="fas fa-users font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                    <h3 class="heading-text text-bold-600"><?php echo e($reports['customer']); ?></h3>
                                    <p class="sub-heading">Customers</p>
                                </div>
                                <span class="inc-dec-percentage">
                                    <small class="success"><i class="fa fa-arrow-up"></i> Total </small>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                            <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon success d-flex justify-content-center mr-3">
                                    <i class="fas fa-user-tie font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                    <h3 class="heading-text text-bold-600"><?php echo e($reports['admin']); ?></h3>
                                    <p class="sub-heading">Admin User</p>
                                </div>
                                <span class="inc-dec-percentage">
                                    <small class="primary"><i class="fa fa-arrow-up"></i> Total </small>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                            <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon success d-flex justify-content-center mr-3">
                                    <i class="fas fa-users customize-icon font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                    <h3 class="heading-text text-bold-600"><?php echo e($reports['pages']); ?></h3>
                                    <p class="sub-heading">Pages</p>
                                </div>
                                <span class="inc-dec-percentage">
                                    <small class="primary"><i class="fa fa-arrow-up"></i> Total </small>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row grouped-multiple-statistics-card">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-xl-4 col-sm-6 col-12">
                            <div class="d-flex align-items-start">
                                <span class="card-icon warning d-flex justify-content-center mr-3">
                                    <i class="fas fa-money font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                    <h3 class="heading-text text-bold-600"><?php echo e(priceFormat($reports['todaySale'])); ?></h3>
                                    <p class="sub-heading">Sales (<?php echo e(general()->currency); ?>)</p>
                                </div>
                                <span class="inc-dec-percentage">
                                    <small class="success"><i class="fa fa-arrow-up"></i> Today</small>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4 col-sm-6 col-12">
                            <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon danger d-flex justify-content-center mr-3">
                                    <i class="fas fa-money font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                    <h3 class="heading-text text-bold-600"><?php echo e(priceFormat($reports['monthlytSale'])); ?></h3>
                                    <p class="sub-heading">Sales (<?php echo e(general()->currency); ?>)</p>
                                </div>
                                <span class="inc-dec-percentage">
                                    <small class="success"><i class="fa fa-arrow-up"></i> Monthly </small>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4 col-sm-6 col-12">
                            <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon success d-flex justify-content-center mr-3">
                                    <i class="fas fa-money font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                    <h3 class="heading-text text-bold-600"><?php echo e(priceFormat($reports['yearlySale'])); ?></h3>
                                    <p class="sub-heading">Sales (<?php echo e(general()->currency); ?>)</p>
                                </div>
                                <span class="inc-dec-percentage">
                                    <small class="primary"><i class="fa fa-arrow-up"></i> Yearly </small>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row grouped-multiple-statistics-card">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                            <div class="d-flex align-items-start">
                                <span class="card-icon warning d-flex justify-content-center mr-3">
                                    <i class="fa fa-sitemap font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                    <h3 class="heading-text text-bold-600"><?php echo e($orderTotal->total); ?></h3>
                                    <p class="sub-heading">Orders</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                            <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon danger d-flex justify-content-center mr-3">
                                    <i class="fa fa-sitemap font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                    <h3 class="heading-text text-bold-600"><?php echo e($orderTotal->pending); ?></h3>
                                    <p class="sub-heading">Pending Orders</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                            <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon success d-flex justify-content-center mr-3">
                                    <i class="fa fa-sitemap font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                    <h3 class="heading-text text-bold-600"><?php echo e($orderTotal->confirmed); ?></h3>
                                    <p class="sub-heading">Confirm Orders</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                            <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">
                                <span class="card-icon success d-flex justify-content-center mr-3">
                                    <i class="fa fa-sitemap font-large-2 p-1"></i>
                                </span>
                                <div class="stats-amount mr-3">
                                    <h3 class="heading-text text-bold-600"><?php echo e($orderTotal->delivered); ?></h3>
                                    <p class="sub-heading">Delivered Orders</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
   
    <!-- active users and my task timeline cards starts here -->
    <div class="row match-height">
        <!-- active users card -->
        <div class="col-xl-12 col-lg-12">
            <div class="card active-users">
                <div class="card-header border-0">
                    <h4 class="card-title">Latest Products</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive position-relative card-body">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="min-width: 60px;">SL</th>
                                    <th style="min-width: 350px;">Product Name</th>
                                    <th style="min-width: 80px;">Image</th>
                                    <th style="min-width: 200px;">Catagory</th>
                                    <th style="min-width: 80px;">Status</th>
                                    <th style="min-width: 160px;">Action/Author</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($products->currentpage()==1?$i+1:$i+($products->perpage()*($products->currentpage() - 1))+1); ?>

                                    </td>
                                    <td>
                                        <span><a href="<?php echo e(route('productView',$product->slug?:'no-slug')); ?>" target="_blank"><?php echo e($product->name); ?></a></span>
                                        <br />
                                        <span style="color: #ccc;"><b style="color: #1ab394;"><?php echo e(general()->currency); ?></b> <?php echo e(priceFormat($product->final_price)); ?></span>

                                        <?php if($product->fetured==true): ?>
                                        <span><i class="fa fa-star" style="color: #1ab394;"></i></span>
                                        <?php endif; ?> <?php if($product->brand): ?>
                                        <span style="color: #ccc;"><b style="color: #1ab394;">Brand:</b> <?php echo e($product->brand->name); ?></span>
                                        <?php endif; ?> 
                                        <?php if($product->fetured==true): ?>
                                        <span><i class="fa fa-star" style="color: #1ab394;"></i></span>
                                        <?php endif; ?>
                                        <span style="color: #ccc;"><i class="fa fa-calendar" style="color: #1ab394;"></i> <?php echo e($product->created_at->format('d-m-Y')); ?></span>
                                    </td>
                                    <td style="padding: 5px; text-align: center;">
                                        <img src="<?php echo e(asset($product->image())); ?>" style="max-width: 70px; max-height: 50px;" />
                                    </td>
                                    <td>
                                        <?php $__currentLoopData = $product->productCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$ctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($i==0?'':'-'); ?> <?php echo e($ctg->name); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                    <td>
                                        <?php if($product->status=='active'): ?>
                                        <span class="badge badge-success">Active </span>
                                        <?php elseif($product->status=='inactive'): ?>
                                        <span class="badge badge-danger">Inactive </span>
                                        <?php else: ?>
                                        <span class="badge badge-danger">Draft </span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 5px;">
                                        <a href="<?php echo e(route('admin.productsAction',['edit',$product->id])); ?>" class="btn btn-sm btn-info">Edit</a>
                                        <?php if(isset(json_decode(Auth::user()->permission->permission, true)['products']['delete'])): ?>
                                        <a href="<?php echo e(route('admin.productsAction',['delete',$product->id])); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are You Want To Delete?')">Delete</a>
                                        <?php endif; ?>
                                        <br />
                                        <span style="color: #ccc;">
                                            <i class="fa fa-user" style="color: #1ab394;"></i>
                                            <?php echo e(Str::limit($product->user?$product->user->name:'No Author',15)); ?>

                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    
</div>
<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?>
<script></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\megh-fashion\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>