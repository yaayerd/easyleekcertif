<?php

namespace App\Notifications;

// use App\Models\User;
use Illuminate\Foundation\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RestaurantAjoutee extends Notification
{
    use Queueable;
    private $restaurant;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $restaurant)
    {
        $this->restaurant = $restaurant;
        
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

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouveau restaurant ajouté sur Easyleek')
            ->greeting('Bonjour!')
            ->line('Nous tenons à vous informer que vous avez été ajouté en tant que nouveau restaurant sur la plateforme Easyleek.')
            ->line('Voici les informations de votre compte restaurant:')
            ->line('Nous vous suggerrons de modifier votre mot de passe:')
            ->line('Nom de votre restaurant: ' . $notifiable->name)
            // ->line('Adresse: ' . $notifiable->adresse)
            ->action('Accéder à la plateforme ici ', url('/categorie/list'))
            ->line('Merci de faire partie de notre plateforme. Belle aventure!');
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
