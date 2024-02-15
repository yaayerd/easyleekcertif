<?php

namespace App\Notifications;

// use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ClientInscrit extends Notification
{
    use Queueable;
    private $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Bienvenue sur notre plateforme Easyleek')
            ->greeting('Bienvenue ' . $notifiable->name . '!')
            ->line('Nous sommes ravis de vous accueillir sur notre plateforme.')
            ->line('Merci de vous être inscrit. Vous pouvez maintenant profiter de tous les avantages pour commander vos repas.')
            ->line('Vos informations sont les suivantes : ')
            ->line('Adresse Mail : ' . $notifiable->mail)
            ->line('Téléphone : ' . $notifiable->phone)
            ->line('Adresse : ' . $notifiable->adresse)
            ->line('Vous pourrez modifier ces informations sur votre profil si vous le souhaitez.')
            ->action('Accéder à la plateforme', url('/categorie/list'))
            ->line('Si vous avez des questions ou des préoccupations, n\'hésitez pas à nous contacter.')
            ->line('Nous vous souhaitons une excellente expérience sur notre plateforme. Merci!');
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
