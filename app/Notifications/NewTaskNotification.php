<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Task;

class NewTaskNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
        if (env('APP_ENV') == 'local') {
            return null;
        }
    }


    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('You have been assigned a new Task on TaxitManager.')
            ->action('Click Here', url('/dashboard'))
            ->line('Click the link above for more information. Thank You');
    }

    public function toArray($notifiable)
    {
        return [
            'task_name' => $this->task->name,
            'task_slug' => $this->task->slug,
            'task_instruction' => $this->task->instruction->name,
            'task_instruction_slug' => $this->task->instruction->slug,
        ];
    }
}
