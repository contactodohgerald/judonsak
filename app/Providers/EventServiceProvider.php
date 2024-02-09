<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\StaffCreated' => [
            'App\Listeners\SendStaffNotificaation',
        ],
        'App\Events\SendTask' => [
            'App\Listeners\SendTaskNotificaation',
        ],
        'App\Events\InstructionDeleted' => [
            'App\Listeners\DeleteInstruction',
        ],
        'App\Events\InstructionRetrieved' => [
            'App\Listeners\RetrievedInstruction',
        ],
        'App\Events\ContractDeleted' => [
            'App\Listeners\DeletedContract',
        ],
        'App\Events\ClientDeleted' => [
            'App\Listeners\DeletedClient',
        ],
        'App\Events\TaskDeleted' => [
            'App\Listeners\DeletedTask',
        ],
        'App\Events\TaskCreated' => [
            'App\Listeners\CreatedTask',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
