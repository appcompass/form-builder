<?php

namespace P3in\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use P3in\Models\FormStorage;

class DeploymentStatus extends Notification
{
    use Queueable;

    private $lines;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $lines)
    {
        $this->lines = $lines;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * toMail
     *
     * @param      mixed    $notifiable
     * @return     \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $email = new MailMessage;
        $email->subject('Deployment Status');
        foreach ($this->lines as $line) {
            $email->line($line);
        }
        return $email;
    }

    /**
     * toArray
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
