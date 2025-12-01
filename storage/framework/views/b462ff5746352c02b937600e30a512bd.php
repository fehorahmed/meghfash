 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Medias Library')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css">
    .fileuploard-div {
        border: 2px dotted #e3e3e3;
        padding: 25px;
        text-align: center;
    }

    .fileuploard-div p {
        font-size: 20px;
        color: silver;
        text-transform: uppercase;
    }
    .fileuploard-div label {
        margin: 0;
    }
    .fileuploard-div i {
        font-size: 60px;
        cursor: pointer;
        color: #c6c2c2;
    }

    ul.medialists {
        margin: 0;
        padding: 0;
        list-style: none;
    }
    ul.medialists li img {
        width: 100%;
    }
    ul.medialists li {
        display: inline-block;
        width: 9%;
        border: 1px solid #d4d4d4;
        cursor: pointer;
        padding: 5px;
        margin: 3px;
        position: relative;
        height: 100px;
    }

    .progressdivs {
    }
    .mediaImagediv {
        overflow: hidden;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        opacity: 1;
        transition: opacity 0.1s;
    }

    @media only screen and (max-width: 600px) {
        ul.medialists li {
            width: 17%;
            height: 70px;
        }
    }
</style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Medias Library</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Medias Library</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.medies')); ?>">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>


<?php echo $__env->make(adminTheme().'alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php if(isset(json_decode(Auth::user()->permission->permission, true)['medies']['add'])): ?>
<div class="card">
    <div class="card-content">
        <div class="card-body">
            <form action="<?php echo e(route('admin.mediesCreate')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="fileuploard-div">
                    <div>
                        <p>Click To Files upload</p>
                    </div>
                    <div>
                        <?php if(session('errors')): ?>
                        <ul style="list-style: none;">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li style="color: #f44336; font-weight: bold; font-size: 12px;"><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label>
                            <input type="file" name="images[]" multiple="" class="fileuploard" />
                        </label>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
<form action="<?php echo e(route('admin.medies')); ?>" class="mediaAllForm" >
    <input type="hidden" name="actionType" value="allDelete">
    <div class="card">
        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
            <h4 class="card-title">Medias All 
                <?php if(isset(json_decode(Auth::user()->permission->permission, true)['medies']['delete'])): ?>
                <a href="javascript:void(0)" class="btn btn-sm btn-danger mediaAllDeleted">Delete</a>
                <?php endif; ?>
            </h4>
        </div>
        <div class="card-content">
            <div class="card-body moremediesDiv">
                <div class="dataLastPage" data-lastpage="<?php echo e($medies->lastPage()); ?>" data-nowpage="1"></div>
                <ul class="postsAuto medialists">
                    <?php echo $__env->make(adminTheme().'medies.includes.mediesAll', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </ul>
                <div class="text-center mt-2" style="display: none;">
                    <div class="loader"><i class="fa fa-spin fa-spinner"></i></div>
                </div>
                <?php if($medies->lastPage() > 1): ?>
                <div>
                    <p class="moremedies">
                        <span class="badge" style="color: white; background: #1c84c6; cursor: pointer;">More ..</span>
                    </p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</form>


<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?>

<script type="text/javascript">
    $(".progressdivs1").hide();
    $(document).ready(function () {
        $(".mediaAllDeleted").click(function () {
            if (confirm("Are you want to delete All Selected?")) {
                $("form.mediaAllForm").trigger("submit");
            } else {
                return false;
            }
        });

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $(".moremediesDiv").on("click", ".moremedies", function () {
            var LP = $(".dataLastPage").attr("data-lastpage");
            var pageWall = parseInt($(".dataLastPage").attr("data-nowpage"));

            if (pageWall < LP) {
                pageWall = pageWall + 1;
                $(".dataLastPage").attr("data-nowpage", pageWall);

                var dataUrl = $(".dataLastPage").attr("data-url");

                if (typeof dataUrl !== typeof undefined && dataUrl !== false) {
                    var url = dataUrl;
                } else {
                    var url = "";
                }

                getPosts(pageWall, url);
            } else {
                $(".moremedies").empty().append("NO Data");
            }

            function getPosts(pageWall, url) {
                $.ajax({
                    url: url + "?page=" + pageWall,
                    dataType: "json",
                    beforeSend: function () {
                        $(".loading").show();
                        $(".loader").show();
                    },
                    complete: function () {
                        $(".loading").hide();
                        $(".loader").hide();
                    },
                })
                    .done(function (data) {
                        $(".postsAuto").append(data.view);

                        // location.hash = pageWall;
                    })
                    .fail(function () {
                        $(".moremedies").html("No More Data.");
                    });
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/medies/medies.blade.php ENDPATH**/ ?>