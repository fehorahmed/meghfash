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

         
         <?php if(
         isset(json_decode($roles->permission, true)['ecommerceSetting']['general']) || 
         isset(json_decode($roles->permission, true)['ecommerceSetting']['promotions']) || 
         isset(json_decode($roles->permission, true)['ecommerceSetting']['coupons']) ||
         isset(json_decode($roles->permission, true)['products']['list']) ||  
         isset(json_decode($roles->permission, true)['postsOther']['tag']) ||  
         isset(json_decode($roles->permission, true)['postsOther']['attribute']) ||  
         isset(json_decode($roles->permission, true)['postsOther']['category'])  ||
         isset(json_decode($roles->permission, true)['orders']['list']) 
         ): ?>
         
         <li class=" navigation-header"><span>Products Unit </span><i class=" feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="Others"></i>
         
         <?php if(
         isset(json_decode($roles->permission, true)['ecommerceSetting']['general']) || 
         isset(json_decode($roles->permission, true)['ecommerceSetting']['promotions']) || 
         isset(json_decode($roles->permission, true)['ecommerceSetting']['coupons']) 
         ): ?>
         <li class="nav-item <?php echo e(Request::is('admin/ecommerce*')? 'active' : ''); ?>">
          <a href="#">
          <i class="fa-solid fa-sliders"></i> <span class="menu-title" >Ecommerce Setting </span></a>
           <ul class="menu-content">
            <?php if(isset(json_decode($roles->permission, true)['ecommerceSetting']['general'])): ?>
                <li class="<?php echo e(Request::is('admin/ecommerce/setting*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.ecommerceSetting','general')); ?>">General Setting</a></li>
            <?php endif; ?>
            <?php if(isset(json_decode($roles->permission, true)['ecommerceSetting']['coupons'])): ?>
             <li class="<?php echo e(Request::is('admin/ecommerce/coupons*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.ecommerceCoupons')); ?>">Coupons</a></li>
             <?php endif; ?>
            
            <?php if(isset(json_decode($roles->permission, true)['ecommerceSetting']['promotions'])): ?>
             <li class="<?php echo e(Request::is('admin/ecommerce/promotions*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.ecommercePromotions')); ?>">Promotions</a></li>
             <?php endif; ?>
           </ul>
         </li>
         <?php endif; ?>

         <?php if(
         isset(json_decode($roles->permission, true)['products']['list']) ||  
         isset(json_decode($roles->permission, true)['postsOther']['tag']) ||  
         isset(json_decode($roles->permission, true)['postsOther']['attribute']) ||  
         isset(json_decode($roles->permission, true)['postsOther']['category']) 
         ): ?>
         <li class=" nav-item"><a href="#"><i class="fas fa-stream"></i><span class="menu-title" >Products </span></a>
           <ul class="menu-content">
             
            <?php if(isset(json_decode($roles->permission, true)['products']['list'])): ?>
             <li class="
             <?php if( Request::is('admin/products/categories*') || Request::is('admin/products/lavel-print*') ): ?>
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
             
             <?php if(isset(json_decode($roles->permission, true)['products']['list'])): ?>
             <li class="<?php echo e(Request::is('admin/products/lavel-print*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.productsLabelPrint')); ?>">Lavel Print</a>
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
          <li class=" nav-item <?php echo e(Request::is('admin/order-return*')? 'active' : ''); ?>"><a href="<?php echo e(route('admin.ordersReturn')); ?>"><i class="fas fa-undo"></i><span class="menu-title">Order Return</span></a></li>
          <li class="nav-item <?php echo e(Request::is('admin/whole-sales*')? 'active' : ''); ?>">
          <a href="#"><i class="fas fa-sitemap"></i><span class="menu-title" >Wholesale orders </span></a>
           <ul class="menu-content">
             <li class="<?php echo e(Request::is('admin/whole-sales')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.wholeSales')); ?>"> Order List</a></li>
             <li class="<?php echo e(Request::is('admin/whole-sales/pending')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.wholeSales','pending')); ?>"> Pending Order</a></li>
             <li class="<?php echo e(Request::is('admin/whole-sales/delivered')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.wholeSales','delivered')); ?>"> Delivered Orders</a></li>
             <li class="<?php echo e(Request::is('admin/whole-sales/cancelled')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.wholeSales','cancelled')); ?>"> Cancelled Orders</a></li>
             <li class="<?php echo e(Request::is('admin/whole-sales/unpaid')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.wholeSales','unpaid')); ?>"> Unpaid Orders</a></li>
           </ul>
        </li>
        
        <li class=" nav-item <?php echo e(Request::is('admin/wholesale-return*')? 'active' : ''); ?>"><a href="<?php echo e(route('admin.wholesaleReturn')); ?>"><i class="fas fa-undo"></i><span class="menu-title">Wholesale Return</span></a></li>
        <?php endif; ?>
        
        <?php endif; ?>
        
        
        
        
        <?php if(
         isset(json_decode($roles->permission, true)['posUrders']['list']) ||
         isset(json_decode($roles->permission, true)['expenses']['list']) 
         ): ?>
        <li class=" navigation-header"><span style="color: #009688;font-weight: bold;">POS Unit </span><i class=" feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="Others"></i>
        </li>
        <?php if(
         isset(json_decode($roles->permission, true)['posUrders']['list']) 
         ): ?>
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
             
             <?php if(isset(json_decode($roles->permission, true)['posUrders']['salesreport'])): ?>
             <li class="<?php echo e(Request::is('admin/pos-sales/reports')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.posOrdersReports')); ?>"> Sales Reports</a></li>
             <?php endif; ?>
           </ul>
        </li>
        <?php endif; ?>
        
        <?php if(
         isset(json_decode($roles->permission, true)['expenses']['report']) ||
         isset(json_decode($roles->permission, true)['expenses']['list']) 
         ): ?>
        <li class="nav-item <?php echo e(Request::is('admin/expenses*')? 'active' : ''); ?>">
          <a href="#"><i class="fas fa-list"></i><span class="menu-title" >Expenses</span></a>
           <ul class="menu-content">
               <?php if(isset(json_decode($roles->permission, true)['expenses']['list'])): ?>
             <li 
             
             <?php if(Request::is('admin/expenses/types')): ?>
             
             <?php else: ?>
             class="<?php echo e(Request::is('admin/expenses')? 'active' : ''); ?>"
             <?php endif; ?>
             ><a class="menu-item" href="<?php echo e(route('admin.expensesList')); ?>"> Expenses List</a></li>
             <?php endif; ?>
             
             
             <?php if(isset(json_decode($roles->permission, true)['expenses']['type'])): ?>
             <li class="<?php echo e(Request::is('admin/expenses/types*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.expensesTypes')); ?>"> Head of Expenses</a></li>
             <?php endif; ?>
             
             <?php if(isset(json_decode($roles->permission, true)['expenses']['report'])): ?>
             <li class="<?php echo e(Request::is('admin/expenses/reports')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.expensesReports')); ?>"> Expenses Reports</a></li>
             <?php endif; ?>
           </ul>
        </li>
        <?php endif; ?>
        <?php endif; ?>
        
        
         <?php if(
         isset(json_decode($roles->permission, true)['suppliers']['list']) ||
         isset(json_decode($roles->permission, true)['stockManage']['list']) ||
         isset(json_decode($roles->permission, true)['stockManage']['report']) ||
         isset(json_decode($roles->permission, true)['paymentMethod']['list']) ||
         isset(json_decode($roles->permission, true)['warehouse']['list']) 
         ): ?>
        
        
        <li class=" navigation-header"><span style="color: #009688;font-weight: bold;">Inventory Unit </span><i class=" feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="Others"></i></li>
        
        <li class="nav-item <?php echo e(Request::is('admin/reports*')? 'active' : ''); ?>">
          <a href="#"><i class="fa fa-home"></i><span class="menu-title" > Inventory Management</span></a>
           <ul class="menu-content">
             <?php if(isset(json_decode($roles->permission, true)['suppliers']['list'])): ?>
             <li class="<?php echo e(Request::is('admin/suppliers*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.usersSupplier')); ?>"> Suppliers</a></li>
             <?php endif; ?>
             
             <?php if(isset(json_decode($roles->permission, true)['warehouse']['list'])): ?>
             <li class="<?php echo e(Request::is('admin/warehouses*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.productsWarehouses')); ?>"> Store/Branch</a></li>
             <li class="<?php echo e(Request::is('admin/stock-transfer*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.stockTransfer')); ?>"> Stock Transfer</a></li>
             <li class="<?php echo e(Request::is('admin/stock-minus*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.stockMinus')); ?>"> Stock Minus</a></li>
             <?php endif; ?>
             
             <?php if(isset(json_decode($roles->permission, true)['stockManage']['list'])): ?>
             
             <li class="<?php echo e(Request::is('admin/stock-management*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.purchases')); ?>"> Stock Management</a></li>
            <?php endif; ?>
            
            <?php if(isset(json_decode($roles->permission, true)['stockManage']['report'])): ?>
             <li class="<?php echo e(Request::is('admin/stock-report*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.stocksList')); ?>"> Stock Reports</a></li>
            <?php endif; ?>
            
            <?php if(isset(json_decode($roles->permission, true)['paymentMethod']['list'])): ?>
             <li class="<?php echo e(Request::is('admin/payment-method*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.paymentMethods')); ?>"> Payment Methods</a></li>
            <?php endif; ?>
            
           </ul>
         </li>
        
        
         
         
         <?php endif; ?>
         
         
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
             <li class="<?php echo e(Request::is('admin/reports/summery*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.reportsAll','summery')); ?>"> Summery Sales Reports</a></li>
             <li class="<?php echo e(Request::is('admin/reports/today-reports*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.reportsAll','today-reports')); ?>"> Today Reports</a></li>
             <?php endif; ?>
             
             <?php if(isset(json_decode($roles->permission, true)['reports']['products'])): ?>
             <li class="<?php echo e(Request::is('admin/reports/products*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.reportsAll','products')); ?>"> Products Reports</a></li>
             
             <li class="<?php echo e(Request::is('admin/reports/history-of-product*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.reportsAll','history-of-product')); ?>"> Top Product Report</a></li>
             <?php endif; ?>
             
             <?php if(isset(json_decode($roles->permission, true)['reports']['products'])): ?>
             <li class="<?php echo e(Request::is('admin/reports/store-branch*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.reportsAll','store-branch')); ?>"> Store/Branch Reports</a></li>
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
        isset(json_decode($roles->permission, true)['pages']['list']) ||  
        isset(json_decode($roles->permission, true)['medies']['list']) ||  
        isset(json_decode($roles->permission, true)['clients']['list']) ||  
         isset(json_decode($roles->permission, true)['brands']['list']) ||
         isset(json_decode($roles->permission, true)['sliders']['list']) ||
         isset(json_decode($roles->permission, true)['galleries']['list']) ||
         isset(json_decode($roles->permission, true)['menus']['list']) ||
         isset(json_decode($roles->permission, true)['themeSetting']['list'])
        ): ?>
        
         <li class=" navigation-header"><span style="color: #009688;font-weight: bold;">General Unit </span><i class=" feather icon-minus" ></i>
         </li>
         
         <li class="nav-item <?php echo e(Request::is('admin/clients*')? 'active' : ''); ?>">
          <a href="#"><i class="fas fa-bars"></i><span class="menu-title" >General Unit </span></a>
           <ul class="menu-content">
               
             <?php if(isset(json_decode($roles->permission, true)['pages']['list'])): ?>
             <li class="<?php echo e(Request::is('admin/pages*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.pages')); ?>"> Pages</a></li>
             <?php endif; ?>
             
             <?php if(isset(json_decode($roles->permission, true)['medies']['list'])): ?>
             <li class="<?php echo e(Request::is('admin/medies*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.medies')); ?>"> Medias Library</a></li>
             <?php endif; ?>
             
             <?php if(isset(json_decode($roles->permission, true)['clients']['list'])): ?>
             <li class="<?php echo e(Request::is('admin/clients*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.clients')); ?>"> Clients</a></li>
             <?php endif; ?>
             
             <?php if(isset(json_decode($roles->permission, true)['brands']['list'])): ?>
             <li class="<?php echo e(Request::is('admin/brands*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.brands')); ?>"> Brands</a></li>
             <?php endif; ?>
             
             <?php if(isset(json_decode($roles->permission, true)['sliders']['list'])): ?>
             <li class="<?php echo e(Request::is('admin/sliders*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.sliders')); ?>"> Sliders</a></li>
             <?php endif; ?>
             
             <?php if(isset(json_decode($roles->permission, true)['galleries']['list'])): ?>
             <li class="<?php echo e(Request::is('admin/galleries*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.galleries')); ?>"> Galleries</a></li>
             <?php endif; ?>
             
             <?php if(isset(json_decode($roles->permission, true)['menus']['list'])): ?>
             <li class="<?php echo e(Request::is('admin/menus*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.menus')); ?>"> Menus Setting</a></li>
             <?php endif; ?>
             
             <?php if(isset(json_decode($roles->permission, true)['themeSetting']['list'])): ?>
             <li class="<?php echo e(Request::is('admin/theme-setting*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.themeSetting')); ?>"> Theme Setting</a></li>
             <?php endif; ?>
           </ul>
        </li>
         
        
        
        <?php endif; ?>

        <?php if(
        isset(json_decode($roles->permission, true)['adminUsers']['list']) ||  
         isset(json_decode($roles->permission, true)['adminRoles']['list']) ||
         isset(json_decode($roles->permission, true)['users']['list']) ||
         isset(json_decode($roles->permission, true)['subscribe']['list']) 
        ): ?>

         <li class=" navigation-header"><span style="color: #00bcd4;font-weight: bold;">Users Management </span><i class="feather icon-droplet feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="UI"></i>
         </li>
         
         <li class="nav-item <?php echo e(Request::is('admin/reports*')? 'active' : ''); ?>">
          <a href="#"><i class="fa fa-user"></i><span class="menu-title" > Users Management</span></a>
           <ul class="menu-content">
             <?php if(isset(json_decode($roles->permission, true)['adminUsers']['list'])): ?>
             <li class="<?php echo e(Request::is('admin/users/admin*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.usersAdmin')); ?>"> Administrator Users</a></li>
             <?php endif; ?>
             
             <?php if(isset(json_decode($roles->permission, true)['adminRoles']['list'])): ?>
             <li class="<?php echo e(Request::is('admin/users/role*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.userRoles')); ?>"> Roles Users</a></li>
             <?php endif; ?>
             
             <?php if(isset(json_decode($roles->permission, true)['users']['list'])): ?>
             
             <li class="<?php echo e(Request::is('admin/users/customer*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.usersCustomer')); ?>"> Customer Users</a></li>

             <li class="<?php echo e(Request::is('admin/users/wholesale-customer*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.usersWholesaleCustomer')); ?>"> Wholesale Customer</a></li>
             <?php endif; ?>
           </ul>
         </li>
         
         
         

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
         
         
         <li class="nav-item <?php echo e(Request::is('admin/reports*')? 'active' : ''); ?>">
          <a href="#"><i class="fa fa-cog"></i><span class="menu-title" > Apps Setting</span></a>
           <ul class="menu-content">
             <?php if(isset(json_decode($roles->permission, true)['appsSetting']['general'])): ?>
             <li class="<?php echo e(Request::is('admin/setting/general*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.setting','general')); ?>"> General Setting</a></li>
             <?php endif; ?>
             
             <?php if(isset(json_decode($roles->permission, true)['appsSetting']['mail'])): ?>
             <li class="<?php echo e(Request::is('admin/setting/mail*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.setting','mail')); ?>"> Mail Setting</a></li>
             <?php endif; ?>
             
             <?php if(isset(json_decode($roles->permission, true)['appsSetting']['sms'])): ?>
             <li class="<?php echo e(Request::is('admin/setting/sms*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.setting','sms')); ?>"> SMS Setting</a></li>
             <?php endif; ?>
             
             <?php if(isset(json_decode($roles->permission, true)['appsSetting']['social'])): ?>
             <li class="<?php echo e(Request::is('admin/setting/social*')? 'active' : ''); ?>"><a class="menu-item" href="<?php echo e(route('admin.setting','social')); ?>"> Social Setting</a></li>
             <?php endif; ?>
           </ul>
         </li>
         
         
         
         <?php endif; ?>
    
         <!--Permission Check List Menus End-->

       </ul>
       <div style="padding: 15px;text-align: center;border: 1px solid #e5e7ec;font-size: 20px;">
         <p>Support Center<br>Contact Us<br>Call: 01619-991807</p>
       </div>
     </div>
   </div>
   <!-- END: Main Menu--><?php /**PATH /home/meghfash/public_html/resources/views/admin/layouts/sidebar.blade.php ENDPATH**/ ?>