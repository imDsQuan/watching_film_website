<?php

namespace App\Repositories;

use App\Models\Item;
use Illuminate\Support\Facades\DB;

class ItemsRepository extends EloquentRepository
{

    public function getModel()
    {
        return Item::class;
    }


    public function getAllItem($user_id)
    {
        return DB::table('tbl_poster')->join('tbl_items', 'tbl_items.poster_id', '=', 'tbl_poster.id')
            ->where('tbl_items.user_id', '=', $user_id)
            ->select('tbl_poster.*', 'tbl_items.id as item_id')
            ->distinct()
            ->get();
    }
}
