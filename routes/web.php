<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Welcome\WelcomeController;
use App\Http\Controllers\Welcome\CartController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\MenusController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\EcommerceController;
use Inertia\Inertia;


Route::fallback(function () {
    return Inertia::render('Error', [
        'status' => 404,
        'message' => 'Page not found.',
    ]);
});

Route::get('/', [WelcomeController::class, 'index'])->name('index');
Route::get('/image-view', [WelcomeController::class, 'imageView'])->name('imageView');
Route::get('/image/{template?}/{image?}', [WelcomeController::class, 'imageView2'])->name('imageView2');
Route::get('/sitemap.xml', [WelcomeController::class, 'siteMapXml'])->name('siteMapXml');
Route::get('/product.xml', [WelcomeController::class, 'productFeedXml'])->name('productFeedXml');
Route::get('/search', [WelcomeController::class, 'search'])->name('search');
Route::get('/order-tracking', [WelcomeController::class, 'orderTracking'])->name('orderTracking');
Route::post('/contact-mail', [WelcomeController::class, 'contactMail'])->name('contactMail');
Route::post('/enquery-send/{slug}', [WelcomeController::class, 'inquerySend'])->name('inquerySend');
Route::post('/subscribe', [WelcomeController::class, 'subscribe'])->name('subscribe');

Route::any('/courier-{type}-callback', [WelcomeController::class, 'courierCallBack'])->name('courierCallBack');

Route::get('/geo/filter/{id}', [WelcomeController::class, 'geo_filter'])->name('geo_filter');
Route::get('/payments/filter/{id}', [WelcomeController::class, 'payment_filter'])->name('payment_filter');

Route::get('/product/category/{slug}', [WelcomeController::class, 'productCategory'])->name('productCategory');
Route::get('/product/filter/{slug}', [WelcomeController::class, 'productFilterCategory'])->name('productFilterCategory');
Route::get('/product/brand/{slug}', [WelcomeController::class, 'productBrand'])->name('productBrand');
Route::get('/product/{slug}', [WelcomeController::class, 'productView'])->name('productView');

Route::get('/promotion/{slug}', [WelcomeController::class, 'promotion'])->name('promotion');
Route::get('/offer-product', [WelcomeController::class, 'offerProduct'])->name('offerProduct');

Route::get('/blog/category/{slug}', [WelcomeController::class, 'blogCategory'])->name('blogCategory');
Route::get('/blog/author/{id}/{slug}', [WelcomeController::class, 'blogAuthor'])->name('blogAuthor');
Route::get('/blog/tag/{slug}', [WelcomeController::class, 'blogTag'])->name('blogTag');
Route::get('/blog/search', [WelcomeController::class, 'blogSearch'])->name('blogSearch');
Route::get('/blog/{slug}', [WelcomeController::class, 'blogView'])->name('blogView');

Route::post('/blog-comments/{id}', [WelcomeController::class, 'blogComments'])->name('blogComments');

