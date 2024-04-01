<?php

namespace App\Http\Controllers\API\Admin;

use App\CommandProcess\Admin\Product\AddProductImage;
use App\CommandProcess\Admin\Product\DeleteProduct;
use App\CommandProcess\Admin\Product\DeleteProductImage;
use App\CommandProcess\Admin\Product\GetAllProducts;
use App\CommandProcess\Admin\Product\GetFilteredProducts;
use App\CommandProcess\Admin\Product\GetProduct;
use App\CommandProcess\Admin\Product\GetProductImages;
use App\CommandProcess\Admin\Product\SortProductImages;
use App\CommandProcess\Admin\Product\StoreProduct;
use App\CommandProcess\Admin\Product\UpdateProduct;
use App\CommandProcess\Admin\Product\UpdateProductsBulkAction;
use App\CommandProcess\Admin\ProductCategory\DeleteCategory;
use App\CommandProcess\Admin\ProductCategory\GetCategory;
use App\CommandProcess\Admin\ProductCategory\StoreLeadStatus;
use App\CommandProcess\Admin\ProductCategory\UpdateCategory;
use App\CommandProcess\Admin\ProductCategory\UpdateProductCategoriesBulkAction;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\AddProductImageRequest;
use App\Http\Requests\Admin\Product\CreateProductRequest;
use App\Http\Requests\Admin\Product\GetProductImageRequest;
use App\Http\Requests\Admin\Product\RemoveProductImageRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductsBulkActionRequest;
use App\Http\Requests\Admin\ProductCategory\CreateProductCategoryRequest;
use App\Http\Requests\Admin\ProductCategory\UpdateProductCategoriesBulkActionRequest;
use App\Http\Requests\Admin\ProductCategory\UpdateProductCategoryRequest;
use App\Http\Resources\Admin\Product\ProductWithImagesResource;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rosamarsky\CommandBus\CommandBus;

class ProductController extends Controller
{
    use ApiResponseHelpers;

    protected CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $products = $this->commandBus->execute(new GetFilteredProducts($request->all()));

        return $this->respondWithSuccess(trans('Products fetched successfully'), $products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateProductRequest $request
     * @return JsonResponse
     */
    public function store(CreateProductRequest $request)
    {
        $product = $this->commandBus->execute(
            new StoreProduct($request->all())
        );

        return $this->respondCreated(__('Product created successfully'), $product);
    }

    /**
     * Display the specified resource.
     *
     * @param $productId
     * @return JsonResponse
     */
    public function show($productId)
    {
        $product = $this->commandBus->execute(new GetProduct((int) $productId));

        return $this->respondWithContentOnly(new ProductWithImagesResource($product));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductRequest $request
     * @param $productId
     * @return JsonResponse
     */
    public function update(UpdateProductRequest $request, $productId): JsonResponse
    {
        $this->commandBus->execute(new UpdateProduct((int) $request->get('id'), $request->all()));

        return $this->respondUpdated(__('Product updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $productId
     * @return JsonResponse
     */
    public function destroy($productId): JsonResponse
    {
        $this->commandBus->execute(new DeleteProduct((int) $productId));

        return $this->respondWithSuccess(__('Product deleted successfully'));
    }


    /**
     * Update Bulk Action
     *
     * @param UpdateProductsBulkActionRequest $request
     * @return JsonResponse
     */
    public function updateBulkAction(UpdateProductsBulkActionRequest $request): JsonResponse
    {
        $message = $this->commandBus->execute(
            new UpdateProductsBulkAction(
                (array) $request->get('data_ids'),
                (string) $request->get('action')
            )
        );

        return $this->respondWithSuccess($message);
    }



    /**
     * Get All Products
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllProducts(Request $request): JsonResponse
    {
        $products = $this->commandBus->execute(new GetAllProducts());

        return $this->respondWithSuccess(__('Products fetched successfully'), $products);
    }

    

    /**
     * Add Product Image
     *
     * @param AddProductImageRequest $request
     * @return JsonResponse
     */
    public function addProductImage(AddProductImageRequest $request): JsonResponse
    {
        $this->commandBus->execute(
            new AddProductImage((int) $request->get('product_id'), $request->file('image'))
        );

        return $this->respondWithSuccess(__('Image added successfully'));
    }


    /**
     * Add Product Image
     *
     * @param RemoveProductImageRequest $request
     * @return JsonResponse
     */
    public function removeProductImage(RemoveProductImageRequest $request): JsonResponse
    {
        $this->commandBus->execute(new DeleteProductImage((int) $request->get('image_id')));

        return $this->respondWithSuccess(__('Image removed successfully'));
    }


    /**
     * Get Product Images
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getProductImages(Request $request): JsonResponse
    {
        $images = $this->commandBus->execute(new GetProductImages((int) $request->get('product_id')));

        return $this->respondWithSuccess(__('Product images fetched successfully'), $images);
    }

    /**
     * Sort Product Images
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sortProductImages(Request $request): JsonResponse
    {
        $this->commandBus->execute(new SortProductImages((array) $request->get('image_ids')));

        return $this->respondWithSuccess(__('Images sorted successfully'));
    }

}
