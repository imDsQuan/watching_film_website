<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository extends EloquentRepository
{

    public function getModel()
    {
        return User::class;
    }

    public function getAll()
    {
        return User::orderByDesc('id')->get();
    }

    public function getRecent(int $limit)
    {
        return DB::table('users')->orderBy('id', 'desc')->take($limit)->get();
    }
}
