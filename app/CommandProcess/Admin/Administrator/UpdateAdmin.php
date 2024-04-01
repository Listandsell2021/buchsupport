<?php

namespace App\CommandProcess\Admin\Administrator;

use Rosamarsky\CommandBus\Command;

class UpdateAdmin implements Command
{
    public int $adminId;
    public array $data;

    public function __construct(int $adminId, array $data)
    {
        $this->adminId = $adminId;
        $this->data = $data;
    }
}
