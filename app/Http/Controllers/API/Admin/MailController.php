<?php

namespace App\Http\Controllers\API\Admin;


use App\CommandProcess\Admin\Mail\GetFilteredMails;
use App\CommandProcess\Admin\Mail\GetMail;
use App\CommandProcess\Admin\Mail\UpdateMail;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Mail\UpdateMailRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Rosamarsky\CommandBus\CommandBus;


class MailController extends Controller
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
        $mails = $this->commandBus->execute(new GetFilteredMails($request->all()));

        return $this->respondWithSuccess(trans('Mail list fetched successfully'), $mails);
    }


    /**
     * Display the specified resource.
     *
     * @param $leadId
     * @return JsonResponse
     */
    public function show($leadId)
    {
        $mail = $this->commandBus->execute(new GetMail((int) $leadId));

        return $this->respondWithContentOnly($mail);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMailRequest $request
     * @param $mailId
     * @return JsonResponse
     */
    public function update(UpdateMailRequest $request, $mailId): JsonResponse
    {
        $this->commandBus->execute(new UpdateMail((int) $mailId, $request->all()));

        return $this->respondUpdated(__('Mail updated successfully'));
    }

    
}
