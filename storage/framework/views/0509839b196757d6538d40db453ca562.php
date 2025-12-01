
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" >
            <thead>
                <tr>
                    <th>Image</th>
                    <th width="60%">Info</th>
                </tr>
            </thead>
            <tbody class="sortable">
            <?php $__currentLoopData = $slider->sliderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="cursor: move;">
                    <input type="hidden" name="slideid[]" value="<?php echo e($slide->id); ?>">
                    <img src="<?php echo e(asset($slide->image())); ?>" style="max-width: 100px;">
                    <br>
                    <a href="<?php echo e(route('admin.slideAction',['edit',$slide->id])); ?>" class="btn btn-md btn-info">Edit</a>


                    <?php if(isset(json_decode(Auth::user()->permission->permission, true)['sliders']['delete'])): ?>
                    <a href="<?php echo e(route('admin.slideAction',['delete',$slide->id])); ?>" class="btn btn-md btn-danger" onclick="return confirm('Are Your Want To Delete?')">Delete</a>
                    <?php endif; ?>
                    </td>
                    <td style="cursor: move;">
                    <span><b>Name: </b><?php echo e($slide->name); ?></span><br>
                    <span><b>Description:</b> <?php echo e(Str::limit($slide->description,150)); ?></span>
                    <?php if($slide->seo_title || $slide->seo_description): ?>
                   <br><a href="<?php echo e($slide->seo_description); ?>" class="btn btn-sm btn-success" target="_blank"><?php echo e($slide->seo_title); ?></a>
                    <?php endif; ?>
                    <br>
                    <?php if($slide->status=='active'): ?>
                    <span><i class="fa fa-check" style="color: #1ab394;"></i></span>
                    <?php else: ?>
                    <span><i class="fa fa-time" style="color: #1ab394;"></i></span>
                    <?php endif; ?>
                    <?php if($slide->icon): ?>
                    <span>Color: <span style="    width: 150px;height: 10px;display: inline-block;background:<?php echo e($slide->icon); ?>"></span></span>
                    <?php endif; ?>
                    </td>
                </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if($slider->sliderItems->count()==0): ?>
                <tr>
                    <td colspan="2" style="text-align:center;">No Slide Found</td>
                </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Image</th>
                    <th>Info</th>
                </tr>
            </tfoot>
        </table>
    </div>
  
  <script type="text/javascript">
    $( function() {
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();
          } );
  </script><?php /**PATH D:\xampp\htdocs\posher-react-laravel\resources\views/admin/sliders/includes/slideItems.blade.php ENDPATH**/ ?>