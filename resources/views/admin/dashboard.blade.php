@extends(adminTheme().'layouts.app') @section('title')
<title>{{websiteTitle('Dashboard')}}</title>
@endsection @push('css')
<style type="text/css">
    .BillingSummery tr td {
        padding: 5px;
    }
    .BillingSummery .Amount {
        font-size: 15px;
        font-weight: bold;
        color: #3f51b5;
    }
    .BillingSummery .Text {
        color: #6c6c6c;
    }
    
    .todaySummery ul li b {
        width: 150px;
        display: inline-block;
    }
    
    .todaySummery ul {
        padding-left: 20px;
    }
    
</style>
@endpush @section('contents')
<div class="content-header row"></div>
<div class="content-body">
    <!-- Grouped multiple cards for statistics starts here -->
    <div class="row grouped-multiple-statistics-card">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-6 col-xl-4 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="todaySummery">
                                <h4>Today Summery</h4>
                                <ul>
                                    <li><b>Total Sale</b>: {{priceFullFormat($reports['todaySale']+$reports['posSale']+$reports['todayWholesale'])}} </li>
                                    <li><b>Online Sale</b>: {{priceFullFormat($reports['todaySale'])}} </li>
                                    <li><b>POS Sale</b>:  {{priceFullFormat($reports['posSale'])}}</li>
                                    <li><b>Wholesale</b>: {{priceFullFormat($reports['todayWholesale'])}} </li>
                                    <li><b>Expense</b>: {{priceFullFormat($reports['todayExpense'])}} </li>
                                    <li><b>Stock Purchase</b>: {{priceFullFormat($reports['todayStockPurchase'])}} </li>
                                    <li><b>Return Sale</b>: {{priceFullFormat($reports['todayReturnSale'])}} </li>
                                    <li><b>Wholesale Return</b>: {{priceFullFormat($reports['todayReturnSale'])}} </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-4 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="todaySummery">
                                <h4>Product Summery</h4>
                                <ul>
                                    <li><b>Total Product Stock</b>: {{number_format($reports['totalItems'])}} Items ({{number_format($reports['totalStock'])}} Qty) </li>
                                    <li><b>Today Stock In</b>: {{number_format($reports['todayStockInItem'])}} Items ({{number_format($reports['todayStockIn'])}} Qty) </li>
                                    <li><b>Today Stock Out</b>:  {{number_format($reports['todayStockSaleItem'])}} Items ({{number_format($reports['todayStockSale'])}} Qty)</li>
                                    <li><b>Stock Out Product</b>: {{number_format($reports['totalStockOutItem'])}} Items </li>
                                    <li><b>Low Stock Product</b>: {{number_format($reports['totalLowStockOutItem'])}} Items </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-4 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="todaySummery">
                                <h4>General Summery</h4>
                                <ul>
                                    <li><b>Total Due</b>: {{priceFullFormat($reports['totalDueSale'])}} </li>
                                    <li><b>Total Customer</b>:  {{number_format($reports['customer'])}} </li>
                                    <li><b>Total Admin</b>: {{number_format($reports['admin'])}} </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Grouped multiple cards for statistics starts here -->
    <!--<div class="row grouped-multiple-statistics-card">-->
    <!--    <div class="col-12">-->
    <!--        <div class="card">-->
    <!--            <div class="card-body">-->
    <!--                <div class="row">-->
    <!--                    <div class="col-lg-6 col-xl-3 col-sm-6 col-12">-->
    <!--                        <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">-->
    <!--                            <span class="card-icon success d-flex justify-content-center mr-3">-->
    <!--                                <i class="fas fa-chart-line customize-icon font-large-2 p-1"></i>-->
    <!--                            </span>-->
    <!--                            <div class="stats-amount mr-3">-->
    <!--                                <h3 class="heading-text text-bold-600">{{$reports['posSale']}}</h3>-->
    <!--                                <p class="sub-heading">POS Report</p>-->
    <!--                            </div>-->
    <!--                            <span class="inc-dec-percentage">-->
    <!--                                <a href="{{route('admin.posOrdersReports')}}" class="primary"><i class="fa fa-arrow-up"></i> View </a>-->
    <!--                            </span>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                    <div class="col-lg-6 col-xl-3 col-sm-6 col-12">-->
    <!--                        <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">-->
    <!--                            <span class="card-icon primary d-flex justify-content-center mr-3">-->
    <!--                                <i class="fas fa-desktop font-large-2 p-1"></i>-->
    <!--                            </span>-->
    <!--                            <div class="stats-amount mr-3">-->
    <!--                                <h3 class="heading-text text-bold-600">{{$reports['posOrder']}}</h3>-->
    <!--                                <p class="sub-heading">POS Sale</p>-->
    <!--                            </div>-->
    <!--                            <span class="inc-dec-percentage">-->
    <!--                                <a href="{{route('admin.posOrders')}}" class="info"><i class="fa fa-arrow-up"></i> View</a>-->
    <!--                            </span>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                    <div class="col-lg-6 col-xl-3 col-sm-6 col-12">-->
    <!--                        <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">-->
    <!--                            <span class="card-icon danger d-flex justify-content-center mr-3">-->
    <!--                                <i class="fas fa-chart-line font-large-2 p-1"></i>-->
    <!--                            </span>-->
    <!--                            <div class="stats-amount mr-3">-->
    <!--                                <h3 class="heading-text text-bold-600">{{$reports['totalStock']}}</h3>-->
    <!--                                <p class="sub-heading">Stock Report</p>-->
    <!--                            </div>-->
    <!--                            <span class="inc-dec-percentage">-->
    <!--                                <a href="{{route('admin.stocksList')}}" class="success"><i class="fa fa-arrow-up"></i> View </a>-->
    <!--                            </span>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                    <div class="col-lg-6 col-xl-3 col-sm-6 col-12">-->
    <!--                        <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">-->
    <!--                            <span class="card-icon success d-flex justify-content-center mr-3">-->
    <!--                                <i class="fas fa-list font-large-2 p-1"></i>-->
    <!--                            </span>-->
    <!--                            <div class="stats-amount mr-3">-->
    <!--                                <h3 class="heading-text text-bold-600">{{$reports['todayExpense']}}</h3>-->
    <!--                                <p class="sub-heading">Expenses</p>-->
    <!--                            </div>-->
    <!--                            <span class="inc-dec-percentage">-->
    <!--                                <a href="{{route('admin.expensesReports')}}" class="primary"><i class="fa fa-arrow-up"></i> View </a>-->
    <!--                            </span>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    <!-- Grouped multiple cards for statistics starts here -->
    <!--<div class="row grouped-multiple-statistics-card">-->
    <!--    <div class="col-12">-->
    <!--        <div class="card">-->
    <!--            <div class="card-body">-->
    <!--                <div class="row">-->
    <!--                    <div class="col-lg-6 col-xl-3 col-sm-6 col-12">-->
    <!--                        <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">-->
    <!--                            <span class="card-icon primary d-flex justify-content-center mr-3">-->
    <!--                                <i class="fas fa-stream font-large-2 p-1"></i>-->
    <!--                            </span>-->
    <!--                            <div class="stats-amount mr-3">-->
    <!--                                <h3 class="heading-text text-bold-600">{{$reports['product']}}</h3>-->
    <!--                                <p class="sub-heading">Products</p>-->
    <!--                            </div>-->
    <!--                            <span class="inc-dec-percentage">-->
    <!--                                <small class="info"><i class="fa fa-arrow-up"></i> Total</small>-->
    <!--                            </span>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                    <div class="col-lg-6 col-xl-3 col-sm-6 col-12">-->
    <!--                        <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">-->
    <!--                            <span class="card-icon danger d-flex justify-content-center mr-3">-->
    <!--                                <i class="fas fa-users font-large-2 p-1"></i>-->
    <!--                            </span>-->
    <!--                            <div class="stats-amount mr-3">-->
    <!--                                <h3 class="heading-text text-bold-600">{{$reports['customer']}}</h3>-->
    <!--                                <p class="sub-heading">Customers</p>-->
    <!--                            </div>-->
    <!--                            <span class="inc-dec-percentage">-->
    <!--                                <small class="success"><i class="fa fa-arrow-up"></i> Total </small>-->
    <!--                            </span>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                    <div class="col-lg-6 col-xl-3 col-sm-6 col-12">-->
    <!--                        <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">-->
    <!--                            <span class="card-icon success d-flex justify-content-center mr-3">-->
    <!--                                <i class="fas fa-user-tie font-large-2 p-1"></i>-->
    <!--                            </span>-->
    <!--                            <div class="stats-amount mr-3">-->
    <!--                                <h3 class="heading-text text-bold-600">{{$reports['admin']}}</h3>-->
    <!--                                <p class="sub-heading">Admin User</p>-->
    <!--                            </div>-->
    <!--                            <span class="inc-dec-percentage">-->
    <!--                                <small class="primary"><i class="fa fa-arrow-up"></i> Total </small>-->
    <!--                            </span>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                    <div class="col-lg-6 col-xl-3 col-sm-6 col-12">-->
    <!--                        <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">-->
    <!--                            <span class="card-icon success d-flex justify-content-center mr-3">-->
    <!--                                <i class="fas fa-users customize-icon font-large-2 p-1"></i>-->
    <!--                            </span>-->
    <!--                            <div class="stats-amount mr-3">-->
    <!--                                <h3 class="heading-text text-bold-600">{{$reports['pages']}}</h3>-->
    <!--                                <p class="sub-heading">Pages</p>-->
    <!--                            </div>-->
    <!--                            <span class="inc-dec-percentage">-->
    <!--                                <small class="primary"><i class="fa fa-arrow-up"></i> Total </small>-->
    <!--                            </span>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    <!--<div class="row grouped-multiple-statistics-card">-->
    <!--    <div class="col-12">-->
    <!--        <div class="card">-->
    <!--            <div class="card-body">-->
    <!--                <div class="row">-->
    <!--                    <div class="col-lg-6 col-xl-4 col-sm-6 col-12">-->
    <!--                        <div class="d-flex align-items-start">-->
    <!--                            <span class="card-icon warning d-flex justify-content-center mr-3">-->
    <!--                                <i class="fas fa-money font-large-2 p-1"></i>-->
    <!--                            </span>-->
    <!--                            <div class="stats-amount mr-3">-->
    <!--                                <h3 class="heading-text text-bold-600">{{priceFormat($reports['todaySale'])}}</h3>-->
    <!--                                <p class="sub-heading">Sales ({{general()->currency}})</p>-->
    <!--                            </div>-->
    <!--                            <span class="inc-dec-percentage">-->
    <!--                                <small class="success"><i class="fa fa-arrow-up"></i> Today</small>-->
    <!--                            </span>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                    <div class="col-lg-6 col-xl-4 col-sm-6 col-12">-->
    <!--                        <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">-->
    <!--                            <span class="card-icon danger d-flex justify-content-center mr-3">-->
    <!--                                <i class="fas fa-money font-large-2 p-1"></i>-->
    <!--                            </span>-->
    <!--                            <div class="stats-amount mr-3">-->
    <!--                                <h3 class="heading-text text-bold-600">{{priceFormat($reports['monthlytSale'])}}</h3>-->
    <!--                                <p class="sub-heading">Sales ({{general()->currency}})</p>-->
    <!--                            </div>-->
    <!--                            <span class="inc-dec-percentage">-->
    <!--                                <small class="success"><i class="fa fa-arrow-up"></i> Monthly </small>-->
    <!--                            </span>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                    <div class="col-lg-6 col-xl-4 col-sm-6 col-12">-->
    <!--                        <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">-->
    <!--                            <span class="card-icon success d-flex justify-content-center mr-3">-->
    <!--                                <i class="fas fa-money font-large-2 p-1"></i>-->
    <!--                            </span>-->
    <!--                            <div class="stats-amount mr-3">-->
    <!--                                <h3 class="heading-text text-bold-600">{{priceFormat($reports['yearlySale'])}}</h3>-->
    <!--                                <p class="sub-heading">Sales ({{general()->currency}})</p>-->
    <!--                            </div>-->
    <!--                            <span class="inc-dec-percentage">-->
    <!--                                <small class="primary"><i class="fa fa-arrow-up"></i> Yearly </small>-->
    <!--                            </span>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    <!--<div class="row grouped-multiple-statistics-card">-->
    <!--    <div class="col-12">-->
    <!--        <div class="card">-->
    <!--            <div class="card-body">-->
    <!--                <div class="row">-->
    <!--                    <div class="col-lg-6 col-xl-3 col-sm-6 col-12">-->
    <!--                        <div class="d-flex align-items-start">-->
    <!--                            <span class="card-icon warning d-flex justify-content-center mr-3">-->
    <!--                                <i class="fa fa-sitemap font-large-2 p-1"></i>-->
    <!--                            </span>-->
    <!--                            <div class="stats-amount mr-3">-->
    <!--                                <h3 class="heading-text text-bold-600">{{$orderTotal->total}}</h3>-->
    <!--                                <p class="sub-heading">Orders</p>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                    <div class="col-lg-6 col-xl-3 col-sm-6 col-12">-->
    <!--                        <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">-->
    <!--                            <span class="card-icon danger d-flex justify-content-center mr-3">-->
    <!--                                <i class="fa fa-sitemap font-large-2 p-1"></i>-->
    <!--                            </span>-->
    <!--                            <div class="stats-amount mr-3">-->
    <!--                                <h3 class="heading-text text-bold-600">{{$orderTotal->pending}}</h3>-->
    <!--                                <p class="sub-heading">Pending Orders</p>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                    <div class="col-lg-6 col-xl-3 col-sm-6 col-12">-->
    <!--                        <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">-->
    <!--                            <span class="card-icon success d-flex justify-content-center mr-3">-->
    <!--                                <i class="fa fa-sitemap font-large-2 p-1"></i>-->
    <!--                            </span>-->
    <!--                            <div class="stats-amount mr-3">-->
    <!--                                <h3 class="heading-text text-bold-600">{{$orderTotal->confirmed}}</h3>-->
    <!--                                <p class="sub-heading">Confirm Orders</p>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                    <div class="col-lg-6 col-xl-3 col-sm-6 col-12">-->
    <!--                        <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">-->
    <!--                            <span class="card-icon success d-flex justify-content-center mr-3">-->
    <!--                                <i class="fa fa-sitemap font-large-2 p-1"></i>-->
    <!--                            </span>-->
    <!--                            <div class="stats-amount mr-3">-->
    <!--                                <h3 class="heading-text text-bold-600">{{$orderTotal->delivered}}</h3>-->
    <!--                                <p class="sub-heading">Delivered Orders</p>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    
   
    <!-- active users and my task timeline cards starts here -->
    <div class="row match-height">
        <!-- active users card -->
        <div class="col-xl-12 col-lg-12">
            <div class="card active-users">
                <div class="card-header border-0">
                    <h4 class="card-title">Latest Products</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive position-relative card-body">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="min-width: 60px;">SL</th>
                                    <th style="min-width: 350px;">Product Name</th>
                                    <th style="min-width: 80px;">Image</th>
                                    <th style="min-width: 200px;">Catagory</th>
                                    <th style="min-width: 80px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $i=>$product)
                                <tr>
                                    <td>
                                        {{$products->currentpage()==1?$i+1:$i+($products->perpage()*($products->currentpage() - 1))+1}}
                                    </td>
                                    <td>
                                        <span><a href="{{route('productView',$product->slug?:'no-slug')}}" target="_blank">{{$product->name}}</a></span>
                                        <br />
                                        <span style="color: #ccc;"><b style="color: #1ab394;">{{general()->currency}}</b> {{priceFormat($product->final_price)}}</span>

                                        @if($product->fetured==true)
                                        <span><i class="fa fa-star" style="color: #1ab394;"></i></span>
                                        @endif 
                                        @if($product->brand)
                                        <span style="color: #ccc;"><b style="color: #1ab394;">Brand:</b> {{$product->brand->name}}</span>
                                        @endif 
                                        <span style="color: #ccc;"><i class="fa fa-calendar" style="color: #1ab394;"></i> {{$product->created_at->format('d-m-Y')}}</span>
                                    </td>
                                    <td style="padding: 5px; text-align: center;">
                                        <img src="{{asset($product->image())}}" style="max-width: 70px; max-height: 50px;" />
                                    </td>
                                    <td>
                                        @foreach($product->productCategories as $i=>$ctg) {{$i==0?'':'-'}} {{$ctg->name}} @endforeach
                                    </td>
                                    <td>
                                        @if($product->status=='active')
                                        <span class="badge badge-success">Active </span>
                                        @elseif($product->status=='inactive')
                                        <span class="badge badge-danger">Inactive </span>
                                        @else
                                        <span class="badge badge-danger">Draft </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    
</div>
@endsection @push('js')
<script></script>
@endpush