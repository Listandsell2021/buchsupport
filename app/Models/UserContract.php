<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserContract extends Model
{
    use HasFactory;

    protected $table = 'user_contract';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'service_id',
        'document',
        'document_path',
        'note',
        'price',
        'quantity',
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
