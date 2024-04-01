<?php

namespace App\Models;

use App\DataHolders\Enum\AuthRole;
use App\Helpers\Trait\SortingEloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SortingEloquent;

    protected $table = 'admins';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'dob',
        'phone_no',
        'gender',
        'street',
        'postal_code',
        'city',
        'country',
        'auth_role',
        'role_id',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Get Admin Full Name
     *
     * @return string
     */
    public function fullname(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }


    /**
     * Admin Relations Admin Roles
     *
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(AdminRole::class, 'role_id');
    }


    /**
     * Relations with permissions
     *
     * @return HasMany
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(AdminPermission::class, 'role_id', 'role_id');
    }


    /**
     * Get Admin fillable properties
     *
     * @return array
     */
    public static function fillableProps(): array
    {
        $instance = new static();
        return $instance->fillable;
    }

    /**
     * Get Active Admins
     *
     * @param $query
     * @return void
     */
    public function scopeActive($query): void
    {
        $query->where('admins.is_active', 1);
    }


    /**
     * Get Salesperson Admins
     *
     * @param $query
     * @return void
     */
    public function scopeSalesperson($query): void
    {
        $query->where('admins.auth_role', AuthRole::getSalespersonRole());
    }


    /**
     * Get Auth Admins
     *
     * @param $query
     * @return void
     */
    public function scopeAdmin($query): void
    {
        $authRoles = [AuthRole::getAdminRole()];
        if (isAuthSuperAdmin()) {
            $authRoles[] = AuthRole::getSuperAdminRole();
        }
        $query->whereIn('admins.auth_role', $authRoles);
    }



}
