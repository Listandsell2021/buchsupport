<?php

namespace App\CommandProcess\Salesperson\Dashboard;


use App\Models\Lead;
use Illuminate\Support\Facades\DB;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetLeadDetailHandler implements Handler
{

    public function handle(Command $command)
    {
        return Lead::select('leads.*')
            ->where('leads.id', $command->leadId)
            ->where('leads.salesperson_id', getAdminId())
            ->first();
    }

}
