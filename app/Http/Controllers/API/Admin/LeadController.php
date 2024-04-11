<?php

namespace App\Http\Controllers\API\Admin;


use App\CommandProcess\Admin\Lead\AddLeadNote;
use App\CommandProcess\Admin\Lead\ConvertLeadToNewCustomer;
use App\CommandProcess\Admin\Lead\CreateLeadContract;
use App\CommandProcess\Admin\Lead\CreateLeadProductCategory;
use App\CommandProcess\Admin\Lead\DeleteAddedProduct;
use App\CommandProcess\Admin\Lead\DeleteLead;
use App\CommandProcess\Admin\Lead\DeleteLeadNote;
use App\CommandProcess\Admin\Lead\DownloadContractDocument;
use App\CommandProcess\Admin\Lead\GetFilteredLeads;
use App\CommandProcess\Admin\Lead\GetLead;
use App\CommandProcess\Admin\Lead\GetLeadAddedProducts;
use App\CommandProcess\Admin\Lead\GetLeadContract;
use App\CommandProcess\Admin\Lead\GetLeadCustomerOrders;
use App\CommandProcess\Admin\Lead\GetLeadNotes;
use App\CommandProcess\Admin\Lead\GetLeadsMapLocation;
use App\CommandProcess\Admin\Lead\GetLeadStatus;
use App\CommandProcess\Admin\Lead\UpdateBulkLeadSalesperson;
use App\CommandProcess\Admin\Lead\UpdateBulkLeadStatus;
use App\CommandProcess\Admin\Lead\UpdateLeadObjection;
use App\CommandProcess\Admin\Lead\RequestForNewCustomer;
use App\CommandProcess\Admin\Lead\StoreLead;
use App\CommandProcess\Admin\Lead\UpdateContractMembership;
use App\CommandProcess\Admin\Lead\UpdateContractProducts;
use App\CommandProcess\Admin\Lead\UpdateLead;
use App\CommandProcess\Admin\Lead\UpdateLeadSalesperson;
use App\CommandProcess\Admin\Lead\UpdateLeadStatus;
use App\CommandProcess\Admin\Lead\UpdateLeadTablePreference;
use App\CommandProcess\Admin\Lead\UploadContractDocument;
use App\CommandProcess\Admin\Lead\CreateLeadProduct;
use App\CommandProcess\Admin\LeadStatus\StoreLeadStatus;
use App\CommandProcess\Admin\SmartList\StoreSmartList;
use App\DataHolders\Enum\LeadStatus;
use App\DataHolders\Enum\Membership;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Lead\AddedNewCustomerRequest;
use App\Http\Requests\Admin\Lead\AddLeadNoteRequest;
use App\Http\Requests\Admin\Lead\ApproveNewCustomerRequest;
use App\Http\Requests\Admin\Lead\ChangeStatusRequest;
use App\Http\Requests\Admin\Lead\CreateLeadContractRequest;
use App\Http\Requests\Admin\Lead\CreateLeadOrderRequest;
use App\Http\Requests\Admin\Lead\CreateLeadRequest;
use App\Http\Requests\Admin\Lead\DeleteAddedProductRequest;
use App\Http\Requests\Admin\Lead\DeleteLeadNoteRequest;
use App\Http\Requests\Admin\Lead\DeleteLeadRequest;
use App\Http\Requests\Admin\Lead\DownloadContractDocumentRequest;
use App\Http\Requests\Admin\Lead\GetContractRequest;
use App\Http\Requests\Admin\Lead\GetLeadCustomerOrdersRequest;
use App\Http\Requests\Admin\Lead\ImportLeadRequest;
use App\Http\Requests\Admin\Lead\RemoveLeadObjectionRequest;
use App\Http\Requests\Admin\Lead\UpdateBulkLeadSalespersonRequest;
use App\Http\Requests\Admin\Lead\UpdateBulkLeadStatusRequest;
use App\Http\Requests\Admin\Lead\UpdateContractMembershipRequest;
use App\Http\Requests\Admin\Lead\UpdateContractProductsRequest;
use App\Http\Requests\Admin\Lead\UpdateLeadRequest;
use App\Http\Requests\Admin\Lead\UpdateLeadSalespersonRequest;
use App\Http\Requests\Admin\Lead\UpdateLeadTablePreferenceRequest;
use App\Http\Requests\Admin\Lead\UploadContractDocumentRequest;
use App\Http\Requests\Admin\LeadStatus\CreateLeadStatusRequest;
use App\Http\Requests\Admin\Service\CreateServiceRequest;
use App\Http\Requests\Admin\ProductCategory\CreateProductCategoryRequest;
use App\Libraries\LaraExcel\Admin\LeadsImport;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Rosamarsky\CommandBus\CommandBus;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class LeadController extends Controller
{
    use ApiResponseHelpers;

    protected CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $leads = $this->commandBus->execute(new GetFilteredLeads($request->all()));

        return $this->respondWithSuccess(trans('Leads fetched successfully'), $leads);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateLeadRequest $request
     * @return JsonResponse
     */
    public function store(CreateLeadRequest $request): JsonResponse
    {
        $lead = $this->commandBus->execute(new StoreLead($request->all()));

        return $this->respondCreated(__('Lead created successfully'), $lead);
    }

    /**
     * Display the specified resource.
     *
     * @param $leadId
     * @return JsonResponse
     */
    public function show($leadId): JsonResponse
    {
        $lead = $this->commandBus->execute(new GetLead((int) $leadId));

        return $this->respondWithContentOnly($lead);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLeadRequest $request
     * @param $leadId
     * @return JsonResponse
     */
    public function update(UpdateLeadRequest $request, $leadId): JsonResponse
    {
        $this->commandBus->execute(new UpdateLead((int) $request->get('id'), $request->only(Lead::fillableProps())));

        return $this->respondUpdated(__('Lead updated successfully'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteLeadRequest $request
     * @param $leadId
     * @return JsonResponse
     */
    public function destroy(DeleteLeadRequest $request, $leadId): JsonResponse
    {
        $this->commandBus->execute(new DeleteLead((int) $request->get('lead_id')));

        return $this->respondWithSuccess(__('Lead deleted successfully'));
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getLeadsMapLocation(Request $request): JsonResponse
    {
        $leads = $this->commandBus->execute(new GetLeadsMapLocation($request->all()));

        return $this->respondWithSuccess(trans('Leads map location fetched successfully'), $leads);
    }


    /**
     * Change Active Status
     *
     * @param ChangeStatusRequest $request
     * @return JsonResponse
     */
    public function changeStatus(ChangeStatusRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->commandBus->execute(
            new UpdateLeadStatus(
                (int) $request->get('lead_id'),
                (int) $request->get('lead_status_id')
            )
        );

        return $this->respondWithSuccess(__('Lead Status Updated'));
    }

    /**
     * Update Lead Objection
     *
     * @param RemoveLeadObjectionRequest $request
     * @return JsonResponse
     */
    public function updateObjection(RemoveLeadObjectionRequest $request): JsonResponse
    {
        $this->commandBus->execute(
            new UpdateLeadObjection(
                (int) $request->get('lead_id'),
                (string) $request->get('reason')
            )
        );

        return $this->respondWithSuccess(__('Lead objection update Successfully'));
    }

    /**
     * Remove Lead Objection
     *
     * @param RemoveLeadObjectionRequest $request
     * @return JsonResponse
     */
    public function removeObjection(RemoveLeadObjectionRequest $request): JsonResponse
    {
        $this->commandBus->execute(
            new UpdateLeadObjection(
                (int) $request->get('lead_id'),
                (string) $request->get('reason')
            )
        );

        return $this->respondWithSuccess(__('Lead objection removed Successfully'));
    }


    /**
     * Import Leads
     *
     * @param ImportLeadRequest $request
     * @return JsonResponse
     */
    public function importLeads(ImportLeadRequest $request): JsonResponse
    {
        $data = Excel::toArray(new LeadsImport(), $request->file('file'), null, \Maatwebsite\Excel\Excel::XLSX);
        $leads = $data[0];
        $i = 1;
        $headers = $leads[0];
        $newData = [];
        foreach ($leads as $lead) {
            if ($i !== 1) {
                $array = [];

                foreach ($headers as $index=>$column) {
                    $array[$column] = $lead[$index];
                }
                $newData[] = $array;
            }
            $i++;
        }
        foreach ($newData as $lead) {
            Lead::create($lead);
        }

        return $this->respondWithSuccess('Successfully imported');

        /*return (new LeadsExport())->download('leads.xlsx', \Maatwebsite\Excel\Excel::XLSX, [
            'Content-Disposition' => 'attachment; filename="leads.xlsx"',
        ]);*/
    }
    

    /**
     * Get Lead Status
     *
     * @return JsonResponse
     */
    public function getLeadStatus(): JsonResponse
    {
        $leadStatus = $this->commandBus->execute(new GetLeadStatus());

        return $this->respondWithSuccess('Lead status fetched successfully', $leadStatus);
    }

    /**
     * Add Lead Status
     *
     * @param CreateLeadStatusRequest $request
     * @return JsonResponse
     */
    public function addLeadStatus(CreateLeadStatusRequest $request): JsonResponse
    {
        $leadStatus = $this->commandBus->execute(new StoreLeadStatus($request->all()));

        return $this->respondWithSuccess(__('Lead status created successfully'), $leadStatus);
    }


    /**
     * Get Lead Customer Pipeline
     *
     * @param GetLeadCustomerOrdersRequest $request
     * @return JsonResponse
     */
    public function getLeadCustomerOrder(GetLeadCustomerOrdersRequest $request): JsonResponse
    {
        $orders = $this->commandBus->execute(new GetLeadCustomerOrders($request->get('lead_id')));

        return $this->respondWithSuccess(__('Pipelines created successfully'), $orders);
    }


    /**
     * Get Lead Notes
     *
     * @param Request $request
     * @param $leadId
     * @return JsonResponse
     */
    public function getLeadNotes(Request $request): JsonResponse
    {
       $leadNotes = $this->commandBus->execute(new GetLeadNotes((int) $request->get('lead_id')));

       return $this->respondWithSuccess(__('Lead notes fetched Successfully'), $leadNotes);
    }

    /**
     * Get Lead Notes
     *
     * @param AddLeadNoteRequest $request
     * @return JsonResponse
     */
    public function addLeadNote(AddLeadNoteRequest $request): JsonResponse
    {
        $leadNote = $this->commandBus->execute(
            new AddLeadNote(
                (int) $request->get('lead_id'),
                (string) $request->get('note')
            )
        );

        return $this->respondWithSuccess(__('Lead note added successfully'), $leadNote);
    }


    /**
     * Delete Lead Notes
     *
     * @param DeleteLeadNoteRequest $request
     * @return JsonResponse
     */
    public function deleteLeadNote(DeleteLeadNoteRequest $request): JsonResponse
    {
        $leadNote = $this->commandBus->execute(
            new DeleteLeadNote((int) $request->get('note_id'))
        );

        return $this->respondWithSuccess(__('Lead note added successfully'), $leadNote);
    }

    /**
     * Update Leads Salesperson
     *
     * @param UpdateLeadSalespersonRequest $request
     * @return JsonResponse
     */
    public function updateSalesperson(UpdateLeadSalespersonRequest $request): JsonResponse
    {
        $this->commandBus->execute(
            new UpdateLeadSalesperson(
                (int) $request->get('lead_id'),
                (int) $request->get('salesperson_id')
            )
        );

        return $this->respondWithSuccess(__('Salesperson updated successfully'));
    }


    /**
     * Get Contract Detail
     *
     * @param GetContractRequest $request
     * @return JsonResponse
     */
    public function getContractDetail(GetContractRequest $request): JsonResponse
    {
        $contract = $this->commandBus->execute(new GetLeadContract((int) $request->get('lead_id')));

        return $this->respondWithSuccess(__('Lead contract fetched successfully'), $contract);
    }


    /**
     * Get Contract Detail
     *
     * @param UploadContractDocumentRequest $request
     * @return JsonResponse
     */
    public function uploadContractDocument(UploadContractDocumentRequest $request): JsonResponse
    {
        $contract = $this->commandBus->execute(
            new UploadContractDocument(
                (int) $request->get('lead_id'),
                $request->file('document')
            )
        );

        return $this->respondWithSuccess(__('Lead contract uploaded successfully'), $contract);
    }


    /**
     * Get Contract Detail
     *
     * @param UpdateContractMembershipRequest $request
     * @return JsonResponse
     */
    public function updateContractMembership(UpdateContractMembershipRequest $request): JsonResponse
    {
        $this->commandBus->execute(
            new UpdateContractMembership(
                (int) $request->get('lead_id'),
                (string) $request->get('membership')
            )
        );

        return $this->respondWithSuccess(__('Contract membership updated successfully'));
    }


    /**
     * Update Contract Products
     *
     * @param UpdateContractProductsRequest $request
     * @return JsonResponse
     */
    public function updateContractProducts(UpdateContractProductsRequest $request): JsonResponse
    {
        $this->commandBus->execute(
            new UpdateContractProducts(
                (int) $request->get('contract_id'),
                (array) $request->get('products')
            )
        );

        return $this->respondWithSuccess(__('Contract updated successfully'));
    }


    /**
     * Request For New Customer
     *
     * @param CreateLeadContractRequest $request
     * @return JsonResponse
     */
    public function requestNewCustomer(CreateLeadContractRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $this->commandBus->execute(
                new CreateLeadContract(
                    (int) $request->get('lead_id'),
                    $request->file('document'),
                    $request->get('service_id'),
                    $request->get('quantity'),
                    $request->get('price'),
                    (string) $request->get('note'),
                )
            );

            $this->commandBus->execute(new ConvertLeadToNewCustomer($request->get('lead_id')));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return $this->respondWithSuccess(__('New Customer Request sent successfully'));
    }


    /**
     * Create Lead Order
     *
     * @param CreateLeadOrderRequest $request
     * @return JsonResponse
     */
    public function createLeadOrder(CreateLeadOrderRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $this->commandBus->execute(
                new CreateLeadContract(
                    (int) $request->get('lead_id'),
                    $request->file('document'),
                    $request->get('service_id'),
                    $request->get('quantity'),
                    $request->get('price'),
                    (string) $request->get('note'),
                )
            );

            $this->commandBus->execute(new ConvertLeadToNewCustomer($request->get('lead_id')));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return $this->respondWithSuccess(__('New Customer Request sent successfully'));
    }


    /**
     * Approve Lead New Customer
     *
     * @param ApproveNewCustomerRequest $request
     * @return JsonResponse
     */
    /*public function approveLeadNewCustomer(ApproveNewCustomerRequest $request): JsonResponse
    {
        $this->commandBus->execute(new ConvertLeadToNewCustomer($request->get('lead_id')));

        return $this->respondWithSuccess(__('New user created successfully'));
    }*/

    /**
     * Update Leads Salesperson
     *
     * @param UpdateBulkLeadSalespersonRequest $request
     * @return JsonResponse
     */
    public function updateBulkLeadSalespersons(UpdateBulkLeadSalespersonRequest $request): JsonResponse
    {
        $this->commandBus->execute(new UpdateBulkLeadSalesperson((int) $request->get('salesperson_id')));

        return $this->respondCreated(__('Leads salesperson updated successfully'));
    }

    /**
     * Update Leads Status
     *
     * @param UpdateBulkLeadStatusRequest $request
     * @return JsonResponse
     */
    public function updateBulkLeadStatus(UpdateBulkLeadStatusRequest $request): JsonResponse
    {
        $this->commandBus->execute(new UpdateBulkLeadStatus((int) $request->get('lead_status_id')));

        return $this->respondCreated(__('Leads status updated successfully'));
    }


    /**
     * Update Lead Table Preferences
     *
     * @param UpdateLeadTablePreferenceRequest $request
     * @return JsonResponse
     */
    public function saveLeadTablePreferences(UpdateLeadTablePreferenceRequest $request): JsonResponse
    {
        $this->commandBus->execute(new UpdateLeadTablePreference((array) $request->get('columns')));

        return $this->respondWithSuccess(__('Lead table preference updated successfully'));
    }

    

    /**
     * Create Lead Product
     *
     * @param CreateServiceRequest $request
     * @return JsonResponse
     */
    public function createLeadProduct(CreateServiceRequest $request): JsonResponse
    {
        $this->commandBus->execute(new CreateLeadProduct((int) $request->get('lead_id'), $request->all()));

        return $this->respondCreated(__('Product created successfully'));
    }


    /**
     * Create Lead Product Category
     *
     * @param CreateProductCategoryRequest $request
     * @return JsonResponse
     */
    public function createLeadProductCategory(CreateProductCategoryRequest $request): JsonResponse
    {
        $this->commandBus->execute(new CreateLeadProductCategory((int) $request->get('lead_id'), $request->all()));

        return $this->respondCreated(__('Category created successfully'));
    }


    /**
     * Delete Added Product
     *
     * @param DeleteAddedProductRequest $request
     * @return JsonResponse
     */
    public function deleteAddedProduct(DeleteAddedProductRequest $request): JsonResponse
    {
        $this->commandBus->execute(new DeleteAddedProduct((int) $request->get('added_product_id')));

        return $this->respondWithSuccess(__('Deleted successfully'));
    }



    /**
     * Get Added Products
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getLeadAddedProducts(Request $request): JsonResponse
    {
        $products = $this->commandBus->execute(new GetLeadAddedProducts((int) $request->get('lead_id')));

        return $this->respondWithSuccess(__('Product created successfully'), $products);
    }


    /**
     * Get Contract Detail
     *
     * @param DownloadContractDocumentRequest $request
     * @return BinaryFileResponse
     */
    public function downloadContractDocument(DownloadContractDocumentRequest $request): BinaryFileResponse
    {
        return $this->commandBus->execute(new DownloadContractDocument((int) $request->get('contract_id')));
    }
}
