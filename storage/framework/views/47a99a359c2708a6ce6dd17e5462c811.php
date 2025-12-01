
<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Comments List')); ?></title>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<style type="text/css">
  .commentauthor img{
    float: left;
    margin-right: 10px;
    margin-top: 1px;
    width: 40px;
  }
  .table-responsive table tr.inactive {
    background: #ffcece;
  }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('contents'); ?>


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
     <h3 class="content-header-title mb-0">Comments List</h3>
     <div class="row breadcrumbs-top">
       <div class="breadcrumb-wrapper col-12">
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a>
           </li>
           <li class="breadcrumb-item active">Comments List</li>
         </ol>
       </div>
     </div>
   </div>
   <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
     <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
       	<a class="btn btn-outline-primary" href="<?php echo e(route('admin.postsCommentsAll')); ?>">
       		<i class="fa-solid fa-rotate"></i>
       	</a>
     </div>
   </div>
</div>
 
	

 <?php echo $__env->make(general()->adminTheme.'.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 <div class="card">
 	<div class="card-content">
 		<div id="accordion">
			    <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" id="headingTwo" style="background:#009688;padding: 15px 20px; cursor: pointer;">
			         <i class="fa fa-filter"></i> Search click Here..
			    </div>
			    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="border: 1px solid #00b5b8;border-top: 0;">
			      <div class="card-body">
			       	
			       	<form action="<?php echo e(route('admin.postsCommentsAll')); ?>">
			       		<div class="row">
			       			<div class="col-md-12 mb-0">
		       					<div class="input-group">
                             		<input type="text" name="search" value="<?php echo e(request()->search?request()->search:''); ?>" placeholder="Comments Title, email, website" class="form-control <?php echo e($errors->has('search')?'error':''); ?>">
                             		<button type="submit" class="btn btn-success btn-sm rounded-0"><i class="fa fa-search"></i> Search</button>
                 				</div>
			       			</div>
			       		</div>
			       </form>

			      </div>
			    </div>
			</div>
 	</div>
 </div>

 <div class="card">
 	<div class="card-header " style="border-bottom: 1px solid #e3ebf3;">
	 	<h4 class="card-title">Comments List</h4>
 	</div>
     <div class="card-content">
         <div class="card-body">
         	<form action="<?php echo e(route('admin.postsCommentsAll')); ?>">
         	<div class="row">
     			<div class="col-md-4">
     				<div class="input-group mb-1">
     					<select class="form-control form-control-sm rounded-0" name="action" required="">
     						<option value="1">Approve</option>
     						<option value="2">Un-approve</option>
     						<option value="3">Feature</option>
     						<option value="4">Un-feature</option>
     						<option value="5">Delete</option>
     					</select>
     					<button class="btn btn-sm btn-primary rounded-0" onclick="return confirm('Are You Want To Action?')">Action</button>
     				</div>
     			</div>
     		</div>
             <div class="table-responsive">


             	<table class="table table-striped table-bordered table-hover" >
				    <thead>
				        <tr>
				            <th width="5%"></th>
				            <th width="20%">Author</th>
				            <th>Comments</th>
				            <th width="20%">In Response To</th>
				            <th width="25%">Action</th>
				        </tr>
				    </thead>
				    <tbody>
				        <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				        <tr class="<?php echo e($comment->status=='inactive'?'inactive':''); ?>">
				            <td>
				              <input class="checkbox" type="checkbox" name="checkid[]" value="<?php echo e($comment->id); ?>"> 
				            </td>
				            <td class="commentauthor">
				            <?php if($comment->user): ?>
				            <span><img src="<?php echo e(asset($comment->user->image())); ?>"></span>
				            <?php else: ?>
				            <span><img src="<?php echo e(asset('public/medies/profile.png')); ?>"></span>
				            <?php endif; ?>

				            <?php if($comment->website==null): ?>
				            <span><?php echo e($comment->name); ?></span>
				            <?php else: ?>
				            <a href="//<?php echo e($comment->website); ?>" rel="nofollow" target="_blank"><?php echo e($comment->name); ?></a>
				            <?php endif; ?>     	       
				            <a href="mailto:<?php echo e($comment->email); ?>"><?php echo e($comment->email); ?></a>

				            
				            <br>
				            <?php if($comment->status=='active'): ?>
				           <span><i class="fa fa-check" style="color: #1ab394;"></i></span>
				           <a href="<?php echo e(route('admin.postsCommentsAction',['status',$comment->id])); ?>" class="badge btn-danger" style="color: black !important;">Unapprove</a>
				           <?php else: ?>
				           <span><i class="fa fa-times" style="color: #ed5565;"></i></span>
				           <a href="<?php echo e(route('admin.postsCommentsAction',['status',$comment->id])); ?>"  class="badge btn-success">Approved</a>
				           <?php endif; ?>
				           
				            </td>
				            <td>
				            <span>
				            <?php echo $comment->content; ?>

				            </span>
				            </td>
				            <td>
				                <?php if($comment->post): ?>
				                <a href="<?php echo e(route('admin.postsAction',['edit',$comment->post->id])); ?>" target="_blank"><?php echo e($comment->post->name); ?></a>
				                <br>
				                <a href="<?php echo e(route('blogView',$comment->post->slug)); ?>" target="_blank" class="badge btn-info">Post View</a><br>
				                <a href="<?php echo e(route('admin.postsComments',$comment->post->id)); ?>" class="badge badge-success"><i class="fa fa-comments"></i> View (<?php echo e($comment->post->postComments->where('status','<>','temp')->count()); ?>)</a>
				                <?php endif; ?>
				            </td>
				            <td class="center">
				            <a href="<?php echo e(route('admin.postsCommentsAction',['edit',$comment->id])); ?>" class="btn btn-md btn-info">Edit</a>
				            <a href="<?php echo e(route('admin.postsCommentsAction',['replay',$comment->id])); ?>" class="btn btn-md btn-info"><i class="fa fa-reply"></i></a>
				            <a href="<?php echo e(route('admin.postsCommentsAction',['delete',$comment->id])); ?>" onclick="return confirm('Are You Want To Delete?')" class="btn btn-md btn-danger" ><i class="fa fa-trash"></i></a>
				              <br>
				              <span><?php echo e($comment->created_at->format('d-m-Y h:i A')); ?></span>       
				            </td>
				        </tr>
				        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				    </tbody>
				</table>
				<?php echo e($comments->links('pagination')); ?>

             </div>
           	</form>
         </div>
     </div>
 </div>




<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/admin/posts/comments/postsCommentsAll.blade.php ENDPATH**/ ?>