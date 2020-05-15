<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\schedules;

class MailSend extends Mailable
{
    public $schedule;
    public $schedule_detail = [];

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(schedules $schedule,$schedule_detail)
    {
        //
        $this->schedule = $schedule;
        $this->schedule_detail = $schedule_detail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('welcome');
    }
}
