<?php

namespace App\Models;


use App\Helpers\Trait\SortingEloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeadContract extends Model
{
    use HasFactory, SortingEloquent;

    protected $table = "lead_contracts";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lead_id',
        'membership',
        'document_name',
        'document_path',
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
     * Contract Products
     *
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'lead_contract_products', 'contract_id', 'product_id');
    }



    /**
     * Contract Product Items
     *
     * @return HasMany
     */
    public function product_items(): HasMany
    {
        return $this->hasMany(ContractProduct::class, 'contract_id');
    }


}