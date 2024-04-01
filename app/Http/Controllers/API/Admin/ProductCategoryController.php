<?php

namespace App\Http\Controllers\API\Admin;

use App\CommandProcess\Admin\ProductCategory\DeleteCategory;
use App\CommandProcess\Admin\ProductCategory\GetActiveCategories;
use App\CommandProcess\Admin\ProductCategory\GetCategory;
use App\CommandProcess\Admin\ProductCategory\GetFilteredCategories;
use App\CommandProcess\Admin\ProductCategory\StoreCategory;
use App\CommandProcess\Admin\ProductCategory\UpdateCategory;
use App\CommandProcess\Admin\ProductCategory\UpdateCategoryActiveStatus;
use App\CommandProcess\Admin\ProductCategory\UpdateProductCategoriesBulkAction;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCategory\ChangeActiveStatusRequest;
use App\Http\Requests\Admin\ProductCategory\CreateProductCategoryRequest;
use App\Http\Requests\Admin\ProductCategory\UpdateProductCategoriesBulkActionRequest;
use App\Http\Requests\Admin\ProductCategory\UpdateProductCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Rosamarsky\CommandBus\CommandBus;

class ProductCategoryController extends Controller
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
        $admins = $this->commandBus->execute(new GetFilteredCategories($request->all()));

        return $this->respondWithSuccess(trans('Product Category fetched successfully'), $admins);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateProductCategoryRequest $request
     * @return JsonResponse
     */
    public function store(CreateProductCategoryRequest $request)
    {
        $category = $this->commandBus->execute(
            new StoreCategory($request->only(ProductCategory::fillableProps()))
        );

        return $this->respondCreated(__('Product Category created successfully'), $category);
    }

    /**
     * Display the specified resource.
     *
     * @param $categoryId
     * @return JsonResponse
     */
    public function show($categoryId)
    {
        $category = $this->commandBus->execute(new GetCategory((int) $categoryId));

        return $this->respondWithContentOnly($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductCategoryRequest $request
     * @param $categoryId
     * @return JsonResponse
     */
    public function update(UpdateProductCategoryRequest $request, $categoryId): JsonResponse
    {
        $this->commandBus->execute(new UpdateCategory((int) $categoryId, $request->only(ProductCategory::fillableProps())));

        return $this->respondUpdated(__('Product Category updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $categoryId
     * @return JsonResponse
     */
    public function destroy($categoryId)
    {
        $this->commandBus->execute(new DeleteCategory((int) $categoryId));

        return $this->respondWithSuccess(__('Product Category deleted successfully'));
    }

    /**
     * Change Active Status
     *
     * @param ChangeActiveStatusRequest $request
     * @return JsonResponse
     */
    public function changeActiveStatus(ChangeActiveStatusRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->commandBus->execute(
            new UpdateCategoryActiveStatus(
                (int) $request->get('category_id'),
                (int) $request->get('is_active')
            )
        );

        return $this->respondWithSuccess(__('Product Category active status updated'));
    }


    /**
     * Update Bulk Action
     *
     * @param UpdateProductCategoriesBulkActionRequest $request
     * @return JsonResponse
     */
    public function updateBulkAction(UpdateProductCategoriesBulkActionRequest $request): JsonResponse
    {
        $message = $this->commandBus->execute(
            new UpdateProductCategoriesBulkAction(
                (array) $request->get('data_ids'),
                (string) $request->get('action')
            )
        );

        return $this->respondWithSuccess($message);
    }


    /**
     * Get Active Categories
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getActiveCategories(Request $request): JsonResponse
    {
        $categories = $this->commandBus->execute(new GetActiveCategories());

        return $this->respondWithSuccess(__('Get active product categories'), $categories);
    }

}
