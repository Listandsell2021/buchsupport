<?php

namespace App\CommandProcess\Admin\UserInquiry;

use Rosamarsky\CommandBus\Command;

class DeleteUserInquiry implements Command
{
    public int $inquiryId;

    public function __construct(int $inquiryId)
    {
        $this->inquiryId = $inquiryId;
    }
}
