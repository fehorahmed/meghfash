<div class="blog-sidebar">
	<div class="blogSearch mb-4">
		<h2 class="widget-title" style="margin-bottom: 13px;font-size: 24px;text-transform: uppercase;">Search Blog </h2>
		<form action="<?php echo e(route('blogSearch')); ?>">
			<div class="input-group">
				<input type="text" name="search" value="<?php echo e(request()->search); ?>" class="form-control" placeholder="Search" title="Search for." />
				<button type="submit" class="btn" style="background: #0ba350;color: white;">
					<i class="fa fa-search"></i>
				</button>
			</div>
		</form>
	</div>
	<hr>
	<div class="mb-4 widget_categories">
		<h2 class="widget-title" style="margin-bottom: 13px;font-size: 24px;text-transform: uppercase;">Categories </h2>
		<ul>
		<?php $__currentLoopData = App\Models\Attribute::where('type',6)->where('status','active')->where('parent_id',null)->orderBy('name')->limit(5)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<li><a href="<?php echo e(route('blogCategory',$ctg->slug?:'no-title')); ?>" style="color: #0ba36c;"><?php echo e($ctg->name); ?> (<?php echo e($ctg->activePosts()->count()); ?>)</a></li>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</ul>
	</div>
	<hr>
	<div class="mb-4 widget_categories">
		<h2 class="widget-title" style="margin-bottom: 13px;font-size: 24px;text-transform: uppercase;">Popular Post </h2>
		<?php $__currentLoopData = App\Models\Post::where('type',1)->where('status','active')->latest()->limit(5)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lPost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		
		<div class="card mb-3" style="max-width: 540px;">
			<div class="row g-0 m-0">
				<div class="col-md-4 p-0">
				    <img src="<?php echo e(asset($lPost->image())); ?>" class="img-fluid rounded-start" alt="<?php echo e($lPost->name); ?>">
				</div>
				<div class="col-md-8 p-0">
    				<div class="card-body" style="padding:5px 10px;">
    					<a href="<?php echo e(route('blogView',$lPost->slug?:'no-title')); ?>" style="height: 40px;display: block;overflow: hidden;line-height: 18px;color: black;"><?php echo e($lPost->name); ?></a>
    					<p style="margin:0;"><small><?php echo e($lPost->created_at->format('d-m-Y')); ?></small></p>
    				</div>
				</div>
			</div>
		</div>

		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

	</div>
	
</div> 
<?php /**PATH D:\xampp\htdocs\poshak\resources\views/welcome/blogs/includes/sideBar.blade.php ENDPATH**/ ?>