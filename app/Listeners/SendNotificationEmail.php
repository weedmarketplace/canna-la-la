<?php

namespace App\Listeners;

use App\Events\SendNotification;
use App\Mail\DefaultMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\Sms;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotificationEmail implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  SendNotification  $event
     * @return void
     */
    public function handle(SendNotification $event)
    {
        //TODO turnon
        // return false;
        if(in_array($event->type,['order_created'])){
            $id = (int)$event->payload['id'];
            
            $order = DB::table('orders')->select('sku','hash','email')->where('id',$id)->first();
            $event->payload['sku'] = $order->sku;
            $event->payload['hash'] = $order->hash;
            $event->payload['email'] = $order->email ? $order->email : 'empty';
            $event->payload['subject_data'] = "Order ".$order->sku." created";
            
            $adminMail = DB::table('admin')->select('email')->first();
            
            if($order->email){
                Mail::to($event->payload['email'])->send(new DefaultMail($event));
            }
            Mail::to($adminMail->email)->send(new DefaultMail($event));
            // if($adminMail->sms_notification){
            //     $message =  trans('sms.'.$event->type, ['sku' => $event->payload['sku']]);
            //     Sms::send($adminMail->phone,$message);
            // }
        }
        if(in_array($event->type,['order_shipping'])){
            $event->payload['subject_data'] = "Order ".$event->payload['sku']." shipping confirmed";
            Mail::to($event->payload['email'])->send(new DefaultMail($event));    
        }
        if(in_array($event->type,['order_canceled'])){
            $event->payload['subject_data'] = "Order ".$event->payload['sku']." ";
            Mail::to($event->payload['email'])->send(new DefaultMail($event));
        }
        if(in_array($event->type,['order_success'])){
            $event->payload['subject_data'] = "Order ".$event->payload['sku']." delivered";
            Mail::to($event->payload['email'])->send(new DefaultMail($event));    
        }

        if(in_array($event->type,['password_recovery'])){
            Mail::to($event->payload['email'])->send(new DefaultMail($event));    
        }
        
        if(in_array($event->type,['feedback'])){
            $adminMail = DB::table('admin')->select('email')->first();
            Mail::to($adminMail->email)->send(new DefaultMail($event));
        }
    }
    public function failed($event) 
    {
        DB::table('report')->insert([
            'connection' => 'async/database',
            'queue' => $event->type ? $event->type : 'Unknown',
            'payload' => $event->payload  ? json_encode($event->payload ) : 'Unknown',
            'failed_at' => date("Y-m-d H:i:s")
        ]);
    }
}