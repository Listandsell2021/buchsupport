<?php


namespace App\Libraries\HelperTraits;


use App\DataHolders\Enum\Membership;
use App\Models\Service;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait LibraryHelper
{
    public function getProductWithDetails($hideHidden = 1)
    {
        $query = Service::select([
            'products.id', 'products.id as product_id', 'products.name as product_name', 'products.description', 'products.youtube_link',
            'user_products.quantity', 'user_products.condition', 'user_products.position', 'user_products.purchased_date', 'user_products.price', 'user_products.status',
            'user_products.is_hidden as is_hidden',
            'user_products.note as user_product_note', 'user_products.id as user_product_id',
            'user_products.user_id', 'product_categories.name as category_name', 'products.category_id'
        ])
            ->with('images')
            ->join('user_products', 'products.id', 'user_products.product_id')
            ->leftJoin('product_categories', 'products.category_id', 'product_categories.id')
            ->where('user_products.status', 1);

        if ($hideHidden) {
            return $query->where('user_products.is_hidden', 0);
        }
        return $query;
    }


    /**
     * Search Product Category By User Id
     *
     * @param $userId
     * @return mixed
     */
    public function searchProductCategoriesByUserId($userId): mixed
    {
        return ProductCategory::select('product_categories.id', 'product_categories.name')
            ->join('products', 'product_categories.id', 'products.category_id')
            ->join('user_products', 'products.id', 'user_products.product_id')
            ->where('user_products.user_id', $userId)
            ->groupBy('product_categories.id', 'product_categories.name');
    }


    public function getLibrariesQueryBuilder()
    {
        return User::select('users.id', 'users.uid', 'users.membership')->with(['products' => function($query) {
            $query->where('user_products.status', 1)->where('user_products.is_hidden', 0);
        }, 'products.images', 'products.category'])
            ->where('is_active', 1)
            ->withCount(['products' => function($query){
                $query->where('user_products.status', 1)->where('user_products.is_hidden', 0);
            }])
            ->having('products_count', '>', 0);
    }


    /**
     * Search Products
     *
     * @param array $requestData
     * @param int $paginationNo
     * @return mixed
     */
    public function searchProducts(array $requestData, int $paginationNo): mixed
    {
        Session::put('product_search_filters', $requestData);

        $hasFilter = request('is_filtering');
        $hasSorting = request('is_sorting');

        $filters = [
            'category_ids' => [],
            'sort_by' => 'products.name',
            'sort_order' => 'asc',
        ];

        if ($hasFilter) {
            $filters['category_ids'] = (array) request()->input('category_ids');
        }

        if ($hasSorting) {
            $filters['sort_by'] = in_array(request()->input('sort_by'), ['product_categories.name']) ? request()->input('sort_by') : $filters['sort_by'];
            $filters['sort_order'] = in_array(request()->input('sort_order'), ['asc', 'desc']) ? request()->input('sort_order') : $filters['sort_order'];
        }

        $products = Service::select([
            'products.id', 'products.id as product_id', 'products.category_id', 'products.name as product_name',
            'products.description', 'products.youtube_link', 'product_categories.id as category_id',
            'product_categories.name as category_name'
        ])
            ->leftJoin('product_categories', 'products.category_id', 'product_categories.id')
            ->with('images')
            ->where(function ($query) use ($filters, $hasFilter, $hasSorting) {
                $query->where('products.name', 'LIKE', '%' . request()->input('search_key') . '%');
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

    /**
     * Search Customers
     *
     * @param array $data
     * @param int $paginationNo
     * @return mixed
     */
    public function searchCustomers(array $data, int $paginationNo): mixed
    {
        Session::put('customer_search_filters', $data);

        $hasFilter = (bool) request()->input('is_filtering');
        $hasSorting = (bool) request()->input('is_sorting');

        /*foreach (request()->input('membership_ids') as $membership) {
            $membership = json_decode($membership, 1);
            if (isset($membership['value'])) {
                $filters['membership_ids'][] = $membership['value'];
            }
        }*/

        $filters = [
            'membership_ids' => '',
            'product_range_min' => '',
            'product_range_max' => '',
            'sort_by' => 'users.id',
            'sort_order' => 'desc',
        ];

        if ($hasFilter) {
            $filters['product_range_min'] = (int)request()->input('product_range')[0];
            $filters['product_range_max'] = (int)request()->input('product_range')[1];
            $filters['membership_ids'] = (array) request()->input('membership_ids');
        }

        if ($hasSorting) {
            $filters['sort_by'] = in_array(request()->input('sort_by'), ['products_count']) ? request()->input('sort_by') : $filters['sort_by'];
            $filters['sort_order'] = in_array(request()->input('sort_order'), ['asc', 'desc']) ? request()->input('sort_order') : $filters['sort_order'];
        }

        $customers = $this
            ->getLibrariesQueryBuilder()
            ->where(function ($query) use ($filters, $hasFilter, $hasSorting) {
                if (!empty(request()->input('search_key'))) {
                    $query->where('users.uid', 'LIKE', '%' . str_replace(' ', '', request()->input('search_key')) . '%');
                }
                if (isset($filters['membership_ids']) && is_array($filters['membership_ids']) && count($filters['membership_ids']) > 0) {
                    $query->whereIn('users.membership', $filters['membership_ids']);
                }
            });

        if ($hasFilter) {
            if (!empty($filters['product_range_min']) && !empty($filters['product_range_max'])) {
                $customers->having('products_count', '>=', $filters['product_range_min']);
                $customers->having('products_count', '<=', $filters['product_range_max']);
            }
        }

        $membershipOrder = sprintf("'%s'", implode("','", Membership::order()));
        $customers->orderBy('users.is_special', 'DESC');
        $customers->orderByRaw("FIELD(users.membership, ".$membershipOrder.")");

        if ($hasSorting) {
            if (!empty($filters['sort_by'])) {
                $customers->orderBy($filters['sort_by'], $filters['sort_order']);
            }
        }

        return $customers->paginate($paginationNo);
    }
}
