<?php

namespace App\Models;


use App\Libraries\AdminCommission\SalespersonCommission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AdminCommissionInvoice extends Model
{
    use HasFactory;

    protected $table = "admin_commission_invoices";

    protected $fillable = ['commission_id', 'invoice_id'];

    public $timestamps = false;

    /**
     * Get Salesperson Admin
     *
     * @return HasOne
     */
    public function commission(): HasOne
    {
        return $this->hasOne(SalespersonCommission::class, 'id', 'commission_id');
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