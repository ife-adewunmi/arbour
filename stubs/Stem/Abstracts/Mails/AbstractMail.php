<?php

namespace App\Stem\Abstracts\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

abstract class AbstractMail extends Mailable
{
    use Queueable, SerializesModels;
}
