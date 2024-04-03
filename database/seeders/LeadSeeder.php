<?php

namespace Database\Seeders;


use App\DataHolders\Enum\Membership;
use App\Models\Admin;
use App\Models\LeadContract;
use App\Models\Lead;
use App\Models\LeadContract;
use App\Models\LeadStatus;
use App\Models\Notification;
use App\Models\SalesPerson;
use App\Models\SmartList;
use App\Models\User;
use App\Models\UserContract;
use Database\Factories\LeadFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

class LeadSeeder extends Seeder
{
    public int $defaultLeadStatusId = 0;

    /**
     *
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Lead::truncate();
        LeadContract::truncate();
        SmartList::truncate();
        Notification::truncate();

        $this->defaultLeadStatusId = 3; //$defaultLeadStatus->id
        $customers = User::all();
        $salespersons = Admin::salesperson()->take(5)->get()->toArray();

        foreach ($customers as $customer) {
            Lead::create($this->getLeadData($customer, $salespersons));
        }

        Lead::factory()->count(250)->create();

        Schema::enableForeignKeyConstraints();
    }

    public function getLeadData($customer, $salespersons): array
    {
        $location = $this->getMapLocation();

        $salesperson = $salespersons[array_rand($salespersons)];

        return array_merge(Arr::only($customer->toArray(), Lead::fillableProps()), [
            'map_longitude' => $location['lng'],
            'map_latitude'  => $location['lat'],
            'lead_status_id' => $this->defaultLeadStatusId,
            'is_converted'  => 1,
            'converted_at'  => $customer->created_at,
            'converted_to'  => $customer->id,
            'salesperson_id' => $salesperson['id'],
            'contract_document' => 'testing.pdf',
            'contract_document_path' => 'testing.pdf',
        ]);
    }


    public function getMapLocation(): array
    {
        $latitude = 52.466498;
        $longitude = 13.431378;

        $center = [
            'lng' => $longitude,
            'lat' => $latitude
        ];

        return (new LeadFactory())->generateRandomPoint($center, 1000);
    }
}
