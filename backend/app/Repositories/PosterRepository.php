<?php

namespace App\Repositories;

use App\Models\Poster;
use Illuminate\Support\Facades\DB;

class PosterRepository extends EloquentRepository
{

    public function getAllMovie()
    {
        return DB::table('tbl_poster')->where('type', 'like', '%video%')->orderBy('created_at', 'desc')->get();
    }

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

    public function getRandom() {
        return Poster::inRandomOrder()->first();
    }

    public function getNewRealase()
    {
        return DB::table('tbl_poster')->orderBy('created_at', 'desc')->take(15)->get();
    }

    public function getByGenre($genre)
    {
        return DB::table('tbl_genre')->leftJoin('tbl_poster_genres', 'tbl_genre.id', '=', 'tbl_poster_genres.genre_id')
            ->leftJoin('tbl_poster', 'tbl_poster_genres.poster_id', '=', 'tbl_poster.id')
            ->select('tbl_poster.*')
            ->where('tbl_genre.title', 'like', '%'.$genre.'%')
            ->orderBy('tbl_poster.id', 'desc')
            ->take(10)
            ->get();
    }

    public function getGenres($slug) {
        return DB::table('tbl_poster')->join('tbl_poster_genres', 'tbl_poster_genres.poster_id', '=', 'tbl_poster.id')
            ->join('tbl_genre', 'tbl_poster_genres.genre_id', '=', 'tbl_genre.id')
            ->where('tbl_poster.slug', 'like', '%'.$slug.'%')
            ->select('tbl_genre.*')
            ->distinct()
            ->get();
    }

    public function getCast($slug)
    {
        return DB::table('tbl_actor')
            ->join('tbl_media', 'tbl_media.id', '=', 'tbl_actor.media_id')
            ->join('tbl_role', 'tbl_actor.id', '=', 'tbl_role.actor_id')
            ->join('tbl_poster', 'tbl_poster.id', '=', 'tbl_role.poster_id')
            ->where('tbl_poster.slug', 'like', '%'.$slug.'%')
            ->select('tbl_actor.*', 'tbl_role.role', 'tbl_role.position', 'tbl_role.id as role_id', 'tbl_media.url as img')
            ->orderBy('tbl_role.position')
            ->get();
    }

    public function getSimilarMovieBySlug($slug)
    {
        return DB::table('tbl_genre')->leftJoin('tbl_poster_genres', 'tbl_genre.id', '=', 'tbl_poster_genres.genre_id')
            ->leftJoin('tbl_poster', 'tbl_poster_genres.poster_id', '=', 'tbl_poster.id')
            ->select('tbl_poster.*')
            ->whereIn('tbl_genre.id', function($query) use ($slug) {
                $query->select('tbl_poster_genres.genre_id')->from('tbl_poster_genres')
                    ->join('tbl_poster', 'tbl_poster_genres.poster_id', '=', 'tbl_poster.id')
                    ->where('tbl_poster.slug', 'like', '%'.$slug.'%');
            })
            ->where('tbl_poster.type', 'like', '%video%')
            ->orderBy('tbl_poster.id', 'desc')
            ->distinct()
            ->take(10)
            ->get();
    }

    public function getAllTvShow()
    {
        return DB::table('tbl_poster')->where('type', 'like', '%tvShow%')->orderBy('created_at', 'desc')->get();
    }

    public function getSimilarTvShowBySlug($slug)
    {
        return DB::table('tbl_genre')->leftJoin('tbl_poster_genres', 'tbl_genre.id', '=', 'tbl_poster_genres.genre_id')
            ->leftJoin('tbl_poster', 'tbl_poster_genres.poster_id', '=', 'tbl_poster.id')
            ->select('tbl_poster.*')
            ->whereIn('tbl_genre.id', function($query) use ($slug) {
                $query->select('tbl_poster_genres.genre_id')->from('tbl_poster_genres')
                    ->join('tbl_poster', 'tbl_poster_genres.poster_id', '=', 'tbl_poster.id')
                    ->where('tbl_poster.slug', 'like', '%'.$slug.'%');
            })
            ->where('tbl_poster.type', 'like', '%tvShow%')
            ->orderBy('tbl_poster.id', 'desc')
            ->distinct()
            ->take(10)
            ->get();
    }


}
