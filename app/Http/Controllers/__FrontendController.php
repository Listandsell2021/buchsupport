<?php

namespace App\Http\Controllers;


use App\DataHolders\Enum\CallUserType;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Requests\Frontend\CreateBookInquiryRequest;
use App\Http\Requests\Frontend\CreateGuestInquiryRequest;
use App\Models\CallUser;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Rosamarsky\CommandBus\CommandBus;

class __FrontendController extends Controller
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
    public function getHomePageData(Request $request): JsonResponse
    {
        $latestProducts = Product::withDetails()
            ->orderBy('user_products.id', 'desc')
            ->take(8)
            ->get();

        $reviews = json_decode(file_get_contents(storage_path('data/reviews.json')));

        return $this->respondWithSuccess(trans('frontend data fetched successfully'), compact('latestProducts', 'reviews'));
    }



    /**
     * Get Filtered Customers
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getFilteredCustomers(Request $request): JsonResponse
    {
        $customers = $this->searchCustomers($request, 12);

        return $this->respondWithSuccess(trans('customers fetched successfully'), $customers);
    }


    /**
     * Get Filtered Products
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getFilteredProducts(Request $request): JsonResponse
    {
        $products = $this->searchProducts($request,40);

        return $this->respondWithSuccess( 'Successfully fetched Customers', $products);
    }


    /**
     * Create Guest Inquiry
     *
     * @param CreateGuestInquiryRequest $request
     * @return JsonResponse
     */
    public function createGuestInquiry(CreateGuestInquiryRequest $request): JsonResponse
    {
        $firstName = $request->get('first_name');
        $lastName = $request->get('last_name');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $price = $request->get('price');
        $bookUser = User::find($request->get('user_id'));
        $product = Product::find($request->get('product_id'));
        $title = $product->title;

        $note = "$firstName $lastName interessiert sich für das Werk \"$title\" von $bookUser->first_name $bookUser->last_name ($bookUser->id)";

        CallUser::create([
            'note'      => $note,
            'type'      => CallUserType::buy_product->name,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone'     => $phone,
            'email'     => $email,
            'price'     => $price,
        ]);

        return $this->respondWithSuccess( 'Inquiry requested successfully');
    }


    /**
     * Create Book Inquiry
     *
     * @param CreateBookInquiryRequest $request
     * @return JsonResponse
     */
    public function createBookInquiry(CreateBookInquiryRequest $request): JsonResponse
    {
        $first_name = $request->get('first_name');
        $last_name = $request->get('last_name');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $price = $request->get('price');
        $product = Product::find($request->get('product_id'));

        $note = $first_name." ".$last_name. " interessiert sich für das Werk ".$product->title;

        CallUser::create([
            'note' => $note,
            'type' => 'buy_product',
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone' => $phone,
            'email' => $email,
            'price' => $price,
        ]);

        return $this->respondWithSuccess( 'Book inquired successfully');
    }
    

    private function searchCustomers(Request $request, $paginationNo)
    {
        $hasFilter = $request->get('is_filtering');
        $hasSorting = $request->get('is_sorting');

        $filters = [
            'membership_ids' => '',
            'product_range_min' => '',
            'product_range_max' => '',
            'sort_by' => 'users.membership_id',
            'sort_order' => 'desc',
        ];

        if ($hasFilter) {
            $filters['product_range_min'] = (int)$request->get('product_range')[0];
            $filters['product_range_max'] = (int)$request->get('product_range')[1];
            $filters['membership_ids'] = (array) $request->get('membership_ids');
        }

        if ($hasSorting) {
            $filters['sort_by'] = in_array($request->get('sort_by'), ['products_count']) ? $request->get('sort_by') : $filters['sort_by'];
            $filters['sort_order'] = in_array($request->get('sort_order'), ['asc', 'desc']) ? $request->get('sort_order') : $filters['sort_order'];
        }

        $customers = User::with(['products' => function($query) {
            $query->where('user_products.status', 1)->where('user_products.is_hidden', 0);
        }, 'products.images', 'products.category'])
            ->withCount(['products' => function($query){
                $query->where('user_products.status', 1)->where('user_products.is_hidden', 0);
            }])
            ->having('products_count', '>', 0)
            ->where(function ($query) use ($filters, $hasFilter, $hasSorting, $request) {
                if (!empty($request->get('search_key'))) {
                    $query->where('users.uid', 'LIKE', '%' . str_replace(' ', '', $request->get('search_key')) . '%');
                }
                if (!empty($filters['membership_ids'])) {
                    $query->whereIn('users.membership_id', $filters['membership_ids']);
                }
            });

        if ($hasFilter) {
            if (!empty($filters['product_range_min']) && !empty($filters['product_range_max'])) {
                $customers->having('products_count', '>=', $filters['product_range_min']);
                $customers->having('products_count', '<=', $filters['product_range_max']);
            }
        }

        if ($hasSorting) {
            if (!empty($filters['sort_by'])) {
                $customers->orderBy($filters['sort_by'], $filters['sort_order']);
            }
            $customers->orderBy('users.is_special', 'DESC');
        }

        return $customers->paginate($paginationNo);
    }



    /**
     * Search Products
     *
     * @param Request $request
     * @param $paginationNo
     * @return mixed
     */
    private function searchProducts(Request $request,$paginationNo): mixed
    {
        $hasFilter = $request->get('is_filtering');
        $hasSorting = $request->get('is_sorting');

        $filters = [
            'category_ids' => [],
            'sort_by' => 'products.name',
            'sort_order' => 'asc',
        ];
        if ($hasFilter) {
            $filters['category_ids'] = (array) $request->get('category_ids');
        }

        if ($hasSorting) {
            $filters['sort_by'] = in_array($request->get('sort_by'), ['product_categories.name']) ? $request->get('sort_by') : $filters['sort_by'];
            $filters['sort_order'] = in_array($request->get('sort_order'), ['asc', 'desc']) ? $request->get('sort_order') : $filters['sort_order'];
        }

        $products = Product::select([
            'products.id', 'products.id as product_id', 'products.category_id', 'products.name as product_name',
            'products.description', 'products.youtube_link', 'product_categories.id as category_id',
            'product_categories.name as category_name'
        ])
            ->leftJoin('product_categories', 'products.category_id', 'product_categories.id')
            ->with('images')
            ->where(function ($query) use ($filters, $hasFilter, $hasSorting, $request) {
                $query->where('products.name', 'LIKE', '%' . $request->get('search_key') . '%');
                if ($hasFilter) {
                    if (count($filters['category_ids']) > 0) {
                        $query->whereIn('products.category_id', $filters['category_ids']);
                    }
                }
            });

        if ($hasSorting) {
            if (!empty($filters['sort_by'])) {
                $products->orderBy($filters['sort_by'], $filters['sort_order']);
            }
        }

        return $products->paginate($paginationNo);
    }

}
