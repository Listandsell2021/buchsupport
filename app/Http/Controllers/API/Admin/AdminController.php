<?php

namespace App\Http\Controllers\API\Admin;

use App\CommandProcess\Admin\Administrator\CreateSalespersonCommission;
use App\CommandProcess\Admin\Administrator\DeleteAdmin;
use App\CommandProcess\Admin\Administrator\DownloadAdminCommissionDocument;
use App\CommandProcess\Admin\Administrator\GetActiveSalespersons;
use App\CommandProcess\Admin\Administrator\GetAdmin;
use App\CommandProcess\Admin\Administrator\GetFilteredAdminCommissions;
use App\CommandProcess\Admin\Administrator\GetFilteredAdmins;
use App\CommandProcess\Admin\Administrator\StoreAdmin;
use App\CommandProcess\Admin\Administrator\UpdateAdmin;
use App\CommandProcess\Admin\Administrator\UpdateAdminActiveStatus;
use App\CommandProcess\Admin\Administrator\UpdateAdminBulkAction;
use App\CommandProcess\Admin\Administrator\UpdateAdminCommissionPaidStatus;
use App\CommandProcess\Admin\AdminRole\GetActiveRoles;
use App\CommandProcess\Admin\Customer\DownloadContractDocument;
use App\DataHolders\Enum\AuthRole;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Administrator\ChangeActiveStatusRequest;
use App\Http\Requests\Admin\Administrator\CreateAdminCommissionRequest;
use App\Http\Requests\Admin\Administrator\CreateAdminRequest;
use App\Http\Requests\Admin\Administrator\DownloadAdminCommissionRequest;
use App\Http\Requests\Admin\Administrator\UpdateAdminBulkActionRequest;
use App\Http\Requests\Admin\Administrator\UpdateAdminRequest;
use App\Http\Requests\Admin\Administrator\UpdateCommissionPaidStatusRequest;
use App\Models\Admin;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rosamarsky\CommandBus\CommandBus;

class AdminController extends Controller
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
        $admins = $this->commandBus->execute(new GetFilteredAdmins($request->all()));

        return $this->respondWithSuccess(trans('Admins fetched successfully'), $admins);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateAdminRequest $request
     * @return JsonResponse
     */
    public function store(CreateAdminRequest $request)
    {
        $admin = $this->commandBus->execute(new StoreAdmin($request->all()));

        return $this->respondCreated(__('Admin created successfully'), $admin);
    }

    /**
     * Display the specified resource.
     *
     * @param $adminId
     * @return JsonResponse
     */
    public function show($adminId)
    {
        $admin = $this->commandBus->execute(new GetAdmin((int) $adminId));

        return $this->respondWithContentOnly($admin);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAdminRequest $request
     * @param $adminId
     * @return JsonResponse
     */
    public function update(UpdateAdminRequest $request, $adminId): JsonResponse
    {
        $this->commandBus->execute(new UpdateAdmin((int) $request->get('id'), $request->all()));

        return $this->respondUpdated(__('Admin updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $adminId
     * @return JsonResponse
     */
    public function destroy($adminId)
    {
        $this->commandBus->execute(new DeleteAdmin((int) $adminId));

        return $this->respondWithSuccess(__('Admin deleted successfully'));
    }

    /**
     * Change Active Status
     *
     * @param ChangeActiveStatusRequest $request
     * @return JsonResponse
     */
    public function changeActiveStatus(ChangeActiveStatusRequest $request): JsonResponse
    {
        $this->commandBus->execute(
            new UpdateAdminActiveStatus(
                (int) $request->get('admin_id'),
                (int) $request->get('is_active')
            )
        );

        return $this->respondWithSuccess(__('Admin Active Status Updated'));
    }

    /**
     * Update Bulk Action
     *
     * @param UpdateAdminBulkActionRequest $request
     * @return JsonResponse
     */
    public function updateBulkAction(UpdateAdminBulkActionRequest $request): JsonResponse
    {
        $message = $this->commandBus->execute(
            new UpdateAdminBulkAction(
                (array) $request->get('data_ids'),
                (string) $request->get('action')
            )
        );

        return $this->respondWithSuccess($message);
    }

    /**
     * Create Salesperson Commission Pdf
     *
     * @param CreateAdminCommissionRequest $request
     * @return JsonResponse
     */
    public function createSalespersonCommission(CreateAdminCommissionRequest $request): JsonResponse
    {
        $adminId = (int) $request->get('admin_id');
        $dateFrom = (string) $request->get('date_from');
        $dateTo = (string) $request->get('date_to');

        $success = $this->commandBus->execute(new CreateSalespersonCommission($adminId, $dateFrom, $dateTo));

        return $this->respondWithSuccess($success ? trans('Successfully created commission') : trans('Commission could not be created'), $success);
    }


    /**
     * Get Salesperson Commissions
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getSalespersonCommissions(Request $request): JsonResponse
    {
        $commissions = $this->commandBus->execute(new GetFilteredAdminCommissions($request->all()));

        return $this->respondWithSuccess(trans('Commissions fetched successfully'), $commissions);
    }


    /**
     * Update Commission Paid Status
     *
     * @param UpdateCommissionPaidStatusRequest $request
     * @return JsonResponse
     */
    public function updateCommissionPaidStatus(UpdateCommissionPaidStatusRequest $request): JsonResponse
    {
        $this->commandBus->execute(
            new UpdateAdminCommissionPaidStatus(
                (int) $request->get('commission_id'),
                (int) $request->get('paid')
            )
        );

        return $this->respondWithSuccess((int) $request->get('paid') ? __('Admin commission paid successfully') : __('Admin commission unpaid successfully'));
    }


    /**
     * Update Commission Paid Status
     * @param DownloadAdminCommissionRequest $request
     * @return mixed
     */
    public function downloadAdminCommission(DownloadAdminCommissionRequest $request): mixed
    {
        return $this->commandBus->execute( new DownloadAdminCommissionDocument((int) $request->get('commission_id')) );
    }



    /**
     * Get Auth Roles
     *
     * @return JsonResponse
     */
    public function getAuthRoles(): JsonResponse
    {
        $roles = AuthRole::forSelectOptions();

        return $this->respondWithSuccess(__('Auth roles fetched successfully'), $roles);
    }


    /**
     * Get Admin Roles
     *
     * @return JsonResponse
     */
    public function getAdminRoles(): JsonResponse
    {
        $roles = $this->commandBus->execute(new GetActiveRoles());

        return $this->respondWithSuccess(__('Admin roles fetched successfully'), $roles);
    }


    /**
     * Get Active Salespersons
     *
     * @return JsonResponse
     */
    public function getActiveSalespersons(): JsonResponse
    {
        $salespersons = $this->commandBus->execute(new GetActiveSalespersons());

        return $this->respondWithSuccess(__('Salespersons fetched successfully'), $salespersons);
    }

}
