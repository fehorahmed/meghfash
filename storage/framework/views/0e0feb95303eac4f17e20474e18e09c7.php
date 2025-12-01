<div class="row">
	<div class="form-group col-md-12">
	    <input type="hidden" class="extraAttributeId">
	    <label>Specification</label>
		<input type="text" class="form-control extraAttributeTitle form-control-sm" placeholder="Title">
	</div>
	<div class="form-group col-md-12">
		<textarea rows="3" class="form-control extraAttributeValue form-control-sm ExtraEditorTiny" placeholder="Value"></textarea>
	</div>
	<div class="form-group col-md-12">
	    <span class="btn btn-sm btn-primary extraAttributeAdd rounded-0"
			data-url="<?php echo e(route('admin.productsUpdateAjax',['extraAttributeAdd',$product->id])); ?>"
			 style="min-width:50px;text-align:center;cursor:pointer;padding: 8px;"
			 ><i class="fa fa-plus"></i> Submit</span>
	</div>
	<div class="form-group col-md-12">
		<label>Additional Info</label>
		<div class="extraAttributeList">
			<?php echo $__env->make('admin.products.includes.extraAttributeList', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>
	</div>
</div><?php /**PATH D:\xampp\htdocs\megh-fashion\resources\views/admin/products/includes/productsDataOthers.blade.php ENDPATH**/ ?>