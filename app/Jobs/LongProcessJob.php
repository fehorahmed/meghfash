<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LongProcessJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $id;
    /**
     * Create a new job instance.
     */
    public function __construct($id)
    {
        //
        $this->id = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // কাজ শুরু - স্ট্যাটাস আপডেট
        $order = Order::where('order_type','customer_order')->where('mail_send_status',false)->find($this->id);
        if($order){

        //**********Send Mail***************//
            if(general()->mail_status && $order->email){
                //Mail Data
                $datas =array('order'=>$order);
                $template ='mails.InvoiceMail';
                $toEmail =$order->email;
                $toName =$order->name;
                $subject ='Order Successfully Completed in '.general()->title;
            
                sendMail($toEmail,$toName,$subject,$datas,$template);
            }

            if(general()->mail_status && general()->mail_from_address){
                //Mail Data
                $datas =array('order'=>$order);
                $template ='mails.InvoiceMail';
                $toEmail =general()->mail_from_address;
                $toName =general()->mail_from_name;
                $subject ='Order Successfully Completed in '.general()->title;
            
                sendMail($toEmail,$toName,$subject,$datas,$template);
            }
            //**********Send Mail***************//
            
            //Send SMS 
            if(general()->sms_status && $order->mobile){
                $msg ='Your order is success. #'.$order->invoice.' Thank you for your shopping';
                sendSMS($order->mobile,$msg);
            }
            $order->mail_send_status = true;
            $order->save();

        }
    

    }
}
