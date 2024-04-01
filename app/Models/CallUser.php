<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CallUser extends Model
{
    use HasFactory;

    protected $table = "call_users";

    protected $fillable = [
        'user_id',
        'type',
        'first_name',
        'last_name',
        'email',
        'phone',
        'price',
        'note',
    ];


    /**
     * Get User
     *
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
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