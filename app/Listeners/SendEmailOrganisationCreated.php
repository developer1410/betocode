<?php

namespace App\Listeners;

use App\Events\OrganisationCreated;
use App\Organisation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailOrganisationCreated implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrganisationCreated  $event
     * @return void
     */
    public function handle(OrganisationCreated $event)
    {
        Mail::to($event->user->email)
            ->send(new \App\Mail\OrganisationCreated($event->organisation));
    }
}
