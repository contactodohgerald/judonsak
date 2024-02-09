<?php

namespace App\Listeners;

use App\Events\ClientDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeletedClient
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
     * @param  ClientDeleted  $event
     * @return void
     */
    public function handle(ClientDeleted $event)
    {
        //
    }
}
