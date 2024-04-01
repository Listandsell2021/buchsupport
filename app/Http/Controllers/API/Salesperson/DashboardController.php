<?php

namespace App\Http\Controllers\API\Salesperson;


use App\CommandProcess\Salesperson\Dashboard\GetAdminAppointments;
use App\CommandProcess\Salesperson\Dashboard\GetAdminLeadActivities;
use App\CommandProcess\Salesperson\Dashboard\GetDashboardCards;
use App\CommandProcess\Salesperson\Dashboard\GetFilteredLeads;
use App\CommandProcess\Salesperson\Dashboard\GetLeadDetail;
use App\CommandProcess\Salesperson\Dashboard\GetUserProfile;
use App\CommandProcess\Salesperson\Dashboard\UpdateUserProfile;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Salesperson\User\UpdateUserProfileRequest;
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
     * @param Request $request
     * @return JsonResponse
     */
    public function getCardDetails(Request $request): JsonResponse
    {
        $cards = $this->commandBus->execute(new GetDashboardCards());

        return $this->respondWithSuccess(trans('Dashboard cards fetched successfully'), $cards);
    }

    /**
     * Get User Profile
     *
     * @return JsonResponse
     */
    public function getUserProfile(): JsonResponse
    {
        $user = $this->commandBus->execute(new GetUserProfile());

        return $this->respondWithSuccess(trans('User profile fetched successfully'), $user);
    }

    /**
     * Update User Profile
     *
     * @param UpdateUserProfileRequest $request
     * @return JsonResponse
     */
    public function updateUserProfile(UpdateUserProfileRequest $request): JsonResponse
    {
        $this->commandBus->execute(new UpdateUserProfile($request->all()));

        return $this->respondWithSuccess(trans('User profile update successfully'));
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getFilteredLeads(Request $request): JsonResponse
    {
        $leads = $this->commandBus->execute(new GetFilteredLeads());

        return $this->respondWithSuccess(trans('Leads fetched successfully'), $leads);
    }


    /**
     * Get Lead Detail
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getLeadDetail(Request $request): JsonResponse
    {
        $lead = $this->commandBus->execute(new GetLeadDetail((int) $request->get('lead_id')));

        return $this->respondWithSuccess(trans('Lead detail fetched successfully'), $lead);
    }
    

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAdminLeadActivities(Request $request): JsonResponse
    {
        $activities = $this->commandBus->execute(new GetAdminLeadActivities());

        return $this->respondWithSuccess(trans('Activities fetched successfully'), $activities);
    }

    /**
     * Get Admin Appointments
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAdminAppointments(Request $request): JsonResponse
    {
        $appointments = $this->commandBus->execute(new GetAdminAppointments());

        return $this->respondWithSuccess(trans('Appointments fetched successfully'), $appointments);
    }


    /**
     * Get Admin Appointments
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getContractProducts(Request $request): JsonResponse
    {
        $appointments = $this->commandBus->execute(new GetAdminAppointments());

        return $this->respondWithSuccess(trans('Appointments fetched successfully'), $appointments);
    }


}
