<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{

    protected $table = 'visitors';

    public $timestamps = false;

    protected $fillable = [
        'ip',
        'date',
    ];


    public function scopeOnDate($query, $date) {
        return $query->where('date', date('Y-m-d'), strtotime($date));
    }

    public function scopeByIp($query, $ip) {
        return $query->where('ip', $ip);
    }


    /**
     * Relationship with Packages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function packs()
    {
        return $this->hasMany(VisitorPack::class, 'visitor_id');
    }


}
