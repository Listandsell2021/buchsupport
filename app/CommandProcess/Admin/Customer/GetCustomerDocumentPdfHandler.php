<?php

namespace App\CommandProcess\Admin\Customer;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;
use Barryvdh\DomPDF\Facade\Pdf;

class GetCustomerDocumentPdfHandler implements Handler
{
    const PRODUCTS_PER_PAGE = 11;
    const NEXT_PAGE_PRODUCTS_PER_PAGE = 18;

    /**
     * @throws ValidationException
     */
    public function handle(Command $command)
    {
        $userDetail = User::select([
            '*',
            DB::raw('(SELECT SUM(user_products.price) FROM user_products WHERE user_id = users.id) as total_price'),
            DB::raw('(SELECT AVG(user_products.price) FROM user_products WHERE user_id = users.id) as average_price'),
            DB::raw('(SELECT AVG(user_products.condition) FROM user_products WHERE user_id = users.id) as average_condition')
        ])
            ->with('products', 'products.category')
            ->withCount('products')
            ->where('id', $command->userId)
            ->first();

        if (!$userDetail) {
            throw ValidationException::withMessages(['user' => trans('Customer detail not available')]);
        }

        $estimatedTotalProductsInNextPage = $userDetail->products_count - self::PRODUCTS_PER_PAGE;

        if ($estimatedTotalProductsInNextPage <= 0) {
            $totalPage = 1;
        } else {
            $estimatedPage = 1 + (int) ($estimatedTotalProductsInNextPage / self::NEXT_PAGE_PRODUCTS_PER_PAGE);
            $totalPage = ($estimatedTotalProductsInNextPage % self::NEXT_PAGE_PRODUCTS_PER_PAGE) == 0 ? $estimatedPage : ($estimatedPage + 1);
        }

        $pdf = Pdf::loadView('admin.pdf.customer_welcome_registration', [
            'user'              => $userDetail,
            'productCount'      => $userDetail->products_count,
            'sumProducts'       => getNumberInGermanFormat($userDetail->total_price),
            'avgPrice'          => getNumberInGermanFormat($userDetail->average_price),
            'avgCondition'      => $this->numberFormatWhenFloat($userDetail->average_condition),
            'firstPageProducts' => $userDetail->products->slice(0, self::PRODUCTS_PER_PAGE),
            'afterPageProducts' => $userDetail->products->slice(self::PRODUCTS_PER_PAGE),
            'totalPage'         => $totalPage
        ]);

        return $pdf->download();
    }


    private function numberFormatWhenFloat($number): int|string
    {
        $val = trimTrailingZeroes($number) + 0;
        if (is_int($val)) {
            return $val;
        }
        return getNumberInGermanFormat($val);
    }
}
