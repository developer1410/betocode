<?php

namespace App\Mail;

use App\Organisation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrganisationCreated extends Mailable
{
    use Queueable;
    use SerializesModels;

    public Organisation $organisation;

    /**
     * Create a new message instance.
     * @param Organisation $organisation
     *
     * @return void
     */
    public function __construct(Organisation $organisation)
    {
        $this->organisation = $organisation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.organisation.created');
    }
}
