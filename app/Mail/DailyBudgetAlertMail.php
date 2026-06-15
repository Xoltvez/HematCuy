<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DailyBudgetAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $totalExpense;
    public $dailyBudget;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $totalExpense, $dailyBudget)
    {
        $this->user = $user;
        $this->totalExpense = $totalExpense;
        $this->dailyBudget = $dailyBudget;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Daily Budget Alert Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.daily_budget_alert',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
