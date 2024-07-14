<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessCustomerToAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $formatAmountPayment;
    public $nameCourse;
    public $nameCustomer;
    public $initCourse;
    public $emailCustomer;
    public $noTelpCustomer;



    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($formatAmountPayment, $nameCourse, $nameCustomer, $initCourse, $emailCustomer, $noTelpCustomer)
    {
        $this->formatAmountPayment = $formatAmountPayment;
        $this->nameCourse = $nameCourse;
        $this->nameCustomer = $nameCustomer;
        $this->initCourse = $initCourse;
        $this->emailCustomer = $emailCustomer;
        $this->noTelpCustomer = $noTelpCustomer;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Payment Success Customer',
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
            view: 'mail.payment_success_customer_to_admin_mail',
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
