<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $table = 'purchases';
    protected $fillable = [
        'item_id',
        'user_id',
        'payment_method',
        'purchase_post_code',
        'purchase_address',
        'purchase_building'
    ];
}
