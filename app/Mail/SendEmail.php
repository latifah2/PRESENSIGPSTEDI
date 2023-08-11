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
    public $file_cuti;
    public $listCuti;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fileCuti, $listCuti)
        {
            $this->file_cuti = $fileCuti;
            $this->listCuti = $listCuti;
        }

        /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('latifahkhoirunnisa11@gmail.com', 'Nisa')
                    ->subject('Send Email form Cuti')
                    ->view('cuti.cuti')
                    ->attach($this->file_cuti);
    }
    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    //public function envelope()
    //{
      //  return new Envelope(
       //     from: new Address ('latifahkhoirunnisa11@gmail.com', 'Nisa'),
       //     subject: 'Send Email form Cuti',
        //);
    //}

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    //public function content()
    //{
     //   return new Content(
     //       view: 'cuti.cuti',
      //  );
    //}

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        //return [Attachment::fromPath('public/upload/cuti/')
        return [Attachment::fromPath($this->file_cuti)
    ];
    }
}
