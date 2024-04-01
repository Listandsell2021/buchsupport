<?php

namespace App\CommandProcess\Admin\ProductCategory;


use App\Services\Admin\ProductCategoryService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateCategoryActiveStatusHandler implements Handler
{

    public ProductCategoryService $dbService;

    public function __construct(ProductCategoryService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $this->dbService->updateActiveStatus($command->categoryId, $command->status);
    }
}
