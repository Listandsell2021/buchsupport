<?php

namespace App\Models;

use App\Libraries\HelperTraits\SortingEloquent;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;
use Illuminate\Notifications\Notifiable;

class OfferedVisibilityPack extends Model
{
    use Notifiable, LaravelVueDatatableTrait, SortingEloquent;

    public function visibilityPack()
    {
        return $this->belongsTo(VisibilityPack::class);
    }

    public function visibilityPackDuration()
    {
        return $this->belongsTo(VisibilityPackDuration::class);
    }

    protected $fillable = [
        'visibility_pack_id',
        'visibility_pack_duration_id',
        'price',
        'sorting',
    ];

    // protected $dataTableRelationships = [
    //     "belongsTo" => [
    //         'visibilityPack' => [
    //             "model" => VisibilityPack::class,
    //             'foreign_key' => 'visibility_pack_id',
    //             'columns' => [
    //                 'name' => [
    //                     'searchable' => true,
    //                     'orderable' => true,
    //                 ],
    //             ],
    //         ],
    //     ],
    // ];

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'visibility_pack_id' => [
            'searchable' => true,
        ],
        'visibility_pack_duration_id' => [
            'searchable' => true,
        ],
        'price' => [
            'searchable' => true,
        ],
        'default' => [
            'searchable' => true,
        ],
    ];
}
