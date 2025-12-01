
<div class="ProAttributesItems">
    <?php if($product->productAttibutes->count() > 0): ?>
    <span class="btn"  style="border: 1px solid #e7e3e3;margin-bottom: 10px;background: #f7f7f7;" data-toggle="modal" data-target="#AddAttributes" >Edit Attributes</span>
    <br>
    <div class="table-responsive">
        <table class="table table-bordered">
            <?php $__currentLoopData = $product->productAttibutes()->whereHas('attribute')->select('reff_id', 'drag')->groupBy('reff_id', 'drag')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <th style="width: 200px;min-width: 200px;vertical-align: middle;"><?php echo e($attri->attribute->name); ?></th>
                <td style="padding: 3px;min-width:300px;">
                    <?php $__currentLoopData = $product->productAttibutes()->whereHas('attributeItem')->where('reff_id',$attri->reff_id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span style="vertical-align: middle;border: 1px solid #dfd9d9;display: inline-block;margin-bottom: 5px;padding: 5px 10px;border-radius: 5px;"><?php echo e($item->attributeItem?$item->attributeItem->name:'Not Found'); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
    </div>
    <?php else: ?>
    <span class="btn"  style="border: 1px solid #e7e3e3;margin-bottom: 10px;background: #f7f7f7;" data-toggle="modal" data-target="#AddAttributes" >Add Attributes</span>
    <br>
    <span style="color: #b7b7b7;">
        Adding new attributes helps the product to have many attributes.
    </span>
    <?php endif; ?>
</div>
<hr>

<div class="ProVariationAttribute">
    <?php if($product->productVariationAttibutes->count() > 0): ?>
    <span class="btn" style="border: 1px solid #e7e3e3;margin-bottom: 10px;background: #e8edef;"  data-toggle="modal" data-target="#AddAttributesVaritaionItem" >Add Variation Item</span>
    <?php if($attri =$product->productVariationAttibutes()->where('reff_id','68')->first()): ?>
    <span class="btn" style="border: 1px solid #83fcff;margin-bottom: 10px;background: #83fcff;margin-left: 10px;"  data-toggle="modal" data-target="#EditAttributesVaritaionList" >Edit Variation Image</span>
    <?php endif; ?>
    <span class="btn deleteBtnStatus variationItemsDeleteBtn" 
    data-url="<?php echo e(route('admin.productsUpdateAjax',['attributesItemDeletesIds',$product->id])); ?>"
    style="border: 1px solid #e7e3e3;margin-bottom: 10px;background: #ff425c;color: white;display:none;"  
    onclick="return confirm('Are you want to variation item delete?')">
    <i class="fa fa-trash"></i></span>
    <br>
    <div class="attributErrorMsg">
        <?php echo $attriMessage; ?>

    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th styl="min-width: 50px;width: 50px;text-align:center;">
                    <label style="cursor: pointer; margin-bottom: 0;"> 
                    <?php if($product->productVariationAttributeItems()->count() > 0): ?>
                    <input class="checkbox" type="checkbox" class="form-control" id="checkall" />
                    <?php endif; ?>
                    ID </label>
                </th>
                <th style="min-width: 70px;text-align:center;">Image</th>
                <?php $__currentLoopData = $product->productVariationAttibutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <th style="min-width: 120px;width: 120px;" ><?php echo e($att->attribute?$att->attribute->name:'Not found'); ?></th>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <th style="min-width: 120px;width: 120px;">Price</th>
                <th style="min-width: 100px;width: 100px;text-align:center;">Qty</th>
                <th style="min-width: 45px;width: 45px;"></th>
            </tr>
            <?php $__currentLoopData = $product->productVariationAttributeItems()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vi=>$variationItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td style="vertical-align: middle;padding:5px;text-align:center;">
                <input class="checkbox" type="checkbox" name="checkid[]" value="<?php echo e($variationItem->id); ?>" />
                    <?php echo e($vi+1); ?>

                </td>
                <td style="vertical-align: middle;padding:5px;text-align:center;">
                    <img src="<?php echo e(asset($variationItem->variationItemImage())); ?>" style="max-width:100px;max-height:40px;">
                </td>
                <?php $__currentLoopData = $product->productVariationAttibutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($attValue =$variationItem->attributeVatiationItems()->where('attribute_id',$att->reff_id)->first()): ?>
                <td style="vertical-align: middle;padding:5px;">
                    <?php echo e($attValue->attribute_item_value); ?>

                </td>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <td style="vertical-align: middle;padding:5px;">
                    <?php echo e(priceFullFormat($variationItem->final_price)); ?>

                    <?php if($variationItem->barcode): ?>
                    <a href="<?php echo e(route('admin.productsAction',['barcode',$product->id,'variation_id'=>$variationItem->id])); ?>" target="_blank" style="color: #ff864a;font-size: 12px;font-weight: bold;display: block;">Print  <i class="fa fa-barcode" style="color: black;"></i> </a>
                    <?php endif; ?>
                </td>
                <td style="vertical-align: middle;padding:5px;text-align:center;"><?php echo e($variationItem->quantity); ?>

                <?php if($variationItem->stock_status): ?>
                <span style="color: #11a578;font-size: 12px;font-weight: bold;display: block;">Stock In</span>
                <?php else: ?>
                <span style="color: #ff0000;font-size: 12px;font-weight: bold;display: block;">Stock Out</span>
                <?php endif; ?>
                </td>
                <td style="padding: 5px;vertical-align: middle;">
                    <span class="btn btn-sm btn-info btn-block" data-toggle="modal" data-target="#editAttributesVaritaionItem_<?php echo e($variationItem->id); ?>" ><i class="fa fa-edit"></i></span>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if($product->productVariationAttributeItems()->get()->count()==0): ?>
            <tr>
                <td colspan="<?php echo e(5+$product->productVariationAttibutes->count()); ?>"  style="text-align:center;color: #afafaf;"> No Variation Item</td>
            </tr>
            <?php endif; ?>
        </table>
    </div>
    
    <?php else: ?>
    <span class="btn" style="border: 1px solid #e7e3e3;margin-bottom: 10px;background: #e8edef;"  data-toggle="modal" data-target="#AddAttributesVaritaion" >Add Variation Attributes</span>
    <br>
    <span style="color: #b7b7b7;">
         Adding new <b>Variation</b> attributes helps the product to have many price Variation.
    </span>
    <br>
    <br>
    <?php endif; ?>
</div>


<?php if($product->productVariationAttibutes->count() > 0): ?>
<!-- Modal -->
<div class="modal fade text-left" id="AddAttributesVaritaionItem" tabindex="-1" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Variation Item</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times; </span>
                </button>
            </div>
            <div class="modal-body">
                
                <div class="varitaionItemproduct">
                    <div class="row">
                        <?php $__currentLoopData = $product->productVariationAttibutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atti): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4 form-group">
                            <label><?php echo e($atti->attribute?$atti->attribute->name:''); ?>* <span class="errorMsg"></span></label>
                            <select class="form-control attributeAddItemIds" name="itemsIds[]" >
                                <option value="">Select Option</option>
                                <?php if($attribute =$atti->attribute): ?>
                                <?php $__currentLoopData = $attribute->subAttributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Regular Price</label>
                            <input type="number" class="form-control variationPriceUpdate variation_price_0" data-id="0" name="variation_price"  value="<?php echo e($product->regular_price); ?>" placeholder="Price">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Discount</label>
                            <div class="input-group">
                                <input type="number" class="form-control variationPriceUpdate variation_discount_0" data-id="0" name="variation_discount"  value="<?php echo e($product->discount); ?>" placeholder="Discount">
                                <select class="form-control variationPriceUpdate variation_discount_type_0" name="variation_discount_type" data-id="0" >
                                    <option value="percent" <?php echo e($product->discount_type=='percent'?'selected':''); ?> >Percent(%)</option>
                                    <!--<option value="flat" <?php echo e($product->discount_type=='flat'?'selected':''); ?>>Flat(<?php echo e(general()->currency); ?>)</option>-->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Sale Price</label>
                            <input type="number" class="form-control final_price_0" data-id="0" readonly=""  value="<?php echo e($product->final_price); ?>" placeholder="Sale Price">
                        </div>
                    </div>
                    <!--<div class="row">-->
                    <!--    <div class="col-md-6 form-group">-->
                    <!--        <div class="input-group">-->
                    <!--            <span>Warrenty Charge 1</span>-->
                    <!--            <input type="number" class="form-control form-control-sm" name="variation_warrenty_charge"  placeholder="Warrenty Charge">-->
                    <!--        </div>-->
                    <!--        <div class="input-group">-->
                    <!--            <span>Warrenty Charge 2</span>-->
                    <!--            <input type="number" class="form-control form-control-sm" name="variation_warrenty_charge2"  placeholder="Warrenty Charge">-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Quantity</label>
                            <input type="number" class="form-control" readonly="" value="<?php echo e($product->quantity); ?>" placeholder="Quantity">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Stock Status</label>
                            <select class="form-control" name="variation_stock">
                                <option value="1" <?php echo e($product->stock_status==1?'selected':''); ?> >Stock In</option>
                                <option value="0" <?php echo e($product->stock_status==0?'selected':''); ?>>Stock Out</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Barcode</label>
                            <div class="input-group">
                                <input type="text" class="form-control variation_barcode" name="variation_barcode" value="<?php echo e(Carbon\Carbon::now()->format('ymd').$product->id.rand(1111,9999)); ?>" placeholder="Barcode">
                                <!--<div class="input-group-append">-->
                                <!--    <span class="input-group-text generate_Barcode" style="cursor:pointer;" data-id="0"><i class="fa fa-refresh"></i></span>-->
                                <!--</div>-->
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <span class="btn btn-success variationItemAttribute" data-url="<?php echo e(route('admin.productsUpdateAjax',['attributesVariationItemAdd',$product->id])); ?>" >Save Continue</span>
                <br>
            </div>
        </div>
    </div>
