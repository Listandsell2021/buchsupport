<?php

namespace App\CommandProcess\Admin\Lead;


use Rosamarsky\CommandBus\Command;

class UpdateContractMembership implements Command
{
    public int $leadId;
    public string $membership;

    public function __construct(int $leadId, string $membership)
    {
        $this->leadId = $leadId;
        $this->membership = $membership;
    }
}
