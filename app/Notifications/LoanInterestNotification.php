<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoanInterestNotification extends Notification
{
    use Queueable;

    private $interestData;
    private $loan;
    private $last_trx;
    /**
     * Create a new notification instance.
     */
    public function __construct($interestData, $loan, $last_trx)
    {
        $this->interestData = $interestData;
        $this->loan = $loan;
        $this->last_trx = $last_trx;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
      return [
        'account_no' => $this->interestData['account_no'],
        'user' => $this->loan->user,
        'last_date' => $this->last_trx?date('d-m-Y',strtotime($this->last_trx->date)):'-',
        'total_interest' => $this->interestData['total_interest'],
        'interest_details' => $this->interestData['interest_details'],
      ];
    }
}
