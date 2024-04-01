<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorPack extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'visitor_id',
        'pack_name',
        'page_no',
        'per_page',
        'offset',
        'total_users',
    ];


    public function scopeOnDate($query, $date) {
        return $query->where('date', date('Y-m-d'), strtotime($date));
    }

    public function scopeByIp($query, $ip) {
        return $query->where('ip', $ip);
    }

}
