<div class="card-header" style="padding: 8px 15px; border: 1px solid #00b5b8; margin: 2px 0;" data-toggle="collapse" href="#accordion4" aria-expanded="false" aria-controls="accordion4">
    <a class="card-title lead collapsed" href="#" style="color: white;">Product Categories</a>
</div>
<div id="accordion4" style="border: 1px solid #00b5b8;" role="tabpanel" data-parent="#accordionWrapa1" class="collapse" aria-expanded="false">
    <div class="card-content">
        <div class="card-body" style="padding:10px;">
            <form action="<?php echo e(route('admin.menusItemsPost',$menu->id)); ?>" method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="parent" value="<?php echo e($parent->id); ?>" />
                <div class="form-group" style="margin-bottom: 5px;">
                    <label for="name">Select Categories</label>
                    <select data-placeholder="Select Categories..." name="productCategories[]" class="select2 form-control" multiple="multiple" required="">
                        <?php $__currentLoopData = $productCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$productCtg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($productCtg->id); ?>"><?php echo e($productCtg->name); ?></option>
                        
                        <?php if($productCtg->subctgs->count() >0): ?> <?php echo $__env->make(adminTheme().'menus.includes.productCategorySubList',['subcategories' => $productCtg->subctgs,'i'=>1], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <?php endif; ?>
                        
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <?php if(isset(json_decode(Auth::user()->permission->permission, true)['menus']['add'])): ?>
                <button type="submit" class="btn btn-sm btn-block btn-primary" style="padding:10px;" onclick="return confirm('Are You Want To Add?')"><i class="fa fa-plus"></i> Add</button>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div><?php /**PATH D:\xampp\htdocs\megh-fashion\resources\views/admin/menus/includes/productCategoryList.blade.php ENDPATH**/ ?>