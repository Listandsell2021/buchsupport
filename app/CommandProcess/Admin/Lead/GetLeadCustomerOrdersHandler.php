<?php

namespace App\CommandProcess\Admin\Lead;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetLeadCustomerOrdersHandler implements Handler
{

    public function handle(Command $command)
    {
        return Order::select(DB::raw('CONCAT(users.first_name, " ", users.last_name) as username'), 'orders.*')->with(['service', 'pipeline'])
            ->join('users', 'users.id', 'orders.user_id')
            ->join('leads', 'leads.converted_to', 'users.id')
            ->first();
    }
}
