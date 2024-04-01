<?php

namespace App\CommandProcess\Admin\Customer;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetCustomersBirthdayHandler implements Handler
{
    
    public function __construct()
    {

    }

    public function handle(Command $command)
    {
        $startYear = date('Y', strtotime(request()->get('start')));
        $endYear = date('Y', strtotime(request()->get('end')));

        $startDate = date('Y-m-d', strtotime(request()->get('start')));
        $endDate = date('Y-m-d', strtotime(request()->get('end')));

        // DB::enableQueryLog();
        $birthDates = User::select(
            'id as customer_id', DB::raw('CONCAT(first_name, " ", last_name) as user_name'), 'dob as birth_date',
            DB::raw('CONCAT(first_name, " ", last_name) as title')
        );

        if ($endYear != $startYear) {
            $birthDates->addSelect(DB::raw("CONCAT(IF(DATE_FORMAT(dob , '%m') >= 10, '".$startYear."', '".$endYear."'), '-', DATE_FORMAT(dob , '%m-%d')) as start"));
        } else {
            $birthDates->addSelect(DB::raw("CONCAT(".$startYear.", '-', DATE_FORMAT(dob , '%m-%d')) as start"));
        }

        return $birthDates
            ->where(function ($query) use ($startDate, $endDate, $startYear, $endYear) {
                $query->havingBetween('start', [$startDate, $endDate]);
            })
            ->get();

    }
}
