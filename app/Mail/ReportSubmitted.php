<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Company;
use App\Models\Event;

class ReportSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $content;
    public $event;
    public $company;
    public $userName;
    public $coordinator;

    public function __construct(String $content, Event $event, Company $company, String $userName, String $coordinator)
    {
        $this->content=$content;
        $this->event=$event;
        $this->company=$company;
        $this->userName = $userName;
        $this->coordinator = $coordinator;
    }

    public function build()
    {
        return $this->from('fr-app@eestec-sa.ba')
                    ->subject('[EESTEC]['.$this->event->name.']['.$this->company->name.'] New report')
                    ->view('emails.report-email');
    }
}
