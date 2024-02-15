<?php

namespace App\Notifications;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
// use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Messages\MailMessage;


class CommandeEffectuee extends Notification //implements ShouldQueue
{
    use Queueable ;
    private $commande; 

    /**
     * Create a new notification instance.
     */
    public function __construct(Commande $commande)
    {
        $this->commande = $commande; 
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
        // dd($notifiable);
        return (new MailMessage)
        ->from('easyleek@mail.com')
        ->subject('Confirmation de commande sur Easyleek')
        ->greeting('Merci pour votre commande, ')
        ->greeting('Merci pour votre commande, ' . $notifiable->name . '!')
        ->line('Nous vous confirmons que votre commande a été reçue avec succès.')
        ->line('Détails de la commande:')
        ->line('Numéro de commande: ' . $this->commande->numeroCommande)
        ->line('Plat commandé: ' . $this->commande->nomPlat)
        ->line('Total de la commande: ' . $this->commande->prixCommande)
        ->line('Lieu de la livraison: ' . $this->commande->lieuLivraison)
        // ->line('Date de la commande: ' . $this->commande->created_at)
        // ->action('Voir les détails de la commande', url('/commande/show/' . $this->commande->id))
        ->line('Merci de faire confiance à notre plateforme. Nous vous tiendrons informé de l\'état de votre commande.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            // 'commande' => $this->commande 
        ];
    }
}
