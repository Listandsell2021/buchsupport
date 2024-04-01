<?php

namespace App\Models;


use App\Helpers\Trait\SortingEloquent;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadActivity extends Model
{
    use HasFactory, SortingEloquent;

    protected $table = "lead_activities";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lead_id',
        'admin_id',
        'description',
        'type',
        'data'
    ];



    /**
     * Get data to array
     */
    protected function data(): Attribute
    {
        return Attribute::make(
            get: fn (string|null $value) => json_decode($value),
            set: fn (array $value) => json_encode($value),
        );
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