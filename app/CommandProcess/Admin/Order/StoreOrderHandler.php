<?php

namespace App\CommandProcess\Admin\Order;


use App\Helpers\Config\ContractDocConfig;
use App\Models\Lead;
use App\Models\LeadContract;
use App\Models\Order;
use App\Services\Admin\OrderService;
use Illuminate\Support\Facades\Storage;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class StoreOrderHandler implements Handler
{
    private OrderService $dbService;

    public function __construct(OrderService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $order = $this->dbService->save($command->data);

        $this->updateOrderContractDocument($order->id);
    }

    protected function updateOrderContractDocument($orderId): void
    {
        $document = request()->file('document');
        $documentName = $document->getClientOriginalName();
        $orderFolderPath = ContractDocConfig::getOrderContractRelativePath($orderId);
        Storage::disk(ContractDocConfig::storageDisk())->putFileAs($orderFolderPath, $document, $documentName);
        Order::where('id', $orderId)->update([
            'document' => $documentName,
            'document_path' => $orderFolderPath."/".$documentName,
        ]);
    }
}
