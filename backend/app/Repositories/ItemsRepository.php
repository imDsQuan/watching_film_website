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
        return DB::table('tbl_poster')->join('tbl_item', 'tbl_item.poster_id', '=', 'tbl_poster.id')
            ->where('tbl_item.user_id', '=', $user_id)
            ->select('tbl_poster.*', 'tbl_item.id as item_id')
            ->distinct()
            ->get();
    }
}
