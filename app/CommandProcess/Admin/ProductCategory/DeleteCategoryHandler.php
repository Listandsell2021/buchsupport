<?php

namespace App\CommandProcess\Admin\ProductCategory;


use App\Services\Admin\ProductCategoryService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class DeleteCategoryHandler implements Handler
{

    private ProductCategoryService $dbService;

    /**
     * @param ProductCategoryService $dbService
     */
    public function __construct(ProductCategoryService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $this->dbService->delete($command->categoryId);
    }
}
