<?php

namespace App\Models;


use App\Helpers\Trait\SortingEloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AdminCommission extends Model
{
    use HasFactory, SortingEloquent;

    protected $table = "admin_commissions";

    protected $fillable = [
        'admin_id', 'incremental_no',
        'commission_no', 'commission_from', 'commission_to', 'commission_date',
        'total_gross', 'subtotal', 'tax', 'tax_total', 'previous_commission_id', 'previous_unpaid', 'total', 'paid'
    ];


    /**
     * Get Salesperson Admin
     *
     * @return HasOne
     */
    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class, 'id', 'admin_id');
    }


    /**
     * Get Invoices
     *
     * @return BelongsToMany
     */
    public function invoices(): BelongsToMany
    {
        return $this->belongsToMany(Invoice::class, 'admin_commission_invoices', 'commission_id', 'invoice_id');
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
}