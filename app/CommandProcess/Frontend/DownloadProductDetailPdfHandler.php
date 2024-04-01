<?php

namespace App\CommandProcess\Frontend;

use App\Models\LeadActivity;
use App\Models\LeadAppointment;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class DownloadProductDetailPdfHandler implements Handler
{
    const PRODUCTS_PER_PAGE = 11;
    const NEXT_PAGE_PRODUCTS_PER_PAGE = 18;


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
            return redirect()->back()->with(['message' => 'Could not fetch user data :'.$command->userId]);
        }

        $estimatedTotalProductsInNextPage = $userDetail->products_count - self::PRODUCTS_PER_PAGE;

        if ($estimatedTotalProductsInNextPage <= 0) {
            $totalPage = 1;
        } else {
            $estimatedPage = 1 + (int) ($estimatedTotalProductsInNextPage / self::NEXT_PAGE_PRODUCTS_PER_PAGE);
            $totalPage = ($estimatedTotalProductsInNextPage % self::NEXT_PAGE_PRODUCTS_PER_PAGE) == 0 ? $estimatedPage : ($estimatedPage + 1);
        }

        $pdf = Pdf::loadView('pdf', [
            'user'              => $userDetail,
            'productCount'      => $userDetail->products_count,
            'sumProducts'       => getNumberInGermanFormat($userDetail->total_price),
            'avgPrice'          => getNumberInGermanFormat($userDetail->average_price),
            'avgCondition'      => $this->numberFormatWhenFloat($userDetail->average_condition),
            'firstPageProducts' => $userDetail->products->slice(0, self::PRODUCTS_PER_PAGE),
            'afterPageProducts' => $userDetail->products->slice(self::PRODUCTS_PER_PAGE),
            'totalPage'         => $totalPage
        ]);

        return $pdf->stream('export.pdf');
    }

    private function numberFormatWhenFloat($number): int|string
    {
        $val = TrimTrailingZeroes($number) + 0;
        if (is_int($val)) {
            return $val;
        }
        return getNumberInGermanFormat($val);
    }
}
