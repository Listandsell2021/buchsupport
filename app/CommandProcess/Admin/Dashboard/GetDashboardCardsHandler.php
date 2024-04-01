<?php

namespace App\CommandProcess\Admin\Dashboard;

use App\Models\Admin;
use App\Models\Product;
use App\Models\User;
use App\Models\Visitor;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetDashboardCardsHandler implements Handler
{

    public function handle(Command $command)
    {
        $productsCount = Product::count();
        $customersCount = User::count();
        $adminsCount = Admin::admin()->count();
        $salespersonsCount = Admin::salesperson()->count();
        $dailyVisitors = Visitor::where('date', date('Y-m-d'))->count();

        return [
            [
                "cardClass"     => "card-body primary",
                "title"         => trans("Products"),
                "dataInNumber"  => $productsCount,
                "spanClass"     => "font-primary",
                "iconClass"     => "icon-arrow-up",
                "status"        => "+2%",
                "svgIcon"       => "new-order"
            ],
            [
                "cardClass"     => "card-body warning",
                "title"         => trans("Customers"),
                "dataInNumber"  => $customersCount,
                "spanClass"     => "font-warning",
                "iconClass"     => "icon-arrow-up",
                "status"        => "+5%",
                "svgIcon"       => "customers"
            ],
            [
                "cardClass"     => "card-body warning",
                "title"         => trans("Staffs"),
                "dataInNumber"  => $adminsCount,
                "spanClass"     => "font-warning",
                "iconClass"     => "",
                "status"        => "",
                "svgIcon"       => "customers"
            ],
            [
                "cardClass"     => "card-body warning",
                "title"         => trans("Salespersons"),
                "dataInNumber"  => $salespersonsCount,
                "spanClass"     => "font-warning",
                "iconClass"     => "",
                "status"        => "",
                "svgIcon"       => "customers"
            ],
            [
                "cardClass"     => "card-body secondary",
                "title"         => trans("Daily Visitors"),
                "dataInNumber"  => $dailyVisitors,
                "spanClass"     => "font-secondary",
                "iconClass"     => "",
                "status"        => "",
                "svgIcon"       => ""
            ],
        ];
    }

}
