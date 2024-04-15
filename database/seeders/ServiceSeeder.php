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
                    [
                        "name" => "Vertrag",
                    ],
                    [
                        "name" => "Vertrag angenommen",
                    ],
                    [
                        "name" => "Kunde angelegt",
                        'has_conversion' => 1,
                    ],
                    [
                        "name" => "Unterlagen verschickt",
                        "has_tracking" => 1,
                    ],
                    [
                        "name" => "Erledigt",
                        "has_option" => 1
                    ],
                ]
            ],
            [
                'name' => 'Showroom',
                'status' => [
                    [
                        "name" => "Vertrag"
                    ],
                    [
                        "name" => "Vertrag angenommen",
                    ],
                    [
                        "name" => "Showroom angelegt",
                    ],
                    [
                        "name" => "Erledigt",
                        "has_option" => 1
                    ]
                ]
            ],
            [
                'name' => 'Buch',
                'status' => [
                    [
                        "name" => "Vertrag"
                    ],
                    [
                        "name" => "Vertrag angenommen"
                    ],
                    [
                        "name" => "Werk verschickt"
                    ],
                    [
                        "name" => "Erledigt",
                        "has_option" => 1
                    ]
                ]
            ],
        ];

        foreach ($services as $service) {
            $createdService = Service::create(['name' => $service['name'], 'price' => 0, 'is_active' => 1]);
            $i = 1;
            foreach ($service['status'] as $status) {
                ServicePipeline::create(array_merge([
                    'service_id' => $createdService->id,
                    'default' => $i == 1,
                    'order_no' => $i
                ], $status));
                ++$i;
            }
        }

    }
}
