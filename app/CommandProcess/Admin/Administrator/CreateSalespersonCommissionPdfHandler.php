<?php

namespace App\CommandProcess\Admin\Administrator;

use App\Libraries\AdminCommission\SalespersonCommission;
use App\Libraries\Settings\Setting;
use App\Models\Admin;
use App\Models\AdminCommission;
use App\Models\Invoice;
use App\Models\LeadContract;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\CommandBus;
use Rosamarsky\CommandBus\Handler;

class CreateSalespersonCommissionPdfHandler implements Handler
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

        $invoices = Invoice::select('invoices.id', 'invoices.total', 'invoices.invoice_no', 'invoices.invoice_date',
            'leads.id as lead_id',
            'users.first_name', 'users.last_name'
        )
            ->join('users', 'invoices.user_id', 'users.id')
            ->join('leads', 'users.id', 'leads.converted_to')
            ->where('leads.salesperson_id', $command->adminId)
            ->whereBetween('invoices.invoice_date', [$dateFrom, $dateTo])
            ->get();

        $previousUnpaidInvoices = AdminCommission::where('admin_id', $command->adminId)
            ->where('paid', 0)
            ->orderBy('created_at', 'desc')
            ->first();

        $success = true;

        $commission = null;

        DB::beginTransaction();

        try {
            $salespersonCommission = new SalespersonCommission($command->adminId, $invoices->toArray(), $previousUnpaidInvoices ? $previousUnpaidInvoices->toArray() : [], $dateFrom, $dateTo);
            $commission = $salespersonCommission->saveToDatabase();

            $admin = Admin::find($command->adminId);
            $setting = Setting::all();
            $check = 1;
            $pdf = Pdf::loadView('admin.commission.customer_commission', compact('setting', 'invoices', 'commission', 'admin'));
            //return view('admin.commission.customer_commission', compact('setting', 'invoices', 'commission', 'admin', 'check'));

            $pdf->save(getAdminCommissionStorageAbsolutePath($commission->id.'.pdf'));

            $admin->wallet = roundNumber($commission->total);
            $admin->save();

            DB::commit();
        } catch (\Exception $e) {
            if ($commission) {
                if (File::exists(getAdminCommissionStorageAbsolutePath($commission->id.'.pdf'))) {
                    File::delete(getAdminCommissionStorageAbsolutePath($commission->id.'.pdf'));
                }
            }

            $success = false;
            DB::rollback();
        }

        return $success;
     }
}
