
    <div style="max-width: 550px;margin: auto; border: 1px solid #000000;margin-bottom: 25px;transform: rotate(90deg);margin-top: 95px;margin-left: -55px;">
        <style>
            .table td, .table th {
                border-bottom: 1px solid #000000;
                border-top: 1px solid #000000;
                color: black;
                font-size: 18px;
            }
        </style>
        <h4 style="text-align: center;font-weight: bold;font-family: sans-serif;margin:0;padding:5px;">Order No: {{ $order->invoice }}
        <br>
        <b>Date:</b> {{$order->created_at->format('d-m-Y')}}
        </h4>
        <div style="display:flex;">
            <table class="table" style="margin: 0;">
                <tr>
                    <th style="padding: 2px 5px;">Name:</th>
                    <th style="padding: 2px 5px;">{{ $order->name }}</th>
                </tr>
                <tr>
                    <th style="padding: 2px 5px;">Mobile:</th>
                    <th style="padding: 2px 5px;">{{ $order->mobile }}</th>
                </tr>
                <tr>
                    <th style="padding: 2px 5px;" >Address:</th>
                    <th style="white-space: normal;padding: 2px 5px;">{{ $order->fullAddress() }}</th>
                </tr>
                <tr>
                    <th style="padding: 2px 5px;" >Item:</th>
                    <th style="white-space: normal;padding: 2px 5px;">
                        {{$order->getDescription()}}
                    </th>
                </tr>
                <tr>
                    <th style="padding: 2px 5px;" >Payable bill:</th>
                    <th style="white-space: normal;padding: 2px 5px;">
                       {{priceFullFormat($order->due_amount)}}
                    </th>
                </tr>
            </table>
        </div>
        <p style="text-align: center;margin-bottom: 15px;padding: 5px;">
            
            <img src="{{asset(general()->logo())}}" style="max-width: 100%;max-height:70px;">
            <br>
            <span style="font-size: 18px;color: black;"><b>Mobile: {{general()->mobile}} , 01611634423</span></b> <br>
            <!--<span style="font-size: 16px;color: black;" ></span><br>-->
            <!--<span style="font-size: 16px;color: black;">facebook/meghfashionbd</span>-->
        </p>

        {{--
        <p style="text-align: center;margin-bottom: 15px;padding: 5px;">
            
            <img src="{{asset(general()->logo())}}" style="max-width: 100%;">
            <!--<br>-->
            <!--<span style="font-size: 28px;display: block;line-height: 30px;">{{general()->title}}</span>-->
            <!--<span>Mobile: {{general()->mobile}} Email: {{general()->email}}</span> <br>-->
            <!--<span>{{general()->address_one}}</span>-->
        </p>
        <h4 style="text-align: center;font-weight: bold;font-family: sans-serif;">Order No: {{ $order->invoice }}</h4>
        <div style="padding: 5px;">
            <table class="table">
                <tr>
                    <th>Name:</th>
                    <th>{{ $order->name }}</th>
                </tr>
                <tr>
                    <th>Mobile:</th>
                    <th>{{ $order->mobile }}</th>
                </tr>
                <tr>
                    <th>Address</th>
                    <th style="white-space: normal;">{{ $order->fullAddress() }}</th>
                </tr>
            </table>
            <br>
            
            <p style="text-align:center;">Thank you for shopping</p>
            <br>
        </div>
        --}}
    </div>
