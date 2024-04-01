<?php

namespace App\CommandProcess\Customer\Profile;

use Rosamarsky\CommandBus\Command;

class UploadProfileImage implements Command
{
    public int $userId;
    public mixed $image;

    public function __construct(int $userId, mixed $image)
    {
        $this->userId = $userId;
        $this->image = $image;
    }
}
