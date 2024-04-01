<?php

namespace App\Http\Controllers\API\Admin;


use App\CommandProcess\Admin\Dashboard\GetDashboardCards;
use App\CommandProcess\Admin\Dashboard\GetSalespersonsCommissionGraph;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Rosamarsky\CommandBus\CommandBus;

class DashboardController extends Controller
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
     * @return JsonResponse
     */
    public function getCardDetails(Request $request): JsonResponse
    {
        $admins = $this->commandBus->execute(new GetDashboardCards());

        return $this->respondWithSuccess(trans('Dashboard details fetched successfully'), $admins);
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getSalespersonCommissionGraph(Request $request): JsonResponse
    {
        $salespersonIds = (array) ($request->has('salesperson_ids') ? $request->get('salesperson_ids') : []);
        $dateFrom = (string) ($request->has('date_from') ? $request->get('date_from') : '');
        $dateTo = (string) ($request->has('date_to') ? $request->get('date_to') : '');

        $commissions = $this->commandBus->execute(
            new GetSalespersonsCommissionGraph($salespersonIds, $dateFrom, $dateTo)
        );

        return $this->respondWithSuccess(trans('Salespersons commission fetched successfully'), $commissions);
    }

}
