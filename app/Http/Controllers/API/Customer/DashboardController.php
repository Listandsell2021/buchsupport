<?php

namespace App\Http\Controllers\API\Customer;


use App\CommandProcess\Customer\Dashboard\CreateUserComment;
use App\CommandProcess\Customer\Dashboard\FilterUserProducts;
use App\CommandProcess\Customer\Dashboard\GetDashboardCards;
use App\CommandProcess\Customer\Dashboard\GetUserComments;
use App\CommandProcess\Customer\Dashboard\GetUserProductCategories;
use App\CommandProcess\Customer\Dashboard\ReverseProductView;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Dashboard\CreateCommentRequest;
use App\Http\Requests\Frontend\CreateUserBookInquiryRequest;
use App\Models\CallUser;
use App\Models\Product;
use App\Models\User;
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
        $cards = $this->commandBus->execute(new GetDashboardCards((int) $request->get('user_id')));

        return $this->respondWithSuccess(trans('Dashboard details fetched successfully'), $cards);
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getProductCategories(Request $request): JsonResponse
    {
        $categories = $this->commandBus->execute(new GetUserProductCategories((int) $request->get('user_id')));

        return $this->respondWithSuccess(trans('Categories fetched successfully'), $categories);
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function searchProducts(Request $request): JsonResponse
    {
        $cards = $this->commandBus->execute(new FilterUserProducts((int) $request->get('user_id')));

        return $this->respondWithSuccess(trans('Products fetched successfully'), $cards);
    }


    /**
     * Reverse Product View
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function reverseProductView(Request $request): JsonResponse
    {
        $isHidden = $this->commandBus->execute(new ReverseProductView((int) $request->get('user_product_id')));

        $message = 'Produkt ist jetzt sichtbar';
        if ($isHidden) {
            $message = 'Produkt ist jetzt ausgeblendet';
        }

        return $this->respondWithSuccess($message, $isHidden);
    }


    /**
     * Create User Comment
     *
     * @param CreateCommentRequest $request
     * @return JsonResponse
     */
    public function createUserComment(CreateCommentRequest $request): JsonResponse
    {
        $comment = $this->commandBus->execute(new CreateUserComment((string) $request->get('text')));

        return $this->respondWithSuccess(__('Comment created successfully'), $comment);
    }


    /**
     * Get User Comments
     *
     * @return JsonResponse
     */
    public function getUserComments(): JsonResponse
    {
        $comments = $this->commandBus->execute(new GetUserComments(getCustomerId()));

        return $this->respondWithSuccess(__('Comments fetched successfully'), $comments);
    }


    /**
     * Create User book inquiry
     *
     * @param CreateUserBookInquiryRequest $request
     * @return JsonResponse
     */
    public function createUserBookInquiry(CreateUserBookInquiryRequest $request): JsonResponse
    {
        $userOfSession = $request->user();
        $userFromBook = User::find($request->get('user_id'));
        $product = Product::find($request->get('product_id'));

        $note = "$userOfSession->first_name $userOfSession->last_name ($userOfSession->id)
        interessiert sich für das Werk \"$product->title\" von $userFromBook->first_name $userFromBook->last_name ($userFromBook->id)";

        CallUser::create([
            'user_id' => $userOfSession->id,
            'note' => $note,
            'type' => 'buy_product'
        ]);

        return $this->respondWithSuccess(__("We'll get back to you as soon as possible!"));
    }
}
