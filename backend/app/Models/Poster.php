<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poster extends Model
{
    use HasFactory;

    protected $table = 'tbl_poster';


    protected $fillable  = [
        'title',
        'cover_id',
        'poster_id',
        'trailer_id',
        'duration',
        'type',
        'tags',
        'rating',
        'imdb',
        'year',
        'description',
        'views',
        'enable',
        'comment',
        'slug',
        'label',
        'subLabel'];

}
