<?php

namespace App\Http\Rules\Admin;


use Illuminate\Contracts\Validation\Rule;

class CheckUserFormPattern implements Rule
{
    protected string $message;

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
     * @param $forms
     * @return bool
     */
    public function passes($attribute, $forms): bool
    {
        $pass = true;


        foreach ($forms as $form) {
            if (
                !isset($form['purchase_date']) || ! ((bool) strtotime($form['purchase_date'])) ||
                !isset($form['status']) ||
                !isset($form['id']) || strlen($form['id']) == 0
            ) {
                $this->message = 'Purchase date is invalid';
                $pass = false;
            }
            foreach ($form['products'] as $product) {
                if (
                    !isset($product['id']) || strlen($product['id']) == 0 ||
                    !isset($product['product_id']) || $product['product_id'] == 0 ||
                    !isset($product['price']) || $product['price'] == 0 ||
                    !isset($product['quantity']) || $product['quantity'] == 0 ||
                    !isset($product['condition']) || $product['condition'] == 0
                ) {
                    $this->message = 'Product form is invalid';
                    $pass = false;
                }
            }
        }

        return $pass;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }
}
