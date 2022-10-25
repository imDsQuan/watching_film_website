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
        return $this->_model->skip($offset)->take(10)->get();
    }

    public function getActorBySlug($slug) {
        return DB::table('tbl_actor')
            ->where('slug', 'like', '%'.$slug.'%')
            ->first();
    }

}
