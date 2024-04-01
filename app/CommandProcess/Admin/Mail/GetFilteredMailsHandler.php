<?php

namespace App\CommandProcess\Admin\Mail;

use App\Services\Admin\MailService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetFilteredMailsHandler implements Handler
{

    private MailService $dbService;

    public function __construct(MailService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        return $this->dbService->searchAndPaginate($command->data);
    }
}
