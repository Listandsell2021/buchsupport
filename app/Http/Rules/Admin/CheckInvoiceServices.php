<?php

namespace App\Http\Rules\Admin;


use App\Helpers\Config\ImageConfig;
use Illuminate\Contracts\Validation\Rule;

class CheckInvoiceServices implements Rule
{
    protected string $message = "";

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $services
     * @return bool
     */
    public function passes($attribute, $services): bool
    {
        $pass = true;

        foreach ($services as  $index=>$service) {
            if (!hasInput($service['item_no'] ?? '')) {
                $this->addMessageList(($index+1).'. '.__('Service Item is required'));
                $pass = false;
            }
            if (!hasInput($service['service'] ?? '')) {
                $this->addMessageList(($index+1).'. '.__('Service is required'));
                $pass = false;
            }
            if (!isset($service['quantity'])) {
                $this->addMessageList(($index+1).'. '.__('Service quantity is required'));
                $pass = false;
            }
            if (isset($service['quantity']) && (int) $service['quantity'] == 0) {
                $this->addMessageList(($index+1).'. '.__('Service quantity must be greater than 0'));
                $pass = false;
            }
            if (!isset($service['unit_price'])) {
                $this->addMessageList(($index+1).'. '.__('Service unit price is required'));
                $pass = false;
            }
            if (isset($service['unit_price']) && (int) $service['unit_price'] == 0) {
                $this->addMessageList(($index+1).'. '.__('Service unit price must be greater than 0'));
                $pass = false;
            }
            if (!isset($service['total_price'])) {
                $this->addMessageList(($index+1).'. '.__('Service total price is required'));
                $pass = false;
            }
            if (isset($service['total_price']) && (int) $service['total_price'] == 0) {
                $this->addMessageList(($index+1).'. '.__('Service total price must be greater than 0'));
                $pass = false;
            }
        }

        return $pass;
    }


    /**
     * Add Message List
     *
     * @param $message
     * @return void
     */
    public function addMessageList($message): void
    {
        $this->message .= "<li>".$message."</li>";
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "<ul>".$this->message."</ul>";
    }
}
