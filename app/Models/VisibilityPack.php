<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;
use Illuminate\Notifications\Notifiable;

class VisibilityPack extends Model
{
    use Notifiable, LaravelVueDatatableTrait;

    protected $table = 'visibility_packs';

    protected $fillable = [
        'name',
        'slug'
    ];


    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'name' => [
            'searchable' => true,
        ],
    ];
}
