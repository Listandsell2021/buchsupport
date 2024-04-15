<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'admin_id', 'user_id', 'lead_id', 'service_id', 'pipeline_id', 'price', 'quantity', 'note',
        'subtotal', 'tax', 'tax_price', 'total', 'shipment_no', 'document', 'document_path',
        'commissioned', 'status', 'order_at', 'order_no'
    ];


    /**
     * Fillable Properties
     *
     * @return array
     */
    public static function fillableProps(): array
    {
        $instance = new static();
        return $instance->fillable;
    }


    /**
     * Relation to User
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    /**
     * Relation to Admin
     *
     * @return BelongsTo
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }


    /**
     * Relation to Service
     *
     * @return BelongsTo
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }


    /**
     * Relation to Pipeline
     *
     * @return BelongsTo
     */
    public function pipeline(): BelongsTo
    {
        return $this->belongsTo(ServicePipeline::class, 'pipeline_id');
    }


    /**
     * Relation to Lead
     *
     * @return BelongsTo
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }


    /**
     * Relation to Order Stages
     *
     * @return HasMany
     */
    public function stages(): HasMany
    {
        return $this->hasMany(OrderStage::class, 'order_id');
    }


}
