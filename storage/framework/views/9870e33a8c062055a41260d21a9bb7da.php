<?php $__currentLoopData = $medies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<li>
    <div class="mediaImagediv" data-toggle="modal"  data-target="#default<?php echo e($media->id); ?>">
        <img src="<?php echo e(asset($media->image())); ?>" />
    </div>
    <?php if(isset(json_decode(Auth::user()->permission->permission, true)['medies']['delete'])): ?>
    <div style="top: 0; position: absolute;">
        <input type="checkbox" name="mediaid[]" value="<?php echo e($media->id); ?>" />
    </div>
    <?php endif; ?>
    <div style="top: 0; right: 0; position: absolute; background: #ffffff; padding: 2px 5px;">
        <a href="<?php echo e(route('admin.mediesEdit',$media->id)); ?>" target="_blank"> <i class="fa fa-edit"></i></a>
    </div>

    <!-- Modal -->
    <div class="modal fade text-left" id="default<?php echo e($media->id); ?>" tabindex="-1" role="dialog" >
       <div class="modal-dialog modal-dialog-centered" role="document">
    	 <div class="modal-content">
    	   <div class="modal-header">
    		 <h4 class="modal-title" id="myModalLabel1">File Details</h4>
    		 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    		   <span aria-hidden="true">&times; </span>
    		 </button>
    	   </div>
    	   <div class="modal-body">
    	   	    <div class="row">
    	   	        <div class="col-md-4">
    	   	            <div>
    	   	                <img src="<?php echo e(asset($media->image())); ?>" >
    	   	            </div>
    	   	        </div>
    	   	        <div class="col-md-8">
    	   	            <table class="table table-borderless mediaDetails">
    	   	                <tr>
    	   	                    <th style="padding: 5px;width: 120px;">File Size</th>
    	   	                    <td style="padding: 5px;">: <?php echo e($media->file_size); ?> Bytes</td>
    	   	                </tr>
    	   	                <tr>
    	   	                    <th style="padding: 5px;">Url </th>
    	   	                    <td style="padding: 5px;"><input type="text" class="form-control form-control-sm urlcopytext" id="myInput" value="<?php echo e(asset($media->file_url)); ?>" /></td>
    	   	                </tr>
    	   	                <tr>
    	   	                    <th style="padding: 5px;">File Name </th>
    	   	                    <td style="padding: 5px;">: <?php echo e($media->file_name); ?></td>
    	   	                </tr>
    	   	                <tr>
    	   	                    <th style="padding: 5px;">File Alt Tag</th>
    	   	                    <td style="padding: 5px;">: <?php echo e($media->alt_text); ?></td>
    	   	                </tr>
    	   	                <tr>
    	   	                    <th style="padding: 5px;">File Caption</th>
    	   	                    <td style="padding: 5px;">: <?php echo e($media->caption); ?></td>
    	   	                </tr>
    	   	                <tr>
    	   	                    <th style="padding: 5px;">File Description</th>
    	   	                    <td style="padding: 5px;">: <?php echo $media->description; ?></td>
    	   	                </tr>
    	   	                <tr>
    	   	                    <th style="padding: 5px;">Author</th>
    	   	                    <td style="padding: 5px;">: <?php echo e($media->user?$media->user->name:'no Author'); ?></td>
    	   	                </tr>
    	   	            </table>
    	   	        </div>
    	   	    </div>
    	   </div>

    	 </div>
       </div>
     </div>
    
</li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/admin/medies/includes/mediesAll.blade.php ENDPATH**/ ?>