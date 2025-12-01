 <?php $__env->startSection('title'); ?>
<title>Expenses List - <?php echo e(general()->title); ?> | <?php echo e(general()->subtitle); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css"></style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Expenses List</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Expenses List</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            
            <?php if(isset(json_decode(Auth::user()->permission->permission, true)['expenses']['add'])): ?>
            <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#addExpenses">
                Add Expenses
            </button>
            <?php endif; ?>
            
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.expensesList')); ?>">
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
                    <div class="card-content">

                            <div id="accordion">
                                <div
                                    class="card-header collapsed"
                                    data-toggle="collapse"
                                    data-target="#collapseTwo"
                                    aria-expanded="false"
                                    aria-controls="collapseTwo"
                                    id="headingTwo"
                                    style="background: #009688;padding: 10px; cursor: pointer; border: 1px solid #00b5b8;"
                                >
                                    Search click Here..
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="border: 1px solid #00b5b8; border-top: 0;">
                                    <div class="card-body">
                                        <form action="<?php echo e(route('admin.expensesList')); ?>">
                                            <div class="row">
                                                <div class="col-md-3 mb-0">
                                                    <div class="form-group">
                                                        <select class="form-control" name="type">
                                                            <option value="">Select Type</option>
                                                            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($type->id); ?>" <?php echo e(request()->type==$type->id?'selected':''); ?>><?php echo e($type->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-0">
                                                    <div class="form-group">
                                                        <select class="form-control" name="warehouse_id">
                                                            <option value="">Select Store/Branch</option>
                                                            <?php $__currentLoopData = App\Models\Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($warehouse->id); ?>" <?php echo e(request()->warehouse_id==$warehouse->id?'selected':''); ?>><?php echo e($warehouse->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-0">
                                                    <div class="input-group">
                                                        <input type="date" name="startDate" value="<?php echo e(request()->startDate); ?>" class="form-control <?php echo e($errors->has('startDate')?'error':''); ?>" />
                                                        <input type="date" value="<?php echo e(request()->endDate); ?>" name="endDate" class="form-control <?php echo e($errors->has('endDate')?'error':''); ?>" />
                                                        <button type="submit" class="btn btn-success rounded-0">Search</button>
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
                        <h4 class="card-title">Expenses List</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                              <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="min-width: 120px;width: 120px;">Date</th>
                                            <th style="min-width: 200px;width: 200px;">Expense Head</th>
                                            <th style="min-width: 150px;width: 150px;">Amount</th>
                                            <th style="min-width: 200px;">Description</th>
                                            <th style="min-width: 150px;width: 150px;">Expense By</th>
                                            <th style="min-width: 150px;width: 150px;">Store/Branch</th>
                                            <th style="min-width: 150px;width:150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <span><?php echo e($expense->created_at->format('d-m-Y')); ?></span>
                                            </td>
                                            <td>
                                                <?php if($expense->imageFile): ?>
                                                <a href="<?php echo e(asset($expense->imageFile->file_url)); ?>" target="_blank"><i class="fas fa-external-link-alt"></i></a>
                                                <?php endif; ?>
                                                <span><?php echo e($expense->head?$expense->head->name:'Others'); ?></span>
                                                
                                            </td>
                                            <td>
                                                <span><?php echo e(priceFullFormat($expense->amount)); ?></span>
                                            </td>
                                            <td>
                                                <?php echo $expense->description; ?>

                                            </td>
                                            <td>
                                                <span><?php echo e($expense->user?$expense->user->name:''); ?></span>
                                            </td>
                                            <td>
                                                <span><?php echo e($expense->warehouse?$expense->warehouse->name:''); ?></span>
                                            </td>
                                            <td class="center">
                                                <?php if(isset(json_decode(Auth::user()->permission->permission, true)['expenses']['add'])): ?>
                                                <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#updateExpenses<?php echo e($expense->id); ?>"> Edit </button>
                                                <!-- Modal -->
                                                 <div class="modal fade text-left" id="updateExpenses<?php echo e($expense->id); ?>" >
                                                   <div class="modal-dialog" role="document">
                                                     <div class="modal-content">
                                                        <form action="<?php echo e(route('admin.expensesListAction',['update',$expense->id])); ?>" method="post" enctype="multipart/form-data">
                                                            <?php echo csrf_field(); ?>
                                                           <div class="modal-header">
                                                             <h4 class="modal-title" id="myModalLabel1">Update Expense</h4>
                                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                               <span aria-hidden="true">&times; </span>
                                                             </button>
                                                           </div>
                                                           <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-6 form-group">
                                                                        <label>Date*</label>
                                                                        <input type="date" name="date" value="<?php echo e($expense->created_at->format('Y-m-d')); ?>" class="form-control" required="">
                                                                    </div>
                                                                    <div class="col-md-6 form-group">
                                                                        <label>Expense Head*</label>
                                                                        <select class="form-control" name="type" required="">
                                                                            <option value="">Select Type</option>
                                                                            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <option value="<?php echo e($type->id); ?>" <?php echo e($expense->type_id==$type->id?'selected':''); ?>><?php echo e($type->name); ?></option>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                            <option value="0" <?php echo e($expense->type_id==0?'selected':''); ?>>Others</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Store/Branch*</label>
                                                                    <select class="form-control" name="warehouse_id" required="">
                                                                        <option value="">Select Store/Branch</option>
                                                                        <?php $__currentLoopData = App\Models\Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($warehouse->id); ?>" <?php echo e($expense->warehouse_id==$warehouse->id?'selected':''); ?> ><?php echo e($warehouse->name); ?></option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Upload Attachment</label>
                                                                    <input type="file" name="attachment" accept="image/*" class="form-control" >
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Amount*</label>
                                                                    <input type="number" name="amount" value="<?php echo e($expense->amount); ?>" class="form-control" required="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Description</label>
                                                                    <textarea class="form-control" name="description" placeholder="Write Description"><?php echo $expense->description; ?></textarea>
                                                                </div>
                                                           </div>
                                                           <div class="modal-footer">
                                                             <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close </button>
                                                             
                                                             <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Update Expense</button>
                                                             
                                                           </div>
                                                       </form>
                                                       
                                                     </div>
                                                   </div>
                                                 </div>

                                                <?php endif; ?>
                                                
                                                <a href="<?php echo e(route('admin.expensesListAction',['delete',$expense->id])); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are You Want To Delete?')">Delete</a>
                                                <?php if(isset(json_decode(Auth::user()->permission->permission, true)['expenses']['delete'])): ?>
                                               <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <?php echo e($expenses->links('pagination')); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Basic Inputs end -->
