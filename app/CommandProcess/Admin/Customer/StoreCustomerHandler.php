<?php

namespace App\CommandProcess\Admin\Customer;


use App\Http\Resources\Admin\AdminResource;
use App\Http\Resources\Admin\Customer\CustomerResource;
use App\Http\Resources\Admin\RoleResource;
use App\Services\Admin\CustomerService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class StoreCustomerHandler implements Handler
{


    private CustomerService $dbService;

    public function __construct(CustomerService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        if (isset($command->data['dob'])) {
            $command->data['dob'] = getGlobalDate($command->data['dob']);
        }
        $customer = $this->dbService->save($command->data);

        $userProducts = [];

        if (count($command->forms) > 0) {
            $formOrderNo = 1;
            $position = 1;
            foreach ($command->forms as $form) {
                $formId = Str::orderedUuid();
                if (count($form['products']) > 0) {
                    foreach ($form['products'] as $product) {
                        $userProducts[] = [
                            'form_id' => $formId,
                            'user_id' => $customer->id,
                            'product_id' => $product['product_id'],
                            'price' => $product['price'],
                            'quantity' => $product['quantity'],
                            'condition' => $product['condition'],
                            'note' => $product['note'],
                            'position' => $position++,
                            'form_order_no' => $formOrderNo,
                            'show_price' => $product['show_price'],
                            'show_purchase_date' => $product['show_purchase_date'],
                            'purchased_date' => date('Y-m-d', strtotime($form['purchase_date'])),
                            'status' => $form['status'],
                        ];
                    }
                }
                $formOrderNo++;
            }
        }

        if (count($userProducts) > 0) {
            DB::table('user_products')->insert($userProducts);
        }

        return new CustomerResource($customer);
    }
}
