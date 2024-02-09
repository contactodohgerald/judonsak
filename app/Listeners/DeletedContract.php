<?php

namespace App\Listeners;

use App\Events\ContractDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeletedContract
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
     * @param  ContractDeleted  $event
     * @return void
     */
    public function handle(ContractDeleted $event)
    {
        //
    }
}
