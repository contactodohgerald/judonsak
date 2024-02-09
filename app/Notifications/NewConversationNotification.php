<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Conversation;

class NewConversationNotification extends Notification
{
    use Queueable;

    protected $conversation;

    public function __construct(Conversation $conversation)
    {
        $this->conversation = $conversation;
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
            ->line('You have a new message on TaxitManager.')
            ->action('Click Here', url('/conversations'))
            ->line('Click the link above for more information. Thank You');
    }

    public function toArray($notifiable)
    {
        return [
            'conversation_slug' => $this->conversation->slug,
        ];
    }
}
