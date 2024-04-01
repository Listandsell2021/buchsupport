<?php

namespace App\CommandProcess\Admin\Comment;

use Rosamarsky\CommandBus\Command;

class GetFilteredComments implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
