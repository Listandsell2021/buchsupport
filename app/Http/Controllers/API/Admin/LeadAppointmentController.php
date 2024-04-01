<?php

namespace App\Http\Controllers\API\Admin;

use App\CommandProcess\Admin\LeadAppointment\DeleteLeadAppointment;
use App\CommandProcess\Admin\LeadAppointment\GetFilteredLeadAppointments;
use App\CommandProcess\Admin\LeadAppointment\GetLeadAppointment;
use App\CommandProcess\Admin\LeadAppointment\StoreLeadAppointment;
use App\CommandProcess\Admin\LeadAppointment\UpdateLeadAppointment;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LeadAppointment\CreateLeadAppointmentRequest;
use App\Http\Requests\Admin\LeadAppointment\DeleteLeadAppointmentRequest;
use App\Http\Requests\Admin\LeadAppointment\UpdateLeadAppointmentRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Rosamarsky\CommandBus\CommandBus;

class LeadAppointmentController extends Controller
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
    public function listAll(Request $request): JsonResponse
    {
        $appointments = $this->commandBus->execute(new GetFilteredLeadAppointments((int) $request->get('lead_id')));

        return $this->respondWithSuccess(trans('Lead Appointment fetched successfully'), $appointments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateLeadAppointmentRequest $request
     * @return JsonResponse
     */
    public function store(CreateLeadAppointmentRequest $request): JsonResponse
    {
        $appointment = $this->commandBus->execute( new StoreLeadAppointment($request->all()) );

        return $this->respondCreated(__('Lead Appointment created successfully'), $appointment);
    }

    /**
     * Display the specified resource.
     *
     * @param $appointmentId
     * @return JsonResponse
     */
    public function show($appointmentId)
    {
        $category = $this->commandBus->execute(new GetLeadAppointment((int) $appointmentId));

        return $this->respondWithContentOnly($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLeadAppointmentRequest $request
     * @return JsonResponse
     */
    public function update(UpdateLeadAppointmentRequest $request): JsonResponse
    {
        $this->commandBus->execute(new UpdateLeadAppointment((int) $request->get('id'), $request->all()));

        return $this->respondUpdated(__('Lead Appointment updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteLeadAppointmentRequest $request
     * @return JsonResponse
     */
    public function destroy(DeleteLeadAppointmentRequest $request): JsonResponse
    {
        $this->commandBus->execute(new DeleteLeadAppointment((int) $request->get('appointment_id')));

        return $this->respondWithSuccess(__('Lead Appointment deleted successfully'));
    }


}
