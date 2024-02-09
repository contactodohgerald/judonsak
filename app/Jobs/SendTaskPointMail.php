<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TaskPointNotification;
use App\Models\TaskPoint;
use App\User;


class SendTaskPointMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $taskPoint;
    protected $user;
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TaskPoint $taskPoint, User $user)
    {
        $this->taskPoint = $taskPoint;
        $this->user = $user;
    }

    /** * * * * * *
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return Notification::send($this->user, new TaskPointNotification($this->taskPoint));
    }
}
