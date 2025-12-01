<?php
namespace App\Console\Commands;

use Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use Illuminate\Console\Command;

class EmailNotificationsDaily extends Command
{


    protected $signature = 'DailyEmail:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily Email Notifications';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $from =Carbon::now();
        $to = clone $from;
        
        $startDay = clone $from;
        $daysDifference = $startDay->diffInDays($to);
        if($daysDifference > 0){
        $previousDate = $startDay->subDays($daysDifference);
        }else{
        $previousDate = $startDay->subDay();
        }
        
        
        $currentMonth = clone $from;
        $monthlyData = [];
        for ($i = 0; $i < 12; $i++) {
            $month = $currentMonth->copy()->subMonths($i);
            $orders = Order::whereIn('order_type', ['customer_order', 'pos_order'])
                            ->where('order_status','delivered')
                            ->whereMonth('created_at', $month->format('m'))
                            ->whereYear('created_at', $month->format('Y'))
                            ->select(['id', 'grand_total', 'order_type'])
                            ->get();

            $customers = User::where('status', 1)
                             ->whereMonth('created_at', $month->format('m'))
                             ->whereYear('created_at', $month->format('Y'))
                             ->count();
            $monthlyData[] = [
                'month' => $month->format('F Y'),  // Month name (e.g., March 2024)
                'total' => $orders->sum('grand_total'),  // Total grand_total for the month
                'posTotal' => $orders->where('order_type', 'pos_order')->sum('grand_total'),  // POS sales
                'onlineTotal' => $orders->where('order_type', 'customer_order')->sum('grand_total'),  // Online sales
                'customerTotal' => $customers  // Total number of customers
            ];
        }

            
        $customerOrders  = Order::latest()->where('order_type','customer_order')->where('order_status','delivered')
                        ->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)->get(['id','invoice','name','mobile','grand_total','payment_status','order_status','created_at']);
        
        $posOrders  = Order::latest()->where('order_type','pos_order')->where('order_status','delivered')
                        ->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)->get(['id','invoice','name','mobile','grand_total','payment_status','order_status','changed_amount','created_at']);
        
        $users  = User::where('status',1)
                        ->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)->count();
        
        
        //Previus data get
        $preCustomerOrders  = Order::latest()->where('order_type','customer_order')->where('order_status','delivered')
                        ->whereDate('created_at','>=',$previousDate)->whereDate('created_at','<',$from)->get(['id','invoice','name','mobile','grand_total','payment_status','order_status','created_at']);
        
        $prePosOrders  = Order::latest()->where('order_type','pos_order')->where('order_status','delivered')
                        ->whereDate('created_at','>=',$previousDate)->whereDate('created_at','<',$from)->get(['id','invoice','name','mobile','grand_total','payment_status','order_status','created_at']);
        
        $preUsers  = User::where('status',1)
                        ->whereDate('created_at','>=',$previousDate)->whereDate('created_at','<',$from)->count();
        
        
        $totalSales =$customerOrders->sum('grand_total')+$posOrders->sum('grand_total');
        $preTotalSales =$preCustomerOrders->sum('grand_total')+$prePosOrders->sum('grand_total');
        
        $report =array(
                'totalSales'=>$customerOrders->sum('grand_total')+$posOrders->sum('grand_total'),
                'grothSales1'=>$preTotalSales,
                'grothSales'=>($preTotalSales > 0) ? (($totalSales - $preTotalSales) / $preTotalSales) * 100 : 100,
                'posSales'=>$posOrders->sum('grand_total'),
                'posSales1'=>$prePosOrders->sum('grand_total'),
                'grothPosSales'=>($prePosOrders->sum('grand_total') > 0) ? (($posOrders->sum('grand_total') - $prePosOrders->sum('grand_total')) / $prePosOrders->sum('grand_total')) * 100 : 100,
                'onlineSales'=>$customerOrders->sum('grand_total'),
                'onlineSales1'=>$preCustomerOrders->sum('grand_total'),
                'grothOnlineSales'=>($preCustomerOrders->sum('grand_total') > 0) ? (($customerOrders->sum('grand_total') - $preCustomerOrders->sum('grand_total')) / $preCustomerOrders->sum('grand_total')) * 100 : 100,
                'customer'=>$users,
                'customer1'=>$preUsers,
                'preCustomer'=>($preUsers > 0) ? (($users - $preUsers) / $preUsers) * 100 : 100,
            );
        
        $emails =['info@meghfashion.com'];
        // $toEmail ='rabiulk449@gmail.com';
        $toName =general()->title;
        $subject ='Daily Sales Report Summery Form '.general()->title;
        $datas =array('report'=>$report,'posOrders'=>$posOrders,'customerOrders'=>$customerOrders,'monthlyData'=>$monthlyData);
        $template ='mails.summeryReportAdminMail';

        foreach ($emails as $toEmail){
          //  sendMail($toEmail,$toName,$subject,$datas,$template);
        }
        
        
        // \Log::info('Every Hour after Mail Send Notification');
    }
    
    
    
}