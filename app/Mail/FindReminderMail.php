<?php

namespace App\Mail;

use App\Models\Find;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class FindReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $findEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Find $find)
    {
        $this->findEmail = $find;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Recordatorio de Hallazgo por Finalizar')
        ->view('mails.find_reminder', [
            'find' => $this->findEmail,
        ]);
    }
}
