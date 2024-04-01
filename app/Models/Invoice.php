<?php

namespace App\Models;

use App\Helpers\Trait\SortingEloquent;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory, SortingEloquent;

    protected $table = 'invoices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',

        'year',
        'month',
        'invoice_date',
        'incremental_no',
        'invoice_no',

        'user_company',
        'user_gender',
        'user_name',
        'user_address',
        'user_no',

        'services',
        'service_total',
        'subtotal',
        'vat',
        'vat_total',
        'total',

        'is_paid',
        'invoice_path',

        'is_cancelled',
        'cancelled_inc_no',
        'cancelled_invoice_no',
        'cancelled_invoice_path',
        'cancelled_invoice_sent_at',

        'payment_reminder',
        'payment_reminder_sent_on',
        'payment_reminder_path',
        'payment_reminder_sent_at',

        'payment_warning',
        'payment_warning_on',
        'payment_warning_path',
        'payment_warning_sent_at',

    ];

    /**
     * Get data to array
     */
    protected function services(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => json_decode($value),
            set: fn (array $value) => json_encode($value),
        );
    }


    /**
     * Get Fillable columns
     *
     * @return array
     */
    public static function fillableProps(): array
    {
        $instance = new static();
        return $instance->fillable;
    }

    /**
     * Relationship with Customer
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
