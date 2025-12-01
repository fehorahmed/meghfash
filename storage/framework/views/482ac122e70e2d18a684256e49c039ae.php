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
            <li class="nav-item mobile-menu d-lg-none mr-auto">
                <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#">
                <!-- <i class="fa-2x fas fa-bars"></i> -->
                <i class="fa-2x fas fa-arrow-alt-circle-right"></i>
                </a>
            </li>
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="<?php echo e(route('index')); ?>">
                    <img class="brand-logo" src="<?php echo e(asset(general()->favicon())); ?>" style="max-height:30px;background: white;border-radius: 50%;" />
                    <h2 class="brand-text">Megh F.</h2>
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
            <li class="nav-item d-none d-md-block dropdown dropdown-user">
               <a class="nav-link" href="javascript:void(0)" data-toggle="dropdown" style="background: #06a5ff;color: white;margin-right: 5px;">Sales</a>
               <div class="dropdown-menu dropdown-menu-left">
                    <a class="dropdown-item" href="<?php echo e(route('admin.posOrdersAction','create')); ?>" style="min-width: 220px"> New POS Sale</a>
                    <a class="dropdown-item" href="<?php echo e(route('admin.posOrders')); ?>" style="min-width: 220px">POS Sales List</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo e(route('admin.ordersAction','create')); ?>" style="min-width: 220px"> New Online Sale</a>
                    <a class="dropdown-item" href="<?php echo e(route('admin.orders')); ?>" style="min-width: 220px">Order List</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo e(route('admin.wholeSalesAction','create')); ?>" style="min-width: 220px"> New Whole Sale</a>
                    <a class="dropdown-item" href="<?php echo e(route('admin.wholeSales')); ?>" style="min-width: 220px">Order List</a>
               </div>
           </li>
            <li class="nav-item d-none d-md-block dropdown dropdown-user">
               <a class="nav-link" href="javascript:void(0)" data-toggle="dropdown" style="background: #ff425c;color: white;margin-right: 5px;">Return</a>
               <div class="dropdown-menu dropdown-menu-left">
                    <a class="dropdown-item" href="<?php echo e(route('admin.ordersReturn')); ?>" style="min-width: 220px">Online Order Return</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo e(route('admin.wholesaleReturn')); ?>" style="min-width: 220px">Wholesale Order Return</a>
               </div>
           </li>
            <li class="nav-item d-none d-md-block dropdown dropdown-user">
               <a class="nav-link" href="javascript:void(0)" data-toggle="dropdown" style="background: #06a5ff;color: white;margin-right: 5px;">Products</a>
               <div class="dropdown-menu dropdown-menu-left">
                    <a class="dropdown-item" href="<?php echo e(route('admin.productsAction','create')); ?>" style="min-width: 220px"> New Product</a>
                    <a class="dropdown-item" href="<?php echo e(route('admin.products')); ?>" style="min-width: 220px">All Products</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo e(route('admin.productsCategories')); ?>" style="min-width: 220px">Categories</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo e(route('admin.productsLabelPrint')); ?>" style="min-width: 220px">Lavel Print</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo e(route('admin.purchases')); ?>" style="min-width: 220px">Stock Manage</a>
               </div>
           </li>
            <li class="nav-item d-none d-md-block dropdown dropdown-user">
               <a class="nav-link" href="javascript:void(0)" data-toggle="dropdown" style="background: #ff864a;color: white;margin-right: 5px;">Expenses</a>
               <div class="dropdown-menu dropdown-menu-left">
                    <a class="dropdown-item" href="<?php echo e(route('admin.expensesList')); ?>" style="min-width: 220px">Expenses List</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo e(route('admin.expensesTypes')); ?>" style="min-width: 220px">Head of Expenses</a>
                    <a class="dropdown-item" href="<?php echo e(route('admin.expensesReports')); ?>" style="min-width: 220px">Expenses Reports</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo e(route('admin.paymentMethods',['manage',87])); ?>" style="min-width: 220px">Cash Withdrawal</a>
               </div>
           </li>
            <li class="nav-item d-none d-md-block dropdown dropdown-user">
               <a class="nav-link" href="javascript:void(0)" data-toggle="dropdown" style="background: #06a5ff;color: white;margin-right: 5px;">Users</a>
               <div class="dropdown-menu dropdown-menu-left">
                    <a class="dropdown-item" href="<?php echo e(route('admin.usersCustomer')); ?>" style="min-width: 220px">Customer User</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo e(route('admin.usersWholesaleCustomer')); ?>" style="min-width: 220px">Wholesale User</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo e(route('admin.usersSupplier')); ?>" style="min-width: 220px">Supplier User</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo e(route('admin.usersAdmin')); ?>" style="min-width: 220px">Admin User</a>
               </div>
           </li>
            <li class="nav-item d-none d-md-block dropdown dropdown-user">
               <a class="nav-link" href="javascript:void(0)" data-toggle="dropdown" style="background: #2dcee3;color: white;margin-right: 5px;">Reports</a>
               <div class="dropdown-menu dropdown-menu-left">
                    <a class="dropdown-item" href="<?php echo e(route('admin.reportsAll','summery')); ?>" style="min-width: 220px">Summery Sales Reports</a>
                    <a class="dropdown-item" href="<?php echo e(route('admin.reportsAll','today-reports')); ?>" style="min-width: 220px">Today Reports</a>
                    <a class="dropdown-item" href="<?php echo e(route('admin.reportsAll','products')); ?>" style="min-width: 220px">Products Reports</a>
                    <a class="dropdown-item" href="<?php echo e(route('admin.reportsAll','history-of-product')); ?>" style="min-width: 220px">Top Product Report</a>
                    <a class="dropdown-item" href="<?php echo e(route('admin.stocksList')); ?>" style="min-width: 220px">Stock Reports</a>
                    <a class="dropdown-item" href="<?php echo e(route('admin.expensesReports')); ?>" style="min-width: 220px">Expenses Reports</a>
                    <a class="dropdown-item" href="<?php echo e(route('admin.posOrdersReports')); ?>" style="min-width: 220px">Sales Reports</a>
               </div>
           </li>
         </ul>
         <ul class="nav navbar-nav float-right">

           <li class="dropdown dropdown-user nav-item">
               <a class="dropdown-toggle nav-link dropdown-user-link" href="javascript:void(0)" data-toggle="dropdown">
               <div class="avatar avatar-online">
                <img src="<?php echo e(asset(Auth::user()->image())); ?>" alt="avatar" /><i></i>
              </div>
               <span class="user-name"><?php echo e(Str::limit(Auth::user()->name,15)); ?></span>
               </a>
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
 <!-- END: Header--><?php /**PATH /media/fehor/AAAAA/Other/meghfash/resources/views/admin/layouts/header.blade.php ENDPATH**/ ?>