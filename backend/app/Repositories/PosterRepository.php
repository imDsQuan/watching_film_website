<?php

namespace App\Repositories;

use App\Models\Poster;
use Illuminate\Support\Facades\DB;

class PosterRepository extends EloquentRepository
{

    public function getModel()
    {
        return Poster::class;
    }

    public function getMovieById($id){
        return DB::table('tbl_poster')->where('type', 'like', '%video%')->where('id', '=', $id)->first();
    }

    public function getTvShowById($id){
        return DB::table('tbl_poster')->where('type', 'like', '%tvShow%')->where('id', '=', $id)->first();
    }

    public function totalMovie() {
        return DB::table('tbl_poster')->where('type', 'like', '%video%')->count();
    }

    public function totalTvShow() {
        return DB::table('tbl_poster')->where('type', 'like', '%tvShow%')->count();
    }

    public function paginateMovie($limit, float $offset)
    {
        return DB::table('tbl_poster')->where('type', 'like', '%video%')->skip($offset)->take($limit)->get();
    }

    public function paginateTvShow($limit, float $offset)
    {
        return DB::table('tbl_poster')->where('type', 'like', '%tvShow%')->skip($offset)->take($limit)->get();
    }

    public function getMovieBySlug($slug)
    {
        return DB::table('tbl_poster')
            ->where('type', 'like', '%video%')
            ->where('slug', 'like', '%'.$slug.'%')
            ->first();
    }

    public function getTvShowBySlug($slug)
    {
        return DB::table('tbl_poster')
            ->where('type', 'like', '%tvShow%')
            ->where('slug', 'like', '%'.$slug.'%')
            ->first();
    }

    public function getMovieByKeyword($keyword)
    {
        return DB::table('tbl_poster')
            ->where('type', 'like', '%video%')
            ->where('title', 'like', '%'.$keyword.'%')
            ->get();
    }

    public function getTvShowByKeyword($keyword)
    {
        return DB::table('tbl_poster')
            ->where('type', 'like', '%tvShow%')
            ->where('title', 'like', '%'.$keyword.'%')
            ->get();
    }


}
