<?php

namespace App\CommandProcess\Admin\Mail;


use App\Services\Admin\MailService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetMailHandler implements Handler
{

    public MailService $dbService;

    public function __construct(MailService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $mail = $this->dbService->getById($command->mailId);
        $mail->variables = ($mail->mailable)::getVariables();
        $mail->html_layout = !empty($mail->html_layout) ? (string) $mail->html_layout : getMailTemplate((string) $mail->layout);

        return $mail;
    }
}
