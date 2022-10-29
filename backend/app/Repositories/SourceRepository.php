<?php

namespace App\Repositories;

use App\Models\Source;
use Illuminate\Support\Facades\DB;

class SourceRepository extends EloquentRepository
{

    public function getModel()
    {
        return Source::class;
    }

    public function getSourceByPosterId($posterId)
    {
        return DB::table('tbl_source')->where('poster_id', '=', $posterId)->get();
    }
}
