<?php

namespace App\Http\Controllers\API\Customer;


use App\CommandProcess\Admin\Dashboard\GetDashboardCards;
use App\CommandProcess\Customer\Profile\GetUserDetail;
use App\CommandProcess\Customer\Profile\UpdateUserDetail;
use App\CommandProcess\Customer\Profile\UpdateUserPassword;
use App\CommandProcess\Customer\Profile\UploadProfileImage;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Profile\UpdateProfileImageRequest;
use App\Http\Requests\Customer\Profile\UpdateUserDetailRequest;
use App\Http\Requests\Customer\Profile\UpdateUserPasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Rosamarsky\CommandBus\CommandBus;

class ProfileController extends Controller
{
    use ApiResponseHelpers;

    protected CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }


    /**
     * Get User Detail
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getUserDetail(Request $request): JsonResponse
    {
        $user = $this->commandBus->execute(new GetUserDetail((int) $request->get('user_id')));

        return $this->respondWithContentOnly($user);
    }


    /**
     * Update User Profile
     *
     * @param UpdateUserDetailRequest $request
     * @return JsonResponse
     */
    public function updateUserDetail(UpdateUserDetailRequest $request): JsonResponse
    {
        $this->commandBus->execute(new UpdateUserDetail($request->all()));

        $user = $this->commandBus->execute(new GetUserDetail((int) $request->get('id')));

        return $this->respondWithSuccess(trans('Profile updated successfully'), $user);
    }


    /**
     * Update User Password
     *
     * @param UpdateUserPasswordRequest $request
     * @return JsonResponse
     */
    public function updateUserPassword(UpdateUserPasswordRequest $request): JsonResponse
    {
        $this->commandBus->execute(new UpdateUserPassword($request->get('user_id'), $request->get('password')));

        return $this->respondWithSuccess(trans('Password updated successfully'));
    }

    /**
     * Update User Profile
     *
     * @param UpdateProfileImageRequest $request
     * @return JsonResponse
     */
    public function uploadProfileImage(UpdateProfileImageRequest $request): JsonResponse
    {
        $this->commandBus->execute(new UploadProfileImage($request->get('user_id'), $request->file('image')));

        return $this->respondWithSuccess(trans('Profile image updated successfully'));
    }



}
