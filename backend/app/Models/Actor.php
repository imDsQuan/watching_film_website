<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;

    protected $table = 'tbl_actor';

    protected $fillable = ['media_id', 'name', 'born', 'height', 'type', 'bio', 'slug'];

}
