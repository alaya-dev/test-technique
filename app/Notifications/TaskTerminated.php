<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class TaskTerminated extends Notification
{
    use Queueable;

    protected $task;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail']; // Indique que cette notification est envoyée par e-mail
    }

    /**
     * Get the mail representation of the notification.
     */
    /**
 * Get the mail representation of the notification.
 */
public function toMail($notifiable)
{
    $deadline = $this->task->deadline;
    $url = url('/liste-task'); // URL vers la page /home, ajustez si nécessaire

    return (new MailMessage)
                ->subject('Une tâche a été terminée')
                ->line('La tâche "' . $this->task->title . '" a été marquée comme terminée par ' ) // Premier paragraphe du corps de l'e-mail
                ->line('Description: ' . $this->task->description)
                ->line('Date limite: ' . Carbon::parse($deadline)->format('d/m/Y H:i'))
                ->action('Voir la tâche', $url) // Ajout du lien vers la tâche
                ->line('Merci de votre collaboration !');
}

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
