<?php

namespace App\CommandProcess\Admin\Order;


use App\Helpers\Config\ContractDocConfig;
use App\Models\Order;
use App\Services\Admin\OrderService;
use Illuminate\Support\Facades\Storage;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateOrderHandler implements Handler
{
    public OrderService $dbService;

    public function __construct(OrderService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command): void
    {
        $this->dbService->update($command->orderId, $command->data);
        $this->updateOrderContractDocument($command->orderId);
    }

    protected function updateOrderContractDocument($orderId): void
    {
        $document = request()->file('document');

        if ($document) {
            $order = Order::find($orderId);
            if (Storage::disk(ContractDocConfig::storageDisk())->exists($order->document_path)) {
                Storage::disk(ContractDocConfig::storageDisk())->delete($order->document_path);
            }
            $documentName = $document->getClientOriginalName();
            $orderFolderPath = ContractDocConfig::getOrderContractRelativePath($orderId);
            Storage::disk(ContractDocConfig::storageDisk())->putFileAs($orderFolderPath, $document, $documentName);
            Order::where('id', $orderId)->update([
                'document' => $documentName,
                'document_path' => $orderFolderPath."/".$documentName,
            ]);
        }
    }
}
