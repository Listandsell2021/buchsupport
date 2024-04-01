<?php

namespace App\CommandProcess\Customer\Dashboard;

use App\Http\Resources\LibraryResource;
use App\Models\Admin;
use App\Models\Product;
use App\Models\SalesPerson;
use App\Models\User;
use App\Models\UserProduct;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetDashboardCardsHandler implements Handler
{

    public function handle(Command $command)
    {
        $countProducts = UserProduct::where('user_id', $command->userId)->count();
        $countTotalProducts = UserProduct::where('user_id', $command->userId)->sum('quantity');
        $sumProducts = getNumberInGermanFormat(UserProduct::where('user_id', $command->userId)->sum('price'));
        $avgPrice = getNumberInGermanFormat(UserProduct::where('user_id', $command->userId)->avg('price'));
        $avgCondition = getAverageProductCondition(UserProduct::where('user_id', $command->userId)->sum('condition'));

        return [
            'countProducts'     => $countProducts,
            'countTotalProducts' => $countTotalProducts,
            'sumProducts'       => $sumProducts,
            'avgPrice'          => $avgPrice,
            'avgCondition'      => $avgCondition,
        ];
    }

}
