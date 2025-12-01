<table class="table table-bordered areaChargeTable" style="margin:0;">
	<tr>
		<td style="width: 200px;min-width: 200px;">Title</td>
		<td style="min-width: 200px;">Value</td>
		<td style="min-width: 100px;width: 100px;">Action</td>
	</tr>
	<tbody class="sortable">
	<?php $__currentLoopData = $product->extraAttribute; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $extraAttri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<tr>
		<th style="cursor: all-scroll;">
		<?php echo $extraAttri->name; ?>

		<input type="hidden" name="extraAttributeSerial[]" value="<?php echo e($extraAttri->id); ?>">
		</th>
		<td><?php echo $extraAttri->content; ?></td>
		<td><a href="javascript:void(0)" 
			data-id="<?php echo e($extraAttri->id); ?>"
			data-url="<?php echo e(route('admin.productsUpdateAjax',['extraAttributeDelete',$product->id])); ?>" 
			class="btn-sm btn btn-danger extraAttributeDelete"
			><i class="fa fa-trash"></i></a>
			<a href="javascript:void(0)" 
			data-id="<?php echo e($extraAttri->id); ?>"
			data-title="<?php echo e($extraAttri->name); ?>"
			data-value="<?php echo e($extraAttri->content); ?>"
			class="btn-sm btn btn-info extraAttributeEdit"
			><i class="fa fa-edit"></i></a>
		</td>
	</tr>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php if($product->extraAttribute()->count()==0): ?>
	<tr>
	    <td colspan="3" style="text-align:center;color:gray;">No extra value</td>
	</tr>
	<?php endif; ?>
	</tbody>
</table>


 <script type="text/javascript">
     
    $(function(){
          $( ".sortable" ).sortable();
          $( ".sortable" ).disableSelection();
      });
</script><?php /**PATH /home/posherbd/public_html/resources/views/admin/products/includes/extraAttributeList.blade.php ENDPATH**/ ?>