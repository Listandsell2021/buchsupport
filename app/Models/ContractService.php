<?php

namespace App\Models;


use App\Helpers\Trait\SortingEloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContractService extends Model
{
    use HasFactory, SortingEloquent;

    protected $table = "lead_contract_services";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lead_id',
        'service_id',
        'quantity',
        'note',
        'price',
        'order_no',
    ];



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
     * Relations to Lead
     *
     * @return BelongsTo
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

}