<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersAdd extends Model
{
    use HasFactory;
    protected $table = 'users_adds';
    protected $fillable = [
        'user_id',
        'post_code',
        'address',
        'building',
        'image'
    ];
}
