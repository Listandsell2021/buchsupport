<?php

namespace App\Models;


use App\Helpers\Trait\SortingEloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadContract extends Model
{
    use HasFactory, SortingEloquent;

    protected $table = "lead_contract";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lead_id',
        'document',
        'document_path',
        'service_id',
        'quantity',
        'note',
        'price',
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


    /**
     * Relations to Service
     *
     * @return BelongsTo
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

}