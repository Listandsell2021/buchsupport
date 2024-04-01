<?php

namespace App\Http\Controllers\API\Admin;


use App\CommandProcess\Admin\Mail\GetFilteredMails;
use App\CommandProcess\Admin\Setting\GetSettings;
use App\CommandProcess\Admin\Setting\UpdateSettings;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\UpdateSettingRequest;
use App\Libraries\Settings\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Rosamarsky\CommandBus\CommandBus;


class SettingController extends Controller
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
    public function list(Request $request)
    {
        $settings = $this->commandBus->execute(new GetSettings($request->all()));

        return $this->respondWithSuccess(trans('Settings fetched successfully'), $settings);
    }


    /**
     * Update Setting
     *
     * @param UpdateSettingRequest $request
     * @return JsonResponse
     */
    public function update(UpdateSettingRequest $request): JsonResponse
    {
        $this->commandBus->execute(new UpdateSettings($request->all()));
        Setting::reset();

        return $this->respondWithSuccess('Settings updated successfully');
    }

    
}
