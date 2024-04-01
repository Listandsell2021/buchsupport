<?php

namespace App\Http\Controllers\API\Admin;

use App\CommandProcess\Admin\Comment\DeleteComment;
use App\CommandProcess\Admin\Comment\GetFilteredComments;
use App\CommandProcess\Admin\Comment\UpdateCommentApprovedStatus;
use App\CommandProcess\Admin\Comment\UpdateCommentBulkAction;
use App\Http\Requests\Admin\Comment\UpdateApprovedStatusRequest;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Comment\UpdateCommentBulkActionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Rosamarsky\CommandBus\CommandBus;


class CommentController extends Controller
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
        $comments = $this->commandBus->execute(new GetFilteredComments($request->all()));

        return $this->respondWithSuccess(trans('Comments fetched successfully'), $comments);
    }


    /**
     * Update Approved Status
     *
     * @param UpdateApprovedStatusRequest $request
     * @return JsonResponse
     */
    public function updateApprovedStatus(UpdateApprovedStatusRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->commandBus->execute(
            new UpdateCommentApprovedStatus(
                (int) $request->get('comment_id'),
                (int) $request->get('status')
            )
        );

        return $this->respondWithSuccess(__('Comment updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $commentId
     * @return JsonResponse
     */
    public function destroy($commentId): JsonResponse
    {
        $this->commandBus->execute(new DeleteComment((int) $commentId));

        return $this->respondWithSuccess(__('Comment deleted successfully'));
    }



    /**
     * Update Bulk Action
     *
     * @param UpdateCommentBulkActionRequest $request
     * @return JsonResponse
     */
    public function updateBulkAction(UpdateCommentBulkActionRequest $request): JsonResponse
    {
        $message = $this->commandBus->execute(
            new UpdateCommentBulkAction(
                (array) $request->get('data_ids'),
                (string) $request->get('action')
            )
        );

        return $this->respondWithSuccess($message);
    }


}
