<?php

namespace App\Models;

use App\Helpers\Trait\SortingEloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Pipeline extends Model
{
    use SortingEloquent;

    protected $table = 'pipelines';

    protected $fillable = ['name'];


    /**
     * Belong to Users
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'pipeline_users', 'pipeline_id', 'user_id')->orderBy('pipeline_users.order_no', 'asc');
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
