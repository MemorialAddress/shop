<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'items';
    protected $fillable = [
        'user_id',
        'item_name',
        'brand_name',
        'price',
        'item_describe',
        'category',
        'condition'
    ];
}
