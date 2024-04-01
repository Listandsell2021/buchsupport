<?php

namespace App\Models;

use App\DataHolders\Enum\LeadStatus;
use App\Helpers\Config\AuthConfig;
use App\Helpers\Trait\SortingEloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SmartList extends Model
{
    use HasFactory, SortingEloquent;

    protected $table = "smart_lists";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'admin_id',
    ];


    /**
     * Admin Smart List Leads
     *
     * @return BelongsToMany
     */
    public function leads(): BelongsToMany
    {
        return $this->belongsToMany(Lead::class, 'smart_list_leads', 'smart_list_id');
    }


    /**
     * Admin Smart List Leads
     *
     * @return BelongsToMany
     */
    public function active_leads(): BelongsToMany
    {
        return $this->belongsToMany(Lead::class, 'smart_list_leads', 'smart_list_id')
            ->where('leads.is_converted', 0);
    }

    /**
     * Admin Smart List Leads
     *
     * @return BelongsToMany
     */
    public function inactive_leads(): BelongsToMany
    {
        return $this->belongsToMany(Lead::class, 'smart_list_leads', 'smart_list_id')
            ->where('leads.is_converted', 1);
    }


}