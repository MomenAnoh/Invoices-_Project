<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class CreateInvoice extends Notification
{
    use Queueable;
    // لازم اخد البيانات الي جاية  من الكنترولر 
    private $invoice;
    

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invoice)
    {
       $this->invoice=$invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

     //دا لو هعمل نوتيفيكيشن ع الايميل كمان 
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */

     public function toDatabase($notifiable)
{
    
    return [
        'id' => $this->invoice->id,
        'title' => " :تم اضافة فاتورة جديدة بواسطة",
        'user'=>auth::user()->name
    ];
}
}
