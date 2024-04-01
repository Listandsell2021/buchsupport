<?php

namespace App\Models;

use App\Helpers\Trait\SortingEloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    use HasFactory, SortingEloquent;

    protected $table = 'mail_templates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'event', 'mailable', 'subject', 'html_template', 'text_template',
        'html_layout', 'layout_path',
        'html_style', 'style_path',
    ];


}
