<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="{{asset(general()->favicon())}}">
<title>Welcome to {{general()->title}}! Confirm Your Registration.</title>
<!-- Google Font CDN-->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
<style>

    body{
        margin:0;
        background:#f1f1f1;
        font-family: sans-serif;
    }
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }
    
    td, th {
      border: 1px solid #dddddd;
      text-align: left;
      font-size:14px;
      padding: 8px;
    }
    ul.pageLink {
        margin: 0;
        padding: 0;
        list-style: none;
        text-align: center;
    }
    
    ul.pageLink li {
        display: inline-block;
        border-right: 1px solid #dbdada;
        line-height: 14px;
    }
    
    ul.pageLink li a {
        padding: 0 15px;
        color: gray;
        text-decoration: none;
    }
	@media only screen and (max-width: 600px){
        
        

	}

</style>

</head>
<body style="background:#f1f1f1;padding: 15px;">
<div style="margin:25px auto;max-width:600px;width:600px;overflow:auto;padding:15px;background:#fff;">

<p style="text-align:center;">
<a href="{{route('index')}}" target="_blank"><img src="{{URL::asset(general()->logo())}}" style="max-width:200px;"></a>

</p>
<p style="text-align:center;">
    <b>Mobile:</b> {{general()->mobile}}, <b>Email:</b> {{general()->email}} <br>
    <b>Address:</b> {{general()->address_one}}
</p>

<div style="padding:10px;margin: 10px 0;">
    <h2 style="margin: 0;padding: 5px 0;">Dear Sir, </h2>
    <div>
    <p>
        Welcome to the {{general()->title}}! Hello! Here’s your sale report for today. We’re excited to share the details with you shortly.
    </p>
    <h3>
        Today Reports -
        
        {{Carbon\Carbon::now()->format('d M, Y')}}
    </h3>
    
    <div class="row" style="display:flex;margin:0 -5px;">
        <div class="col-md-3" style="padding:5px;flex: 0 0 24%;max-width: 24%;">
            <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                <div style="color: #959595;font-size:14px;">Total Sales <small>(BDT)</small></div>
                <div style="color: black;font-size: 20px;font-weight: bold;margin: 3px 0;">{{number_format($datas['report']['totalSales'])}}</div>
                
                @if($datas['report']['grothSales'] > 0)
                <div style="color: green;">
                @else
                <div style="color: red;">
                @endif
                
                :{{number_format($datas['report']['grothSales'],1)}}
                %</div>
            </div>
        </div>
        <div class="col-md-3" style="padding:5px;flex: 0 0 24%;max-width: 24%;">
            <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                <div style="color: #959595;font-size:14px;">POS Sales <small>(BDT)</small></div>
                <div style="color: black;font-size: 20px;font-weight: bold;margin: 3px 0;">{{number_format($datas['report']['posSales'])}}</div>
                @if($datas['report']['grothPosSales'] > 0)
                <div style="color: green;">
                @else
                <div style="color: red;">
                @endif
                    :{{number_format($datas['report']['grothPosSales'],1)}}
                    %</div>
            </div>
        </div>
        <div class="col-md-3" style="padding:5px;flex: 0 0 24%;max-width: 24%;">
            <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                <div style="color: #959595;font-size:13px;">Online Sales <small>(BDT)</small></div>
                <div style="color: black;font-size: 20px;font-weight: bold;margin: 3px 0;">{{number_format($datas['report']['onlineSales'])}}</div>
                @if($datas['report']['grothOnlineSales'] > 0)
                <div style="color: green;">
                @else
                <div style="color: red;">
                @endif
                    :{{number_format($datas['report']['grothOnlineSales'],1)}}
                    %</div>
            </div>
        </div>
        <div class="col-md-3" style="padding:5px;flex: 0 0 24%;max-width: 24%;">
            <div style="padding: 10px 15px;border: 1px solid #e8e8e8;border-radius: 10px;background: white;">
                <div style="color: #959595;font-size:14px;">New Customer</div>
                <div style="color: black;font-size: 20px;font-weight: bold;margin: 3px 0;">{{number_format($datas['report']['customer'])}}</div>
                @if($datas['report']['preCustomer'] > 0)
                <div style="color: green;">
                @else
                <div style="color: red;">
                @endif
                    :{{number_format($datas['report']['preCustomer'],1)}}
                    %</div>
            </div>
        </div>
    </div>
  
    <div>
    <h3>POS Sales List</h3>
    <div class="table-responsive">
        @php
            $totalCash = 0;
            $totalCard = 0;
            $totalMobile = 0;
        @endphp
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Bill</th>
                    <th>Cash</th>
                    <th>Card</th>
                    <th>Mobile</th>
                </tr>
            </thead>
            <trbody>
                @foreach($datas['posOrders'] as $pOrder)
                
                @php    
                    $cash = $pOrder->transections->where('payment_method', 'Cash Method')->sum('received_amount');
                    $card = $pOrder->transections->where('payment_method', 'Card Method')->sum('received_amount');
                    $mobile = $pOrder->transections->where('payment_method', 'Mobile Method')->sum('received_amount');
                    
                    $totalCash +=$cash-$pOrder->changed_amount;
                    $totalCard +=$card;
                    $totalMobile +=$mobile;
                    
                @endphp
                
                
                <tr>
                    <td>#{{$pOrder->invoice}}</td>
                    <td>{{$pOrder->name}}</td>
                    <td>{{$pOrder->items()->count()}}</td>
                    <td>{{priceFullFormat($pOrder->grand_total)}}</td>
                    <td>{{priceFormat($cash-$pOrder->changed_amount)}}</td>
                    <td>{{priceFormat($card)}}</td>
                    <td>{{priceFormat($mobile)}}</td>
                </tr>
                
                @endforeach
                
                @if($datas['posOrders']->count()==0)
                <tr>
                    <td style="text-align:center;" colspan="7">No Sales Order</td>
                </tr>
                @endif
                <tr>
                    <td></td>
                    <td></td>
                    <td>Total</td>
                    <td>{{priceFormat($datas['posOrders']->sum('grand_total'))}}</td>
                    <td>{{priceFormat($totalCash)}}</td>
                    <td>{{priceFormat($totalCard)}}</td>
                    <td>{{priceFormat($totalMobile)}}</td>
                </tr>
            </trbody>
        </table>
    </div>
