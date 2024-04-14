<?php

namespace App\Services\Admin;

use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CustomerService
{

    /**
     * Get all records.
     *
     * @return mixed
     */
    public function searchAndPaginate(array $data): mixed
    {
        $filters = $data['filters'] ?? [];

        $query = User::select('users.*', DB::raw('cast(users.registered_at as DATE) as registered_at'))
            ->where(function ($query) use ($filters) {
                if (hasInput($filters['uid'] ?? '')) {
                    $query->where('users.uid', 'LIKE', '%' . removeSpace($filters['uid']) . '%');
                }
                if (hasInput($filters['name'] ?? '')) {
                    $query->where(
                        DB::raw("CONCAT_WS(' ', users.first_name, users.last_name)"), 'LIKE', '%' . $filters['name'] . '%'
                    );
                }
                if (hasInput($filters['street'] ?? '')) {
                    $query->where('users.street', 'LIKE', '%' . $filters['street'] . '%');
                }
                if (hasInput($filters['postal_code_start'] ?? '')) {
                    $query->where('users.postal_code', '>=', $filters['postal_code_start']);
                }
                if (hasInput($filters['postal_code_end'] ?? '')) {
                    $query->where('users.postal_code', '<=', $filters['postal_code_end']);
                }
                if (hasInput($filters['city'] ?? '')) {
                    $query->where('users.city', 'LIKE', '%' . $filters['city'] . '%');
                }
                if (hasInput($filters['is_active'] ?? '')) {
                    $query->where('users.is_active', (int)$filters['is_active']);
                }
            })
            ->sorting([
                'users.uid', 'users.first_name', 'users.street', 'users.postal_code', 'users.city', 'users.dob',
                'users.registered_at', 'products_count', 'users.is_active',
            ], 'users.id', 'desc');

        return $query->paginate(getPerPageTotal());
    }


    /**
     * Get specific record by id.
     *
     * @param int $id
     * @return mixed
     */
    public function getById(int $id): mixed
    {
        return User::with('orders')->where('id', $id)->first();
    }

    /**
     * Store data to database.
     *
     * @param array $data
     * @return User
     */
    public function save($data)
    {
        $data['password_text'] = $data['password'];
        $data['password'] = bcrypt($data['password']);
        $uid = (int) User::max('uid');
        $data['uid'] = ++$uid;
        $data['registered_at'] = getCurrentDateTime();

        return User::create($data);
    }

    /**
     * Update specific record to database.
     *
     * @param int $customerId
     * @param array $data
     * @return void
     */
    public function update(int $customerId, array $data): void
    {
        $data['dob'] = getGlobalDate($data['dob']);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password_text'] = $data['password'];
            $data['password'] = bcrypt($data['password']);
        }

        User::where('id', $customerId)->update( Arr::only($data, User::fillableProps()) );
    }


    /**
     * Delete specific record.
     *
     * @param int $customerId
     * @return void
     */
    public function delete(int $customerId): void
    {
        User::where('id', $customerId)->delete();
    }

    /**
     * Delete specific record.
     *
     * @param array $customerIds
     * @return void
     */
    public function deleteBulk(array $customerIds): void
    {
        User::whereIn('id', $customerIds)->delete();
    }

    /**
     * Update Active Status
     *
     * @param int $customerId
     * @param int $isActive
     * @return void
     */
    public function updateActiveStatus(int $customerId, int $isActive): void
    {
        User::where('id', $customerId)->update(['is_active' => $isActive]);
    }

    /**
     * Bulk Update Active Status
     *
     * @param array $customerIds
     * @param int $isActive
     * @return void
     */
    public function updateBulkActiveStatus(array $customerIds, int $isActive): void
    {
        User::whereIn('id', $customerIds)->update(['is_active' => $isActive]);
    }


    /**
     * Update Invoice Settings
     *
     * @param int $customerId
     * @param array $data
     * @return void
     */
    public function updateInvoiceSetting(int $customerId, array $data): void
    {
        User::where('id', $customerId)->update([
            'auto_invoice' => (int) $data['auto_invoice'],
            'auto_invoice_date' => (int) $data['auto_invoice_date']
        ]);
    }


    /**
     * Get Active Customers
     *
     * @param array $filters
     * @return mixed
     */
    public function searchCustomers(array $filters): mixed
    {
        return User::select('users.*', DB::raw("CONCAT_WS(' ', users.first_name, users.last_name) as name"))
            ->where(function ($query) use ($filters) {
            if (hasInput($filters['name'] ?? '')) {
                $query->where(
                    DB::raw("CONCAT_WS(' ', users.first_name, users.last_name)"), 'LIKE', '%' . $filters['name'] . '%'
                );
            }
        })
            ->where('users.is_active', 1)
            ->orderBy('users.first_name')
            ->get();
    }


    /**
     * Get Products By Customer
     *
     * @param int $customerId
     * @return mixed
     */
    public function getProductsByCustomer(int $customerId): mixed
    {
        return Service::select('products.*', 'user_products.price', 'user_products.id as user_product_id')
            ->join('user_products', 'products.id', 'user_products.product_id')
            ->where('user_products.user_id', $customerId)
            ->orderBy('user_products.position')
            ->get();
    }




    /**
     * Get Customer Contract
     *
     * @param int $customerId
     * @return mixed
     */
    public function getContractByCustomerId(int $customerId): mixed
    {
        return UserContract::where('user_id', $customerId)->first();
    }



}