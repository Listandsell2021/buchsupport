<?php

namespace App\CommandProcess\Admin\Lead;

use App\Helpers\Config\ContractDocConfig;
use App\Models\Lead;
use App\Models\LeadContract;
use App\Models\Order;
use App\Services\Admin\LeadService;
use Illuminate\Support\Facades\Storage;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class CreateOrderFromLeadHandler implements Handler
{

    private LeadService $leadService;

    public function __construct(LeadService $leadService)
    {
        $this->leadService = $leadService;
    }

    public function handle(Command $command)
    {
        $order = $this->leadService->createOrderByLead($command->leadId);

        $this->orderContractDocumentUpdate($order->id, $command->leadId);
    }

    protected function orderContractDocumentUpdate($orderId, $leadId): void
    {
        $leadContract = LeadContract::where('lead_id', $leadId)->first();
        $orderDocPath = ContractDocConfig::getOrderContractRelativePath($orderId.'/'.$leadContract->document);
        Storage::disk(ContractDocConfig::storageDisk())->copy($leadContract->document_path, $orderDocPath);
        Order::where('id', $orderId)->update([
            'document' => $leadContract->document,
            'document_path' => $orderDocPath,
        ]);
        Lead::where('id', $leadId)->update(['has_order' => 1]);
    }
}
