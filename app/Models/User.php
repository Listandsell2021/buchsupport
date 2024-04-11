<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Helpers\Trait\SortingEloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SortingEloquent;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uid',
        'membership',
        'first_name',
        'last_name',
        'email',
        'password',
        'password_text',
        'dob',
        'gender',
        'street',
        'postal_code',
        'city',
        'country',
        'note',
        'image_path',
        'is_special',
        'secondary_first_name',
        'secondary_last_name',
        'is_active',
        'registered_at',
        'auto_invoice',
        'auto_invoice_date',
        'document_name',
        'document_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
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
     * Get Fillable Columns
     *
     * @return array
     */
    public static function fillableProps(): array
    {
        $instance = new static();
        return $instance->fillable;
    }


    /**
     * Relation with contract
     *
     * @return HasOne
     */
    public function contract(): HasOne
    {
        return $this->hasOne(UserContract::class, 'user_id');
    }


    /**
     * Relation with Orders
     *
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

}
