 <!-- BEGIN: Main Menu-->
   <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
     <div class="main-menu-content">
       <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
         <li class=" navigation-header"><span>General </span><i class="feather icon-minus" ></i>
         </li>
         <li class=" nav-item {{Request::is('admin/dashboard')? 'active' : ''}}">
          <a href="{{route('admin.dashboard')}}"><i class="fas fa-th-large"></i><span class="menu-title" data-i18n="Email Application">Dashboard</span></a>
         </li>
         
         <li class=" nav-item {{Request::is('admin/my-profile')? 'active' : ''}}">
          <a href="{{route('admin.myProfile')}}"><i class="fas fa-user-check"></i><span class="menu-title" >My Profile</span></a>
         </li>

         <!--Permission Check List Menus Start-->

        @if($roles = Auth::user()->permission)
            
        @if(
         isset(json_decode($roles->permission, true)['posts']['list']) || 
         isset(json_decode($roles->permission, true)['postsOther']['list']) 
        )
        <li class="nav-item {{Request::is('admin/posts*')? 'active' : ''}}">
          <a href="index.html">
          <i class="fas fa-file-alt"></i>
          <span class="menu-title" data-i18n="Dashboard">Posts </span>
          <!-- <span class="badge badge badge-primary badge-pill float-right mr-2">3 </span> -->
          </a>
           <ul class="menu-content">
             @isset(json_decode($roles->permission, true)['posts']['list'])
             <li class="
             @if( Request::is('admin/posts/categories*') || Request::is('admin/posts/tags*') || Request::is('admin/posts/comments*') )
             @else
             {{Request::is('admin/posts*')? 'active' : ''}}
             @endif
             ">
              <a class="menu-item" href="{{route('admin.posts')}}" >All Posts </a>
             </li>
             @endisset

             @isset(json_decode($roles->permission, true)['posts']['add'])
             <li><a class="menu-item" href="{{route('admin.postsAction',['create'])}}" >New Post </a>
             </li>
             @endisset

             @isset(json_decode($roles->permission, true)['postsOther']['category'])
             <li class="{{Request::is('admin/posts/categories*')? 'active' : ''}}">
              <a class="menu-item" href="{{route('admin.postsCategories')}}" >Categories </a>
             </li>
             @endisset

             @isset(json_decode($roles->permission, true)['postsOther']['tags'])
             <li class="{{Request::is('admin/posts/tags*')? 'active' : ''}}">
              <a class="menu-item" href="{{route('admin.postsTags')}}">Tags </a>
             </li>
             @endisset

             @isset(json_decode($roles->permission, true)['postsOther']['comments'])
             <li class="{{Request::is('admin/posts/comments*')? 'active' : ''}}">
              <a class="menu-item" href="{{route('admin.postsCommentsAll')}}">Comments </a>
             </li>
             @endisset
           </ul>
         </li>
         @endif

         
         @if(
         isset(json_decode($roles->permission, true)['ecommerceSetting']['general']) || 
         isset(json_decode($roles->permission, true)['ecommerceSetting']['promotions']) || 
         isset(json_decode($roles->permission, true)['ecommerceSetting']['coupons']) ||
         isset(json_decode($roles->permission, true)['products']['list']) ||  
         isset(json_decode($roles->permission, true)['postsOther']['tag']) ||  
         isset(json_decode($roles->permission, true)['postsOther']['attribute']) ||  
         isset(json_decode($roles->permission, true)['postsOther']['category'])  ||
         isset(json_decode($roles->permission, true)['orders']['list']) 
         )
         
         <li class=" navigation-header"><span>Products Unit </span><i class=" feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="Others"></i>
         
         @if(
         isset(json_decode($roles->permission, true)['ecommerceSetting']['general']) || 
         isset(json_decode($roles->permission, true)['ecommerceSetting']['promotions']) || 
         isset(json_decode($roles->permission, true)['ecommerceSetting']['coupons']) 
         )
         <li class="nav-item {{Request::is('admin/ecommerce*')? 'active' : ''}}">
          <a href="#">
          <i class="fa-solid fa-sliders"></i> <span class="menu-title" >Ecommerce Setting </span></a>
           <ul class="menu-content">
            @isset(json_decode($roles->permission, true)['ecommerceSetting']['general'])
                <li class="{{Request::is('admin/ecommerce/setting*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.ecommerceSetting','general')}}">General Setting</a></li>
            @endisset
            @isset(json_decode($roles->permission, true)['ecommerceSetting']['coupons'])
             <li class="{{Request::is('admin/ecommerce/coupons*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.ecommerceCoupons')}}">Coupons</a></li>
             @endisset
            
            @isset(json_decode($roles->permission, true)['ecommerceSetting']['promotions'])
             <li class="{{Request::is('admin/ecommerce/promotions*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.ecommercePromotions')}}">Promotions</a></li>
             @endisset
           </ul>
         </li>
         @endif

         @if(
         isset(json_decode($roles->permission, true)['products']['list']) ||  
         isset(json_decode($roles->permission, true)['postsOther']['tag']) ||  
         isset(json_decode($roles->permission, true)['postsOther']['attribute']) ||  
         isset(json_decode($roles->permission, true)['postsOther']['category']) 
         )
         <li class=" nav-item"><a href="#"><i class="fas fa-stream"></i><span class="menu-title" >Products </span></a>
           <ul class="menu-content">
             
            @isset(json_decode($roles->permission, true)['products']['list'])
             <li class="
             @if( Request::is('admin/products/categories*') || Request::is('admin/products/lavel-print*') )
             @else
             {{Request::is('admin/products*')? 'active' : ''}}
             @endif
             "><a class="menu-item" href="{{route('admin.products')}}">All Products</a>
             </li>
             @endisset

              @isset(json_decode($roles->permission, true)['postsOther']['category'])
             <li class="{{Request::is('admin/products/categories*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.productsCategories')}}">Categories</a>
             </li>
             @endisset
             @isset(json_decode($roles->permission, true)['postsOther']['tag'])
             <li class="{{Request::is('admin/products/tags*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.productsTags')}}">Tags</a>
             </li>
             @endisset
             @isset(json_decode($roles->permission, true)['postsOther']['attribute'])
             <li class="{{Request::is('admin/products/attributes*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.productsAttributes')}}">Attributes</a>
             </li>
             @endisset
             
             @isset(json_decode($roles->permission, true)['products']['list'])
             <li class="{{Request::is('admin/products/lavel-print*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.productsLabelPrint')}}">Lavel Print</a>
             </li>
            @endisset

           </ul>
         </li>
         @endif
        
        @if(
         isset(json_decode($roles->permission, true)['orders']['list']) 
         )
          <li class="nav-item {{Request::is('admin/orders*')? 'active' : ''}}">
          <a href="#"><i class="fas fa-sitemap"></i><span class="menu-title" >Order Management</span></a>
           <ul class="menu-content">
             <li class="{{Request::is('admin/orders')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.orders')}}"> Order List</a></li>
             <li class="{{Request::is('admin/orders/pending')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.orders','pending')}}"> Pending Order</a></li>
             <li class="{{Request::is('admin/orders/confirmed')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.orders','confirmed')}}"> Confirmed Orders</a></li>
             <li class="{{Request::is('admin/orders/shipped')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.orders','shipped')}}"> Shipped Orders</a></li>
             <li class="{{Request::is('admin/orders/delivered')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.orders','delivered')}}"> Delivered Orders</a></li>
             <li class="{{Request::is('admin/orders/cancelled')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.orders','cancelled')}}"> Cancelled Orders</a></li>
             <li class="{{Request::is('admin/orders/unpaid')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.orders','unpaid')}}"> Unpaid Orders</a></li>
             <li class="{{Request::is('admin/orders/pending-payment')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.orders','pending-payment')}}"> Pending Payment</a></li> 
           </ul>
        </li>
          <li class=" nav-item {{Request::is('admin/order-return*')? 'active' : ''}}"><a href="{{route('admin.ordersReturn')}}"><i class="fas fa-undo"></i><span class="menu-title">Order Return</span></a></li>
          <li class="nav-item {{Request::is('admin/whole-sales*')? 'active' : ''}}">
          <a href="#"><i class="fas fa-sitemap"></i><span class="menu-title" >Wholesale orders </span></a>
           <ul class="menu-content">
             <li class="{{Request::is('admin/whole-sales')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.wholeSales')}}"> Order List</a></li>
             <li class="{{Request::is('admin/whole-sales/pending')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.wholeSales','pending')}}"> Pending Order</a></li>
             <li class="{{Request::is('admin/whole-sales/delivered')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.wholeSales','delivered')}}"> Delivered Orders</a></li>
             <li class="{{Request::is('admin/whole-sales/cancelled')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.wholeSales','cancelled')}}"> Cancelled Orders</a></li>
             <li class="{{Request::is('admin/whole-sales/unpaid')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.wholeSales','unpaid')}}"> Unpaid Orders</a></li>
           </ul>
        </li>
        
        <li class=" nav-item {{Request::is('admin/wholesale-return*')? 'active' : ''}}"><a href="{{route('admin.wholesaleReturn')}}"><i class="fas fa-undo"></i><span class="menu-title">Wholesale Return</span></a></li>
        @endif
        
        @endif
        
        
        
        
        @if(
         isset(json_decode($roles->permission, true)['posUrders']['list']) ||
         isset(json_decode($roles->permission, true)['expenses']['list']) 
         )
        <li class=" navigation-header"><span style="color: #009688;font-weight: bold;">POS Unit </span><i class=" feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="Others"></i>
        </li>
        @if(
         isset(json_decode($roles->permission, true)['posUrders']['list']) 
         )
        <li class="nav-item {{Request::is('admin/pos-sales*')? 'active' : ''}}">
          <a href="#"><i class="fas fa-desktop"></i><span class="menu-title" >POS Management</span></a>
           <ul class="menu-content">
             <li 
             
             @if(Request::is('admin/pos-sales/reports'))
             
             @else
             class="{{Request::is('admin/pos-sales')? 'active' : ''}}"
             @endif
             ><a class="menu-item" href="{{route('admin.posOrders')}}"> POS Sales</a></li>
             <li class="{{Request::is('admin/orders/pending')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.posOrdersAction','create')}}"> New Order</a></li>
             
             @isset(json_decode($roles->permission, true)['posUrders']['salesreport'])
             <li class="{{Request::is('admin/pos-sales/reports')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.posOrdersReports')}}"> Sales Reports</a></li>
             @endisset
           </ul>
        </li>
        @endif
        
        @if(
         isset(json_decode($roles->permission, true)['expenses']['report']) ||
         isset(json_decode($roles->permission, true)['expenses']['list']) 
         )
        <li class="nav-item {{Request::is('admin/expenses*')? 'active' : ''}}">
          <a href="#"><i class="fas fa-list"></i><span class="menu-title" >Expenses</span></a>
           <ul class="menu-content">
               @isset(json_decode($roles->permission, true)['expenses']['list'])
             <li 
             
             @if(Request::is('admin/expenses/types'))
             
             @else
             class="{{Request::is('admin/expenses')? 'active' : ''}}"
             @endif
             ><a class="menu-item" href="{{route('admin.expensesList')}}"> Expenses List</a></li>
             @endisset
             
             
             @isset(json_decode($roles->permission, true)['expenses']['type'])
             <li class="{{Request::is('admin/expenses/types*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.expensesTypes')}}"> Head of Expenses</a></li>
             @endisset
             
             @isset(json_decode($roles->permission, true)['expenses']['report'])
             <li class="{{Request::is('admin/expenses/reports')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.expensesReports')}}"> Expenses Reports</a></li>
             @endisset
           </ul>
        </li>
        @endif
        @endif
        
        
         @if(
         isset(json_decode($roles->permission, true)['suppliers']['list']) ||
         isset(json_decode($roles->permission, true)['stockManage']['list']) ||
         isset(json_decode($roles->permission, true)['stockManage']['report']) ||
         isset(json_decode($roles->permission, true)['paymentMethod']['list']) ||
         isset(json_decode($roles->permission, true)['warehouse']['list']) 
         )
        
        
        <li class=" navigation-header"><span style="color: #009688;font-weight: bold;">Inventory Unit </span><i class=" feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="Others"></i></li>
        
        <li class="nav-item {{Request::is('admin/reports*')? 'active' : ''}}">
          <a href="#"><i class="fa fa-home"></i><span class="menu-title" > Inventory Management</span></a>
           <ul class="menu-content">
             @isset(json_decode($roles->permission, true)['suppliers']['list'])
             <li class="{{Request::is('admin/suppliers*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.usersSupplier')}}"> Suppliers</a></li>
             @endisset
             
             @isset(json_decode($roles->permission, true)['warehouse']['list'])
             <li class="{{Request::is('admin/warehouses*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.productsWarehouses')}}"> Store/Branch</a></li>
             <li class="{{Request::is('admin/stock-transfer*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.stockTransfer')}}"> Stock Transfer</a></li>
             <li class="{{Request::is('admin/stock-minus*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.stockMinus')}}"> Stock Minus</a></li>
             @endisset
             
             @isset(json_decode($roles->permission, true)['stockManage']['list'])
             
             <li class="{{Request::is('admin/stock-management*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.purchases')}}"> Stock Management</a></li>
            @endisset
            
            @isset(json_decode($roles->permission, true)['stockManage']['report'])
             <li class="{{Request::is('admin/stock-report*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.stocksList')}}"> Stock Reports</a></li>
            @endisset
            
            @isset(json_decode($roles->permission, true)['paymentMethod']['list'])
             <li class="{{Request::is('admin/payment-method*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.paymentMethods')}}"> Payment Methods</a></li>
            @endisset
            
           </ul>
         </li>
        
        {{--
        @isset(json_decode($roles->permission, true)['suppliers']['list'])
        <li class=" nav-item {{Request::is('admin/suppliers*')? 'active' : ''}}"><a href="{{route('admin.usersSupplier')}}"><i class="fas fa-user"></i><span class="menu-title">Suppliers</span></a></li>
         @endisset
        
        @isset(json_decode($roles->permission, true)['warehouse']['list'])
        <li class=" nav-item {{Request::is('admin/warehouses*')? 'active' : ''}}"><a href="{{route('admin.productsWarehouses')}}"><i class="fas fa-home"></i><span class="menu-title">Store/Branch</span></a></li>
        <li class=" nav-item {{Request::is('admin/stock-transfer*')? 'active' : ''}}"><a href="{{route('admin.stockTransfer')}}"><i class="fas fa-truck"></i><span class="menu-title">Stock Transfer</span></a></li>
         @endisset
        
        @isset(json_decode($roles->permission, true)['stockManage']['list'])
        <li class=" nav-item {{Request::is('admin/stock-management*')? 'active' : ''}}"><a href="{{route('admin.purchases')}}"><i class="fas fa-truck"></i><span class="menu-title">Stock Management</span></a></li>
        @endisset
        
        @isset(json_decode($roles->permission, true)['stockManage']['report'])
        <li class=" nav-item {{Request::is('admin/stock-report*')? 'active' : ''}}"><a href="{{route('admin.stocksList')}}"><i class="fas fa-chart-line"></i><span class="menu-title">Stock Reports</span></a></li>
        @endisset
        
        @isset(json_decode($roles->permission, true)['paymentMethod']['list'])
        <li class=" nav-item {{Request::is('admin/payment-method*')? 'active' : ''}}"><a href="{{route('admin.paymentMethods')}}"><i class="fas fa-money"></i><span class="menu-title">Payment Methods</span></a></li>
        @endisset
         
         --}}
         
         
         @endif
         
         
        @if(
         isset(json_decode($roles->permission, true)['reports']['summery']) ||
         isset(json_decode($roles->permission, true)['reports']['products']) ||
         isset(json_decode($roles->permission, true)['reports']['customer']) ||
         isset(json_decode($roles->permission, true)['reports']['orders']) 
         )
        <li class=" navigation-header"><span style="color: #009688;font-weight: bold;">Report Unit </span><i class=" feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="Others"></i>
         </li>
         <li class="nav-item {{Request::is('admin/reports*')? 'active' : ''}}">
          <a href="#"><i class="fas fa-chart-line"></i><span class="menu-title" > Reports Management</span></a>
           <ul class="menu-content">
             
             @isset(json_decode($roles->permission, true)['reports']['summery'])
             <li class="{{Request::is('admin/reports/summery*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.reportsAll','summery')}}"> Summery Sales Reports</a></li>
             <li class="{{Request::is('admin/reports/today-reports*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.reportsAll','today-reports')}}"> Today Reports</a></li>
             @endisset
             
             @isset(json_decode($roles->permission, true)['reports']['products'])
             <li class="{{Request::is('admin/reports/products*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.reportsAll','products')}}"> Products Reports</a></li>
             
             <li class="{{Request::is('admin/reports/history-of-product*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.reportsAll','history-of-product')}}"> Top Product Report</a></li>
             @endisset
             
             @isset(json_decode($roles->permission, true)['reports']['products'])
             <li class="{{Request::is('admin/reports/store-branch*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.reportsAll','store-branch')}}"> Store/Branch Reports</a></li>
             @endisset
             
             @isset(json_decode($roles->permission, true)['reports']['customer'])
             <li class="{{Request::is('admin/reports/customer-reports*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.reportsAll','customer-reports')}}"> Customer Reports</a></li>
             @endisset
             
             @isset(json_decode($roles->permission, true)['reports']['orders'])
             <li class="{{Request::is('admin/reports/order-reports*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.reportsAll','order-reports')}}"> Order Reports</a></li>
             @endisset
             
           </ul>
         </li>
         @endif
         
         @if(
        isset(json_decode($roles->permission, true)['pages']['list']) ||  
        isset(json_decode($roles->permission, true)['medies']['list']) ||  
        isset(json_decode($roles->permission, true)['clients']['list']) ||  
         isset(json_decode($roles->permission, true)['brands']['list']) ||
         isset(json_decode($roles->permission, true)['sliders']['list']) ||
         isset(json_decode($roles->permission, true)['galleries']['list']) ||
         isset(json_decode($roles->permission, true)['menus']['list']) ||
         isset(json_decode($roles->permission, true)['themeSetting']['list'])
        )
        
         <li class=" navigation-header"><span style="color: #009688;font-weight: bold;">General Unit </span><i class=" feather icon-minus" ></i>
         </li>
         
         <li class="nav-item {{Request::is('admin/clients*')? 'active' : ''}}">
          <a href="#"><i class="fas fa-bars"></i><span class="menu-title" >General Unit </span></a>
           <ul class="menu-content">
               
             @isset(json_decode($roles->permission, true)['pages']['list'])
             <li class="{{Request::is('admin/pages*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.pages')}}"> Pages</a></li>
             @endisset
             
             @isset(json_decode($roles->permission, true)['medies']['list'])
             <li class="{{Request::is('admin/medies*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.medies')}}"> Medias Library</a></li>
             @endisset
             
             @isset(json_decode($roles->permission, true)['clients']['list'])
             <li class="{{Request::is('admin/clients*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.clients')}}"> Clients</a></li>
             @endisset
             
             @isset(json_decode($roles->permission, true)['brands']['list'])
             <li class="{{Request::is('admin/brands*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.brands')}}"> Brands</a></li>
             @endisset
             
             @isset(json_decode($roles->permission, true)['sliders']['list'])
             <li class="{{Request::is('admin/sliders*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.sliders')}}"> Sliders</a></li>
             @endisset
             
             @isset(json_decode($roles->permission, true)['galleries']['list'])
             <li class="{{Request::is('admin/galleries*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.galleries')}}"> Galleries</a></li>
             @endisset
             
             @isset(json_decode($roles->permission, true)['menus']['list'])
             <li class="{{Request::is('admin/menus*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.menus')}}"> Menus Setting</a></li>
             @endisset
             
             @isset(json_decode($roles->permission, true)['themeSetting']['list'])
             <li class="{{Request::is('admin/theme-setting*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.themeSetting')}}"> Theme Setting</a></li>
             @endisset
           </ul>
        </li>
         
        {{--
        
        
        @isset(json_decode($roles->permission, true)['pages']['list'])
          <li class="nav-item {{Request::is('admin/pages*')? 'active' : ''}}"><a href="{{route('admin.pages')}}"><i class="fas fa-copy"></i><span class="menu-title">Pages</span></a>
         </li>
         @endisset

         @isset(json_decode($roles->permission, true)['medies']['list'])
         <li class="nav-item {{Request::is('admin/medies*')? 'active' : ''}}"><a href="{{route('admin.medies')}}"><i class="fas fa-images"></i><span class="menu-title">Medias Library</span></a>
         </li>
         @endisset
        
        
         @isset(json_decode($roles->permission, true)['clients']['list'])
         <li class=" nav-item {{Request::is('admin/clients*')? 'active' : ''}}"><a href="{{route('admin.clients')}}"><i class="fas fa-user-tie"></i><span class="menu-title">Clients</span></a>
         </li>
         @endisset

         @isset(json_decode($roles->permission, true)['brands']['list'])
         <li class=" nav-item {{Request::is('admin/brands*')? 'active' : ''}}"><a href="{{route('admin.brands')}}"><i class="fas fa-chess-rook"></i><span class="menu-title">Brands</span></a>
         </li>
         @endisset

         @isset(json_decode($roles->permission, true)['sliders']['list'])
         <li class=" nav-item {{Request::is('admin/sliders*')? 'active' : ''}}"><a href="{{route('admin.sliders')}}"><i class="fas fa-chalkboard"></i><span class="menu-title">Sliders</span></a>
         </li>
         @endisset

         @isset(json_decode($roles->permission, true)['galleries']['list'])
         <li class=" nav-item {{Request::is('admin/galleries*')? 'active' : ''}}"><a href="{{route('admin.galleries')}}"><i class="fas fa-images"></i><span class="menu-title">Galleries</span></a>
         </li>
         @endisset

         @isset(json_decode($roles->permission, true)['menus']['list'])
         <li class=" nav-item {{Request::is('admin/menus*')? 'active' : ''}}"><a href="{{route('admin.menus')}}"><i class="fas fa-bars"></i><span class="menu-title">Menus Setting</span></a>
         </li>
         @endisset

         @isset(json_decode($roles->permission, true)['themeSetting']['list'])
         <li class=" nav-item {{Request::is('admin/theme-setting*')? 'active' : ''}}"><a href="{{route('admin.themeSetting')}}"><i class="fa-solid fa-sliders"></i><span class="menu-title">Theme Setting</span></a>
         </li>
         @endisset
            
        --}}
        
        @endif

        @if(
        isset(json_decode($roles->permission, true)['adminUsers']['list']) ||  
         isset(json_decode($roles->permission, true)['adminRoles']['list']) ||
         isset(json_decode($roles->permission, true)['users']['list']) ||
         isset(json_decode($roles->permission, true)['subscribe']['list']) 
        )

         <li class=" navigation-header"><span style="color: #00bcd4;font-weight: bold;">Users Management </span><i class="feather icon-droplet feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="UI"></i>
         </li>
         
         <li class="nav-item {{Request::is('admin/reports*')? 'active' : ''}}">
          <a href="#"><i class="fa fa-user"></i><span class="menu-title" > Users Management</span></a>
           <ul class="menu-content">
             @isset(json_decode($roles->permission, true)['adminUsers']['list'])
             <li class="{{Request::is('admin/users/admin*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.usersAdmin')}}"> Administrator Users</a></li>
             @endisset
             
             @isset(json_decode($roles->permission, true)['adminRoles']['list'])
             <li class="{{Request::is('admin/users/role*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.userRoles')}}"> Roles Users</a></li>
             @endisset
             
             @isset(json_decode($roles->permission, true)['users']['list'])
             
             <li class="{{Request::is('admin/users/customer*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.usersCustomer')}}"> Customer Users</a></li>

             <li class="{{Request::is('admin/users/wholesale-customer*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.usersWholesaleCustomer')}}"> Wholesale Customer</a></li>
             @endisset
           </ul>
         </li>
         
         
         {{--
         @isset(json_decode($roles->permission, true)['adminUsers']['list'])
         <li class=" nav-item {{Request::is('admin/users/admin*')? 'active' : ''}}">
          <a href="{{route('admin.usersAdmin')}}"><i class="fas fa-user"></i><span class="menu-title" >Administrator Users </span></a>
         </li>
         @endisset

         @isset(json_decode($roles->permission, true)['adminRoles']['list'])
         <li class=" nav-item {{Request::is('admin/users/role*')? 'active' : ''}}">
          <a href="{{route('admin.userRoles')}}"><i class="fas fa-ruler-combined"></i><span class="menu-title" >Roles Users </span></a>
         </li>
         @endisset

         @isset(json_decode($roles->permission, true)['users']['list'])
         <li class=" nav-item {{Request::is('admin/users/customer*')? 'active' : ''}}">
          <a href="{{route('admin.usersCustomer')}}"><i class="fas fa-users"></i><span class="menu-title" >Customer Users </span></a>
         </li>
         
         <li class=" nav-item {{Request::is('admin/users/wholesale-customer*')? 'active' : ''}}">
          <a href="{{route('admin.usersWholesaleCustomer')}}"><i class="fas fa-users"></i><span class="menu-title" >Wholesale Customer </span></a>
         </li>
         @endisset


         @isset(json_decode($roles->permission, true)['subscribe']['list'])
         <li class=" nav-item {{Request::is('admin/subscribes*')? 'active' : ''}}">
          <a href="{{route('admin.subscribes')}}"><i class="fas fa-user-tag"></i><span class="menu-title" >Subscribe Users </span></a>
         </li>
         @endisset
         
         --}}

         @endif
         
        @if(
         isset(json_decode($roles->permission, true)['appsSetting']['general']) ||  
         isset(json_decode($roles->permission, true)['appsSetting']['mail']) ||
         isset(json_decode($roles->permission, true)['appsSetting']['sms']) ||
         isset(json_decode($roles->permission, true)['appsSetting']['social']) 
         )
         <li class=" navigation-header"><span style="color: #000000;font-weight: bold;">Apps Setting </span><i class=" feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="Others"></i>
         </li>
         @endif
         
         
         <li class="nav-item {{Request::is('admin/reports*')? 'active' : ''}}">
          <a href="#"><i class="fa fa-cog"></i><span class="menu-title" > Apps Setting</span></a>
           <ul class="menu-content">
             @isset(json_decode($roles->permission, true)['appsSetting']['general'])
             <li class="{{Request::is('admin/setting/general*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.setting','general')}}"> General Setting</a></li>
             @endisset
             
             @isset(json_decode($roles->permission, true)['appsSetting']['mail'])
             <li class="{{Request::is('admin/setting/mail*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.setting','mail')}}"> Mail Setting</a></li>
             @endisset
             
             @isset(json_decode($roles->permission, true)['appsSetting']['sms'])
             <li class="{{Request::is('admin/setting/sms*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.setting','sms')}}"> SMS Setting</a></li>
             @endisset
             
             @isset(json_decode($roles->permission, true)['appsSetting']['social'])
             <li class="{{Request::is('admin/setting/social*')? 'active' : ''}}"><a class="menu-item" href="{{route('admin.setting','social')}}"> Social Setting</a></li>
             @endisset
           </ul>
         </li>
         
         {{--
         @isset(json_decode($roles->permission, true)['appsSetting']['general'])
         <li class="nav-item {{Request::is('admin/setting/general*')? 'active' : ''}}">
            <a href="{{route('admin.setting','general')}}">
              <i class="fa fa-cog"></i>
              <span class="menu-title" >General Setting</span>
            </a>
         </li>
         @endisset

         @isset(json_decode($roles->permission, true)['appsSetting']['mail'])
         <li class=" nav-item {{Request::is('admin/setting/mail*')? 'active' : ''}}">
            <a href="{{route('admin.setting','mail')}}">
              <i class="fas fa-envelope"></i>
              <span class="menu-title" >Mail Setting</span>
            </a>
         </li>
         @endisset

         @isset(json_decode($roles->permission, true)['appsSetting']['sms'])
          <li class=" nav-item {{Request::is('admin/setting/sms*')? 'active' : ''}}">
            <a href="{{route('admin.setting','sms')}}">
              <i class="fas fa-comments"></i>
              <span class="menu-title">SMS Setting</span>
            </a>
         </li>
         @endisset

         @isset(json_decode($roles->permission, true)['appsSetting']['social'])
          <li class=" nav-item {{Request::is('admin/setting/social*')? 'active' : ''}}">
            <a href="{{route('admin.setting','social')}}">
              <i class="fab fa-codepen"></i>
              <span class="menu-title">Social Setting</span>
            </a>
         </li>
         @endisset
         --}}
         
         @endif
    
         <!--Permission Check List Menus End-->

       </ul>
       <div style="padding: 15px;text-align: center;border: 1px solid #e5e7ec;font-size: 20px;">
         <p>Support Center<br>Contact Us<br>Call: 01619-991807</p>
       </div>
     </div>
   </div>
   <!-- END: Main Menu-->