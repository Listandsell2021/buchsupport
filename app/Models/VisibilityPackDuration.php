<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;
use Illuminate\Notifications\Notifiable;

class VisibilityPackDuration extends Model
{
    //
    use Notifiable, LaravelVueDatatableTrait;
    protected $fillable = [
        'duration',
    ];


    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'duration' => [
            'searchable' => true,
        ],
    ];
}
