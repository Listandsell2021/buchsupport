<?php

namespace App\CommandProcess\Admin\Lead;


use App\CommandProcess\Admin\Service\StoreService;
use App\Libraries\Services\ProductImageManager;
use App\Models\ProductImage;
use App\Services\Admin\ServicesService;
use Illuminate\Support\Facades\DB;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\CommandBus;
use Rosamarsky\CommandBus\Handler;

class CreateLeadProductHandler implements Handler
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {

        $this->commandBus = $commandBus;
    }

    public function handle(Command $command)
    {
        $product = $this->commandBus->execute(new StoreService(array_merge($command->data, ['is_archived' => 1])));

        return DB::table('lead_new_products')->insert([
            'lead_id'   => $command->leadId,
            'type'      => 'product',
            'related_id' => $product->id
        ]);
    }
}