</div>



 <!-- Modal -->
 <div class="modal fade text-left" id="addExpenses" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
        <form action="<?php echo e(route('admin.expensesListAction','create')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
           <div class="modal-header">
             <h4 class="modal-title" id="myModalLabel1">Add Expense</h4>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times; </span>
             </button>
           </div>
           <div class="modal-body">
               <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Date*</label>
                        <input type="date" name="date" value="<?php echo e(Carbon\Carbon::now()->format('Y-m-d')); ?>" class="form-control" required="">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Expense Head*</label>
                        <select class="form-control" name="type" required="">
                            <option value="">Select Type</option>
                            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <option value="0">Others</option>
                        </select>
                    </div>
               </div>
                <div class="form-group">
                    <label>Store/Branch*</label>
                    <select class="form-control" name="warehouse_id" required="">
                        <option value="">Select Store/Branch</option>
                        <?php $__currentLoopData = App\Models\Attribute::latest()->where('type',5)->where('status','active')->get(['id','name']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($warehouse->id); ?>"><?php echo e($warehouse->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Upload Attachment</label>
                    <input type="file" name="attachment" accept="image/*" class="form-control">
                </div>
                <div class="form-group">
                    <label>Amount*</label>
                    <input type="number" name="amount" class="form-control" required="" placeholder="Enter Amount">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" name="description" placeholder="Write Description"></textarea>
                </div>
           </div>
           <div class="modal-footer">
             <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close </button>
             <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add Expense</button>
           </div>
       </form>
     </div>
   </div>
 </div>
  <?php if(isset(json_decode(Auth::user()->permission->permission, true)['expenses']['add'])): ?>
<?php endif; ?>

<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?> <?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/accounts/expenses/expensesList.blade.php ENDPATH**/ ?>