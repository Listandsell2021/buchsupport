<?php

namespace App\Console\Commands;

use App\CommandProcess\Admin\Invoice\CreateCustomerAutoInvoice;
use App\Libraries\Settings\Setting;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Console\Command;
use Rosamarsky\CommandBus\CommandBus;

class CustomerAutoInvoice extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:customers_invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create customers invoice';


    /**
     * Execute the console command.
     */
    public function handle(CommandBus $commandBus)
    {
        $customers = User::where('auto_invoice', 1)->get();

        foreach ($customers as $customer) {

            $hasInvoiceOfThisMonth = $this->getHasInvoiceOfThisMonth($customer->id);
            $isInvoiceDate = $this->isCustomerInvoiceDate((int) $customer->auto_invoice_date);

            if (!$hasInvoiceOfThisMonth && $isInvoiceDate) {
                $commandBus->execute( new CreateCustomerAutoInvoice($customer->id) );
            }
        }

        $this->info('Customers automatic invoice created Successfully');
    }




    /**
     * Is customer invoice date
     *
     * @param int $invoiceDate
     * @return bool
     */
    public function isCustomerInvoiceDate(int $invoiceDate): bool
    {
        $todayDate = (int) date('d');

        if ($invoiceDate == $todayDate) {
            return true;
        }

        $lastDate = date("t");

        if ($lastDate > $invoiceDate) {
            return true;
        }

        return false;
    }


    /**
     * Is Invoice Already created for this month
     *
     * @param $customerId
     * @return bool
     */
    private function getHasInvoiceOfThisMonth($customerId): bool
    {
        $hasInvoiceForThisMonth = false;

        $lastInvoice = Invoice::where('user_id', $customerId)->orderBy('invoice_date', 'desc')->first();
        $currentYear = date('Y');
        $currentMonth = date('m');

        if ($lastInvoice) {
            $lastInvoiceYear = date('Y', strtotime($lastInvoice->invoice_date));
            $lastInvoiceMonth = date('m', strtotime($lastInvoice->invoice_date));

            if ($currentYear == $lastInvoiceYear && $currentMonth == $lastInvoiceMonth) {
                $hasInvoiceForThisMonth = true;
            }
        }

        return $hasInvoiceForThisMonth;
    }

}
