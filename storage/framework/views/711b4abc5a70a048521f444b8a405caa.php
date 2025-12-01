 <style>
     body.vertical-layout.vertical-menu-modern.menu-expanded .navbar .navbar-brand .brand-text{
         font-size: 22px;
     }
 </style>
 
 <!-- BEGIN: Header-->
 <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow">
   <div class="navbar-wrapper">
     <div class="navbar-header">
       <ul class="nav navbar-nav flex-row">
         <li class="nav-item mobile-menu d-lg-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#">
          <!-- <i class="fa-2x fas fa-bars"></i> -->
          <i class="fa-2x fas fa-arrow-alt-circle-right"></i>
          </a>
          </li>
         <li class="nav-item mr-auto">
          <a class="navbar-brand" href="<?php echo e(route('index')); ?>">
             <img class="brand-logo" src="<?php echo e(asset(general()->favicon())); ?>" style="max-height:30px;background: white;border-radius: 50%;" />
             <h2 class="brand-text">Posher</h2>
           </a>
           </li>
         <li class="nav-item d-none d-lg-block nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse" style="    color: white;"><i class="fa-2x fas fa-bars"></i></a></li>
       </ul>
     </div>
     <div class="navbar-container content">
       <div class="collapse navbar-collapse" id="navbar-mobile">
         <ul class="nav navbar-nav mr-auto float-left">
           
           <li class="nav-item d-none d-md-block">
            <a class="nav-link nav-link-expand" href="#">
              <i class="fas fa-compress"></i>
            </a>
          </li>
          <li class="nav-item d-none d-md-block">
            <a class="nav-link">Quick Link</a>
          </li>
         </ul>
         <ul class="nav navbar-nav float-right">

           <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="javascript:void(0)" data-toggle="dropdown">
               <div class="avatar avatar-online">
                <img src="<?php echo e(asset(Auth::user()->image())); ?>" alt="avatar" /><i></i>
              </div>
               <span class="user-name"><?php echo e(Str::limit(Auth::user()->name,15)); ?></span></a>
               <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="<?php echo e(route('customer.dashboard')); ?>" style="min-width: 220px"><i class="fas fa-th-large"></i> My Dashboard </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo e(route('admin.myProfile')); ?>" style="min-width: 220px"><i class="fas fa-user-check"></i> My Profile </a>

                 <div class="dropdown-divider"></div>
                 
                 <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="fas fa-power-off"></i> Logout 
                  </a>
                  
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
                
               </div>
           </li>
         </ul>
       </div>
     </div>
   </div>
 </nav>
 <!-- END: Header--><?php /**PATH C:\xampp\htdocs\posher-react-laravel\resources\views/admin/layouts/header.blade.php ENDPATH**/ ?>