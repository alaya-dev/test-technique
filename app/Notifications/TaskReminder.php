<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class TaskReminder extends Notification
{
    use Queueable;

    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail']; // Notification envoyée par e-mail
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Rappel de tâche')
                    ->line('La tâche "' . $this->task->title . '" est en attente.')
                    ->line('Description: ' . $this->task->description)
                    ->line('Date limite: ' . Carbon::parse($this->task->deadline)->format('d/m/Y H:i'))
                    ->line('Merci de votre attention !');
    }
}
