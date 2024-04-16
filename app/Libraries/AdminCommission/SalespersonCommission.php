<?php

namespace App\Libraries\AdminCommission;

use App\Libraries\Settings\Setting;
use App\Models\AdminCommission;
use App\Models\AdminCommissionInvoice;
use App\Models\AdminOrderCommission;

class SalespersonCommission
{

    protected int $adminId;
    protected array $orders;
    protected string $dateFrom;
    protected string $dateTo;

    public function __construct(int $adminId, array $orders, string $dateFrom, string $dateTo)
    {
        $this->adminId = $adminId;
        $this->orders = $orders;
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
        $lastIncrementalNo = AdminCommission::max('incremental_no');
        $incrementalNo = ++$lastIncrementalNo;

        $commission = AdminCommission::create([
            'admin_id'          => $this->adminId,
            'incremental_no'    => $incrementalNo,
            'commission_no'     => getAdminCommissionNo($incrementalNo),
            'commission_from'   => $this->dateFrom,
            'commission_to'     => $this->dateTo,
            'commission_date'   => getCurrentDate(),
            'total_commission'  => $this->getTotalCommission(),
            'subtotal'          => $this->getSubtotal(),
            'tax'               => $this->getTax(),
            'tax_total'         => $this->getTaxTotal(),
            'total'             => $this->getTotalPrice(),
            'paid'              => 0,
        ]);

        $data = [];
        foreach ($this->orders as $order) {
            $data[] = ['order_id' => $order['id'], 'commission_id' => $commission->id];
        }

        if (count($data) > 0) {
            AdminOrderCommission::insert($data);
        }

        return $commission;
    }

    public function getTotalPrice(): float
    {
        return $this->getTotalCommission();
    }

    protected function getTotalCommission(): float
    {
        $total = 0;
        foreach ($this->orders as $order) {
            $total += $order['total'];
        }
        return roundNumber($total);
    }

    protected function getTax(): float
    {
        return (float) Setting::getVatPercentage();
    }

    protected function getTaxTotal(): float
    {
        return round($this->getTotalCommission() - $this->getSubtotal());
    }

    protected function getSubtotal(): float
    {
        $total = $this->getTotalCommission();
        $tax = $this->getTax();
        return roundNumber(($total * 100) / (100 + $tax));
    }


}