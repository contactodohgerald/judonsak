<?php

namespace App\Listeners;

use App\Events\StaffCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendStaffNotificaation
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
     * @param  StaffCreated  $event
     * @return void
     */
    public function handle(StaffCreated $event)
    {
        //
    }
}
