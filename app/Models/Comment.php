<?php

namespace App\Models;

use App\Helpers\Trait\SortingEloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Comment
 */
class Comment extends Model
{
    use SortingEloquent;

    protected $table = 'comments';
    protected $fillable = ['user_id', 'text', 'approved'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function scopeActive($query)
    {
        return $query->where('comments.approved', 1);
    }

}
