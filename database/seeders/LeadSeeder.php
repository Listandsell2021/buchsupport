<?php

namespace Database\Seeders;


use App\DataHolders\Enum\Membership;
use App\Models\Admin;
use App\Models\ContractProduct;
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
        ContractProduct::truncate();
        SmartList::truncate();
        Notification::truncate();

        //$defaultLeadStatus = LeadStatus::where('default', 1)->first();
        $this->defaultLeadStatusId = 3; //$defaultLeadStatus->id
        $customers = User::with('forms')->get();
        $salespersons = Admin::salesperson()->take(5)->get()->toArray();

        foreach ($customers as $customer) {

            $lead = Lead::create($this->getLeadData($customer, $salespersons));

            $leadContract = LeadContract::create([
                'lead_id'       => $lead->id,
                'membership'    => $customer->membership,
                'document_name' => 'testing.pdf',
                'document_path' => $lead->id.'/testing.pdf',
            ]);

            ContractProduct::insert($this->getContractProducts($customer->forms, $leadContract->id));
        }

        $customerContracts = [];
        foreach ($customers as $customer) {
            $customerContracts[] = [
                'user_id' => $customer->id,
                'document_name' => 'testing.pdf',
                'document_path' => $customer->id.'/testing.pdf',
            ];
        }
        foreach (array_chunk($customerContracts, 50) as $chuckedCustomerContracts) {
            UserContract::insert($chuckedCustomerContracts);
        }


        $leads = Lead::factory()->count(250)->create();

        $leadContracts = [];
        foreach ($leads as $lead) {
            $leadContracts[] = [
                'lead_id'       => $lead->id,
                'membership'    => Membership::silver->name,
                'document_name' => null,
                'document_path' => null,
            ];
        }

        foreach (array_chunk($leadContracts, 50) as $chunkedLeadContracts) {
            LeadContract::insert($chunkedLeadContracts);
        }

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
            'salesperson_id' => $salesperson['id']
        ]);
    }

    public function getContractProducts($forms, $contractId): array
    {
        $contractProducts = [];

        $productIds = [];
        foreach ($forms as $form) {
            if (!in_array($form->product_id, $productIds)) {
                $contractProducts[] = [
                    "contract_id" => $contractId,
                    "product_id" => $form->product_id,
                    "price" => $form->price,
                    "quantity" => $form->quantity,
                    "condition" => $form->condition,
                ];
            }

            $productIds[] = $form->product_id;
        }

        return $contractProducts;
    }

    public function getMapLocation(): array
    {
        $latitude = 52.489974;
        $longitude = 13.408845;

        $center = [
            'lng' => $longitude,
            'lat' => $latitude
        ];

        return (new LeadFactory())->generateRandomPoint($center, 1000);
    }
}
