<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentSendMail extends Mailable
{

    use Queueable, SerializesModels;

    public $urlPembayaran;
    public $priceCourseFormat;
    public $nameCourse;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($urlPembayaran, $priceCourseFormat, $nameCourse)
    {
        $this->urlPembayaran = $urlPembayaran;
        $this->priceCourseFormat = $priceCourseFormat;
        $this->nameCourse = $nameCourse;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Payment Send Mail Notification !!',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mail.payment_send_mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
