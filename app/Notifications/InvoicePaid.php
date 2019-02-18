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
        $this->is_a=count($archivos);

        $this->archivos=$archivos;
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
  
        $url = url('/'.$this->archivos[0]);
        $pdf = url('/'.$this->archivos[0]);
        $xml = url('/'.$this->archivos[1]);
       
        if($this->is_a=1){
       
        return (new MailMessage)
                ->subject('Invoice Paid')
                ->markdown('mail.invoice.paid', ['url'=>$url, 'pdf' => $pdf,'xml'=>$xml ]);
            }
        if($this->is_a=0){
       
        return (new MailMessage)
                ->subject('Invoice Paid')
                ->markdown('mail.invoice.paid', ['url'=>$url, 'pdf' => $pdf,'xml'=>$pdf]);
                    }
                
              
          
                 
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
