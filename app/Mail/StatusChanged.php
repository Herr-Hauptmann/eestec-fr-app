<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Company;
use App\Models\Event;

class StatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $event;
    public $company;
    public $userName;
    public $coordinator;
    public $status;

    public function __construct(Event $event, Company $company, String $userName, String $coordinator, String $status)
    {
        $this->event=$event;
        $this->company=$company;
        $this->userName = $userName;
        $this->coordinator = $coordinator;
        $this->status = $status;
    }

    public function build()
    {
        return $this->from('fr-app@eestec-sa.ba')
                    ->subject('[EESTEC]['.$this->event->name.']['.$this->company->name.'] Contacting status changed to '.$this->status.'!')
                    ->view('emails.status-email');
    }
}
