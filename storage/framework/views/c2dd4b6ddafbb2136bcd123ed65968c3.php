<div class="card-header" style="padding: 8px 15px; border: 1px solid #00b5b8; margin-top: 3px;" data-toggle="collapse" href="#accordion3" aria-expanded="false" aria-controls="accordion3">
    <a class="card-title lead collapsed" href="#" style="color: white;">Post Categories</a>
</div>
<div id="accordion3" style="border: 1px solid #00b5b8;border-top: none;" role="tabpanel" data-parent="#accordionWrapa1" class="collapse" aria-expanded="false">
    <div class="card-content">
        <div class="card-body" style="padding:10px;">
            <form action="<?php echo e(route('admin.menusItemsPost',$menu->id)); ?>" method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="parent" value="<?php echo e($parent->id); ?>" />
                <div class="form-group" style="margin-bottom: 5px;">
                    <label for="name">Select Categories</label>
                    <select data-placeholder="Select Categories..." name="blogCategories[]" class="select2 form-control" multiple="multiple" required="">
                        <?php $__currentLoopData = $blogCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$bctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($bctg->id); ?>"><?php echo e($bctg->name); ?></option>
                        <?php if($bctg->subctgs->count() >0): ?> <?php echo $__env->make(adminTheme().'menus.includes.postCategorySubList',['subcategories' => $bctg->subctgs,'i'=>1], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <?php if(isset(json_decode(Auth::user()->permission->permission, true)['menus']['add'])): ?>
                <button type="submit" class="btn btn-sm btn-block btn-primary" style="padding:10px;"><i class="fa fa-plus"></i> Add</button>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div><?php /**PATH D:\xampp\htdocs\poshak\resources\views/admin/menus/includes/postCategoryList.blade.php ENDPATH**/ ?>