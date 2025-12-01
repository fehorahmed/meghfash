 
<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Menu Config')); ?></title>
<?php $__env->stopSection(); ?> 
<?php $__env->startPush('css'); ?>

<style type="text/css">
    .listmenu ul {
        margin: 0;
        padding: 0;
    }
    .listmenu ul li {
        list-style: none;
        margin: 5px;
        padding: 10px;
        border: 1px solid gray;
    }
    .menumanage {
        float: right;
    }
    .select2-container--default .select2-search--inline .select2-search__field {
        width: 100% !important;
    }
</style>
<?php $__env->stopPush(); ?> 
<?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Menu Config</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Menu Config</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <?php if($menu->parent_id): ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.menusAction',['edit',$menu->parent_id])); ?>">BACK</a>
            <?php else: ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.menus')); ?>">BACK</a>
            <?php endif; ?>
            <a class="btn btn-outline-primary reloadPage" href="javascript:void(0)">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>

<div class="content-body">
    <!-- Basic Elements start -->
    <section class="basic-elements">
        <?php echo $__env->make(adminTheme().'alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                        <h4 class="card-title">Add Items</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div id="accordionWrapa1" role="tablist" aria-multiselectable="true">
                                <div class="card accordion">

                                    <!--Custom menus Items -->
                                    <?php echo $__env->make(adminTheme().'menus.includes.customLink', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    

                                    <!--Page menus Items -->
                                    <?php echo $__env->make(adminTheme().'menus.includes.pagesList', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


                                    <!--Post Category Items -->
                                    <?php echo $__env->make(adminTheme().'menus.includes.postCategoryList', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    

                                    <!--Service Category Items -->
                                    <?php echo $__env->make(adminTheme().'menus.includes.productCategoryList', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                        <h4 class="card-title">Menu Config</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.menusAction',['update',$menu->id])); ?>" method="post" >
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Menu Name(*) </label>
                                            <input type="text" class="form-control <?php echo e($errors->has('name')?'error':''); ?>" name="name" placeholder="Enter Menu Name" value="<?php echo e($parent->name?:old('name')); ?>" required="" />
                                            <?php if($errors->has('name')): ?>
                                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('name')); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fetured">Menu Location</label>
                                            <div class="input-group">
                                                <select class="form-control" name="location">
                                                    <option value="">Select Location</option>
                                                    <option value="Header Menus" <?php echo e($parent->location=='Header Menus'?'selected':''); ?>>Header Menus</option>
                                                    <option value="Category Menus" <?php echo e($parent->location=='Category Menus'?'selected':''); ?>>Category Menus</option>
                                                    <option value="Footer Two" <?php echo e($parent->location=='Footer Two'?'selected':''); ?>>Footer Two</option>
                                                    <option value="Footer Three" <?php echo e($parent->location=='Footer Three'?'selected':''); ?>>Footer Three</option>
                                                    <option value="Footer Four" <?php echo e($parent->location=='Footer Four'?'selected':''); ?>>Footer Four</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <hr/>
                                
                                <p>
                                <b> <?php if($menu->parent_id): ?> <?php echo e($menu->menuName()?:'No Found'); ?> <?php else: ?> Primary <?php endif; ?> : </b>
                                    Label

                                    <span style="float: right;">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you Want To Delete?')">Delete</button>
                                        <label style="cursor: pointer; margin-bottom: 0;"> <input class="checkbox" type="checkbox" class="form-control" id="checkall" /> All <span class="checkCounter"></span> </label>
                                    </span>
                                </p>
                                <div class="listmenu">
                                    <ul  class="sortable">
                                        <?php $__currentLoopData = $menu->subMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuli): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="ui-sortable-handle" <?php if(!$menuli->
                                            menuName()): ?> style="border: 1px solid red;" <?php endif; ?> >
                                            <span style="cursor: move;">
                                                <input type="hidden" name="menuids[]" value="<?php echo e($menuli->id); ?>" />
                                                <?php if($menuli->icon): ?>
                                                <span><?php echo $menuli->icon; ?></span>
                                                <?php elseif($menuli->imageFile): ?>
                                                <img src="<?php echo e(asset($menuli->image())); ?>" width="25px" />
                                                <?php endif; ?> <?php echo e($menuli->menuName()?:'No Found'); ?>


                                                <span style="color: #d8d8d8;">
                                                    ( <?php if($menuli->menu_type==1): ?> Page <?php elseif($menuli->menu_type==2): ?> Post Category <?php elseif($menuli->menu_type==3): ?> Product Category <?php elseif($menuli->menu_type==0): ?> Custom <?php endif; ?> )
                                                </span>
                                                <strong>Sub: <?php echo e($menuli->subMenus->count()); ?></strong>
                                            </span>
                                            <span class="menumanage">
                                                <a href="<?php echo e(route('admin.menusItemsAction',['edit',$menuli->id])); ?>" style="margin: 0 10px; color: #7bdc00;"><i class="fa fa-edit"></i></a>
                                                <a href="<?php echo e(route('admin.menusAction',['edit',$menuli->id])); ?>" style="margin: 0 10px;"><i class="fa fa-plus"></i></a>
                                                
                                                <?php if(isset(json_decode(Auth::user()->permission->permission, true)['menus']['delete'])): ?>
                                                <label><i class="fa fa-trash text-danger"></i> <input class="checkbox" type="checkbox" name="deleteItems[]" value="<?php echo e($menuli->id); ?>"></label>
                                                <?php endif; ?>
                                                <span> </span>
                                            </span>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="form-group col-6">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="status" name="status" <?php echo e($parent->status=='active'?'checked':''); ?>/>
                                            <label class="custom-control-label" for="status">Active</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                    	<?php if(isset(json_decode(Auth::user()->permission->permission, true)['menus']['add'])): ?>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                      <?php endif; ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Basic Inputs end -->
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
<<script>
    $(document).ready(function(){
        $('.checkbox').click('');
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/admin/menus/menuEdit.blade.php ENDPATH**/ ?>