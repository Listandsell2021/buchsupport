<?php

namespace App\Http\Controllers\API\Admin;



use App\CommandProcess\Admin\SmartList\DeleteSmartList;
use App\CommandProcess\Admin\SmartList\GetAdminSmartList;
use App\CommandProcess\Admin\SmartList\GetAdminSmartListDetails;
use App\CommandProcess\Admin\SmartList\GetSmartListLeads;
use App\CommandProcess\Admin\SmartList\StoreSmartList;
use App\Http\Requests\Admin\SmartList\CreateSmartListRequest;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SmartList\DeleteSmartListRequest;
use App\Http\Requests\Admin\SmartList\ShowSmartListRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Rosamarsky\CommandBus\CommandBus;


class SmartListController extends Controller
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
        $smartList = $this->commandBus->execute(new GetAdminSmartList());

        return $this->respondWithSuccess(trans('Smart list fetched successfully'), $smartList);
    }



    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getDetails(Request $request): JsonResponse
    {
        $smartListDetail = $this->commandBus->execute(new GetAdminSmartListDetails());

        return $this->respondWithSuccess(trans('Smart list details fetched successfully'), $smartListDetail);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param CreateSmartListRequest $request
     * @return JsonResponse
     */
    public function store(CreateSmartListRequest $request): JsonResponse
    {
        $lead = $this->commandBus->execute(new StoreSmartList($request->get('name'), (int) $request->get('salesperson_id')));

        return $this->respondCreated(__('Smart list created successfully'), $lead);
    }


    /**
     * Display the specified resource.
     *
     * @param ShowSmartListRequest $request
     * @return JsonResponse
     */
    public function show(ShowSmartListRequest $request): JsonResponse
    {
        $leads = $this->commandBus->execute( new GetSmartListLeads((int) $request->get('smart_list_id')) );

        return $this->respondWithSuccess('', $leads);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteSmartListRequest $request
     * @return JsonResponse
     */
    public function destroy(DeleteSmartListRequest $request): JsonResponse
    {
        $this->commandBus->execute( new DeleteSmartList((int) $request->get('smart_list_id')) );

        return $this->respondWithSuccess(__('Smart list deleted successfully'));
    }


    
}
