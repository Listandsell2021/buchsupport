<?php

namespace App\Models;


use App\Helpers\Trait\SortingEloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class Lead extends Model
{
    use HasFactory, SortingEloquent;

    protected $table = "leads";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'gender',
        'phone_no',
        'street',
        'postal_code',
        'city',
        'country',
        'map_longitude',
        'map_latitude',
        'lead_status_id',
        'salesperson_id',
        'objection',
        'is_converted',
        'converted_at',
        'converted_to',
        'created_by'
    ];





    /**
     * Get Full Name
     *
     * @return string
     */
    public function fullname(): string
    {
        return $this->first_name.' '.$this->last_name;
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


    /**
     * Lead Notes
     *
     * @return HasMany
     */
    public function notes(): HasMany
    {
        return $this->hasMany(LeadNote::class, 'lead_id');
    }

    /**
     * Lead Appointments
     *
     * @return HasMany
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(LeadAppointment::class, 'lead_id');
    }

    /**
     * Lead Contract
     *
     * @return HasOne
     */
    public function contract(): HasOne
    {
        return $this->hasOne(LeadContract::class, 'lead_id');
    }


    /**
     * Lead Status
     *
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(LeadStatus::class, 'lead_status_id');
    }


    /**
     * Lead Salesperson
     *
     * @return BelongsTo
     */
    public function salesperson(): BelongsTo
    {
        return $this->belongsTo(SalesPerson::class, 'salesperson_id');
    }


    /**
     * Lead Added Products
     *
     * @return HasMany
     */
    public function added_products(): HasMany
    {
        return $this->hasMany(LeadAddedProduct::class, 'lead_id');
    }


    /**
     * Scope a query to only include active leads
     */
    public function scopeActive($query): void
    {
        $query->where('is_converted', 0);
    }

    /**
     * Scope a query to only include converted leads
     */
    public function scopeConverted($query): void
    {
        $query->where('is_converted', 1);
    }



}