//Auth Route Start
Route::any('/login', [AuthController::class, 'login'])->name('login');
Route::any('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
Route::any('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('resetPassword');
Route::post('/reset-password-check', [AuthController::class, 'resetPasswordCheck'])->name('resetPasswordCheck');
Route::any('/register', [AuthController::class, 'register'])->name('register');
Route::post('/log-out', [AuthController::class, 'logout'])->name('logout');


Route::get('/login/{provider}', [AuthController::class, 'redirectToProvider'])->name('socialLogin');
Route::get('/login/{provider}/callback', [AuthController::class, 'handleProviderCallback'])->name('socialLoginCallback');


Route::any('add-to-cart/{id?}', [CartController::class, 'addToCart'])->name('addToCart');
Route::get('change-to-cart/{product}/{type}', [CartController::class, 'changeToCart'])->name('changeToCart');
Route::get('select-delivery-area/{id}', [CartController::class, 'selectDeliveryArea'])->name('selectDeliveryArea');
Route::get('cart-count', [CartController::class, 'cartCount'])->name('cartCount');
Route::get('carts', [CartController::class, 'carts'])->name('carts');
Route::any('checkout', [CartController::class, 'checkout'])->name('checkout');
Route::get('order-status/{id}', [CartController::class, 'orderStatus'])->name('orderStatus');
Route::any('ssl-payment/{action}', [CartController::class, 'sslPayment'])->name('sslPayment');
Route::get('order-payment/{id}', [CartController::class, 'orderPayment'])->name('orderPayment')->middleware('auth');
Route::get('order-payment-send/{type}/{id}', [CartController::class, 'orderPaymentSend'])->name('orderPaymentSend')->middleware('auth');;
Route::any('OrderTrack', [CartController::class, 'OrderTrack'])->name('OrderTrack');
Route::get('order-invoice/{invoice}', [CartController::class, 'invoiceView'])->name('invoiceView');
Route::get('wishlist-compare/update/{id}/{type}', [CartController::class, 'wishlistCompareUpdate'])->name('wishlistCompareUpdate');
Route::get('my-wishlist', [CartController::class, 'myWishlist'])->name('myWishlist');
Route::get('my-compare', [CartController::class, 'myCompare'])->name('myCompare');
Route::post('my-coupon-apply', [CartController::class, 'couponApply'])->name('couponApply');

Route::get('/{slug}', [WelcomeController::class, 'pageView'])->name('pageView');

//Customer Route Group Start

Route::group(['prefix' => 'customer', 'as' => 'customer.', 'middleware' => ['auth', 'role:customer']], function () {

    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');

    Route::any('/profile', [CustomerController::class, 'profile'])->name('profile');
    Route::any('/change-password', [CustomerController::class, 'changePassword'])->name('changePassword');

    Route::get('/orders', [CustomerController::class, 'myOrders'])->name('myOrders');
    Route::get('/my-reviews', [CustomerController::class, 'myReviews'])->name('myReviews');
    Route::any('/my-reviews/review/{id}', [CustomerController::class, 'orderReview'])->name('orderReview');
});


// Admin Route Group Start

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'role:admin', 'permission']], function () {


    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::any('/my-profile', [AdminController::class, 'myProfile'])->name('myProfile');

    // Medias Library Route
    Route::get('/medias', [AdminController::class, 'medies'])->name('medies');
    Route::post('/medias/create', [AdminController::class, 'mediesCreate'])->name('mediesCreate');
    Route::match(['get', 'post'], '/medias/edit/{id}', [AdminController::class, 'mediesEdit'])->name('mediesEdit');
    Route::get('/medies/delete/{id}', [AdminController::class, 'mediesDelete'])->name('mediesDelete');
    // Medias Library Route End

    //Page Management
    Route::get('/pages', [AdminController::class, 'pages'])->name('pages');
    Route::any('/pages/{action}/{id?}', [AdminController::class, 'pagesAction'])->name('pagesAction');
    //Page Management End

    // Posts Comments Route End
    Route::get('/posts/comments/all', [PostsController::class, 'postsCommentsAll'])->name('postsCommentsAll');
    Route::get('/posts/comments/post/{id}', [PostsController::class, 'postsComments'])->name('postsComments');
    Route::any('/posts/comments/{action}/{id}', [PostsController::class, 'postsCommentsAction'])->name('postsCommentsAction');
    // Posts Comments Route End

    // Posts Categories Route
    Route::get('/posts/categories', [PostsController::class, 'postsCategories'])->name('postsCategories');
    Route::any('/posts/categories/{action}/{id?}', [PostsController::class, 'postsCategoriesAction'])->name('postsCategoriesAction');
    // Posts Categories Route End

    // Posts Tags Route
    Route::get('/posts/tags', [PostsController::class, 'postsTags'])->name('postsTags');
    Route::any('/posts/tags/{action}/{id?}', [PostsController::class, 'postsTagsAction'])->name('postsTagsAction');
    // Posts Tags Route End

    // Posts Route
    Route::get('/posts', [PostsController::class, 'posts'])->name('posts');
    Route::any('/posts/{action}/{id?}', [PostsController::class, 'postsAction'])->name('postsAction');
    // Posts Route End

    //Ecommerce Mangement Start

    // Products Categories Route
    Route::get('/products/categories', [EcommerceController::class, 'productsCategories'])->name('productsCategories');
    Route::any('/products/categories/{action}/{id?}', [EcommerceController::class, 'productsCategoriesAction'])->name('productsCategoriesAction');
    // Products Categories Route End

    // Products Tags Route
    Route::get('/products/tags', [EcommerceController::class, 'productsTags'])->name('productsTags');
    Route::any('/products/tags/{action}/{id?}', [EcommerceController::class, 'productsTagsAction'])->name('productsTagsAction');
    // Products Tags Route End

    // Products Attributes Route
    Route::get('/products/attributes', [EcommerceController::class, 'productsAttributes'])->name('productsAttributes');
    Route::any('/products/attributes/{action}/{id?}', [EcommerceController::class, 'productsAttributesAction'])->name('productsAttributesAction');
    Route::any('/products/attributes/item/{action}/{id}', [EcommerceController::class, 'productsAttributesItemAction'])->name('productsAttributesItemAction');
    // Products Attributes Route End


    Route::get('/products/lavel-print', [EcommerceController::class, 'productsLabelPrint'])->name('productsLabelPrint');

    //Products Management
    Route::get('/products', [EcommerceController::class, 'products'])->name('products');
    Route::any('/products/{action}/{id?}', [EcommerceController::class, 'productsAction'])->name('productsAction');
    Route::any('/products/update/ajax/{column}/{id}', [EcommerceController::class, 'productsUpdateAjax'])->name('productsUpdateAjax');
    //Products Management End

    // Ecommerce Setting Route
    Route::get('/ecommerce/coupons', [EcommerceController::class, 'ecommerceCoupons'])->name('ecommerceCoupons');
    Route::any('/ecommerce/coupons/{action}/{id?}', [EcommerceController::class, 'ecommerceCouponsAction'])->name('ecommerceCouponsAction');

    Route::get('/ecommerce/promotions', [EcommerceController::class, 'ecommercePromotions'])->name('ecommercePromotions');
    Route::any('/ecommerce/promotions/{action}/{id?}', [EcommerceController::class, 'ecommercePromotionsAction'])->name('ecommercePromotionsAction');

    Route::any('/ecommerce/setting/{action}/{id?}', [EcommerceController::class, 'ecommerceSetting'])->name('ecommerceSetting');
    // Ecommerce Setting Route End

    // Order Management Route End
    Route::get('/invoice/{id}', [OrdersController::class, 'invoice'])->name('invoice');
    Route::get('/orders/{status?}', [OrdersController::class, 'orders'])->name('orders');
    Route::any('/orders-manage/{action}/{id?}', [OrdersController::class, 'ordersAction'])->name('ordersAction');
    // Order Management Route End

    Route::get('/order-return', [OrdersController::class, 'ordersReturn'])->name('ordersReturn');
    Route::any('/order-return/{action}/{id?}', [OrdersController::class, 'ordersReturnAction'])->name('ordersReturnAction');

    Route::get('/whole-sales/{status?}', [OrdersController::class, 'wholeSales'])->name('wholeSales');
    Route::any('/whole-sales-manage/{action}/{id?}', [OrdersController::class, 'wholeSalesAction'])->name('wholeSalesAction');

    Route::get('/wholesale-return', [OrdersController::class, 'wholesaleReturn'])->name('wholesaleReturn');
    Route::any('/wholesale-return/{action}/{id?}', [OrdersController::class, 'wholesaleReturnAction'])->name('wholesaleReturnAction');


    //POS Order Management
    Route::any('/pos-sales/today', [OrdersController::class, 'posOrdersToday'])->name('posOrdersToday');
    Route::get('/pos-sales/reports', [OrdersController::class, 'posOrdersReports'])->name('posOrdersReports');
    Route::get('/pos-sales', [OrdersController::class, 'posOrders'])->name('posOrders');
    Route::any('/pos-sales/{action}/{id?}', [OrdersController::class, 'posOrdersAction'])->name('posOrdersAction');
    //POS Order Management End

    Route::get('/stock-transfer', [OrdersController::class, 'stockTransfer'])->name('stockTransfer');
    Route::any('/stock-transfer/{action}/{id?}', [OrdersController::class, 'stockTransferAction'])->name('stockTransferAction');

    Route::get('/stock-minus', [OrdersController::class, 'stockMinus'])->name('stockMinus');
    Route::any('/stock-minus/{action}/{id?}', [OrdersController::class, 'stockMinusAction'])->name('stockMinusAction');

    Route::get('/stock-management', [OrdersController::class, 'purchases'])->name('purchases');
    Route::any('/stock-management/{action}/{id?}', [OrdersController::class, 'purchasesAction'])->name('purchasesAction');

    Route::get('/stock-report', [OrdersController::class, 'stocksList'])->name('stocksList');

    // Payment Method Start
    Route::any('/payment-method/{action?}/{id?}', [AdminController::class, 'paymentMethods'])->name('paymentMethods');

    // Warehouses Start
    Route::get('/warehouses', [AdminController::class, 'productsWarehouses'])->name('productsWarehouses');
    Route::any('/warehouses/{action}/{id?}', [AdminController::class, 'productsWarehousesAction'])->name('productsWarehousesAction');

    //Supplier User Management
    Route::get('suppliers/', [AdminController::class, 'usersSupplier'])->name('usersSupplier');
    Route::any('suppliers/{action}/{id?}', [AdminController::class, 'usersSupplierAction'])->name('usersSupplierAction');
    //Supplier User Management End


    // Expenses Start
    Route::get('/expenses/reports/', [AdminController::class, 'expensesReports'])->name('expensesReports');

    Route::get('/expenses/types/', [AdminController::class, 'expensesTypes'])->name('expensesTypes');
    Route::any('/expenses/types/{action}/{id?}', [AdminController::class, 'expensesTypesAction'])->name('expensesTypesAction');

    Route::get('/expenses/', [AdminController::class, 'expensesList'])->name('expensesList');
    Route::any('/expenses/{action}/{id?}', [AdminController::class, 'expensesListAction'])->name('expensesListAction');
    // Expenses Start

    // Reports Route Start
    Route::get('/reports/{type}', [AdminController::class, 'reportsAll'])->name('reportsAll');
    // Reports Route End

    // Clients Route
    Route::get('/clients', [AdminController::class, 'clients'])->name('clients');
    Route::any('/clients/{action}/{id?}', [AdminController::class, 'clientsAction'])->name('clientsAction');
    // Clients Route End

    // Brands Route
    Route::get('/brands', [AdminController::class, 'brands'])->name('brands');
    Route::any('/brands/{action}/{id?}', [AdminController::class, 'brandsAction'])->name('brandsAction');
    // Brands Route End

    // Slider Route
    Route::get('/sliders', [AdminController::class, 'sliders'])->name('sliders');
    Route::any('/sliders/{action}/{id?}', [AdminController::class, 'slidersAction'])->name('slidersAction');
    Route::any('/sliders/slide/{action}/{id}', [AdminController::class, 'slideAction'])->name('slideAction');
    // Slider Route End

    // Gallery Route
    Route::get('/galleries', [AdminController::class, 'galleries'])->name('galleries');
    Route::any('/galleries/{action}/{id?}', [AdminController::class, 'galleriesAction'])->name('galleriesAction');
    // Gallery Route End


    // Theme Route
    Route::get('/theme-setting', [AdminController::class, 'themeSetting'])->name('themeSetting');
    Route::any('/theme-setting/{action}/{id?}', [AdminController::class, 'themeSettingAction'])->name('themeSettingAction');
    // Theme Route End

    // Menus Route
    Route::get('/menus', [MenusController::class, 'menus'])->name('menus');
    Route::any('/menus/config/{action}/{id?}', [MenusController::class, 'menusAction'])->name('menusAction');
    Route::post('/menus/items/post/{id}', [MenusController::class, 'menusItemsPost'])->name('menusItemsPost');
    Route::any('/menus/items/{action}/{id}', [MenusController::class, 'menusItemsAction'])->name('menusItemsAction');
    // Menus Route End


    //User Management
    Route::get('/users/admin/', [AdminController::class, 'usersAdmin'])->name('usersAdmin');
    Route::any('/users/admin/{action}/{id?}', [AdminController::class, 'usersAdminAction'])->name('usersAdminAction');

    Route::get('/users/customer/', [AdminController::class, 'usersCustomer'])->name('usersCustomer');
    Route::any('/users/customer/{action}/{id?}', [AdminController::class, 'usersCustomerAction'])->name('usersCustomerAction');

    Route::get('/users/wholesale-customer/', [AdminController::class, 'usersWholesaleCustomer'])->name('usersWholesaleCustomer');
    Route::any('/users/wholesale-customer/{action}/{id?}', [AdminController::class, 'usersWholesaleCustomerAction'])->name('usersWholesaleCustomerAction');

    Route::get('/users/roles', [AdminController::class, 'userRoles'])->name('userRoles');
    Route::any('/users/roles/{action}/{id?}', [AdminController::class, 'userRoleAction'])->name('userRoleAction');

    Route::get('/subscribes', [AdminController::class, 'subscribes'])->name('subscribes');

    // Apps Setting
    Route::get('/setting/{type}', [AdminController::class, 'setting'])->name('setting');
    Route::post('/setting/{type}/update', [AdminController::class, 'settingUpdate'])->name('settingUpdate');
});
