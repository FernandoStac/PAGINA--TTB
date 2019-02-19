<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InvoicePaid extends Notification
{
    use Queueable;

    protected $archivos;
    protected $is_a;
    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public function __construct(array $archivos)
    {   
      

        $this->archivos=$archivos;
        $this->is_a=count($archivos);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
  
  
   
   
   
   
     public function toMail($notifiable)
    {
      //  if($archivos=[0]){
            $url = url('/'.$this->archivos[0]);
            $pdf = url('/'.$this->archivos[0]);
            if(!is_null($this->archivos[1])){
                $xml = url('/'.$this->archivos[1]);
            }else{
                $xml=1;
            }
            
                   
          // return dd($xml);
            return (new MailMessage)
                    ->subject('Invoice Paid')
                    ->markdown('mail.invoice.paid', ['url'=>$url, 'pdf' => $pdf,'xml'=>$xml ]);
           //     }     
      
        //     if($archivos=[1]){ 
        //     $url = url('/'.$this->archivos[0]);
        //     $pdf = url('/'.$this->archivos[0]);
        //     $xml = url('/'.$this->archivos[1]);
        
        
      
        // return (new MailMessage)
        //         ->subject('Invoice Paid')
        //         ->markdown('mail.invoice.paid', ['url'=>$url, 'pdf' => $pdf,'xml'=>$xml ]);
        //     }


                
              
          
                 
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiableste una que se llama xml 
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
