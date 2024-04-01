<?php

namespace App\CommandProcess\Admin\ProductCategory;


use App\Http\Resources\Admin\AdminResource;
use App\Http\Resources\Admin\RoleResource;
use App\Services\Admin\ProductCategoryService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetCategoryHandler implements Handler
{

    public ProductCategoryService $dbService;

    public function __construct(ProductCategoryService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        return $this->dbService->getById($command->categoryId);
    }
}
