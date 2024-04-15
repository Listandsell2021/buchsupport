<?php

namespace App\CommandProcess\Admin\Dashboard;

use App\Models\Admin;
use App\Models\Service;
use App\Models\User;
use App\Models\Visitor;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetDashboardCardsHandler implements Handler
{

    public function handle(Command $command)
    {
        $customersCount = User::count();
        $adminsCount = Admin::admin()->count();
        $salespersonsCount = Admin::salesperson()->count();
        //$dailyVisitors = Visitor::where('date', date('Y-m-d'))->count();

        return [
            [
                "cardClass"     => "card-body primary",
                "title"         => trans("Customers"),
                "dataInNumber"  => $customersCount,
                "spanClass"     => "font-primary",
                "iconClass"     => "icon-arrow-up",
                "status"        => "+5%",
                "svgIcon"       => "customers"
            ],
            [
                "cardClass"     => "card-body primary",
                "title"         => trans("Staffs"),
                "dataInNumber"  => $adminsCount,
                "spanClass"     => "font-primary",
                "iconClass"     => "",
                "status"        => "",
                "svgIcon"       => "new-order"
            ],
            [
                "cardClass"     => "card-body primary",
                "title"         => trans("Salespersons"),
                "dataInNumber"  => $salespersonsCount,
                "spanClass"     => "font-primary",
                "iconClass"     => "",
                "status"        => "",
                "svgIcon"       => "customers"
            ],
            /*[
                "cardClass"     => "card-body secondary",
                "title"         => trans("Daily Visitors"),
                "dataInNumber"  => $dailyVisitors,
                "spanClass"     => "font-secondary",
                "iconClass"     => "",
                "status"        => "",
                "svgIcon"       => ""
            ],*/
        ];
    }

}
