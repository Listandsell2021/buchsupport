<?php

namespace App\Http\Controllers\API\Admin;

use App\CommandProcess\Admin\AdminRole\GetFilteredRoles;
use App\CommandProcess\Admin\AdminRole\UpdateRoleBulkAction;
use App\CommandProcess\Admin\Comment\UpdateCommentBulkAction;
use App\CommandProcess\Admin\Permission\GetAdminPermissions;
use App\CommandProcess\Admin\AdminRole\DeleteRole;
use App\CommandProcess\Admin\AdminRole\GetRoleAndPermissions;
use App\CommandProcess\Admin\AdminRole\StoreRole;
use App\CommandProcess\Admin\AdminRole\UpdateRole;
use App\CommandProcess\Admin\AdminRole\UpdateRoleActiveStatus;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Comment\UpdateCommentBulkActionRequest;
use App\Http\Requests\Admin\Roles\ChangeActiveStatusRequest;
use App\Http\Requests\Admin\Roles\CreateRoleRequest;
use App\Http\Requests\Admin\Roles\DeleteRoleRequest;
use App\Http\Requests\Admin\Roles\UpdateRoleBulkActionRequest;
use App\Http\Requests\Admin\Roles\UpdateRoleRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Rosamarsky\CommandBus\CommandBus;

class RoleController extends Controller
{
    use ApiResponseHelpers;

    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $roles = $this->commandBus->execute(new GetFilteredRoles());

        return $this->respondWithContentOnly($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRoleRequest $request
     * @return JsonResponse
     */
    public function store(CreateRoleRequest $request)
    {
        $role = $this->commandBus->execute(
            new StoreRole(
                (string) $request->get('name'),
                (int) $request->get('status'),
                (array) $request->get('permissions')
            )
        );

        return $this->respondCreated(__('New role created successfully'), $role);
    }

    /**
     * Display the specified resource.
     *
     * @param int $roleId
     * @return JsonResponse
     */
    public function show(int $roleId): JsonResponse
    {
        $role = $this->commandBus->execute(new GetRoleAndPermissions($roleId));

        return $this->respondWithContentOnly($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRoleRequest $request
     * @param $roleId
     * @return JsonResponse
     */
    public function update(UpdateRoleRequest $request, $roleId): JsonResponse
    {
        $this->commandBus->execute(
            new UpdateRole(
                (int) $roleId,
                (string) $request->get('name'),
                (int) $request->get('is_active'),
                (array) $request->get('permissions')
            )
        );

        return $this->respondUpdated(__('Admin role updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteRoleRequest $request
     * @param $roleId
     * @return JsonResponse
     */
    public function destroy(DeleteRoleRequest $request, $roleId)
    {
        $this->commandBus->execute(new DeleteRole((int) $roleId));

        return $this->respondOk(__('Admin role deleted successfully'));
    }


    /**
     * Change Active Status
     *
     * @param ChangeActiveStatusRequest $request
     * @return JsonResponse
     */
    public function changeActiveStatus(ChangeActiveStatusRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->commandBus->execute(new UpdateRoleActiveStatus((int) $request->get('role_id'), (int) $request->get('is_active')));

        return $this->respondOk(__('Admin role activated successfully'));
    }


    /**
     * Update Bulk Action
     *
     * @param UpdateRoleBulkActionRequest $request
     * @return JsonResponse
     */
    public function updateBulkAction(UpdateRoleBulkActionRequest $request): JsonResponse
    {
        $message = $this->commandBus->execute(
            new UpdateRoleBulkAction(
                (array) $request->get('data_ids'),
                (string) $request->get('action')
            )
        );

        return $this->respondWithSuccess($message);
    }


    /**
     * Get All Permissions
     *
     * @return JsonResponse
     */
    public function getAllPermissions(): JsonResponse
    {
        $permissions = $this->commandBus->execute(new GetAdminPermissions());

        return $this->respondWithSuccess(__('Permissions fetched successfully'), $permissions);
    }

}
