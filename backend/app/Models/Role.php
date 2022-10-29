<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'tbl_role';

    protected $fillable = ['poster_id', 'actor_id', 'role', 'position'];

}
