<?php

namespace App\CommandProcess\Admin\Invoice;

use App\Libraries\Settings\Setting;
use App\Mail\Admin\Invoice\SendPaymentReminderMailToCustomer;
use App\Mail\Admin\Invoice\SendPaymentWarningMailToCustomer;
use App\Models\User;
use App\Services\Admin\CustomerService;
use App\Services\Admin\InvoiceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\CommandBus;
use Rosamarsky\CommandBus\Handler;

class SendPaymentWarningHandler implements Handler
{
    private InvoiceService $invoiceService;
    private CustomerService $customerService;
    private CommandBus $commandBus;

    /**
     * @param InvoiceService $invoiceService
     * @param CommandBus $commandBus
     * @param CustomerService $customerService
     */
    public function __construct(InvoiceService $invoiceService, CommandBus $commandBus, CustomerService $customerService)
    {
        $this->invoiceService = $invoiceService;
        $this->commandBus = $commandBus;
        $this->customerService = $customerService;
    }

    public function handle(Command $command)
    {
        $invoice = $this->invoiceService->getById($command->invoiceId);

        if (!$invoice->payment_reminder) {
            $this->commandBus->execute(new CreatePaymentWarning($command->invoiceId));
        }

        if ($invoice->user_id == null || ((int) $invoice->user_id) == 0) {
            return false;
        }

        $user = $this->customerService->getById($invoice->user_id);

        if (!$user) {
            return false;
        }

        if (!$user->email) {
            return false;
        }

        Mail::to($user->email)->send(new SendPaymentWarningMailToCustomer($invoice->user_name));

        return true;
    }
}
