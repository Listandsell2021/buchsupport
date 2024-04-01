<?php

namespace App\CommandProcess\Admin\ProductCategory;


use App\Http\Resources\Admin\AdminResource;
use App\Services\Admin\ProductCategoryService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class StoreCategoryHandler implements Handler
{


    private ProductCategoryService $dbService;

    public function __construct(ProductCategoryService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        return $this->dbService->save($command->data);
    }
}
