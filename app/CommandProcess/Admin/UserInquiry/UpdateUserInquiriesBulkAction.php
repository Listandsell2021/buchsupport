<?php

namespace App\CommandProcess\Admin\UserInquiry;

use Rosamarsky\CommandBus\Command;

class UpdateUserInquiriesBulkAction implements Command
{
    public array $inquiryIds;
    public string $action;

    public function __construct(array $inquiryIds, string $action)
    {
        $this->inquiryIds = $inquiryIds;
        $this->action = $action;
    }
}
