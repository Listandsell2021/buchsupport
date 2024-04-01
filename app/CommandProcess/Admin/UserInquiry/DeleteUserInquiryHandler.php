<?php

namespace App\CommandProcess\Admin\UserInquiry;


use App\Services\Admin\UserInquiryService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class DeleteUserInquiryHandler implements Handler
{

    private UserInquiryService $dbService;

    /**
     * @param UserInquiryService $dbService
     */
    public function __construct(UserInquiryService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $this->dbService->delete($command->inquiryId);
    }
}
