<div class="card-header" style="padding: 8px 15px; border: 1px solid #00b5b8;margin-top: 3px;" data-toggle="collapse" href="#accordion2" aria-expanded="false" aria-controls="accordion2">
    <a class="card-title lead collapsed" href="#" style="color: white;">Pages</a>
</div>
<div id="accordion2" style="border: 1px solid #00b5b8;border-top: none;" role="tabpanel" data-parent="#accordionWrapa1" class="collapse" aria-expanded="false">
    <div class="card-content">
        <div class="card-body" style="padding:10px;">
            <form action="<?php echo e(route('admin.menusItemsPost',$menu->id)); ?>" method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="parent" value="<?php echo e($parent->id); ?>" />
                <div class="form-group" style="margin-bottom: 5px;">
                    <label for="pages">Select Pages</label>
                    <select data-placeholder="Select Pages..." name="pages[]" class="select2 form-control" multiple="multiple" required="">
                        <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($page->id); ?>"><?php echo e($page->name); ?>


                            <?php if($page->template): ?>
                            (<span><?php echo e($page->template); ?></span>)
                            <?php endif; ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php if($errors->has('pages*')): ?>
                    <p style="color: red; margin: 0; font-size: 10px;">The Page Must Be a Number</p>
                    <?php endif; ?>
                </div>
                <?php if(isset(json_decode(Auth::user()->permission->permission, true)['menus']['add'])): ?>
                <button type="submit" class="btn btn-sm btn-block btn-primary" style="padding:10px;"><i class="fa fa-plus"></i> Add</button>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
<?php /**PATH /home/meghfash/public_html/resources/views/admin/menus/includes/pagesList.blade.php ENDPATH**/ ?>