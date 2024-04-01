<?php

namespace App\Http\Rules\Admin;


use App\Models\Product;
use Illuminate\Contracts\Validation\Rule;

class CheckContractProductsPattern implements Rule
{
    protected string $message = '';

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
     * @param $products
     * @return bool
     */
    public function passes($attribute, $products): bool
    {
        $pass = true;

        if (!is_array($products)) {
            $this->addMessageList('Wrong product format list');
            return false;
        }

        if (count($products) == 0) {
            $this->addMessageList('Products are required');
            return false;
        }

        foreach ($products as $product) {

            if (
                !isset($product['product_id']) || (int) $product['product_id'] == 0
            ) {
                $this->addMessageList('Product cannot be empty');
                $pass = false;
            }
            if (!isset($product['price']) || (int) $product['price'] == 0 ) {
                $this->addMessageList('Product price is required');
                $pass = false;
            }
            if (!isset($product['quantity']) || (int) $product['quantity'] == 0 ) {
                $this->addMessageList('Product quantity is required');
                $pass = false;
            }
            if (!isset($product['condition']) || $product['condition'] == 0 ) {
                $this->addMessageList('Product quality is required');
                $pass = false;
            }
            if ($product['condition'] > 5) {
                $this->addMessageList('Product quality must be between 1 to 5');
                $pass = false;
            }
        }

        if (!$pass) {
            return false;
        }

        $productIds = array_map(function ($product) {
            return $product['product_id'];
        }, $products);

        if (count($productIds) != count(array_unique($productIds))) {
            $this->addMessageList('Same products cannot be added');
            $pass = false;
        }

        if (!$pass) {
            return false;
        }

        $countProducts = Product::whereIn('id', $productIds)->count();

        if (count($productIds) != $countProducts) {
            $this->addMessageList('Products are not available');
            $pass = false;
        }

        return $pass;
    }


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

    public function getOnlyMessage(): string
    {
        return $this->message;
    }

}
