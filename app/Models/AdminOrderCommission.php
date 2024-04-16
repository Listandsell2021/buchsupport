<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class AdminOrderCommission extends Model
{
    use HasFactory;

    protected $table = "admin_order_commissions";

    protected $fillable = ['commission_id', 'order_id'];

    public $timestamps = false;


    /**
     * Get Order
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }


    /**
     * Get Commission
     *
     * @return BelongsTo
     */
    public function commission(): BelongsTo
    {
        return $this->belongsTo(AdminCommission::class, 'commission_id');
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