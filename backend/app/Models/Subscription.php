<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'tbl_subscription';

    protected $fillable = ['user_id', 'duration','method', 'pack_id', 'infos', 'status', 'currency', 'price', 'transaction', 'email', 'start_date', 'expired_date', 'payment_id'];
}
