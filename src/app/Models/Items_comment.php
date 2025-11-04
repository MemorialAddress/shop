<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items_comment extends Model
{
    use HasFactory;
    protected $table = 'items_comments';
    protected $fillable = [
        'item_id',
        'user_id',
        'comment'
    ];
}