</div>
<div>
    <h3>Online Sales List</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Bill</th>
                    <th>Date</th>
                </tr>
            </thead>
            <trbody>
                @foreach($datas['customerOrders'] as $pOrder)
                <tr>
                    <td>#{{$pOrder->invoice}}</td>
                    <td>{{$pOrder->name}}</td>
                    <td>{{$pOrder->items()->count()}}</td>
                    <td>{{priceFullFormat($pOrder->grand_total)}}</td>
                    <td>{{$pOrder->created_at->format('d-m-Y')}}</td>
                </tr>
                @endforeach
                @if($datas['customerOrders']->count()==0)
                <tr>
                    <td style="text-align:center;" colspan="5">No Customer Order</td>
                </tr>
                @endif
            </trbody>
        </table>
    </div>
</div>

<div>
    <h3>Yearly Total Sales</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Total Sales</th>
                    <th>POS Sales</th>
                    <th>Online Sales</th>
                    <th>New Customer</th>
                </tr>
            </thead>
            <tbody> 
                @foreach($datas['monthlyData'] as $data)
                    <tr>
                        <td>{{$data['month']}}</td>
                        <td>{{ priceFullFormat($data['total'], 2) }}</td> 
                        <td>{{ priceFullFormat($data['posTotal'], 2) }}</td>
                        <td>{{ priceFullFormat($data['onlineTotal'], 2) }}</td>
                        <td>{{ priceFormat($data['customerTotal']) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
    
    <br><br>
    
     Best regards, <br/>
     The {{general()->title}} Team <br/>
     {{general()->website}}
    </p>
    
  <br>
  <p style="margin:0;">If You Have any questions, please email us at <a href="mailto:{{general()->email}}" >{{general()->email}}</a> or visit our 
  @if($pg =pageTemplate('Contact Us'))
  <a href="{{route('pageView',$pg->slug?:'no-title')}}" target="_blank">{{$pg->name}}</a>
  @endif
  .</p>
  <br>
</div>

<div style="padding:10px;margin: 10px 0;border-top: 1px solid #ededed;">
   <p style="text-align: center;">
       
       @if(general()->facebook_link)
       <a href="{{general()->facebook_link}}" target="_blank" style="display: inline-block;padding: 0 10px;"><img style="width:25px;" src="{{URL::asset('welcome/social/facebook.png')}}"></a>
       @endif
       
       @if(general()->instagram_link)
       <a href="{{general()->instagram_link}}" target="_blank" style="display: inline-block;padding: 0 10px;"><img style="width:25px;" src="{{URL::asset('welcome/social/instagram.png')}}"></a>
       @endif
        
       @if(general()->pinterest_link)
       <a href="{{general()->pinterest_link}}" target="_blank" style="display: inline-block;padding: 0 10px;"><img style="width:25px;" src="{{URL::asset('welcome/social/pinterest.png')}}"></a>
       @endif
       
       @if(general()->twitter_link)
       <a href="{{general()->twitter_link}}" target="_blank" style="display: inline-block;padding: 0 10px;"><img style="width:25px;" src="{{URL::asset('welcome/social/twitter-alt.png')}}"></a>
       @endif
        
       @if(general()->youtube_link)
       <a href="{{general()->youtube_link}}" target="_blank" style="display: inline-block;padding: 0 10px;"><img style="width:25px;" src="{{URL::asset('welcome/social/youtube.png')}}"></a>
       @endif
   </p>
   <p>
       <ul class="pageLink">
           
           <li><a href="{{route('index')}}">Home</a></li>
           
           <li>
              @if($pg =pageTemplate('About Us'))
              <a href="{{route('pageView',$pg->slug?:'no-title')}}" target="_blank">{{$pg->name}}</a>
              @endif
           </li>
           
           <li style="border-right: 1px solid #fff;">
              @if($pg =pageTemplate('Contact Us'))
              <a href="{{route('pageView',$pg->slug?:'no-title')}}" target="_blank">{{$pg->name}}</a>
              @endif
           </li>
       </ul>
   </p>
  <p style="text-align: center;">you have received this email as a registered user of <a href="{{route('index')}}">{{general()->website}}</a> can <a href="{{route('index')}}">unsubscribe</a> from these emails here.</p>
</div>

</div>
</body>
</html>