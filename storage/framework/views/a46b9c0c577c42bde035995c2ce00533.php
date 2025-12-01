
<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Products List')); ?></title>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
<style type="text/css">
    .card .topBorderHeader{
        border-top: 3px solid #3d3196 !important;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('contents'); ?>

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
            <?php if(isset(json_decode(Auth::user()->permission->permission, true)['products']['add'])): ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.productsAction','create')); ?>">Add Product</a>
            <?php endif; ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.products')); ?>">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>


<?php echo $__env->make('admin.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="card">
    <div class="card-content">
        <div id="accordion">
                <div
                    class="card-header collapsed"
                    data-toggle="collapse"
                    data-target="#collapseTwo"
                    aria-expanded="false"
                    aria-controls="collapseTwo"
                    id="headingTwo"
                    style="background:#009688;padding: 15px 20px; cursor: pointer;"
                >
                   <i class="fa fa-filter"></i> Search click Here..
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="border: 1px solid #00b5b8; border-top: 0;">
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.products')); ?>">
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <div class="input-group">
                                        <input type="date" name="startDate" value="<?php echo e($r->startDate?Carbon\Carbon::parse($r->startDate)->format('Y-m-d') :''); ?>" class="form-control <?php echo e($errors->has('startDate')?'error':''); ?>" />
                                        <input type="date" value="<?php echo e($r->endDate?Carbon\Carbon::parse($r->endDate)->format('Y-m-d') :''); ?>" name="endDate" class="form-control <?php echo e($errors->has('endDate')?'error':''); ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <div class="input-group">
                                        <input type="text" name="search" value="<?php echo e($r->search?$r->search:''); ?>" placeholder="Product Name, Barcode" class="form-control <?php echo e($errors->has('search')?'error':''); ?>" />
                                        <button type="submit" class="btn btn-success rounded-0"><i class="fa fa-search"></i> Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
</div>

<div class="card">
    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
        <h4 class="card-title">Products List</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form action="<?php echo e(route('admin.products')); ?>">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-1">
                            <select class="form-control form-control-sm rounded-0" name="action" required="">
                                <option value="">Select Action</option>
                                <option value="1">Products Active</option>
                                <option value="2">Products InActive</option>
                                <option value="5">Products Delete</option>
                            </select>
                            <button class="btn btn-sm btn-primary rounded-0" onclick="return confirm('Are You Want To Action?')">Action</button>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <ul class="statuslist">
                            <li><a href="<?php echo e(route('admin.products')); ?>">All (<?php echo e($totals->total); ?>)</a></li>
                            <li><a href="<?php echo e(route('admin.products',['status'=>'active'])); ?>">Active (<?php echo e($totals->active); ?>)</a></li>
                            <li><a href="<?php echo e(route('admin.products',['status'=>'inactive'])); ?>">Inactive (<?php echo e($totals->inactive); ?>)</a></li>
                            <li><a href="<?php echo e(route('admin.products',['status'=>'new_arrival'])); ?>">New Arrival (<?php echo e($totals->new_arrival); ?>)</a></li>
                            <li><a href="<?php echo e(route('admin.products',['status'=>'top_sale'])); ?>">Top Sale (<?php echo e($totals->top_sale); ?>)</a></li>
                            <li><a href="<?php echo e(route('admin.products',['status'=>'tranding'])); ?>">Tranding (<?php echo e($totals->tranding); ?>)</a></li>
                        </ul>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="min-width: 60px;">
                                    <label style="cursor: pointer; margin-bottom: 0;"> <input class="checkbox" type="checkbox" class="form-control" id="checkall" /> All <span class="checkCounter"></span> </label>
                                </th>
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
                                    <input class="checkbox" type="checkbox" name="checkid[]" value="<?php echo e($product->id); ?>" /><br />
                                    <?php echo e($products->currentpage()==1?$i+1:$i+($products->perpage()*($products->currentpage() - 1))+1); ?>

                                </td>
                                <td>
                                    <span><a href="<?php echo e(route('productView',$product->slug?:'no-slug')); ?>" target="_blank"><?php echo e($product->name); ?></a></span>
                                    <br/>
                                    <span style="color: #ccc;"><b style="color: #1ab394;"><?php echo e(general()->currency); ?></b> <?php echo e(priceFormat($product->offerPrice())); ?></span>

                                    <?php if($product->brand): ?>
                                    <span style="color: #ccc;"><b style="color: #1ab394;">Brand:</b> <?php echo e($product->brand->name); ?></span>
                                    <?php endif; ?>

                                    <?php if($product->fetured==true): ?>
                                    <span><i class="fa fa-star" style="color: #1ab394;"></i></span>
                                    <?php endif; ?>
                                    <?php if($product->new_arrival==true): ?>
                                    <span ><i class="fa-solid fa-bookmark" style="color: #ff864a;"></i></span>
                                    <?php endif; ?>
                                    
                                    <?php if($product->import_status==true): ?>
                                    <span ><i class="fas fa-ship" style="color: #ff864a;"></i></span>
                                    <?php endif; ?>
                                    <span style="color: #ccc;"><i class="fa fa-calendar" style="color: #1ab394;"></i> <?php echo e($product->created_at->format('d-m-Y')); ?></span>
                                    
                                    <b>QTY:</b> <?php echo e($product->quantity); ?>

        
                                </td>
                                <td style="padding: 5px; text-align: center;">
                                    <img src="<?php echo e(asset($product->image())); ?>" style="max-width: 70px; max-height: 50px;" />
                                </td>
                                <td>
                                    <?php $__currentLoopData = $product->productCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$ctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                     <?php echo e($i==0?'':'-'); ?> <?php echo e($ctg->name); ?> 

                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                    <?php if(isset(json_decode(Auth::user()->permission->permission, true)['products']['add'])): ?>
                                    <a href="<?php echo e(route('admin.productsAction',['edit',$product->id])); ?>" class="btn btn-sm btn-info">Edit</a>
                                    <?php endif; ?>
                                    <a href="<?php echo e(route('admin.productsAction',['view',$product->id])); ?>" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                    <?php if(isset(json_decode(Auth::user()->permission->permission, true)['products']['delete'])): ?>
                                    <a href="<?php echo e(route('admin.productsAction',['delete',$product->id])); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are You Want To Delete?')"><i class="fa fa-trash"></i></a>
                                    <?php endif; ?>
                                    <?php if(isset(json_decode(Auth::user()->permission->permission, true)['products']['add'])): ?>
                                    <a href="<?php echo e(route('admin.productsAction',['duplicate',$product->id])); ?>" class="btn btn-sm" style="background-color: #ff864a;color: white;" onclick="return confirm('Are You Want To Deplicate?')"><i class="fa fa-copy"></i></a>
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

                    <?php echo e($products->links('pagination')); ?>

                </div>
            </form>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?> <?php $__env->stopPush(); ?>

<?php echo $__env->make(general()->adminTheme.'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\megh-fashion\resources\views/admin/products/productsAll.blade.php ENDPATH**/ ?>