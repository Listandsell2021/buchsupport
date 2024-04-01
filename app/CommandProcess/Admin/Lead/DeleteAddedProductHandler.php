<?php

namespace App\CommandProcess\Admin\Lead;

use App\CommandProcess\Admin\Product\DeleteProduct;
use App\CommandProcess\Admin\ProductCategory\DeleteCategory;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\Category;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\CommandBus;
use Rosamarsky\CommandBus\Handler;

class DeleteAddedProductHandler implements Handler
{

    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function handle(Command $command)
    {
        $addedProduct = DB::table('lead_new_products')->find($command->addedProductId);

        if (!$addedProduct) {
            return;
        }

        if ($addedProduct->type == 'category') {
            $this->commandBus->execute(new DeleteCategory($addedProduct->related_id));
        }

        if ($addedProduct->type == 'product') {
            $this->commandBus->execute(new DeleteProduct($addedProduct->related_id));
        }

        DB::table('lead_new_products')->where('id', $command->addedProductId)->delete();

    }
}
