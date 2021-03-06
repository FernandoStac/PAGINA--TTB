<?php

namespace App\Notifications;

use Illuminate\Support\Facades\Lang;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewNotification extends Notification
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

        $pdf=url('/'.$this->archivos[0]);
        // $xml=url('/'.$this->archivos[1]);

        // if($this->is_a>1){
        //     return (new MailMessage)
        //             ->subject(Lang::getFromJson('Archivo cargado'))
        //             ->line('Se cargo un archivo nuevo.')
        //             //->line("<a class='btn btn-button' href='".$pdf."' >PDF</a> <br>")
        //             //->line("<a class='btn btn-button' href='".$xml."' >xml</a>")
        //             //->action('Ver archivo PDF', url('/'.$this->archivos[0]))
        //             // ->action('Ver archivo PDF', url('/'.$this->archivos[0]))
        //             ->action('Ver archivo XML', url('/'.$this->archivos[0]))
        //             ->action('Ver archivo XML', url('/'.$this->archivos[1]));
        // }
        // if($this->is_a=0){
        //     return (new MailMessage)
        //             ->subject(Lang::getFromJson('Archivo cargado'))
        //             ->line('Se cargo un archivo nuevo.')
        //             //->line("<a class='btn btn-button' href='".$pdf."' >PDF</a> <br>")
        //             //->line("<a class='btn btn-button' href='".$xml."' >xml</a>")
        //             //->action('Ver archivo PDF', url('/'.$this->archivos[0]))
        //             // ->action('Ver archivo PDF', url('/'.$this->archivos[0]))
        //             ->action('Ver archivo XML', url('/'.$this->archivos[0]));
        //             // ->action('Ver archivo XML', url('/'.$this->archivos[1]));
        // }

        return (new MailMessage)
                    ->subject(Lang::getFromJson('Archivo cargado'))
                    ->line('Se cargo un archivo nuevo.')
                    ->action('Ver archivo PDF', url('/'.$this->archivos[0]));
        
                    
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
