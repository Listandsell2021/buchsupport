<?php

namespace App\CommandProcess\Admin\UserInquiry;

use App\Services\Admin\UserInquiryService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateUserInquiriesBulkActionHandler implements Handler
{

    private UserInquiryService $inquiryService;

    public function __construct(UserInquiryService $inquiryService)
    {
        $this->inquiryService = $inquiryService;
    }

    public function handle(Command $command)
    {
        $message = '';

        if ($command->action == 'delete') {
            $this->inquiryService->deleteBulk($command->inquiryIds);
            $message = trans('User inquiries deleted successfully');
        }

        return $message;
    }
}
