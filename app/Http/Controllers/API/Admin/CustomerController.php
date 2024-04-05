<?php

namespace App\Http\Controllers\API\Admin;


use App\CommandProcess\Admin\Customer\DeleteCustomer;
use App\CommandProcess\Admin\Customer\DownloadContractDocument;
use App\CommandProcess\Admin\Customer\SearchCustomers;
use App\CommandProcess\Admin\Customer\GetCustomerDocumentPdf;
use App\CommandProcess\Admin\Customer\GetCustomerProducts;
use App\CommandProcess\Admin\Customer\GetCustomersBirthday;
use App\CommandProcess\Admin\Customer\GetFilteredCustomers;
use App\CommandProcess\Admin\Customer\GetCustomer;
use App\CommandProcess\Admin\Customer\SortCustomerProducts;
use App\CommandProcess\Admin\Customer\StoreCustomer;
use App\CommandProcess\Admin\Customer\UpdateCustomer;
use App\CommandProcess\Admin\Customer\UpdateCustomerActiveStatus;
use App\CommandProcess\Admin\Customer\UpdateCustomerForms;
use App\CommandProcess\Admin\Customer\UpdateCustomerInvoiceSetting;
use App\CommandProcess\Admin\Customer\UpdateCustomersBulkAction;
use App\Http\Requests\Admin\Customer\ChangeActiveStatusRequest;
use App\Http\Requests\Admin\Customer\CreateCustomerRequest;
use App\Http\Requests\Admin\Customer\CustomerDocumentRequest;
use App\Http\Requests\Admin\Customer\DownloadContractDocumentRequest;
use App\Http\Requests\Admin\Customer\UpdateCustomerRequest;
use App\Http\Requests\Admin\Customer\UpdateCustomersBulkActionRequest;
use App\DataHolders\Enum\Membership;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Rosamarsky\CommandBus\CommandBus;

class CustomerController extends Controller
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
    public function index(Request $request): JsonResponse
    {
        $customers = $this->commandBus->execute(new GetFilteredCustomers($request->all()));

        return $this->respondWithSuccess(trans('Customers fetched successfully'), $customers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCustomerRequest $request
     * @return JsonResponse
     */
    public function store(CreateCustomerRequest $request): JsonResponse
    {
        $customer = $this->commandBus->execute(
            new StoreCustomer($request->only(User::fillableProps()))
        );

        return $this->respondCreated(__('Customer created successfully'), $customer);
    }

    /**
     * Display the specified resource.
     *
     * @param $customerId
     * @return JsonResponse
     */
    public function show($customerId): JsonResponse
    {
        $customer = $this->commandBus->execute(new GetCustomer((int) $customerId));

        return $this->respondWithContentOnly($customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCustomerRequest $request
     * @param $customerId
     * @return JsonResponse
     */
    public function update(UpdateCustomerRequest $request, $customerId): JsonResponse
    {
        $this->commandBus->execute(
            new UpdateCustomer((int) $customerId, $request->all())
        );

        return $this->respondUpdated(__('Customer updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $customerId
     * @return JsonResponse
     */
    public function destroy($customerId): JsonResponse
    {
        $this->commandBus->execute(new DeleteCustomer((int) $customerId));

        return $this->respondWithSuccess(__('Customer deleted successfully'));
    }

    /**
     * Change Active Status
     *
     * @param ChangeActiveStatusRequest $request
     * @return JsonResponse
     */
    public function changeActiveStatus(ChangeActiveStatusRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->commandBus->execute(
            new UpdateCustomerActiveStatus(
                (int) $request->get('user_id'),
                (int) $request->get('is_active')
            )
        );

        return $this->respondWithSuccess(__('Customer Active Status Updated'));
    }


    /**
     * Update Bulk Action
     *
     * @param UpdateCustomersBulkActionRequest $request
     * @return JsonResponse
     */
    public function updateBulkAction(UpdateCustomersBulkActionRequest $request): JsonResponse
    {
        $message = $this->commandBus->execute(
            new UpdateCustomersBulkAction(
                (array) $request->get('data_ids'),
                (string) $request->get('action')
            )
        );

        return $this->respondWithSuccess($message);
    }


    /**
     * Get Active Customers
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function searchCustomers(Request $request): JsonResponse
    {
        $customers = $this->commandBus->execute(new SearchCustomers($request->all()));

        return $this->respondWithSuccess('Customers fetched successfully', $customers);
    }


    /**
     * Get Memberships
     *
     * @return JsonResponse
     */
    public function getMemberships(): JsonResponse
    {
        $memberships = Membership::getForSelect();

        return $this->respondWithSuccess('Memberships fetched Successfully', $memberships);
    }


    /**
     * Get Customer Birthdays
     *
     * @return JsonResponse
     */
    public function getCustomerBirthdays(): JsonResponse
    {
        $dates = $this->commandBus->execute(new GetCustomersBirthday());

        return $this->respondWithSuccess('Memberships fetched Successfully', $dates);
    }


    /**
     * Get Products By Customer
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getProductsByCustomer(Request $request): JsonResponse
    {
        $products = $this->commandBus->execute(new GetCustomerProducts($request->get('user_id')));

        return $this->respondWithSuccess('Customer products fetched successfully', $products);
    }



    /**
     * Sort Customer Products
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sortCustomerProducts(Request $request): JsonResponse
    {
        $this->commandBus->execute(
            new SortCustomerProducts(
                (int) $request->get('user_id'),
                (array) $request->get('user_product_ids')
            )
        );

        return $this->respondWithSuccess('Products sorted successfully');
    }



    /**
     * Download Welcome and Registration PDF
     *
     */
    public function downloadCustomerDocumentPdf(CustomerDocumentRequest $request)
    {
        return $this->commandBus->execute( new GetCustomerDocumentPdf((int) $request->get('user_id')) );
    }



    /**
     * Download Welcome and Registration PDF
     *
     */
    public function downloadContractDocument(DownloadContractDocumentRequest $request)
    {
        return $this->commandBus->execute( new DownloadContractDocument((int) $request->get('user_id')) );
    }



    /**
     * Update Customer Forms
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateCustomerForms(Request $request): JsonResponse
    {
        $this->commandBus->execute(
            new UpdateCustomerForms(
                (int) $request->get('user_id'),
                (array) $request->get('forms')
            )
        );

        return $this->respondWithSuccess('Customer forms updated successfully');
    }


    /**
     * Update Invoice Settings
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateInvoiceSetting(Request $request): JsonResponse
    {
        $this->commandBus->execute(
            new UpdateCustomerInvoiceSetting(
                (int) $request->get('user_id'),
                $request->except('user_id')
            )
        );

        return $this->respondWithSuccess('Invoice settings updated successfully');
    }


}
