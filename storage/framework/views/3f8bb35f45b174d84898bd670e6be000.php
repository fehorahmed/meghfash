<div class="row">
	<div class="form-group col-md-4">
		<label>Regular Price</label>
		<input type="number" name="regular_price" 
		value="<?php echo e($product->regular_price?$product->regular_price:old('regular_price')); ?>" 
		data-url="<?php echo e(route('admin.productsUpdateAjax',['regular_price',$product->id])); ?>" 
		class="form-control productDataAjaxUpdate form-control-sm priceUpdate regular_price <?php echo e($errors->has('regular_price')?'error':''); ?>"
		data-id="00"
		 placeholder="Enter Price">
		<?php if($errors->has('regular_price')): ?>
        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('regular_price')); ?></p>
        <?php endif; ?>
	</div>
	<div class="form-group col-md-4">
		<label>Discount (optional)</label>
		<div class="input-group">
			<select class="form-control productDataAjaxUpdate form-control-sm discounttype priceUpdate <?php echo e($errors->has('discount_type')?'error':''); ?>"
			data-url="<?php echo e(route('admin.productsUpdateAjax',['discount_type',$product->id])); ?>" 
			 name="discount_type">
				<option value="percent" <?php echo e($product->discount_type=='percent'?'selected':''); ?>>Percent (%)</option>
				<!--<option value="flat" <?php echo e($product->discount_type=='flat'?'selected':''); ?>>Flat (Currency)</option>-->
			</select>
			<input type="number" name="discount" 
			value="<?php echo e($product->discount?$product->discount:old('discount')); ?>" 
			data-url="<?php echo e(route('admin.productsUpdateAjax',['discount',$product->id])); ?>" 
			class="form-control productDataAjaxUpdate form-control-sm discount priceUpdate <?php echo e($errors->has('discount')?'error':''); ?>" placeholder="Dicount">
		</div>
		<?php if($errors->has('discount_type')): ?>
        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('discount_type')); ?></p>
        <?php endif; ?>
        <?php if($errors->has('discount')): ?>
        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('discount')); ?></p>
        <?php endif; ?>
	</div>
	<div class="form-group col-md-4">
		<label>Final Price</label>
		<input type="number" readonly="" 
		value="<?php echo e($product->final_price?$product->final_price:old('final_price')); ?>" 
		data-url="<?php echo e(route('admin.productsUpdateAjax',['final_price',$product->id])); ?>" 
		class="form-control productDataAjaxUpdate form-control-sm final_price" placeholder="0.00">
	</div>
</div>

<div class="row">
	<div class="form-group col-md-4">
		<label>Stock Quantity</label>
		<input  type="number" readonly="" name="quantity" 
		value="<?php echo e($product->quantity?$product->quantity:old('quantity')); ?>" 
		data-url="<?php echo e(route('admin.productsUpdateAjax',['quantity',$product->id])); ?>" 
		class="form-control productDataAjaxUpdate form-control-sm <?php echo e($errors->has('quantity')?'error':''); ?>" 
		placeholder="(Stock Out)">
		<?php if($errors->has('quantity')): ?>
        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('quantity')); ?></p>
        <?php endif; ?>
	</div>
	<div class="form-group col-md-4">
		<label>Stock Out Limit</label>
		<input type="number" name="stock_out_limit" 
		value="<?php echo e($product->stock_out_limit?$product->stock_out_limit:old('stock_out_limit')); ?>"
		data-url="<?php echo e(route('admin.productsUpdateAjax',['stock_out_limit',$product->id])); ?>"  
		class="form-control productDataAjaxUpdate form-control-sm <?php echo e($errors->has('stock_out_limit')?'error':''); ?>" 
		placeholder="Stock Out 0">
		<?php if($errors->has('stock_out_limit')): ?>
        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('stock_out_limit')); ?></p>
        <?php endif; ?>
	</div>
	<div class="form-group col-md-4">
		<label>Stock Status</label>
		<select class="form-control productDataAjaxUpdate form-control-sm <?php echo e($errors->has('stock_status')?'error':''); ?>"
		value="<?php echo e($product->stock_status?$product->stock_status:old('stock_status')); ?>" 
		data-url="<?php echo e(route('admin.productsUpdateAjax',['stock_status',$product->id])); ?>"
		>
		    <option value="1" <?php echo e($product->stock_status==1?'selected':''); ?>>Stock In</option>
            <option value="0" <?php echo e($product->stock_status==0?'selected':''); ?>>Out Of Stock</option>
		</select>
		<?php if($errors->has('stock_status')): ?>
        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('stock_status')); ?></p>
        <?php endif; ?>
	</div>
