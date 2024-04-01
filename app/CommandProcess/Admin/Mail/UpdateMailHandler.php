<?php

namespace App\CommandProcess\Admin\Mail;


use App\Services\Admin\MailService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateMailHandler implements Handler
{

    public MailService $dbService;

    public function __construct(MailService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $this->dbService->update($command->mailId, $command->data);
    }
}
