<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    protected $table = 'tbl_episode';

    protected $fillable = ['season_id', 'media_id', 'title', 'description', 'duration', 'enabled', 'position', 'views', 'slug'];
}
