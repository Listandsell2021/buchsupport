<?php

namespace App\CommandProcess\Admin\Customer;


use App\Helpers\Trait\ProductAttributes;
use App\Http\Resources\Admin\Customer\CustomerResource;
use App\Models\Admin;
use App\Models\SalesPerson;
use App\Models\UserContract;
use App\Models\UserProduct;
use App\Services\Admin\CustomerService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetCustomerHandler implements Handler
{
    use ProductAttributes;

    public CustomerService $dbService;

    public function __construct(CustomerService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $customer = $this->dbService->getById($command->customerId);

        $customer->forms = $this->convertToFormAttributes(UserProduct::where('user_id', $command->customerId)->get());

        $customer->document = UserContract::where('user_id', $command->customerId)->first();

        $customer->salesperson = Admin::select('admins.*')
            ->join('leads', 'admins.id', 'leads.salesperson_id')
            ->where('converted_to', $command->customerId)
            ->first();

        return new CustomerResource($customer);
    }
}
