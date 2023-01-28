<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    use HasFactory;

    protected $table = 'tbl_pack';

    protected $fillable = ['title', 'description', 'duration', 'discount', 'price', 'position'];
}
