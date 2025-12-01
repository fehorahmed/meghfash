<?php if($gallery->galleryImages->count()>0): ?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" >
            <thead>
                <tr>
                    <th width="30%">
                        <label style="cursor: pointer;margin-bottom: 0;">
                        <?php if(isset(json_decode(Auth::user()->permission->permission, true)['galleries']['delete'])): ?>
                        <input class="checkbox" type="checkbox" class="form-control" id="checkall">  All 
                        <?php endif; ?>
                        <span class="checkCounter"></span>
                      </label>
                    Image</th>
                    <th width="70%">Content</th>
                </tr>
            </thead>
            <tbody id="sortable">
            <?php $__currentLoopData = $gallery->galleryImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="cursor: move;">
                    <?php if(isset(json_decode(Auth::user()->permission->permission, true)['galleries']['add'])): ?>
                    <span>Title</span>
                    <input type="text" class="form-control"  name="imageName[]" placeholder="Enter Title" value="<?php echo e($image->alt_text); ?>">
                    <?php else: ?>
                    <span>Title</span>
                    <input type="text" class="form-control" disabled=""  placeholder="Enter Title" value="<?php echo e($image->alt_text); ?>">
                    <?php endif; ?>
                    
                    <img src="<?php echo e(asset($image->file_url)); ?>" style="max-width: 100px;">
                    <?php if(isset(json_decode(Auth::user()->permission->permission, true)['galleries']['delete'])): ?>
                    <input type="checkbox" name="checkid[]" value="<?php echo e($image->id); ?>"> <i class="fa fa-trash text-danger"></i>
                    <?php endif; ?>
                    <?php if(isset(json_decode(Auth::user()->permission->permission, true)['galleries']['add'])): ?>
                    <input type="hidden" name="imageid[]" value="<?php echo e($image->id); ?>">
                    <?php endif; ?>
                    
                    
                    </td>
                    <td style="cursor: move;">
                    
                    <?php if(isset(json_decode(Auth::user()->permission->permission, true)['galleries']['add'])): ?>
                    <span>Description</span>
                    <textarea class="form-control" rows="4" name="imageDescription[]" placeholder="Write Description"><?php echo e($image->description); ?></textarea>
                    <?php else: ?>
                    <span>Description</span>
                    <textarea class="form-control" rows="4" disabled="" placeholder="Write Description"><?php echo e($image->description); ?></textarea>
                    <?php endif; ?>
                    </td>
                </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

<?php endif; ?>
<script type="text/javascript">
    $( function() {
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();
        } );
</script><?php /**PATH D:\xampp\htdocs\poshak\resources\views/admin/galleries/includes/galleriesImages.blade.php ENDPATH**/ ?>