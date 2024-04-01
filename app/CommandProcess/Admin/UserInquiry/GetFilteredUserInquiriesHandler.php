<?php

namespace App\CommandProcess\Admin\UserInquiry;


use App\Services\Admin\UserInquiryService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetFilteredUserInquiriesHandler implements Handler
{

    private UserInquiryService $dbService;

    public function __construct(UserInquiryService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        return $this->dbService->searchAndPaginate($command->data);
    }
}
