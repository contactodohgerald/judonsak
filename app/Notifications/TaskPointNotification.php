<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\models\TaskPoint;

class TaskPointNotification extends Notification
{
    use Queueable;
    protected $taskPoint;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(TaskPoint $taskPoint)
    {
        $this->taskPoint = $taskPoint;
        if (env('APP_ENV') == 'local') {
            return null;
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('You have been awarded a new Task Piont on TaxitManager.')
            ->action('Click Here', url('/dashboard'))
            ->line('Click the link above for more information. Thank You');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'taskPoint_partners_point' => $this->taskPoint->partners_point,
            'taskPoint_line_manager_point' => $this->taskPoint->line_manager_point,
            'taskPoint_description' => $this->taskPoint->description,
        ];
    }
}