</div>
<div class="row">
	<div class="form-group col-md-4">
		<label>Barcode (Optional) 
		<?php if($product->bar_code && $product->variation_status==false): ?>
        <a href="<?php echo e(route('admin.productsAction',['barcode',$product->id])); ?>" target="_blank" style="color: #ff864a;font-size: 12px;font-weight: bold;">Print  <i class="fa fa-barcode" style="color: black;"></i> </a>
        <?php endif; ?>
		</label>
		<input type="text" name="bar_code" 
		<?php if($product->bar_code && $product->variation_status==false): ?>
		readonly=""
		<?php endif; ?>
		value="<?php echo e($product->bar_code?:old('bar_code')); ?>" 
		data-url="<?php echo e(route('admin.productsUpdateAjax',['bar_code',$product->id])); ?>" 
		class="form-control productDataAjaxUpdate form-control-sm <?php echo e($errors->has('bar_code')?'error':''); ?>" 

		placeholder="Enter Barcode">
		<?php if($errors->has('bar_code')): ?>
        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('bar_code')); ?></p>
        <?php endif; ?>
	</div>
	
	<div class="form-group col-md-4">
		<label>Offer Schedule Start</label>
		<input type="date" name="offer_start_date" 
		value="<?php echo e($product->offer_start_date?Carbon\Carbon::parse($product->offer_start_date)->format('Y-m-d'):old('offer_start_date')); ?>" data-url="<?php echo e(route('admin.productsUpdateAjax',['offer_start_date',$product->id])); ?>" 
		class="form-control productDataAjaxUpdate form-control-sm <?php echo e($errors->has('offer_start_date')?'error':''); ?>" >
		<?php if($errors->has('offer_start_date')): ?>
        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('offer_start_date')); ?></p>
        <?php endif; ?>
	</div>
	<div class="form-group col-md-4">
		<label>Offer Schedule End</label>
		<input type="date" name="offer_end_date" value="<?php echo e($product->offer_end_date?Carbon\Carbon::parse($product->offer_end_date)->format('Y-m-d'):old('offer_end_date')); ?>" data-url="<?php echo e(route('admin.productsUpdateAjax',['offer_end_date',$product->id])); ?>" class="form-control productDataAjaxUpdate form-control-sm <?php echo e($errors->has('offer_end_date')?'error':''); ?>" >
		<?php if($errors->has('offer_end_date')): ?>
        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('offer_end_date')); ?></p>
        <?php endif; ?>
	</div>
</div>

<div class="row">
	
	<div class="form-group col-md-4">
		<label>SKU (Optional)</label>
		<input type="text" name="sku_code" 
		value="<?php echo e($product->sku_code?$product->sku_code:old('sku_code')); ?>" 
		data-url="<?php echo e(route('admin.productsUpdateAjax',['sku_code',$product->id])); ?>" 
		class="form-control productDataAjaxUpdate form-control-sm <?php echo e($errors->has('sku_code')?'error':''); ?>" 
		placeholder="Enter SKU">
		<?php if($errors->has('sku_code')): ?>
        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('sku_code')); ?></p>
        <?php endif; ?>
	</div>
	<div class="form-group col-md-4">
		<label>Purchase Price <small>(50%)</small></label>
		<input type="number" name="purchase_price" 
		value="<?php echo e($product->purchase_price?$product->purchase_price:old('purchase_price')); ?>" 
		data-url="<?php echo e(route('admin.productsUpdateAjax',['purchase_price',$product->id])); ?>" 
		class="form-control productDataAjaxUpdate form-control-sm purchase_price_00 <?php echo e($errors->has('purchase_price')?'error':''); ?>"
		placeholder="Purchase Price">
		<?php if($errors->has('purchase_price')): ?>
        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('purchase_price')); ?></p>
        <?php endif; ?>
	</div>
	<div class="form-group col-md-4">
		<label>Wholesale Price <small>(40%)</small></label>
		<input type="number" name="wholesale_price" 
		value="<?php echo e($product->wholesale_price?$product->wholesale_price:old('wholesale_price')); ?>" 
		data-url="<?php echo e(route('admin.productsUpdateAjax',['wholesale_price',$product->id])); ?>" 
		class="form-control productDataAjaxUpdate form-control-sm wholesale_price_00 <?php echo e($errors->has('wholesale_price')?'error':''); ?>"
		placeholder="Wholesale Price">
		<?php if($errors->has('wholesale_price')): ?>
        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('wholesale_price')); ?></p>
        <?php endif; ?>
	</div>
	
</div>
<?php /**PATH /home/meghfash/public_html/resources/views/admin/products/includes/productsDataGeneral.blade.php ENDPATH**/ ?>