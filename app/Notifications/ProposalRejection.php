<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ProposalRejection extends Notification
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
        return (new MailMessage)
            ->subject('Regarding your workflow idea..')
            ->greeting('We are unable to proceed with:')
            ->line("**'{$this->proposal->title}'**")
            ->line("```{$this->proposal->description}```")
            ->line('---')
            ->line('While all ideas are exciting to review, not all can move forward. Here are a few reasons why your proposal may have been closed.')
            ->line('**Not generic enough:** ultimately we want to focus as much time on building things that benefit as many developers as possible.')
            ->line('**Not similar enough:** there is a similarity and spirit to these integrations, maybe yours was not of similar style.')
            ->line('**Not simple enough:** the best integrations do one thing really well, maybe yours had too many steps involved.')
            ->line('You are certainly incouraged to review your idea and submit a revised approach and or submit other ideas!')
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
