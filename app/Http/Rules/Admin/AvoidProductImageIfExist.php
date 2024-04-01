<?php

namespace App\Http\Rules\Admin;

use App\Helpers\Config\ImageConfig;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\File;
use Illuminate\Translation\PotentiallyTranslatedString;

class AvoidProductImageIfExist implements ValidationRule
{
    private int $productId;

    public function __construct(int $productId)
    {
        $this->productId = $productId;
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $permissions
     * @param \Closure(string): PotentiallyTranslatedString $fail
     * @return void
     */
    public function validate(string $attribute, mixed $image, Closure $fail): void
    {
        $imageName = $image->getClientOriginalName();
        $imagePath = ImageConfig::getAbsoluteStorageFolder($this->productId.DIRECTORY_SEPARATOR.$imageName);

        if (File::exists($imagePath)) {
            $fail(__(':image already exists', ['image' => $imageName]));
        }
    }
}
