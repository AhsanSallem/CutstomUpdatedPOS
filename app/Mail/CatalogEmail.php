<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CatalogEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $pdf;

    /**
     * Create a new message instance.
     *
     * @param  string  $pdf
     * @return void
     */
    public function __construct($pdf)
    {
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('your-email@example.com', 'Your Name')
            ->view('emails.catalog') // Replace with the appropriate email view
            ->text('This is the plain text version of the email.') // Add a plain text version of the email
            ->attachData($this->pdf, 'Menu-Plumb-Part-Glasgow.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
