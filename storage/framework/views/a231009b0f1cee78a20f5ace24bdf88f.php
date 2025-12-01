<div id="heading1" class="card-header" style="padding: 8px 15px; border: 1px solid #00b5b8; margin-top: 3px;" role="tab" data-toggle="collapse" href="#Customlink" aria-expanded="false" aria-controls="Customlink">
    <a class="card-title lead collapsed" href="#" style="color: white;">Custom Link</a>
</div>
<div id="Customlink" style="border: 1px solid #00b5b8;border-top: none;" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading1" class="collapse">
    <div class="card-content menus-items">
        <form action="<?php echo e(route('admin.menusItemsPost',$menu->id)); ?>" method="post">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="parent" value="<?php echo e($parent->id); ?>" />
            <div class="card-body" style="padding:10px;">
                <div class="form-group" style="margin-bottom: 5px;">
                    <label for="menuname">Menu Name</label>
                    <input
                        type="text"
                        class="form-control form-control-sm <?php echo e($errors->has('menuname')?'error':''); ?>"
                        name="menuname"
                        placeholder="Enter Menu Name"
                        value="<?php echo e(old('menuname')); ?>"
                        required=""
                    />
                    <?php if($errors->has('menuname')): ?>
                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('menuname')); ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-group" style="margin-bottom: 5px;">
                    <label for="menulink">Menu Link</label>
                    <input
                        type="text"
                        class="form-control form-control-sm <?php echo e($errors->has('menulink')?'error':''); ?>"
                        name="menulink"
                        placeholder="Enter Menu Link"
                        value="<?php echo e(old('menulink')); ?>"
                        required=""
                    />
                    <?php if($errors->has('menulink')): ?>
                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('menulink')); ?></p>
                    <?php endif; ?>
                </div>
                <?php if(isset(json_decode(Auth::user()->permission->permission, true)['menus']['add'])): ?>
                <button type="submit" class="btn btn-sm btn-block btn-primary" style="padding:10px;"><i class="fa fa-plus"></i> Add</button>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div><?php /**PATH D:\xampp\htdocs\poshak\resources\views/admin/menus/includes/customLink.blade.php ENDPATH**/ ?>