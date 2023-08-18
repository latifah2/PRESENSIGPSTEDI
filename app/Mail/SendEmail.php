<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    // Properti untuk menyimpan data
    public $detailEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($detailEmail)
        {
            $this->detailEmail = $detailEmail;
        }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Pengajuan Form Cuti')
                    ->view('templateemail');
    }
}
