<?php

namespace App\Http\Controllers\API\Admin;


use App\CommandProcess\Admin\UserInquiry\DeleteUserInquiry;
use App\CommandProcess\Admin\UserInquiry\GetFilteredUserInquiries;
use App\CommandProcess\Admin\UserInquiry\UpdateUserInquiriesBulkAction;
use App\Http\Requests\Admin\UserInquiry\UpdateUserInquiriesBulkActionRequest;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Rosamarsky\CommandBus\CommandBus;


class UserInquiryController extends Controller
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
    public function index(Request $request): JsonResponse
    {
        $inquiries = $this->commandBus->execute(new GetFilteredUserInquiries($request->all()));

        return $this->respondWithSuccess(trans('User inquiries fetched successfully'), $inquiries);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param $inquiryId
     * @return JsonResponse
     */
    public function destroy($inquiryId): JsonResponse
    {
        $this->commandBus->execute(new DeleteUserInquiry((int) $inquiryId));

        return $this->respondWithSuccess(__('User inquiry deleted successfully'));
    }


    /**
     * Update Bulk Action
     *
     * @param UpdateUserInquiriesBulkActionRequest $request
     * @return JsonResponse
     */
    public function updateBulkAction(UpdateUserInquiriesBulkActionRequest $request): JsonResponse
    {
        $message = $this->commandBus->execute(
            new UpdateUserInquiriesBulkAction(
                (array) $request->get('data_ids'),
                (string) $request->get('action')
            )
        );

        return $this->respondWithSuccess($message);
    }





}
