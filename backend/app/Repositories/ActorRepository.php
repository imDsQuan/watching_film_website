<?php

namespace App\Repositories;

use App\Models\Actor;
use Illuminate\Support\Facades\DB;

class ActorRepository extends EloquentRepository
{

    public function getModel()
    {
        return Actor::class;
    }

    public function paginate($limit, float $offset)
    {
        return $this->_model->skip($offset)->take($limit)->get();
    }

    public function getActorBySlug($slug) {
        return DB::table('tbl_actor')
            ->where('slug', 'like', '%'.$slug.'%')
            ->first();
    }

    public function getActorByKeyword($keyword) {
        return DB::table('tbl_actor')
            ->where('name', 'like', '%'.$keyword.'%')
            ->get();
    }

    public function getActorByPosterId($posterId) {
        return DB::table('tbl_actor')
                ->join('tbl_role', 'tbl_actor.id', '=', 'tbl_role.actor_id')
                ->where('tbl_role.poster_id', '=', $posterId)
                ->select('tbl_actor.*', 'tbl_role.role', 'tbl_role.position', 'tbl_role.id as role_id')
                ->orderBy('tbl_role.position', 'asc')
                ->get();
    }

    public function getPopular()
    {
        return DB::table('tbl_actor')->take(20)->get();

    }

    public function searchActor($keyword)
    {
        return DB::table('tbl_actor')
            ->where('name', 'like', '%'.$keyword.'%')
            ->first();
    }

}
