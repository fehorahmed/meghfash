@extends(adminTheme().'layouts.app') @section('title')
<title>{{websiteTitle('Sales Today Report')}}</title>
@endsection @push('css')
<style type="text/css">
    
    .summery p{
        margin-bottom: 5px;
        color:gray;
    }
    
    .summery h5{
        font-weight: bold;
        font-family: sans-serif;
        color: #4a4a4a;
    }
    
    .selectPercentage {
        display: inline-block;
        margin-right: 10px;
        border: 1px solid gray;
        color: #000000;
        margin-bottom: 10px;
        width: 100px;
        text-align: center;
        background: #e2dfdf;
        cursor: pointer;
    }
    
</style>
@endpush @section('contents')


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Sales Today Report</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item active">Sales Today Report</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="{{route('admin.posOrdersToday')}}">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>

@include('admin.alerts')
<div class="card">
    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
        <h4 class="card-title">Sales Today Report</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form action="{{route('admin.posOrdersToday')}}">
                <div class="row">
                    <div class="col-md-3 mb-1">
                        <div class="input-group">
                            <input type="date" name="startDate" value="{{$from->format('Y-m-d')}}" class="form-control {{$errors->has('startDate')?'error':''}}" />
                            <button type="submit" class="btn btn-success rounded-0"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                    <div class="col-md-7 mb-1">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="summery">
                                    <p>Today Sale ({{number_format(0)}})</p>
                                    <h5>
                                        <i class="fas fa-chart-line" style="color: green;"></i>
                                        {{ priceFullFormat($orders->sum('grand_total')) }}</h5>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="summery">
                                    <p>Card ({{number_format(0)}})</p>
                                    <h5>
                                        <i class="fas fa-chart-line" style="color: green;"></i>
                                        {{ priceFullFormat($orders->sum('total_card')) }}</h5>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="summery">
                                    <p>Mobile ({{number_format(0)}})</p>
                                    <h5>
                                        <i class="fas fa-chart-line" style="color: green;"></i>
                                        {{ priceFullFormat($orders->sum('total_mobile')) }}</h5>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="summery">
                                    <p>Cash ({{number_format(0)}})</p>
                                    <h5>
                                        <i class="fas fa-chart-line" style="color: green;"></i>
                                        {{ priceFullFormat($orders->sum('total_cash')-$orders->sum('changed_amount')) }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
      
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
        <h4 class="card-title">Today Sale List</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form action="{{route('admin.posOrdersToday')}}" method="post">
                @csrf
            <input type="hidden" name="startDate" value="{{$from->format('Y-m-d')}}">
            <div class="row">
                <div class="col-md-8">
                    <span class="selectPercentage" data-percent="0">
                        0%
                    </span>
                    <span class="selectPercentage" data-percent="30">
                        30%
                    </span>
                    <span class="selectPercentage" data-percent="50">
                        50%
                    </span>
                    <span class="selectPercentage" data-percent="80">
                        80%
                    </span>
                    <span class="selectPercentage" data-percent="90">
                        90%
                    </span>
                    <span class="selectPercentage" data-percent="100">
                        100%
                    </span>
                    <p style="color: #F44336;font-weight: bold;">
                        How many order hidden form today sales.
                    </p>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success" onclick="return confirm('Are you want to Update?')">Update Status</button>
                </div>
            </div>
            
                @php
                    $totalCash = 0;
                    $totalCard = 0;
                    $totalMobile = 0;
                    $totalReceived = 0;
                    $totalRemaining = 0;
                @endphp
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>#Invoice</th>
                                <th style="min-width: 140px;">Customer</th>
                                <th>Items</th>
                                <th>VAT</th>
                                <th>Discount</th>
                                <th>Bill</th>
                                <th>Cash</th>
                                <th>Card</th>
                                <th>Mobile</th>
                                <th>Received</th>
                                <th>Change</th>
                                <th style="min-width: 120px;">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                @php
                                    $cash = $order->transections->where('payment_method', 'Cash Method')->sum('received_amount');
                                    $card = $order->transections->where('payment_method', 'Card Method')->sum('received_amount');
                                    $mobile = $order->transections->where('payment_method', 'Mobile Method')->sum('received_amount');
                                    $received = $order->transections->sum('received_amount');
 
                                    if($received > $order->grand_total){
                                    $remaining = $received - $order->grand_total;
                                    }else{
                                    $remaining = 0;
                                    }
                                    
            
                                    $totalCash += $cash;
                                    $totalCard += $card;
                                    $totalMobile += $mobile;
                                    $totalReceived += $received;
                                    $totalRemaining += $remaining;
                                @endphp
            
                                <tr>
                                    <td><input type="checkbox" name="checkid[]" {{$order->addedby_id==671?'checked':''}} value="{{$order->id}}"></td>
                                    <td>#{{$order->invoice }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $order->items()->sum('quantity') }}</td>
                                    <td>{{ number_format($order->tax_amount) }}</td>
                                    <td>{{ number_format($order->discount_price) }}</td>
                                    <td>{{ number_format($order->grand_total,0) }}</td>
                                    <td>{{ number_format($cash) }}</td>
                                    <td>{{ number_format($card) }}</td>
                                    <td>{{ number_format($mobile) }}</td>
                                    <td>{{ number_format($received,0) }}</td>
                                    <td>{{ intval($remaining) }}</td>
                                    <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
            
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Total</th>
                                <th>{{ number_format($orders->sum('total_qty')) }}</th>
                                <th>{{ priceFormat($orders->sum('tax_amount')) }}</th>
                                <th>{{ priceFormat($orders->sum('discount_price')) }}</th>
                                <th>{{ priceFormat($orders->sum('grand_total')) }}</th>
                                <th>{{ number_format($totalCash-$totalRemaining) }}</th>
                                <th>{{ number_format($totalCard) }}</th>
                                <th>{{ number_format($totalMobile) }}</th>
                                <th>{{ number_format($totalReceived) }}</th>
                                <th>{{ intval($totalRemaining) }}</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </form>
       </div>
    </div>
</div>



@endsection 
@push('js') 

<script>
    $(document).ready(function() {
        $('.selectPercentage').on('click', function() {
            // Get the percentage value
            var percent = $(this).data('percent');
            
            // Select all checkboxes with name "checkid"
            var checkboxes = $('input[name="checkid[]"]');
            
            // Calculate how many checkboxes to check
            var numToCheck = Math.round((percent / 100) * checkboxes.length);
            
            // Uncheck all checkboxes first
            checkboxes.prop('checked', false);
            
            // Check the required number of checkboxes
            checkboxes.slice(0, numToCheck).prop('checked', true);
        });
    });
</script>


@endpush