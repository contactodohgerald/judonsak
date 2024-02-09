<?php

namespace App\Listeners;

use App\Events\InstructionRetrieved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RetrievedInstruction
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
     * @param  InstructionRetrieved  $event
     * @return void
     */
    public function handle(InstructionRetrieved $event)
    {
        //
    }
}
