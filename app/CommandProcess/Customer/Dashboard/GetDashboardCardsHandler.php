<?php

namespace App\CommandProcess\Customer\Dashboard;

use App\Http\Resources\LibraryResource;
use App\Models\Admin;
use App\Models\Service;
use App\Models\SalesPerson;
use App\Models\User;
use App\Models\UserService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetDashboardCardsHandler implements Handler
{

    public function handle(Command $command)
    {
        $countProducts = UserService::where('user_id', $command->userId)->count();
        $countTotalProducts = UserService::where('user_id', $command->userId)->sum('quantity');
        $sumProducts = getNumberInGermanFormat(UserService::where('user_id', $command->userId)->sum('price'));
        $avgPrice = getNumberInGermanFormat(UserService::where('user_id', $command->userId)->avg('price'));
        $avgCondition = getAverageProductCondition(UserService::where('user_id', $command->userId)->sum('condition'));

        return [
            'countProducts'     => $countProducts,
            'countTotalProducts' => $countTotalProducts,
            'sumProducts'       => $sumProducts,
            'avgPrice'          => $avgPrice,
            'avgCondition'      => $avgCondition,
        ];
    }

}
