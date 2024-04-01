<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProduct extends Model
{
    use HasFactory;

    protected $table = 'user_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'form_id',
        'product_id',
        'user_id',
        'note',
        'price',
        'quantity',
        'condition',
        'position',
        'form_order_no',
        'is_hidden',
        'show_price',
        'show_purchase_date',
    ];


    public function product()
    {
        return $this->hasOne(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }
}
