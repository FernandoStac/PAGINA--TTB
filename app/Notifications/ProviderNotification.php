<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ProviderNotification extends Notification
{
    use Queueable;
    protected $information;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $information)
    {
        $this->information=$information;
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
        $url =url('/');
        $url2 =url('/'.$this->information[3]);
        return (new MailMessage)->markdown('mail.provider.acceptedRejected',['url'=>$url, 'status' => $this->information[0] ,'message'=>$this->information[1] ,'document'=>$this->information[2] ,'owner'=>$this->information[4],'url2'=>$url2 ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
