<?php

namespace App\Models;

use App\Helpers\Trait\SortingEloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Libraries\EloquentHelpers\ProductHelper;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ServicePipeline extends Model
{
    use HasFactory, SortingEloquent, ProductHelper;


    protected $table = "service_pipelines";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_id',
        'name',
        'default',
        'order_no'
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
     * Service
     *
     * @return HasOne
     */
    public function service(): HasOne
    {
        return $this->hasOne(Service::class, 'service_id');
    }

}
