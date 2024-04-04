<?php

namespace Database\Seeders;

use App\Mail\Admin\Invoice\SendCancelledInvoiceMailToCustomer;
use App\Mail\Admin\Invoice\SendPaymentReminderMailToCustomer;
use App\Mail\Admin\Invoice\SendPaymentWarningMailToCustomer;
use App\Models\Service;
use App\Models\ServicePipeline;
use Illuminate\Database\Seeder;
use App\Models\MailTemplate;
use App\Mail\Admin\Lead\NewCustomerRequestMailToAdmin;
use App\Mail\Admin\WelcomeMail;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServicePipeline::truncate();
        Service::truncate();

        $services = [
            [
                'name' => 'Mitgliedschaft',
                'status' => [
                    'Vertrag', 'Vertrag angenommen', 'Kunde angelegt', 'Unterlagen verschickt',
                    'bezahlt', 'rettungsversuch', 'widerrufen'
                ]
            ],
            [
                'name' => 'Showroom',
                'status' => [
                    'Vertrag', 'Vertrag angenommen', 'showroom angelegt',
                    'bezahlt', 'rettungsversuch', 'widerrufen'
                ]
            ],
            [
                'name' => 'Buch',
                'status' => [
                    'Vertrag', 'Vertrag angenommen', 'werk verschickt',
                    'bezahlt', 'rettungsversuch', 'widerrufen'
                ]
            ],
        ];

        foreach ($services as $service) {
            $createdService = Service::create(['name' => $service['name'], 'price' => 0, 'is_active' => 1]);
            $i = 1;
            foreach ($service['status'] as $status) {
                ServicePipeline::create([
                    'service_id' => $createdService->id,
                    'name' => $status,
                    'default' => $i == 1,
                    'order_no' => $i
                ]);
                ++$i;
            }
        }

    }
}
