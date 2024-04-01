<?php

namespace App\CommandProcess\Customer\Dashboard;

use App\Models\UserProduct;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class ReverseProductViewHandler implements Handler
{

    public function handle(Command $command)
    {
        $userProduct = UserProduct::find($command->userProductId);
        $hiddenStatus = !$userProduct->is_hidden;
        $userProduct->is_hidden = $hiddenStatus;
        $userProduct->save();

        return $hiddenStatus;
    }
}
