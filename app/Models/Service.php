<?php

namespace App\Models;

use App\Helpers\Trait\SortingEloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Libraries\EloquentHelpers\ProductHelper;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory, SortingEloquent, ProductHelper;


    protected $table = "services";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'note',
        'is_active',
    ];


    /**
     * Scope Active
     *
     * @param $query
     * @return mixed
     */
    public function scopeActive($query): mixed
    {
        return $query->where('is_active', 1);
    }


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
     * Relation to Pipelines
     *
     * @return HasMany
     */
    public function pipelines(): HasMany
    {
        return $this->hasMany(ServicePipeline::class, 'service_id');
    }

}
