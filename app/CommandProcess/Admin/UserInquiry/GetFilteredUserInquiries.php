<?php

namespace App\CommandProcess\Admin\UserInquiry;

use Rosamarsky\CommandBus\Command;

class GetFilteredUserInquiries implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
