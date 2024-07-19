<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;


class TaskModified extends Notification
{
    use Queueable;

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
    public function toMail($notifiable)
{
    $mailMessage = (new MailMessage)
                    ->subject('Une tâche a été modifiée') // Sujet de l'e-mail
                    ->line('Une nouvelle tâche vous a été modifiée par le leader') // Premier paragraphe du corps de l'e-mail
                    ->line('Titre de la tâche: ' . $this->task->title); // Ajout d'une ligne avec le titre de la tâche

    // Vérifier si une deadline est définie et l'ajouter à l'email
    if ($this->task->deadline) {
        $mailMessage->line('Délai de la tâche: ' . \Carbon\Carbon::parse($this->task->deadline)->format('d/m/Y')); // Ajout d'une ligne avec le délai
    }

    $mailMessage->action('Voir la tâche', url('/home')) // Bouton d'action avec un lien vers la tâche
                ->line('Merci de votre collaboration !'); // Message de conclusion

    return $mailMessage;
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
