<?php

namespace App\Libraries\AdminCommission;

use App\Libraries\Settings\Setting;
use App\Models\AdminCommission;
use App\Models\AdminCommissionInvoice;

class SalespersonCommission
{

    protected int $adminId;
    protected array $invoices;
    protected array $unpaidCommission;
    protected string $dateFrom;
    protected string $dateTo;

    public function __construct(int $adminId, array $invoices, array $unpaidCommission, string $dateFrom, string $dateTo)
    {
        $this->adminId = $adminId;
        $this->invoices = $invoices;
        $this->unpaidCommission = $unpaidCommission;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }


    /**
     * Save to Database
     *
     * @return mixed
     */
    public function saveToDatabase(): mixed
    {
        /*$lastIncrementalNo = AdminCommission::max('incremental_no');
        $incrementalNo = ++$lastIncrementalNo;*/
        $incrementalNo = 1;

        $commission = AdminCommission::create([
            'admin_id'          => $this->adminId,
            'incremental_no'    => $incrementalNo,
            'commission_no'     => getAdminCommissionNo($incrementalNo),
            'commission_from'   => $this->dateFrom,
            'commission_to'     => $this->dateTo,
            'commission_date'   => getCurrentDate(),
            'total_gross'       => $this->getInvoiceTotal(),
            'subtotal'          => $this->getSubtotal(),
            'tax'               => $this->getTax(),
            'tax_total'         => $this->getTaxTotal(),
            'previous_commission_id' => $this->unpaidCommission['id'] ?? null,
            'previous_unpaid'   => $this->getPreviousUnpaidCommission(),
            'total'             => $this->getTotalPrice(),
            'paid'              => 0,
        ]);

        $data = [];
        foreach ($this->invoices as $invoice) {
            $data[] = ['invoice_id' => $invoice['id'], 'commission_id' => $commission->id];
        }

        if (count($data) > 0) {
            AdminCommissionInvoice::insert($data);
        }

        return $commission;
    }

    public function getTotalPrice(): float
    {
        return $this->getInvoiceTotal() - $this->getPreviousUnpaidCommission();
    }

    protected function getInvoiceTotal(): float
    {
        $total = 0;
        foreach ($this->invoices as $invoice) {
            $total += $invoice['total'];
        }
        return roundNumber($total);
    }

    protected function getPreviousUnpaidCommission(): float
    {
        return (float) ($this->unpaidCommission['total'] ?? 0);
    }

    protected function getTax(): float
    {
        return (float) Setting::getVatPercentage();
    }

    protected function getTaxTotal(): float
    {
        return round($this->getInvoiceTotal() - $this->getSubtotal());
    }

    protected function getSubtotal(): float
    {
        $total = $this->getInvoiceTotal();
        $tax = $this->getTax();
        return roundNumber(($total * 100) / (100 + $tax));
    }


}