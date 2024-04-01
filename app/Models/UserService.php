<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserService extends Model
{
    use HasFactory;

    protected $table = 'user_services';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'service_id',
        'note',
        'price',
        'quantity',
        'order_no'
    ];


    public function service(): HasOne
    {
        return $this->hasOne(Service::class, 'service_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'user_id');
    }
}
