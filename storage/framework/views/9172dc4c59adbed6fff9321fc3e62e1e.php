 <!-- BEGIN: Main Menu-->
   <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
     <div class="main-menu-content">
       <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
         <li class=" navigation-header"><span>General </span><i class="feather icon-minus" ></i>
         </li>
         <li class=" nav-item <?php echo e(Request::is('admin/dashboard')? 'active' : ''); ?>">
          <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="fas fa-th-large"></i><span class="menu-title" data-i18n="Email Application">Dashboard</span></a>
         </li>
         
         <li class=" nav-item <?php echo e(Request::is('admin/my-profile')? 'active' : ''); ?>">
          <a href="<?php echo e(route('admin.myProfile')); ?>"><i class="fas fa-user-check"></i><span class="menu-title" >My Profile</span></a>
         </li>

         <!--Permission Check List Menus Start-->

        <?php if($roles = Auth::user()->permission): ?>
            
        <?php if(
         isset(json_decode($roles->permission, true)['posts']['list']) || 
         isset(json_decode($roles->permission, true)['postsOther']['list']) 
        ): ?>
        <li class="nav-item <?php echo e(Request::is('admin/posts*')? 'active' : ''); ?>">
          <a href="index.html">
          <i class="fas fa-file-alt"></i>
          <span class="menu-title" data-i18n="Dashboard">Posts </span>
          <!-- <span class="badge badge badge-primary badge-pill float-right mr-2">3 </span> -->
          </a>
           <ul class="menu-content">
             <?php if(isset(json_decode($roles->permission, true)['posts']['list'])): ?>
             <li class="
             <?php if( Request::is('admin/posts/categories*') || Request::is('admin/posts/tags*') || Request::is('admin/posts/comments*') ): ?>
             <?php else: ?>
             <?php echo e(Request::is('admin/posts*')? 'active' : ''); ?>

             <?php endif; ?>
             ">
              <a class="menu-item" href="<?php echo e(route('admin.posts')); ?>" >All Posts </a>
             </li>
             <?php endif; ?>

             <?php if(isset(json_decode($roles->permission, true)['posts']['add'])): ?>
             <li><a class="menu-item" href="<?php echo e(route('admin.postsAction',['create'])); ?>" >New Post </a>
             </li>
             <?php endif; ?>

             <?php if(isset(json_decode($roles->permission, true)['postsOther']['category'])): ?>
             <li class="<?php echo e(Request::is('admin/posts/categories*')? 'active' : ''); ?>">
              <a class="menu-item" href="<?php echo e(route('admin.postsCategories')); ?>" >Categories </a>
             </li>
             <?php endif; ?>

             <?php if(isset(json_decode($roles->permission, true)['postsOther']['tags'])): ?>
             <li class="<?php echo e(Request::is('admin/posts/tags*')? 'active' : ''); ?>">
              <a class="menu-item" href="<?php echo e(route('admin.postsTags')); ?>">Tags </a>
             </li>
             <?php endif; ?>

             <?php if(isset(json_decode($roles->permission, true)['postsOther']['comments'])): ?>
             <li class="<?php echo e(Request::is('admin/posts/comments*')? 'active' : ''); ?>">
              <a class="menu-item" href="<?php echo e(route('admin.postsCommentsAll')); ?>">Comments </a>
             </li>
             <?php endif; ?>
           </ul>
         </li>
         <?php endif; ?>

         <?php if(isset(json_decode($roles->permission, true)['pages']['list'])): ?>
          <li class="nav-item <?php echo e(Request::is('admin/pages*')? 'active' : ''); ?>"><a href="<?php echo e(route('admin.pages')); ?>"><i class="fas fa-copy"></i><span class="menu-title">Pages</span></a>
         </li>
         <?php endif; ?>

         <?php if(isset(json_decode($roles->permission, true)['medies']['list'])): ?>
         <li class="nav-item <?php echo e(Request::is('admin/medies*')? 'active' : ''); ?>"><a href="<?php echo e(route('admin.medies')); ?>"><i class="fas fa-images"></i><span class="menu-title">Medias Library</span></a>
         </li>
         <?php endif; ?>
         
         <li class=" navigation-header"><span>Products Unit </span><i class=" feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="Others"></i>
         
         <?php if(
         isset(json_decode($roles->permission, true)['ecommerceSetting']['general']) || 
         isset(json_decode($roles->permission, true)['ecommerceSetting']['coupons']) 
         ): ?>
         <li class="nav-item <?php echo e(Request::is('admin/ecommerce*')? 'active' : ''); ?>">
          <a href="#">
          <i class="fa-solid fa-sliders"></i> <span class="menu-title" >Ecommerce Setting </span></a>
           <ul class="menu-content">
               <?php if(isset(json_decode($roles->permission, true)['ecommerceSetting']['general'])): ?>
             <li class="<?php echo e(Request::is('admin/ecommerce/setting*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.ecommerceSetting','general')); ?>">General Setting</a>
                <?php endif; ?>
                <?php if(isset(json_decode($roles->permission, true)['ecommerceSetting']['coupons'])): ?>
             <li class="<?php echo e(Request::is('admin/ecommerce/coupons*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.ecommerceCoupons')); ?>">Coupons</a></li>
             </li>
             <?php endif; ?>
           </ul>
         </li>
         <?php endif; ?>

         <?php if(
         isset(json_decode($roles->permission, true)['products']['list']) ||  
         isset(json_decode($roles->permission, true)['productsCtg']['list']) 
         ): ?>
         <li class=" nav-item"><a href="#"><i class="fas fa-stream"></i><span class="menu-title" >Products </span></a>
           <ul class="menu-content">
             
            <?php if(isset(json_decode($roles->permission, true)['products']['list'])): ?>
             <li class="
             <?php if( Request::is('admin/products/categories*')): ?>
             <?php else: ?>
             <?php echo e(Request::is('admin/products*')? 'active' : ''); ?>

             <?php endif; ?>
             "><a class="menu-item" href="<?php echo e(route('admin.products')); ?>">All Products</a>
             </li>
             <?php endif; ?>

              <?php if(isset(json_decode($roles->permission, true)['postsOther']['category'])): ?>
             <li class="<?php echo e(Request::is('admin/products/categories*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.productsCategories')); ?>">Categories</a>
             </li>
             <?php endif; ?>
             <?php if(isset(json_decode($roles->permission, true)['postsOther']['tag'])): ?>
             <li class="<?php echo e(Request::is('admin/products/tags*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.productsTags')); ?>">Tags</a>
             </li>
             <?php endif; ?>
             <?php if(isset(json_decode($roles->permission, true)['postsOther']['attribute'])): ?>
             <li class="<?php echo e(Request::is('admin/products/attributes*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.productsAttributes')); ?>">Attributes</a>
             </li>
             <?php endif; ?>

           </ul>
         </li>
         <?php endif; ?>
        
        <?php if(
         isset(json_decode($roles->permission, true)['orders']['list']) 
         ): ?>
          <li class="nav-item <?php echo e(Request::is('admin/orders*')? 'active' : ''); ?>">
          <a href="#"><i class="fas fa-sitemap"></i><span class="menu-title" >Order Management</span></a>
           <ul class="menu-content">
             <li class="<?php echo e(Request::is('admin/orders')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.orders')); ?>"> Order List</a></li>
             <li class="<?php echo e(Request::is('admin/orders/pending')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.orders','pending')); ?>"> Pending Order</a></li>
             <li class="<?php echo e(Request::is('admin/orders/confirmed')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.orders','confirmed')); ?>"> Confirmed Orders</a></li>
             <li class="<?php echo e(Request::is('admin/orders/shipped')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.orders','shipped')); ?>"> Shipped Orders</a></li>
             <li class="<?php echo e(Request::is('admin/orders/delivered')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.orders','delivered')); ?>"> Delivered Orders</a></li>
             <li class="<?php echo e(Request::is('admin/orders/cancelled')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.orders','cancelled')); ?>"> Cancelled Orders</a></li>
             <li class="<?php echo e(Request::is('admin/orders/unpaid')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.orders','unpaid')); ?>"> Unpaid Orders</a></li>
             <li class="<?php echo e(Request::is('admin/orders/pending-payment')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.orders','pending-payment')); ?>"> Pending Payment</a></li> 
           </ul>
        </li>
        <?php endif; ?>
        
        <li class=" navigation-header"><span style="color: #009688;font-weight: bold;">POS Unit </span><i class=" feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="Others"></i>
        </li>
        <li class="nav-item <?php echo e(Request::is('admin/pos-sales*')? 'active' : ''); ?>">
          <a href="#"><i class="fas fa-desktop"></i><span class="menu-title" >POS Management</span></a>
           <ul class="menu-content">
             <li 
             
             <?php if(Request::is('admin/pos-sales/reports')): ?>
             
             <?php else: ?>
             class="<?php echo e(Request::is('admin/pos-sales')? 'active' : ''); ?>"
             <?php endif; ?>
             ><a class="menu-item" href="<?php echo e(route('admin.posOrders')); ?>"> POS Sales</a></li>
             <li class="<?php echo e(Request::is('admin/orders/pending')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.posOrdersAction','create')); ?>"> New Order</a></li>
             <li class="<?php echo e(Request::is('admin/pos-sales/reports')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.posOrdersReports')); ?>"> Sales Reports</a></li>
           </ul>
        </li>
        
        <li class=" nav-item <?php echo e(Request::is('admin/warehouses*')? 'active' : ''); ?>"><a href="<?php echo e(route('admin.productsWarehouses')); ?>"><i class="fas fa-home"></i><span class="menu-title">Warehouse/Branch</span></a>
         </li>
        
        <li class=" nav-item <?php echo e(Request::is('admin/payment-method*')? 'active' : ''); ?>"><a href="<?php echo e(route('admin.paymentMethods')); ?>"><i class="fas fa-money"></i><span class="menu-title">Payment Methods</span></a>
         </li>
         
        <?php if(
         isset(json_decode($roles->permission, true)['reports']['summery']) ||
         isset(json_decode($roles->permission, true)['reports']['products']) ||
         isset(json_decode($roles->permission, true)['reports']['customer']) ||
         isset(json_decode($roles->permission, true)['reports']['orders']) 
         ): ?>
        <li class=" navigation-header"><span style="color: #009688;font-weight: bold;">Report Unit </span><i class=" feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="Others"></i>
         </li>
         <li class="nav-item <?php echo e(Request::is('admin/reports*')? 'active' : ''); ?>">
          <a href="#"><i class="fas fa-chart-line"></i><span class="menu-title" > Reports Management</span></a>
           <ul class="menu-content">
             
             <?php if(isset(json_decode($roles->permission, true)['reports']['summery'])): ?>
             <li class="<?php echo e(Request::is('admin/reports/summery*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.reportsAll','summery')); ?>"> Summery Reports</a></li>
             <?php endif; ?>
             
             <?php if(isset(json_decode($roles->permission, true)['reports']['products'])): ?>
             <li class="<?php echo e(Request::is('admin/reports/products*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.reportsAll','products')); ?>"> Products Reports</a></li>
             <?php endif; ?>
             
             <?php if(isset(json_decode($roles->permission, true)['reports']['customer'])): ?>
             <li class="<?php echo e(Request::is('admin/reports/customer-reports*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.reportsAll','customer-reports')); ?>"> Customer Reports</a></li>
             <?php endif; ?>
             
             <?php if(isset(json_decode($roles->permission, true)['reports']['orders'])): ?>
             <li class="<?php echo e(Request::is('admin/reports/order-reports*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.reportsAll','order-reports')); ?>"> Order Reports</a></li>
             <?php endif; ?>
             
           </ul>
         </li>
         <?php endif; ?>
         
         <?php if(
        isset(json_decode($roles->permission, true)['clients']['list']) ||  
         isset(json_decode($roles->permission, true)['brands']['list']) ||
         isset(json_decode($roles->permission, true)['sliders']['list']) ||
         isset(json_decode($roles->permission, true)['galleries']['list']) ||
         isset(json_decode($roles->permission, true)['menus']['list']) ||
         isset(json_decode($roles->permission, true)['themeSetting']['list'])
        ): ?>
        
         <li class=" navigation-header"><span style="color: #009688;font-weight: bold;">General Unit </span><i class=" feather icon-minus" ></i>
         </li>
         

         <?php if(isset(json_decode($roles->permission, true)['clients']['list'])): ?>
         <li class=" nav-item <?php echo e(Request::is('admin/clients*')? 'active' : ''); ?>"><a href="<?php echo e(route('admin.clients')); ?>"><i class="fas fa-user-tie"></i><span class="menu-title">Clients</span></a>
         </li>
         <?php endif; ?>

         <?php if(isset(json_decode($roles->permission, true)['brands']['list'])): ?>
         <li class=" nav-item <?php echo e(Request::is('admin/brands*')? 'active' : ''); ?>"><a href="<?php echo e(route('admin.brands')); ?>"><i class="fas fa-chess-rook"></i><span class="menu-title">Brands</span></a>
         </li>
         <?php endif; ?>

         <?php if(isset(json_decode($roles->permission, true)['sliders']['list'])): ?>
         <li class=" nav-item <?php echo e(Request::is('admin/sliders*')? 'active' : ''); ?>"><a href="<?php echo e(route('admin.sliders')); ?>"><i class="fas fa-chalkboard"></i><span class="menu-title">Sliders</span></a>
         </li>
         <?php endif; ?>

         <?php if(isset(json_decode($roles->permission, true)['galleries']['list'])): ?>
         <li class=" nav-item <?php echo e(Request::is('admin/galleries*')? 'active' : ''); ?>"><a href="<?php echo e(route('admin.galleries')); ?>"><i class="fas fa-images"></i><span class="menu-title">Galleries</span></a>
         </li>
         <?php endif; ?>

         <?php if(isset(json_decode($roles->permission, true)['menus']['list'])): ?>
         <li class=" nav-item <?php echo e(Request::is('admin/menus*')? 'active' : ''); ?>"><a href="<?php echo e(route('admin.menus')); ?>"><i class="fas fa-bars"></i><span class="menu-title">Menus Setting</span></a>
         </li>
         <?php endif; ?>

         <?php if(isset(json_decode($roles->permission, true)['themeSetting']['list'])): ?>
         <li class=" nav-item <?php echo e(Request::is('admin/theme-setting*')? 'active' : ''); ?>"><a href="<?php echo e(route('admin.themeSetting')); ?>"><i class="fa-solid fa-sliders"></i><span class="menu-title">Theme Setting</span></a>
         </li>
         <?php endif; ?>
        
        <?php endif; ?>

        <?php if(
        isset(json_decode($roles->permission, true)['adminUsers']['list']) ||  
         isset(json_decode($roles->permission, true)['adminRoles']['list']) ||
         isset(json_decode($roles->permission, true)['users']['list']) ||
         isset(json_decode($roles->permission, true)['subscribe']['list']) 
        ): ?>

         <li class=" navigation-header"><span style="color: #00bcd4;font-weight: bold;">Users Management </span><i class="feather icon-droplet feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="UI"></i>
         </li>
         <?php if(isset(json_decode($roles->permission, true)['adminUsers']['list'])): ?>
         <li class=" nav-item <?php echo e(Request::is('admin/users/admin*')? 'active' : ''); ?>">
          <a href="<?php echo e(route('admin.usersAdmin')); ?>"><i class="fas fa-user"></i><span class="menu-title" >Administrator Users </span></a>
         </li>
         <?php endif; ?>

         <?php if(isset(json_decode($roles->permission, true)['adminRoles']['list'])): ?>
         <li class=" nav-item <?php echo e(Request::is('admin/users/role*')? 'active' : ''); ?>">
          <a href="<?php echo e(route('admin.userRoles')); ?>"><i class="fas fa-ruler-combined"></i><span class="menu-title" >Roles Users </span></a>
         </li>
         <?php endif; ?>

         <?php if(isset(json_decode($roles->permission, true)['users']['list'])): ?>
         <li class=" nav-item <?php echo e(Request::is('admin/users/customer*')? 'active' : ''); ?>">
          <a href="<?php echo e(route('admin.usersCustomer')); ?>"><i class="fas fa-users"></i><span class="menu-title" >Customer Users </span></a>
         </li>
         <?php endif; ?>


         <?php if(isset(json_decode($roles->permission, true)['subscribe']['list'])): ?>
         <li class=" nav-item <?php echo e(Request::is('admin/subscribes*')? 'active' : ''); ?>">
          <a href="<?php echo e(route('admin.subscribes')); ?>"><i class="fas fa-user-tag"></i><span class="menu-title" >Subscribe Users </span></a>
         </li>
         <?php endif; ?>

         <?php endif; ?>
         
        <?php if(
         isset(json_decode($roles->permission, true)['appsSetting']['general']) ||  
         isset(json_decode($roles->permission, true)['appsSetting']['mail']) ||
         isset(json_decode($roles->permission, true)['appsSetting']['sms']) ||
         isset(json_decode($roles->permission, true)['appsSetting']['social']) 
         ): ?>
         <li class=" navigation-header"><span style="color: #000000;font-weight: bold;">Apps Setting </span><i class=" feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="Others"></i>
         </li>
         <?php endif; ?>
         
         
         <?php if(isset(json_decode($roles->permission, true)['appsSetting']['general'])): ?>
         <li class="nav-item <?php echo e(Request::is('admin/setting/general*')? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.setting','general')); ?>">
              <i class="fa fa-cog"></i>
              <span class="menu-title" >General Setting</span>
            </a>
         </li>
         <?php endif; ?>

         <?php if(isset(json_decode($roles->permission, true)['appsSetting']['mail'])): ?>
         <li class=" nav-item <?php echo e(Request::is('admin/setting/mail*')? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.setting','mail')); ?>">
              <i class="fas fa-envelope"></i>
              <span class="menu-title" >Mail Setting</span>
            </a>
         </li>
         <?php endif; ?>

         <?php if(isset(json_decode($roles->permission, true)['appsSetting']['sms'])): ?>
          <li class=" nav-item <?php echo e(Request::is('admin/setting/sms*')? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.setting','sms')); ?>">
              <i class="fas fa-comments"></i>
              <span class="menu-title">SMS Setting</span>
            </a>
         </li>
         <?php endif; ?>

         <?php if(isset(json_decode($roles->permission, true)['appsSetting']['social'])): ?>
          <li class=" nav-item <?php echo e(Request::is('admin/setting/social*')? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.setting','social')); ?>">
              <i class="fab fa-codepen"></i>
              <span class="menu-title">Social Setting</span>
            </a>
         </li>
         <?php endif; ?>
         <?php endif; ?>

         <!--Permission Check List Menus End-->

       </ul>
       <div style="padding: 15px;text-align: center;border: 1px solid #e5e7ec;font-size: 20px;">
         <p>Support Center<br>Contact Us<br>Call: 01619-991807</p>
       </div>
     </div>
   </div>
   <!-- END: Main Menu--><?php /**PATH D:\xampp\htdocs\poshak\resources\views/admin/layouts/sidebar.blade.php ENDPATH**/ ?>