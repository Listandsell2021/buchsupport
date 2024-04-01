<?php

namespace App\CommandProcess\Admin\Product;


use App\Helpers\Config\ImageConfig;
use App\Libraries\Services\ProductImageManager;
use App\Models\ProductImage;
use App\Services\Admin\ProductService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class StoreProductHandler implements Handler
{
    private ProductService $dbService;

    public function __construct(ProductService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $product = $this->dbService->save($command->data);

        if (isset($command->data['images']) && count($command->data['images']) > 0) {
            $order = 1;
            foreach ($command->data['images'] as $file) {
                if (in_array($file->getClientOriginalExtension(), ImageConfig::getImageExtensions())) {
                    $name = $file->getClientOriginalName();
                    $imagePath = ProductImageManager::store($product->id, $file, $name);
                    $this->dbService->createProductImage((int) $product->id, $name, $imagePath, $order++);
                }
            }
        }

        return $product;
    }
}
