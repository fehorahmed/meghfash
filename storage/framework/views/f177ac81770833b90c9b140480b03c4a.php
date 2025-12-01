
<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Product Edit')); ?></title>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
<style type="text/css">
    .catagorydiv {
        max-height: 300px;
        overflow: auto;
    }
    .catagorydiv ul {
        padding-left: 20px;
    }
    .catagorydiv ul li {
        list-style: none;
    }
    .areaChargeTable tr td{
        padding:4px;
    }

    .areaChargeTable tr th{
        padding:4px;
    }

    .form-control.error {
        border-color: #cf8b8b;
        background: #fed1d1;
    }
    .table tbody+tbody {
        border-top: 0px solid #98A4B8;
    }

</style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Product Edit</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Product Edit</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.products')); ?>">BACK</a>
            <?php if(isset(json_decode(Auth::user()->permission->permission, true)['products']['add'])): ?>
			 <a class="btn btn-outline-primary" href="<?php echo e(route('admin.productsAction','create')); ?>">Add Product</a>
			 <?php endif; ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.productsAction',['edit',$product->id])); ?>">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>

<div class="content-body">
    <!-- Basic Elements start -->
    <section class="basic-elements">
        <?php echo $__env->make('admin.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <form action="<?php echo e(route('admin.productsAction',['update',$product->id])); ?>" class="mainformDATA" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Product Edit 
                            <?php if($product->slug): ?>
                            <a href="<?php echo e(route('productView',$product->slug?:'no-slug')); ?>" class="badge badge-success float-right" target="_blank">View</a>
                            <?php endif; ?>
                            </h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Product Name </label>
                                    <input type="text" class="form-control <?php echo e($errors->has('name')?'error':''); ?>" name="name" placeholder="Enter Product Name" value="<?php echo e($product->name?:old('name')); ?>" required="" />
                                    <?php if($errors->has('name')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('name')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="short_description">Short Description</label>
                                    <textarea name="short_description" class="form-control <?php echo e($errors->has('short_description')?'error':''); ?>" placeholder="Enter Short Description"><?php echo $product->short_description; ?></textarea>
                                    <?php if($errors->has('short_description')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('short_description')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="description">Product Information </label>
                                    <textarea name="description" class="<?php echo e($errors->has('description')?'error':''); ?> tinyEditor" placeholder="Enter Description"><?php echo $product->description; ?></textarea>
                                    <?php if($errors->has('description')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('description')); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                     <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Product Data</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                 <ul class="nav nav-tabs" role="tablist" style="border-bottom: none;">
                                     <li class="nav-item">
                                         <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" role="tab" aria-selected="true"><i class="fas fa-cog"></i> General</a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" role="tab" aria-selected="false"><i class="fas fa-truck"></i> Shipping</a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3" role="tab" aria-selected="false"><i class="fas fa-exchange-alt"></i> Attributes</a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" id="base-tab4" data-toggle="tab" aria-controls="tab4" href="#tab4" role="tab" aria-selected="false"><i class="fas fa-tags"></i> Specification</a>
                                     </li>
                                 </ul>
                                 <div class="tab-content px-1 pt-1" style="border: 1px solid #ddd;">
                                     <div class="tab-pane active" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
                                         <?php echo $__env->make('admin.products.includes.productsDataGeneral', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                     </div>
                                     <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
                                         <?php echo $__env->make('admin.products.includes.productsDataShipping', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                     </div>
                                     <div class="tab-pane ProAttributesItemsnNew" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
                                         
                                            <?php echo $__env->make('admin.products.includes.productsDataAttributes2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                     </div>
                                     <div class="tab-pane" id="tab4" role="tabpanel" aria-labelledby="base-tab4">
                                         <?php echo $__env->make('admin.products.includes.productsDataOthers', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                     </div>
                                 </div>


                            </div>
                        </div>
                    </div>
                   
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">SEO Optimize</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="seo_title">SEO Meta Title</label>
                                    <input type="text" class="form-control <?php echo e($errors->has('seo_title')?'error':''); ?>" name="seo_title" placeholder="Enter SEO Meta Title" value="<?php echo e($product->seo_title?:old('seo_title')); ?>" />
                                    <?php if($errors->has('seo_title')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('seo_title')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="seo_description">SEO Meta Description </label>
                                    <textarea name="seo_description" class="form-control <?php echo e($errors->has('seo_description')?'error':''); ?>" placeholder="Enter SEO Meta Description"><?php echo $product->seo_description; ?></textarea>
                                    <?php if($errors->has('seo_description')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('seo_description')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="seo_keyword">SEO Meta Keyword </label>
                                    <textarea name="seo_keyword" class="form-control <?php echo e($errors->has('seo_keyword')?'error':''); ?>" placeholder="Enter SEO Meta Keyword"><?php echo $product->seo_keyword; ?></textarea>
                                    <?php if($errors->has('seo_keyword')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('seo_keyword')); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Product Images</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="image">Product Image (Size:- 600X600)</label>
                                    <input type="file" name="image" class="form-control <?php echo e($errors->has('image')?'error':''); ?>" />
                                    <?php if($errors->has('image')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('image')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <img src="<?php echo e(asset($product->image())); ?>" style="max-width: 100px;" />
                                    <?php if(isset(json_decode(Auth::user()->permission->permission, true)['products']['add'])): ?>
                                    <?php if($product->imageFile): ?>
                                    <a href="<?php echo e(route('admin.mediesDelete',$product->imageFile->id)); ?>" class="mediaDelete" style="color: red;"><i class="fa fa-trash"></i></a>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="gallery_image">Product Gallery (Size:- 600X600)</label>
                                    <input type="file" name="gallery_image[]" class="form-control <?php echo e($errors->has('gallery_image')?'error':''); ?>"  multiple="" />
                                    <?php if($errors->has('gallery_image')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('gallery_image')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="row">
                                    <?php $__currentLoopData = $product->galleryFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-4 form-group">
                                    <img src="<?php echo e(asset($gallery->file_url)); ?>" style="max-width: 60px;max-height: 60px" />

                                    <a href="<?php echo e(route('admin.mediesDelete',$gallery->id)); ?>" class="mediaDelete" style="color: red;"><i class="fa fa-trash"></i></a>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Product Category</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <?php if($errors->has('categoryid*')): ?>
                                <p style="color: red; margin: 0; font-size: 10px;">The Category Must Be a Number</p>
                                <?php endif; ?>
                                <div class="catagorydiv">
                                    <ul>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" value="<?php echo e($ctg->id); ?>" id="category_<?php echo e($ctg->id); ?>" name="categoryid[]" <?php $__currentLoopData = $product->productCtgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $postctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($postctg->reff_id==$ctg->id?'checked':''); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>/>
                                                <label class="custom-control-label" for="category_<?php echo e($ctg->id); ?>"><?php echo e($ctg->name); ?></label>
                                            </div>
                                            <?php if($ctg->subctgs->count() >0): ?> <?php echo $__env->make('admin.products.includes.productEditSubctg',['subcategories' => $ctg->subctgs,'i'=>1], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <?php endif; ?>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Product Tags</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <?php if($errors->has('tags*')): ?>
                                <p style="color: red; margin: 0; font-size: 10px;">The Tags Must Be a Number</p>
                                <?php endif; ?>
                                <select data-placeholder="Select Tags..." name="tags[]" class="select2 form-control" multiple="multiple">
                                    <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tag->id); ?>" <?php $__currentLoopData = $product->productTags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producttag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($producttag->reff_id==$tag->id?'selected':''); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>><?php echo e($tag->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Product Brand</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Brand</label>
                                    <select name="brand" class="form-control selectBrand" data-url="<?php echo e(route('admin.productsUpdateAjax',['brandFilter',$product->id])); ?>">
                                        <option value="">Select Brands</option>
                                        <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$brd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($brd->id); ?>" <?php echo e($product->brand_id==$brd->id?'selected':''); ?> ><?php echo e($brd->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php if($errors->has('brand')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('brand')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <!--<div class="form-group">-->
                                <!--    <label>Sub Brand</label>-->
                                <!--    <select name="sub_brand" class="form-control subBrand">-->
                                <!--        <option value="">Select Sub Brand</option>-->
                                <!--        <?php if($brand): ?>-->
                                <!--        <?php $__currentLoopData = $brand->subbrands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>-->
                                <!--        <option value="<?php echo e($brand->id); ?>" <?php echo e($product->subbrand_id==$brand->id?'selected':''); ?> ><?php echo e($brand->name); ?> </option>-->
                                <!--        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>-->
                                <!--        <?php endif; ?>-->
                                <!--    </select>-->
                                <!--    <?php if($errors->has('sub_brand')): ?>-->
                                <!--    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('sub_brand')); ?></p>-->
                                <!--    <?php endif; ?>-->
                                <!--</div>-->
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Product Action</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="status">Product Status</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="status" name="status" <?php echo e($product->status=='active'?'checked':''); ?>/>
                                            <label class="custom-control-label" for="status">Active</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="fetured">Trending</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="fetured" name="fetured" <?php echo e($product->fetured?'checked':''); ?>/>
                                            <label class="custom-control-label" for="fetured">Active</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="new_arrival">New Arrival</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="new_arrival" name="new_arrival" <?php echo e($product->new_arrival?'checked':''); ?>/>
                                            <label class="custom-control-label" for="new_arrival">Active</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="up_coming">Top Sale</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="up_coming" name="up_coming" <?php echo e($product->up_coming?'checked':''); ?>/>
                                            <label class="custom-control-label" for="up_coming">Active</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Published Date</label>
                                    <input type="date" class="form-control form-control-sm" name="created_at" value="<?php echo e($product->created_at->format('Y-m-d')); ?>">
                                    <?php if($errors->has('created_at')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('created_at')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <?php if(isset(json_decode(Auth::user()->permission->permission, true)['products']['add'])): ?>
                                <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save changes</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </section>
    <!-- Basic Inputs end -->
</div>

<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?>

<script>

    $(document).ready(function(){
        


        $(document).on('click','.SubmitSingleProduct',function() {
            $('.SubmitSingleForm').submit();
        });

        $(document).on('change','.SubmitSingleProduct1',function() {
            $('.SubmitSingleForm').submit();
        });

        
        $(document).on('change','.selectBrand',function(){
            var url =$(this).data('url');
            var brandId =$(this).val();
            
            if(brandId=='' || brandId==null || brandId=='undefined'){
                $('.subBrand').empty().append('<option value="">Select Sub Brand</option>');
            }else{
                
                $.ajax({
                  url:url,
                  dataType: 'json',
                  cache: false,
                  data:{brandId:brandId},
                   success : function(data){
                        $('.subBrand').empty().append(data.viewData);
                   },error: function () {
                      alert('error');
                    }
                });
                   
            }
            
        });


        ///Product Price Jquery

            $(document).on('change keyup','.variationPriceUpdate',function(){
                var id =$(this).data('id');
                var Rprice =parseInt($('.variation_price_'+id).val());
                var Dtype =$('.variation_discount_type_'+id).val();
                var discount =parseInt($('.variation_discount_'+id).val());
                var final_price=0;
                if(Rprice < 1){
                  final_price =0;
                }

                if(Dtype=='percent'){

                 if(discount < 100){
                    final_price =Rprice - Rprice * discount /100 ;
                  }else{
                    final_price =Rprice;
                  }
                  
                }else{

                  if(Rprice > discount){
                    final_price =Rprice - discount;
                  }else{
                    final_price =Rprice;
                  }

                }
                
                $('.final_price_'+id).val(final_price);
            });
            
            $(document).on('change keyup mouseup','.priceUpdate',function(){

                var Rprice =parseInt($('.regular_price').val());

                var Dtype =$('.discounttype').val();

                var discount =parseInt($('.discount').val());

                var final_price=0;

                if(Rprice < 1){
                  final_price =0;
                }

                if(Dtype=='percent'){

                 if(discount < 100){
                    final_price =Rprice - Rprice * discount /100 ;
                  }else{
                    final_price =Rprice;
                  }
                  
                }else{

                  if(Rprice > discount){
                    final_price =Rprice - discount;
                  }else{
                    final_price =Rprice;
                  }

                }
              
              $('.final_price').val(final_price);

            });
            
            $(document).on('change', '.changeImage', function() {
                var classImage = $(this).data('image');
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $(classImage).attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });
            
            

          ///Product Price Jquery

          ///Product Ajax Update Data Jquery
          $(document).on('change','.productDataAjaxUpdate',function(){

                var url =$(this).data('url');
                var data =$(this).val();

                $.ajax({
                  url:url,
                  dataType: 'json',
                  cache: false,
                  data:{data:data},
                   success : function(data){

                   },error: function () {
                      alert('error');
                    }
                });

          });
          ///Product Ajax Update Data Jquery

          ///Product Attribute Filters Jquery
          $(document).on('change','.attributesItemFilter',function(){
                var url =$(this).data('url');
                var attriID =$(this).val();

                $.ajax({
                  url:url,
                  dataType: 'json',
                  cache: false,
                  data:{attriID:attriID},
                   success : function(data){
                    $('.AttributeItems').empty().append(data.viewData);
                   },error: function () {
                      alert('error');
                    }
                });

          });

          ///Product Attribute Filters Jquery

          ///Product Attribute Add Jquery
          
            $(document).on('click','.attributesVariationAddItem',function(){
                var url =$(this).data('url');
                var attriID = [];
                $('input[name="attributesVariationAddItemId[]"]:checked').each(function() {
                    attriID.push($(this).val());
                });
                
                attributeAjaxAction(url,attriID);
                
            });
            
            $(document).on('click','.variationItemAttribute',function(){
                var url =$(this).data('url');

                var allSelected = true;
                $('.varitaionItemproduct .attributeAddItemIds').each(function() {
                    if ($(this).val() === "") {
                        //$(this).closest('.form-group').find('.errorMsg').text('This field is required.');
                        allSelected = false;
                        return false;
                    }
                });
                
                if (!allSelected) {
                    alert('Please select an option for all attributes.');
                } else {
                    
                    var formData = new FormData();

                    $('.varitaionItemproduct').find('input, select').each(function() {
                        var name = $(this).attr('name');
                        var value = $(this).val();
                        if ($(this)[0].type === "file") {
                            var file = $(this)[0].files[0];
                            if (file) {
                                formData.append(name, file);  // Append the file
                            }
                        } else {
                            formData.append(name, value);  // Append regular form data
                        }
                    });
                
                    $.ajax({
                        url:url,
                        type: 'POST',
                        data:formData,
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success : function(data){
                            
                        $('#AddAttributesVaritaionItem').modal('hide');
                        
                        setTimeout(function() {
                            $('.ProAttributesItemsnNew').empty().append(data.viewData);
                        }, 200);
                        
                        // setTimeout(function() {
                        //         $('.attributErrorMsg').empty();
                        //     }, 2000);
        
                        },error: function () {
                            alert('error');
                        }
                    });
                
                }
            });
            
            $(document).on('click','.variationItemAttributeUpdate',function(){
                var url =$(this).data('url');
                var id =$(this).data('id');
                
                var formData = new FormData();

                $('.varitaionItemproduct_' + id).find('input, select').each(function() {
                    var name = $(this).attr('name');
                    var value = $(this).val();
                    if ($(this)[0].type === "file") {
                        var file = $(this)[0].files[0];
                        if (file) {
                            formData.append(name, file);  // Append the file
                        }
                    } else {
                        formData.append(name, value);  // Append regular form data
                    }
                });
                
                $.ajax({
                    url:url,
                    type: 'POST',
                    data:formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success : function(data){
                        
                    $('#editAttributesVaritaionItem_'+id).modal('hide');
                    
                    setTimeout(function() {
                        $('.ProAttributesItemsnNew').empty().append(data.viewData);
                    }, 200);
    
                    },error: function () {
                        alert('error');
                    }
                });
            });
            
            $(document).on('click','.variationItemImageUpdate',function(){
                
                var url =$(this).data('url');
                var formData = new FormData();

                $('.variationItemImageUpdateform').find('input').each(function() {
                    var name = $(this).attr('name');
                    var value = $(this).val();
                    if ($(this)[0].type === "file") {
                        var file = $(this)[0].files[0];
                        if (file) {
                            formData.append(name, file);  // Append the file
                        }
                    } else {
                        formData.append(name, value);  // Append regular form data
                    }
                });
                
                $.ajax({
                    url:url,
                    type: 'POST',
                    data:formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success : function(data){
                        
                    $('#EditAttributesVaritaionList').modal('hide');
                    
                    setTimeout(function() {
                        $('.ProAttributesItemsnNew').empty().append(data.viewData);
                    }, 200);
    
                    },error: function () {
                        alert('error');
                    }
                });
            });
            
            $(document).on('click','.variationItemsDeleteBtn',function(){
                var url =$(this).data('url');
                var attriID = [];
                $('input[name="checkid[]"]:checked').each(function() {
                    attriID.push($(this).val());
                });
                attributeAjaxAction(url,attriID);
                // alert(attriID);
            });
            

            $(document).on('click','.attributesAddItem',function(){
                var url =$(this).data('url');
                var attriID = [];
                $('input[name="attributesAddItemId[]"]:checked').each(function() {
                    attriID.push($(this).val());
                });
                
                attributeAjaxAction(url,attriID);
            });
            
            function attributeAjaxAction(url,attriID){
                $.ajax({
                  url:url,
                  dataType: 'json',
                  cache: false,
                  data:{attriID:attriID},
                  success : function(data){
                      
                    $('#AddAttributes').modal('hide');
                    $('#AddAttributesVaritaion').modal('hide');
                    
                    setTimeout(function() {
                        $('.ProAttributesItemsnNew').empty().append(data.viewData);
                    }, 200);

                  },error: function () {
                      alert('error');
                    }
                });
            }
          ///Product Attribute Add Jquery
          
          ///Product Attribute Add Jquery
          $(document).on('click','.attributesItemAdd',function(){
                var url =$(this).data('url');
                var attriID =$('.attributesItemAddId').val();

                if(attriID){

                    $.ajax({
                      url:url,
                      dataType: 'json',
                      cache: false,
                      data:{attriID:attriID},
                       success : function(data){
                        $('.attributesItemAddId').val('');
                        $('.AttributeItemsList').empty().append(data.viewData);
                        $('.priceVariationDiv').empty().append(data.viewData2);
                        
                        setTimeout(function() {
                            $('.attributErrorMsg').empty();
                        }, 2000);
                        
                       },error: function () {
                          alert('error');
                        }
                    });

                }else{
                   $('.attributesItemAddId').addClass('error'); 
                }
          
            });
          ///Product Attribute Add Jquery

          ///Product Attribute Update Jquery
          $(document).on('change','.attributesItemColor',function(){

                var url =$(this).data('url');
                var attriID =$(this).data('id');
                var attriValue =$(this).val();
 
                if(attriID && attriValue){

                    $.ajax({
                      url:url,
                      dataType: 'json',
                      cache: false,
                      data:{attriID:attriID,attriValue:attriValue},
                       success : function(data){
                        $('.AttributeItemsList').empty().append(data.viewData);
                       },error: function () {
                          alert('error');
                        }
                    });

                }

            });

          $(document).on('change','.attributesItemImage',function(){
            var url =$(this).data('url');
            var attriID =$(this).data('id');

            var file_data = $(this).prop('files')[0];
            var form_data = new FormData();

                form_data.append('attriValue', file_data);
                form_data.append('attriID', attriID);

                $.ajax({
                  url:url,
                  type:'POST',
                  dataType: 'json',
                  cache: false,
                  contentType: false,
                  processData: false,
                  data:form_data,
                   success : function(data){
                    $('.AttributeItemsList').empty().append(data.viewData);
                   },error: function () {
                      alert('error');
                    }
                });

            });

          

          ///Product Attribute Update Jquery


          ///Product Attribute Delete Jquery
          $(document).on('click','.attributesItemDelete',function(){
            var url =$(this).data('url');
            var attriID =$(this).data('id');

            if(confirm('Are You Want To Delete?') && attriID){

                $.ajax({
                  url:url,
                  dataType: 'json',
                  cache: false,
                  data:{attriID:attriID},
                   success : function(data){
                    $('.AttributeItemsList').empty().append(data.viewData);
                    $('.priceVariationDiv').empty().append(data.viewData2);
                   },error: function () {
                      alert('error');
                    }
                });

            }
          
          });
          ///Product Attribute Delete Jquery



          ///Product Extra Attribute Add Jquery

          $(document).on('click','.extraAttributeTitle,.extraAttributeValue,.attributesItemAddId',function(){
            $('.extraAttributeTitle').removeClass('error');
            $('.extraAttributeValue').removeClass('error');
            $('.attributesItemAddId').removeClass('error');

          });


          $(document).on('click','.extraAttributeAdd',function(){

                var url =$(this).data('url');
                var attri_id =$('.extraAttributeId').val();
                var title =$('.extraAttributeTitle').val();
                var value =$('.extraAttributeValue').val();
                if(title==''){
                    $('.extraAttributeTitle').addClass('error');
                }

                if(value==''){
                    $('.extraAttributeValue').addClass('error');
                }

                if(title && value){
                    
                    $.ajax({
                      url:url,
                      dataType: 'json',
                      cache: false,
                      data:{title:title,value:value,attri_id:attri_id},
                       success : function(data){
                        $('.extraAttributeTitle').val('');
                        $('.extraAttributeValue').val('')
                        $('.extraAttributeId').val('');
                        $('.extraAttributeList').empty().append(data.viewData);
                       },error: function () {
                          alert('error');
                        }
                    });

                }

          });
          ///Product Extra Attribute Add Jquery

          ///Product Extra Attribute Delete Jquery

          $(document).on('click','.extraAttributeEdit',function(){
              var attriID =$(this).data('id');
              var attriTitle =$(this).data('title');
              var attriValue =$(this).data('value');
              console.log(attriID);
              console.log(attriTitle);
              console.log(attriValue);
              
              attriValue = attriValue.replace(/<br\s*\/?>/gi, '');
              
              $('.extraAttributeValue').val(attriValue);
              $('.extraAttributeTitle').val(attriTitle);
              $('.extraAttributeId').val(attriID);
              
          });
          
          $(document).on('click','.extraAttributeDelete',function(){

                var url =$(this).data('url');
                var attriID =$(this).data('id');

                if(confirm('Are You Want To Delete?')){

                    $.ajax({
                      url:url,
                      dataType: 'json',
                      cache: false,
                      data:{attriID:attriID},
                       success : function(data){
                        $('.extraAttributeList').empty().append(data.viewData);
                       },error: function () {
                          alert('error');
                        }
                    });

                }

            });


          ///Product Extra Attribute Delete Jquery

          ///Product Extra Attribute Delete Jquery
          $(document).on('click','.priceVariationStatus',function(){

            var url =$(this).data('url');
    
            $.ajax({
              url:url,
              dataType: 'json',
              cache: false,
               success : function(data){
               $('.priceVariationDiv').empty().append(data.viewData);
               },error: function () {
                  alert('error');
                }
            });

          });
          
          ///Product Extra Attribute Delete Jquery

          ///Product Extra Attribute Delete Jquery
          $(document).on('click','.variationItemsAdd',function(){

            var url =$(this).data('url');
            var form =$('.mainformDATA');
            var data =form.serialize();
    
            $.ajax({
              url:url,
              dataType: 'json',
              cache: false,
              data:data,
               success : function(data){
               $('.priceVariationDiv').empty().append(data.viewData);
               },error: function () {
                  alert('error');
                }
            });

          });
          
          ///Product Variationi item Delete Jquery
          $(document).on('click','.variationItemsDelete',function(){
            var url =$(this).data('url');
            var skuId =$(this).data('id');

            if(confirm('Are You Want To Delete?') && skuId){

                $.ajax({
                  url:url,
                  dataType: 'json',
                  cache: false,
                  data:{skuId:skuId},
                   success : function(data){
                    $('.priceVariationDiv').empty().append(data.viewData);
                   },error: function () {
                      alert('error');
                    }
                });

            }
          
          });
          
          ///Product Extra Attribute Delete Jquery

    });
</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make(general()->adminTheme.'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\poshak\resources\views/admin/products/productsEdit.blade.php ENDPATH**/ ?>