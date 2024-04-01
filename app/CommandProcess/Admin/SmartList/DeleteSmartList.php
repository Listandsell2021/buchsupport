<?php

namespace App\CommandProcess\Admin\SmartList;

use Rosamarsky\CommandBus\Command;

class DeleteSmartList implements Command
{
    public int $smartListId;

    public function __construct(int $smartListId)
    {
        $this->smartListId = $smartListId;
    }
}
