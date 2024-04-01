<?php

namespace App\Http\Requests\Admin\Notification;

use App\DataHolders\Enum\LeadStatus;
use App\Models\Notification;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Closure;

class MarkNotificationReadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'notification_ids' => ['required', 'array',
                function (string $attribute, mixed $value, Closure $fail) {
                    $notificationsCount = (int) Notification::whereIn('id', $value)->count();
                    if (!$notificationsCount) {
                        $fail("Notification does not exist");
                    }
                },
            ],
        ];
    }


    /**
     * Validation Messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'notification_ids.required' => trans('Notification is required'),
            'notification_ids.array' => trans('Notification is invalid'),
        ];
    }
}
