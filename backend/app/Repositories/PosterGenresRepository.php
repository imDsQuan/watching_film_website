<?php

namespace App\Repositories;

use App\Models\PosterGenres;
use Illuminate\Support\Facades\DB;

class PosterGenresRepository extends EloquentRepository
{

    public function getModel()
    {
        return PosterGenres::class;
    }

    public function getMovieGenreId($movieId){
        return DB::table('tbl_poster_genres')->where('poster_id', '=', $movieId)->select('genre_id')->get();
    }

    public function deleteWherePosterId($posterId) {
        DB::table('tbl_poster_genres')->where('poster_id', '=', $posterId)->delete();
    }
}
