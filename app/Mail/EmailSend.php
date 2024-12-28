<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailSend extends Mailable
{
    use Queueable, SerializesModels;
    public $invoices_id;
    
    /**
     * Create a new message instance.
     */
    public function __construct($invoices_id)
    {
        $this->invoices_id = $invoices_id;
        
    }
    
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->invoices_id,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.sendmail',
            with: [
                'invoices_id' => $this->invoices_id,
                
            ],
        );
    }
}