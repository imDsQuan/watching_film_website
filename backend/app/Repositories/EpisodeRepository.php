<?php

namespace App\Repositories;

use App\Models\Episode;
use Illuminate\Support\Facades\DB;

class EpisodeRepository extends EloquentRepository
{

    public function getModel()
    {
        return Episode::class;
    }

    public function maxPosition() {
        return DB::table('tbl_episode')->max('position');
    }

    public function getAll()
    {
        return Episode::all()->sortBy('position');
    }

    public function getEpisodeBySeasonId($id)
    {
        return DB::table('tbl_episode')
            ->join('tbl_media', 'tbl_media.id', '=', 'tbl_episode.media_id')
            ->where('tbl_episode.season_id', '=', $id)
            ->select('tbl_episode.*', 'tbl_media.url as img_url')
            ->orderBy('tbl_episode.position', 'asc')
            ->get();
    }
}
