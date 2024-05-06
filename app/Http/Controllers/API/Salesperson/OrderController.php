<?php

namespace App\Http\Controllers\API\Salesperson;


use App\CommandProcess\Salesperson\Dashboard\GetDashboardCards;
use App\CommandProcess\Salesperson\Order\GetFilteredOrders;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Rosamarsky\CommandBus\CommandBus;

class OrderController extends Controller
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
    public function list(Request $request): JsonResponse
    {
        $orders = $this->commandBus->execute(new GetFilteredOrders($request->all()));

        return $this->respondWithSuccess(trans('Orders fetched successfully'), $orders);
    }


}
