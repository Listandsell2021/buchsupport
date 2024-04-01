<?php

namespace App\Http\Controllers\API\Admin;


use App\CommandProcess\Admin\Customer\UpdateCustomersBulkAction;
use App\CommandProcess\Admin\Invoice\CancelInvoice;
use App\CommandProcess\Admin\Invoice\CreateCustomerCustomInvoice;
use App\CommandProcess\Admin\Invoice\CreateInvoicePaymentReminder;
use App\CommandProcess\Admin\Invoice\CreatePaymentWarning;
use App\CommandProcess\Admin\Invoice\DeleteInvoice;
use App\CommandProcess\Admin\Invoice\DownloadCancelledInvoice;
use App\CommandProcess\Admin\Invoice\DownloadCustomerInvoice;
use App\CommandProcess\Admin\Invoice\DownloadPaymentReminder;
use App\CommandProcess\Admin\Invoice\DownloadPaymentWarning;
use App\CommandProcess\Admin\Invoice\GetFilteredInvoices;
use App\CommandProcess\Admin\Invoice\GetInvoice;
use App\CommandProcess\Admin\Invoice\GetInvoiceData;
use App\CommandProcess\Admin\Invoice\SendCancelledInvoice;
use App\CommandProcess\Admin\Invoice\SendPaymentReminder;
use App\CommandProcess\Admin\Invoice\SendPaymentWarning;
use App\CommandProcess\Admin\Invoice\SetInvoicePaid;
use App\CommandProcess\Admin\Invoice\SetInvoiceUnpaid;
use App\CommandProcess\Admin\Invoice\UpdateInvoice;
use App\CommandProcess\Admin\Invoice\UpdateInvoicesBulkAction;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Invoice\CancelInvoiceRequest;
use App\Http\Requests\Admin\Invoice\ChangeInvoicePaidStatusRequest;
use App\Http\Requests\Admin\Invoice\CreateCustomInvoiceRequest;
use App\Http\Requests\Admin\Invoice\CreatePaymentReminderRequest;
use App\Http\Requests\Admin\Invoice\CreatePaymentWarningRequest;
use App\Http\Requests\Admin\Invoice\DownloadCancelledInvoiceRequest;
use App\Http\Requests\Admin\Invoice\DownloadPaymentReminderRequest;
use App\Http\Requests\Admin\Invoice\DownloadPaymentWarningRequest;
use App\Http\Requests\Admin\Invoice\SendCancelledInvoiceRequest;
use App\Http\Requests\Admin\Invoice\SendPaymentReminderRequest;
use App\Http\Requests\Admin\Invoice\SendPaymentWarningRequest;
use App\Http\Requests\Admin\Invoice\UpdateInvoicesBulkActionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Rosamarsky\CommandBus\CommandBus;


