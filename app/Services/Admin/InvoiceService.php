<?php

namespace App\Services\Admin;

use App\Models\Invoice;
use App\Models\User;
use App\Models\UserProduct;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;


class InvoiceService
{

    /**
     * Get all records.
     *
     * @param array $data
     * @return mixed
     */
    public function searchAndPaginate(array $data): mixed
    {
        $filters = $data['filters'] ?? [];

        $query = Invoice::select('invoices.*',)
            ->where(function ($query) use ($filters) {
                if (hasInput($filters['invoice_no'] ?? '')) {
                    $query->where('invoices.invoice_no', 'LIKE', '%' . $filters['invoice_no'] . '%');
                }
                if (hasInput($filters['user_name'] ?? '')) {
                    $query->where('invoices.user_name', 'LIKE', '%' . $filters['user_name'] . '%');
                }
                if (hasInput($filters['invoice_date_from'] ?? '') && isDate($filters['invoice_date_from'])) {
                    $query->where('invoices.invoice_date', '>=', getGlobalDate($filters['invoice_date_from']));
                }
                if (hasInput($filters['invoice_date_to'] ?? '') && isDate($filters['invoice_date_to'])) {
                    $query->where('invoices.invoice_date', '<=', getGlobalDate($filters['invoice_date_to']));
                }
                if (hasInput($filters['is_paid'] ?? '')) {
                    $query->where('invoices.is_paid', (int)$filters['is_paid']);
                }
                if (hasInput($filters['is_cancelled'] ?? '')) {
                    $query->where('invoices.is_cancelled', (int)$filters['is_cancelled']);
                }
            })
            ->sorting([
                'invoices.invoice_no', 'invoices.user_name', 'invoices.invoice_date', 'invoices.grand_total_price',
                'invoices.is_paid', 'invoices.is_cancelled'
            ], 'invoices.id', 'desc');


        return $query->paginate(getPerPageTotal());
    }


    /**
     * Get Customer Detail
     *
     * @param int $customerId
     * @return mixed
     */
    public function getCustomerDetail(int $customerId): mixed
    {
        $user = User::select('users.*')
            ->where('users.id', $customerId)
            ->first();
        $userPivot = UserProduct::select(DB::raw('SUM(user_products.price) as product_price'))
            ->where('user_products.user_id', $customerId)
            ->first();
        $user->product_price = $userPivot->product_price;
        return $user;

    }


    /**
     * Create Invoice
     *
     * @param array $data
     * @return mixed
     */
    public function createInvoice(array $data): mixed
    {
        return Invoice::create(Arr::only($data, Invoice::fillableProps()));
    }


    /**
     * Get Incremental No
     *
     * @param string $year
     * @return int
     */
    public function getIncrementalNo(string $year): int
    {
        $incrementalNo = (int) Invoice::where('year', $year)->max('incremental_no');
        return ++$incrementalNo;
    }



    /**
     * Get Invoice By Id
     *
     * @param int $invoiceId
     * @return mixed
     */
    public function getById(int $invoiceId): mixed
    {
        return Invoice::where('id', $invoiceId)->first();
    }

    /**
     * Update Invoice
     *
     * @param int $invoiceId
     * @param array $data
     * @return bool
     */
    public function updateInvoice(int $invoiceId, array $data): bool
    {
        return (bool) Invoice::where('id', $invoiceId)->update(Arr::only($data, Invoice::fillableProps()));
    }

    /**
     * Set Invoice as Paid
     *
     * @param int $invoiceId
     * @return void
     */
    public function setAsPaid(int $invoiceId): void
    {
        Invoice::where('id', $invoiceId)->update(['is_paid' => 1]);
    }

    /**
     * Set invoices as paid
     *
     * @param array $invoiceIds
     * @return void
     */
    public function setBulkAsPaid(array $invoiceIds): void
    {
        Invoice::whereIn('id', $invoiceIds)->update(['is_paid' => 1]);
    }

    /**
     * Set Invoice as Unpaid
     *
     * @param int $invoiceId
     * @return void
     */
    public function setAsUnpaid(int $invoiceId): void
    {
        Invoice::where('id', $invoiceId)->update(['is_paid' => 0]);
    }

    /**
     * Set invoices as unpaid
     *
     * @param array $invoiceIds
     * @return void
     */
    public function setBulkAsUnpaid(array $invoiceIds): void
    {
        Invoice::whereIn('id', $invoiceIds)->update(['is_paid' => 0]);
    }


    /**
     * Delete Invoice
     *
     * @param int $invoiceId
     * @return void
     */
    public function delete(int $invoiceId): void
    {
        Invoice::where('id', $invoiceId)->delete();
    }


    /**
     * Delete Invoices
     *
     * @param array $invoiceIds
     * @return void
     */
    public function deleteBulk(array $invoiceIds): void
    {
        Invoice::whereIn('id', $invoiceIds)->delete();
    }


    /**
     * Create Payment Reminder
     *
     * @param int $invoiceId
     * @param string $reminderPath
     * @param string $reminderDate
     * @return void
     */
    public function createPaymentReminder(int $invoiceId, string $reminderPath, string $reminderDate): void
    {
        Invoice::where('id', $invoiceId)->update([
            'payment_reminder'      => 1,
            'payment_reminder_on'   => $reminderDate,
            'payment_reminder_path' => $reminderPath,
        ]);
    }


    /**
     * Create Payment Warning
     *
     * @param int $invoiceId
     * @param string $path
     * @param string $date
     * @return void
     */
    public function createPaymentWarning(int $invoiceId, string $path, string $date): void
    {
        Invoice::where('id', $invoiceId)->update([
            'payment_warning'      => 1,
            'payment_warning_on'   => $date,
            'payment_warning_path' => $path,
        ]);
    }

    /**
     * Cancel Invoice
     *
     * @param int $invoiceId
     * @param int $incrementalNo
     * @param $cancelledInvoiceNo
     * @param string $cancelledInvoicePath
     * @return void
     */
    public function cancelInvoice(int $invoiceId, int $incrementalNo, $cancelledInvoiceNo, string $cancelledInvoicePath): void
    {
        Invoice::where('id', $invoiceId)->update([
            'is_cancelled'          => 1,
            'cancelled_inc_no'      => $incrementalNo,
            'cancelled_invoice_no'  => $cancelledInvoiceNo,
            'cancelled_invoice_path' => $cancelledInvoicePath,
        ]);
    }



    /**
     * Get Cancelled Invoice Incremental No
     *
     * @return int
     */
    public function getCancelledIncrementalNo(): int
    {
        $incrementalNo = (int) Invoice::max('cancelled_inc_no');
        return ++$incrementalNo;
    }


}
