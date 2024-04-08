<?php

namespace App\Services\Admin;

use App\DataHolders\Enum\AuthRole;
use App\DataHolders\Enum\Gender;
use App\DataHolders\Enum\LeadActivityType;
use App\DataHolders\Enum\Membership;
use App\Events\Admin\LeadNoteAdded;
use App\Events\Admin\LeadStatusUpdated;
use App\Events\Admin\NewLeadsCreated;
use App\Helpers\Config\AuthConfig;
use App\Models\Admin;
use App\Models\Lead;
use App\Models\LeadActivity;
use App\Models\LeadContract;
use App\Models\LeadNote;
use App\Models\LeadStatus;
use App\Models\Order;
use App\Models\Service;
use App\Models\ProductCategory;
use App\Models\ServicePipeline;
use App\Models\User;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LeadService
{
    /**
    * Get all records.
    *
    * @return mixed
    */
    public function searchAndPaginate(array $data)
    {
        return $this->getSearchQuery($data)->paginate(getPerPageTotal());
    }


    /**
     * Get Leads Location
     *
     * @param array $data
     * @return mixed
     */
    public function getLeadsLocation(array $data): mixed
    {

        return $this->getSearchQuery($data)
            ->select('leads.map_longitude as lng', 'leads.map_latitude as lat',
                DB::raw('CONCAT(leads.first_name, " ", leads.last_name) as fullname'),
                'leads.id'
            )
            ->where(function ($query) {
                if (in_array(getAdminAuthRole(), [AuthRole::getAdminRole(), AuthRole::getSalespersonRole(), ''])) {
                    $query->where('leads.salesperson_id', getAdminId());
                }
            })
            ->get();
    }


    /**
     * Get Search Query
     *
     * @param array $data
     * @return mixed
     */
    public function getSearchQuery(array $data): mixed
    {
        $filters = $data['filters'] ?? [];

        $dbQuery =  Lead::select('leads.*',
            'lead_status.code as lead_status_code', 'lead_status.name as lead_status_name',
            DB::raw("CONCAT(admins.first_name, ' ', admins.last_name) as salesperson")
        )
            ->leftJoin('lead_status', 'leads.lead_status_id', 'lead_status.id')
            ->leftJoin('admins', 'leads.salesperson_id', 'admins.id')
            ->where(function($query) use ($filters) {
                if (hasInput($filters['name'] ?? '')) {
                    $query->where(
                        DB::raw("CONCAT_WS(' ', leads.first_name, leads.last_name)"), 'LIKE', '%' . $filters['name'] . '%'
                    );
                }
                if (hasInput($filters['email'] ?? '')) {
                    $query->where('leads.email', 'LIKE', '%'.$filters['email'].'%');
                }
                if (in_array($filters['gender'] ?? '', Gender::onlyNames())) {
                    $query->where('leads.gender', '=', $filters['gender']);
                }
                if (hasInput($filters['phone_no'] ?? '')) {
                    $query->where('leads.phone_no', 'LIKE', '%'.$filters['phone_no'].'%');
                }
                if (hasInput($filters['street'] ?? '')) {
                    $query->where('leads.street', 'LIKE', '%'.$filters['street'].'%');
                }
                if (hasInput($filters['country'] ?? '')) {
                    $query->where('leads.country', 'LIKE', '%'.$filters['country'].'%');
                }
                if (hasInput($filters['city'] ?? '')) {
                    $query->where('leads.city', 'LIKE', '%'.$filters['city'].'%');
                }
                if (hasInput($filters['postal_code_start'] ?? '')) {
                    $query->where('leads.postal_code', '>=', $filters['postal_code_start']);
                }
                if (hasInput($filters['postal_code_end'] ?? '')) {
                    $query->where('leads.postal_code', '<=', $filters['postal_code_end']);
                }
                if (hasInput($filters['lead_status_id'] ?? '')) {
                    $query->where('leads.lead_status_id', $filters['lead_status_id']);
                }
                if (hasArrayInput($filters['salesperson_ids'] ?? [])) {
                    $query->whereIn('leads.salesperson_id', $filters['salesperson_ids']);
                }
        });

        if (hasInput($filters['smart_list_id'] ?? '')) {
            $dbQuery->join('smart_list_leads', 'leads.id', 'smart_list_leads.lead_id')
                ->where('smart_list_leads.smart_list_id', $filters['smart_list_id']);
        }

        return $dbQuery->sorting([
            'leads.first_name', 'leads.city', 'leads.street',
            'leads.postal_code', 'leads.gender', 'leads.lead_status_id', 'salesperson'
        ], 'leads.id', 'desc');
    }



    /**
    * Get specific record by id.
    *
    * @param int $leadId
    * @return mixed
    */
    public function getById(int $leadId): mixed
    {
        return Lead::select('leads.*',
            DB::raw('CONCAT(salespersons.first_name, " ", salespersons.last_name) as salesperson'),
            'lead_status.name as lead_status_name', 'lead_status.code as lead_status_code',
            DB::raw('CONCAT(customers.first_name, " ", customers.last_name) as customer'),
        )
            ->with(['contract', 'contract.service'])
            ->leftJoin('lead_status', 'leads.lead_status_id', 'lead_status.id')
            ->leftJoin('admins as salespersons', 'leads.salesperson_id', 'salespersons.id')
            ->leftJoin('admins as customers', 'leads.converted_to', DB::raw('customers.id'))
            ->where('leads.id', $leadId)
            ->first();
    }

    /**
    * Store data to database.
    *
    * @param array $data
    * @return mixed
    */
    public function save(array $data): mixed
    {
        $lead = Lead::create(Arr::only($data, Lead::fillableProps()));

        event(new NewLeadsCreated([$lead->id]));

        return $lead;
    }

    /**
     * Update specific record to database.
     *
     * @param int $leadId
     * @param array $data
     * @return void
     */
    public function update(int $leadId, array $data): void
    {
        $lead = Lead::find($leadId);

        Lead::where('id', $leadId)->update(Arr::only($data, Lead::fillableProps()));

        if (isset($data['lead_status_id']) && $lead->lead_status_id != $data['lead_status_id']) {
            $leadStatus = LeadStatus::find($data['lead_status_id']);
            event(new LeadStatusUpdated($leadId, $leadStatus->name));
        }
    }

    /**
     * Delete specific record.
     *
     * @param int $leadId
     * @return void
     */
    public function delete(int $leadId): void
    {
        Lead::where('id', $leadId)->delete();
    }


    /**
     * Update Status
     *
     * @param int $leadId
     * @param int $status_id
     * @return void
     */
    public function updateStatus(int $leadId, int $status_id): void
    {
        Lead::where('id', $leadId)->update(['lead_status_id' => $status_id]);
        $leadStatus = LeadStatus::find($status_id);

        event(new LeadStatusUpdated($leadId, $leadStatus->name));
    }


    /**
     * Get total Leads
     *
     * @return int
     */
    public function getTotalLeads(): int
    {
        return (int) Lead::count();
    }


    /**
     * Get Lead Notes
     *
     * @param int $leadId
     * @return mixed
     */
    public function getLeadNotes(int $leadId): mixed
    {
        return LeadNote::select('lead_notes.*', DB::raw('CONCAT(admins.first_name, " ", admins.last_name) as created_by'))
            ->leftJoin('admins', 'lead_notes.admin_id', 'admins.id')
            ->where('lead_id', $leadId)
            ->get();
    }


    /**
     * Add Lead Note
     *
     * @param int $leadId
     * @param string $note
     * @return mixed
     */
    public function addLeadNote(int $leadId, string $note): mixed
    {
        $leadNote = LeadNote::create([
            'lead_id'       => $leadId,
            'description'   => $note,
            'admin_id'      => getAdminId(),
        ]);

        event(new LeadNoteAdded($leadId, (int) $leadNote->id, $note));

        return $leadNote;
    }

    /**
     * Update Leads Salesperson
     *
     * @param int $leadId
     * @param int $salespersonId
     * @return void
     */
    public function updateSalesperson(int $leadId, int $salespersonId): void
    {
        Lead::where('id', $leadId)->update(['salesperson_id' => $salespersonId]);
    }


    /**
     * Update Lead Objection
     *
     * @param int $leadId
     * @param string $reason
     * @return mixed
     */
    public function updateObjection(int $leadId, string $reason): mixed
    {
        return Lead::where('id', $leadId)->update([
            'objection' => $reason
        ]);
    }

    /**
     * Remove Lead Objection
     *
     * @param int $leadId
     * @return mixed
     */
    public function removeObjection(int $leadId): mixed
    {
        return Lead::where('id', $leadId)->update([
            'objection' => null
        ]);
    }

    /**
     * Get Contract Detail
     *
     * @param int $leadId
     * @return mixed
     */
    public function getContractDetail(int $leadId): mixed
    {
        return LeadContract::with(['service'])
            ->where('lead_id', $leadId)
            ->first();
    }


    /**
     * Update Contract Document
     *
     * @param int $leadId
     * @param string $documentName
     * @param string $documentPath
     * @return mixed
     */
    public function updateContractDocument(int $leadId, string $documentName, string $documentPath): mixed
    {
        return LeadContract::where('lead_id', $leadId)->update([
            'document_name' => $documentName,
            'document_path' => $documentPath
        ]);
    }

    /**
     * Get Lead Contract By Lead Id
     *
     * @param int $leadId
     * @return mixed
     */
    public function getContractByLead(int $leadId): mixed
    {
        return LeadContract::where('lead_id', $leadId)->first();
    }

    /**
     * Get Contract By ID
     *
     * @param int $contractId
     * @return mixed
     */
    public function getContractById(int $contractId): mixed
    {
        return LeadContract::find($contractId);
    }

    /**
     * Update Contract Membership
     *
     * @param $leadId
     * @param $membership
     * @return void
     */
    public function updateContractMembership($leadId, $membership): void
    {
        if (in_array($membership, Membership::onlyNames())) {
            LeadContract::where('lead_id', $leadId)->update(['membership' => $membership]);
        }
    }

    /**
     * Update Contract Products
     *
     * @param int $contractId
     * @param array $products
     * @return void
     */
    public function updateContractProducts(int $contractId, array $products): void
    {
        $data = [];
        foreach ($products as $product) {
            $data[$product['product_id']] = [
                "quantity"  => $product['quantity'],
                "condition" => $product['condition'],
                "price"     => $product['price'],
            ];
        }

        if (count($data) > 0) {
            $contract = LeadContract::find($contractId);
            $contract->products()->sync($data);
        }
    }

    /**
     * Request for New Customer
     *
     * @param int $leadId
     * @return mixed
     */
    public function requestForNewCustomer(int $leadId): mixed
    {
        $lead = Lead::find($leadId);
        $lead->has_conversion_request = 1;
        $lead->save();

        return $lead;
    }


    /**
     * Get conversion pending leads
     *
     * @return mixed
     */
    public function getConversionPendingLeads(): mixed
    {
        return Lead::where('has_conversion_request', 1)->where('is_converted', 0)->get();
    }


    /**
     * Convert Lead to New Customer
     *
     * @param int $leadId
     * @return mixed
     */
    public function convertLeadToNewCustomer(int $leadId): mixed
    {
        $lead = Lead::with(['contract'])->where('id', $leadId)->first();

        $password = Str::random(10);

        $uid = User::max('uid');

        $customer = User::create([
            "membership"    => $lead->contract->membership,
            'uid'           => ++$uid,
            "first_name"    => $lead->first_name,
            "last_name"     => $lead->last_name,
            "email"         => $lead->email,
            "password"      => bcrypt($password),
            "password_text" => $password,
            "gender"        => $lead->gender,
            "phone_no"      => $lead->phone_no,
            "street"        => $lead->street,
            "postal_code"   => $lead->postal_code,
            "city"          => $lead->city,
            "country"       => $lead->country,
            "is_active"     => 1,
            "registered_at" => getCurrentDateTime()
        ]);

        Lead::where('id', $leadId)->update([
            'is_converted' => 1,
            'converted_to' => $customer->id,
            'converted_at' => getCurrentDateTime(),
        ]);

        $pipeline = ServicePipeline::where('service_id', $lead->contract->service_id)->orderBy('default', 'desc')->first();

        Order::create([
            'user_id' => $customer->id,
            'service_id' => $lead->contract->service_id,
            'pipeline_id' => $pipeline->id,
            'price' => (float) $lead->contract->price,
            'quantity' => (int) $lead->contract->quantity,
            'note' => $lead->contract->note,
            'order_at' => getCurrentDateTime()
        ]);

        return $customer;
    }

    /**
     * Update Bulk Lead Salesperson
     *
     * @param array $leadIds
     * @param int $salespersonId
     * @return void
     */
    public function updateBulkSalesperson(array $leadIds, int $salespersonId): void
    {
        foreach (array_chunk($leadIds, 100) as $chuckedLeadIds) {
            Lead::whereIn('id', $chuckedLeadIds)->update(['salesperson_id' => $salespersonId]);
        }
    }

    /**
     * Update Bulk Lead Status
     *
     * @param array $leadIds
     * @param int $leadStatusId
     * @return void
     */
    public function updateBulkStatus(array $leadIds, int $leadStatusId): void
    {
        foreach (array_chunk($leadIds, 100) as $chuckedLeadIds) {
            Lead::whereIn('id', $chuckedLeadIds)->update(['lead_status_id' => $leadStatusId]);
        }
    }

    /**
     * Save Lead table preference
     *
     * @param int $adminId
     * @param array $columns
     * @return bool
     */
    public function saveTablePreference(int $adminId, array $columns): bool
    {
        return (bool) Admin::where('id', $adminId)->update(['lead_columns' => $columns]);
    }

    /**
     * Create Lead Contract
     *
     * @param int $leadId
     * @param int $serviceId
     * @param int $quantity
     * @param float $price
     * @param string $note
     * @param string $documentName
     * @param string $documentPath
     * @return mixed
     */
    public function createLeadContract(int $leadId, int $serviceId, int $quantity, float $price, string $note, string $documentName, string $documentPath): mixed
    {
        return LeadContract::create([
            'lead_id' => $leadId,
            'service_id' => $serviceId,
            'quantity' => $quantity,
            'price' => $price,
            'note' => $note,
            'document' => $documentName,
            'document_path' => $documentPath
        ]);
    }

}