</div>

<?php if($attri =$product->productVariationAttibutes()->where('reff_id','68')->first()): ?>
<!-- Modal -->
<div class="modal fade text-left" id="EditAttributesVaritaionList" tabindex="-1" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Add Variation Images</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times; </span>
                </button>
            </div>
            <div class="modal-body">
                    <p>
                        <?php echo e($attri->attribute?$attri->attribute->name:'Not Found'); ?>

                    </p>
                    <?php if($product->productVariationAttributeItemsValues()->where('reff_id',$attri->reff_id)->count() > 0): ?>
                    <div class="variationItemImageUpdateform">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 150px;min-width: 150px;">Item</th>
                                    <th style="min-width:200px;">Image</th>
                                </tr>
                                <?php $__currentLoopData = $product->productVariationAttributeItemsValues()->where('reff_id',$attri->reff_id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attriValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($attriValue->attributeItem?$attriValue->attributeItem->name:'Not Found'); ?>

                                    <input type="hidden" name="valueItems[]" value="<?php echo e($attriValue->id); ?>">
                                    </td>
                                    <td style="padding:2px;">
                                        <div class="input-group">
                                            <input type="file" name="variation_image_<?php echo e($attriValue->id); ?>" class="form-control changeImage" data-image=".variaValueImage_<?php echo e($attriValue->id); ?>" accept="image/*" >
                                            <div style="width: 80px;text-align: center;">
                                                <img src="<?php echo e(asset($attriValue->variationImage())); ?>" class="variaValueImage_<?php echo e($attriValue->id); ?>" style="height: 40px;max-width: 100%;">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </table>
                        </div>
                        <br>
                        <span class="btn btn-success variationItemImageUpdate" data-url="<?php echo e(route('admin.productsUpdateAjax',['attributesVariationImageUpdate',$product->id])); ?>" >Save Continue</span>
                        <br>
                    </div>
                    <?php else: ?>
                    <p>
                        Please add variation item colors. 
                    </p>
                    <?php endif; ?>
                    

                <br>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $__currentLoopData = $product->productVariationAttributeItems()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemEdit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<!-- Modal -->
<div class="modal fade text-left" id="editAttributesVaritaionItem_<?php echo e($itemEdit->id); ?>" tabindex="-1" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Variation Item</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times; </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="varitaionItemproduct_<?php echo e($itemEdit->id); ?>">
                    <input type="hidden" value="<?php echo e($itemEdit->id); ?>" name="variation_id">
                    <div class="row">
                        <?php $__currentLoopData = $product->productVariationAttibutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atti): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4 form-group">
                            <label><?php echo e($atti->attribute?$atti->attribute->name:''); ?>*</label>
                            <select class="form-control" name="itemsIds[]" >
                                <option value="">Select Option</option>
                                <?php if($attribute =$atti->attribute): ?>
                                <?php $__currentLoopData = $attribute->subAttributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->id); ?>"
                                
                                <?php $__currentLoopData = $itemEdit->attributeVatiationItems()->where('attribute_id',$atti->reff_id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $checkItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e($checkItem->attribute_item_id==$item->id?'selected':''); ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                ><?php echo e($item->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Regular Price</label>
                            <input type="number" class="form-control variationPriceUpdate variation_price_<?php echo e($itemEdit->id); ?>" data-id="<?php echo e($itemEdit->id); ?>" name="variation_price"  value="<?php echo e($itemEdit->reguler_price); ?>" placeholder="Price">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Discount</label>
                            <div class="input-group">
                                <input type="number" class="form-control variationPriceUpdate variation_discount_<?php echo e($itemEdit->id); ?>" data-id="<?php echo e($itemEdit->id); ?>" name="variation_discount"  value="<?php echo e($itemEdit->discount); ?>" placeholder="Discount">
                                <select class="form-control variationPriceUpdate variation_discount_type_<?php echo e($itemEdit->id); ?>" data-id="<?php echo e($itemEdit->id); ?>" name="variation_discount_type" >
                                    <option value="percent" <?php echo e($itemEdit->discount_type=='percent'?'selected':''); ?> >Percent(%)</option>
                                    <!--<option value="flat" <?php echo e($itemEdit->discount_type=='flat'?'selected':''); ?> >Flat(<?php echo e(general()->currency); ?>)</option>-->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Sale Price</label>
                            <input type="number" class="form-control final_price_<?php echo e($itemEdit->id); ?>" data-id="<?php echo e($itemEdit->id); ?>" readonly=""  value="<?php echo e($itemEdit->final_price); ?>" placeholder="Sale Price">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Quantity</label>
                            <input type="number" class="form-control" readonly="" value="<?php echo e($itemEdit->quantity); ?>" placeholder="Quantity">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Stock Status</label>
                            <select class="form-control" name="variation_stock">
                                <option value="1" <?php echo e($itemEdit->stock_status?'selected':''); ?> >Stock In</option>
                                <option value="0" <?php echo e($itemEdit->stock_status==false?'selected':''); ?> >Stock Out</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Barcode</label>
                            <div class="input-group">
                                <input type="text" class="form-control variation_barcode" name="variation_barcode"
                                <?php echo e($itemEdit->barcode?'readonly':''); ?>

                                value="<?php echo e($itemEdit->barcode?:Carbon\Carbon::now()->format('ymd').$product->id.rand(1111,9999)); ?>" placeholder="Barcode">
                                <!--<div class="input-group-append">-->
                                <!--    <span class="input-group-text generate_Barcode" style="cursor:pointer;" data-id="<?php echo e($itemEdit->id); ?>"><i class="fa fa-refresh"></i></span>-->
                                <!--</div>-->
                            </div>
                        </div>
                    </div>
                </div>
                
                <br>
                <br>
                <span class="btn btn-success variationItemAttributeUpdate" data-id="<?php echo e($itemEdit->id); ?>" data-url="<?php echo e(route('admin.productsUpdateAjax',['attributesVariationItemUpdate',$product->id])); ?>" >Save Continue</span>
                <br>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php endif; ?>

<!-- Modal -->
<div class="modal fade text-left" id="AddAttributesVaritaion" tabindex="-1" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Select Variation Attributes</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times; </span>
                </button>
            </div>
            <div class="modal-body">
                <?php $__currentLoopData = $variationAttributes->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label style="margin: 5px;border: 1px solid #dfd9d9;padding: 5px 10px;border-radius: 5px;">
                    <input type="checkbox" value="<?php echo e($attri->id); ?>"  name="attributesVariationAddItemId[]"> <?php echo e($attri->name); ?>

                </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <br><br>
                <span class="btn btn-success attributesVariationAddItem" data-url="<?php echo e(route('admin.productsUpdateAjax',['attributesVariationItemAddIds',$product->id])); ?>" >Save Continue</span>
                <br>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade text-left" id="AddAttributes" tabindex="-1" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Select Attributes</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times; </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="attributeAreaSelect" style="height: 300px;overflow: auto;margin-bottom: 10px;">
                    <div class="row m-0">
                        <?php $__currentLoopData = $attributes->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-12">
                            <div class="attributeTitle">
                                <p style="margin-bottom: 5px; font-weight: bold;">
                                    <?php echo e($attri->name); ?>

                                </p>
                                <ul style="list-style: none; background: #f6f8fb; padding: 10px; border: 1px solid #dce1e7; border-radius: 5px;">
                                    <?php $__currentLoopData = $attri->subCtgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li style="display:inline-block;">
                                            <label style="margin:0;margin-right: 10px;">
                                                <input type="checkbox" value="<?php echo e($item->id); ?>"  name="attributesAddItemId[]"
                                                
                                                <?php $__currentLoopData = $product->productAttibutes()->whereHas('attributeItem')->where('reff_id',$attri->id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($itm->parent_id==$item->id?'checked':''); ?>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                
                                                > <?php echo e($item->name); ?>

                                            </label>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <span class="btn btn-success attributesAddItem" data-url="<?php echo e(route('admin.productsUpdateAjax',['attributesItemAddIds',$product->id])); ?>" >Save Continue</span>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\xampp\htdocs\megh-fashion\resources\views/admin/products/includes/productsDataAttributes2.blade.php ENDPATH**/ ?>