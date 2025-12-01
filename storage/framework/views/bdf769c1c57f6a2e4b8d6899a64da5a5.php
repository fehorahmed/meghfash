
<div class="row">
	<div class="form-group col-md-4">
		<label>Weight</label>
		<div class="input-group">
			
			<select 
			name="weight_unit"
			readonly=""
			class="form-control productDataAjaxUpdate form-control-sm <?php echo e($errors->has('weight_unit')?'error':''); ?>"
			data-url="<?php echo e(route('admin.productsUpdateAjax',['weight_unit',$product->id])); ?>"
			>
			    <option value="Gram" <?php echo e($product->weight_unit=='Gram'?'selected':''); ?>>Gram</option>
			</select>
			
			
			<input type="number" name="weight_amount" 
			value="<?php echo e($product->weight_amount?$product->weight_amount:old('weight_amount')); ?>" 
			data-url="<?php echo e(route('admin.productsUpdateAjax',['weight_amount',$product->id])); ?>" 
		    class="form-control productDataAjaxUpdate form-control-sm <?php echo e($errors->has('weight_amount')?'error':''); ?>"
			placeholder="Weight">
		</div>
	</div>
	<div class="form-group col-md-8">
		<label>Dimensions</label>
		<div class="input-group">
			
			<input type="text" name="dimensions_unit" 
			value="<?php echo e($product->dimensions_unit?$product->dimensions_unit:old('dimensions_unit')); ?>" 
			data-url="<?php echo e(route('admin.productsUpdateAjax',['dimensions_unit',$product->id])); ?>" 
		    class="form-control productDataAjaxUpdate form-control-sm <?php echo e($errors->has('dimensions_unit')?'error':''); ?>"
			 placeholder="Unit (cm)">
			 
			<input type="number" name="dimensions_length" 
			value="<?php echo e($product->dimensions_length?$product->dimensions_length:old('dimensions_length')); ?>" 
			data-url="<?php echo e(route('admin.productsUpdateAjax',['dimensions_length',$product->id])); ?>" 
		    class="form-control productDataAjaxUpdate form-control-sm <?php echo e($errors->has('dimensions_length')?'error':''); ?>"
			placeholder="Length">
			
			<input type="number" name="dimensions_width" 
			value="<?php echo e($product->dimensions_width?$product->dimensions_width:old('dimensions_width')); ?>" 
			data-url="<?php echo e(route('admin.productsUpdateAjax',['dimensions_width',$product->id])); ?>" 
		    class="form-control productDataAjaxUpdate form-control-sm <?php echo e($errors->has('dimensions_width')?'error':''); ?>"
			placeholder="Width">
			<input type="number" name="dimensions_height" 
			value="<?php echo e($product->dimensions_height?$product->dimensions_height:old('dimensions_height')); ?>" 
			data-url="<?php echo e(route('admin.productsUpdateAjax',['dimensions_height',$product->id])); ?>" 
		    class="form-control productDataAjaxUpdate form-control-sm <?php echo e($errors->has('dimensions_height')?'error':''); ?>"
			placeholder="Height">
		</div>
	</div>
</div>

<?php /**PATH /home/posherbd/public_html/posher.com.bd/resources/views/admin/products/includes/productsDataShipping.blade.php ENDPATH**/ ?>