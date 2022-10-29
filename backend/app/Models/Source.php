<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    protected $table = 'tbl_source';

    protected $fillable = ['media_id', 'poster_id', 'episode_id', 'type', 'url', 'quality', 'title'];
}
