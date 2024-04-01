<?php

namespace App\Http\Rules\Admin;


use App\Helpers\Config\ImageConfig;
use Illuminate\Contracts\Validation\Rule;

class CheckProductImages implements Rule
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
     * @param $images
     * @return bool
     */
    public function passes($attribute, $images): bool
    {
        $pass = true;

        foreach ($images as $image) {
            if (!($image instanceof \Illuminate\Http\UploadedFile)) {
                $this->addMessageList(__('Image not found'));
                return false;
            }
        }

        foreach ($images as  $image) {
            if (!in_array($image->getClientOriginalExtension(), ImageConfig::getImageExtensions())) {
                $this->addMessageList($image->getClientOriginalName().' must be of types '.implode(',', ImageConfig::getImageExtensions()));
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
