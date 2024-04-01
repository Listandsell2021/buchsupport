<?php

namespace App\Console\Commands;

use App\CommandProcess\Admin\Invoice\CreateCustomerAutoInvoice;
use App\Libraries\Settings\Setting;
use App\Models\User;
use Illuminate\Console\Command;
use Rosamarsky\CommandBus\CommandBus;

class CreateTestInvoice extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:test_invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create test invoice';


    /**
     * Execute the console command.
     */
    public function handle(CommandBus $commandBus)
    {
        $customer = User::first();

        $commandBus->execute( new CreateCustomerAutoInvoice($customer->id) );

        /*


         $customer = User::first();
         $commandBus->execute( new CreateAutomaticCustomerInvoice($customer->id) );


         $customers = User::take(10)->get();

         $userDetail = [
            'user_gender'   => 'male',
            'user_name'     => 'Dhan Kumar Lama',
            'user_address'  => 'Jadibuti, Ktm',
            'user_no'       => '05',
        ];

        $services = [
            [
                'item_no' => 1001,
                'service' => '',
                'quantity' => 1,
                'unit_price' => 998,
                'total_price' => 998
            ]
        ];

        $servicePrice = 998;
        $vat = Setting::getVatPercentage();
        $vatPrice = ($servicePrice * $vat) / 100;
        $subtotalPrice = $servicePrice - $vatPrice;
        $totalPrice = $servicePrice;
        $isPaid = 1;
        $settings =
        $i = 1;

        foreach ($customers as $customer) {
            $commandBus->execute(new CreateCustomerInvoice($customer->id, '2023', '08'));
            echo $i++."\n";
        }
        */
        $this->info('Invoices created Successfully');
    }
}
