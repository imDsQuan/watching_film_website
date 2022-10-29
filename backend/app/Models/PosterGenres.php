<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosterGenres extends Model
{
    use HasFactory;

    protected $table = 'tbl_poster_genres';

    protected $fillable =['poster_id', 'genre_id'];
}
