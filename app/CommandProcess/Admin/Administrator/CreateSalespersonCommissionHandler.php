<?php

namespace App\CommandProcess\Admin\Administrator;

use App\DataHolders\Enum\OrderStatus;
use App\Libraries\AdminCommission\SalespersonCommission;
use App\Libraries\Settings\Setting;
use App\Models\Admin;
use App\Models\AdminCommission;
use App\Models\Invoice;
use App\Models\LeadContract;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\CommandBus;
use Rosamarsky\CommandBus\Handler;

class CreateSalespersonCommissionHandler implements Handler
{

    public function __construct()
    {

    }

    public function handle(Command $command)
    {
        $dateFrom = $command->dateFrom;
        $dateTo = $command->dateTo;

        if (isDate($command->dateFrom) && isDate($command->dateTo)) {
            $dateFrom = getGlobalDate($command->dateFrom);
            $dateTo = getGlobalDate($command->dateTo);
        }

        if (!File::isDirectory(getAdminCommissionStorageAbsolutePath())) {
            File::makeDirectory(getAdminCommissionStorageAbsolutePath());
        }

        $orderQuery = Order::select('orders.id', 'orders.subtotal as total',
            DB::raw('DATE(orders.order_at) as order_at'),
            'users.first_name', 'users.last_name'
        )
            ->join('users', 'orders.user_id', 'users.id')
            ->where('orders.admin_id', $command->adminId)
            ->where('orders.commissioned', 0)
            //->where('orders.status', OrderStatus::paid->name)
            ;

        $currentOrders = $orderQuery->clone()->whereBetween('order_at', [$dateFrom, $dateTo])->get();
        $previousUnpaidOrders = $orderQuery->clone()->where('order_at', '<', $dateFrom)->get();

        $orders = $currentOrders->merge($previousUnpaidOrders);

        if ($orders->count() == 0) {
            return false;
        }

        $success = true;
        $commission = null;
        $admin = Admin::find($command->adminId);
        $pdfName = getDateInGermany($dateFrom).'_'.getDateInGermany($dateTo).'-'.$admin->fullname().'.pdf';

        DB::beginTransaction();

        try {

            $salespersonCommission = new SalespersonCommission($command->adminId, $orders->toArray(), $dateFrom, $dateTo);
            $commission = $salespersonCommission->saveToDatabase();
            $setting = Setting::all();
            //$check = true;
            $pdf = Pdf::loadView('admin.commission.salesperson_commission', compact('setting', 'orders', 'commission', 'admin'));
            //return view('admin.commission.salesperson_commission', compact('setting', 'orders', 'commission', 'admin', 'check'));
            $pdf->save(getAdminCommissionStorageAbsolutePath($pdfName));
            AdminCommission::where('id', $commission->id)->update(['document' => $pdfName]);
            Order::whereIn('id', $orders->pluck('id'))->update(['commissioned' => 1]);
            DB::commit();
        } catch (\Exception $e) {
            if ($commission) {
                if (File::exists(getAdminCommissionStorageAbsolutePath($pdfName))) {
                    File::delete(getAdminCommissionStorageAbsolutePath($pdfName));
                }
            }

            dd($e);

            $success = false;
            DB::rollback();
        }

        return $success;
     }
}