class InvoiceController extends Controller
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
    public function listInvoices(Request $request): JsonResponse
    {
        $invoices = $this->commandBus->execute(new GetFilteredInvoices($request->all()));

        return $this->respondWithSuccess(trans('Invoices fetched successfully'), $invoices);
    }

    /**
     * Display the specified resource.
     *
     * @param $invoiceId
     * @return JsonResponse
     */
    public function show($invoiceId): JsonResponse
    {
        return $this->respondWithContentOnly($this->commandBus->execute(new GetInvoice((int) $invoiceId)));
    }


    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $this->commandBus->execute(new UpdateInvoice($request->all()));

        return $this->respondWithSuccess('Invoice updated successfully');
    }


    /**
     * Delete Invoice
     *
     * @param $invoiceId
     * @return JsonResponse
     */
    public function destroy($invoiceId): JsonResponse
    {
        $this->commandBus->execute(new DeleteInvoice((int) $invoiceId));

        return $this->respondWithSuccess(__('Lead deleted successfully'));
    }


    /**
     * Update Bulk Action
     *
     * @param UpdateInvoicesBulkActionRequest $request
     * @return JsonResponse
     */
    public function updateBulkAction(UpdateInvoicesBulkActionRequest $request): JsonResponse
    {
        $message = $this->commandBus->execute(
            new UpdateInvoicesBulkAction(
                (array) $request->get('data_ids'),
                (string) $request->get('action')
            )
        );

        return $this->respondWithSuccess($message);
    }



    /**
     * Download Invoice
     *
     * @param Request $request
     * @return mixed
     */
    public function downloadInvoice(Request $request): mixed
    {
        return $this->commandBus->execute(new DownloadCustomerInvoice($request->get('invoice_id')));
    }


    /**
     * Get Invoice Data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getInvoiceData(Request $request): JsonResponse
    {
        $data = $this->commandBus->execute(new GetInvoiceData((int) $request->get('user_id')));

        return $this->respondWithSuccess(trans('Invoice data fetched successfully'), $data);
    }


    /**
     * Create Invoice
     *
     * @param CreateCustomInvoiceRequest $request
     * @return mixed
     */
    public function createCustomInvoice(CreateCustomInvoiceRequest $request): mixed
    {
        $data = $this->commandBus->execute(new CreateCustomerCustomInvoice($request->all()));

        return $this->respondWithSuccess(trans('Invoice created successfully'), $data);
    }

    //

    /**
     * Set Invoice Paid
     *
     * @param ChangeInvoicePaidStatusRequest $request
     * @return JsonResponse
     */
    public function setInvoicePaid(ChangeInvoicePaidStatusRequest $request): JsonResponse
    {
        $data = $this->commandBus->execute(new SetInvoicePaid($request->get('invoice_id')));

        return $this->respondWithSuccess(trans('Invoice marked as paid successfully'), $data);
    }


    /**
     * Set Invoice Unpaid
     *
     * @param ChangeInvoicePaidStatusRequest $request
     * @return JsonResponse
     */
    public function setInvoiceUnpaid(ChangeInvoicePaidStatusRequest $request): JsonResponse
    {
        $data = $this->commandBus->execute(new SetInvoiceUnpaid($request->get('invoice_id')));

        return $this->respondWithSuccess(trans('Invoice marked as unpaid successfully'), $data);
    }


    /**
     * Create Payment Reminder
     *
     * @param CreatePaymentReminderRequest $request
     * @return JsonResponse
     */
    public function createPaymentReminder(CreatePaymentReminderRequest $request): JsonResponse
    {
        $this->commandBus->execute(new CreateInvoicePaymentReminder($request->get('invoice_id')));

        return $this->respondWithSuccess(trans('Payment reminder created successfully'));
    }

    /**
     * Download Payment Reminder
     *
     * @param DownloadPaymentReminderRequest $request
     * @return mixed
     */
    public function downloadPaymentReminder(DownloadPaymentReminderRequest $request): mixed
    {
        return $this->commandBus->execute(new DownloadPaymentReminder($request->get('invoice_id')));
    }


    /**
     * Send Payment Reminder
     *
     * @param SendPaymentReminderRequest $request
     * @return JsonResponse
     */
    public function sendPaymentReminder(SendPaymentReminderRequest $request): JsonResponse
    {
        $data = $this->commandBus->execute(new SendPaymentReminder($request->get('invoice_id')));

        return $this->respondWithSuccess($data ? trans('Payment reminder sent successfully') : trans('Payment reminder could not sent successfully'), $data);
    }


    /**
     * Create Payment Warning
     *
     * @param CreatePaymentWarningRequest $request
     * @return JsonResponse
     */
    public function createPaymentWarning(CreatePaymentWarningRequest $request): JsonResponse
    {
        $this->commandBus->execute(new CreatePaymentWarning($request->get('invoice_id')));

        return $this->respondWithSuccess(trans('Payment warning created successfully'));
    }

    /**
     * Download Payment Reminder
     *
     * @param DownloadPaymentWarningRequest $request
     * @return mixed
     */
    public function downloadPaymentWarning(DownloadPaymentWarningRequest $request): mixed
    {
        return $this->commandBus->execute(new DownloadPaymentWarning($request->get('invoice_id')));
    }


    /**
     * Send Payment Reminder
     *
     * @param SendPaymentWarningRequest $request
     * @return JsonResponse
     */
    public function sendPaymentWarning(SendPaymentWarningRequest $request): JsonResponse
    {
        $data = $this->commandBus->execute(new SendPaymentWarning($request->get('invoice_id')));

        return $this->respondWithSuccess($data ? trans('Payment warning sent successfully') : trans('Payment warning could not sent successfully'), $data);
    }


    /**
     * Cancel Invoice
     *
     * @param CancelInvoiceRequest $request
     * @return JsonResponse
     */
    public function cancelInvoice(CancelInvoiceRequest $request): JsonResponse
    {
        $this->commandBus->execute(new CancelInvoice($request->get('invoice_id')));

        return $this->respondWithSuccess(trans('Cancel invoice successfully'));
    }


    /**
     * Download Payment Reminder
     *
     * @param DownloadCancelledInvoiceRequest $request
     * @return mixed
     */
    public function downloadCancelledInvoice(DownloadCancelledInvoiceRequest $request): mixed
    {
        return $this->commandBus->execute(new DownloadCancelledInvoice($request->get('invoice_id')));
    }


    /**
     * Send Payment Reminder
     *
     * @param SendCancelledInvoiceRequest $request
     * @return JsonResponse
     */
    public function sendCancelledInvoice(SendCancelledInvoiceRequest $request): JsonResponse
    {
        $data = $this->commandBus->execute(new SendCancelledInvoice($request->get('invoice_id')));

        return $this->respondWithSuccess($data ? trans('Cancelled invoice sent successfully') : trans('Cancelled invoice could not sent successfully'), $data);
    }



    /**
     * Get Invoice No By Date
     *
     * @param CreateCustomInvoiceRequest $request
     * @return JsonResponse
     */
    public function getInvoiceNoByDate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'invoice_date' => 'required|date|date_format:'.getLocaleDateFormat(),
        ]);

        $invoiceNo = getInvoiceNo(date('Y', strtotime($request->get('invoice_date'))));

        return $this->respondWithSuccess(trans('Invoice data fetched successfully'), $invoiceNo);
    }

}
