<?php

namespace App\CommandProcess\Admin\Order;


use App\Helpers\Config\ContractDocConfig;
use App\Services\Admin\OrderService;
use Illuminate\Support\Facades\Storage;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class DownloadOrderContractDocumentHandler implements Handler
{
    private OrderService $dbService;

    public function __construct(OrderService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $order = $this->dbService->getById($command->orderId);

        $filePath = Storage::disk(ContractDocConfig::storageDisk())->path($order->document_path);

        return response()->download($filePath, $order->document);
    }
}
