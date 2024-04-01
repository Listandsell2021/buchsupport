<?php

namespace App\CommandProcess\Admin\Dashboard;

use App\Models\Lead;
use App\Models\LeadContract;
use Illuminate\Support\Facades\DB;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;
use function Sodium\add;

class GetSalespersonsCommissionGraphHandler implements Handler
{

    public function handle(Command $command)
    {
        $dateFrom = $this->getThisMonthStartingDate();
        $dateTo = $this->getThisMonthEndingDate();

        if (isDate($command->dateFrom) && isDate($command->dateTo)) {
            $dateFrom = getGlobalDate($command->dateFrom);
            $dateTo = getGlobalDate($command->dateTo);
        }

        $contracts = LeadContract::select(
            DB::raw('SUM(lead_contract_products.price) as contract_price'),
            DB::raw('DATE(leads.converted_at) as converted_at')
        )
            ->join('leads', 'lead_contracts.lead_id', 'leads.id')
            ->join('lead_contract_products', 'lead_contracts.id', 'lead_contract_products.contract_id')
            ->where(function ($query) use ($command) {
                if (count($command->salespersonIds) > 0) {
                    $query->whereIn('leads.salesperson_id', $command->salespersonIds);
                }
            })
            ->where('leads.is_converted', 1)
            ->groupBy(DB::raw('DATE(leads.converted_at)'))
            ->whereBetween(DB::raw('DATE(leads.converted_at)'), [$dateFrom, $dateTo])
            ->get();

        $data = $this->getData($contracts, $dateFrom, $dateTo);

        return [
            'labels'    => $data['labels'],
            'datasets'  => $data['datasets'],
        ];
    }


    public function getData($data, $from, $to): array
    {
        $weeklyDates = $this->getSegmentedDates($from, $to);
        //dd($weeklyDates);

        foreach ($weeklyDates as $index=>$weeklyDate) {
            $price = 0;
            foreach ($data as $datum) {
                if (in_array($datum->converted_at, $weeklyDate['dates'])) {
                    $price += $datum->contract_price;
                }
            }
            $weeklyDates[$index]['price'] = $price;
            $weeklyDates[$index]['__label'] = $this->getDateRangeText($weeklyDate['date_from'], $weeklyDate['date_to']);
        }

        $datasets[0]['label'] = __('Commission');
        $datasets[0]['backgroundColor'] = '#56d798';
        $labels = [];

        foreach ($weeklyDates as $weeklyDate) {
            $labels[] = $weeklyDate['__label'];
            $datasets[0]['data'][] = [
                'x'     => 0,
                'y'     => $weeklyDate['price'],
                'price' => $weeklyDate['price'],
            ];
        }

        return [
            'labels'    => $labels,
            'datasets'  => $datasets,
        ];
    }


    /**
     * Get Dates
     *
     */
    public function getSegmentedDates(string $from, string $to): array
    {
        $to = date(getGlobalDateFormat(), strtotime($to . ' +1 day'));

        $period = new \DatePeriod(
            new \DateTime($from),
            new \DateInterval('P1D'),
            new \DateTime($to),
        );

        $data = [];

        foreach ($period as $date) {
            $key = $date->format('Y').'_'.$date->format('n'); //$date->format('W')
            $data[$key]['dates'][] = $date->format('Y-m-d');
            $data[$key]['date_from'] = min($data[$key]['dates']);
            $data[$key]['date_to'] = max($data[$key]['dates']);
        }

        return $data;
    }

    public function getDateRangeText($dateFrom, $dateTo): string
    {
        $dateFrom = new \DateTime($dateFrom);
        $dateTo = new \DateTime($dateTo);

        $dateFromMonth = '';
        $dateToMonth = '';

        foreach (getMonths() as $monthNo => $monthName) {
            if ($monthNo == (int) $dateFrom->format('m')) {
                $dateFromMonth = ucfirst($monthName);
            }
            if ($monthNo == (int) $dateTo->format('m')) {
                $dateToMonth = ucfirst($monthName);
            }
        }

        if ($dateFromMonth == $dateToMonth) {
            return $dateFrom->format('d').'-'.$dateTo->format('d').' '.$dateToMonth.' '.$dateFrom->format('Y');
        }

        return $dateFrom->format('d').' '.$dateFromMonth.' - '.$dateTo->format('d').' '.$dateToMonth.' '.$dateFrom->format('Y');
    }


    /**
     * Get this month starting date
     */
    private function getThisMonthStartingDate(): string
    {
        return date('Y-m-01');
    }

    /**
     * Get this month ending date
     */
    private function getThisMonthEndingDate(): string
    {
        return date('Y-m-t');
    }


}
