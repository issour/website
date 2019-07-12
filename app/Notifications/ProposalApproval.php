<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ProposalApproval extends Notification
{
    use Queueable;

    public $proposal;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($proposal)
    {
        $this->proposal = $proposal;
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $repository = config('services.github.owner') .'/'. $this->proposal->repository;

        return (new MailMessage)
            ->subject('Your workflow proposal has been approved')
            ->greeting("Approved: {$this->proposal->title}")
            ->line('Your idea is a good fit for Nova Workflows! ')
            ->line('Next steps involve building it and publishing it')
            ->line('That will take place on this github repository:')
            ->line("**Github:** [https://github.com/$repository]($repository)")
            ->line('The top voted workflows in staging get priorty')
            ->line('You can upvote it by logging in with Github')
            ->action('Upvote Workflow', url("workflows/$repository"))
            ->line('You will receive a notification when it goes live!')
            ->line('Thank you for using Nova Workflows!');
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
            //
        ];
    }
}
