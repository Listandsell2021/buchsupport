<?php

namespace App\CommandProcess\Admin\Lead;


use App\CommandProcess\Admin\ProductCategory\StoreCategory;
use Illuminate\Support\Facades\DB;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\CommandBus;
use Rosamarsky\CommandBus\Handler;

class CreateLeadProductCategoryHandler implements Handler
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function handle(Command $command)
    {
        $category = $this->commandBus->execute(new StoreCategory(array_merge($command->data, ['is_archived' => 1])));

        return DB::table('lead_new_products')->insert([
            'lead_id'   => $command->leadId,
            'type'      => 'category',
            'related_id' => $category->id
        ]);
    }
}
