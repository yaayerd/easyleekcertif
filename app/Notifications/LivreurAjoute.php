<?php

namespace App\Notifications;

use App\Models\Livreur;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LivreurAjoute extends Notification
{
    use Queueable;
    private $livreur; 

    /**
     * Create a new notification instance.
     */
    public function __construct(User $livreur)
    {
        $this->livreur = $livreur; 
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
            ->subject('Bienvenue sur notre plateforme, cher livreur!')
            ->greeting('Bienvenue ' . $this->livreur->nom . '!')
            ->line('Vous avez été ajouté à notre plateforme en tant que livreur.')
            ->line('Voici quelques informations sur votre compte:')
            ->line('Nom: ' . $this->livreur->nom)
            ->line('Email: ' . $this->livreur->email)
            ->line('Numéro de téléphone: ' . $this->livreur->telephone)
            ->line('Merci de faire partie de notre équipe de livreurs. Nous comptons sur vous pour assurer une livraison efficace.')
            // ->action('Se connecter à votre compte', url('/restaurant/login'))
            ->line('Merci et bonne livraison!');
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
